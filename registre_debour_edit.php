<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_name=GetUserName();
	$user_id = $_REQUEST["user_id"];$edition=date("d/m/Y");
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
		$frais_monuments=$user_["frais_monuments"];$frais_guide=$user_["frais_guide"];$frais_divers=$user_["frais_divers"];$frais_guide_local=$user_["frais_guide_local"];
	}
						$sql  = "SELECT * FROM rs_data_produits where last_name='$service' ;";
						$user = db_query($database_name, $sql); $user_ = fetch_array($user);
						$type_s=$user_["profile_id"];$tarif_monuments=$user_["tarif_monuments"];$monuments=$user_["monuments"];
						$tarif_guide_extra=$user_["tarif_guide_extra"];$tarif_guide_local=$user_["tarif_guide_local"];$divers=$user_["divers"];

$pax=0;$pax1=0;
if ($type_s==3){

	$sql  = "SELECT * ";
	$sql .= "FROM details_bookings_excursions_rak where id_registre=$id_registre ORDER BY id;";
	$users = db_query($database_name, $sql);


$pax=0;while($users1_ = fetch_array($users)) { 
$pax=$pax+$users1_["adultes"];$pax1=$pax1+$users1_["enfants"];
}
}

if ($type_s==1){

	$sql  = "SELECT * ";
	$sql .= "FROM details_bookings_sejours_rak where id_registre=$id_registre and hpl=1 ORDER BY id;";
	$users = db_query($database_name, $sql);


$pax=0;while($users1_ = fetch_array($users)) { 
$pax=$pax+$users1_["adultes"];$pax1=$pax1+$users1_["enfants"];
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

<?

if($user_id == "0") { ?>

<table bordercolor="#FFFFFF" class="table2">
  <tr><td style="text-align:center">

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
		<tr><td><?php echo "Nbre Pax	:";?></td><td><? echo $pax; ?></td></tr>
		<tr><td><?php echo "Observations:"; ?></td><td><input type="text" id="observation" name="observation" style="width:250px" value="<?php echo $observation; ?>"></td></tr>
		<tr><td><input type="hidden" id="motif_cancel" name="motif_cancel" style="width:250px" value="<?php echo $motif_cancel; ?>"></td></tr>
<tr><td><? echo "Monuments : ";?></td><td align="left"><? echo $monuments;?></td></tr>
<tr><td><? echo "Tarif Monuments : "."Total Pax : ".$pax."  X  ".$tarif_monuments." = ";?></td>
<? $frais_monuments=$pax*$tarif_monuments;$frais_monuments1=$pax*$tarif_monuments;?>
<td align="center"><input type="text" id="frais_monuments" name="frais_monuments" style="width:250px" value="<?php echo $frais_monuments; ?>"></td></tr>
<? $frais_guide=$tarif_guide_extra*$mode;$frais_guide1=$tarif_guide_extra*$mode;?>
<tr><td align="left"><? echo "Guide Extra : ".$guide;?></td><td align="center"><input type="text" id="frais_guide" name="frais_guide" style="width:250px" value="<?php echo $frais_guide; ?>"></td></tr>
<tr><td align="left"><? $frais_divers="";echo "Frais Divers : ";?></td><td align="center"><input type="text" id="frais_divers" name="frais_divers" style="width:250px" value="<?php echo $frais_divers; ?>"></td></tr>

</td></tr></table>
<? }
else
{ ?>
<table>
<TR><td><span class="Style2"><? print("<font size=\"4\" face=\"Comic sans MS\" color=\"000033\">Major Travel Service</font>") ; ?></span></td></tr>
<TR><td><span class="Style2"><? print("<font size=\"4\" face=\"Comic sans MS\" color=\"000033\">  Agence marrakech  </font>") ; ?>  </span></td>
</TR></table>
<table class="table2">

  <tr><td align="center"><?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"000033\">Pièce de Caisse N° : </font>") ; ?></td>
	<td align="center"><?php $p=$user_id+10000;print("<font size=\"3\" face=\"Comic sans MS\" color=\"000033\">$p</font>") ; ?></td>
		</tr>
		<tr><td></td><td></td></tr>
		<tr><td></td><td></td></tr>
		<tr><td bordercolor="#FFFFFF"><?php echo "LP N° :"; ?></td><td bordercolor="#FFFFFF"><?php echo $id_registre1+200000; ?></td>
		</tr>
		<tr>
		<td bordercolor="#FFFFFF"><?php echo "Date	:"; ?></td><td bordercolor="#FFFFFF"><?php echo $date; ?>
		</tr>
		<tr><td bordercolor="#FFFFFF"><?php echo "Service	:";?></td><td bordercolor="#FFFFFF"><? echo $service; ?></td>
		</tr>
		<tr><td bordercolor="#FFFFFF"><?php echo "Nbre Pax	:";?></td><td bordercolor="#FFFFFF"><? echo $pax." Adt"." - ".$pax1." Enf"; ?></td>
		</tr>
		<td bordercolor="#FFFFFF">
		<?php echo "Client		:"; ?></td><td bordercolor="#FFFFFF"><?php echo $client; ?></td>
		</tr>
		<tr><td bordercolor="#FFFFFF"><?php echo "Observations:"; ?></td><td bordercolor="#FFFFFF"><?php echo $observation; ?></td>
		</tr>
		<tr><td bordercolor="#FFFFFF"><? echo "Monuments : ";?></td><td align="left" bordercolor="#FFFFFF"><? echo $monuments;?></td>
		</tr>
		<tr><td bordercolor="#FFFFFF"><? echo "Frais Monuments : ";?></td><td align="right" bordercolor="#FFFFFF"><? echo number_format($frais_monuments,2,',',' ');?></td>
		<tr><td bordercolor="#FFFFFF" width="350"><? echo "Frais Guide Extra : ".$guide;?></td><td align="right" bordercolor="#FFFFFF"><? echo number_format($frais_guide,2,',',' ');?></td>
		<tr><td bordercolor="#FFFFFF" width="350"><? echo "Frais Guide Local : ";?></td><td align="right" bordercolor="#FFFFFF"><? echo number_format($frais_guide_local,2,',',' ');?></td>
		<tr><td bordercolor="#FFFFFF"><? echo "Frais Divers : ";?></td><td align="right" bordercolor="#FFFFFF"><? echo number_format($frais_divers,2,',',' ');?></td>
		<tr><td bordercolor="#FFFFFF"></td><td bordercolor="#FFFFFF"></td>
		</tr>
		<tr><td></td><td></td></tr><? $frais_total=$frais_monuments+$frais_guide+$frais_divers+$frais_guide_local;?>
		<tr><td><? echo "Emetteur : ".$user_open."-".$edition;?></td><td align="right"><? echo "Total : ".number_format($frais_total,2,',',' ');?></td>
		</table>
<? } ?>

</body>

</html>