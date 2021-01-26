<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$router->group(['prefix' => '/contacts'], function () use ($router) {
    $router->get('/', 'ContactController@index');
    $router->post('/', 'ContactController@store');
    $router->get('/{id:[0-9]+}', 'ContactController@show');
    $router->put('/{id:[0-9]+}', 'ContactController@update');
    $router->delete('/{id:[0-9]+}', 'ContactController@destroy');
});

$router->get('/states', 'StateController@index');

