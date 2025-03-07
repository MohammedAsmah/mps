<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];$numero = $_REQUEST["numero"];$client = $_REQUEST["client"];

	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "";

		$produit = "";
		$quantite = "";
		$prix_unit = "";
		$condit = "";$sans_remise = 0;
		$produit1 = "";
		$quantite1 = "";
		$produit2 = "";
		$quantite2 = "";
		$produit3 = "";
		$quantite3 = "";
		$produit4 = "";
		$quantite4 = "";
		$produit5 = "";
		$quantite5 = "";
		$produit6 = "";
		$quantite6 = "";
		$produit7 = "";
		$quantite7 = "";
		$produit8 = "";
		$quantite8 = "";
		$produit9 = "";
		$quantite9 = "";
		$produit10 = "";
		$quantite10 = "";
		$produit11 = "";$quantite11 = "";
		$produit12 = "";$quantite12 = "";
		$produit13 = "";$quantite13 = "";$produit14 = "";$quantite14 = "";$produit15 = "";$quantite15 = "";
		$produit16 = "";$quantite16 = "";$produit17 = "";$quantite17 = "";$produit18 = "";$quantite18 = "";
		$produit19 = "";$quantite19 = "";$produit20 = "";$quantite20 = "";

		
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM detail_commandes WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";

		$produit = $user_["produit"];
		$quantite = $user_["quantite"];
		$prix_unit = $user_["prix_unit"];
		$condit = $user_["condit"];$sans_remise = $user_["sans_remise"];
		
		}

	// extracts profile list
	$produit_list = "";
	$sql = "SELECT * FROM  produits where dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list .= $temp_["produit"]."-->".$temp_["prix"];
		$produit_list .= "</OPTION>";
	}
	
	if($user_id == "0") {
	$produit_list1 = "";
	$sql = "SELECT * FROM  produits where dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit1 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list1 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list1 .= $temp_["produit"]."-->".$temp_["prix"];
		$produit_list1 .= "</OPTION>";
	}
		$produit_list2 = "";
	$sql = "SELECT * FROM  produits where dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit2 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list2 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list2 .= $temp_["produit"]."-->".$temp_["prix"];
		$produit_list2 .= "</OPTION>";
	}
	$produit_list3 = "";
	$sql = "SELECT * FROM  produits where dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit3 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list3 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list3 .= $temp_["produit"]."-->".$temp_["prix"];
		$produit_list3 .= "</OPTION>";
	}
		$produit_list4 = "";
	$sql = "SELECT * FROM  produits where dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit4 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list4 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list4 .= $temp_["produit"]."-->".$temp_["prix"];
		$produit_list4 .= "</OPTION>";
	}
	$produit_list5 = "";
	$sql = "SELECT * FROM  produits where dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit5 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list5 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list5 .= $temp_["produit"]."-->".$temp_["prix"];
		$produit_list5 .= "</OPTION>";
	}
		$produit_list6 = "";
	$sql = "SELECT * FROM  produits where dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit6 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list6 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list6 .= $temp_["produit"]."-->".$temp_["prix"];
		$produit_list6 .= "</OPTION>";
	}
		$produit_list7 = "";
	$sql = "SELECT * FROM  produits where dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit7 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list7 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list7 .= $temp_["produit"]."-->".$temp_["prix"];
		$produit_list7 .= "</OPTION>";
	}
		$produit_list8 = "";
	$sql = "SELECT * FROM  produits where dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit8 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list8 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list8 .= $temp_["produit"]."-->".$temp_["prix"];
		$produit_list8 .= "</OPTION>";
	}
	$produit_list9 = "";
	$sql = "SELECT * FROM  produits where dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit9 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list9 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list9 .= $temp_["produit"]."-->".$temp_["prix"];
		$produit_list9 .= "</OPTION>";
	}
		$produit_list10 = "";
	$sql = "SELECT * FROM  produits where dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit10 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list10 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list10 .= $temp_["produit"]."-->".$temp_["prix"];
		$produit_list10 .= "</OPTION>";
	}
	
			$produit_list11 = "";
	$sql = "SELECT * FROM  produits where dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit11 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list11 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list11 .= $temp_["produit"]."-->".$temp_["prix"];
		$produit_list11 .= "</OPTION>";
	}
		$produit_list12 = "";
	$sql = "SELECT * FROM  produits where dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit12 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list12 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list12 .= $temp_["produit"]."-->".$temp_["prix"];
		$produit_list12 .= "</OPTION>";
	}
		$produit_list13 = "";
	$sql = "SELECT * FROM  produits where dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit13 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list13 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list13 .= $temp_["produit"]."-->".$temp_["prix"];
		$produit_list13 .= "</OPTION>";
	}
		$produit_list14 = "";
	$sql = "SELECT * FROM  produits where dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit14 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list14 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list14 .= $temp_["produit"]."-->".$temp_["prix"];
		$produit_list14 .= "</OPTION>";
	}
		$produit_list15 = "";
	$sql = "SELECT * FROM  produits where dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit15 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list15 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list15 .= $temp_["produit"]."-->".$temp_["prix"];
		$produit_list15 .= "</OPTION>";
	}
		$produit_list16 = "";
	$sql = "SELECT * FROM  produits where dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit16 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list16 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list16 .= $temp_["produit"]."-->".$temp_["prix"];
		$produit_list16 .= "</OPTION>";
	}
		$produit_list17 = "";
	$sql = "SELECT * FROM  produits where dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit17 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list17 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list17 .= $temp_["produit"]."-->".$temp_["prix"];
		$produit_list17 .= "</OPTION>";
	}
		$produit_list18 = "";
	$sql = "SELECT * FROM  produits where dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit18 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list18 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list18 .= $temp_["produit"]."-->".$temp_["prix"];
		$produit_list18 .= "</OPTION>";
	}
		$produit_list19 = "";
	$sql = "SELECT * FROM  produits where dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit19 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list19 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list19 .= $temp_["produit"]."-->".$temp_["prix"];
		$produit_list19 .= "</OPTION>";
	}

			$produit_list20 = "";
	$sql = "SELECT * FROM  produits where dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit20 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list20 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list20 .= $temp_["produit"]."-->".$temp_["prix"];
		$produit_list20 .= "</OPTION>";
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
			document.location = "enregistrer_panier.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
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

<form id="form_user" name="form_user" method="post" action="enregistrer_panier.php">

	<table class="table3">
		<? if($user_id == "0") {?>
		<tr>
		<td><?php echo "produit : "; ?></td>
		<td><?php echo "Quantite : "; ?></td>
		</tr>
		<tr>
		<td><select onkeydown="return liDown(this);" id="produit" name="produit"><?php echo $produit_list; ?></select></td>
		<td align="center"><input type="text" id="quantite" name="quantite" style="width:160px" value="<?php echo $quantite; ?>"></td>
		</tr>
		<tr>
		<td><select onkeydown="return liDown(this);" id="produit1" name="produit1"><?php echo $produit_list1; ?></select></td>
		<td align="center"><input type="text" id="quantite1" name="quantite1" style="width:160px" value="<?php echo $quantite1; ?>"></td>
		</tr>
		<tr>
		<td><select onkeydown="return liDown(this);" id="produit2" name="produit2"><?php echo $produit_list2; ?></select></td>
		<td align="center"><input type="text" id="quantite2" name="quantite2" style="width:160px" value="<?php echo $quantite2; ?>"></td>
		</tr>
		<tr>
		<td><select onkeydown="return liDown(this);" id="produit3" name="produit3"><?php echo $produit_list3; ?></select></td>
		<td align="center"><input type="text" id="quantite3" name="quantite3" style="width:160px" value="<?php echo $quantite3; ?>"></td>
		</tr>
		<tr>
		<td><select onkeydown="return liDown(this);" id="produit4" name="produit4"><?php echo $produit_list4; ?></select></td>
		<td align="center"><input type="text" id="quantite4" name="quantite4" style="width:160px" value="<?php echo $quantite4; ?>"></td>
		</tr>
		<tr>
		<td><select onkeydown="return liDown(this);" id="produit5" name="produit5"><?php echo $produit_list5; ?></select></td>
		<td align="center"><input type="text" id="quantite5" name="quantite5" style="width:160px" value="<?php echo $quantite5; ?>"></td>
		</tr>
		<tr>
		<td><select onkeydown="return liDown(this);" id="produit6" name="produit6"><?php echo $produit_list6; ?></select></td>
		<td align="center"><input type="text" id="quantite6" name="quantite6" style="width:160px" value="<?php echo $quantite6; ?>"></td>
		</tr>
		<tr>
		<td><select onkeydown="return liDown(this);" id="produit7" name="produit7"><?php echo $produit_list7; ?></select></td>
		<td align="center"><input type="text" id="quantite7" name="quantite7" style="width:160px" value="<?php echo $quantite7; ?>"></td>
		</tr>
		<tr>
		<td><select onkeydown="return liDown(this);" id="produit8" name="produit8"><?php echo $produit_list8; ?></select></td>
		<td align="center"><input type="text" id="quantite8" name="quantite8" style="width:160px" value="<?php echo $quantite8; ?>"></td>
		</tr>
		<tr>
		<td><select onkeydown="return liDown(this);" id="produit9" name="produit9"><?php echo $produit_list9; ?></select></td>
		<td align="center"><input type="text" id="quantite9" name="quantite9" style="width:160px" value="<?php echo $quantite9; ?>"></td>
		</tr>
		<tr>
		<td><select onkeydown="return liDown(this);" id="produit10" name="produit10"><?php echo $produit_list10; ?></select></td>
		<td align="center"><input type="text" id="quantite10" name="quantite10" style="width:160px" value="<?php echo $quantite10; ?>"></td>
		</tr>
		
		<tr>
		<td><select onkeydown="return liDown(this);" id="produit11" name="produit11"><?php echo $produit_list11; ?></select></td>
		<td align="center"><input type="text" id="quantite11" name="quantite11" style="width:160px" value="<?php echo $quantite11; ?>"></td>
		</tr>
		<tr>
		<td><select onkeydown="return liDown(this);" id="produit12" name="produit12"><?php echo $produit_list12; ?></select></td>
		<td align="center"><input type="text" id="quantite12" name="quantite12" style="width:160px" value="<?php echo $quantite12; ?>"></td>
		</tr>
		<tr>
		<td><select onkeydown="return liDown(this);" id="produit13" name="produit13"><?php echo $produit_list13; ?></select></td>
		<td align="center"><input type="text" id="quantite13" name="quantite13" style="width:160px" value="<?php echo $quantite13; ?>"></td>
		</tr>
		<tr>
		<td><select onkeydown="return liDown(this);" id="produit14" name="produit14"><?php echo $produit_list14; ?></select></td>
		<td align="center"><input type="text" id="quantite14" name="quantite14" style="width:160px" value="<?php echo $quantite14; ?>"></td>
		</tr>
		<tr>
		<td><select onkeydown="return liDown(this);" id="produit15" name="produit15"><?php echo $produit_list15; ?></select></td>
		<td align="center"><input type="text" id="quantite15" name="quantite15" style="width:160px" value="<?php echo $quantite15; ?>"></td>
		</tr>
		<tr>
		<td><select onkeydown="return liDown(this);" id="produit16" name="produit16"><?php echo $produit_list16; ?></select></td>
		<td align="center"><input type="text" id="quantite16" name="quantite16" style="width:160px" value="<?php echo $quantite16; ?>"></td>
		</tr>
		<tr>
		<td><select onkeydown="return liDown(this);" id="produit17" name="produit17"><?php echo $produit_list17; ?></select></td>
		<td align="center"><input type="text" id="quantite17" name="quantite17" style="width:160px" value="<?php echo $quantite17; ?>"></td>
		</tr>
		<tr>
		<td><select onkeydown="return liDown(this);" id="produit18" name="produit18"><?php echo $produit_list18; ?></select></td>
		<td align="center"><input type="text" id="quantite18" name="quantite18" style="width:160px" value="<?php echo $quantite18; ?>"></td>
		</tr>
		<tr>
		<td><select onkeydown="return liDown(this);" id="produit19" name="produit19"><?php echo $produit_list19; ?></select></td>
		<td align="center"><input type="text" id="quantite19" name="quantite19" style="width:160px" value="<?php echo $quantite19; ?>"></td>
		</tr>
		<tr>
		<td><select onkeydown="return liDown(this);" id="produit20" name="produit20"><?php echo $produit_list20; ?></select></td>
		<td align="center"><input type="text" id="quantite20" name="quantite20" style="width:160px" value="<?php echo $quantite20; ?>"></td>
		</tr>
		
		
		
		
		
		
	<? }?>	

	<? if($user_id <> "0") {?>
		<tr>
		<td><?php echo "produit : "; ?></td><td><select onkeydown="return liDown(this);" id="produit" name="produit"><?php echo $produit_list; ?></select></td>
		</tr>
		<tr>
		<td><?php echo "Quantite"; ?></td><td align="center"><input type="text" id="quantite" name="quantite" style="width:160px" value="<?php echo $quantite; ?>"></td>
		</tr>
		<tr><td><?php echo "Paquet"; ?></td><td align="center"><input type="text" id="condit" name="condit" style="width:160px" value="<?php echo $condit; ?>"></td>
		</tr>
		<tr><td><?php echo "Prix Unit"; ?></td><td align="center"><input type="text" id="prix_unit" name="prix_unit" style="width:160px" value="<?php echo $prix_unit; ?>"></td>
		</tr>
		<tr><td><input type="checkbox" id="sans_remise" name="sans_remise"<?php if($sans_remise) { echo " checked"; } ?>></td><td>Article sans Remises</td>
		</tr>	
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