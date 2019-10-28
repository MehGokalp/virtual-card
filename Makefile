build: docker-compose.yml
	@echo 'Building the container'
	docker-compose build --force-rm --no-cache && \
	docker-compose up -d && \
	sleep 3 && \
	docker exec -it virtual_card_php bin/console assets:install --env=dev --no-interaction && \
	docker exec -it virtual_card_php bin/console doctrine:migrations:migrate --env=dev --no-interaction && \
	docker exec -it virtual_card_php bin/console doctrine:fixtures:load --env=dev --no-interaction
	@echo 'Container built. You can access the server: http://localhost:8080'

conphp:
	docker exec -it --user root virtual-card_php_1 /bin/bash

default: build
