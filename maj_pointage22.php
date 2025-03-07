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
			$employe = $_REQUEST["employe"];$ref = $_REQUEST["ref"];$service = $_REQUEST["service"];$poste = $_REQUEST["poste"];
			$poste = $_REQUEST["poste"];if(isset($_REQUEST["statut"])) { $statut = 1; } else { $statut = 0; }
			$t_h_normales = $_REQUEST["t_h_normales"];$t_h_25 = $_REQUEST["t_h_25"];$t_h_50 = $_REQUEST["t_h_50"];
			if(isset($_REQUEST["manual"])) { $manual = 1; } else { $manual = 0; }
				$sam_m = $_REQUEST["sam_m"];$dim_m = $_REQUEST["dim_m"];$lun_m = $_REQUEST["lun_m"];$mar_m = $_REQUEST["mar_m"];
			$mer_m = $_REQUEST["mer_m"];$jeu_m = $_REQUEST["jeu_m"];$ven_m = $_REQUEST["ven_m"];
			$sam_s = $_REQUEST["sam_s"];$dim_s = $_REQUEST["dim_s"];$lun_s = $_REQUEST["lun_s"];$mar_s = $_REQUEST["mar_s"];
			$mer_s = $_REQUEST["mer_s"];$jeu_s = $_REQUEST["jeu_s"];$ven_s = $_REQUEST["ven_s"];
			$sam_sup = $_REQUEST["sam_sup"];$dim_sup = $_REQUEST["dim_sup"];$lun_sup = $_REQUEST["lun_sup"];$mar_sup = $_REQUEST["mar_sup"];
			$mer_sup = $_REQUEST["mer_sup"];$jeu_sup = $_REQUEST["jeu_sup"];$ven_sup = $_REQUEST["ven_sup"];
			if(isset($_REQUEST["valide"])) { $valide = 1; } else { $valide = 0; }
			
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				$sql  = "INSERT INTO employes ( code, employe,service,statut,poste )
				 VALUES ('$ref','$employe','$service','$statut','$poste')";

				db_query($database_name, $sql);
			

			break;

			case "update_user":
			$user_id=$_REQUEST["user_id"];
			$sql = "UPDATE employes SET ref = '$ref',employe = '$employe',t_h_normales='$t_h_normales',
				t_h_25='$t_h_25',t_h_50='$t_h_50',valide='$valide',poste='$poste',manual='$manual',statut='$statut', 
				sam_m='$sam_m',dim_m='$dim_m',lun_m='$lun_m',mar_m='$mar_m',mer_m='$mer_m',jeu_m='$jeu_m',ven_m='$ven_m',
			sam_s='$sam_s',dim_s='$dim_s',lun_s='$lun_s',mar_s='$mar_s',mer_s='$mer_s',jeu_s='$jeu_s',ven_s='$ven_s',
			sam_sup='$sam_sup',dim_sup='$dim_sup',lun_sup='$lun_sup',mar_sup='$mar_sup',mer_sup='$mer_sup',jeu_sup='$jeu_sup',ven_sup='$ven_sup'
			
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
	$sql .= "FROM employes where employe<>'$vide' and statut=0 and (service='$occ' or service='$per') and controle=1 ORDER BY service,employe;";
	$users = db_query($database_name, $sql);$erreur=0;$compteur=0;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste "; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "employe2.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "liste "; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Nom et Prenom ";?></th>
	<th><?php echo "H.N";?></th>
	<th><?php echo "H.25%";?></th>
	<th><?php echo "H.50%";?></th>
	<th><?php echo "H.100%";?></th>
	<th><?php echo "Total H.";?></th>	
	<th><?php echo "Controle";?></th>		
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<td><?php echo $users_["employe"]; ?></td>
<td><?php echo number_format($users_["t_h_normales"],2,',',' '); ?></td>
<td><?php echo number_format($users_["t_h_25"],2,',',' '); ?></td>
<td><?php echo number_format($users_["t_h_50"],2,',',' '); ?></td>
<td><?php echo number_format($users_["t_h_100"],2,',',' '); ?></td>
<td><?php $tt=$users_["t_h_normales"]+($users_["t_h_25"]*1.25)+($users_["t_h_50"]*1.50);
echo number_format($tt,2,',',' ');?></td>

<?php } ?>

</table>

<p style="text-align:center">


</body>

</html>