<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$user_login = $user_["login"];
	
	$user_id = $_REQUEST["user_id"];$numero = $_REQUEST["numero"];
	
		$client = $_REQUEST["client"];
		$sql  = "SELECT * ";
		$sql .= "FROM rs_data_fournisseurs WHERE last_name = '$client' ;";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$c1 = $user_["c1"];$c2 = $user_["c2"];$c3 = $user_["c3"];$log = $user_["login"];
		$c4 = $user_["c4"];$c5 = $user_["c5"];$c6 = $user_["c6"];
		
		echo $client."--".$c1."-".$c2."-".$c3."-".$c4."-".$c5."-".$c6;
		
		
		

	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "";

		$produit = "";
		$reference = "";
		$quantite = "";
		$prix_unit = "";$prix_ref = "";
		$condit = "";$sans_remise = 0;
		$produit1 = "";
		$quantite1 = "";
		$reference1="";
		$produit2 = "";
		$quantite2 = "";$reference2="";
		$produit3 = "";
		$quantite3 = "";$reference3="";
		$produit4 = "";
		$quantite4 = "";$reference4="";
		$produit5 = "";
		$quantite5 = "";$reference5="";
		$produit6 = "";
		$quantite6 = "";$reference6="";
		$produit7 = "";
		$quantite7 = "";$reference7="";
		$produit8 = "";
		$quantite8 = "";$reference8="";
		$produit9 = "";
		$quantite9 = "";$reference9="";
		$produit10 = "";
		$quantite10 = "";$reference10="";
		$produit11 = "";$quantite11 = "";$reference11="";
		$produit12 = "";$quantite12 = "";$reference12="";
		$produit13 = "";$quantite13 = "";$reference13="";
		$produit14 = "";$quantite14 = "";$reference14="";
		$produit15 = "";$quantite15 = "";$reference15="";
		$produit16 = "";$quantite16 = "";$reference16="";
		$produit17 = "";$quantite17 = "";$reference17="";
		$produit18 = "";$quantite18 = "";$reference18="";
		$produit19 = "";$quantite19 = "";$reference19="";
		$produit20 = "";$quantite20 = "";$reference20="";

		
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM detail_commandes_frs WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";

		$produit = $user_["produit"];$reference = $user_["reference"];$reference_l1 = $user_["reference_l1"];$reference_l2 = $user_["reference_l2"];
		$quantite = $user_["quantite"];
		$prix_unit = $user_["prix_unit"];$prix_ref = $user_["prix_ref"];
		$condit = $user_["condit"];$sans_remise = $user_["sans_remise"];
		$reference_v=$user_["reference_v"];$quantite_r=$user_["quantite_r"];$date_r=dateUsToFr($user_["date_r"]);
		$prix_unit_r=$user_["prix_unit_r"];$obs_r=$user_["obs_r"];
		
		}

	// extracts profile list
	$produit_list = "";$vide="";
	$sql = "SELECT * FROM  articles_commandes  ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list .= $temp_["produit"];
		$produit_list .= "</OPTION>";
	}
	
	if($user_id == "0") {
	$produit_list1 = "";
	$sql = "SELECT * FROM  articles_commandes  ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit1 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list1 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list1 .= $temp_["produit"];
		$produit_list1 .= "</OPTION>";
	}
		$produit_list2 = "";
	$sql = "SELECT * FROM  articles_commandes  ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit2 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list2 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list2 .= $temp_["produit"];
		$produit_list2 .= "</OPTION>";
	}
	$produit_list3 = "";
	$sql = "SELECT * FROM  articles_commandes  ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit3 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list3 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list3 .= $temp_["produit"];
		$produit_list3 .= "</OPTION>";
	}
		$produit_list4 = "";
	$sql = "SELECT * FROM  articles_commandes  ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit4 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list4 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list4 .= $temp_["produit"];
		$produit_list4 .= "</OPTION>";
	}
	$produit_list5 = "";
	$sql = "SELECT * FROM  articles_commandes  ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit5 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list5 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list5 .= $temp_["produit"];
		$produit_list5 .= "</OPTION>";
	}
		$produit_list6 = "";
	$sql = "SELECT * FROM  articles_commandes  ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit6 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list6 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list6 .= $temp_["produit"];
		$produit_list6 .= "</OPTION>";
	}
		$produit_list7 = "";
	$sql = "SELECT * FROM  articles_commandes  ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit7 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list7 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list7 .= $temp_["produit"];
		$produit_list7 .= "</OPTION>";
	}
		$produit_list8 = "";
	$sql = "SELECT * FROM  articles_commandes  ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit8 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list8 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list8 .= $temp_["produit"];
		$produit_list8 .= "</OPTION>";
	}
	$produit_list9 = "";
	$sql = "SELECT * FROM  articles_commandes  ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit9 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list9 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list9 .= $temp_["produit"];
		$produit_list9 .= "</OPTION>";
	}
		$produit_list10 = "";
	$sql = "SELECT * FROM  articles_commandes  ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit10 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list10 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list10 .= $temp_["produit"];
		$produit_list10 .= "</OPTION>";
	}
	

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
		if(document.getElementById("produit").value == "" ) {
			alert("<?php echo Translate("champs indispensables !"); ?>");
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression ?"; ?>")) {
			document.location = "enregistrer_panier_bc_mps.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}
<!--
/*
Script téléchargé du Coin Web de QuentinC
http://www.quentinc.net/

Nom du script : Liste avec recherche clavier

Catégorie : Formulaires
Date de dernière modification : Lundi 23 janvier 2006 15:30
URL exact : /javascript/script39-liste-avec-recherche-clavier/

Vous trouverez d'autres scripts à l'adresse : 
http://www.quentinc.net/javascript/

© 2002-2006, QuentinC
Vous pouvez utiliser, modifier et redistribuer ce script, à condition de laisser les présents commentaires intacts, et de ne pas l'utiliser à des fins commerciales.
*/
var timer = null;
var chaine
= "";
function startsWith (str1, str2) {
var k = str1.substring(0, str2.length);
return (str2.toLowerCase() == k.toLowerCase());
}
function
liDown (list) {

var c = event.keyCode;
if (c < 48 && c!=32) return true;

var s = String.fromCharCode(c);
chaine += s;
var n = list.selectedIndex;
var
ok = false;

if (chaine.length > 1 && startsWith(list.options[n].text, chaine)) ok=true;

for (var i=n+1; i < list.options.length && !ok; i++)
{
if (startsWith(list.options[i].text, chaine)) { n = i; ok = true; }
}
for (var i=0; i < n && !ok; i++) {
if (startsWith(list.options[i].text,
chaine)) { n = i; ok = true; }
}
list.selectedIndex = n;


if (timer!=null) clearTimeout(timer);
timer = setTimeout("clearChaine();",
2000);
return false;
}
function clearChaine () { chaine=""; }

// -->


--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" method="post" action="enregistrer_panier_bc_mps.php">

	<table class="table3">
		<? if($user_id == "0") {?>
		<tr>
		<td><?php echo "Article : "; ?></td>
		<td><?php echo "Autre reference : "; ?></td>
		<td><?php echo "Quantite : "; ?></td>
		</tr>
		<tr>
		<td><select onkeydown="return liDown(this);" id="produit" style="width:250px" name="produit"><?php echo $produit_list; ?></select></td>
		<td align="left"><input type="text" id="reference" name="reference" style="width:300px" value="<?php echo $reference; ?>"></td>
		<td align="center"><input type="text" id="quantite" name="quantite" style="width:50px" value="<?php echo $quantite; ?>"></td>
		
		</tr>
		<tr>
		<td><select onkeydown="return liDown(this);" id="produit1" style="width:250px" name="produit1"><?php echo $produit_list1; ?></select></td>
		<td align="left"><input type="text" id="reference1" name="reference1" style="width:300px" value="<?php echo $reference1; ?>"></td>
		<td align="center"><input type="text" id="quantite1" name="quantite1" style="width:50px" value="<?php echo $quantite1; ?>"></td>
		</tr>
		<tr>
		<td><select onkeydown="return liDown(this);" id="produit2" style="width:250px" name="produit2"><?php echo $produit_list2; ?></select></td>
		<td align="left"><input type="text" id="reference2" name="reference2" style="width:300px" value="<?php echo $reference2; ?>"></td>
		<td align="center"><input type="text" id="quantite2" name="quantite2" style="width:50px" value="<?php echo $quantite2; ?>"></td>
		</tr>
		<tr>
		<td><select onkeydown="return liDown(this);" id="produit3" style="width:250px" name="produit3"><?php echo $produit_list3; ?></select></td>
		<td align="left"><input type="text" id="reference3" name="reference3" style="width:300px" value="<?php echo $reference3; ?>"></td>
		<td align="center"><input type="text" id="quantite3" name="quantite3" style="width:50px" value="<?php echo $quantite3; ?>"></td>
		</tr>
		<tr>
		<td><select onkeydown="return liDown(this);" id="produit4" style="width:250px" name="produit4"><?php echo $produit_list4; ?></select></td>
		<td align="left"><input type="text" id="reference4" name="reference4" style="width:300px" value="<?php echo $reference4; ?>"></td>
		<td align="center"><input type="text" id="quantite4" name="quantite4" style="width:50px" value="<?php echo $quantite4; ?>"></td>
		</tr>
		<tr>
		<td><select onkeydown="return liDown(this);" id="produit5" style="width:250px" name="produit5"><?php echo $produit_list5; ?></select></td>
		<td align="left"><input type="text" id="reference5" name="reference5" style="width:300px" value="<?php echo $reference5; ?>"></td>
		<td align="center"><input type="text" id="quantite5" name="quantite5" style="width:50px" value="<?php echo $quantite5; ?>"></td>
		</tr>
		<tr>
		<td><select onkeydown="return liDown(this);" id="produit6" style="width:250px" name="produit6"><?php echo $produit_list6; ?></select></td>
		<td align="left"><input type="text" id="reference6" name="reference6" style="width:300px" value="<?php echo $reference6; ?>"></td>
		<td align="center"><input type="text" id="quantite6" name="quantite6" style="width:50px" value="<?php echo $quantite6; ?>"></td>
		</tr>
		<tr>
		<td><select onkeydown="return liDown(this);" id="produit7" style="width:250px" name="produit7"><?php echo $produit_list7; ?></select></td>
		<td align="left"><input type="text" id="reference7" name="reference7" style="width:300px" value="<?php echo $reference7; ?>"></td>
		<td align="center"><input type="text" id="quantite7" name="quantite7" style="width:50px" value="<?php echo $quantite7; ?>"></td>
		</tr>
		<tr>
		<td><select onkeydown="return liDown(this);" id="produit8" style="width:250px" name="produit8"><?php echo $produit_list8; ?></select></td>
		<td align="left"><input type="text" id="reference8" name="reference8" style="width:300px" value="<?php echo $reference8; ?>"></td>
		<td align="center"><input type="text" id="quantite8" name="quantite8" style="width:50px" value="<?php echo $quantite8; ?>"></td>
		</tr>
		<tr>
		<td><select onkeydown="return liDown(this);" id="produit9" style="width:250px" name="produit9"><?php echo $produit_list9; ?></select></td>
		<td align="left"><input type="text" id="reference9" name="reference9" style="width:300px" value="<?php echo $reference9; ?>"></td>
		<td align="center"><input type="text" id="quantite9" name="quantite9" style="width:50px" value="<?php echo $quantite9; ?>"></td>
		</tr>
		<tr>
		<td><select onkeydown="return liDown(this);" id="produit10" style="width:250px" name="produit10"><?php echo $produit_list10; ?></select></td>
		<td align="left"><input type="text" id="reference10" name="reference10" style="width:300px" value="<?php echo $reference10; ?>"></td>
		<td align="center"><input type="text" id="quantite10" name="quantite10" style="width:50px" value="<?php echo $quantite10; ?>"></td>
		</tr>
		
	<? }?>	

	<? if($user_id <> "0") {?>
		<tr>
		<td><?php echo "Article : "; ?></td><td><select onkeydown="return liDown(this);" id="produit" style="width:250px" name="produit"><?php echo $produit_list; ?></select></td>
		</tr>
		<tr>
		<td><?php echo "Autre Reference : "; ?></td><td align="center"><input type="textarea" id="reference" name="reference" style="width:400px" value="<?php echo $reference; ?>"></td>
		</tr>	
		<tr>
		<td><?php echo " : "; ?></td><td align="center"><input type="textarea" id="reference_l1" name="reference_l1" style="width:400px" value="<?php echo $reference_l1; ?>"></td>
		</tr>
		<tr>
		<td><?php echo " : "; ?></td><td align="center"><input type="textarea" id="reference_l2" name="reference_l2" style="width:400px" value="<?php echo $reference_l2; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Quantite : "; ?></td><td align="center"><input type="text" id="quantite" name="quantite" style="width:160px" value="<?php echo $quantite; ?>"></td>
		</tr>
		</tr>
		<tr><td><?php echo "Prix Unit : "; ?></td><td align="center"><input type="text" id="prix_unit" name="prix_unit" style="width:160px" value="<?php echo $prix_unit; ?>"></td>
		</tr>
		<tr><td><?php echo "Prix Réf : "; ?></td><td align="center"><input type="text" id="prix_ref" name="prix_ref" style="width:160px" value="<?php echo $prix_ref; ?>"></td>
		</tr>
		<tr><td><input type="checkbox" id="sans_remise" name="sans_remise"<?php if($sans_remise) { echo " checked"; } ?>></td><td>Article sans Prix</td>
		</tr>	
		
		<? if ($user_login=="admin" or $user_login=="rakia" or $user_login=="nabila"){?>
		<tr>
		<td><?php echo "Bon reception : "; ?></td><td align="center"><input type="text" id="reference_v" name="reference_v" style="width:160px" value="<?php echo $reference_v; ?>"></td>
		</tr>	
		<tr>
		<td><?php echo "Date reception : "; ?></td><td align="center"><input type="text" id="date_r" name="date_r" style="width:160px" value="<?php echo $date_r; ?>"></td>
		</tr>	
		
		<tr>
		<td><?php echo "Quantite Livree : "; ?></td><td align="center"><input type="text" id="quantite_r" name="quantite_r" style="width:160px" value="<?php echo $quantite_r; ?>"></td>
		</tr>
		</tr>
		<tr><td><?php echo "Prix Unit : "; ?></td><td align="center"><input type="text" id="prix_unit_r" name="prix_unit_r" style="width:160px" value="<?php echo $prix_unit_r; ?>"></td>
		</tr>
		<tr><td><?php echo "Observations : "; ?></td><td align="center"><input type="text" id="obs_r" name="obs_r" style="width:260px" value="<?php echo $obs_r; ?>"></td>
		</tr>
		<? }?>
		
		<? }?>	

	</table>

<p style="text-align:center">

<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">
<input type="hidden" id="numero" name="numero" value="<?php echo $numero; ?>">
<input type="hidden" id="client" name="client" value="<?php echo $client; ?>">
<input type="hidden" id="montant" name="montant" value="<?php echo $mt; ?>">
<table class="table3"><tr>

<?php if($user_id != "0") { $action_maj="update_user";$action_sup="delete_user";?>

<td><button type="button" onClick="CheckUser()"><?php echo Translate("Update"); ?></button></td>
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