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
class OMSAlertsController extends Controller
{

    public function alert($amount)
    {

        $today = date("Y-m-d");

        $week = date("Y-m-d", strtotime("+7 day", strtotime($today)));
        $twoweeks = date("Y-m-d", strtotime("+15 day", strtotime($today)));
        $month = date("Y-m-d", strtotime("+1 month", strtotime($today)));
        $threemonths = date("Y-m-d", strtotime("+3 month", strtotime($today)));


       $contract = DB::table('contracts')
           ->join('customers','customers.id','contracts.id_customer')
           ->select('contracts.*',DB::raw('(contracts.nbAvance + contracts.nbSimple) as park'),'customers.*')
           ;



        $data = null;

        switch($amount)
        {
            case 7:
                $data = $contract->whereBetween(DB::raw("datediff('".$week."',end_contract)"), array(1,7))->get();
                break;

            case 15:
                $data = $contract->whereBetween(DB::raw("datediff('".$twoweeks."',end_contract)"),array(1,15))
                    ->get();
                break;

            case 30:
                $data = $contract->whereBetween(DB::raw("datediff('".$month."',end_contract) "), array(1,31))
                ->get();
                break;
            case 90:
                $data = $contract->whereBetween(DB::raw("datediff('".$threemonths."',end_contract) "), array(1,90))
                ->get();
                  break;
        }


      // return response()->json($data);
     //   return response($twoweeks);
        return view('alertlines',['alert'=>$data]);

    }



}