<?php

namespace App\Http\Controllers;

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
            ->select('detail_contract.*')->first();
        $vehicles=DB::table('detail_contract')->where('detail_contract.id','=',$id_detail)
            ->join('info_detail_contract','info_detail_contract.id_detail','detail_contract.id')
            ->join('vehicles','vehicles.id','info_detail_contract.id_vehicle')
            ->select('vehicles.imei')->get();
        return response()->json(["info"=>$info,"vehicles"=>$vehicles]);
    }

}