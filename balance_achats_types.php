<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$caisse="";$action="Recherche";$date="";$date1="";$du="";$au="";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">


</head>

<body style="background:#dfe8ff">
		<? require "body_cal.php";?>

	<?
	
			if(isset($_REQUEST["action"])){}else{
	?>
	<form id="form" name="form" method="post" action="balance_achats_types.php">
	<td><?php echo "Du : "; ?><input onclick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" />
	<td><?php echo "Au : "; ?><input onclick="ds_sh(this);" name="date1" readonly="readonly" style="cursor: text" />
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }
	if(isset($_REQUEST["action"]))
	{
	
	$date=dateFrToUs($_POST['date']);$du=$_POST['date'];$date1=dateFrToUs($_POST['date1']);$au=$_POST['date1'];
	$du=$_POST['date'];$au=$_POST['date1'];
	
	$sql  = "SELECT date,frs,produit,ref,type,sum(qte) As total_qte,sum(prix_achat) As total_prix,sum(qte*prix_achat) as valeur ";
	$sql .= "FROM achats_mat where date between '$date' and '$date1' GROUP BY type;";
	$users = db_query($database_name, $sql);
	
	?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Balance Achats $du au $au"; ?></span>

<p style="text-align:center">


<table class="table2">

<tr>
	<th><?php echo "Designation";?></th>
	<th><?php echo "Qte";?></th>
	<th><?php echo "Valeur";?></th>
</tr>

<?php $debit=0;$credit=0;$t=0;$s=0;$t_avoir_t=0;$p=0;
while($users_ = fetch_array($users)) { ?><tr>
<?php $produit=$users_["produit"];$type=$users_["type"];if ($type=="col"){$titre="colorants";}
if ($type=="emb"){$titre="Emballages";}
if ($type=="eti"){$titre="Etiquettes";}if ($type=="mat"){$titre="Matiere Premiere";}
if ($type=="mat_cons"){$titre="Matiere Consomable";}
if ($type=="divers"){$titre="Divers";}
?>
<? echo "<td><a href=\"balance_achats_details_types.php?produit=$type&date=$date&date1=$date1\">$titre</a></td>";?>

<? /*echo "<td><a href=\"balance_achats_produit.php?produit=$produit&date=$date&date1=$date1\">$produit</a></td>";*/?>
<td align="right"><?php $t=$t+$users_["total_qte"];echo number_format($users_["total_qte"],3,',',' ');?></td>
<td align="right"><?php $p=$p+($users_["valeur"]);
echo number_format($users_["valeur"],2,',',' ');?></td>

<?php } ?>
<tr><td></td><td align="right"><?php echo number_format($t,3,',',' ');?></td>
<td align="right"><?php echo number_format($p,2,',',' ');?></td>
</table>
<?php } ?>


<p style="text-align:center">

</body>

</html>