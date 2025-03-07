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
	$date1=$_GET['date1'];$total_e=0;$total_c=0;$total_t=0;
	$a="A";$date2=$_GET['date2'];

//print column titles for the actual page
$pdf->SetFillColor(232);
$pdf->SetY(5);
$pdf->SetFont('Arial','B',18);
$pdf->Cell(20,6,'M.P.S',1,0,'L',1);
$pdf->SetX(260);$d=date("d/m/Y");
$pdf->Cell(34,6,$d,1,0,'L',1);
$pdf->SetFont('Arial','B',14);
$pdf->SetY(15);$t_show="FACTURATION DU MOIS  : ".dateUsToFr($date1)."   ".dateUsToFr($date2);
$pdf->Cell(0,6,$t_show,1,0,'L',1);
$pdf->SetFont('Arial','B',12);
$pdf->SetY($y_axis_initial);
$pdf->SetX(15);
$pdf->Cell(23,8,'Date',1,0,'L',1);
$pdf->Cell(20,8,'Numero',1,0,'L',1);
$pdf->Cell(70,8,'Designation',1,0,'L',1);
$pdf->Cell(22,8,'HTVA',1,0,'R',1);
$pdf->Cell(22,8,'TVA',1,0,'R',1);
$pdf->Cell(22,8,'TTC',1,0,'R',1);
$pdf->Cell(22,8,'INPUT',1,0,'L',1);
$pdf->Cell(22,8,'M.T',1,0,'R',1);
$pdf->Cell(22,8,'Especes',1,0,'R',1);
$pdf->Cell(22,8,'Cheques',1,0,'R',1);
$pdf->Cell(22,8,'Effets',1,0,'R',1);
$y_axis = $y_axis + $row_height;

//Select the Products you want to show in your PDF file
/*$result=mysql_query('select Code,Name,Price from Products ORDER BY Code',$link);*/
	$sql  = "SELECT * ";
	$sql .= "FROM factures where date_f between '$date1' and '$date2' ORDER BY id;";
	$users = db_query($database_name, $sql);

//initialize counter
$i = 0;

//Set maximum rows per page
$max = 25;
$compteur=0;
//Set Row Height
$row_height = 6;$t_cheque=0;$ca=0;
/*while($row = mysql_fetch_array($result))*/
while($compteur <= 200)
{
	//If the current row is the last one, create new page and print column title
	if ($i == $max)
	{
		$pdf->AddPage();

		//print column titles for the current page
		$y_axis_initial=25;
		$pdf->SetY($y_axis_initial);
		$pdf->SetX(15);
		$pdf->Cell(23,8,'Date',1,0,'L',1);
		$pdf->Cell(20,8,'Numero',1,0,'L',1);
		$pdf->Cell(70,8,'Designation',1,0,'L',1);
		$pdf->Cell(22,8,'HTVA',1,0,'R',1);
		$pdf->Cell(22,8,'TVA',1,0,'R',1);
		$pdf->Cell(22,8,'TTC',1,0,'R',1);
		$pdf->Cell(22,8,'INPUT',1,0,'L',1);
		$pdf->Cell(22,8,'M.T',1,0,'R',1);
		$pdf->Cell(22,8,'Especes',1,0,'R',1);
		$pdf->Cell(22,8,'Cheques',1,0,'R',1);
		$pdf->Cell(22,8,'Effets',1,0,'R',1);
		
		//Go to next row
		$y_axis = 25;
		
		//Set $i variable to 0 (first row)
		$i = 0;
	}

	$pdf->SetY($y_axis);
	$pdf->SetX(15);$input="";
	$pdf->Cell(23,6,$compteur,1,0,'L',1);
	//Go to next row
	$y_axis = $y_axis + $row_height;
	$i = $i + 1;$compteur=$compteur+1;
}
	$pdf->Ln();	

	/*$sql  = "SELECT * ";
	$sql .= "FROM registre_remises where id='$id_registre' ORDER BY id;";
	$users11 = db_query($database_name, $sql);$user_ = fetch_array($users11);
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
		$obj1=$objet1."-".$date_cheque1."-".$ref1;
		$obj2=$objet2."-".$date_cheque2."-".$ref2;
		$obj3=$objet3."-".$date_cheque3."-".$ref3;
		$obj4=$objet4."-".$date_cheque4."-".$ref4;
		$obj5=$objet5."-".$date_cheque5."-".$ref5;
		$obj6=$objet6."-".$date_cheque6."-".$ref6;
		$obj7=$objet7."-".$date_cheque7."-".$ref7;
		$obj8=$objet8."-".$date_cheque8."-".$ref8;
		$obj9=$objet9."-".$date_cheque9."-".$ref9;
		$obj10=$objet10."-".$date_cheque10."-".$ref10;


	/*$pdf->Ln();
	$pdf->SetX(190);
	$pdf->Cell(60,6,$libelle1,1,0,'L',1);
	$pdf->Cell(25,6,$montant1,1,0,'R',1);
	$pdf->Ln();
	$pdf->SetX(205);
	$pdf->Cell(60,6,$libelle2,1,0,'L',1);
	$pdf->Cell(25,6,$montant2,1,0,'R',1);
	$pdf->Ln();
	$pdf->SetX(205);
	$pdf->Cell(60,6,$libelle3,1,0,'L',1);
	$pdf->Cell(25,6,$montant3,1,0,'R',1);
	$pdf->Ln();
	$pdf->SetX(205);
	$pdf->Cell(60,6,$libelle4,1,0,'L',1);
	$pdf->Cell(25,6,$montant4,1,0,'R',1);
	$pdf->Ln();
	$pdf->SetX(205);
	$pdf->Cell(60,6,$libelle5,1,0,'L',1);
	$pdf->Cell(25,6,$montant5,1,0,'R',1);
	$pdf->SetX(205);
	$pdf->Cell(60,6,'Total : ',1,0,'L',1);
	$net=number_format($t_cheque+($montant1+$montant2+$montant3+$montant4+$montant5),2,',',' ');
	$pdf->Cell(25,6,$net,1,0,'R',1);*/
	
	/*if ($cheque1>0){
	$pdf->Ln();
	$pdf->SetX(137);
	$pdf->Cell(90,6,$obj1,1,0,'L',1);
	$pdf->Cell(22,6,$cheque1,1,0,'R',1);
	}
	if ($cheque2>0){
	$pdf->Ln();
	$pdf->SetX(137);
	$pdf->Cell(90,6,$obj2,1,0,'L',1);
	$pdf->Cell(22,6,$cheque2,1,0,'R',1);
	}
	if ($cheque3>0){
	$pdf->Ln();
	$pdf->SetX(137);
	$pdf->Cell(90,6,$obj3,1,0,'L',1);
	$pdf->Cell(22,6,$cheque3,1,0,'R',1);
	}
	if ($cheque4>0){
	$pdf->Ln();
	$pdf->SetX(137);
	$pdf->Cell(90,6,$obj4,1,0,'L',1);
	$pdf->Cell(22,6,$cheque4,1,0,'R',1);
	}
	if ($cheque5>0){
	$pdf->Ln();
	$pdf->SetX(137);
	$pdf->Cell(90,6,$obj5,1,0,'L',1);
	$pdf->Cell(22,6,$cheque5,1,0,'R',1);
	}
	if ($cheque6>0){
	$pdf->Ln();
	$pdf->SetX(137);
	$pdf->Cell(90,6,$obj6,1,0,'L',1);
	$pdf->Cell(22,6,$cheque6,1,0,'R',1);
	}
	if ($cheque7>0){
	$pdf->Ln();
	$pdf->SetX(137);
	$pdf->Cell(90,6,$obj7,1,0,'L',1);
	$pdf->Cell(22,6,$cheque7,1,0,'R',1);
	}
	if ($cheque8>0){
	$pdf->Ln();
	$pdf->SetX(137);
	$pdf->Cell(90,6,$obj8,1,0,'L',1);
	$pdf->Cell(22,6,$cheque8,1,0,'R',1);
	}
	if ($cheque9>0){
	$pdf->Ln();
	$pdf->SetX(137);
	$pdf->Cell(90,6,$obj9,1,0,'L',1);
	$pdf->Cell(22,6,$cheque9,1,0,'R',1);
	}
	if ($cheque10>0){
	$pdf->Ln();
	$pdf->SetX(137);
	$pdf->Cell(90,6,$obj10,1,0,'L',1);
	$pdf->Cell(22,6,$cheque10,1,0,'R',1);
	}
	$pdf->Ln();
	$pdf->Ln();
	$cheque=$cheque1+$cheque2+$cheque3+$cheque4+$cheque5+$cheque6+$cheque7+$cheque8+$cheque9+$cheque10;
	$pdf->SetX(137);$net_enc=number_format($t_cheque+($montant1+$montant2+$montant3+$montant4+$montant5)+$cheque,2,',',' ');
	$pdf->Cell(90,6,'Total Remise : ',1,0,'L',1);
	$pdf->Cell(22,6,$net_enc,1,0,'R',1);*/
//Create file
$pdf->Output();
?>
