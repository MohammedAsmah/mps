<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];		$date=dateUsToFr($_REQUEST['date']);


	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "Evaluation";

		$client = "";$client1 = "";$client2 = "";$client3 = "";$client4 = "";$client5 = "";$client6 = "";$client7 = "";
		$client8 = "";$bb="";$observation="";
		$client9 = "";
		$client10 = "";$sans_remise6=0;$sans_remise7=0;$sans_remise8=0;$sans_remise9=0;$sans_remise10=0;
		$evaluation = "En Cours";$sans_remise=0;$sans_remise1=0;$sans_remise2=0;$sans_remise3=0;$sans_remise4=0;$sans_remise5=0;
		$date=dateUsToFr($_REQUEST['date']);$ttc=0;
		$date1=dateUsToFr($_REQUEST['date']);$date2=dateUsToFr($_REQUEST['date']);
		$date3=dateUsToFr($_REQUEST['date']);$date4=dateUsToFr($_REQUEST['date']);$date5=dateUsToFr($_REQUEST['date']);
		$date6=dateUsToFr($_REQUEST['date']);$date7=dateUsToFr($_REQUEST['date']);$date8=dateUsToFr($_REQUEST['date']);
		$date9=dateUsToFr($_REQUEST['date']);$date10=dateUsToFr($_REQUEST['date']);
		
		$vendeur=$_REQUEST['vendeur'];$destination=$_REQUEST['destination'];
		
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM commandes_frs WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $users_ = fetch_array($user);

		$title = "details";$vendeur=$users_["vendeur"];$id_registre=$users_["id_registre"];$net=$users_["net"];$active=$users_["active"];
		$ev_pre=$users_["ev_pre"];$bl=$users_["bl"];$bc=$users_["bc"];$piece=$users_["piece"];$bb=$users_["bb"];
		$commande=$users_["commande"];$evaluation=$users_["evaluation"];$client=$users_["client"];	$valider_f=$users_["valider_f"];	
		$remise10=$users_["remise_10"];$remise2=$users_["remise_2"];$remise3=$users_["remise_3"];$remise4=$users_["remise_4"];
		$sans_remise=$users_["sans_remise"];$date=dateUsToFr($users_["date_e"]);$date=dateUsToFr($users_["date_e"]);
		$observation=$users_["observation"];$ttc=$users_["ttc"];$date_cloture=dateUsToFr($users_["date_cloture"]);$obs_cloture=$users_["obs_cloture"];
	}

	// extracts profile list
	$client_list = "";$v="1";
	$sql = "SELECT * FROM  rs_data_fournisseurs ORDER BY last_name;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($client == $temp_["last_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$client_list .= "<OPTION VALUE=\"" . $temp_["last_name"] . "\"" . $selected . ">";
		$client_list .= $temp_["last_name"];
		$client_list .= "</OPTION>";
	}	if($user_id == "0") {

	
	}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . $title; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function UpdateUser() {
			document.getElementById("form_user").submit();
	}

	function CheckUser() {
			if(document.getElementById("frs").value == "" ) {
			alert("<?php echo ("remplir le champs fournisseur !"); ?>");
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression ?"; ?>")) {
			document.location = "bc_mps.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
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
<? require "body_cal.php";?>
<span style="font-size:24px"><?php  ?></span>

<form id="form_user" name="form_user" method="post" action="bc_mps.php">

	<table class="table3">
	<? if($user_id == "0") {?>
		<tr><td><?php echo "Fournisseur "; ?></td>
		<td><select onkeydown="return liDown(this);" id="frs" name="frs"><?php echo $client_list; ?></select></td></tr>
		
		
		<tr><td><?php echo "Date : "; ?></td><td><input onClick="ds_sh(this);" name="date" value="<?php echo $date; ?>" readonly="readonly" style="cursor: text" /></td>
		<tr><td><?php echo "Sans Prix "; ?></td><td><input type="checkbox" id="sans_remise" name="sans_remise"<?php if($sans_remise) { echo " checked"; } ?>></td></tr>
		</tr>
		
		<tr><td><?php echo "Bon de Besoin : "; ?></td><td><input type="text" id="bb" name="bb" style="width:160px" value="<?php echo $bb; ?>"></td></tr>
		<tr><td><?php echo "Observations : "; ?></td><td><input type="text" id="observation" name="observation" style="width:300px" value="<?php echo $observation; ?>"></td></tr>

		<tr><td><?php echo $destination; ?></td>
		<td><?php echo "Prix TTC "; ?></td><td><input type="checkbox" id="ttc" name="ttc"<?php if($ttc) { echo " checked"; } ?>></td></tr>
		</tr>
		

	<? }?>
	<? if($user_id <> "0") {?>
		
		<tr><td><?php echo "Date : "; ?></td><td><input onClick="ds_sh(this);" name="date" value="<?php echo $date; ?>" readonly="readonly" style="cursor: text" /></td>
		
		<tr><td><?php echo "Fournisseur : "; ?></td><td><select onkeydown="return liDown(this);" id="frs" name="frs"><?php echo $client_list; ?></select></td></tr>
		<tr><td><?php echo "Sans prix "; ?></td><td><input type="checkbox" id="sans_remise" name="sans_remise"<?php if($sans_remise) { echo " checked"; } ?>></td></tr>
		<tr><td><?php echo "Observations : "; ?></td><td><input type="text" id="observation" name="observation" style="width:200px" value="<?php echo $observation; ?>"></td></tr>
		<tr><td><?php echo "Bon de Besoin : "; ?></td><td><input type="text" id="bb" name="bb" style="width:160px" value="<?php echo $bb; ?>"></td></tr>
		<tr><td><?php echo $destination; ?></td>
		<tr><td><?php echo "Prix TTC "; ?></td><td><input type="checkbox" id="ttc" name="ttc"<?php if($ttc) { echo " checked"; } ?>></td></tr>
		</tr>
		<tr><td><?php echo "Date Clôture: "; ?></td><td><input onClick="ds_sh(this);" name="date_cloture" value="<?php echo $date_cloture; ?>" readonly="readonly" style="cursor: text" /></td></tr>
		<tr><td><?php echo "Obs Clôture: "; ?></td><td><input type="text" id="obs_cloture" name="obs_cloture" style="width:160px" value="<?php echo $obs_cloture; ?>"></td></tr>
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