<?php

use Illuminate\Routing\Router;

Admin::registerHelpersRoutes();

Route::group([
    'prefix'        => config('admin.prefix'),
    'namespace'     => Admin::controllerNamespace(),
    'middleware'    => ['web', 'admin'],
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    $router->resource('stores', StoreController::class);   //商铺列表
    $router->get('stores/show/{id?}', 'StoreController@show');
    $router->resource('types', TypeController::class);  //商铺分类
    $router->resource('classes', GoodsTypeController::class);
    $router->resource('goods', GoodsController::class);
    $router->resource('categories', CategoryController::class);

});
