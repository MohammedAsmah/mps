<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
$valeur=3600;
set_time_limit($valeur);
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 
	} //if
	
	$date1="";$date2="";$action="Recherche";$t_cheque_t = 0;
	$t_espece_t = 0;
	$t_effet_t = 0;$t_virement_t = 0;
	$profiles_list_mois = "";$mois="";
	$sql1 = "SELECT * FROM mois_rak_08 ORDER BY id;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($mois == $temp_["mois"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_mois .= "<OPTION VALUE=\"" . $temp_["mois"] . "\"" . $selected . ">";
		$profiles_list_mois .= $temp_["mois"];
		$profiles_list_mois .= "</OPTION>";
	}
	$credit=0;$tva_r=0;$arrondi=0;$exedent=0;$avances=0;
	
	if(isset($_REQUEST["action"])){}else{?>
	
	<form id="form" name="form" method="post" action="declaration_tva.php">
	<td><?php echo "Du : "; ?><input onClick="ds_sh(this);" name="date1" value="<?php echo $date1; ?>" readonly="readonly" style="cursor: text" /></td>
	<td><?php echo "Au : "; ?><input onClick="ds_sh(this);" name="date2" value="<?php echo $date2; ?>" readonly="readonly" style="cursor: text" /></td>
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	<? }?>
	

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Factures"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>


<?
	if(isset($_REQUEST["action"]))
	{
	$date1=dateFrToUs($_POST['date1']);$date2=dateFrToUs($_POST['date2']);
	$date_d1=dateFrToUs($_POST['date1']);$date_d2=dateFrToUs($_POST['date2']);
	$de1=$_POST['date1'];$de2=$_POST['date2'];$au_f=$de2;
	
	
		$sql  = "SELECT * ";
		$sql .= "FROM tva_2024 WHERE du = '" . $date1. "';";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";

		$mois = $user_["mois"];$excedents_factures = $user_["excedents_factures"];
		$avance_commande_moisprecedent = $user_["avance_commande_moisprecedent"];
		$avance_commande_moisencours = $user_["avance_commande_moisencours"];
		$exercice = $user_["exercice"];$arrondi = $user_["arrondi"];
		$tva_a_recuperer = $user_["tva_a_recuperer"];$enc_exe=$user_["caexonore"];
		$numeroexonore=$user_["numeroexonore"];$mend=$user_["mend"];$m_represente=$user_["m_represente"];
		$credit_mois_precedent = $user_["credit_mois_precedent"];
		//$credit_mois_precedent = -40178.16;
	
	
	
	
	if ($date2>"2016-12-31"){
	if ($date2>="2018-01-01" and $date2<"2019-01-01"){$factures="factures2018";}
	if ($date2>="2017-01-01" and $date2<"2018-01-01"){$factures="factures";}
	if ($date2>="2019-01-01" and $date2<"2020-01-01"){$factures="factures2019";}
	if ($date2>="2020-01-01" and $date2<"2021-01-01"){$factures="factures2020";}
	if ($date2>="2021-01-01" and $date2<"2022-01-01"){$factures="factures2021";}
	if ($date2>="2022-01-01" and $date2<"2023-01-01"){$factures="factures2022";}
	if ($date2>="2023-01-01" and $date2<="2023-12-31"){$factures="factures2023";$detail_factures="detail_factures2023";}
			if ($date2>="2024-01-01" and $date2<="2024-12-31"){$factures="factures2024";$detail_factures="detail_factures2024";}
			if ($date2>="2025-01-01" and $date2<="2025-12-31"){$factures="factures2025";$detail_factures="detail_factures2025";}
			if ($date2>="2026-01-01" and $date2<="2026-12-31"){$factures="factures2026";$detail_factures="detail_factures2026";}
	
	
	
	$sql  = "SELECT * ";
	$sql .= "FROM ".$factures." where (date_f between '$date1' and '$date2') and montant>0 ORDER BY id;";
	}
	else
	{
	$sql  = "SELECT * ";
	$sql .= "FROM factures2016 where (date_f between '$date1' and '$date2') and montant>0 ORDER BY id;";
	}
	$users = db_query($database_name, $sql);
	
	
	
	
	$row_height = 6;$t_cheque=0;$ca=0;$htva_t=0;$tva_t=0;$ttc_t=0;$espece=0;$cheque=0;$effet=0;$tmt_t=0;
	$t_espece=0;
	$t_cheque_t = 0;
	$t_espece_t = 0;
	$t_effet_t = 0;$t_virement_t = 0;
	$y_axis_initial = 25;$y_axis = 25;$row_height=6;$t_reste=0;$t_total_encaisse=0;
	$total_e=0;$total_c=0;$total_t=0;
	

?>

<span style="font-size:24px"><?php echo "DECLARATION TVA $mois $exercice"; ?></span>

<table class="table2">



<?php $ca=0;$ca_e=0;while($users_ = fetch_array($users)) { 
	
	$total_cheque = 0;
	$total_espece = 0;
	$total_effet = 0;
	$total_virement = 0;

$client=$users_["client"];$id=$users_["id"];$f=$users_["numero"];$d=$users_["date_f"];$client_se=Trim($client);
$evaluation=$users_["evaluation"]; $client=$users_["client"];$user_id=$users_["id"];


$facture=$users_["id"];

if ($date2>"2016-12-31"){
$user_id=$users_["id"]+0;
if ($user_id<10){$zero="000";}
if ($user_id>=10 and $user_id<100){$zero="00";}
if ($user_id>=100 and $user_id<1000){$zero="0";}
if ($user_id>=1000 and $user_id<10000){$zero="0";}
$facture=$users_["id"]+0;
}else
{
$facture=$users_["id"]+9040;
}







$date=dateUsToFr($users_["date_f"]);$d=dateUsToFr($users_["date_f"]);$datefacture=$users_["date_f"];
$evaluation=$users_["evaluation"]; $client=$users_["client"];$t_f=$users_["montant"];
if ($users_["ht"]==0){
$ca=$ca+$users_["montant"];
$ht=number_format($users_["montant"]/1.2,2,',',' ');

$tva=number_format($users_["montant"]/1.2*0.20,2,',',' ');

$ttc=number_format($users_["montant"],2,',',' ');
}
else
{
$ca_e=$ca_e+$users_["montant"];
}


		
		
		$sql  = "SELECT numero_cheque,facture_n,client,client_tire,v_banque,sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece
		, sum(m_effet) as total_effet,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
		$sql .= "FROM porte_feuilles_factures where (m_cheque<>0 and remise=1 and facture_n='$facture' and date_f='$datefacture' and (date_remise between '$date1' and '$date2')) or 
		(m_effet<>0 and facture_n='$facture' and date_f='$datefacture' and (date_remise_e between '$date1' and '$date2') and (date_echeance <= '$date2') and remise_e=1) or 
		(m_virement<>0 and facture_n='$facture' and date_f='$datefacture' and (date_virement between '$date1' and '$date2')) or 
		(facture_n='$facture' and date_f='$datefacture' and m_espece>0 and date_enc between '$date1' and '$date2') Group BY facture_n;";
		$users11 = db_query($database_name, $sql);
		
		
		
		
		$t_cheque=0;$t_effet=0;$t_virement=0;$t_espece=0;
while($row = fetch_array($users11))
{
	$client = $row['client'];$client_tire=$row['client_tire'];
	$banque=$row['v_banque'];$facture_n=$row['facture_n'];
	$numero_cheque=$row['numero_cheque'];
	$total_e = 0;
	$total_avoir = $row['total_avoir'];
	$total_diff_prix = 0;
	$total_cheque = $row['total_cheque'];
	$t_cheque=$t_cheque+$total_cheque;
	$t_cheque_t=$t_cheque_t+$total_cheque;
	
	$total_effet = $row['total_effet'];
	$t_effet=$t_effet+$total_effet;
	$t_effet_t=$t_effet_t+$total_effet;
	
	$total_virement = $row['total_virement'];
	$t_virement=$t_virement+$total_virement;
	$t_virement_t=$t_virement_t+$total_virement;
	
	$total_espece = $row['total_espece'];
	$t_espece=$t_espece+$total_espece;
	$t_espece_t=$t_espece_t+$total_espece;
	
	
}
/////fincheques

//effet
/*
		$sql  = "SELECT remise,numero_cheque,facture_n,client,client_tire,v_banque,sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece
		, sum(m_effet) as total_effet,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
		$sql .= "FROM porte_feuilles_factures where m_effet<>0 and facture_n='$facture' and date_f='$datefacture' and (date_remise_e between '$date1' and '$date2') and (date_echeance <= '$date2') and remise_e=1 Group BY facture_n;";
		$users11 = db_query($database_name, $sql);
		$t_effet=0;
while($row = fetch_array($users11))
{
	$client = $row['client'];$client_tire=$row['client_tire'];
	$banque=$row['v_banque'];$facture_n=$row['facture_n'];
	$numero_cheque=$row['numero_cheque'];
	$total_e = 0;
	$total_avoir = $row['total_avoir'];
	$total_diff_prix = 0;
	$total_effet = $row['total_effet'];
	$t_effet=$t_effet+$total_effet;
	$t_effet_t=$t_effet_t+$total_effet;
}
*/
///fin effet

//virment
/*
		$sql  = "SELECT remise,numero_cheque,facture_n,client,client_tire,v_banque,sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece
		, sum(m_effet) as total_effet,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
		$sql .= "FROM porte_feuilles_factures where m_virement<>0 and facture_n='$facture' and date_f='$datefacture' and (date_virement between '$date1' and '$date2') Group BY facture_n;";
		$users11 = db_query($database_name, $sql);
		$t_virement=0;
while($row = fetch_array($users11))
{
	$client = $row['client'];$client_tire=$row['client_tire'];
	$banque=$row['v_banque'];$facture_n=$row['facture_n'];
	$numero_cheque=$row['numero_cheque'];
	$total_e = 0;
	$total_avoir = $row['total_avoir'];
	$total_diff_prix = 0;
	
	$total_virement = $row['total_virement'];
	
	$t_virement=$t_virement+$total_virement;
	$t_virement_t=$t_virement_t+$total_virement;
}
*/
///fin virment

		/*$sql  = "SELECT numero_cheque,facture_n,client,client_tire,v_banque,m_espece,sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece
		, sum(m_effet) as total_effet,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
		$sql .= "FROM porte_feuilles_factures where facture_n='$facture' and date_f='$datefacture' and m_espece>0 and date_enc between '$date1' and '$date2' Group BY facture_n;";
		$users11 = db_query($database_name, $sql);
		$t_espece=0;
while($row = fetch_array($users11))
{
	$client = $row['client'];$client_tire=$row['client_tire'];
	$banque=$row['v_banque'];$facture_n=$row['facture_n'];
	$numero_cheque=$row['numero_cheque'];
	$total_e = 0;
	$total_avoir = $row['total_avoir'];
	$total_diff_prix = 0;
	$total_espece = $row['total_espece'];
	
	$t_espece=$t_espece+$total_espece;
	$t_espece_t=$t_espece_t+$total_espece;
}
*/
//condition non encaisse
	$reste=$t_f-($total_espece+$total_cheque+$total_effet+$total_virement);
	$total_encaisse=($total_espece+$total_cheque+$total_effet+$total_virement);
	
	$t_reste=$t_reste+$reste;$t_total_encaisse=$t_total_encaisse+$total_encaisse;

$t_e=$t_e+$total_espece;
$t_c=$t_c+$total_cheque;
$t_f=$t_f+$total_effet;
$t_v=$t_v+$total_virement;

$total_espece=number_format($total_espece,2,',',' ');
$total_cheque=number_format($total_cheque,2,',',' ');
$total_effet=number_format($total_effet,2,',',' ');
$total_virement=number_format($total_virement,2,',',' ');

 }
 
 // effets non echus
 
 
 $sql  = "SELECT date_remise,date_enc,date_remise_e,client,client_tire,client_tire_e,vendeur,numero_effet,v_banque_e,facture_n,impaye,date_echeance,date_facture,date_f,
	sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece, sum(m_effet) as total_effet
	,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix ";
	$sql .= "FROM porte_feuilles_factures where facture_n<>0 and m_effet<>0 and id_registre_regl<>0 
	and date_echeance>'$date2' and date_enc <= '$date2' group by facture_n ORDER BY facture_n;";
	
	$users11 = db_query($database_name, $sql);
	$compteur1=0;$total_g=0;$total_e=0;$total_c=0;$total_t=0;$total_ee=0;$d="";$compteur=0;
while($users_1 = fetch_array($users11)) { $date_enc=$users_1["date_enc"];$vendeur=$users_1["vendeur"];$impaye=$users_1["impaye"];
			$ref=$users_1["numero_effet"]."/".$users_1["v_banque_e"];$facture_n=$users_1["facture_n"];$date_remise=$users_1["date_remise"];
			$client=$users_1["client"];$client_tire=$users_1["client_tire_e"];$client_tire_e=$users_1["client_tire_e"];$date_facture = $users_1['date_f'];
			$client=$users_1["client"];$total_e=$users_1["total_e"];$total_avoir=$users_1["total_avoir"];$date_f = $users_1['date_f'];
			$total_cheque=$users_1["total_cheque"];$total_espece=$users_1["total_espece"];$total_effet=$users_1["total_effet"];
			$total_diff_prix=$users_1["total_diff_prix"];$date_echeance=$users_1["date_echeance"];$date_remise_e=$users_1["date_remise_e"];
					
				if ($date_facture>=$date1 and $date_facture<=$date2){
				$total_c=$total_c+$total_effet;$tchq=number_format($total_effet,2,',',' ');
				$compteur++;
				//echo "<tr><td>$facture_n</td><td>$total_effet</td></tr>";
			 	}
				
 } 
		$tcc=number_format($total_c,2,',',' '); 
		///////////////////////////////////
		$t_reste = $t_reste-$total_c;//////
		///////////////////////////////////
	// impayes du mois
	$sql  = "SELECT * ";
	$sql .= "FROM porte_feuilles_factures where (date_impaye between '$date1' and '$date2') and facture_n<>0 and r_impaye=1 and m_cheque<>0 ORDER BY date_impaye;";
	$users111 = db_query($database_name, $sql);
	$compteur1=0;$total_imp_c=0;
while($users_12 = fetch_array($users111)) { 
			$m_cheque=$users_12["m_cheque"];$total_imp_c=$total_imp_c+$m_cheque;
	} 
	$sql  = "SELECT * ";$total_imp_e=0;
	$sql .= "FROM porte_feuilles_factures where (date_impaye_e between '$date1' and '$date2') and facture_n<>0 and r_impaye_e=1 and m_effet<>0 ORDER BY id;";
	$users1111 = db_query($database_name, $sql);
	while($users_122 = fetch_array($users1111)) { 
			$m_cheque=$users_122["m_effet"];$total_imp_e=$total_imp_e+$m_cheque;
	} 
	
	$vide="";
	//encaissement du mois
	$sql  = "SELECT date_virement,date_remise,date_echeance,date_enc,numero_cheque,facture_n,client,
		client_tire,v_banque,date_cheque,remise,facture_n,date_remise_e,date_facture,
		sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece
		, sum(m_effet) as total_effet,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
		$sql .= "FROM porte_feuilles_factures where 
		(date_remise between '$date1' and '$date2' and facture_n<>0 and remise=1 and id_registre_regl<>0 and numero_cheque_imp='$vide') 
		or (date_remise_e>='$date1' and date_remise_e<='$date2' and facture_n<>0 and m_effet<>0 and m_cheque=0 and remise_e=1 and numero_cheque_imp='$vide')   
		
		or (date_virement between '$date1' and '$date2' and facture_n<>0 and m_virement<>0 and id_registre_regl<>0)
		or (date_enc between '$date1' and '$date2' and facture_n<>0 and m_espece<>0)
		Group BY id order by facture_n;";
		$users113 = db_query($database_name, $sql);
		$row_height = 6;$t_cheque=0;$htva_t=0;$tva_t=0;$ttc_t=0;$espece=0;$cheque=0;$effet=0;$tmt_t=0;
	$t_cheque_t = 0;
	$total_espece_t = 0;
	$total_effet_t = 0;$encaiss_mois=0;

/*while($row = mysql_fetch_array($result))*/
		$total_effet=0;$total_espece=0;$total_cheque=0;$total_virement=0;
while($row = fetch_array($users113)){
	//If the current row is the last one, create new page and print column title
	
	$client = $row['client'];$client_tire=$row['client_tire'];$date_remise=dateUsToFr($row['date_remise']);
	$date_remise_c = $row['date_remise'];$date_remise_e = $row['date_remise_e'];$date_facture = $row['date_facture'];
	$banque=$row['v_banque'];$facture_n=$row['facture_n'];$date_enc = $row['date_enc'];$date_enc1 = dateUsToFr($row['date_enc']);
	$numero_cheque=$row['numero_cheque'];$date_virement = $row['date_virement'];$date_v = dateUsToFr($row['date_virement']);
		
	$total_e = 0;
	$total_avoir = $row['total_avoir'];
	$total_diff_prix = 0;
	
	//if ($date_facture>"2017-12-31"){$factures="factures2019";}else{$factures="factures";}
	$sql  = "SELECT * ";
	$sql .= "FROM ".$factures." where numero='$facture_n' ORDER BY id;";
	$users1 = db_query($database_name, $sql);$row1 = fetch_array($users1);$dt=dateUsToFr($row1["date_f"]);
	$d=$row1["date_f"];$ff=$row1["numero"];
	if ($date_facture<$date1){
	
	$cheque = $row['total_cheque'];$date_echeance = $row['date_echeance'];
	$espece = $row['total_espece'];	
	$effet = $row['total_effet'];
	$virement = $row['total_virement'];
	if ($date_remise_c>=$date1 and $date_remise_c<=$date2){
		$total_cheque=$total_cheque+$cheque;}else{$cheque=0;}
		
	if ($date_remise_e>=$date1 and $date_remise_e<=$date2){
	$total_effet=$total_effet+$effet;}else{$effet=0;}
	
	if ($date_virement>=$date1 and $date_virement<=$date2){
	$total_virement=$total_virement+$virement;$date_remise=$date_v;}else{$virement=0;}
	
	if ($date_enc>=$date1 and $date_enc<=$date2){
	$total_espece=$total_espece+$espece;$date_remise=$date_enc1;}else{$espece=0;}
	$encaiss_mois=$encaiss_mois+$total_espece+$total_virement+$total_effet+$total_cheque;
	}
	
	}
	
	// encaiss impayes
	$sql  = "SELECT * ";
	$sql .= "FROM porte_feuilles_impayes where (date_enc between '$date1' and '$date2') and facture_n<>0 ORDER BY date_enc;";
	$users114 = db_query($database_name, $sql);
	$compteur1=0;$total_g_imp=0;
	while($users_14 = fetch_array($users114)) { 
			$date_remise=$users_1["date_remise"];$dr=dateUsToFr($users_1["date_remise"]);
			$client=$users_1["client"];$numero_cheque_imp=$users_1["numero_cheque_imp"];
			$numero_cheque=$users_1["numero_cheque"];
			$m_cheque=$users_14["m_cheque"]+$users_14["m_espece"]+$users_14["m_virement"]+$users_14["m_avoir"]+$users_14["m_effet"];
			$total_g_imp=$total_g_imp+$m_cheque;
			$ref="";
			 } 
			 

		
		
 
 ?>
<tr><td><? 
echo " C.A </td><td align=\"right\"> </td>";?>
<tr><td align="right"><? $ca_f=number_format($ca/1.20,2,',',' ');
echo "CA H TVA 	</td><td align=\"right\"> $ca_f</td>";?>

<tr><td align="right"><? $tva=$ca/1.20*0.20;$tva_f=number_format($tva,2,',',' ');
echo "TVA </td><td align=\"right\"> $tva_f</td>";?>
<tr><td align="right"><? $ca_e_f=number_format($ca_e,2,',',' ');
echo "CA Exonéré </td><td align=\"right\"> $ca_e_f</td>";?>
<tr><td align="right"><? $ca_t_f=number_format($ca_e+$ca,2,',',' ');
echo " </td><td align=\"right\"> $ca_t_f</td>";?>

<tr><td><? 
echo " à Déduire </td><td align=\"right\"> </td>";?>

<tr><td align="right"><? $reste_f=number_format($t_reste,2,',',' ');
echo " Factures non Encaissées</td><td align=\"right\" bgcolor=\"#66CCCC\"> $reste_f</td>";?>

<tr><td align="right"><? $lien="<a href=\"\\mps\\tutorial\\releve_factures_n_enc_tva.php?date1=$date1&date2=$date2&compteur=$compteur\">$tcc</a>";
echo " Effets à recevoir non Echus</td><td align=\"right\" bgcolor=\"#66CCCC\"> $lien</td>";?>

<tr><td align="right"><? $t1=number_format($t_reste+$total_c,2,',',' ');
echo " Total 1</td><td align=\"right\" bgcolor=\"#66CCCC\"> $t1</td>";?>

<tr><td align="right"><? $imp_mois=number_format($total_imp_e+$total_imp_c,2,',',' ');
echo " Impayés du mois</td><td align=\"right\"> $imp_mois</td>";?>

<? if ($avance_commande_moisprecedent<>0){?>
<tr><td align="right"><? $avances_f=number_format($avance_commande_moisprecedent,2,',',' ');
echo " Avances/commandes </td><td align=\"right\"> $avances_f</td>";?>
<? }?>

<tr><td></td><td></td></tr>

<tr><td align="right"><? $ca_net_mois=$ca+$ca_e-$t_reste-$total_c-$total_imp_e-$total_imp_c-$avance_commande_moisprecedent;
$ca_net_mois_f=number_format($ca+$ca_e-$t_reste-$total_c-$total_imp_e-$total_imp_c-$avance_commande_moisprecedent,2,',',' ');

echo " CA Net du Mois</td><td align=\"right\"> $ca_net_mois_f</td>";?>

<tr><td><? 
echo " à Ajouter </td><td align=\"right\"> </td>";?>

<tr><td align="right"><? 
echo " Encaissement / clients </td><td align=\"right\"> </td>";?>
<? if ($mend>=0){?>
<tr><td align="right"><? $menda=number_format($mend,2,',',' ');
echo "E. N. D. 	</td><td align=\"right\"> $menda</td>";
} ?>


<? if ($m_represente>=0){?>
<tr><td align="right"><? $m_representea=number_format($m_represente,2,',',' ');
echo "Impayés Représentés 	</td><td align=\"right\"> $m_representea</td>";
} ?>

<tr><td align="right"><? $total_cheque_f=number_format($total_cheque,2,',',' ');
echo " Chèques </td><td align=\"right\"> $total_cheque_f</td>";?>

<tr><td align="right"><? $total_espece_f=number_format($total_espece,2,',',' ');
echo " Espèces </td><td align=\"right\"> $total_espece_f</td>";?>

<tr><td align="right"><? $total_effet_f=number_format($total_effet,2,',',' ');
echo " Effets à recevoir </td><td align=\"right\"> $total_effet_f</td>";?>

<? if ($total_virement<>0){?>
<tr><td align="right"><? $total_virement_f=number_format($total_virement,2,',',' ');
echo " Virements </td><td align=\"right\"> $total_virement_f</td>";?>
<? }?>

<? if ($total_g_imp<>0){?>
<tr><td align="right"><? $total_g_imp_f=number_format($total_g_imp,2,',',' ');
echo " Encaissement des impayés </td><td align=\"right\"> $total_g_imp_f</td>";?>
<? }?>

<? if ($exedents_factures<>0){?>
<tr><td align="right"><? $exedent_f=number_format($exedents_factures,2,',',' ');
echo " Excédents/factures </td><td align=\"right\"> $exedent_f</td>";?>
<? }?>

<? if ($avance_commande_moisencours<>0){?>
<tr><td align="right"><? $avance_commande_moisencours_f=number_format($avance_commande_moisencours,2,',',' ');
echo " Avance/commande </td><td align=\"right\"> $avance_commande_moisencours_f</td>";?>
<? }?>

<tr><td><? $t2=number_format($mend+$m_represente+$total_cheque+$total_espece+$total_effet+$total_virement+$total_g_imp+$exedents_factures+$avance_commande_moisencours,2,',',' ');
echo " </td><td align=\"right\" bgcolor=\"#66CCCC\"> $t2</td>";?>

<tr><td><? $t3=number_format($ca_net_mois+$mend+$m_represente+$total_cheque+$total_espece+$total_effet+$total_virement+$total_g_imp+$exedents_factures+$avance_commande_moisencours,2,',',' ');
echo " </td><td align=\"right\" bgcolor=\"#66CCCC\"> $t3</td>";?>

<tr><td><? $enc_exe_f=number_format($enc_exe,2,',',' ');
echo " CHIFFRE D'AFFAIRE EXONERE </td><td align=\"right\"> $enc_exe_f</td>";?>
<? echo " <tr><td>ATTESTATION D'EXONERATION N° </td><td align=\"right\"> $numeroexonore</td>";?>

<tr><td><? $t4=number_format($ca_net_mois+$mend+$m_represente+$total_cheque+$total_espece+$total_effet+$total_virement+$total_g_imp+$exedents_factures+$avance_commande_moisencours-$enc_exe,2,',',' ');
echo " </td><td align=\"right\" bgcolor=\"#66CCCC\"> $t4</td>";?>

<tr><td><? 
echo " CALCUL TVA        $t4 * 1.20/20</td><td align=\"right\" > </td>";?>

<tr><td><? $tva_c=($ca_net_mois+$mend+$m_represente+$total_cheque+$total_espece+$total_effet+$total_virement+$total_g_imp+$exedents_factures+$avance_commande_moisencours-$enc_exe)/1.20*20/100;
$tva_c_f=number_format($tva_c,2,',',' ');
echo " TVA COLLECTEE     </td><td align=\"right\" >$tva_c_f </td>";?>

<tr><td><? $tva_r_f=number_format($tva_a_recuperer,2,',',' ');
echo " TVA A RECUPERER</td><td align=\"right\" bgcolor=\"#66CCCC\"> $tva_r_f</td>";?>

<tr><td><? $credit_f=number_format($credit_mois_precedent,2,',',' ');
echo " CREDIT TVA MOIS $precedant</td><td align=\"right\" bgcolor=\"#66CCCC\"> $credit_f</td>";?>

<tr><td><? $tva_du_f=number_format($tva_c+$credit_mois_precedent-$tva_a_recuperer,2,',',' ');
$tvaar=$tva_c+$credit_mois_precedent-$tva_a_recuperer;
if ($tva_c+$credit_mois_precedent-$tva_a_recuperer>0){
echo " TVA DUE AU $au_f</td><td align=\"right\" bgcolor=\"#66CCCC\"> $tva_du_f</td>";$tvaardue=0;
$sql = "UPDATE tva_2024 SET credit_mois_precedent = '$tvaardue'			
			 WHERE mois = '$moisr'";
			db_query($database_name, $sql);

}
else{echo " TVA A REPORTER </td><td align=\"right\" bgcolor=\"#66CCCC\"> $tva_du_f</td>";

//report tva
if ($mois=="JANVIER"){$moisr="FEVRIER";} 
if ($mois=="FEVRIER"){$moisr="MARS";} 
if ($mois=="MARS"){$moisr="AVRIL";} 
if ($mois=="AVRIL"){$moisr="MAI";} 
if ($mois=="MAI"){$moisr="JUIN";} 
if ($mois=="JUIN"){$moisr="JUILLET";} 
if ($mois=="JUILLET"){$moisr="AOUT";} 
if ($mois=="AOUT"){$moisr="SEPTEMBRE";} 
if ($mois=="SEPTEMBRE"){$moisr="OCTOBRE";} 
if ($mois=="OCTOBRE"){$moisr="NOVEMBRE";} 
if ($mois=="NOVEMBRE"){$moisr="DECEMBRE";} 

$sql = "UPDATE tva_2024 SET credit_mois_precedent = '$tvaar'			
			 WHERE mois = '$moisr'";
			db_query($database_name, $sql);




}?>

<tr><td><? $arrondi_f=number_format($arrondi,2,',',' ');
echo " ARRONDIE</td><td align=\"right\" bgcolor=\"#66CCCC\"> $arrondi_f</td>";?>

<tr><td><? 

if ($date1=="2015-05-01"){
$tva_net_f=number_format($tva_c+$credit_mois_precedent-$tva_a_recuperer+$arrondi+0.01,2,',',' ');}
else
{
$tva_net_f=number_format($tva_c+$credit_mois_precedent-$tva_a_recuperer+$arrondi,2,',',' ');}
echo " </td><td align=\"right\" bgcolor=\"#66CCCC\"> $tva_net_f</td>";?>

</table>


<? } ?>

<p style="text-align:center">

</body>

</html>