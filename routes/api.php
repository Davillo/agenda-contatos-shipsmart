<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use App\Http\Controllers\ContactController;
use App\Http\Controllers\StateController;

$router->group(['prefix' => '/contacts'], function () use ($router) {
    $router->get('/', [ContactController::class, 'index']);
    $router->post('/', [ContactController::class, 'store']);
    $router->get('/{id}', [ContactController::class, 'show']);
    $router->put('/{id}', [ContactController::class, 'update']);
    $router->delete('/{id}', [ContactController::class, 'destroy']);
});

Route::get('/states', [StateController::class, 'index']);
