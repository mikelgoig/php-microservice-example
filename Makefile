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
start: build up git-hooks-install ## Build and start the containers

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

## —— Composer 🧙 ——————————————————————————————————————————————————————————————
.PHONY: composer
composer: ## Run composer, pass the parameter "c=" to run a given command, example: make composer c='req symfony/orm-pack'
	@$(eval c ?=)
	@$(COMPOSER) $(c)

.PHONY: composer-install
composer-install: ## Install Composer dependencies according to the current composer.lock file
composer-install: c = install --prefer-dist --no-dev --no-progress --no-scripts --no-interaction
composer-install: composer

.PHONY: composer-update
composer-update: ## Update Composer dependencies
composer-update: c = update
composer-update: composer

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
.PHONY: test
test: ## Execute all tests with Codeception. Pass the parameter "c=" to add options to codecept
	@$(eval c ?=)
	@$(PHP) vendor/bin/codecept run --skip-group=skip $(c)

.PHONY: test-ff
test-ff: ## Execute all tests with Codeception, with fail fast option
test-ff: c = --fail-fast
test-ff: test

.PHONY: ct
ct: ## Execute component tests. Pass the parameter "c=" to add options to codeception, example: make ct c="--skip-group=skip"
	@$(eval c ?=)
	@$(PHP) vendor/bin/codecept run component $(c)

.PHONY: ctff
ctff: ## Execute component tests, with fail fast option
ctff: c = --fail-fast
ctff: ct

.PHONY: codecept-build
codecept-build: ## Build Codeception generated actions
	@$(PHP) vendor/bin/codecept build

## —— Analysis 🔎 ——————————————————————————————————————————————————————————————
.PHONY: lint
lint: phpstan ecs ## Analyze code and show errors (PHPStan, ECS)

.PHONY: lint-fix
lint-fix: ecs-fix ## Analyze code and fix errors (ECS)

.PHONY: phpstan
phpstan: ## Run PHPStan and show errors
	@$(eval c ?=)
	@$(PHP) vendor/bin/phpstan analyse --memory-limit=-1 $(c)

.PHONY: phpstan-cc
phpstan-cc: ## Clear PHPStan cache
	@$(PHP_CONT) rm -rf var/cache/phpstan

.PHONY: ecs
ecs: ## Run Easy Coding Standard (ECS) and show errors
	@$(eval c ?=)
	@$(PHP) vendor/bin/ecs check --memory-limit=-1 $(c)

.PHONY: ecs-fix
ecs-fix: ## Run Easy Coding Standard (ECS) and fix errors
	@$(PHP) vendor/bin/ecs check --fix --memory-limit=-1

.PHONY: ecs-list
ecs-list: ## List Easy Coding Standard (ECS) used rules
	@$(PHP) vendor/bin/ecs list-checkers

## —— Git Hooks ☠️ ————————————————————————————————————————————————————————————
.PHONY: git-hooks-install
git-hooks-install: ## Install git hooks using Captainhook
	php service/vendor/bin/captainhook install --configuration=service/captainhook.json --force
