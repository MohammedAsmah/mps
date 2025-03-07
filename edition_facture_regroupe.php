<?php
	require "config.php";
	require "connect_db.php";
	require "functions.php";
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$user_name=GetUserName();
	$error_message = "";
	$type_service="SEJOURS ET CIRCUITS";
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	
		$numero=$_GET['numero'];$client=$_GET['client'];$date=$_GET['date'];

include 'class.ezpdf.php';	// inclusion du code de la bibliothèque
$pdf = & new Cezpdf();	// constructeur de la classe EZPDF
$pdf->Cezpdf('a4','portrait');
$pdf->selectFont('Helvetica.afm');
if (file_exists('logoagence.JPG')){
  $pdf->addJpegFromFile('logoagence.JPG',30,$pdf->y-40,140,0);
}
if (file_exists('logoagence.JPG')){
  $pdf->addJpegFromFile('logo1.JPG',10,$pdf->y-50,190,0);
}

$pdf->addText(380,820,10, ' '); 
$pdf->addText(380,800,10, ' Q.I sidi Ghanem Marrakech');
$pdf->addText(380,780,10, ' Tel: +212 24 33 51 16   Fax +212 24 33 51 17 ');
$pdf->addText(380,760,10, ' RC : Marrakech  - IF :  - Patente : ');


$pdf->addText(7, 790, 7, '');
$pdf->addText(10, 660, 12, 'Marrakech le : '.$date);
$pdf->addText(350, 700, 14, $client);
//$pdf->addText(350, 680, 12, $adresse);

$pdf->addText(220, 640, 16, 'Facture : ');
$pdf->addText(310, 640, 16, $numero);

$ligne=600;

$pdf->setLineStyle(1);
$pdf->line(5, 615, 585, 615);
$pdf->line(5, 635, 585, 635);
$pdf->line(5, 70, 5, 635);
$pdf->line(135, 70, 135, 635);
$pdf->line(420, 70, 420, 635);
$pdf->line(470, 70, 470, 635);
$pdf->line(525, 70, 525, 635);
$pdf->line(585, 70, 585, 635);

$pdf->addText(40, 620, 14, 'Qte');
$pdf->addText(255, 620, 14, 'Article');
$pdf->addText(420, 620, 14, 'Unite');
$pdf->addText(470, 620, 14, 'Prix Unit');
$pdf->addText(530, 620, 14, 'Montant');


	$sql  = "SELECT * ";
	$sql .= "FROM detail_factures where facture='$numero' ORDER BY produit;";
	$users = db_query($database_name, $sql);$net=0;

while($row=mysql_fetch_array($users)) 
  { 
  	$quantite=$row["quantite"]; $produit=$row["produit"];$prix_unit=$row["prix_unit"];$condit=$row["condit"];
  	$montant_f=$quantite*$condit*$prix_unit;
  	$montant_f_f=number_format($montant_f,2,',',' ');
   $pdf->addText(50, $ligne, 9, $quantite);
   $pdf->addText(140, $ligne, 8, $produit);
   $pdf->addText(430, $ligne, 8, $condit);
   $pdf->addText(480, $ligne, 9, $prix_unit);
   $pdf->addText(540, $ligne, 9, $montant_f_f);
	$ligne=$ligne-10;$net=$net+$montant_f;
  } 
	$pdf->line(5, 70, 585, 70);
   $net=number_format($net,2,',',' ');
   $pdf->addText(50, 40, 14, ' ');
   $pdf->addText(380, 50, 14, 'Total A regler');
   $pdf->addText(500,50, 14, $net);
   
  

$pdf->ezStream();		// envoi du fichier au navigateur


?>
