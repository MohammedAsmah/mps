<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$user_name=GetUserName();
	$error_message = "";
	$type_service="SEJOURS ET CIRCUITS";$action="Recherche";$date1="";$date2="";$total_cc=0;$total_tt=0;$date="";
	$porte_feuille=0;$entree=0;$remise=0;$total_cheque=0;
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url

	
	?>
	<? if(isset($_REQUEST["action"])){}else{ ?>
	<form id="form" name="form" method="post" action="porte_feuilles1.php">
	<td><?php echo "Du : "; ?><input onClick="ds_sh(this);" name="date1" value="<?php echo $date1; ?>" readonly="readonly" style="cursor: text" /></td>
	<td><?php echo "Au : "; ?><input onClick="ds_sh(this);" name="date2" value="<?php echo $date2; ?>" readonly="readonly" style="cursor: text" /></td>
	<input type="submit" id="action" name="action" value="<?php echo $action; ?>">
	</form>
	
	<? }


?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<? 	if(isset($_REQUEST["action"]))
	{ 
?>
<span style="font-size:24px"><?php $date1=dateFrToUs($_POST['date1']);$date2=dateFrToUs($_POST['date2']);$solde=0;?>
<table border="0" class="table2" bordercolorlight="#FFFBF0" bordercolor="#FFFBF0">
<td align="center" bordercolor="#FFFBF0"></td><td align="center" bordercolor="#FFFBF0">
<? $d=date("d/m/Y");$e="Porte Feuille : ".dateUsToFr($date1)." au ".dateUsToFr($date2);print("<font size=\"6\" face=\"Comic sans MS\" color=\"000033\">$e </font>"); ?></td></span>
</table>
<table border="0" class="table2">
<tr>
	<th><?php $a1= "Date Emission";print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$a1 </font>");?></th>
	<th><?php $a2= "Designation";print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$a2 </font>");?></th>
	<th><?php $a3= "N° Cheque";print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$a3 </font>");?></th>
	<th><?php $a5= "Date Regl";print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$a5 </font>");?></th>
	<th><?php $a6= "MT Cheque";print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$a6 </font>");?></th>
	<th><?php $a7= "Debit";print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$a7 </font>");?></th>
	<th><?php $a8= "Credit";print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$a8 </font>");?></th>
	<th><?php $a9= "Solde";print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$a9 </font>");?></th>
	
</tr>




<?
////////Porte feuille
	$sql  = "SELECT id,date_enc,date_cheque,client,client_tire,v_banque,numero_cheque,sum(m_cheque) As total_cheque ";
	$sql .= "FROM porte_feuilles where m_cheque<>0 and remise=0 and facture_n<>0 and date_cheque<='$date2' GROUP BY date_cheque;";
	$users113 = db_query($database_name, $sql);
	$compteur1=0;$total_g=0;
	while($users_13 = fetch_array($users113)) { 
			$date_enc=$users_13["date_enc"];
			$client=$users_13["client"];$client_tire=$users_13["client_tire"];
			$v_banque=$users_13["v_banque"];$numero_cheque=$users_13["numero_cheque"];$total_cheque=$users_13["total_cheque"];
			$ref=$v_banque." ".$numero_cheque;$date_cheque=dateUsToFr($users_13["date_cheque"]);$date_cheque1=$users_13["date_cheque"];
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
	while($users_11 = fetch_array($users11)) { 
			
			$client=$users_11["client"];$client_tire=$users_11["client_tire"];$client_tire_e=$users_11["client_tire_e"];
			$client=$users_11["client"];$total_e=$users_11["total_e"];$total_avoir=$users_11["total_avoir"];$facture_n=$users_11["facture_n"];
			$total_cheque=$users_11["total_cheque"];$total_espece=$users_11["total_espece"];$total_effet=$users_11["total_effet"];
			$total_diff_prix=$users_11["total_diff_prix"];$numero_cheque=$users_11["numero_cheque"];$v_banque=$users_11["v_banque"];
			$total_c1=$total_c1+$total_cheque;$total_cc=$total_cc+$total_cheque;
			
	} 

	}
	$porte_feuille=$total_g;
	$entree=$total_cc;
	
////////////remise
	
	$sql  = "SELECT * ";
	$sql .= "FROM registre_remises where date between '$date1' and '$date2' ORDER BY id;";
	$users112 = db_query($database_name, $sql);
	$compteur1=0;$total_gg=0;
	while($users_22 = fetch_array($users112)) { $id_r=$users_22["id"];$date_enc=$users_22["date"];$banque=$users_22["banque"];
			$statut=$users_22["statut"];$observation=$users_22["observation"];$dest=$users_22["service"];$date_remise=$users_22["date"];
			$service=$users_22["service"];$code=$users_22["code_produit"];$id_tableau=$users_22["id"]."/2008";$bon=$users_22["statut"];
			$t=$users_22["bon_sortie"]."/".$users_22["mois"]."".$users_22["annee"]; 
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

//////

$report=$porte_feuille-$entree+$remise;

	?>
	
	<? $sql  = "SELECT date_enc,date_cheque,facture_n,v_banque,numero_cheque,client,client_tire,client_tire_e,sum(montant_e) as total_e,sum(m_cheque) as 
	total_cheque,sum(m_espece) as 
	total_espece, sum(m_effet) as total_effet
	,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix ";
	$sql .= "FROM porte_feuilles where date_enc='$date1' and m_cheque<>0 and facture_n<>0 and impaye<>1 Group BY numero_cheque;";
	$users11 = db_query($database_name, $sql);$total_c1=$report;$t_c=0;
	while($users_1 = fetch_array($users11)) { 
			
			$client=$users_1["client"];$client_tire=$users_1["client_tire"];$client_tire_e=$users_1["client_tire_e"];$date_enc=dateUsToFr($users_1["date_enc"]);
			$client=$users_1["client"];$total_e=$users_1["total_e"];$total_avoir=$users_1["total_avoir"];$facture_n=$users_1["facture_n"];
			$total_cheque=$users_1["total_cheque"];$total_espece=$users_1["total_espece"];$total_effet=$users_1["total_effet"];$date_cheque=dateUsToFr($users_1[
			"date_cheque"]);
			$total_diff_prix=$users_1["total_diff_prix"];$numero_cheque=$users_1["numero_cheque"];$v_banque=$users_1["v_banque"];
			$total_c1=$total_c1+$total_cheque;$t_c=$t_c+$total_cheque;?>
            <tr><td><? print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$date_enc </font>");?>
			</td><td><? print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$client/$client_tire</font>");?>
			</td><td><? print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$numero_cheque/$v_banque </font>");?>
			</td><td><? print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$date_cheque </font>");?></td>
			<td align="right"><? $t1=number_format($total_cheque,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t1 </font>");?></td>
			<td align="right"><? $t2=number_format($total_cheque,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t2 </font>");?></td>
			<td></td>
			<td align="right"><? $t3=number_format($total_c1,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t3 </font>");?></td>
			
	<? } ?>

	<? $sql  = "SELECT date_enc,date_cheque,facture_n,v_banque,numero_cheque,client,client_tire,client_tire_e,sum(montant_e) as total_e,sum(m_cheque) as 
	total_cheque,sum(m_espece) as 
	total_espece, sum(m_effet) as total_effet
	,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix ";
	$sql .= "FROM porte_feuilles where date_remise='$date1' and m_cheque<>0 and facture_n<>0 and impaye<>1 Group BY numero_cheque;";
	$users111 = db_query($database_name, $sql);
	while($users_111 = fetch_array($users111)) { 
			
			$client=$users_111["client"];$client_tire=$users_111["client_tire"];$client_tire_e=$users_111["client_tire_e"];$date_enc=dateUsToFr($users_111["date_enc"]);
			$client=$users_111["client"];$total_e=$users_111["total_e"];$total_avoir=$users_111["total_avoir"];$facture_n=$users_111["facture_n"];
			$total_cheque=$users_111["total_cheque"];$total_espece=$users_111["total_espece"];$total_effet=$users_111["total_effet"];$date_cheque=dateUsToFr($users_111[
			"date_cheque"]);
			$total_diff_prix=$users_111["total_diff_prix"];$numero_cheque=$users_111["numero_cheque"];$v_banque=$users_111["v_banque"];
			$total_c1=$total_c1-$total_cheque;?>
            <tr><td><? print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$date_enc </font>");?>
			</td><td><? print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$client/$client_tire</font>");?>
			</td><td><? print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$numero_cheque/$v_banque </font>");?>
			</td><td><? print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$date_cheque </font>");?></td>
			<td align="right"><? $t1=number_format($total_cheque,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t1 </font>");?></td>
			<td></td><td align="right"><? $t2=number_format($total_cheque,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t2 </font>");?></td>
			<td align="right"><? $t3=number_format($total_c1,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t3 </font>");?></td>
			
			
	<? } ?>

</strong>
<p style="text-align:center">

<? }?>
            <tr><td><? $v="";print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$v </font>");?>
			</td><td><? print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$v</font>");?>
			</td><td><? print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$v </font>");?>
			</td><td><? print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$v </font>");?></td>
			<td align="right"><? $t1=number_format($total_cheque,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$v </font>");?></td>
			<td align="right"><? $t2=number_format($entree,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t2 </font>");?></td>
			<td align="right"><? $t2=number_format($remise,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t2 </font>");?></td>
			<td align="right"><? $t3=number_format($porte_feuille,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t3 </font>");?></td>


</table>
<tr><td><? $d=date("d/m/Y");print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">Edite le : $d </font>");?>
<?

/*$imp="Imprimer";echo "<td><a href=\"\\mps\\tutorial\\porte_feuilles1.php?date1=$date1&date2=$date2\">".$imp."</a></td>";*/
?>
</body>

</html>