<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$du="";$au="";$vendeur="";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
		?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Evaluations"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "detail_evaluation.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";
	$action="recherche";
	$date="";$client="";$eva="";
	?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>
<span style="font-size:24px"><?php echo "liste Evaluations"; ?></span>
	
	<form id="form" name="form" method="post" action="editer_evaluations.php">
	<td><?php echo "DU : "; ?><input onclick="ds_sh(this);" name="du" readonly="readonly" style="cursor: text" />
	<td><?php echo "AU : "; ?><input onclick="ds_sh(this);" name="au" readonly="readonly" style="cursor: text" />
	<input type="submit" id="action" name="action" value="<?php echo $action; ?>">
	</form>

<?	
	
	if(isset($_REQUEST["action"]))
	{ $du=DateFrToUs($_POST['du']);$au=DateFrToUs($_POST['au']);
	
	$sql  = "SELECT * ";
	$sql .= "FROM commandes where date_e between '$du' and '$au' ORDER BY date_e;";
	$users = db_query($database_name, $sql);
//
?>
<tr>
<td><?php echo $vendeur .":".dateUsToFr($du)." au ".dateUsToFr($au) ;?></td>
</tr>

<table class="table2">

<tr>
	<th><?php echo "Evaluation";?></th>
	<th><?php echo "Date";?></th>
	<th><?php echo "Client";?></th>
</tr>

<?php $total_g=0;

while($users_ = fetch_array($users)) { ?><tr>
		<? $commande=$users_["commande"];$evaluation=$users_["evaluation"];$client=$users_["client"];
		$date=dateUsToFr($users_["date_e"]);$id=$users_["id"];
		$vendeur_ref=$users_["vendeur"];$numero=$users_["commande"];$sans_remise=$users_["sans_remise"];
		$remise10=$users_["remise_10"];
		$remise2=$users_["remise_2"];$remise3=$users_["remise_3"];$date1=dateFrToUs($users_["date"]);
			?>
			<td><? echo $evaluation;?></td>
			<td><? echo $date;?></td>
			<td><? echo $client;?></td>

<?php } ?>
</table>
<?php } ?>
<p style="text-align:center">

</body>

</html>