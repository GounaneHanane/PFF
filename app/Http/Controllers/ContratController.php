<?php

namespace App\Http\Controllers;

use App\Models\TypesSubscribe;
use App\Models\Vehicle;
use App\Models\Box;
use App\Models\Detail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use Response;
use Validator;
use Illuminate\Support\Facades\DB;
class ContratController extends Controller
{

   public function AddingInfo($nameCustomer)
   {
       $typesSubscribes = DB::table('types_subscribes')->get();


       $customerId = DB::table('customers')->where('name','=',$nameCustomer)->
       select('customers.id')->pluck('id')->first();

       $contratId = DB::table('contracts')->where('id_customer','=',$customerId)->pluck('id')->first();

       $details = DB::table('details')->where('id_contract','=',$contratId)->
           join('vehicles','vehicles.id','=','details.id_vehicle')->
           join('boxes','boxes.id','=','details.id_boxe')->
           join('types_customers_subscribes','types_customers_subscribes.id','details.id_type_customer_subscribe')->
           join('types_subscribes','types_subscribes.id','types_customers_subscribes.id_subscribe')->
             select('vehicles.*','boxes.*','types_subscribes.*')->get();


       return view('add_client',['types_subscribe'=>$typesSubscribes , 'id_contract'=>$contratId , 'details'=>$details]);

   }
    public function showInfo($idContrat)
    {
        //$typesSubscribes = DB::table('types_subscribes')->get();


        $types_subscribes = DB::table('types_subscribes')->select('types_subscribes.*')->get();


      $contract = DB::table('contracts')->
             select("contracts.*",DB::raw('(contracts.nbAvance + contracts.nbSimple) as nbVehicles'),"contracts.id as idContract")
                 ->where('contracts.id','=',$idContrat)
                 ->first();





        $details = DB::table('details')->where([['id_contract','=',$idContrat],['details.isactive','=','1']])->
        join('vehicles','vehicles.id','details.id_vehicle')->
        join('type_customers_subscribes','type_customers_subscribes.id','details.id_type_customer_subscribe')->
        join('types_subscribes','types_subscribes.id','type_customers_subscribes.id_type_subscribe')->
        select('vehicles.*','vehicles.id as idVehicle','types_subscribes.id as idtypeSub','types_subscribes.type as typeSub','details.*')->get();
        $type=DB::table('types_subscribes')->
            select('types_subscribes.*')->get();
        $vehicle=DB::table('vehicles')->where([['vehicles.isActive','=','1'],['contracts.id','=',$idContrat]])->
        join('customers','customers.id','vehicles.customer_id')->
        join('contracts','customers.id','contracts.id_customer')->
        select('vehicles.*')->get();
        $client=DB::table('contracts')->where([['contracts.id','=',$idContrat],['contracts.isactive','=','1']])->
            join('customers','customers.id','contracts.id_customer')->
            select('customers.name','contracts.*')->get();

        return view('contractInfo',['details'=>$details,'cli'=>$client,'types'=>$type,'vehicles'=>$vehicle ,
             "types_subscribes"=>$types_subscribes , "contract"=>$contract ]);
       // return response()->json($client);
    }
    public  function refreshDetail($idContract)
    {
        $details = DB::table('details')->where('details.id_contract','=',$idContract)
            ->where('details.isActive','=','1')
            ->join('vehicles','vehicles.id','details.id_vehicle')
            ->join('type_customers_subscribes','type_customers_subscribes.id','details.id_type_customer_subscribe')
            ->join('types_subscribes','types_subscribes.id','type_customers_subscribes.id_type_subscribe')
            ->select('details.*','vehicles.*','types_subscribes.type','details.id as id_detail')
            ->get();

        return view('DetailsLines',[ 'details'=>$details ]);



    }
    public function getPrice(Request $request)
    {
        if ($request->input('AddingDate'))
            $AddingDate = $request->input('AddingDate');
        else
            $AddingDate = date("Y-m-d");


        $date = explode('-', $AddingDate);

        if ($date[2] > 1 and $date[2] < 15) {
            $date[2] = '15';
        }
        if ($date[2] > 15) {
            $time = strtotime($AddingDate);
            $date = date("Y-m-d", strtotime("+1 month", $time));
            $date = explode('-', $date);
            $date[2] = '1';


        }

        $date = implode('-', $date);

        $AddingDate=$date;
        $idTypeCustomer = DB::table('vehicles')->where('vehicles.id', '=', $request->input('vehicules'))->
        join('customers', 'customers.id', 'vehicles.customer_id')->
        join('types_customers', 'types_customers.id', 'customers.id_type_customer')->
        select('types_customers.id')->pluck('id')->first();

        $PriceTypeCustomerSubscribe = DB::table('type_customers_subscribes')->where('id_type_subscribe', '=', $request->input('types'))
            ->where('id_type_customer', '=', $idTypeCustomer)->select('type_customers_subscribes.price')->pluck("price")->first();
        $idContract = DB::table('vehicles')->where('vehicles.id', '=',$request->input('vehicules') )->
        join('customers', 'customers.id', 'vehicles.customer_id')->
        join('contracts','contracts.id_customer','customers.id')->
        select('contracts.id')->pluck('id')->first();

        $end_contract=DB::table('contracts')->where('id','=',$idContract)
            ->select(DB::raw('day(end_contract) as date'))->pluck('date')->first();
        $price=DB::table('contracts')->where('id','=',$idContract)
            ->select(DB::raw($PriceTypeCustomerSubscribe."*timestampdiff(month,'".$AddingDate."',end_contract)/timestampdiff(month,start_Contract,end_contract) as thirdPrice"))
            ->pluck('thirdPrice')->first();
        $AddingDate = explode('-', $AddingDate);

        if($end_contract!=$AddingDate[2])
        {
            $price+=($PriceTypeCustomerSubscribe/12)*(1/2);
        }

        return response($price);
    }
    public function getPriceEdit(Request $request)
    {
        if ($request->input('AddingDateEdit'))
            $AddingDate = $request->input('AddingDateEdit');
        else
            $AddingDate = date("Y-m-d");


        $date = explode('-', $AddingDate);

        if ($date[2] > 1 and $date[2] < 15) {
            $date[2] = '15';
        }
        if ($date[2] > 15) {
            $time = strtotime($AddingDate);
            $date = date("Y-m-d", strtotime("+1 month", $time));
            $date = explode('-', $date);
            $date[2] = '1';


        }

        $date = implode('-', $date);

        $AddingDate=$date;
        $idContract = $request->input('idContract');

        $idTypeCustomer = DB::table('contracts')->where('contracts.id','=',$idContract)
            ->join('customers','customers.id','contracts.id_customer')
            ->select('customers.id_type_customer')->pluck('id_type_customer')->first();


        $PriceTypeCustomerSubscribe = DB::table('type_customers_subscribes')->where('id_type_subscribe', '=', $request->input('types'))
            ->where('id_type_customer', '=', $idTypeCustomer)->select('type_customers_subscribes.price')->pluck("price")->first();


        $price=DB::table('contracts')->where('contracts.id','=',$idContract)
            ->select(DB::raw($PriceTypeCustomerSubscribe."*datediff(end_contract,'".$AddingDate."')/datediff(end_contract,start_Contract) as thirdPrice"))
            ->pluck('thirdPrice')->first();

       return response($price);
    }
    public function updateVehicule(Request $request)
    {
  if ($request->input('AddingDateEdit'))
            $AddingDate = $request->input('AddingDateEdit');
        else
            $AddingDate = date("Y-m-d");


        $date = explode('-', $AddingDate);

        if ($date[2] > 1 and $date[2] < 15) {
            $date[2] = '15';
        }
        if ($date[2] > 15) {
            $time = strtotime($AddingDate);
            $date = date("Y-m-d", strtotime("+1 month", $time));
            $date = explode('-', $date);
            $date[2] = '1';


        }

        $date = implode('-', $date);

        $AddingDate=$date;
        $idTypeCustomer = DB::table('vehicles')->where('vehicles.imei', '=', $request->input('imeiId'))->
        join('customers', 'customers.id', 'vehicles.customer_id')->
        join('types_customers', 'types_customers.id', 'customers.id_type_customer')->
        select('types_customers.id')->pluck('id')->first();

        $TypeCustomerSubscribe = DB::table('type_customers_subscribes')->where('id_type_subscribe', '=', $request->input('typesEdit'))
            ->where('id_type_customer', '=', $idTypeCustomer)->select('type_customers_subscribes.id')->pluck('id')->first();
        $contract = DB::table('vehicles')->where('imei','=',$request->input('imeiId'))
            ->join('details','details.id_vehicle','vehicles.id')
            ->update(['id_type_customer_subscribe'=>$TypeCustomerSubscribe , 'price'=>$request->input('priceVehiclesEdit'),
                'AddingDate'=>$AddingDate ]
            );
        return response()->json([(['id_type_customer_subscribe'=>$TypeCustomerSubscribe , 'price'=>$request->input('priceVehiclesEdit'),
            'AddingDate'=>$AddingDate
    ])]);
    }
   public function addVehicule(Request $request)
   {

       $messages = [
           'required' => strtoupper(':attribute') .' est obligatoire',
           'unique' => strtoupper(':attribute').' est déja existe'
       ];






       $validator = Validator::make($request->all(), [
           'vehicules' => 'required|unique:details,id_vehicle',
           'types' => 'required',
           'priceVehicles'=>'required',




       ],$messages);

       if ($validator->fails())
       {
           $errors = $validator->errors();



           return response()->json([
               'success' => false,
               'message' => $errors
           ], 422);
       }

       else {





           if ($request->input('AddingDate'))
               $AddingDate = $request->input('AddingDate');
           else
               $AddingDate = date("Y-m-d");


           $date = explode('-', $AddingDate);

           if ($date[2] > 1 and $date[2] < 15) {
               $date[2] = '15';
           }
           if ($date[2] > 15) {
               $time = strtotime($AddingDate);
               $date = date("Y-m-d", strtotime("+1 month", $time));
               $date = explode('-', $date);
               $date[2] = '1';


           }

           $date = implode('-', $date);

            $AddingDate=$date;
          /* $VehicleId = DB::table('vehicles')->where('imei', '=', $request->input('vehicule'))->
           select('vehicles.id')->pluck('id')->first();*/


           $idTypeCustomer = DB::table('vehicles')->where('vehicles.id', '=', $request->input('vehicules'))->
           join('customers', 'customers.id', 'vehicles.customer_id')->
           join('types_customers', 'types_customers.id', 'customers.id_type_customer')->
           select('types_customers.id')->pluck('id')->first();

           $TypeCustomerSubscribe = DB::table('type_customers_subscribes')->where('id_type_subscribe', '=', $request->input('types'))
               ->where('id_type_customer', '=', $idTypeCustomer)->select('type_customers_subscribes.*');

           $idTypeCustomerSubscribe = $TypeCustomerSubscribe->pluck('id')->first();

           $idContract = DB::table('vehicles')->where('vehicles.id', '=',$request->input('vehicules') )->
           join('customers', 'customers.id', 'vehicles.customer_id')->
           join('contracts','contracts.id_customer','customers.id')->
           select('contracts.id')->pluck('id')->first();

                $detail = new Detail();
                $detail->id_contract = $idContract;
                $detail->id_vehicle = $request->input('vehicules');
                $detail->id_type_customer_subscribe = $idTypeCustomerSubscribe ;
                $detail->price = $request->input('priceVehicles');
                $detail->offer = 0;
                $detail->AddingDate=$AddingDate;

    $detail->save();

           return response($idTypeCustomer . $idTypeCustomerSubscribe  );


       }


   }

   public function detailsInfo($id)
   {
       $detail = DB::table('details')->where('details.id','=',$id)
            ->join('vehicles','vehicles.id','details.id_vehicle')
           ->join('type_customers_subscribes','type_customers_subscribes.id','details.id_type_customer_subscribe')
           ->join('types_subscribes','types_subscribes.id','type_customers_subscribes.id_type_subscribe')

       ->select('details.*','vehicles.*','types_subscribes.id as id_subscribe')->first();
       return response()->json(["detail"=>$detail]);
   }

   public function renewal($id)
   {

       $contract = DB::table('contracts')->where('contracts.id','=',$id)->select('contracts.*')->first();

        $renwal =  \DB::table('renewal')->insert([
           [
               'id_contract'      => $contract->id,
               'urlContract'             => "",
               'start_renewal' => $contract->start_contract,
               'end_renewal'      => $contract->end_contract,
               'nbAvance'             => $contract->nbAvance,
               'nbSimple'             => $contract->nbSimple,
               'priceAvance'             => $contract->priceAvance,
               'priceSimple'             => $contract->priceSimple,
               'price' => $contract->price,
               'defaultSimple' => $contract->defaultSimple,
               'defaultAvance' => $contract->defaultAvance,
               'isActive'          => 1
           ]
       ]);

       return response()->json($contract);
   }

}