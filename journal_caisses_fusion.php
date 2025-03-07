<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$caisse="";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$date = dateFrToUs($_REQUEST["date"]);$caisse = $_REQUEST["caisse"];$libelle = $_REQUEST["libelle"];$type = $_REQUEST["type"];
			$debit = $_REQUEST["debit"];$credit = $_REQUEST["credit"];
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
				$sql  = "INSERT INTO journal_caisses ( date,caisse,libelle,type,debit,credit ) VALUES ( ";
				$sql .= "'".$date . "',";
				$sql .= "'".$caisse . "',";
				$sql .= "'".$libelle . "',";
				$sql .= "'".$type . "',";
				$sql .= "'".$debit . "',";
				$sql .= "'".$credit . "');";
				db_query($database_name, $sql);

			////
			$sql  = "SELECT * ";$sss=0;
			$sql .= "FROM journal_caisses where caisse='$caisse' ORDER BY date,id;";
			$users = db_query($database_name, $sql);
			while($users_ = fetch_array($users)) {
			$id=$users_["id"];$sss=$sss+($users_["debit"]-$users_["credit"]);
			$sql = "UPDATE journal_caisses SET ";
			$sql .= "solde = '" . $sss . "' ";
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);
			}

			
			////




			break;

			case "update_user":

			$sql = "UPDATE journal_caisses SET ";
			$sql .= "date = '" . $date . "', ";
			$sql .= "libelle = '" . $libelle . "', ";
			$sql .= "caisse = '" . $caisse . "', ";
			$sql .= "type = '" . $type . "', ";
			$sql .= "debit = '" . $debit . "', ";
			$sql .= "credit = '" . $credit . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
			///
			$sql  = "SELECT * ";$sss=0;
			$sql .= "FROM journal_caisses where caisse='$caisse' ORDER BY date,id;";
			$users = db_query($database_name, $sql);
			while($users_ = fetch_array($users)) {
			$id=$users_["id"];$sss=$sss+($users_["debit"]-$users_["credit"]);
			$sql = "UPDATE journal_caisses SET ";
			$sql .= "solde = '" . $sss . "' ";
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);
			}
			///
			
			break;
			
			case "delete_user":
			
			// delete user's profile
			$id=$_REQUEST["user_id"];
			$sql  = "SELECT * ";
			$sql .= "FROM journal_caisses WHERE id = " . $_REQUEST["user_id"] . ";";
			$user = db_query($database_name, $sql); $user_ = fetch_array($user);
			$caisse=$user_["caisse"];

			
			$sql2 = "DELETE FROM journal_caisses WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql2);
			
			////
			$sql  = "SELECT * ";$sss=0;
			$sql .= "FROM journal_caisses where caisse='$caisse' ORDER BY date,id;";
			$users = db_query($database_name, $sql);
			while($users_ = fetch_array($users)) {
			$id=$users_["id"];$sss=$sss+($users_["debit"]-$users_["credit"]);
			$sql = "UPDATE journal_caisses SET ";
			$sql .= "solde = '" . $sss . "' ";
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);
			}
			////
			
			break;


		} //switch
	} //if
	
	$profiles_list_caisse = "";$caisse_list="";$action="Recherche";
	$sql1 = "SELECT * FROM liste_caisses ORDER BY profile_name;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($caisse_list == $temp_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_caisse .= "<OPTION VALUE=\"" . $temp_["profile_name"] . "\"" . $selected . ">";
		$profiles_list_caisse .= $temp_["profile_name"];
		$profiles_list_caisse .= "</OPTION>";
	}
		if(isset($_REQUEST["action"]))
	{}else{

	?>
	<form id="form" name="form" method="post" action="journal_caisses_fusion.php">
	<td><?php echo "Caisse : "; ?></td><td><select id="caisse_list" name="caisse_list"><?php echo $profiles_list_caisse; ?></select>
	<? /*
	<td><?php echo "Du : "; ?><input type="text" id="du" name="du" value="<?php echo $du; ?>" size="15"></td>
	<td><?php echo "Au : "; ?><input type="text" id="au" name="au" value="<?php echo $au; ?>" size="15"></td>
	<tr>
	*/?>
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	<? }
	
	if(isset($_REQUEST["action"]))
	{
			$sql  = "SELECT * ";$d="2008-12-31";
			$sql .= "FROM journal_caisses_2009 where date>'$d' ORDER BY date,id;";
			$users = db_query($database_name, $sql);
	
	

	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "journal_caisse.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Caisse : ".$caisse_list; ?></span>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>

<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Libelle";?></th>
	<th><?php echo "Debit";?></th>
	<th><?php echo "Credit";?></th>
	<th><?php echo "Solde";?></th>
</tr>

<?php $debit=0;$credit=0;$sss=0;while($users_ = fetch_array($users)) { ?><tr>
<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo dateUsToFr($users_["date"]);?></A></td>
<td><?php $libelle=$users_["libelle"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$libelle </font>"); ?></td>
<?php $caisse=$users_["caisse"];?>
<?php $type=$users_["type"];?>
<td align="right"><?php $debit=$debit+$users_["debit"];$d=number_format($users_["debit"],2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$d </font>"); ?></td>
<td align="right"><?php $credit=$credit+$users_["credit"];$c=number_format($users_["credit"],2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$c </font>"); ?></td>
<td align="right"><?php $ss=number_format($users_["solde"],2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$ss </font>"); ?></td>

<?
	$date = $users_["date"];$libelle=$users_["libelle"];$caisse=$users_["caisse"];$type=$users_["type"];$debit=$users_["debit"];
	$credit=$users_["credit"];$statut=$users_["statut"];
			
				$sql  = "INSERT INTO journal_caisses ( date,caisse,libelle,type,debit,credit ) VALUES ( ";
				$sql .= "'".$date . "',";
				$sql .= "'".$caisse . "',";
				$sql .= "'".$libelle . "',";
				$sql .= "'".$type . "',";
				$sql .= "'".$debit . "',";
				$sql .= "'".$credit . "');";
				db_query($database_name, $sql);
?>





<?php } ?>

</table>
<?php } ?>
<p style="text-align:center">

</body>

</html>