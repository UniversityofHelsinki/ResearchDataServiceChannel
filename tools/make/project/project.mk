CLI_SERVICE := drupal
CLI_SHELL := bash
CLI_USER := drupal
DOCKER_PROJECT_ROOT := /app

SYNC_TARGETS := drush-sync-prompt-for-username

ifeq ($(ENV),production)
	DRUPAL_POST_INSTALL_TARGETS := drush-updb drush-cr drush-uli
else
	DRUPAL_POST_INSTALL_TARGETS := drush-updb drush-filestage drush-cr drush-uli
endif

PHONY += drush-filestage
drush-filestage:
	$(call step,Enable stage_file_proxy module...)
	$(call drush_on_${RUN_ON},en -y stage_file_proxy)

drush-sync-prompt-for-username: PROMPT := Give your HY username for syncing data:
drush-sync-prompt-for-username:
	$(call step,Sync database from @$(DRUPAL_SYNC_SOURCE)...)
	@${DOCKER_COMPOSE_EXEC} --env PROJECT_SSH_USER=$(shell bash -c 'read -p "$(PROMPT) " u; echo $$u') \
		-u ${CLI_USER} ${CLI_SERVICE} ${CLI_SHELL} \
		-c "drush --ansi --strict=0 sql-sync -y @$(DRUPAL_SYNC_SOURCE) @self"
