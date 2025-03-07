<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$action="Recherche";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	
		if(!isset($_REQUEST["action"])){
?>
	
	<form id="form" name="form" method="post" action="fiches_stock.php">

	<td><?php $action="Recherche";$du="01/01/2009";echo "Du : "; ?><input type="text" id="du" name="du" value="<?php echo $du; ?>" size="15"></td>
	<td><?php $au="";echo "Au : "; ?><input type="text" id="au" name="au" value="<?php echo $au; ?>" size="15"></td>
	<tr>
	
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }else
	
	{
	$du=dateFrToUs($_POST['du']);$au=dateFrToUs($_POST['au']);$au1=$_POST['au'];

	
	
	$sql  = "SELECT * ";
	$sql .= "FROM produits ORDER BY produit;";
	$users = db_query($database_name, $sql);
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Produits"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "fiche_stock.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "liste Produits"; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Code";?></th>
	<th><?php echo "Nom";?></th>
	<th><?php echo "Conditionnement";?></th>
	<th><?php echo "Prix Unit";?></th>
	<th><?php echo "Poids";?></th>
	<th><?php echo "Dispo";?></th>
	<th><?php echo "S.Final";?></th>
	<th><?php echo "S.Init.exe.encours";?></th>
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<? $id=$users_["id"];echo "<tr><td><a href=\"fiche_stock.php?user_id=$id&au=$au\">$id</a></td>";?>
<td style="text-align:left" bgcolor="#66CCCC"><?php echo $users_["produit"]; ?></td>
<td bgcolor="#66CCCC"><?php echo $users_["condit"]; ?></td>
<td style="text-align:left" bgcolor="#66CCCC"><?php echo $users_["prix"]; ?></td>
<td bgcolor="#66CCCC"><?php echo $users_["poids"]; ?></td>
<?php if ($users_["dispo"]==0){?><td bgcolor="#FF3333"><? echo "non";}else{?><td bgcolor="#0066FF"><? echo "oui";}; ?></td>
<td bgcolor="#66CCCC"><?php echo $users_["stock_final"]; ?></td>
<td bgcolor="#66CCCC"><?php echo $users_["stock_ini_exe"]; ?></td>
<?php } ?>

</table>
<?php } ?>
<p style="text-align:center">


</body>

</html>