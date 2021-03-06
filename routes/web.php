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



// /contract

Route::post('/contrat/addcontrat','ContractController@addContrat');
Route::get('/contrat/', 'ContractController@contrat');
Route::post('/contract/Modify','ContractController@UpdateContract');
Route::get('/contrat/countVehicles/{idVehicle}','ContractController@CountVehicles');
Route::get('/contrat/delete/{id}','ContractController@DisableContract');
Route::get('/contrat/update/{id}', 'ContractController@update');
Route::get("/contrat/price/{idClient}/",'ContractController@getPrice'); // Renewal
Route::get('/contrat/search/', 'ContractController@searchContrat');// Renewal
Route::post('/renewal/vehicles','ContractController@vehicleRenewal'); // alert


// Renewal
Route::get('/Renouvelement','RenouvelementController@renewal');
Route::post('/renewal/','RenouvelementController@renewalVehicles');



// alert
Route::get('/home','AlertController@alert');
Route::get('/alerte/renv/{id_detail}','AlertController@Alert_Detail_Contrat');
Route::get('/alert/{amount}','AlertController@alertByTime');



// Details
Route::get("/contrat/showdetails/{idDetail}",'DetailController@showInfo');
Route::get("/detail/search/","DetailController@searchDetail");
Route::get('/contrat/detail/verifyType/{idDetail}/{idType}','DetailController@verifyType');
Route::get("/details/info/{id}","DetailController@detailsInfo");
Route::get('/detail/delete/{id}','DetailController@DisableDetail');
Route::post("/contrat/detail/price/calcul","DetailController@getPrice");
Route::post('/contract/addVehicule/','DetailController@addVehicule');
Route::post("/contrat//detail/price/calculEdit","DetailController@getPriceEdit");

Route::post('/contract/detail/Modify','DetailController@updateVehicule');


Route::get('/pdf/{id}','GenerateController@test');
Route::get('/pdf/contract/{matricule}','GenerateCController@contract');
