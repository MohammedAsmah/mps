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
	$date=$_GET['date_enc'];$vendeur=$_GET['vendeur'];$id_registre=$_GET['id_registre'];$total_e=0;$total_c=0;$total_t=0;
	$bon_sortie=$_GET['bon_sortie'];$t=$_GET['t'];$dest=$_GET['dest'];$a="A";

//print column titles for the actual page
$pdf->SetFillColor(232);
$pdf->SetFont('Arial','B',14);
$pdf->SetY(15);$t_show="Tableau Encaissement ".$t."  BS : ".$bon_sortie."    Date : ".dateUsToFr($date)."   ".$vendeur." - ".$dest;
$pdf->Cell(250,6,$t_show,1,0,'L',1);
$pdf->SetFont('Arial','B',12);
$pdf->SetY($y_axis_initial);
$pdf->SetX(15);
$pdf->Cell(90,8,'Client',1,0,'L',1);
$pdf->Cell(25,8,'Montant',1,0,'R',1);
$pdf->Cell(25,8,'Avoir',1,0,'R',1);
$pdf->Cell(25,8,'Dif/Prix',1,0,'R',1);
$pdf->Cell(25,8,'Espece',1,0,'R',1);
$pdf->Cell(25,8,'Cheque',1,0,'R',1);
$pdf->Cell(25,8,'Effet',1,0,'R',1);
$pdf->Cell(25,8,'Virmt',1,0,'R',1);
$y_axis = $y_axis + $row_height;

//Select the Products you want to show in your PDF file
/*$result=mysql_query('select Code,Name,Price from Products ORDER BY Code',$link);*/
		$sql  = "SELECT numero_cheque,client,sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece
		, sum(m_effet) as total_effet,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
	$sql .= "FROM porte_feuilles where id_registre_regl='$id_registre' and numero_cheque<>'$a' Group BY id;";
$users11 = db_query($database_name, $sql);

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
		$pdf->SetX(15);
		$pdf->Cell(90,8,'Client',1,0,'L',1);
		$pdf->Cell(25,8,'Montant',1,0,'R',1);
		$pdf->Cell(25,8,'Avoir',1,0,'R',1);
		$pdf->Cell(25,8,'Dif/Prix',1,0,'R',1);
		$pdf->Cell(25,8,'Espece',1,0,'R',1);
		$pdf->Cell(25,8,'Cheque',1,0,'R',1);
		$pdf->Cell(25,8,'Effet',1,0,'R',1);
		$pdf->Cell(25,8,'Virmt',1,0,'R',1);
		
		//Go to next row
		$y_axis = $y_axis + $row_height;
		
		//Set $i variable to 0 (first row)
		$i = 0;
	}

	$client = $row['client'];
	$total_e = $row['total_e'];
	$total_avoir = $row['total_avoir'];
	$total_diff_prix = $row['total_diff_prix'];
	$total_cheque = $row['total_cheque'];
	$total_espece = $row['total_espece'];
	$total_effet = $row['total_effet'];
	$total_virement = $row['total_virement'];
	$t_espece=$t_espece+$total_espece-$total_avoir-$total_diff_prix;
	$pdf->SetY($y_axis);
	$pdf->SetX(15);
	$pdf->Cell(90,6,$client,1,0,'L',1);
	$pdf->Cell(25,6,$total_e,1,0,'R',1);
	$pdf->Cell(25,6,$total_avoir,1,0,'R',1);
	$pdf->Cell(25,6,$total_diff_prix,1,0,'R',1);
	$pdf->Cell(25,6,$total_espece,1,0,'R',1);
	$pdf->Cell(25,6,$total_cheque,1,0,'R',1);
	$pdf->Cell(25,6,$total_effet,1,0,'R',1);
	$pdf->Cell(25,6,$total_virement,1,0,'R',1);

	//Go to next row
	$y_axis = $y_axis + $row_height;
	$i = $i + 1;
}
	$pdf->Ln();
	$pdf->SetX(180);
	$pdf->Cell(25,6,$t_espece,1,0,'R',1);

//Create file
$pdf->Output();
?>
