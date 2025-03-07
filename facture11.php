<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];$du = $_REQUEST["du"];$au = $_REQUEST["au"];

	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "Nouvelle Facture";

		$date = date("d/m/y");
		$client = "";
		$vendeur = "";
		$evaluation = "";$sans_remise=0;$editee=0;
		
	} else {

		$action_2 = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM factures2016 WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";

		$date = dateUsToFr($user_["date_f"]);
		$client = $user_["client"];$numero = $user_["numero"];$ht = $user_["ht"];
		$vendeur = $user_["vendeur"];$montant = $user_["montant"];
		$evaluation = $user_["evaluation"];$sans_remise = $user_["sans_remise"];$remise10 = $user_["remise_10"];
		$remise2 = $user_["remise_2"];$remise3 = $user_["remise_3"];$editee = $user_["editee"];$s_controle = $user_["s_controle"];
		}

	// extracts profile list
	$client_list = "";
	$sql = "SELECT * FROM  clients ORDER BY client;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($client == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
		
		$client_list .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";
		$client_list .= $temp_["client"];
		$client_list .= "</OPTION>";
	}
	$vendeur_list = "";
	$sql = "SELECT * FROM  vendeurs ORDER BY ref;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($vendeur == $temp_["vendeur"]) { $selected = " selected"; } else { $selected = ""; }
		
		$vendeur_list .= "<OPTION VALUE=\"" . $temp_["vendeur"] . "\"" . $selected . ">";
		$vendeur_list .= $temp_["ref"]." === ".$temp_["vendeur"];
		$vendeur_list .= "</OPTION>";
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
<? require "head_cal.php";?>
<script type="text/javascript">
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
</script>


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . $title; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function UpdateUser() {
			document.getElementById("form_user").submit();
	}

	function CheckUser() {
		if(document.getElementById("client").value == "" ) {
			alert("<?php echo Translate("The values for the fields [First name] and [Last name] are required !"); ?>");
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression ?"; ?>")) {
			document.location = "edition_factures.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}


--></script>

</head>

<body style="background:#dfe8ff">
<? require "body_cal.php";?>
<span style="font-size:24px"><?php $numero=$user_id+9040;echo "Facture : ".$numero."---".$date."---".$client; ?></span>

<form id="form_user" name="form_user" method="post" action="edition_factures.php">

	<table class="table3">

		<tr>
		<td><?php echo "date"; ?></td><td><input onClick="ds_sh(this);" name="date" value="<?php echo $date; ?>" readonly="readonly" style="cursor: text" /></td>
		</tr>
		<tr>
		<td><?php echo "Client : "; ?></td><td><select onkeydown="return liDown(this);" id="client" name="client"><?php echo $client_list; ?></select></td>
		</tr>
		<tr><td><?php echo "Evaluation"; ?></td><td><input type="text" id="evaluation" name="evaluation" style="width:160px" value="<?php echo $evaluation; ?>"></td>
		</tr>
		<tr><td><input type="checkbox" id="sans_remise" name="sans_remise"<?php if($sans_remise) { echo " checked"; } ?>></td><td>Facture sans Remises</td>
		</tr>
		<tr><td><?php echo "Remise 10%"; ?></td><td><input type="text" id="remise10" name="remise10" style="width:60px" value="<?php echo $remise10; ?>"></td>
		</tr>
		<tr><td><?php echo "Remise 2%"; ?></td><td><input type="text" id="remise2" name="remise2" style="width:60px" value="<?php echo $remise2; ?>"></td>
		</tr>
		<tr><td><?php echo "Remise 3%"; ?></td><td><input type="text" id="remise3" name="remise3" style="width:60px" value="<?php echo $remise3; ?>"></td>
		</tr>
		<tr><td><?php echo "Montant Facture"; ?></td><td><input type="text" id="montant" name="montant" style="width:160px" value="<?php echo $montant; ?>"></td>
		</tr>
		<tr><td><input type="checkbox" id="ht" name="ht"<?php if($ht) { echo " checked"; } ?>></td><td>Facture H.T</td>
		<tr><td><input type="checkbox" id="editee" name="editee"<?php if($editee) { echo " checked"; } ?>></td><td>Facture Editée</td>
		<tr><td><input type="checkbox" id="s_controle" name="s_controle"<?php if($s_controle) { echo " checked"; } ?>></td><td>Facture Contrôlée</td>
		</table>

<p style="text-align:center">

<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="action_2" name="action_2" value="<?php echo $action_2; ?>">
<input type="hidden" id="du" name="du" value="<?php echo $du; ?>">
<input type="hidden" id="au" name="au" value="<?php echo $au; ?>">
<table class="table3"><tr>

<?php if($user_id != "0") { ?>
<td><button type="button" onClick="CheckUser()"><?php echo Translate("Update"); ?></button></td>
<?php } else { ?>
<td><button type="button"  onClick="CheckUser()"><?php echo Translate("OK"); ?></button></td>
<?php 
} ?>
</tr></table>

</center>

</form>

</body>

</html>