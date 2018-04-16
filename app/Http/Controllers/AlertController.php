<?php

namespace App\Http\Controllers;

use App\detail_contract;
use App\Models\TypesCustomersSubscribe;
use App\Rules\home;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use Response;
use Illuminate\Support\Facades\DB;
class AlertController extends Controller
{

    public function Alert()
    {
        $a=DB::table('alerte')
            ->join('detail_contract','detail_contract.id','alerte.id')
            ->select('alerte.*',DB::raw('(detail_contract.nbAvance + detail_contract.nbSimple) as park'))->get();
        $nb=DB::table('alerte')
            ->select(DB::raw('count(*) as nb'))->get();
        return view('home',['alert'=>$a,'nb'=>$nb]);
    }


    public function refresh()
    {
          $a=DB::table('alerte')
            ->join('detail_contract','detail_contract.id','alerte.id')
            ->select('alerte.*',DB::raw('(detail_contract.nbAvance + detail_contract.nbSimple) as park'))->get();
        $nb=DB::table('alerte')
            ->select(DB::raw('count(*) as nb'))->get();
        return view('alertlines',['alert'=>$a,'nb'=>$nb]);
    }

    public function AlertNotification()
    {
        $nb=DB::table('alerte')
            ->select(DB::raw('count(*) as nb'))->get();
        return view('layout',['nb'=>$nb]);
    }
    public function AlertNotification2()
    {
        $nb=DB::table('alerte')
            ->select(DB::raw('count(*) as nb'))->get();

        $a=DB::table('alerte')
            ->join('detail_contract','detail_contract.id','alerte.id')
            ->select('alerte.*',DB::raw('(detail_contract.nbAvance + detail_contract.nbSimple) as park'))->get();
        return view('renouvelement',['alert'=>$a,'nb'=>$nb]);
    }
    public function Alert_Detail_Contrat($id_detail)
    {
        $info=DB::table('detail_contract')->where('detail_contract.id','=',$id_detail)
            ->join('info_detail_contract','info_detail_contract.id_detail','detail_contract.id')
            ->join('contracts','detail_contract.id_contract','contracts.id')
            ->join('customers','customers.id','contracts.id_customer')
            ->join('type_customers_subscribes','type_customers_subscribes.id_type_customer','customers.id_type_customer')
            ->select('detail_contract.*','customers.*')->first();
        $SimplePrice=DB::table('detail_contract')->where('detail_contract.id','=',$id_detail)->where('type_customers_subscribes.id_type_subscribe','=','1')
            ->join('info_detail_contract','info_detail_contract.id_detail','detail_contract.id')
            ->join('contracts','detail_contract.id_contract','contracts.id')
            ->join('customers','customers.id','contracts.id_customer')
            ->join('type_customers_subscribes','type_customers_subscribes.id_type_customer','customers.id_type_customer')
            ->select('type_customers_subscribes.price')->first();
        $AdvancedPrice=DB::table('detail_contract')->where('detail_contract.id','=',$id_detail)->where('type_customers_subscribes.id_type_subscribe','=','2')
            ->join('info_detail_contract','info_detail_contract.id_detail','detail_contract.id')
            ->join('contracts','detail_contract.id_contract','contracts.id')
            ->join('customers','customers.id','contracts.id_customer')
            ->join('type_customers_subscribes','type_customers_subscribes.id_type_customer','customers.id_type_customer')
            ->select('type_customers_subscribes.price')->first();
        $vehicles=DB::table('detail_contract')->where('detail_contract.id','=',$id_detail)->where('info_detail_contract.isActive','=','1')
            ->join('info_detail_contract','info_detail_contract.id_detail','detail_contract.id')
            ->join('vehicles','vehicles.id','info_detail_contract.id_vehicle')
            ->select('vehicles.imei')->get();
        return response()->json(["info"=>$info,"vehicles"=>$vehicles,"simplePrice"=>$SimplePrice,"advancedPrice"=>$AdvancedPrice]);
    }

}