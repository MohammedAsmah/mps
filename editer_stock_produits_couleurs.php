<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	require "fpdf.php";
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	
	$du=$_GET['du'];$date1=$_GET['date1'];$date=dateUsToFr($_GET['date1']);
	

//Create new pdf file
$pdf=new FPDF('L','mm','A4');

//Disable automatic page break
$pdf->SetAutoPageBreak(false);


// grille couleurs 
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 25;$y_axis = 25;$row_height=6;$l=25;



//print column titles for the actual page
$pdf->SetFillColor(255);$entete=5;
$pdf->SetY(1);
$pdf->SetFont('arial','B',12);$pdf->SetX(5);$titre="STOCK INITIAL AU 02/12/2015  : ";
$pdf->Cell(70,12,$titre,0,0,'L',0);


$pdf->SetX(75);$pdf->Cell(70,12,'MARRON',0,0,'L',0);
$pdf->SetX(135);$pdf->Cell(70,12,'BEIGE',0,0,'L',0);
$pdf->SetX(200);$pdf->Cell(70,12,'GRIS',0,0,'L',0);



$pdf->SetFont('arial','',10);
$pdf->SetY(12);$pdf->SetX(5);$d="  Designation Article  ";
$pdf->Cell(50,8,$d,0,0,'L',1);//$pdf->SetFillColor(139,69,19);


$pdf->SetFont('arial','',8);
$pdf->SetY(14);$pdf->SetX(68); 
$pdf->Cell(20,8,'MPS',0,0,'L',1);
$pdf->Cell(20,8,'JAOUDA',0,0,'L',1);
$pdf->Cell(20,8,'TOTAL',0,0,'L',1);


$pdf->SetY(14);$pdf->SetX(129);
$pdf->Cell(20,8,'MPS',0,0,'L',1);
$pdf->Cell(20,8,'JAOUDA',0,0,'L',1);
$pdf->Cell(20,8,'TOTAL',0,0,'L',1);


$pdf->SetY(14);$pdf->SetX(190);
$pdf->Cell(20,8,'MPS',0,0,'L',1);
$pdf->Cell(20,8,'JAOUDA',0,0,'L',1);
$pdf->Cell(20,8,'TOTAL',0,0,'L',1);
$pdf->SetFont('arial','',10);

$pdf->SetFont('arial','',8);
$pdf->SetY(14);$pdf->SetX(240); 
$pdf->Cell(20,8,'TOTAL GENERAL',0,0,'L',1);

$pdf->SetLineWidth(0.2);
$pdf->Line(3,11,270,11);
$pdf->Line(3,11,3,20);
$pdf->Line(63,11,63,20);
$pdf->Line(128,11,128,20);
$pdf->Line(180,11,180,20);
$pdf->Line(240,11,240,20);
$pdf->Line(270,11,270,20);

$ligne=20;

$sql  = "SELECT * ";$vide="";$article="article";
	$sql .= "FROM produits where dispo=1 and produit<>'$vide' and famille='$article' and couleurs=1 ORDER BY produit;";
	$users2 = db_query($database_name, $sql);
while($users_2 = fetch_array($users2)) { 

			$id=$users_2["id"];$produit=$users_2["produit"];//($prix_unit,2,',',' ')
			$p_marron=$users_2["p_marron"];	$p_beige=$users_2["p_beige"];	$p_gris=$users_2["p_gris"];		
$p_marron_jp=$users_2["p_marron_jp"];	$p_beige_jp=$users_2["p_beige_jp"];	$p_gris_jp=$users_2["p_gris_jp"];
$sql  = "SELECT * ";$type="production";	$marron=0;$beige=0;$gris=0;
$sql .= "FROM entrees_stock where produit='$produit' and type='$type' and (date between '$du' and '$date1' ) ORDER BY date;";
		$users3 = db_query($database_name, $sql);
		while($users_3 = fetch_array($users3)) {	
			//$marron=$marron+$users_3["marron"];$beige=$beige+$users_3["beige"];$gris=$gris+$users_3["gris"];
			}
$total=$p_marron_jp+$p_beige_jp+$p_gris_jp+$p_marron+$p_beige+$p_gris;
$pdf->SetY($ligne);	$pdf->SetX(4);
		$pdf->Cell(50,10,$produit,0,0,'L',1);
		$pdf->SetX(68);
		
		$pdf->Cell(20,10,number_format($p_marron,0,',',' '),0,0,'L',1);
		$pdf->Cell(20,10,number_format($p_marron_jp,0,',',' '),0,0,'L',1);
		$pdf->Cell(20,10,number_format($p_marron+$p_marron_jp,0,',',' '),0,0,'L',1);
		
		$pdf->Cell(20,10,number_format($p_beige,0,',',' '),0,0,'L',1);
		$pdf->Cell(20,10,number_format($p_beige_jp,0,',',' '),0,0,'L',1);
		$pdf->Cell(20,10,number_format($p_beige_jp+$p_beige,0,',',' '),0,0,'L',1);	
		
		$pdf->Cell(20,10,number_format($p_gris,0,',',' '),0,0,'L',1);
		$pdf->Cell(20,10,number_format($p_gris_jp,0,',',' '),0,0,'L',1);
		$pdf->Cell(20,10,number_format($p_gris_jp+$p_gris,0,',',' '),0,0,'L',1);	
		
		$pdf->Cell(20,10,number_format($total,0,',',' '),0,0,'L',1);
		$pdf->Line(3,$ligne,3,$ligne+7);
		$pdf->Line(63,$ligne,63,$ligne+7);
		$pdf->Line(128,$ligne,128,$ligne+7);
		$pdf->Line(180,$ligne,180,$ligne+7);
		$pdf->Line(240,$ligne,240,$ligne+7);
		$pdf->Line(270,$ligne,270,$ligne+7);

		$pdf->SetLineWidth(0.1);
		$pdf->Line(3,$ligne+1,270,$ligne+1);
			$ligne=$ligne+7;
	
}
$pdf->Line(3,$ligne+1,270,$ligne+1);




//ENTREES

$pdf->SetY($ligne+10);
$pdf->SetFont('arial','B',12);$pdf->SetX(5);$titre="PRODUCTION AU  : ".$date;
$pdf->Cell(70,12,$titre,0,0,'L',0);

$pdf->SetX(75);$pdf->Cell(70,12,'MARRON',0,0,'L',0);
$pdf->SetX(135);$pdf->Cell(70,12,'BEIGE',0,0,'L',0);
$pdf->SetX(200);$pdf->Cell(70,12,'GRIS',0,0,'L',0);

$ligne=$ligne+10;
$pdf->SetLineWidth(0.2);
$pdf->Line(3,$ligne+25,270,$ligne+25);
$pdf->Line(3,$ligne+25,3,$ligne+40);
$pdf->Line(63,$ligne+25,63,$ligne+40);
$pdf->Line(128,$ligne+25,128,$ligne+40);
$pdf->Line(180,$ligne+25,180,$ligne+40);
$pdf->Line(240,$ligne+25,240,$ligne+40);
$pdf->Line(270,$ligne+25,270,$ligne+40);



$pdf->SetFont('arial','',8);
$pdf->SetY($ligne+30);$pdf->SetX(4);
$d="  Designation Article  ";
$pdf->Cell(50,8,$d,0,0,'L',1);


$pdf->SetFont('arial','',8);
$pdf->SetY($ligne+30);$pdf->SetX(68); 
$pdf->Cell(20,8,'MPS',0,0,'L',1);
$pdf->Cell(20,8,'JAOUDA',0,0,'L',1);
$pdf->Cell(20,8,'TOTAL',0,0,'L',1);


$pdf->SetY($ligne+30);$pdf->SetX(129);
$pdf->Cell(20,8,'MPS',0,0,'L',1);
$pdf->Cell(20,8,'JAOUDA',0,0,'L',1);
$pdf->Cell(20,8,'TOTAL',0,0,'L',1);


$pdf->SetY($ligne+30);$pdf->SetX(190);
$pdf->Cell(20,8,'MPS',0,0,'L',1);
$pdf->Cell(20,8,'JAOUDA',0,0,'L',1);
$pdf->Cell(20,8,'TOTAL',0,0,'L',1);
$pdf->SetFont('arial','',10);

$pdf->SetFont('arial','',8);
$pdf->SetY($ligne+30);$pdf->SetX(240); 
$pdf->Cell(20,8,'TOTAL GENERAL',0,0,'L',1);

$pdf->SetFont('arial','',8);
$ligne=$ligne+35;
$sql  = "SELECT * ";$vide="";$article="article";
	$sql .= "FROM produits where dispo=1 and produit<>'$vide' and famille='$article' and couleurs=1 ORDER BY produit;";
	$users2 = db_query($database_name, $sql);
while($users_2 = fetch_array($users2)) { 

			$id=$users_2["id"];$produit=$users_2["produit"];//($prix_unit,2,',',' ')
			$p_marron=$users_2["p_marron"];	$p_beige=$users_2["p_beige"];	$p_gris=$users_2["p_gris"];		
$p_marron_jp=$users_2["p_marron_jp"];	$p_beige_jp=$users_2["p_beige_jp"];	$p_gris_jp=$users_2["p_gris_jp"];
$sql  = "SELECT * ";$type="production";	$marron=0;$beige=0;$gris=0;$marron_entree_j=0;$beige_entree_j=0;$gris_entree_j=0;
$sql .= "FROM entrees_stock where produit='$produit' and type='$type' and (date between '$du' and '$date1' ) ORDER BY date;";
		$users3 = db_query($database_name, $sql);
		while($users_3 = fetch_array($users3)) {	
			$marron=$marron+$users_3["marron"];$beige=$beige+$users_3["beige"];$gris=$gris+$users_3["gris"];
			$marron_entree_j=$marron_entree_j+$users_3["marron_b"];$beige_entree_j=$beige_entree_j+$users_3["beige_b"];$gris_entree_j=$gris_entree_j+$users_3["gris_b"];
			}
		$total_entrees=$marron+$beige+$gris;
		$total_entrees_j=$marron_entree_j+$beige_entree_j+$gris_entree_j;
		$pdf->SetY($ligne);	$pdf->SetX(4);
		$pdf->Cell(50,10,$produit,0,0,'L',1);
		$pdf->SetX(68);
		
		$pdf->Cell(20,10,number_format($marron,0,',',' '),0,0,'L',1);
		$pdf->Cell(20,10,number_format($marron_entree_j,0,',',' '),0,0,'L',1);
		$pdf->Cell(20,10,number_format($marron+$marron_entree_j,0,',',' '),0,0,'L',1);
		
		$pdf->Cell(20,10,number_format($beige,0,',',' '),0,0,'L',1);
		$pdf->Cell(20,10,number_format($beige_entree_j,0,',',' '),0,0,'L',1);
		$pdf->Cell(20,10,number_format($beige+$beige_entree_j,0,',',' '),0,0,'L',1);
		
		$pdf->Cell(20,10,number_format($gris,0,',',' '),0,0,'L',1);
		$pdf->Cell(20,10,number_format($gris_entree_j,0,',',' '),0,0,'L',1);
		$pdf->Cell(20,10,number_format($gris+$gris_entree_j,0,',',' '),0,0,'L',1);
		
		$pdf->Cell(20,10,number_format($total_entrees+$total_entrees_j,0,',',' '),0,0,'L',1);
		$pdf->Line(3,$ligne,3,$ligne+7);
		$pdf->Line(63,$ligne,63,$ligne+7);
		$pdf->Line(128,$ligne,128,$ligne+7);
		$pdf->Line(180,$ligne,180,$ligne+7);
		$pdf->Line(240,$ligne,240,$ligne+7);
		$pdf->Line(270,$ligne,270,$ligne+7);

		$pdf->SetLineWidth(0.1);
		$pdf->Line(3,$ligne+1,270,$ligne+1);
			$ligne=$ligne+7;
	
}
$pdf->Line(3,$ligne+1,270,$ligne+1);



//sortie

$pdf->SetY($ligne+10);
$pdf->SetFont('arial','B',12);$pdf->SetX(5);$titre="SORTIES AU  : ".$date;
$pdf->Cell(70,12,$titre,0,0,'L',0);

$pdf->SetX(75);$pdf->Cell(70,12,'MARRON',0,0,'L',0);
$pdf->SetX(135);$pdf->Cell(70,12,'BEIGE',0,0,'L',0);
$pdf->SetX(200);$pdf->Cell(70,12,'GRIS',0,0,'L',0);
$ligne=$ligne+10;
$pdf->SetFont('arial','',8);
$pdf->SetY($ligne+14);$pdf->SetX(68); 
$pdf->Cell(20,8,'MPS',0,0,'L',1);
$pdf->Cell(20,8,'JAOUDA',0,0,'L',1);
$pdf->Cell(20,8,'TOTAL',0,0,'L',1);


$pdf->SetY($ligne+14);$pdf->SetX(129);
$pdf->Cell(20,8,'MPS',0,0,'L',1);
$pdf->Cell(20,8,'JAOUDA',0,0,'L',1);
$pdf->Cell(20,8,'TOTAL',0,0,'L',1);


$pdf->SetY($ligne+14);$pdf->SetX(190);
$pdf->Cell(20,8,'MPS',0,0,'L',1);
$pdf->Cell(20,8,'JAOUDA',0,0,'L',1);
$pdf->Cell(20,8,'TOTAL',0,0,'L',1);
$pdf->SetFont('arial','',10);

$pdf->SetFont('arial','',8);
$pdf->SetY(14);$pdf->SetX(240); 
$pdf->Cell(20,8,'TOTAL GENERAL',0,0,'L',1);

$pdf->SetLineWidth(0.2);
$pdf->Line(3,$ligne+11,270,$ligne+11);
$pdf->Line(3,$ligne+11,3,$ligne+20);
$pdf->Line(63,$ligne+11,63,$ligne+20);
$pdf->Line(128,$ligne+11,128,$ligne+20);
$pdf->Line(180,$ligne+11,180,$ligne+20);
$pdf->Line(240,$ligne+11,240,$ligne+20);
$pdf->Line(270,$ligne+11,270,$ligne+20);

$ligne=$ligne+25;
$sql  = "SELECT * ";$vide="";$article="article";
	$sql .= "FROM produits where dispo=1 and produit<>'$vide' and famille='$article' and couleurs=1 ORDER BY produit;";
	$users2 = db_query($database_name, $sql);
while($users_2 = fetch_array($users2)) { 

			$id=$users_2["id"];$produit=$users_2["produit"];//($prix_unit,2,',',' ')
			$p_marron=$users_2["p_marron"];	$p_beige=$users_2["p_beige"];	$p_gris=$users_2["p_gris"];		
$p_marron_jp=$users_2["p_marron_jp"];	$p_beige_jp=$users_2["p_beige_jp"];	$p_gris_jp=$users_2["p_gris_jp"];
$sql  = "SELECT * ";$type="production";	$marron=0;$beige=0;$gris=0;$marron_p=0;$beige_p=0;$gris_p=0;
$sql .= "FROM bon_de_sortie_magasin where produit='$produit' and (date between '$du' and '$date1' ) ORDER BY date;";
		$users3 = db_query($database_name, $sql);
		while($users_3 = fetch_array($users3)) {	
			$marron=$marron+$users_3["marron"];$beige=$beige+$users_3["beige"];$gris=$gris+$users_3["gris"];
			$marron_p=$marron_p+$users_3["marron_b"];$beige_p=$beige_p+$users_3["beige_b"];$gris_p=$gris_p+$users_3["gris_b"];
			}
		$total_sorties_m=$marron+$marron_p;
		$total_sorties_b=$beige+$beige_p;
		$total_sorties_g=$gris+$gris_p;
		
		$pdf->SetY($ligne);	$pdf->SetX(4);
		$pdf->Cell(50,10,$produit,0,0,'L',1);
		$pdf->SetX(68);
		
		$pdf->Cell(20,10,number_format($marron,0,',',' '),0,0,'L',1);
		$pdf->Cell(20,10,number_format($marron_p,0,',',' '),0,0,'L',1);
		$pdf->Cell(20,10,number_format($total_sorties_m,0,',',' '),0,0,'L',1);
		
		$pdf->Cell(20,10,number_format($beige,0,',',' '),0,0,'L',1);
		$pdf->Cell(20,10,number_format($beige_p,0,',',' '),0,0,'L',1);
		$pdf->Cell(20,10,number_format($total_sorties_b,0,',',' '),0,0,'L',1);
		
		$pdf->Cell(20,10,number_format($gris,0,',',' '),0,0,'L',1);
		$pdf->Cell(20,10,number_format($gris_p,0,',',' '),0,0,'L',1);
		$pdf->Cell(20,10,number_format($total_sorties_g,0,',',' '),0,0,'L',1);
		
		$pdf->Cell(20,10,number_format($total_sorties_m+$total_sorties_b+$total_sorties_g,0,',',' '),0,0,'L',1);
		
		$pdf->Line(3,$ligne,3,$ligne+7);
		$pdf->Line(63,$ligne,63,$ligne+7);
		$pdf->Line(128,$ligne,128,$ligne+7);
		$pdf->Line(180,$ligne,180,$ligne+7);
		$pdf->Line(240,$ligne,240,$ligne+7);
		$pdf->Line(270,$ligne,270,$ligne+7);

		$pdf->SetLineWidth(0.1);
		$pdf->Line(3,$ligne+1,270,$ligne+1);
			$ligne=$ligne+7;
	
}
$pdf->Line(3,$ligne+1,270,$ligne+1);



//stock
$pdf->SetFillColor(255);$entete=5;
$pdf->SetY($ligne+10);
$pdf->SetFont('arial','B',12);$pdf->SetX(5);$titre="STOCK AU  : ".$date;
$pdf->Cell(70,12,$titre,0,0,'L',0);

$pdf->SetX(75);$pdf->Cell(70,12,'MARRON',0,0,'L',0);
$pdf->SetX(135);$pdf->Cell(70,12,'BEIGE',0,0,'L',0);
$pdf->SetX(200);$pdf->Cell(70,12,'GRIS',0,0,'L',0);
$ligne=$ligne+10;
$pdf->SetFont('arial','',8);
$pdf->SetY($ligne+14);$pdf->SetX(68); 
$pdf->Cell(20,8,'MPS',0,0,'L',1);
$pdf->Cell(20,8,'JAOUDA',0,0,'L',1);
$pdf->Cell(20,8,'TOTAL',0,0,'L',1);


$pdf->SetY($ligne+14);$pdf->SetX(129);
$pdf->Cell(20,8,'MPS',0,0,'L',1);
$pdf->Cell(20,8,'JAOUDA',0,0,'L',1);
$pdf->Cell(20,8,'TOTAL',0,0,'L',1);


$pdf->SetY($ligne+14);$pdf->SetX(190);
$pdf->Cell(20,8,'MPS',0,0,'L',1);
$pdf->Cell(20,8,'JAOUDA',0,0,'L',1);
$pdf->Cell(20,8,'TOTAL',0,0,'L',1);
$pdf->SetFont('arial','',10);

$pdf->SetFont('arial','',8);
$pdf->SetY(14);$pdf->SetX(240); 
$pdf->Cell(20,8,'TOTAL GENERAL',0,0,'L',1);

$pdf->SetLineWidth(0.2);
$pdf->Line(3,$ligne+11,270,$ligne+11);
$pdf->Line(3,$ligne+11,3,$ligne+20);
$pdf->Line(63,$ligne+11,63,$ligne+20);
$pdf->Line(128,$ligne+11,128,$ligne+20);
$pdf->Line(180,$ligne+11,180,$ligne+20);
$pdf->Line(240,$ligne+11,240,$ligne+20);
$pdf->Line(270,$ligne+11,270,$ligne+20);


$ligne=$ligne+25;
$sql  = "SELECT * ";$vide="";$article="article";
	$sql .= "FROM produits where dispo=1 and produit<>'$vide' and famille='$article' and couleurs=1 ORDER BY produit;";
	$users2 = db_query($database_name, $sql);
while($users_2 = fetch_array($users2)) { 

			$id=$users_2["id"];$produit=$users_2["produit"];//($prix_unit,2,',',' ')
			$marron_initial=$users_2["p_marron"];	$beige_initial=$users_2["p_beige"];	$gris_initial=$users_2["p_gris"];		
			$marron_jp_initial=$users_2["p_marron_jp"];	$beige_jp_initial=$users_2["p_beige_jp"];	$gris_jp_initial=$users_2["p_gris_jp"];
			
$sql  = "SELECT * ";$type="production";	$marron_sortie=0;$beige_sortie=0;$gris_sortie=0;$marron_p_sortie=0;$beige_p_sortie=0;$gris_p_sortie=0;
$sql .= "FROM bon_de_sortie_magasin where produit='$produit' and (date between '$du' and '$date1' ) ORDER BY date;";
		$users3 = db_query($database_name, $sql);
		while($users_3 = fetch_array($users3)) {	
			$marron_sortie=$marron_sortie+$users_3["marron"];$beige_sortie=$beige_sortie+$users_3["beige"];$gris_sortie=$gris_sortie+$users_3["gris"];
			$marron_p_sortie=$marron_p_sortie+$users_3["marron_b"];$beige_p_sortie=$beige_p_sortie+$users_3["beige_b"];$gris_p_sortie=$gris_p_sortie+$users_3["gris_b"];
			}
			$total_sorties_m=$marron_sortie+$marron_p_sortie;
		$total_sorties_b=$beige_sortie+$beige_p_sortie;
		$total_sorties_g=$gris_sortie+$gris_p_sortie;
		
$sql  = "SELECT * ";$type="production";	$marron_entree=0;$beige_entree=0;$gris_entree=0;
$sql .= "FROM entrees_stock where produit='$produit' and type='$type' and (date between '$du' and '$date1' ) ORDER BY date;";
		$users3 = db_query($database_name, $sql);
		while($users_3 = fetch_array($users3)) {	
			$marron_entree=$marron_entree+$users_3["marron"];$beige_entree=$beige_entree+$users_3["beige"];$gris_entree=$gris_entree+$users_3["gris"];
			$marron_entree_jp=$marron_entree_jp+$users_3["marron_b"];$beige_entree_jp=$beige_entree_jp+$users_3["beige_b"];$gris_entree_jp=$gris_entree_jp+$users_3["gris_b"];
			}
		$t_entrees=$marron_entree+$beige_entree+$gris_entree;			
			
		
		
		$pdf->SetY($ligne);	$pdf->SetX(4);
		$pdf->Cell(50,10,$produit,0,0,'L',1);
		$pdf->SetX(68);
		$stock_marron_final_mps=$marron_initial+$marron_entree-$marron_sortie;
		$stock_marron_final_jp=$marron_jp_initial+$marron_entree_jp-$marron_p_sortie;
		$pdf->Cell(20,10,number_format($marron_initial+$marron_entree-$marron_sortie,0,',',' '),0,0,'L',1);
		$pdf->Cell(20,10,number_format($marron_jp_initial+$marron_entree_jp-$marron_p_sortie,0,',',' '),0,0,'L',1);
		$pdf->Cell(20,10,number_format($stock_marron_final_mps+$stock_marron_final_jp,0,',',' '),0,0,'L',1);
		
		$stock_beige_final_mps=$beige_initial+$beige_entree-$beige_sortie;
		$stock_beige_final_jp=$beige_jp_initial+$beige_entree_jp-$beige_p_sortie;
		$pdf->Cell(20,10,number_format($beige_initial+$beige_entree-$beige_sortie,0,',',' '),0,0,'L',1);
		$pdf->Cell(20,10,number_format($beige_jp_initial+$beige_entree_jp-$beige_p_sortie,0,',',' '),0,0,'L',1);
		$pdf->Cell(20,10,number_format($stock_beige_final_mps+$stock_beige_final_jp,0,',',' '),0,0,'L',1);
		
		$stock_gris_final_mps=$gris_initial+$gris_entree-$gris_sortie;
		$stock_gris_final_jp=$gris_jp_initial+$gris_entree_jp-$gris_p_sortie;
		$pdf->Cell(20,10,number_format($gris_initial+$gris_entree-$gris_sortie,0,',',' '),0,0,'L',1);
		$pdf->Cell(20,10,number_format($gris_jp_initial+$gris_entree_jp-$gris_p_sortie,0,',',' '),0,0,'L',1);
		$pdf->Cell(20,10,number_format($stock_gris_final_mps+$stock_gris_final_jp,0,',',' '),0,0,'L',1);
		
		$pdf->Cell(20,10,number_format($stock_marron_final_mps+$stock_marron_final_jp+$stock_beige_final_mps+$stock_beige_final_jp+$stock_gris_final_mps+$stock_gris_final_jp,0,',',' '),0,0,'L',1);
		
		
		
		$pdf->Line(3,$ligne,3,$ligne+7);
		$pdf->Line(63,$ligne,63,$ligne+7);
		$pdf->Line(128,$ligne,128,$ligne+7);
		$pdf->Line(180,$ligne,180,$ligne+7);
		$pdf->Line(240,$ligne,240,$ligne+7);
		$pdf->Line(270,$ligne,270,$ligne+7);

		$pdf->SetLineWidth(0.1);
		$pdf->Line(3,$ligne+1,270,$ligne+1);
			$ligne=$ligne+7;
	
}
$pdf->Line(3,$ligne+1,270,$ligne+1);



$pdf->Output();	

