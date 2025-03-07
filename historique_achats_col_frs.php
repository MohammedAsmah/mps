<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$action="Recherche";$date="";$date1="";$du="";$au="";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
		
	
	// recherche ville
	
	$frs=$_GET['frs'];
	
	
	
	
	
	$sql  = "SELECT * ";$col="col";
	$sql .= "FROM achats_mat where type='$col' and frs='$frs' group by produit ORDER BY produit;";
	$users = db_query($database_name, $sql);
		
	
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head><? require "head_cal.php";?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	
--></script>

</head>

<body style="background:#dfe8ff"><? require "body_cal.php";?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Achats Collorants : $frs"; ?></span>

<table class="table2">

<tr>
	
	<th><?php echo "Collorant";?></th>
	
</tr>
<? $t=0;$q=0;while($users_ = fetch_array($users)) {?><tr>
	
	<?php $produit=$users_["produit"];?>
	<? echo "<td><a href=\"historique_achats_col_frs_produit.php?frs=$frs&produit=$produit\">$produit</a></td>";?>
	

<? }?>

</table>


</body>

</html>