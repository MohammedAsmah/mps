<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$caisse="";$action="Recherche";$date="";$date1="";$du="";$au="";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">


</head>

<body style="background:#dfe8ff">
		<? require "body_cal.php";?>

	<?
	
			if(isset($_REQUEST["action"])){}else{
	?>
	<form id="form" name="form" method="post" action="palmares_clients_last.php">
	
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }
	if(isset($_REQUEST["action"]))
	{$encours="encours";$vide="";$debit=0;$credit=0;$t=0;$s=0;$t=0;?>
	<p>

<span style="font-size:24px"><?php echo "Mouvements Clients "; ?></span>

<p style="text-align:center">


<table class="table2">

<tr>
	<th><?php echo "Client";?></th>
	<th><?php echo "Vendeur";?></th>
	<th><?php echo "Ville";?></th>
	<th><?php echo "Addresse";?></th>
	<th><?php echo "Date";?></th>
	
</tr>

<?
	
	
	
	$sql  = "SELECT * ";$vide="";
	$sql .= "FROM clients where client<>'$vide' order by vendeur_nom,ville,client;";
	$usersc = db_query($database_name, $sql);
	while($users_c = fetch_array($usersc)) {
	$client=$users_c["client"];$ville=$users_c["ville"];$vendeur=$users_c["vendeur_nom"];$add=$users_c["adrresse"];
	
	$sql  = "SELECT * ";
	$sql .= "FROM commandes where client='$client' and evaluation<>'$vide' order by date_e DESC;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$date_e=dateUsToFr($users_["date_e"]);$net=$users_["net"];
	
	
	print("<tr><td><font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$client </font></td>");
	print("<td><font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$vendeur </font></td>");
	print("<td><font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$ville </font></td>");
	
	print("<td><font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$add </font></td>");
	print("<td><font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$date_e </font></td>");?>

<?php } ?>


<?php } ?>

<p style="text-align:center">

</body>

</html>