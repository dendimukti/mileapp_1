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
    return "DENDI: " . $router->app->version();
});
// , 'middleware' => 'auth', 'namespace'
$router->group(['prefix' => 'api'], function () use ($router) {

    $router->get('order', ['as' => 'get.order', 'uses' => 'OrderController@getOrders']);
    $router->get('order/{id}', ['as' => 'get.order.id', 'uses' => 'OrderController@getOrder']);
    $router->post('order', ['as' => 'post.order', 'uses' => 'OrderController@create']);
    $router->put('order/{id}', ['as' => 'put.order', 'uses' => 'OrderController@update']);
    $router->patch('order/{id}', ['as' => 'patch.order', 'uses' => 'OrderController@updateState']);
    $router->delete('order/{id}', ['as' => 'delete.order', 'uses' => 'OrderController@delete']);
});
