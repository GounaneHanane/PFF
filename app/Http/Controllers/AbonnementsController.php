<?php

namespace App\Http\Controllers;

use App\TypesCustomersSubscribe;
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
            ->select('types_customers.type as ClientType','types_customers.id as ClientTypeId')->get();
        $AbonnementType=DB::table('types_subscribes')
            ->select('types_subscribes.type as AbonnementType','types_subscribes.id as AbonnementTypeId')->get();
        return view('abonnement',['abonnement'=>$A,'clientTypes'=>$ClientType,'abonnementTypes'=>$AbonnementType]);
    }
   /* public function saveCustomer(Request $request)
    {
        $customer = new Customers();
        $customer->name = $request->input('nom');

        $customer->contact = $request->input('contact');
        $customer->contact_phone = $request->input('NContact');
        $customer->email = $request->input('mail');
        $customer->city = $request->input('city');
        $customer->phone = $request->input('phone');
        $customer->id_type_customer = 1;

        $customer->save();


        return Redirect::to('add_contract');


        /*
                return response('Good'
                ,200) ->header('Content-Type', 'text/plain');
                //return response()->json($request['nom']);
                //echo var_dump($_POST);
        */
    //}
}