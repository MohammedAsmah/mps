<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_name=GetUserName();
	$user_id = $_REQUEST["user_id"];
	if($user_id == "0") {

	$id_registre=$_GET['id_registre'];	$date=$_GET['date'];	$client=$_GET['client'];	$service=$_GET['service'];
	$id_registre1=$_GET['id_registre'];	$date1=$_GET['date'];	$client1=$_GET['client'];	$service1=$_GET['service'];
	$duree=$_GET['duree'];$code=$_GET['code'];$date_p=$_GET['date'];$date_p1=$_GET['date'];
	$type_voucher="debours";
		$action_ = "insert_new_user";

		$title = "Nouveau voucher";

		$type_service = "";
		$statut = "en cours";
		$user_open = $user_name;
		$date_open = "";
		$observation="";
		$motif_cancel="";$fournisseur="";
		$code_produit="";
	
	} else {

		$action_ = "update_user";
		$action1_ = "update_detail";
		$date_p=$_GET['date_p'];$date_p1=$_GET['date_p1'];
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM registre_debours_rak WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "";
		$id_registre = $user_["lp"];
		$date=dateUsToFr($user_["date"]);
		$service = $user_["service"];
		$client = $user_["client"];
		$statut = $user_["statut"];
		$user_open = $user_["user_open"];
		$date_open = $user_["date_open"];
		$observation=$user_["observation"];
		$type_service="SEJOURS ET CIRCUITS";
		$motif_cancel=$user_["motif_cancel"];
		$fournisseur=$user_["fournisseur"];
		$type_voucher=$user_["type_voucher"];
		$date1=$user_["date"];
		$service1 = $user_["service"];
		$client1 = $user_["client"];
		$id_registre1=$user_["lp"];
		$code_produit=$user_["code_produit"];
		$frais_monuments=$user_["frais_monuments"];$frais_guide=$user_["frais_guide"];$frais_divers=$user_["frais_divers"];
		$frais_guide_local=$user_["frais_guide_local"];
	}
						$sql  = "SELECT * FROM rs_data_produits where last_name='$service' ;";
						$user = db_query($database_name, $sql); $user_ = fetch_array($user);
						$type_s=$user_["profile_id"];$tarif_monuments=$user_["tarif_monuments"];$monuments=$user_["monuments"];
						$tarif_guide_extra=$user_["tarif_guide_extra"];$tarif_guide_local=$user_["tarif_guide_local"];$divers=$user_["divers"];
$pax=0;

if ($type_s==3){

	$sql  = "SELECT * ";
	$sql .= "FROM details_bookings_excursions_rak where id_registre=$id_registre ORDER BY id;";
	$users = db_query($database_name, $sql);


$pax=0;while($users1_ = fetch_array($users)) { 
$pax=$pax+$users1_["adultes"];
}
}

if ($type_s==1){

	$sql  = "SELECT * ";
	$sql .= "FROM details_bookings_sejours_rak where id_registre=$id_registre and hpl=1 ORDER BY id;";
	$users = db_query($database_name, $sql);


$pax=0;while($users1_ = fetch_array($users)) { 
$pax=$pax+$users1_["adultes"];
}
}

	$sql  = "SELECT * ";
	$sql .= "FROM registre_lp_rak where id='$id_registre' ORDER BY id;";
	$users = db_query($database_name, $sql);$user_ = fetch_array($users);
	$guide=$user_["guide"];
	
	$sql  = "SELECT * ";$mode=0;
	$sql .= "FROM rs_data_guides where last_name='$guide' ORDER BY last_name;";
	$users = db_query($database_name, $sql);$user_ = fetch_array($users);$mode1=$user_["type"];
	if ($mode1=="Extra"){$mode=1;}else{$mode=0;}
	
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
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression  ?"; ?>")) {
			document.location = "registres_vouchers.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}


--></script>

</head>

<body style="background:#dfe8ff">

<form id="form_user" name="form_user" method="post" action="registres_vouchers.php">

<?

if($user_id == "0") { ?>

<table class="table2"><tr><td style="text-align:center">

		<tr><td><?php echo "LP	:";?></td><td><? echo $id_registre1+200000; ?></td></tr>
		<tr><td><?php echo "Date	:";?></td><td><? echo dateUsToFr($date); ?></td></tr>
		<tr><td><?php echo "Service	:";?></td><td><? echo $service; ?></td></tr>
		<input type="hidden" id="date" name="date" value="<?php echo dateUsToFr($date); ?>">
		<input type="hidden" id="lp" name="lp" value="<?php echo $id_registre1; ?>">
		<tr><td><?php echo "Client		:"; ?></td><td><?php echo $client; ?></td>
		<input type="hidden" id="client" name="client" value="<?php echo $client1; ?>">
		<input type="hidden" id="type_s" name="type_s" value="<?php echo $type_s; ?>">
		<input type="hidden" id="statut" name="statut" value="<?php echo $statut; ?>">
		</tr>
		<tr><td><?php echo "Observations:"; ?></td><td><input type="text" id="observation" name="observation" style="width:250px" value="<?php echo $observation; ?>"></td></tr>
		<tr><td><input type="hidden" id="motif_cancel" name="motif_cancel" style="width:250px" value="<?php echo $motif_cancel; ?>"></td></tr>
<tr><td><? echo "Monuments : ";?></td><td align="left"><? echo $monuments;?></td></tr>
<tr><td><? $t_monuments=$pax*$tarif_monuments;echo "Tarif Monuments : "."Total Pax : ".$pax."  X  ".$tarif_monuments." = ";?></td>
<? $frais_monuments=$pax*$tarif_monuments;$frais_monuments1=$pax*$tarif_monuments;?>
<td align="center"><input type="text" id="frais_monuments" name="frais_monuments" style="width:250px" value="<?php echo $frais_monuments; ?>"></td></tr>
<? $frais_guide=$tarif_guide_extra*$mode;$frais_guide1=$tarif_guide_extra*$mode;?>
<tr><td align="left"><? echo "Guide Extra : ".$guide;?></td><td align="center"><input type="text" id="frais_guide" name="frais_guide" style="width:250px" value="<?php echo $frais_guide; ?>"></td></tr>
<? if ($pax>20){$frais_guide_local=$tarif_guide_local*1;}else{$frais_guide_local=$tarif_guide_local*0;}?>
<tr><td align="left"><? echo "Guide Local : ";?></td><td align="center"><input type="text" id="frais_guide_local" name="frais_guide_local" style="width:250px" value="<?php echo $frais_guide_local; ?>"></td></tr>
<tr><td align="left"><? $frais_divers="";echo "Frais Divers : ";?></td><td align="center"><input type="text" id="frais_divers" name="frais_divers" style="width:250px" value="<?php echo $frais_divers; ?>"></td></tr>

</td></tr></table>
<? }
else
{ ?>
<table class="table2"><tr><td style="text-align:center">

		<tr><td><?php echo "LP N° :"; ?></td><td><?php echo $id_registre1+200000; ?></td></tr>
		<input type="hidden" id="lp" name="lp" value="<?php echo $id_registre1; ?>">
		<tr>
		<td><?php echo "Date	:"; ?></td><td><?php echo $date; ?>
		<input type="hidden" id="date" name="date" value="<?php echo $date; ?>"></td>
		</tr>
		<tr><td><?php echo "Service	:";?></td><td><? echo $service; ?></td></tr>
		<td>
		<?php echo "Client		:"; ?></td><td><?php echo $client; ?></td>
		<input type="hidden" id="client" name="client" value="<?php echo $client; ?>">
		</tr>
		
		<tr><td><?php echo "Piece N° :"; ?></td><td><?php echo $user_id+10000; ?></td></tr>
		<tr><td>
		<?php echo "Statut		:"; ?></td><td><input type="text" id="statut" name="statut" style="width:250px" value="<?php echo $statut; ?>"></td>
		<td>
		<?php echo "Observations:"; ?></td><td><input type="text" id="observation" name="observation" style="width:250px" value="<?php echo $observation; ?>"></td>
		</tr>
		
		<tr><td><?php echo "Motif Annulation:"; ?></td><td><input type="text" id="motif_cancel" name="motif_cancel" style="width:250px" value="<?php echo $motif_cancel; ?>"></td>
		</tr>
<tr><td><? echo "Monuments : ";?></td><td align="left"><? echo $monuments;?></td></tr>
<tr><td><? echo "Tarif Monuments : "."Total Pax : ".$pax."  X  ".$tarif_monuments." = ";?></td>
<td align="right"><input type="text" id="frais_monuments" name="frais_monuments" style="width:250px" value="<?php echo $frais_monuments; ?>"></td></tr>
<tr><td><? echo "Guide Extra : ".$guide;?></td><td align="center"><input type="text" id="frais_guide" name="frais_guide" style="width:250px" value="<?php echo $frais_guide; ?>"></td></tr>
<tr><td align="left"><? echo "Guide Local : ";?></td><td align="center"><input type="text" id="frais_guide_local" name="frais_guide_local" style="width:250px" value="<?php echo $frais_guide_local; ?>"></td></tr>
<tr><td><? echo "Frais Divers : ";?></td><td align="center"><input type="text" id="frais_divers" name="frais_divers" style="width:250px" value="<?php echo $frais_divers; ?>"></td></tr>
</td></tr></table>
<? } ?>



<center>
<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="date_p" name="date_p" value="<?php echo dateFrToUs($date); ?>">
<input type="hidden" id="date_p1" name="date_p1" value="<?php echo dateFrToUs($date); ?>">
<input type="hidden" id="date1" name="date1" value="<?php echo dateFrToUs($date); ?>">
<input type="hidden" id="user_open" name="user_open" value="<?php echo $user_open; ?>">
<input type="hidden" id="date_open" name="date_open" value="<?php echo $date_open; ?>">
<input type="hidden" id="id_registre" name="id_registre" value="<?php echo $id_registre; ?>">
<input type="hidden" id="id_registre" name="id_registre" value="<?php echo $id_registre; ?>">
<input type="hidden" id="guide" name="guide" value="<?php echo $guide; ?>">
<input type="hidden" id="id_registre1" name="id_registre1" value="<?php echo $id_registre1; ?>">
<input type="hidden" id="client1" name="client1" value="<?php echo $client1; ?>">
<input type="hidden" id="service" name="service" value="<?php echo $service; ?>">
<input type="hidden" id="service1" name="service1" value="<?php echo $service; ?>">
<input type="hidden" id="fournisseur" name="fournisseur" value="<?php echo $guide; ?>">
<input type="hidden" id="type_voucher" name="type_voucher" value="<?php echo $type_voucher; ?>">
<input type="hidden" id="code" name="code" value="<?php echo $code_produit; ?>">
<input type="hidden" id="duree" name="duree" value="<?php echo $duree; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">


  <table class="table3"><tr>

<?php if($user_id != "0") { ?>
<td><button type="button" onClick="CheckUser()"><?php echo Translate("Update"); ?></button></td>
<td style="width:20px"></td>
<?php } else { ?>
<td><button type="button"  onClick="CheckUser()"><?php echo Translate("OK"); ?></button></td>
<?php 
} ?>
</tr></table>
</center>

</form>

</body>

</html>