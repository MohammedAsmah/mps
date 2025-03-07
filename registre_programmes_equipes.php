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
			$date_ins=date("Y-m-d");$du=dateFrToUs($_REQUEST["du"]);$au=dateFrToUs($_REQUEST["au"]);
		}
		if ($user_login=="admin" or $user_login=="semhari" ){
		switch($_REQUEST["action_"]) {
			
			case "insert_new_user":
			
				
				$startTimeStamp = strtotime($du);
				$endTimeStamp = strtotime($au);

				$timeDiff = abs($endTimeStamp - $startTimeStamp);

				$numberDays = $timeDiff/86400;  // 86400 seconds in one day

				// and you might want to convert to integer
				$numberDays = intval($numberDays);
				
				$numberDays=$numberDays+1;
				
				$sql  = "INSERT INTO registre_programmes_equipes ( date_ins,du,au,obs )
				VALUES ('$date_ins','$du','$au','$numberDays')";
				db_query($database_name, $sql);$id_production=mysql_insert_id();

				
				$date=$du;
				
				//for ($i=0;$i<$numberDays;$i++){
								
				$sql1  = "SELECT * ";$etat="1";
				$sql1 .= "FROM machines where etat='$etat' ORDER BY id;";
				$users1 = db_query($database_name, $sql1);
				while($users_1 = fetch_array($users1)) { 
					for ($j=1;$j<=3;$j++){
					$machine=$users_1["designation"];
					$sql  = "INSERT INTO details_programmes_equipes ( id_production,date_ins,date,machine,poste )
					VALUES ('$id_production','$date_ins','$du','$machine','$j')";
					db_query($database_name, $sql);
					
					}
										
					}
					
				$date = strtotime("+1 day", strtotime($date));
				$date=date("Y-m-d", $date);
				
				//}
				
					

			break;

			case "update_user":

			$sql = "UPDATE registre_programmes_equipes SET ";
			$sql .= "du = '" . $du . "', ";$sql .= "au = '" . $au . "', ";
			$sql .= "obs = '" . $_REQUEST["obs"] . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			// delete user's profile
			$sql = "DELETE FROM registre_programmes_equipes WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			/*$sql = "DELETE FROM details_productions WHERE id_production = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);*/
			break;
			}

		} //switch
	} //if
	
	$du="";$action="Recherche";
			if(isset($_REQUEST["action"])){}else{
	?>
	<form id="form" name="form" method="post" action="registre_programmes_equipes.php">
	<table><td><?php echo "Du: "; ?><input onClick="ds_sh(this);" name="du" readonly="readonly" style="cursor: text" />
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td></td></table>
	</form>
	
	<? }
	if(isset($_REQUEST["action"]) or isset($_REQUEST["action_"]))
	{$du=dateFrToUs($_POST['du']);$date_f=$_POST['du'];
		
	$sql  = "SELECT * ";
	$sql .= "FROM registre_programmes_equipes where du='$du' ORDER BY du;";
	$users = db_query($database_name, $sql);
		}
		
		else
			
		{
	$sql  = "SELECT * ";$today=date("y-m-d");$date_f=date("d/m/Y");
	$sql .= "FROM registre_programmes_equipes where du='$today' ORDER BY du;";
	$users = db_query($database_name, $sql);}

	?>
	

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "Programme du : $date_f ===>"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "programme_equipe.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Programme du : $date_f ===>"; ?></span>

	<? if(isset($_REQUEST["action"]) or isset($_REQUEST["action_"])){?>
<? echo "<td><a href=\"programme_equipe.php?du=$date_f&user_id=0\">Ajout</a></td>";?>
	<? }?>
<table class="table2">

<tr>
	<th><?php echo "du";?></th>
	<th><?php echo "Observations";?></th>
	<th><?php echo "Actions";?></th>

</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>

<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo dateUsToFr($users_["du"])." au ".dateUsToFr($users_["au"]);?></A></td>
<td style="text-align:center"><?php echo $users_["obs"]; ?></td>
<? $id_production=$users_["id"];echo "<td><a href=\"programme_equipe_details.php?id_production=$id_production\">Details</a></td>";?>

<?php } ?>

</table>

<p style="text-align:center">

	<? if(isset($_REQUEST["action"]) or isset($_REQUEST["action_"])){?>

<? echo "<td><a href=\"programme_equipe.php?du=$date_f&user_id=0\">Ajout</a></td>";?>
	<? }?>

</body>

</html>