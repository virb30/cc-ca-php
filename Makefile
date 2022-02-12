composer:
	docker-compose run composer composer $(filter-out $@, $(MAKECMDGOALS))

test:
	docker-compose exec --user ${UID}:${GID} php php ./vendor/bin/phpunit $(filter-out $@, $(MAKECMDGOALS))