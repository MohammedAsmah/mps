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
	$date1=$_GET['date1'];$vendeur=$_GET['vendeur'];$total_e=0;$total_c=0;$total_t=0;
	$a="A";$date2=$_GET['date2'];
	$date1_show=dateUsToFr($_GET['date1']);$date2_show=dateUsToFr($_GET['date2']);
//print column titles for the actual page
$pdf->SetFillColor(232);
$pdf->SetFont('Arial','B',14);
$pdf->SetY(5);$t_show="Tableau Encaissement ".$vendeur." Du ".$date1_show." Au ".$date2_show;
$pdf->Cell(250,6,$t_show,1,0,'L',1);
$pdf->SetFont('Arial','B',12);
$pdf->SetY($y_axis_initial);
$pdf->SetX(5);
$pdf->Cell(50,8,'Client',1,0,'L',1);
$pdf->Cell(18,8,'Facture',1,0,'L',1);
$pdf->Cell(25,8,'Tableau',1,0,'L',1);
$pdf->Cell(70,8,'Bon Sortie',1,0,'L',1);
$pdf->Cell(32,8,'Ref/regl',1,0,'L',1);
$pdf->Cell(25,8,'Espece',1,0,'R',1);
$pdf->Cell(25,8,'Cheque',1,0,'R',1);
$pdf->Cell(20,8,'Effet',1,0,'R',1);
$pdf->Cell(20,8,'Virmt',1,0,'R',1);
$y_axis = $y_axis + $row_height;

//Select the Products you want to show in your PDF file
/*$result=mysql_query('select Code,Name,Price from Products ORDER BY Code',$link);*/
		/*$sql  = "SELECT numero_cheque,client,sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece
		, sum(m_effet) as total_effet,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
	$sql .= "FROM porte_feuilles where (date_enc between '$date1' and '$date2') and vendeur='$vendeur' and numero_cheque<>'$a' Group BY id;";
$users11 = db_query($database_name, $sql);*/

		$sql  = "SELECT * ";//and numero_cheque<>'$a'
		$vide="";
	$sql .= "FROM porte_feuilles where (date_enc between '$date1' and '$date2') and vendeur='$vendeur' and facture_n<>'$vide' and impaye=0 Order BY date_enc;";
$users11 = db_query($database_name, $sql);

//initialize counter
$i = 0;

//Set maximum rows per page
$max = 28;

//Set Row Height
$row_height = 6;$t_espece=0;$t_cheque=0;
/*while($row = mysql_fetch_array($result))*/
while($row = fetch_array($users11))
{
	//If the current row is the last one, create new page and print column title
	if ($i == $max)
	{
		$pdf->AddPage();
		$y_axis_initial = 25;
		//print column titles for the current page
		$pdf->SetY($y_axis_initial);
		$pdf->SetX(5);
		$pdf->Cell(50,8,'Client',1,0,'L',1);
		$pdf->Cell(18,8,'Facture',1,0,'L',1);
		$pdf->Cell(25,8,'Tableau',1,0,'L',1);
		$pdf->Cell(70,8,'Bon Sortie',1,0,'L',1);
		$pdf->Cell(32,8,'Ref/regl',1,0,'L',1);
		$pdf->Cell(25,8,'Espece',1,0,'R',1);
		$pdf->Cell(25,8,'Cheque',1,0,'R',1);
		$pdf->Cell(20,8,'Effet',1,0,'R',1);
		$pdf->Cell(20,8,'Virmt',1,0,'R',1);
		
		//Go to next row
		$y_axis = $y_axis_initial; 
		
		//Set $i variable to 0 (first row)
		$i = 0;
	}
	$id_registre_regl = $row['id_registre_regl'];
	$sql1  = "SELECT * ";
	$sql1 .= "FROM registre_reglements where id='$id_registre_regl' ORDER BY id;";
	$users111 = db_query($database_name, $sql1);$users_111 = fetch_array($users111);
	$statut=$users_111["statut"];$observation=$users_111["observation"];$dest=$users_111["service"];
	$service=$users_111["service"];$code=$users_111["code_produit"];$bon=$users_111["observation"];
	$id_tableau=$users_111["bon_sortie"]."/".$users_111["mois"]."".$users_111["annee"];
	$client = $row['client'];
	$numero_cheque = $row['numero_cheque'];$facture_n = $row['facture_n'];
	$total_cheque = $row['m_cheque'];$total_espece = $row['m_espece']-$row['m_avoir']-$row['m_diff_prix'];
	$total_effet = $row['m_effet'];$total_avoir = $row['m_avoir'];$total_diff = $row['m_diff_prix'];
	$total_virement = $row['m_virement'];
	$t_cheque=$t_cheque+$total_cheque-$total_effet-$total_virement;
	$t_espece=$t_espece+$total_espece;
	$pdf->SetY($y_axis);
	$pdf->SetX(5);
	$pdf->Cell(50,6,$client,1,0,'L',1);
	$pdf->Cell(18,6,$facture_n,1,0,'L',1);
	$pdf->Cell(25,6,$id_tableau,1,0,'L',1);
	$pdf->Cell(70,6,$bon,1,0,'L',1);
	$pdf->Cell(32,6,$numero_cheque,1,0,'L',1);
	$pdf->Cell(25,6,number_format($total_espece,2,',',' '),1,0,'R',1);
	$pdf->Cell(25,6,number_format($total_cheque,2,',',' '),1,0,'R',1);
	$pdf->Cell(20,6,number_format($total_effet,2,',',' '),1,0,'R',1);
	$pdf->Cell(20,6,number_format($total_virement,2,',',' '),1,0,'R',1);

	//Go to next row
	$y_axis = $y_axis + $row_height;
	$i = $i + 1;
}
	$pdf->Ln();$t_es=number_format($t_espece,2,',',' ');$t_ch=number_format($t_cheque,2,',',' ');
	$pdf->SetX(200);
	$pdf->Cell(25,6,$t_es,1,0,'R',1);
	$pdf->Cell(25,6,$t_ch,1,0,'R',1);
	$sql  = "SELECT * ";$depenses=0;$t_enc=0;
	$sql .= "FROM registre_reglements where vendeur='$vendeur' and (date between '$date1' and '$date2') ORDER BY id;";
	$users11 = db_query($database_name, $sql);while($user_ = fetch_array($users11))
{

		$libelle1=$user_["libelle1"];$montant1=$user_["montant1"];
		$libelle2=$user_["libelle2"];$montant2=$user_["montant2"];
		$libelle3=$user_["libelle3"];$montant3=$user_["montant3"];
		$libelle4=$user_["libelle4"];$montant4=$user_["montant4"];
		$libelle5=$user_["libelle5"];$montant5=$user_["montant5"];
		$objet1=$user_["objet1"];$cheque1=$user_["cheque1"];
		$objet2=$user_["objet2"];$cheque2=$user_["cheque2"];
		$objet3=$user_["objet3"];$cheque3=$user_["cheque3"];
		$objet4=$user_["objet4"];$cheque4=$user_["cheque4"];
		$objet5=$user_["objet5"];$cheque5=$user_["cheque5"];
		$objet6=$user_["objet6"];$cheque6=$user_["cheque6"];
		$objet7=$user_["objet7"];$cheque7=$user_["cheque7"];
		$objet8=$user_["objet8"];$cheque8=$user_["cheque8"];
		$objet9=$user_["objet9"];$cheque9=$user_["cheque9"];
		$objet10=$user_["objet10"];$cheque10=$user_["cheque10"];
		$date_cheque1=dateUsToFr($user_["date_cheque1"]);$ref1=$user_["ref1"];
		$date_cheque2=dateUsToFr($user_["date_cheque2"]);$ref2=$user_["ref2"];
		$date_cheque3=dateUsToFr($user_["date_cheque3"]);$ref3=$user_["ref3"];
		$date_cheque4=dateUsToFr($user_["date_cheque4"]);$ref4=$user_["ref4"];
		$date_cheque5=dateUsToFr($user_["date_cheque5"]);$ref5=$user_["ref5"];
		$date_cheque6=dateUsToFr($user_["date_cheque6"]);$ref6=$user_["ref6"];
		$date_cheque7=dateUsToFr($user_["date_cheque7"]);$ref7=$user_["ref7"];
		$date_cheque8=dateUsToFr($user_["date_cheque8"]);$ref8=$user_["ref8"];
		$date_cheque9=dateUsToFr($user_["date_cheque9"]);$ref9=$user_["ref9"];
		$date_cheque10=dateUsToFr($user_["date_cheque10"]);$ref10=$user_["ref10"];
		$depenses=$depenses+$montant1+$montant2+$montant3+$montant4+$montant5;
		$t_enc=$t_enc+$cheque1+$cheque2+$cheque3+$cheque4+$cheque5+$cheque6+$cheque7+$cheque8+$cheque9+$cheque10;
		}
		$dep=number_format($depenses,2,',',' ');
		$net_espece=$t_espece-$depenses;$net_show=number_format($net_espece+$t_enc,2,',',' ');
		$pdf->Ln();
		$pdf->SetX(175);
		$pdf->Cell(25,6,'Depenses',1,0,'R',1);
		$pdf->Cell(25,6,$dep,1,0,'R',1);
		$pdf->Ln();
		$pdf->SetX(175);
		$pdf->Cell(25,6,'Enc/Imp',1,0,'R',1);
		$pdf->Cell(25,6,number_format($t_enc,2,',',' '),1,0,'R',1);
		$pdf->Ln();
		$pdf->SetX(175);
		$pdf->Cell(25,6,'Net Espece',1,0,'R',1);
		$pdf->Cell(25,6,$net_show,1,0,'R',1);
		
//Create file
$pdf->Output();
?>
