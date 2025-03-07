<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"])) { $id_facture=$_REQUEST["id_facture"];

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$produit = $_REQUEST["produit"];$montant_g=$_REQUEST["montant_g"];$montant_t=$_REQUEST["montant_t"];
			$date = dateFrToUs($_REQUEST["date"]);$date1 = $_REQUEST["date"];
			$frs = $_REQUEST["frs"];$ref = $_REQUEST["ref"];$date_valeur = dateFrToUs($_REQUEST["date_valeur"]);


		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
				$d=dateFrToUs(date("d/m/Y"));$mat="divers";
				$sql  = "INSERT INTO reglements_factures_achats ( id_facture,frs,ref,date,date_valeur,date_ins,montant_g,montant_t ) VALUES ( ";
				$sql .= "'" . $id_facture . "', ";
				$sql .= "'" . $frs . "', ";
				$sql .= "'" . $ref . "', ";
				$sql .= "'" . $date . "', ";$sql .= "'" . $date_valeur . "', ";
				$sql .= "'" . $montant_g . "', ";$sql .= "'" . $montant_t . "', ";
				$sql .= $d . ");";

				db_query($database_name, $sql);
			

			break;

			case "update_user":

			$sql = "UPDATE reglements_factures_achats SET ";
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
			$sql = "DELETE FROM reglements_factures_achats WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} else
	{$id_facture=$_GET["id_facture"];}
	
	
	// recherche ville
	?>
	
	<?
	$sql  = "SELECT * ";$mat="divers";
	$sql .= "FROM reglements_factures_achats where id_facture=$id_facture ORDER BY date;";
	$users = db_query($database_name, $sql);
	
	

	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "Production"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "regl_achat_divers.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Reglements Fournisseurs Divers"; ?></span>

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>


<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Fournisseur";?></th>
	<th><?php echo "Facture N°";?></th>
	<th><?php echo "Montant";?></th>
	<th><?php echo "Mode";?></th>
	

</tr>
<? while($users_ = fetch_array($users)) {?><tr>
	<?php $id=$users_["id"]; ?><?php $date_r=dateUsToFr($users_["date"]);?>
	<? echo "<td><a href=\"regl_achat_divers.php?frs=$frs&user_id=$id&id_facture=$id_facture\">$date_r</a></td>";?>
	<td align="left"><?php echo $users_["frs"];?></td>
	<td align="left"><?php echo $users_["produit"];?></td>
	<td align="left"><?php echo $users_["ref"];?></td>
	<td align="center"><?php echo number_format($users_["montant_g"],2,',',' ');?></td>
	<td align="center"><?php echo number_format($users_["montant_t"],2,',',' ');?></td>
	

<? }?>
</table>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>
<? echo "<td><a href=\"regl_achat_divers.php?frs=$frs&id_facture=$id_facture&user_id=0\">Ajout reglement</a></td>";?>	

</body>

</html>