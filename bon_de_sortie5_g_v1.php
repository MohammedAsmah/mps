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
		$montant1=number_format($montant,2,',',' ');
		$vendeur=$_GET['vendeur'];$date1=dateUsToFr($_GET['date']);$service=$_GET['service'];
			
			$sql = "TRUNCATE TABLE `bon_de_sortie`  ;";
			db_query($database_name, $sql);
			$sql = "TRUNCATE TABLE `bon_de_sortie_pro`  ;";
			db_query($database_name, $sql);

			////////////////controle 
			$req = mysql_query("SELECT COUNT(*) as cpt1 FROM bon_de_sortie"); 
				$row = mysql_fetch_array($req); 
				$nb1 = $row['cpt1']; 
				if ($nb1>0){}else{
			
			
			
			
		$sql  = "SELECT * ";
		$sql .= "FROM commandes WHERE id_registre = " . $id_registre . ";";
		$user = db_query($database_name, $sql); 

		while($user_ = fetch_array($user)) { 
		$date = dateUsToFr($user_["date_e"]);$date_sortie=$user_["date_e"];
		$client = $user_["client"];$montant_f = $user_["net"];$numero = $user_["commande"];
		$vendeur = $user_["vendeur"];$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];
		$evaluation = $user_["evaluation"];$sans_remise = $user_["sans_remise"];$remise3 = $user_["remise_3"];

	
	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_commandes where commande='$numero' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { 
		$produit=$users1_["produit"]; $id=$users1_["id"];$quantite=$users1_["quantite"];$condit=$users1_["condit"];$prix=$users1_["prix_unit"];
		
				$prix=$prix*(1-$remise10/100);
				$prix=$prix*(1-$remise2/100);
				$prix=$prix*(1-$remise3/100);
				$sql  = "INSERT INTO bon_de_sortie ( commande, produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $quantite . "', ";
				$sql .= "'" . $prix . "', ";
				$sql .= "'" . $condit . "');";

				db_query($database_name, $sql);
		
		
		/////promotion
				
				
				$sql1p  = "SELECT * ";
				$sql1p .= "FROM liste_promotions where article='$produit' and date_fin>='$date_sortie' and base<=$quantite ORDER BY base DESC;";
				$users11pp = db_query($database_name, $sql1p);$trouve=0;
				while($users11_pp = fetch_array($users11pp)) { 
					if ($trouve==0){
					$base=$users11_pp["base"];
					$promotion=$users11_pp["promotion"];
					$date_pp=$users11_pp["date"];
				if ($base>0){$trouve=1;
				@$taux=intval($quantite/$base);
				$promotion=$promotion*$taux;
				$sql  = "INSERT INTO bon_de_sortie_pro ( commande, produit, quantite,condit ) VALUES ( ";
				$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $promotion . "', ";
				$sql .= "'" . $condit . "');";

				db_query($database_name, $sql);

				} 
				}
				
				}
				
				}
		
		
		
	}
	
	////fincontrole
	}

//Create new pdf file
$pdf=new FPDF('P','mm','A4');

//Disable automatic page break
$pdf->SetAutoPageBreak(false);

//Add first page
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 25;$y_axis = 25;$row_height=6;$l=25;

//print column titles for the actual page
$pdf->SetFillColor(195);
$pdf->SetY(5);
$pdf->SetFont('arial','B',18);
$pdf->Cell(60,14,'   Bon de Sortie',1,0,'L',1);

$pdf->SetFillColor(255);
$pdf->SetFont('arial','B',14);
$pdf->SetX(130);$d="Marrakech le : ".$date1;
$pdf->Cell(25,10,$d,0,0,'L',1);

$pdf->SetFont('Courier','',12);
$pdf->SetY(20);$pdf->SetX(10);$d="Vendeur : ".$vendeur;
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetY(15);$pdf->SetX(100);$d="Destination : ".$service;
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetY(30);$pdf->SetX(10);$d="Client : ".$c;
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetY(35);$pdf->SetX(90);$d="Numero :  ".$bon_sortie;
$pdf->Cell(30,10,$d,0,0,'L',1);

$pdf->SetY(35);$pdf->SetX(145);$d="Montant : ".$montant1;
$pdf->Cell(30,10,$d,0,0,'L',1);
$pdf->SetLineWidth(0.3);
$pdf->Line(3,3,205,3);
$pdf->Line(3,47,205,47);
$pdf->Line(3,60,205,60);
$pdf->Line(3,3,3,60);
$pdf->Line(205,3,205,60);


$pdf->SetY(48);$pdf->SetX(7);$d="  Designation Article  ";
$pdf->Cell(50,9,$d,0,0,'L',1);

$pdf->SetX(87);$d="C.M C.A ";
$pdf->Cell(10,9,$d,0,0,'L',1);

$pdf->SetY(48);$pdf->SetX(109);$d="Nbr Paquets ";
$pdf->Cell(30,9,$d,0,0,'L',1);
$pdf->SetY(48);$pdf->SetX(136);$d="  Quantite  ";
$pdf->Cell(30,9,$d,0,0,'L',1);
$pdf->SetY(48);$pdf->SetX(170);$d=" Observation  ";
$pdf->Cell(30,9,$d,0,0,'L',1);$ligne=47;
$pdf->Line(87,$ligne,87,$ligne+18);
$pdf->Line(97,$ligne,97,$ligne+18);
	$pdf->Line(108,$ligne,108,$ligne+18);
	$pdf->Line(141,$ligne,141,$ligne+18);
$pdf->Line(164,$ligne,164,$ligne+18);


$ligne=65;$pdf->Line(3,60,3,65);$pdf->Line(205,60,205,65);
	
	
		$sql  = "SELECT commande,produit,condit,prix_unit,sum(quantite) as qte ";
		$sql .= "FROM bon_de_sortie where commande='$id_registre' GROUP BY produit;";
		$user1 = db_query($database_name, $sql);
		
		$total=0;
		
		
	while($users11_ = fetch_array($user1)) { 
		$produit=$users11_["produit"];$condit=$users11_["condit"];$qte=$users11_["qte"];$prix=$users11_["prix_unit"];
		$total=$total+($qte*$condit*$prix);
		
		if ($ligne<=260){
		
		if ($qte>0){$pdf->SetY($ligne);$pdf->SetX(5);
	$pdf->Cell(50,6,$produit,0,0,'L',1);$pdf->SetX(89);
	$pdf->Cell(10,6,'--  --',0,0,'L',1);$pdf->SetX(112);
	$pdf->Cell(10,6,$qte,0,0,'L',1);$pdf->SetX(125);
	$pdf->Cell(10,6,' X ',0,0,'L',1);$pdf->SetX(132);
	$pdf->Cell(20,6,$condit,0,0,'L',1);$pdf->SetX(150);
	$pdf->Cell(30,6,$qte*$condit,0,0,'L',1);
	
	$pdf->Line(3,$ligne,3,$ligne+5);
	$pdf->Line(87,$ligne,87,$ligne+5);
	$pdf->Line(97,$ligne,97,$ligne+5);
	$pdf->Line(108,$ligne,108,$ligne+5);
	$pdf->Line(141,$ligne,141,$ligne+5);
	$pdf->Line(164,$ligne,164,$ligne+5);
	
	$pdf->Line(205,$ligne,205,$ligne+5);
	
		
			$ligne=$ligne+5;
		 }
		 }
		 
		 else{
		 $pdf->Line(3,$ligne,3,$ligne+5);
	$pdf->Line(87,$ligne,87,$ligne+5);
	$pdf->Line(97,$ligne,97,$ligne+5);
	$pdf->Line(108,$ligne,108,$ligne+5);
	$pdf->Line(141,$ligne,141,$ligne+5);
	$pdf->Line(164,$ligne,164,$ligne+5);
	
	$pdf->Line(205,$ligne,205,$ligne+5);
	
		 $pdf->line(3, $ligne+5, 205, $ligne+5);

$pdf->SetY($ligne+14);$pdf->SetX(10);
	$pdf->Cell(50,9,'Magasinier',0,0,'L',1);
$pdf->SetX(90);
	$pdf->Cell(50,9,'Controle',0,0,'L',1);
$pdf->SetX(160);
	$pdf->Cell(50,9,'Visa',0,0,'L',1);
	
		 //nouvelle page
		 //Add first page
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 25;$y_axis = 25;$row_height=6;$l=25;

//print column titles for the actual page
$pdf->SetFillColor(195);
$pdf->SetY(5);
$pdf->SetFont('arial','B',18);
$pdf->Cell(60,14,'   Bon de Sortie',1,0,'L',1);

$pdf->SetFillColor(255);
$pdf->SetFont('arial','B',14);
$pdf->SetX(130);$d="Marrakech le : ".$date1;
$pdf->Cell(25,10,$d,0,0,'L',1);

$pdf->SetFont('Courier','',12);
$pdf->SetY(20);$pdf->SetX(10);$d="Vendeur : ".$vendeur;
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetY(15);$pdf->SetX(100);$d="Destination : ".$service;
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetY(30);$pdf->SetX(10);$d="Client : ".$c;
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetY(35);$pdf->SetX(90);$d="Numero :  ".$bon_sortie;
$pdf->Cell(30,10,$d,0,0,'L',1);

$pdf->SetY(35);$pdf->SetX(145);$d="Montant : ".$montant;
$pdf->Cell(30,10,$d,0,0,'L',1);
$pdf->SetLineWidth(0.3);
$pdf->Line(3,3,205,3);
$pdf->Line(3,47,205,47);
$pdf->Line(3,60,205,60);
$pdf->Line(3,3,3,60);
$pdf->Line(205,3,205,60);


$pdf->SetY(48);$pdf->SetX(7);$d="  Designation Article  ";
$pdf->Cell(50,9,$d,0,0,'L',1);

$pdf->SetX(87);$d="C.M C.A ";
$pdf->Cell(10,9,$d,0,0,'L',1);

$pdf->SetY(48);$pdf->SetX(109);$d="Nbr Paquets ";
$pdf->Cell(30,9,$d,0,0,'L',1);
$pdf->SetY(48);$pdf->SetX(136);$d="  Quantite  ";
$pdf->Cell(30,9,$d,0,0,'L',1);
$pdf->SetY(48);$pdf->SetX(170);$d=" Observation  ";
$pdf->Cell(30,9,$d,0,0,'L',1);$ligne=47;
$pdf->Line(87,$ligne,87,$ligne+18);
$pdf->Line(97,$ligne,97,$ligne+18);
	$pdf->Line(108,$ligne,108,$ligne+18);
	$pdf->Line(141,$ligne,141,$ligne+18);
$pdf->Line(164,$ligne,164,$ligne+18);


$ligne=65;$pdf->Line(3,60,3,65);$pdf->Line(205,60,205,65);


if ($qte>0){$pdf->SetY($ligne);$pdf->SetX(5);
	$pdf->Cell(50,6,$produit,0,0,'L',1);$pdf->SetX(89);
	$pdf->Cell(10,6,'--  --',0,0,'L',1);$pdf->SetX(112);
	$pdf->Cell(10,6,$qte,0,0,'L',1);$pdf->SetX(125);
	$pdf->Cell(10,6,' X ',0,0,'L',1);$pdf->SetX(132);
	$pdf->Cell(20,6,$condit,0,0,'L',1);$pdf->SetX(150);
	$pdf->Cell(30,6,$qte*$condit,0,0,'L',1);
	
	$pdf->Line(3,$ligne,3,$ligne+5);
	$pdf->Line(87,$ligne,87,$ligne+5);
	$pdf->Line(97,$ligne,97,$ligne+5);
	$pdf->Line(108,$ligne,108,$ligne+5);
	$pdf->Line(141,$ligne,141,$ligne+5);
	$pdf->Line(164,$ligne,164,$ligne+5);
	
	$pdf->Line(205,$ligne,205,$ligne+5);
	
		
			$ligne=$ligne+5;
		 }
	
		 }
		 
  } 
  
  $pdf->Line(3,$ligne,3,$ligne+5);
  $pdf->Line(87,$ligne,87,$ligne+5);
	$pdf->Line(97,$ligne,97,$ligne+5);
	$pdf->Line(108,$ligne,108,$ligne+5);
		$pdf->Line(141,$ligne,141,$ligne+5);
			$pdf->Line(164,$ligne,164,$ligne+5);
  $pdf->Line(205,$ligne,205,$ligne+5);
  $pdf->Line(3,$ligne+5,205,$ligne+5);


//sortie promotions
				$req = mysql_query("SELECT COUNT(*) as cpt FROM bon_de_sortie_pro"); 
				$row = mysql_fetch_array($req); 
				$nb = $row['cpt']; 
				if ($nb>0){

$ligne=$ligne+20;$pdf->SetY($ligne);$pdf->SetX(10);$pdf->SetFont('arial','B',14);
$pdf->Cell(30,11,'Promotions',0,0,'L',1);$pdf->SetFont('arial','',10);
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
   $pdf->SetY($ligne);$pdf->SetX(10);
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

$pdf->SetY($ligne+14);$pdf->SetX(10);
	$pdf->Cell(50,9,'Magasinier',0,0,'L',1);
$pdf->SetX(90);
	$pdf->Cell(50,9,'Controle',0,0,'L',1);
$pdf->SetX(160);
	$pdf->Cell(50,9,'Visa',0,0,'L',1);
$pdf->SetY($ligne+5);$pdf->SetX(160);
	$pdf->Cell(50,9,$total,0,0,'L',1);	
	
if ($total-$montant>10)
	{$pdf->line(3, $ligne+5, 205, 5);
	$pdf->line(5, $ligne+5, 205, 5);}

	// envoi du fichier au navigateur */
//Create file
$pdf->Output();
