<?php

namespace Drupal\hy_samlauth\Controller;

use Drupal\samlauth\Controller\SamlController as OriginalSamlController;
use Drupal\hy_samlauth\SamlService;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 *
 */
class SamlController extends OriginalSamlController {
  /**
   * {@inheritdoc}
   */
  public function login() {
    $this->saml->setPostLoginLogoutDestination();
    return parent::login();
  }

  /**
   * {@inheritdoc}
   */
  public function logout() {
    $this->saml->setPostLoginLogoutDestination();
    return parent::logout();
  }

  /**
   * {@inheritdoc}
   */
  public function acs() {
    try {
      $this->saml->acs();
    }
    catch (\Exception $e) {
      $messenger = \Drupal::messenger();
      $messenger->addMessage($e->getMessage(), $messenger::TYPE_ERROR);
      return new RedirectResponse('/');
    }

    // Set default redirect.
    $url = "/";

    // Check if redirection cookie is set.
    if ($this->requestStack->getCurrentRequest()->cookies->has(SamlService::COOKIE_SAML_REDIRECT)) {
      $cookie_url = unserialize($this->requestStack->getCurrentRequest()->cookies->get(SamlService::COOKIE_SAML_REDIRECT));
      if (!empty($cookie_url)) {
        $url = $cookie_url;
      }
    }

    // Return redirect response.
    return $this->createRedirectResponse($url);
  }

  /**
   * {@inheritdoc}
   */
  public function sls() {
    $this->saml->sls();

    $url = $this->saml->getPostLogoutDestination()->toString(TRUE);
    $response = $this->createRedirectResponse($url->getGeneratedUrl());
    $this->saml->removePostLoginLogoutDestination();
    return $response;
  }

}
