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
$y_axis_initial = 25;$y_axis = 25;$row_height=10;
	$total_e=0;$total_c=0;$total_t=0;
	$a="A";
	
	
	$id_production=$_GET["id_production"];
	
		$sql  = "SELECT * ";
		$sql .= "FROM productions WHERE id = " . $id_production . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$date = dateUsToFr($user_["date"]);$du=$user_["date"];
		// variation
	list($annee1,$mois1,$jour1) = explode('-', $du);
	$arr = mktime(0,0,0,$mois1,$jour1,$annee1); 
	$precedant=$arr-(24*60*60);
	$d_s_a=date("Y-m-d",$precedant);

//print column titles for the actual page
$pdf->SetFillColor(255);
$pdf->SetY(5);$pdf->SetX(6);
$pdf->SetFont('Courier','B',18);
$pdf->Cell(20,6,'M.P.S',0,0,'L',1);
$pdf->SetFont('Courier','B',20);
$pdf->SetY(5);$pdf->SetX(80);$t_show="FICHE DE PRODUCTION 24H  DU : ".$date;
$pdf->Cell(80,6,$t_show,0,0,'L',1);
$pdf->SetFont('Courier','B',12);
$pdf->SetY($y_axis_initial);
$pdf->SetX(5);
$pdf->SetFillColor(173);

$pdf->Cell(27,7,'MACHINE',1,0,'L',1);
$pdf->Cell(75,7,'ARTICLE',1,0,'L',1);

$pdf->Cell(22,7,'06H-14H',1,0,'C',1);
$pdf->Cell(22,7,'14H-22H',1,0,'C',1);
$pdf->Cell(22,7,'22H-06H',1,0,'C',1);

$pdf->Cell(18,7,'TOTAL',1,0,'C',1);

$pdf->Cell(16,7,'ARRET',1,0,'C',1);
$pdf->Cell(17,7,'REBUTS',1,0,'C',1);
$pdf->Cell(16,7,'POIDS',1,0,'C',1);

$pdf->Cell(16,7,'TC1',1,0,'C',1);
$pdf->Cell(16,7,'TC2',1,0,'C',1);
$pdf->Cell(16,7,'TC3',1,0,'C',1);







$pdf->SetFillColor(255);

$y_axis = $y_axis + $row_height;$t=0;

//Select the Products you want to show in your PDF file
/*$result=mysql_query('select Code,Name,Price from Products ORDER BY Code',$link);*/
	$date=dateFrToUs(date("d/m/Y"));$total=0;
	
	

	$sql  = "SELECT * ";$today=date("y-m-d");
	$sql .= "FROM details_productions where id_production='$id_production' ORDER BY ordre;";
	$users = db_query($database_name, $sql);
	

//initialize counter
$i = 0;

//Set maximum rows per page
$max = 38;

//Set Row Height
$row_height = 9;

/*while($row = mysql_fetch_array($result))*/


while($users_ = fetch_array($users))
{
	//If the current row is the last one, create new page and print column title
	if ($i >= $max)
	{
		$pdf->AddPage();

		//print column titles for the current page
		
		$pdf->SetY($y_axis_initial);
		
		$pdf->SetX(5);
		$pdf->Cell(27,7,'MACHINE',1,0,'L',1);
$pdf->Cell(75,7,'ARTICLE',1,0,'L',1);

$pdf->Cell(22,7,'06H-14H',1,0,'C',1);
$pdf->Cell(22,7,'14H-22H',1,0,'C',1);
$pdf->Cell(22,7,'22H-06H',1,0,'C',1);

$pdf->Cell(18,7,'TOTAL',1,0,'C',1);

$pdf->Cell(16,7,'ARRET',1,0,'C',1);
$pdf->Cell(17,7,'REBUTS',1,0,'C',1);
$pdf->Cell(16,7,'POIDS',1,0,'C',1);

$pdf->Cell(16,7,'TC1',1,0,'C',1);
$pdf->Cell(16,7,'TC2',1,0,'C',1);
$pdf->Cell(16,7,'TC3',1,0,'C',1);

		
		//Go to next row
		$y_axis = 34;
		
		//Set $i variable to 0 (first row)
		$i = 0;
	}
	
	
	
	 
$id_production=$id_production;$id=$users_["id"];$machine=$users_["machine"];
$obs_machine=$users_["obs_machine"];$obs_g .= '<br>'.$obs_machine;$obs_machine_1=$users_["obs_machine_1"];
$obs_machine_2=$users_["obs_machine_2"];$obs_machine_3=$users_["obs_machine_3"];
$m="<td>$machine</td>";

$p=$users_["produit"]; 

$p1=$users_["prod_6_14"];


$p2= $users_["prod_14_22"];


$p3= $users_["prod_22_6"];


$total= $users_["prod_22_6"]+$users_["prod_6_14"]+$users_["prod_14_22"];

 
$h= $users_["temps_arret_h_1"]+$users_["temps_arret_h_2"]+$users_["temps_arret_h_3"];
$m=$users_["temps_arret_m_1"]+$users_["temps_arret_m_2"]+$users_["temps_arret_m_3"];
if ($m>=60){$h1=intval($m/60);$h=$h+$h1;$m=$m-60*$h1;}
$t=$h.":".$m;
$rebut= $users_["rebut_1"]+$users_["rebut_2"]+$users_["rebut_3"];
$poids= ($users_["poids_1"]+$users_["poids_2"]+$users_["poids_3"])/3;
$tc1= $users_["tc1"];
$tc2= $users_["tc2"];
$tc3= $users_["tc3"];
	
	$pdf->SetY($y_axis);$vide="";
	$pdf->SetX(5);
	$pdf->Cell(27,6,$machine,1,0,'L',1);
	if ($machine<>"BROYEUR" and $machine<>"LAVEUSE" and $machine<>"EXTRUDEUSE") {
	$pdf->Cell(75,6,$p,1,0,'L',1);
	}
	else {
	/*$pdf->Cell(135,6,$p,1,0,'L',1);*/
	}
	
	
	if ($machine<>"BROYEUR" and $machine<>"LAVEUSE" and $machine<>"EXTRUDEUSE") {
		
	$pdf->Cell(22,6,number_format($p1,0,',',' '),1,0,'C',1);
	$pdf->Cell(22,6,number_format($p2,0,',',' '),1,0,'C',1);
	$pdf->Cell(22,6,number_format($p3,0,',',' '),1,0,'C',1);
	$pdf->SetFont('Times','B',14);
	$pdf->Cell(18,6,number_format($total,0,',',' '),1,0,'C',1);
	$pdf->SetFont('Courier','B',12);
	
	$pdf->Cell(16,6,$t,1,0,'C',1);
	$pdf->SetFont('Times','B',14);
	$pdf->Cell(17,6,$rebut,1,0,'C',1);
	$pdf->SetFont('Courier','B',12);
	$pdf->Cell(16,6,$poids,1,0,'C',1);
	
	$pdf->Cell(16,6,$tc1,1,0,'C',1);
	$pdf->Cell(16,6,$tc2,1,0,'C',1);
	$pdf->Cell(16,6,$tc3,1,0,'C',1);
	
	
	$sql2  = "SELECT * ";
	$sql2 .= "FROM details_productions where date='$d_s_a' and produit='$p' ORDER BY id;";
	$users22 = db_query($database_name, $sql2);$user_22 = fetch_array($users22);
	
		$prod_6_14_p = $user_22["prod_6_14"];
		$prod_14_22_p = $user_22["prod_14_22"];$prod_22_6_p = $user_22["prod_22_6"];
		
		$total_precedant=$prod_6_14_p+$prod_14_22_p+$prod_22_6_p;
		
		$temps_arret_h = $user_["temps_arret_h"];$temps_arret_m = $user_["temps_arret_m"];
		$obs = $user_["obs"];
		$rebut = $user_["rebut"];$tc1 = $user_["tc1"];$tc2 = $user_["tc2"];
		$tc3 = $user_["tc3"];$obs_machine = $user_["obs_machine"];$signe="?";
		if ($total_precedant>$total){$signe="-";}
		if ($total_precedant<$total){$signe="+";}
		if ($total_precedant==$total){$signe="=";}
		
	$pdf->Cell(6,6,$signe,1,0,'C',1);
	
	
	
	}
	else
	{
	$vide="..............................................................";
	  $v="";
	  $pdf->SetFont('Times','B',14);
	  $pdf->Cell(26,6,number_format($p1,3,',',' '),1,0,'C',1);
	  /*$pdf->Cell(156,6,$obs_machine_1,1,0,'C',1);*/
	  $pdf->SetFont('Courier','B',12);
	  }
	
	
	
	
	//Go to next row
	$y_axis = $y_axis + $row_height;
	
	$i = $i + 1;
}
	
	$pdf->Ln();	
	$y_axis = $y_axis + $row_height;
	$pdf->SetY($y_axis);
	$pdf->SetX(5);
	$vide1="LAVEUSE....................................................................................";
	$vide2="EXTRUDEUSE.................................................................................";
	$vide3="BROYEUR....................................................................................";
	$vide4="SECHAGE....................................................................................";
	
	$pdf->SetY(203);
	$pdf->SetX(238);
	$pdf->Cell(50,5,'Observations : Voir Verso ',0,0,'R',0);
	
	
	/*$pdf->Cell(248,7,$vide1,1,0,'L',1);
	$y_axis = $y_axis + $row_height;
	$pdf->SetY($y_axis);
	$pdf->SetX(5);
	$pdf->Cell(248,7,$vide2,1,0,'L',1);
	$y_axis = $y_axis + $row_height;
	$pdf->SetY($y_axis);
	$pdf->SetX(5);
	$pdf->Cell(248,7,$vide3,1,0,'L',1);
	/*$y_axis = $y_axis + $row_height;
	$pdf->SetY($y_axis);
	$pdf->SetX(5);
	$pdf->Cell(248,7,$vide4,1,0,'L',1);*/
	
	/*$t="TOTAL : ".number_format($s,2,',',' ');
	$pdf->Cell(43,5,$t,1,0,'R',1);*/
	
	
	$sql  = "SELECT * ";$today=date("y-m-d");
	$sql .= "FROM details_productions where id_production='$id_production' ORDER BY id;";
	$users1 = db_query($database_name, $sql);
	

	
	
//initialize counter

$pdf->AddPage();$y_axis = 5;
$i = 0;$pdf->Ln();	/*$y_axis = $y_axis + 2*$row_height;*/
$pdf->SetY($y_axis);
$pdf->SetX(5);
$pdf->Cell(33,8,'OBSERVATIONS',0,0,'L',1);

$y_axis = $y_axis + $row_height;
$pdf->SetY($y_axis);
$pdf->SetX(5);
/*$pdf->Cell(27,7,'MACHINE',1,0,'L',1);
$pdf->Cell(250,7,'OBSERVATION',1,0,'L',1);*/




//Set maximum rows per page
$max = 18;

//Set Row Height
$row_height = 4.7;  $pdf->SetFont('Courier','B',10);

/*while($row = mysql_fetch_array($result))*/


while($users_ = fetch_array($users1))
{
	//If the current row is the last one, create new page and print column title
	if ($i >= $max)
	{
		$pdf->AddPage();

		//print column titles for the current page
		
		$pdf->SetY($y_axis_initial);
		
		/*$pdf->SetX(5);
		$pdf->Cell(27,7,'MACHINE',1,0,'L',1);
		$pdf->Cell(250,7,'OBSERVATION',1,0,'L',1);*/

		
		//Go to next row
		$y_axis = 5;
		
		//Set $i variable to 0 (first row)
		$i = 0;
	}
	
	
	
	 
$id_production=$id_production;$id=$users_["id"];$machine=$users_["machine"];
$poste1=" ";$poste2=" ";$poste3=" ";
/*if ($obs_machine_1<>""){$poste1=" P1 : ";}
if ($obs_machine_2<>""){$poste2=" P2 : ";}
if ($obs_machine_3<>""){$poste3=" P3 : ";}*/
$obs_machine=$users_["obs_machine_1"]." ".$users_["obs_machine_2"]." ".$users_["obs_machine_3"];
$obs_g .= '<br>'.$obs_machine;$obs_machine_1=$users_["obs_machine_1"];
$obs_machine_2=$users_["obs_machine_2"];$obs_machine_3=$users_["obs_machine_3"];
$m="<td>$machine</td>";

$p=$users_["produit"]; 

$p1=$users_["prod_6_14"];


$p2= $users_["prod_14_22"];


$p3= $users_["prod_22_6"];


$total= $users_["prod_22_6"]+$users_["prod_6_14"]+$users_["prod_14_22"];

 
$h= $users_["temps_arret_h_1"]+$users_["temps_arret_h_2"]+$users_["temps_arret_h_3"];
$m=$users_["temps_arret_m_1"]+$users_["temps_arret_m_2"]+$users_["temps_arret_m_3"];
if ($m>=60){$h1=intval($m/60);$h=$h+$h1;$m=$m-60*$h1;}
$t=$h.":".$m;
$rebut= $users_["rebut_1"]+$users_["rebut_2"]+$users_["rebut_3"];
$poids= ($users_["poids_1"]+$users_["poids_2"]+$users_["poids_3"])/3;
$tc1= $users_["tc1"];
$tc2= $users_["tc2"];
$tc3= $users_["tc3"];
	
	/*if ($machine<>"BROYEUR" and $machine<>"LAVEUSE" and $machine<>"EXTRUDEUSE") {*/
	
	if ($obs_machine_1<>"" or $obs_machine_2<>"" or $obs_machine_3<>""){
	$pdf->SetY($y_axis);
	$pdf->SetX(5);
	$pdf->Cell(27,6,$machine,0,0,'L',1);
	$y_axis = $y_axis + $row_height;
	/*if ($obs_machine_1<>"" and $obs_machine_2<>"" and $obs_machine_3<>""){*/
	if ($obs_machine_1<>""){
	
	$pdf->SetY($y_axis);
	$pdf->SetX(30);
	$pdf->Cell(250,6,$obs_machine_1,0,0,'L',1);
	$y_axis = $y_axis + $row_height;
	$pdf->SetY($y_axis+$row_height);
	}
	if ($obs_machine_2<>""){
	$pdf->SetY($y_axis);
	$pdf->SetX(30);
	$pdf->Cell(250,6,$obs_machine_2,0,0,'L',1);
	$y_axis = $y_axis + $row_height;
	$pdf->SetY($y_axis+$row_height);
	}
	if ($obs_machine_3<>""){
	$pdf->SetY($y_axis);
	$pdf->SetX(30);
	$pdf->Cell(250,6,$obs_machine_3,0,0,'L',1);
	$y_axis = $y_axis + $row_height;
	}
	
	}
	/*}*/
	/*else
	{$pdf->SetY($y_axis);
	$pdf->SetX(5);
	$pdf->Cell(27,6,$machine,0,0,'L',1);
	$pdf->Cell(50,6,$obs_machine,0,0,'L',1);$y_axis = $y_axis + $row_height;
	}*/
	
	
	//Go to next row
	
	
	/*}*/ //OBS EXTRUDEUSE
	$i = $i + 1;
}
	$pdf->Ln();	
	$pdf->SetX(125);
	
	
	
$pdf->Output();
?>
