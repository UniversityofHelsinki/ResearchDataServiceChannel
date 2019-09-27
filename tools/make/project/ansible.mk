ANSIBLE_ROLES_PATH := ansible/roles

PHONY += deploy
deploy: ENV := testing
deploy: USER := valimaat
deploy: ## Deploy the app. Use ENV=production if deploying to production. Default ENV=testing
	ansible-playbook -i ansible/inventory/$(ENV) ansible/deploy.yml --ask-become-pass -u $(USER) --check

PHONY += provision-dry-run
provision: ENV := testing
provision: USER := valimaat
provision: ## Make provisioning
	$(call step,Make dry run on provisioning...)
	ansible-playbook -i ansible/inventory/$(ENV) ansible/provision.yml --ask-become-pass -u $(USER)

PHONY += provision-dry-run
provision-dry-run: ENV := testing
provision-dry-run: USER := valimaat
provision-dry-run: ## Make dry run on provisioning
	$(call step,Make dry run on provisioning...)
	ansible-playbook -i ansible/inventory/$(ENV) ansible/provision.yml --ask-become-pass -u $(USER) --check

PHONY += ansible-install-roles
ansible-install-roles: ## Install Ansible roles
	ansible-galaxy install -r ansible/requirements.yml -p $(ANSIBLE_ROLES_PATH)

PHONY += ansible-update-roles
ansible-update-roles: ## Update Ansible roles
	ansible-galaxy remove --roles-path=$(ANSIBLE_ROLES_PATH) $(shell find $(ANSIBLE_ROLES_PATH) -mindepth 1 -maxdepth 1 -type d -exec basename {} \;) || true
	ansible-galaxy install --force-with-deps --role-file=ansible/requirements.yml --roles-path=$(ANSIBLE_ROLES_PATH)
