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
Route::get('/clients/', 'ClientsController@idC');
Route::get('/clients/all','ClientsController@AllC');
Route::get('/clients/name/{name}', 'ClientsController@CustomerName');
Route::get('/clients/delete/{name}', 'ClientsController@DeleteCustomer');
Route::get('/clients/{}/{name}', 'ClientsController@DeleteCustomer');
Route::get('/clients/type/{type}', 'ClientsController@CustomerType');


Route::view('/contrat', 'contrat');
Route::view('/layout', 'layout');
Route::view('/addClient', 'add_client');
Route::post('/addclient',['as'=>'/addClient','uses'=>'ClientsController@saveCustomer']);
//Route::get('client/{id}', 'ClientsController@idC');
Route::get('customer/','ClientsController@AllC');


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
