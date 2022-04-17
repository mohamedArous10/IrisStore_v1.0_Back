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
    return $router->app->version();
});

$router->group([

    'prefix' => 'api/v2/auth'

], function ($router) {

    $router->post('login', 'AuthController@login');
    $router->post('logout', 'AuthController@logout');
    $router->post('refresh', 'AuthController@refresh');
    $router->post('me', 'AuthController@me');

});


$router->group([ 'middleware' => 'author', 'prefix' => 'api/v1/'], function () use ($router) {
    $router->group(['prefix' => 'users'], function () use ($router) {
        
        $router->get('list', 'UserController@list');
        $router->get('edit/{id}', 'UserController@edit');
        $router->post('insert', 'UserController@store');
        $router->put('update/{id}', 'UserController@update');
        $router->delete('delete/{id}', 'UserController@delete');
    });


    $router->group(['prefix' => 'categories'], function () use ($router) {
        
        $router->get('list', 'CategoryController@list');
        $router->get('edit/{id}', 'CategoryController@edit');
        $router->post('insert', 'CategoryController@store');
        $router->put('update/{id}', 'CategoryController@update');
        $router->delete('delete/{id}', 'CategoryController@delete');
    });



    $router->group(['prefix' => 'products'], function () use ($router) {
        
        $router->get('list', 'ProductController@list');
        $router->get('edit/{id}', 'ProductController@edit');
        $router->post('insert', 'ProductController@store');
        $router->post('update/{id}', 'ProductController@update');
        $router->delete('delete/{id}', 'ProductController@delete');
    });


    $router->group(['prefix' => 'commands'], function () use ($router) {
        
        $router->get('list', 'CommandController@list');
        $router->get('edit/{id}', 'CommandController@edit');
        $router->post('insert', 'CommandController@store');
        $router->post('update/{id}', 'CommandController@update');
        $router->delete('delete/{id}', 'CommandController@delete');
    });
});