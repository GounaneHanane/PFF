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

/*
Route::view('/home', 'home');
Route::get('/clients/', 'ClientsController@idC');
Route::get('/clients/critiere/','ClientsController@critiere');
Route::get('/clients/all','ClientsController@AllC');
Route::get('/clients/name/{name}', 'ClientsController@CustomerName');
Route::get('/clients/delete/{id}', 'ClientsController@DeleteCustomer');
Route::get('/clients/{}/{name}', 'ClientsController@DeleteCustomer');
Route::get('/clients/type/{type}', 'ClientsController@CustomerType');
Route::get('/clients/city/{city}', 'ClientsController@CustomerCity');
Route::get('/abonnement/count/{id}', 'AbonnementsController@count');

Route::view('/addclient','ClientController@AddingInfo');
Route::get('/clientinfo/{name}', 'ClientsController@CustomerInfo');
*/

Route::get('/abonnement', 'AbonnementsController@idAbonnement');
Route::view('/editclient', 'EditClient');
Route::view('/savecontrat', 'SaveContrat');
Route::view('/login', 'Login');
Route::view('/alertes', 'Alertes');
Route::view('/dashboard', 'Dashboard');

//Route::view('/contrat', 'Contrat');
Route::get('/contrat/', 'OMSContratController@contrat');
Route::get('/contrat/search/', 'OMSContratController@searchContrat');
Route::get('/contrat/recherche/', 'OMSContratController@recherche');
Route::get('/contrat/delete/{id}','OMSContratController@DisableContract');
Route::get('/contrat/refresh/','OMSContratController@refresh');
Route::get("/contrat/price/{idClient}/{idTypeSubscribe}",'OMSContratController@getPrice');



Route::view('/home', 'home');
Route::post('/contract','ClientsController@json');

//Route::view('/contrat', 'contrat');
//Route::view('/layout', 'layout');


Route::get('/addClient', 'ClientsController@AddCustomerView');
Route::view('/addcontrat', 'add_contrat');
Route::post('/contrat/addcontrat','OMSContratController@addContrat');
Route::post("/contrat/addDetail",'OMSContratController@addDetail');


/*
Route::post('/add','ClientsController@saveCustomer');
Route::get('deleteAbonnement/{id}','AbonnementsController@deleteAbonnement');
Route::post('/updateAbonnement','AbonnementsController@updateAbonnement');
Route::post("/add_type",'AbonnementsController@saveAbonnement');
Route::post('/contract/addVehicule/','ContratController@addVehicule');
*/





/*
//Route::post('/addclient', array('uses' => 'ClientsController@saveCustomer'));


//Route::get('client/{id}', 'ClientsController@idC');
/*Route::post('/addclient',['as'=>'/addClient','uses'=>'ClientsController@saveCustomer']);
Route::get('customer/','ClientsController@AllC');

*/
