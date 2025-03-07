<?php
	require('fpdf.php');
	require "config.php";
	require "connect_db.php";
	require "functions.php";
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	
		//sub
	
	
		$id_registre=$_GET['id_registre'];$bon_sortie=$_GET['bon_sortie'];$c=$_GET['observation'];
		$montant=$_GET['montant'];
		
		$vendeur=$_GET['vendeur'];$date1=dateUsToFr($_GET['date']);$service=$_GET['service'];
		$datee=$_GET['date'];
			
			$sql = "TRUNCATE TABLE `bon_de_sortie`  ;";
			db_query($database_name, $sql);
			$sql = "TRUNCATE TABLE `bon_de_sortie_pro`  ;";
			db_query($database_name, $sql);

		$sql  = "SELECT * ";
		$sql .= "FROM commandes WHERE id_registre = " . $id_registre . ";";
		$user = db_query($database_name, $sql); 

		while($user_ = fetch_array($user)) { 
		$date = dateUsToFr($user_["date_e"]);
		$client = $user_["client"];$montant_f = $user_["net"];$numero = $user_["commande"];
		$vendeur = $user_["vendeur"];$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];
		$evaluation = $user_["evaluation"];$sans_remise = $user_["sans_remise"];$remise3 = $user_["remise_3"];

	
	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_commandes where commande='$numero' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { 
		$produit=$users1_["produit"]; $id=$users1_["id"];$quantite=$users1_["quantite"];$condit=$users1_["condit"];
		

				$sql  = "INSERT INTO bon_de_sortie ( commande, produit, quantite,condit ) VALUES ( ";
				$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $quantite . "', ";
				$sql .= "'" . $condit . "');";

				db_query($database_name, $sql);
		}
		
		//sortie promotions
	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_commandes_pro where commande='$numero' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { 
		$produit=$users1_["produit"]; $id=$users1_["id"];$quantite=$users1_["quantite"];$condit=$users1_["condit"];
		

				$sql  = "INSERT INTO bon_de_sortie_pro ( commande, produit, quantite,condit ) VALUES ( ";
				$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $quantite . "', ";
				$sql .= "'" . $condit . "');";

				db_query($database_name, $sql);
		}
		
		
		
	}

	
	
	////////////////////////
		$sql  = "SELECT * ";$escompte="1";$montant_f=0;
		$sql .= "FROM commandes WHERE date_e='$datee' and escompte_exercice='$escompte' and vendeur='$vendeur' and client='$client' ORDER BY date_e;";
		$user = db_query($database_name, $sql); 

		while($user_ = fetch_array($user)) { 
		$date = dateUsToFr($user_["date_e"]);
		$client = $user_["client"];$montant_f = $montant_f+$user_["net"];$numero = $user_["commande"];
		$vendeur = $user_["vendeur"];$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];
		$evaluation = $user_["evaluation"];$sans_remise = $user_["sans_remise"];$remise3 = $user_["remise_3"];

	
	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_commandes where commande='$numero' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { 
		$produit=$users1_["produit"]; $id=$users1_["id"];$quantite=$users1_["quantite"];$condit=$users1_["condit"];
		

				$sql  = "INSERT INTO bon_de_sortie ( commande, produit, quantite,condit ) VALUES ( ";
				$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $quantite . "', ";
				$sql .= "'" . $condit . "');";

				db_query($database_name, $sql);
		}
		
			
		
	}
	
	/////////////////////////////////////////
	
	
	
	

//Create new pdf file
$pdf=new FPDF('P','mm','A4');

//Disable automatic page break
$pdf->SetAutoPageBreak(false);

//Add first page
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 25;$y_axis = 25;$row_height=6;$l=25;$ent=46;

/*$pdf->addJpegFromFile("logo_mps.JPG",40,820);*/
$pdf->Image('logo_mps_2.jpg',10,10,185,35);
/*$pdf->addJpegFromFile("logo_mps.JPG",40,820);*/
//$pdf->Image('logo_mps_2_pied.jpg',10,290,185,270);

//print column titles for the actual page
$pdf->SetFillColor(255);
$pdf->SetY($ent);
$pdf->SetFont('Times','B',14);


$pdf->SetFillColor(255);
$pdf->SetFont('Times','',14);$pdf->SetY($ent+22);
$pdf->SetX(30);$d="Marrakech le : ".$date1;
$pdf->Cell(25,10,$d,0,0,'L',1);
$pdf->SetFont('','',12);


$pdf->SetY($ent+10);$pdf->SetX(139);$d=$c;
$pdf->Cell(40,10,$d,0,0,'L',1);
$pdf->SetY($ent+20);$pdf->SetX(139);if($bon_sortie<>"87/092022"){$d=$service;}else{$d="TATA";}
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetY($ent);$pdf->SetX(60);$d="Bon de Livraison Numero :  ".$bon_sortie;
$pdf->Cell(30,10,$d,0,0,'L',1);

$total=0;
//cadre

$pdf->SetLineWidth(0.3);
//$pdf->Line(3,3,205,3);
$pdf->Line(3,76,205,76);
$pdf->Line(3,90,205,90);
$pdf->Line(3,76,3,90);
$pdf->Line(205,76,205,90);

$pdf->SetY(78);$pdf->SetX(10);$d="  Designation Article  ";
$pdf->Cell(50,10,$d,0,0,'L',1);
$pdf->SetY(78);$pdf->SetX(85);$d="  Nbre Paquets  ";
$pdf->Cell(30,10,$d,0,0,'L',1);
$pdf->SetY(78);$pdf->SetX(125);$d="  Quantite  ";
$pdf->Cell(30,10,$d,0,0,'L',1);
$pdf->SetY(78);$pdf->SetX(165);$d="Prix Unit";
$pdf->Cell(20,10,$d,0,0,'L',1);
$pdf->SetY(78);$pdf->SetX(185);$d=" Prix Total";
$pdf->Cell(20,10,$d,0,0,'L',1);

$ligne=95;
		$sql  = "SELECT * ";
		$sql .= "FROM produits order by produit ;";
		$user1 = db_query($database_name, $sql);
	while($users11_ = fetch_array($user1)) { 
		$produit=$users11_["produit"];$condit=$users11_["condit"];$qte=0;$prix_unit=$users11_["prix"];

	$sql1  = "SELECT * ";
	$sql1 .= "FROM bon_de_sortie where produit='$produit' and commande='$id_registre' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { 
		$qte=$qte+$users1_["quantite"];
	}


	////////////////////////////// NOUVELLE PAGE

	if ($ligne>=250){

	$pdf->SetY($ligne+5);$pdf->SetX(102);
	$pdf->Cell(50,9,'A repporter',0,0,'L',1);
	

//Add first page
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 25;$y_axis = 25;$row_height=6;$l=25;$ent=55;

/*$pdf->addJpegFromFile("logo_mps.JPG",40,820);*/
$pdf->Image('logo_mps_2.jpg',10,10,185,35);

//print column titles for the actual page
$pdf->SetFillColor(255);
$pdf->SetY($ent);
$pdf->SetFont('Times','B',14);


$pdf->SetFillColor(255);
$pdf->SetFont('Times','',14);$pdf->SetY($ent+25);
$pdf->SetX(30);$d=$date1;
$pdf->Cell(25,10,$d,0,0,'L',1);
$pdf->SetFont('','',11);



$pdf->SetY($ent+10);$pdf->SetX(139);$d=$c;
$pdf->Cell(40,10,$d,0,0,'L',1);
$pdf->SetY($ent+20);$pdf->SetX(139);$d=$service;
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetY($ent);$pdf->SetX(60);$d="Bon de Livraison Numero :  ".$bon_sortie;
$pdf->Cell(30,10,$d,0,0,'L',1);

$ligne=$ent+55;



////////////////////////////////////
}




	
		if ($qte>0){$pdf->SetY($ligne);$pdf->SetX(20);
	$pdf->Cell(50,6,$produit,0,0,'L',1);$pdf->SetX(120);
	$pdf->Cell(10,6,$qte,0,0,'C',1);$pdf->SetX(130);
	$pdf->Cell(10,6,' x ',0,0,'C',1);$pdf->SetX(140);
	$pdf->Cell(20,6,$condit,0,0,'C',1);$pdf->SetX(165);$d=number_format($prix_unit,2,',',' ');
	$pdf->Cell(10,6,$d,0,0,'R',1);$pdf->SetX(189);$d=number_format($prix_unit*$condit*$qte,2,',',' ');
	$pdf->Cell(10,6,$d,0,0,'R',1);
	$total = $total+$prix_unit*$condit*$qte;
	
	
	
		
			$ligne=$ligne+5;
		 }
  } 
 

$pdf->SetY($ligne+10);$pdf->SetX(155);
	$pdf->Cell(50,6,'Total Brut : ',0,0,'L',1);
 $pdf->SetX(189);
	$pdf->Cell(10,6,number_format($total,2,',',' '),0,0,'R',1);
	
$pdf->SetY($ligne+20);$pdf->SetX(155);$montant=number_format($montant+$montant_f,2,',',' ');
	$pdf->Cell(50,6,'Total Net : ',0,0,'L',1);
 $pdf->SetX(189);
	$pdf->Cell(10,6,$montant,0,0,'R',1);	

$pdf->Output();
