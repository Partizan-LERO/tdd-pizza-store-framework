# Simple framework for creating pizza-like application

How to run:

`docker-compose up -d --build` - to build environment

`docker-exec -ti tdd-discount_app_1 composer install` - to install all needed dependencies

`docker exec -ti tdd-discount_app_1 ./vendor/bin/phpunit tests/` - to run tests
