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
	
	
	
	$sql  = "SELECT date,frs,produit,ref,type,taux_tva,sum(qte) As total_qte,sum(ttc) as valeur ";
	$sql .= "FROM achats_mat GROUP BY frs order by frs;";
	$users = db_query($database_name, $sql);
	
	/*$sql  = "SELECT * ";
	$sql .= "FROM achats_mat order by id;";
	$users = db_query($database_name, $sql);*/
	?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Balance Fournisseurs"; ?></span>

<p style="text-align:center">


<table class="table2">

<tr>
	<th><?php echo "Fournisseur";?></th>
	<th><?php echo "Relevé";?></th>
	<th><?php echo "Solde Factures";?></th>
	
</tr>

<?php $debit=0;$credit=0;$t=0;$s=0;$t_avoir_t=0;$p=0;$mr=0;
while($users_ = fetch_array($users)) { ?>
<?php $frs=$users_["frs"];$taux_tva=$users_["taux_tva"];$ref=$users_["ref"];$ttc=($users_["qte"]*$users_["prix_achat"])*(1+$users_["taux_tva"]/100);
		$sql  = "SELECT * ";$m=0;$net=$users_["valeur"];$id=$users_["id"];
		$sql .= "FROM porte_feuilles_frs WHERE vendeur = '" . $frs . "';";
		$user = db_query($database_name, $sql); $m=0;
		while($users_2 = fetch_array($user)) {
		$m=$m+$users_2["montant_e"];$mr=$mr+$users_2["montant_e"];
		}
		$solde=$net-$m;/*if ($solde>0){*/
	//////
	/*$id_registre_regl=1;
	$sql1  = "INSERT INTO porte_feuilles_frs 
	(vendeur,id_commande,id_registre_regl,montant_e )
	VALUES ('$frs','$ref','$id_registre_regl','$net')";
	db_query($database_name, $sql1);*/
	/////////////
			/*$sql = "UPDATE achats_mat SET ";
			$sql .= "ttc = " . $ttc . " ";
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);*/
	
	
	
	///////
	
?><tr>
<? echo "<td><a href=\"historique_fournisseur.php?frs=$frs\">$frs</a></td>";?>
<? echo "<td><a href=\"balance_fournisseurs_details.php?frs=$frs\">R</a></td>";?>

<?php $p=$p+($users_["valeur"]);$s=$s+$solde;?>


<td align="right"><?php 
echo number_format($solde,2,',',' ');?></td>

<?php /*}*/ ?>


<?php } ?>
<tr><td></td>

<td align="right"><?php echo number_format($s,2,',',' ');?></td>
</table>

<? echo "<td><a href=\"\\mps\\tutorial\\balance_fournisseurs.php\">Imprimer Balance </a></td>";?>

<p style="text-align:center">

</body>

</html>