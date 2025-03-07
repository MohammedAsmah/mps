<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$action="Recherche";	
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action"])){}else{
	?>

	<form id="form" name="form" method="post" action="etat_retraits_employes.php">
	<table>
	<td><?php echo "Du: "; ?><input onClick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" /></td>
	<td><?php echo "Au: "; ?><input onClick="ds_sh(this);" name="date2" readonly="readonly" style="cursor: text" /></td>
	
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }
	$type="retrait";
	if(isset($_REQUEST["action"]))
	{$date=dateFrToUs($_POST['date']);$date2=dateFrToUs($_POST['date2']);
	$date_f=dateFrToUs($_POST['date']);$du=$_POST['date'];$au=$_POST['date2'];
		
		$sql  = "SELECT * ";
		$sql .= "FROM avances_employes where date_avance between '$date' and '$date2' and type='$type' and montant<>0 ORDER BY id;";
	$users = db_query($database_name, $sql);
		}
		
		else
			
		{
		
		$sql  = "SELECT * ";$date_vide="0000-00-00";
		$sql .= "FROM avances_employes where date_avance='$date_vide' and type='$type' ORDER BY id;";
	$users = db_query($database_name, $sql);}
		
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste "; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "avance_employe.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">
<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Retraits/avances employes : ".$du." au ".$au; ?></span>

<table class="table2">

<tr>
	
	<th><?php echo "Date";?></th>
	<th><?php echo "Employe";?></th>
	<th><?php echo "Montant";?></th>
	<th><?php echo "Motif";?></th>
	
	
</tr>

<?php $m=0;while($users_ = fetch_array($users)) { ?><tr>
<?php $id=$users_["id"]; $date_avance=dateUsToFr($users_["date_avance"]);$employe=$users_["employe"];?>
<? echo "<td>$date_avance</td>";?>
<td><?php echo $users_["employe"]; ?></td>
<td align="right"><?php echo $users_["montant"]; $m=$m+$users_["montant"];?></td>
<td><?php echo $users_["motif"]; ?></td>

<?php } ?>
<tr><td></td><td></td>
<td align="right"><?php echo number_format($m,2,',',' '); ?></td>
<td></td><td></td>

</table>

<p style="text-align:center">

</p>
</body>

</html>