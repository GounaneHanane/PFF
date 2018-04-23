<?php
namespace App\Http\Controllers;
use Response;
use Illuminate\Support\Facades\DB;


use FPDF;


class PDF extends FPDF
{
	private $_info,$_years;


    public function init($info,$years)
    {
    
        $this->_info = $info;
        $this->_years = $years;


    }
    function choice($w,$h)
    {
       $x = $this->GetX();
             $width = $w;
              $y = $this->GetY();


            $this->SetXY($x + $width, $y - $h);


    }

function Header()
{
    // Logo
    $this->Image('http://localhost/opentech.png',10,10,60);
    // Police Arial gras 15
    $this->SetFont('Arial','B',15);
    // Décalage à droite
    $this->Cell(140);
        $this->SetFont('Arial','B',10);

        $this->SetTitle($this->_info->matricule);


    $para = "Fiche contrat\nMatricule : ".$this->_info->matricule." \nDate de debut : ".$this->_info->start_contract." \nDuree du contrat :  ";

    // Titre

        $this->MultiCell(60,5,
    	$para
    	,0,'L');
          
        $this->SetFont('Arial','I',10);
        $this->choice(180,3);
        $this->Cell(1,1,'12 M',0,1,'R');
        $this->choice(181.5,2.5);

        if($this->_years == 1)
        {
            $this->SetFont('Arial','B',9);
            $this->Cell(3,3,'X',1,1,'C');

        }
        else
            $this->Cell(3,3,' ',1,1,'R');  


        $this->SetFont('Arial','I',10);  
        $this->choice(193.5,1.8);
        $this->Cell(1,1,'24 M',0,1,'R');
        $this->choice(194.5,2.4);
        if($this->_years == 2)
        {
            $this->SetFont('Arial','B',9);
            $this->Cell(3,3,'X',1,1,'C');

        }
        else
            $this->Cell(3,3,' ',1,1,'R');  

    $this->Ln(20);

        $this->SetFont('Arial','B',10);

        $p = "\n  OpenTech \n  20-26 Rue Bassatines 1 er Etage N3\n  20120 Casablanca\n\n  Tel.: +212(0)522 30 90 90 - Fax: +212(0)522 31 90 90\n  Email: contact@opentech.ma\n  Web: www.opentech.ma\n\n\n";
$this->setFillColor(230,230,230); 

 $y = $this->GetY();
    $this->MultiCell(90,5,
    	$p
    	,0,'L',TRUE);

   
    $x = $this->GetX();
    $width = 65;

    $this->SetXY($x + $width, $y);




    $client = "\n  Nom : ".$this->_info->name."\n  Contact : ".$this->_info->contact."\n  Tel:".$this->_info->phone_number."\n  Mail: ".$this->_info->mail."\n\n\n\n\n\n";
 
    $this->setFillColor(255,255,255); 

      $this->Cell(40);




       $this->MultiCell(90,5,
        $client
        ,1,'L',TRUE);

}


// Pied de page
function Footer()
{
    $this->Ln(7);
    $this->SetFont('Arial','I',9);
    // Numéro de page
    

    $this->Cell(60,1,'Pour OPENTECH , nom et signature',0,1,'R');

    $whois = "Pour ".$this->_info->name." , nom et signature";
    $this->choice(1,1);
    $this->Cell(150,1,$whois,0,1,'R');

    $this->Ln(2);

    $buffer = "";
    
    for($i = 0; $i <= 7;$i++)
       $buffer .= "\n";

       $this->choice(7,1);
       $this->MultiCell(85,3,
       $buffer
       ,1,1,'L',TRUE);

       $this->choice(102,24);
       $this->MultiCell(85,3,
       $buffer
       ,1,1,'L',TRUE);

       $this->SetFont('Arial','I',6.5);
       $this->Ln(7.5);

       
       $para = "Capital de 500 000 MAD - RC.:263465 - Patente:32480519\nI.F .: 14366774 - C.N.S.S.: 9211038 - I.C.E.: 000093194000039s";

       // Titre
   
           $this->MultiCell(180,3,
           $para
           ,0,'C');

       


}
}

class GenerateCController extends Controller
{
  public function contract($matricule)
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


        $years = round((strtotime($info->end_contract)-strtotime($info->start_contract))/(3600*24*365.25));
    	$pdf = new PDF('P','mm','Legal');
    	$pdf->init($info,$years);
    	$pdf->AddPage();

    $pdf->setFillColor(255,255,255); 

         $pdf->Ln(20);
         

    $stupid = "\n  Date debut prevue : ".$info->start_contract." - Date prevue fin de service ".$info->end_contract."\n\n\n\n  Duree d'abonnement :  ".$years." annee \n";



      for($i = 0; $i <= 30;$i++)
          $stupid .= "\n";

       $pdf->MultiCell(195,5,
        $stupid
        ,1,1,'L',TRUE);


        $pdf->output();
        exit;

        
    }
}