# Executables (local)
DOCKER_COMP = docker compose

# Docker containers
PHP_CONT = $(DOCKER_COMP) exec php

# Executables
PHP      = $(PHP_CONT) php
COMPOSER = $(PHP_CONT) composer
SYMFONY  = $(PHP) bin/console

# Misc
.DEFAULT_GOAL = help

## —— 🎵 🐳 The Symfony Docker Makefile 🐳 🎵 —————————————————————————————————
.PHONY: help
help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9\./_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

## —— Docker 🐳 ————————————————————————————————————————————————————————————————
.PHONY: build
build: ## Builds the Docker images
	@$(DOCKER_COMP) build --pull --no-cache

.PHONY: up
up: ## Start the docker hub in detached mode (no logs)
	@HTTP_PORT=8000 HTTPS_PORT=4443 HTTP3_PORT=4443 $(DOCKER_COMP) up --detach

.PHONY: start
start: build up ## Build and start the containers

.PHONY: down
down: ## Stop the docker hub
	@$(DOCKER_COMP) down --remove-orphans

.PHONY: logs
logs: ## Show live logs
	@$(DOCKER_COMP) logs --tail=0 --follow

.PHONY: sh
sh: ## Connect to the FrankenPHP container
	@$(PHP_CONT) sh

.PHONY: bash
bash: ## Connect to the FrankenPHP container via bash so up and down arrows go to previous commands
	@$(PHP_CONT) bash

.PHONY: test
test: ## Start tests with phpunit, pass the parameter "c=" to add options to phpunit, example: make test c="--group e2e --stop-on-failure"
	@$(eval c ?=)
	@$(DOCKER_COMP) exec -e APP_ENV=test php bin/phpunit $(c)

## —— Composer 🧙 ——————————————————————————————————————————————————————————————
.PHONY: composer
composer: ## Run composer, pass the parameter "c=" to run a given command, example: make composer c='req symfony/orm-pack'
	@$(eval c ?=)
	@$(COMPOSER) $(c)

.PHONY: vendor
vendor: ## Install vendors according to the current composer.lock file
vendor: c = install --prefer-dist --no-dev --no-progress --no-scripts --no-interaction
vendor: composer

## —— Symfony 🎵 ———————————————————————————————————————————————————————————————
.PHONY: sf
sf: ## List all Symfony commands or pass the parameter "c=" to run a given command, example: make sf c=about
	@$(eval c ?=)
	@$(SYMFONY) $(c)

.PHONY: cc
cc: c = c:c ## Clear the cache
cc: sf

## —— Doctrine 💾 ——————————————————————————————————————————————————————————————
.PHONY: db
db: ## List all Doctrine commands
db: c = list doctrine
db: sf

.PHONY: db-create
db-create: ## Create the database, if not exists
db-create: c = doctrine:database:create --if-not-exists --no-interaction
db-create:
	@$(SYMFONY) $(c)

.PHONY: db-drop
db-drop: ## Drop the database, if exists
db-drop: c = doctrine:database:drop --if-exists --force --no-interaction
db-drop:
	@$(SYMFONY) $(c)

.PHONY: db-migrate
db-migrate: ## Execute migrations
db-migrate: c = doctrine:migrations:migrate --no-interaction
db-migrate:
	@$(SYMFONY) $(c)

.PHONY: db-fresh
db-fresh: ## Drop the database and create a new one with all migrations
db-fresh: db-drop db-create db-migrate

.PHONY: db-diff
db-diff: ## Generate a migration by comparing your database to your mapping information
db-diff: db-fresh
db-diff: c = doctrine:migrations:diff --no-interaction
db-diff: sf

.PHONY: db-validate
db-validate: ## Validate that Doctrine mapping files are correct and in sync with the database
db-validate: c = doctrine:schema:validate --no-interaction
db-validate: sf

## —— Test 🧪 ——————————————————————————————————————————————————————————————————
ct: ## Execute component tests. Pass the parameter "c=" to add options to codeception, example: make ct c="--skip-group=skip"
	@$(eval c ?=)
	@$(PHP_CONT) vendor/bin/codecept run component $(c)

ctff: ## Execute component tests with fail fast option
ctff: c = --fail-fast
ctff: ct
