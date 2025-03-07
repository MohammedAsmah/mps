<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
$error_message = "";
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$login = $user_["login"];
	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$designation = $_REQUEST["designation"];$code = $_REQUEST["code"];
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				$sql  = "INSERT INTO machines ( code, designation )
				 VALUES ('$code','$designation')";

				db_query($database_name, $sql);
			

			break;

			case "update_user":
			$user_id=$_REQUEST["user_id"];
			$sql = "UPDATE machines SET code = '$code',designation = '$designation' WHERE id = '$user_id'";
			db_query($database_name, $sql);
			
			break;
			
			case "delete_user":
			

			// delete user's profile
			$sql = "DELETE FROM machines WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	$sql  = "SELECT * ";$vide="";
	$sql .= "FROM machines where designation<>'$vide' ORDER BY ordre;";
	$users = db_query($database_name, $sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title><?php echo "" . "liste "; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "machine.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>
<? $sql  = "SELECT * ";
	$sql .= "FROM periodes ORDER BY id;";
	$users2 = db_query($database_name, $sql);
	while($users_2 = fetch_array($users2)) 
	{ if ($users_2["encours"]==1){$du=$users_2["du"];$au=$users_2["au"];$du_f=dateFrToUs($users_2["du"]);$au_f=dateFrToUs($users_2["au"]);}
	}
	 ?>
<span style="font-size:24px"><?php echo "<td>Etat Production </td>"; ?></span>

<table class="table2">

<tr>
	
	<th><?php echo "Machine";?></th>
	<th><?php echo "Jours ";?></th>
	<th><?php echo "Pieces ";?></th>
	<th><?php echo "Rebus (kg) ";?></th>
	
	<th><?php echo "Historique Production";?></th>
	<th><?php echo "Historique Entretien";?></th>
	<th><?php echo "Historique Pièces rechange";?></th>
	
	
</tr>

<?php 

$du_f="2008-01-01";$au_f="2025-12-31";

while($users_ = fetch_array($users)) { 

	
	$machine=$users_["designation"];
	$sql  = "SELECT machine,produit,date,sum(prod_6_14) as t_prod_6_14,sum(prod_14_22) as t_prod_14_22,sum(prod_22_6) as t_prod_22_6,
	sum(temps_arret_h_1) as t_temps_arret_h1,sum(temps_arret_m_1) as t_temps_arret_m1,
	sum(temps_arret_h_2) as t_temps_arret_h2,sum(temps_arret_m_2) as t_temps_arret_m2,
	sum(temps_arret_h_3) as t_temps_arret_h3,sum(temps_arret_m_3) as t_temps_arret_m3,
	sum(rebut_1) as t_rebut1,sum(rebut_2) as t_rebut2,sum(rebut_3) as t_rebut3,sum(poids_1) as t_poids,
	sum(tc1) as t_tc1,sum(tc2) as t_tc2,sum(tc3) as t_tc3 ";$today=date("y-m-d");
	$sql .= "FROM details_productions where machine='$machine' and date between '$du_f' and '$au_f' group by id ORDER BY date;";
	$users1 = db_query($database_name, $sql);
	
	$obs_g="";$jour=0;$t_total=0;$t_rebut=0;
	
	while($users_1 = fetch_array($users1)) { 
	$id_production=$id_production;$id=$users_1["id"];$machine=$users_1["machine"];$obs_machine=$users_1["obs_machine"];
	$p=$users_1["produit"];$jour=$jour+1; 

	$total= $users_1["t_prod_22_6"]+$users_1["t_prod_6_14"]+$users_1["t_prod_14_22"];
	$h= $users_1["t_temps_arret_h1"]+$users_1["t_temps_arret_h2"]+$users_1["t_temps_arret_h3"];
	$m=$users_1["t_temps_arret_m1"]+$users_1["t_temps_arret_m2"]+$users_1["t_temps_arret_m3"];
	$h_m=$m/60;$h=$h+$h_m;
	$rebut= $users_1["t_rebut1"]+$users_1["t_rebut2"]+$users_1["t_rebut3"];
	$t_rebut=$t_rebut+($rebut/1000);
	$t_total=$t_total+$total;
	$poids= $users_1["t_poids"];

	}

	//if ($jour>0){
	
	?>


<tr>
<? if ($login == "admin"){?>
<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["designation"];?></A></td>
<? } else {?>
<td><?php echo $users_["designation"];?></td>
<? } ?>
<?php  $id=$users_["id"];$ordre=$users_["id"];?>
<td align="center"><?php  echo $jour;?></td>
<td align="center"><?php  echo $t_total ;?></td>
<td align="center"><?php  echo $t_rebut ;?></td>
<? echo "<td><a href=\"productions_details_machines.php?machine=$machine&du=$du_f&au=$au_f\">Afficher</a></td>";?>
<? echo "<td><a href=\"productions_details_machines_obs.php?machine=$machine&du=$du_f&au=$au_f\">Afficher</a></td>";?>
<? echo "<td><a href=\"productions_details_machines_obs1.php?machine=$machine&du=$du_f&au=$au_f\">Afficher</a></td>";?>
<?php //} 

}

?>

</table>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>

</body>

</html>