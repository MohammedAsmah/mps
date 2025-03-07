<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$produit = $_REQUEST["produit"];$user_id = $_REQUEST["user_id"];
			$machine=$_REQUEST["machine"];
			
			$debut=dateFrToUs($_REQUEST["debut"]);
			$fin=dateFrToUs($_REQUEST["fin"]);
			$timedebut=$_REQUEST["timedebut"];
			$timefin=$_REQUEST["timefin"];
			$stock_i=$_REQUEST["stock_i"];
			$stock_f=$_REQUEST["stock_f"];
			
			$sql  = "SELECT * ";
		$sql .= "FROM machines WHERE designation = '" . $machine . "';";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$ordre = $user_["ordre"];
			
			$date_ins=date("Y-m-d");
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
				$sql  = "INSERT INTO programme_machines ( 
				produit,machine,ordre,date_ins,debut,fin,timedebut,timefin,stock_i,stock_f )
				 VALUES ('$produit','$machine','$ordre','$date_ins','$debut','$fin','$timedebut','$timefin','$stock_i','$stock_f')";

				db_query($database_name, $sql);

			

			break;

			case "update_user":

			$sql = "UPDATE programme_machines SET produit = '$produit',machine = '$machine',
			date_ins = '$date_ins',debut = '$debut',fin = '$fin',timedebut = '$timedebut',
			timefin = '$timefin',stock_i = '$stock_i',stock_f = '$stock_f' WHERE id = '$user_id'";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			// delete user's profile
			$sql = "DELETE FROM programme_machines WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	$sql  = "SELECT * ";$today=date("y-m-d");$fin="0000-00-00";
	$sql .= "FROM programme_machines where fin='$fin' ORDER BY ordre;";
	$users = db_query($database_name, $sql);

	?>
	

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "Programme de Production encours "; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "programme_machine.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Programme de Production encours"; ?></span>

<? echo "<td><a href=\"programme_machine.php?user_id=0\">Ajout Machine au programme </a></td>";?>
<table class="table2">

<tr>
	<th><?php echo "Machine";?></th>
	<th><?php echo "Article";?></th>

</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>

<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["machine"];?></A></td>
<td><?php echo $users_["produit"]; $id=$users_["id"];$ordre=$users_["id"];?></td>
<? /*$sql = "UPDATE programme_machines SET ";
			$sql .= "ordre = '" . $ordre . "' ";
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);*/
			?>
<?php } ?>

</table>

<p style="text-align:center">


</body>

</html>