<?php
	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	
	// recherche ville
	?>
	
	<?
	$sql  = "SELECT * ";
	$sql .= "FROM produits ORDER BY produit;";
	$users1 = db_query($database_name, $sql);
	//reset 
	$activer=0;$vendeur="";
	
	while($users_1 = fetch_array($users1)) { $sql = "UPDATE produits SET palmares = $activer ";
	db_query($database_name, $sql);}
	
	$sql  = "SELECT * ";
	$sql .= "FROM produits ORDER BY produit;";
	$users = db_query($database_name, $sql);
	$vendeurs_list = "";
	$sql = "SELECT * FROM  vendeurs ORDER BY vendeur;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($vendeur == $temp_["vendeur"]) { $selected = " selected"; } else { $selected = ""; }
		
		$vendeurs_list .= "<OPTION VALUE=\"" . $temp_["vendeur"] . "\"" . $selected . ">";
		$vendeurs_list .= $temp_["vendeur"];
		$vendeurs_list .= "</OPTION>";
	}
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Produits"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "produit.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
		<? require "body_cal.php";?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "liste Produits"; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Article";?></th>
</tr>
<form id="regForm" name="regForm" method="post" action="palmares_articles_avoirs1.php">
	<td><?php echo "Du : "; ?><input onClick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" />
	<?php echo "Au : "; ?><input onClick="ds_sh(this);" name="date1" readonly="readonly" style="cursor: text" /></td>
	<td><?php echo "Vendeur : "; ?><select id="vendeur" name="vendeur"><?php echo $vendeurs_list; ?></select></td>
	<td><input type="submit" name="Submit1" value="RECHERCHE"> </td>
	   
      </tr>
</form>
</table>

<p style="text-align:center">


</body>

</html>