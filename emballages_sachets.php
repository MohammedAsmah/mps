<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$stock_final_mp = $_REQUEST["stock_final_mp"];$valeur_final_mp = $_REQUEST["valeur_final_mp"];$produit = $_REQUEST["produit"];
			

		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
				$sql  = "INSERT INTO report_mat_precedant_2021 ( produit,poids ) VALUES ( ";
				$sql .= "'".$profile_name . "',";
				$sql .= "'".$poids . "');";
				db_query($database_name, $sql);

			break;

			case "update_user":
			$d="2022-01-01";
			$sql = "UPDATE report_mat_precedant SET ";
			$sql .= "produit = '" . $produit . "', ";
			$sql .= "stock_final_mp = '" . $stock_final_mp . "', ";
			$sql .= "date = '" . $d . "', ";
			$sql .= "valeur_final_mp = '" . $valeur_final_mp . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			
			break;


		} //switch
	} //if
	
	$sql  = "SELECT * ";$vide="";$emb="emb1";
	$sql .= "FROM report_mat_precedant where produit<>'$vide' and type='$emb' ORDER BY id;";
	$users = db_query($database_name, $sql);$sti=0;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "emballage_sachet.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo ""; ?></span>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>

<table class="table2">

<tr>
	<th><?php echo "Libelle";?></th>
	<th><?php echo "Poids";?></th>
	<th><?php echo "stock";?></th>
	<th><?php echo "valeur";?></th>
	
</tr>

<?php 
	$v=0;$achats_t=0;while($users_ = fetch_array($users)) { ?><tr>
	
	<?
	$p= $users_["produit"];$emballage= $users_["produit"];$id= $users_["id"];$poids= $users_["poids"];$stock=$users_["stock_final_mp"];$valeur= $users_["valeur_final_mp"];
	$sachet="<td align=\"left\"><a href=\"emballage_sachet.php?user_id=$id\">$p</a></td>";
		print("<font size=\"1\" face=\"Arial\" color=\"#000033\">$sachet </font>");
		
		
		$type_emb="sachets";
		
			/*$sql  = "INSERT INTO report_mat_precedant ( produit,type ) VALUES ( ";
				$sql .= "'" . $p . "', ";
				$sql .= "'" . $emb . "', ";
							
				$sql .= $poids . ");";

				db_query($database_name, $sql);*/
		
		
		
		
	?>
	
	<td align="right"><?php $poids= number_format($poids,3,',',' ');print("<font size=\"2\" face=\"Arial\" color=\"#000033\">$poids </font>");?></td>
	<td align="right"><?php $stock= number_format($stock,3,',',' ');print("<font size=\"2\" face=\"Arial\" color=\"#000033\">$stock </font>");?></td>
	<td align="right"><?php $valeur= number_format($valeur,3,',',' ');print("<font size=\"2\" face=\"Arial\" color=\"#000033\">$valeur </font>");?></td>
	</tr>
<?php } ?>
<tr>

</table>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>

</body>

</html>