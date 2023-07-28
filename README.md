# Trivago Case Study

[![Latest Stable Version](https://img.shields.io/packagist/v/laravel/lumen-framework)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://img.shields.io/packagist/l/laravel/lumen)](https://packagist.org/packages/laravel/lumen-framework)


This case study was built using Lumen Framework, Mysql & Docker. To run this project, please make sure that you have Docker setup in your machine. If not, please download Docker from [here](https://www.docker.com/products/docker-desktop/).

### How to run the app
1. Once you downloaded the app in your machine, please go inside the project directory and run below command.
```shell
docker-compose up --build -d
```
>Above command will build all docker containers and prepare everything for you

2. Once all 3 docker containers are up and running, please ssh inside the PHP container
3. Once inside the PHP container, please run below commands.
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
1. In order to test the application, for now REST API testing tool `Postman` or something similar will be necessary. I wanted to implemented `Swagger` but was facing some difficulties.
2. Possible end points are as below (required form-params are listed below)
```text
<<Item Endpoits>>
GET http://localhost/api/hotelier/{hotelierId}/items[/perPage/{perPage}] << get list of all items own by a hotelier(with pagination)(perPage is optional param)
GET http://localhost/api/hotelier/{hotelierId}/items/ratings/{rating}[/perPage/{perPage}]  << get list of all items that has given rating own by the given hotelier(with pagination)(perPage is optional param)
GET http://localhost/api/hotelier/{hotelierId}/items/cities/{cityId}[/perPage/{perPage}]  << get list of all items that has given city own by the given hotelier(with pagination)(perPage is optional param)
GET http://localhost/api/hotelier/{hotelierId}/items/badges/{badgeName}[/perPage/{perPage}] << get list of all items that has given reputation badge(red, yellow, green) own by a hotelier(with pagination)(perPage is optional param)
GET http://localhost/api/hotelier/{hotelierId}/items/{itemId} << get a single item own by the given hotelier
POST http://localhost/api/hotelier/{hotelierId}/items << create a new item own by the given hotelier
PUT http://localhost/api/hotelier/{hotelierId}/items/{itemId} << update the given item own by the given hotelier
DELETE http://localhost/api/hotelier/{hotelierId}/items/{itemId} << mark as deleted the given item own by the given hotelier

<<Reservation Endpoits>>
GET http://localhost/api/reservations/{reservationId} << get the given reservation
POST http://localhost/api/reservations/ << create a new reservation

<<Other Endpoits>>
GET http://localhost/api/cities[/{perPage}] << list of all the active cities (with pagination)
GET http://localhost/api/states[/{perPage}] << list of all the active states (with pagination)
GET http://localhost/api/countries[/{perPage}] << list of all the active countries (with pagination)
```
4. Form-params for `POST http://localhost/api/hotelier/{hotelierId}/items` and `PUT http://localhost/api/hotelier/{hotelierId}/items/{itemId}` methods

```text
-> name: STRING 
-> category: STRING 
-> image: URL
-> reputation: NUMERIC (a number between 0 and 1000)
-> price: DECIMAL
-> availability: NUMERIC (minimum value should be 1)
-> address: STRING
-> zip_code: NUMERIC (always 5 digit number)
-> rating: NUMERIC (a number between 0 and 5)
-> city: NUMERIC (id of a city from cities table that belongs to given state and country)
-> state: NUMERIC (id of a state from states table that belongs to given country)
-> country: NUMERIC (id of a country from countries table)
```

5. Form-params for `POST http://localhost/api/reservations/` method
```text
-> start_date: DATE (a date that should be greater or equals to now in dd/mm/yyy format)
-> end_date: DATE (a date that should be greater or equals to start_date in dd/mm/yyy format)
-> accommodation: NUMERIC (number of available accommodations)
-> item_id: NUMERIC (id of an item from items table that is not marked as deleted and have more available accommodation than required)
```
### How to test the endpoints
I implemented one feature/interface test just to showcase my skills. In order to run the test, ssh into PHP docker container and run below command.
```shell
vendor/bin/phpunit
```
> There are 4 test cases with 23 assertions and all should be green. I will add more tests if possible.
