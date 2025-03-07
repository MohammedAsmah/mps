<?php
//PDF USING MULTIPLE PAGES
//CREATED BY: Carlos Vasquez S.
//E-MAIL: cvasquez@cvs.cl
//CVS TECNOLOGIA E INNOVACION
//SANTIAGO, CHILE

require('fpdf.php');
	require "config.php";
	require "connect_db.php";
	require "functions.php";
//Connect to your database
/*mysql_connect('localhost','root','');
mysql_select_db('mps2008');*/

//Create new pdf file
$pdf=new FPDF('L','mm','A4');

//Disable automatic page break
$pdf->SetAutoPageBreak(false);

//Add first page
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 25;$y_axis = 25;$row_height=8;
	$total_e=0;$total_c=0;$total_t=0;
	$a="A";
	$sql = "TRUNCATE TABLE `report_matiere1`  ;";
			db_query($database_name, $sql);
	$sql = "TRUNCATE TABLE `report_matiere2`  ;";
			db_query($database_name, $sql);
	$sql = "TRUNCATE TABLE `report_matiere3`  ;";
			db_query($database_name, $sql);		
	$sql = "TRUNCATE TABLE `report_matiere4`  ;";
			db_query($database_name, $sql);
	
	
	
	$jan_du="2012-01-01";$jan_au="2012-01-31";
	$fev_du="2012-02-01";$fev_au="2012-02-29";
	$mar_du="2012-03-01";$mar_au="2012-03-31";
	
	
	

//print column titles for the actual page
$pdf->SetFillColor(240);
$pdf->SetY(5);
$pdf->SetFont('Arial','B',18);
$pdf->Cell(20,6,'M.P.S',0,0,'L',0);
$pdf->SetFont('Arial','B',20);
$pdf->SetY(5);$t_show="MATIERE PREMIERE ";$pdf->SetX(90);
$pdf->Cell(97,6,$t_show,0,0,'L',0);$pdf->SetY(15);
$pdf->SetX(80);$d="1er Trimestre ";
$pdf->Cell(60,6,$d,0,0,'L',0);
$pdf->SetFont('Arial','B',12);
$pdf->SetY($y_axis_initial);
$pdf->SetX(2);
$pdf->Cell(50,8,'designation',1,0,'C',0);
$pdf->Cell(30,8,'stock init. MP',1,0,'C',0);
$pdf->Cell(30,8,'stock init. PF',1,0,'C',0);
$pdf->Cell(50,8,'janvier',1,0,'C',0);
$pdf->Cell(50,8,'fevrier',1,0,'C',0);
$pdf->Cell(50,8,'mars',1,0,'C',0);

$pdf->Cell(30,8,'A reporter',1,0,'C',0);
$pdf->SetY($y_axis_initial+7);
$pdf->SetX(2);
$pdf->Cell(50,6,'',0,0,'C',0);
$pdf->Cell(30,6,'',0,0,'C',0);
$pdf->Cell(30,6,'',0,0,'C',0);
$pdf->Cell(25,8,'achats',1,0,'C',0);
$pdf->Cell(25,8,'consom.',1,0,'C',0);
$pdf->Cell(25,8,'achats',1,0,'C',0);
$pdf->Cell(25,8,'consom.',1,0,'C',0);
$pdf->Cell(25,8,'achats',1,0,'C',0);
$pdf->Cell(25,8,'consom.',1,0,'C',0);
$pdf->Cell(30,8,'',0,0,'C',0);		

$y_axis = $y_axis_initial+7+ $row_height;$t=0;

//Select the Products you want to show in your PDF file
/*$result=mysql_query('select Code,Name,Price from Products ORDER BY Code',$link);*/
	$date=dateFrToUs(date("d/m/Y"));$total=0;
	
	$sql  = "SELECT * ";
	$sql .= "FROM types_matieres where dispo=1 order BY profile_name;";
	$users = db_query($database_name, $sql);

//initialize counter
$i = 0;

//Set maximum rows per page
$max = 38;

//Set Row Height
$row_height = 6;$t_cheque=0;$ca=0;$htva_t=0;$tva_t=0;$ttc_t=0;$espece=0;$cheque=0;$effet=0;$tmt_t=0;
	$t_cheque_t = 0;
	$total_espece_t = 0;
	$total_effet_t = 0;

/*while($row = mysql_fetch_array($result))*/
while($row = fetch_array($users))
{
	
	$matiere = $row['profile_name'];$vide="";
	//stock initial
	$stock_initial_pf=0;$stock_initial=0;	
	 $sql1  = "SELECT * ";$d="2012-01-01";$d_exe1="2013-01-01";
	$sql1 .= "FROM report_mat_precedant where date='$d' and produit='$matiere' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users1_ = fetch_array($users1)) { 
		$stock_initial_pf = $stock_initial_pf+$users1_["stock_final_pf"];
		$encours_initial_pf=$encours_initial_pf+$users1_["encours"];
		$stock_initial=$stock_initial+$users1_["stock_final_mp"];
		$vfm=$vfm+$users1_["valeur_final_mp"];
	}
	$stmp=number_format($stock_initial,3,',',' ');$stmp1=$stock_initial;
	$stpf=number_format($stock_initial_pf,3,',',' ');$stpf1=$stock_initial_pf;
	
	
	
	
	$janvier  = "SELECT * ";$achats=0;
	$janvier .= "FROM achats_mat where produit='$matiere' and date between '$jan_du' and '$jan_au' ORDER BY produit;";
	$janvier = db_query($database_name, $janvier);$achats=0;$prix_revient=0;
	while($janvier_ = fetch_array($janvier)) { 
 		$produit = $janvier_["produit"];
		$achats = $achats+$janvier_["qte"];$prix_revient=$prix_revient+($janvier_["qte"]*$janvier_["prix_achat"]);
		
	}
	$achats_jan=number_format($achats,3,',',' ');$achats_jan1=$achats;
	
	$fevrier  = "SELECT * ";$achats=0;
	$fevrier .= "FROM achats_mat where produit='$matiere' and date between '$fev_du' and '$fev_au' ORDER BY produit;";
	$fevrier = db_query($database_name, $fevrier);$achats=0;$prix_revient=0;
	while($fevrier_ = fetch_array($fevrier)) { 
 		$produit = $fevrier_["produit"];
		$achats = $achats+$fevrier_["qte"];$prix_revient=$prix_revient+($fevrier_["qte"]*$fevrier_["prix_achat"]);
		
	}
	$achats_fev=number_format($achats,3,',',' ');$achats_fev1=$achats;
	
	$mars  = "SELECT * ";$achats=0;
	$mars .= "FROM achats_mat where produit='$matiere' and date between '$mar_du' and '$mar_au' ORDER BY produit;";
	$mars = db_query($database_name, $mars);$achats=0;$prix_revient=0;
	while($mars_ = fetch_array($mars)) { 
 		$produit = $mars_["produit"];
		$achats = $achats+$mars_["qte"];$prix_revient=$prix_revient+($mars_["qte"]*$mars_["prix_achat"]);
		
	}
	$achats_mar=number_format($achats,3,',',' ');$achats_mar1=$achats;
	
	//consommé
	$janvier  = "SELECT * ";$consomme=0;
	$janvier .= "FROM detail_factures where matiere='$matiere' and date_f between '$jan_du' and '$jan_au' ORDER BY produit;";
	$janvier = db_query($database_name, $janvier);$achats=0;$prix_revient=0;
	while($janvier_ = fetch_array($janvier)) { 
 		
		$consomme = $consomme+($janvier_["quantite"]*$janvier_["condit"]*$janvier_["poids"]/1000);
		
	}
	$consomme_jan=number_format($consomme,3,',',' ');$consomme_jan1=$consomme;
	
	$fevrier  = "SELECT * ";$consomme=0;
	$fevrier .= "FROM detail_factures where matiere='$matiere' and date_f between '$fev_du' and '$fev_au' ORDER BY produit;";
	$fevrier = db_query($database_name, $fevrier);$achats=0;$prix_revient=0;
	while($fevrier_ = fetch_array($fevrier)) { 
 		$consomme = $consomme+($fevrier_["quantite"]*$fevrier_["condit"]*$fevrier_["poids"]/1000);
		
	}
	$consomme_fev=number_format($consomme,3,',',' ');$consomme_fev1=$consomme;
	
	$mars  = "SELECT * ";$consomme=0;
	$mars .= "FROM detail_factures where matiere='$matiere' and date_f between '$mar_du' and '$mar_au' ORDER BY produit;";
	$mars = db_query($database_name, $mars);$achats=0;$prix_revient=0;
	while($mars_ = fetch_array($mars)) { 
 		$consomme = $consomme+($mars_["quantite"]*$mars_["condit"]*$mars_["poids"]/1000);
		
	}
	$consomme_mar=number_format($consomme,3,',',' ');$consomme_mar1=$consomme;
	
		
	$pdf->SetY($y_axis);$pdf->SetX(2);
	$pdf->Cell(50,6,$matiere,1,0,'L',0);
	$pdf->Cell(30,6,$stmp,1,0,'R',0);
	$pdf->Cell(30,6,$stpf,1,0,'R',0);
	$pdf->Cell(25,6,$achats_jan,1,0,'R',0);
	$pdf->Cell(25,6,$consomme_jan,1,0,'R',0);
	$pdf->Cell(25,6,$achats_fev,1,0,'R',0);
	$pdf->Cell(25,6,$consomme_fev,1,0,'R',0);
	$pdf->Cell(25,6,$achats_mar,1,0,'R',0);
	$pdf->Cell(25,6,$consomme_mar,1,0,'R',0);
		
	$pdf->Cell(30,6,$vide,1,0,'R',0);	
	//Go to next row
	$y_axis = $y_axis + $row_height;
	$pdf->SetY($y_axis);
	$resultat_janvier=0;
	$resultat_fevrier=0;
	$resultat_mars=0;
	$resultat_janvier=$stmp1+$stpf1+$achats_jan1-$consomme_jan1;
	$resultat_fevrier=$resultat_janvier+$achats_fev1-$consomme_fev1;
	$resultat_mars=$resultat_fevrier+$achats_mar1-$consomme_mar1;
	$resultat_report=$resultat_mars;
	
	$resultat_janvier=number_format($resultat_janvier,3,',',' ');
	$resultat_fevrier=number_format($resultat_fevrier,3,',',' ');
	$resultat_mars=number_format($resultat_mars,3,',',' ');$resultat_report_1=$resultat_report;
	$resultat_report=number_format($resultat_report,3,',',' ');
	
$pdf->SetX(2);
$pdf->Cell(50,8,'',0,0,'C',0);
$pdf->Cell(30,8,'',0,0,'C',0);
$pdf->Cell(30,8,'',0,0,'C',0);
$pdf->Cell(50,8,$resultat_janvier,0,0,'C',0);
$pdf->Cell(50,8,$resultat_fevrier,0,0,'C',0);
$pdf->Cell(50,8,$resultat_mars,0,0,'C',0);

$pdf->Cell(30,8,$resultat_report,0,0,'C',0);
	$y_axis = $y_axis + $row_height+10;$trimestre="1er";$ok=0;
	
				if (!$ok){
				$sql  = "INSERT INTO report_matiere1 ( produit,type, stock_final_mp ) VALUES ( ";
				$sql .= "'" . $matiere . "', ";
				$sql .= "'" . $trimestre . "', ";
				$sql .= $resultat_report_1 . ");";

				db_query($database_name, $sql);
				$ok=1;}
	
	
	
	
	
	
	$i = $i + 1;
}



//////////////////////////

//Add first page
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 25;$y_axis = 25;$row_height=8;
	$total_e=0;$total_c=0;$total_t=0;
	$a="A";
	
	
	$jan_du="2012-04-01";$jan_au="2012-04-30";
	$fev_du="2012-05-01";$fev_au="2012-05-31";
	$mar_du="2012-06-01";$mar_au="2012-06-30";
	
	
	

//print column titles for the actual page
$pdf->SetFillColor(240);
$pdf->SetY(5);
$pdf->SetFont('Arial','B',18);
$pdf->Cell(20,6,'M.P.S',0,0,'L',0);
$pdf->SetFont('Arial','B',20);
$pdf->SetY(5);$t_show="MATIERE PREMIERE ";$pdf->SetX(90);
$pdf->Cell(97,6,$t_show,0,0,'L',0);$pdf->SetY(15);
$pdf->SetX(80);$d="2eme Trimestre ";
$pdf->Cell(60,6,$d,0,0,'L',0);
$pdf->SetFont('Arial','B',12);
$pdf->SetY($y_axis_initial);
$pdf->SetX(2);
$pdf->Cell(50,8,'designation',1,0,'C',0);
$pdf->Cell(30,8,'stock init. MP',1,0,'C',0);
/*$pdf->Cell(30,8,'stock init. PF',1,0,'C',0);*/
$pdf->Cell(50,8,'avril',1,0,'C',0);
$pdf->Cell(50,8,'mai',1,0,'C',0);
$pdf->Cell(50,8,'juin',1,0,'C',0);

$pdf->Cell(30,8,'A reporter',1,0,'C',0);
$pdf->SetY($y_axis_initial+7);
$pdf->SetX(2);
$pdf->Cell(50,6,'',0,0,'C',0);
$pdf->Cell(30,6,'',0,0,'C',0);
/*$pdf->Cell(30,6,'',0,0,'C',0);*/
$pdf->Cell(25,8,'achats',1,0,'C',0);
$pdf->Cell(25,8,'consom.',1,0,'C',0);
$pdf->Cell(25,8,'achats',1,0,'C',0);
$pdf->Cell(25,8,'consom.',1,0,'C',0);
$pdf->Cell(25,8,'achats',1,0,'C',0);
$pdf->Cell(25,8,'consom.',1,0,'C',0);
$pdf->Cell(30,8,'',0,0,'C',0);		

$y_axis = $y_axis_initial+7+ $row_height;$t=0;

//Select the Products you want to show in your PDF file
/*$result=mysql_query('select Code,Name,Price from Products ORDER BY Code',$link);*/
	$date=dateFrToUs(date("d/m/Y"));$total=0;
	
	$sql  = "SELECT * ";
	$sql .= "FROM types_matieres where dispo=1 order BY profile_name;";
	$users = db_query($database_name, $sql);

//initialize counter
$i = 0;

//Set maximum rows per page
$max = 38;

//Set Row Height
$row_height = 6;$t_cheque=0;$ca=0;$htva_t=0;$tva_t=0;$ttc_t=0;$espece=0;$cheque=0;$effet=0;$tmt_t=0;
	$t_cheque_t = 0;
	$total_espece_t = 0;
	$total_effet_t = 0;

/*while($row = mysql_fetch_array($result))*/
while($row = fetch_array($users))
{
	
	$matiere = $row['profile_name'];$vide="";
	//stock initial
	
	$sql1  = "SELECT * ";$trimestre="1er";$stock_initial=0;
	$sql1 .= "FROM report_matiere1 where produit='$matiere' and type='$trimestre' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users1_ = fetch_array($users1)) { 
		
		$stock_initial=$stock_initial+$users1_["stock_final_mp"];
		
	}
	
	
	
	$stmp=number_format($stock_initial,3,',',' ');$stmp1=$stock_initial;
	
	
	
	
	
	$janvier  = "SELECT * ";$achats=0;
	$janvier .= "FROM achats_mat where produit='$matiere' and date between '$jan_du' and '$jan_au' ORDER BY produit;";
	$janvier = db_query($database_name, $janvier);$achats=0;$prix_revient=0;
	while($janvier_ = fetch_array($janvier)) { 
 		$produit = $janvier_["produit"];
		$achats = $achats+$janvier_["qte"];$prix_revient=$prix_revient+($janvier_["qte"]*$janvier_["prix_achat"]);
		
	}
	$achats_jan=number_format($achats,3,',',' ');$achats_jan1=$achats;
	
	$fevrier  = "SELECT * ";$achats=0;
	$fevrier .= "FROM achats_mat where produit='$matiere' and date between '$fev_du' and '$fev_au' ORDER BY produit;";
	$fevrier = db_query($database_name, $fevrier);$achats=0;$prix_revient=0;
	while($fevrier_ = fetch_array($fevrier)) { 
 		$produit = $fevrier_["produit"];
		$achats = $achats+$fevrier_["qte"];$prix_revient=$prix_revient+($fevrier_["qte"]*$fevrier_["prix_achat"]);
		
	}
	$achats_fev=number_format($achats,3,',',' ');$achats_fev1=$achats;
	
	$mars  = "SELECT * ";$achats=0;
	$mars .= "FROM achats_mat where produit='$matiere' and date between '$mar_du' and '$mar_au' ORDER BY produit;";
	$mars = db_query($database_name, $mars);$achats=0;$prix_revient=0;
	while($mars_ = fetch_array($mars)) { 
 		$produit = $mars_["produit"];
		$achats = $achats+$mars_["qte"];$prix_revient=$prix_revient+($mars_["qte"]*$mars_["prix_achat"]);
		
	}
	$achats_mar=number_format($achats,3,',',' ');$achats_mar1=$achats;
	
	//consommé
	$janvier  = "SELECT * ";$consomme=0;
	$janvier .= "FROM detail_factures where matiere='$matiere' and date_f between '$jan_du' and '$jan_au' ORDER BY produit;";
	$janvier = db_query($database_name, $janvier);$achats=0;$prix_revient=0;
	while($janvier_ = fetch_array($janvier)) { 
 		
		$consomme = $consomme+($janvier_["quantite"]*$janvier_["condit"]*$janvier_["poids"]/1000);
		
	}
	$consomme_jan=number_format($consomme,3,',',' ');$consomme_jan1=$consomme;
	
	$fevrier  = "SELECT * ";$consomme=0;
	$fevrier .= "FROM detail_factures where matiere='$matiere' and date_f between '$fev_du' and '$fev_au' ORDER BY produit;";
	$fevrier = db_query($database_name, $fevrier);$achats=0;$prix_revient=0;
	while($fevrier_ = fetch_array($fevrier)) { 
 		$consomme = $consomme+($fevrier_["quantite"]*$fevrier_["condit"]*$fevrier_["poids"]/1000);
		
	}
	$consomme_fev=number_format($consomme,3,',',' ');$consomme_fev1=$consomme;
	
	$mars  = "SELECT * ";$consomme=0;
	$mars .= "FROM detail_factures where matiere='$matiere' and date_f between '$mar_du' and '$mar_au' ORDER BY produit;";
	$mars = db_query($database_name, $mars);$achats=0;$prix_revient=0;
	while($mars_ = fetch_array($mars)) { 
 		$consomme = $consomme+($mars_["quantite"]*$mars_["condit"]*$mars_["poids"]/1000);
		
	}
	$consomme_mar=number_format($consomme,3,',',' ');$consomme_mar1=$consomme;
	
		
	$pdf->SetY($y_axis);$pdf->SetX(2);
	$pdf->Cell(50,6,$matiere,1,0,'L',0);
	$pdf->Cell(30,6,$stmp,1,0,'R',0);
	/*$pdf->Cell(30,6,$stpf,1,0,'R',0);*/
	$pdf->Cell(25,6,$achats_jan,1,0,'R',0);
	$pdf->Cell(25,6,$consomme_jan,1,0,'R',0);
	$pdf->Cell(25,6,$achats_fev,1,0,'R',0);
	$pdf->Cell(25,6,$consomme_fev,1,0,'R',0);
	$pdf->Cell(25,6,$achats_mar,1,0,'R',0);
	$pdf->Cell(25,6,$consomme_mar,1,0,'R',0);
		
	$pdf->Cell(30,6,$vide,1,0,'R',0);	
	//Go to next row
	$y_axis = $y_axis + $row_height;
	$pdf->SetY($y_axis);
	$resultat_janvier=0;
	$resultat_fevrier=0;
	$resultat_mars=0;
	$resultat_janvier=$stmp1+$achats_jan1-$consomme_jan1;
	$resultat_fevrier=$resultat_janvier+$achats_fev1-$consomme_fev1;
	$resultat_mars=$resultat_fevrier+$achats_mar1-$consomme_mar1;
	$resultat_report=$resultat_mars;
	
	$resultat_janvier=number_format($resultat_janvier,3,',',' ');
	$resultat_fevrier=number_format($resultat_fevrier,3,',',' ');
	$resultat_mars=number_format($resultat_mars,3,',',' ');$resultat_report_1=$resultat_report;
	$resultat_report=number_format($resultat_report,3,',',' ');
	
$pdf->SetX(2);
$pdf->Cell(50,8,'',0,0,'C',0);
$pdf->Cell(30,8,'',0,0,'C',0);
/*$pdf->Cell(30,8,'',0,0,'C',0);*/
$pdf->Cell(50,8,$resultat_janvier,0,0,'C',0);
$pdf->Cell(50,8,$resultat_fevrier,0,0,'C',0);
$pdf->Cell(50,8,$resultat_mars,0,0,'C',0);

$pdf->Cell(30,8,$resultat_report,0,0,'C',0);
	$y_axis = $y_axis + $row_height+10;
	$trimestre="2eme";$ok=0;
	
				if (!$ok){
				$sql  = "INSERT INTO report_matiere2 ( produit,type, stock_final_mp ) VALUES ( ";
				$sql .= "'" . $matiere . "', ";
				$sql .= "'" . $trimestre . "', ";
				$sql .= $resultat_report_1 . ");";

				db_query($database_name, $sql);
				$ok=1;}
	
	
	$i = $i + 1;
}

//////////////////////////


//////////////////////////

//Add first page
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 25;$y_axis = 25;$row_height=8;
	$total_e=0;$total_c=0;$total_t=0;
	$a="A";
	
	
	$jan_du="2012-07-01";$jan_au="2012-07-31";
	$fev_du="2012-08-01";$fev_au="2012-08-31";
	$mar_du="2012-09-01";$mar_au="2012-09-30";
	
	
	

//print column titles for the actual page
$pdf->SetFillColor(240);
$pdf->SetY(5);
$pdf->SetFont('Arial','B',18);
$pdf->Cell(20,6,'M.P.S',0,0,'L',0);
$pdf->SetFont('Arial','B',20);
$pdf->SetY(5);$t_show="MATIERE PREMIERE ";$pdf->SetX(90);
$pdf->Cell(97,6,$t_show,0,0,'L',0);$pdf->SetY(15);
$pdf->SetX(80);$d="3eme Trimestre ";
$pdf->Cell(60,6,$d,0,0,'L',0);
$pdf->SetFont('Arial','B',12);
$pdf->SetY($y_axis_initial);
$pdf->SetX(2);
$pdf->Cell(50,8,'designation',1,0,'C',0);
$pdf->Cell(30,8,'stock init. MP',1,0,'C',0);
/*$pdf->Cell(30,8,'stock init. PF',1,0,'C',0);*/
$pdf->Cell(50,8,'juillet',1,0,'C',0);
$pdf->Cell(50,8,'aout',1,0,'C',0);
$pdf->Cell(50,8,'septembre',1,0,'C',0);

$pdf->Cell(30,8,'A reporter',1,0,'C',0);
$pdf->SetY($y_axis_initial+7);
$pdf->SetX(2);
$pdf->Cell(50,6,'',0,0,'C',0);
$pdf->Cell(30,6,'',0,0,'C',0);
/*$pdf->Cell(30,6,'',0,0,'C',0);*/
$pdf->Cell(25,8,'achats',1,0,'C',0);
$pdf->Cell(25,8,'consom.',1,0,'C',0);
$pdf->Cell(25,8,'achats',1,0,'C',0);
$pdf->Cell(25,8,'consom.',1,0,'C',0);
$pdf->Cell(25,8,'achats',1,0,'C',0);
$pdf->Cell(25,8,'consom.',1,0,'C',0);
$pdf->Cell(30,8,'',0,0,'C',0);		

$y_axis = $y_axis_initial+7+ $row_height;$t=0;

//Select the Products you want to show in your PDF file
/*$result=mysql_query('select Code,Name,Price from Products ORDER BY Code',$link);*/
	$date=dateFrToUs(date("d/m/Y"));$total=0;
	
	$sql  = "SELECT * ";
	$sql .= "FROM types_matieres where dispo=1 order BY profile_name;";
	$users = db_query($database_name, $sql);

//initialize counter
$i = 0;

//Set maximum rows per page
$max = 38;

//Set Row Height
$row_height = 6;$t_cheque=0;$ca=0;$htva_t=0;$tva_t=0;$ttc_t=0;$espece=0;$cheque=0;$effet=0;$tmt_t=0;
	$t_cheque_t = 0;
	$total_espece_t = 0;
	$total_effet_t = 0;

/*while($row = mysql_fetch_array($result))*/
while($row = fetch_array($users))
{
	
	$matiere = $row['profile_name'];$vide="";
	//stock initial
	
	$sql1  = "SELECT * ";$trimestre="2eme";$stock_initial=0;
	$sql1 .= "FROM report_matiere2 where produit='$matiere' and type='$trimestre' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users1_ = fetch_array($users1)) { 
		
		$stock_initial=$stock_initial+$users1_["stock_final_mp"];
		
	}
	
	
	
	$stmp=number_format($stock_initial,3,',',' ');$stmp1=$stock_initial;
	
	
	
	
	
	$janvier  = "SELECT * ";$achats=0;
	$janvier .= "FROM achats_mat where produit='$matiere' and date between '$jan_du' and '$jan_au' ORDER BY produit;";
	$janvier = db_query($database_name, $janvier);$achats=0;$prix_revient=0;
	while($janvier_ = fetch_array($janvier)) { 
 		$produit = $janvier_["produit"];
		$achats = $achats+$janvier_["qte"];$prix_revient=$prix_revient+($janvier_["qte"]*$janvier_["prix_achat"]);
		
	}
	$achats_jan=number_format($achats,3,',',' ');$achats_jan1=$achats;
	
	$fevrier  = "SELECT * ";$achats=0;
	$fevrier .= "FROM achats_mat where produit='$matiere' and date between '$fev_du' and '$fev_au' ORDER BY produit;";
	$fevrier = db_query($database_name, $fevrier);$achats=0;$prix_revient=0;
	while($fevrier_ = fetch_array($fevrier)) { 
 		$produit = $fevrier_["produit"];
		$achats = $achats+$fevrier_["qte"];$prix_revient=$prix_revient+($fevrier_["qte"]*$fevrier_["prix_achat"]);
		
	}
	$achats_fev=number_format($achats,3,',',' ');$achats_fev1=$achats;
	
	$mars  = "SELECT * ";$achats=0;
	$mars .= "FROM achats_mat where produit='$matiere' and date between '$mar_du' and '$mar_au' ORDER BY produit;";
	$mars = db_query($database_name, $mars);$achats=0;$prix_revient=0;
	while($mars_ = fetch_array($mars)) { 
 		$produit = $mars_["produit"];
		$achats = $achats+$mars_["qte"];$prix_revient=$prix_revient+($mars_["qte"]*$mars_["prix_achat"]);
		
	}
	$achats_mar=number_format($achats,3,',',' ');$achats_mar1=$achats;
	
	//consommé
	$janvier  = "SELECT * ";$consomme=0;
	$janvier .= "FROM detail_factures where matiere='$matiere' and date_f between '$jan_du' and '$jan_au' ORDER BY produit;";
	$janvier = db_query($database_name, $janvier);$achats=0;$prix_revient=0;
	while($janvier_ = fetch_array($janvier)) { 
 		
		$consomme = $consomme+($janvier_["quantite"]*$janvier_["condit"]*$janvier_["poids"]/1000);
		
	}
	$consomme_jan=number_format($consomme,3,',',' ');$consomme_jan1=$consomme;
	
	$fevrier  = "SELECT * ";$consomme=0;
	$fevrier .= "FROM detail_factures where matiere='$matiere' and date_f between '$fev_du' and '$fev_au' ORDER BY produit;";
	$fevrier = db_query($database_name, $fevrier);$achats=0;$prix_revient=0;
	while($fevrier_ = fetch_array($fevrier)) { 
 		$consomme = $consomme+($fevrier_["quantite"]*$fevrier_["condit"]*$fevrier_["poids"]/1000);
		
	}
	$consomme_fev=number_format($consomme,3,',',' ');$consomme_fev1=$consomme;
	
	$mars  = "SELECT * ";$consomme=0;
	$mars .= "FROM detail_factures where matiere='$matiere' and date_f between '$mar_du' and '$mar_au' ORDER BY produit;";
	$mars = db_query($database_name, $mars);$achats=0;$prix_revient=0;
	while($mars_ = fetch_array($mars)) { 
 		$consomme = $consomme+($mars_["quantite"]*$mars_["condit"]*$mars_["poids"]/1000);
		
	}
	$consomme_mar=number_format($consomme,3,',',' ');$consomme_mar1=$consomme;
	
		
	$pdf->SetY($y_axis);$pdf->SetX(2);
	$pdf->Cell(50,6,$matiere,1,0,'L',0);
	$pdf->Cell(30,6,$stmp,1,0,'R',0);
	/*$pdf->Cell(30,6,$stpf,1,0,'R',0);*/
	$pdf->Cell(25,6,$achats_jan,1,0,'R',0);
	$pdf->Cell(25,6,$consomme_jan,1,0,'R',0);
	$pdf->Cell(25,6,$achats_fev,1,0,'R',0);
	$pdf->Cell(25,6,$consomme_fev,1,0,'R',0);
	$pdf->Cell(25,6,$achats_mar,1,0,'R',0);
	$pdf->Cell(25,6,$consomme_mar,1,0,'R',0);
		
	$pdf->Cell(30,6,$vide,1,0,'R',0);	
	//Go to next row
	$y_axis = $y_axis + $row_height;
	$pdf->SetY($y_axis);
	$resultat_janvier=0;
	$resultat_fevrier=0;
	$resultat_mars=0;
	$resultat_janvier=$stmp1+$achats_jan1-$consomme_jan1;
	$resultat_fevrier=$resultat_janvier+$achats_fev1-$consomme_fev1;
	$resultat_mars=$resultat_fevrier+$achats_mar1-$consomme_mar1;
	$resultat_report=$resultat_mars;
	
	$resultat_janvier=number_format($resultat_janvier,3,',',' ');
	$resultat_fevrier=number_format($resultat_fevrier,3,',',' ');
	$resultat_mars=number_format($resultat_mars,3,',',' ');$resultat_report_1=$resultat_report;
	$resultat_report=number_format($resultat_report,3,',',' ');
	
$pdf->SetX(2);
$pdf->Cell(50,8,'',0,0,'C',0);
$pdf->Cell(30,8,'',0,0,'C',0);
/*$pdf->Cell(30,8,'',0,0,'C',0);*/
$pdf->Cell(50,8,$resultat_janvier,0,0,'C',0);
$pdf->Cell(50,8,$resultat_fevrier,0,0,'C',0);
$pdf->Cell(50,8,$resultat_mars,0,0,'C',0);

$pdf->Cell(30,8,$resultat_report,0,0,'C',0);
	$y_axis = $y_axis + $row_height+10;
	
	$trimestre="3eme";$ok=0;
	
				if (!$ok){
				$sql  = "INSERT INTO report_matiere3 ( produit,type, stock_final_mp ) VALUES ( ";
				$sql .= "'" . $matiere . "', ";
				$sql .= "'" . $trimestre . "', ";
				$sql .= $resultat_report_1 . ");";

				db_query($database_name, $sql);
				$ok=1;}
	
	$i = $i + 1;
}

//////////////////////////


//////////////////////////

//Add first page
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 25;$y_axis = 25;$row_height=8;
	$total_e=0;$total_c=0;$total_t=0;
	$a="A";
	
	
	$jan_du="2012-10-01";$jan_au="2012-10-31";
	$fev_du="2012-11-01";$fev_au="2012-11-30";
	$mar_du="2012-12-01";$mar_au="2012-12-31";
	
	
	

//print column titles for the actual page
$pdf->SetFillColor(240);
$pdf->SetY(5);
$pdf->SetFont('Arial','B',18);
$pdf->Cell(20,6,'M.P.S',0,0,'L',0);
$pdf->SetFont('Arial','B',20);
$pdf->SetY(5);$t_show="MATIERE PREMIERE ";$pdf->SetX(90);
$pdf->Cell(97,6,$t_show,0,0,'L',0);$pdf->SetY(15);
$pdf->SetX(80);$d="4eme Trimestre ";
$pdf->Cell(60,6,$d,0,0,'L',0);
$pdf->SetFont('Arial','B',12);
$pdf->SetY($y_axis_initial);
$pdf->SetX(2);
$pdf->Cell(50,8,'designation',1,0,'C',0);
$pdf->Cell(30,8,'stock init. MP',1,0,'C',0);
/*$pdf->Cell(30,8,'stock init. PF',1,0,'C',0);*/
$pdf->Cell(50,8,'octobre',1,0,'C',0);
$pdf->Cell(50,8,'novembre',1,0,'C',0);
$pdf->Cell(50,8,'decembre',1,0,'C',0);

$pdf->Cell(30,8,'A reporter',1,0,'C',0);
$pdf->SetY($y_axis_initial+7);
$pdf->SetX(2);
$pdf->Cell(50,6,'',0,0,'C',0);
$pdf->Cell(30,6,'',0,0,'C',0);
/*$pdf->Cell(30,6,'',0,0,'C',0);*/
$pdf->Cell(25,8,'achats',1,0,'C',0);
$pdf->Cell(25,8,'consom.',1,0,'C',0);
$pdf->Cell(25,8,'achats',1,0,'C',0);
$pdf->Cell(25,8,'consom.',1,0,'C',0);
$pdf->Cell(25,8,'achats',1,0,'C',0);
$pdf->Cell(25,8,'consom.',1,0,'C',0);
$pdf->Cell(30,8,'',0,0,'C',0);		

$y_axis = $y_axis_initial+7+ $row_height;$t=0;

//Select the Products you want to show in your PDF file
/*$result=mysql_query('select Code,Name,Price from Products ORDER BY Code',$link);*/
	$date=dateFrToUs(date("d/m/Y"));$total=0;
	
	$sql  = "SELECT * ";
	$sql .= "FROM types_matieres where dispo=1 order BY profile_name;";
	$users = db_query($database_name, $sql);

//initialize counter
$i = 0;

//Set maximum rows per page
$max = 38;

//Set Row Height
$row_height = 6;$t_cheque=0;$ca=0;$htva_t=0;$tva_t=0;$ttc_t=0;$espece=0;$cheque=0;$effet=0;$tmt_t=0;
	$t_cheque_t = 0;
	$total_espece_t = 0;
	$total_effet_t = 0;

/*while($row = mysql_fetch_array($result))*/
while($row = fetch_array($users))
{
	
	$matiere = $row['profile_name'];$vide="";
	//stock initial
	
	$sql1  = "SELECT * ";$trimestre="3eme";$stock_initial=0;
	$sql1 .= "FROM report_matiere3 where produit='$matiere' and type='$trimestre' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users1_ = fetch_array($users1)) { 
		
		$stock_initial=$stock_initial+$users1_["stock_final_mp"];
		
	}
	
	
	
	$stmp=number_format($stock_initial,3,',',' ');$stmp1=$stock_initial;
	
	
	
	
	
	$janvier  = "SELECT * ";$achats=0;
	$janvier .= "FROM achats_mat where produit='$matiere' and date between '$jan_du' and '$jan_au' ORDER BY produit;";
	$janvier = db_query($database_name, $janvier);$achats=0;$prix_revient=0;
	while($janvier_ = fetch_array($janvier)) { 
 		$produit = $janvier_["produit"];
		$achats = $achats+$janvier_["qte"];$prix_revient=$prix_revient+($janvier_["qte"]*$janvier_["prix_achat"]);
		
	}
	$achats_jan=number_format($achats,3,',',' ');$achats_jan1=$achats;
	
	$fevrier  = "SELECT * ";$achats=0;
	$fevrier .= "FROM achats_mat where produit='$matiere' and date between '$fev_du' and '$fev_au' ORDER BY produit;";
	$fevrier = db_query($database_name, $fevrier);$achats=0;$prix_revient=0;
	while($fevrier_ = fetch_array($fevrier)) { 
 		$produit = $fevrier_["produit"];
		$achats = $achats+$fevrier_["qte"];$prix_revient=$prix_revient+($fevrier_["qte"]*$fevrier_["prix_achat"]);
		
	}
	$achats_fev=number_format($achats,3,',',' ');$achats_fev1=$achats;
	
	$mars  = "SELECT * ";$achats=0;
	$mars .= "FROM achats_mat where produit='$matiere' and date between '$mar_du' and '$mar_au' ORDER BY produit;";
	$mars = db_query($database_name, $mars);$achats=0;$prix_revient=0;
	while($mars_ = fetch_array($mars)) { 
 		$produit = $mars_["produit"];
		$achats = $achats+$mars_["qte"];$prix_revient=$prix_revient+($mars_["qte"]*$mars_["prix_achat"]);
		
	}
	$achats_mar=number_format($achats,3,',',' ');$achats_mar1=$achats;
	
	//consommé
	$janvier  = "SELECT * ";$consomme=0;
	$janvier .= "FROM detail_factures where matiere='$matiere' and date_f between '$jan_du' and '$jan_au' ORDER BY produit;";
	$janvier = db_query($database_name, $janvier);$achats=0;$prix_revient=0;
	while($janvier_ = fetch_array($janvier)) { 
 		
		$consomme = $consomme+($janvier_["quantite"]*$janvier_["condit"]*$janvier_["poids"]/1000);
		
	}
	$consomme_jan=number_format($consomme,3,',',' ');$consomme_jan1=$consomme;
	
	$fevrier  = "SELECT * ";$consomme=0;
	$fevrier .= "FROM detail_factures where matiere='$matiere' and date_f between '$fev_du' and '$fev_au' ORDER BY produit;";
	$fevrier = db_query($database_name, $fevrier);$achats=0;$prix_revient=0;
	while($fevrier_ = fetch_array($fevrier)) { 
 		$consomme = $consomme+($fevrier_["quantite"]*$fevrier_["condit"]*$fevrier_["poids"]/1000);
		
	}
	$consomme_fev=number_format($consomme,3,',',' ');$consomme_fev1=$consomme;
	
	$mars  = "SELECT * ";$consomme=0;
	$mars .= "FROM detail_factures where matiere='$matiere' and date_f between '$mar_du' and '$mar_au' ORDER BY produit;";
	$mars = db_query($database_name, $mars);$achats=0;$prix_revient=0;
	while($mars_ = fetch_array($mars)) { 
 		$consomme = $consomme+($mars_["quantite"]*$mars_["condit"]*$mars_["poids"]/1000);
		
	}
	$consomme_mar=number_format($consomme,3,',',' ');$consomme_mar1=$consomme;
	
		
	$pdf->SetY($y_axis);$pdf->SetX(2);
	$pdf->Cell(50,6,$matiere,1,0,'L',0);
	$pdf->Cell(30,6,$stmp,1,0,'R',0);
	/*$pdf->Cell(30,6,$stpf,1,0,'R',0);*/
	$pdf->Cell(25,6,$achats_jan,1,0,'R',0);
	$pdf->Cell(25,6,$consomme_jan,1,0,'R',0);
	$pdf->Cell(25,6,$achats_fev,1,0,'R',0);
	$pdf->Cell(25,6,$consomme_fev,1,0,'R',0);
	$pdf->Cell(25,6,$achats_mar,1,0,'R',0);
	$pdf->Cell(25,6,$consomme_mar,1,0,'R',0);
		
	$pdf->Cell(30,6,$vide,1,0,'R',0);	
	//Go to next row
	$y_axis = $y_axis + $row_height;
	$pdf->SetY($y_axis);
	$resultat_janvier=0;
	$resultat_fevrier=0;
	$resultat_mars=0;
	$resultat_janvier=$stmp1+$achats_jan1-$consomme_jan1;
	$resultat_fevrier=$resultat_janvier+$achats_fev1-$consomme_fev1;
	$resultat_mars=$resultat_fevrier+$achats_mar1-$consomme_mar1;
	$resultat_report=$resultat_mars;
	
	$resultat_janvier=number_format($resultat_janvier,3,',',' ');
	$resultat_fevrier=number_format($resultat_fevrier,3,',',' ');
	$resultat_mars=number_format($resultat_mars,3,',',' ');$resultat_report_1=$resultat_report;
	$resultat_report=number_format($resultat_report,3,',',' ');
	
$pdf->SetX(2);
$pdf->Cell(50,8,'',0,0,'C',0);
$pdf->Cell(30,8,'',0,0,'C',0);
/*$pdf->Cell(30,8,'',0,0,'C',0);*/
$pdf->Cell(50,8,$resultat_janvier,0,0,'C',0);
$pdf->Cell(50,8,$resultat_fevrier,0,0,'C',0);
$pdf->Cell(50,8,$resultat_mars,0,0,'C',0);

$pdf->Cell(30,8,$resultat_report,0,0,'C',0);
	$y_axis = $y_axis + $row_height+10;
	
	$trimestre="4eme";$ok=0;
	
				if (!$ok){
				$sql  = "INSERT INTO report_matiere4 ( produit,type, stock_final_mp ) VALUES ( ";
				$sql .= "'" . $matiere . "', ";
				$sql .= "'" . $trimestre . "', ";
				$sql .= $resultat_report_1 . ");";

				db_query($database_name, $sql);
				$ok=1;}
	
	$i = $i + 1;
}

//////////////////////////



	$pdf->Ln();	
	$pdf->SetX(145);
	
$pdf->Output();
?>
