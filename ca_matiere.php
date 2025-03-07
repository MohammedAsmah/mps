<?php
//PDF USING MULTIPLE PAGES
//CREATED BY: Carlos Vasquez S.
//E-MAIL: cvasquez@cvs.cl
//CVS TECNOLOGIA E INNOVACION
//SANTIAGO, CHILE
$valeur=3600;
set_time_limit($valeur);

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
	$du=dateUsToFr($_GET['du']);$au=dateUsToFr($_GET['au']);$du1=$_GET['du'];$au1=$_GET['au'];$total_e=0;$total_c=0;$total_t=0;
	$a="A";$t1=0;$t2=0;$t3=0;$t4=0;$t5=0;$t6=0;$t7=0;$t8=0;$t9=0;

//print column titles for the actual page
$pdf->SetFillColor(255);
$pdf->SetY(5);
$pdf->SetFont('Arial','B',18);
$pdf->Cell(20,6,'M.P.S',1,0,'L',1);
$pdf->SetX(260);$d=date("d/m/Y");
$pdf->Cell(34,6,$d,1,0,'L',1);
$pdf->SetFont('Arial','B',14);
$pdf->SetY(15);$t_show="STOCK MATIERE PREMIERE AU ".$au;
$pdf->SetX(80);
$pdf->Cell(150,6,$t_show,1,0,'C',1);
$pdf->SetFont('Arial','B',7);
$pdf->SetY($y_axis_initial);
$pdf->SetX(5);
$pdf->Cell(55,6,'Matiere',1,0,'C',1);
$pdf->Cell(23,6,'S.I. Matiere',1,0,'C',1);
$pdf->Cell(23,6,'S.I. Prod.Finis',1,0,'C',1);
$pdf->Cell(23,6,'Encours 01/01',1,0,'C',1);
$pdf->Cell(24,6,'Achats',1,0,'C',1);
$pdf->Cell(23,6,'Consome',1,0,'C',1);
$pdf->Cell(23,6,'S.Final Prod.Finis',1,0,'C',1);
$pdf->Cell(23,6,'Encours 31/12',1,0,'C',1);
$pdf->Cell(23,6,'S.F.Matiere',1,0,'C',1);
$pdf->Cell(23,6,'C.M.U.P',1,0,'C',1);
$pdf->Cell(25,8,'Valeur Matiere',1,0,'C',1);
$y_axis = $y_axis + $row_height;

//initialize counter
$i = 0;

//Set maximum rows per page
$max = 28;

//Set Row Height
$row_height = 6;

/*while($row = mysql_fetch_array($result))*/
	 $sql  = "SELECT * ";$matiere="matiere";
	$sql .= "FROM tableau_matiere where type='$matiere' ORDER BY id;";
	$users = db_query($database_name, $sql);
	$t1=0;$t2=0;$t3=0;$t4=0;$t5=0;$t6=0;$t7=0;$t8=0;$t9=0;$t10=0;

while($row = fetch_array($users))
{
	//If the current row is the last one, create new page and print column title
	if ($i == $max)
	{
		$pdf->AddPage();

		//print column titles for the current page
$pdf->SetFillColor(255);
$pdf->SetFont('Courrier','B',18);
$pdf->Cell(20,6,'M.P.S',1,0,'L',1);
$pdf->SetX(260);$d=date("d/m/Y");
$pdf->Cell(34,6,$d,1,0,'L',1);
$pdf->SetFont('Courrier','B',14);
$pdf->SetY(15);$t_show="STOCK MATIERE PREMIERE AU ".$au;
$pdf->SetX(80);
$pdf->Cell(150,6,$t_show,1,0,'C',1);
$pdf->SetY($y_axis_initial);$pdf->SetFont('Arial','B',7);
$pdf->SetX(5);
$pdf->Cell(45,6,'Matiere',1,0,'C',1);
$pdf->Cell(23,6,'S.I. Matiere',1,0,'C',1);
$pdf->Cell(23,6,'S.I. Prod.Finis',1,0,'C',1);
$pdf->Cell(23,6,'Encours 01/01',1,0,'C',1);
$pdf->Cell(26,6,'Achats',1,0,'C',1);
$pdf->Cell(26,6,'Consome',1,0,'C',1);
$pdf->Cell(23,6,'S.Final Prod.Finis',1,0,'C',1);
$pdf->Cell(23,6,'Encours 31/12',1,0,'C',1);
$pdf->Cell(26,6,'S.F.Matiere',1,0,'C',1);
$pdf->Cell(23,6,'C.M.U.P',1,0,'C',1);
$pdf->Cell(26,8,'Valeur Matiere',1,0,'C',1);
		//Go to next row
		$y_axis = 34;
		
		//Set $i variable to 0 (first row)
		$i = 0;
	}

	$matiere=$row["matiere"];
	$s_i_m=$row["s_i_m"];
	$s_i_m_p_f=$row["s_i_m_p_f"];
	$encours_1_1=$row["encours_1_1"];
	$achats_matiere=$row["achats_matiere"];
	$consome=$row["consome"];
	$s_f_p_f=$row["s_f_p_f"];
	$encours_31_12=$row["encours_31_12"];
	$s_f_m_p=$row["s_f_m_p"];
	$cmup=$row["cmup"];
	$v_f_m_p=$row["v_f_m_p"];

	$pdf->SetFont('Arial','',10);
	$pdf->SetY($y_axis);
	$pdf->SetX(5);
	$pdf->Cell(45,6,$matiere,1,0,'L',1);
	$pdf->Cell(23,6,number_format($s_i_m,3,',',' '),1,0,'R',1);
	$pdf->Cell(23,6,number_format($s_i_m_p_f,3,',',' '),1,0,'R',1);
	$pdf->Cell(23,6,number_format($encours_1_1,3,',',' '),1,0,'R',1);
	$pdf->Cell(26,6,number_format($achats_matiere,3,',',' '),1,0,'R',1);
	$pdf->Cell(26,6,number_format($consome,3,',',' '),1,0,'R',1);
	$pdf->Cell(23,6,number_format($s_f_p_f,3,',',' '),1,0,'R',1);
	$pdf->Cell(23,6,number_format($encours_31_12,3,',',' '),1,0,'R',1);
	$pdf->Cell(26,6,number_format($s_f_m_p,3,',',' '),1,0,'R',1);
	$pdf->Cell(23,6,number_format($cmup,3,',',' '),1,0,'R',1);
	$pdf->Cell(26,6,number_format($v_f_m_p,3,',',' '),1,0,'R',1);
	$y_axis = $y_axis + $row_height;
	$i = $i + 1;
	$t1=$t1+$s_i_m;
	$t2=$t2+$s_i_m_p_f;
	$t3=$t3+$encours_1_1;
	$t4=$t4+$achats_matiere;
	$t5=$t5+$consome;
	$t6=$t6+$s_f_p_f;
	$t7=$t7+$encours_31_12;
	$t8=$t8+$s_f_m_p;
	$t9=$t9+$cmup;
	$t10=$t10+$v_f_m_p;
	
	}
	$vide="";
	$pdf->SetY($y_axis+$row_height);
	$pdf->SetX(5);

	$pdf->Cell(45,6,'TOTAUX : ',1,0,'L',1);
	$pdf->Cell(23,6,number_format($t1,3,',',' '),1,0,'R',1);
	$pdf->Cell(23,6,number_format($t2,3,',',' '),1,0,'R',1);
	$pdf->Cell(20,6,number_format($t3,3,',',' '),1,0,'R',1);
	$pdf->Cell(26,6,number_format($t4,3,',',' '),1,0,'R',1);
	$pdf->Cell(25,6,number_format($t5,3,',',' '),1,0,'R',1);
	$pdf->Cell(23,6,number_format($t6,3,',',' '),1,0,'R',1);
	$pdf->Cell(20,6,number_format($t7,3,',',' '),1,0,'R',1);
	$pdf->Cell(26,6,number_format($t8,3,',',' '),1,0,'R',1);
	$pdf->Cell(23,6,$vide,1,0,'R',1);
	$pdf->Cell(26,6,number_format($t10,3,',',' '),1,0,'R',1);
	

	$pdf->SetY($y_axis+$row_height);$pdf->Ln();	$pdf->Ln();	$pdf->Ln();	
/*$pdf->Cell(150,6,'LEGENDE',1,0,'C',1);$pdf->Ln();	
$pdf->Cell(150,6,'S.I.M.---->STOCK INITIAL MATIERE',1,0,'L',1);$pdf->Ln();	
$pdf->Cell(150,6,'S.I.M.P.F---->STOCK INITIAL MATIERE PRODUITS FINIS',1,0,'L',1);$pdf->Ln();	
$pdf->Cell(150,6,'ENC 01/01 --->ENCOURS AU 01/01',1,0,'L',1);$pdf->Ln();	
$pdf->Cell(150,6,'ACHATS------->ACHATS MATIERE EXERCICE',1,0,'L',1);$pdf->Ln();	
$pdf->Cell(150,6,'CONSOME------>CONSOMME MATIERE',1,0,'L',1);$pdf->Ln();	
$pdf->Cell(150,6,'S.F.P.F------>STOCK FINAL PRODUITS FINIS',1,0,'L',1);$pdf->Ln();	
$pdf->Cell(150,6,'ENC 31/12---->ENCOURS AU 31/12',1,0,'L',1);$pdf->Ln();	
$pdf->Cell(150,6,'S.F.M.P------>STOCK FINAL MATIERE PREMIERE',1,0,'L',1);$pdf->Ln();	
$pdf->Cell(150,6,'C.M.U.P------>PRIX REVIENT',1,0,'L',1);$pdf->Ln();	
$pdf->Cell(150,8,'V.F.M.P------>VALEUR FINALE MATIERE PREMIERE',1,0,'L',1);$pdf->Ln();	
	*/
	
$pdf->Output();
?>
