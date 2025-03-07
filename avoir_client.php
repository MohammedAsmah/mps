<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];		
	$date=dateUsToFr($_REQUEST['date']);


	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "Evaluation";

		$client = "";$client2 = "";$client3 = "";$client4 = "";$client5 = "";$client6 = "";
		$evaluation = "En Cours";$sans_remise=0;$sans_remise1=0;$sans_remise2=0;$sans_remise3=0;$sans_remise4=0;$sans_remise5=0;
		$date=dateUsToFr($_REQUEST['date']);$date1=dateUsToFr($_REQUEST['date']);$date2=dateUsToFr($_REQUEST['date']);
		$date3=dateUsToFr($_REQUEST['date']);$date4=dateUsToFr($_REQUEST['date']);$date5=dateUsToFr($_REQUEST['date']);
		$client=$_REQUEST['client'];$be=$_REQUEST['be'];$matricule=$_REQUEST['matricule'];
		
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM avoirs WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $users_ = fetch_array($user);

		$title = "details";$vendeur=$users_["vendeur"];$id_registre=$users_["id_registre"];$net=$users_["net"];$active=$users_["active"];
		$ev_pre=$users_["ev_pre"];$be=$users_["be"];$matricule=$users_["matricule"];
		$commande=$users_["commande"];$evaluation=$users_["evaluation"];$client=$users_["client"];	$valider_f=$users_["valider_f"];	
		$remise10=$users_["remise_10"];$remise2=$users_["remise_2"];$remise3=$users_["remise_3"];$remise_4=$users_["remise_4"];
		$sans_remise=$users_["sans_remise"];$date=dateUsToFr($users_["date_e"]);$date=dateUsToFr($users_["date_e"]);$mode=$users_["mode"];
		}

	// extracts profile list
	$client_list = "";$v="1";
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
			document.location = "avoirs_client.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
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

<span style="font-size:16px"><?php echo "Avoir : $client pour $date Bon d'entree numero : $be "; ?></span>

<form id="form_user" name="form_user" method="post" action="avoirs_client.php">

	<table class="table3">
	<? if($user_id == "0") {?>
		<tr><td><?php echo "Date : "; ?></td><td><input type="text" id="date" name="date" style="width:160px" value="<?php echo $date; ?>"></td>
		<tr><td><?php echo "N° B.E : "; ?></td><td><input type="text" id="be" name="be" style="width:160px" value="<?php echo $be; ?>"></td></tr>
		<tr><td><?php echo "Matricule : "; ?></td><td><input type="text" id="matricule" name="matricule" style="width:160px" value="<?php echo $matricule; ?>"></td></tr>
		<tr><td><?php echo "Net : "; ?></td><td><input type="text" id="net" name="net" style="width:160px" value="<?php echo $net; ?>"></td></tr>
		<tr><td><?php echo "Sans Remise : "; ?></td>		
		<td><input type="checkbox" id="sans_remise" name="sans_remise"<?php if($sans_remise) { echo " checked"; } ?>></td></tr>
		<tr><td><?php echo "Client : "; ?></td><td><select onkeydown="return liDown(this);" id="client" name="client"><?php echo $client_list; ?></select></td></tr>
	<? }?>
	<? if($user_id <> "0") {?>
		
		<tr><td><?php echo "Date : "; ?></td><td><input type="text" id="date" name="date" style="width:160px" value="<?php echo $date; ?>"></td></tr>
		<tr><td><?php echo "Client : "; ?></td><td><select onkeydown="return liDown(this);" id="client" name="client"><?php echo $client_list; ?></select></td></tr>
		<tr><td><?php echo "N° B.E : "; ?></td><td><input type="text" id="be" name="be" style="width:160px" value="<?php echo $be; ?>"></td></tr>
		<tr><td><?php echo "Matricule : "; ?></td><td><input type="text" id="matricule" name="matricule" style="width:160px" value="<?php echo $matricule; ?>"></td></tr>
		<tr><td><?php echo "Autre remise : "; ?></td><td><input type="text" id="mode" name="mode" style="width:160px" value="<?php echo $mode; ?>"></td>
		<td><?php echo "Montant : "; ?></td><td><input type="text" id="remise_4" name="remise_4" style="width:60px" value="<?php echo $remise_4; ?>"></td></tr>
		<tr><td><?php echo "net"; ?></td><td><input type="text" id="net" name="net" style="width:160px" value="<?php echo $net; ?>"></td>
	
	<? }?>
	</table>

<p style="text-align:center">

<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">
<input type="hidden" id="vendeur" name="vendeur" value="<?php echo $vendeur; ?>">
<? if ($user_id==0){?><input type="client" id="client" name="client" value="<?php echo $client; ?>"><? }?>

<input type="hidden" id="evaluation" name="evaluation" value="<?php echo $evaluation; ?>">

<table class="table3"><tr>

<?php if($user_id != "0") { ?>

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