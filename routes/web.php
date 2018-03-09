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
Route::get('/contrat/', 'ContratController@contrat');
Route::get('/clients/all','ClientsController@AllC');
Route::get('/clients/name/{name}', 'ClientsController@CustomerName');
Route::get('/clients/delete/{id}', 'ClientsController@DeleteCustomer');
Route::get('/clients/{}/{name}', 'ClientsController@DeleteCustomer');
Route::get('/clients/type/{type}', 'ClientsController@CustomerType');
Route::get('/clients/city/{city}', 'ClientsController@CustomerCity');
Route::get('/abonnement/count/{id}', 'AbonnementsController@count');
Route::get('/abonnement', 'AbonnementsController@idAbonnement');
Route::view('/addclient','ClientController@AddingInfo');
Route::get('/clientinfo/{name}', 'ClientsController@CustomerInfo');
Route::view('/editclient', 'EditClient');
Route::view('/savecontrat', 'SaveContrat');
Route::view('/login', 'Login');
Route::view('/alertes', 'Alertes');
Route::view('/dashboard', 'Dashboard');

//Route::view('/contrat', 'Contrat');

Route::view('/home', 'home');
Route::post('/contract','ClientsController@json');

//Route::view('/contrat', 'contrat');
//Route::view('/layout', 'layout');

Route::get('/addClient', 'ClientsController@AddCustomerView');
Route::view('/addcontrat', 'add_contrat');


Route::post('/add','ClientsController@saveCustomer');
Route::get('deleteAbonnement/{id}','AbonnementsController@deleteAbonnement');
Route::post('/updateAbonnement','AbonnementsController@updateAbonnement');
Route::post("/add_type",'AbonnementsController@saveAbonnement');
Route::post('/contract/addVehicule/','ContratController@addVehicule');






/*
//Route::post('/addclient', array('uses' => 'ClientsController@saveCustomer'));


//Route::get('client/{id}', 'ClientsController@idC');
/*Route::post('/addclient',['as'=>'/addClient','uses'=>'ClientsController@saveCustomer']);
Route::get('customer/','ClientsController@AllC');

*/
