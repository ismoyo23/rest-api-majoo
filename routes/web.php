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

$router->group(['prefix' => 'auth'], function() use($router) {
    $router->post('/login', 'AuthController@login');
    $router->post('/register', 'AuthController@register');
});


$router->group(['prefix' => 'activities', 'middleware' => 'auth', 'middleware' => 'role:admin'], function() use($router) {

    $router->get('/', 'ActivitiesController@index');
    $router->get('/{id}', 'ActivitiesController@show');
    $router->post('/', 'ActivitiesController@create');
    $router->put('/{id}', 'ActivitiesController@update');
    $router->delete('/{id}', 'ActivitiesController@delete');

});


$router->group(['prefix' => 'permission', 'middleware' => 'auth'], function() use($router) {

    $router->get('/', 'PermissionController@index');
    $router->get('/{id}', 'PermissionController@show');
    $router->post('/', 'PermissionController@create');
    $router->put('/{id}', 'PermissionController@update');
    $router->delete('/{id}', 'PermissionController@delete');

});

$router->group(['prefix' => 'usersHasActivities', 'middleware' => 'auth'], function() use($router) {

    $router->get('/', 'UsersHasActivitiesController@index');
    $router->get('/{id}', 'UsersHasActivitiesController@show');
    $router->post('/', 'UsersHasActivitiesController@create');
    $router->put('/{id}', 'UsersHasActivitiesController@update');
    $router->delete('/{id}', 'UsersHasActivitiesController@delete');

});

$router->group(['prefix' => 'files', 'middleware' => 'auth'], function() use($router) {

    $router->get('/', 'FileController@index');
    $router->get('/{id}', 'FileController@show');
    $router->post('/', 'FileController@create');
    $router->put('/{id}', 'FileController@update');
    $router->delete('/{id}', 'FileController@delete');

});

$router->group(['prefix' => 'profiles', 'middleware' => 'auth'], function() use($router) {

    $router->get('/', 'ProfilesController@index');
    $router->get('/{id}', 'ProfilesController@show');
    $router->post('/', 'ProfilesController@create');
    $router->put('/{id}', 'ProfilesController@update');
    $router->delete('/{id}', 'ProfilesController@delete');

});