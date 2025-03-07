<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_name=GetUserName();
	$user_id = $_REQUEST["user_id"];
	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "";

		$lp = "";
		$date=dateUsToFr($_GET["date"]);
		$type_service = "SEJOURS ET CIRCUITS";
		$service = "";
		$vendeur =$_GET["vendeur"];
		$statut = "";$valider_caisse=0;
		$user_open = $user_name;
		$date_open = "";
		$observation="";
		$motif_cancel="";
		$libelle1="";$montant1=0;$libelle2="";$montant2=0;$libelle3="";$montant3=0;$libelle4="";$montant4=0;$libelle5="";$montant5=0;
		$libelle6="";$montant6=0;$libelle7="";$montant7=0;$libelle8="";$montant8=0;
		$objet1="";$cheque1=0;$objet2="";$cheque2=0;$objet3="";$cheque3=0;$objet4="";$cheque4=0;$objet5="";$cheque5=0;
		$objet6="";$cheque6=0;$objet7="";$cheque7=0;$objet8="";$cheque8=0;$objet9="";$cheque9=0;$objet10="";$cheque10=0;
		$date_cheque1="";$ref1="";$date_cheque2="";$ref2="";$date_cheque3="";$ref3="";$date_cheque4="";$ref4="";$date_cheque5="";$ref5="";
		$date_cheque6="";$ref6="";$date_cheque7="";$ref7="";$date_cheque8="";$ref8="";$date_cheque9="";$ref9="";$date_cheque10="";$ref10="";
	} else {

		$action_ = "update_user";
		$action1_ = "update_detail";
	
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM registre_reglements WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "";

		$date=dateUsToFr($user_["date"]);
		$service = $user_["service"];
		$vendeur = $user_["vendeur"];
		$statut = $user_["statut"];
		$user_open = $user_["user_open"];
		$date_open = $user_["date_open"];
		$observation=$user_["observation"];
		$valider_caisse=$user_["valider_caisse"];

		$type_service="SEJOURS ET CIRCUITS";
		$motif_cancel=$user_["motif_cancel"];$id=$_REQUEST["user_id"];
		$libelle1=$user_["libelle1"];$montant1=$user_["montant1"];
		$libelle2=$user_["libelle2"];$montant2=$user_["montant2"];
		$libelle3=$user_["libelle3"];$montant3=$user_["montant3"];
		$libelle4=$user_["libelle4"];$montant4=$user_["montant4"];
		$libelle5=$user_["libelle5"];$montant5=$user_["montant5"];
		$libelle6=$user_["libelle6"];$montant6=$user_["montant6"];
		$libelle7=$user_["libelle7"];$montant7=$user_["montant7"];
		$libelle8=$user_["libelle8"];$montant8=$user_["montant8"];
		$objet1=$user_["objet1"];$cheque1=$user_["cheque1"];
		$objet2=$user_["objet2"];$cheque2=$user_["cheque2"];
		$objet3=$user_["objet3"];$cheque3=$user_["cheque3"];
		$objet4=$user_["objet4"];$cheque4=$user_["cheque4"];
		$objet5=$user_["objet5"];$cheque5=$user_["cheque5"];
		$objet6=$user_["objet6"];$cheque6=$user_["cheque6"];
		$objet7=$user_["objet7"];$cheque7=$user_["cheque7"];
		$objet8=$user_["objet8"];$cheque8=$user_["cheque8"];
		$objet9=$user_["objet9"];$cheque9=$user_["cheque9"];
		$objet10=$user_["objet10"];$cheque10=$user_["cheque10"];
		$date_cheque1=dateUsToFr($user_["date_cheque1"]);$ref1=$user_["ref1"];
		$date_cheque2=dateUsToFr($user_["date_cheque2"]);$ref2=$user_["ref2"];
		$date_cheque3=dateUsToFr($user_["date_cheque3"]);$ref3=$user_["ref3"];
		$date_cheque4=dateUsToFr($user_["date_cheque4"]);$ref4=$user_["ref4"];
		$date_cheque5=dateUsToFr($user_["date_cheque5"]);$ref5=$user_["ref5"];
		$date_cheque6=dateUsToFr($user_["date_cheque6"]);$ref6=$user_["ref6"];
		$date_cheque7=dateUsToFr($user_["date_cheque7"]);$ref7=$user_["ref7"];
		$date_cheque8=dateUsToFr($user_["date_cheque8"]);$ref8=$user_["ref8"];
		$date_cheque9=dateUsToFr($user_["date_cheque9"]);$ref9=$user_["ref9"];
		$date_cheque10=dateUsToFr($user_["date_cheque10"]);$ref10=$user_["ref10"];
	}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . $title; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function UpdateUser() {
			document.getElementById("form_user").submit();
	}

	function CheckUser() {
			UpdateUser();
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression ?"; ?>")) {
			document.location = "maj_porte_feuilles.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}


--></script>

</head>

<body style="background:#dfe8ff">

<?		
	$vendeur_list = "";
	$sql = "SELECT * FROM  vendeurs ORDER BY vendeur;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($vendeur == $temp_["vendeur"]) { $selected = " selected"; } else { $selected = ""; }
		
		$vendeur_list .= "<OPTION VALUE=\"" . $temp_["vendeur"] . "\"" . $selected . ">";
		$vendeur_list .= $temp_["vendeur"];
		$vendeur_list .= "</OPTION>";
	}
	$profiles_list_p = "Selectionnez Produit";
	$sql_produit = "SELECT * FROM rs_data_villes ORDER BY ville;";
	$temp_produit = db_query($database_name, $sql_produit);
	while($temp_produit_ = fetch_array($temp_produit)) {
		if($service == $temp_produit_["ville"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_p .= "<OPTION VALUE=\"" . $temp_produit_["ville"] . "\"" . $selected . ">";
		$profiles_list_p .= $temp_produit_["ville"];
		$profiles_list_p .= "</OPTION>";
	}
	$profiles_list = "";
	$sql = "SELECT profile_id, profile_name FROM rs_statut_profiles ORDER BY profile_id;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($statut == $temp_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list .= "<OPTION VALUE=\"" . $temp_["profile_name"] . "\"" . $selected . ">";
		$profiles_list .= $temp_["profile_name"];
		$profiles_list .= "</OPTION>";
	}
	
?>

<form id="form_user" name="form_user" method="post" action="maj_porte_feuilles.php">

<table class="table2">

		<tr>
		<td><?php echo "Date	:"; ?></td><td><input type="text" id="date" name="date" value="<?php echo $date; ?>"></td>
		</tr>
		<td>
		<?php echo "Vendeur		:"; ?></td><td>
		<select id="vendeur" name="vendeur"><?php echo $vendeur_list; ?></select></td>
		<tr>
		<td>
		<?php echo "Destination		:"; ?></td><td>
		<select id="service" name="service"><?php echo $profiles_list_p; ?></select></td>
		</tr>
		<? /*<td>
		<?php echo "Bon de Sortie	:"; ?></td><td><input type="text" id="statut" name="statut" value="<?php echo $statut; ?>"></td>
		<td>
		*/ ?>
		<td><?php echo "Bon de Sortie:"; ?></td><td><input type="text" id="observation" name="observation" style="width:250px" value="<?php echo $observation; ?>"></td>
		</tr>
		<tr><td><input type="hidden" id="motif_cancel" name="motif_cancel" style="width:250px" value="<?php echo $motif_cancel; ?>"></td>
		</tr>
		<? if($user_id <> "0") {?>
		<tr>
		<td><input type="checkbox" id="valider_caisse" name="valider_caisse"<?php if($valider_caisse) { echo " checked"; } ?>></td>
		<td><?php echo "Valider sur Caisse"; ?></td></tr>
		<? }?>
	</table>
	<tr>	
<table class="table2">
<tr><td><?php echo "Frais chargement : "; ?></td></tr>
		<tr><td><?php echo "Libelle "; ?></td><td><?php echo "Montant "; ?></td></tr>
		<tr>
		<td><input type="text" id="libelle1" name="libelle1" style="width:400px" value="<?php echo $libelle1; ?>"></td>
		<td align="right"><input type="text" id="montant1" name="montant1" style="width:150px" value="<?php echo $montant1; ?>"></td>

		</tr>
		<tr>
		<td><input type="text" id="libelle2" name="libelle2" style="width:400px" value="<?php echo $libelle2; ?>"></td>
		<td align="right"><input type="text" id="montant2" name="montant2" style="width:150px" value="<?php echo $montant2; ?>"></td>
		</tr>
		<tr>
		<td><input type="text" id="libelle3" name="libelle3" style="width:400px" value="<?php echo $libelle3; ?>"></td>
		<td align="right"><input type="text" id="montant3" name="montant3" style="width:150px" value="<?php echo $montant3; ?>"></td>
		</tr>
		<tr>
		<td><input type="text" id="libelle4" name="libelle4" style="width:400px" value="<?php echo $libelle4; ?>"></td>
		<td align="right"><input type="text" id="montant4" name="montant4" style="width:150px" value="<?php echo $montant4; ?>"></td>
		</tr>
		<tr>
		<td><input type="text" id="libelle5" name="libelle5" style="width:400px" value="<?php echo $libelle5; ?>"></td>
		<td align="right"><input type="text" id="montant5" name="montant5" style="width:150px" value="<?php echo $montant5; ?>"></td>
		</tr>
		
		<tr>
		<td><input type="text" id="libelle6" name="libelle6" style="width:400px" value="<?php echo $libelle6; ?>"></td>
		<td align="right"><input type="text" id="montant6" name="montant6" style="width:150px" value="<?php echo $montant6; ?>"></td>
		</tr>
		<tr>
		<td><input type="text" id="libelle7" name="libelle7" style="width:400px" value="<?php echo $libelle7; ?>"></td>
		<td align="right"><input type="text" id="montant7" name="montant7" style="width:150px" value="<?php echo $montant7; ?>"></td>
		</tr>
		<tr>
		<td><input type="text" id="libelle8" name="libelle8" style="width:400px" value="<?php echo $libelle8; ?>"></td>
		<td align="right"><input type="text" id="montant8" name="montant8" style="width:150px" value="<?php echo $montant8; ?>"></td>
		</tr>
		
		
</td></tr></table>

<table class="table2">
<tr><td><?php echo "Encaissements Divers : "; ?></td></tr>
		<tr><td><?php echo "Libelle "; ?></td><td><?php echo "Montant "; ?></td><td><?php echo "Date Cheque "; ?></td><td><?php echo "Reference "; ?></td>
		</tr>
		<tr>
		<td><input type="text" id="objet1" name="objet1" style="width:400px" value="<?php echo $objet1; ?>"></td>
		<td align="right"><input type="text" id="cheque1" name="cheque1" style="width:150px" value="<?php echo $cheque1; ?>"></td>
		<td align="right"><input type="text" id="date_cheque1" name="date_cheque1" style="width:80px" value="<?php echo $date_cheque1; ?>"></td>
		<td align="right"><input type="text" id="ref1" name="ref1" style="width:80px" value="<?php echo $ref1; ?>"></td>
		</tr>
		<tr>
		<td><input type="text" id="objet2" name="objet2" style="width:400px" value="<?php echo $objet2; ?>"></td>
		<td align="right"><input type="text" id="cheque2" name="cheque2" style="width:150px" value="<?php echo $cheque2; ?>"></td>
		<td align="right"><input type="text" id="date_cheque2" name="date_cheque2" style="width:80px" value="<?php echo $date_cheque2; ?>"></td>
		<td align="right"><input type="text" id="ref2" name="ref2" style="width:80px" value="<?php echo $ref2; ?>"></td>
		</tr>
		<tr>
		<td><input type="text" id="objet3" name="objet3" style="width:400px" value="<?php echo $objet3; ?>"></td>
		<td align="right"><input type="text" id="cheque3" name="cheque3" style="width:150px" value="<?php echo $cheque3; ?>"></td>
		<td align="right"><input type="text" id="date_cheque3" name="date_cheque3" style="width:80px" value="<?php echo $date_cheque3; ?>"></td>
		<td align="right"><input type="text" id="ref3" name="ref3" style="width:80px" value="<?php echo $ref3; ?>"></td>
		</tr>
		<tr>
		<td><input type="text" id="objet4" name="objet4" style="width:400px" value="<?php echo $objet4; ?>"></td>
		<td align="right"><input type="text" id="cheque4" name="cheque4" style="width:150px" value="<?php echo $cheque4; ?>"></td>
		<td align="right"><input type="text" id="date_cheque4" name="date_cheque4" style="width:80px" value="<?php echo $date_cheque4; ?>"></td>
		<td align="right"><input type="text" id="ref4" name="ref4" style="width:80px" value="<?php echo $ref4; ?>"></td>
		</tr>
		<tr>
		<td><input type="text" id="objet5" name="objet5" style="width:400px" value="<?php echo $objet5; ?>"></td>
		<td align="right"><input type="text" id="cheque5" name="cheque5" style="width:150px" value="<?php echo $cheque5; ?>"></td>
		<td align="right"><input type="text" id="date_cheque5" name="date_cheque5" style="width:80px" value="<?php echo $date_cheque5; ?>"></td>
		<td align="right"><input type="text" id="ref5" name="ref5" style="width:80px" value="<?php echo $ref5; ?>"></td>
		</tr>
		
		<tr>
		<td><input type="text" id="objet6" name="objet6" style="width:400px" value="<?php echo $objet6; ?>"></td>
		<td align="right"><input type="text" id="cheque6" name="cheque6" style="width:150px" value="<?php echo $cheque6; ?>"></td>
		<td align="right"><input type="text" id="date_cheque6" name="date_cheque6" style="width:80px" value="<?php echo $date_cheque6; ?>"></td>
		<td align="right"><input type="text" id="ref6" name="ref6" style="width:80px" value="<?php echo $ref6; ?>"></td>
		</tr>
		<tr>
		<td><input type="text" id="objet7" name="objet7" style="width:400px" value="<?php echo $objet7; ?>"></td>
		<td align="right"><input type="text" id="cheque7" name="cheque7" style="width:150px" value="<?php echo $cheque7; ?>"></td>
		<td align="right"><input type="text" id="date_cheque7" name="date_cheque7" style="width:80px" value="<?php echo $date_cheque7; ?>"></td>
		<td align="right"><input type="text" id="ref7" name="ref7" style="width:80px" value="<?php echo $ref7; ?>"></td>
		</tr>
		<tr>
		<td><input type="text" id="objet8" name="objet8" style="width:400px" value="<?php echo $objet8; ?>"></td>
		<td align="right"><input type="text" id="cheque8" name="cheque8" style="width:150px" value="<?php echo $cheque8; ?>"></td>
		<td align="right"><input type="text" id="date_cheque8" name="date_cheque8" style="width:80px" value="<?php echo $date_cheque8; ?>"></td>
		<td align="right"><input type="text" id="ref8" name="ref8" style="width:80px" value="<?php echo $ref8; ?>"></td>
		</tr>
		<tr>
		<td><input type="text" id="objet9" name="objet9" style="width:400px" value="<?php echo $objet9; ?>"></td>
		<td align="right"><input type="text" id="cheque9" name="cheque9" style="width:150px" value="<?php echo $cheque9; ?>"></td>
		<td align="right"><input type="text" id="date_cheque9" name="date_cheque9" style="width:80px" value="<?php echo $date_cheque9; ?>"></td>
		<td align="right"><input type="text" id="ref9" name="ref9" style="width:80px" value="<?php echo $ref9; ?>"></td>
		</tr>
		<tr>
		<td><input type="text" id="objet10" name="objet10" style="width:400px" value="<?php echo $objet10; ?>"></td>
		<td align="right"><input type="text" id="cheque10" name="cheque10" style="width:150px" value="<?php echo $cheque10; ?>"></td>
		<td align="right"><input type="text" id="date_cheque10" name="date_cheque10" style="width:80px" value="<?php echo $date_cheque10; ?>"></td>
		<td align="right"><input type="text" id="ref10" name="ref10" style="width:80px" value="<?php echo $ref10; ?>"></td>
		</tr>
		
</td></tr></table>



<center>
<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="user_open" name="user_open" value="<?php echo $user_open; ?>">
<input type="hidden" id="date_open" name="date_open" value="<?php echo $date_open; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">

  <table class="table3"><tr>

<?php if($user_id != "0") { ?>
<td><button type="button" onClick="CheckUser()"><?php echo Translate("Update"); ?></button></td>
<td style="width:20px"></td>
<td><button type="button" onClick="DeleteUser()"><?php echo Translate("Delete"); ?></button></td>
<?php } else { ?>
<td><button type="button"  onClick="CheckUser()"><?php echo Translate("OK"); ?></button></td>
<?php 
} ?>
</tr></table>
</center>

</form>

</body>

</html>