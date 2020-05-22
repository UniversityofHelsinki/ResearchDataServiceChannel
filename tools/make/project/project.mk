PROMPT := Give your HY username for syncing data:
shell: --shell-prompt

--shell-prompt:
	$(call docker_run_cmd,grep -qF 'export PROJECT_SSH_USER' ~/.bashrc || echo 'export PROJECT_SSH_USER=$(shell bash -c 'read -p "$(PROMPT) " u; echo $$u')' >> ~/.bashrc)

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

drush-sync-prompt-for-username:
	$(call step,Sync database from @$(DRUPAL_SYNC_SOURCE)...)
	@docker-compose exec --env PROJECT_SSH_USER=$(shell bash -c 'read -p "$(PROMPT) " u; echo $$u') \
		-u ${CLI_USER} ${CLI_SERVICE} ${CLI_SHELL} \
		-c "drush --ansi --strict=0 sql-sync -y @$(DRUPAL_SYNC_SOURCE) @self"

PHONY += shell-test
shell-test: HOST := datasupport-test.it.helsinki.fi
shell-test: ## Login to test server
	@ssh -t $(shell bash -c 'read -p "$(PROMPT) " u; echo $$u')@$(HOST) "cd /data/rds/current ; bash"

PHONY += shell-prod
shell-prod: HOST := datasupport.helsinki.fi
shell-prod:
	@ssh -t $(shell bash -c 'read -p "$(PROMPT) " u; echo $$u')@$(HOST) "cd /data/rds/current ; bash"
