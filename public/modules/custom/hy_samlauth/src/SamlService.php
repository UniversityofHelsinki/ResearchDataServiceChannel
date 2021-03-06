<?php

namespace Drupal\hy_samlauth;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Flood\FloodInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Path\PathValidator;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\StringTranslation\TranslationInterface;
use Drupal\Core\Url;
use Drupal\externalauth\Authmap;
use Drupal\externalauth\ExternalAuth;
use Drupal\hy_samlauth\Event\HySamlauthUserSyncEvent;
use Drupal\samlauth\SamlService as OriginalSamlService;
use Drupal\Core\TempStore\PrivateTempStoreFactory;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Drupal\user\UserInterface;
use RuntimeException;

/**
 *
 */
class SamlService extends OriginalSamlService {

  const SESS_VALUE_KEY = 'postLoginLogoutDestination';
  const COOKIE_SAML_REDIRECT = 'UHRDS_REDIRECT_URL';
  const SESSION_SAML_NAME = 'UHRDS_USER_NAME';
  const SESSION_SAML_USER = 'UHRDS_USER_USERNAME';
  const SESSION_SAML_EMAIL = 'UHRDS_USER_EMAIL';
  const SESSION_SAML_GROUP = 'UHRDS_USER_GROUP';

  protected $session;
  protected $pathValidator;
  protected $tempStoreFactory;
  protected $store;

  /**
   * Constructor for Drupal\hy_samlauth\SamlService.
   * @param ExternalAuth $external_auth
   * @param Authmap $authmap
   * @param ConfigFactoryInterface $config_factory
   * @param EntityTypeManagerInterface $entity_type_manager
   * @param LoggerInterface $logger
   * @param EventDispatcherInterface $event_dispatcher
   * @param RequestStack $request_stack
   * @param PrivateTempStoreFactory $temp_store_factory
   * @param FloodInterface $flood
   * @param AccountInterface $current_user
   * @param MessengerInterface $messenger
   * @param TranslationInterface $translation
   * @param Session $session
   * @param PathValidator $pathValidator
   */
  public function __construct(
    ExternalAuth $external_auth,
    Authmap $authmap,
    ConfigFactoryInterface $config_factory,
    EntityTypeManagerInterface $entity_type_manager,
    LoggerInterface $logger,
    EventDispatcherInterface $event_dispatcher,
    RequestStack $request_stack,
    PrivateTempStoreFactory $temp_store_factory,
    FloodInterface $flood,
    AccountInterface $current_user,
    MessengerInterface $messenger,
    TranslationInterface $translation,
    Session $session,
    PathValidator $pathValidator
  ) {
    parent::__construct(
      $external_auth,
      $authmap,
      $config_factory,
      $entity_type_manager,
      $logger,
      $event_dispatcher,
      $request_stack,
      $temp_store_factory,
      $flood,
      $current_user,
      $messenger,
      $translation
    );

    $this->setSession($session);
    $this->setPathValidator($pathValidator);
  }

  /**
   * @param \Symfony\Component\HttpFoundation\Session\Session $session
   */
  public function setSession(Session $session) {
    $this->session = $session;
  }

  /**
   * @param \Drupal\Core\Path\PathValidator $pathValidator
   */
  public function setPathValidator(PathValidator $pathValidator) {
    $this->pathValidator = $pathValidator;
  }

  public function synchronizeUserAttributes(UserInterface $account, $skip_save = FALSE, $first_saml_login = FALSE) {
    // Skip user authentication.
  }

  /**
   * Set login and logout destinations in user´s session.
   */
  public function setPostLoginLogoutDestination() {
    // Ensure that session is started.
    if (!$this->session->isStarted()) {
      $this->session->start();
    }

    // We default at least to our frontpage.
    $url = new Url('<front>');

    // If we can catch the referrer, use that.
    $referer = $this->requestStack->getCurrentRequest()->server->get('HTTP_REFERER');
    if ($referer) {
      if ($valid_url = $this->pathValidator->getUrlIfValid($referer)) {
        $url = $valid_url;
      }
    }

    // In conjunction with "Redirect to login" module, it sets the current URI
    // when it triggers login. We may catch the URI from the cookie.
    if ($this->requestStack->getCurrentRequest()->cookies->has(self::COOKIE_SAML_REDIRECT)) {
      $cookie_url = unserialize($this->requestStack->getCurrentRequest()->cookies->get(self::COOKIE_SAML_REDIRECT));
      if ($valid_url = $this->pathValidator->getUrlIfValid($cookie_url)) {
        $url = $valid_url;
      }
    }

    // Store the serialized URL into session.
    $this->session->set(self::SESS_VALUE_KEY, serialize($url));
    $this->session->save();
  }

  /**
   * Get login and logout destinations in user´s session.
   *
   * @return \Drupal\Core\Url|null
   */
  public function getPostLoginLogoutDestination() {
    if (!empty($this->session->get(self::SESS_VALUE_KEY))) {
      return unserialize($this->session->get(self::SESS_VALUE_KEY));
    }
    return NULL;
  }

  /**
   * Removes post login/logout destination from existing session. Nothing is
   * done if request has no session.
   */
  public function removePostLoginLogoutDestination() {
    $this->store->delete(self::SESS_VALUE_KEY);
  }

  /**
   * {@inheritdoc}
   */
  public function getPostLoginDestination() {
    return $this->getPostLoginLogoutDestination();
  }

  /**
   * {@inheritdoc}
   */
  public function getPostLogoutDestination() {
    return $this->getPostLoginLogoutDestination();
  }

  /**
   * @return bool if a valid user was fetched from the saml assertion this request.
   */
  protected function isAuthenticated() {
    return $this->getSamlAuth()->isAuthenticated();
  }

  /**
   * Processes a SAML response (Assertion Consumer Service).
   *
   * First checks whether the SAML request is OK, then takes action on the
   * Drupal user (logs in / maps existing / create new) depending on attributes
   * sent in the request and our module configuration.
   *
   * @throws \OneLogin_Saml2_Error
   * @throws \OneLogin_Saml2_ValidationError
   */
  public function acs() {
    // Get samlAuth response.
    $this->getSamlAuth()->processResponse();

    // Now look if there were any errors and also throw.
    $errors = $this->getSamlAuth()->getErrors();
    if (!empty($errors)) {
      // We have one or multiple error types / short descriptions, and one
      // 'reason' for the last error.
      throw new RuntimeException('Error(s) encountered during processing of ACS response. Type(s): ' . implode(', ', array_unique($errors)) . '; reason given for last error: ' . $this->getSamlAuth()->getLastErrorReason());
    }

    if (!$this->isAuthenticated()) {
      throw new RuntimeException('Could not authenticate.');
    }

    $unique_id = $this->getAttributeByConfig('unique_id_attribute');
    if (!$unique_id) {
      throw new \Exception('Configured unique ID is not present in SAML response.');
    }

    $attributes = $this->getAttributes();

    if (empty($attributes)) {
      throw new \OneLogin_Saml2_Error('No user attributes given.', \OneLogin_Saml2_Error::SAML_RESPONSE_NOT_FOUND);
    }

    // Set samlauth attributes to user.temp session via eventDispatcher.
    $event = new HySamlauthUserSyncEvent($attributes);
    $this->eventDispatcher->dispatch(HySamlauthUserSyncEvent::USER_COOKIE, $event);
    $event->setAttribute(self::SESSION_SAML_NAME, $this->getAttributeByConfig('user_name_attribute'));
    $event->setAttribute(self::SESSION_SAML_EMAIL, $this->getAttributeByConfig('user_mail_attribute'));
    $event->setAttribute(self::SESSION_SAML_USER, $this->getAttributeByConfig('user_username_attribute'));
    $event->setAttribute(self::SESSION_SAML_GROUP, $this->getAttributeByConfig('user_group_attribute'));
  }

  /**
   * {@inheritdoc}
   */
  public function logout($return_to = NULL, array $parameters = []) {
    if (!$return_to) {
      $sp_config = $this->samlAuth->getSettings()->getSPData();
      $return_to = $sp_config['singleLogoutService']['url'];
    }

    // Get logout return URL.
    $parameters = ['referrer' => $return_to];
    if ($return_url = $this->getPostLogoutDestination()) {
      $parameters['return'] = $return_url->setAbsolute(TRUE)->toString(TRUE)->getGeneratedUrl();
    }

    $this->samlAuth->logout($return_to, $parameters);
  }

}
