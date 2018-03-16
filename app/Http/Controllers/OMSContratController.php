<?php

namespace App\Http\Controllers;

use App\Models\TypesSubscribe;
use App\Models\Vehicle;
use App\Models\Box;
use App\Models\Detail;
use  App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use function PHPSTORM_META\type;
use Response;
use Validator;
use Illuminate\Support\Facades\DB;
class OMSContratController extends Controller
{


    public function contrat()
    {
        $c = DB::table('contractveiw')
            ->select('contractveiw.*')
            ->get();

        $AllC = DB::table('customers')->select('customers.id', 'customers.name')->get();

        $ClientType = DB::table('types_customers')
            ->select('types_customers.type as ClientType', 'types_customers.id as ClientTypeId')->get();

        /*
        $AbonnementType=DB::table('types_subscribes')
        ->select('types_subscribes.type as AbonnementType','types_subscribes.id as AbonnementTypeId')->get();
        $v=DB::table('vehicles')
        ->select('vehicles.*')->get();

        */
//return response()->json([$c]);
//  return view('Contrat',['contracts'=>$c,'clientTypes'=>$ClientType,'abonnementTypes'=>$AbonnementType,'vehicle'=>$v]);
        return view('Contrat', ['contracts' => $c, 'clientTypes' => $ClientType, 'Customers' => $AllC]);
    }


    public function searchContrat(Request $request)
    {

        $id_contract = ($request->input('id_contract') == null) ? null : $request->input('id_contract');
        $id_customer = ($request->input('id_customer') == null) ? null : $request->input('id_customer');
        $debut_contrat = ($request->input('debut_contrat') == null) ? null : $request->input('debut_contrat');
        $fin_contrat = ($request->input('fin_contrat') == null) ? null : $request->input('fin_contrat');
        $typeClient = ($request->input('typeClient') == null) ? null : $request->input('typeClient');
        $critiere = [];
        $i = 0;

        $contracts = DB::table('contracts')->where('contracts.isActive', '=', '1');

        if ($id_contract != null) {
            $critiere[$i] = ['contracts.id', '=', $id_contract];
            $i++;

        }
        if ($debut_contrat != null) {
            $critiere[$i] = ['contracts.start_contract', '=', $debut_contrat];
            $i++;

        }
        if ($fin_contrat != null) {
            $critiere[$i] = ['contracts.end_contract', '=', $fin_contrat];
            $i++;

        }

        if ($typeClient != null) {
            $critiere[$i] = ['customers.id_type_customer', '=', $typeClient];
            $i++;

        }
        if ($id_customer != null) {
            $critiere[$i] = ['customers.id', '=', $id_customer];
            $i++;

        }


        $QueryContracts = $contracts
            ->join('customers', 'customers.id', '=', 'contracts.id_customer')
            ->join('types_customers', 'types_customers.id', '=', 'customers.id_type_customer')
            ->join('count_vehicle', 'count_vehicle.customer_id', '=', 'customers.id')
            ->select('contracts.*', 'customers.*', 'contracts.id as id_contract', 'types_customers.type as type_customer', 'count_vehicle.*')
            ->where($critiere)
            ->get();


        return view('ContractLines', ['contracts' => $QueryContracts]);
    }

    public function DisableContract($id)
    {

        $contrat = DB::table('contracts')->where('contracts.id', $id)->update(['isActive' => 0]);


        return response()->json([$id]);

    }


    public function refresh()
    {
        $c = DB::table('contracts')
            ->where('contracts.isActive', '=', '1')
            ->join('customers', 'customers.id', '=', 'contracts.id_customer')
            ->join('types_customers', 'types_customers.id', '=', 'customers.id_type_customer')
            ->join('count_vehicle', 'count_vehicle.customer_id', '=', 'customers.id')
            ->select('contracts.*', 'customers.*', 'contracts.id as id_contract', 'types_customers.type as type_customer', 'count_vehicle.*')
            ->get();

        return view('ContractLines', ['contracts' => $c]);
    }

    public function addContrat(Request $request)
    {
          $messages = [
               'required' => strtoupper(':attribute') .' est obligatoire',
              'unique' => strtoupper(':attribute') .' est deja existe'
           ];


           $validator = Validator::make($request->all(), [
               'ncontrat' => 'required',
               'dated' => 'required',
               'client' => 'required|unique:contracts,id_customer',


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


        $client= $request->input('client');
        $contract = new Contract();
        $contract->id_customer = $client;
        $today = date("Y-m-d H:i:s");
        $contract->start_contract = $today;
        $date = date_create($today);
        date_modify($date, '+1 year');
        $contract->urlContract = "/contractPdf/" .$client;
        $contract->end_contract = date_format($date, 'Y-m-d H:i:s');
        $contract->isActive = 1;
        $contract->save();


    }

}



}