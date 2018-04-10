<?php

namespace App\Http\Controllers;
use Response;



use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

require "phpToPDF.php";


class GenerateController extends Controller
{

    public function test()
    {
       // $html2pdf = new Html2Pdf('P', 'A4', 'fr', true, 'UTF-8', array(0, 0, 0, 0));

       
    }
}