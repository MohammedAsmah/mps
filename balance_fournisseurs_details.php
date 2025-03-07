<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$caisse="";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url

			$frs=$_GET['frs'];$date1=$_GET['date'];$date1=$_GET['date1'];
			

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">


</head>

<body style="background:#dfe8ff">
	
	
<?			
	
	$sql  = "SELECT date,frs,produit,ref,taux_tva,type,sum(qte) As total_qte,sum(ttc) as valeur ";$eti="eti";
	$sql .= "FROM achats_mat where frs='$frs' GROUP BY ref order by date;";
	$users = db_query($database_name, $sql);
	?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Balance achats $frs "; ?></span>

<p style="text-align:center">


<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Reference";?></th>
	<th><?php echo "Valeur";?></th>
	<th><?php echo "Reglé";?></th>
	<th><?php echo "Mode";?></th>
	<th><?php echo "Solde";?></th>
	
</tr>

<?php $debit=0;$credit=0;$t=0;$q=0;$s=0;$mode_reg="";
while($users_ = fetch_array($users)) { ?>
<?php $dt=dateUsToFr($users_["date"]);$taux_tva=$users_["taux_tva"];$ref=$users_["ref"];?>

<?php $p=$users_["valeur"];$t=$t+$users_["valeur"];?>
<tr><td><?php echo $dt;?></td>
<td align="center"><?php echo $users_["ref"];?></td>
<td align="right"><?php echo number_format($p,2,',',' ');?></td><td><table>
		<? $sql  = "SELECT * ";$m=0;$net=$users_["valeur"];$mode_reg="";
		$sql .= "FROM porte_feuilles_frs WHERE id_commande='$ref' and vendeur = '" . $frs . "';";
		$user = db_query($database_name, $sql); $m=0;
		while($users_2 = fetch_array($user)) {?>
		
		<? $m=$m+$users_2["montant_e"];$mr=$mr+$users_2["montant_e"];$mode_reg=$users_2["mode_reg"];
		?>	<tr><td align="right"><?php echo number_format($users_2["montant_e"],2,',',' ')?></td>
			<td><?php echo $mode_reg;?></td></tr>
<?
		
		}
		$solde=$net-$m;$s=$s+$solde;
		
		?></table></td>

<td align="right"><?php echo number_format($solde,2,',',' ')?></td>		


<?php } ?>
<tr></tr>
<td></td><td></td>
<td align="right"><?php echo number_format($t,2,',',' ')?></td>
<td align="right"><?php echo number_format($mr,2,',',' ')?></td>
<td></td>
<td align="right"><?php echo number_format($s,2,',',' ')?></td>
</table>

<p style="text-align:center">

</body>

</html>