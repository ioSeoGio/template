all:
	echo hello, this is makefile 

php:
	docker exec -it $(shell basename $(CURDIR))_php_1 bash

migrate:
	docker exec -it $(shell basename $(CURDIR))_php_1 "/usr/bin/php yii migrate"

build:
	docker-compose up -d --build

db-rights:
	if [ -d database/ ]; \
	then \
		sudo chmod 777 -R database/; \
	fi;

rights: db-rights
	sudo chmod 777 -R web/
	sudo chmod 777 -R runtime/

	sudo chmod 777 -R migrations/
	sudo chmod 777 -R vendor/

up:
	docker-compose up -d

down:
	docker-compose down

init: rights build

rebuild: down db-rights build
