<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$user_name=GetUserName();
	$error_message = "";
	$type_service="SEJOURS ET CIRCUITS";
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
		if(isset($_REQUEST["action_"])) { 
			$date_cheque =dateFrToUs($_REQUEST["date_cheque"]);$client_tire=$_REQUEST["client_tire"];$id_registre=$_REQUEST["id_registre"];
			$client = $_REQUEST["client"];$total_cheque=$_REQUEST["total_cheque"];$id=$_REQUEST["user_id"];
			$numero_cheque=$_REQUEST["numero_cheque"];$date_impaye =dateFrToUs($_REQUEST["date_impaye"]);
			if(isset($_REQUEST["remise"])) { $remise = 1; $id_r=$id_registre;} else { $remise = 0; $id_r=0;}
			if(isset($_REQUEST["r_impaye"])) { $r_impaye = 1; } else { $r_impaye = 0; }
					$sql = "UPDATE porte_feuilles SET ";
					$sql .= "numero_remise = '" . $id_r . "', ";
					$sql .= "date_cheque = '" . $date_cheque . "', ";
					$sql .= "date_impaye = '" . $date_impaye . "', ";
					$sql .= "r_impaye = '" . $r_impaye . "', ";
					$sql .= "remise = '" . $remise . "' ";
					$sql .= "WHERE id = " . $id . ";";
					db_query($database_name, $sql);
					
					///insertion cheque impaye :
					
					$action="recherche";$ref="";
					
					
					
					}
	$action="recherche";$ref="";
	
	?>
	<? if(isset($_REQUEST["action"])){}else{ ?>
	<form id="form" name="form" method="post" action="miseajour_portefeuille_commandes.php">
	<TR><td><?php $ref="";echo "Reference ou valeur	: "; ?></td><td><input type="text" id="ref" name="ref" value="<?php echo $ref; ?>">
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

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "registre_reglement.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<? 	

	
	if (isset($_REQUEST["action"])){
	$ref=$_POST['ref'];
	/*$sql  = "SELECT id,id_registre_regl,numero_remise,date_enc,date_cheque,date_echeance,date_remise,client,facture_n,remise,
	montant_f,client_tire,v_banque,numero_cheque,sum(m_cheque) As total_cheque,sum(m_effet) As total_effet ";
	$sql .= "FROM porte_feuilles where m_cheque='$ref' or numero_cheque='$ref' or facture_n='$ref' or numero_effet='$ref' GROUP BY id;";
	*/
	$du="2010-01-01";$au="2015-12-31";
	$sql  = "SELECT id,id_registre_regl,numero_remise,id_commande,date_enc,date_cheque,date_echeance,date_remise,client,facture_n,remise,
	montant_f,client_tire,v_banque,numero_cheque,sum(m_cheque) As total_cheque,sum(m_effet) As total_effet ";
	$sql .= "FROM porte_feuilles where date_enc between '$du' and '$au' GROUP BY id;";
	$users11 = db_query($database_name, $sql);



?>


<span style="font-size:24px"><?php echo "Resultat recherche pour $ref " ; ?></span>

<table class="table2">

<tr>	<th><?php echo "Registre";?></th>

	<th><?php echo "Client";?></th>
	<th><?php echo "Client Tiré";?></th>
	<th><?php echo "Date Entree";?></th>
	<th><?php echo "Date Encaisse";?></th>
	<th><?php echo "Reference";?></th>
	<th><?php echo "Montant";?></th>
	<th><?php echo "Facture";?></th>
	<th><?php echo "Montant Fact";?></th>
	<th><?php echo "Remis";?></th>
	<th><?php echo "Date Remise";?></th>
</tr>

<?php $compteur1=0;$total_g=0;
while($users_1 = fetch_array($users11)) { 
			$id_registre_regl=$users_1["id_registre_regl"];$id_registre=$users_1["numero_remise"];$id=$users_1["id"];
			$date_enc=$users_1["date_enc"];$date_echeance=$users_1["date_echeance"];$facture_n=$users_1["facture_n"];
			$montant_f=$users_1["montant_f"];$remise=$users_1["remise"];$total_effet=$users_1["total_effet"];
			$client=$users_1["client"];$client_tire=$users_1["client_tire"];$date_remise=$users_1["date_remise"];
			$v_banque=$users_1["v_banque"];$numero_cheque=$users_1["numero_cheque"];$total_cheque=$users_1["total_cheque"];
			$ref=$v_banque." ".$numero_cheque;
			if ($total_cheque>0){$date_cheque=$users_1["date_cheque"];$t=$total_cheque;}
			if ($total_effet>0){$date_cheque=$users_1["date_echeance"];$t=$total_effet;}?>
			<tr>
			<? echo "<td><a href=\"registres_reglements_consult.php?id=$id_registre_regl\">$id_registre_regl</a></td>";?>
			<td><?php echo $client; ?></td>
			<td><?php echo $client_tire; ?></td>
			<td><?php echo dateUsToFr($date_enc); ?></td>
			<td><?php echo dateUsToFr($date_cheque); ?></td>
			<td><?php echo $ref; ?></td>
			<td align="right"><?php echo number_format($t,2,',',' '); ?></td>
			<td><?php echo $facture_n; ?></td>
			<td><?php echo number_format($montant_f,2,',',' '); ?></td>
			<?php if ($remise==1){$rep="oui";}else{$rep="non";} ?>
			<? echo "<td><a href=\"remise_imp.php?id_registre=$id_registre&user_id=$id\">".$rep."</a></td>";?>
			<td><?php if ($remise==1){echo dateUsToFr($date_remise);} ?></td>
			</tr>

				<?
				if ($facture_n==0){
				$sql  = "SELECT * ";$cde=$users_1["id_commande"];$date2010="2009-12-31";
				$sql .= "FROM commandes where date_e>'$date2010' and id='$cde' ORDER BY id;";
				$users = db_query($database_name, $sql);$row = fetch_array($users);
					$date_e=$row["date_e"];
					$sql = "UPDATE porte_feuilles SET ";
					$sql .= "date_e = '" . $date_e . "' ";
					$sql .= "WHERE id = " . $id . ";";
					db_query($database_name, $sql);}
					else
					{				$sql  = "SELECT * ";$cde=$users_1["id_commande"];$date2010="2009-12-31";
				$sql .= "FROM factures where date_f>'$date2010' and id='$cde' ORDER BY id;";
				$users = db_query($database_name, $sql);$row = fetch_array($users);
					$date_e=$row["date_f"];
					$sql = "UPDATE porte_feuilles SET ";
					$sql .= "date_e = '" . $date_e . "' ";
					$sql .= "WHERE id = " . $id . ";";
					db_query($database_name, $sql);}


?>



<? } ?>
</table>
</strong>
<p style="text-align:center">
<? }?>
</body>

</html>