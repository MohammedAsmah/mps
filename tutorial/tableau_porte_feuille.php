<?php
//PDF USING MULTIPLE PAGES
//CREATED BY: Carlos Vasquez S.
//E-MAIL: cvasquez@cvs.cl
//CVS TECNOLOGIA E INNOVACION
//SANTIAGO, CHILE

require('../fpdf.php');
	require "../config.php";
	require "../connect_db.php";
	require "../functions.php";
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
$y_axis_initial = 25;$y_axis = 25;$row_height=6;
	$date1=$_GET['date1'];$total_cc=0;$total_tt=0;$date="";
	$date2=$_GET['date2'];$a="A";

//print column titles for the actual page
$pdf->SetFillColor(232);
$pdf->SetY(5);
$pdf->SetFont('Arial','B',18);
$pdf->Cell(20,6,'M.P.S',1,0,'L',1);
$pdf->SetX(260);$d=dateUsToFr($date);
$pdf->Cell(34,6,$d,1,0,'L',1);
$pdf->SetFont('Arial','B',14);
$pdf->SetY(15);$t_show="Porte Feuille ";
$pdf->Cell(0,6,$t_show,1,0,'L',1);
$pdf->SetFont('Arial','B',12);
$pdf->SetY($y_axis_initial);
$pdf->SetX(5);
$pdf->Cell(25,8,'Date Emission',1,0,'L',1);
$pdf->Cell(90,8,'Designation',1,0,'R',1);
$pdf->Cell(25,8,'N. Cheque',1,0,'R',1);
$pdf->Cell(25,8,'Banque',1,0,'R',1);
$pdf->Cell(25,8,'Date Regl',1,0,'R',1);
$pdf->Cell(25,8,'MT Cheque',1,0,'R',1);
$pdf->Cell(25,8,'Debit',1,0,'R',1);
$pdf->Cell(25,8,'Credit',1,0,'R',1);
$pdf->Cell(25,8,'Solde',1,0,'R',1);
$y_axis = $y_axis + $row_height;

//Select the Products you want to show in your PDF file
/*$result=mysql_query('select Code,Name,Price from Products ORDER BY Code',$link);*/
////////Porte feuille
	$sql  = "SELECT id,date_enc,date_cheque,client,client_tire,v_banque,numero_cheque,sum(m_cheque) As total_cheque ";
	$sql .= "FROM porte_feuilles where m_cheque<>0 and remise=0 and facture_n<>0 GROUP BY date_cheque;";
	$users11 = db_query($database_name, $sql);
	$compteur1=0;$total_g=0;
	while($users_1 = fetch_array($users11)) { 
			$date_enc=$users_1["date_enc"];
			$client=$users_1["client"];$client_tire=$users_1["client_tire"];
			$v_banque=$users_1["v_banque"];$numero_cheque=$users_1["numero_cheque"];$total_cheque=$users_1["total_cheque"];
			$ref=$v_banque." ".$numero_cheque;$date_cheque=dateUsToFr($users_1["date_cheque"]);$date_cheque1=$users_1["date_cheque"];
			$total_g=$total_g+$total_cheque;
	} 

////// entrees

	$sql  = "SELECT * ";$total_cc=0;$total_tt=0;
	$sql .= "FROM registre_reglements where date between '$date1' and '$date2' ORDER BY id;";
	$users111 = db_query($database_name, $sql);
	
	while($users_111 = fetch_array($users111)) {
	$id_r=$users_111["id"];$vendeur=$users_111["vendeur"];$tableau=$users_111["bon_sortie"]."/".$users_111["mois"].$users_111["annee"];$service=$users_111["service"];
		
	/*$sql  = "SELECT * ";
	$sql .= "FROM porte_feuilles where id_registre_regl='$id_r' and (m_cheque<>0 or m_effet<>0) ORDER BY id_registre_regl;";
	$users11 = db_query($database_name, $sql);*/
	$sql  = "SELECT facture_n,v_banque,numero_cheque,client,client_tire,client_tire_e,sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece, sum(m_effet) as total_effet
	,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix ";
	$sql .= "FROM porte_feuilles where id_registre_regl='$id_r' and m_cheque<>0 and facture_n<>0 and impaye<>1 Group BY numero_cheque;";
	$users11 = db_query($database_name, $sql);$total_c1=0;
	while($users_1 = fetch_array($users11)) { 
			
			$client=$users_1["client"];$client_tire=$users_1["client_tire"];$client_tire_e=$users_1["client_tire_e"];
			$client=$users_1["client"];$total_e=$users_1["total_e"];$total_avoir=$users_1["total_avoir"];$facture_n=$users_1["facture_n"];
			$total_cheque=$users_1["total_cheque"];$total_espece=$users_1["total_espece"];$total_effet=$users_1["total_effet"];
			$total_diff_prix=$users_1["total_diff_prix"];$numero_cheque=$users_1["numero_cheque"];$v_banque=$users_1["v_banque"];
			$total_c1=$total_c1+$total_cheque;$total_cc=$total_cc+$total_cheque;
			
	} 

	}
	$porte_feuille=$total_g;
	$entree=$total_cc;
	
////////////remise
	
	$sql  = "SELECT * ";
	$sql .= "FROM registre_remises where date between '$date1' and '$date2' ORDER BY id;";
	$users11 = db_query($database_name, $sql);
	$compteur1=0;$total_gg=0;
	while($users_1 = fetch_array($users11)) { $id_r=$users_1["id"];$date_enc=$users_1["date"];$banque=$users_1["banque"];
			$statut=$users_1["statut"];$observation=$users_1["observation"];$dest=$users_1["service"];$date_remise=$users_1["date"];
			$service=$users_1["service"];$code=$users_1["code_produit"];$id_tableau=$users_1["id"]."/2008";$bon=$users_1["statut"];
			$t=$users_1["bon_sortie"]."/".$users_1["mois"]."".$users_1["annee"]; 
			$sql  = "SELECT * ";
			$sql .= "FROM porte_feuilles where numero_remise=$id_r ORDER BY id;";
			$users = db_query($database_name, $sql);
			$total_g=0;
			while($users_ = fetch_array($users)) { 
				$m_cheque=$users_["m_cheque"];
				$total_gg=$total_gg+$m_cheque;
			 }
	 } 
	 
$remise=$total_gg;

$report=$porte_feuille-$entree+$remise;

	?>
	
	<? $sql  = "SELECT date_enc,date_cheque,facture_n,v_banque,numero_cheque,client,client_tire,client_tire_e,sum(montant_e) as total_e,sum(m_cheque) as 
	total_cheque,sum(m_espece) as 
	total_espece, sum(m_effet) as total_effet
	,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix ";
	$sql .= "FROM porte_feuilles where (date_enc='$date1' or date_remise='$date1') and m_cheque<>0 and facture_n<>0 and impaye<>1 Group BY id;";
	$users11 = db_query($database_name, $sql);$t_c=0;$total_c1=$report;


//initialize counter
$i = 0;

//Set maximum rows per page
$max = 25;

//Set Row Height
$row_height = 6;$t_espece=0;
/*while($row = mysql_fetch_array($result))*/
while($row = fetch_array($users11))
{
	//If the current row is the last one, create new page and print column title
	if ($i == $max)
	{
		$pdf->AddPage();

		//print column titles for the current page
		$pdf->SetY($y_axis_initial);
		$pdf->SetX(5);
		$pdf->Cell(25,8,'Date Emission',1,0,'L',1);
		$pdf->Cell(90,8,'Designation',1,0,'R',1);
		$pdf->Cell(25,8,'N. Cheque',1,0,'R',1);
		$pdf->Cell(25,8,'Banque',1,0,'R',1);
		$pdf->Cell(25,8,'Date Regl',1,0,'R',1);
		$pdf->Cell(25,8,'MT Cheque',1,0,'R',1);
		$pdf->Cell(25,8,'Debit',1,0,'R',1);
		$pdf->Cell(25,8,'Credit',1,0,'R',1);
		$pdf->Cell(25,8,'Solde',1,0,'R',1);
		
		//Go to next row
		$y_axis = $y_axis + $row_height;
		
		//Set $i variable to 0 (first row)
		$i = 0;
	}

	$client=$users_1["client"];$client_tire=$users_1["client_tire"];$client_tire_e=$users_1["client_tire_e"];$date_enc=dateUsToFr($users_1["date_enc"]);
	$client=$users_1["client"];$total_e=$users_1["total_e"];$total_avoir=$users_1["total_avoir"];$facture_n=$users_1["facture_n"];
	$total_cheque=$users_1["total_cheque"];$total_espece=$users_1["total_espece"];$total_effet=$users_1["total_effet"];$date_cheque=dateUsToFr($users_1[
	"date_cheque"]);
	$total_diff_prix=$users_1["total_diff_prix"];$numero_cheque=$users_1["numero_cheque"];$v_banque=$users_1["v_banque"];
	$total_c1=$total_c1+$total_cheque;$t_c=$t_c+$total_cheque;
	$pdf->SetY($y_axis);
	$pdf->SetX(5);$client=$client."/".$client_tire;
	$tcc=number_format($total_cheque,2,',',' ');$tcc1=number_format($total_c1,2,',',' ');
	$pdf->Cell(90,6,$date_enc,1,0,'L',1);$vide="";
	$pdf->Cell(25,6,$client,1,0,'R',1);
	$pdf->Cell(25,6,$numero_cheque,1,0,'R',1);
	$pdf->Cell(25,6,$v_banque,1,0,'R',1);
	$pdf->Cell(25,6,$date_cheque,1,0,'R',1);
	$pdf->Cell(25,6,$tcc,1,0,'R',1);
	$pdf->Cell(25,6,$ttc,1,0,'R',1);
	$pdf->Cell(25,6,$vide,1,0,'R',1);
	$pdf->Cell(25,6,$tcc1,1,0,'R',1);

	//Go to next row
	$y_axis = $y_axis + $row_height;
	$i = $i + 1;
}
	$pdf->Ln();	
	$pdf->SetX(155);
	$pdf->Cell(25,6,'Total : ',1,0,'L',1);
	$pdf->Cell(25,6,$vide,1,0,'R',1);

//Create file
$pdf->Output();
?>
