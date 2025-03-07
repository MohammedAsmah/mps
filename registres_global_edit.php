<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$user_name=GetUserName();
	$error_message = "";
		/*$sql  = "SELECT * ";$sel=1;
		$sql .= "FROM mois_rak WHERE encours = " . $sel . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";

		$mois = $user_["mois"];
		$du = dateUsToFr($user_["du"]);
		$au= dateUsToFr($user_["au"]);*/
		$du="01/11/06";$au="30/11/06";
		$action="Recherche";$numlp="";
		$date1="";$date2="";
	?>
	<form id="form" name="form" method="post" action="registres_global_edit.php">
	<td><?php echo "Du : "; ?><input onclick="ds_sh(this);" name="date1" readonly="readonly" style="cursor: text" / value="<?php echo $du; ?>"></td>
	<td><?php echo "Au : "; ?><input onclick="ds_sh(this);" name="date2" readonly="readonly" style="cursor: text" / value="<?php echo $au; ?>"></td><tr>
	<td><?php echo "Numero LP : "; ?><input type="text" id="numlp" name="numlp" value="<?php echo $numlp; ?>">
	<input type="submit" id="action" name="action" value="<?php echo $action; ?>">
	</form>
	
	<?
	if(isset($_REQUEST["action"]))
	{ $date1=dateFrToUs($_POST['date1']);$date2=dateFrToUs($_POST['date2']);$numlp=$_POST['numlp'];
	if ($numlp==""){
	$sql  = "SELECT * ";
	$sql .= "FROM registre_lp_rak where date between '$date1' and '$date2' ORDER BY id;";
	$users = db_query($database_name, $sql);}
	else
	{$sql  = "SELECT * ";
	$sql .= "FROM registre_lp_rak where id='$numlp' ORDER BY id;";
	$users = db_query($database_name, $sql);}
	
	}
	else {	$sql  = "SELECT * ";
	$sql .= "FROM registre_lp_rak ORDER BY id;";
	$users = db_query($database_name, $sql);}

	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "registre.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo ""; ?></span>

<table class="table2">

<tr>
	<th><?php echo "LP";?></th>
	<th><?php echo "Date";?></th>
	<th><?php echo "Service";?></th>
	<th><?php echo "Client";?></th>
	<th><?php echo "Statut";?></th>
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<? $id_r=$users_["id"];$date=$users_["date"];$client=$users_["client"];$service=$users_["service"];$code=$users_["code_produit"];$lp=$users_["id"]+200000;?>
<td><?php echo $lp; ?>
<td><?php echo dateUsToFr($users_["date"]); ?></td>
<td><?php echo $users_["service"]; ?></td>
<td><?php echo $users_["client"]; ?></td>
<td><?php echo $users_["statut"]; ?></td>
<? 
 } ?>

</table>

</body>

</html>