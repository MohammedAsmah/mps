<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
		$type_service="SEJOURS ET CIRCUITS";$action="Recherche";$date1="";$date2="";$total_cc=0;$total_tt=0;$date="";
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url

	
	?>
	<? if(isset($_REQUEST["action"])){}else{ ?>
	<form id="form" name="form" method="post" action="liste_clients.php">
	<td><?php echo "Du : "; ?><input type="text" id="date1" name="date1" value="<?php echo $date1; ?>" /></td>
	<td><?php echo "Au : "; ?><input type="text" id="date2" name="date2" value="<?php echo $date2; ?>" /></td>
	<input type="submit" id="action" name="action" value="<?php echo $action; ?>">
	</form>
	
	<? }

	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url

	if(isset($_REQUEST["action"]))
	{ ?>

	<span style="font-size:24px"><?php $date1=dateFrToUs($_POST['date1']);$date2=dateFrToUs($_POST['date2']);$total=0;



	$sql  = "SELECT * ";
	$sql .= "FROM clients ORDER BY client;";
	$users = db_query($database_name, $sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Clients"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "client.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "liste Client"; ?></span>
<tr>
<td align="center" bordercolor="#FFFBF0"><? $imp="Imprimer Liste";$link="<a href=\"\\mps\\tutorial\\liste_clients.php?date1=$date1&date2=$date2\">".$imp."</a>";?>
<?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"000033\">$link </font>");?></td>
</tr>

<table class="table2">

<tr>
	<th><?php echo "Code";?></th>
	<th><?php echo "Nom";?></th>
	<th><?php echo "Vendeur";?></th>
	
	<th><?php echo "Ville";?></th>
	<th><?php echo "Remise2";?></th>
	<th><?php echo "Remise3";?></th>
	<th><?php echo "Patente";?></th>
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<td><?php echo $users_["client"];?></td>
<td><?php echo $users_["vendeur_nom"]; ?></td>
<td><?php echo $users_["ville"]; ?></td>
<td><?php echo $users_["remise2"]; ?></td>
<td><?php echo $users_["remise3"]; ?></td>
<td><?php echo $users_["patente"]; ?></td>
<?php } ?>

</table>

<p style="text-align:center">

<tr>
<td align="center" bordercolor="#FFFBF0"><? $imp="Imprimer Liste";$link="<a href=\"\\mps\\tutorial\\liste_clients.php?date1=$date1&date2=$date2\">".$imp."</a>";?>
<?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"000033\">$link </font>");?></td>
</tr>

<? }?>
</body>

</html>