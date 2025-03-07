<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$user_name=GetUserName();
	$error_message = "";
	$type_service="SEJOURS ET CIRCUITS";$action="Recherche";$date1="";$date2="";
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	$vendeur_list = "";$vendeur="";
	$sql = "SELECT * FROM  vendeurs ORDER BY vendeur;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($vendeur == $temp_["vendeur"]) { $selected = " selected"; } else { $selected = ""; }
		
		$vendeur_list .= "<OPTION VALUE=\"" . $temp_["vendeur"] . "\"" . $selected . ">";
		$vendeur_list .= $temp_["vendeur"];
		$vendeur_list .= "</OPTION>";
	}

	
	?>
	<? if(isset($_REQUEST["action"])){}else{ ?>
	<form id="form" name="form" method="post" action="journal_encaissements.php">
	<td><?php echo "du : "; ?><input onclick="ds_sh(this);" name="date1" value="<?php echo $date1; ?>" readonly="readonly" style="cursor: text" /></td>
	<td><?php echo "au : "; ?><input onclick="ds_sh(this);" name="date2" value="<?php echo $date2; ?>" readonly="readonly" style="cursor: text" /></td>
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
	$sql  = "SELECT * ";$espece="ESPECE";$vide="0000-00-00";$date1=dateFrToUs($_POST['date1']);$total=0;$date2=dateFrToUs($_POST['date2']);
	$sql .= "FROM porte_feuilles_factures where date_enc='$vide' or date_f='$vide' and facture_n>16000 ORDER BY id_registre_regl;";
	$users11 = db_query($database_name, $sql);
	
	
	/*$sql  = "SELECT * ";
	$sql .= "FROM registre_reglements where id>5000 ORDER BY id;";
	$users11 = db_query($database_name, $sql);*/
	
	
	
	
?>


<span style="font-size:24px"><?php echo "Journal Encaissments du : ".dateUsToFr($date)." ".$vendeur; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Client";?></th>	<th><?php echo "Vendeur";?></th>

	<th><?php echo "Evaluation";?></th>
	<th><?php echo "Montant";?></th>
	<th><?php echo "Reference";?></th>
	<th><?php echo "DATE E";?></th>
</tr>

<?php $compteur1=0;$total_g=0;
while($users_1 = fetch_array($users11)) { $id_r=$users_1["id"];$date_enc=$users_1["date_enc"];$vendeur=$users_1["vendeur"];
			$client=$users_1["client"];$evaluation=$users_1["evaluation"];$facture_n=$users_1["facture_n"];$id_regl=$users_1["id_registre_regl"];
			$mode=$users_1["mode"];$valeur=$users_1["valeur"];$v_banque=$users_1["v_banque"];$numero_cheque=$users_1["numero_cheque"];
			$ref=$v_banque." ".$numero_cheque;$date_e=$users_1["date_e"];$id_commande=$users_1["id_commande"];
			
		if ($facture_n<>0){
		$sql  = "SELECT * ";
		$sql .= "FROM factures WHERE numero = '$facture_n' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$date_f = $user_["date_f"];$d=$user_["date_f"];
			$sql = "UPDATE porte_feuilles_factures SET ";
			$sql .= "date_e = '" . $date_f . "', ";
			$sql .= "date_f = '" . $date_f . "' ";
			$sql .= "WHERE id = " . $id_r . ";";
			db_query($database_name, $sql);
		}
		
		
		
		$sql  = "SELECT * ";
		$sql .= "FROM registre_reglements WHERE id = '$id_regl' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$date_enc = $user_["date"];
			$sql = "UPDATE porte_feuilles_factures SET ";
			$sql .= "date_enc = '" . $date_enc . "' ";
			$sql .= "WHERE date_enc = '$vide' and id = " . $id_r . ";";
			db_query($database_name, $sql);
		
		
		
	/*while($users_1 = fetch_array($users11)) { $id_r=$users_1["id"];$date_enc=$users_1["date"];$d="0000-00-00";
			
				
			$sql = "UPDATE porte_feuilles_factures SET ";
			$sql .= "date_enc = '" . $date_enc . "' ";
			
			$sql .= "WHERE date_enc='$d' and id_registre_regl = " . $id_r . ";";
			db_query($database_name, $sql);
		*/
		
		
		
		/*else
		{
				$sql  = "SELECT * ";
		$sql .= "FROM commandes WHERE evaluation = '$evaluation' and id='$id_commande' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$date_f = $user_["date_e"];$d=$user_["date_e"];
			$sql = "UPDATE porte_feuilles SET ";
			$sql .= "date_e = '" . $date_f . "' ";
			$sql .= "WHERE id = " . $id_r . ";";
			db_query($database_name, $sql);
		}*/
		
		
			
			
			
			
			
			
			
			?>
<? } ?>
</strong>
<p style="text-align:center">




</table>


<? }?>
</body>

</html>