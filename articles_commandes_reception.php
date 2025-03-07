<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html"; charset="UTF-8">
<meta charset="UTF-8">
<title><?php echo "" . "liste articles commandes"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "article_commande_reception.php?user_id=" + user_id; }
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
			$quantite = $_REQUEST["quantite"];$type_c="MP";$statut=$_REQUEST["statut"];$id=$_REQUEST["user_id"];
			
		}
		
		switch($_REQUEST["action_"]) {

					
			case "update_user":
			$sql = "UPDATE detail_bon_besoin SET ";
			$sql .= "numero_br = '" . $_REQUEST["br"] . "', ";
			$sql .= "date_reception = '" . $date_reception . "', ";
			$sql .= "statut = '" . $statut . "', ";
			$sql .= "quantite_r = '" . $_REQUEST["quantite_r"] . "' ";
			$sql .= "WHERE id = '" . $id . "';";
			db_query($database_name, $sql);
			
			break;
			
			case "delete_user":
			
			// delete user's profile
			$confirme=$_REQUEST["confirme"];
			if ($confirme==""){
			$sql = "DELETE FROM detail_bon_besoin WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);}
			
			break;
					
	
		} 
	} 



	$sql  = "SELECT * ";$reception="reception globale";
	$sql .= "FROM detail_bon_besoin where statut<>'$reception' order BY date_b;";
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
	<th><?php echo "Date CD";?></th>
	<th><?php echo "Statut";?></th>
	
</thead>
</div>



<?php while($users_ = fetch_array($users)) { ?><tr>

<td bgcolor="#66CCCC"><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["id"];$id=$users_["id"];?></A></td>
<td style="text-align:left" bgcolor="#66CCCC"><?php echo $users_["produit"]; ?></td>
<td style="text-align:left" bgcolor="#66CCCC" align="right"><?php echo $users_["quantite"]; ?></td>
<td style="text-align:left" bgcolor="#66CCCC" align="right"><?php echo $users_["unite"]; ?></td>
<td style="text-align:left" bgcolor="#66CCCC" align="right"><?php echo dateUsToFr($users_["date_b"]); ?></td>
<td style="text-align:left" bgcolor="#66CCCC" align="right"><?php echo dateUsToFr($users_["date_commande"]); ?></td>
<td style="text-align:left" bgcolor="#66CCCC" align="right"><?php echo $users_["statut"]; ?></td>
<?php } ?>

</table>

<p style="text-align:center">


	
</body>

</html>