<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	
			if(isset($_REQUEST["action"])){}else{$action="recherche";
	?>
	<form id="form" name="form" method="post" action="maj_echeances.php">
	<td><?php echo "Du : "; ?><input type="text" name="du" id="du" style="width:80px"/>
	<td><?php echo "Au : "; ?><input type="text" name="au" id="au" style="width:80px"/>
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }
	if(isset($_REQUEST["action"]))
	{
	
	$du=dateFrToUs($_POST['du']);$du1=$_POST['du'];$au=dateFrToUs($_POST['au']);$au1=$_POST['au'];}
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$designation = $_REQUEST["designation"];$banque = $_REQUEST["banque"];
			$montant_echeance = $_REQUEST["montant_echeance"];
			$date_echeance = dateFrToUs($_REQUEST["date_echeance"]);
			
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
		
			break;

			case "update_user":
			$user_id=$_REQUEST["user_id"];
			$sql = "UPDATE echeances_credits SET designation = '$designation',banque = '$banque',montant_echeance = '$montant_echeance',date_echeance = '$date_echeance' WHERE id = '$user_id'";
			db_query($database_name, $sql);

			break;
			
			case "delete_user":

			$sql = "DELETE FROM echeances_credits WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);$id_credit=$_REQUEST["user_id"];

			break;


		} //switch
	} //if
	
	$sql  = "SELECT * ";
	$sql .= "FROM echeances_credits where date_echeance between '$du' and '$au' ORDER BY id;";
	$users = db_query($database_name, $sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php  ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "maj_echeance.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php  ?></span>

<table class="table2">

<tr>
	<th><?php echo "Designation";?></th>
	<th><?php echo "Banque";?></th>
	<th><?php echo "Montant Echeance";?></th>
	<th><?php echo "Date Echeance";?></th>
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["designation"];?></A></td>
<td><?php echo $users_["banque"]; ?></td>
<td><?php echo $users_["montant_echeance"]; ?></td>
<td><?php echo dateUsToFr($users_["date_echeance"]); ?></td>
<?php } ?>

</table>

</body>

</html>