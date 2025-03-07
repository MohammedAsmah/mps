<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$caisse="";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	
	$profiles_list_caisse = "";$caisse_list="";$action="Recherche";$du="";$au="";
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
	<form id="form" name="form" method="post" action="journal_caisses_c_v.php">
	<td><?php echo "Du : "; ?><input type="text" id="du" name="du" value="<?php echo $du; ?>" size="15"></td>
	<td><?php echo "Au : "; ?><input type="text" id="au" name="au" value="<?php echo $au; ?>" size="15"></td>
	<td><?php echo "Caisse : "; ?><select id="caisse_list" name="caisse_list"><?php echo $profiles_list_caisse; ?></select></td>
	<tr>
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	<? }
	
	
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
	
<?	if(isset($_REQUEST["action"]))
	{
			$du=dateFrToUs($_POST['du']);$au=dateFrToUs($_POST['au']);$caisse=$_POST['caisse_list'];
			$sql  = "SELECT * ";
			$sql .= "FROM journal_caisses where caisse='$caisse' and (date between '$du' and '$au') and controle=0 ORDER BY date,id;";
			$users = db_query($database_name, $sql);?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Caisse : ".$caisse; ?></span>

<p style="text-align:center">

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

<? 			$id=$users_["id"];$sql = "UPDATE journal_caisses SET controle = 1 WHERE id = '$id'";
			db_query($database_name, $sql);
?>

<?php } ?>

</table>
<?php } ?>
<p style="text-align:center">

</body>

</html>