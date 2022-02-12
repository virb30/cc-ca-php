# PHP Docker Template

PHP project template with Docker

## Description

Configures Docker containers for:
- PHP
- Nginx
- Composer

### Directory structure

Below we decribe the default directory structure to be used as a starting point.
Feel free to change it as your needs.

#### Directories

- `.docker`: contains Dockerfiles and files that are required for docker to run
- `.vscode`: contains configuration files of VS Code (debug)
- `public`: public path of project - You should put all public files in this folder eg. index.php, favicon.ico
- `src`: source code of application - All the code should be put in this directory
- `tests`: tests files of application - PHPUnit will listen to this folder by default

#### Files
- `composer.json`
- `composer.lock`
- `docker-compose.yml`
- `Makefile`: contains some common commands to be used as helper
- `phpunit.xml`: configures PHPUnit


## Available Configuration

You can set a DB_DRIVER to be installed at PHP image build, accepted values are:
- none: to use with Sqlite
- mysql: to use with MariaDB
- pgsql: to use with Postgres

It's also possible to set the INSTALL_REDIS argument to true, 
this will install the Redis driver to PHP image at build.

```yml
...
php:
  build:
    # ...
    args:
      USER_ID: ${UID:-0}
      GROUP_ID: ${GID:-0}
      INSTALL_REDIS: "false"
      DB_DRIVER: "none"
...
```

## How to Use

With this template it is possible to:

- Start the environment
```console
docker-compose -f "docker-compose.yml" up -d --build
```
The application will be available at http://localhost:8080

  
- Install PHP dependencies with composer
```console
docker-compose run composer composer <composer command>
# alternativelly you can use the Makefile helper
make composer "<composer command>"
```

- Run PhpUnit tests
```console
docker-compose exec php php ./vendor/bin/phpunit
# to specify a test file
docker-compose exec php php ./vendor/bin/phpunit path/to/FileTest.php

# alternativelly you can use the Makefile command

make test
# or
make test /path/to/FileTest.php
```