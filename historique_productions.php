<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$user_login = $user_["login"];
	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$date_ins=date("Y-m-d");$obs=$_REQUEST["obs"];$date=dateFrToUs($_REQUEST["date"]);
		}
		if ($user_login=="admin" or $user_login=="nezha" ){
		switch($_REQUEST["action_"]) {
			
			case "insert_new_user":
			
				$sql  = "INSERT INTO productions ( date_ins,date,obs )
				VALUES ('$date_ins','$date','$obs')";
				db_query($database_name, $sql);$id_production=mysql_insert_id();

				$sql1  = "SELECT * ";$today=date("y-m-d");$fin="0000-00-00";
				$sql1 .= "FROM programme_machines where fin='$fin' ORDER BY ordre;";
				$users1 = db_query($database_name, $sql1);
				while($users_1 = fetch_array($users1)) { 
					$machine=$users_1["machine"];$produit=$users_1["produit"];$ordre=$users_1["ordre"];
					$sql  = "INSERT INTO details_productions ( id_production,date_ins,date,obs,produit,machine,ordre )
					VALUES ('$id_production','$date_ins','$date','$obs','$produit','$machine','$ordre')";
					db_query($database_name, $sql);
					
					}

			break;

			case "update_user":

			$sql = "UPDATE productions SET ";
			$sql .= "date = '" . $date . "', ";
			$sql .= "obs = '" . $_REQUEST["obs"] . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			// delete user's profile
			$sql = "DELETE FROM productions WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			$sql = "DELETE FROM details_productions WHERE id_production = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			}

		} //switch
	} //if
	
	$date="";$action="Recherche";$date2="";
			if(isset($_REQUEST["action"])){}else{
	?>
	<form id="form" name="form" method="post" action="historique_productions.php">
	<table><td><?php echo "Du: "; ?><input onClick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" />
	<td><?php echo "Au: "; ?><input onClick="ds_sh(this);" name="date2" readonly="readonly" style="cursor: text" />
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td></td></table>
	</form>
	
	<? }
	if(isset($_REQUEST["action"]) or isset($_REQUEST["action_"]))
	{$date=dateFrToUs($_POST['date']);$date_f=$_POST['date'];$date2=dateFrToUs($_POST['date2']);$date_f2=$_POST['date2'];
		
	$sql  = "SELECT * ";
	$sql .= "FROM productions where date between '$date' and '$date2' ORDER BY date;";
	$users = db_query($database_name, $sql);
		}
		
		else
			
		{
	$sql  = "SELECT * ";$today=date("y-m-d");$date_f=date("d/m/Y");
	$sql .= "FROM productions where date='$today' ORDER BY date;";
	$users = db_query($database_name, $sql);}

	?>
	

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "Production du : $date_f ===>"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "production.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Production du : $date_f ===>"; ?></span>

	<? if(isset($_REQUEST["action"]) or isset($_REQUEST["action_"])){?>
<? echo "<td><a href=\"production.php?date=$date_f&user_id=0\">Ajout</a></td>";?>
	<? }?>
<table class="table2">

<tr>
	<th><?php echo "date";?></th>
	<th><?php echo "Observations";?></th>
	<th><?php echo "Actions";?></th>

</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>

<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo dateUsToFr($users_["date"]);?></A></td>
<td style="text-align:center"><?php echo $users_["obs"]; ?></td>
<? $id_production=$users_["id"];echo "<td><a href=\"productions_details.php?id_production=$id_production\">Details</a></td>";?>

<?php } ?>

</table>

<p style="text-align:center">

	<? if(isset($_REQUEST["action"]) or isset($_REQUEST["action_"])){?>

<? echo "<td><a href=\"production.php?date=$date_f&user_id=0\">Ajout</a></td>";?>
	<? }?>

</body>

</html>