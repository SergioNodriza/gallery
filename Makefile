#!/bin/bash

DOCKER_BE = gallery-be
OS := $(shell uname)

ifeq ($(OS),Linux)
	UID = $(shell id -u)
else
	UID = 1000
endif

run: ## Start the containers
	docker network create gallery-network || true
	U_ID=${UID} docker-compose up -d

stop: ## Stop the containers
	U_ID=${UID} docker-compose stop

restart: ## Restart the containers
	$(MAKE) stop && $(MAKE) run

build: ## Rebuilds all the containers
	U_ID=${UID} docker-compose build

ssh-be: ## ssh's into the be container
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} bash

generate-ssh-keys: ## Generates SSH keys for the JWT library
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} mkdir -p config/jwt
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} openssl genrsa -passout pass:f8467974ddd108823dd947cd350c1f8e -out config/jwt/private.pem -aes256 4096
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} openssl rsa -pubout -passin pass:f8467974ddd108823dd947cd350c1f8e -in config/jwt/private.pem -out config/jwt/public.pem
