<?php
	require('fpdf.php');
	require "config.php";
	require "connect_db.php";
	require "functions.php";
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$user = $user_["login"];
	
	
	
	
	
		//sub
		$montant=$_GET['montant'];$destination=$_GET['destination'];$montant1=$_GET['montant'];
		$montant=number_format($montant,2,',',' ');$m=0;
		$vendeur=$_GET['vendeur'];$date=$_GET['date'];$date_aff=dateUsToFr($_GET['date']);$time_edition=date("Y-m-d H:i:s");
		list($dt, $hr) = explode(" ", $time_edition);
		list($annee,$mois,$jour) = explode("-", $dt);
		list($heure,$minute,$seconde) = explode(":", $hr);
		$heure = $heure -1 ;
		$horaire = "imprime le : ".$jour."/".$mois."/".$annee."  ".$heure.":".$minute.":".$seconde." par : ".$user;
	
				$sql  = "INSERT INTO evaluations_prealables ( vendeur,date,montant,destination,user,date_edition,time_edition ) VALUES ( ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $montant1 . "', ";
				$sql .= "'" . $destination . "', ";
				$sql .= "'" . $user . "', ";
				$sql .= "'" . $horaire . "', ";
				$sql .= "'" . $time_edition . "');";

				db_query($database_name, $sql);
	
	
		/*$id_registre=$_GET['id_registre'];$bon_sortie=$_GET['bon_sortie'];$c=$_GET['observation'];
		$montant=$_GET['montant'];
		$montant=number_format($montant,2,',',' ');
		$vendeur=$_GET['vendeur'];$date1=dateUsToFr($_GET['date']);$service=$_GET['service'];*/
			
			$sql = "TRUNCATE TABLE `bon_de_sortie`  ;";
			db_query($database_name, $sql);
			$sql = "TRUNCATE TABLE `bon_de_sortie_pro`  ;";
			db_query($database_name, $sql);
		$tt=0;
		$sql  = "SELECT COUNT(*) AS total FROM bon_de_sortie ";
		$userc = db_query($database_name, $sql); 	
		$row = mysql_fetch_assoc($userc);
		$tot=$row['total'];	
		if ($tot==0){	
			
		$sql  = "SELECT * ";$i=0;$m=0;
		$sql .= "FROM commandes WHERE date_e='$date' and vendeur='$vendeur' and ev_pre=1 ORDER BY destination ";
		$user = db_query($database_name, $sql); 

		while($user_ = fetch_array($user)) { 
		$date = dateUsToFr($user_["date_e"]);$i=$i+1;
		$client = $user_["client"];$montant_f = $user_["net"];$numero = $user_["commande"];$m=$m+$user_["net"];
		$vendeur = $user_["vendeur"];$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];
		$evaluation = $user_["evaluation"];$sans_remise = $user_["sans_remise"];$remise3 = $user_["remise_3"];

		

	
	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_commandes where commande='$numero' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { 
		$produit=$users1_["produit"]; $id=$users1_["id"];$quantite=$users1_["quantite"];$condit=$users1_["condit"];
		$prix_unit=$users1_["prix_unit"];

				$sql  = "INSERT INTO bon_de_sortie ( commande, produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $quantite . "', ";$sql .= "'" . $prix_unit . "', ";
				$sql .= "'" . $condit . "');";

				db_query($database_name, $sql);
		}
		
		//sortie promotions
	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_commandes_pro where commande='$numero' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { 
		$produit=$users1_["produit"]; $id=$users1_["id"];$quantite=$users1_["quantite"];$condit=$users1_["condit"];
		$prix_unit=$users1_["prix_unit"];

				$sql  = "INSERT INTO bon_de_sortie_pro ( commande, produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $quantite . "', ";$sql .= "'" . $prix_unit . "', ";
				$sql .= "'" . $condit . "');";

				db_query($database_name, $sql);
		}
		
		
		
	}

if ($i>1){$client="Divers clients";}
//Create new pdf file
$pdf=new FPDF('P','mm','A4');

//Disable automatic page break
$pdf->SetAutoPageBreak(false);

//Add first page
$pdf->AddPage();
$pdf->SetFillColor(255);
$pdf->SetFont('arial','',9);	
$pdf->SetY(5);
$pdf->SetX(135);
$pdf->Cell(50,9,$horaire,0,0,'L',1);

//set initial y axis position per page
$y_axis_initial = 25;$y_axis = 25;$row_height=6;$l=25;

//print column titles for the actual page
$pdf->SetFillColor(195);
$pdf->SetY(5);
$pdf->SetFont('arial','B',18);
$pdf->Cell(70,14,'   Evaluation Prealable',1,0,'L',1);

$pdf->SetY(20);
$pdf->SetFillColor(255);
$pdf->SetFont('arial','B',14);
$pdf->SetX(130);$d="Marrakech le : ".$date_aff;
$pdf->Cell(25,10,$d,0,0,'L',1);

$pdf->SetFont('Courier','',12);
$pdf->SetY(20);$pdf->SetX(10);$d="Vendeur : ".$vendeur;
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetY(30);$pdf->SetX(120);$d="Destination : ".$destination;
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetY(30);$pdf->SetX(10);$d="Client : ".$client;
$pdf->Cell(40,10,$d,0,0,'L',1);

/*$pdf->SetY(35);$pdf->SetX(90);$d="Numero :  ".$bon_sortie;
$pdf->Cell(30,10,$d,0,0,'L',1);*/

/*$pdf->SetY(35);$pdf->SetX(145);$d="Montant : ".$montant;
$pdf->Cell(30,10,$d,0,0,'L',1);*/
$pdf->SetLineWidth(0.3);
$pdf->Line(3,3,205,3);
$pdf->Line(3,47,205,47);
$pdf->Line(3,60,205,60);
$pdf->Line(3,3,3,60);
$pdf->Line(205,3,205,60);


$pdf->SetY(48);$pdf->SetX(10);$d="  Designation Article  ";
$pdf->Cell(50,10,$d,0,0,'L',1);
$pdf->SetY(48);$pdf->SetX(85);$d="  Nbre Paquets  ";
$pdf->Cell(30,10,$d,0,0,'L',1);
$pdf->SetY(48);$pdf->SetX(124);$d="  Quantite  ";
$pdf->Cell(30,10,$d,0,0,'L',1);
$pdf->SetY(48);$pdf->SetX(150);$d="  Prix Unit.";
$pdf->Cell(15,10,$d,0,0,'L',1);
$pdf->SetY(48);$pdf->SetX(178);$d="  Total  ";
$pdf->Cell(10,10,$d,0,0,'L',1);

$ligne=47;
$pdf->Line(87,$ligne,87,$ligne+18);
	$pdf->Line(127,$ligne,127,$ligne+18);
	$pdf->Line(155,$ligne,155,$ligne+18);
	$pdf->Line(179,$ligne,179,$ligne+18);



$ligne=65;$pdf->Line(3,60,3,65);$pdf->Line(205,60,205,65);
	
	
		$sql  = "SELECT * ";
		$sql .= "FROM produits order by produit ;";
		$user1 = db_query($database_name, $sql);
	while($users11_ = fetch_array($user1)) { 
		$produit=$users11_["produit"];$condit=$users11_["condit"];$qte=0;

	$sql1  = "SELECT * ";
	$sql1 .= "FROM bon_de_sortie where produit='$produit' and commande='$id_registre' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { 
		$qte=$qte+$users1_["quantite"];$prix_unit=$users1_["prix_unit"];
	}	
//////////////////////

if ($ligne>=280){ $pdf->Line(3,$ligne,3,$ligne+5);
  $pdf->Line(87,$ligne,87,$ligne+5);
	$pdf->Line(127,$ligne,127,$ligne+5);
	$pdf->Line(155,$ligne,155,$ligne+5);
	$pdf->Line(179,$ligne,179,$ligne+5);
  $pdf->Line(205,$ligne,205,$ligne+5);
  $pdf->Line(3,$ligne+5,205,$ligne+5);
$pdf->SetY($ligne+8);
$pdf->SetX(130);$d="A repporter ";
$pdf->Cell(25,10,$d,0,0,'L',1);

//Add first page
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 25;$y_axis = 25;$row_height=6;$l=25;

//print column titles for the actual page
$pdf->SetFillColor(195);
$pdf->SetY(5);
$pdf->SetFont('arial','B',18);
$pdf->Cell(70,14,'   Evaluation Prealable',1,0,'L',1);

$pdf->SetFillColor(255);
$pdf->SetFont('arial','B',14);
$pdf->SetX(130);$d="Marrakech le : ".$date_aff;
$pdf->Cell(25,10,$d,0,0,'L',1);

$pdf->SetFont('Courier','',12);
$pdf->SetY(20);$pdf->SetX(10);$d="Vendeur : ".$vendeur;
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetY(15);$pdf->SetX(100);$d="Destination : ".$destination;
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetY(30);$pdf->SetX(10);$d="Client : ".$client;
$pdf->Cell(40,10,$d,0,0,'L',1);

/*$pdf->SetY(35);$pdf->SetX(90);$d="Numero :  ".$bon_sortie;
$pdf->Cell(30,10,$d,0,0,'L',1);*/

/*$pdf->SetY(35);$pdf->SetX(145);$d="Montant : ".$montant;
$pdf->Cell(30,10,$d,0,0,'L',1);*/
$pdf->SetLineWidth(0.3);
$pdf->Line(3,3,205,3);
$pdf->Line(3,47,205,47);
$pdf->Line(3,60,205,60);
$pdf->Line(3,3,3,60);
$pdf->Line(205,3,205,60);


$pdf->SetY(48);$pdf->SetX(10);$d="  Designation Article  ";
$pdf->Cell(50,10,$d,0,0,'L',1);
$pdf->SetY(48);$pdf->SetX(85);$d="  Nbre Paquets  ";
$pdf->Cell(30,10,$d,0,0,'L',1);
$pdf->SetY(48);$pdf->SetX(124);$d="  Quantite  ";
$pdf->Cell(30,10,$d,0,0,'L',1);

$pdf->SetY(48);$pdf->SetX(150);$d="  Prix Unit.";
$pdf->Cell(15,10,$d,0,0,'L',1);
$pdf->SetY(48);$pdf->SetX(178);$d="  Total  ";
$pdf->Cell(10,10,$d,0,0,'L',1);

$ligne=47;
$pdf->Line(87,$ligne,87,$ligne+18);
	$pdf->Line(127,$ligne,127,$ligne+18);
	$pdf->Line(155,$ligne,155,$ligne+18);
	$pdf->Line(179,$ligne,179,$ligne+18);



$ligne=65;$pdf->Line(3,60,3,65);$pdf->Line(205,60,205,65);
	
}

/////////////////////







		if ($qte>0){$pdf->SetY($ligne);$pdf->SetX(4);
	$pdf->Cell(50,6,$produit,0,0,'L',1);$pdf->SetX(90);
	$pdf->Cell(10,6,$qte,0,0,'L',1);$pdf->SetX(100);
	$pdf->Cell(10,6,' X ',0,0,'L',1);$pdf->SetX(112);
	$pdf->Cell(20,6,$condit,0,0,'L',1);$pdf->SetX(130);
	$pdf->Cell(30,6,$qte*$condit,0,0,'L',1);$d=number_format($prix_unit,2,',',' ');
	$pdf->Cell(30,6,$d,0,0,'L',1);$d=number_format($qte*$condit*$prix_unit,2,',',' ');$pdf->SetX(180);
	$tt=$tt+($qte*$condit*$prix_unit);
	$pdf->Cell(30,6,$d,0,0,'L',1);
	
	/*$pdf->addText(455, $ligne, 9.5, number_format($prix_unit,2,',',' '));
   $pdf->addText(530, $ligne, 9.5, number_format($qte*$condit*$prix_unit,2,',',' '));
*/
   
	$pdf->Line(3,$ligne,3,$ligne+5);
	$pdf->Line(87,$ligne,87,$ligne+5);
	$pdf->Line(127,$ligne,127,$ligne+5);
	$pdf->Line(155,$ligne,155,$ligne+5);
	$pdf->Line(179,$ligne,179,$ligne+5);
	$pdf->Line(205,$ligne,205,$ligne+5);
	
		
			$ligne=$ligne+5;
		 }
  } 
  
  $pdf->Line(3,$ligne,3,$ligne+5);
  $pdf->Line(87,$ligne,87,$ligne+5);
	$pdf->Line(127,$ligne,127,$ligne+5);
	$pdf->Line(155,$ligne,155,$ligne+5);
	$pdf->Line(179,$ligne,179,$ligne+5);
  $pdf->Line(205,$ligne,205,$ligne+5);
  $pdf->Line(3,$ligne+5,205,$ligne+5);


//sortie promotions
				$req = mysql_query("SELECT COUNT(*) as cpt FROM bon_de_sortie_pro"); 
				$row = mysql_fetch_array($req); 
				$nb = $row['cpt']; 
				if ($nb>0){

$ligne=$ligne+20;$pdf->SetY($ligne);$pdf->SetX(10);
$pdf->Cell(30,9,'Promotions',0,0,'L',1);
$ligne=$ligne+8;
		$sql  = "SELECT * ";
		$sql .= "FROM produits order by produit ;";
		$user1 = db_query($database_name, $sql);
	while($users11_ = fetch_array($user1)) { 
		$produit=$users11_["produit"];$condit=$users11_["condit"];$qte1=0;

	$sql1  = "SELECT * ";
	$sql1 .= "FROM bon_de_sortie_pro where produit='$produit' and commande='$id_registre' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { 
		$qte1=$qte1+$users1_["quantite"];
	}	
		if ($qte1>0){
   $pdf->SetY($ligne);$pdf->SetX(4);
	$pdf->Cell(50,9,$produit,0,0,'L',1);$pdf->SetX(90);
	$pdf->Cell(10,9,$qte1,0,0,'L',1);$pdf->SetX(100);
	$pdf->Cell(10,9,' X ',0,0,'L',1);$pdf->SetX(112);
	$pdf->Cell(20,9,$condit,0,0,'L',1);$pdf->SetX(130);
	$pdf->Cell(30,9,$qte1*$condit,0,0,'L',1);
			$ligne=$ligne+7;
		 }
  } 
  
///////////////////////////

	

}
$pdf->line(3, $ligne+5, 205, $ligne+5);

$pdf->SetY($ligne+6);
$pdf->SetX(180);
$pdf->Cell(50,9,$m,0,0,'L',1);
$pdf->Output();
}
$sql = "TRUNCATE TABLE `bon_de_sortie`  ;";
			db_query($database_name, $sql);
			$sql = "TRUNCATE TABLE `bon_de_sortie_pro`  ;";
			db_query($database_name, $sql);
			
