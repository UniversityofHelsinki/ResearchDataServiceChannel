DEPLOY_REPO := git@github.com:UniversityofHelsinki/ResearchDataServiceChannel.git
DEPLOY_FOLDER := deploy-build

PHONY += deploy
deploy: ENV := testing
deploy: --deploy-prepare deploy-build deploy-build/vendor deploy-build/artifact.tar.gz deploy-ansible

PHONY += --deploy-prepare
--deploy-prepare:
	@rm -rf $(DEPLOY_FOLDER)

deploy-build:
	$(call sub_step,Clone the repo to ./$(DEPLOY_FOLDER) folder...)
ifeq ($(ENV),production)
	@git clone -b master --depth 1 $(DEPLOY_REPO) $(DEPLOY_FOLDER)
else
	@git clone -b dev --depth 1 $(DEPLOY_REPO) $(DEPLOY_FOLDER)
endif

deploy-build/vendor:
ifeq ($(DOCKER_COMPOSE_BIN),no)
	$(call, warn,Composer needed!)
else
	$(call sub_step,Use local Composer to build...)
	@(cd $(DEPLOY_FOLDER) && composer install --no-dev --ignore-platform-reqs)
endif

deploy-build/artifact.tar.gz:
	$(call sub_step,Create artifact...)
	@(cd $(DEPLOY_FOLDER) && tar -hczf artifact.tar.gz --files-from=conf/artifact/include --exclude-from=conf/artifact/exclude)

PHONY += upload-artifact
upload-artifact:
	$(call sub_step,Upload artifact...)
	scp $(DEPLOY_FOLDER)/artifact.tar.gz marjuhko@datasupport-test.it.helsinki.fi:/data/rds/releases/
