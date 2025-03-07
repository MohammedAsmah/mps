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
			$id_contrat = $_REQUEST["id_contrat"];$saison = $_REQUEST["saison"];
			$du = dateFrToUs($_REQUEST["du"]);
			$au = dateFrToUs($_REQUEST["au"]);


		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
				$type="retrait";
				$sql  = "INSERT INTO details_saisons ( id_contrat,saison,du, au )
				 VALUES ('$id_contrat','$saison','$du','$au')";

				db_query($database_name, $sql);
			

			break;

			case "update_user":
			$user_id=$_REQUEST["user_id"];
			
			$sql = "UPDATE details_saisons SET saison = '$saison',du = '$du',au = '$au' WHERE id = '$user_id'";
			db_query($database_name, $sql);
			
			break;
			
			case "delete_user":
			

			// delete user's profile
			$sql = "DELETE FROM details_saisons WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	}

	else
		{$id_contrat=$_GET["id_contrat"];}
	
	$sql  = "SELECT * ";$type="retrait";
	$sql .= "FROM details_saisons where id_contrat='$id_contrat' ORDER BY id;";
	$users = db_query($database_name, $sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste "; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "detail_saison.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Saison contrat : "; ?></span>

<table class="table2">

<tr>
	
	<th><?php echo "Saison";?></th>
	<th><?php echo "Du";?></th>
	<th><?php echo "Au";?></th>
	
	
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<?php $id=$users_["id"]; $du=dateUsToFr($users_["du"]);$au=dateUsToFr($users_["au"]);$saison=$users_["saison"];?>
<? echo "<td><a href=\"detail_saison.php?employe=$employe&user_id=$id\">$du</a></td>";?>
<td><?php echo $au; ?></td>
<td><?php echo $saison; ?></td>

<?php } ?>

</table>

<p style="text-align:center">
<? echo "<td><a href=\"retrait_employe.php?employe=$employe&user_id=0\">Ajout prelevement</a></td>";?>
</p>
</body>

</html>