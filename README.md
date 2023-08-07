# Lumen REST Api

[![Latest Stable Version](https://img.shields.io/packagist/v/laravel/lumen-framework)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://img.shields.io/packagist/l/laravel/lumen)](https://packagist.org/packages/laravel/lumen-framework)


This REST Api was built using Lumen Framework, Mysql & Docker. To run this project, please make sure that you have Docker setup in your machine. If not, please download Docker from [here](https://www.docker.com/products/docker-desktop/).

### How to run the app
1. Once you downloaded the app in your machine, please go inside the project directory and run below command.
```shell
docker-compose up --build -d
```
>Above command will build all docker containers and prepare everything for you

2. Once all 3 docker containers are up and running, please SSH inside the PHP container.
3. Please run below `composer` command to install all dependencies.
```shell
composer install
```
4. Once inside the PHP container, please run below commands.
```shell
php artisan migrate
```
> Above command will run database migrations and create all necessary tables for this application

```shell
php artisan db:seed
```
> Above command will run database seeder and fill tables with fake data for testing purpose.

Now the application is up and running with necessary fake data for testing.

### How to use the endpoints
1. In order to test the application, for now REST API testing tool `Postman` or something similar will be necessary. Also, another way of testing the API is using Swagger. Please go to http://localhost/api/documentation from your browser to browse available endpoints and test them one by one.
3. If the documentation link above is not working, please SSH to PHP container and then run `php artisan swagger-lume:generate` command which will generate the documentation automatically and afterwards the above URL will work.
### How to test the endpoints
I implemented one feature/interface test just to showcase my skills. In order to run the test, ssh into PHP docker container and run below command.
```shell
vendor/bin/phpunit
```
> There are 4 test cases with 23 assertions and all should be green. I will add more tests if possible.
