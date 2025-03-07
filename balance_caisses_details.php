<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$caisse="";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url

		if(isset($_REQUEST["action_"])){
		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$date = dateFrToUs($_REQUEST["date"]);$caisse = $_REQUEST["caisse"];$libelle = $_REQUEST["libelle"];$type = $_REQUEST["type"];
			$debit = $_REQUEST["debit"];$credit = $_REQUEST["credit"];$caisse1 = $_REQUEST["caisse1"];$type1 = $_REQUEST["type1"];
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
			}
			}
			else
			{$type1=$_GET['type'];$caisse1=$_GET['caisse'];
				$du1=date("d/m/Y");	$date1=$_GET['date1'];$date=$_GET['date'];$au=dateUsToFr($_GET['date1']);$du=dateUsToFr($_GET['date']);

			}
			

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">


</head>

<body style="background:#dfe8ff">
	
	
<?			

	$sql  = "SELECT *";
	$sql .= "FROM journal_caisses where caisse='$caisse1' and type='$type1' and date between '$date' and '$date1' ORDER BY date;";
	$users = db_query($database_name, $sql);
	?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Balance Caisse $caisse1 Type : $type1 du $du au $au "; ?></span>

<p style="text-align:center">


<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Libelle";?></th>
	<th><?php echo "Debit";?></th>
	<th><?php echo "Credit";?></th>
</tr>

<?php $debit=0;$credit=0;
while($users_ = fetch_array($users)) { ?><tr>
<?php $dt=dateUsToFr($users_["date"]);$id=$users_["id"];?>
<? echo "<td><a href=\"journal_caisse_maj.php?user_id=$id&caisse=$caisse1&type=$type1\">$dt</a></td>";?>
<td><?php echo $users_["libelle"];?></td>
<td align="right"><?php $debit=$debit+$users_["debit"];echo number_format($users_["debit"],2,',',' ');?></td>
<td align="right"><?php $credit=$credit+$users_["credit"];echo number_format($users_["credit"],2,',',' ');?></td>
<?php } ?>
<tr><td></td><td></td>
<td align="right"><?php echo number_format($debit,2,',',' ');?></td>
<td align="right"><?php echo number_format($credit,2,',',' ');?></td></tr>
</table>

<p style="text-align:center">

</body>

</html>