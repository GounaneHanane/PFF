<?php

namespace App\Http\Controllers;

use App\Customers;
use  App\Models\Contract;
use Illuminate\Http\Request;
use Response;
use Validator;
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
            ->where('customers.isActive','=',1)
            ->join('types_customers', 'customers.id_type_customer', '=', 'types_customers.id')


            ->join('contracts','customers.id','=','contracts.id_customer')
           // CV is view couting details per contract
            ->join('cv','cv.id_contract','contracts.id')
            ->select('customers.*' , 'customers.id as idCustomer','types_customers.*','contracts.id as id_contract','cv.vehicles')

            ->get();







       // return Illuminate\Routing\ResponseFactory::json($c);
       // json_encode($c);
        //return response('correct', 200)::json($c);




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
            ->join('cv','cv.id_contract','contracts.id')
            ->select('customers.*','types_customers.*','contracts.id as id_contract','cv.vehicles')

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
            ->join('cv','cv.id_contract','contracts.id')
            ->select('customers.*','types_customers.*','contracts.id as id_contract','cv.vehicles')->get();



        return view('ClientsLines',['client'=>$c]);
    }
    public function CustomerType($type)
    {
        $c = DB::table('types_customers')->where('types_customers.type', '=', $type)

            ->join('customers', 'types_customers.id', '=', 'customers.id_type_customer')
            ->join('contracts','customers.id','=','contracts.id_customer')
            ->join('cv','cv.id_contract','contracts.id')
            ->select('customers.*','types_customers.*','contracts.id as id_contract','cv.vehicles')

            ->get();


        return view('ClientsLines',['client'=>$c]);
    }

    public function CustomerCity($city)
    {
        $c = DB::table('customers')->where('city', 'like', "%".$city."%")
            ->join('types_customers', 'customers.id_type_customer', '=', 'types_customers.id')
            ->join('contracts','customers.id','=','contracts.id_customer')
            ->join('cv','cv.id_contract','contracts.id')
            ->select('customers.*','types_customers.*','contracts.id as id_contract','cv.vehicles')

            ->get();


        return view('ClientsLines',['client'=>$c]);
    }

    public function DeleteCustomer($id)
    {


        $disableCustomers = DB::table('customers')->where('customers.id','=',$id)->update(['isActive' => 0]);
        //$disableContracts = DB::table('contracts')->where('contracts.id_customer','=',$id)->update(['isActive' => 0]);



        return Redirect::to('/clients');

    }

    public function saveCustomer(Request $request)
    {


        $messages = [
            'required' => strtoupper(':attribute') .' est obligatoire',
            'unique' => strtoupper(':attribute').' est déja existe'
        ];


        $validator = Validator::make($request->all(), [
            'nom' => 'required|unique:customers,name',
            'contact' => 'required',
            'NContact' => 'required',
            'email' => 'required',
            'ville' => 'required',
            'telephone' => 'required',
            'address' => 'required',
            'type_client' => 'required',


        ],$messages);

        if ($validator->fails()) {
            $errors = $validator->errors();
            //$errors->add('nom','Le nom est obligatoire');
            //$errors =  json_decode($errors);



            return response()->json([
                'success' => false,
                'message' => $errors
            ], 422);
        } else {


            $customer = new Customers();
            $customer->name = $request->input('nom');
            $customer->contact = $request->input('contact');
            $customer->contact_phone = $request->input('NContact');
            $customer->email = $request->input('email');
            $customer->city = $request->input('ville');
            $customer->phone = $request->input('telephone');
            $customer->id_type_customer = $request->input('type_client');
            $customer->address = $request->input('address');
            $customer->isactive = 1;


            $customer->save();


            $customerId = DB::table('customers')->where('name', '=', $request->input('nom'))->
            select('customers.id')->pluck('id')->first();

            $contract = new Contract();
            $contract->id_customer = $customerId;
            $today = date("Y-m-d H:i:s");
            $contract->start_date = $today;
            $date = date_create($today);
            date_modify($date, '+1 year');
            $contract->urlContract = "/contractPdf/" . $request->input('nom');
            $contract->end_date = date_format($date, 'Y-m-d H:i:s');
            $contract->save();


            $contractId = DB::table('contracts')->where('contracts.id_customer', '=', $customerId)->
            select('contracts.id')->pluck('id')->first();


            return response($contractId
                , 200)->header('Content-Type', 'text/plain');

        }

    }


    public function CustomerInfo($name)
    {
        $c = DB::table('customers')->where('name', 'like', $name."%")

            ->join('types_customers', 'customers.id_type_customer', '=', 'types_customers.id')
            ->join('contracts','customers.id','=','contracts.id_customer')
            ->join('cv','cv.id_contract','contracts.id')
            ->select('customers.*','types_customers.*','contracts.id as id_contract','cv.vehicles')->first();

        $type_client =  DB::table('types_customers')->get();

        $typesSubscribes = DB::table('types_subscribes')->get();


        $customerId = DB::table('customers')->where('name','=',$name)->
        select('customers.id')->pluck('id')->first();

        $contratId = DB::table('contracts')->where('id_customer','=',$customerId)->pluck('id')->first();

        $details = DB::table('details')->where('id_contract','=',$contratId)->
        join('vehicles','vehicles.id','=','details.id_vehicle')->
        join('boxes','boxes.id','=','details.id_boxe')->
        join('types_customers_subscribes','types_customers_subscribes.id','details.id_type_customer_subscribe')->
        join('types_subscribes','types_subscribes.id','types_customers_subscribes.id_subscribe')->
        select('vehicles.*','boxes.*','types_subscribes.*','details.*')->get();



        return view('ClientInfo',['c'=>$c,'types_client'=>$type_client,'details'=>$details]);

    }

    public function AddCustomerView()
    {
        $typesSubscribes = DB::table('types_subscribes')->get();
        $typesCustomers = DB::table('types_customers')->get();


        return view('add_client',['types_subscribe'=>$typesSubscribes , 'types_customers'=>$typesCustomers]);
    }



}

