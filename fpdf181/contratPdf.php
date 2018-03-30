<?php
require ('fpdf.php');
$pdf=new FPDF();
var_dump(get_class_methods($pdf));
?>
