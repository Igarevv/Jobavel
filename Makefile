.DEFAULT_GOAL := help

build: ## Build application
	docker-compose up --build -d
	docker-compose exec php composer install --prefer-dist -o
	docker-compose exec php php artisan key:generate
	docker-compose exec php php artisan migrate:fresh --seed
	docker-compose exec php php artisan storage:link

app-optimize: ## Run optimization commands
	docker-compose exec php php artisan route:cache
	docker-compose exec php php artisan config:cache
	docker-compose exec php php artisan view:cache

build-front-dev: ## Build frontend with flag dev
	docker-compose exec php sh -c "npm install && npm run dev"

build-front-prod: ## Build frontend with flag build
	docker-compose exec php sh -c "npm install && npm run build"

app-migration: ## Run migration with seeding
	docker-compose exec php php artisan migrate:fresh --seed

composer-build: ## Run composer install
	docker-compose exec php composer install

composer-update: ## Run composer update
	docker-compose exec php composer update

tinker: ## Run Tinker
	docker-compose exec php php artisan tinker

user-give-employee: ## Give random credentials with role employee
	docker exec -it php php artisan test:give-user 0

user-give-employer: ## Give random credentials with role employer
	docker exec -it php php artisan test:give-user 1

test-super-admin: ## Give super admin credentials
	docker exec -it php php artisan admin:super

.PHONY: help
help:
	@echo "Available commands:\n"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
