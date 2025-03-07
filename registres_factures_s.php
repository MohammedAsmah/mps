<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
			$sql  = "SELECT * ";$sel=1;
		$sql .= "FROM mois_rak WHERE encours = " . $sel . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";

		$mois = $user_["mois"];
		$du = dateUsToFr($user_["du"]);
		$au = dateUsToFr($user_["au"]);
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	$type_service="SEJOURS ET CIRCUITS";
	$sql  = "SELECT * ";
	$sql .= "FROM registre_factures_rak WHERE mois_f='$mois' and type_service='$type_service' ORDER BY id;";
	$users = db_query($database_name, $sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "sejour_pdf.php?numero=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo ""; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Numero";?></th>
	<th><?php echo "Date";?></th>
	<th><?php echo "Client";?></th>
	<th><?php echo "Du";?></th>
	<th><?php echo "Au";?></th>
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["id"]."/2007";?></A></td>
<td style="text-align:center"><?php echo dateUsToFr($users_["date_f"]); ?></td>
<td><?php echo $users_["client"]; ?></td>
<td style="text-align:center"><?php echo dateUsToFr($users_["du"]); ?></td>
<td style="text-align:center"><?php echo dateUsToFr($users_["au"]); ?></td>

<?php } ?>

</table>


</body>

</html>
