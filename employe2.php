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
		$employe = $user_["employe"];$statut=$user_["statut"];$poste=$user_["poste"];
		$t_h_normales=$user_["t_h_normales"];$t_h_25=$user_["t_h_25"];$t_h_50=$user_["t_h_50"];
		$t_h_100=$user_["t_h_100"];$manual=$user_["manual"];$valide=$user_["valide"];
		$sam_s=$user_["sam_s"];$dim_s=$user_["dim_s"];$lun_s=$user_["lun_s"];$mar_s=$user_["mar_s"];
		$mer_s=$user_["mer_s"];$jeu_s=$user_["jeu_s"];$ven_s=$user_["ven_s"];
		$sam_m=$user_["sam_m"];$dim_m=$user_["dim_m"];$lun_m=$user_["lun_m"];$mar_m=$user_["mar_m"];
		$mer_m=$user_["mer_m"];$jeu_m=$user_["jeu_m"];$ven_m=$user_["ven_m"];
		$sam_sup=$user_["sam_sup"];$dim_sup=$user_["dim_sup"];$lun_sup=$user_["lun_sup"];$mar_sup=$user_["mar_sup"];
		$mer_sup=$user_["mer_sup"];$jeu_sup=$user_["jeu_sup"];$ven_sup=$user_["ven_sup"];$heures=$user_["heures"];
		if ($sam_m==0){$sam_m="";}if ($dim_m==0){$dim_m="";}if ($lun_m==0){$lun_m="";}
		if ($mar_m==0){$mar_m="";}if ($mer_m==0){$mer_m="";}if ($jeu_m==0){$jeu_m="";}if ($ven_m==0){$ven_m="";}
		if ($sam_s==0){$sam_s="";}if ($dim_s==0){$dim_s="";}if ($lun_s==0){$lun_s="";}
		if ($mar_s==0){$mar_s="";}if ($mer_s==0){$mer_s="";}if ($jeu_s==0){$jeu_s="";}if ($ven_s==0){$ven_s="";}
		if ($sam_sup==0){$sam_sup="";}if ($dim_sup==0){$dim_sup="";}if ($lun_sup==0){$lun_sup="";}
		if ($mar_sup==0){$mar_sup="";}if ($mer_sup==0){$mer_sup="";}if ($jeu_sup==0){$jeu_sup="";}if ($ven_sup==0){$ven_sup="";}
		
		$valide_sam=$user_["valide_sam"];$motif_sam=$user_["motif_sam"];
		$valide_dim=$user_["valide_dim"];$motif_dim=$user_["motif_dim"];
		$valide_lun=$user_["valide_lun"];$motif_mar=$user_["motif_mar"];
		$valide_mar=$user_["valide_mar"];$motif_mer=$user_["motif_mer"];
		$valide_mer=$user_["valide_mer"];$motif_jeu=$user_["motif_jeu"];
		$valide_jeu=$user_["valide_jeu"];$motif_ven=$user_["motif_ven"];
		$valide_ven=$user_["valide_ven"];$motif_lun=$user_["motif_lun"];
		
		$ferier_sam=$user_["ferier_sam"];
		$ferier_dim=$user_["ferier_dim"];
		$ferier_lun=$user_["ferier_lun"];
		$ferier_mar=$user_["ferier_mar"];
		$ferier_mer=$user_["ferier_mer"];
		$ferier_jeu=$user_["ferier_jeu"];
		$ferier_ven=$user_["ferier_ven"];
		
			if($ferier_sam==1) { $ferier_sam = 1; $sam_m_f=$sam_m;$sam_m1=0;$sam_s_f=$sam_s;$sam_s1=0;} else { $ferier_sam = 0; }
			if($ferier_dim==1) { $ferier_dim = 1; $dim_m_f=$dim_m;$dim_m1=0;$dim_s_f=$dim_s;$dim_s1=0;} else { $ferier_dim = 0; }
			if($ferier_lun==1) { $ferier_lun = 1; $lun_m_f=$lun_m;$lun_m1=0;$lun_s_f=$lun_s;$lun_s1=0;} else { $ferier_lun = 0; }
			if($ferier_mar==1) { $ferier_mar = 1; $mar_m_f=$mar_m;$mar_m1=0;$mar_s_f=$mar_s;$mar_s1=0;} else { $ferier_mar = 0; }
			if($ferier_mer==1) { $ferier_mer = 1; $mer_m_f=$mer_m;$mer_m1=0;$mer_s_f=$mer_s;$mer_s1=0;} else { $ferier_mer = 0; }
			if($ferier_jeu==1) { $ferier_jeu = 1; $jeu_m_f=$jeu_m;$jeu_m1=0;$jeu_s_f=$jeu_s;$jeu_s1=0;} else { $ferier_jeu = 0; }
			if($ferier_ven==1) { $ferier_ven = 1; $ven_m_f=$ven_m;$ven_m1=0;$ven_s_f=$ven_s;$ven_s1=0;} else { $ferier_ven = 0; }
		
		
		
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
			document.location = "maj_pointage2.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}


--></script>

</head>

<body style="background:#dfe8ff">


<form id="form_user" name="form_user" method="post" action="maj_pointage2.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table class="table3">
				
		
		<tr>
		<td bgcolor="#66CCCC"><?php echo "Nom Employe : "; ?></td><td bgcolor="#66CCCC"><?php echo $employe."  Entree : ".$date_entree; ?></td>
		<td><input type="text" id="ordre" name="ordre" style="width:40px" value="<?php echo $ordre; ?>"></td>
		</tr>
	
		<table>
		<tr><td></td><td align "center"><? echo " Sam "?></td>
		<td align "center"><? echo " Dim "?></td>
		<td align "center"><? echo " Lun "?></td>
		<td align "center"><? echo " Mar "?></td>
		<td align "center"><? echo " Mer "?></td>
		<td align "center"><? echo " Jeu "?></td>
		<td align "center"><? echo " Ven "?></td></tr>
		
		<tr><td><? echo "Matin : "?></td>
		<td><input type="text" id="sam_m" name="sam_m" style="width:40px" value="<?php echo $sam_m; ?>"></td>
		<td><input type="text" id="dim_m" name="dim_m" style="width:40px" value="<?php echo $dim_m; ?>"></td>
		<td><input type="text" id="lun_m" name="lun_m" style="width:40px" value="<?php echo $lun_m; ?>"></td>
		<td><input type="text" id="mar_m" name="mar_m" style="width:40px" value="<?php echo $mar_m; ?>"></td>
		<td><input type="text" id="mer_m" name="mer_m" style="width:40px" value="<?php echo $mer_m; ?>"></td>
		<td><input type="text" id="jeu_m" name="jeu_m" style="width:40px" value="<?php echo $jeu_m; ?>"></td>
		<td><input type="text" id="ven_m" name="ven_m" style="width:40px" value="<?php echo $ven_m; ?>"></td></tr>
	<tr><td><? echo "Soir : "?></td>
		<td><input type="text" id="sam_s" name="sam_s" style="width:40px" value="<?php echo $sam_s; ?>"></td>
		<td><input type="text" id="dim_s" name="dim_s" style="width:40px" value="<?php echo $dim_s; ?>"></td>
		<td><input type="text" id="lun_s" name="lun_s" style="width:40px" value="<?php echo $lun_s; ?>"></td>
		<td><input type="text" id="mar_s" name="mar_s" style="width:40px" value="<?php echo $mar_s; ?>"></td>
		<td><input type="text" id="mer_s" name="mer_s" style="width:40px" value="<?php echo $mer_s; ?>"></td>
		<td><input type="text" id="jeu_s" name="jeu_s" style="width:40px" value="<?php echo $jeu_s; ?>"></td>
		<td><input type="text" id="ven_s" name="ven_s" style="width:40px" value="<?php echo $ven_s; ?>"></td></tr>
	<tr><td><? echo "H.Supp : "?></td>
		<td><input type="text" id="sam_sup" name="sam_sup" style="width:40px" value="<?php echo $sam_sup; ?>"></td>
		<td><input type="text" id="dim_sup" name="dim_sup" style="width:40px" value="<?php echo $dim_sup; ?>"></td>
		<td><input type="text" id="lun_sup" name="lun_sup" style="width:40px" value="<?php echo $lun_sup; ?>"></td>
		<td><input type="text" id="mar_sup" name="mar_sup" style="width:40px" value="<?php echo $mar_sup; ?>"></td>
		<td><input type="text" id="mer_sup" name="mer_sup" style="width:40px" value="<?php echo $mer_sup; ?>"></td>
		<td><input type="text" id="jeu_sup" name="jeu_sup" style="width:40px" value="<?php echo $jeu_sup; ?>"></td>
		<td><input type="text" id="ven_sup" name="ven_sup" style="width:40px" value="<?php echo $ven_sup; ?>"></td></tr>		
		<tr><td><? echo "Controle : "?></td>
		<td><input type="checkbox" id="valide_sam" name="valide_sam"<?php if($valide_sam) { echo " checked"; } ?>></td>
		<td><input type="checkbox" id="valide_dim" name="valide_dim"<?php if($valide_dim) { echo " checked"; } ?>></td>
		<td><input type="checkbox" id="valide_lun" name="valide_lun"<?php if($valide_lun) { echo " checked"; } ?>></td>
		<td><input type="checkbox" id="valide_mar" name="valide_mar"<?php if($valide_mar) { echo " checked"; } ?>></td>
		<td><input type="checkbox" id="valide_mer" name="valide_mer"<?php if($valide_mer) { echo " checked"; } ?>></td>
		<td><input type="checkbox" id="valide_jeu" name="valide_jeu"<?php if($valide_jeu) { echo " checked"; } ?>></td>
		<td><input type="checkbox" id="valide_ven" name="valide_ven"<?php if($valide_ven) { echo " checked"; } ?>></td>
		<tr><td><? echo "Ferier : "?></td>
		<td><input type="checkbox" id="ferier_sam" name="ferier_sam"<?php if($ferier_sam) { echo " checked"; } ?>></td>
		<td><input type="checkbox" id="ferier_dim" name="ferier_dim"<?php if($ferier_dim) { echo " checked"; } ?>></td>
		<td><input type="checkbox" id="ferier_lun" name="ferier_lun"<?php if($ferier_lun) { echo " checked"; } ?>></td>
		<td><input type="checkbox" id="ferier_mar" name="ferier_mar"<?php if($ferier_mar) { echo " checked"; } ?>></td>
		<td><input type="checkbox" id="ferier_mer" name="ferier_mer"<?php if($ferier_mer) { echo " checked"; } ?>></td>
		<td><input type="checkbox" id="ferier_jeu" name="ferier_jeu"<?php if($ferier_jeu) { echo " checked"; } ?>></td>
		<td><input type="checkbox" id="ferier_ven" name="ferier_ven"<?php if($ferier_ven) { echo " checked"; } ?>></td>
		<tr><td><? echo "Statut : "?></td>
		<td><select id="motif_sam" name="motif_sam"><?php echo $profiles_list_motif_sam; ?></select></td>
		<td><select id="motif_dim" name="motif_dim"><?php echo $profiles_list_motif_dim; ?></select></td>
		<td><select id="motif_lun" name="motif_lun"><?php echo $profiles_list_motif_lun; ?></select></td>
		<td><select id="motif_mar" name="motif_mar"><?php echo $profiles_list_motif_mar; ?></select></td>
		<td><select id="motif_mer" name="motif_mer"><?php echo $profiles_list_motif_mer; ?></select></td>
		<td><select id="motif_jeu" name="motif_jeu"><?php echo $profiles_list_motif_jeu; ?></select></td>
		<td><select id="motif_ven" name="motif_ven"><?php echo $profiles_list_motif_ven; ?></select></td>
		

		</table>
		
		
		<? 
		
		$repos=0;if ($sam_m+$sam_s==0 or $lun_m+$lun_s==0 or $mar_m+$mar_s==0 or $mer_m+$mer_s==0 
			or $jeu_m+$jeu_s==0 or $ven_m+$ven_s==0){$repos=1;}
		
		
		$hn=0;$t_h_s_25=0;$t_h_s_50=0;
		$heures_normales=$sam_m+$sam_s+$lun_m+$lun_s+$mar_m+$mar_s+$mer_m+$mer_s+$jeu_m+$jeu_s+$ven_m+$ven_s;
		$heures_sup=$sam_sup+$lun_sup+$mar_sup+$mer_sup+$jeu_sup+$ven_sup;
		$ht=$heures_normales+$heures_sup;
		if ($heures_normales>=44)
		{$hn=44;$t_h_s_25=$sam_sup+$lun_sup+$mar_sup+$mer_sup+$jeu_sup+$ven_sup+($heures_normales-44);
		if ($repos==0){$t_h_s_50=$dim_m+$dim_s+$dim_sup;}
		else{$t_h_s_25=$t_h_s_25+$dim_m+$dim_s+$dim_sup;$t_h_s_50=0;}}
		else {
			if ($heures_normales+$heures_sup>=44)
				{$hn=44;$t_h_s_25=$ht-44;if ($repos==0){$t_h_s_50=$dim_m+$dim_s+$dim_sup;}else{$t_h_s_25=$t_h_s_25+$dim_m+$dim_s+$dim_sup;$t_h_s_50=0;}}
				else
				{$htt=$heures_normales+$heures_sup+$dim_m+$dim_s+$dim_sup;
				if ($htt>=44){$hn=44;$t_h_s_25=$htt-44;$t_h_s_50=0;}
				else {$hn=$heures_normales+$heures_sup+$dim_m+$dim_s+$dim_sup;$t_h_s_25=0;$t_h_s_50=0;}
				}
			}
			
		?>
		<table>
		<tr><td><input type="checkbox" id="valide" name="valide"<?php if($valide) { echo " checked"; } ?>></td><td>Controle</td>
		<td><?php echo "Observations"; ?></td><td><input type="text" id="observations" name="observations" style="width:260px" value="<?php echo $observations; ?>"></td>
		
		
		</table>
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

/*function date_diff ($date_recent, $date_old) {
   return date_to_timestamp($date_recent) - date_to_timestamp($date_old);
}*/






?>
<table class="table2">
<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Statut";?></th>
	<th><?php echo "Heures";?></th>	
	<th><?php echo "Arrondi";?></th>		
	<th></th>
</tr>

<?
	
	

	$sql  = "SELECT * ";
	$sql .= "FROM pointeuse where name='$employe' and non_inclus=0 ORDER BY id;";
	$users = db_query($database_name, $sql);$in=0;$out=0;

while($users_ = fetch_array($users)) { 

$de=$users_["date"];
list($d, $h) = explode(" ", $de);
list($heures, $min,$seconde) = explode(":", $h);
list($annee, $mois,$jours) = explode("-", $d);

$entree="";$sortie="";
$s1=substr($users_["statut"], 0, 4); 
$s2=substr($users_["statut"], 0, 5);

if ($s1=="ENT"){$in=$in+1;$date_in=strtotime($users_["date"]);
$entree=$heures.":".$min;$in_s=8;$avance_min=0;

if ($poste=="service" and $employe<>"SEMHARI MOHAMED"){$in_s=8;
if ($heures<$in_s)
{$avance_min=60-$min;$c_in=$heures;$date1 = mktime($heures,$min,$seconde,$mois,$jours,$annee);}
else {$in_m1=7;$in_m2=14;$in_m3=19;$c_in=$heures;$date1 = mktime($heures,$min,$seconde,$mois,$jours,$annee);}
}

if ($poste=="machine" and $employe<>"SEMHARI MOHAMED"){$in_s=6;$in_m1=6;$in_m2=14;$in_m3=19;
if ($heures<$in_m1 or ($heures>12 and $heures<$in_m2) or ($heures>16 and $heures<$in_m3))
{$avance_min=60-$min;$c_in=$heures;$date1 = mktime($heures,$min,$seconde,$mois,$jours,$annee);}
else
{$in_m1=7;$in_m2=14;$in_m3=19;$c_in=$heures;$date1 = mktime($heures,$min,$seconde,$mois,$jours,$annee);}
}


?>
<tr><td><?php echo $users_["date"]."--------------->".$avance_min." min"; ?></td>
<td><?php echo $users_["statut"]; ?></td>
<?
}

if ($s2=="SOR"){$in=$in+1;$date_out=strtotime($users_["date"]);$sortie=$heures.":".$min;$c_out=$heures;
$date2 = mktime($heures,$min,$seconde,$mois,$jours,$annee);
$diff=$c_out-$c_in;
$diff_date = $date2-$date1; 
@$diff['heures'] = (int)($diff_date/(60*60*60)); 
@$diff['jours'] = (int)($diff_date/(60*60*24)); 
$heures_totales = $diff_date/(60);$h_t=intval($heures_totales/60);$m_t=$heures_totales%60;

$tempsreel=$date_out-$date_in;$t_r=strftime('%H:%M:%S', $tempsreel);
list($hr, $mr,$sr) = explode(":", $t_r);
$hr=$hr-1;?>
<tr><td><?php echo $users_["date"]; ?></td>
<td><?php echo $users_["statut"]; ?></td>
<? }

?>




<?php 

	if ($s1=="ENT"){
	$datej=$users_["date_j"];
	list($annee1,$mois1,$jour1) = explode('-', $datej); 
	$d = mktime(0,0,0,$mois1,$jour1,$annee1);
	$nom_jour=date("D",$d);
	$jour_t="";
	if ($nom_jour=="Sat"){$jour_t="Samedi";} if ($nom_jour=="Sun"){$jour_t="Dimanche";}
	if ($nom_jour=="Mon"){$jour_t="Lundi";} if ($nom_jour=="Tue"){$jour_t="Mardi";}
	if ($nom_jour=="Wed"){$jour_t="Mercredi";} if ($nom_jour=="Thu"){$jour_t="Jeudi";}
	if ($nom_jour=="Fri"){$jour_t="Vendredi";} 
	
	?><td><?php echo $jour_t; ?></td><td></td><? 
	}


if ($s2=="SOR") {?>
<? if ($hr<=0){?>
<td bgcolor="#66CCCC"><?php echo "Erreur !!"; ?></td>
<? } else {?>
<td><?php if ($avance_min>0){if ($avance_min<$mr){$mr=$mr-$avance_min;}else{$hr=$hr-1;$mr=60-$avance_min+$mr;}}
echo $hr." heures ".$mr." min"; ?></td>
<? }?>
<?  
	
	
		if ($mr>=25 and $mr<=50){$heures=$hr+0.50;$minute=00;}
	if ($mr<25){$heures=$hr;$minutes=00;}
	if ($mr>50){$heures=$hr+1;$minutes=00;}
	$lun=0;$mar=0;$mer=0;$jeu=0;$ven=0;$sam=0;$dim=0;
	$lun_s=0;$mar_s=0;$mer_s=0;$jeu_s=0;$ven_s=0;$sam_s=0;$dim_s=0;

	if ($nom_jour=="Mon"){if ($heures>=9){$lun_s=$heures-8;$lun=$heures-$lun_s;}else{$lun_s=0;$lun=$heures;}}
	if ($nom_jour=="Tue"){if ($heures>=9){$mar_s=$heures-8;$mar=$heures-$mar_s;}else{$mar_s=0;$mar=$heures;}}
	if ($nom_jour=="Wed"){if ($heures>=9){$mer_s=$heures-8;$mer=$heures-$mer_s;}else{$mer_s=0;$mer=$heures;}}
	if ($nom_jour=="Thu"){if ($heures>=9){$jeu_s=$heures-8;$jeu=$heures-$jeu_s;}else{$jeu_s=0;$jeu=$heures;}}
	if ($nom_jour=="Fri"){if ($heures>=9){$ven_s=$heures-8;$ven=$heures-$ven_s;}else{$ven_s=0;$ven=$heures;}}
	if ($nom_jour=="Sat"){if ($heures>=5){$sam_s=$heures-4;$sam=$heures-$sam_s;}else{$sam_s=0;$sam=$heures;}}
	if ($nom_jour=="Sun"){if ($heures>=9){$dim_s=$heures-8;$dim=$heures-$dim_s;}else{$dim_s=0;$dim=$heures;}}

?>

<td><?php echo number_format($heures,2,',',' '); ?></td>
<? 	if ($nom_jour=="Sat"){$t_h_samedi=$t_h_samedi+$heures;}
    if ($nom_jour=="Sun"){$t_h_dimanche=$t_h_dimanche+$heures;}
	if ($nom_jour=="Mon"){$t_h_n=$t_h_n+$heures;} 
	if ($nom_jour=="Tue"){$t_h_n=$t_h_n+$heures;}
	if ($nom_jour=="Wed"){$t_h_n=$t_h_n+$heures;}
	if ($nom_jour=="Thu"){$t_h_n=$t_h_n+$heures;}
	if ($nom_jour=="Fri"){$t_h_n=$t_h_n+$heures;} 
?>
<? }  ?>
<? }  ?>


</table>




</center>

</form>

</body>

</html>
