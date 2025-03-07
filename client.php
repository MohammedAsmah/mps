<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];

	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "Nouveau Client";

		$login = "";$patente = "";$minimum=0;
		$last_name = "";
		$first_name = "";$ville="";$vendeur="";$inputation="";
		$email = "";$ice = "";
		$locked = "";
		$profile_id = 0;
		$remarks = "";
		$remise2=0;$remise10=0;
		$remise3=0;
		$remise2_v=0;$remise10_v=0;
		$remise3_v=0;
		$sans_escompte=0;
		$com_debiteur_to_a=0;
		$com_debiteur_to_e=0;
		$com_cash_rep_a=0;
		$com_cash_rep_e=0;
		$com_cash_ag_a=0;
		$com_cash_ag_e=0;
		$type_remise="";
		$escompte=0;$prix1=0;$prix2=0;$escompte2=0;
		
		
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM clients WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";

		$login = $user_["ref"];$patente = $user_["patente"];$inputation = $user_["inputation"];$prix1 = $user_["prix1"];$prix2 = $user_["prix2"];$minimum = $user_["minimum"];
		$last_name = $user_["client"];$last_name1 = $user_["client"];$ancien_client = $user_["client"];$ice = $user_["ice"];
		$vendeur = $user_["vendeur_nom"];$ville = $user_["ville"];$escompte2 = $user_["escompte2"];
		$remarks = $user_["adrresse"];$remise2 = $user_["remise2"];$remise3 = $user_["remise3"];$remise10 = $user_["remise10"];$type_remise = $user_["type_remise"];
		$escompte = $user_["escompte"];$remise2_v = $user_["remise2_v"];$remise3_v = $user_["remise3_v"];$remise10_v = $user_["remise10_v"];$sans_escompte = $user_["sans_escompte"];
		}
	$profiles_list_vendeur = "";
	$sql = "SELECT * FROM vendeurs ORDER BY vendeur;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($vendeur == $temp_["vendeur"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_vendeur .= "<OPTION VALUE=\"" . $temp_["vendeur"] . "\"" . $selected . ">";
		$profiles_list_vendeur .= $temp_["vendeur"];
		$profiles_list_vendeur .= "</OPTION>";
	}
	$profiles_list_ville = "";
	$sql = "SELECT * FROM rs_data_villes ORDER BY ville;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($ville == $temp_["ville"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_ville .= "<OPTION VALUE=\"" . $temp_["ville"] . "\"" . $selected . ">";
		$profiles_list_ville .= $temp_["ville"];
		$profiles_list_ville .= "</OPTION>";
	}
	
	$profiles_list_remise = "";
	$sql = "SELECT * FROM types_remises ORDER BY profile_name;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($type_remise == $temp_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_remise .= "<OPTION VALUE=\"" . $temp_["profile_name"] . "\"" . $selected . ">";
		$profiles_list_remise .= $temp_["profile_name"];
		$profiles_list_remise .= "</OPTION>";
	}
	


	// extracts profile list
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
		if(document.getElementById("last_name").value == "" ) {
			alert("<?php echo Translate("The values for the fields are required !"); ?>");
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression de ce client ?"; ?>")) {
			document.location = "clients.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}

	function Editcontrat(user_id) { document.location = "contrats_sejours.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" method="post" action="clients.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table class="table3">
		<tr>
		<td><?php echo "Code"; ?></td><td><input type="text" id="login" name="login" style="width:260px" value="<?php echo $login; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Client"; ?></td><td><input type="text" id="last_name" name="last_name" style="width:260px" value="<?php echo $last_name; ?>"></td>
		</tr>
		
		<tr>
		<td><?php echo "Type de remise : "; ?></td><td><select id="type_remise" name="type_remise"><?php echo $profiles_list_remise; ?></select></td>
		</tr>
		<tr>
		<td><?php echo "Escompte"; ?></td><td><input type="text" id="escompte" name="escompte" style="width:260px" value="<?php echo $escompte; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "2eme Escompte"; ?></td><td><input type="text" id="escompte2" name="escompte2" style="width:260px" value="<?php echo $escompte2; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Minimum M.Escompte"; ?></td><td><input type="text" id="minimum" name="minimum" style="width:260px" value="<?php echo $minimum; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Sans Escompte"; ?></td><td><input type="checkbox" id="sans_escompte" name="sans_escompte"<?php if($sans_escompte) { echo " checked"; } ?>></td>
		</tr>
		
		<tr>
		<td><?php echo "Remise 10 "; ?></td>
		<td><input type="text" id="remise10" name="remise10" style="width:260px" value="<?php echo $remise10; ?>">
		<input type="checkbox" id="remise10_v" name="remise10_v"<?php if($remise10_v) { echo " checked"; } ?>></td>
		</tr>

		<tr>
		<td><?php echo "Remise 2 "; ?></td>
		<td><input type="text" id="remise2" name="remise2" style="width:260px" value="<?php echo $remise2; ?>">
		<input type="checkbox" id="remise2_v" name="remise2_v"<?php if($remise2_v) { echo " checked"; } ?>></td>
		</tr>
		<tr>
		<td><?php echo "Remise 3 "; ?></td>
		<td><input type="text" id="remise3" name="remise3" style="width:260px" value="<?php echo $remise3; ?>">
		<input type="checkbox" id="remise3_v" name="remise3_v"<?php if($remise3_v) { echo " checked"; } ?>></td>
		</tr>
		<tr>
		<td><?php echo "Vendeur : "; ?></td><td><select id="vendeur" name="vendeur"><?php echo $profiles_list_vendeur; ?></select></td>
		</tr>
		<tr>
		<td><?php echo "Adresse"; ?></td><td><input type="text" id="remarks" name="remarks" style="width:260px" value="<?php echo $remarks; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Ville : "; ?></td><td><select id="ville" name="ville"><?php echo $profiles_list_ville; ?></select></td>
		</tr>
		<tr>
		<td><?php echo "Patente"; ?></td><td><input type="text" id="patente" name="patente" style="width:100px" value="<?php echo $patente; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Inputation"; ?></td><td><input type="text" id="inputation" name="inputation" style="width:100px" value="<?php echo $inputation; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "ICE"; ?></td><td><input type="text" id="ice" name="ice" style="width:100px" value="<?php echo $ice; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Grille Tarifs"; ?></td><td>Tarif 1 : <input type="checkbox" id="prix1" name="prix1"<?php if($prix1) { echo " checked"; } ?>>
		Tarif 2 : <input type="checkbox" id="prix2" name="prix2"<?php if($prix2) { echo " checked"; } ?>>
		</td>
		
		
		</table>


<p style="text-align:center">

<?
	$sql  = "SELECT * ";
	$sql .= "FROM factures where client='$last_name' ORDER BY id;";
	$userss = db_query($database_name, $sql);
 $compteur=0;while($users_s = fetch_array($userss)) { $compteur=$compteur+1; } ?>

<?
	$sql  = "SELECT * ";
	$sql .= "FROM commandes where client='$last_name' ORDER BY id;";
	$usersss = db_query($database_name, $sql);
 $compteur1=0;while($users_ss = fetch_array($usersss)) { $compteur1=$compteur1+1; } ?>







<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">
<input type="hidden" id="last_name1" name="last_name1" value="<?php echo $last_name1; ?>">
<input type="hidden" id="ancien_client" name="ancien_client" value="<?php echo $ancien_client; ?>">
<table class="table3"><tr>

<?php if($user_id != "0") { ?>
<td><button type="button" onClick="CheckUser()"><?php echo Translate("Update"); ?></button></td>
<td style="width:20px"></td>
<? if ($compteur==0 and $compteur1==0){?>
<td><button type="button" onClick="DeleteUser()"><?php echo Translate("Delete"); ?></button></td>
<? }?>
<?php } else { ?>
<td><button type="button"  onClick="CheckUser()"><?php echo Translate("OK"); ?></button></td>
<?php 
} ?>
</tr></table>

</center>

</form>


<?
	$sql  = "SELECT * ";
	$sql .= "FROM factures2016 where client='$last_name' ORDER BY id;";
	$users = db_query($database_name, $sql);
?>
<table class="table2">

<tr>
	<th><?php echo "Numero";?></th>
	<th><?php echo "Date";?></th>
	<th width="200"><?php echo "Client";?></th>
	<th width="150"><?php echo "Montant";?></th>
</tr>

<?php $ca=0;while($users_ = fetch_array($users)) { ?><tr>

<? $client=$users_["client"];$id=$users_["id"];$f=$users_["numero"];$d=$users_["date_f"];?>

<?php $evaluation=$users_["evaluation"]; $client=$users_["client"];$user_id=$users_["id"];$facture=$users_["id"]+9040;
$facture=$users_["id"]+9040;$client=$users_["client"];$m=$users_["montant"];$user_id=$users_["id"];
echo "<td>$facture</td>";?>
<td><?php $date=dateUsToFr($users_["date_f"]);$d=dateUsToFr($users_["date_f"]);print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$d </font>"); ?></td>
<td><?php $c=$users_["client"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$c </font>"); ?> </td>
<?php $evaluation=$users_["evaluation"]; $client=$users_["client"];?>
<td align="right" width="150"><?php $ca=$ca+$users_["montant"];$m=number_format($users_["montant"],2,',',' ');
print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$m </font>");
 ?></td>
<?php } ?>

<?
	$sql  = "SELECT * ";
	$sql .= "FROM factures where client='$last_name' ORDER BY id;";
	$users = db_query($database_name, $sql);


while($users_ = fetch_array($users)) { ?><tr>

<? $client=$users_["client"];$id=$users_["id"];$f=$users_["numero"];$d=$users_["date_f"];?>

<?php $evaluation=$users_["evaluation"]; $client=$users_["client"];$user_id=$users_["id"];$facture=$users_["id"]+0;

$exercice=$users_["exercice"];
	if ($id<10){$zero="0000";}
if ($id>=10 and $id<100){$zero="000";}
if ($id>=100 and $id<1000){$zero="00";}
if ($id>=1000 and $id<10000){$zero="0";}
if ($id>=10000){$zero="";}
	$facture1=$zero.$id."/".$exercice;

$client=$users_["client"];$m=$users_["montant"];$user_id=$users_["id"];
echo "<td>$facture1</td>";?>
<td><?php $date=dateUsToFr($users_["date_f"]);$d=dateUsToFr($users_["date_f"]);print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$d </font>"); ?></td>
<td><?php $c=$users_["client"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$c </font>"); ?> </td>
<?php $evaluation=$users_["evaluation"]; $client=$users_["client"];?>
<td align="right" width="150"><?php $ca=$ca+$users_["montant"];$m=number_format($users_["montant"],2,',',' ');
print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$m </font>");
 ?></td>
<?php } ?>

<?
	$sql  = "SELECT * ";
	$sql .= "FROM factures2018 where client='$last_name' ORDER BY id;";
	$users = db_query($database_name, $sql);


while($users_ = fetch_array($users)) { ?><tr>

<? $client=$users_["client"];$id=$users_["id"];$f=$users_["numero"];$d=$users_["date_f"];?>

<?php $evaluation=$users_["evaluation"]; $client=$users_["client"];$user_id=$users_["id"];$facture=$users_["id"]+0;

$exercice=$users_["exercice"];
if ($user_id<10){$zero="000";}
if ($user_id>=10 and $user_id<100){$zero="00";}
if ($user_id>=100 and $user_id<1000){$zero="0";}
if ($user_id>=1000 and $user_id<10000){$zero="";}
$facture=$users_["id"]+0;$exercice=$users_["exercice"];$facture1=$zero.$facture."/".$exercice;

$client=$users_["client"];$m=$users_["montant"];$user_id=$users_["id"];
echo "<td>$facture1</td>";?>
<td><?php $date=dateUsToFr($users_["date_f"]);$d=dateUsToFr($users_["date_f"]);print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$d </font>"); ?></td>
<td><?php $c=$users_["client"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$c </font>"); ?> </td>
<?php $evaluation=$users_["evaluation"]; $client=$users_["client"];?>
<td align="right" width="150"><?php $ca=$ca+$users_["montant"];$m=number_format($users_["montant"],2,',',' ');
print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$m </font>");
 ?></td>
<?php } ?>

<?
	$sql  = "SELECT * ";
	$sql .= "FROM factures2019 where client='$last_name' ORDER BY id;";
	$users = db_query($database_name, $sql);


while($users_ = fetch_array($users)) { ?><tr>

<? $client=$users_["client"];$id=$users_["id"];$f=$users_["numero"];$d=$users_["date_f"];?>

<?php $evaluation=$users_["evaluation"]; $client=$users_["client"];$user_id=$users_["id"];$facture=$users_["id"]+0;

$exercice=$users_["exercice"];
if ($user_id<10){$zero="000";}
if ($user_id>=10 and $user_id<100){$zero="00";}
if ($user_id>=100 and $user_id<1000){$zero="0";}
if ($user_id>=1000 and $user_id<10000){$zero="";}
$facture=$users_["id"]+0;$exercice=$users_["exercice"];$facture1=$zero.$facture."/".$exercice;

$client=$users_["client"];$m=$users_["montant"];$user_id=$users_["id"];
echo "<td>$facture1</td>";?>
<td><?php $date=dateUsToFr($users_["date_f"]);$d=dateUsToFr($users_["date_f"]);print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$d </font>"); ?></td>
<td><?php $c=$users_["client"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$c </font>"); ?> </td>
<?php $evaluation=$users_["evaluation"]; $client=$users_["client"];?>
<td align="right" width="150"><?php $ca=$ca+$users_["montant"];$m=number_format($users_["montant"],2,',',' ');
print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$m </font>");
 ?></td>
<?php } ?>


<?
	$sql  = "SELECT * ";
	$sql .= "FROM factures2020 where client='$last_name' ORDER BY id;";
	$users = db_query($database_name, $sql);


while($users_ = fetch_array($users)) { ?><tr>

<? $client=$users_["client"];$id=$users_["id"];$f=$users_["numero"];$d=$users_["date_f"];?>

<?php $evaluation=$users_["evaluation"]; $client=$users_["client"];$user_id=$users_["id"];$facture=$users_["id"]+0;

$exercice=$users_["exercice"];
if ($user_id<10){$zero="000";}
if ($user_id>=10 and $user_id<100){$zero="00";}
if ($user_id>=100 and $user_id<1000){$zero="0";}
if ($user_id>=1000 and $user_id<10000){$zero="";}
$facture=$users_["id"]+0;$exercice=$users_["exercice"];$facture1=$zero.$facture."/".$exercice;

$client=$users_["client"];$m=$users_["montant"];$user_id=$users_["id"];
echo "<td>$facture1</td>";?>
<td><?php $date=dateUsToFr($users_["date_f"]);$d=dateUsToFr($users_["date_f"]);print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$d </font>"); ?></td>
<td><?php $c=$users_["client"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$c </font>"); ?> </td>
<?php $evaluation=$users_["evaluation"]; $client=$users_["client"];?>
<td align="right" width="150"><?php $ca=$ca+$users_["montant"];$m=number_format($users_["montant"],2,',',' ');
print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$m </font>");
 ?></td>
<?php } ?>



<?
	$sql  = "SELECT * ";
	$sql .= "FROM factures2021 where client='$last_name' ORDER BY id;";
	$users = db_query($database_name, $sql);


while($users_ = fetch_array($users)) { ?><tr>

<? $client=$users_["client"];$id=$users_["id"];$f=$users_["numero"];$d=$users_["date_f"];?>

<?php $evaluation=$users_["evaluation"]; $client=$users_["client"];$user_id=$users_["id"];$facture=$users_["id"]+0;

$exercice=$users_["exercice"];
if ($user_id<10){$zero="000";}
if ($user_id>=10 and $user_id<100){$zero="00";}
if ($user_id>=100 and $user_id<1000){$zero="0";}
if ($user_id>=1000 and $user_id<10000){$zero="";}
$facture=$users_["id"]+0;$exercice=$users_["exercice"];$facture1=$zero.$facture."/".$exercice;

$client=$users_["client"];$m=$users_["montant"];$user_id=$users_["id"];
echo "<td>$facture1</td>";?>
<td><?php $date=dateUsToFr($users_["date_f"]);$d=dateUsToFr($users_["date_f"]);print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$d </font>"); ?></td>
<td><?php $c=$users_["client"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$c </font>"); ?> </td>
<?php $evaluation=$users_["evaluation"]; $client=$users_["client"];?>
<td align="right" width="150"><?php $ca=$ca+$users_["montant"];$m=number_format($users_["montant"],2,',',' ');
print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$m </font>");
 ?></td>
<?php } ?>


<?
	$sql  = "SELECT * ";
	$sql .= "FROM factures2022 where client='$last_name' ORDER BY id;";
	$users = db_query($database_name, $sql);


while($users_ = fetch_array($users)) { ?><tr>

<? $client=$users_["client"];$id=$users_["id"];$f=$users_["numero"];$d=$users_["date_f"];?>

<?php $evaluation=$users_["evaluation"]; $client=$users_["client"];$user_id=$users_["id"];$facture=$users_["id"]+0;

$exercice=$users_["exercice"];
if ($user_id<10){$zero="000";}
if ($user_id>=10 and $user_id<100){$zero="00";}
if ($user_id>=100 and $user_id<1000){$zero="0";}
if ($user_id>=1000 and $user_id<10000){$zero="";}
$facture=$users_["id"]+0;$exercice=$users_["exercice"];$facture1=$zero.$facture."/".$exercice;

$client=$users_["client"];$m=$users_["montant"];$user_id=$users_["id"];
echo "<td>$facture1</td>";?>
<td><?php $date=dateUsToFr($users_["date_f"]);$d=dateUsToFr($users_["date_f"]);print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$d </font>"); ?></td>
<td><?php $c=$users_["client"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$c </font>"); ?> </td>
<?php $evaluation=$users_["evaluation"]; $client=$users_["client"];?>
<td align="right" width="150"><?php $ca=$ca+$users_["montant"];$m=number_format($users_["montant"],2,',',' ');
print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$m </font>");
 ?></td>
<?php } ?>


<?
	$sql  = "SELECT * ";
	$sql .= "FROM factures2023 where client='$last_name' ORDER BY id;";
	$users = db_query($database_name, $sql);


while($users_ = fetch_array($users)) { ?><tr>

<? $client=$users_["client"];$id=$users_["id"];$f=$users_["numero"];$d=$users_["date_f"];?>

<?php $evaluation=$users_["evaluation"]; $client=$users_["client"];$user_id=$users_["id"];$facture=$users_["id"]+0;

$exercice=$users_["exercice"];
if ($user_id<10){$zero="000";}
if ($user_id>=10 and $user_id<100){$zero="00";}
if ($user_id>=100 and $user_id<1000){$zero="0";}
if ($user_id>=1000 and $user_id<10000){$zero="";}
$facture=$users_["id"]+0;$exercice=$users_["exercice"];$facture1=$zero.$facture."/".$exercice;

$client=$users_["client"];$m=$users_["montant"];$user_id=$users_["id"];
echo "<td>$facture1</td>";?>
<td><?php $date=dateUsToFr($users_["date_f"]);$d=dateUsToFr($users_["date_f"]);print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$d </font>"); ?></td>
<td><?php $c=$users_["client"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$c </font>"); ?> </td>
<?php $evaluation=$users_["evaluation"]; $client=$users_["client"];?>
<td align="right" width="150"><?php $ca=$ca+$users_["montant"];$m=number_format($users_["montant"],2,',',' ');
print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$m </font>");
 ?></td>
<?php } ?>


<tr><td></td><td></td><td></td>
<td align="right"><?php $ca=number_format($ca,2,',',' '); print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$ca </font>");?></td></tr>
</table>

</body>

</html>