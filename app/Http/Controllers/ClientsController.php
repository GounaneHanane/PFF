<?php

namespace App\Http\Controllers;

use App\Customers;
use  App\Models\Contract;
use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function show(Clients $clients)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function edit(Clients $clients)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Clients $clients)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function destroy(Clients $clients)
    {
        //
    }

    public function idC()
    {
        $c = DB::table('customers')
            ->join('types_customers', 'customers.id_type_customer', '=', 'types_customers.id')


            ->join('contracts','customers.id','=','contracts.id_customer')



            ->select('customers.*','types_customers.*','contracts.id as id_contract')->get();






       // return Illuminate\Routing\ResponseFactory::json($c);
       // json_encode($c);
        //return response('correct', 200)::json($c);
        //return response()->json($c);

        $type_client =  DB::table('types_customers')->get();

        return view('client',['client'=>$c,'type_client'=>$type_client]);
    }
    public function Contrat()
    {
        return view('ClientsLines');
    }
    public function AllC()
    {
        $c = DB::table('customers')

            ->join('types_customers', 'customers.id_type_customer', '=', 'types_customers.id')


            ->join('contracts','customers.id','=','contracts.id_customer')

            ->join('details','details.id_contract','contrats.id')


            ->select('customers.*','types_customers.*','contracts.id as id_contract','count(details) as NumVehicule')

            ->get();


        return view('ClientsLines',['client'=>$c]);



       // $clients = DB::table('clients')->get();
       // return view('ListeClient',['clients'=>$clients]);
    }

    public function CustomerName($name)
    {
        //$name = $request->input('name');
        $c = DB::table('customers')->where('name', 'like', $name."%")

            ->join('types_customers', 'customers.id_type_customer', '=', 'types_customers.id')
            ->join('contracts','customers.id','=','contracts.id_customer')
            ->select('customers.*','types_customers.*','contracts.id as id_contract')->get();


        return view('ClientsLines',['client'=>$c]);
    }
    public function CustomerType($type)
    {
        $c = DB::table('types_customers')->where('types_customers.type', '=', $type)

            ->join('customers', 'types_customers.id', '=', 'customers.id_type_customer')
            ->join('contracts','customers.id','=','contracts.id_customer')
            ->select('customers.*','types_customers.*','contracts.id as id_contract')->get();
        return view('ClientsLines',['client'=>$c]);
    }

    public function CustomerCity($city)
    {
        $c = DB::table('customers')->where('city', 'like', "%".$city."%")
            ->join('types_customers', 'customers.id_type_customer', '=', 'types_customers.id')

            ->join('contracts','customers.id','=','contracts.id_customer')
            ->select('customers.*','types_customers.*','contracts.id as id_contract')->get();
        return view('ClientsLines',['client'=>$c]);
    }

    public function DeleteCustomer($id)
    {


        $deleteQuery = DB::table('customers')->where('id', $id)->delete();

        return response('Le client a été supprimé', 200)
            ->header('Content-Type', 'text/plain');
    }/*
    public function AddCustomer($nom,$contact)
    {
        $deleteQuery = DB::table('customers')->insert([[]])

        return response('Le client a été supprimé', 200)
            ->header('Content-Type', 'text/plain');
    }*/

    public function saveCustomer(Request $request)
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

        $customerId = DB::table('customers')->where('name','=',$request->input('nom'))->
            select('customers.id')->pluck('id')->first();

        $contract = new Contract();
        $contract->id_customer = $customerId;
        $today = date("Y-m-d H:i:s");
        $contract->start_date =  $today;
        $date = date_create($today);
        date_modify($date, '+1 year');
        $contract->urlContract = "/contractPdf/".$request->input('nom');
        $contract->end_date = date_format($date, 'Y-m-d H:i:s');
        $contract->save();


        return Redirect::to('addcontrat/'.$customer->name);


        /*
                return response('Good'
                ,200) ->header('Content-Type', 'text/plain');
                //return response()->json($request['nom']);
                //echo var_dump($_POST);
        */
    }



}

