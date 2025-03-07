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
$pdf=new FPDF('P','mm','A4');

//Disable automatic page break
$pdf->SetAutoPageBreak(false);

//Add first page
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 25;$y_axis = 25;$row_height=8;
	$total_e=0;$total_c=0;$total_t=0;
	$a="A";

//print column titles for the actual page
$pdf->SetFillColor(255);
$pdf->SetY(5);
$pdf->SetFont('Arial','B',18);
$pdf->Cell(20,6,'M.P.S',1,0,'L',1);
$pdf->SetFont('Arial','B',20);
$pdf->SetY(5);$t_show="SITUATION FOURNISSEURS ";$pdf->SetX(60);
$pdf->Cell(127,7,$t_show,1,0,'L',1);$pdf->SetY(15);
$pdf->SetX(80);$d="AU : ".date("d/m/Y");
$pdf->Cell(60,6,$d,1,0,'L',1);
$pdf->SetFont('Arial','B',12);
$pdf->SetY($y_axis_initial);
$pdf->SetX(35);
$pdf->SetFillColor(173);
$pdf->Cell(90,8,'FOURNISSEUR',1,0,'M',1);
$pdf->Cell(43,8,'SOLDE',1,0,'R',1);
$pdf->SetFillColor(255);

$y_axis = $y_axis + $row_height;$t=0;

//Select the Products you want to show in your PDF file
/*$result=mysql_query('select Code,Name,Price from Products ORDER BY Code',$link);*/
	$date=dateFrToUs(date("d/m/Y"));$total=0;
	
	$sql  = "SELECT date,frs,produit,ref,type,taux_tva,sum(qte) As total_qte,sum(ttc) as valeur ";
	$sql .= "FROM achats_mat GROUP BY frs order by frs;";
	$users = db_query($database_name, $sql);

//initialize counter
$i = 0;

//Set maximum rows per page
$max = 38;

//Set Row Height
$row_height = 6;$debit=0;$credit=0;$t=0;$s=0;$t_avoir_t=0;$p=0;$mr=0;

/*while($row = mysql_fetch_array($result))*/
while($users_ = fetch_array($users))
{
	//If the current row is the last one, create new page and print column title
	if ($i == $max)
	{
		$pdf->AddPage();

		//print column titles for the current page
		/*$pdf->SetY($y_axis_initial);
		$pdf->SetX(125);
		$repport="Repport : ".number_format($s,2,',',' ');$pdf->Cell(40,6,$repport,1,0,'R',1);*/
		$pdf->SetY($y_axis_initial);
		
		$pdf->SetX(35);
		$pdf->Cell(90,8,'FOURNISSEUR',1,0,'M',1);
		$pdf->Cell(43,8,'SOLDE',1,0,'R',1);
		
		//Go to next row
		$y_axis = 34;
		
		//Set $i variable to 0 (first row)
		$i = 0;
	}
	$frs=$users_["frs"];$taux_tva=$users_["taux_tva"];$ref=$users_["ref"];$ttc=($users_["qte"]*$users_["prix_achat"])*(1+$users_["taux_tva"]/100);
		$sql  = "SELECT * ";$m=0;$net=$users_["valeur"];$id=$users_["id"];
		$sql .= "FROM porte_feuilles_frs WHERE vendeur = '" . $frs . "';";
		$user = db_query($database_name, $sql); $m=0;
		while($users_2 = fetch_array($user)) {
		$m=$m+$users_2["montant_e"];$mr=$mr+$users_2["montant_e"];
		}
		$solde=$net-$m;
	
	
	$p=$p+($users_["valeur"]);$s=$s+$solde;
	if ($solde>0){
	$pdf->SetY($y_axis);$vide="";
	$pdf->SetX(35);
	$pdf->Cell(90,6,$frs,1,0,'L',1);
	$pdf->Cell(43,6,number_format($solde,2,',',' '),1,0,'R',1);
	
	//Go to next row
	$y_axis = $y_axis + $row_height;
	
	$i = $i + 1;}
}
	$pdf->Ln();	
	$pdf->SetX(125);$t="TOTAL : ".number_format($s,2,',',' ');
	$pdf->Cell(43,5,$t,1,0,'R',1);
$pdf->Output();
?>
