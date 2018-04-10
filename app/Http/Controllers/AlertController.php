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
            ->join('contracts','contracts.id','alerte.id')
            ->select('alerte.*',DB::raw('(contracts.nbAvance + contracts.nbSimple) as park'))->get();
        return view('home',['alert'=>$a]);
    }


}