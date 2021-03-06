<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/api/home', function () {
        return 'Seja bem vindo';
});

$router->post('/api/login', 'AuthController@login');
$router->post('/api/register', 'RegisterController@register');

$router->group(['prefix' => '/api/videos'], function () use ($router) {
        $router->get('/free', 'VideoController@livre');
        $router->group(['middleware' => 'auth'], function () use ($router) {
                $router->get('', 'VideoController@index');
                $router->get('/{id}', 'VideoController@show');
                $router->post('', 'VideoController@store');
                $router->put('/{id}', 'VideoController@update');
                $router->delete('/{id}', 'VideoController@delete');
        });
});

$router->group(['prefix' => '/api/categorias'], function () use ($router) {
        $router->group(['middleware' => 'auth'], function () use ($router){
                $router->get('', 'CategoriaController@index');
                $router->get('/{id}', 'CategoriaController@show');
                $router->post('', 'CategoriaController@store');
                $router->put('/{id}', 'CategoriaController@update');
                $router->delete('/{id}', 'CategoriaController@delete');
                $router->get('/{id}/videos', 'CategoriaController@videoPorCategoria');
        });
});



