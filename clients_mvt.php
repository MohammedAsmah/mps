<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$user_login = $user_["login"];

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	
	$sql  = "SELECT * ";$vide='';
	$sql .= "FROM clients where client<>'$vide' ORDER BY vendeur_nom,client;";
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

<table class="table2">

<tr>
	
	<th><?php echo "Nom";?></th>
	<th><?php echo "Vendeur";?></th>
	
	<th><?php echo "Ville";?></th>
	<th><?php echo "Adresse";?></th>
</tr>

<?php $i=0; while($users_ = fetch_array($users)) { 
$client=$users_["client"];$newd="2019-01-01";

$sql  = "SELECT client,sum(net) As net,date_e ";
	$sql .= "FROM commandes where client='$client' and date_e>'$newd' GROUP BY client ORDER BY id;";
	$users1 = db_query($database_name, $sql);
	$users_1 = fetch_array($users1);$net=$users_1["net"];
								
  if ($net>0){$i++;

?><tr>
<td><a href="JavaScript:EditUser(<?php $id=$users_["id"];echo $users_["id"]; ?>)"><?php echo $users_["id"];?></A></td>
<?php $id=$users_["id"]; $ref=$users_["vendeur"];?>
<? echo "<td><a href=\"compte_client.php?client=$client\">$client</a></td>";?>
<td><?php echo $users_["vendeur_nom"]; ?></td>
<td><?php echo $users_["remise10"]; ?></td>
<td><?php echo $users_["remise2"]; ?></td>
<td><?php echo $users_["remise3"]; ?></td>
<td><?php echo $users_["escompte"]; ?></td>
<td><?php echo $users_["ville"];$v=$users_["ville"];
 
?></td>
<td><?php echo $users_["adrresse"]; ?></td>

<?php } ?>
<?php } ?>
</table>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo "Nbre clients : $i"; ?></button>
<tr>
<td align="center" bordercolor="#FFFBF0"><? $imp="Imprimer Liste";$link="<a href=\"liste_clients_pdf.php\">".$imp."</a>";?>
<?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"000033\">$link </font>");?></td>
</tr>

</body>

</html>