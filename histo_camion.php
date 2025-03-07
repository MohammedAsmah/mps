<?php
set_time_limit(0);
	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();$datej=date("d/m/Y H:i:s");
	$user_name=GetUserName();
	$error_message = "";
	$type_service="SEJOURS ET CIRCUITS";
	//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$user_login = $user_["login"];
	
	$matricule=$_GET["matricule"];

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
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<? 	
	
	$sql  = "SELECT * ";
	$sql .= "FROM registre_vendeurs where matricule='$matricule' ORDER BY id;";
	$users11 = db_query($database_name, $sql);
?>


<span style="font-size:24px"><?php echo $matricule; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Destination";?></th>
	<th><?php echo "Vendeur";?></th>
	<th><?php echo "Bon.Sortie";?></th>
	<th><?php echo "Observations";?></th>
	
</tr>

<?php $compteur1=0;$total_g=0;
while($users_1 = fetch_array($users11)) { $id_r=$users_1["id"];$date3=$users_1["date"];$vendeur=$users_1["vendeur"];
			$statut=$users_1["statut"];$observation=$users_1["observation"];$valide=$users_1["valide"];$valide_c=$users_1["valide_c"];
			$service=$users_1["service"];$code=$users_1["code_produit"];$lp=$users_1["id"]+100000;$bon=$users_1["statut"];?>
			<tr>
			<? $dt=dateUsToFr($users_1["date"]);$user_id=$users_1["id"];$imprimer=$users_1["imprimer"];
			$hh=$users_1["heure"];$mm=$users_1["montant"];$bl_out=$users_1["bl_out"];$bl_in=$users_1["bl_in"];
			
			
			
			
			
			?>			<td><?php echo dateUsToFr($users_1["date"]); ?></td>

			
			
			<td><?php $destination=$users_1["service"];echo $users_1["service"]; ?></td>

			<td><?php $vendeur=$users_1["vendeur"];echo $users_1["vendeur"]; ?></td>
			
			<td><?php echo $bon; ?></td>
			
			<td><?php echo $users_1["obs_c"]; ?></td>
												
			<?
			 } ?>

</table>
</strong>

</body>

</html>
