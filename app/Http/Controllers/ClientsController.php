<?php

namespace App\Http\Controllers;

use App\Clients;
use Illuminate\Http\Request;

use Response;
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
            ->join('contracts','customers.id','=','contracts.id')
            ->select('customers.*','types_customers.*','contracts.id as id_contract')->get();



       // return Illuminate\Routing\ResponseFactory::json($c);
       // json_encode($c);
        //return response('correct', 200)::json($c);
        //return response()->json($c);

        return view('client',['client'=>$c]);
    }

    public function AllC()
    {
        $c = DB::table('customers')
            ->join('types_customers', 'customers.id_type_customer', '=', 'types_customers.id')
            ->join('contracts','customers.id','=','contracts.id')
            ->select('customers.*','types_customers.*','contracts.id as id_contract')->get();


        return view('lines',['client'=>$c]);



       // $clients = DB::table('clients')->get();
       // return view('ListeClient',['clients'=>$clients]);
    }

    public function CustomerName($name)
    {
        //$name = $request->input('name');
        $c = DB::table('customers')->where('name', 'like', "%".$name."%")

            ->join('types_customers', 'customers.id_type_customer', '=', 'types_customers.id')
            ->join('contracts','customers.id','=','contracts.id')
            ->select('customers.*','types_customers.*','contracts.id as id_contract')->get();


        return view('lines',['client'=>$c]);
    }
    public function CustomerType($type)
    {
        $c = DB::table('types_customers')->where('types_customers.type', 'like', "%".$type."%")

            ->join('customers', 'types_customers.id', '=', 'customers.id_type_customer')
            ->join('contracts','customers.id','=','contracts.id_customer')
            ->select('customers.*','types_customers.*','contracts.id as id_contract')->get();
        return view('lines',['client'=>$c]);
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
        return response("hola",200) ->header('Content-Type', 'text/plain');
    }

}

