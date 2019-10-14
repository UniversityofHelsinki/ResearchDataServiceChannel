ANSIBLE_ROLES_PATH := ansible/roles
WARNING_USERNAME := USERNAME is required, e.g. make target USERNAME=johnsmith

PHONY += deploy
deploy: ENV := testing
deploy: ## Deploy the app. Use ENV=production if deploying to production. Default ENV=testing
ifndef USERNAME
	$(call warn,$(WARNING_USERNAME))
else
	$(call step,Deploy to $(ENV) with user $(USERNAME) ...)
	ansible-playbook -i ansible/inventory/$(ENV) ansible/deploy.yml --become-user=root -u $(USERNAME) --ask-become-pass
endif

PHONY += provision-dry-run
provision: ENV := testing
provision: ## Make provisioning
ifndef USERNAME
	$(call warn,$(WARNING_USERNAME))
else
	$(call step,Make dry run on provisioning...)
	ansible-playbook -i ansible/inventory/$(ENV) ansible/provision.yml --become-user=root -u $(USERNAME) --ask-become-pass
endif

PHONY += provision-dry-run
provision-dry-run: ENV := testing
provision-dry-run: ## Make dry run on provisioning
ifndef USERNAME
	$(call warn,$(WARNING_USERNAME))
else
	$(call step,Make dry run on provisioning...)
	ansible-playbook -i ansible/inventory/$(ENV) ansible/provision.yml --become-user=root -u $(USERNAME) --ask-become-pass --check
endif

PHONY += ansible-install-roles
ansible-install-roles: ## Install Ansible roles
	ansible-galaxy install -r ansible/requirements.yml -p $(ANSIBLE_ROLES_PATH)

PHONY += ansible-update-roles
ansible-update-roles: ## Update Ansible roles
	ansible-galaxy remove --roles-path=$(ANSIBLE_ROLES_PATH) $(shell find $(ANSIBLE_ROLES_PATH) -mindepth 1 -maxdepth 1 -type d -exec basename {} \;) || true
	ansible-galaxy install --force-with-deps --role-file=ansible/requirements.yml --roles-path=$(ANSIBLE_ROLES_PATH)
