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
class ContractController extends Controller
{
    private function dateContract($dateC)
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


    public function contrat()
    {

        $c = DB::table('detail_contract')
            ->where('detail_contract.isActive', '=', '1')
            ->where('detail_contract.status','=','1')
            ->join('contracts','contracts.id','detail_contract.id_contract')
            ->join('customers', 'customers.id', '=', 'contracts.id_customer')
            ->join('types_customers', 'types_customers.id', '=', 'customers.id_type_customer')
            ->select('contracts.*', 'customers.*', 'contracts.id as id_contract', 'types_customers.type as type_customer',
                'detail_contract.*', 'detail_contract.id as id_detail',
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




        $ClientType = DB::table('types_customers')
            ->select('types_customers.type as ClientType', 'types_customers.id as ClientTypeId')->get();

        $types_subscribes = DB::table('types_subscribes')->select('types_subscribes.*')->get();

        return view('Contrat', ['contracts' => $c, 'clientTypes' => $ClientType, 'Customers' => $hasContrat,
            'typeSubscribes' => $types_subscribes , 'clients' => $hasnotContrat]);
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




        $contractDate = $this->dateContract($date);

        $start_date = $contractDate[0];
        $end_date = $contractDate[1];

        $total = $priceAvance + $priceSimple;


        $contract = DB::table('detail_contract')->
             join('contracts','contracts.id','detail_contract.id_contract')
            ->where('contracts.id_customer','=',$client)
            ->where('detail_contract.status','=','1')
            ->update(['nbSimple'=>$nbSimple , 'nbAvance'=>$nbAvance , 'price'=>$total
                ,'defaultSimple'=>$defaultSimple , 'defaultAvance'=>$defaultAvance
                ,'start_contract'=>$start_date , 'end_contract'=>$end_date
            ])

        ;


        return response()->json(['dA'=>$start_date,'dS'=>$end_date , 'date'=>$date]);
    }

    public function addContract(Request $request)
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

        $id = DB::table('contracts')->orderBy('id','desc')->select('contracts.id')->pluck('id')->first('id');

        $year = date("Y",strtotime($start_date));
        $yy = $year[2].$year[3];

        $month = date("m",strtotime($start_date));
        $mm = $month[2].$month[3];

        $matricule = "CR".$yy.$mm."-"."01".;

        $contract =  \DB::table('contracts')->insert([
            [
                'matricule' => ,
                'isActive'          => 1
            ]
        ]);
    }

}