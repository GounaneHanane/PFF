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
            ->select('alerte.*')->get();
        return view('home',['alert'=>$a]);
    }


}