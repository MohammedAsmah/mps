<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$du="";$au="";$vendeur="";$remise_1=0;$remise_2=0;$remise_3=0;
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	
	if(isset($_REQUEST["action_r"])) {
	
		if ($_REQUEST["action_r"]=="delete_user")
		{
			$sql  = "SELECT * ";$id=$_REQUEST["id"];
			$sql .= "FROM porte_feuilles where id='$id' ORDER BY id;";
			$users11 = db_query($database_name, $sql);$users_1 = fetch_array($users11);$id_registre_regl=$users_1["id_registre_regl"];
			$id_r=$users_1["id"];$date_enc=$users_1["date_enc"];$vendeur=$users_1["vendeur"];$n_banque=$users_1["n_banque"];
			$client=$users_1["client"];$evaluation=$users_1["evaluation"];$id_commande=$users_1["id_commande"];$date_cheque=dateUsToFr($users_1["date_valeur"]);
			$mode=$users_1["mode"];$valeur=$users_1["valeur"];$v_banque=$users_1["v_banque"];$numero_cheque=$users_1["numero_cheque"];
			$client_tire=$users_1["client_tire"];$facture_n=$users_1["facture_n"];$montant_f=$users_1["montant_f"];
			$sql = "DELETE FROM porte_feuilles WHERE id = " . $_REQUEST["id"] . ";";
			db_query($database_name, $sql);
		}
		else
		{
			$id_registre = $_REQUEST["id_registre"];$date_enc=$_REQUEST["date_enc"];$vendeur=$_REQUEST["vendeur"];
			$facture_n=$_REQUEST["facture_n"];$montant_f=$_REQUEST["montant_f"];$id = $_REQUEST["id"];
			$montant_regl=$_REQUEST["montant"];
			$mode = $_REQUEST["mode"];
			$n_banque=$_REQUEST["n_banque"];
			$v_banque = $_REQUEST["v_banque"];
			$ref=$_REQUEST["ref"];
			$date_cheque=dateFrToUs($_REQUEST["date_cheque"]);
			$date_remise=dateFrToUs($_REQUEST["date_cheque"]);
			if ($mode=="EFFET"){$date_remise=$date_enc;}
			$client_tire=$_REQUEST["client_tire"];
			$sql = "UPDATE porte_feuilles SET ";
			$sql .= "valeur = '" . $montant_regl . "', ";
			$sql .= "mode = '" . $mode . "', ";
			$sql .= "n_banque = '" . $n_banque . "', ";
			$sql .= "v_banque = '" . $v_banque . "', ";
			$sql .= "date_valeur = '" . $date_cheque . "', ";
			$sql .= "date_remise = '" . $date_remise . "', ";
			$sql .= "client_tire = '" . $client_tire . "', ";
			$sql .= "facture_n = '" . $facture_n . "', ";
			$sql .= "montant_f = '" . $montant_f . "', ";
			$sql .= "numero_cheque = '" . $ref . "' ";
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);
		}
	}
	else
	{
	$id_registre=$_GET['id_registre'];
	$date=$_GET['date_enc'];$date3=$_GET['date_enc'];$date_enc=$_GET['date_enc'];
	$vendeur=$_GET['vendeur'];
	}
	
	$sql  = "SELECT * ";
	$sql .= "FROM porte_feuilles where date_enc='$date_enc' and vendeur='$vendeur' and id_registre_regl='$id_registre' ORDER BY id;";
	$users11 = db_query($database_name, $sql);?>
	

<span style="font-size:24px"><?php echo dateUsToFr($date_enc)."---> ".$vendeur; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Client";?></th>
	<th><?php echo "Evaluation";?></th>
	<th><?php echo "Reference";?></th>
	<th><?php echo "ESPECE";?></th>
	<th><?php echo "CHEQUE";?></th>
	<th><?php echo "EFFET";?></th>
	<th><?php echo "AVOIR";?></th>
</tr>

<?php $compteur1=0;$total_g=0;$total_e=0;$total_c=0;$total_t=0;$total_a=0;
while($users_1 = fetch_array($users11)) { $id_r=$users_1["id"];$date_enc=$users_1["date_enc"];$vendeur=$users_1["vendeur"];
			$client=$users_1["client"];$evaluation=$users_1["evaluation"];$id_commande=$users_1["id_commande"];
			$mode=$users_1["mode"];$valeur=$users_1["valeur"];$v_banque=$users_1["v_banque"];$numero_cheque=$users_1["numero_cheque"];
			$ref=$v_banque." ".$numero_cheque;?>
			<tr><?php $dt=dateUsToFr($users_1["date_enc"]); ?>
			<? echo "<td><a href=\"evaluation_vers_reglement2.php?id=$id_r\">$dt</a></td>";?>
			<td><?php echo $client; ?></td>
			<td><?php echo $evaluation; ?></td>
			<td><?php echo $ref; ?></td>

			<? if ($mode=="ESPECE"){?> <td align="right"><?php $total_e=$total_e+$valeur;echo number_format($valeur,2,',',' '); ?></td><TD></TD><TD></TD><td></td><? }?>
			<? if ($mode=="CHEQUE"){?> <td></td><td align="right"><?php $total_c=$total_c+$valeur;echo number_format($valeur,2,',',' '); ?></td><td></td><td></td><? }?>
			<? if ($mode=="EFFET"){?> <td></td><TD></TD><td align="right"><?php $total_t=$total_t+$valeur;echo number_format($valeur,2,',',' '); ?></td><td></td><? }?>
			<? if ($mode=="AVOIR"){?> <td></td><TD></TD><TD></TD><td align="right"><?php $total_a=$total_a+$valeur;echo number_format($valeur,2,',',' '); ?></td><? }?>
<? } ?>
<tr><td></td><td></td><td></td><td></td>
			<td align="right" bgcolor="#6699FF"><?php echo number_format($total_e,2,',',' '); ?></td>
			<td align="right" bgcolor="#6699FF"><?php echo number_format($total_c,2,',',' '); ?></td>
			<td align="right" bgcolor="#6699FF"><?php echo number_format($total_t,2,',',' '); ?></td>
			<td align="right" bgcolor="#6699FF"><?php echo number_format($total_a,2,',',' '); ?></td>
</table>
	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link rel="stylesheet" type="text/css" href="styles.css">

</head>

<body style="background:#dfe8ff">

<p style="text-align:center">

</body>

</html>