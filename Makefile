all:
	echo hello, this is makefile 

php:
	docker exec -it $(shell basename $(CURDIR))_php_1 bash

rebuild:
	docker-compose down
	sudo chmod 777 -R database/
	docker-compose up -d --build