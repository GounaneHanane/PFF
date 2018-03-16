<?php

namespace App\Http\Controllers;

use App\Models\TypesCustomersSubscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use Response;
use Illuminate\Support\Facades\DB;
class AbonnementsController extends Controller
{


    public function idAbonnement()
    {
        $A=DB::table('types_customers_subscribes')
            ->join('types_customers','types_customers.id','=','types_customers_subscribes.id_type_customer')
            ->join('types_subscribes','types_subscribes.id','=','types_customers_subscribes.id_subscribe')
            ->select('types_customers_subscribes.*','types_customers.type as ClientType','types_customers.id as ClientTypeId','types_subscribes.type as AbonnementType','types_subscribes.id as AbonnementTypeId','countabonnementvehicle.count as VehicleCount')->get();



        $ClientType=DB::table('types_customers')
            ->select('types_customers.type as ClientType','types_customers.id as ClientTypeId')->get();
        $AbonnementType=DB::table('types_subscribes')
            ->select('types_subscribes.type as AbonnementType','types_subscribes.id as AbonnementTypeId')->get();


        return view('abonnement',['abonnement'=>$A,'clientTypes'=>$ClientType,'abonnementTypes'=>$AbonnementType]);
        //return response()->json([$A]);
    }
    public function saveAbonnement(Request $request)
    {

        $Abonnement = new TypesCustomersSubscribe();
        $Abonnement->price = $request->input('price');
        $Abonnement->id_type_customer = $request->input('type_client');
        $Abonnement->id_subscribe = $request->input('type_abonnement');
        $Abonnement->save();


        return Redirect::to('abonnement');

    }
    public function count($id)
    {
        $CountVehicle=DB::table('details')->where("	id_type_customer_subscribe",$id)
            ->select("count")
            ->get();
        return view("abonnement",['CountVehicle'=>$CountVehicle]);
    }
        /*
                return response('Good'
                ,200) ->header('Content-Type', 'text/plain');
                //return response()->json($request['nom']);
                //echo var_dump($_POST);
        */
public function updateAbonnement(Request $request)
{
    DB::table('types_customers_subscribes')
        ->where([
            ['id_subscribe', '=',  $request->input('type_abonnement')],
            ['id_type_customer', '=',  $request->input('type_client')],
        ])
        ->update(['price' => $request->input('price')]);

    return Redirect::to('abonnement');
}
public function DeleteAbonnement($id)
{
    $deleteQuery = DB::table('types_customers_subscribes')->where('id', $id)->delete();
    return Redirect::to('abonnement');
}
}