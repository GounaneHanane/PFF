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
            ->join('contract_warning','contract_warning.id','=','detail_contract.id')
            ->select('contracts.*', 'customers.*','count', 'contracts.id as id_contract', 'types_customers.type as type_customer',
                'detail_contract.*', 'detail_contract.id as id_detail', 'detail_contract.matricule as detail_matricule',
                DB::raw('( ifnull(detail_contract.nbAvance,0) + ifnull(detail_contract.nbSimple,0)) as nbVehicles'))
            ->get();
        $nb=DB::table('alerte')
            ->select(DB::raw('count(*) as nb'))->get();


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



        $matricule_detail = "CR".$yy.$mm."-"."01-".$gid;
        $matricule_contract = "CR".$yy.$mm."-".$gid;

        $contract =  \DB::table('contracts')->insert([
            [
                'matricule' =>  $matricule_contract,
                'id_customer' => $client,
                'created_at' => $date,
                'updated_at' => $date,
                'isActive'          => 1
            ]
        ]);





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

        return response(strlen($id));
    }

    public function refresh()
    {
        $c = DB::table('detail_contract')
            ->where('detail_contract.isActive', '=', '1')
            ->where('detail_contract.status','=','1')
            ->join('contracts','contracts.id','detail_contract.id_contract')
            ->join('customers', 'customers.id', '=', 'contracts.id_customer')
            ->join('types_customers', 'types_customers.id', '=', 'customers.id_type_customer')
            ->select('contracts.*', 'customers.*', 'contracts.id as id_contract', 'types_customers.type as type_customer',
                'detail_contract.*', 'detail_contract.id as id_detail', 'detail_contract.matricule as detail_matricule',
                DB::raw('( ifnull(detail_contract.nbAvance,0) + ifnull(detail_contract.nbSimple,0)) as nbVehicles'))
            ->get();

        return view('ContractLines', ['contracts' => $c]);
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

        $contracts = DB::table('detail_contract')->where('detail_contract.isActive', '=', '1')->
            where('detail_contract.status','=','1');

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

            ->where($critiere)
            ->select('contracts.*', 'customers.*', 'contracts.id as id_contract', 'types_customers.type as type_customer',
                'detail_contract.*', 'detail_contract.id as id_detail', 'detail_contract.matricule as detail_matricule',
                DB::raw('( ifnull(detail_contract.nbAvance,0) + ifnull(detail_contract.nbSimple,0)) as nbVehicles'))
            ->get();


        return view('ContractLines', ['contracts' => $QueryContracts]);
    }

    public function DisableContract($id)
    {
        $detail_contrat = DB::table('detail_contract')->where('detail_contract.id', $id)->update(['isActive' => 0]);

    }

}