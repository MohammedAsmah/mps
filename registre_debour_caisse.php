<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_name=GetUserName();
	$user_id = $_REQUEST["user_id"];$date1=$_GET["date1"];$date2=$_GET["date2"];$paye=$_GET["paye"];
		$action_ = "update_user";
		$action1_ = "update_detail";
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM registre_debours_rak WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$lp = $user_["lp"];
		$date=dateUsToFr($user_["date"]);
		$service = $user_["service"];
		$client = $user_["client"];
		$statut = $user_["statut"];
		$user_open = $user_["user_open"];
		$date_open = $user_["date_open"];
		$observation=$user_["observation"];
		$motif_cancel=$user_["motif_cancel"];
		$fournisseur=$user_["fournisseur"];$guide=$user_["fournisseur"];
		$frais_monuments=$user_["frais_monuments"];$frais_guide=$user_["frais_guide"];$frais_divers=$user_["frais_divers"];
		$frais_guide_local=$user_["frais_guide_local"];
		$monuments=$user_["frais_monuments"];$extra=$user_["frais_guide"];$divers=$user_["frais_divers"];
		$local=$user_["frais_guide_local"];
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

<form id="form_user" name="form_user" method="post" action="pieces_debours_par_guide.php">

<table class="table2"><tr><td style="text-align:center">

		<tr><td><?php echo "LP N° :"; ?></td><td><?php echo $lp+200000; ?></td></tr>
		<tr>
		<td><?php echo "Date	:"; ?></td><td><?php echo $date; ?>
		</tr>
		<tr><td><?php echo "Service	:";?></td><td><? echo $service; ?></td></tr>
		<td>
		<?php echo "Client		:"; ?></td><td><?php echo $client; ?></td>
		</tr>
		<tr><td><?php $piece=$user_id;$libelle=$fournisseur;echo "Piece N° :"; ?></td><td><?php echo $user_id+10000; ?></td></tr>
		<tr><td><?php echo "Statut		:"; ?></td><td><?php echo $statut; ?></td></tr>
		<tr><td><?php echo "Observations:"; ?></td><td><?php echo $observation; ?></td></tr>
		<tr><td><?php echo "Motif Annulation:"; ?></td><?php echo $motif_cancel; ?></td></tr>
		<tr><td><? echo "Frais Monuments = ";?></td>
		<td><input type="text" id="monuments" name="monuments" value="<?php echo $monuments; ?>"></td>
		<tr><td><? echo "Guide Extra : ".$fournisseur." = ";?></td>
		<td><input type="text" id="extra" name="extra" value="<?php echo $extra; ?>"></td>
		<tr><td><? echo "Guide Local : "." = ";?></td>
		<td><input type="text" id="local" name="local" value="<?php echo $local; ?>"></td>
		<tr><td><? echo "Frais Divers : "." = ";?></td>
		<td><input type="text" id="divers" name="divers" value="<?php echo $divers; ?>"></td>
		<tr><td bgcolor="#FF0000"><? echo "Total Pièce : "." = ";?></td><td><? echo number_format($frais_divers+$frais_monuments+$frais_guide+$frais_guide_local,2,',',' ');?></td>
		<? if ($paye==0){?>
		<? $frais=$frais_divers+$frais_monuments+$frais_guide+$frais_guide_local;
		$frais_paye=$frais_divers+$frais_monuments+$frais_guide+$frais_guide_local;
		 }?>
		
</td></tr></table>


<center>
<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="guide" name="guide" value="<?php echo $guide; ?>">
<input type="hidden" id="frais_paye" name="frais_paye" value="<?php echo $frais_paye; ?>">
<input type="hidden" id="libelle" name="libelle" value="<?php echo $libelle; ?>">
<input type="hidden" id="ref" name="ref" value="<?php echo $piece; ?>">
<input type="hidden" id="lp" name="lp" value="<?php echo $lp; ?>">
<input type="hidden" id="date_lp" name="date_lp" value="<?php echo dateFrToUs($date); ?>">
<input type="hidden" id="service" name="service" value="<?php echo $service; ?>">
<input type="hidden" id="client" name="client" value="<?php echo $client; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">
<input type="hidden" id="date1" name="date1" value="<?php echo $date1; ?>">
<input type="hidden" id="date2" name="date2" value="<?php echo $date2; ?>">

  <table class="table3"><tr>
<? if ($paye==0){?>
<?php if($user_id != "0") { ?>
<td><button type="button" onClick="CheckUser()"><?php echo "Valider"; ?></button></td>
<td style="width:20px"></td>
<?php } else { ?>
<td><button type="button"  onClick="CheckUser()"><?php echo Translate("OK"); ?></button></td>
<?php 
} ?>
<? }else {?>
<td><? echo "Piece déja payée consulter Folio!!";?></td><? }?>

</tr></table>
</center>

</form>

</body>

</html>