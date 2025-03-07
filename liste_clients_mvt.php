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
			$last_name = $_REQUEST["last_name"];$last_name1 = $_REQUEST["last_name1"];$login = $_REQUEST["login"];
			$remarks = $_REQUEST["remarks"];$remise10 = $_REQUEST["remise10"];$remise2 = $_REQUEST["remise2"];$remise3 = $_REQUEST["remise3"];
			$vendeur = $_REQUEST["vendeur"];$ville = $_REQUEST["ville"];
			if(isset($_REQUEST["remise10_v"])) { $remise10_v = 1; } else { $remise10_v = 0; }
			if(isset($_REQUEST["remise2_v"])) { $remise2_v = 1; } else { $remise2_v = 0; }
			if(isset($_REQUEST["remise3_v"])) { $remise3_v = 1; } else { $remise3_v = 0; }
			if(isset($_REQUEST["prix1"])) { $prix1 = 1; } else { $prix1 = 0; }
			if(isset($_REQUEST["prix2"])) { $prix2 = 1; } else { $prix2 = 0; }
			$type_remise = $_REQUEST["type_remise"];$escompte = $_REQUEST["escompte"];
			if(isset($_REQUEST["sans_escompte"])) { $sans_escompte = 1; } else { $sans_escompte = 0; }
			$sql2 .= "FROM rs_data_villes WHERE ville = '$ville' ;";
			$user2 = db_query($database_name, $sql2);
			$user_2 = fetch_array($user2);$region = $user_2["region"];
			
			
			$patente = $_REQUEST["patente"];$inputation = $_REQUEST["inputation"];
		}
		if ($user_login=="admin" or $user_login=="rakia" or $user_login=="Radia" or $user_login=="najat"){
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
				$date_update=date("y-m-d");
		
				$sql  = "INSERT INTO clients ( ref, client,user,date_update, type_remise,escompte,patente,inputation,remise10,remise2,remise3,ville,region,vendeur_nom,adrresse,remise10_v,remise2_v,remise3_v,prix1,prix2,sans_escompte )
				 VALUES ('$login','$last_name','$user_login','$date_update','$type_remise','$escompte','$patente','$inputation','$remise10','$remise2','$remise3','$ville','$region','$vendeur','$remarks','$remise10_v','$remise2_v','$remise3_v','$prix1','$prix2','$sans_escompte')";

				db_query($database_name, $sql);
			

			break;

			case "update_user":
			$user_id=$_REQUEST["user_id"];
			$sql = "UPDATE clients SET remise10 = '$remise10',remise2 = '$remise2',remise10_v = '$remise10_v',remise2_v = '$remise2_v',remise3_v = '$remise3_v',patente = '$patente',inputation = '$inputation',remise3 = '$remise3',adrresse = '$remarks',
			client = '$last_name' , vendeur_nom = '$vendeur', type_remise = '$type_remise', escompte = '$escompte',ville = '$ville',region = '$region',prix1 = '$prix1',prix2 = '$prix2',sans_escompte = '$sans_escompte' WHERE id = '$user_id'";
			db_query($database_name, $sql);
			
			$ancien_client=$_REQUEST["ancien_client"];
			if ($ancien_client<>$last_name){
			$sql = "UPDATE avoirs SET client = '$last_name' WHERE client = '$ancien_client'";
			db_query($database_name, $sql);
			$sql = "UPDATE commandes SET client = '$last_name' WHERE client = '$ancien_client'";
			db_query($database_name, $sql);
			$sql = "UPDATE detail_avoirs SET client = '$last_name' WHERE client = '$ancien_client'";
			db_query($database_name, $sql);
			$sql = "UPDATE detail_avoirs_pro SET client = '$last_name' WHERE client = '$ancien_client'";
			db_query($database_name, $sql);
			$sql = "UPDATE detail_commandes SET client = '$last_name' WHERE client = '$ancien_client'";
			db_query($database_name, $sql);
			$sql = "UPDATE factures SET client = '$last_name' WHERE client = '$ancien_client'";
			db_query($database_name, $sql);
			$sql = "UPDATE detail_factures SET client = '$last_name' WHERE client = '$ancien_client'";
			db_query($database_name, $sql);
			$sql = "UPDATE porte_feuilles SET client = '$last_name' WHERE client = '$ancien_client'";
			db_query($database_name, $sql);
			$sql = "UPDATE porte_feuilles_impayes SET client = '$last_name' WHERE client = '$ancien_client'";
			db_query($database_name, $sql);
			
						
			
			}
			
						
			break;
			
			case "delete_user":
			

			// delete user's profile
			$sql = "DELETE FROM clients WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
		} //switch
	} //if
	
	$vendeur="";$action="Filtrer";$ville="";
	$sql1 = "SELECT * FROM vendeurs ORDER BY vendeur;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($vendeur == $temp_["vendeur"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_vendeur .= "<OPTION VALUE=\"" . $temp_["vendeur"] . "\"" . $selected . ">";
		$profiles_list_vendeur .= $temp_["vendeur"];
		$profiles_list_vendeur .= "</OPTION>";
	}
	$sql2 = "SELECT * FROM rs_data_villes ORDER BY ville;";
	$temp = db_query($database_name, $sql2);
	while($temp_ = fetch_array($temp)) {
		if($ville == $temp_["ville"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_ville .= "<OPTION VALUE=\"" . $temp_["ville"] . "\"" . $selected . ">";
		$profiles_list_ville .= $temp_["ville"];
		$profiles_list_ville .= "</OPTION>";
	}
	
	if(isset($_REQUEST["action"])){?><form id="form" name="form" method="post" action="clients.php">
	<table><td><?php echo "Vendeur: "; ?></td><td><select id="vendeur" name="vendeur"><?php echo $profiles_list_vendeur; ?></select></td>
	<td><?php echo "Ville: "; ?></td><td><select id="ville" name="ville"><?php echo $profiles_list_ville; ?></select></td>
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form><?}
	
	if(isset($_REQUEST["action"]))
	{$vendeur=$_POST['vendeur'];$ville=$_POST['ville'];
	
	if ($ville==""){
	$sql  = "SELECT * ";$vide='';
	$sql .= "FROM clients where client<>'$vide' and vendeur_nom='$vendeur' ORDER BY vendeur_nom,client;";
	$users = db_query($database_name, $sql);
	}else{
	$sql  = "SELECT * ";$vide='';
	$sql .= "FROM clients where client<>'$vide' and vendeur_nom='$vendeur' and ville='$ville' ORDER BY vendeur_nom,client;";
	$users = db_query($database_name, $sql);
	}
	
	}
	else
	{
	$sql  = "SELECT * ";$vide='';
	$sql .= "FROM clients where client<>'$vide' ORDER BY vendeur_nom,client;";
	$users = db_query($database_name, $sql);
	}
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Clients"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "client.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "liste Client"; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Code";?></th>
	<th><?php echo "Nom";?></th>
	<th><?php echo "Vendeur";?></th>
	
	<th><?php echo "Ville";?></th>
	<th><?php echo "Dernier Mvt";?></th>
	<th><?php echo "Montant";?></th>
	
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<td><a href="JavaScript:EditUser(<?php $id=$users_["id"];echo $users_["id"]; ?>)"><?php echo $users_["id"];?></A></td>
<?php $id=$users_["id"];$client=$users_["client"]; $ref=$users_["vendeur"];?>
<? echo "<td><a href=\"compte_client.php?user_id=$id\">$client</a></td>";?>
<td><?php echo $users_["vendeur_nom"]; ?></td>
<td><?php echo $users_["ville"];$v=$users_["ville"];
 
?></td>


<? $sql  = "SELECT * ";
	$sql .= "FROM commandes where client='$client' ORDER BY date_e DESC;";
	$usersc = db_query($database_name, $sql);$users_c = fetch_array($usersc);
	$date_derniere=dateUstoFr($users_c["date_e"]);$montant=$users_c["net"];
	
	
	
	?>
<td><?php echo $date_derniere; ?></td>
<td><?php echo number_format($montant,2,',',' '); ?></td>




<?php } ?>

</table>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>
<tr>
<td align="center" bordercolor="#FFFBF0"><? $imp="Imprimer Liste";$link="<a href=\"liste_clients_pdf.php\">".$imp."</a>";?>
<?php print("<font size=\"5\" face=\"Comic sans MS\" color=\"000033\">$link </font>");?></td>
</tr>

</body>

</html>