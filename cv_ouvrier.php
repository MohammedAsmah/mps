<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];

	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "Nouveau Client";

		$ref = "";$service="";
		$employe = "";$statut=0;$poste="";
		$t_h_100="";$t_h_normales="";$t_h_25="";$t_h_50="";$manual=0;
		
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM employes WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";$date_j=date("y-m-d");$date_limite="2009-06-01";$message_c="";
		$date_cin = $user_["date_cin"];if ($date_cin<$date_j){$message=0;$message_c="<br>carte nationale expirée";}
		$adresse_cr = $user_["adresse_cr"];$date_cr = $user_["date_cr"];$date_entree = dateUsToFr($user_["date_entree"]);
		if ($adresse_cr=="" or $date_cr<$date_limite){$message=0;$message_c=$message_c."<br>pas de certificat residence";}

		$ref = $user_["ref"];$service = $user_["service"];$observations = $user_["observations"];$ordre=$user_["ordre"];
		$employe = $user_["employe"];$statut=$user_["statut"];$poste=$user_["poste"];$photo=$user_["photo"];
				
		$machine=$user_["machine"];
		$laveuse=$user_["laveuse"];
		$extrudeuse=$user_["extrudeuse"];
		$broyeur=$user_["broyeur"];
		$melange=$user_["melange"];
		$services=$user_["services"];
		$chargement=$user_["chargement"];
		$emballage=$user_["emballage"];
		$autres=$user_["autres"];		
		
		
		
		}
	$profiles_list_s = "";
	$sql43 = "SELECT * FROM rs_data_services ORDER BY service;";
	$temp = db_query($database_name, $sql43);
	while($temp_ = fetch_array($temp)) {
		if($service == $temp_["service"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_s .= "<OPTION VALUE=\"" . $temp_["service"] . "\"" . $selected . ">";
		$profiles_list_s .= $temp_["service"];
		$profiles_list_s .= "</OPTION>";
	}
$profiles_list_poste = "";
	$sql43 = "SELECT * FROM rs_data_postes ORDER BY poste;";
	$temp = db_query($database_name, $sql43);
	while($temp_ = fetch_array($temp)) {
		if($poste == $temp_["poste"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_poste .= "<OPTION VALUE=\"" . $temp_["poste"] . "\"" . $selected . ">";
		$profiles_list_poste .= $temp_["poste"];
		$profiles_list_poste .= "</OPTION>";
	}
	
	$profiles_list_motif_sam = "";
	$sql43 = "SELECT * FROM rs_data_motifs ORDER BY poste;";
	$temp = db_query($database_name, $sql43);
	while($temp_ = fetch_array($temp)) {
		if($motif_sam == $temp_["poste"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_motif_sam .= "<OPTION VALUE=\"" . $temp_["poste"] . "\"" . $selected . ">";
		$profiles_list_motif_sam .= $temp_["poste"];
		$profiles_list_motif_sam .= "</OPTION>";
	}
	
	$profiles_list_motif_dim = "";
	$sql43 = "SELECT * FROM rs_data_motifs ORDER BY poste;";
	$temp = db_query($database_name, $sql43);
	while($temp_ = fetch_array($temp)) {
		if($motif_dim == $temp_["poste"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_motif_dim .= "<OPTION VALUE=\"" . $temp_["poste"] . "\"" . $selected . ">";
		$profiles_list_motif_dim .= $temp_["poste"];
		$profiles_list_motif_dim .= "</OPTION>";
	}
	$profiles_list_motif_lun = "";
	$sql43 = "SELECT * FROM rs_data_motifs ORDER BY poste;";
	$temp = db_query($database_name, $sql43);
	while($temp_ = fetch_array($temp)) {
		if($motif_lun == $temp_["poste"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_motif_lun .= "<OPTION VALUE=\"" . $temp_["poste"] . "\"" . $selected . ">";
		$profiles_list_motif_lun .= $temp_["poste"];
		$profiles_list_motif_lun .= "</OPTION>";
	}
	$profiles_list_motif_mar = "";
	$sql43 = "SELECT * FROM rs_data_motifs ORDER BY poste;";
	$temp = db_query($database_name, $sql43);
	while($temp_ = fetch_array($temp)) {
		if($motif_mar == $temp_["poste"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_motif_mar .= "<OPTION VALUE=\"" . $temp_["poste"] . "\"" . $selected . ">";
		$profiles_list_motif_mar .= $temp_["poste"];
		$profiles_list_motif_mar .= "</OPTION>";
	}
	$profiles_list_motif_mer = "";
	$sql43 = "SELECT * FROM rs_data_motifs ORDER BY poste;";
	$temp = db_query($database_name, $sql43);
	while($temp_ = fetch_array($temp)) {
		if($motif_mer == $temp_["poste"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_motif_mer .= "<OPTION VALUE=\"" . $temp_["poste"] . "\"" . $selected . ">";
		$profiles_list_motif_mer .= $temp_["poste"];
		$profiles_list_motif_mer .= "</OPTION>";
	}
	$profiles_list_motif_jeu = "";
	$sql43 = "SELECT * FROM rs_data_motifs ORDER BY poste;";
	$temp = db_query($database_name, $sql43);
	while($temp_ = fetch_array($temp)) {
		if($motif_jeu == $temp_["poste"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_motif_jeu .= "<OPTION VALUE=\"" . $temp_["poste"] . "\"" . $selected . ">";
		$profiles_list_motif_jeu .= $temp_["poste"];
		$profiles_list_motif_jeu .= "</OPTION>";
	}
	$profiles_list_motif_ven = "";
	$sql43 = "SELECT * FROM rs_data_motifs ORDER BY poste;";
	$temp = db_query($database_name, $sql43);
	while($temp_ = fetch_array($temp)) {
		if($motif_ven == $temp_["poste"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_motif_ven .= "<OPTION VALUE=\"" . $temp_["poste"] . "\"" . $selected . ">";
		$profiles_list_motif_ven .= $temp_["poste"];
		$profiles_list_motif_ven .= "</OPTION>";
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
		if(document.getElementById("employe").value == 0 ) {
			alert("<?php echo $message_c ; ?>");
			UpdateUser();
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression ?"; ?>")) {
			document.location = "cv_ouvriers.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}


--></script>

</head>

<body style="background:#dfe8ff">


<form id="form_user" name="form_user" method="post" action="cv_ouvriers.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table class="table3">
				
		
		<tr>
		<td><?php echo "Nom et Prénom : "; ?></td><td><?php echo $employe; ?></td>
		<tr>
		<td><?php echo "Date Entree : ";?></td><td><?php echo $date_entree;?></td>
		<tr>
		<td><?php print("<img src=\"./photos/$photo\" alt=\"$employe\" border=\"0\">");?></td>
		</tr>
	
		<table>
		<tr><th></th><th><?php echo "Machine";?></th>
	<th><?php echo "Laveuse";?></th>
	<th><?php echo "Extrudeuse";?></th>
	<th><?php echo "Broyeur";?></th>
	<th><?php echo "Mélange";?></th>
	<th><?php echo "Services";?></th>
	<th><?php echo "Chargement";?></th>	
	<th><?php echo "Emballage";?></th>	
	<th><?php echo "Autres";?></th>	</tr>	
		
			
		<tr><td><? echo "Taches	: "?></td>
		<td><input type="checkbox" id="machine" name="machine"<?php if($machine) { echo " checked"; } ?>></td>
		<td><input type="checkbox" id="laveuse" name="laveuse"<?php if($laveuse) { echo " checked"; } ?>></td>
		<td><input type="checkbox" id="extrudeuse" name="extrudeuse"<?php if($extrudeuse) { echo " checked"; } ?>></td>
		<td><input type="checkbox" id="broyeur" name="broyeur"<?php if($broyeur) { echo " checked"; } ?>></td>
		<td><input type="checkbox" id="melange" name="melange"<?php if($melange) { echo " checked"; } ?>></td>
		<td><input type="checkbox" id="services" name="services"<?php if($services) { echo " checked"; } ?>></td>
		<td><input type="checkbox" id="chargement" name="chargement"<?php if($chargement) { echo " checked"; } ?>></td>
		<td><input type="checkbox" id="emballage" name="emballage"<?php if($emballage) { echo " checked"; } ?>></td>
		<td><input type="text" id="autres" name="autres"<?php echo $autres; ?>></td>
		
		

		</table>
		
		
		<? 
		
		
		
			
		?>
		
		</table>
		

<p style="text-align:center">

<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">
<input type="hidden" id="t_h_25" name="t_h_25" value="<?php echo $t_h_s_25; ?>">
<input type="hidden" id="t_h_50" name="t_h_50" value="<?php echo $t_h_s_50; ?>">
<input type="hidden" id="t_h_normales" name="t_h_normales" value="<?php echo $hn; ?>">
<input type="hidden" id="message" name="message" value="<?php echo $message; ?>">
<input type="hidden" id="ref" name="ref" value="<?php echo $ref; ?>">
<input type="hidden" id="employe" name="employe" value="<?php echo $employe; ?>">
<input type="hidden" id="poste" name="poste" value="<?php echo $poste; ?>">

<table class="table3"><tr>

<?php if($user_id != "0") { ?>
<td><button type="button" onClick="CheckUser()"><?php echo Translate("Update"); ?></button></td>
<td style="width:20px"></td>
<td><button type="button" onClick="DeleteUser()"><?php echo Translate("Delete"); ?></button></td>
<?php } else { ?>
<td><button type="button"  onClick="CheckUser()"><?php echo Translate("OK"); ?></button></td>
<?php 
} ?>
</tr></table>

<?
		function date_to_timestamp ($date) {
    return preg_match('/^\s*(\d\d\d\d)-(\d\d)-(\d\d)\s*(\d\d):(\d\d):(\d\d)/', $date, $m)
           ?  mktime($m[4], $m[5], $m[6], $m[2], $m[3], $m[1])
           : 0;
}





?>



</center>

</form>

</body>

</html>
