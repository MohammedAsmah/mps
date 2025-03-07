<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) ) { 

		if($_REQUEST["action_"] != "delete_user" and $_REQUEST["action_"] != "import") {
			
			
			$date = dateFrToUs($_REQUEST["date"]);$date1 = $_REQUEST["date"];
			
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
			break;

			case "update_user":
			$marron=$_REQUEST["marron"];$beige=$_REQUEST["beige"];$gris=$_REQUEST["gris"];
			$marron_b=$_REQUEST["marron_b"];$beige_b=$_REQUEST["beige_b"];$gris_b=$_REQUEST["gris_b"];
			$sql = "UPDATE bon_de_sortie_magasin SET ";
			$sql .= "marron = '" . $_REQUEST["marron"] . "', ";
			$sql .= "beige = '" . $_REQUEST["beige"] . "', ";
			$sql .= "gris = '" . $_REQUEST["gris"] . "', ";
			$sql .= "marron_b = '" . $_REQUEST["marron_b"] . "', ";
			$sql .= "beige_b = '" . $_REQUEST["beige_b"] . "', ";
			$sql .= "gris_b = '" . $_REQUEST["gris_b"] . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			
			break;

			
		}

			//switch
	} //if
	
	
	// recherche ville
	?>
	
	<?
	
		$action="Recherche";
			if(isset($_REQUEST["action"]) or isset($_REQUEST["action_"])){}else{
	?>
	<form id="form" name="form" method="post" action="sorties_stock_couleurs.php">
	<table><td><?php echo "Date: "; ?><input onClick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" />
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td></td></table>
	</form>
	
	<? }
	if(isset($_REQUEST["action"]) or isset($_REQUEST["action_"])){

	$sql  = "SELECT id ,id_registre,date,produit,sum(depot_a) As depot_a,sum(depot_b) As depot_b,sum(marron) As marron,sum(beige) As beige,sum(gris) As gris,sum(marron_b) As marron_b,sum(beige_b) As beige_b,sum(gris_b) As gris_b  ";$type="production";$date=dateFrToUs($_POST['date']);
	$sql .= "FROM bon_de_sortie_magasin where date='$date' group by produit ORDER BY date;";
	$users = db_query($database_name, $sql);}
	else
	{	$sql  = "SELECT id ,id_registre,date,produit,sum(depot_a) As depot_a,sum(depot_b) As depot_b,sum(marron) As marron,sum(beige) As beige,sum(gris) As gris,sum(marron_b) As marron_b,sum(beige_b) As beige_b,sum(gris_b) As gris_b ";$type="production";$dj=date("Y-m-d");
	$sql .= "FROM bon_de_sortie_magasin where date='$dj' group by produit ORDER BY date;";
	$users = db_query($database_name, $sql);}

	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "SYNTHESE COULEURS"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "sortie_stock_couleurs.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "SYNTHESE COULEURS"; ?></span>


<table class="table2">

<tr>
	<th><?php echo "DATE";?></th>
	<th><?php echo "BON DE SORTIE";?></th>
	<th><?php echo "ARTICLE";?></th>
	<th><?php echo "QTE MPS";?></th>
	<th><?php echo "QTE JP";?></th>
	<th><?php echo "MPS"; ?><table class="table2">
		<tr><th><?php echo "Marron"; ?></th>
		<th><?php echo "Beige"; ?></th>
		<th><?php echo "Gris"; ?></th></tr>
		</table>
	</th>
	<th><?php echo "JAOUDA"; ?><table class="table2">
		<tr><th><?php echo "Marron"; ?></th>
		<th><?php echo "Beige"; ?></th>
		<th><?php echo "Gris"; ?></th></tr>
		</table>
	</th>
</tr>

<?php while($users_ = fetch_array($users)) { ?>
<? $user_id=$users_["id"];$date=dateUsToFr($users_["date"]);$id_registre=$users_["id_registre"];
$sql  = "SELECT * ";
$sql .= "FROM registre_vendeurs WHERE id='$id_registre' Order BY id;";
		$user5 = db_query($database_name, $sql); $user_5 = fetch_array($user5);
		$bs=$user_5["statut"];



$produit=$users_["produit"];$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit='$produit' Order BY produit;";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$couleurs=$user_["couleurs"];
		$depot_a=$users_["depot_a"];$depot_b=$users_["depot_b"];
if ($couleurs=="1"){
echo "<tr><td><a href=\"sortie_stock_couleurs.php?user_id=$user_id&date=$date&bs=$bs&depot_a=$depot_a&depot_b=$depot_b\">$bs</a></td>";
?><td ><?php echo $date; ?></td>
<td ><?php echo $users_["produit"]; ?></td>
<td style="text-align:center"><?php echo $users_["depot_a"]; ?></td>
<td style="text-align:center"><?php echo $users_["depot_b"]; ?></td>
<td><table class="table2">
<td style="text-align:center"><?php echo $users_["marron"]; ?></td>
<td style="text-align:center"><?php echo $users_["beige"]; ?></td>
<td style="text-align:center"><?php echo $users_["gris"]; ?></td></table>
</td><td><table class="table2">
<td style="text-align:center"><?php echo $users_["marron_b"]; ?></td>
<td style="text-align:center"><?php echo $users_["beige_b"]; ?></td>
<td style="text-align:center"><?php echo $users_["gris_b"]; ?></td></table></td>
<? }  } ?>

</table>

<p style="text-align:center">
<table><tr><td>

</table>
</body>

</html>