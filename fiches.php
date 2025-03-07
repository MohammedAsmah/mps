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
	$categorie=$_GET["categorie"];
	
	// recherche ville
	?>
	
	<?
	$sql  = "SELECT * ";$art="article";$vide="";
	//$sql .= "FROM produits where famille='$art' ORDER BY dispo DESC,famille DESC,produit ASC;";
	$sql .= "FROM produits where famille='$art' and dispo=1 and produit<>'$vide' and categorie='$categorie' ORDER BY produit ASC;";
	$users = db_query($database_name, $sql);
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "Liste des Articles"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "fiche.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Liste des Articles"; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Code";?></th>
	<th><?php echo "Designation";?></th>
	<th><?php echo "Accessoires";?></th>
	<th><?php echo "Condit.";?></th>
	<th><?php echo "Tarif";?></th>
	<th><?php echo "Poids";?></th>
	<th><?php echo "Seuil";?></th>
	<th><?php echo "Obs";?></th>

</tr>

<?php $compteur=1;while($users_ = fetch_array($users)) { $produit=$users_["produit"];$prix1=$users_["prix"];$user_id=$users_["id"];$dispo_f=$users_["dispo_f"];


			/*$sql = "UPDATE produits SET dispo_g = '$dispo_f' WHERE id = '$user_id'";
			db_query($database_name, $sql);
*/




?><tr>

<? 
if ($login=="admin"){?>
<td bgcolor="#66CCCC"><?php echo $compteur;?></td>
<? }?>
<? $id_produit=$users_["id"];$prix=$users_["prix"];$condit=$users_["condit"];$poids=$users_["poids_evaluation"];
echo "<td><a href=\"fiches_techniques.php?produit=$produit&id_produit=$id_produit&produit=$produit&condit=$condit&prix=$prix&poids_art=$poids&categorie=$categorie\">$produit</a></td>";
$sql  = "SELECT * ";$cc=0;
	$sql .= "FROM fiches_techniques where id_produit='$id_produit' GROUP BY id ORDER BY id;";
	$usersss = db_query($database_name, $sql);
    while($usersss_ = fetch_array($usersss)) {$cc=$cc+1;}


echo "<td align=\"center\">$cc </td>";
?>

<td bgcolor="#66CCCC" align="center"><?php echo $users_["condit"]; ?></td>
<td style="text-align:left" bgcolor="#66CCCC" align="right"><?php echo number_format($users_["prix"],2,',',' '); ?></td>
<td bgcolor="#66CCCC" align="center"><?php echo number_format($users_["poids_evaluation"],0,',',' '); ?></td>
<td bgcolor="#66CCCC" align="center"><?php echo number_format($users_["seuil_critique"],0,',',' '); ?></td>
<? if ($login=="admin" or $login=="driss"){echo "<td><a href=\"fiches_techniques1.php?categorie=$categorie&produit=$produit&id_produit=$id_produit&produit=$produit&condit=$condit&prix=$prix&poids=$poids\">$produit</a></td>";}?>
<?php $compteur=$compteur+1;} ?>

</table>

<p style="text-align:center">

	

</body>

</html>