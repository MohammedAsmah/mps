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
			$date = dateFrToUs($_REQUEST["date"]);$date_fin = dateFrToUs($_REQUEST["date_fin"]);$article = $_REQUEST["article"];
			$base = $_REQUEST["base"];$promotion = $_REQUEST["promotion"];
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				$sql  = "INSERT INTO liste_promotions ( date, article, base,promotion,date_fin )
				 VALUES ('$date','$article','$base','$promotion','$date_fin')";

				db_query($database_name, $sql);
			

			break;

			case "update_user":
			$user_id=$_REQUEST["user_id"];
			$sql = "UPDATE liste_promotions SET date = '$date',date_fin = '$date_fin',base = '$base',promotion = '$promotion',article = '$article'
			 WHERE id = '$user_id'";
			db_query($database_name, $sql);
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			break;
			
			case "delete_user":
			

			// delete user's profile
			$sql = "DELETE FROM liste_promotions WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	$sql  = "SELECT * ";
	$sql .= "FROM liste_promotions ORDER BY article,date;";
	$users = db_query($database_name, $sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Promotions"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "promotion.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "liste Promotions"; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Article";?></th>
	<th><?php echo "Base";?></th>
	<th><?php echo "Promotion";?></th>
	<th><?php echo "Date fin";?></th>
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo dateUsToFr($users_["date"]);?></A></td>
<?php $id=$users_["id"];$article=$users_["article"]; $base=$users_["base"];?>
<td><?php echo $users_["article"]; ?></td>
<td><?php echo $users_["base"]; ?></td>
<td><?php echo $users_["promotion"]; ?></td>
<td><?php echo dateUsToFr($users_["date_fin"]); ?></td>
<?php } ?>

</table>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>

</body>

</html>