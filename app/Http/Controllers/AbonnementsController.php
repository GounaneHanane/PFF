<?php

namespace App\Http\Controllers;

use App\Clients;
use Illuminate\Http\Request;

use Response;
use Illuminate\Support\Facades\DB;
class AbonnementsController extends Controller
{


    public function idAbonnement()
    {
        $A=DB::table('types_customers_subscribes')
            ->join('types_customers','types_customers.id','=','types_customers_subscribes.id_type_customer')
            ->join('types_subscribes','types_subscribes.id','=','types_customers_subscribes.id_subscribe')
            ->select('types_customers_subscribes.*','types_customers.type as ClientType','types_subscribes.type as AbonnementType')->get();
        $ClientType=DB::table('types_customers')
            ->select('types_customers.type as ClientType')->get();
        $AbonnementType=DB::table('types_subscribes')
            ->select('types_subscribes.type as AbonnementType')->get();
        return view('abonnement',['abonnement'=>$A,'clientTypes'=>$ClientType,'abonnementTypes'=>$AbonnementType]);
    }

}