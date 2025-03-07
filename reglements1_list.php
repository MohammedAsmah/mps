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
	
	if ($_REQUEST["action_r"]=="reglement"){
	
		$id_commande = $_REQUEST["id_commande"];
	 	$sql  = "SELECT * ";
		$sql .= "FROM factures where id='$id_commande' ORDER BY date_f;";$client="";
		$users2 = db_query($database_name, $sql);$users2_ = fetch_array($users2);
		$solde=$users2_["solde"];$client=$users2_["client"];
		$id_registre = $_REQUEST["id_registre"];$montant_e=$_REQUEST["montant_e"];$date_enc=$_REQUEST["date_enc"];
		$vendeur=$_REQUEST["vendeur"];$date_enc2=$_REQUEST["date_enc"];$obs=$_REQUEST["obs"];
		$facture=$_REQUEST["id_commande"]+9040;$montant_f=$_REQUEST["montant_e"];
//1er regl		
		$montant_r=$_REQUEST["montant_r"];$ref=$_REQUEST["ref"];$mode=$_REQUEST["ref"];
		$date_valeur=dateFrToUs($_REQUEST["date_valeur"]);$v_banque=$_REQUEST["v_banque"];
		$n_banque="BCP";$client_tire=$_REQUEST["client_tire"];$date_remise_cheque=dateFrToUs($_REQUEST["date_valeur"]);
		$solde=$solde+$montant_r;
		
		$montant_enc=$montant_r;$evaluation="";

			$sql = "UPDATE factures SET ";$valider_f=1;$oui=1;
			$sql .= "id_registre_regl = '" . $id_registre . "', ";
			$sql .= "solde = '" . $solde . "' ";
			$sql .= "WHERE id = " . $id_commande . ";";
			db_query($database_name, $sql);
	$sql1  = "INSERT INTO reglements  
	(vendeur,id_commande,client ,client_tire,n_banque,v_banque,date_enc,id_registre_regl,
	facture_n,montant_f,evaluation,montant_e,date_valeur,montant_r,obs,ref,mode )
	VALUES ('$vendeur','$id_commande','$client','$client_tire','$n_banque','$v_banque','$date_enc','$id_registre','$facture','$montant_f',
	'$evaluation','$montant_e','$date_valeur','$montant_r','$obs','$ref','$mode')";
	db_query($database_name, $sql1);
	}
	else
	///mise à jour reglments //////////////////////////////
	{
		$montant_r=$_REQUEST["montant_r"];$ref=$_REQUEST["ref"];$mode=$_REQUEST["ref"];$obs=$_REQUEST["ref"];
		$date_valeur=dateFrToUs($_REQUEST["date_valeur"]);$v_banque=$_REQUEST["v_banque"];
		$n_banque="BCP";$client_tire=$_REQUEST["client_tire"];$date_remise_cheque=dateFrToUs($_REQUEST["date_valeur"]);
		$solde=$solde+$montant_r;
			
			$sql = "UPDATE reglements SET ";
			$sql .= "montant_r = '" . $montant_r . "', ";
			$sql .= "v_banque = '" . $v_banque . "', ";
			$sql .= "montant_e = '" . $montant_e . "', ";
			$sql .= "montant_f = '" . $montant_f . "', ";
			$sql .= "date_valeur = '" . $date_valeur . "', ";
			$sql .= "client_tire = '" . $client_tire . "', ";
			$sql .= "obs = '" . $obs . "', ";
			$sql .= "mode = '" . $mode . "', ";
			$sql .= "ref = '" . $ref . "' ";
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);

	
	}
			
	if ($vendeur=="CAISSE" or $vendeur=="VENTE USINE"){$v1="CAISSE";$v2="VENTE USINE";
	
	$sql  = "SELECT * ";$instance="FACTURE EN INSTANCE";
	$sql .= "FROM factures where (vendeur='$v1' or vendeur='$v2' ) and client<>'$instance' ORDER BY date_f;";
	$users = db_query($database_name, $sql);
	}
	else
	{
	$sql  = "SELECT * ";$instance="FACTURE EN INSTANCE";
	$sql .= "FROM factures where vendeur='$vendeur' and client<>'$instance' ORDER BY date_f;";
	$users = db_query($database_name, $sql);
	}
	
	}
	else
	{

	$id_registre=$_GET['id_registre'];
	$date=$_GET['date_enc'];$date3=$_GET['date_enc'];$date_enc=$_GET['date_enc'];$date_enc2=$_GET['date_enc'];
	$vendeur=$_GET['vendeur'];
	if ($vendeur=="CAISSE" or $vendeur=="VENTE USINE"){$v1="CAISSE";$v2="VENTE USINE";
	$sql  = "SELECT * ";$instance="FACTURE EN INSTANCE";
	$sql .= "FROM factures where (vendeur='$v1' or vendeur='$v2' ) and client<>'$instance' ORDER BY date_f;";
	$users = db_query($database_name, $sql);
	}
	else
	{
	$sql  = "SELECT * ";$instance="FACTURE EN INSTANCE";
	$sql .= "FROM factures where vendeur='$vendeur' and client<>'$instance' ORDER BY date_f;";
	$users = db_query($database_name, $sql);
	}
	
	
	}
	
	$sql  = "SELECT id,date_enc,vendeur,client,facture_n,montant_f,montant_r,id_registre_regl,mode,montant_e,v_banque,ref,client_tire,
	date_valeur, sum(montant_r) As total_r ";
	$sql .= "FROM reglements where id_registre_regl='$id_registre' GROUP by mode,facture_n  Order BY id;";
	$users11 = db_query($database_name, $sql);
	
	?>
	
<table class="table2">

<tr>
	<th><?php echo "Client";?></th>
	<th><?php echo "Facture";?></th>
	<th><?php echo "Montant Facture";?></th>
	<th bgcolor="#33CC66"><?php echo "Avoir";?></th>
	<th bgcolor="#33CC66"><?php echo "Diff/Prix";?></th>
	<th bgcolor="#3366FF"><?php echo "ESPECE";?></th>
	<th bgcolor="#3366FF"><?php echo "CHEQUE";?></th>
	<th bgcolor="#3366FF"><?php echo "EFFET";?></th>
	<th bgcolor="#3366FF"><?php echo "VIREMENT";?></th>
</tr>

<?php $compteur1=0;$total_g=0;$t_espece=0;
while($users_1 = fetch_array($users11)) { 
			$id_r=$users_1["id"];$date_enc1=$users_1["date_enc"];$vendeur=$users_1["vendeur"];$date_enc2=$users_1["date_enc"];
			$client=$users_1["client"];$facture=$users_1["facture_n"];$montant_e=$users_1["montant_e"];$montant_f=$users_1["montant_f"];
			$mode=$users_1["mode"];$montant_r=$users_1["montant_r"];$v_banque=$users_1["v_banque"];$ref=$users_1["ref"];$total_r=$users_1["total_r"];
			$ref=$v_banque." ".$ref;$date_valeur=dateUsToFr($users_1["date_valeur"]);$client_tire=$users_1["client_tire"];?>
			<tr>
			<? echo "<td><a href=\"evaluation_vers_reglement1_list_f.php?id=$id_r&id_registre=$id_registre&vendeur=$vendeur&client=$client&montant=$montant_e\">$client</a></td>";?>
			<td><?php echo $facture; ?></td>
			<td align="right"><?php echo number_format($montant_f,2,',',' '); ?></td>
			<td align="right"><?php echo number_format($total_r,2,',',' '); ?></td>

			
			
<? } ?>
<tr><td bgcolor=""></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>

</table>

	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Factures"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "detail_evaluation.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";
	?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>
<span style="font-size:24px"><?php echo "liste Factures"; ?></span>
<tr>
<td><?php echo $vendeur ;?></td>
			<? echo "<td><a href=\"tableau_enc1.php?id_registre=$id_registre\">Editer Tableau</a></td>";?>
</tr>

<table class="table2">

<tr>
	<th><?php echo "Facture";?></th>
	<th><?php echo "Date";?></th>
	<th><?php echo "Client";?></th>
	<th><?php echo "Net";?></th>
</tr>

<?php 

$total_g=0;
while($users_ = fetch_array($users)) { ?><tr>
	<? $client=$users_["client"];$date=dateUsToFr($users_["date_f"]);
	$vendeur=$users_["vendeur"];$id_commande=$users_["id"];$solde=$users_["solde"];$num=$id_commande+9040;
	echo "<td>$num</td>";?>
	<?php $id=$users_["id"];?>
	<td><?php echo $date; ?></td>
	<td><?php echo $users_["client"]; ?></td>
	<td style="text-align:Right"><?php $net=$users_["montant"];echo number_format($net,2,',',' '); ?></td>
	<? echo "<td><a href=\"evaluation_vers_reglement_list_f.php?id_registre=$id_registre&montant=$net&id_commande=$id_commande&vendeur=$vendeur&client=$client&date_enc=$date_enc2\">valider</a></td>";?>

<?php } ?>

<tr><td></td><td></td><td></td><td></td>
<td style="text-align:Right"><?php echo number_format($total_g,2,',',' '); ?></td>
</tr>

</table>
<tr>
</tr>

<p style="text-align:center">

</body>

</html>