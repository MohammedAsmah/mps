<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();$user_name=GetUserName();
	//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$login = $user_["login"];

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$employe = $_REQUEST["employe"];$ref = $_REQUEST["ref"];$service = $_REQUEST["service"];$poste = $_REQUEST["poste"];$ordre = $_REQUEST["ordre"];
			$poste = $_REQUEST["poste"];if(isset($_REQUEST["statut"])) { $statut = 1; } else { $statut = 0; }
			$t_h_normales = $_REQUEST["t_h_normales"];$t_h_25 = $_REQUEST["t_h_25"];$t_h_50 = $_REQUEST["t_h_50"];
			if(isset($_REQUEST["manual"])) { $manual = 1; } else { $manual = 0; }
				$sam_m = $_REQUEST["sam_m"];$dim_m = $_REQUEST["dim_m"];$lun_m = $_REQUEST["lun_m"];$mar_m = $_REQUEST["mar_m"];
			$mer_m = $_REQUEST["mer_m"];$jeu_m = $_REQUEST["jeu_m"];$ven_m = $_REQUEST["ven_m"];
			$sam_s = $_REQUEST["sam_s"];$dim_s = $_REQUEST["dim_s"];$lun_s = $_REQUEST["lun_s"];$mar_s = $_REQUEST["mar_s"];
			$mer_s = $_REQUEST["mer_s"];$jeu_s = $_REQUEST["jeu_s"];$ven_s = $_REQUEST["ven_s"];
			$sam_sup = $_REQUEST["sam_sup"];$dim_sup = $_REQUEST["dim_sup"];$lun_sup = $_REQUEST["lun_sup"];$mar_sup = $_REQUEST["mar_sup"];
			$mer_sup = $_REQUEST["mer_sup"];$jeu_sup = $_REQUEST["jeu_sup"];$ven_sup = $_REQUEST["ven_sup"];
			if(isset($_REQUEST["valide"])) { $valide = 1; } else { $valide = 0; }
			$observations = $_REQUEST["observations"];
			if(isset($_REQUEST["valide_sam"]) or $sam_m<>'') { $valide_sam = 1; } else { $valide_sam = 0; }
			if(isset($_REQUEST["valide_dim"]) or $dim_m<>'') { $valide_dim = 1; } else { $valide_dim = 0; }
			if(isset($_REQUEST["valide_lun"]) or $lun_m<>'')  { $valide_lun = 1; } else { $valide_lun = 0; }
			if(isset($_REQUEST["valide_mar"]) or $mar_m<>'') { $valide_mar = 1; } else { $valide_mar = 0; }
			if(isset($_REQUEST["valide_mer"]) or $mer_m<>'') { $valide_mer = 1; } else { $valide_mer = 0; }
			if(isset($_REQUEST["valide_jeu"]) or $jeu_m<>'') { $valide_jeu = 1; } else { $valide_jeu = 0; }
			if(isset($_REQUEST["valide_ven"]) or $ven_m<>'') { $valide_ven = 1; } else { $valide_ven = 0; }
			
			$motif_sam = $_REQUEST["motif_sam"];$motif_dim = $_REQUEST["motif_dim"];$motif_lun = $_REQUEST["motif_lun"];
			$motif_mar = $_REQUEST["motif_mar"];$motif_mer = $_REQUEST["motif_mer"];$motif_jeu = $_REQUEST["motif_jeu"];
			$motif_ven = $_REQUEST["motif_ven"];
			//////////////////////////////////////////
			
		
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
			
		////////////////////////////////////////////////////////
			
			
			
			
			
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				$sql  = "INSERT INTO employes ( code, employe,service,statut,poste )
				 VALUES ('$ref','$employe','$service','$statut','$poste')";

				db_query($database_name, $sql);
			

			break;

			case "update_user":
			$user_id=$_REQUEST["user_id"];
			$sql = "UPDATE employes SET ordre = '$ordre',ref = '$ref',employe = '$employe',t_h_normales='$hn',
				t_h_25='$t_h_s_25',t_h_50='$t_h_s_50',valide='$valide', 
				sam_m='$sam_m',dim_m='$dim_m',lun_m='$lun_m',mar_m='$mar_m',mer_m='$mer_m',jeu_m='$jeu_m',ven_m='$ven_m',
			sam_s='$sam_s',dim_s='$dim_s',lun_s='$lun_s',mar_s='$mar_s',mer_s='$mer_s',jeu_s='$jeu_s',ven_s='$ven_s',
			sam_sup='$sam_sup',dim_sup='$dim_sup',lun_sup='$lun_sup',mar_sup='$mar_sup',mer_sup='$mer_sup',jeu_sup='$jeu_sup',ven_sup='$ven_sup',
			valide_sam='$valide_sam',valide_dim='$valide_dim',valide_lun='$valide_lun',valide_mar='$valide_mar',valide_mer='$valide_mer',valide_jeu='$valide_jeu',
			valide_ven='$valide_ven',observations='$observations',motif_sam='$motif_sam',motif_dim='$motif_dim',
			motif_lun='$motif_lun',motif_mar='$motif_mar',motif_mer='$motif_mer',motif_jeu='$motif_jeu',motif_ven='$motif_ven'
			
				WHERE id = '$user_id'";
			db_query($database_name, $sql);
			
			break;
			
			case "delete_user":
			

			// delete user's profile
			$sql = "DELETE FROM employes WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	$sql  = "SELECT * ";$occ="occasionnelles";$per="permanents";$vide="";
	$sql .= "FROM employes where employe<>'$vide' and statut=0 and (service='$occ' or service='$per') ORDER BY tectra DESC, employe ASC;";
	$users = db_query($database_name, $sql);$erreur=0;$compteur=0;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "Pointage "; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "employe2.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Pointage "; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Nom et Prenom ";?></th>
	<th><?php echo "Sam";?></th>
	<th><?php echo "Dim";?></th>
	<th><?php echo "Lun";?></th>
	<th><?php echo "Mar";?></th>
	<th><?php echo "Mer";?></th>
	<th><?php echo "Jeu";?></th>
	<th><?php echo "Ven";?></th>	
	<th><?php echo "Controle";?></th>		
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<? $compteur=$compteur+1;if($login=="admin" or $login=="fatimaezzahra" or $login=="alaoui"){ ?>
<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["employe"];?></A></td>
<? }else { ?><td><?php echo $users_["employe"];?></td>
<? }?>

<? if ($users_["valide"]==0){?>
<? if ($users_["valide_sam"]==1){
	if (($users_["sam_m"]+$users_["sam_s"]+$users_["sam_sup"])>0){?>
<td align="right" bgcolor="#66CCCC"><?php echo number_format($users_["sam_m"]+$users_["sam_s"]+$users_["sam_sup"],2,',',' '); ?></td>
	<? }else {?>
<td align="right" bgcolor="#FF3333"><?php echo number_format($users_["sam_m"]+$users_["sam_s"]+$users_["sam_sup"],2,',',' '); ?></td>	
	<?}} else { ?>
<td align="right"><?php echo number_format($users_["sam_m"]+$users_["sam_s"]+$users_["sam_sup"],2,',',' '); ?></td>
<? }?>

<? if ($users_["valide_dim"]==1){
	if (($users_["dim_m"]+$users_["dim_s"]+$users_["dim_sup"])>0){?>
<td align="right" bgcolor="#66CCCC"><?php echo number_format($users_["dim_m"]+$users_["dim_s"]+$users_["dim_sup"],2,',',' '); ?></td>
<? } else {?>
	
<td align="right" bgcolor="#FF3333"><?php echo number_format($users_["dim_m"]+$users_["dim_m"]+$users_["dim_m"],2,',',' '); ?></td>	
	<?}} else { ?>

<td align="right"><?php echo number_format($users_["dim_m"]+$users_["dim_s"]+$users_["dim_sup"],2,',',' '); ?></td>
<? }?>

<? if ($users_["valide_lun"]==1){
	if (($users_["lun_m"]+$users_["lun_s"]+$users_["lun_sup"])>0){?>
<td align="right" bgcolor="#66CCCC"><?php echo number_format($users_["lun_m"]+$users_["lun_s"]+$users_["lun_sup"],2,',',' '); ?></td>
<? } else {?>
	
<td align="right" bgcolor="#FF3333"><?php echo number_format($users_["lun_m"]+$users_["lun_s"]+$users_["lun_sup"],2,',',' '); ?></td>	
	<?}} else { ?>

<td align="right"><?php echo number_format($users_["lun_m"]+$users_["lun_s"]+$users_["lun_sup"],2,',',' '); ?></td>
<? }?>

<? if ($users_["valide_mar"]==1){
	if (($users_["mar_m"]+$users_["mar_s"]+$users_["mar_sup"])>0){?>
<td align="right" bgcolor="#66CCCC"><?php echo number_format($users_["mar_m"]+$users_["mar_s"]+$users_["mar_sup"],2,',',' '); ?></td>
<? } else {?>
	
<td align="right" bgcolor="#FF3333"><?php echo number_format($users_["mar_m"]+$users_["mar_s"]+$users_["mar_sup"],2,',',' '); ?></td>	
	<?}} else { ?>

<td align="right"><?php echo number_format($users_["mar_m"]+$users_["mar_s"]+$users_["mar_sup"],2,',',' '); ?></td>
<? }?>

<? if ($users_["valide_mer"]==1){
	if (($users_["mer_m"]+$users_["mer_s"]+$users_["mer_sup"])>0){?>
<td align="right" bgcolor="#66CCCC"><?php echo number_format($users_["mer_m"]+$users_["mer_s"]+$users_["mer_sup"],2,',',' '); ?></td>
<? } else {?>
	
<td align="right" bgcolor="#FF3333"><?php echo number_format($users_["mer_m"]+$users_["mer_s"]+$users_["mer_sup"],2,',',' '); ?></td>	
	<?}} else { ?>

<td align="right"><?php echo number_format($users_["mer_m"]+$users_["mer_s"]+$users_["mer_sup"],2,',',' '); ?></td>
<? }?>

<? if ($users_["valide_jeu"]==1){
	if (($users_["jeu_m"]+$users_["jeu_s"]+$users_["jeu_sup"])>0){?>
<td align="right" bgcolor="#66CCCC"><?php echo number_format($users_["jeu_m"]+$users_["jeu_s"]+$users_["jeu_sup"],2,',',' '); ?></td>
<? } else {?>
	
<td align="right" bgcolor="#FF3333"><?php echo number_format($users_["jeu_m"]+$users_["jeu_s"]+$users_["jeu_sup"],2,',',' '); ?></td>	
	<?}} else { ?>
<td align="right"><?php echo number_format($users_["jeu_m"]+$users_["jeu_s"]+$users_["jeu_sup"],2,',',' '); ?></td>
<? }?>

<? if ($users_["valide_ven"]==1){
	if (($users_["ven_m"]+$users_["ven_s"]+$users_["ven_sup"])>0){?>
<td align="right" bgcolor="#66CCCC"><?php echo number_format($users_["ven_m"]+$users_["ven_s"]+$users_["ven_sup"],2,',',' '); ?></td>
<? } else {?>
	
<td align="right" bgcolor="#FF3333"><?php echo number_format($users_["ven_m"]+$users_["ven_s"]+$users_["ven_sup"],2,',',' '); ?></td>	
	<?}} else { ?>
<td align="right"><?php echo number_format($users_["ven_m"]+$users_["ven_s"]+$users_["ven_sup"],2,',',' '); ?></td>
<? }?>
<td><?php $obs="";if ($users_["motif_sam"]<>""){$obs=$users_["motif_sam"]."-";}
if ($users_["motif_dim"]<>""){$obs=$obs.$users_["motif_dim"]."-";}
if ($users_["motif_lun"]<>""){$obs=$obs.$users_["motif_lun"]."-";}
if ($users_["motif_mar"]<>""){$obs=$obs.$users_["motif_mar"]."-";}
if ($users_["motif_mer"]<>""){$obs=$obs.$users_["motif_mer"]."-";}
if ($users_["motif_jeu"]<>""){$obs=$obs.$users_["motif_jeu"]."-";}
if ($users_["motif_ven"]<>""){$obs=$obs.$users_["motif_ven"]."-";}

 echo $obs; ?></td>

<? } else {?>

<td align="right" bgcolor="#66CCCC"><?php echo number_format($users_["sam_m"]+$users_["sam_s"]+$users_["sam_sup"],2,',',' '); ?></td>
<td align="right" bgcolor="#66CCCC"><?php echo number_format($users_["dim_m"]+$users_["dim_s"]+$users_["dim_sup"],2,',',' '); ?></td>
<td align="right" bgcolor="#66CCCC"><?php echo number_format($users_["lun_m"]+$users_["lun_s"]+$users_["lun_sup"],2,',',' '); ?></td>
<td align="right" bgcolor="#66CCCC"><?php echo number_format($users_["mar_m"]+$users_["mar_s"]+$users_["mar_sup"],2,',',' '); ?></td>
<td align="right" bgcolor="#66CCCC"><?php echo number_format($users_["mer_m"]+$users_["mer_s"]+$users_["mer_sup"],2,',',' '); ?></td>
<td align="right" bgcolor="#66CCCC"><?php echo number_format($users_["jeu_m"]+$users_["jeu_s"]+$users_["jeu_sup"],2,',',' '); ?></td>
<td align="right" bgcolor="#66CCCC"><?php echo number_format($users_["ven_m"]+$users_["ven_s"]+$users_["ven_sup"],2,',',' '); ?></td>
<td bgcolor="#66CCCC"><?php echo $users_["observations"]; ?></td>

<? } ?>
<?php } ?>
<tr><td><? echo "Erreur pointage : $erreur / $compteur";?></td></tr>
</table>

<p style="text-align:center">


</body>

</html>