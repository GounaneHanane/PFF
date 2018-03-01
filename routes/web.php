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



Route::get('test', function () {
    return 'User ';
});
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
Route::get('/abonnement', 'AbonnementsController@idAbonnement');
Route::view('/addcontrat', 'add_contrat');
Route::view('/clientinfo', 'ClientInfo');
Route::view('/editclient', 'EditClient');
Route::view('/savecontrat', 'SaveContrat');
Route::view('/login', 'Login');
Route::view('/alertes', 'Alertes');
Route::view('/dashboard', 'Dashboard');
Route::post('/contract','ClientsController@json');
//Route::view('/contrat', 'contrat');
//Route::view('/layout', 'layout');

Route::view('/addClient', 'add_client');





Route::post('/add','ClientsController@saveCustomer');






/*
//Route::post('/addclient', array('uses' => 'ClientsController@saveCustomer'));


//Route::get('client/{id}', 'ClientsController@idC');
=======
/*Route::post('/addclient',['as'=>'/addClient','uses'=>'ClientsController@saveCustomer']);
>>>>>>> d8e848ec32e30952161019fd74f2ab7bdcec9dcb
Route::get('customer/','ClientsController@AllC');

*/
