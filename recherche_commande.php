<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$user_name=GetUserName();
	$error_message = "";
	$type_service="SEJOURS ET CIRCUITS";
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
		
	$action="recherche";$ref="";
	
	?>
	<? if(isset($_REQUEST["action"])){}else{ ?>
	<form id="form" name="form" method="post" action="recherche_commande.php">
	<TR><td><?php $ref="";echo "Reference commande	: "; ?></td><td><input type="text" id="ref" name="ref" value="<?php echo $ref; ?>">
	<input type="submit" id="action" name="action" value="<?php echo $action; ?>">
	</form>
	
	<? }


?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">



</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<? 	

	
	if (isset($_REQUEST["action"])){
	$ref=$_POST['ref'];
	$sql  = "SELECT * ";
	$sql .= "FROM entrees_stock_mp where commande='$ref' GROUP BY id ;";
	$users11 = db_query($database_name, $sql);
	
	
?>


<span style="font-size:24px"><?php echo "Resultat recherche pour $ref " ; ?></span>

<table class="table2">

<tr>	

	<th><?php echo "Date";?></th>
	<th><?php echo "Fournisseur";?></th>
	<th><?php echo "Article";?></th>
	<th><?php echo "Bon Reception";?></th>
	<th><?php echo "Bon Livraison";?></th>
	<th><?php echo "Quantite";?></th>
	
</tr>

<?php 



$compteur1=0;$total_g=0;
while($users_1 = fetch_array($users11)) { ?>
			<tr>
			<td><?php echo dateUsToFr($users_1["date"]); ?></td>
			<td><?php echo $users_1["frs"]; ?></td>
			<td><?php echo $users_1["produit"]; ?></td>
			<td><?php echo $users_1["reception"]; ?></td>
			<td><?php echo $users_1["livraison"]; ?></td>
			<td><?php echo $users_1["depot_a"]; ?></td>
			</tr>




<? } ?>



</table>
</strong>
<p style="text-align:center">
<? }?>
</body>

</html>