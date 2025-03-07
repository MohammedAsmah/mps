<?php
	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$login = $user_["login"];
	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"])) { 

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$choix1 = $_REQUEST["choix1"] ;
			$choix2 = $_REQUEST["choix2"] ;
			$choix3 = $_REQUEST["choix3"] ;
			$importateur1 = $_REQUEST["importateur1"] ;
			$importateur2 = $_REQUEST["importateur2"] ;
			$importateur3 = $_REQUEST["importateur3"];
			
			$siege_social = $_REQUEST["siege_social"] ;
			$adresse = $_REQUEST["adresse"] ;
			$ville = $_REQUEST["ville"];
			$identifiant = $_REQUEST["identifiant"] ;
			$taxe = $_REQUEST["taxe"];
			$modalite_paiement = $_REQUEST["modalite_paiement"] ;
			
			$numero_rc = $_REQUEST["numero_rc"] ;
			$centre_rc = $_REQUEST["centre_rc"] ;
			$regime_douanier = $_REQUEST["regime_douanier"] ;
			$exp1 =$_REQUEST["exp1"] ;$exp2 =  $_REQUEST["exp2"];
			$exp3 =$_REQUEST["exp3"];$exp4 = $_REQUEST["exp4"];
			$bureau_douanier = $_REQUEST["bureau_douanier"] ;
			$montant =  $_REQUEST["montant"];
			$origine =  $_REQUEST["origine"] ;
			$provenance =  $_REQUEST["provenance"];
			$condition_livraison =  $_REQUEST["condition_livraison"];
			$nomenclature =$_REQUEST["nomenclature"];
			$designation1 =  $_REQUEST["designation1"];
			$designation2 =  $_REQUEST["designation2"];
			$designation3 =  $_REQUEST["designation3"];
			$poids =  $_REQUEST["poids"];
			$complementaires = $_REQUEST["complementaires"];
			$date_imp = dateFrToUs($_REQUEST["date"]);
			echo $date_imp;
		}
		
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				$sql  = "INSERT INTO d_o_a ( choix1, choix2, choix3,importateur1,importateur2,importateur3,
				siege_social,adresse,ville,identifiant,taxe,modalite_paiement,
				numero_rc,centre_rc,regime_douanier,exp1,exp2,exp3,exp4,bureau_douanier,montant,origine,provenance
				,condition_livraison,nomenclature,designation1,designation2,designation3,poids,date_imp,complementaires) VALUES ( ";
								
				$sql .= "'" . $choix1 . "', ";
				$sql .= "'" . $choix2 . "', ";
				$sql .= "'" . $choix3 . "', ";
				$sql .= "'" . $importateur1 . "', ";
				$sql .= "'" . $importateur2 . "', ";
				$sql .= "'" . $importateur3 . "', ";
				
				$sql .= "'" . $siege_social . "', ";
				$sql .= "'" . $adresse . "', ";
				$sql .= "'" . $ville . "', ";
				$sql .= "'" . $identifiant . "', ";
				$sql .= "'" . $taxe . "', ";
				$sql .= "'" . $modalite_paiement . "', ";
				
				$sql .= "'" . $numero_rc . "', ";
				$sql .= "'" . $centre_rc . "', ";
				$sql .= "'" . $regime_douanier . "', ";
				$sql .= "'" . $exp1 . "', ";
				$sql .= "'" . $exp2 . "', ";
				$sql .= "'" . $exp3 . "', ";
				$sql .= "'" . $exp4 . "', ";
				$sql .= "'" . $bureau_douanier . "', ";
				$sql .= "'" . $montant . "', ";
				$sql .= "'" . $origine . "', ";
				$sql .= "'" . $provenance . "', ";
				$sql .= "'" . $condition_livraison . "', ";
				$sql .= "'" . $nomenclature . "', ";
				$sql .= "'" . $designation1 . "', ";
				$sql .= "'" . $designation2 . "', ";
				$sql .= "'" . $designation3 . "', ";
				$sql .= "'" . $poids . "', ";
				$sql .= "'" . $date_imp . "', ";
				$sql .= "'" . $complementaires . "');";

				db_query($database_name, $sql);
			

			break;

			case "update_user":

			$sql = "UPDATE d_o_a SET ";
			$sql .= "choix1 = '" . $_REQUEST["choix1"] . "', ";
			$sql .= "choix2 = '" . $_REQUEST["choix2"] . "', ";
			$sql .= "choix3 = '" . $_REQUEST["choix3"] . "', ";
			$sql .= "importateur1 = '" . $_REQUEST["importateur1"] . "', ";
			$sql .= "importateur2 = '" . $_REQUEST["importateur2"] . "', ";
			$sql .= "importateur3 = '" . $_REQUEST["importateur3"] . "', ";
			
			$sql .= "siege_social = '" . $_REQUEST["siege_social"] . "', ";
			$sql .= "adresse = '" . $_REQUEST["adresse"] . "', ";
			$sql .= "ville = '" . $_REQUEST["ville"] . "', ";
			$sql .= "identifiant = '" . $_REQUEST["identifiant"] . "', ";
			$sql .= "taxe = '" . $_REQUEST["taxe"] . "', ";
			$sql .= "modalite_paiement = '" . $_REQUEST["modalite_paiement"] . "', ";
			
			
			$sql .= "numero_rc = '" . $_REQUEST["numero_rc"] . "', ";
			$sql .= "centre_rc = '" . $_REQUEST["centre_rc"] . "', ";
			$sql .= "regime_douanier = '" . $_REQUEST["regime_douanier"] . "', ";
			$sql .= "exp1 = '" . $_REQUEST["exp1"] . "', ";$sql .= "exp2 = '" . $_REQUEST["exp2"] . "', ";
			$sql .= "exp3 = '" . $_REQUEST["exp3"] . "', ";$sql .= "exp4 = '" . $_REQUEST["exp4"] . "', ";
			$sql .= "bureau_douanier = '" . $_REQUEST["bureau_douanier"] . "', ";
			$sql .= "montant = '" . $_REQUEST["montant"] . "', ";
			$sql .= "origine = '" . $_REQUEST["origine"] . "', ";
			$sql .= "provenance = '" . $_REQUEST["provenance"] . "', ";
			$sql .= "condition_livraison = '" . $_REQUEST["condition_livraison"] . "', ";
			$sql .= "nomenclature = '" . $_REQUEST["nomenclature"] . "', ";
			$sql .= "designation1 = '" . $designation1 . "', ";
			$sql .= "designation2 = '" . $designation2 . "', ";
			$sql .= "designation3 = '" . $designation3 . "', ";
			$sql .= "poids = '" . $poids . "', ";
			$sql .= "complementaires = '" . $complementaires . "', ";
			$sql .= "date_imp = '" . $date_imp . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			// delete user's profile
			$sql = "DELETE FROM d_o_a WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch

	} //if
	
	
	// recherche ville
	?>
	
	<?
	$sql  = "SELECT * ";
	$sql .= "FROM d_o_a ORDER BY id;";
	$users = db_query($database_name, $sql);
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Engagements"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "d_o_a_1.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "liste Accreditifs"; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Designation";?></th>
	<th><?php echo "Actions";?></th>
	
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>


			<? $id=$users_["id"];$designation1=$users_["designation1"];$date=dateUsToFr($users_["date_imp"]);?>
		
			
			<? $link="<a href=\"\\mps\\tutorial\\d_o_a_edition.php?id=$id\">imprimer</a>";?>

<td bordercolor="#FFFBF0"><?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"000033\">$date </font>");?></td>
<td bordercolor="#FFFBF0"><?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"000033\">$designation1 </font>");?></td>			
<td align="center" bordercolor="#FFFBF0"><?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"000033\">$link </font>");
 ?>
<a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo " Editer";?></A></td>
			
<?php } ?>

</table>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>
	
<tr>

</tr>

</body>

</html>