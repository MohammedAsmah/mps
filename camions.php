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
			$chauffeur = $_REQUEST["chauffeur"];$longueur = $_REQUEST["longueur"];$matricule = $_REQUEST["matricule"];$telephone = $_REQUEST["telephone"];$permis = $_REQUEST["permis"];

		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				$sql  = "INSERT INTO rs_data_camions ( matricule,chauffeur,longueur,telephone,permis ) VALUES ('$matricule','$chauffeur','$longueur','$telephone','$permis')";

				db_query($database_name, $sql);
			

			break;

			case "update_user":

			$sql = "UPDATE rs_data_camions SET ";
			$sql .= "matricule = '" . $matricule . "', ";
			$sql .= "longueur = '" . $longueur . "', ";
			$sql .= "telephone = '" . $telephone . "', ";
			$sql .= "permis = '" . $permis . "', ";
			$sql .= "chauffeur = '" . $chauffeur . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			// delete user's profile
			$sql = "DELETE FROM rs_data_camions WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	$sql  = "SELECT * ";$vide="";
	$sql .= "FROM rs_data_camions where matricule<>'=vide' ORDER BY matricule;";
	$users = db_query($database_name, $sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "camion.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo ""; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Matricule";?></th>	
<th><?php echo "Chauffeur";?></th>
<th><?php echo "Permis";?></th>
<th><?php echo "Volume";?></th>
<th><?php echo "Telephone";?></th>
<th><?php echo "Compteur";?></th>
<th><?php echo "Dernier Chargement";?></th>
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["matricule"];?></A></td>
<td><?php echo $users_["chauffeur"];?></td>
<td><?php echo $users_["permis"];?></td>
<td><?php echo $users_["longueur"];?></td>
<td><?php echo $users_["telephone"];?></td>


<?  $matricule=$users_["matricule"];$sql  = "SELECT * ";$c=0;$vers="";$last="";
	$sql .= "FROM registre_vendeurs where matricule='$matricule'  group by date ORDER BY date ASC;";
	$usersc = db_query($database_name, $sql);
	$users_c = fetch_array($usersc);
	$last=$users_c["date"];
	/*while($users_c = fetch_array($usersc)) {
	$c=$c+1;$last=$users_c["date"];$vers=$users_c["service"]." - ".$users_c["vendeur"];
	}*/
	
	?>
<td><?php //echo $c;?></td>
<td><?php $d=dateUsTofr($last);if ($d=="//"){$d="";}$histo=$d." ".$vers; echo "<a href=\"histo_camion.php?matricule=$matricule\">".$histo."</a>"; ?></td>




<?php } ?>

</table>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>

<table class="table2">

<tr>
	<th><?php echo "Matricule";?></th>	

<th><?php echo "Dernier Chargement";?></th>
</tr>

<? $sql  = "SELECT * ";$c=0;$vers="";$last="";$exe1="2024-01-01";$exe2="2024-09-30";
	$sql .= "FROM registre_vendeurs where date between '$exe1' and '$exe2' group by matricule ORDER BY date DESC;";
	$usersc = db_query($database_name, $sql);
	
	while($users_c = fetch_array($usersc)) {
	$c=$c+1;$last=$users_c["date"];$vers=$users_c["service"]." - ".$users_c["vendeur"];
	?><tr><td><?php echo $users_c["matricule"];$mm=$users_c["matricule"];?></td>
		<td><?php $d=dateUsTofr($last);if ($d=="//"){$d="";}$histo=$d." ".$vers; echo "<a href=\"histo_camion.php?matricule=$mm\">".$histo."</a>"; ?></td></tr>
	<? }
	
	?>



</table>


</body>

</html>