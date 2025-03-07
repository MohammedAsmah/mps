<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	$du=$_GET["du"];
	
	$sql  = "SELECT * ";$occ="occasionnelles";$per="permanents";$vide="";
	$sql .= "FROM journal_paie where du='$du' and employe<>'$vide' and statut=0 and (service='$occ' or service='$per') ORDER BY service,employe;";
	$users = db_query($database_name, $sql);$erreur=0;$compteur=0;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste "; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "pointage_archive_employe.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "liste "; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Nom et Prenom ";?></th>
	<th><?php echo "H.N";?></th>
	<th><?php echo "H.25%";?></th>
	<th><?php echo "H.50%";?></th>
	<th><?php echo "H.100%";?></th>
	<th><?php echo "Total H.";?></th>
	<th><?php echo "obs";?></th>	
	
</tr>

<?php $tr=0;$ser="";while($users_ = fetch_array($users)) { ?><tr>
<? if ($tr==0 and $ser<>$users_["service"])
{?><tr><td bgcolor="#66CCCC"><?php $ser==$users_["service"];$tr=1;echo $users_["service"];?></td></tr><? }?>

<td><?php echo $users_["employe"];?></td>
<td align="right"><?php echo number_format($users_["t_h_normales"],2,',',' '); ?></td>
<td align="right"><?php echo number_format($users_["t_h_25"],2,',',' '); ?></td>
<td align="right"><?php echo number_format($users_["t_h_50"],2,',',' '); ?></td>
<td align="right"><?php echo number_format($users_["t_h_100"],2,',',' '); ?></td>
<td align="right"><?php $tt=$users_["t_h_normales"]+($users_["t_h_25"]*1.25)+($users_["t_h_50"]*1.50);
echo number_format($tt,2,',',' ');?></td>
<td><?php echo $users_["observations"];?></td>
<? if ($ser<>$users_["service"]){$ser=$users_["service"];$tr=0;}?>
<?php } ?>
</table>

<p style="text-align:center">


</body>

</html>