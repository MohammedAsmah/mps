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
			// prepares data to simplify database insert or update
			$produit = $_REQUEST["produit"];$condit = $_REQUEST["condit"];$prix = $_REQUEST["prix"];$prix_rechange = $_REQUEST["prix_rechange"];
			$type = $_REQUEST["type"];$famille = $_REQUEST["famille"];$equipes = $_REQUEST["equipes"];
			$seuil_critique = $_REQUEST["seuil_critique"];$stock_comptable = $_REQUEST["stock_comptable"];$stock_ini_exe = $_REQUEST["stock_ini_exe"];
			if(isset($_REQUEST["dispo"])) { $dispo = 1; } else { $dispo = 0; }
			$date_dispo = dateFrtoUs($_REQUEST["date_dispo"]);
			if(isset($_REQUEST["dispo_f"])) { $dispo_f = 1; } else { $dispo_f = 0; }
			if(isset($_REQUEST["couleurs"])) { $couleurs = 1; } else { $couleurs = 0; }
			
			$p_marron = $_REQUEST["marron"];
			$p_beige = $_REQUEST["beige"];
			$p_gris = $_REQUEST["gris"];
						
			
			$r1 = $_REQUEST["r1"];$r2 = $_REQUEST["r2"];$r3 = $_REQUEST["r3"];
			
			
		}
		
		if ($login=="admin" or $login=="rakia" or $login=="najat" or $login=="driss"){
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				$sql  = "INSERT INTO produits ( produit, condit, ";
				$sql .= "prix,prix_rechange,r1,r2,r3,seuil_critique,famille,equipes, dispo,date_dispo,couleurs,p_marron,p_beige,p_gris,dispo_f ) VALUES ( ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $condit . "', ";
				$sql .= "'" . $prix . "', ";$sql .= "'" . $prix_rechange . "', ";
				$sql .= "'" . $r1 . "', ";$sql .= "'" . $r2 . "', ";$sql .= "'" . $r3 . "', ";
				$sql .= "'" . $seuil_critique . "', ";
				$sql .= "'" . $famille . "', ";$sql .= "'" . $equipes . "', ";$sql .= "'" . $dispo . "', ";$sql .= "'" . $date_dispo . "', ";
				$sql .= "'" . $couleurs . "', ";$sql .= "'" . $p_marron . "', ";$sql .= "'" . $p_beige . "', ";$sql .= "'" . $p_gris . "', ";
				$sql .= $dispo_f . ");";

				db_query($database_name, $sql);
			

			break;

			case "update_user":

			$sql = "UPDATE produits SET ";
			$sql .= "produit = '" . $_REQUEST["produit"] . "', ";
			if ($login=="admin"){
			$sql .= "stock_ini_exe = '" . $_REQUEST["stock_ini_exe"] . "', ";$sql .= "stock_initial_jp = '" . $_REQUEST["stock_ini_exe_jp"] . "', ";
			$sql .= "date_dispo = '" . $date_dispo . "', ";
			}
			$sql .= "condit = '" . $condit . "', ";$sql .= "seuil_critique = '" . $seuil_critique . "', ";
			$sql .= "dispo = '" . $dispo . "', ";$sql .= "prix_rechange = '" . $prix_rechange . "', ";$sql .= "dispo_f = '" . $dispo_f . "', ";
			$sql .= "prix = '" . $prix . "', ";$sql .= "r1 = '" . $r1 . "', ";$sql .= "r2 = '" . $r2 . "', ";$sql .= "r3 = '" . $r3 . "', ";
			$sql .= "couleurs = '" . $couleurs . "', ";$sql .= "p_marron = '" . $p_marron . "', ";$sql .= "p_beige = '" . $p_beige . "', ";$sql .= "p_gris = '" . $p_gris . "', ";
			$sql .= "famille = '" . $famille . "', ";$sql .= "equipes = '" . $equipes . "', ";
			$sql .= "stock_comptable = '" . $stock_comptable . "' ";
			
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			// delete user's profile
			$sql = "DELETE FROM produits WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	}
	} //if
	
	
	// recherche ville
	?>
	
	<?
	$sql  = "SELECT * ";$art="accessoire";
	$sql .= "FROM produits where famille='$art' ORDER BY dispo DESC,famille DESC,produit ASC;";
	$users = db_query($database_name, $sql);
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Produits"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "accessoire_article.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "liste accessoires"; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Code";?></th>
	<th><?php echo "Nom";?></th>
	<th><?php echo "Conditionnement";?></th>
	<th><?php echo "EMB";?></th>
	<th><?php echo "Prix Unit";?></th>
	
	<th><?php echo "Famille";?></th>
	<th><?php echo "Poids_eval";?></th>
	
	<th><?php echo "Dispo";?></th>
	<th><?php echo "Seuil";?></th>

</tr>

<?php $compteur=1;while($users_ = fetch_array($users)) { $produit=$users_["produit"];?><tr>

<? 
if ($login=="admin" or $login=="rakia" or $login=="najat" or $login=="leila"){?>
<td bgcolor="#66CCCC"><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $compteur;?></A></td>
<? }?>
<? $id_produit=$users_["id"];echo "<td><a href=\"fiches_techniques.php?produit=$produit&id_produit=$id_produit&produit=$produit\">$produit</a></td>";?>
<td bgcolor="#66CCCC"><?php echo $users_["condit"]; ?></td>
<td bgcolor="#66CCCC"><?php echo $users_["emballage3"]; ?></td>
<td style="text-align:left" bgcolor="#66CCCC" align="right"><?php echo $users_["prix"]; ?></td>
<td style="text-align:left" bgcolor="#66CCCC" align="left"><?php echo $users_["famille"]; ?></td>
<td bgcolor="#66CCCC" align="right"><?php echo $users_["poids_evaluation"]; ?></td>

<?php if ($users_["dispo"]==0){?><td bgcolor="#FF3333"><? echo "non";}else{?><td bgcolor="#0066FF"><? echo "oui";}; ?></td>

<td bgcolor="#66CCCC" align="left"><?php echo $users_["seuil_critique"]; ?></td>
<?php $compteur=$compteur+1;} ?>

</table>

<p style="text-align:center">
<? 
if ($login=="admin" or $login=="rakia" or $login=="najat" or $login=="leila"){?>
<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>
<? }?>	
	<?  echo "<tr><td><a href=\"produits_encours.php?\">Liste produits consommés</a></td>";?>

</body>

</html>