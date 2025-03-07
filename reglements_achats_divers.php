<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$produit = $_REQUEST["produit"];$taux_tva=$_REQUEST["taux_tva"];$prix=$_REQUEST["prix"];
			$date = dateFrToUs($_REQUEST["date"]);$date1 = $_REQUEST["date"];
			$frs = $_REQUEST["frs"];$ref = $_REQUEST["ref"];$date_bl = dateFrToUs($_REQUEST["date_bl"]);


		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
				$d=dateFrToUs(date("d/m/Y"));$mat="divers";
				$sql  = "INSERT INTO factures_achats ( produit,type, frs,ref,date,date_bl,date_ins,prix_achat,solde,taux_tva ) VALUES ( ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $mat . "', ";
				$sql .= "'" . $frs . "', ";
				$sql .= "'" . $ref . "', ";
				$sql .= "'" . $date . "', ";$sql .= "'" . $date_bl . "', ";
				$sql .= "'" . $d . "', ";
				$sql .= "'" . $prix . "', ";$sql .= "'" . $prix . "', ";
				$sql .= $taux_tva . ");";

				db_query($database_name, $sql);
			

			break;

			case "update_user":

			$sql = "UPDATE factures_achats SET ";
			$sql .= "produit = '" . $_REQUEST["produit"] . "', ";
			$sql .= "frs = '" . $_REQUEST["frs"] . "', ";
			$sql .= "ref = '" . $_REQUEST["ref"] . "', ";
			$sql .= "taux_tva = '" . $_REQUEST["taux_tva"] . "', ";
			$sql .= "date = '" . $date . "', ";
			$sql .= "date_bl = '" . $date_bl . "', ";
			$sql .= "solde = '" . $prix . "', ";
			$sql .= "prix_achat = '" . $prix . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			// delete user's profile
			$sql = "DELETE FROM factures_achats WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	
	// recherche ville
	?>
	
	<?
	$sql  = "SELECT * ";$mat="divers";$debut_exe="2011-01-01";
	$sql .= "FROM factures_achats where solde<>0 ORDER BY date;";
	$users = db_query($database_name, $sql);
	
	/*$d=dateFrToUs(date("d/m/Y"));
	$sql  = "SELECT * ";
	$sql .= "FROM achats_mat where date_ins='$d' ORDER BY date;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);*/

	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "Production"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "achat_divers.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Fournisseurs Divers"; ?></span>

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>


<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Fournisseur";?></th>
	<th><?php echo "Prestation";?></th>
	<th><?php echo "Facture N°";?></th>
	<th><?php echo "Montant";?></th>
	<th><?php echo "Taux TVA";?></th>
	

</tr>
<? while($users_ = fetch_array($users)) {?><tr>
	<td><?php echo dateUsToFr($users_["date"]);?></td>
	<td align="left"><?php $id_facture=$users_["id"];$frs=$users_["frs"];$ref=$users_["ref"];echo $users_["frs"];?></td>
	<td align="left"><?php echo $users_["produit"];?></td>
	<td align="left"><?php echo $users_["ref"];?></td>
	<td align="center"><?php echo number_format($users_["prix_achat"],2,',',' ');?></td>
	<td align="center"><?php echo number_format($users_["taux_tva"],2,',',' ');?></td>
	

<? }?>
</table>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>
	

</body>

</html>