# php-api
Symfony PHP API test application.

### Tech stack
PHP 8.1, Symfony, Docker

### Installation
1. docker compose up
2. run container docker exec -it "php-api-php-1" /bin/sh
3. run composer install inside container
4. run php bin/console d:m:m inside container
5. run php bin/console d:f:load inside container
6. run php bin/console lexik:jwt:generate-keypair inside container to generate keypair
6. import data/APIAPP.postman_collection.json to postman
7. get token from route /api/login_check using credentials nick: admin, password: admin
8. test methods using bearer token