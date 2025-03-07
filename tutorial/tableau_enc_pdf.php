<?php
//SHOW A DATABASE ON A PDF FILE
//CREATED BY: Carlos Vasquez S.
//E-MAIL: cvasquez@cvs.cl
//CVS TECNOLOGIA E INNOVACION
//SANTIAGO, CHILE

require('../fpdf.php');
	require "../config.php";
	require "../connect_db.php";
	require "../functions.php";

//Connect to your database
//Connexion à la base
/*mysql_connect('localhost','root','');
mysql_select_db('mps2008');*/

	$date=$_GET['date_enc'];$vendeur=$_GET['vendeur'];$id_registre=$_GET['id_registre'];$total_e=0;$total_c=0;$total_t=0;
	$bon_sortie=$_GET['bon_sortie'];$t=$_GET['t'];$dest=$_GET['dest'];$a="A";
	
/*	$sql  = "SELECT numero_cheque,client,sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece, sum(m_effet) as total_effet
	,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
	$sql .= "FROM porte_feuilles where id_registre_regl='$id_registre' and numero_cheque<>'$a' Group BY id;";
	$users11 = db_query($database_name, $sql);*/

//Select the Products you want to show in your PDF file
/*$result=mysql_query('select client,montant_e,m_cheque,m_espece,m_effet,m_avoir,m_diff_prix,m_virement FROM porte_feuilles
 where id_registre_regl=$id_registre Order BY client');*/
		$sql  = "SELECT numero_cheque,client,sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece, sum(m_effet) as total_effet
	,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
	$sql .= "FROM porte_feuilles where id_registre_regl='$id_registre' and numero_cheque<>'$a' ands impaye=0 Group BY id;";
$users11 = db_query($database_name, $sql);

$number_of_products = mysql_numrows($users11);

//Initialize the 3 columns and the total
$column_client = "";
$column_eval = "";
$column_avoir = "";
$column_cheque = "";
$total = 0;
$compteur1=0;$total_g=0;$t_espece=0;
while($users_1 = fetch_array($users11)) { 
			$client=substr($users_1["client"],0,50);$total_e=$users_1["total_e"];$total_avoir=$users_1["total_avoir"];
	$total_cheque=number_format($users_1["total_cheque"],',','.','.');
	$total_e_show=number_format($users_1["total_e"],',','.','.');
	$total_avoir_show=number_format($users_1["total_avoir"],',','.','.');
	$column_client = $column_client.$client."\n";
	$column_eval = $column_eval.$total_e_show."\n";
	$column_avoir = $column_avoir.$total_avoir_show."\n";
	$column_cheque = $column_cheque.$total_cheque."\n";
	
}


//For each row, add the field to the corresponding column
/*while($row = mysql_fetch_array($result))
{
	$code = $row["Code"];
	$name = substr($row["Name"],0,20);
	$real_price = $row["Price"];
	$price_to_show = number_format($row["Price"],',','.','.');

	$column_code = $column_code.$code."\n";
	$column_name = $column_name.$name."\n";
	$column_price = $column_price.$price_to_show."\n";

	//Sum all the Prices (TOTAL)
	$total = $total+$real_price;
}
mysql_close();*/

//Convert the Total Price to a number with (.) for thousands, and (,) for decimals.
/*$total = number_format($total,',','.','.');*/

//Create a new PDF file
$pdf=new FPDF('L','mm','A4');
$pdf->AddPage();

//Fields Name position
$Y_Fields_Name_position = 20;
//Table position, under Fields Name
$Y_Table_Position = 26;

//First create each Field Name
//Gray color filling each Field Name box
$pdf->SetFillColor(232,232,232);
//Bold Font for Field Name
$pdf->SetFont('Arial','B',12);
$pdf->SetY($Y_Fields_Name_position);
$pdf->SetX(45);
$pdf->Cell(20,6,'Client',1,0,'L',1);
$pdf->SetX(145);
$pdf->Cell(50,6,'Eval',1,0,'L',1);
$pdf->SetX(195);
$pdf->Cell(30,6,'Avoir',1,0,'R',1);
$pdf->SetX(225);
$pdf->Cell(30,6,'Cheque',1,0,'R',1);
$pdf->Ln();

//Now show the 3 columns
$pdf->SetFont('Arial','',12);
$pdf->SetY($Y_Table_Position);
$pdf->SetX(45);
$pdf->MultiCell(50,6,$column_client,1);
$pdf->SetY($Y_Table_Position);
$pdf->SetX(145);
$pdf->MultiCell(20,6,$column_eval,1);
$pdf->SetY($Y_Table_Position);
$pdf->SetX(195);
$pdf->MultiCell(30,6,$column_avoir,1,'R');
$pdf->SetY($Y_Table_Position);
$pdf->SetX(225);
$pdf->MultiCell(30,6,$column_cheque,1,'R');
/*$pdf->MultiCell(30,6,'$ '.$total,1,'R');*/

//Create lines (boxes) for each ROW (Product)
//If you don't use the following code, you don't create the lines separating each row
$i = 0;
$pdf->SetY($Y_Table_Position);
while ($i < $number_of_products)
{
	$pdf->SetX(45);
	$pdf->MultiCell(120,6,'',1);
	$i = $i +1;
}

$pdf->Output();
?>  
