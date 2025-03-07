<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$login = $user_["login"];
	$user_id = $_REQUEST["user_id"];$qte_tige1=0;
				


	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "Nouveau Produit";

			$choix1 = "";
			$choix2 = "XXXXXXXXXXXXXXXXXXXX";
			$choix3 = "XXXXXXXXXXXXXXXXXXXX" ;
			$importateur1 = "STE MOULAGE PLASTIQUE DU SUD" ;
			$importateur2 = "62, NLLE ZONE INDUSTRIELLE SIDI GHANEM" ;
			$importateur3 = "MARRAKECH MAROC";
			$siege_social = "STE MOULAGE PLASTIQUE DU SUD" ;
			$adresse = "62, NLLE ZONE INDUSTRIELLE SIDI GHANEM" ;
			$ville = "MARRAKECH MAROC";
			$identifiant="06580058";
			$taxe="46235622";
			$modalite_paiement="";
			$numero_rc = "10499" ;
			$centre_rc = "MARRAKECH" ;
			$regime_douanier = "" ;
			$exp1 ="" ;$exp2 =  "";
			$exp3 ="";$exp4 = "";
			$bureau_douanier = "" ;
			$montant =  "";
			$origine =  "" ;
			$provenance =  "";
			$condition_livraison = "";
			$nomenclature ="";
			$designation1 =  "";$designation2 =  "";$designation3 =  "";
			$poids =  "";
			$complementaires = "";
			$date = "";
			
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM d_o_a WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$choix1 = $user_["choix1"] ;
			$choix2 = $user_["choix2"] ;
			$choix3 = $user_["choix3"] ;
			$importateur1 = $user_["importateur1"] ;
			$importateur2 = $user_["importateur2"] ;
			$importateur3 = $user_["importateur3"];
			$siege_social = $user_["siege_social"] ;
			$adresse = $user_["adresse"] ;
			$ville = $user_["ville"];
			$identifiant = $user_["identifiant"] ;
			$taxe = $user_["taxe"] ;
			$modalite_paiement = $user_["modalite_paiement"];
			
			$numero_rc = $user_["numero_rc"] ;
			$centre_rc = $user_["centre_rc"] ;
			$regime_douanier = $user_["regime_douanier"] ;
			$exp1 =$user_["exp1"] ;$exp2 =  $user_["exp2"];
			$exp3 =$user_["exp3"];$exp4 = $user_["exp4"];
			$bureau_douanier = $user_["bureau_douanier"] ;
			$montant =  $user_["montant"];
			$origine =  $user_["origine"] ;
			$provenance =  $user_["provenance"];
			$condition_livraison =  $user_["condition_livraison"];
			$nomenclature =$user_["nomenclature"];
			$designation =  $user_["designation"];
			$poids =  $user_["poids"];
			$complementaires = $user_["complementaires"];
			$date = dateUsToFr($user_["date_imp"]);
			
			
			
	}
	
	

	
	// extracts profile list

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . $title; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">
<link href="Templates/css.css" rel="stylesheet" type="text/css">
<script type="text/javascript"><!--
	function UpdateUser() {
			document.getElementById("form_user").submit();
	}

	function CheckUser() {
		if(document.getElementById("nomenclature").value == "" ) {
			alert("<?php echo "nomenclature !"; ?>");
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression ?"; ?>")) {
			document.location = "d_o_a.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}

//--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php  ?></span>

<form id="form_user" name="form_user" method="post" action="d_o_a.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table width="671" class="table3">
	
		<tr><td></td><td>
			<table>
		<td></td><td><input type="text" id="choix1" name="choix1" style="width:260px" value="<?php echo $choix1; ?>"></td>
		</tr>
		<tr>
		<td></td><td><input type="text" id="choix2" name="choix2" style="width:260px" value="<?php echo $choix2; ?>"></td>
		</tr>
		<tr>
		<td></td><td><input type="text" id="choix3" name="choix3" style="width:260px" value="<?php echo $choix3; ?>"></td>
		</tr>
		</table></td>
		</tr>
       
		<tr>
		<td><table>
		<tr><td><?php echo "IMPORTATEUR "; ?></td></tr>
        <TR><td><input type="text" id="importateur1" name="importateur1" style="width:280px" value="<?php echo $importateur1; ?>"></td>
		<TR><td><input type="text" id="importateur2" name="importateur2" style="width:280px" value="<?php echo $importateur2; ?>"></td>
		<TR><td><input type="text" id="importateur3" name="importateur3" style="width:280px" value="<?php echo $importateur3; ?>"></td>
		<tr><td><?php echo "Registre de Commerce "; ?></td></tr>
		<tr><td><? echo "N°RC : ";?><input type="text" id="numero_rc" name="numero_rc" style="width:100px" value="<?php echo $numero_rc; ?>"></td></TR>
		<tr><td><? echo "Centre RC : ";?><input type="text" id="centre_rc" name="centre_rc" style="width:100px" value="<?php echo $centre_rc; ?>"></td></TR>
		
		<tr><td><?php echo "EXPEDITEUR "; ?></td></tr>
		<TR><td><input type="text" id="exp1" name="exp1" style="width:280px" value="<?php echo $exp1; ?>"></td>
		<TR><td><input type="text" id="exp2" name="exp2" style="width:280px" value="<?php echo $exp2; ?>"></td>
		<TR><td><input type="text" id="exp3" name="exp3" style="width:280px" value="<?php echo $exp3; ?>"></td>
		<TR><td><input type="text" id="exp4" name="exp4" style="width:280px" value="<?php echo $exp4; ?>"></td>
		
		<tr><td><?php echo "MONTANT TOTAL EN DEVISE "; ?></td></tr>
		<TR><td><input type="text" id="montant" name="montant" style="width:280px" value="<?php echo $montant; ?>"></td>
		
		<tr><td><?php echo "MODALITES DE PAIEMENTS "; ?></td></tr>
		<TR><td><input type="text" id="modalite_paiement" name="modalite_paiement" style="width:280px" value="<?php echo $modalite_paiement; ?>"></td>
		
		
		<tr><td><?php echo "CONDITIONS DE LIVRAISON "; ?></td></tr>
		<TR><td><input type="text" id="condition_livraison" name="condition_livraison" style="width:280px" value="<?php echo $condition_livraison; ?>"></td>
		
		<tr><td><?php echo "DESIGNATION MARCHANDISES "; ?></td></tr>
		<TR><td><input type="text" id="designation1" name="designation1" style="width:280px" value="<?php echo $designation1; ?>"></td>
		<TR><td><input type="text" id="designation2" name="designation2" style="width:280px" value="<?php echo $designation2; ?>"></td>
		<TR><td><input type="text" id="designation3" name="designation3" style="width:280px" value="<?php echo $designation3; ?>"></td>

		<tr><td><?php echo "DATE  "; ?></td></tr>
		<TR><td><input type="text" id="date" name="date" style="width:180px" value="<?php echo $date; ?>"></td>
			
		
		</table>
		</TD>
		<td><table>
		<tr><td><?php echo "SIEGE SOCIAL "; ?></TD></tr>
		<td><input type="text" id="siege_social" name="siege_social" style="width:280px" value="<?php echo $siege_social; ?>"></td>
		<tr><td><?php echo "ADRESSE "; ?></TD></tr>
		<td><input type="text" id="adresse" name="adresse" style="width:280px" value="<?php echo $adresse; ?>"></td>
		<tr><td><?php echo "VILLE "; ?></TD></tr>
		<td><input type="text" id="ville" name="ville" style="width:200px" value="<?php echo $ville; ?>"></td>
		<tr><td><?php echo "IDENTIFIANT "; ?></TD></tr>
		<td><input type="text" id="identifiant" name="identifiant" style="width:200px" value="<?php echo $identifiant; ?>"></td>
		<tr><td><?php echo "TAXE PROFESSIONNELLE "; ?></TD></tr>
		<td><input type="text" id="taxe" name="taxe" style="width:200px" value="<?php echo $taxe; ?>"></td>
		
		<tr><td><?php echo "BUREAU DOUANIER "; ?></TD></tr>
		<td><input type="text" id="bureau_douanier" name="bureau_douanier" style="width:280px" value="<?php echo $bureau_douanier; ?>"></td>
		
		<tr><td><?php echo "PAYS D'ORIGINE "; ?></TD></tr>
		<td><input type="text" id="origine" name="origine" style="width:280px" value="<?php echo $origine; ?>"></td>
		
		<tr><td><?php echo "PAYS PROVENANCE "; ?></TD></tr>
		<td><input type="text" id="provenance" name="provenance" style="width:280px" value="<?php echo $provenance; ?>"></td>
		
		<tr><td><?php echo "NOMENCLATURE "; ?></TD></tr>
		<td><input type="text" id="nomenclature" name="nomenclature" style="width:280px" value="<?php echo $nomenclature; ?>"></td>
		
		<tr><td><?php echo "REGIME DOUANIER "; ?></TD></tr>
		<td><input type="text" id="regime_douanier" name="regime_douanier" style="width:280px" value="<?php echo $regime_douanier; ?>"></td>
		
		<tr><td><?php echo "POIDS NET "; ?></TD></tr>
		<td><input type="text" id="poids" name="poids" style="width:200px" value="<?php echo $poids; ?>"></td>
		
		<tr><td><?php echo "UNITES COMPLEMENTAIRES "; ?></TD></tr>
		<td><input type="text" id="complementaires" name="complementaires" style="width:200px" value="<?php echo $complementaires; ?>"></td>
		
		</table>
		</td>
		
		
	</table>

	</center>

</td></tr></table>


<p style="text-align:center">

<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">

<table class="table3"><tr>

<?php if($user_id != "0") { 
?>
<td><button type="button" onClick="CheckUser()"><?php echo Translate("Update"); ?></button></td>
<td style="width:20px"></td>
<td><button type="button" onClick="DeleteUser()"><?php echo Translate("Delete"); ?></button></td>
<?php } else { ?>
<td><button type="button"  onClick="CheckUser()"><?php echo Translate("OK"); ?></button></td>
<?php } ?>
</tr></table>

</center>

</form>


</body>

</html>