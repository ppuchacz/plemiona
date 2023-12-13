### Requirements

* php >=8.2
* composer
* docker
* docker-compose


### How to run

Enter the project directory in terminal, then

Install packages and prepare database:
```shell
composer install
php bin/console doc:mig:mig --no-interaction
```
Add test data in database by running fixtures
```shell
php bin/console doc:fix:load --append
```

Start php's built-in web server:
```
php -S localhost:8000 -t public
```

Open in your browser http://localhost:8000/village/1
