<?php

namespace App\Http\Controllers;

use App\Customers;
use  App\Models\Contract;
use Illuminate\Http\Request;
use Response;
use Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
class RenouvelementController extends Controller
{

    public function renewal()
    {
        $archive = DB::table('detail_contract')
            ->where('detail_contract.isActive', '=', '1')
            ->where('detail_contract.status','=','0')
            ->join('contracts','contracts.id','detail_contract.id_contract')
            ->join('customers', 'customers.id', '=', 'contracts.id_customer')
            ->join('types_customers', 'types_customers.id', '=', 'customers.id_type_customer')

            ->join('contract_warning','contract_warning.id','detail_contract.id')
            ->select('contracts.*', 'customers.*', 'contracts.id as id_contract', 'detail_contract.id_contract' ,'types_customers.type as type_customer',

                'detail_contract.*', 'detail_contract.id as id_detail', 'detail_contract.matricule as detail_matricule',
                'contract_warning.count as count',
                DB::raw('( ifnull(detail_contract.nbAvance,0) + ifnull(detail_contract.nbSimple,0)) as nbVehicles'))
            ->get();
        $nb=DB::table('alerte')
            ->select(DB::raw('count(*) as nb'))->get();

        $hasContrat = DB::table('customers')
            ->whereIn('customers.id',function($q){
                $q->select('contracts.id_customer')->from('contracts');
            })
            ->select('customers.id', 'customers.name')->get();

               $ClientType = DB::table('types_customers')
            ->select('types_customers.type as ClientType', 'types_customers.id as ClientTypeId')->get();




        return view('Renouvelement',['nb'=>$nb,'archive'=>$archive, 'clientTypes' => $ClientType ,
            "Customers"=>$hasContrat
    ]);
    }


}

