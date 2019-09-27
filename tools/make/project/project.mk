CLI_SERVICE := drupal
CLI_SHELL := bash
CLI_USER := drupal
DOCKER_PROJECT_ROOT := /var/www/drupal/public_html

ifeq ($(ENV),production)
	DRUPAL_POST_INSTALL_TARGETS := drush-updb drush-cr drush-uli
else
	DRUPAL_POST_INSTALL_TARGETS := drush-updb drush-filestage drush-cr drush-uli
endif

PHONY += drush-filestage
drush-filestage:
	$(call step,Enable stage_file_proxy module...)
	$(call drush_on_${RUN_ON},en -y stage_file_proxy)
