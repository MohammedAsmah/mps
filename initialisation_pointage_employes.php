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
			$employe = $_REQUEST["employe"];$ref = $_REQUEST["ref"];$service = $_REQUEST["service"];
			$poste = $_REQUEST["poste"];if(isset($_REQUEST["statut"])) { $statut = 1; } else { $statut = 0; }
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				$sql  = "INSERT INTO employes ( code, employe,service,statut,poste )
				 VALUES ('$ref','$employe','$service','$statut','$poste')";

				db_query($database_name, $sql);
			

			break;

			case "update_user":
			$user_id=$_REQUEST["user_id"];
			$sql = "UPDATE employes SET ref = '$ref',employe = '$employe',service = '$service',statut = '$statut'
			,poste = '$poste'			WHERE id = '$user_id'";
			db_query($database_name, $sql);
			
			break;
			
			case "delete_user":
			

			// delete user's profile
			$sql = "DELETE FROM employes WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	$sql  = "SELECT * ";
	$sql .= "FROM employes ORDER BY employe;";
	$users = db_query($database_name, $sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste "; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "employe.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "liste "; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Code";?></th>
	<th><?php echo "operateur";?></th>
	<th><?php echo "service";?></th>
	<th><?php echo "Poste";?></th>
	<th><?php echo "Statut";?></th>	
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["ref"];?></A></td>
<td><?php echo $users_["employe"]; ?></td>
<td><?php echo $users_["service"]; $ch=substr($users_["service"],0,22);$ch=Trim($ch);?></td>
<td><?php echo $ch; 
			$id=$users_["id"];$vide="";
			$sql = "UPDATE employes SET valide = 0,t_h_normales=0,t_h_25=0,t_h_50=0,t_h_100=0,
			sam_m=0,dim_m=0,lun_m=0,mar_m=0,mer_m=0,jeu_m=0,ven_m=0,
			sam_s=0,dim_s=0,lun_s=0,mar_s=0,mer_s=0,jeu_s=0,ven_s=0,observations='$vide',
			sam_sup=0,dim_sup=0,lun_sup=0,mar_sup=0,mer_sup=0,jeu_sup=0,ven_sup=0,heures=0,
			valide_sam=0,valide_dim=0,valide_lun=0,valide_mar=0,valide_mer=0,valide_jeu=0,valide_ven=0,cloture=0,  		
			motif_sam='$vide',motif_dim='$vide',motif_lun='$vide',motif_mar='$vide',motif_mer='$vide',motif_jeu='$vide',
			motif_ven='$vide' 
			WHERE id = '$id'";
			db_query($database_name, $sql);

?></td>
<td><?php echo $users_["poste"]; ?></td>
<td><?php $statut=$users_["statut"]; if ($statut==1){echo "Sortie";}?></td>

<?php } ?>

</table>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>

</body>

</html>