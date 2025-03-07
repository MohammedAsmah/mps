<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";	$du="";$au="";$action="Recherche";

	
	?>
	<form id="form" name="form" method="post" action="ca_par_quantite_par_prix.php">
	<td><?php echo "Du : "; ?><input type="text" id="du" name="du" value="<?php echo $du; ?>" size="15"></td>
	<td><?php echo "Au : "; ?><input type="text" id="au" name="au" value="<?php echo $au; ?>" size="15"></td>
	<tr>
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<?
	if(isset($_REQUEST["action"]))
	{
	 $du=dateFrToUs($_POST['du']);$au=dateFrToUs($_POST['au']);
	 $ca=0;
	 
	
	
?>
</table>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "Detail Evaluation"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "produit.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<table class="table2">

<tr>
	<th><?php $total=0;$pt=0;echo "Produit";?></th>
	<th><?php echo "Matiere";?></th>
	<th><?php echo "Quantité";?></th>
	<th><?php echo "condit";?></th>
	<th><?php echo "Poids Unit /g";?></th>
	<th><?php echo "Poids Total /kg";?></th>
</tr>



<?	
$sql1  = "SELECT * ";$art="article";
		$sql1 .= "FROM produits where famille='$art' ORDER BY produit;";
		$users1p = db_query($database_name, $sql1);
		while($users_p = fetch_array($users1p)) { 
 		$produit = $users_p["produit"];
	echo "<tr><td><a href=\"ca_par_quantite_details.php?matiere=$produit&du=$du&au=$au\">$produit</a></td><td><table>";

	if ($du>"2016-12-31"){
	$sql  = "SELECT produit,matiere,poids,prix_unit ";
	$sql .= "FROM detail_factures where date_f between '$du' and '$au' and produit='$produit' group BY prix_unit;";
	}
	else
	{
	$sql  = "SELECT produit,matiere,poids,prix_unit,date_f ";
	$sql .= "FROM detail_factures2016 where date_f between '$du' and '$au' and produit='$produit' group BY prix_unit order by date_f;";
	}
	$users = db_query($database_name, $sql);
	while($users_ = fetch_array($users)) { 
 		$produit = $users_["produit"];$prix_unit=number_format($users_["prix_unit"],2,',',' ');	$dt = dateUstoFr($users_["date_f"]);	
	
	 echo "<tr><td>$prix_unit</td><td>$dt</td>";?>

</tr>
<?	

 }
 echo "</table></tr>";
 } // fin action
 
 
 
  } // fin action
 
 ?>


</table>

<p style="text-align:center">


</body>

</html>