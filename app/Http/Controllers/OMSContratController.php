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
            ->join('count_vehicle', 'count_vehicle.customer_id', '=', 'customers.id')
            ->join('count_price','count_price.id_contract','=','contracts.id')
            ->select('contracts.*', 'customers.*', 'contracts.id as id_contract', 'types_customers.type as type_customer', 'count_vehicle.*',
                 'count_price.*')

            ->get();

        $AllC = DB::table('customers')->select('customers.id', 'customers.name')->get();

        $ClientType = DB::table('types_customers')
            ->select('types_customers.type as ClientType', 'types_customers.id as ClientTypeId')->get();

        $types_subscribes = DB::table('types_subscribes')->select('types_subscribes.*')->get();

        /*
        $AbonnementType=DB::table('types_subscribes')
        ->select('types_subscribes.type as AbonnementType','types_subscribes.id as AbonnementTypeId')->get();
        $v=DB::table('vehicles')
        ->select('vehicles.*')->get();

        */
//return response()->json([$c]);
//  return view('Contrat',['contracts'=>$c,'clientTypes'=>$ClientType,'abonnementTypes'=>$AbonnementType,'vehicle'=>$v]);
        return view('Contrat', ['contracts' => $c, 'clientTypes' => $ClientType, 'Customers' => $AllC,
            'typeSubscribes'=>$types_subscribes]);
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
            ->join('count_vehicle', 'count_vehicle.customer_id', '=', 'customers.id')
            ->join('count_price','count_price.id_contract','=','contracts.id')
            ->select('contracts.*', 'customers.*', 'contracts.id as id_contract', 'types_customers.type as type_customer', 'count_vehicle.*',
                'count_price.*')


            ->where($critiere)
            ->get();


        return view('ContractLines', ['contracts' => $QueryContracts]);
    }

    public function DisableContract($id)
    {

        $contrat = DB::table('contracts')->where('contracts.id', $id)->update(['isActive' => 0]);
        $details = DB::table('details')->where('details.id', $id)->update(['isActive' => 0]);





        return response()->json([$id]);

    }



    public function refresh()
    {
        $c = DB::table('contracts')
            ->where('contracts.isActive', '=', '1')
            ->join('customers', 'customers.id', '=', 'contracts.id_customer')
            ->join('types_customers', 'types_customers.id', '=', 'customers.id_type_customer')
            ->join('count_vehicle', 'count_vehicle.customer_id', '=', 'customers.id')
            ->join('count_price','count_price.id_contract','=','contracts.id')
            ->select('contracts.*', 'customers.*', 'contracts.id as id_contract', 'types_customers.type as type_customer', 'count_vehicle.*',
                'count_price.*')

            ->get();

        return view('ContractLines', ['contracts' => $c]);
    }

    public function addContrat(Request $request)
    {
          $messages = [
               'required' => strtoupper(':attribute') .' est obligatoire',
              'unique' => strtoupper(':attribute') .' est deja existe'
           ];


           $validator = Validator::make($request->all(), [
               'ncontrat' => 'required',
               'dated' => 'required',
               'client' => 'required|unique:contracts,id_customer',


           ],$messages);

           if ($validator->fails()) {
               $errors = $validator->errors();
               //$errors->add('nom','Le nom est obligatoire');
               //$errors =  json_decode($errors);



               return response()->json([
                   'success' => false,
                   'message' => $errors
               ], 422);
           } else {


        $client= $request->input('client');
        $contract = new Contract();
        $contract->id_customer = $client;


             if($request->input('dated') != null)
                $date_start_contract = $request->input('dated');
             else
                 $date_start_contract = date("Y-m-d");



                   $date = explode('-', $date_start_contract);

                   if($date[2] > 1 and $date[2]<15)
                   {
                       $date[2]='15';
                   }
                   if($date[2] > 15)
                   {
                       $time = strtotime($date_start_contract);
                       $date = date("Y-m-d", strtotime("+1 month", $time));
                       $date = explode('-', $date);
                       $date[2]='1';


                   }

                   $date = implode('-', $date);

                   $date_start_contract=$date;

               $time = strtotime($date_start_contract);
               $date_end_contract = date("Y-m-d",strtotime("+1 year", $time));





        $contract->urlContract = "/contractPdf/" .$client;
        $contract->start_contract = $date_start_contract;
        $contract->end_contract = $date_end_contract;
        $contract->isActive = 1;
        $contract->save();



        $vehicles = DB::table('vehicles')->where('customer_id','=',$client)->get();


        return response()->json(['vehicles'=>$vehicles]);
    }



}
    public function getPrice($idClient,$idTypeSubscribe)
    {
        $idTypeCustomer = DB::table('customers')->where('customers.id','=',$idClient)->select('customers.id_type_customer')->
        pluck('id_type_customer')->first();


        $price = DB::table('type_customers_subscribes')->where('type_customers_subscribes.id_type_customer','=',$idTypeCustomer)
            ->where('type_customers_subscribes.id_type_subscribe','=',$idTypeSubscribe)->select('type_customers_subscribes.price')
            ->pluck('price')->first();



        return response()->json($price);
    }

    public function addDetail(Request $request)
    {

        $messages = [
            'required' => strtoupper(':attribute') .' est obligatoire',
            'unique' => strtoupper(':attribute') .' est deja existe'
        ];


        $validator = Validator::make($request->all(), [
            'typeAbonnement' => 'required',
            'price' => 'required',
            'matricule' => 'required|unique:details,id_vehicle',


        ],$messages);

        if ($validator->fails()) {
            $errors = $validator->errors();
            //$errors->add('nom','Le nom est obligatoire');
            //$errors =  json_decode($errors);



            return response()->json([
                'success' => false,
                'message' => $errors
            ], 422);
        }

        else {

            $vehicleAdd = $request->all('newvehicle');
            $client = $request->input('client');

            if($vehicleAdd == 0) {


                $idTypeCustomer = DB::table('customers')->where('customers.id', '=', $client)->select('customers.id_type_customer')->
                pluck('id_type_customer')->first();
                $idTypeSubscribe = $request->input('typeAbonnement');

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
                $detail = new Detail();
                $detail->id_contract = $idContrat;
                $detail->id_vehicle = $idVehicle;
                $detail->price = $price;
                $detail->id_type_customer_subscribe = $id_type_customer_subscribe;
                $detail->offer = $offre;

                $detail->save();
            }
            else
            {

            }

            return response()->json($request->all());
        }

    }



}