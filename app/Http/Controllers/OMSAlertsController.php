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



      $a= DB::table('contracts')->where(DB::raw('to_days(detail_contract.end_contract) - to_days(curdate())'),'<',$amount)->where('detail_contract.status','=','1')
           ->join('detail_contract','detail_contract.id_contract','contracts.id')
           ->join('customers','customers.id','contracts.id_customer')
           ->select('detail_contract.*',DB::raw('(detail_contract.nbAvance + detail_contract.nbSimple) as park'),'customers.*')->get();






       return view('alertlines',['alert'=>$a]);
      //  return response($a);

    }



}