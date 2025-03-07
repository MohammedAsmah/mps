<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$user_name=GetUserName();
	$error_message = "";
	$type_service="EXCURSIONS";
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"])) { 
		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$date = dateFrToUs($_REQUEST["date"]);
			$service=$_REQUEST["service"];
			$client=$_REQUEST["client"];
			$statut=$_REQUEST["statut"];
			$date_open=$_REQUEST["date_open"];
			$user_open=$user_name;
/*			$date_cancel=$_REQUEST["date_cancel"];
			$user_cancel=$_REQUEST["user_cancel"];
			$motif_cancel=$_REQUEST["motif_cancel"];*/
			$observation=$_REQUEST["observation"];
			$motif_cancel=$_REQUEST["motif_cancel"];
			$groupe=$_REQUEST["groupe"];
			$guide=$_REQUEST["guide"];
			$type_service=$_REQUEST["type_service"];
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
	// recherche contrat			
		$sql  = "SELECT * FROM contrats_transferts WHERE last_name=\"$client\" and first_name=\"$service\" ;";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$code_produit="";
		$code_produit=$user_["login"];
			
		$type_service="TRANSFERTS";
		$sql  = "INSERT INTO registre_lp_rak (date,service,client,date_open,user_open,observation,statut,type_service,code_produit,groupe,guide ) VALUES ('$date','$service','$client','$date_open','$user_open','$observation','$statut','$type_service','$code_produit','$groupe','$guide')";

		db_query($database_name, $sql);
			

			break;

			case "update_user":
					$sql  = "SELECT * FROM contrats_transferts WHERE last_name=\"$client\" and first_name=\"$service\" ;";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$code_produit="";
		$code_produit=$user_["login"];

			$sql = "UPDATE registre_lp_rak SET ";
			$sql .= "statut = '" . $_REQUEST["statut"] . "', ";
			$sql .= "observation = '" . $observation . "', ";
			$sql .= "date = '" . $date . "', ";
			$sql .= "service = '" . $service . "', ";
			$sql .= "type_service = '" . $type_service . "', ";
			$sql .= "client = '" . $client . "', ";
			$sql .= "guide = '" . $guide . "', ";
			$sql .= "groupe = '" . $groupe . "', ";
			$sql .= "code_produit = '" . $code_produit . "', ";
			$sql .= "motif_cancel = '" . $motif_cancel . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			// delete user's profile
			$sql = "DELETE FROM registre_lp_rak WHERE profile_id = " . $_REQUEST["user_id"] . ";";
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
	
	
	$action="recherche";
	$date="";
	?>
	
	<form id="form" name="form" method="post" action="registres_factures.php">
	<td><?php echo "Date : "; ?><input onclick="ds_sh(this);" name="date1" readonly="readonly" style="cursor: text" /></td>
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
	$sql .= "FROM registre_lp_rak where type_service='$type_s' and date='$date' and client='$client' ORDER BY id;";
	$users = db_query($database_name, $sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "registre_transfert.php?user_id=" + user_id; }
	function EditUser1(user_id) { document.location = "registre_transfert_annuler.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo ""; ?></span>

<table class="table2">

<tr>
	<th><?php echo "LP";?></th>
	<th><?php echo "Date";?></th>
	<th><?php echo "Code";?></th>
	<th><?php echo "Service";?></th>
	<th><?php echo "Client";?></th>
	<th><?php echo "Statut";?></th>
	<th><?php echo "Utilisateur";?></th>
	<th><?php echo "Participants";?></th>
	
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["id"]+200000;?></A></td>
<td><?php echo dateUsToFr($users_["date"]); ?></td>
<td><?php echo $users_["code_produit"]; ?></td>
<td><?php echo $users_["service"]; ?></td>
<td><?php echo $users_["client"]; ?></td>
<td><?php echo $users_["statut"]; ?></td>
<td><?php echo $users_["user_open"]; ?></td>
<? $id_r=$users_["id"];$date=$users_["date"];$client=$users_["client"];$service=$users_["service"];$code=$users_["code_produit"];$lp=$users_["id"]+200000;
echo "<td><a href=\"bookings_transferts.php?id_registre=$id_r&date=$date&client=$client&service=$service&code=$code\">"."Bookings"."</a></td>";?>
<?php } ?>

</table>

<p style="text-align:center">
<table>
<tr><td><? echo "<td><a href=\"registre_transfert.php?date=$date&client=$client&user_id=0\">"."  Ajout LP  "."</a></td>";?></td></tr>
<? 	if(isset($_REQUEST["action"]))
{?>
<tr><td><? echo "<td><a href=\"transferts_departs_globale.php?date=$date&client=$client\">"."  Etat Transferts Departs  ".dateUsToFr($date)."</a></td>";?></td></tr>
<tr><td><? echo "<td><a href=\"transferts_arrivees_globale.php?date=$date&client=$client\">"."  Etat Transferts Arrivees  ".dateUsToFr($date)."</a></td>";?></td></tr>

<? }?>

</body>

</html>