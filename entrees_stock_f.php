<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$login = $user_["login"];$date_ins=date("y-m-d");
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 

		if($_REQUEST["action_"] != "delete_user" and $_REQUEST["action_"] != "import") {
			$id=$_REQUEST["user_id"];
			// prepares data to simplify database insert or update
			$produit = $_REQUEST["produit"];$depot_a=$_REQUEST["depot_a"];$depot_c=0;$depot_b=0;
			if(isset($_REQUEST["achat"])) { $achat = 1; } else { $achat = 0; }
			$date = dateFrToUs($_REQUEST["date"]);$date1 = $_REQUEST["date"];$type="production";
	if($_REQUEST["action_"] == "insert_new_user") {	
	
		$produit1 = $_REQUEST["produit1"];$depot_a1=$_REQUEST["depot_a1"];$produit2 = $_REQUEST["produit2"];$depot_a2=$_REQUEST["depot_a2"];
		$produit3 = $_REQUEST["produit3"];$depot_a3=$_REQUEST["depot_a3"];$produit7 = $_REQUEST["produit7"];$depot_a7=$_REQUEST["depot_a7"];
		$produit4 = $_REQUEST["produit4"];$depot_a4=$_REQUEST["depot_a4"];$produit5 = $_REQUEST["produit5"];$depot_a5=$_REQUEST["depot_a5"];
		$produit6 = $_REQUEST["produit6"];$depot_a6=$_REQUEST["depot_a6"];$produit8 = $_REQUEST["produit8"];$depot_a8=$_REQUEST["depot_a8"];
		$produit9 = $_REQUEST["produit9"];$depot_a9=$_REQUEST["depot_a9"]; 
		
		
		if(isset($_REQUEST["achat1"])) { $achat1 = 1; } else { $achat1 = 0; }
		if(isset($_REQUEST["achat2"])) { $achat2 = 1; } else { $achat2 = 0; }
		if(isset($_REQUEST["achat3"])) { $achat3 = 1; } else { $achat3 = 0; }
		if(isset($_REQUEST["achat4"])) { $achat4 = 1; } else { $achat4 = 0; }
		if(isset($_REQUEST["achat5"])) { $achat5 = 1; } else { $achat5 = 0; }
		if(isset($_REQUEST["achat6"])) { $achat6 = 1; } else { $achat6 = 0; }
		if(isset($_REQUEST["achat7"])) { $achat7 = 1; } else { $achat7 = 0; }
		if(isset($_REQUEST["achat8"])) { $achat8 = 1; } else { $achat8 = 0; }
		if(isset($_REQUEST["achat9"])) { $achat9 = 1; } else { $achat9 = 0; }
		
		}
		
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		if($_REQUEST["depot_a"] > 0) {	
				$sql  = "INSERT INTO entrees_stock_f ( produit, date,date_ins,depot_a,type,achat ) VALUES ( ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $date_ins . "', ";
				
				$sql .= "'" . $depot_a . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $achat . ");";
				db_query($database_name, $sql);
			}
		if($_REQUEST["depot_a1"] > 0) {	
				$sql  = "INSERT INTO entrees_stock_f ( achat,produit, date,date_ins,user,depot_a,type,depot_b ) VALUES ( ";
				$sql .= "'" . $achat1 . "', ";$sql .= "'" . $produit1 . "', ";
				$sql .= "'" . $date . "', ";$sql .= "'" . $date_ins . "', ";$sql .= "'" . $user . "', ";
				$sql .= "'" . $depot_a1 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			}
		if($_REQUEST["depot_a2"] > 0) {	
				$sql  = "INSERT INTO entrees_stock_f ( achat,produit, date,date_ins,user,depot_a,type,depot_b ) VALUES ( ";
				$sql .= "'" . $achat2 . "', ";$sql .= "'" . $produit2 . "', ";
				$sql .= "'" . $date . "', ";$sql .= "'" . $date_ins . "', ";$sql .= "'" . $user . "', ";
				$sql .= "'" . $depot_a2 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			}
		if($_REQUEST["depot_a3"] > 0) {	
				$sql  = "INSERT INTO entrees_stock_f ( achat,produit, date,date_ins,user,depot_a,type,depot_b ) VALUES ( ";
				$sql .= "'" . $achat3 . "', ";$sql .= "'" . $produit3 . "', ";
				$sql .= "'" . $date . "', ";$sql .= "'" . $date_ins . "', ";$sql .= "'" . $user . "', ";
				$sql .= "'" . $depot_a3 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			}
		if($_REQUEST["depot_a4"] > 0) {	
				$sql  = "INSERT INTO entrees_stock_f ( achat,produit, date,date_ins,user,depot_a,type,depot_b ) VALUES ( ";
				$sql .= "'" . $achat4 . "', ";$sql .= "'" . $produit4 . "', ";
				$sql .= "'" . $date . "', ";$sql .= "'" . $date_ins . "', ";$sql .= "'" . $user . "', ";
				$sql .= "'" . $depot_a4 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			}
		if($_REQUEST["depot_a5"] > 0) {	
				$sql  = "INSERT INTO entrees_stock_f ( achat,produit, date,date_ins,user,depot_a,type,depot_b ) VALUES ( ";
				$sql .= "'" . $achat5 . "', ";$sql .= "'" . $produit5 . "', ";
				$sql .= "'" . $date . "', ";$sql .= "'" . $date_ins . "', ";$sql .= "'" . $user . "', ";
				$sql .= "'" . $depot_a5 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			}
		if($_REQUEST["depot_a6"] > 0) {	
				$sql  = "INSERT INTO entrees_stock_f ( achat,produit, date,date_ins,user,depot_a,type,depot_b ) VALUES ( ";
				$sql .= "'" . $achat6 . "', ";$sql .= "'" . $produit6 . "', ";
				$sql .= "'" . $date . "', ";$sql .= "'" . $date_ins . "', ";$sql .= "'" . $user . "', ";
				$sql .= "'" . $depot_a6 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			}
		if($_REQUEST["depot_a7"] > 0) {	
				$sql  = "INSERT INTO entrees_stock_f ( achat,produit, date,date_ins,user,depot_a,type,depot_b ) VALUES ( ";
				$sql .= "'" . $achat7 . "', ";$sql .= "'" . $produit7 . "', ";
				$sql .= "'" . $date . "', ";$sql .= "'" . $date_ins . "', ";$sql .= "'" . $user . "', ";
				$sql .= "'" . $depot_a7 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			}
		if($_REQUEST["depot_a8"] > 0) {	
				$sql  = "INSERT INTO entrees_stock_f ( achat,produit, date,date_ins,user,depot_a,type,depot_b ) VALUES ( ";
				$sql .= "'" . $achat8 . "', ";$sql .= "'" . $produit8 . "', ";
				$sql .= "'" . $date . "', ";$sql .= "'" . $date_ins . "', ";$sql .= "'" . $user . "', ";
				$sql .= "'" . $depot_a8 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			}
		if($_REQUEST["depot_a9"] > 0) {	
				$sql  = "INSERT INTO entrees_stock_f ( achat,produit, date,date_ins,user,depot_a,type,depot_b ) VALUES ( ";
				$sql .= "'" . $achat9 . "', ";$sql .= "'" . $produit9 . "', ";
				$sql .= "'" . $date . "', ";$sql .= "'" . $date_ins . "', ";$sql .= "'" . $user . "', ";
				$sql .= "'" . $depot_a9 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			}
			break;

			case "update_user":
			
			
			$sql = "UPDATE entrees_stock_f SET produit = '$produit',achat = '$achat'
			,depot_a = '$depot_a',date = '$date' WHERE id = '$id'";
			db_query($database_name, $sql);
			
			
			

			/*$sql = "UPDATE entrees_stock_f SET ";
			$sql .= "produit = '" . $_REQUEST["produit"] . "', ";
			$sql .= "achat = '" . $achat . "', ";
			$sql .= "depot_a = '" . $_REQUEST["depot_a"] . "', ";
			$sql .= "date = '" . $date . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);*/
			break;
			
			case "delete_user":
			
			// delete user's profile
			$sql = "DELETE FROM entrees_stock_f WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;

			case "import":

			echo "importation en cours";
			break;


		} //switch
	} //if
	
	
	// recherche ville
	?>
	
	<?
	
		$date="";$action="Recherche";
			if(isset($_REQUEST["action"])){}else{
	?>
	<form id="form" name="form" method="post" action="entrees_stock_f.php">
	<table><td><?php echo "Date: "; ?><input onClick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" />
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td></td></table>
	</form>
	
	<? }
	if(isset($_REQUEST["action"])){

	$sql  = "SELECT * ";$type="production";$date=dateFrToUs($_POST['date']);$date1=$_POST['date'];
	$sql .= "FROM entrees_stock_f where date='$date' and type='$type' ORDER BY date;";
	$users = db_query($database_name, $sql);}
	else
	{	
	
	/*$sql  = "SELECT * ";$type="production";$fe="2011-12-31";
	$sql .= "FROM entrees_stock_f where type='$type' and date>'$fe' ORDER BY date;";
	$users = db_query($database_name, $sql);*/
	
	$sql  = "SELECT id,produit,date,sum(depot_a) as depot ";$type="production";$fe="2023-12-31";
	$sql .= "FROM entrees_stock_f where type='$type' and date>'$fe' group by id ORDER BY date,id;";
	$users = db_query($database_name, $sql);
	
	
	}

	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "ENTREE PRODUCTION"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "entree_stock_f.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "ENTREE PRODUCTION"; ?></span>

<table class="table2">

<tr>
	<th><?php echo "DATE";?></th>
	<th><?php echo "ARTICLE";?></th>
	<th><?php echo "QUANTITE";?></th>
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<? $user_id=$users_["id"];$d=dateUsToFr($users_["date"]);echo "<td><a href=\"entree_stock_f.php?user_id=$user_id\">$d</a></td>";?>
<td><?php echo $users_["produit"]; ?></td>
<td style="text-align:left"><?php echo $users_["depot"]; ?></td>
<?php } ?>

</table>

<p style="text-align:center">
<table><tr><td>
<? echo "<a href=\"entree_stock_f.php?date=$date1&user_id=0\">Ajout Production</a></td>";?></tr><tr>
</table>
</body>

</html>