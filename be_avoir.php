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

		$client = "";$client1 = "";$client2 = "";$client3 = "";$client4 = "";$client5 = "";$client6 = "";$client7 = "";
		$client8 = "";
		$client9 = "";
		$client10 = "";$client11 = "";$client12 = "";$client13 = "";$client14 = "";$client15 = "";
		$evaluation = "En Cours";$sans_remise=0;$sans_remise1=0;$sans_remise2=0;$sans_remise3=0;$sans_remise4=0;$sans_remise5=0;
		$date=dateUsToFr($_REQUEST['date']);$date1=dateUsToFr($_REQUEST['date']);$date2=dateUsToFr($_REQUEST['date']);
		$date3=dateUsToFr($_REQUEST['date']);$date4=dateUsToFr($_REQUEST['date']);$date5=dateUsToFr($_REQUEST['date']);
		$client=$_REQUEST['client'];$be=$_REQUEST['be'];$vendeur=$_REQUEST['vendeur'];
		
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM avoirs_vendeurs WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $users_ = fetch_array($user);

		$title = "details";$vendeur=$users_["vendeur"];$id_registre=$users_["id_registre"];$net=$users_["net"];$active=$users_["active"];
		$ev_pre=$users_["ev_pre"];$be=$users_["be"];
		$commande=$users_["commande"];$evaluation=$users_["evaluation"];$client=$users_["client"];	$valider_f=$users_["valider_f"];	
		$remise10=$users_["remise_10"];$remise2=$users_["remise_2"];$remise3=$users_["remise_3"];$remise_4=$users_["remise_4"];
		$sans_remise=$users_["sans_remise"];$date=dateUsToFr($users_["date_e"]);$date=dateUsToFr($users_["date_e"]);$mode=$users_["mode"];
		$client1=$users_["client1"];
		$client2=$users_["client2"];
		$client3=$users_["client3"];
		$client4=$users_["client4"];
		$client5=$users_["client5"];
		$client6=$users_["client6"];
		$client7=$users_["client7"];
		$client8=$users_["client8"];
		$client9=$users_["client9"];
		$client10=$users_["client10"];
	$client11=$users_["client11"];
	$client12=$users_["client12"];
	$client13=$users_["client13"];
	$client14=$users_["client14"];
	$client15=$users_["client15"];
	
		}

	// extracts profile list
	$vendeur_list = "";$v="1";
	$sql = "SELECT * FROM  vendeurs ORDER BY vendeur;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($vendeur == $temp_["vendeur"]) { $selected = " selected"; } else { $selected = ""; }
		
		$vendeur_list .= "<OPTION VALUE=\"" . $temp_["vendeur"] . "\"" . $selected . ">";
		$vendeur_list .= $temp_["vendeur"];
		$vendeur_list .= "</OPTION>";
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
	}	
	
	
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
	
	$client_list11 = "";
	$sql = "SELECT * FROM  clients where vendeur_nom='$vendeur' or champs1='$v' ORDER BY client;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($client11 == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
		
		$client_list11 .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";
		$client_list11 .= $temp_["client"];
		$client_list11 .= "</OPTION>";
	}
	
	$client_list12 = "";
	$sql = "SELECT * FROM  clients where vendeur_nom='$vendeur' or champs1='$v' ORDER BY client;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($client12 == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
		
		$client_list12 .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";
		$client_list12 .= $temp_["client"];
		$client_list12 .= "</OPTION>";
	}
	
	$client_list13 = "";
	$sql = "SELECT * FROM  clients where vendeur_nom='$vendeur' or champs1='$v' ORDER BY client;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($client13 == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
		
		$client_list13 .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";
		$client_list13 .= $temp_["client"];
		$client_list13 .= "</OPTION>";
	}
	
	$client_list14 = "";
	$sql = "SELECT * FROM  clients where vendeur_nom='$vendeur' or champs1='$v' ORDER BY client;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($client14 == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
		
		$client_list14 .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";
		$client_list14 .= $temp_["client"];
		$client_list14 .= "</OPTION>";
	}
	
	$client_list15 = "";
	$sql = "SELECT * FROM  clients where vendeur_nom='$vendeur' or champs1='$v' ORDER BY client;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($client15 == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
		
		$client_list15 .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";
		$client_list15 .= $temp_["client"];
		$client_list15 .= "</OPTION>";
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
			document.location = "be_avoirs.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
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

<span style="font-size:16px"><?php echo "Avoir : $vendeur pour $date Bon d'entree numero : $be "; ?></span>

<form id="form_user" name="form_user" method="post" action="be_avoirs.php">

	<table class="table3">
	<? if($user_id == "0") {?>
		<tr><td><?php echo "Date : "; ?></td><td><input type="text" id="date" name="date" style="width:160px" value="<?php echo $date; ?>"></td>
		<tr><td><?php echo "Vendeur : "; ?></td><td><select onkeydown="return liDown(this);" id="vendeur" name="vendeur"><?php echo $vendeur_list; ?></select></td></tr>
		<tr><td><?php echo "N° B.E : "; ?></td><td><input type="text" id="be" name="be" style="width:160px" value="<?php echo $be; ?>"></td></tr>
		<tr>
		<table class="table3">
		<tr><td><select onkeydown="return liDown(this);" id="client1" name="client1"><?php echo $client_list1; ?></select></td></tr>
		<tr><td><select onkeydown="return liDown(this);" id="client2" name="client2"><?php echo $client_list2; ?></select></td></tr>
		<tr><td><select onkeydown="return liDown(this);" id="client3" name="client3"><?php echo $client_list3; ?></select></td></tr>
		<tr><td><select onkeydown="return liDown(this);" id="client4" name="client4"><?php echo $client_list4; ?></select></td></tr>
		<tr><td><select onkeydown="return liDown(this);" id="client5" name="client5"><?php echo $client_list5; ?></select></td></tr>
		<tr><td><select onkeydown="return liDown(this);" id="client6" name="client6"><?php echo $client_list6; ?></select></td></tr>
		<tr><td><select onkeydown="return liDown(this);" id="client7" name="client7"><?php echo $client_list7; ?></select></td></tr>
		<tr><td><select onkeydown="return liDown(this);" id="client8" name="client8"><?php echo $client_list8; ?></select></td></tr>
		<tr><td><select onkeydown="return liDown(this);" id="client9" name="client9"><?php echo $client_list9; ?></select></td></tr>
		<tr><td><select onkeydown="return liDown(this);" id="client10" name="client10"><?php echo $client_list10; ?></select></td></tr>
		<tr><td><select onkeydown="return liDown(this);" id="client11" name="client11"><?php echo $client_list11; ?></select></td></tr>
		<tr><td><select onkeydown="return liDown(this);" id="client12" name="client12"><?php echo $client_list12; ?></select></td></tr>
		<tr><td><select onkeydown="return liDown(this);" id="client13" name="client13"><?php echo $client_list13; ?></select></td></tr>
		<tr><td><select onkeydown="return liDown(this);" id="client14" name="client14"><?php echo $client_list14; ?></select></td></tr>
		<tr><td><select onkeydown="return liDown(this);" id="client15" name="client15"><?php echo $client_list15; ?></select></td></tr>
		</table>
	
	<? }?>
	<? if($user_id <> "0") {?>
		
		<tr><td><?php echo "Date : "; ?></td><td><input type="text" id="date" name="date" style="width:160px" value="<?php echo $date; ?>"></td></tr>
		<tr><td><?php echo "Vendeur : "; ?></td><td><select onkeydown="return liDown(this);" id="vendeur" name="vendeur"><?php echo $vendeur_list; ?></select></td></tr>
		<tr><td><?php echo "N° B.E : "; ?></td><td><input type="text" id="be" name="be" style="width:160px" value="<?php echo $be; ?>"></td></tr>
		<tr>
		<table class="table3">
		<tr><td><select onkeydown="return liDown(this);" id="client1" name="client1"><?php echo $client_list1; ?></select></td></tr>
		<tr><td><select onkeydown="return liDown(this);" id="client2" name="client2"><?php echo $client_list2; ?></select></td></tr>
		<tr><td><select onkeydown="return liDown(this);" id="client3" name="client3"><?php echo $client_list3; ?></select></td></tr>
		<tr><td><select onkeydown="return liDown(this);" id="client4" name="client4"><?php echo $client_list4; ?></select></td></tr>
		<tr><td><select onkeydown="return liDown(this);" id="client5" name="client5"><?php echo $client_list5; ?></select></td></tr>
		<tr><td><select onkeydown="return liDown(this);" id="client6" name="client6"><?php echo $client_list6; ?></select></td></tr>
		<tr><td><select onkeydown="return liDown(this);" id="client7" name="client7"><?php echo $client_list7; ?></select></td></tr>
		<tr><td><select onkeydown="return liDown(this);" id="client8" name="client8"><?php echo $client_list8; ?></select></td></tr>
		<tr><td><select onkeydown="return liDown(this);" id="client9" name="client9"><?php echo $client_list9; ?></select></td></tr>
		<tr><td><select onkeydown="return liDown(this);" id="client10" name="client10"><?php echo $client_list10; ?></select></td></tr>
		<tr><td><select onkeydown="return liDown(this);" id="client11" name="client11"><?php echo $client_list11; ?></select></td></tr>
		<tr><td><select onkeydown="return liDown(this);" id="client12" name="client12"><?php echo $client_list12; ?></select></td></tr>
		<tr><td><select onkeydown="return liDown(this);" id="client13" name="client13"><?php echo $client_list13; ?></select></td></tr>
		<tr><td><select onkeydown="return liDown(this);" id="client14" name="client14"><?php echo $client_list14; ?></select></td></tr>
		<tr><td><select onkeydown="return liDown(this);" id="client15" name="client15"><?php echo $client_list15; ?></select></td></tr>
		</table>
	
	<? }?>
	</table>

<p style="text-align:center">

<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">
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