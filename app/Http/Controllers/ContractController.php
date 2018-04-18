<?php

namespace App\Http\Controllers;

use App\Models\TypesSubscribe;
use App\Models\Vehicle;
use App\Models\Box;
use App\Models\Detail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\info_detail_contract;


use Response;
use Validator;
use Illuminate\Support\Facades\DB;
class ContractController extends Controller
{
   

    public  function verifyType($idDetail,$idType)
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
    public function contrat()
    {

        $c = DB::table('detail_contract')
            ->where('detail_contract.isActive', '=', '1')
            ->where('detail_contract.status','=','1')
            ->join('contracts','contracts.id','detail_contract.id_contract')
            ->join('customers', 'customers.id', '=', 'contracts.id_customer')
            ->join('types_customers', 'types_customers.id', '=', 'customers.id_type_customer')

            ->join('contract_warning','contract_warning.id','detail_contract.id')
            ->select('contracts.*','detail_contract.id as id_detail', 'customers.*', 'contracts.id as idContract', 'types_customers.type as type_customer',

                'detail_contract.*', 'detail_contract.id as id_detail', 'detail_contract.matricule as detail_matricule',
                'contract_warning.count as count',
                DB::raw('( ifnull(detail_contract.nbAvance,0) + ifnull(detail_contract.nbSimple,0)) as nbVehicles'))
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
            'typeSubscribes' => $types_subscribes ,'nb'=>$nb, 'clients' => $hasnotContrat]);
    }

    public function update($id)
    {
        $contracts = DB::table('detail_contract')->where('detail_contract.id','=',$id)
            ->join('contracts','contracts.id','detail_contract.id_contract')
            ->join('customers','customers.id','contracts.id_customer')
            ->select('detail_contract.*','contracts.*', DB::raw('(detail_contract.nbAvance + detail_contract.nbSimple) as nbVehicles'))
            ->first();





        $customer = DB::table('customers')->where('customers.id','=',$contracts->id_customer)->select('customers.*')->first();



        return response()->json(['contracts'=>$contracts ,  'customer'=>$customer]);
    }

    public function UpdateContract(Request $request)
    {
        $client = $request->input("client");
        $nbAvance = $request->input("nbAvance");
        $nbSimple = $request->input("nbSimple");

        $defaultAvance  = $request->input("defaultAvance");
        $defaultSimple  = $request->input("defaultSimple");

        $priceAvance = $request->input("priceAvance");
        $priceSimple = $nbSimple * $defaultSimple;
        $priceAvance = $nbAvance * $defaultAvance;

        $date = $request->input("date");



        $id = DB::table('contracts')->
            where('contracts.id_customer','=',$client)
            ->select('contracts.id')->pluck('id')->first();

        $gid =  str_pad($id, 4, '0', STR_PAD_LEFT);





        $contractDate = $this->dateContract($date);

        $start_date = $contractDate[0];
        $end_date = $contractDate[1];

        $year = date("Y",strtotime($start_date));
        $yy = $year[2].$year[3];

        $mm = date("m",strtotime($start_date));




        $nbAnnee = str_pad(
            DB::table('detail_contract')->where('detail_contract.id_contract','=',$id)->get()->count(),
                 2,
        '0' , STR_PAD_LEFT);

        $matricule_detail = "CR".$yy.$mm."-".$nbAnnee."-".$gid;
        $total = $priceAvance + $priceSimple;


        $contract = DB::table('detail_contract')
            ->where('detail_contract.id_contract','=',$id)
            ->where('detail_contract.status','=','1')
            ->update(['nbSimple'=>$nbSimple , 'nbAvance'=>$nbAvance , 'price'=>$total
                ,'defaultSimple'=>$defaultSimple , 'defaultAvance'=>$defaultAvance
                ,'start_contract'=>$start_date , 'end_contract'=>$end_date , 'matricule'=>$matricule_detail
            ])

        ;


        return response()->json(['dA'=>$start_date,'dS'=>$end_date , 'date'=>$date
            , 'nbAnnee' => $nbAnnee ,'id' => $id
            ,'matricule'=>$matricule_detail]);
    }

    public function addContrat(Request $request)
    {
        $client = $request->input('client');
        $nbSimple = $request->input('nbVehiclesSimple');
        $nbAvance = $request->input('nbVehiclesAvance');
        $priceSimple = $request->input('priceVehiclesSimple');
        $priceAvance = $request->input('priceVehiclesAvance');
        $defaultSimple = $request->input('defaultSimple');
        $defaultAvance = $request->input('defaultAvance');

        $date = $request->input("dated");

        $contractDate = $this->dateContract($date);

        $start_date = $contractDate[0];
        $end_date = $contractDate[1];

        $id = DB::table('contracts')->orderBy('id','desc')->select('contracts.id')->pluck('id')->first();
        if($id == null)
            $id = 0;

        $id++;


        $year = date("Y",strtotime($start_date));
        $yy = $year[2].$year[3];

        $mm = date("m",strtotime($start_date));

        $gid =  str_pad($id, 4, '0', STR_PAD_LEFT);



        $total = $priceAvance + $priceSimple;



        $matricule_detail = "CR".$yy.$mm."-"."1-".$gid;
        $matricule_contract = "CR".$yy.$mm."-".$gid;

        $contract =  \DB::table('contracts')->insert([
            [
                'matricule' =>  $matricule_contract,
                'id_customer' => $client,
                'created_at' => date("Y-m-d"),
                'updated_at' => date("Y-m-d"),
                'isActive'          => 1
            ]
        ]);

        $id_contract=DB::table('contracts')->where('matricule','=',$matricule_contract)->select('id')->pluck('id')->first();



        $contract =  \DB::table('detail_contract')->insert([
            [
                'id_contract' =>  $id_contract,
                'created_at' => date("Y-m-d"),
                'updated_at' => date("Y-m-d"),
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

        return response(strlen($id));
    }

    public function refresh($status)
    {
        $c = DB::table('detail_contract')
            ->where('detail_contract.isActive', '=', '1')
            ->where('detail_contract.status','=',$status)
            ->join('contracts','contracts.id','detail_contract.id_contract')
            ->join('customers', 'customers.id', '=', 'contracts.id_customer')
            ->join('types_customers', 'types_customers.id', '=', 'customers.id_type_customer')
            ->join('contract_warning','contract_warning.id','=','detail_contract.id')
            ->select('contracts.*', 'customers.*','count', 'contracts.id as id_contract', 'types_customers.type as type_customer',
                'detail_contract.*', 'detail_contract.id as id_detail', 'detail_contract.matricule as detail_matricule',
                DB::raw('( ifnull(detail_contract.nbAvance,0) + ifnull(detail_contract.nbSimple,0)) as nbVehicles'))
            ->get();


        return view('ContractLines', ['contracts' => $c] );

       // return response($c[1]->nbVehicles);
    }

    public function CountVehicles($idCustomer)
    {
        $vehciles = DB::table('vehicles')->where('vehicles.customer_id','=',$idCustomer)->get()->count();

        return response($vehciles);
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

    }

    public function searchContrat(Request $request)
    {
        $matricule = ($request->input('matricule') == null) ? null : $request->input('matricule');
        $id_customer = ($request->input('id_customer') == null) ? null : $request->input('id_customer');
        $debut_contrat = ($request->input('debut_contrat') == null) ? null : $request->input('debut_contrat');
        $fin_contrat = ($request->input('fin_contrat') == null) ? null : $request->input('fin_contrat');
        $typeClient = ($request->input('typeClient') == null) ? null : $request->input('typeClient');
        $critiere = [];
        $i = 0;

        $status = $request->input('status');



        $contracts = DB::table('detail_contract')->where('detail_contract.isActive', '=', '1')->
            where('detail_contract.status','=',$status);

        if ($matricule != null) {
            $critiere[$i] = ['detail_contract.matricule', 'like', $matricule];
            $i++;

        }
        if ($debut_contrat != null) {
            $critiere[$i] = ['detail_contract.start_contract', '=', $debut_contrat];
            $i++;

        }
        if ($fin_contrat != null) {
            $critiere[$i] = ['detail_contract.end_contract', '=', $fin_contrat];
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
            ->join('contracts','contracts.id','detail_contract.id_contract')
            ->join('customers', 'customers.id', '=', 'contracts.id_customer')
            ->join('types_customers', 'types_customers.id', '=', 'customers.id_type_customer')

            ->join('contract_warning','contract_warning.id','detail_contract.id')
            ->select('contracts.*', 'customers.*', 'contracts.id as id_contract', 'types_customers.type as type_customer',
                'detail_contract.*', 'detail_contract.id as id_detail', 'detail_contract.matricule as detail_matricule',
                'contract_warning.count as count',
                DB::raw('( ifnull(detail_contract.nbAvance,0) + ifnull(detail_contract.nbSimple,0)) as nbVehicles'))
            ->where($critiere)

            ->get();

      return view('ContractLines', ['contracts' => $QueryContracts]);


    }

    public function DisableContract($id)
    {
        $detail_contrat = DB::table('contracts')
            ->join('detail_contract','detail_contract.id_contract','contracts.id')
            ->where('detail_contract.id','=', $id)
            ->update(['contracts.isActive' => 0 , 'detail_contract.isActive' => 0]);

    }
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
    public function vehicleRenewal(Request $request)
    {
        $id=$request->input('id_detail');
        $contract_id=DB::table('detail_contract')->where('id','=',$id)->select('id_contract')->pluck('id_contract')->first();
        $new_id=DB::table('detail_contract')->where('id_contract','=',$contract_id)->where('status','=','1')->select('id')->pluck('id')->first();
        $date = $request->input("datedR");
        $contractDate = $this->dateContract($date);
        $start_datee = $contractDate[0];
        $vehicles=$request->input('NewVehicles');

        $idDs = array();

        foreach($vehicles as $v)
        {

            $idVehicle=DB::table('vehicles')->where('imei','=',$v)->select('vehicles.id')->pluck('id')->first();
            $idTypeCustomerSubscribe=DB::table('info_detail_contract')->where('id_detail','=',$id)->where('id_vehicle','=',$idVehicle)
            ->select('id_type_customer_subscribe')->pluck('id_type_customer_subscribe')->first();
            $price=DB::table('type_customers_subscribes')->where('id','=',$idTypeCustomerSubscribe)->select('price')->pluck('price')->first();
            $info_detail_contract = new info_detail_contract();
            $info_detail_contract->id_detail = $new_id;
            $info_detail_contract->id_vehicle = $idVehicle;
            $info_detail_contract->id_type_customer_subscribe = $idTypeCustomerSubscribe ;
            $info_detail_contract->price = $price;
            $info_detail_contract->offer = 0;
            $info_detail_contract->AddingDate=$start_datee;
            $info_detail_contract->save();

            array_push($idDs, $idTypeCustomerSubscribe);


        }

        return response($idDs);
    }

}