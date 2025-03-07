<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	require "fpdf.php";
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	
	$du=$_GET['du'];$date1=$_GET['date1'];$date=dateUsToFr($_GET['date1']);
	$sql  = "SELECT * ";$vide="";$article="article";
	$sql .= "FROM produits where dispo=1 and produit<>'$vide' and famille='$article' ORDER BY produit;";
	$users = db_query($database_name, $sql);


//Create new pdf file
$pdf=new FPDF('P','mm','A4');

//Disable automatic page break
$pdf->SetAutoPageBreak(false);

//Add first page
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 25;$y_axis = 25;$row_height=6;$l=25;

//print column titles for the actual page
$pdf->SetFillColor(255);$entete=5;
$pdf->SetY(1);
$pdf->SetFont('arial','B',12);$pdf->SetX(5);$titre="Etat de Stock Au : ".$date;
$pdf->Cell(70,12,$titre,0,0,'L',0);

$pdf->SetLineWidth(0.2);
$pdf->Line(3,11,205,11);
/*$pdf->Line(3,16,205,16);*/
$pdf->Line(3,11,3,17);
$pdf->Line(117,11,117,17);
$pdf->Line(155,11,155,17);
$pdf->Line(179,11,179,17);
$pdf->Line(205,11,205,17);


$pdf->SetFont('arial','',10);
$pdf->SetY(12);$pdf->SetX(20);$d="  Designation Article  ";
$pdf->Cell(50,8,$d,0,0,'L',1);
$pdf->SetY(12);$pdf->SetX(124);$d="  MPS  ";
$pdf->Cell(20,8,$d,0,0,'L',1);
$pdf->SetY(12);$pdf->SetX(157);$d="  JAOUDA ";
$pdf->Cell(20,8,$d,0,0,'L',1);
$pdf->SetY(12);$pdf->SetX(180);$d="  Total  ";
$pdf->Cell(20,8,$d,0,0,'L',1);
$pdf->SetFont('arial','',8);
$ligne=17;


	while($users_ = fetch_array($users)) { 

			$id=$users_["id"];$produit=$users_["produit"];$stock_controle=$users_["stock_controle"];$seuil_critique=$users_["seuil_critique"];
			$type=$users_["type"];

			//entrees
			$sql1  = "SELECT produit,date,sum(depot_a) As total_depot_a,sum(depot_b) As total_depot_b,sum(depot_c) As total_depot_c ";
			$du="2009-01-01";$au=dateFrToUs(date("d/m/y"));
			$sql1 .= "FROM entrees_stock where produit='$produit' and (date between '$du' and '$date1' ) group BY produit;";
			$users11 = db_query($database_name, $sql1);$users1 = fetch_array($users11);
			$e_depot_a = $users1["total_depot_a"];$e_depot_b = $users1["total_depot_b"];$e_depot_c = $users1["total_depot_c"];
			
			//sorties
			$sql1  = "SELECT produit,date,sum(depot_a) As total_depot_a,sum(depot_b) As total_depot_b,sum(depot_c) As total_depot_c ";
			$du="2009-01-01";$au=dateFrToUs(date("d/m/y"));
			$sql1 .= "FROM bon_de_sortie_magasin where produit='$produit' and (date between '$du' and '$date1' ) group BY produit;";
			$users111 = db_query($database_name, $sql1);$users2 = fetch_array($users111);
			$s_depot_a = $users2["total_depot_a"];$s_depot_b = $users2["total_depot_b"];$s_depot_c = $users2["total_depot_c"];
			$mps=$e_depot_a-$s_depot_a;$jaouda=$e_depot_b-$s_depot_b;
		
			$sql1  = "SELECT produit,date,sum(depot_a) As total_depot_a,sum(depot_b) As total_depot_b,sum(depot_c) As total_depot_c ";
			$du="2009-01-01";$au=dateFrToUs(date("d/m/y"));
			$sql1 .= "FROM bon_de_sortie_magasin where produit='$produit' and (date between '$du' and '$date1' ) group BY date order BY date DESC;";
			$users1111 = db_query($database_name, $sql1);$users22 = fetch_array($users1111);
			$last_out = $users22["total_depot_a"]+$users22["total_depot_b"]+$users22["total_depot_c"];
			$last_date = dateUsToFr($users22["date"]);
			
		
		
		
		
		if ($ligne>=280){$pdf->Line(3,$ligne,205,$ligne);
$pdf->SetFont('Courier','',10);$pdf->SetY($ligne+2);
$pdf->SetX(130);$d="A repporter";
$pdf->Cell(40,10,$d,0,0,'L',1);

//Add first page 
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 25;$y_axis = 25;$row_height=6;$l=25;

//print column titles for the actual page
$pdf->SetFillColor(255);$entete=5;
$pdf->SetY(1);
$pdf->SetFont('arial','B',12);$pdf->SetX(5);$titre="Etat de Stock Au : ".$date;
$pdf->Cell(70,12,$titre,0,0,'L',0);

$pdf->SetLineWidth(0.2);
$pdf->Line(3,11,205,11);
/*$pdf->Line(3,16,205,16);*/
$pdf->Line(3,11,3,17);
$pdf->Line(117,11,117,17);
$pdf->Line(155,11,155,17);
$pdf->Line(179,11,179,17);
$pdf->Line(205,11,205,17);

$pdf->SetFont('arial','',10);
$pdf->SetY(12);$pdf->SetX(20);$d="  Designation Article  ";
$pdf->Cell(50,8,$d,0,0,'L',1);
$pdf->SetY(12);$pdf->SetX(124);$d="  MPS  ";
$pdf->Cell(20,8,$d,0,0,'L',1);
$pdf->SetY(12);$pdf->SetX(157);$d="  JAOUDA ";
$pdf->Cell(20,8,$d,0,0,'L',1);
$pdf->SetY(12);$pdf->SetX(180);$d="  Total  ";
$pdf->Cell(20,8,$d,0,0,'L',1);
$pdf->SetFont('arial','',8);
$ligne=17;

}



		
		
		$q=0;
		$sql  = "SELECT * ";$type="production";$dj=dateFrToUs($date);
		
		$sql .= "FROM entrees_stock where produit='$produit' and type='$type' and date='$dj' ORDER BY date;";
		$users1 = db_query($database_name, $sql);
		while($users_1 = fetch_array($users1)) {	
			$q=$q+$users_1["depot_a"];
			}
			
		if ($q>0){$q="Prod : ".$q;
		/*$pdf->Cell(20,8,$q,0,0,'L',1);*/
		}
				
		
		$t=($e_depot_a-$s_depot_a)+($e_depot_b-$s_depot_b);
		////////////
		if ($t<>0){
		$pdf->SetX(70);$h=$last_date."     (".$last_out.")";$ld=dateFrToUs($last_date);	
		/*$pdf->Cell(40,8,$h,0,0,'L',1);*/
		$date_jour=date("Y-m-d");
		$nbjours = round((strtotime($date_jour) - strtotime($ld))/(60*60*24)-1); 
		if ($nbjours>=30){
			$j=$nbjours." jrs";
			/*$pdf->Cell(40,8,$h,0,0,'L',1);
		$pdf->SetX(105);$pdf->Cell(40,8,$j,0,0,'L',1);*/
		}
		
		}
		//////////////
		
		////seuil critique
		
		if ($seuil_critique>$t){
		$pdf->SetTextColor(220,50,50);
		$pdf->SetY($ligne);	$pdf->SetX(4);
		$pdf->Cell(50,10,$produit,0,0,'L',1);
		$pdf->SetX(90);$seuil="Seuil : ".$seuil_critique;
		$pdf->Cell(10,10,$seuil,0,0,'L',1);
		$pdf->SetX(105);
		$pdf->Cell(10,10,$e_depot_a,0,0,'L',1);$pdf->SetX(120);
		$pdf->Cell(10,10,$s_depot_a,0,0,'L',1);$pdf->SetX(140);
		$d=number_format($prix_unit,2,',',' ');
		$pdf->Cell(10,10,$e_depot_b,0,0,'L',1);$pdf->SetX(160);
		$pdf->Cell(10,10,$s_depot_b,0,0,'L',1);$pdf->SetX(180);
		$pdf->Cell(10,10,$t,0,0,'L',1);
		$pdf->SetTextColor(0);
	   	}else
		{
		$pdf->SetY($ligne);	$pdf->SetX(4);
		$pdf->Cell(50,10,$produit,0,0,'L',1);
		$pdf->SetX(105);
		$pdf->Cell(10,10,$e_depot_a,0,0,'L',1);$pdf->SetX(120);
		$pdf->Cell(10,10,$s_depot_a,0,0,'L',1);$pdf->SetX(140);
		$d=number_format($prix_unit,2,',',' ');
		$pdf->Cell(10,10,$e_depot_b,0,0,'L',1);$pdf->SetX(160);
		$pdf->Cell(10,10,$s_depot_b,0,0,'L',1);$pdf->SetX(180);
		$pdf->Cell(10,10,$t,0,0,'L',1);
	   	}
		
		
		$pdf->Line(3,$ligne,3,$ligne+7);
		$pdf->Line(117,$ligne,117,$ligne+7);
		$pdf->Line(155,$ligne,155,$ligne+7);
		$pdf->Line(179,$ligne,179,$ligne+7);
		$pdf->Line(205,$ligne,205,$ligne+7);
		$pdf->SetLineWidth(0.1);
		$pdf->Line(3,$ligne+1,205,$ligne+1);
			$ligne=$ligne+7;$article=$article+1;
			
		 }
		 
		 
$pdf->Line(3,$ligne,205,$ligne);

$pdf->Output();	

