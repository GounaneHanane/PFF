<?php

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






/*
Route::get('/foo', function () {
    return view('test');
});
*/


Route::view('/home', 'home');
Route::view('/client', 'client');
Route::view('/contrat', 'contrat');
Route::view('/layout', 'layout');
Route::get('client/{id}', 'ClientsController@idC');
Route::get('costomer/','ClientsController@AllC');


/*
Route::get('user/{id}', function ($id) {
    return 'User '.$id;
});
Route::get('/home', function () {
    return view('test', ['name' => 'James']);
});

Route::get('/client', function () {
    return view('home');
});
