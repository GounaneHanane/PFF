<?php
namespace App\Http\Controllers;
use Response;
use Illuminate\Support\Facades\DB;


use FPDF;


class PDF extends FPDF
{
	private $_info;

    public function init($info)
    {
    
    	$this->_info = $info;


    }

function Header()
{
    // Logo
    $this->Image('http://localhost/opentech.png',10,10,60);
    // Police Arial gras 15
    $this->SetFont('Arial','B',15);
    // Décalage à droite
    $this->Cell(130);
        $this->SetFont('Arial','B',9);

        $this->SetTitle($this->_info->matricule);

    $para = "Nom : ".$this->_info->name." \nMatricule : ".$this->_info->matricule." \nDate de debut : ".$this->_info->start_contract." \nDate de fin : ".$this->_info->end_contract."\nTelephone : ".$this->_info->phone_number." ";

    // Titre
    $this->MultiCell(50,5,
    	$para
    	,0,'L');
    // Saut de ligne
    $this->Ln(20);

        $this->SetFont('Arial','B',10);

        $p = "Taille de Park : ".$this->_info->count."\nNombre D'Avance : ".$this->_info->nbAvance."\nNombre De Simple: ".$this->_info->nbSimple."\n".
            "Price Total : ".$this->_info->price;

    $this->MultiCell(50,5,
    	$p
    	,0,'L');
}
function BasicTable($header, $data)
{
	$this->Ln(20);
        $this->SetFont('Arial','B',11);

        $this->Cell(15);

    foreach($header as $col)
        $this->Cell(33,13,$col,1,0,'C');

        $this->Ln();
        $this->SetFont('Arial','I',11);


    foreach($data as $row)
    {
    	        $this->Cell(15);

        foreach($row as $col)
            $this->Cell(33,15,$col,1);
        $this->Ln();
    }
}

// Pied de page
function Footer()
{
    // Positionnement à 1,5 cm du bas
    $this->SetY(-15);
    // Police Arial italique 8
    $this->SetFont('Arial','I',8);
    // Numéro de page
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

class GenerateController extends Controller
{
  public function test($matricule)
    {
    	$info = DB::table('detail_contract')->where('detail_contract.matricule','=',$matricule)
    	     ->join('contracts','contracts.id','detail_contract.id_contract')
    	     ->join('customers','customers.id','contracts.id_customer')
    	     ->select('detail_contract.*','contracts.*','customers.*',
    	     	'detail_contract.matricule as matricule',
DB::raw("(detail_contract.nbavance + detail_contract.nbSimple) as count")
    	 )
           
    	     ->first();

    	     $vehicles = DB::table('info_detail_contract')->
    	             join('detail_contract','detail_contract.id',
    	                 'info_detail_contract.id_detail')
    	            ->join('vehicles','vehicles.id','info_detail_contract.id_vehicle')->
    	   join('type_customers_subscribes','type_customers_subscribes.id','info_detail_contract.id_type_customer_subscribe')->
                    join('types_subscribes','types_subscribes.id','type_customers_subscribes.id_type_subscribe')->
where('detail_contract.matricule','=',$matricule)

    	            ->select('imei','marque','model','type','info_detail_contract.price')
    	            ->get();



        $thead = array('IMEI','MARQUE','MODEL','TYPE','PRIX');


    	   

    	$pdf = new PDF('P','mm','Legal');
    	$pdf->init($info);
    	$pdf->AddPage();

    	$pdf->BasicTable($thead,$vehicles);
        $pdf->output();
        exit;

        
    }
}