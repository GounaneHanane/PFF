<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

     protected function dateContract($dateC)
    {

        if ($dateC)
            $date_start_contract = $dateC;
        else
            $date_start_contract = date("Y-m-d");


        $date = explode('-', $date_start_contract);

        if ($date[2] > 1 and $date[2] < 15) {
            $date[2] = '15';
        }
        if ($date[2] > 15) {
            $time = strtotime($date_start_contract);
            $date = date("Y-m-d", strtotime("+1 month", $time));
            $date = explode('-', $date);
            $date[2] = '1';


        }

        $date = implode('-', $date);

        $date_start_contract = $date;

        $time = strtotime($date_start_contract);
        $date_end_contract = date("Y-m-d", strtotime("+1 year", $time));

        $contratDated = array();
        $contratDated[0] = $date_start_contract;
        $contratDated[1] = $date_end_contract;
        return $contratDated;

    }
}
