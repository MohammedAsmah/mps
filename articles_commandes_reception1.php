<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html"; charset="UTF-8">
<meta charset="UTF-8">
<title><?php echo "" . "liste articles commandes"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "article_commande_reception1.php?user_id=" + user_id; }
--></script>

</head>

<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); 
	$profile_id = GetUserProfile();	$user_name=GetUserName();$date_time=date("y-m-d h:m:s");

	$error_message = "";
	
	
	if(isset($_REQUEST["action_"])) { 

		if($_REQUEST["action_"] != "delete_user") {
			
			$produit = $_REQUEST["produit"];$condit = $_REQUEST["condit"];$prix = $_REQUEST["prix"];$date_reception = dateFrToUs($_REQUEST["date_reception"]);
			$quantite = $_REQUEST["quantite_q"];$type_c="MP";if(isset($_REQUEST["confirme"])) { $confirme = 1; } else { $confirme = 0; }
			$id=$_REQUEST["user_id"];
			
		}
		
		switch($_REQUEST["action_"]) {

					
			case "update_user":
			$statut="commande encours";
			$sql = "UPDATE detail_bon_besoin SET ";
			$sql .= "date_confirmation = '" . $date_reception . "', ";
			$sql .= "confirme = '" . $confirme . "', ";
			$sql .= "statut = '" . $statut . "', ";
			$sql .= "quantite = '" . $quantite . "' ";
			$sql .= "WHERE id = '" . $id . "';";
			db_query($database_name, $sql);
			
			break;
					
	
		} 
	} 



	$sql  = "SELECT * ";$c="1";
	$sql .= "FROM detail_bon_besoin where confirme=1 and bon_commande=0 and date_b>'2021-13-31' order BY date_b;";
	$users = db_query($database_name, $sql);
	
?>	


<body style="background:#dfe8ff">


<table class="table2">
<div id="titre">
<caption><?php echo "Bon de Besoin en cours"; ?></caption>
<thead>
	<th><?php echo "Id";?></th>
	<th><?php echo "Designation";?></th>
	<th><?php echo "Quantite";?></th>
	<th><?php echo " Unite ";?></th>
	<th><?php echo "Date BB";?></th>
	
	
</thead>
</div>



<?php while($users_ = fetch_array($users)) { ?><tr>

<td bgcolor="#66CCCC"><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["id"];$id=$users_["id"];?></A></td>
<td style="text-align:left" bgcolor="#66CCCC"><?php echo $users_["produit"]; ?></td>
<td style="text-align:left" bgcolor="#66CCCC" align="right"><?php echo $users_["quantite"]; ?></td>
<td style="text-align:left" bgcolor="#66CCCC" align="right"><?php echo $users_["unite"]; ?></td>
<td style="text-align:left" bgcolor="#66CCCC" align="right"><?php echo dateUsToFr($users_["date_b"]); ?></td>

<?php } ?>

</table>

<p style="text-align:center">


	
</body>

</html>