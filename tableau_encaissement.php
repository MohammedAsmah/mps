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
$y_axis_initial = 25;$y_axis = 25;$row_height=6;$l=25;
	$date=$_GET['date_enc'];$vendeur=$_GET['vendeur'];$id_registre=$_GET['id_registre'];
	$total_e=0;$total_c=0;$total_t=0;
	$bon_sortie=$_GET['bon_sortie'];$t=$_GET['t'];$dest=$_GET['dest'];$a="A";

//print column titles for the actual page
$pdf->SetFillColor(255);
$pdf->SetY(5);
$pdf->SetFont('arial','B',18);
$pdf->Cell(20,6,'M.P.S',1,0,'L',1);
$pdf->SetX(260);$d=dateUsToFr($date);
$pdf->Cell(34,6,$d,1,0,'L',1);
$pdf->SetFont('arial','B',14);
$pdf->SetY(15);$t_show="Tableau ".$t."  BS : ".$bon_sortie."   ".$vendeur." - ".$dest;
$pdf->Cell(0,6,$t_show,1,0,'L',1);
$pdf->SetFont('arial','B',12);
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
	$sql .= "FROM porte_feuilles where impaye=0 and id_registre_regl='$id_registre' and e_e=0 and numero_cheque<>'$a' Group BY id;";
$users11 = db_query($database_name, $sql);

//initialize counter
$i = 0;

//Set maximum rows per page
$max = 19;

//Set Row Height
$row_height = 7;$t_espece=0;
/*while($row = mysql_fetch_array($result))*/
while($row = fetch_array($users11))
{
	//If the current row is the last one, create new page and print column title
	if ($i >= $max)
	{
		$pdf->AddPage();

		//print column titles for the current page
		/*$pdf->SetY($y_axis_initial);*/
		$pdf->SetY(5);
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
		/*$y_axis = $y_axis + $row_height;*/
		$y_axis=15;
		
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
	$pdf->SetY($y_axis);if ($id_registre==704){$v=0;}else{$v=$total_espece-($total_avoir+$total_diff_prix);}
	$pdf->SetX(15);
	$pdf->Cell(90,6,$client,1,0,'L',1);
	$pdf->Cell(25,6,$total_e,1,0,'R',1);
	$pdf->Cell(25,6,$total_avoir,1,0,'R',1);
	$pdf->Cell(25,6,$total_diff_prix,1,0,'R',1);
	$pdf->Cell(25,6,$v,1,0,'R',1);
	$pdf->Cell(25,6,$total_cheque,1,0,'R',1);
	$pdf->Cell(25,6,$total_effet,1,0,'R',1);
	$pdf->Cell(25,6,$total_virement,1,0,'R',1);

	//Go to next row
	$y_axis = $y_axis + $row_height;$l=$l+5;
	$i = $i + 1;
	}
	
		
	$pdf->Ln();	$t_espe=number_format($t_espece,2,',',' ');
	$pdf->SetX(155);
	$pdf->Cell(25,6,'Total : ',1,0,'L',1);
	$pdf->Cell(25,6,$t_espe,1,0,'R',1);
	$i = $i + 1;
	if ($i >= $max)
	{
		$pdf->AddPage();
		$i=0;$y_axis_initial = 25;$y_axis = 25;$row_height=6;$l=25;
		$pdf->SetFillColor(255);
$pdf->SetY(5);
$pdf->SetFont('arial','B',18);
$pdf->Cell(20,6,'M.P.S',1,0,'L',1);
$pdf->SetX(260);$d=dateUsToFr($date);
$pdf->Cell(34,6,$d,1,0,'L',1);
$pdf->SetFont('arial','B',14);
$pdf->SetY(15);$t_show="Tableau ".$t."  BS : ".$bon_sortie."   ".$vendeur." - ".$dest;
$pdf->Cell(0,6,$t_show,1,0,'L',1);
$pdf->SetFont('arial','B',12);
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
$y_axis = $y_axis + $row_height;$pdf->SetY($y_axis+10);
$pdf->SetX(120);
	$pdf->Cell(60,6,'REPPORT',1,0,'L',1);
	$pdf->Cell(25,6,$t_espe,1,0,'R',1);$y_axis = $y_axis + $row_height;
		}
	
	$sql  = "SELECT * ";
	$sql .= "FROM registre_reglements where id='$id_registre' ORDER BY id;";
	$users11 = db_query($database_name, $sql);$user_ = fetch_array($users11);
		$libelle1=$user_["libelle1"];$montant1=$user_["montant1"];
		$libelle2=$user_["libelle2"];$montant2=$user_["montant2"];
		$libelle3=$user_["libelle3"];$montant3=$user_["montant3"];
		$libelle4=$user_["libelle4"];$montant4=$user_["montant4"];
		$libelle5=$user_["libelle5"];$montant5=$user_["montant5"];
		$libelle6=$user_["libelle6"];$montant6=$user_["montant6"];
		$libelle7=$user_["libelle7"];$montant7=$user_["montant7"];
		$libelle8=$user_["libelle8"];$montant8=$user_["montant8"];
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
	
	$pdf->SetY($y_axis);
	$pdf->Ln();
	if($montant1<>0){
	$pdf->Ln();$y_axis=$y_axis+5;
	$pdf->SetX(120);
	$pdf->Cell(60,6,$libelle1,1,0,'L',1);
	$pdf->Cell(25,6,$montant1,1,0,'R',1);
	$i = $i + 1;
	if ($i >= $max)
	{
		$pdf->AddPage();
		$i=0;
		}
	} 	
	
	if($montant2<>0){

	$pdf->Ln();$y_axis=$y_axis+5;
	$pdf->SetX(120);
	$pdf->Cell(60,6,$libelle2,1,0,'L',1);
	$pdf->Cell(25,6,$montant2,1,0,'R',1);
	$i = $i + 1;
	if ($i >= $max)
	{
		$pdf->AddPage();
		$i=0;
		}
	} 
	if($montant3<>0){
	$pdf->Ln();$y_axis=$y_axis+5;
	$pdf->SetX(120);
	$pdf->Cell(60,6,$libelle3,1,0,'L',1);
	$pdf->Cell(25,6,$montant3,1,0,'R',1);
	$i = $i + 1;
	if ($i >= $max)
	{
		$pdf->AddPage();
		$i=0;
		}
	} 	
	if($montant4<>0){
	$pdf->Ln();$y_axis=$y_axis+5;
	$pdf->SetX(120);
	$pdf->Cell(60,6,$libelle4,1,0,'L',1);
	$pdf->Cell(25,6,$montant4,1,0,'R',1);
	$i = $i + 1;
	if ($i >= $max)
	{
		$pdf->AddPage();
		$i=0;
		}
	} 	
	if($montant5<>0){
	$pdf->Ln();$y_axis=$y_axis+5;
	$pdf->SetX(120);
	$pdf->Cell(60,6,$libelle5,1,0,'L',1);
	$pdf->Cell(25,6,$montant5,1,0,'R',1);
	$i = $i + 1;
	if ($i >= $max)
	{
		$pdf->AddPage();
		$i=0;
		}
	} 	
	if($montant6<>0){
	$pdf->Ln();$y_axis=$y_axis+5;
	$pdf->SetX(120);
	$pdf->Cell(60,6,$libelle6,1,0,'L',1);
	$pdf->Cell(25,6,$montant6,1,0,'R',1);
	$i = $i + 1;
	if ($i >= $max)
	{
		$pdf->AddPage();
		$i=0;
		}
	} 	
	if($montant7<>0){
	$pdf->Ln();$y_axis=$y_axis+5;
	$pdf->SetX(120);
	$pdf->Cell(60,6,$libelle7,1,0,'L',1);
	$pdf->Cell(25,6,$montant7,1,0,'R',1);
	$i = $i + 1;
	if ($i >= $max)
	{
		$pdf->AddPage();
		$i=0;
		}
	} 	
	if($montant8<>0){
	$pdf->Ln();$y_axis=$y_axis+5;
	$pdf->SetX(120);
	$pdf->Cell(60,6,$libelle8,1,0,'L',1);
	$pdf->Cell(25,6,$montant8,1,0,'R',1);
	$i = $i + 1;
	if ($i >= $max)
	{
		$pdf->AddPage();
		$i=0;
		}
	}
	$y_axis=$y_axis+15;$pdf->SetY($y_axis);
	$pdf->Ln();
	$pdf->SetX(120);
	$pdf->Cell(60,6,'Total : ',1,0,'L',1);
	$net=number_format($t_espece-($montant1+$montant2+$montant3+$montant4+$montant5+$montant6+$montant7+$montant8),2,',',' ');
	$pdf->Cell(25,6,$net,1,0,'R',1);
	$y_axis=$y_axis+15;$y=0;
	
	$i = $i + 1;
	if ($i >= $max)
	{
		$pdf->AddPage();
		$i=0;
		}
	
	
	
	if ($cheque1>0){
	$pdf->Ln();$y=$y+5;
	$pdf->SetX(60);
	$pdf->Cell(120,6,$obj1,1,0,'L',1);
	$pdf->Cell(25,6,$cheque1,1,0,'R',1);
	$i = $i + 1;
	if ($i >= $max)
	{
		$pdf->AddPage();
		$i=0;
		}
	}
	if ($cheque2>0){
	$pdf->Ln();$y=$y+5;
	$pdf->SetX(60);
	$pdf->Cell(120,6,$obj2,1,0,'L',1);
	$pdf->Cell(25,6,$cheque2,1,0,'R',1);
	$i = $i + 1;
	if ($i >= $max)
	{
		$pdf->AddPage();
		$i=0;
		}
	}
	if ($cheque3>0){
	$pdf->Ln();$y=$y+5;
	$pdf->SetX(60);
	$pdf->Cell(120,6,$obj3,1,0,'L',1);
	$pdf->Cell(25,6,$cheque3,1,0,'R',1);
	$i = $i + 1;
	if ($i >= $max)
	{
		$pdf->AddPage();
		$i=0;
		}
	}
	if ($cheque4>0){
	$pdf->Ln();$y=$y+5;
	$pdf->SetX(60);
	$pdf->Cell(120,6,$obj4,1,0,'L',1);
	$pdf->Cell(25,6,$cheque4,1,0,'R',1);
	$i = $i + 1;
	if ($i >= $max)
	{
		$pdf->AddPage();
		$i=0;
		}
	}
	if ($cheque5>0){
	$pdf->Ln();$y=$y+5;
	$pdf->SetX(60);
	$pdf->Cell(120,6,$obj5,1,0,'L',1);
	$pdf->Cell(25,6,$cheque5,1,0,'R',1);
	$i = $i + 1;
	if ($i >= $max)
	{
		$pdf->AddPage();
		$i=0;
		}
	}
	if ($cheque6>0){
	$pdf->Ln();$y=$y+5;
	$pdf->SetX(60);
	$pdf->Cell(120,6,$obj6,1,0,'L',1);
	$pdf->Cell(25,6,$cheque6,1,0,'R',1);
	$i = $i + 1;
	if ($i >= $max)
	{
		$pdf->AddPage();
		$i=0;
		}
	}
	if ($cheque7>0){
	$pdf->Ln();$y=$y+5;
	$pdf->SetX(60);
	$pdf->Cell(120,6,$obj7,1,0,'L',1);
	$pdf->Cell(25,6,$cheque7,1,0,'R',1);
	$i = $i + 1;
	if ($i >= $max)
	{
		$pdf->AddPage();
		$i=0;
		}
	}
	if ($cheque8>0){
	$pdf->Ln();$y=$y+5;
	$pdf->SetX(60);
	$pdf->Cell(120,6,$obj8,1,0,'L',1);
	$pdf->Cell(25,6,$cheque8,1,0,'R',1);
	$i = $i + 1;
	if ($i >= $max)
	{
		$pdf->AddPage();
		$i=0;
		}
	}
	if ($cheque9>0){
	$pdf->Ln();$y=$y+5;
	$pdf->SetX(60);
	$pdf->Cell(120,6,$obj9,1,0,'L',1);
	$pdf->Cell(25,6,$cheque9,1,0,'R',1);
	$i = $i + 1;
	if ($i >= $max)
	{
		$pdf->AddPage();
		$i=0;
		}
	}
	if ($cheque10>0){
	$pdf->Ln();$y=$y+5;
	$pdf->SetX(60);
	$pdf->Cell(120,6,$obj10,1,0,'L',1);
	$pdf->Cell(25,6,$cheque10,1,0,'R',1);
	$i = $i + 1;
	if ($i >= $max)
	{
		$pdf->AddPage();
		$i=0;
		}
	}
	

	$pdf->Ln();
		
	$sql  = "SELECT * ";$t_imp=0;
	$sql .= "FROM porte_feuilles_impayes where tableau='$id_registre' Group BY id;";
	$users11 = db_query($database_name, $sql);
	
	
$y_axis = $y_axis + $y;
	while($row1 = fetch_array($users11))
	{
	
/*	$i = $i + 1;
	if ($i >= $max)
	{
		$pdf->AddPage();
		$i=0;
		}
		*/
		$y_axis = $y_axis + 5;

	$libelle = "Encaisst. impayé / ".$row1['client']."/".$row1['numero_cheque_imp'];
	$m_espece_imp = $row1['m_espece'];
	$m_virement_imp = $row1['m_virement'];
	$m_cheque_imp = $row1['m_cheque'];
	$m_effet_imp = $row1['m_effet'];
	/*$t_imp=$t_imp+$m_espece_imp+$m_virement_imp+$m_cheque_imp;*/
	$t_imp=$t_imp+$m_espece_imp;
	$pdf->SetY($y_axis);
	$pdf->SetX(15);$l="";
	$pdf->Cell(165,6,$libelle,1,0,'L',1);
	$pdf->Cell(25,6,number_format($m_espece_imp,2,',',' '),1,0,'R',1);
	$pdf->Cell(25,6,number_format($m_cheque_imp,2,',',' '),1,0,'R',1);
	$pdf->Cell(25,6,number_format($m_effet_imp,2,',',' '),1,0,'R',1);
	$pdf->Cell(25,6,number_format($m_virement_imp,2,',',' '),1,0,'R',1);
	
	}
	if ($t_imp>0){
	$pdf->Ln();	$t_imp1=number_format($t_imp,2,',',' ');
	$pdf->SetX(100);
	$pdf->Cell(80,6,'Total Encaiss impayes : ',1,0,'L',1);
	$pdf->Cell(25,6,$t_imp1,1,0,'R',1);
	$i = $i + 1;
	if ($i >= $max)
	{
		$pdf->AddPage();
		$i=0;
		}
	}

	$pdf->Ln();
	$cheque=$cheque1+$cheque2+$cheque3+$cheque4+$cheque5+$cheque6+$cheque7+$cheque8+$cheque9+$cheque10;
	/*$cheque=0;*/
	$pdf->SetX(100);$net_enc=number_format($t_espece-($montant1+$montant2+$montant3+$montant4+$montant5+$montant6+$montant7+$montant8)+$cheque+$t_imp,2,',',' ');
	$pdf->Cell(80,6,'Total A encaisser : ',1,0,'L',1);
	$pdf->Cell(25,6,$net_enc,1,0,'R',1);
//Create file
$pdf->Output();
?>
