<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$user_name=GetUserName();
	$error_message = "";
	$type_service="TRANSFERTS";
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"])) { 
		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$date = dateFrToUs($_REQUEST["date"]);
			$service=$_REQUEST["service"];
			$v_ref=$_REQUEST["v_ref"];
			$noms=$_REQUEST["noms"];
			$client=$_REQUEST["client"];
			$adultes=$_REQUEST["adultes"];
			$enfants=$_REQUEST["enfants"];
			$stay=$_REQUEST["stay"];
			$statut=$_REQUEST["statut"];
			$date_open=$_REQUEST["date_open"];
			$user_open=$user_name;
/*			$date_cancel=$_REQUEST["date_cancel"];
			$user_cancel=$_REQUEST["user_cancel"];
			$motif_cancel=$_REQUEST["motif_cancel"];*/
			$observation=$_REQUEST["observation"];
			$motif_cancel=$_REQUEST["motif_cancel"];
			
			
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
	// recherche contrat			
		$sql  = "SELECT * FROM contrats_sejours WHERE last_name=\"$client\" and first_name=\"$service\"".";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$code_produit="";
		$code_produit=$user_["user_id"];
			
				$type_service="TRANSFERTS";
				$sql  = "INSERT INTO registre_transferts_rak (date,service,client,v_ref,noms,adultes,enfants,stay,date_open,user_open,observation,statut,type_service,code_produit ) VALUES ('$date','$service','$client','$v_ref','$noms','$adultes','$enfants','$stay','$date_open','$user_open','$observation','$statut','$type_service','$code_produit')";

				db_query($database_name, $sql);
			

			break;

			case "update_user":
			
			$sql = "UPDATE registre_transferts_rak SET ";
			$sql .= "statut = '" . $_REQUEST["statut"] . "', ";
			$sql .= "observation = '" . $observation . "', ";

			$sql .= "v_ref = '" . $v_ref . "', ";
			$sql .= "noms = '" . $noms . "', ";
			$sql .= "adultes = '" . $adultes . "', ";
			$sql .= "enfants = '" . $enfants . "', ";
			$sql .= "stay = '" . $stay . "', ";

			$sql .= "motif_cancel = '" . $motif_cancel . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			// delete details
			$sql4 = "DELETE FROM details_bookings_sejours_transferts_rak WHERE id_registre = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql4);
			
			// delete user's profile
			$sql = "DELETE FROM registre_transferts_rak WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	else {$client="";$date1="";}
	if(isset($_REQUEST["action_"])) { $date1 = $_REQUEST["date"];$client=$_REQUEST["client"];}

	$action="recherche";
	$client_list = "";
	$sql = "SELECT * FROM  rs_data_clients ORDER BY last_name;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($client == $temp_["last_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$client_list .= "<OPTION VALUE=\"" . $temp_["last_name"] . "\"" . $selected . ">";
		$client_list .= $temp_["last_name"]." === ".$temp_["first_name"];
		$client_list .= "</OPTION>";
	}
	
	
	?>
	<form id="form" name="form" method="post" action="registres_it_transferts.php">
	<td><?php echo "Date : "; ?>
	<input type="text" id="date1" name="date1" value="<?php echo $date1; ?>">
	<?php echo "Client : "; ?><select id="client" name="client"><?php echo $client_list; ?></select>
	<input type="submit" id="action" name="action" value="<?php echo $action; ?>">
	</form>
	
	<?
	$date="";$client="";
	if(isset($_REQUEST["action"]))
	{ $date=dateFrToUs($_POST['date1']);$client=$_POST['client'];}
	if(isset($_REQUEST["action_r"]))
	{ $date=dateFrToUs($_GET['date']);$client=$_GET['client'];}
	if(isset($_REQUEST["action_r1"]))
	{ $date=dateFrToUs($_GET['date']);$client=$_GET['client'];}
	$type_s="TRANSFERTS";
	$sql  = "SELECT * ";
	$sql .= "FROM registre_transferts_rak where type_service='$type_s' and date='$date' and client='$client' ORDER BY id;";
	$users = db_query($database_name, $sql);
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "registre_it_transfert.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo ""; ?></span>

<th><?php echo "Client : ".$client;?></th>

<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Ref";?></th>
	<th><?php echo "Noms";?></th>
	<th><?php echo "Statut";?></th>
	<th><?php echo "Utilisateur";?></th>
	
	
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["v_ref"]; ?></A></td>
<td><?php echo $users_["noms"]; ?></td>
<td><?php echo $users_["statut"]; ?></td>
<td><?php echo $users_["user_open"]; ?></td>
<? $id_r=$users_["id"];$date3=$users_["date"];$client3=$users_["client"];$service=$users_["service"];
$code=$users_["code_produit"];$v_ref=$users_["v_ref"];$noms=$users_["noms"];
echo "<td><a href=\"bookings_it.php?v_ref=$v_ref&noms=$noms&id_registre=$id_r&date=$date3&client=$client3&service=$service&code=$code\">"."Itineraire"."</a></td>";?>
<?php } ?>

</table>
<table>
<tr><td><? /*echo "<td><a href=\"bookings_edit_sans_lp_global.php?date=$date&client=$client\">"." Liste Arrivées du ".dateUsToFr($date)."  "."</a></td>";?></td></tr>
<tr><td><? echo "<td><a href=\"bookings_edit_sans_lp_global_depart.php?date=$date&client=$client\">"." Liste Départs du ".dateUsToFr($date)."</a></td>";?></td></tr>
<tr><td><? echo "<td><a href=\"bookings_edit_sans_lp_global_depart_transferts.php?date=$date&client=$client\">"." Liste Transferts Départs du ".dateUsToFr($date)."</a></td>";*/?></td></tr>

</table>
</strong>
<p style="text-align:center">

<? echo "<td><a href=\"registre_it_transfert.php?date=$date&client=$client&user_id=0\">"."Ajout Nouveau Client"."</a></td>";?>


</body>

</html>