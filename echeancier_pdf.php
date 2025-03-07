<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	require "fpdf.php";
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$caisse="";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	$du1=date("d/m/Y");$date=date("Y-m-d");$fin_exe="2017-12-31";$t=0;$te=0;
	$sql  = "SELECT id,designation,sum(montant_echeance) as t_m,date_echeance ";
	$sql .= "FROM echeances_credits where date_echeance>='$date' and date_echeance<='$fin_exe' group by id order BY date_echeance;";
	$users = db_query($database_name, $sql);
	while($users_ = fetch_array($users)) { 
	
			$date_echeance=$users_["date_echeance"];$id=$users_["id"];
			list($annee1,$mois1,$jour1) = explode('-', $date_echeance); 
			$date = mktime(0,0,0,$mois1,$jour1,$annee1); 
			$mois=date("M",$date);
				if ($mois=="May"){$mois1="MAI";$mois_v=5;}
				if ($mois=="Jun"){$mois1="JUIN";$mois_v=6;}
				if ($mois=="Jul"){$mois1="JUIL";$mois_v=7;}
				if ($mois=="Aug"){$mois1="AOUT";$mois_v=8;}
				if ($mois=="Sep"){$mois1="SEP";$mois_v=9;}
				if ($mois=="Oct"){$mois1="OCT";$mois_v=10;}
				if ($mois=="Nov"){$mois1="NOV";$mois_v=11;}
				if ($mois=="Dec"){$mois1="DEC";$mois_v=12;}
				if ($mois=="Jan"){$mois1="JAN";$mois_v=1;}
				if ($mois=="Feb"){$mois1="FEV";$mois_v=2;}
				if ($mois=="Mar"){$mois1="MARS";$mois_v=3;}
				if ($mois=="Apr"){$mois1="AVRIL";$mois_v=4;}
			$sql = "UPDATE echeances_credits SET mois = '$mois_v' WHERE id = $id ";
			db_query($database_name, $sql);
}



//Create new pdf file
$pdf=new FPDF('L','mm','A4');

//Disable automatic page break
$pdf->SetAutoPageBreak(false);

//Add first page
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 25;$y_axis = 25;$row_height=6;$l=25;

//print column titles for the actual page
$pdf->SetFillColor(255);$entete=5;
$pdf->SetY(1);$datejour=date("d/m/Y");
$pdf->SetFont('arial','B',12);$pdf->SetX(95);$titre="Echéancier Au : ".$datejour;
$pdf->Cell(70,12,$titre,0,0,'L',0);
$ligne=5;$inter=3;$col=295;

	
	for ($compteur=1;$compteur<=12;$compteur++)
	{
				if ($compteur==5){$mois1="MAI";$mois_v=5;}
				if ($compteur==6){$mois1="JUIN";$mois_v=6;}
				if ($compteur==7){$mois1="JUILLET";$mois_v=7;}
				if ($compteur==8){$mois1="AOUT";$mois_v=8;}
				if ($compteur==9){$mois1="SEPTEMBRE";$mois_v=9;}
				if ($compteur==10){$mois1="OCTOBRE";$mois_v=10;}
				if ($compteur==11){$mois1="NOVEMBRE";$mois_v=11;}
				if ($compteur==12){$mois1="DECEMBRE";$mois_v=12;}
				if ($compteur==1){$mois1="JANVIER";$mois_v=1;}
				if ($compteur==2){$mois1="FEVRIER";$mois_v=2;}
				if ($compteur==3){$mois1="MARS";$mois_v=3;}
				if ($compteur==4){$mois1="AVRIL";$mois_v=4;}

	$du1=date("d/m/Y");$date=date("Y-m-d");$fin_exe="2017-12-31";$fin_exe_fr="31/12/2017";$t=0;
	$sql  = "SELECT id,designation,color,sum(montant_echeance) as t_m,date_echeance ";
	$sql .= "FROM echeances_credits where mois=$compteur and date_echeance>'$date' and date_echeance<='$fin_exe' group by id order BY date_echeance;";
	$users1 = db_query($database_name, $sql);
	
	$pdf->SetFont('arial','B',11);
	
	while($users_1 = fetch_array($users1)) { 
	$tt=$tt+$users_1["t_m"];}
	if ($tt>0){
	
	
	$sql  = "SELECT id,designation,color,sum(montant_echeance) as t_m,date_echeance ";
	$sql .= "FROM echeances_credits where mois=$compteur and date_echeance>'$date' and date_echeance<='$fin_exe' group by id order BY date_echeance;";
	$users = db_query($database_name, $sql);
	
	$pdf->SetY($ligne);
	$pdf->SetX(1);
	$pdf->Cell(30,12,$mois1,0,0,'L',0);

	$ligne=$ligne+5;
	
	if ($ligne>=170){
	
	//Disable automatic page break
	$pdf->SetAutoPageBreak(false);

	//Add first page
	$pdf->AddPage();
	$ligne=5;
	}
	
	
	
	
	$pdf->SetY($ligne);
	$pdf->SetX(3);
	$titre1="Echeance";
	$titre2="Designation";
	$titre3="Montant";
	$pdf->Cell(24,12,$titre1,0,0,'L',0);
	$pdf->Cell(230,12,$titre2,0,0,'L',0);
	$pdf->Cell(30,12,$titre3,0,0,'R',0);
	$pdf->Line(1,$ligne+$inter,$col,$ligne+$inter);
	$debit=0;$credit=0;
	while($users_ = fetch_array($users)) { 
			$date_echeance=$users_["date_echeance"];
			list($annee1,$mois1,$jour1) = explode('-', $date_echeance); 
			$date = mktime(0,0,0,$mois1,$jour1,$annee1); 
			$mois=date("M",$date);
				if ($mois=="May"){$mois1="MAI";$mois_v=5;}
				if ($mois=="Jun"){$mois1="JUIN";$mois_v=6;}
				if ($mois=="Jul"){$mois1="JUIL";$mois_v=7;}
				if ($mois=="Aug"){$mois1="AOUT";$mois_v=8;}
				if ($mois=="Sep"){$mois1="SEP";$mois_v=9;}
				if ($mois=="Oct"){$mois1="OCT";$mois_v=10;}
				if ($mois=="Nov"){$mois1="NOV";$mois_v=11;}
				if ($mois=="Dec"){$mois1="DEC";$mois_v=12;}
				if ($mois=="Jan"){$mois1="JAN";$mois_v=1;}
				if ($mois=="Feb"){$mois1="FEV";$mois_v=2;}
				if ($mois=="Mar"){$mois1="MARS";$mois_v=3;}
				if ($mois=="Apr"){$mois1="AVRIL";$mois_v=4;}

	$ligne=$ligne+5;
	$pdf->SetY($ligne);
	$pdf->SetX(3);
	
	
	$d1=dateUsToFr($date_echeance);
	$d2=$users_["designation"];
	$d3=number_format($users_["t_m"],2,',',' ');
	if ($users_["color"]=="rouge"){$pdf->SetTextColor(220,50,50);}
	if ($users_["color"]=="jaune"){$pdf->SetTextColor(0,80,180);}
	if ($users_["color"]=="vert"){$pdf->SetTextColor(230,230,100);}
	if ($users_["color"]=="bleu"){$pdf->SetTextColor(0,80,180);}
	if ($users_["color"]==""){$pdf->SetTextColor(0);}
	
	$pdf->SetFont('arial','B',11);	
	$pdf->Cell(24,12,$d1,0,0,'L',0);
	$pdf->SetFont('arial','B',9);
	$pdf->Cell(240,12,$d2,0,0,'L',0);
	$pdf->SetFont('arial','B',11);
	$pdf->Cell(30,12,$d3,0,0,'R',0);
	$pdf->SetTextColor(0);
		
	$pdf->Line(1,$ligne+$inter,$col,$ligne+$inter);


	$t=$t+$users_["t_m"];$te=$te+$users_["t_m"];
 } 

	if ($t>0){
	$titre1=" ";
	$titre2=" ";
	$titre3="Total $mois1  :  ".number_format($t,2,',',' ');
	$ligne=$ligne+5;
	$pdf->SetY($ligne);
	$pdf->SetX(3);
	$pdf->Cell(24,12,$titre1,0,0,'L',0);
	$pdf->Cell(240,12,$titre2,0,0,'L',0);
	$pdf->SetFont('arial','B',11);
	$pdf->Cell(30,12,$titre3,0,0,'R',0);
	$pdf->SetFont('arial','B',11);
	$pdf->Line(1,$ligne+$inter,$col,$ligne+$inter);
	$ligne=$ligne+5;
	 }
 }
 }
	$toe=number_format($te,2,',',' ');
	$titre1="Total Echeancier au : ".$fin_exe_fr." : ".$toe;
	$titre2=" ";
	
	$ligne=$ligne+5;
	$pdf->SetY($ligne);
	$pdf->SetX(3);$titre="";
	$pdf->Cell(60,12,$titre,0,0,'L',0);
	$pdf->Cell(140,12,$titre2,0,0,'L',0);
	$pdf->SetFont('arial','B',11);
	$pdf->Cell(80,12,$titre1,0,0,'R',0);
	$pdf->SetFont('arial','B',11);
	$pdf->Line(1,$ligne+$inter,$col,$ligne+$inter);
	
	$date_jour=date("Y-m-d");
	if ($date_jour>="2013-09-15"){


	$du1="01/01/2018";$date="2018-01-01";$fin_exe="2018-12-31";$t11=0;$tt11=0;
	$sql  = "SELECT id,designation,sum(montant_echeance) as t_m,date_echeance ";
	$sql .= "FROM echeances_credits where date_echeance>='$date' and date_echeance<='$fin_exe' group by id order BY date_echeance;";
	$users = db_query($database_name, $sql);
	while($users_ = fetch_array($users)) { 
	
			$date_echeance=$users_["date_echeance"];$id=$users_["id"];
			list($annee1,$mois1,$jour1) = explode('-', $date_echeance); 
			$date = mktime(0,0,0,$mois1,$jour1,$annee1); 
			$mois=date("M",$date);
				if ($mois=="May"){$mois1="MAI";$mois_v=5;}
				if ($mois=="Jun"){$mois1="JUIN";$mois_v=6;}
				if ($mois=="Jul"){$mois1="JUIL";$mois_v=7;}
				if ($mois=="Aug"){$mois1="AOUT";$mois_v=8;}
				if ($mois=="Sep"){$mois1="SEP";$mois_v=9;}
				if ($mois=="Oct"){$mois1="OCT";$mois_v=10;}
				if ($mois=="Nov"){$mois1="NOV";$mois_v=11;}
				if ($mois=="Dec"){$mois1="DEC";$mois_v=12;}
				if ($mois=="Jan"){$mois1="JAN";$mois_v=1;}
				if ($mois=="Feb"){$mois1="FEV";$mois_v=2;}
				if ($mois=="Mar"){$mois1="MARS";$mois_v=3;}
				if ($mois=="Apr"){$mois1="AVRIL";$mois_v=4;}
			$sql = "UPDATE echeances_credits SET mois = '$mois_v' WHERE id = $id ";
			db_query($database_name, $sql);
}


//Disable automatic page break
$pdf->SetAutoPageBreak(false);

//Add first page
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 25;$y_axis = 25;$row_height=6;$l=25;

//print column titles for the actual page
$pdf->SetFillColor(255);$entete=5;
$pdf->SetY(1);$datejour=date("d/m/Y");
$pdf->SetFont('arial','B',12);$pdf->SetX(95);$titre="Echéancier 2018 Edite le  : ".$datejour;
$pdf->Cell(70,12,$titre,0,0,'L',0);
$ligne=5;$inter=3;$col=295;

	for ($compteur=1;$compteur<=12;$compteur++)
	{
				if ($compteur==5){$mois1="MAI";$mois_v=5;}
				if ($compteur==6){$mois1="JUIN";$mois_v=6;}
				if ($compteur==7){$mois1="JUILLET";$mois_v=7;}
				if ($compteur==8){$mois1="AOUT";$mois_v=8;}
				if ($compteur==9){$mois1="SEPTEMBRE";$mois_v=9;}
				if ($compteur==10){$mois1="OCTOBRE";$mois_v=10;}
				if ($compteur==11){$mois1="NOVEMBRE";$mois_v=11;}
				if ($compteur==12){$mois1="DECEMBRE";$mois_v=12;}
				if ($compteur==1){$mois1="JANVIER";$mois_v=1;}
				if ($compteur==2){$mois1="FEVRIER";$mois_v=2;}
				if ($compteur==3){$mois1="MARS";$mois_v=3;}
				if ($compteur==4){$mois1="AVRIL";$mois_v=4;}

	$du1="01/01/2018";$date="2018-01-01";$fin_exe="2018-12-31";$fin_exe_fr="31/12/2018";$t11=0;$tt11=0;
	$sql  = "SELECT id,designation,sum(montant_echeance) as t_m,date_echeance ";
	$sql .= "FROM echeances_credits where mois=$compteur and date_echeance>'$date' and date_echeance<='$fin_exe' group by id order BY date_echeance;";
	$users1 = db_query($database_name, $sql);
	while($users_1 = fetch_array($users1)) { 
	$tt11=$tt11+$users_1["t_m"];}
	if ($tt11>0){
	
	
	$sql  = "SELECT id,designation,sum(montant_echeance) as t_m,date_echeance ";
	$sql .= "FROM echeances_credits where mois=$compteur and date_echeance>'$date' and date_echeance<='$fin_exe' group by id order BY date_echeance;";
	$users = db_query($database_name, $sql);
	
	$pdf->SetFont('arial','B',12);
	$pdf->SetY($ligne);
	$pdf->SetX(5);
	$pdf->Cell(30,12,$mois1,0,0,'L',0);

	$ligne=$ligne+5;
	
	if ($ligne>=170){
	
	//Disable automatic page break
	$pdf->SetAutoPageBreak(false);

	//Add first page
	$pdf->AddPage();
	$ligne=5;
	}
	
	$pdf->SetY($ligne);
	$pdf->SetX(15);
	$titre1="Echeance";
	$titre2="Designation";
	$titre3="Montant";
	$pdf->Cell(30,12,$titre1,0,0,'L',0);
	$pdf->Cell(220,12,$titre2,0,0,'L',0);
	$pdf->Cell(30,12,$titre3,0,0,'R',0);
	$pdf->Line(3,$ligne+$inter,$col,$ligne+$inter);	
	

	$debit=0;$credit=0;
while($users_ = fetch_array($users)) { 
			$date_echeance=$users_["date_echeance"];
			list($annee1,$mois1,$jour1) = explode('-', $date_echeance); 
			$date = mktime(0,0,0,$mois1,$jour1,$annee1); 
			$mois=date("M",$date);
				if ($mois=="May"){$mois1="MAI";$mois_v=5;}
				if ($mois=="Jun"){$mois1="JUIN";$mois_v=6;}
				if ($mois=="Jul"){$mois1="JUIL";$mois_v=7;}
				if ($mois=="Aug"){$mois1="AOUT";$mois_v=8;}
				if ($mois=="Sep"){$mois1="SEP";$mois_v=9;}
				if ($mois=="Oct"){$mois1="OCT";$mois_v=10;}
				if ($mois=="Nov"){$mois1="NOV";$mois_v=11;}
				if ($mois=="Dec"){$mois1="DEC";$mois_v=12;}
				if ($mois=="Jan"){$mois1="JAN";$mois_v=1;}
				if ($mois=="Feb"){$mois1="FEV";$mois_v=2;}
				if ($mois=="Mar"){$mois1="MARS";$mois_v=3;}
				if ($mois=="Apr"){$mois1="AVRIL";$mois_v=4;}
				
				
				$ligne=$ligne+5;
	$pdf->SetY($ligne);
	$pdf->SetX(15);
	
	
	$d1=dateUsToFr($date_echeance);
	$d2=$users_["designation"];
	$d3=number_format($users_["t_m"],2,',',' ');
	if ($users_["color"]=="rouge"){$pdf->SetTextColor(220,50,50);}
	if ($users_["color"]=="jaune"){$pdf->SetTextColor(0,80,180);}
	if ($users_["color"]=="vert"){$pdf->SetTextColor(230,230,100);}
	if ($users_["color"]=="bleu"){$pdf->SetTextColor(0,80,180);}
	if ($users_["color"]==""){$pdf->SetTextColor(0);}
	
	$pdf->SetFont('arial','B',10);	
	$pdf->Cell(30,12,$d1,0,0,'L',0);
	$pdf->SetFont('arial','B',8);
	$pdf->Cell(220,12,$d2,0,0,'L',0);
	$pdf->SetFont('arial','B',10);
	$pdf->Cell(30,12,$d3,0,0,'R',0);
	$pdf->SetTextColor(0);
		
	$pdf->Line(3,$ligne+$inter,$col,$ligne+$inter);


	$t11=$t11+$users_["t_m"];$te=$te+$users_["t_m"];
 
	} 
 
 
 
 
 
 
 
 
 if ($t11>0){
	$titre1=" ";
	$titre2=" ";
	$titre3="Total $mois1  :  ".number_format($t11,2,',',' ');
	$ligne=$ligne+5;
	$pdf->SetY($ligne);
	$pdf->SetX(15);
	$pdf->Cell(30,12,$titre1,0,0,'L',0);
	$pdf->Cell(220,12,$titre2,0,0,'L',0);
	$pdf->SetFont('arial','B',10);
	$pdf->Cell(30,12,$titre3,0,0,'R',0);
	$pdf->SetFont('arial','B',10);
	$pdf->Line(3,$ligne+$inter,$col,$ligne+$inter);
	$ligne=$ligne+5;
	 }
	 
	 
	 
	 
 }
 }
	$toe=number_format($te,2,',',' ');
	$titre1="Total Echeancier au : ".$fin_exe_fr." : ".$toe;
	$titre2=" ";
	
	$ligne=$ligne+5;
	$pdf->SetY($ligne);
	$pdf->SetX(15);$titre="";
	$pdf->Cell(60,12,$titre,0,0,'L',0);
	$pdf->Cell(140,12,$titre2,0,0,'L',0);
	$pdf->SetFont('arial','B',10);
	$pdf->Cell(80,12,$titre1,0,0,'R',0);
	$pdf->SetFont('arial','B',10);
	$pdf->Line(3,$ligne+$inter,$col,$ligne+$inter);

 }

//Disable automatic page break
$pdf->SetAutoPageBreak(false);

//Add first page
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 25;$y_axis = 25;$row_height=6;$l=25;

//print column titles for the actual page
$pdf->SetFillColor(255);$entete=5;
$pdf->SetY(1);$datejour=date("d/m/Y");
$pdf->SetFont('arial','B',12);$pdf->SetX(95);$titre="Echéancier Previsionnel  : ".$datejour;
$pdf->Cell(70,12,$titre,0,0,'L',0);
$ligne=10;$inter=3;$col=295;
$pdf->SetY($ligne);
	$pdf->SetX(15);
	$titre1="Echeance";
	$titre2="Designation";
	$titre3="Montant";
	$pdf->Cell(30,12,$titre1,0,0,'L',0);
	$pdf->Cell(220,12,$titre2,0,0,'L',0);
	$pdf->Cell(30,12,$titre3,0,0,'R',0);
	$pdf->Line(3,$ligne+$inter,$col,$ligne+$inter);	


	$ddd=date("Y-m-d");$r11=0;$rr11=0;
	$sql  = "SELECT id,designation,sum(montant_echeance) as t_m,date_echeance ";
	$sql .= "FROM echeancier_previsionnel group by id order BY date_echeance;";
	$users1 = db_query($database_name, $sql);
while($users_1 = fetch_array($users1)) { 
	$date_echeance=$users_1["date_echeance"];
	$d1=dateUsToFr($date_echeance);
	$d2=$users_1["designation"];
	$d3=number_format($users_1["t_m"],2,',',' ');
	if ($users_1["color"]=="rouge"){$pdf->SetTextColor(220,50,50);}
	if ($users_1["color"]=="jaune"){$pdf->SetTextColor(0,80,180);}
	if ($users_1["color"]=="vert"){$pdf->SetTextColor(230,230,100);}
	if ($users_1["color"]=="bleu"){$pdf->SetTextColor(0,80,180);}
	if ($users_1["color"]==""){$pdf->SetTextColor(0);}
	
	$ligne=$ligne+5;
	$pdf->SetY($ligne);
	$pdf->SetX(15);
	
	$pdf->SetFont('arial','B',10);	
	$pdf->Cell(30,12,$d1,0,0,'L',0);
	$pdf->SetFont('arial','B',8);
	$pdf->Cell(220,12,$d2,0,0,'L',0);
	$pdf->SetFont('arial','B',10);
	$pdf->Cell(30,12,$d3,0,0,'R',0);
	$pdf->SetTextColor(0);
		
	$pdf->Line(3,$ligne+$inter,$col,$ligne+$inter);
	$r11=$r11+$users_1["t_m"];
	
	}
	
	$toe=number_format($r11,2,',',' ');
	$titre1="Total Previsionel : ".$toe;
	$titre2=" ";
	
	$ligne=$ligne+5;
	$pdf->SetY($ligne);
	$pdf->SetX(15);$titre="";
	$pdf->Cell(60,12,$titre,0,0,'L',0);
	$pdf->Cell(140,12,$titre2,0,0,'L',0);
	$pdf->SetFont('arial','B',10);
	$pdf->Cell(80,12,$titre1,0,0,'R',0);
	$pdf->SetFont('arial','B',10);
	$pdf->Line(3,$ligne+$inter,$col,$ligne+$inter);

$pdf->Output();	

?>