<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];		$du = $_REQUEST["du"];$au = $_REQUEST["au"];


	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "Nouvelle Facture";

		$date = date("d/m/y");
		$client = "FACTURE EN INSTANCE";
		$vendeur = "";
		$sans_remise=0;$montant="";
		$ev1="";$ev2="";$ev3="";$ev4="";$ev5="";$ev6="";$ev7="";$ev8="";$ev9="";$ev10 = "";
		$ev1_07="";$ev2_07="";$ev3_07="";$ev4_07="";$ev5_07="";$ev6_07="";$ev7_07="";$ev8_07="";$ev9_07="";$ev10_07 = "";
				$result = mysql_query("SELECT numero,client,date_f FROM factures2022 ORDER BY numero DESC LIMIT 0,1"); 
				$row = mysql_fetch_array($result); 
				$numero = $row["numero"];$client_f = $row["client"];$date_f = dateUsToFr($row["date_f"]);
		
		echo "Derniere Facture : $numero - $client_f - $date_f";
		
		
		
		
	} else {
		$action_ = "update_user";
		
		// gets user infos
		
		$d=$_REQUEST["date_f"];
		    if ($d>="2018-01-01" and $d<="2018-12-31"){$factures="factures2018";$detail_factures="detail_factures2018";}
			if ($d>="2019-01-01" and $d<="2019-12-31"){$factures="factures2019";$detail_factures="detail_factures2019";}
			if ($d>="2020-01-01" and $d<="2020-12-31"){$factures="factures2020";$detail_factures="detail_factures2020";}
			if ($d>="2021-01-01" and $d<="2021-12-31"){$factures="factures2021";$detail_factures="detail_factures2021";}
			if ($d>="2022-01-01" and $d<="2022-12-31"){$factures="factures2022";$detail_factures="detail_factures2022";}
			if ($d>="2023-01-01" and $d<="2023-12-31"){$factures="factures2023";$detail_factures="detail_factures2023";}
			if ($d>="2024-01-01" and $d<="2024-12-31"){$factures="factures2024";$detail_factures="detail_factures2024";}
			if ($d>="2025-01-01" and $d<="2025-12-31"){$factures="factures2025";$detail_factures="detail_factures2025";}
			if ($d>="2026-01-01" and $d<="2026-12-31"){$factures="factures2026";$detail_factures="detail_factures2026";}
		$sql  = "SELECT * ";
		$sql .= "FROM $factures WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";$client_s=0;

		$date = dateUsToFr($user_["date_f"]);
		$client = $user_["client"];$numero = $user_["numero"];$exercice = $user_["exercice"];
		$vendeur = $user_["vendeur"];$montant = $user_["montant"];$id = $user_["id"];
		$evaluation = $user_["evaluation"];
		$ev1 = $user_["ev1"];
		$ev2 = $user_["ev2"];
		$ev3 = $user_["ev3"];
		$ev4 = $user_["ev4"];
		$ev5 = $user_["ev5"];
		$ev6 = $user_["ev6"];
		$ev7 = $user_["ev7"];
		$ev8 = $user_["ev8"];
		$ev9 = $user_["ev9"];
		$ev10 = $user_["ev10"];
		$ev1_07 = $user_["ev1_07"];
		$ev2_07 = $user_["ev2_07"];
		$ev3_07 = $user_["ev3_07"];
		$ev4_07 = $user_["ev4_07"];
		$ev5_07 = $user_["ev5_07"];
		$ev6_07 = $user_["ev6_07"];
		$ev7_07 = $user_["ev7_07"];
		$ev8_07 = $user_["ev8_07"];
		$ev9_07 = $user_["ev9_07"];
		$ev10_07 = $user_["ev10_07"];

		$sans_remise = $user_["sans_remise"];$remise10 = $user_["remise_10"];
		$remise2 = $user_["remise_2"];$remise3 = $user_["remise_3"];
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
			document.location = "factures2019.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}


--></script>

</head>

<body style="background:#dfe8ff">
<? require "body_cal.php";?>
<span style="font-size:24px"><?php if ($id<10){$zero="000";}
if ($id>=10 and $id<100){$zero="00";}
if ($id>=100 and $id<1000){$zero="0";}
if ($id>=1000 and $id<10000){$zero="";}
$facture=$id+0;$facture=$zero.$facture."/".$exercice;




echo "Facture : ".$facture."---".$date."---".$client; ?></span>

<form id="form_user" name="form_user" method="post" action="factures2019.php">

	<table class="table3">

		<tr>
		<td><?php echo "date"; ?></td><td><input onClick="ds_sh(this);" name="date" value="<?php echo $date; ?>" readonly="readonly" style="cursor: text" /></td>
		</tr>
		<tr>
		<td><?php echo "Client : "; ?></td><td><select onkeydown="return liDown(this);" id="client" name="client"><?php echo $client_list; ?></select></td>
		</tr>
		<tr><td><?php echo "Evaluations : "; ?></td></tr>
		<tr><table class="table3">
		<td><input type="text" id="ev1" name="ev1" style="width:70px" value="<?php echo $ev1; ?>"></td>
		<td><input type="text" id="ev2" name="ev2" style="width:70px" value="<?php echo $ev2; ?>"></td>
		<td><input type="text" id="ev3" name="ev3" style="width:70px" value="<?php echo $ev3; ?>"></td>
		<td><input type="text" id="ev4" name="ev4" style="width:70px" value="<?php echo $ev4; ?>"></td>
		<td><input type="text" id="ev5" name="ev5" style="width:70px" value="<?php echo $ev5; ?>"></td>
		<td><input type="text" id="ev6" name="ev6" style="width:70px" value="<?php echo $ev6; ?>"></td>
		<td><input type="text" id="ev7" name="ev7" style="width:70px" value="<?php echo $ev7; ?>"></td>
		<td><input type="text" id="ev8" name="ev8" style="width:70px" value="<?php echo $ev8; ?>"></td>
		<td><input type="text" id="ev9" name="ev9" style="width:70px" value="<?php echo $ev9; ?>"></td>
		<td><input type="text" id="ev10" name="ev10" style="width:70px" value="<?php echo $ev10; ?>"></td>
		</table>
		
		<tr><td><?php echo "Evaluations "; ?></td></tr>
		<tr><table class="table3">
		<td><input type="text" id="ev1_07" name="ev1_07" style="width:70px" value="<?php echo $ev1_07; ?>"></td>
		<td><input type="text" id="ev2_07" name="ev2_07" style="width:70px" value="<?php echo $ev2_07; ?>"></td>
		<td><input type="text" id="ev3_07" name="ev3_07" style="width:70px" value="<?php echo $ev3_07; ?>"></td>
		<td><input type="text" id="ev4_07" name="ev4_07" style="width:70px" value="<?php echo $ev4_07; ?>"></td>
		<td><input type="text" id="ev5_07" name="ev5_07" style="width:70px" value="<?php echo $ev5_07; ?>"></td>
		<td><input type="text" id="ev6_07" name="ev6_07" style="width:70px" value="<?php echo $ev6_07; ?>"></td>
		<td><input type="text" id="ev7_07" name="ev7_07" style="width:70px" value="<?php echo $ev7_07; ?>"></td>
		<td><input type="text" id="ev8_07" name="ev8_07" style="width:70px" value="<?php echo $ev8_07; ?>"></td>
		<td><input type="text" id="ev9_07" name="ev9_07" style="width:70px" value="<?php echo $ev9_07; ?>"></td>
		<td><input type="text" id="ev10_07" name="ev10_07" style="width:70px" value="<?php echo $ev10_07; ?>"></td>
		</table>	
			
		<tr><td><?php echo "Montant Facture"; ?></td><td align="right"><input type="text" id="montant" name="montant" style="width:160px" value="<?php echo $montant; ?>"></td>

		</tr>
		<tr><td><input type="checkbox" id="sans_remise" name="sans_remise"<?php if($sans_remise) { echo " checked"; } ?>></td><td>Facture sans Remises</td>
		</tr>
		<? if ($user_id<>0){?>
		<tr><td><?php echo "Remise 10%"; ?></td><td><input type="text" id="remise10" name="remise10" style="width:60px" value="<?php echo $remise10; ?>"></td>
		</tr>
		<tr><td><?php echo "Remise 2%"; ?></td><td><input type="text" id="remise2" name="remise2" style="width:60px" value="<?php echo $remise2; ?>"></td>
		</tr>
		<tr><td><?php echo "Remise 3%"; ?></td><td><input type="text" id="remise3" name="remise3" style="width:60px" value="<?php echo $remise3; ?>"></td>
		</tr>
		<? }?>
		</tr>
		
	</table>

<p style="text-align:center">

<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">
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