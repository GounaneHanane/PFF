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

Route::get("/details/info/{id}","ContratController@detailsInfo");
Route::view("/renouv","renouvelement");
Route::get('/abonnement', 'AbonnementsController@idAbonnement');
Route::view('/editclient', 'EditClient');
Route::view('/savecontrat', 'SaveContrat');
Route::view('/login', 'Login');
Route::view('/alertes', 'Alertes');
Route::view('/dashboard', 'Dashboard');

//Route::view('/contrat', 'Contrat');
//Route::get('/contrat/', 'OMSContratController@contrat');
Route::get('/contrat/', 'ContractController@contrat');
Route::get('/contrat/detail/verifyType/{idDetail}/{idType}','ContractController@verifyType');



//Route::get('/contrat/search/', 'OMSContratController@searchContrat');
Route::get('/contrat/search/', 'ContractController@searchContrat');

Route::get("/detail/search/","OMSContratController@searchDetail");


//Route::get('/contrat/update/{id}', 'OMSContratController@update');
Route::get('/contrat/update/{id}', 'ContractController@update');
Route::get('/alerte/renv/{id_detail}','AlertController@Alert_Detail_Contrat');
Route::post('/renewal/vehicles','ContratController@vehicleRenewal');


//Route::get('/contrat/delete/{id}','OMSContratController@DisableContract');
Route::get('/contrat/delete/{id}','ContractController@DisableContract');
//Route::get('/contrat/refresh/','OMSContratController@refresh');


Route::get('/contrat/refresh/','ContractController@refresh');



//Route::get("/contrat/detail/refresh/{idContract}","ContratController@refreshDetail");
Route::get("/contrat/detail/refresh/{idContract}","ContractController@refreshDetail");
Route::get('/detail/delete/{id}','OMSContratController@DisableDetail');
Route::get('/contrat/detail/{id}','OMSContratController@DetailSelected');
Route::get('/contrat/detailVehicles/{id}','OMSContratController@DetailVehicles');
Route::get('/contrat/priceDetail/{idClient}/{idTypeSubscribe}/{many}','OMSContratController@PriceVehicles');
Route::get('/contrat/countVehicles/{idVehicle}','OMSContratController@CountVehicles');
Route::post("/contrat//detail/price/calcul","ContratController@getPrice");
Route::post("/contrat//detail/price/calculEdit","ContratController@getPriceEdit");



Route::post('/renewal/','ContratController@renewal');



Route::get("/contrat/price/{idClient}/",'OMSContratController@getPrice');


Route::post('/contract','ClientsController@json');

//Route::view('/contrat', 'contrat');

//Route::view('/layout', 'layout');
Route::get('/layout','AlertController@AlertNotification');
Route::get('/Renouvelement','RenouvelementController@renewal');

Route::get('/home','AlertController@alert');
Route::get('/addClient', 'ClientsController@AddCustomerView');
Route::view('/addcontrat', 'add_contrat');

//Route::post('/contrat/addcontrat','OMSContratController@addContrat');
Route::post('/contrat/addcontrat','ContractController@addContrat');


Route::post("/contrat/addDetail",'OMSContratController@addDetail');


Route::get("/contrat/showdetails/{idDetail}",'ContratController@showInfo');

Route::post("/contrat/addDetailGamme",'OMSContratController@AddDetailGammme');

Route::view("/contrat/details",'contractInfo');

Route::view("/contratFacture","contratCopie");
Route::get("/pdf","GenerateController@test");



Route::get("/alert/{amount}","OMSAlertsController@alert");

//Route::post("/contrat/details/{idcontract}",'OMSContratController@addDetail');


/*
Route::post('/add','ClientsController@saveCustomer');
Route::get('deleteAbonnement/{id}','AbonnementsController@deleteAbonnement');
Route::post('/updateAbonnement','AbonnementsController@updateAbonnement');
Route::post("/add_type",'AbonnementsController@saveAbonnement');

*/

Route::post('/contract/addVehicule/','ContratController@addVehicule');

//Route::post('/contract/Modify','OMSContratController@UpdateContract');
Route::post('/contract/Modify','ContractController@UpdateContract');



Route::post('/contract/detail/Modify','ContratController@updateVehicule');


/*
//Route::post('/addclient', array('uses' => 'ClientsController@saveCustomer'));


//Route::get('client/{id}', 'ClientsController@idC');
/*Route::post('/addclient',['as'=>'/addClient','uses'=>'ClientsController@saveCustomer']);
Route::get('customer/','ClientsController@AllC');

*/
