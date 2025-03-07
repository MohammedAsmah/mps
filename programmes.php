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
			if(isset($_REQUEST["affectation"])) { $affectation = 1; } else { $affectation = 0; }
		}
		if ($user_login=="admin" or $user_login=="nezha" or $user_login=="semhari" ){
		switch($_REQUEST["action_"]) {
			
			case "insert_new_user":
			
			
			//
			$sql  = "SELECT * ";
			$sql .= "FROM employes ORDER BY employe;";
			$users = db_query($database_name, $sql);
			while($users_ = fetch_array($users)) { 
			$id=$users_["id"];$vide="";$non="non";
			$sql = "UPDATE employes SET affectation='$non' 
			WHERE id = '$id'";
			db_query($database_name, $sql);
			} 
			
				$sql  = "INSERT INTO registre_programmes ( du,au,date_ins )
				VALUES ('$du','$au','$date_ins')";
				db_query($database_name, $sql);$id_semaine=mysql_insert_id();

				$sql1  = "SELECT * ";$today=date("y-m-d");$fin="0000-00-00";
				$sql1 .= "FROM programme_machines where fin='$fin' ORDER BY ordre;";
				$users1 = db_query($database_name, $sql1);
				while($users_1 = fetch_array($users1)) { 
					$machine=$users_1["machine"];$produit=$users_1["produit"];$ordre=$users_1["ordre"];
					$sql  = "INSERT INTO registre_postes ( id_semaine,du,au,produit,poste )
					VALUES ('$id_semaine','$du','$au','$produit','$machine')";
					db_query($database_name, $sql);
					
					}

			break;

			case "update_user":

			$sql = "UPDATE registre_programmes SET ";
			$sql .= "du = '" . $du . "', ";
			$sql .= "au = '" . $au . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
			$sql = "UPDATE registre_postes SET ";
			$sql .= "du = '" . $du . "', ";$sql .= "au = '" . $au . "' ";
			$sql .= "WHERE id_semaine = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
			
			
			$id_p=$_REQUEST["user_id"];
				
			
			
			break;
			
			case "delete_user":
			
			// delete user's profile
			$sql = "DELETE FROM registre_programmes WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			$sql = "DELETE FROM registre_postes WHERE id_semaine = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			}

		} //switch
	} //if
	
	$date="";$action="Recherche";
			if(isset($_REQUEST["action"])){}else{
	?>
	<form id="form" name="form" method="post" action="programmes.php">
	<table><td><?php echo "Du: "; ?><input onClick="ds_sh(this);" name="du" readonly="readonly" style="cursor: text" />
	<td><?php echo "Au: "; ?><input onClick="ds_sh(this);" name="au" readonly="readonly" style="cursor: text" />
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td></td></table>
	</form>
	
	<? }
	if(isset($_REQUEST["action"]) or isset($_REQUEST["action_"]))
	{$du=dateFrToUs($_POST['du']);$au=dateFrToUs($_POST['au']);
		
	$sql  = "SELECT * ";
	$sql .= "FROM registre_programmes where du='$du' and  au='$au' ORDER BY du;";
	$users = db_query($database_name, $sql);
		}
		
		else
			
		{
	$sql  = "SELECT * ";$today=date("y-m-d");$date_f=date("d/m/Y");
	$sql .= "FROM registre_programmes where du='$today' ORDER BY du;";
	$users = db_query($database_name, $sql);}

	?>
	

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "Programme du : $du au $au "; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "programme.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "" . "Programme du : $du au $au "; ?></span>

	<? if(isset($_REQUEST["action"]) or isset($_REQUEST["action_"])){?>
<? echo "<td><a href=\"programme.php?du=$du&au=$au&user_id=0\">Ajout</a></td>";?>
	<? }?>
<table class="table2">

<tr>
	<th><?php echo "Du";?></th>
	<th><?php echo "Au";?></th>
	<th><?php echo "Actions";?></th>

</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>

<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo dateUsToFr($users_["du"])." Au ".dateUsToFr($users_["au"]);?></A></td>

<? if ($user_login=="admin" or $user_login=="nezha" or $user_login=="semhari"){
$id_production=$users_["id"];echo "<td><a href=\"programmes_details.php?id_production=$id_production\">Details</a></td>";
}
 if ($user_login=="admin" or $user_login=="semhari" ){
$id_production=$users_["id"];echo "<td><a href=\"\\mps\\tutorial\\programme_semaine.php?id_production=$id_production\">Imprimer Programme</a></td>";
}
?>
<?php } ?>

</table>

<p style="text-align:center">

	<? if(isset($_REQUEST["action"]) or isset($_REQUEST["action_"])){?>

<? echo "<td><a href=\"programme.php?du=$du&au=$au&user_id=0\">Ajout</a></td>";?>
	<? }?>

</body>

</html>