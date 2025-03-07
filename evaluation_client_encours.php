<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];		$date=dateUsToFr($_REQUEST['date']);
	
	//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$login = $user_["login"];

	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "Evaluation";

		$client = "";$client1 = "";$client2 = "";$client3 = "";$client4 = "";$client5 = "";$client6 = "";$client7 = "";
		$client8 = "";
		$client9 = "";
		$client10 = "";$sans_remise6=0;$sans_remise7=0;$sans_remise8=0;$sans_remise9=0;$sans_remise10=0;
		$evaluation = "En Cours";$sans_remise=0;$sans_remise1=0;$sans_remise2=0;$sans_remise3=0;$sans_remise4=0;$sans_remise5=0;
		$date=dateUsToFr($_REQUEST['date']);$date1=dateUsToFr($_REQUEST['date']);$date2=dateUsToFr($_REQUEST['date']);
		$date3=dateUsToFr($_REQUEST['date']);$date4=dateUsToFr($_REQUEST['date']);$date5=dateUsToFr($_REQUEST['date']);
		$date6=dateUsToFr($_REQUEST['date']);$date7=dateUsToFr($_REQUEST['date']);$date8=dateUsToFr($_REQUEST['date']);
		$date9=dateUsToFr($_REQUEST['date']);$date10=dateUsToFr($_REQUEST['date']);
		
		$vendeur=$_REQUEST['vendeur'];$destination=$_REQUEST['destination'];$controle=0;
		
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM commandes WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $users_ = fetch_array($user);
		$controle=$users_["controle"];$bl=$users_["bl"];$numero_bl=$users_["bc"];
		$title = "details";$vendeur=$users_["vendeur"];$id_registre=$users_["id_registre"];$net=$users_["net"];$active=$users_["active"];
		$ev_pre=$users_["ev_pre"];$bl=$users_["bl"];$bc=$users_["bc"];$piece=$users_["piece"];
		$commande=$users_["commande"];$evaluation=$users_["evaluation"];$client=$users_["client"];	$valider_f=$users_["valider_f"];	
		$remise10=$users_["remise_10"];$remise2=$users_["remise_2"];$remise3=$users_["remise_3"];$remise4=$users_["remise_4"];
		$sans_remise=$users_["sans_remise"];$date=dateUsToFr($users_["date_e"]);$date=dateUsToFr($users_["date_e"]);
		}

	// extracts profile list
	$client_list = "";$v="1";
	$sql = "SELECT * FROM  clients where vendeur_nom='$vendeur' or champs1='$v' ORDER BY client;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($client == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
		
		$client_list .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";
		$client_list .= $temp_["client"];
		$client_list .= "</OPTION>";
	}	if($user_id == "0") {

	$client_list1 = "";
	$sql = "SELECT * FROM  clients where vendeur_nom='$vendeur' or champs1='$v' ORDER BY client;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($client1 == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
		
		$client_list1 .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";
		$client_list1 .= $temp_["client"];
		$client_list1 .= "</OPTION>";
	}
	$client_list2 = "";
	$sql = "SELECT * FROM  clients where vendeur_nom='$vendeur' or champs1='$v' ORDER BY client;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($client2 == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
		
		$client_list2 .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";
		$client_list2 .= $temp_["client"];
		$client_list2 .= "</OPTION>";
	}
	$client_list3 = "";
	$sql = "SELECT * FROM  clients where vendeur_nom='$vendeur' or champs1='$v' ORDER BY client;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($client3 == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
		
		$client_list3 .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";
		$client_list3 .= $temp_["client"];
		$client_list3 .= "</OPTION>";
	}
	$client_list4 = "";
	$sql = "SELECT * FROM  clients where vendeur_nom='$vendeur' or champs1='$v' ORDER BY client;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($client4 == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
		
		$client_list4 .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";
		$client_list4 .= $temp_["client"];
		$client_list4 .= "</OPTION>";
	}
	$client_list5 = "";
	$sql = "SELECT * FROM  clients where vendeur_nom='$vendeur' or champs1='$v' ORDER BY client;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($client5 == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
		
		$client_list5 .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";
		$client_list5 .= $temp_["client"];
		$client_list5 .= "</OPTION>";
	}
	
	$client_list6 = "";
	$sql = "SELECT * FROM  clients where vendeur_nom='$vendeur' or champs1='$v' ORDER BY client;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($client6 == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
		
		$client_list6 .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";
		$client_list6 .= $temp_["client"];
		$client_list6 .= "</OPTION>";
	}
	
		$client_list7 = "";
	$sql = "SELECT * FROM  clients where vendeur_nom='$vendeur' or champs1='$v' ORDER BY client;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($client7 == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
		
		$client_list7 .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";
		$client_list7 .= $temp_["client"];
		$client_list7 .= "</OPTION>";
	}

	$client_list8 = "";
	$sql = "SELECT * FROM  clients where vendeur_nom='$vendeur' or champs1='$v' ORDER BY client;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($client8 == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
		
		$client_list8 .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";
		$client_list8 .= $temp_["client"];
		$client_list8 .= "</OPTION>";
	}

	$client_list9 = "";
	$sql = "SELECT * FROM  clients where vendeur_nom='$vendeur' or champs1='$v' ORDER BY client;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($client9 == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
		
		$client_list9 .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";
		$client_list9 .= $temp_["client"];
		$client_list9 .= "</OPTION>";
	}

	$client_list10 = "";
	$sql = "SELECT * FROM  clients where vendeur_nom='$vendeur' or champs1='$v' ORDER BY client;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($client10 == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
		
		$client_list10 .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";
		$client_list10 .= $temp_["client"];
		$client_list10 .= "</OPTION>";
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
			UpdateUser();
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression ?"; ?>")) {
			document.location = "evaluations_client_encours.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
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

<span style="font-size:24px"><?php  ?></span>

<form id="form_user" name="form_user" method="post" action="evaluations_client_encours.php">

	<table class="table3">
	<? if($user_id == "0") {?>
		<tr><td><?php echo "Date "; ?></td><td><?php echo "Client "; ?></td><td><?php echo "Sans Remise"; ?></td></tr>
		
		<tr><td><input type="text" id="date" name="date" style="width:160px" value="<?php echo $date; ?>"></td>
		<td><select onkeydown="return liDown(this);" id="client" name="client"><?php echo $client_list; ?></select></td>
		<td><input type="checkbox" id="sans_remise" name="sans_remise"<?php if($sans_remise) { echo " checked"; } ?>></td>
		</tr>

		<tr><td><input type="text" id="date1" name="date1" style="width:160px" value="<?php echo $date1; ?>"></td>
		<td><select onkeydown="return liDown(this);" id="client" name="client1"><?php echo $client_list1; ?></select></td>
		<td><input type="checkbox" id="sans_remise1" name="sans_remise1"<?php if($sans_remise1) { echo " checked"; } ?>></td>
		</tr>

		<tr><td><input type="text" id="date2" name="date2" style="width:160px" value="<?php echo $date2; ?>"></td>
		<td><select onkeydown="return liDown(this);" id="client" name="client2"><?php echo $client_list2; ?></select></td>
		<td><input type="checkbox" id="sans_remise2" name="sans_remise2"<?php if($sans_remise2) { echo " checked"; } ?>></td>
		</tr>

		<tr><td><input type="text" id="date3" name="date3" style="width:160px" value="<?php echo $date3; ?>"></td>
		<td><select onkeydown="return liDown(this);" id="client" name="client3"><?php echo $client_list3; ?></select></td>
		<td><input type="checkbox" id="sans_remise3" name="sans_remise3"<?php if($sans_remise3) { echo " checked"; } ?>></td>
		
		</tr>

		<tr><td><input type="text" id="date4" name="date4" style="width:160px" value="<?php echo $date4; ?>"></td>
		<td><select onkeydown="return liDown(this);" id="client" name="client4"><?php echo $client_list4; ?></select></td>
		<td><input type="checkbox" id="sans_remise4" name="sans_remise4"<?php if($sans_remise4) { echo " checked"; } ?>></td></tr>

		<tr><td><input type="text" id="date5" name="date5" style="width:160px" value="<?php echo $date5; ?>"></td>
		<td><select onkeydown="return liDown(this);" id="client" name="client5"><?php echo $client_list5; ?></select></td>
		<td><input type="checkbox" id="sans_remise5" name="sans_remise5"<?php if($sans_remise5) { echo " checked"; } ?>></td></tr>
		
		<tr><td><input type="text" id="date6" name="date6" style="width:160px" value="<?php echo $date6; ?>"></td>
		<td><select onkeydown="return liDown(this);" id="client" name="client6"><?php echo $client_list6; ?></select></td>
		<td><input type="checkbox" id="sans_remise6" name="sans_remise6"<?php if($sans_remise6) { echo " checked"; } ?>></td></tr>
		
		<tr><td><input type="text" id="date7" name="date7" style="width:160px" value="<?php echo $date7; ?>"></td>
		<td><select onkeydown="return liDown(this);" id="client" name="client7"><?php echo $client_list7; ?></select></td>
		<td><input type="checkbox" id="sans_remise7" name="sans_remise7"<?php if($sans_remise7) { echo " checked"; } ?>></td></tr>

		<tr><td><input type="text" id="date8" name="date8" style="width:160px" value="<?php echo $date8; ?>"></td>
		<td><select onkeydown="return liDown(this);" id="client" name="client8"><?php echo $client_list8; ?></select></td>
		<td><input type="checkbox" id="sans_remise8" name="sans_remise8"<?php if($sans_remise8) { echo " checked"; } ?>></td></tr>

		<tr><td><input type="text" id="date9" name="date9" style="width:160px" value="<?php echo $date9; ?>"></td>
		<td><select onkeydown="return liDown(this);" id="client" name="client9"><?php echo $client_list9; ?></select></td>
		<td><input type="checkbox" id="sans_remise9" name="sans_remise9"<?php if($sans_remise9) { echo " checked"; } ?>></td></tr>

		<tr><td><input type="text" id="date10" name="date10" style="width:160px" value="<?php echo $date10; ?>"></td>
		<td><select onkeydown="return liDown(this);" id="client" name="client10"><?php echo $client_list10; ?></select></td>
		<td><input type="checkbox" id="sans_remise10" name="sans_remise10"<?php if($sans_remise10) { echo " checked"; } ?>></td></tr>

	<? }?>
	<? if($user_id <> "0") {?>
		
		<tr><td><?php echo "Date : "; ?></td><td><input type="text" id="date" name="date" style="width:160px" value="<?php echo $date; ?>"></td></tr>
		<tr><td><?php echo "Client : "; ?></td><td><select onkeydown="return liDown(this);" id="client" name="client"><?php echo $client_list; ?></select></td></tr>
		<tr><td><?php echo "Evaluation : "; ?></td><td><?php echo $evaluation; ?></td></tr>
		<?if($bl == 0) {?>
		<tr><td><?php echo "Activer B.L Numero : "; ?></td><td><input type="checkbox" id="bl" name="bl"<?php if($bl) { echo " checked"; } ?>></td>
		<? } else {?>
		<tr><td><?php echo "B.L Numero : "; ?></td><td><input type="text" id="bc" name="bc" style="width:160px" value="<?php echo $numero_bl; ?>"></td>
		<? }?>
		<tr><td><?php echo "Unite Article piece : "; ?></td><td><input type="checkbox" id="piece" name="piece"<?php if($piece) { echo " checked"; } ?>></td></tr>
	<? if($evaluation == "encours") {?>
		<td><?php echo "Activer "; ?></td><td><input type="checkbox" id="active" name="active"<?php if($active) { echo " checked"; } ?>></td></tr>
		</tr>
	<? }?>
		
		<? if($login == "admin" or $login=="najat" or $login=="rakia" or $login=="radia" or $login=="Radia") {?>
		<tr><td><?php echo "Remise 10%"; ?></td><td><input type="text" id="remise10" name="remise10" style="width:60px" value="<?php echo $remise10; ?>"></td>
		</tr>
		<tr><td><?php echo "Remise 2%"; ?></td><td><input type="text" id="remise2" name="remise2" style="width:60px" value="<?php echo $remise2; ?>"></td>
		</tr>
		<tr><td><?php echo "Remise 3%"; ?></td><td><input type="text" id="remise3" name="remise3" style="width:60px" value="<?php echo $remise3; ?>"></td>
		</tr>
		<? } else {?>
		<input type="hidden" id="remise10" name="remise10" value="<?php echo $remise10; ?>">
		<input type="hidden" id="remise2" name="remise2" value="<?php echo $remise2; ?>">
		<input type="hidden" id="remise3" name="remise3" value="<?php echo $remise3; ?>">
		<? }?>
		
		
		
		<td><?php echo "Sans Remise "; ?></td><td><input type="checkbox" id="sans_remise" name="sans_remise"<?php if($sans_remise) { echo " checked"; } ?>></td></tr>
		
		<tr><td><?php echo "net"; ?></td><td><input type="text" id="net" name="net" style="width:160px" value="<?php echo $net; ?>"></td>
		<td><?php echo "Inc dans Evaluation préalable "; ?></td><td><input type="checkbox" id="ev_pre" name="ev_pre"<?php if($ev_pre) { echo " checked"; } ?>></td></tr>
	
	<? }?>
	</table>

<p style="text-align:center">

<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">
<input type="hidden" id="vendeur" name="vendeur" value="<?php echo $vendeur; ?>">
<input type="hidden" id="evaluation" name="evaluation" value="<?php echo $evaluation; ?>">
<input type="hidden" id="destination" name="destination" value="<?php echo $destination; ?>">
<table class="table3"><tr>

<?php if($controle == 0) { ?>

<?php if($user_id != "0") { ?>

<td><button type="button" onClick="CheckUser()"><?php echo Translate("Update"); ?></button></td>
<td><button type="button" onClick="DeleteUser()"><?php echo Translate("Delete"); ?></button></td>

<?php } else { ?>
<td><button type="button"  onClick="CheckUser()"><?php echo Translate("OK"); ?></button></td>
<?php 
} ?>
<?php 
} ?>

</tr></table>

</center>

</form>

</body>

</html>