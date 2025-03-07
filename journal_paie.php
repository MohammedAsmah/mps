<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	
	$du=$_GET['du'];
	$sql  = "SELECT * ";$occ="occasionnelles";$per="permanents";$vide="";
	$sql .= "FROM journal_paie where du='$du' ORDER BY employe ;";
	$users = db_query($database_name, $sql);$erreur=0;$compteur=0;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "Pointage "; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">



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
<? $compteur=$compteur+1;if ($users_["controle"]==0){?>
<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["employe"];?></A></td>
<? } else {$erreur=$erreur+1;?>
<td bgcolor="#FF3333"><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["employe"];?></A></td>
<? }?>
<? if ($users_["valide"]==0){?>

<td align="right"><?php echo number_format($users_["sam"],2,',',' '); ?></td>


<td align="right"><?php echo number_format($users_["dim"],2,',',' '); ?></td>



<td align="right"><?php echo number_format($users_["lun"],2,',',' '); ?></td>

<td align="right"><?php echo number_format($users_["mar"],2,',',' '); ?></td>

<td align="right"><?php echo number_format($users_["mer"],2,',',' '); ?></td>


<td align="right"><?php echo number_format($users_["jeu"],2,',',' '); ?></td>

<td align="right"><?php echo number_format($users_["ven"],2,',',' '); ?></td>
<? }?>
<td><?php $obs="";
if ($users_["motif_sam"]<>""){$obs=$users_["motif_sam"]."-";}
if ($users_["motif_dim"]<>""){$obs=$obs.$users_["motif_dim"]."-";}
if ($users_["motif_lun"]<>""){$obs=$obs.$users_["motif_lun"]."-";}
if ($users_["motif_mar"]<>""){$obs=$obs.$users_["motif_mar"]."-";}
if ($users_["motif_mer"]<>""){$obs=$obs.$users_["motif_mer"]."-";}
if ($users_["motif_jeu"]<>""){$obs=$obs.$users_["motif_jeu"]."-";}
if ($users_["motif_ven"]<>""){$obs=$obs.$users_["motif_ven"]."-";}
 echo $obs; ?></td>

<?php } ?>
<tr><td><? ?></td></tr>
</table>

<p style="text-align:center">


</body>

</html>