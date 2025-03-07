<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	
	// recherche ville
	 	if(isset($_REQUEST["action"])) { $date1 = $_REQUEST["date1"];$date2 = $_REQUEST["date2"];}
	else {$date1="";$date2="";}
	$action="recherche";

	 if(isset($_REQUEST["action"])){}else{ ?>
	<form id="form" name="form" method="post" action="etat_sorties.php">
	<td>
	<?php echo "Du : "; ?><input type="text" id="date1" name="date1" value="<?php echo $date1; ?>"></td>
	<td>
	<?php echo "Au : "; ?><input type="text" id="date2" name="date2" value="<?php echo $date2; ?>"></td>
	<input type="submit" id="action" name="action" value="<?php echo $action; ?>">
	</form>
	
	<? }
	if(isset($_REQUEST["action"]))
	{ $date=dateFrToUs($_POST['date1']);$date2=dateFrToUs($_POST['date2']);
	
	$sql  = "SELECT * ";
	$sql .= "FROM produits ORDER BY produit;";
	$users = db_query($database_name, $sql);
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Produits"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php $du=$_POST['date1'];$au=$_POST['date2'];echo "Etat de Sortie du : $du au $au"; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Article";?></th>
	<th><?php echo "MPS";?></th>
	<th><?php echo "JAOUDA";?></th>
	<th><?php echo "SORTIE TOTAL";?></th>
</tr>

<?php while($users_ = fetch_array($users)) { ?>

<?php $id=$users_["id"];$produit=$users_["produit"];?>
			
			<? 
			
			//sorties
			$sql1  = "SELECT produit,date,sum(depot_a) As total_depot_a,sum(depot_b) As total_depot_b,sum(depot_c) As total_depot_c ";
			$du="2009-09-02";$au=dateFrToUs(date("d/m/y"));
			$sql1 .= "FROM bon_de_sortie_magasin where produit='$produit' and date between '$date' and '$date2' group BY produit;";
			$users111 = db_query($database_name, $sql1);$users2 = fetch_array($users111);
			$s_depot_a = $users2["total_depot_a"];$s_depot_b = $users2["total_depot_b"];$s_depot_c = $users2["total_depot_c"];
			$mps=$s_depot_a;$jaouda=$s_depot_b;
			if ($mps>0 or $jaouda>0){
			?>
			
			
<tr><td><?php echo $produit; ?></td>
<td><?php echo $s_depot_a; ?></td>
<td><?php echo $s_depot_b; ?></td>
<td><?php echo ($s_depot_a)+($s_depot_b); ?></td>

<?php } } ?>

</table>
<? } ?>
<p style="text-align:center">

</body>

</html>
