<p align="center">
    <a href="https://github.com/ioSeoGio/template" target="_blank">
        <img src="https://a.radikal.ru/a25/2109/ab/ce51afb287b9.jpg" height="100px">
    </a>
    <h1 align="center">ShrekTeam template</h1>
    <br>
</p>

### This template provide fast and comfortable start for small & long living projects

### Docker-compose file:
- `nginx:1.17`
- `php:latest`
- `postgres:latest`
- `phpmyadmin/adminer:latest` on your choice
- `phpdoc:latest` used to generate code documentation on each start of project

### Template's software:
- `angular` - faster to handle with synced data after ajax requests
- `php8`
- `postgres` - much better for specific tasks than mysql

### The template contains the features:
- user signup/login/logout
- custom gii generator to fast generate models & cruds depends on createad tables
- automatic docs generator

DIRECTORY STRUCTURE
-------------------

      assets/               contains assets definition
      commands/             contains console commands (controllers)
      config/               contains application configurations
      controllers/          contains web controller classes
      controllers/api/      contains web api controller classes
      controllers/api/base  contains web base controller classes (crud controllers)
      custom/               contains custom elements of plugins/framework to rewrite original ones
      custom/giiant/        contains custom gii template
      database/             contains database files on local machines
      docker/               contains docker files
      docs/                 contains documentation
      helpers/              contains custom helpers
      mail/                 contains view files for e-mails
      migrations/           contains migrations files
      models/               contains model classes
      rbac/                 contains rbac rules
      runtime/              contains files generated during runtime
      tests/                contains various tests for the basic application
      vendor/               contains dependent 3rd-party packages
      views/                contains view files for the Web application
      web/                  contains the entry script and Web resources
      widgets/              contains widgets

CONFIGURATION
-------------

For configuration see config/ directory
- `config/console.php` - config of console app
- `config/db.php` - config of db
- `config/gii_generators.php` - list of gii_generators
- `config/i18n.php` - config of internationalization
- `config/params.php` - params of app

- `config/test.php` - temporary not in use
- `config/test_db.php` - temporary not in use

- `config/web.php` - main config file

REQUIREMENTS
------------

All the software of template will be started in docker, so minimal requirement is docker-compose

INSTALLATION
------------

#### Clone template with git in your projects' dir
    git clone https://github.com/ioSeoGio/template.git

#### Build docker environment 
Run `docker-compose up -d --build`
Use -d flag to run docker containers in daemon mode (optional)

#### Go to php container && install vendor files
    docker exec -it template_php_1 /bin/bash
(name 'template_php_1' may be vary, depends of name of your project)
    composer install

#### Make migrations to fill database
    php yii migration
And answer 'yes' to interactive questions

START OF DEVELOPING
-------------------
To fast start after installation:
- `create dbdiagram using for example https://nosqldbm.ru/`
- `make migration based on your dbdiagram`
- `make models & cruds using giiant`

- `continue to develop main application features`

COMMANDS
-------

    php yii batch
Run custom gii generator

TESTING
-------

### Need to configure tests environment
### In development


USEFUL RESOURCES
----------------

[markdown of readme cheatsheet](https://github.com/tchapi/markdown-cheatsheet)