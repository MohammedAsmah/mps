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
		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			
			$date = dateFrToUs($_REQUEST["date"]);
			list($annee1,$mois1,$jour1) = explode('-', $date); 
			$pdu = mktime(0,0,0,$mois1,$jour1,$annee1); 
			$mois=date("m",$pdu);$annee=date("Y",$pdu);
			$service=$_REQUEST["service"];
			$vendeur=$_REQUEST["vendeur"];
			$result = mysql_query("SELECT bon_sortie FROM registre_vendeurs where mois=$mois and annee=$annee ORDER BY bon_sortie DESC LIMIT 0,1"); 
			$row = mysql_fetch_array($result); 
			echo $row["bon_sortie"];
			$dir = $row["bon_sortie"]+1;
	
			
			$statut=$dir."/".$mois.$annee;
			$date_open=$_REQUEST["date_open"];
			$user_open=$user_name;
			$observation=$_REQUEST["observation"];
			$motif_cancel=$_REQUEST["motif_cancel"];
			
			
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
	// recherche contrat			
		$code_produit="";
			
				$type_service="SEJOURS ET CIRCUITS";
				$sql  = "INSERT INTO registre_vendeurs (date,service,vendeur,date_open,user_open,observation,mois,annee,bon_sortie,statut)
				 VALUES ('$date','$service','$vendeur','$date_open','$user_open','$observation','$mois','$annee','$dir','$statut')";

				db_query($database_name, $sql);
			

			break;

			case "update_user":
			
			$sql = "UPDATE registre_vendeurs SET ";
			$sql .= "service = '" . $_REQUEST["service"] . "', ";
			$sql .= "date = '" . $date . "', ";
			$sql .= "observation = '" . $observation . "', ";
			$sql .= "vendeur = '" . $vendeur . "', ";
			$sql .= "motif_cancel = '" . $motif_cancel . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
			//mise à jour commandes
			$sql = "UPDATE commandes SET ";
			$sql .= "date_e = '" . $date . "' ";
			$sql .= "WHERE id_registre = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
			
			break;
			
			case "delete_user":
			
			
			// delete user's profile
			$sql = "DELETE FROM registre_vendeurs WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	else {$vendeur="";$date1="";}
	if(isset($_REQUEST["action_"]) and $_REQUEST["action_"] != "delete_user") { $date1 = $_REQUEST["date"];}
	else {$vendeur="";$date1="";}
	$action="recherche";
	
	
	?>
	<? if(isset($_REQUEST["action"])){}else{ ?>
	<form id="form" name="form" method="post" action="registres_reglements_update1.php">
	<td><?php echo "Date : "; ?><input onclick="ds_sh(this);" name="date1" value="<?php echo $date1; ?>" readonly="readonly" style="cursor: text" /></td>
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
	function EditUser(user_id) { document.location = "registre_vendeur.php?user_id=" + user_id; }
	function EditUser1(user_id) { document.location = "registre_sejour_annuler_sans_lp.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<? 	if(isset($_REQUEST["action"]))
	{ $date=dateFrToUs($_POST['date1']);
	
	$sql  = "SELECT * ";
	$sql .= "FROM registre_reglements where ancien_registre<>0 ORDER BY id;";
	$users111 = db_query($database_name, $sql);
?>


<span style="font-size:24px"><?php echo dateUsToFr($date); ?></span>

<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Destination";?></th>
	<th><?php echo "Vendeur";?></th>
	<th><?php echo "Montant";?></th>
	<th><?php echo "B.S Vendeur";?></th>
	<th><?php echo "B.S Magasin";?></th>
	<th><?php echo "Eval.Clients";?></th>
	
	
</tr>

<?php $compteur1=0;$total_g=0;
while($user_ = fetch_array($users111)) { 
		$date=$user_["date"];$ancien_registre=$user_["ancien_registre"];$idr=$user_["id"];
	$sql  = "SELECT *";
	$sql .= "FROM porte_feuilles_2009 where id_registre_regl='$ancien_registre' Order BY id;";
	$users11 = db_query($database_name, $sql);
	while($users_1 = fetch_array($users11)) { 
			$id_r=$users_1["id"];$date_enc=$users_1["date_enc"];$vendeur=$users_1["vendeur"];$id_commande=$users_1["id_commande"];
			$client=$users_1["client"];$evaluation=$users_1["evaluation"];$montant_e=$users_1["montant_e"];
			$mode=$users_1["mode"];$m_cheque=$users_1["m_cheque"];$v_banque=$users_1["v_banque"];$numero_cheque=$users_1["numero_cheque"];
			$m_espece=$users_1["m_espece"];$m_effet=$users_1["m_effet"];$m_avoir=$users_1["m_avoir"];
			$m_diff_prix=$users_1["m_diff_prix"];$m_virement=$users_1["m_virement"];$impaye=$users_1["impaye"];$obs_diff_prix=$users_1["obs_diff_prix"];
			$client_tire=$users_1["client_tire"];$client_tire_e=$users_1["client_tire_e"];$n_banque=$users_1["n_banque"];$n_banque_e=$users_1["n_banque_e"];
			$v_banque_e=$users_1["v_banque_e"];	$v_banque_v=$users_1["v_banque_v"];	$facture_n=$users_1["facture_n"];
			$montant_f=$users_1["montant_f"];$date_cheque=$users_1["date_cheque"];$date_echeance=$users_1["date_echeance"];$date_virement=$users_1["date_virement"];
			$date_remise_cheque=$users_1["date_remise_cheque"];$date_remise_effet=$users_1["date_remise_effet"];
			$numero_cheque=$users_1["numero_cheque"];$numero_virement=$users_1["numero_virement"];$numero_effet=$users_1["numero_effet"];
	$numero_avoir=$users_1["numero_avoir"];?>
	<tr><td><? echo $date_enc."--".$ancien_registre."--".$client."-->".$idr;?></td></tr><?
	
	
	
	
	$sql1  = "INSERT INTO porte_feuilles 
	(vendeur,	id_commande,client ,client_tire,client_tire_e,	n_banque,	n_banque_e,	v_banque,	v_banque_e,	v_banque_v,	date_enc,
	id_registre_regl,	facture_n,	montant_f,	evaluation,	montant_e,	date_cheque,	date_echeance,	date_virement,
	date_remise_cheque,	date_remise_effet,	m_cheque,	m_espece,	m_effet,	m_virement,	m_avoir,	m_diff_prix,
	obs_diff_prix,	numero_cheque,	numero_virement,	numero_effet,	numero_avoir )
	VALUES ('$vendeur',	'$id_commande',	'$client',	'$client_tire',	'$client_tire_e',	'$n_banque',	'$n_banque_e',
	'$v_banque',
	'$v_banque_e',
	'$v_banque_v',
	'$date_enc',
	'$idr',
	'$facture_n',
	'$montant_f',
	'$evaluation'
	,'$montant_e',
	'$date_cheque',
	'$date_echeance',
	'$date_virement',
	'$date_remise_cheque',
	'$date_remise_effet',
	'$m_cheque',
	'$m_espece',
	'$m_effet',
	'$m_virement',
	'$m_avoir',
	'$m_diff_prix',
	'$obs_diff_prix',
	'$numero_cheque',
	'$numero_virement',
	'$numero_effet',
	'$numero_avoir')";
	db_query($database_name, $sql1);




 } 
 } 
 
 
 
 
 
 ?>

</table>
</strong>
<p style="text-align:center">

<? }?>
</body>

</html>