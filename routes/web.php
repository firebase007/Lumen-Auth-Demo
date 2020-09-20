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

// dummy route
$router->get('/', function () {
    return response(file_get_contents(__DIR__ . '/../README.md'))
    ->header('Content-Type', 'text/plain');
});

// Generate random string
$router->get('appKey', function () {
    return str_random('32');
});


$router->group(['prefix' => 'api', 'middleware' => 'auth'], function () use ($router) {

/**
 * Authentication
 */
$router->post('users', ['uses' => 'AuthController@register']);
// generate token on user login
$router->post('users/login', ['uses' => 'AuthController@login']);



    /**
     * Matches "/api/users
     */
$router->get('users', ['uses' => 'UserController@getAllUsers']);

// Matches "/api/user
//get one user by id
$router->get('user/{id}', ['uses' =>  'UserController@getUser']);


});
