<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$user_name=GetUserName();
	$error_message = "";
	$type_service="SEJOURS ET CIRCUITS";$date1="";$date2="";$action="Recherche";$client="";$vendeur="";
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	$client_list = "";
	$sql = "SELECT * FROM  clients ORDER BY client;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($client == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
		
		$client_list .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";
		$client_list .= $temp_["client"];
		$client_list .= "</OPTION>";
	}
	$vendeur_list = "";
	$sql = "SELECT * FROM  vendeurs ORDER BY vendeur;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($vendeur == $temp_["vendeur"]) { $selected = " selected"; } else { $selected = ""; }
		
		$vendeur_list .= "<OPTION VALUE=\"" . $temp_["vendeur"] . "\"" . $selected . ">";
		$vendeur_list .= $temp_["vendeur"];
		$vendeur_list .= "</OPTION>";
	}

	
	?>
	


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "registre_remise.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<? 	


	$client_tire_get=$_GET['client_tire'];
	
	
		
	
	$sql  = "SELECT * ";
	$sql .= "FROM porte_feuilles_factures where client_tire='$client_tire_get' and facture_n<>0 and r_impaye=1 and m_cheque<>0 ORDER BY date_impaye;";
	$users11 = db_query($database_name, $sql);



?>


<span style="font-size:24px"><?php echo "Etat des impayés : ".$client_tire_get; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Cheque N°";?></th>
	<th><?php echo "Client";?></th>
	<th><?php echo "Date Remise";?></th>
	<th><?php echo "Montant";?></th>
	<th><?php echo "Date impaye";?></th>
	<th><?php echo "Facture";?></th>
	<th><?php echo "Encaissement";?></th>
</tr>

<?php 
$compteur1=0;$total_g=0;
while($users_1 = fetch_array($users11)) { 
			$date_remise=$users_1["date_remise"];
			$client=$users_1["client"];$id=$users_1["id_porte_feuille"];
			$client_tire=$users_1["client_tire"];
			$numero_cheque=$users_1["numero_cheque"];$v_banque=$users_1["v_banque"];
			$m_cheque=$users_1["m_cheque"];$total_g=$total_g+$m_cheque;
			$date_impaye=$users_1["date_impaye"];$facture_n=$users_1["facture_n"];$date_f=$users_1["date_f"];
				if ($date_f>="2018-01-01" and $date_f<"2019-01-01"){$factures="factures2018";$exe="/18";}
				if ($date_f>="2017-01-01" and $date_f<"2018-01-01"){$factures="factures";$exe="/17";}
				if ($date_f>="2019-01-01" and $date_f<"2020-01-01"){$factures="factures2019";$exe="/19";}
				if ($date_f>="2020-01-01" and $date_f<"2021-01-01"){$factures="factures2020";$exe="/20";}
				if ($date_f>="2021-01-01" and $date_f<"2022-01-01"){$factures="factures2021";$exe="/21";}
				if ($date_f>="2022-01-01" and $date_f<"2023-01-01"){$factures="factures2022";$exe="/22";}
				if ($date_f>="2023-01-01" and $date_f<"2024-01-01"){$factures="factures2023";$exe="/23";}
				if ($date_f>="2024-01-01" and $date_f<"2025-01-01"){$factures="factures2024";$exe="/24";}
				if ($date_f>="2025-01-01" and $date_f<"2026-01-01"){$factures="factures2025";$exe="/25";}
				if ($date_f>="2026-01-01" and $date_f<"2027-01-01"){$factures="factures2026";$exe="/26";}
				
				
				$sql  = "SELECT * ";
				$sql .= "FROM ".$factures." where numero='$facture_n' ORDER BY id;";
				$users = db_query($database_name, $sql);$row = fetch_array($users);$d=$row["date_f"];


			?><tr>
			<td><?php $n_v= $numero_cheque."/".$v_banque;print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$n_v </font>"); ?></td>
			<td><?php $c_t= $client."/".$client_tire;print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$c_t </font>"); ?></td>
			<td><?php $d_r= dateUsToFr($date_remise);print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$d_r </font>"); ?></td>
			<td align="right"><?php $m_c= number_format($m_cheque,2,',',' '); print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$m_c </font>");?></td>
			<td><?php $d_i= dateUsToFr($date_impaye); print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$d_i </font>");?></td>
			<td><?php print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$facture_n $exe</font>");?></td>
			
<?	$sql  = "SELECT * ";$total_gg=0;
	$sql .= "FROM porte_feuilles_impayes where id_porte_feuille='$id' ORDER BY id;";
	$users111 = db_query($database_name, $sql);
 while($users_111 = fetch_array($users111)) { 
			$date_remise=$users_111["date_remise"];
			$client=$users_111["client"];$numero_cheque_imp=$users_111["numero_cheque_imp"];
			$m_cheque=$users_111["m_cheque"]+$users_111["m_espece"]+$users_111["m_virement"]+$users_111["m_avoir"];
			$total_gg=$total_gg+$m_cheque;$total_ggg=$total_ggg+$m_cheque;
			$ref="";
			if ($users_111["m_espece"]>0){$ref="espece";}
			if ($users_111["m_virement"]>0){$ref="virement";}
			if ($users_111["m_cheque"]>0){$ref="cheque";}
			if ($users_111["m_avoir"]>0){$ref=$users_111["numero_avoir"];}
			 } ?>
			<td align="right"><?php $m_c_s= number_format($total_gg,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$m_c_s </font>");?></td>
			
<? } ?>



</table>		
	

</body>

</html>