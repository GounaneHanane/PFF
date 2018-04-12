<?php

namespace App\Http\Controllers;

use App\Models\TypesSubscribe;
use App\Models\Vehicle;
use App\Models\Box;
use App\Models\Detail;
use  App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use function PHPSTORM_META\type;
use Response;
use Validator;



use Illuminate\Support\Facades\DB;
class OMSContratController extends Controller
{


    public function contrat()
    {


        $c = DB::table('contracts')
            ->where('contracts.isActive', '=', '1')
            ->join('customers', 'customers.id', '=', 'contracts.id_customer')
            ->join('types_customers', 'types_customers.id', '=', 'customers.id_type_customer')
            ->join('contract_warning','contract_warning.id','=','contracts.id')
            ->select('contracts.*','count', 'customers.*', 'contracts.id as id_contract', 'types_customers.type as type_customer',
                DB::raw('( ifnull(contracts.nbAvance,0) + ifnull(contracts.nbSimple,0)) as nbVehicles'))
            ->get();


        $hasContrat = DB::table('customers')
            ->whereIn('customers.id',function($q){
                $q->select('contracts.id_customer')->from('contracts');
            })
            ->select('customers.id', 'customers.name')->get();

        $hasnotContrat = DB::table('customers')
            ->whereNotIn('customers.id',function($q){
                $q->select('contracts.id_customer')->from('contracts');
            })
            ->select('customers.id', 'customers.name')->get();



        $nb=DB::table('alerte')
            ->select(DB::raw('count(*) as nb'))->get();
        
        $ClientType = DB::table('types_customers')
            ->select('types_customers.type as ClientType', 'types_customers.id as ClientTypeId')->get();

        $types_subscribes = DB::table('types_subscribes')->select('types_subscribes.*')->get();


        return view('Contrat', ['contracts' => $c, 'clientTypes' => $ClientType, 'Customers' => $hasContrat,
            'typeSubscribes' => $types_subscribes,'nb'=>$nb,'clients' => $hasnotContrat]);

    }


    public function searchContrat(Request $request)
    {
        $id_contract = ($request->input('id_contract') == null) ? null : $request->input('id_contract');
        $id_customer = ($request->input('id_customer') == null) ? null : $request->input('id_customer');
        $debut_contrat = ($request->input('debut_contrat') == null) ? null : $request->input('debut_contrat');
        $fin_contrat = ($request->input('fin_contrat') == null) ? null : $request->input('fin_contrat');
        $typeClient = ($request->input('typeClient') == null) ? null : $request->input('typeClient');
        $critiere = [];
        $i = 0;

        $contracts = DB::table('contracts')->where('contracts.isActive', '=', '1');

        if ($id_contract != null) {
            $critiere[$i] = ['contracts.id', '=', $id_contract];
            $i++;

        }
        if ($debut_contrat != null) {
            $critiere[$i] = ['contracts.start_contract', '=', $debut_contrat];
            $i++;

        }
        if ($fin_contrat != null) {
            $critiere[$i] = ['contracts.end_contract', '=', $fin_contrat];
            $i++;

        }

        if ($typeClient != null) {
            $critiere[$i] = ['customers.id_type_customer', '=', $typeClient];
            $i++;

        }
        if ($id_customer != null) {
            $critiere[$i] = ['customers.id', '=', $id_customer];
            $i++;

        }


        $QueryContracts = $contracts
            ->join('customers', 'customers.id', '=', 'contracts.id_customer')
            ->join('types_customers', 'types_customers.id', '=', 'customers.id_type_customer')

            ->where($critiere)
            ->select('contracts.*', 'customers.*', 'contracts.id as id_contract', 'types_customers.type as type_customer',
                DB::raw('(contracts.nbAvance + contracts.nbSimple) as nbVehicles'))
            ->get();



        return view('ContractLines', ['contracts' => $QueryContracts]);

    }



    public function DisableContract($id)
    {

        $contrat = DB::table('contracts')->where('contracts.id', $id)->update(['isActive' => 0]);

        $idDetails = DB::table('details')->where('details.id_contract', '=', $contrat);

        if (isset($idDetails))
            $details = DB::table('details')->where('details.id_contract', $contrat)->update(['isActive' => 0]);


        return response()->json([$id]);

    }

    public function DisableDetail($id)
    {

        $detail = DB::table('details')->where('details.id', $id)->update(['isActive' => 0]);

    }

    public function refresh()
    {
        $c = DB::table('contracts')
            ->where('contracts.isActive', '=', '1')
            ->join('customers', 'customers.id', '=', 'contracts.id_customer')
            ->join('types_customers', 'types_customers.id', '=', 'customers.id_type_customer')
            ->select('contracts.*', 'customers.*', 'contracts.id as id_contract', 'types_customers.type as type_customer',
                DB::raw('(contracts.nbAvance + contracts.nbSimple) as nbVehicles'))
            ->get();

        return view('ContractLines', ['contracts' => $c]);
    }
    public function update($id)
    {

             $contracts = DB::table('contracts')->where('contracts.id','=',$id)
                 ->join('customers','customers.id','contracts.id_customer')
                 ->select('contracts.*', DB::raw('(contracts.nbAvance + contracts.nbSimple) as nbVehicles'))
                 ->first();





             $customer = DB::table('customers')->where('customers.id','=',$contracts->id_customer)->select('customers.*')->first();



             return response()->json(['contracts'=>$contracts ,  'customer'=>$customer]);
    }

    public function PriceVehicles($idCustomer,$type,$many)
    {
/*
 *
 *
 *
*/

        $vehciles = DB::table('vehicles')->where('vehicles.customer_id','=',$idCustomer)
        ->get()->count();

        $typeCustomerId = DB::table('customers')->where('customers.id','=',$idCustomer)->select('customers.id_type_customer')->pluck('id_type_customer')->first();

        $price = $this->getPrice($idCustomer,$type);

        $total = $many * $price;




        return response()->json(['vehicles'=>$vehciles , 'typeCustomerId'=>$typeCustomerId ,'price'=>$price,'typeSubscribe'=>$type , 'total'=>$total]);

    }

    public function PriceCalcul(Request $request)
    {
        $nbVehciles = $request->input("nbVehicles");
        $type = $request->input("type");
        $idTypeSubscribe = DB::table('types_subscribes')->where('type','=',$type)->select('types_subscribes.id')
            ->pluck('id')->first();

        $idCustomer = $request->input("idCustomer");
        $typeCustomerId = DB::table('customers')->where('customers.id','=',$idCustomer)->select('customers.id_type_customer')->pluck('id_type_customer')->first();

        $price = $this->getPrice($idCustomer,$idTypeSubscribe);

        $total = $nbVehciles * $price;



       return response($total);
    }

    public function CountVehicles($idCustomer)
    {
        $vehciles = DB::table('vehicles')->where('vehicles.customer_id','=',$idCustomer)->get()->count();

        return response($vehciles);
    }

    public function DetailVehicles($id)
    {
        $vehicles = DB::table('contracts')

            ->where('contracts.id','=',$id)
            ->join('customers','customers.id','contracts.id_customer')
            ->join('vehicles','vehicles.customer_id','customers.id')
            ->select('vehicles.*','contracts.id as contract_id','contracts.*')
            ->get();

        return response()->json(['vehicles'=>$vehicles]);
    }

    public function DetailSelected($id)
    {
        $details = DB::table('details')->where('details.id','=',$id)
            ->where('details.isActive','=','1')
            ->join('vehicles','vehicles.id','details.id_vehicle')
             ->join('type_customers_subscribes','type_customers_subscribes.id','details.id_type_customer_subscribe')
             ->join('types_subscribes','types_subscribes.id','type_customers_subscribes.id_type_subscribe')
              ->select('details.id as id_detail','details.*','vehicles.*','vehicles.*','types_subscribes.id as types_subscribe_id')->first();


        return response()->json(['details'=>$details ]);

    }

    public function UpdateDetailSelected(Request $request)
    {



        $messages = [
            'required' => strtoupper(':attribute') . ' est obligatoire',
            'unique' => strtoupper(':attribute') . ' est deja existe'
        ];

        $validator = Validator::make($request->all(), [
            'client' => 'required|unique:contracts,id_customer',


        ], $messages);

    }
    static $i=0;
    public function addContrat(Request $request)
    {
        $messages = [
            'required' => strtoupper(':attribute') . ' est obligatoire',
            'unique' => strtoupper(':attribute') . ' est deja existe'
        ];


        $validator = Validator::make($request->all(), [
            'client' => 'required|unique:contracts,id_customer',


        ], $messages);

        if ($validator->fails()) {
            $errors = $validator->errors();
            //$errors->add('nom','Le nom est obligatoire');
            //$errors =  json_decode($errors);


            return response()->json([
                'success' => false,
                'message' => $errors
            ], 422);
        } else {


            $client = $request->input('client');
            $nbSimple = $request->input('nbVehiclesSimple');
            $nbAvance = $request->input('nbVehiclesAvance');
            $priceSimple = $request->input('priceVehiclesSimple');
            $priceAvance = $request->input('priceVehiclesAvance');
            $defaultSimple = $request->input('defaultSimple');
            $defaultAvance = $request->input('defaultAvance');

            $id_type_client = DB::table('customers')->where('customers.id','=',$client)
                ->select('customers.id_type_customer')->pluck('id_type_customer')->first();






            $total = $priceAvance + $priceSimple;
            $contract = new Contract();
            $contract->id="CR-".(i+1);
            $contract->id_customer = $client;
            $contract->nbSimple = $nbSimple;
            $contract->nbAvance = $nbAvance;
            $contract->defaultSimple = $defaultSimple;
            $contract->defaultAvance = $defaultAvance;
            $contract->priceAvance = $priceAvance;
            $contract->priceSimple = $priceSimple;


            $contract->price = $total;


            if ($request->input('dated'))
                $date_start_contract = $request->input('dated');
            else
                $date_start_contract = date("Y-m-d");


            $date = explode('-', $date_start_contract);

            if ($date[2] > 1 and $date[2] < 15) {
                $date[2] = '15';
            }
            if ($date[2] > 15) {
                $time = strtotime($date_start_contract);
                $date = date("Y-m-d", strtotime("+1 month", $time));
                $date = explode('-', $date);
                $date[2] = '1';


            }

            $date = implode('-', $date);

            $date_start_contract = $date;

            $time = strtotime($date_start_contract);
            $date_end_contract = date("Y-m-d", strtotime("+1 year", $time));


            $contract->urlContract = "/contractPdf/" . $client;
            $contract->start_contract = $date_start_contract;
            $contract->end_contract = $date_end_contract;
            $contract->isActive = 1;
            $contract->save();


           // $vehicles = DB::table('vehicles')->where('customer_id', '=', $client)->get();


            return response("Ajouté");
        }


    }

    public function getPrice($idClient)
    {
        $idTypeCustomer = DB::table('customers')->where('customers.id', '=', $idClient)->select('customers.id_type_customer')->
        pluck('id_type_customer')->first();



        $priceSimple = DB::table('type_customers_subscribes')->where('type_customers_subscribes.id_type_customer', '=', $idTypeCustomer)
            ->where('type_customers_subscribes.id_type_subscribe', '=', '1')->select('type_customers_subscribes.price')
            ->pluck('price')->first();
        $priceAvance = DB::table('type_customers_subscribes')->where('type_customers_subscribes.id_type_customer', '=', $idTypeCustomer)
            ->where('type_customers_subscribes.id_type_subscribe', '=', '2')->select('type_customers_subscribes.price')
            ->pluck('price')->first();


        $nbVehicles = DB::table('vehicles')->where('vehicles.customer_id','=',$idClient)
            ->count();


        return response()->json(['priceSimple' => $priceSimple , 'priceAvance'=>$priceAvance,'nbVehicles'=>$nbVehicles]);
      //  return response()->json(['idtc'=>$idClient]);

    }

    public function addDetail(Request $request)
    {

        $messages = [
            'required' => strtoupper(':attribute') . ' est obligatoire',
            'unique' => strtoupper(':attribute') . ' est deja existe'
        ];

        $input = array('typeAbonnement' => 'required',
            'price' => 'required');

        $vehicleAdd = $request->input('newvehicle');


        if ($vehicleAdd == 1) {
            $input['imei'] = 'required';
            $input['marque'] = 'required';
            $input['model'] = 'required';

        } else {
            $input['matricule'] = 'required';
        }
        $validator = Validator::make($request->all(), $input, $messages);
        if ($validator->fails()) {
            $errors = $validator->errors();
            //$errors->add('nom','Le nom est obligatoire');
            //$errors =  json_decode($errors);


            return response()->json([
                'success' => false,
                'message' => $errors,
                'inputs' => $input
            ], 422);
        } else {


            $client = $request->input('client');
            $idTypeCustomer = DB::table('customers')->where('customers.id', '=', $client)->select('customers.id_type_customer')->
            pluck('id_type_customer')->first();
            $idTypeSubscribe = $request->input('typeAbonnement');

            $imei = $request->input('imei');
            $marque = $request->input('marque');
            $model = $request->input('model');
            $matricule = $request->input('matricule');


            $id_type_customer_subscribe = DB::table('type_customers_subscribes')->where('type_customers_subscribes.id_type_customer', '=', $idTypeCustomer)
                ->where('type_customers_subscribes.id_type_subscribe', '=', $idTypeSubscribe)->select('type_customers_subscribes.id')
                ->pluck('id')->first();


            $idContrat = DB::table('contracts')->where('contracts.id_customer', '=', $client)->
            select('contracts.id')->pluck('id')->first();
            $idVehicle = $request->input('matricule');
            $price = $request->input('price');

            $Defaultprice = DB::table('type_customers_subscribes')->where('type_customers_subscribes.id_type_customer', '=', $idTypeCustomer)
                ->where('type_customers_subscribes.id_type_subscribe', '=', $idTypeSubscribe)->select('type_customers_subscribes.price')
                ->pluck('price')->first();
            if ($price == $Defaultprice)
                $offre = 0;
            else
                $offre = 1;
            if ($vehicleAdd == 0) {


                $detail = new Detail();
                $detail->id_contract = $idContrat;
                $detail->id_vehicle = $idVehicle;
                $detail->price = $price;
                $detail->id_type_customer_subscribe = $id_type_customer_subscribe;
                $detail->offer = $offre;

                $detail->save();
            } else {


                $vehicle = new Vehicle();
                $vehicle->imei = $imei;
                $vehicle->marque = $marque;
                $vehicle->model = $model;
                $vehicle->customer_id = $client;
                $vehicle->user_id = 10;

                $vehicle->save();


                $idVehicle = DB::table('vehicles')->where('vehicles.imei', '=', $imei)->select('vehicles.id')->pluck('id')->first();

                $detail = new Detail();
                $detail->id_contract = $idContrat;
                $detail->id_vehicle = $idVehicle;
                $detail->price = $price;
                $detail->id_type_customer_subscribe = $id_type_customer_subscribe;
                $detail->offer = $offre;

                $detail->save();
            }

            return response()->json($request->all());


        }
    }

        public function AddDetailGammme(Request $request)
        {

            $typeAbonnement = $request->input('typeAbonnement');
            $nbVehicles =  $request->input('nbVehicles');
            $total =  $request->input('priceVehicles');
            $price = $total / $nbVehicles;
            $idCustomer = $request->input('client');
            $idContrat = DB::table('contracts')->where('contracts.id_customer', '=', $idCustomer)->
            select('contracts.id')->pluck('id')->first();


            $vehicles = DB::table('vehicles')
                ->where('vehicles.customer_id','=',$idCustomer)
                ->whereNotIn('vehicles.id',function($q){
                $q->select('details.id_vehicle')->from('details');
            })->get();

            $idTypeCustomer = DB::table('customers')->where('customers.id', '=', $idCustomer)->select('customers.id_type_customer')->
            pluck('id_type_customer')->first();

            $id_type_customer_subscribe = DB::table('type_customers_subscribes')->where('type_customers_subscribes.id_type_customer', '=', $idTypeCustomer)
                ->where('type_customers_subscribes.id_type_subscribe', '=', $typeAbonnement)->select('type_customers_subscribes.id')
                ->pluck('id')->first();

            $countVehicles = $vehicles->count();

            $Defaultprice = DB::table('type_customers_subscribes')->where('type_customers_subscribes.id_type_customer', '=', $idTypeCustomer)
                ->where('type_customers_subscribes.id_type_subscribe', '=', $typeAbonnement)->select('type_customers_subscribes.price')
                ->pluck('price')->first();
            if ($price == $Defaultprice)
                $offre = 0;
            else
                $offre = 1;

            for($i = 0; $i < $nbVehicles;$i++)
            {
                $detail = new Detail();
                $detail->id_contract = $idContrat;
                $detail->id_vehicle = $vehicles[$i]->id;
                $detail->typeSubsribe = $typeAbonnement;
                $detail->price = $price;
                $detail->id_type_customer_subscribe = $id_type_customer_subscribe;
                $detail->offer = $offre;

                $detail->save();



            }





            //$vehicles = DB::table('vehicles'),





            // return response($typeAbonnement." ".$nbVehicles." ".$total." ".$price." ".$idCustomer." ".$idContrat);

            return response()->json($vehicles);
        }
       public function updateContract(Request $request)
       {

           $client = $request->input("client");
           $nbAvance = $request->input("nbAvance");
           $nbSimple = $request->input("nbSimple");

           $defaultAvance  = $request->input("defaultAvance");
           $defaultSimple  = $request->input("defaultSimple");

           $priceAvance = $request->input("priceAvance");
           $priceSimple = $nbSimple * $defaultSimple;
           $priceAvance = $nbAvance * $defaultAvance;





           $total = $priceAvance + $priceSimple;


           $contract = DB::table('contracts')->where('contracts.id_customer','=',$client)
               ->update(['nbSimple'=>$nbSimple , 'nbAvance'=>$nbAvance , 'price'=>$total ,
                     'priceSimple'=>$priceSimple , 'priceAvance'=>$priceAvance
                     ,'defaultSimple'=>$defaultSimple , 'defaultAvance'=>$defaultAvance
                   ]);


           return response()->json(['dA'=>$defaultAvance,'dS'=>$defaultSimple]);
       }

       public function searchDetail(Request $request)
       {
           $imei = ($request->input('imei') == null) ? null : $request->input('imei');
           $type_abonnement = ($request->input('type_abonnement') == null) ? null : $request->input('type_abonnement');
           $dateAjout = ($request->input('dateAjout') == null) ? null : $request->input('dateAjout');
           $marque = ($request->input('marque') == null) ? null : $request->input('marque');
           $modele = ($request->input('model') == null) ? null : $request->input('model');
           $critiere = [];
           $i = 0;

           $details = DB::table('info_detail_contract')->where('info_detail_contract.isActive', '=', '1');






           if ($imei != null) {
               $critiere[$i] = ['vehicles.imei', 'like', '%'.$imei.'%'];
               $i++;

           }

           if($marque != null)
           {
               $critiere[$i] = ['vehicles.marque', 'like', '%'.$marque.'%'];
               $i++;
           }
           if($modele != null)
           {
               $critiere[$i] = ['vehicles.model', 'like', '%'.$modele.'%'];
               $i++;
           }

           if ($type_abonnement != null) {
               /*

               $idCustomer = DB::table('contracts')
                   ->where('contracts.id','=',$idContract)
                   ->select('contracts.id_customer')
                   ->pluck('id_customer')->first();


               $id_type_customer = DB::table('customers')
                   ->where('customers.id','=',$idCustomer)
                   ->select('customers.id_type_customer')
                   ->pluck('id_type_customer')->first();

               $matrice = DB::table('type_customers_subscribes')
                   ->where('type_customers_subscribes.id_type_customer','=',$id_type_customer)
                   ->where('type_customers_subscribes.id_type_subscribe','=',$type_abonnement)
                   ->select('type_customers_subscribes.id')->pluck('id')->first();
   */
               $critiere[$i] = ['types_subscribes.id','=',$type_abonnement];
               $i++;

           }
           if ($dateAjout != null) {
               $critiere[$i] = ['info_detail_contract.AddingDate', '=', $dateAjout];
               $i++;

           }




           $QueryDetails = $details
               ->join('detail_contract','detail_contract.id','info_detail_contract.id_detail')
               ->join('vehicles','vehicles.id','info_detail_contract.id_vehicle')
               ->join('type_customers_subscribes','type_customers_subscribes.id','info_detail_contract.id_type_customer_subscribe')
               ->join('types_subscribes','types_subscribes.id','type_customers_subscribes.id_type_subscribe')


               ->where($critiere)

               ->select('info_detail_contract.*','detail_contract.id as id_contract','vehicles.*','types_subscribes.type','info_detail_contract.id as id_detail')

               ->get();




           // $vehilces = DB::table('vehicles')->where($critiere)->select('vehicles.*')->get();

           //return response()->json([ 'critiere'=>$critiere , 'details'=>$QueryDetails , 'matrice'=>$matrice , 'typeC'=>$id_type_customer]);
           return view('DetailsLines',[ 'details'=>$QueryDetails ]);
       }





}






