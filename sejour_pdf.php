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
	
		$numero=$_GET['numero'];
	
		$sql  = "SELECT * ";
		$sql .= "FROM registre_factures_rak WHERE id = " . $numero . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$date = $user_["date_f"];$client=$user_["client"];$produit=$user_["service"];$du = $user_["du"];$au = $user_["au"];
		$num=$numero."/2007";$taux_com=0;$numero_f=$user_["id"]."/2007";
		$date_f=dateUsToFr($date);$pdu=dateUsToFr($du);$pau=dateUsToFr($au);$adresse=$user_["observation"];
		


include 'class.ezpdf.php';	// inclusion du code de la bibliothèque
$pdf = & new Cezpdf();	// constructeur de la classe EZPDF
$pdf->Cezpdf('a4','portrait');
$pdf->selectFont('Helvetica.afm');
if (file_exists('logoagence.JPG')){
  $pdf->addJpegFromFile('logoagence.JPG',10,$pdf->y-90,90,0);
}
if (file_exists('logoagence.JPG')){
  $pdf->addJpegFromFile('logo1.JPG',10,$pdf->y-110,190,0);
}

$pdf->addText(200,820,10, ' '); 
$pdf->addText(200,800,10, ' 11 Derb Mqqadem, Rte Arset Loghzail,Douar Graoua,Medina Marrakech');
$pdf->addText(200,780,10, ' Tel: +212 24 38 56 56   Fax +212 24 37 66 22 ');
$pdf->addText(200,760,10, ' RC : Marrakech  - IF :  - Patente : ');


$pdf->addText(7, 790, 7, '');
$pdf->addText(10, 660, 12, 'Marrakech le : '.$date_f);
$pdf->addText(350, 700, 14, $client);
$pdf->addText(350, 680, 12, $adresse);

$pdf->addText(220, 640, 16, 'Facture : ');
$pdf->addText(310, 640, 16, $numero_f);

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

$pdf->addText(20, 620, 14, 'Ref');
$pdf->addText(150, 620, 14, 'Noms');
$pdf->addText(255, 620, 14, 'Reservation');
$pdf->addText(420, 620, 14, 'Arrivee');
$pdf->addText(475, 620, 14, 'Depart');
$pdf->addText(530, 620, 14, 'Montant');


	$sql  = "SELECT * ";
	$sql .= "FROM details_bookings_sejours_rak where numero_f='$numero' and montant_f>0 ORDER BY id;";
	$users = db_query($database_name, $sql);$net=0;

while($row=mysql_fetch_array($users)) 
  { 
  $ref=$row["v_ref"]; $noms=$row["noms"]; $adt=$row["adultes"];$enf=$row["enfants"];
  $prix=number_format($row["montant_f"]/$row["adultes"],2,',',' ');
  $montant_f_f=number_format($row["montant_f"],2,',',' ');$date_a=dateUsToFr($row["arrivee"]);
  $date_d=dateUsToFr($row["depart"]);$lp=$row["id_registre"]+200000;
  $chambre=$row["chambre"];$regime=$row["regime"];
  if($chambre=="DINER MOROCCAN RESTAURANT"){$chambre="DINER MOROCCAN";$regime="";}
   $pdf->addText(8, $ligne, 9, $ref);
   $pdf->addText(140, $ligne, 8, $noms);
   $pdf->addText(280, $ligne, 8, $chambre." ".$regime);
   $pdf->addText(420, $ligne, 9, $date_a);
   $pdf->addText(480, $ligne, 9, $date_d);
   $pdf->addText(540, $ligne, 9, $montant_f_f);
	$ligne=$ligne-20;$net=$net+$row["montant_f"];
  } 
	$pdf->line(5, 70, 585, 70);
	$ligne=$ligne-50;$com=number_format($net*$taux_com/100,2,',',' ');
   $net=number_format($net-$com,2,',',' ');
   $pdf->addText(50, 60, 14, 'En votre aimable reglement  :');
   $pdf->addText(50, 40, 14, ' ');
   $pdf->addText(380, 50, 14, 'Total A regler');
   $pdf->addText(500,50, 14, $net);
   
  

$pdf->ezStream();		// envoi du fichier au navigateur


?>
