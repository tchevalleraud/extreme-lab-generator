user    := $(shell id -u)
group   := $(shell id -g)

build:
	@echo "### Docker build"
	docker build -t extremelabgenerator:latest --build-arg USER_ID=$(user) --build-arg GROUP_ID=$(group) ./docker/php/

exec:
	@echo "### Docker exec"
	docker container run --rm -v .:/var/www extremelabgenerator:latest php generate.php