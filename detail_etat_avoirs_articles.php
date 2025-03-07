<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$date="";$date_f="";$vendeur="";$remise_1=0;$remise_2=0;$remise_3=0;
		$date="";$action="Recherche";	
	$profiles_list_vendeur = "";$vendeur="";
?>




<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Avoirs"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "avoir_client.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
	<? 
		$date1=$_GET['date1'];$date2=$_GET['date2'];$produit=$_GET['produit'];
		$date_du=dateUsToFr($_GET['date1']);$date_au=dateUsToFr($_GET['date2']);
		$sql  = "SELECT sum(quantite) as quantite,produit,date,client ";
		$sql .= "FROM detail_avoirs where date between '$date1' and '$date2' and produit='$produit' group by client ORDER BY quantite DESC;";
		$users = db_query($database_name, $sql);
		?>
	
	
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>
<span style="font-size:24px"><?php echo "liste Avoirs Du $date_du Au $date_au   -  $produit "; ?></span>

<table class="table2">

<tr>
	
	<? if ($produit==""){?>
	
	<th><?php echo "produit";?></th>
	<th><?php echo "Qte";?></th>

</tr>

<?php 

$total_g=0;$bon="";$client_g="";$total_gg=0;
while($users_ = fetch_array($users)) { ?><tr>
<? 

?>

<td><?php echo $users_["produit"]; ?></td>
<td><?php echo $users_["quantite"];$total_gg=$total_gg+$users_["quantite"]; ?></td>


<?php } ?>
<tr><td></td>
<td><?php echo $total_gg; ?></td>
<td></td>
	<? } else {?>
	
	
	
	<th><?php echo "Quantite";?></th>
	<th><?php echo "Client";?></th>
	</tr>
	
<?php 

$total_g=0;$bon="";$client_g="";$total_gg=0;
while($users_ = fetch_array($users)) { ?><tr>
<? 

?>


<td><?php echo $users_["quantite"]; $total_gg=$total_gg+$users_["quantite"];?></td>
<? $produit=$users_["produit"];$client=$users_["client"];
echo "<td><a href=\"detail_etat_avoirs_articles2.php?produit=$produit&client=$client&date1=$date&date2=$date2\">$client</a></td>";?>

<?php } ?>
<tr>
<td><?php echo $total_gg; ?></td>
<td></td>	
<?php } ?>	

</tr>

</table>


<p style="text-align:center">


</body>

</html>