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
	require "chiffres_lettres.php";
//Connect to your database
/*mysql_connect('localhost','root','');
mysql_select_db('mps2008');*/

//Create new pdf file
//$pdf=new FPDF('P','mm','A4');

/*$dimension = array(210,188);*/
$dimension = array(210,215);
$pdf=new FPDF('P', 'mm', $dimension);


//Disable automatic page break
$pdf->SetAutoPageBreak(false);
$pdf->SetFont('Times','',12);
//Add first page
/*$pdf->AddPage();*/

//set initial y axis position per page


/*$y_axis_initial = 25;$y_axis = 25;le 12/12/2011*/

$y_axis_initial = 5;$y_axis = 5;

$row_height=4;
	$date1=$_GET['date1'];$total_e=0;$total_c=0;$total_t=0;
	$a="A";$date2=$_GET['date2'];

//print column titles for the actual page
$pdf->SetFillColor(255);
$pdf->SetY(5);
$y_axis = $y_axis + $row_height;

//Select the Products you want to show in your PDF file
/*$result=mysql_query('select Code,Name,Price from Products ORDER BY Code',$link);*/
	$sql  = "SELECT * ";
	$sql .= "FROM factures where (date_f between '$date1' and '$date2') and montant>0 ORDER BY id;";
	$users = db_query($database_name, $sql);

//initialize counter
$i = 0;$t=0;

//Set maximum rows per page
$max = 28;

//Set Row Height
$row_height = 4;$t_cheque=0;$ca=0;$htva_t=0;$tva_t=0;$ttc_t=0;$espece=0;$cheque=0;$effet=0;$tmt_t=0;$t_espece=0;
	$t_cheque_t = 0;
	$t_espece_t = 0;
	$t_effet_t = 0;$t_virement_t = 0;

/*while($row = mysql_fetch_array($result))*/
while($row = fetch_array($users))
{
	//If the current row is the last one, create new page and print column title
	$ville="";$client=$row["client"];$id=$row["id"];$f=$row["numero"];$d=$row["date_f"];$m=$row["montant"];$lettres=int2str($m)." dhs";
		$sql  = "SELECT * ";
		$sql .= "FROM clients WHERE client = '" . $client . "';";
		$user_c = db_query($database_name, $sql); $user_cc = fetch_array($user_c);
		$adr = $user_cc["adrresse"];$ville = $user_cc["ville"];if ($adr==$ville){$adr="";}
		
		$pdf->AddPage();$pdf->SetFont('Times','',12);

		


$pdf->SetY(5);$t_show="Mode de Reglement ";


$pdf->SetY($y_axis_initial);
/*$pdf->SetX(5);
$pdf->Cell(30,8,'Code',1,0,'C',1);
$pdf->Cell(90,8,'Designation',1,0,'C',1);
$pdf->Cell(30,8,'Quantite',1,0,'C',1);
$pdf->Cell(30,8,'Prix Unitaire',1,0,'C',1);
$pdf->Cell(30,8,'Montant',1,0,'C',1);*/
$pdf->SetFont('Arial','B',14);
		//Go to next row
		$y_axis = 34;
		
		//Set $i variable to 0 (first row)
		$i = 0;

	$numero = $row['id']+9040;$htt=$row["ht"];$numero_facture = "Facture : ".$numero;
	$client=$row["client"];$id=$row["id"];$f=$row["numero"];$d=$row["date_f"];$client_se=Trim($client);
	$evaluation=$row["evaluation"]; $client=$row["client"];$user_id=$row["id"];$facture=$row["id"]+9040;
	$total_e = 0;$total_avoir = 0;$date=dateUsToFr($row["date_f"]);$d=dateUsToFr($row["date_f"]);
	$brut=0;$brut_sans=0;
	$remise10 = $row["remise_10"];$remise2 = $row["remise_2"];
	$sans_remise = $row["sans_remise"];$remise3 = $row["remise_3"];
	
	$sql  = "SELECT id,date_enc,date_cheque,date_remise,client,client_tire,v_banque,numero_cheque,numero_effet,sum(m_cheque) As total_cheque ,
	sum(m_espece) As total_espece,sum(m_effet) As total_effet,sum(m_virement) As total_virement ";
	$sql .= "FROM porte_feuilles where facture_n=$numero Group BY id;";
	$users11 = db_query($database_name, $sql);
	
	
	
	$y_axis_d=47;$pdf->SetY($y_axis_d);$pdf->SetFont('Times','',8);
	
	$pdf->Cell(70,0,$numero_facture,0,0,'L',1);$y_axis_d=52;
	
	while($users_1 = fetch_array($users11))
	{
		
			$date_remise=dateUsToFr($users_1["date_remise"]);$date_enc=dateUsToFr($users_1["date_enc"]);
			$client=$users_1["client"];$client_tire=$users_1["client_tire"];
			$total_espece=$users_1["total_espece"];
			$v_banque=$users_1["v_banque"];$numero_cheque=$users_1["numero_cheque"];$numero_effet=$users_1["numero_effet"];
			$total_cheque=$users_1["total_cheque"];
			$ref=$v_banque." ".$numero_cheque." ".$numero_effet;$total_effet=$users_1["total_effet"];
			$total_virement=$users_1["total_virement"];
			
			
			$dc=dateUsToFr($date_remise);
			
			$dch= dateUsToFr($date_enc);
			
		if ($total_cheque<>0){
		$tc= "Cheque : ".number_format($total_cheque,2,',',' ')." Remis le : ".$date_remise;}else{$tc="";}
		
		if ($total_espece<>0){
			$te= "Espece : ".number_format($total_espece,2,',',' ')." Le : ".$date_enc; }else{$te="";}
		
		if ($total_effet<>0){
		$tf= "Effet : ".number_format($total_effet,2,',',' '); }else{$tf="";}
			
		if ($total_virement<>0){
		$tv= "Virement : ".number_format($total_virement,2,',',' '); }else{$tv="";}
		
		
		
		
		
		
		
	$pdf->SetY($y_axis_d);
	$pdf->SetX(7);
	
	$pdf->Cell(50,0,$ref,0,0,'L',1);
		if ($total_cheque<>0){
	$pdf->Cell(50,0,$tc,0,0,'R',1);
	}
		if ($total_espece<>0){
	$pdf->Cell(50,0,$te,0,0,'R',1);}
		if ($total_effet<>0){
	$pdf->Cell(50,0,$tf,0,0,'R',1);}
		if ($total_virement<>0){
	$pdf->Cell(50,0,$tv,0,0,'R',1);}
	
	$y_axis_d = $y_axis_d + $row_height;
	
	
	
	}


	
	 
	  
	
	
		
}

$pdf->Output();
?>
