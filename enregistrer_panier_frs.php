<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	
		//sub
	
	if(isset($_REQUEST["action_"]) ) { 
		
		if($_REQUEST["action_"] != "delete_user") {
		$frs =$_REQUEST["frs"];
			
			// prepares data to simplify database insert or update
			$produit =$_REQUEST["produit"];
			if ($_REQUEST["action_"]=="insert_new_user"){
			$produit1 =$_REQUEST["produit1"];$produit11 = $_REQUEST["produit11"];
			$produit2 =$_REQUEST["produit2"];$produit12 = $_REQUEST["produit12"];
			$produit3 =$_REQUEST["produit3"];$produit13 = $_REQUEST["produit13"];
			$produit4 =$_REQUEST["produit4"];$produit14 = $_REQUEST["produit14"];
			$produit5 =$_REQUEST["produit5"];$produit15 = $_REQUEST["produit15"];
			$produit6 =$_REQUEST["produit6"];$produit16 = $_REQUEST["produit16"];
			$produit7 =$_REQUEST["produit7"];$produit17 = $_REQUEST["produit17"];
			$produit8 =$_REQUEST["produit8"];$produit18 = $_REQUEST["produit18"];
			$produit9 =$_REQUEST["produit9"];$produit19 = $_REQUEST["produit19"];
			$produit10 =$_REQUEST["produit10"];$produit20 = $_REQUEST["produit20"];
			}

		
		}	
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
				
				if ($produit<>""){
				
				$sql  = "INSERT INTO detail_produits_frs ( produit,frs )
				VALUES ( ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $frs . "');";
				db_query($database_name, $sql);
				
				}
				
		
				if ($produit1<>""){
				$sql  = "INSERT INTO detail_produits_frs ( frs, produit )
				VALUES ( ";
				$sql .= "'" . $frs . "', ";
				$sql .= "'" . $produit1 . "');";
				db_query($database_name, $sql);

				
				}
			
				if ($produit2<>""){
				$sql  = "INSERT INTO detail_produits_frs ( frs, produit )
				VALUES ( ";
				$sql .= "'" . $frs . "', ";
				$sql .= "'" . $produit2 . "');";
				db_query($database_name, $sql);
				}
		
				if ($produit3<>""){
				$sql  = "INSERT INTO detail_produits_frs ( frs, produit )
				VALUES ( ";
				$sql .= "'" . $frs . "', ";
				$sql .= "'" . $produit3 . "');";
				db_query($database_name, $sql);
				}
				
				if ($produit4<>""){
				$sql  = "INSERT INTO detail_produits_frs ( frs, produit )
				VALUES ( ";
				$sql .= "'" . $frs . "', ";
				$sql .= "'" . $produit4 . "');";
				db_query($database_name, $sql);

				}
				
				if ($produit5<>""){
				$sql  = "INSERT INTO detail_produits_frs ( frs, produit )
				VALUES ( ";
				$sql .= "'" . $frs . "', ";
				$sql .= "'" . $produit5 . "');";
				db_query($database_name, $sql);
				}
				

				if ($produit6<>""){
				$sql  = "INSERT INTO detail_produits_frs ( frs, produit )
				VALUES ( ";
				$sql .= "'" . $frs . "', ";
				$sql .= "'" . $produit6 . "');";
				db_query($database_name, $sql);

				}
				
				if ($produit7<>""){
				$sql  = "INSERT INTO detail_produits_frs ( frs, produit )
				VALUES ( ";
				$sql .= "'" . $frs . "', ";
				$sql .= "'" . $produit7 . "');";
				db_query($database_name, $sql);

				}
	

				if ($produit8<>""){
				$sql  = "INSERT INTO detail_produits_frs ( frs, produit )
				VALUES ( ";
				$sql .= "'" . $frs . "', ";
				$sql .= "'" . $produit8 . "');";
				db_query($database_name, $sql);

				}
		
				if ($produit9<>""){
				$sql  = "INSERT INTO detail_produits_frs ( frs, produit )
				VALUES ( ";
				$sql .= "'" . $frs . "', ";
				$sql .= "'" . $produit9 . "');";
				db_query($database_name, $sql);

				}
		
				if ($produit10<>""){
				$sql  = "INSERT INTO detail_produits_frs ( frs, produit )
				VALUES ( ";
				$sql .= "'" . $frs . "', ";
				$sql .= "'" . $produit10 . "');";
				db_query($database_name, $sql);
				}
				if ($produit11<>""){
				$sql  = "INSERT INTO detail_produits_frs ( frs, produit )
				VALUES ( ";
				$sql .= "'" . $frs . "', ";
				$sql .= "'" . $produit11 . "');";
				db_query($database_name, $sql);
				}
				if ($produit12<>""){
				$sql  = "INSERT INTO detail_produits_frs ( frs, produit )
				VALUES ( ";
				$sql .= "'" . $frs . "', ";
				$sql .= "'" . $produit12 . "');";
				db_query($database_name, $sql);
				}
				if ($produit13<>""){
				$sql  = "INSERT INTO detail_produits_frs ( frs, produit )
				VALUES ( ";
				$sql .= "'" . $frs . "', ";
				$sql .= "'" . $produit13 . "');";
				db_query($database_name, $sql);
				}
				if ($produit14<>""){
				$sql  = "INSERT INTO detail_produits_frs ( frs, produit )
				VALUES ( ";
				$sql .= "'" . $frs . "', ";
				$sql .= "'" . $produit14 . "');";
				db_query($database_name, $sql);
				}
				if ($produit15<>""){
				$sql  = "INSERT INTO detail_produits_frs ( frs, produit )
				VALUES ( ";
				$sql .= "'" . $frs . "', ";
				$sql .= "'" . $produit15 . "');";
				db_query($database_name, $sql);
				}
				if ($produit16<>""){
				$sql  = "INSERT INTO detail_produits_frs ( frs, produit )
				VALUES ( ";
				$sql .= "'" . $frs . "', ";
				$sql .= "'" . $produit16 . "');";
				db_query($database_name, $sql);
				}
				if ($produit17<>""){
				$sql  = "INSERT INTO detail_produits_frs ( frs, produit )
				VALUES ( ";
				$sql .= "'" . $frs . "', ";
				$sql .= "'" . $produit17 . "');";
				db_query($database_name, $sql);
				}
				if ($produit18<>""){
				$sql  = "INSERT INTO detail_produits_frs ( frs, produit )
				VALUES ( ";
				$sql .= "'" . $frs . "', ";
				$sql .= "'" . $produit18 . "');";
				db_query($database_name, $sql);
				}
				if ($produit19<>""){
				$sql  = "INSERT INTO detail_produits_frs ( frs, produit )
				VALUES ( ";
				$sql .= "'" . $frs . "', ";
				$sql .= "'" . $produit19 . "');";
				db_query($database_name, $sql);
				}
				if ($produit20<>""){
				$sql  = "INSERT INTO detail_produits_frs ( frs, produit )
				VALUES ( ";
				$sql .= "'" . $frs . "', ";
				$sql .= "'" . $produit20 . "');";
				db_query($database_name, $sql);
				}
				
			
			break;

			case "update_user":
			
			$produit = $_REQUEST["produit"];
			$sql = "UPDATE detail_produits_frs SET ";
			$sql .= "produit = '" . $produit . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
			

			break;
			
			case "delete_user":
			
		$sql  = "SELECT * ";
		$sql .= "FROM detail_produits_frs WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$numero = $user_["commande"];$produit = $user_["produit"];
		

			$sql = "DELETE FROM detail_produits_frs WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);

		$id = $numero;$id_c = $frs;
		$sql  = "SELECT * ";
		$sql .= "FROM rs_data_fournisseurs WHERE last_name = " . $frs . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$frs = $user_["last_name"];
			
			
			break;


		} //switch
		
	} //if
	else
	{
	
	$frs=$_GET['frs'];
		
	}
	
	
?>
</table>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php  ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">


</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<table class="table2">
<td><?php echo $client;?></td><td><?php 
?></td>
</table>
<tr>
<table class="table2">

<tr>
	
	<th><?php $total=0;echo "Famille Aarticle";?></th>
	
</tr>

<?	
	
	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_produits_frs where frs='$frs' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { ?>
<?php $produit=$users1_["produit"]; $id=$users1_["id"];

		$sub=$users1_["sub"];
echo "<td><a href=\"remplir_panier_frs.php?user_id=$id&frs=$frs\">$produit</a></td>";?>

</tr>
<?	}?>

</table>
<table>
<tr>
<? echo "<td><a href=\"remplir_panier_frs.php?user_id=0&frs=$frs\">Ajout categorie </a></td>";?>
</tr><tr>

</table>

<p style="text-align:center">


</body>

</html>