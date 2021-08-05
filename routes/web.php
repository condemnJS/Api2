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
    return phpinfo();
});

$router->post('/user/register', 'UserController@store');
$router->post('/user/login', 'UserController@login');
$router->post('/user/refresh-access-token', 'UserController@refreshAccessToken');
$router->get('/user', 'UserController@getUsers');

$router->group(['middleware' => 'auth:api'], function () use ($router) {
    $router->group(['prefix' => 'list'], function () use ($router) {
        $router->post('create', 'ListController@create');

        $router->get('get-items', 'ListController@getItems');
        $router->get('/', 'ListController@getItems');

        $router->get('get-item/{id}', 'ListController@getItem');
        $router->get('{id}', 'ListController@getItem');

        $router->put('update/{id}', 'ListController@update');
        $router->put('{id}', 'ListController@update');

        $router->delete('delete/{id}', 'ListController@destroy');
        $router->delete('{id}', 'ListController@destroy');
    });
    $router->group(['prefix' => 'task'], function () use ($router) {
        $router->post('create', 'TaskController@create');

        $router->get('get-items', 'TaskController@getItems');
        $router->get('/', 'TaskController@getItems');

        $router->get('get-item/{id}', 'TaskController@getItem');
        $router->get('{id}', 'TaskController@getItem');

        $router->put('update/{id}', 'TaskController@update');
        $router->put('{id}', 'TaskController@update');

        $router->delete('delete/{id}', 'TaskController@destroy');
        $router->delete('{id}', 'TaskController@destroy');
    });
    $router->group(['prefix' => 'user-list'], function () use ($router) {
        $router->post('create', 'UserListController@create');
        $router->get('get-items', 'UserListController@getItems');
        $router->get('get-item/{id}', 'UserListController@getItem');
        $router->put('update/{id}', 'UserListController@update');
        $router->delete('delete/{id}', 'UserListController@destroy');
    });
});
