<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$user_id=0;$action_="insert_new_user";$date=date("Y-m-d");$datefr=date("d-m-Y");$date_ins=date("Y-m-d h:i:sa");
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) ) { 

		if($_REQUEST["action_"] != "delete_user" and $_REQUEST["action_"] != "import") {
			// prepares data to simplify database insert or update
			$barecode = $_REQUEST["barecode"];
			echo $barecode;
			$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE barecode = '$barecode' ;";$id_p=$_REQUEST["user_id"];
		$userp = db_query($database_name, $sql);
		$user_a = fetch_array($userp);$condit = $user_a["condit"];$id_produit = $user_a["id"];$produit = $user_a["produit"];$palette = $user_a["palette"];
			
			$depot_a=$_REQUEST["depot_a"];$depot_c=0;$depot_b=0;
			if ($depot_a>0){}else{$depot_a = $palette;}
			
			;$type="production";
			
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		if($produit <> "") {
	
				$sql  = "INSERT INTO entrees_stock_test ( produit,barecode, date,date_ins,depot_a,type,depot_b ) VALUES ( ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $barecode . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $date_ins . "', ";
				$sql .= "'" . $depot_a . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
				
				
					$barecode = "";$depot_a="";
			}
		
							
			break;

			case "update_user":
			
			$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE barecode = '$barecode' ;";$id_p=$_REQUEST["user_id"];
		$userp = db_query($database_name, $sql);
		$user_a = fetch_array($userp);$condit = $user_a["condit"];$id_produit = $user_a["id"];$produit = $user_a["produit"];$palette = $user_a["palette"];
			
			$accessoire_1 = "";$accessoire_2 = "";$accessoire_3 = "";$accessoire_4 = "";$accessoire_5 = "";$accessoire_6 = "";
			
			$sql = "UPDATE entrees_stock_test SET ";
			$sql .= "produit = '" . $_REQUEST["produit"] . "', ";
			$sql .= "depot_a = '" . $_REQUEST["depot_a"] . "', ";
			
			$sql .= "date = '" . $date . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
			$sql = "DELETE FROM entrees_stock_acc WHERE id_p = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
						//accessoires
			$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit' ;";$id_p=$_REQUEST["user_id"];
		$userp = db_query($database_name, $sql);
		$user_a = fetch_array($userp);$condit = $user_a["condit"];$id_produit = $user_a["id"];
					
			break;
			
			case "delete_user":
			
			// delete user's profile
			$sql = "DELETE FROM entrees_stock_test WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			$sql = "DELETE FROM entrees_stock_acc WHERE id_p = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
			break;

			case "import":

			echo "importation en cours";
			break;


		}

	$vide="";
				$sql = "DELETE FROM entrees_stock_test WHERE produit = '" . $vide . "';";
				db_query($database_name, $sql);
		//switch
	} //if
	
	
	// recherche ville
	?>
	
		
	<? 
	$sql  = "SELECT * ";$type="production";$dj=date("Y-m-d");
	$sql .= "FROM entrees_stock_test where type='$type' and date='$dj' ORDER BY date;";
	$users = db_query($database_name, $sql);

	
?>



<body style="background:#dfe8ff">
	<? require "body_cal.php";?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "ENTREE PRODUCTION"; ?></span>


<table class="table2">

<tr>
	<th><?php echo "DATE";?></th>
	<th><?php echo "Article : "; ?></th>
	<th><?php echo "Quantite"; ?></th>
	
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<? $user_id=$users_["id"];$date1=dateUsToFr($users_["date"]);

?>
<td style="text-align:left"><?php echo $date1; ?></td>
<td style="text-align:left"><?php echo $users_["produit"]; ?></td>
<td style="text-align:left"><?php echo $users_["depot_a"]; ?></td>


<?php } ?>

</table>

<p style="text-align:center">

</body>

</html>