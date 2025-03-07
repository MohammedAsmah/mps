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
			if(isset($_REQUEST["encaisse"])) { $encaisse = 1; }else { $encaisse = 0; }
			if(isset($_REQUEST["remise"])) { $remise = 1; $id_r=$id_registre;} else { $remise = 0; $id_r=0;}
			if(isset($_REQUEST["r_impaye"])) { $r_impaye = 1; } else { $r_impaye = 0; }
					$sql = "UPDATE porte_feuilles SET ";
					$sql .= "numero_remise = '" . $id_r . "', ";
					$sql .= "date_cheque = '" . $date_cheque . "', ";
					$sql .= "date_impaye = '" . $date_impaye . "', ";
					$sql .= "r_impaye = '" . $r_impaye . "', ";
					$sql .= "date_impaye_e = '" . $date_impaye . "', ";
					$sql .= "r_impaye_e = '" . $r_impaye . "', ";
					$sql .= "encaisse = '" . $encaisse . "', ";
					$sql .= "remise = '" . $remise . "' ";
					$sql .= "WHERE id = " . $id . ";";
					db_query($database_name, $sql);
					
					
					$sql = "UPDATE porte_feuilles_factures SET ";
					$sql .= "numero_remise = '" . $id_r . "', ";
					$sql .= "date_cheque = '" . $date_cheque . "', ";
					
					$sql .= "date_impaye = '" . $date_impaye . "', ";
					$sql .= "r_impaye = '" . $r_impaye . "', ";
					$sql .= "date_impaye_e = '" . $date_impaye . "', ";
					$sql .= "r_impaye_e = '" . $r_impaye . "', ";
					$sql .= "remise = '" . $remise . "' ";
					$sql .= "WHERE id_porte_feuille = " . $id . ";";
					db_query($database_name, $sql);
					
					
					///insertion cheque impaye :
					
					$action="recherche";$ref="";
					
					
					
					}
	if(isset($_REQUEST["action_1"])) { 
			$date_cheque =dateFrToUs($_REQUEST["date_cheque"]);$client_tire=$_REQUEST["client_tire"];$id_registre=$_REQUEST["id_registre"];
			$client = $_REQUEST["client"];$total_cheque=$_REQUEST["total_cheque"];$id=$_REQUEST["user_id"];
			$numero_cheque=$_REQUEST["numero_cheque"];$date_impaye =dateFrToUs($_REQUEST["date_impaye"]);$date_echeance =dateFrToUs($_REQUEST["date_echeance"]);
			if(isset($_REQUEST["remise"])) { $remise = 1; $id_r=$id_registre;} else { $remise = 0; $id_r=0;}
			if(isset($_REQUEST["r_impaye"])) { $r_impaye = 1; } else { $r_impaye = 0; }
						
					
					$sql = "UPDATE porte_feuilles_factures SET ";
					$sql .= "numero_remise = '" . $id_r . "', ";
					$sql .= "date_cheque = '" . $date_cheque . "', ";$sql .= "date_echeance = '" . $date_echeance . "', ";
					$sql .= "date_impaye = '" . $date_impaye . "', ";
					$sql .= "r_impaye = '" . $r_impaye . "', ";
					$sql .= "date_impaye_e = '" . $date_impaye . "', ";
					$sql .= "r_impaye_e = '" . $r_impaye . "', ";
					$sql .= "remise = '" . $remise . "' ";
					$sql .= "WHERE id = " . $id . ";";
					db_query($database_name, $sql);
					
					
					///insertion cheque impaye :
					
					$action="recherche";$ref="";
					
					
					
					}				
					
					
	$action="recherche";$ref="";
	
	?>
	<? if(isset($_REQUEST["action"])){}else{ ?>
	<form id="form" name="form" method="post" action="recherche.php">
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
	$sql  = "SELECT id,id_registre_regl,numero_remise,date_enc,encaisse,date_cheque,date_echeance,date_remise,date_remise_e,remise_e,client,facture_n,remise,
	montant_f,client_tire,v_banque,numero_cheque,sum(m_cheque) As total_cheque,sum(m_effet) As total_effet ";
	$sql .= "FROM porte_feuilles where m_cheque='$ref' or numero_cheque LIKE '$ref%' or facture_n='$ref' or numero_effet LIKE '$ref%' GROUP BY id ;";
	$users11 = db_query($database_name, $sql);
	
	
?>


<span style="font-size:24px"><?php echo "Resultat recherche RE pour $ref " ; ?></span>

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
	<th><?php echo "Enc";?></th>
	<th><?php echo "Date Remise";?></th>
</tr>

<?php 



$compteur1=0;$total_g=0;
while($users_1 = fetch_array($users11)) { 
			$id_registre_regl=$users_1["id_registre_regl"];$id_registre=$users_1["numero_remise"];$id=$users_1["id"];
			$date_enc=$users_1["date_enc"];$date_echeance=$users_1["date_echeance"];$facture_n=$users_1["facture_n"];$e=$users_1["encaisse"];
			$montant_f=$users_1["montant_f"];$remise=$users_1["remise"];$total_effet=$users_1["total_effet"];
			$client=$users_1["client"];$client_tire=$users_1["client_tire"];$date_remise=$users_1["date_remise"];
			$v_banque=$users_1["v_banque"];$numero_cheque=$users_1["numero_cheque"];$total_cheque=$users_1["total_cheque"];
			$ref=$v_banque." ".$numero_cheque;$date_remise_e=$users_1["date_remise_e"];$remise_e=$users_1["remise_e"];
			if ($total_cheque>0){$date_cheque=$users_1["date_cheque"];$t=$total_cheque;$r=$remise;$dr=$date_remise;}
			if ($total_effet>0){$date_cheque=$users_1["date_echeance"];$t=$total_effet;$r=$remise_e;$dr=$date_remise_e;}?>
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
			<?php if ($r==1){$rep="oui";}else{$rep="non";} ?>
			<? echo "<td><a href=\"remise_imp.php?id_registre=$id_registre&user_id=$id\">".$rep."</a></td>";?>
			<?php if ($e==1){$rep="oui";}else{$rep="non";} ?>
			<? echo "<td><a href=\"remise_imp.php?id_registre=$id_registre&user_id=$id\">".$rep."</a></td>";?>
			<td><?php if ($r==1){echo dateUsToFr($dr);} ?></td>
			</tr>




<? } ?>


<?php ?>
</table>
</strong>
<p style="text-align:center">
<? }?>


<? 	

	
	if (isset($_REQUEST["action"])){
	$ref=$_POST['ref'];
	$sql  = "SELECT id,id_registre_regl,numero_remise,date_enc,date_cheque,date_echeance,date_remise,date_remise_e,remise_e,client,facture_n,remise,
	montant_f,client_tire,v_banque,numero_cheque,sum(m_cheque) As total_cheque,sum(m_effet) As total_effet ";
	$sql .= "FROM porte_feuilles_factures where m_cheque='$ref' or numero_cheque='$ref' or facture_n='$ref' or numero_effet='$ref' GROUP BY id ;";
	$users111 = db_query($database_name, $sql);
	
	
?>


<span style="font-size:24px"><?php echo "Resultat recherche RF pour $ref " ; ?></span>

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

<?php 



$compteur1=0;$total_g=0;
while($users_11 = fetch_array($users111)) { 
			$id_registre_regl=$users_11["id_registre_regl"];$id_registre=$users_11["numero_remise"];$id=$users_11["id"];
			$date_enc=$users_11["date_enc"];$date_echeance=$users_11["date_echeance"];$facture_n=$users_11["facture_n"];
			$montant_f=$users_11["montant_f"];$remise=$users_11["remise"];$total_effet=$users_11["total_effet"];
			$client=$users_11["client"];$client_tire=$users_11["client_tire"];$date_remise=$users_11["date_remise"];
			$v_banque=$users_11["v_banque"];$numero_cheque=$users_11["numero_cheque"];$total_cheque=$users_11["total_cheque"];
			$ref=$v_banque." ".$numero_cheque;$date_remise_e=$users_11["date_remise_e"];$remise_e=$users_11["remise_e"];
			if ($total_cheque>0){$date_cheque=$users_11["date_cheque"];$t=$total_cheque;$r=$remise;$dr=$date_remise;}
			if ($total_effet>0){$date_cheque=$users_11["date_echeance"];$t=$total_effet;$r=$remise_e;$dr=$date_remise_e;}?>
			<tr>
			<? echo "<td>$id_registre_regl</td>";?>
			<td><?php echo $client; ?></td>
			<td><?php echo $client_tire; ?></td>
			<td><?php echo dateUsToFr($date_enc); ?></td>
			<td><?php echo dateUsToFr($date_cheque); ?></td>
			<td><?php echo $ref; ?></td>
			<td align="right"><?php echo number_format($t,2,',',' '); ?></td>
			<td><?php echo $facture_n; ?></td>
			<td><?php echo number_format($montant_f,2,',',' '); ?></td>
			<?php if ($r==1){$rep="oui";}else{$rep="non";} ?>
			<? echo "<td><a href=\"remise_imp1.php?id_registre=$id_registre&user_id=$id\">".$rep."</a></td>";?>
			<td><?php if ($r==1){echo dateUsToFr($dr);} ?></td>
			</tr>




<? } ?>


<?php ?>
</table>
</strong>
<p style="text-align:center">
<? }?>


</body>

</html>