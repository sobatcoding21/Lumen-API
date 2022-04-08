<?php

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
    return $router->app->version();
});

$router->get('/key', function () use ($router) {
    return \Illuminate\Support\Str::random(48);
});

$router->get('/users', 'UsersController@index' );
$router->get('/users/{id}', 'UsersController@show' );
$router->post('/users', 'UsersController@store' );
$router->post('/users/update', 'UsersController@update' );
$router->delete('/users/delete/{id}', 'UsersController@destroy' );
