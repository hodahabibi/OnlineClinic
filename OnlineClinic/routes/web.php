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

/** @var TYPE_NAME $router */
$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->get('provider', 'PatientController@getProviders');
$router->get('providerAvailability', 'PatientController@getProvidersAvailabilities');
$router->post('bookAppointment', 'PatientController@postAppointment');


