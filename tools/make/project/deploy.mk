DEPLOY_PROJECT_PATH := /data/rds
DEPLOY_SSH := ssh -o LogLevel=QUIET -t

PHONY += deploy-testing
deploy-testing: HOST := datasupport-test.it.helsinki.fi
deploy-testing: --deploy ## Deploy to testing

PHONY += deploy-production
deploy-production: HOST := datasupport.helsinki.fi
deploy-production: --deploy ## Deploy to production

PHONY += --deploy
--deploy: PROMPT := Give your HY username for syncing data:
--deploy: USER := $(shell bash -c 'read -p "$(PROMPT) " u; echo $$u')
--deploy: DRUSH := /usr/local/bin/drush
--deploy: REPO_PATH := $(DEPLOY_PROJECT_PATH)/repo
--deploy: TIMESTAMP := $(shell date "+%s")
--deploy:
	$(call step,Create database dump ...)
	@$(DEPLOY_SSH) $(USER)@$(HOST) "$(DRUSH) -r $(REPO_PATH)/public sql-dump > $(DEPLOY_PROJECT_PATH)/backups/$(TIMESTAMP).sql"
	$(call step,Pull the latest code in $(REPO_PATH) ...)
	@$(DEPLOY_SSH) $(USER)@$(HOST) "cd $(REPO_PATH) && git pull"
	$(call step,Run composer install ...)
	@$(DEPLOY_SSH) $(USER)@$(HOST) "cd $(REPO_PATH) && composer install --no-dev"
	$(call step,Copy shared files ...)
	@$(DEPLOY_SSH) $(USER)@$(HOST) "cp $(DEPLOY_PROJECT_PATH)/shared/local.settings.php $(REPO_PATH)/public/sites/default/local.settings.php"
	@$(DEPLOY_SSH) $(USER)@$(HOST) "cp $(DEPLOY_PROJECT_PATH)/shared/saml.local.php $(REPO_PATH)/public/sites/default/saml.local.php"
	@$(DEPLOY_SSH) $(USER)@$(HOST) "ln -sfn $(DEPLOY_PROJECT_PATH)/shared/files $(REPO_PATH)/public/sites/default/files"
	$(call step,Run Drush commands ...)
	@$(DEPLOY_SSH) $(USER)@$(HOST) "$(DRUSH) -r $(REPO_PATH)/public deploy"
