<?php

require('fpdf.php');
	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];$qte_tige1=0;
				$sql = "TRUNCATE TABLE `fiche_stock_f_mp`  ;";
			db_query($database_name, $sql);

		$action_ = "update_user";
		
		$stock_initial = $_REQUEST["stock_initial"];$matiere = $_REQUEST["matiere"];
		$stock_initial_pf = $_REQUEST["stock_initial_pf"];
		$stock_final_pf = $_REQUEST["stock_final_pf"];
		
		$sql  = "SELECT * ";$vide="";
		$sql .= "FROM types_emballages1 where profile_id='$user_id' ORDER BY profile_name;";
		$users = db_query($database_name, $sql);$user_ = fetch_array($users);$matiere = $user_["profile_name"];
		
		
		
			
			$ref="Stock initial matiere premiere au 01/01";$date_ini="2015-01-01";$t1=1;
				$sql  = "INSERT INTO fiche_stock_f_mp ( produit, date, entree,ref,type ) VALUES ( ";
				$sql .= "'" . $matiere . "', ";
				$sql .= "'" . $date_ini . "', ";
				$sql .= "'" . $stock_initial . "', ";
				$sql .= "'" . $ref . "', ";
				$sql .= $t1 . ");";

				db_query($database_name, $sql);
				
			$ref="Stock initial / produits finis au 01/01";$date_ini="2015-01-01";$t1=1;
				$sql  = "INSERT INTO fiche_stock_f_mp ( produit, date, entree,ref,type ) VALUES ( ";
				$sql .= "'" . $matiere . "', ";
				$sql .= "'" . $date_ini . "', ";
				$sql .= "'" . $stock_initial_pf . "', ";
				$sql .= "'" . $ref . "', ";
				$sql .= $t1 . ");";

				db_query($database_name, $sql);

			
				
			
			$sql1  = "SELECT * ";$du="2015-01-01";$au=dateFrToUs("31/12/2015");$du_au="2015-12-31";
			$sql1 .= "FROM achats_mat where produit='$matiere' and date between '$du' and '$du_au' ORDER BY produit;";
			$users11 = db_query($database_name, $sql1);
			while($users11_ = fetch_array($users11)) { 
			
			$qte=$users11_["qte"];$date=$users11_["date"];
			$ref="Entree stock / ".$users11_["ref"];$t1=1;
				$sql  = "INSERT INTO fiche_stock_f_mp ( produit, date, entree,ref,type ) VALUES ( ";
				$sql .= "'" . $matiere . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $qte . "', ";
				$sql .= "'" . $ref . "', ";
				$sql .= $t1 . ");";

				db_query($database_name, $sql);

			}

			$sql1  = "SELECT * ";$qte_vendu=0;$du="2015-01-01";$au=dateFrToUs("31/12/2015");
			$sql1 .= "FROM details_factures_mp where libelle='$matiere' and (date_facture between '$du' and '$du_au' ) ORDER BY date_facture;";
			$users112 = db_query($database_name, $sql1);
			while($users11_2 = fetch_array($users112)) { 
			$numero=$users11_2["numero_facture"];$qte_vendu=$users11_2["quantite"];$type_matiere=$users11_2["type"];
			if ($type_matiere=="sachets"){$qte_vendu=$qte_vendu/1000;}
			if ($type_matiere=="matiere"){$qte_vendu=$qte_vendu/1000;}
			$date=$users11_2["date_facture"];$ref="Sortie stock / F $numero";$t2=2;
				$sql  = "INSERT INTO fiche_stock_f_mp ( produit, date, sortie,ref,type ) VALUES ( ";
				$sql .= "'" . $matiere . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $qte_vendu . "', ";
				$sql .= "'" . $ref . "', ";
				$sql .= $t2 . ");";

				db_query($database_name, $sql);

			}
			
			$ref="Stock final / produits finis au 31/12";$date_ini="2015-12-31";$t2=2;
				$sql  = "INSERT INTO fiche_stock_f_mp ( produit, date, sortie,ref,type ) VALUES ( ";
				$sql .= "'" . $matiere . "', ";
				$sql .= "'" . $date_ini . "', ";
				$sql .= "'" . $stock_final_pf . "', ";
				$sql .= "'" . $ref . "', ";
				$sql .= $t2 . ");";

				db_query($database_name, $sql);				
				
	
	

	
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
$pdf->Cell(60,14,'   Fiche de stock : '.$matiere,0,0,'L',0);

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
	
		$sql1  = "SELECT * ";$du="2015-01-01";$au=dateFrToUs(date("d/m/y"));$compteur=0;
			$sql1 .= "FROM fiche_stock_f_mp where produit='$matiere' ORDER BY date,type;";
		$users113 = db_query($database_name, $sql1);$e=0;$s=0;$stock=0;
			while($users11_3 = fetch_array($users113)) { 
			$date=dateUsToFr($users11_3["date"]);$ref=$users11_3["ref"];$entree=$users11_3["entree"];$sortie=$users11_3["sortie"];
			$type=$users11_3["type"];$prix_unit=$users11_3["prix_unit"];$entree_f=number_format($entree,3,',',' ');$sortie_f=number_format($sortie,3,',',' ');
			$stock=$stock+$entree-$sortie;
		
		if ($compteur<50){}		 else{$repport = number_format($stock,3,',',' ');

	$pdf->Line(3,$ligne,3,$ligne+5);
	$pdf->Line(28,$ligne,28,$ligne+5);
	$pdf->Line(115,$ligne,115,$ligne+5);
	$pdf->Line(144,$ligne,144,$ligne+5);
	$pdf->Line(174,$ligne,174,$ligne+5);
$pdf->Line(3,$ligne+5,205,$ligne+5);
		 
//Add first page
$pdf->AddPage();$compteur=0;

//set initial y axis position per page
$y_axis_initial = 25;$y_axis = 25;$row_height=6;$l=25;

//print column titles for the actual page
$pdf->SetFillColor(255);
$pdf->SetY(5);
$pdf->SetFont('arial','B',14);
//$pdf->Cell(60,14,'   Fiche de stock : '.$matiere.' repport : '.$repport,0,0,'L',0);
$pdf->Cell(60,14,'   Fiche de stock : '.$matiere,0,0,'L',0);
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

	
		 }


		
		
	$pdf->SetY($ligne);$pdf->SetX(5);
	$pdf->Cell(20,6,$date,0,0,'L',1);$pdf->SetX(30);
	$pdf->Cell(80,6,$ref,0,0,'L',1);$pdf->SetX(112);
	if ($type==1){
	$pdf->Cell(20,6,$entree_f,0,0,'R',1);$pdf->SetX(142);
	$pdf->Cell(20,6,'',0,0,'R',1);$pdf->SetX(175);
	}
	else
	{
	$pdf->Cell(20,6,'',0,0,'R',1);$pdf->SetX(142);
	$pdf->Cell(20,6,$sortie_f,0,0,'R',1);$pdf->SetX(175);
	}
	//$e=$e+$entree;$s=$s+$sortie;
	//$stock=$e-$s;
	$stock_f=number_format($stock,3,',',' ');
	$pdf->Cell(20,6,$stock_f,0,0,'R',1);
	
	
	$pdf->Line(3,$ligne,3,$ligne+5);
	$pdf->Line(28,$ligne,28,$ligne+5);
	$pdf->Line(115,$ligne,115,$ligne+5);
	$pdf->Line(144,$ligne,144,$ligne+5);
	$pdf->Line(174,$ligne,174,$ligne+5);
	
	
		
			$ligne=$ligne+5;
			$compteur=$compteur+1;
		
		 

		 
		 $e=$e+$entree;$s=$s+$sortie;
  }
$pdf->Line(3,$ligne,3,$ligne+5);
	$pdf->Line(28,$ligne,28,$ligne+5);
	$pdf->Line(115,$ligne,115,$ligne+5);
	$pdf->Line(144,$ligne,144,$ligne+5);
	$pdf->Line(174,$ligne,174,$ligne+5);
$pdf->Line(3,$ligne+5,205,$ligne+5);
  
  $pdf->SetY($ligne+10);$pdf->SetX(112);
  $pdf->Cell(20,6,$e,0,0,'R',1);$pdf->SetX(142);
  $pdf->Cell(20,6,$s,0,0,'R',1);$pdf->SetX(175);
  
//Create file
$pdf->Output();
