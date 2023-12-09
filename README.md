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
Add test user and village manually in your db

Start php's built-in web server:
```
php -S localhost:8000 -t public
```

Open in your browser http://localhost:8000/village/1
