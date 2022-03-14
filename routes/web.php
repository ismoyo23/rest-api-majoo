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

$router->group(['prefix' => 'auth'], function() use($router) {
    $router->post('/', 'AuthController@login');
    $router->post('/register', 'AuthController@register');
    $router->get('/users', 'AuthController@user');
});



$router->group(['prefix' => 'penjualan', 'middleware' => 'auth'], function() use($router) {

    $router->get('/', 'PenjualanController@index');
    $router->post('/', 'PenjualanController@create');
    $router->get('/perProduk', 'PenjualanController@laporanPenjualan');

});


$router->group(['prefix' => 'suplier', 'middleware' => 'auth'], function() use($router) {

    $router->get('/', 'SuplierController@index');
    $router->get('/{id}', 'SuplierController@index');
    $router->post('/', 'SuplierController@create');
    $router->delete('/{id}', 'SuplierController@deleted');
    $router->put('/{id}', 'SuplierController@update');

});



$router->group(['prefix' => 'produk', 'middleware' => 'auth'], function() use($router) {

    $router->post('/{id}', 'ProdukController@update');
    $router->get('/{id}', 'ProdukController@index');
    $router->get('/count_produk/{id}', 'ProdukController@count_produk');
    $router->get('/detail/{id}', 'ProdukController@show');
    $router->post('/', 'ProdukController@create');
    $router->delete('/{id}', 'ProdukController@deleted');

});


$router->group(['prefix' => 'laporanPembelianProduk', 'middleware' => 'auth'], function() use($router) {
    $router->get('/perProduk', 'LaporanPembelianController@per_produk');
    $router->get('/', 'LaporanPembelianController@produk');
});


$router->group(['prefix' => 'kategori', 'middleware' => 'auth'], function() use($router) {

    $router->get('/', 'kategoriController@index');
    $router->post('/', 'kategoriController@create');
    $router->get('/{id}', 'kategoriController@show');
    $router->delete('/{id}', 'kategoriController@deleted');

});

$router->group(['prefix' => 'pelanggan', 'middleware' => 'auth'], function() use($router) {

    $router->get('/', 'PelangganController@index');
    $router->get('/detail/{id}', 'PelangganController@show');
    $router->post('/', 'PelangganController@create');
    $router->put('/{id}', 'PelangganController@update');
    $router->delete('/{id}', 'PelangganController@delete');

});

$router->group(['prefix' => 'profiles', 'middleware' => 'auth'], function() use($router) {

    $router->get('/', 'ProfilesController@index');
    $router->get('/{id}', 'ProfilesController@show');
    $router->post('/', 'ProfilesController@create');
    $router->put('/{id}', 'ProfilesController@update');
    $router->delete('/{id}', 'ProfilesController@delete');

});