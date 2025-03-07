<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$user_name=GetUserName();
	$valeur=3600;
set_time_limit($valeur);

	$error_message = "";
	$type_service="SEJOURS ET CIRCUITS";
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	$action="recherche";
	
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

<? 	

	$date=dateFrToUs(date("d/m/Y"));$total=0;$vide="0000-00-00";
	
	$sql  = "SELECT * ";
	$sql .= "FROM porte_feuilles where facture_n<>0 order BY id;";
	$users11 = db_query($database_name, $sql);
	
	/*$sql  = "SELECT id,date_enc,evaluation,facture_n,date_cheque,client,client_tire,v_banque,numero_cheque,sum(m_cheque) As total_cheque ";
	$sql .= "FROM porte_feuilles where date_e='$vide' GROUP BY id;";
	$users11 = db_query($database_name, $sql);*/
	
	
?>


<span style="font-size:24px"><?php echo "Porte Feuilles au : ".dateUsToFr($date); ?></span>

<table class="table2">

<tr>
	<th><?php echo "Date Remise";?></th>
   	<th><?php echo "Montant Total";?></th>

	
</tr>

<?php 
$compteur1=0;$total_g=0;
while($users_1 = fetch_array($users11)) { 
			$date_enc=$users_1["date_enc"];$evaluation=$users_1["facture_n"];$id=$users_1["id"];
			$client=$users_1["client"];$client_tire=$users_1["client_tire"];$vendeur=$users_1["vendeur"];$id_registre_regl=$users_1["id_registre_regl"];
			$v_banque=$users_1["v_banque"];$numero_cheque=$users_1["numero_cheque"];$m_cheque=$users_1["m_cheque"];$facture_n=$users_1["facture_n"];
			$evaluation=$users_1["evaluation"];$date_echeance=$users_1["date_echeance"];$m_cheque_g=$users_1["m_cheque_g"];$remise=$users_1["remise"];
			$date_remise=$users_1["date_remise"];$numero_remise=$users_1["numero_remise"];$m_effet=$users_1["m_effet"];$m_virement=$users_1["m_virement"];
			$m_espece=$users_1["m_espece"];$date_virement=$users_1["date_virement"];$client_tire_e=$users_1["client_tire_e"];
			$remise_e=$users_1["remise_e"];$date_remise_e=$users_1["date_remise_e"];$numero_remise_e=$users_1["numero_remise_e"];
			$m_effet_g=$users_1["m_effet_g"];$m_vir_g=$users_1["m_vir_g"];$numero_effet=$users_1["numero_effet"];$numero_virement=$users_1["numero_virement"];
			$montant_e=$users_1["montant_e"];$date_impaye=$users_1["date_impaye"];$r_impaye=$users_1["r_impaye"];$date_impaye_e=$users_1["date_impaye_e"];$r_impaye_e=$users_1["r_impaye_e"];
			$ref=$v_banque." ".$numero_cheque;$date_cheque=dateUsToFr($users_1["date_cheque"]);$date_cheque1=$users_1["date_cheque"];?>
			<? echo "<tr><td><a href=\"porte_feuilles_details1.php?date_cheque=$date_cheque1\">$date_cheque</a></td>";
			
			if ($m_cheque<>0){
			$sql1  = "INSERT INTO porte_feuilles_factures 
		(vendeur,id_porte_feuille,client,client_tire,v_banque,date_enc,id_registre_regl,facture_n,evaluation,montant_e,date_cheque,m_cheque,m_cheque_g,numero_cheque,date_remise,remise,numero_remise,date_impaye,r_impaye,date_impaye_e,r_impaye_e)
		VALUES ('$vendeur','$id','$client','$client_tire','$v_banque','$date_enc','$id_registre_regl','$facture_n','$evaluation','$montant_e','$date_cheque1','$m_cheque','$m_cheque_g','$numero_cheque','$date_remise','$remise','$numero_remise','$date_impaye','$r_impaye','$date_impaye_e','$r_impaye_e')";
		db_query($database_name, $sql1);
			}
			if ($m_effet<>0){
			$sql1  = "INSERT INTO porte_feuilles_factures 
		(vendeur,id_porte_feuille,client,client_tire,v_banque,date_enc,id_registre_regl,facture_n,evaluation,montant_e,date_echeance,m_effet,m_effet_g,numero_effet,date_remise_e,remise_e,numero_remise_e,date_impaye,r_impaye,date_impaye_e,r_impaye_e)
		VALUES ('$vendeur','$id','$client','$client_tire','$v_banque','$date_enc','$id_registre_regl','$facture_n','$evaluation','$montant_e','$date_echeance','$m_effet','$m_effet_g','$numero_effet','$date_remise','$remise','$numero_remise_e','$date_impaye','$r_impaye','$date_impaye_e','$r_impaye_e')";
		db_query($database_name, $sql1);
			}
			
			if ($m_virement<>0){
			$sql1  = "INSERT INTO porte_feuilles_factures 
		(vendeur,id_porte_feuille,client,client_tire,v_banque,date_enc,id_registre_regl,facture_n,evaluation,montant_e,date_virement,m_virement,m_vir_g,numero_virement)
		VALUES ('$vendeur','$id','$client','$client_tire','$v_banque','$date_enc','$id_registre_regl','$facture_n','$evaluation','$montant_e','$date_virement','$m_virement','$m_vir_g','$numero_virement')";
		db_query($database_name, $sql1);
			}
			
			if ($m_espece<>0){
			$sql1  = "INSERT INTO porte_feuilles_factures 
		(vendeur,id_porte_feuille,client,date_enc,id_registre_regl,facture_n,evaluation,montant_e,m_espece)
		VALUES ('$vendeur','$id','$client','$date_enc','$id_registre_regl','$facture_n','$evaluation','$montant_e','$m_espece')";
		db_query($database_name, $sql1);
			}
			
			
			
			
			
			
			?>
			<td align="right"><?php $total_g=$total_g+$total_cheque;echo number_format($total_cheque,2,',',' ');?></td></tr>
		<? 
		
		

		
		
?>
<? } ?>
<tr><td></td><td align="right"><? $m=number_format($total_g,2,',',' ');echo "<a href=\"cheques_non_remis.php\">$m</a></td>";?>
<tr><? echo "<td><a href=\"\\mps\\tutorial\\porte_feuilles_facture.php\">Imprimer</a></td>";?>

</table>
</strong>
<p style="text-align:center">


</body>

</html>