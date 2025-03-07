<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) ) { 

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$employe = $_REQUEST["employe"];$ref = $_REQUEST["ref"];$service = $_REQUEST["service"];$s_h = $_REQUEST["s_h"];
			$poste = $_REQUEST["poste"];if(isset($_REQUEST["statut"])) { $statut = 1; } else { $statut = 0; }
			$mode = $_REQUEST["mode"];$paie = $_REQUEST["paie"];
		
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				$sql  = "INSERT INTO employes ( ref, employe,service,statut,poste,paie,mode,s_h )
				 VALUES ('$ref','$employe','$service','$statut','$poste','$paie','$mode','$s_h')";

				db_query($database_name, $sql);
			

			break;

			case "update_user":
			$user_id=$_REQUEST["user_id"];
			$sql = "UPDATE employes SET ref = '$ref',employe = '$employe',service = '$service',statut = '$statut'
			,poste = '$poste',mode = '$mode',paie = '$paie',s_h='$s_h' 
			 
			WHERE id = '$user_id'";
			db_query($database_name, $sql);
			
			break;
			
			case "delete_user":
			

			// delete user's profile
			$sql = "DELETE FROM employes WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	$sql  = "SELECT * ";$occ="occasionnelles";$per="permanents";$vide="";
	$sql .= "FROM employes where employe<>'$vide' and (service='$occ' or service='$per') and statut=1 ORDER BY service,employe;";
	$users = db_query($database_name, $sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste "; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "employe_sortie.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "liste "; ?></span>

<table class="table2">

<tr>
	
	<th><?php echo "operateur";?></th>
	<th><?php echo "service";?></th>
	<th><?php echo "Poste";?></th>
	<th><?php echo "Statut";?></th>	
	<th><?php echo "paie";?></th>		
	<th><?php echo "mode";?></th>
	
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["employe"];?></A></td>
<td><?php echo $users_["service"]; $ch=substr($users_["service"],0,22);$ch=Trim($ch);?></td>
<?php /*echo $ch; 
			$id=$users_["id"];
			$sql = "UPDATE employes SET service = '$ch' WHERE id = '$id'";
			db_query($database_name, $sql);*/

?>
<td><?php echo $users_["poste"]; ?></td>
<td><?php $statut=$users_["statut"]; if ($statut==1){echo "Sortie";}?></td>
<td><?php echo $users_["paie"]; ?></td>
<td><?php echo $users_["mode"]; ?></td>

<?php } ?>

</table>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>

</body>

</html>