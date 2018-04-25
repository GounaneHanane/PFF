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
use App\info_detail_contract;


class DetailController extends Controller
{
	public function refreshDetail($idContract)
    {
        $details = DB::table('info_detail_contract')->where('info_detail_contract.id_detail','=',$idContract)
            ->where('info_detail_contract.isActive','=','1')
            ->join('vehicles','vehicles.id','info_detail_contract.id_vehicle')
            ->join('type_customers_subscribes','type_customers_subscribes.id','info_detail_contract.id_type_customer_subscribe')
            ->join('types_subscribes','types_subscribes.id','type_customers_subscribes.id_type_subscribe')
            ->select('info_detail_contract.*','vehicles.*','types_subscribes.type','info_detail_contract.id as id_detail')
            ->get();


                 $contract = DB::table('detail_contract')->
             select(DB::raw("(detail_contract.nbavance + detail_contract.nbSimple) as nbVehicles"),"detail_contract.*","detail_contract.id_contract as idContract")
                 ->where('detail_contract.id','=',$idContract)

                 ->first();
            

        return view('DetailsLines',[ 'details'=>$details , "contract"=>$contract ]);
    }

    public function showInfo($idContrat)
    {


       $types_subscribes = DB::table('types_subscribes')->select('types_subscribes.*')->get();



      $contract = DB::table('detail_contract')->
             select(DB::raw("(detail_contract.nbavance + detail_contract.nbSimple) as nbVehicles"),"detail_contract.*","detail_contract.id_contract as idContract")
                 ->where('detail_contract.id','=',$idContrat)

                 ->first();






        $details = DB::table('info_detail_contract')->where([['id_detail','=',$idContrat],['info_detail_contract.isactive','=','1']])->

        join('vehicles','vehicles.id','info_detail_contract.id_vehicle')->
        join('detail_contract','detail_contract.id','info_detail_contract.id_detail')->
        join('type_customers_subscribes','type_customers_subscribes.id','info_detail_contract.id_type_customer_subscribe')->
        join('types_subscribes','types_subscribes.id','type_customers_subscribes.id_type_subscribe')->

        select('vehicles.*','vehicles.id as idVehicle','id_detail','types_subscribes.id as idtypeSub','types_subscribes.type as typeSub','info_detail_contract.*','detail_contract.status as status')->orderBy('info_detail_contract.id','desc')->get();

      ;
      $type=DB::table('types_subscribes')->
    select('types_subscribes.*')->get();

        $vehicle=DB::table('vehicles')->where([['vehicles.isActive','=','1'],['detail_contract.id','=',$idContrat]])
            ->whereNotIn('vehicles.id',function($q){
                $q->select('info_detail_contract.id_vehicle')->from('info_detail_contract')->where('isActive','=','1');
            })->
        join('customers','customers.id','vehicles.customer_id')->
        join('contracts','customers.id','contracts.id_customer')->
        join('detail_contract','detail_contract.id_contract','contracts.id')->
        select('vehicles.*')->get();
        $client=DB::table('contracts')->where([['detail_contract.id','=',$idContrat],['contracts.isactive','=','1']])->
            join('customers','customers.id','contracts.id_customer')->
        join('detail_contract','detail_contract.id_contract','contracts.id')->
            select('customers.name','detail_contract.*')->get();
        $nb=DB::table('alerte')
            ->select(DB::raw('count(*) as nb'))->get();
             return view('contractInfo',['details'=>$details,  "types_subscribes"=>$types_subscribes ,"contract"=>$contract,'types'=>$type  ,"nb"=>$nb,'vehicles'=>$vehicle,'cli'=>$client ,"idContrat"=>$idContrat]);



    }

     public function searchDetail(Request $request)
       {
           $imei = ($request->input('imei') == null) ? null : $request->input('imei');
           $type_abonnement = ($request->input('type_abonnement') == null) ? null : $request->input('type_abonnement');
           $dateAjout = ($request->input('dateAjout') == null) ? null : $request->input('dateAjout');
           $marque = ($request->input('marque') == null) ? null : $request->input('marque');
           $modele = ($request->input('model') == null) ? null : $request->input('model');
           $critiere = [];

           $idContract = $request->input('idContract');

           $i = 0;

           $details = DB::table('info_detail_contract')->where('info_detail_contract.isActive', '=', '1')
           ;



             $critiere[0]  = ['detail_contract.id','=',$idContract];

              $i++;

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

               ->select('info_detail_contract.*','detail_contract.*','detail_contract.id as id_contract','vehicles.*','types_subscribes.type','info_detail_contract.id as id_detail')

               ->get();

                 $contract = DB::table('detail_contract')->
             select(DB::raw("(detail_contract.nbavance + detail_contract.nbSimple) as nbVehicles"),"detail_contract.*","detail_contract.id_contract as idContract")
                 ->where('detail_contract.id','=',$idContract)

                 ->first();
            

        return view('DetailsLines',[ 'details'=>$QueryDetails , "contract"=>$contract]);
              
       }
      
   


	public function verifyType($idDetail,$idType)
    {

        $count=DB::table('info_detail_contract')
            ->where('info_detail_contract.id_detail','=',$idDetail)
            ->where('info_detail_contract.isActive','=','1')
            ->where('id_type_subscribe','=',$idType)

            ->join('type_customers_subscribes','type_customers_subscribes.id','info_detail_contract.id_type_customer_subscribe')
            ->count();
        if($idType==1)
            $nbVehicle=DB::table('detail_contract')->where('id','=',$idDetail)->where('status','=','1')
             -> select( DB::raw(' ifnull(detail_contract.nbSimple,0) as nbVehicles'))->pluck('nbVehicles')->first();
        if($idType==2)
            $nbVehicle=DB::table('detail_contract')->where('id','=',$idDetail)->where('status','=','1')
                -> select( DB::raw(' ifnull(detail_contract.nbAvance,0) as nbVehicles'))->pluck('nbVehicles')->first();
        if($count<$nbVehicle)
            return response(1);
        else if ($count==$nbVehicle)
            return response(0);

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
     public function DisableDetail($id)
    {

        $detail = DB::table('info_detail_contract')->where('info_detail_contract.id', $id)->update(['isActive' => 0]);

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

        $idDetailContract = DB::table('vehicles')->where('vehicles.id', '=',$request->input('vehicules') )->where('detail_contract.status',"=",'1')->
        join('customers', 'customers.id', 'vehicles.customer_id')->
        join('contracts','contracts.id_customer','customers.id')->
        join('detail_contract','detail_contract.id_contract','contracts.id')->
        select('detail_contract.id')->pluck('id')->first();
        if($request->input('types')==1)
            $PriceContract = DB::table('detail_contract')->where('id', '=', $idDetailContract)->where('status','=','1')
                ->select('defaultSimple')->pluck("defaultSimple")->first();
        else
            $PriceContract = DB::table('detail_contract')->where('id', '=', $idDetailContract)->where('status','=','1')
                ->select('defaultAvance')->pluck("defaultAvance")->first();
        $end_contract=DB::table('detail_contract')->where('id','=',$idDetailContract)->where('status','=','1')
            ->select(DB::raw('day(end_contract) as date'))->pluck('date')->first();
        $price=DB::table('detail_contract')->where('id','=',$idDetailContract)->where('status','=','1')
            ->select(DB::raw($PriceContract."*timestampdiff(month,'".$AddingDate."',end_contract)/timestampdiff(month,start_Contract,end_contract) as thirdPrice"))
            ->pluck('thirdPrice')->first();
        $AddingDate = explode('-', $AddingDate);
        if($end_contract!=$AddingDate[2])
        {
            $price+=($PriceContract/12)*(1/2);
        }
        return response($price);
    }
      public function addVehicule(Request $request)
   {

       $messages = [
           'required' => strtoupper(':attribute') .' est obligatoire',

       ];






       $validator = Validator::make($request->all(), [
           'vehicules' => 'required:info_detail_contract,id_vehicle',
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


        $idDetailContract = DB::table('vehicles')->where('vehicles.imei', '=',$request->input('imeiId') )->where('detail_contract.status','=','1')->
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

}