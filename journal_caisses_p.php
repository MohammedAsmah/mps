<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$caisse="";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
				$sql  = "SELECT * ";$cai=14;
				$sql .= "FROM liste_caisses WHERE profile_id = " . $cai . ";";
				$user = db_query($database_name, $sql); $user_ = fetch_array($user);
				$debit_c=$user_["debit"];$credit_c=$user_["credit"];
		if(isset($_REQUEST["action_"]) && $profile_id == 1) { 
				
				
		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$date = dateFrToUs($_REQUEST["date"]);$caisse = "PAIE";$libelle = $_REQUEST["libelle"];$type = $_REQUEST["type"];
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
			
				$debit_c=$debit_c+$debit;$credit_c=$credit_c+$credit;$cai=14;$caiss="PAIE";
				$sql1 = "UPDATE liste_caisses SET ";
				$sql1 .= "debit = '" . $debit_c . "', ";
				$sql1 .= "credit = '" . $credit_c . "' ";
				$sql1 .= "WHERE profile_id = " . $cai . ";";
				db_query($database_name, $sql1);
					
			
			
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
			$debit_ancien=$_REQUEST["debit_ancien"];$credit_ancien=$_REQUEST["credit_ancien"];
				$debit_c=$debit_c+$debit-$debit_ancien;$credit_c=$credit_c+$credit-$credit_ancien;$ca=14;
				$sql1 = "UPDATE liste_caisses SET ";
				$sql1 .= "debit = '" . $debit_c . "', ";
				$sql1 .= "credit = '" . $credit_c . "' ";
				$sql1 .= "WHERE profile_id = " . $cai . ";";
				db_query($database_name, $sql1);
			
			
			
			break;
			
			case "delete_user":
		$sql  = "SELECT * ";
		$sql .= "FROM journal_caisses WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$debit=$user_["debit"];$credit=$user_["credit"];
				$debit_c=$debit_c-$debit;$credit_c=$credit_c-$credit;$cai=14;
				$sql1 = "UPDATE liste_caisses SET ";
				$sql1 .= "debit = '" . $debit_c . "', ";
				$sql1 .= "credit = '" . $credit_c . "' ";
				$sql1 .= "WHERE profile_id = " . $cai . ";";
				db_query($database_name, $sql1);
			
			
			
			// delete user's profile
			$sql = "DELETE FROM journal_caisses WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	
			$sql  = "SELECT * ";$caisse="PAIE";
			$sql .= "FROM journal_caisses where caisse='$caisse' and controle=0 ORDER BY date,credit;";
			$users = db_query($database_name, $sql);
	
	

	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "journal_caisse_p.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Caisse : "; ?></span>

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

<?php $debit=0;$credit=0;while($users_ = fetch_array($users)) { ?><tr>
<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo dateUsToFr($users_["date"]);?></A></td>
<td><?php $libelle=$users_["libelle"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$libelle </font>"); ?></td>
<td align="right"><?php $debit=$debit+$users_["debit"];$d=number_format($users_["debit"],2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$d </font>"); ?></td>
<td align="right"><?php $credit=$credit+$users_["credit"];$c=number_format($users_["credit"],2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$c </font>"); ?></td>
<td align="right"><?php $solde=$debit-$credit;$s=number_format($solde,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$s </font>"); ?></td>

<?php } ?>
<tr><td></td><td></td>
<td align="right"><?php $d=number_format($debit_c,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$d </font>"); ?></td>
<td align="right"><?php $c=number_format($credit_c,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$c </font>"); ?></td>
<td></td></tr>
</table>

<p style="text-align:center">

</body>

</html>