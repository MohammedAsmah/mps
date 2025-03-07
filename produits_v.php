<?php
	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$login = $user_["login"];
	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"])) { 

		if($_REQUEST["action_"] != "delete_user") {
			
			
			$hauteur = $_REQUEST["hauteur"];
			$longueur = $_REQUEST["longueur"];
			$largeur = $_REQUEST["largeur"];
			
			$barecode_piece = $_REQUEST["barecode_piece"];
						
			
			
			
			
		}
		
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				

			break;

			case "update_user":
			
			
			$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

				
			
			$sql = "UPDATE produits SET ";
			
			$sql .= "hauteur = '" . $hauteur . "', ";$sql .= "longueur = '" . $longueur . "', ";$sql .= "largeur = '" . $largeur . "', ";
			$sql .= "barecode_piece = '" . $barecode_piece . "' ";
			
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
	
			
			break;
			
			case "delete_user":
			
			
			break;


		} //switch
	
	} //if
	
	
	// recherche ville
	?>
	
	<?
	$sql  = "SELECT * ";$art="article";
	//$sql .= "FROM produits where famille='$art' ORDER BY dispo DESC,famille DESC,produit ASC;";
	$sql .= "FROM produits where famille='$art' and dispo=1 ORDER BY produit ASC;";
	$users = db_query($database_name, $sql);
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Produits"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "produit_v.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "liste Produits"; ?></span>
<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>
<table class="table2">

<tr>
	<th><?php echo "Code";?></th>
	<th><?php echo "designation";?></th>
	<th><?php echo "Conditionnement";?></th>
	<th><?php echo "hauteur";?></th>
	<th><?php echo "longueur";?></th>
	
	<th><?php echo "largeur";?></th>
	
	<th><?php echo "Barecode Pi";?></th>
	

</tr>

<?php $compteur=1;while($users_ = fetch_array($users)) { $produit=$users_["produit"];$prix1=$users_["prix"];$user_id=$users_["id"];$dispo_f=$users_["dispo_f"];$dispo=$users_["dispo"];

		/*	$sql  = "SELECT * ";
		$sql .= "FROM liste_prix_revient WHERE produit = '$produit';";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$prix_revient = $user_["prix"];
			
			
			$sql = "UPDATE produits SET dispo_stock = $dispo WHERE id = '$user_id'";
			db_query($database_name, $sql);*/





?><tr>

<? 
?>
<td bgcolor="#66CCCC"><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $compteur;?></A></td>
<? //}?>
<? $id_produit=$users_["id"];?>
<td bgcolor="#66CCCC" align="left"><?php echo $users_["designation"]; ?></td>
<td bgcolor="#66CCCC" align="left"><?php echo $users_["condit"]; ?></td>

<td bgcolor="#66CCCC" align="left"><?php echo $users_["hauteur"]; ?></td>
<td bgcolor="#66CCCC" align="left"><?php echo $users_["longueur"]; ?></td>
<td bgcolor="#66CCCC" align="left"><?php echo $users_["largeur"]; ?></td>

<td bgcolor="#66CCCC"><?php echo $users_["barecode_piece"]; ?></td>
<?php $compteur=$compteur+1;} ?>

</table>

<p style="text-align:center">
<? 
?>


</body>

</html>