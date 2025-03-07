<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$du="";$au="";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$valider_f = $_REQUEST["valider_f"];$client = $_REQUEST["client"];
			
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
			

			break;

			case "update_user":
			$sql = "UPDATE commandes SET ";
			$sql .= "client = '" . $client . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE commande = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);



			break;
			
			case "delete_user":
			
			break;


		} //switch
	} //if
	
	
	// recherche ville
		?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Evaluations"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "detail_evaluation.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";
	$action="recherche";
	$date="";$client="";$eva="";
	$client_list = "";
	$sql = "SELECT * FROM  clients ORDER BY ref;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($client == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
		
		$client_list .= "<OPTION VALUE=\"" . $temp_["ref"] . "\"" . $selected . ">";
		$client_list .= $temp_["ref"]." === ".$temp_["client"];
		$client_list .= "</OPTION>";
	}
	?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>
<span style="font-size:24px"><?php echo "liste Evaluations"; ?></span>
	
	<form id="form" name="form" method="post" action="editer_evaluations_details.php">
	<td><?php echo "Du : "; ?><input type="text" id="du" name="du" value="<?php echo $du; ?>" size="15"></td>
	<td><?php echo "Au : "; ?><input type="text" id="au" name="au" value="<?php echo $au; ?>" size="15"></td>
	<input type="submit" id="action" name="action" value="<?php echo $action; ?>">
	</form>

<?	
	
	if(isset($_REQUEST["action"]))
	{ $du=DateFrToUs($_POST['du']);$au=DateFrToUs($_POST['au']);
	
	$sql  = "SELECT * ";
	/*$sql .= "FROM commandes where date_e between '$du' and '$au' ORDER BY commande;";*/
	$sql .= "FROM detail_commandes  ORDER BY commande;";
	$users = db_query($database_name, $sql);
	

//




?>
<table class="table2">
<td><?php echo $client;?></td>
<tr>
	<th><?php echo "Evaluation";?></th>
	<th><?php echo "Exercice";?></th>
	<th><?php echo "Date";?></th>
	<th><?php echo "Client";?></th>
	<th><?php echo "Vendeur";?></th>
	<th><?php echo "Montant";?></th>
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<? $commande=$users_["commande"];$produit=$users_["produit"];$quantite=$users_["quantite"];$prix_unit=$users_["prix_unit"];
$condit=$users_["condit"];$id=$users_["id"];

		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE ref = '$produit' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$pp = $user_["produit"];

			
			$sql = "UPDATE detail_commandes SET ";
			$sql .= "produit = '" . $pp . "' ";
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);
			
			
			?>


<?php } ?>

</table>

<p style="text-align:center">

<?php } ?>
</body>

</html>