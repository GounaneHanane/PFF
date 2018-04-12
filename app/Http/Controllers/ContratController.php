<?php

namespace App\Http\Controllers;

use App\detail_contract;
use App\info_detail_contract;
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

       $details = DB::table('info_detail_contract')->where('id_contract','=',$contratId)->
           join('detail_contract','detail_contract.id=id_detail')->
           join('vehicles','vehicles.id','=','info_detail_contract.id_vehicle')->
           join('types_customers_subscribes','types_customers_subscribes.id','info_detail_contract.id_type_customer_subscribe')->
           join('types_subscribes','types_subscribes.id','types_customers_subscribes.id_subscribe')->
             select('vehicles.*','types_subscribes.*')->get();


       return view('add_client',['types_subscribe'=>$typesSubscribes , 'id_contract'=>$contratId , 'details'=>$details]);

   }
    public function showInfo($idContrat)
    {
        //$typesSubscribes = DB::table('types_subscribes')->get();


       $types_subscribes = DB::table('types_subscribes')->select('types_subscribes.*')->get();


      $contract = DB::table('contracts')->where('status','=','1')->
          join('detail_contract','detail_contract.id_contract','contracts.id')->
             select("contracts.*",DB::raw("(detail_contract.nbavance + detail_contract.nbSimple) as nbVehicles"),"detail_contract.*","contracts.id as idContract")
                 ->where('detail_contract.id','=',$idContrat)
                 ->first();





        $details = DB::table('info_detail_contract')->where([['id_contract','=',$idContrat],['info_detail_contract.isactive','=','1'],['detail_contract.status','=','1']])->
        join('vehicles','vehicles.id','info_detail_contract.id_vehicle')->
        join('detail_contract','detail_contract.id','info_detail_contract.id_detail')->
        join('type_customers_subscribes','type_customers_subscribes.id','info_detail_contract.id_type_customer_subscribe')->
        join('types_subscribes','types_subscribes.id','type_customers_subscribes.id_type_subscribe')->
        select('vehicles.*','vehicles.id as idVehicle','types_subscribes.id as idtypeSub','types_subscribes.type as typeSub','info_detail_contract.*')->get();
      ;
      $type=DB::table('types_subscribes')->
    select('types_subscribes.*')->get();
        $vehicle=DB::table('vehicles')->where([['vehicles.isActive','=','1'],['contracts.id','=',$idContrat]])->
        join('customers','customers.id','vehicles.customer_id')->
        join('contracts','customers.id','contracts.id_customer')->

        select('vehicles.*')->get();
        $client=DB::table('contracts')->where([['contracts.id','=',$idContrat],['contracts.isactive','=','1'],['status','=','1']])->
            join('customers','customers.id','contracts.id_customer')->
        join('detail_contract','detail_contract.id_contract','contracts.id')->
            select('customers.name','detail_contract.*')->get();
        $nb=DB::table('alerte')
            ->select(DB::raw('count(*) as nb'))->get();

        return view('contractInfo',['details'=>$details,  "types_subscribes"=>$types_subscribes ,"contract"=>$contract,'types'=>$type  ,"nb"=>$nb,'vehicles'=>$vehicle,'cli'=>$client]);
       // return response()->json($client);
    }
    public  function refreshDetail($idContract)
    {
        $details = DB::table('info_detail_contract')->where('detail_contract.id_contract','=',$idContract)
            ->where('info_detail_contract.isActive','=','1')
            ->join('detail_contract','detail_contract.id','info_detail_contract.id_detail')
            ->join('vehicles','vehicles.id','info_detail_contract.id_vehicle')
            ->join('type_customers_subscribes','type_customers_subscribes.id','info_detail_contract.id_type_customer_subscribe')
            ->join('types_subscribes','types_subscribes.id','type_customers_subscribes.id_type_subscribe')
            ->select('info_detail_contract.*','vehicles.*','types_subscribes.type','info_detail_contract.id as id_detail')
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

        $idDetailContract = DB::table('vehicles')->where('vehicles.id', '=',$request->input('vehicules') )->
        join('customers', 'customers.id', 'vehicles.customer_id')->
        join('contracts','contracts.id_customer','customers.id')->
        join('detail_contract','detail_contract.id_contract','contracts.id')->
        select('detail_contract.id')->pluck('id')->first();
        if($request->input('types')==1)
            $PriceContract = DB::table('detail_contract')->where('id', '=', $idDetailContract)
                ->select('defaultSimple')->pluck("defaultSimple")->first();
        else
            $PriceContract = DB::table('detail_contract')->where('id', '=', $idDetailContract)
                ->select('defaultAvance')->pluck("defaultAvance")->first();
        $end_contract=DB::table('detail_contract')->where('id','=',$idDetailContract)
            ->select(DB::raw('day(end_contract) as date'))->pluck('date')->first();
        $price=DB::table('detail_contract')->where('id','=',$idDetailContract)
            ->select(DB::raw($PriceContract."*timestampdiff(month,'".$AddingDate."',end_contract)/timestampdiff(month,start_Contract,end_contract) as thirdPrice"))
            ->pluck('thirdPrice')->first();
        $AddingDate = explode('-', $AddingDate);

        if($end_contract!=$AddingDate[2])
        {
            $price+=($PriceContract/12)*(1/2);
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


        $idDetailContract = DB::table('vehicles')->where('vehicles.imei', '=',$request->input('imeiId') )->
        join('customers', 'customers.id', 'vehicles.customer_id')->
        join('contracts','contracts.id_customer','customers.id')->
        join('detail_contract','detail_contract.id_contract','contracts.id')->
        select('detail_contract.id')->pluck('id')->first();
        if($request->input('typesEdit')==1)
            $PriceContract = DB::table('detail_contract')->where('id', '=', $idDetailContract)
                ->select('defaultSimple')->pluck("defaultSimple")->first();
        else
            $PriceContract = DB::table('detail_contract')->where('id', '=', $idDetailContract)
                ->select('defaultAvance')->pluck("defaultAvance")->first();
        $end_contract=DB::table('detail_contract')->where('id','=',$idDetailContract)
            ->select(DB::raw('day(end_contract) as date'))->pluck('date')->first();
        $price=DB::table('detail_contract')->where('id','=',$idDetailContract)
            ->select(DB::raw($PriceContract."*timestampdiff(month,'".$AddingDate."',end_contract)/timestampdiff(month,start_Contract,end_contract) as thirdPrice"))
            ->pluck('thirdPrice')->first();
        $AddingDate = explode('-', $AddingDate);

        if($end_contract!=$AddingDate[2])
        {
            $price+=($PriceContract/12)*(1/2);
        }



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
            ->join('info_detail_contract','info_detail_contract.id_vehicle','vehicles.id')
            ->update(['id_type_customer_subscribe'=>$TypeCustomerSubscribe , 'price'=>$request->input('priceVehiclesEdit'),
                'AddingDate'=>$AddingDate ]
            );
        return response()->json([(['id_type_customer_subscribe'=>$TypeCustomerSubscribe , 'price'=>$request->input('priceVehiclesEdit'),
            'AddingDate'=>$AddingDate
    ])]);
    }
    public function searchInfo(Request $request)
    {


    }
   public function addVehicule(Request $request)
   {

       $messages = [
           'required' => strtoupper(':attribute') .' est obligatoire',
           'unique' => strtoupper(':attribute').' est déja existe'
       ];






       $validator = Validator::make($request->all(), [
           'vehicules' => 'required|unique:info_detail_contract,id_vehicle',
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

           $idDetailContract = DB::table('vehicles')->where('vehicles.id', '=',$request->input('vehicules') )->
            where('detail_contract.status','=','1')->
           join('customers', 'customers.id', 'vehicles.customer_id')->
           join('contracts','contracts.id_customer','customers.id')->
           join('detail_contract','contracts.id','detail_contract.id_contract')->
           select('detail_contract.id')->pluck('id')->first();

           $info_detail_contract = new info_detail_contract();
           $info_detail_contract->id_detail = $idDetailContract;
           $info_detail_contract->id_vehicle = $request->input('vehicules');
           $info_detail_contract->id_type_customer_subscribe = $idTypeCustomerSubscribe ;
           $info_detail_contract->price = $request->input('priceVehicles');
           $info_detail_contract->offer = 0;
           $info_detail_contract->AddingDate=$AddingDate;
           $info_detail_contract->save();

           return response($idTypeCustomer . $idTypeCustomerSubscribe  );


       }


   }

   public function detailsInfo($id)
   {
       $detail = DB::table('info_detail_contract')->where('info_detail_contract.id','=',$id)
            ->join('vehicles','vehicles.id','info_detail_contract.id_vehicle')
           ->join('type_customers_subscribes','type_customers_subscribes.id','info_detail_contract.id_type_customer_subscribe')
           ->join('types_subscribes','types_subscribes.id','type_customers_subscribes.id_type_subscribe')
       ->select('info_detail_contract.*','vehicles.*','types_subscribes.id as id_subscribe')->first();
       return response()->json(["detail"=>$detail]);
   }

   public function renewal($id)
   {

       $contract = DB::table('contracts')->where('contracts.id','=',$id)->select('contracts.*')->first();
       $id = DB::table('contracts')->orderBy('id','desc')->select('contracts.id')->pluck('id')->first();
       if($id == null)
           $id = 0;

       $id++;


       $year = date("Y",strtotime($start_date));
       $yy = $year[2].$year[3];

       $mm = date("m",strtotime($start_date));

       $gid =  str_pad($id, 4, '0', STR_PAD_LEFT);



       $total = $priceAvance + $priceSimple;



       $matricule_detail = "CR".$yy.$mm."-"."01-".$gid;
        $detail_contrat=new detail_contract();
       $contract =  \DB::table('detail_contract')->insert([
           [
               'id_contract' =>  $id,
               'created_at' => $date,
               'updated_at' => $date,
               'matricule' =>  $matricule_detail,
               'urlPdf' => '/pdf/'.$matricule_detail,
               'nbAvance' => $nbAvance,
               'nbSimple' => $nbSimple,
               'defaultAvance' => $defaultAvance,
               'defaultSimple' => $defaultSimple,
               'price' => $total,
               'status' => '1',
               'start_contract' => $start_date,
               'end_contract' => $end_date,
               'isActive'          => 1
           ]
       ]);

       $detail_contrat->
          $a  =  \DB::table('renewal')->insert([
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