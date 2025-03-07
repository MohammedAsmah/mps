<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$date="";$date_f="";$vendeur="";$remise_1=0;$remise_2=0;$remise_3=0;
		$date="";$action="Recherche";	
	$profiles_list_vendeur = "";$vendeur="";

	
	$profiles_list_article;
	$sql1 = "SELECT * FROM produits ORDER BY produit;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($produit == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_article .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$profiles_list_article .= $temp_["produit"];
		$profiles_list_article .= "</OPTION>";
	}
	$destination="";
		if(isset($_REQUEST["action"])){}else{
	?>
	<form id="form" name="form" method="post" action="etat_avoirs_articles.php">
	<table>
	<td><?php echo "Du: "; ?><input onClick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" /></td>
	<td><?php echo "Au: "; ?><input onClick="ds_sh(this);" name="date2" readonly="readonly" style="cursor: text" /></td>
	
	<td><?php echo "Article: "; ?></td><td><select id="produit" name="produit"><?php echo $profiles_list_article; ?></select></td>
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }?>
	


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
	if(isset($_REQUEST["action"]))
	{$date=dateFrToUs($_POST['date']);$date_f=dateFrToUs($_POST['date']);$date2=dateFrToUs($_POST['date2']);
	$produit=$_POST['produit'];$date_au=$_POST['date2'];$date_du=$_POST['date'];
		
		if ($produit<>""){
		$sql  = "SELECT sum(quantite) as qte,produit,date,client ";
		$sql .= "FROM detail_avoirs where date between '$date' and '$date2' and produit='$produit' group by client ORDER BY id;";
		$users = db_query($database_name, $sql);
		}
		else
		{
		$sql  = "SELECT sum(quantite) as qte,produit,date,client ";
		$sql .= "FROM detail_avoirs where date between '$date' and '$date2' group by produit ORDER BY produit ;";
		$users = db_query($database_name, $sql);
		}
		?>
	
	
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>
<span style="font-size:24px"><?php echo "liste Avoirs Du $date_du Au $date_au   -  $produit "; ?></span>

<table class="table2">

<tr>
	
	<? if ($produit==""){?>
	
	<th><?php echo "produit";?></th>
	<th><?php echo "Qte Retour";?></th>
	<th><?php echo "Qte Vendu";?></th>
	<th><?php echo "    %     ";?></th>
	

</tr>

<?php 

$total_g=0;$bon="";$client_g="";$total_gg=0;
while($users_ = fetch_array($users)) { ?><tr>
<? 

?>
<? $produit=$users_["produit"];echo "<td><a href=\"detail_etat_avoirs_articles.php?produit=$produit&date1=$date&date2=$date2\">$produit</a></td>";?>

<td><?php echo $users_["qte"]; $total_gg=$total_gg+$users_["qte"];?></td>

		<? $sql  = "SELECT * ";
		$sql .= "FROM detail_commandes where produit='$produit' and date between '$date' and '$date2' ORDER BY date ;";
		$users_c = db_query($database_name, $sql);$total_c=0;
		while($users_cc = fetch_array($users_c)) { 
			$total_c=$total_c+($users_cc["quantite"]*$users_cc["condit"]);}
			
		?>
		<td><?php echo $total_c; $total_cc=$total_cc+$total_c;?></td>
		<td><?php if ($total_c==0){$p=0;}else{$p=$users_["qte"]/$total_c*100;} echo number_format($p,2,',',' ');?></td>
		

<?php } ?>
<tr><td></td>
<td><?php echo $total_gg; ?></td>
<td></td>
	<? } else {?>
	
	
	<th><?php echo "Produit";?></th>
	<th><?php echo "Qte";?></th>
	<th><?php echo "Client";?></th>
	</tr>
	
<?php 

$total_g=0;$bon="";$client_g="";$total_gg=0;
while($users_ = fetch_array($users)) { ?><tr>
<? 

?>

<td><?php echo $users_["produit"]; ?></td>
<td><?php echo $users_["qte"]; ?></td>
<td><?php echo $users_["client"];$total_gg=$total_gg+$users_["qte"]; ?></td>



<?php } ?>	
<tr><td></td>
<td><?php echo $total_gg; ?></td>
<td></td>
<?php } ?>	

</tr>

</table>
<?php } ?>	

<p style="text-align:center">


</body>

</html>