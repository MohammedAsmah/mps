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
			$last_name = $_REQUEST["last_name"];$last_name1 = $_REQUEST["last_name1"];$login = $_REQUEST["login"];
			$remarks = $_REQUEST["remarks"];$remise2 = $_REQUEST["remise2"];$remise3 = $_REQUEST["remise3"];
			$vendeur = $_REQUEST["vendeur"];$ville = $_REQUEST["ville"];$patente = $_REQUEST["patente"];$inputation = $_REQUEST["inputation"];
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				$sql  = "INSERT INTO clients ( ref, client, patente,inputation,remise2,remise3,ville,vendeur_nom,adrresse )
				 VALUES ('$login','$last_name','$patente','$inputation','$remise2','$remise3','$ville','$vendeur','$remarks')";

				db_query($database_name, $sql);
			

			break;

			case "update_user":
			$user_id=$_REQUEST["user_id"];
			$sql = "UPDATE clients SET remise2 = '$remise2',patente = '$patente',inputation = '$inputation',remise3 = '$remise3',adrresse = '$remarks',
			client = '$last_name' , vendeur_nom = '$vendeur',ville = '$ville' WHERE id = '$user_id'";
			db_query($database_name, $sql);
			
			break;
			
			case "delete_user":
			

			// delete user's profile
			$sql = "DELETE FROM clients WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	$sql  = "SELECT client,vendeur_nom,ville,sum(er1_08) as er1_09_t, sum(eme2_08) as eme2_09_t,sum(eme3_08) as eme3_09_t,sum(eme4_08) as eme4_09_t ";
	$sql .= "FROM clients group by id ORDER BY vendeur_nom;";
	$users = db_query($database_name, $sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Clients"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">


</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "C.A PAR VENDEUR 01/01/2008 AU 31/12/2008"; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Ville";?></th>
	<th><?php echo "Vendeur";?></th>
	<th><?php echo "Client";?></th>
	<th><?php echo "1er 08";?></th>
	<th><?php echo "2eme 08";?></th>
	<th><?php echo "3eme 08";?></th>
	<th><?php echo "4eme 08";?></th>
	<th><?php echo "Total";?></th>
</tr>

<?php $t1=0;$t2=0;$t3=0;$t4=0;$t5=0;while($users_ = fetch_array($users)) { 

$t=$users_["er1_09_t"]+$users_["eme2_09_t"]+$users_["eme3_09_t"]+$users_["eme4_09_t"];
$t1=$t1+$users_["er1_09_t"];$vendeur=$users_["vendeur_nom"];
$t2=$t2+$users_["eme2_09_t"];
$t3=$t3+$users_["eme3_09_t"];
$t4=$t4+$users_["eme4_09_t"];
$t5=$t5+$t;
?>
<? if ($t>0){?>
<tr><td><?php echo $users_["ville"];?></td><td><?php echo $users_["vendeur_nom"];?></td><td><?php echo $users_["client"];?></td>
<td align="right"><?php echo number_format($users_["er1_09_t"],2,',',' '); ?></td>
<td align="right"><?php echo number_format($users_["eme2_09_t"],2,',',' '); ?></td>
<td align="right"><?php echo number_format($users_["eme3_09_t"],2,',',' '); ?></td>
<td align="right"><?php echo number_format($users_["eme4_09_t"],2,',',' '); ?></td>
<td align="right"><?php echo number_format($t,2,',',' '); ?></td>
<? }?>
	<? /*$sql  = "SELECT client,vendeur_nom,ville,sum(er1_08) as er1_08_t, sum(eme2_08) as eme2_08_t,sum(eme3_08) as eme3_08_t,sum(eme4_08) as eme4_08_t ";
	$sql .= "FROM clients where vendeur_nom='$vendeur_nom' group by client ORDER BY client;";
	$users1 = db_query($database_name, $sql);while($users_1 = fetch_array($users1)) { 

$t=$users_["er1_08_t"]+$users_["eme2_08_t"]+$users_["eme3_08_t"]+$users_["eme4_08_t"];
$t1=$t1+$users_["er1_08_t"];$vendeur=$users_["vendeur_nom"];
$t2=$t2+$users_["eme2_08_t"];
$t3=$t3+$users_["eme3_08_t"];
$t4=$t4+$users_["eme4_08_t"];
$t5=$t5+$t;*/?>



<?php } ?>
<tr>
<td></td><td align="right"><?php echo number_format($t1,2,',',' '); ?></td>
<td align="right"><?php echo number_format($t2,2,',',' '); ?></td>
<td align="right"><?php echo number_format($t3,2,',',' '); ?></td>
<td align="right"><?php echo number_format($t4,2,',',' '); ?></td>
<td align="right"><?php echo number_format($t5,2,',',' '); ?></td>
</tr>
</table>

<p style="text-align:center">

</body>

</html>