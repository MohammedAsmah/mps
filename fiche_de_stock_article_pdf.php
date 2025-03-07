<?php

require('fpdf.php');
	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];$qte_tige1=0;
				$sql = "TRUNCATE TABLE `fiche_stock_f`  ;";
			db_query($database_name, $sql);

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$non_disponible=$user_["non_disponible"];$seuil_critique=$user_["seuil_critique"];
		$accessoire_1=$user_["accessoire_1"];$qte_ac_1=$user_["qte_ac_1"];
		$accessoire_2=$user_["accessoire_2"];$qte_ac_2=$user_["qte_ac_2"];
		$accessoire_3=$user_["accessoire_3"];$qte_ac_3=$user_["qte_ac_3"];

		$liquider=$user_["liquider"];

		$title = "details";$poids_evaluation=$user_["poids_evaluation"];
		$stock_ini_exe = $user_["stock_ini_exe"];$type = $user_["type"];$stock_controle = $user_["stock_controle"];
		$produit = $user_["produit"];$colorant = $user_["colorant"];$dispo = $user_["dispo"];$production=0;$production1 = $user_["production"];
		$condit = $user_["condit"];$qte_colorant=$user_["qte_colorant"];$prix_revient_final = $user_["prix_revient_final"];$en_cours_final = $user_["en_cours_final"];
		$prix = $user_["prix"];$favoris = $user_["favoris"];$non_favoris = $user_["non_favoris"];$encours = $user_["encours"];
		$poids = $user_["poids"];$stock_initial = $user_["stock_ini_exe"];$stock_final = $user_["stock_final"];$prix_revient = $user_["prix_revient"];
		$emballage2=$user_["emballage2"];$qte_emballage2=$user_["qte_emballage2"];
		$emballage3=$user_["emballage3"];$qte_emballage3=$user_["qte_emballage3"];		
		$tige=$user_["tige"];$qte_tige=$user_["qte_tige"];$emballage=$user_["emballage"];$qte_emballage=$user_["qte_emballage"];
		$matiere=$user_["matiere"];$qte_matiere=$user_["qte_matiere"];$etiquette=$user_["etiquette"];$qte_etiquette=$user_["qte_etiquette"];
			
			$ref="Stock initial au 01/01";$date_ini="2019-01-01";$t1=1;
				$sql  = "INSERT INTO fiche_stock_f ( produit, date, entree,ref,type ) VALUES ( ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $date_ini . "', ";
				$sql .= "'" . $stock_initial . "', ";
				$sql .= "'" . $ref . "', ";
				$sql .= $t1 . ");";

				db_query($database_name, $sql);
			
			$sql1  = "SELECT * ";$du="2019-01-01";$au=dateFrToUs("31/12/2019");
			$sql1 .= "FROM entrees_stock_f where produit='$produit' and (date between '$du' and '$au' ) ORDER BY produit;";
			$users11 = db_query($database_name, $sql1);
			while($users11_ = fetch_array($users11)) { 
			
			$production=$production+($users11_["depot_a"]*$condit);$qte=$users11_["depot_a"]*$condit;$date=$users11_["date"];
			$ref="Entree stock";$t1=1;
				$sql  = "INSERT INTO fiche_stock_f ( produit, date, entree,ref,type ) VALUES ( ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $qte . "', ";
				$sql .= "'" . $ref . "', ";
				$sql .= $t1 . ");";

				db_query($database_name, $sql);

			}

			$sql1  = "SELECT * ";$qte_vendu=0;$du="2019-01-01";$au=dateFrToUs("31/12/2019");
			$sql1 .= "FROM detail_factures2019 where produit='$produit' and (date_f between '$du' and '$au' ) ORDER BY produit;";
			$users11 = db_query($database_name, $sql1);
			while($users11_ = fetch_array($users11)) { 
			$qte_vendu=$qte_vendu+($users11_["quantite"]*$users11_["condit"]);$numero=$users11_["facture"];$prix_unit=$users11_["prix_unit"];
			$qte=$users11_["quantite"]*$users11_["condit"];$date=$users11_["date_f"];$ref="Sortie stock / F $numero";$t2=2;
				$sql  = "INSERT INTO fiche_stock_f ( produit, date, sortie,prix_unit,ref,type ) VALUES ( ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $qte . "', ";$sql .= "'" . $prix_unit . "', ";
				$sql .= "'" . $ref . "', ";
				$sql .= $t2 . ");";

				db_query($database_name, $sql);

			}
			$stock_final=$stock_initial+$production-$qte_vendu;
	

	
//Create new pdf file
$pdf=new FPDF('P','mm','A4');

//Disable automatic page break
$pdf->SetAutoPageBreak(false);

//Add first page
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 25;$y_axis = 25;$row_height=6;$l=25;

//print column titles for the actual page
$pdf->SetFillColor(255);
$pdf->SetY(5);
$pdf->SetFont('arial','B',14);
$pdf->Cell(60,14,'   Fiche de stock : '.$produit,0,0,'L',0);

$pdf->SetLineWidth(0.3);
$pdf->Line(3,3,205,3);
//$pdf->Line(3,8,205,8);
$pdf->Line(3,3,3,290);
//$pdf->Line(3,3,3,60);
$pdf->Line(205,3,205,290);

$pdf->SetFont('arial','',10);
$pdf->SetY(15);$pdf->SetX(7);$d="  Date  ";
$pdf->Cell(15,9,$d,0,0,'L',1);

$pdf->SetX(30);$d="DESIGNATION ";
$pdf->Cell(80,9,$d,0,0,'L',1);

$pdf->SetY(15);$pdf->SetX(120);$d="ENTREE ";
$pdf->Cell(30,9,$d,0,0,'L',1);
$pdf->SetY(15);$pdf->SetX(145);$d=" SORTIE ";
$pdf->Cell(30,9,$d,0,0,'L',1);
$pdf->SetY(15);$pdf->SetX(175);$d=" STOCK  ";
$pdf->Cell(30,9,$d,0,0,'L',1);
$pdf->Line(3,17,205,17);
$ligne=17;
	$pdf->Line(3,$ligne,3,$ligne+7);
	$pdf->Line(28,$ligne,28,$ligne+7);
	$pdf->Line(115,$ligne,115,$ligne+7);
	$pdf->Line(144,$ligne,144,$ligne+7);
	$pdf->Line(174,$ligne,174,$ligne+7);
$pdf->Line(3,$ligne+7,205,$ligne+7);

$ligne=25;$pdf->Line(3,60,3,65);$pdf->Line(205,60,205,65);
$pdf->SetFont('arial','',12);	
	
		$sql1  = "SELECT * ";$du="2019-01-01";$au=dateFrToUs(date("d/m/y"));
			$sql1 .= "FROM fiche_stock_f where produit='$produit' ORDER BY date,type;";
		$users11 = db_query($database_name, $sql1);$e=0;$s=0;
			while($users11_ = fetch_array($users11)) { 
			$date=dateUsToFr($users11_["date"]);$ref=$users11_["ref"];$entree=$users11_["entree"];$sortie=$users11_["sortie"];
			$type=$users11_["type"];$prix_unit=$users11_["prix_unit"];
			
		
		if ($ligne<=280){
		
	$pdf->SetY($ligne);$pdf->SetX(5);
	$pdf->Cell(20,6,$date,0,0,'L',1);$pdf->SetX(30);
	$pdf->Cell(80,6,$ref,0,0,'L',1);$pdf->SetX(112);
	if ($type==1){
	$pdf->Cell(20,6,$entree,0,0,'R',1);$pdf->SetX(142);
	$pdf->Cell(20,6,'',0,0,'R',1);$pdf->SetX(172);
	}
	else
	{
	$pdf->Cell(20,6,'',0,0,'R',1);$pdf->SetX(142);
	$pdf->Cell(20,6,$sortie,0,0,'R',1);$pdf->SetX(172);
	}
	$e=$e+$entree;$s=$s+$sortie;$stock=$e-$s;
	$pdf->Cell(20,6,$stock,0,0,'R',1);
	
	
	$pdf->Line(3,$ligne,3,$ligne+5);
	$pdf->Line(28,$ligne,28,$ligne+5);
	$pdf->Line(115,$ligne,115,$ligne+5);
	$pdf->Line(144,$ligne,144,$ligne+5);
	$pdf->Line(174,$ligne,174,$ligne+5);
	
	
		
			$ligne=$ligne+5;
		
		 }
		 
		 else{

	$pdf->Line(3,$ligne,3,$ligne+5);
	$pdf->Line(28,$ligne,28,$ligne+5);
	$pdf->Line(115,$ligne,115,$ligne+5);
	$pdf->Line(144,$ligne,144,$ligne+5);
	$pdf->Line(174,$ligne,174,$ligne+5);
$pdf->Line(3,$ligne+5,205,$ligne+5);
		 
//Add first page
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 25;$y_axis = 25;$row_height=6;$l=25;

//print column titles for the actual page
$pdf->SetFillColor(255);
$pdf->SetY(5);
$pdf->SetFont('arial','B',14);
$pdf->Cell(60,14,'   Fiche de stock : '.$produit,0,0,'L',0);

$pdf->SetLineWidth(0.3);
$pdf->Line(3,3,205,3);
//$pdf->Line(3,8,205,8);
$pdf->Line(3,3,3,290);
//$pdf->Line(3,3,3,60);
$pdf->Line(205,3,205,290);

$pdf->SetFont('arial','',10);
$pdf->SetY(15);$pdf->SetX(7);$d="  Date  ";
$pdf->Cell(15,9,$d,0,0,'L',1);

$pdf->SetX(30);$d="DESIGNATION ";
$pdf->Cell(80,9,$d,0,0,'L',1);

$pdf->SetY(15);$pdf->SetX(120);$d="ENTREE ";
$pdf->Cell(30,9,$d,0,0,'L',1);
$pdf->SetY(15);$pdf->SetX(145);$d=" SORTIE ";
$pdf->Cell(30,9,$d,0,0,'L',1);
$pdf->SetY(15);$pdf->SetX(175);$d=" STOCK  ";
$pdf->Cell(30,9,$d,0,0,'L',1);
$pdf->Line(3,17,205,17);
$ligne=17;
	$pdf->Line(3,$ligne,3,$ligne+7);
	$pdf->Line(28,$ligne,28,$ligne+7);
	$pdf->Line(115,$ligne,115,$ligne+7);
	$pdf->Line(144,$ligne,144,$ligne+7);
	$pdf->Line(174,$ligne,174,$ligne+7);
$pdf->Line(3,$ligne+7,205,$ligne+7);

$ligne=25;$pdf->Line(3,60,3,65);$pdf->Line(205,60,205,65);
$pdf->SetFont('arial','',12);	

$e=$e+$entree;$s=$s+$sortie;$stock=$e-$s;

		 }
		 
  }
$pdf->Line(3,$ligne,3,$ligne+5);
	$pdf->Line(28,$ligne,28,$ligne+5);
	$pdf->Line(115,$ligne,115,$ligne+5);
	$pdf->Line(144,$ligne,144,$ligne+5);
	$pdf->Line(174,$ligne,174,$ligne+5);
$pdf->Line(3,$ligne+5,205,$ligne+5);
  
//Create file
$pdf->Output();
