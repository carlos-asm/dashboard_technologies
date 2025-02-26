init:
	docker-compose up --build -d
	docker-compose exec app composer install
	docker-compose exec app cp -n .env.example .env || true

test:
	docker-compose exec app vendor/bin/phpunit