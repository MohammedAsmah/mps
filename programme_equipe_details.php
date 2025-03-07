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
	
	if(isset($_REQUEST["action_"]))
	 {$id_production=$_POST["id_production"];
	 
	 if ($user_login=="admin" or $user_login=="nezha" ){
	 		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
				$machine=$_REQUEST["machine"];$produit=$_REQUEST["produit"];$date=dateFrToUs($_REQUEST["date"]);
				$prod_6_14=$_REQUEST["prod_6_14"];$date_ins=date("Y-m-d");$prod_14_22=$_REQUEST["prod_14_22"];$prod_22_6=$_REQUEST["prod_22_6"];
				$rebut=$_REQUEST["rebut"];$poids=$_REQUEST["poids"];$tc1=$_REQUEST["tc1"];$tc2=$_REQUEST["tc2"];$tc3=$_REQUEST["tc3"];
				$temps_arret_h=$_REQUEST["temps_arret_h"];$temps_arret_m=$_REQUEST["temps_arret_m"];$obs_machine=$_REQUEST["obs_machine"];
				$sql  = "SELECT * ";
		$sql .= "FROM machines WHERE designation = '" . $machine . "';";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$ordre = $user_["ordre"];
				$sql  = "INSERT INTO details_productions ( id_production,produit,machine,ordre,date )
				VALUES ('$id_production','$produit','$machine','$ordre','$date')";
				db_query($database_name, $sql);
					
			break;

			case "update_user":
			$equipe=$_REQUEST["equipe"];
			if ($equipe==1){
			$sql = "UPDATE details_productions SET ";
			$sql .= "produit = '" . $_REQUEST["produit"] . "', ";
			$sql .= "machine = '" . $_REQUEST["machine"] . "', ";
			$sql .= "prod_6_14 = '" . $_REQUEST["prod_6_14"] . "', ";
			
			$sql .= "rebut_1 = '" . $_REQUEST["rebut"] . "', ";
			$sql .= "poids_1 = '" . $_REQUEST["poids"] . "', ";
			$sql .= "temps_arret_h_1 = '" . $_REQUEST["temps_arret_h"] . "', ";
			$sql .= "temps_arret_m_1 = '" . $_REQUEST["temps_arret_m"] . "', ";
			$sql .= "tc1 = '" . $_REQUEST["tc1"] . "', ";
			
			$sql .= "obs_machine_1 = '" . $_REQUEST["obs_machine"] . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			}
			if ($equipe==2){
			$sql = "UPDATE details_productions SET ";
			$sql .= "produit = '" . $_REQUEST["produit"] . "', ";
			$sql .= "machine = '" . $_REQUEST["machine"] . "', ";
			
			$sql .= "prod_14_22 = '" . $_REQUEST["prod_14_22"] . "', ";
			
			$sql .= "rebut_2 = '" . $_REQUEST["rebut"] . "', ";
			$sql .= "poids_2 = '" . $_REQUEST["poids"] . "', ";
			$sql .= "temps_arret_h_2 = '" . $_REQUEST["temps_arret_h"] . "', ";
			$sql .= "temps_arret_m_2 = '" . $_REQUEST["temps_arret_m"] . "', ";
			
			$sql .= "tc2 = '" . $_REQUEST["tc2"] . "', ";
			
			$sql .= "obs_machine_2 = '" . $_REQUEST["obs_machine"] . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			}
			if ($equipe==3){
			$sql = "UPDATE details_productions SET ";
			$sql .= "produit = '" . $_REQUEST["produit"] . "', ";
			$sql .= "machine = '" . $_REQUEST["machine"] . "', ";
			
			$sql .= "prod_22_6 = '" . $_REQUEST["prod_22_6"] . "', ";
			$sql .= "rebut_3 = '" . $_REQUEST["rebut"] . "', ";
			$sql .= "poids_3 = '" . $_REQUEST["poids"] . "', ";
			$sql .= "temps_arret_h_3 = '" . $_REQUEST["temps_arret_h"] . "', ";
			$sql .= "temps_arret_m_3 = '" . $_REQUEST["temps_arret_m"] . "', ";
			
			$sql .= "tc3 = '" . $_REQUEST["tc3"] . "', ";
			$sql .= "obs_machine_3 = '" . $_REQUEST["obs_machine"] . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			}
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
					$sql  = "SELECT * ";
					$sql .= "FROM details_productions WHERE id = " . $_REQUEST["user_id"] . ";";
					$user = db_query($database_name, $sql); $user_ = fetch_array($user);
					$date = $user_["date"];$id_production = $user_["id_production"];

			// delete user's profile
			$sql = "DELETE FROM details_productions WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			}

		} //switch
	 }else{

		$id_production=$_GET["id_production"];}
	
		$sql  = "SELECT * ";
		$sql .= "FROM productions WHERE id = " . $id_production . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$date = dateUsToFr($user_["date"]);

	$sql  = "SELECT * ";$today=date("y-m-d");
	$sql .= "FROM details_programmes_equipes where id_production='$id_production' group by machine ORDER BY id;";
	$users = db_query($database_name, $sql);

	?>
	

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "Production $date "; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--

--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Production $date"; ?></span>
<? echo "<span><a href=\"production_detail.php?id_production=$id_production&user_id=0\">Ajout</a></span>";?>

<table class="table2">

<tr>
		<th><?php echo "Machine";?></th>
		<td width="70"><?php echo "  06H-14H "; ?></td>
        <td width="70"><?php echo "  14H-22H "; ?></td>
        <td width="70"><?php echo "  22H-06H "; ?></td>
        

</tr>
<?php $obs_g="";while($users_ = fetch_array($users)) { ?><tr>
<? $id_production=$id_production;$id=$users_["id"];$machine=$users_["machine"];$obs_machine=$users_["obs_machine"];$obs_g .= '<br>'.$obs_machine;
$m="<td>$machine</td>";print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$m </font>");?>
<? $m="<td></td>";print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$m </font>");?>
<? $m="<td></td>";print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$m </font>");?>
<? $m="<td></td>";print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$m </font>");?>

<?php } ?>

</table>
<td><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$obs_g </font>"); ?></td>
<p style="text-align:center">


</body>

</html>