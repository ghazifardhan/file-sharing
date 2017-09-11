<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    $router->resource('group', 'GroupController');
    $router->resource('user', 'UserController');
    $router->resource('usergroup', 'UserGroupController');
    $router->resource('role', 'RoleController');
    $router->resource('uploadmedia', 'UploadMediaController');

});
