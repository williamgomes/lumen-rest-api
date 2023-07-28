<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return "<h2>Welcome to Trivago Case Study</h2>";
});

$router->group(['prefix' => 'api/'], function ($router) {
    $router->get('cities[/{perPage}]', 'CityController@index');
    $router->get('states[/{perPage}]', 'StateController@index');
    $router->get('countries[/{perPage}]', 'CountryController@index');

    $router->group(['prefix' => 'hotelier/{hotelierId}', 'middleware' => 'fakeAuth'], function ($router) {
        $router->get('items[/perPage/{perPage}]', 'ItemsController@index');
        $router->get('items/ratings/{rating}[/perPage/{perPage}]', 'ItemsController@getByRating');
        $router->get('items/cities/{cityId}[/perPage/{perPage}]', 'ItemsController@getByCity');
        $router->get('items/badges/{badgeName}[/perPage/{perPage}]', 'ItemsController@getByBadge');
        $router->get('items/{itemId}', [
            'as' => 'items.show.one',
            'uses' => 'ItemsController@show',
        ]);
        $router->post('items/', 'ItemsController@store');
        $router->put('items/{itemId}', 'ItemsController@update');
        $router->delete('items/{itemId}', 'ItemsController@delete');
    });

    //reservation group
    $router->group(['prefix' => 'reservations'], function ($router) {
        $router->post('/',                 [
            'as' => 'items.create.reservation',
            'uses' => 'ReservationController@store',
        ]);
        $router->get('{reservationId}',
            [
                'as' => 'reservation.show.one',
                'uses' => 'ReservationController@show',
            ]
        );
    });
});
