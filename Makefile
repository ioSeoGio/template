all:
	echo hello, this is makefile 

php:
	docker exec -it $(shell basename $(CURDIR))_php_1 bash

rebuild:
	docker-compose down

	if [ -a database/ ]; \
	then \
		sudo chgrp www-data database/; \
		sudo chmod g+w database/; \
	fi;

	docker-compose up -d --build