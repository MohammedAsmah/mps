<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	 if(isset($_REQUEST["action_"]))
	 {$id_production=$_POST["id_production"];
	 		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
				$intervention=$_REQUEST["intervention"];$operateur=$_REQUEST["operateur"];$date=dateFrToUs($_REQUEST["date"]);
				$date_ins=date("Y-m-d");$compteur=$_REQUEST["compteur"];$machine=$_REQUEST["machine"];
				$temps_arret_h=$_REQUEST["temps_arret_h"];$temps_arret_m=$_REQUEST["temps_arret_m"];$obs=$_REQUEST["obs"];
				
				$sql  = "INSERT INTO details_maintenances ( id_production,machine,date_ins,date,obs,intervention,operateur,compteur )
				VALUES ('$id_production','$machine','$date_ins','$date','$obs','$intervention','$operateur','$compteur')";
				db_query($database_name, $sql);
					
			break;

			case "update_user":

			$sql = "UPDATE details_maintenances SET ";
			$sql .= "intervention = '" . $_REQUEST["intervention"] . "', ";
			$sql .= "operateur = '" . $_REQUEST["operateur"] . "', ";
			$sql .= "compteur = '" . $_REQUEST["compteur"] . "', ";
			$sql .= "obs = '" . $_REQUEST["obs"] . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
					$sql  = "SELECT * ";
					$sql .= "FROM details_maintenances WHERE id = " . $_REQUEST["user_id"] . ";";
					$user = db_query($database_name, $sql); $user_ = fetch_array($user);
					$date = $user_["date"];$id_production = $user_["id_production"];

			// delete user's profile
			$sql = "DELETE FROM details_maintenances WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	 }else{

		$id_production=$_GET["id_production"];}
	
		$sql  = "SELECT * ";
		$sql .= "FROM maintenances WHERE id = " . $id_production . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$date = dateUsToFr($user_["date"]);$machine = $user_["machine"];

	$sql  = "SELECT * ";$today=date("y-m-d");
	$sql .= "FROM details_maintenances where id_production='$id_production' ORDER BY date;";
	$users = db_query($database_name, $sql);

	?>
	

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "Maintenance $date "; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--

--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Maintenance $date Sur la Machine : $machine"; ?></span>
<? echo "<span><a href=\"maintenance_detail.php?id_production=$id_production&user_id=0\">Ajout</a></span>";?>

<table class="table2">

<tr>
	<th><?php echo "Intervention";?></th>
	<th><?php echo "Operateur";?></th>
    <td width="180"><?php echo " Observations "; ?></td>
	<td width="180"><?php echo " Compteur "; ?></td>
		

</tr>
<?php $obs_g="";while($users_ = fetch_array($users)) { ?><tr>
<? $id_production=$id_production;$id=$users_["id"];$intervention=$users_["intervention"];$obs=$users_["obs"];$obs_g .= '<br>'.$obs_machine;$compteur=$users_["compteur"];
$m="<td><a href=\"maintenance_detail.php?machine=$machine&id_production=$id_production&user_id=$id\">$intervention</a></td>";print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$m </font>");?>
<td style="text-align:left"><?php $p=$users_["operateur"]; print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$p </font>");?></td>
<td style="text-align:center"><?php $compteur= $users_["compteur"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$obs </font>"); ?></td>
<td><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$compteur </font>"); ?></td>

<?php } ?>

</table>
<td><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$obs_g </font>"); ?></td>
<p style="text-align:center">

</body>

</html>