<?php

namespace App\Http\Controllers;

use App\Models\detail_contract;
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
    public function dateContract($dateC)
    {

        if ($dateC)
            $date_start_contract = $dateC;
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

        $contratDated = array();
        $contratDated[0] = $date_start_contract;
        $contratDated[1] = $date_end_contract;
        return $contratDated;

    }

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



      $contract = DB::table('detail_contract')->
             select(DB::raw("(detail_contract.nbavance + detail_contract.nbSimple) as nbVehicles"),"detail_contract.*","detail_contract.id_contract as idContract")
                 ->where('detail_contract.id','=',$idContrat)

                 ->first();






        $details = DB::table('info_detail_contract')->where([['id_detail','=',$idContrat],['info_detail_contract.isactive','=','1'],['detail_contract.status','=','1']])->

        join('vehicles','vehicles.id','info_detail_contract.id_vehicle')->
        join('detail_contract','detail_contract.id','info_detail_contract.id_detail')->
        join('type_customers_subscribes','type_customers_subscribes.id','info_detail_contract.id_type_customer_subscribe')->
        join('types_subscribes','types_subscribes.id','type_customers_subscribes.id_type_subscribe')->
        select('vehicles.*','vehicles.id as idVehicle','types_subscribes.id as idtypeSub','types_subscribes.type as typeSub','info_detail_contract.*','detail_contract.id as id_detail')->get();
      ;
      $type=DB::table('types_subscribes')->
    select('types_subscribes.*')->get();

        $vehicle=DB::table('vehicles')->where([['vehicles.isActive','=','1'],['detail_contract.id','=',$idContrat]])->
        join('customers','customers.id','vehicles.customer_id')->
        join('contracts','customers.id','contracts.id_customer')->
        join('detail_contract','detail_contract.id_contract','contracts.id')->
        select('vehicles.*')->get();
        $client=DB::table('contracts')->where([['detail_contract.id','=',$idContrat],['contracts.isactive','=','1'],['status','=','1']])->
            join('customers','customers.id','contracts.id_customer')->
        join('detail_contract','detail_contract.id_contract','contracts.id')->

            select('customers.name','detail_contract.*')->get();
        $nb=DB::table('alerte')
            ->select(DB::raw('count(*) as nb'))->get();
       return view('contractInfo',['details'=>$details,  "types_subscribes"=>$types_subscribes ,"contract"=>$contract,'types'=>$type  ,"nb"=>$nb,'vehicles'=>$vehicle,'cli'=>$client ,"idContrat"=>$idContrat]);

        return response()->json($details);

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
    public function searchInfo(Request $request)
    {


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

   public function detailsInfo($id)
   {
       $detail = DB::table('info_detail_contract')->where('info_detail_contract.id','=',$id)
            ->join('vehicles','vehicles.id','info_detail_contract.id_vehicle')
           ->join('type_customers_subscribes','type_customers_subscribes.id','info_detail_contract.id_type_customer_subscribe')
           ->join('types_subscribes','types_subscribes.id','type_customers_subscribes.id_type_subscribe')
       ->select('info_detail_contract.*','vehicles.*','types_subscribes.id as id_subscribe')->first();
       return response()->json(["detail"=>$detail]);
   }


   public function renewal(Request $request)
   {
        $id=$request->input('id_detail');
        $detail= DB::table('detail_contract')->where('detail_contract.id','=',$id)->select('detail_contract.*')->first();
       $id_contract= DB::table('detail_contract')->where('detail_contract.id','=',$id)->select('detail_contract.id_contract')->pluck('id_contract')->first();
      $start_date= DB::table('detail_contract')->where('id', '<=' ,DB::raw('All (select id from detail_contract where id_contract = '.$id_contract.")"))
           ->select('start_contract')->pluck('start_contract')->first();
       $last_id = DB::table('detail_contract')->orderBy('id','desc')->select('detail_contract.id')->pluck('id')->first();
       if($last_id == null)
           $last_id = 0;

       $last_id++;
        $count=DB::table('detail_contract')->where('id_contract','=',$id_contract)
           ->count();


       $year = date("Y",strtotime($start_date));
       $yy = $year[2].$year[3];

       $mm = date("m",strtotime($start_date));

       $gid =  str_pad($last_id, 4, '0', STR_PAD_LEFT);
     //   $count=str_pad($count,2,0,STR_PAD_LEFT);


       $total = $request->input('defaultAdvanced')* $request->input('nbVehiclesAdvanced') +$request->input('nbVehiclesSimple')*$request->input('defaultSimple') ;

       $date = $request->input("dated");

       $contractDate = $this->dateContract($date);

      $start_datee = $contractDate[0];
       $end_date = $contractDate[1];

       $matricule_detail = "CR".$yy.$mm."-".($count+1)."-".$gid;
       $detail_contrat=new detail_contract();
         $detail_contrat->id_contract=$id_contract;
        $detail_contrat->start_contract=$start_datee;
        $detail_contrat->end_contract=$end_date;
        $detail_contrat->urlPdf='/pdf/'.$matricule_detail;
        $detail_contrat->matricule=$matricule_detail;
       $detail_contrat->nbAvance=$request->input('nbVehiclesAdvanced');
       $detail_contrat->nbSimple=$request->input('nbVehiclesSimple');
       $detail_contrat->defaultAvance=$request->input('defaultAdvanced');
       $detail_contrat->price=$total;
       $detail_contrat->status=1;
       $detail_contrat->isActive=1;
       $detail_contrat->defaultSimple=$request->input('defaultSimple');
       $detail_contrat->save();
      DB::table('detail_contract')->where('id','=',$id)->update(['status'=>0]);


       return response()->json($id_contract);
      //return response($id_contract);
   }
    public function vehicleRenewal(Request $request)
    {
        $id=$request->input('id_detail');
        $contract_id=DB::table('detail_contract')->where('id','=',$id)->select('id_contract')->pluck('id_contract')->first();
        $new_id=DB::table('detail_contract')->where('id_contract','=',$contract_id)->where('status','=','1')->select('id')->pluck('id')->first();
        $date = $request->input("dated");
        $contractDate = $this->dateContract($date);
        $start_datee = $contractDate[0];
        $vehicles=$request->input('NewVehicles');
        foreach($vehicles as $v)
        {
            $idVehicle=DB::table('vehicles')->where('imei','=',$v)->select('vehicles.id')->pluck('id')->first();
            $idTypeCustomerSubscribe=DB::table('info_detail_contract')->where('id_detail','=',$id)->select('id_type_customer_subscribe')->pluck('id_type_customer_subscribe')->first();
            $price=DB::table('type_customers_subscribes')->where('id','=',$idTypeCustomerSubscribe)->select('price')->pluck('price')->first();
            $info_detail_contract = new info_detail_contract();
            $info_detail_contract->id_detail = $new_id;
            $info_detail_contract->id_vehicle = $idVehicle;
            $info_detail_contract->id_type_customer_subscribe = $idTypeCustomerSubscribe ;
            $info_detail_contract->price = $price;
            $info_detail_contract->offer = 0;
            $info_detail_contract->AddingDate=$start_datee;
            $info_detail_contract->save();

        }


        return response()->json($info_detail_contract);
        //return response($id_contract);
    }

}