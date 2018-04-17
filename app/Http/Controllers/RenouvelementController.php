<?php

namespace App\Http\Controllers;

use App\Customers;
use  App\Models\Contract;
use Illuminate\Http\Request;
use App\Models\detail_contract;
use App\info_detail_contract;

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

   public function renewalVehicles(Request $request)
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


       $total = $request->input('defaultAdvancedR')* $request->input('nbVehiclesAdvancedR') +$request->input('nbVehiclesSimpleR')*$request->input('defaultSimpleR') ;

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
       $detail_contrat->nbAvance=$request->input('nbVehiclesAdvancedR');
       $detail_contrat->nbSimple=$request->input('nbVehiclesSimpleR');
       $detail_contrat->defaultAvance=$request->input('defaultAdvancedR');
       $detail_contrat->price=$total;
       $detail_contrat->status=1;
       $detail_contrat->isActive=1;
       $detail_contrat->defaultSimple=$request->input('defaultSimpleR');
       $detail_contrat->save();
      DB::table('detail_contract')->where('id','=',$id)->update(['status'=>0]);


       return response()->json($id_contract);
      //return response($id_contract);
   }


}

