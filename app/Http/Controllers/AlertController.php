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

}