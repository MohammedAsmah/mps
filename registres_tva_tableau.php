<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$user_login = $user_["login"];

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$login = $_REQUEST["login"];
			
			$du = dateFrToUs($_REQUEST["du"]);$au = dateFrToUs($_REQUEST["au"]);
			$annee = $_REQUEST["annee"];$ca_annee = $_REQUEST["ca_annee"];$ca_declare = $_REQUEST["ca_declare"];
			$clients_n = $_REQUEST["clients_n"];$ca_exonore = $_REQUEST["ca_exonore"];
			$effets_recevoir_n = $_REQUEST["effets_recevoir_n"];
			$clients_douteux_n = $_REQUEST["clients_douteux_n"];
			$a_c_n = $_REQUEST["a_c_n"];
			$clients_n_1 = $_REQUEST["clients_n_1"];
			$effets_recevoir_n_1 = $_REQUEST["effets_recevoir_n_1"];
			$clients_douteux_n_1 = $_REQUEST["clients_douteux_n_1"];
			$a_c_n_1 = $_REQUEST["a_c_n_1"];
			
		}
		if ($user_login=="admin" or $user_login=="rakia" or $user_login=="Radia" or $user_login=="najat"){
		
		
		switch($_REQUEST["action_"]) {
		

			
			case "update_user":
			$user_id=$_REQUEST["user_id"];
			$sql = "UPDATE registres_tva SET du = '$du',au = '$au',ca_exonore='$ca_exonore',ca_declare='$ca_declare',ca_annee='$ca_annee',annee='$annee',clients_n='$clients_n',effets_recevoir_n='$effets_recevoir_n',clients_douteux_n='$clients_douteux_n',
			a_c_n='$a_c_n',clients_n_1='$clients_n_1',effets_recevoir_n_1='$effets_recevoir_n_1',clients_douteux_n_1='$clients_douteux_n_1',
			a_c_n_1='$a_c_n_1'		
			 WHERE id = '$user_id'";
			db_query($database_name, $sql);
			
			break;
			
			case "delete_user":
			

			
			break;


	
		} //switch
	} //if
		} //if
	$sql  = "SELECT * ";
	$sql .= "FROM registres_tva ORDER BY du;";
	$users = db_query($database_name, $sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "MISE A JOUR TVA"; ?></title>

<link rel="stylesheet" type="text/css" href="css/bootstrap.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "registre_tva_tableau.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "MISE A JOUR FORMULE TVA"; ?></span>

<table class="table table-striped">

<tr>
	<th><?php echo "Annee";?></th>
	<th><?php echo "DU";?></th>
	<th><?php echo "AU";?></th>
	<th><?php echo "CA A DECLARE CALCULE";?></th>
	<th><?php echo "CA DECLARE REEL";?></th>
	
	<th><?php echo "DIFFERENCE";?></th>
	
	
	
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["annee"];?></A></td>
<?php $id=$users_["id"];$du=dateUsToFr($users_["du"]); $au=dateUsToFr($users_["au"]);?>

<td><?php echo $du; ?></td>
<td><?php echo $au; ?></td>
<? 			$clients_n = $users_["clients_n"];$ca_annee = $users_["ca_annee"];$ca_declare = $users_["ca_declare"];$ca_exonore = $users_["ca_exonore"];
			$effets_recevoir_n = $users_["effets_recevoir_n"];
			$clients_douteux_n = $users_["clients_douteux_n"];
			$a_c_n = $users_["a_c_n"];
			$clients_n_1 = $users_["clients_n_1"];
			$effets_recevoir_n_1 = $users_["effets_recevoir_n_1"];
			$clients_douteux_n_1 = $users_["clients_douteux_n_1"];
			$a_c_n_1 = $users_["a_c_n_1"];
			
			$ca_a_declare = ($ca_annee-$ca_exonore)*1.20+($clients_n_1+$effets_recevoir_n_1+$clients_douteux_n_1)-($a_c_n_1+$clients_n+$effets_recevoir_n+$clients_douteux_n)+$a_c_n;
			
?>
<td align="center"><?php echo number_format($ca_a_declare,2,',',' '); ?></td>
<td align="center"><?php echo number_format($ca_declare,2,',',' '); ?></td>
<td align="center"><?php echo number_format($ca_a_declare-$ca_declare,2,',',' '); ?></td>
<?php } ?>

</table>

<p style="text-align:center">



</body>

</html>