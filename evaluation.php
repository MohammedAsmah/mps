<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];$du = $_REQUEST["du"];$au = $_REQUEST["au"];$vendeur = $_REQUEST["vendeur"];

	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "Evaluation";

		$client = "";
		$evaluation = "En Cours";$sans_remise=0;
		$id_registre=$_GET['id_registre'];
		$date=dateUsToFr($_GET['du']);
		$vendeur=$_GET['vendeur'];
		
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM commandes WHERE commande = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $users_ = fetch_array($user);

		$title = "details";$vendeur=$users_["vendeur"];$id_registre=$users_["id_registre"];

		$commande=$users_["commande"];$evaluation=$users_["evaluation"];$client=$users_["client"];	$valider_f=$users_["valider_f"];	
		$remise10=$users_["remise_10"];$remise2=$users_["remise_2"];$remise3=$users_["remise_3"];$remise4=$users_["remise_4"];
		$sans_remise=$users_["sans_remise"];$date=dateUsToFr($users_["date_e"]);
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
			document.location = "factures.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
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

<span style="font-size:24px"><?php echo "Evaluation Vendeur : $id_registre --> $vendeur"; ?></span>

<form id="form_user" name="form_user" method="post" action="evaluations.php">

	<table class="table3">

		<tr><td><?php echo "Date"; ?></td><td><input type="text" id="date" name="date" style="width:160px" value="<?php echo $date; ?>"></td>
		<tr>
		<td><?php echo "Client : "; ?></td><td><select onkeydown="return liDown(this);" id="client" name="client"><?php echo $client_list; ?></select></td>
		</tr>
		<tr><td><input type="checkbox" id="sans_remise" name="sans_remise"<?php if($sans_remise) { echo " checked"; } ?>></td><td>Evaluation sans Remises</td>
		<tr><td><?php echo "Evaluation"; ?></td><td><input type="text" id="evaluation" name="evaluation" style="width:160px" value="<?php echo $evaluation; ?>"></td>
	<? if($user_id <> "0") {?>
		<tr>
		<td><?php echo "Validation : "; ?></td><td><input type="text" id="valider_f" name="valider_f" value="<?php echo $valider_f; ?>"></td>
		</tr>
		</tr>
		<tr><td><?php echo "Remise 10%"; ?></td><td><input type="text" id="remise10" name="remise10" style="width:60px" value="<?php echo $remise10; ?>"></td>
		</tr>
		<tr><td><?php echo "Remise 2%"; ?></td><td><input type="text" id="remise2" name="remise2" style="width:60px" value="<?php echo $remise2; ?>"></td>
		</tr>
		<tr><td><?php echo "Remise 3%"; ?></td><td><input type="text" id="remise3" name="remise3" style="width:60px" value="<?php echo $remise3; ?>"></td>
		</tr>
		<tr><td><?php echo "Evalution Vendeur"; ?></td><td><input type="text" id="id_registre" name="id_registre" style="width:60px" value="<?php echo $id_registre; ?>"></td>
		</tr>
	<? }?>
	</table>

<p style="text-align:center">

<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">
<input type="hidden" id="du" name="du" value="<?php echo $du; ?>">
<input type="hidden" id="au" name="au" value="<?php echo $au; ?>">
<?php if($user_id == "0") { ?>
<input type="hidden" id="id_registre" name="id_registre" value="<?php echo $id_registre; ?>">
	<? }?>
<input type="hidden" id="vendeur" name="vendeur" value="<?php echo $vendeur; ?>">
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