<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$user_name=GetUserName();
	$error_message = "";
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action1_"])) { 
			$credit=$_REQUEST["credit"];
			$sql = "UPDATE folio_divers_depenses_rak SET ";
			$sql .= "credit = '" . $credit . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
			}
			

	if(isset($_REQUEST["action_"])) { 
		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$date_lp = dateFrToUs($_REQUEST["date_lp"]);
			$service=$_REQUEST["service"];
			$libelle=$_REQUEST["libelle"];
			$ref=$_REQUEST["ref"];
			$date_open=$_REQUEST["date_open"];
			$user_open=$user_name;
			$divers=$_REQUEST["divers"];
			
			
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			$type_depense=1;
				$sql  = "INSERT INTO folio_divers_depenses_rak (date_lp,service,libelle,divers,ref,type_depense )
				 VALUES ('$date_lp','$service','$libelle','$divers','$ref','$type_depense')";

				db_query($database_name, $sql);
			

			break;

			case "update_user":
			$sql = "UPDATE folio_divers_depenses_rak SET ";
			$sql .= "date_lp = '" . $date_lp . "', ";
			$sql .= "service = '" . $service . "', ";
			$sql .= "libelle = '" . $libelle . "', ";
			$sql .= "divers = '" . $divers . "', ";
			$sql .= "ref = '" . $ref . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			// delete user's profile
			$sql = "DELETE FROM folio_divers_depenses_rak WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	$action="recherche";
	$date="";
	?>
	<form id="form" name="form" method="post" action="registres_depenses.php">
	<td><?php echo "Date : "; ?><input onclick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" />
	<input type="submit" id="action" name="action" value="<?php echo $action; ?>">
	</form>
	
	<?
	if(isset($_REQUEST["action"]))
	{ $date=dateFrToUs($_POST['date']);
	$sql  = "SELECT * ";$type_s=1;
	$sql .= "FROM folio_divers_depenses_rak where date_lp='$date' and type_depense='$type_s' ORDER BY id;";
	$users = db_query($database_name, $sql);}
	else
	{	
	$sql  = "SELECT * ";$type_s=1;
	$sql .= "FROM folio_divers_depenses_rak where type_depense='$type_s' ORDER BY id;";
	$users = db_query($database_name, $sql);}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "registre_depense.php?user_id=" + user_id; }
	function EditUser1(user_id) { document.location = "registre_depense_vers_folio.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo ""; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Service";?></th>
	<th><?php echo "Libelle";?></th>
	<th><?php echo "ref";?></th>
	<th><?php echo "Montant";?></th>
	<th><?php echo "Debit";?></th>
	<th><?php echo "Credit";?></th>
	<th><?php echo "Solde";?></th>

</tr>

<?php while($users_ = fetch_array($users)) { if ($users_["credit"]>0){$folio="valide";}else {$folio="non valide";}?><tr>
<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo dateUsToFr($users_["date_lp"]);?></A></td>
<td><?php echo $users_["service"]; ?></td>
<td><?php echo $users_["libelle"]; ?></td>
<td><?php echo $users_["ref"]; ?></td>
<td><?php echo $users_["divers"]; ?></td>
<td><?php echo $users_["debit"]; ?></td>
<td><?php echo $users_["credit"]; ?></td>
<td><?php $solde=$users_["debit"]-$users_["credit"];echo $solde; ?></td>
<td><a href="JavaScript:EditUser1(<?php echo $users_["id"]; ?>)"><?php echo $folio;?></A></td>
<?php } ?>

</table>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>


</body>

</html>