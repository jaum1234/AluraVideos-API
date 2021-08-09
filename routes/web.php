<?php

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PhpParser\Node\Stmt\Catch_;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

$router->post('/api/login', 'AuthController@login');
$router->post('/api/register', 'AuthController@register');

$router->group(['prefix' => '/api/videos'], function () use ($router) {
        $router->get('/free', 'VideoController@livre');

            $router->get('', 'VideoController@index');
            $router->get('/{id}', 'VideoController@show');
            $router->post('', 'VideoController@store');
            $router->put('/{id}', 'VideoController@update');
            $router->delete('/{id}', 'VideoController@delete');
    });



$router->group(['prefix' => '/api/categorias'], function () use ($router) {
        $router->get('', 'CategoriaController@index');
        $router->get('/{id}', 'CategoriaController@show');
        $router->post('', 'CategoriaController@store');
        $router->put('/{id}', 'CategoriaController@update');
        $router->delete('/{id}', 'CategoriaController@delete');
        $router->get('/{id}/videos', 'CategoriaController@buscarVideoPorCategoria');
});



