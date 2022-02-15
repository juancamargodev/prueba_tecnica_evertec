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
    $data = new stdClass();
    $data->name = "api prueba_tecnica_evertec";
    $data->author = "Juan Pablo Camargo vanegas";
    $data->apiVersion = "v0.1-alfa";
    return response()->json($data);
});

$router->group(['prefix'=>'v1'],function () use ($router){

    //rutas para el manejo de la autenticación
    $router->group(['prefix'=>'auth'], function () use ($router){
        $router->post('login', 'AuthController@login');
        $router->get('logout', 'AuthController@logout');
        $router->get('refresh', 'AuthController@refresh');
        $router->get('valid', 'AuthController@getAuthenticatedUser');
    });

    //rutas para el manejo de las ordenes
    $router->group(['prefix'=>'orders'], function () use ($router){
       $router->get('','OrdersController@getOrders');
       $router->get('{orderId}','OrdersController@getOrder');
       $router->get('user/{userId}','OrdersController@getOrdersByUserId');
        $router->post('create','OrdersController@create');
       $router->put('{orderId}','OrdersController@update');
    });

    //rutas para el manejo de los productos
    $router->group(['prefix'=>'products'], function () use ($router){
       $router->get('','ProductsController@getProducts');
       $router->get('/productId', 'ProductsController@getProduct');
    });

    //rutas para el manejo de los datos del webcheckout
    $router->group(['prefix'=>'webCheckout'], function () use ($router){
        $router->post('pay','WebCheckoutController@payOrder');
        $router->post('stateOrder','WebCheckoutController@stateOrder');
    });

});
