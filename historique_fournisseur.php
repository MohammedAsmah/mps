<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$caisse="";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url

			$frs=$_GET['frs'];
			$sql = "TRUNCATE TABLE `historique_fournisseur`  ;";
			db_query($database_name, $sql);
			
			
			/*$sql = "DELETE FROM historique_fournisseur where frs='$frs' ;";
				db_query($database_name, $sql);*/

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

<span style="font-size:24px"><?php $today=date("d/m/Y H:m");echo "Historique Fournisseur : $frs au $today "; ?></span>

<p style="text-align:center">


<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Designation";?></th>
	<th><?php echo "Debit";?></th>
	<th><?php echo "Credit";?></th>
	<th><?php echo "Solde";?></th>
	
</tr>

<?php $debit=0;$credit=0;$t=0;$q=0;$s=0;
while($users_ = fetch_array($users)) { ?>
<?php $dt=dateUsToFr($users_["date"]);$taux_tva=$users_["taux_tva"];$ref=$users_["ref"];?>
<? //////////ajout debit
				$libelle="Facture Numero / $ref";
				$date=$users_["date"];$p=$users_["valeur"];
				
				$sql  = "INSERT INTO historique_fournisseur ( frs,date,libelle,credit ) VALUES ( ";
				$sql .= "'" . $frs . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $libelle . "', ";
				$sql .= $p . ");";
				db_query($database_name, $sql);
?>



<?php $t=$t+$users_["valeur"];?>

		<? $sql  = "SELECT * ";$m=0;$net=$users_["valeur"];
		$sql .= "FROM porte_feuilles_frs WHERE id_commande='$ref' and vendeur = '" . $frs . "';";
		$user = db_query($database_name, $sql); $m=0;
		while($users_2 = fetch_array($user)) {?>
		
		<? $m=$m+$users_2["montant_e"];$mr=$mr+$users_2["montant_e"];$mode_reg=$users_2["mode_reg"];
				$montant_e=$users_2["montant_e"];$paye_le=$users_2["paye_le"];
				$paye_le=$users_2["paye_le"];
				$sql  = "INSERT INTO historique_fournisseur ( frs,date,libelle,debit ) VALUES ( ";
				$sql .= "'" . $frs . "', ";
				$sql .= "'" . $paye_le . "', ";
				$sql .= "'" . $mode_reg . "', ";
				$sql .= $montant_e . ");";
				db_query($database_name, $sql);
		}
		$solde=$net-$m;$s=$s+$solde;
		
		?>


<?php } ?>

<? // edition
		$sql  = "SELECT * ";
		$sql .= "FROM historique_fournisseur where frs='$frs' order by date;";
		$user_frs_s = db_query($database_name, $sql); $m=0;$solde_s=0;
		while($users_frs_h_s = fetch_array($user_frs_s)) {$id=$users_frs_h_s["id"];
			$solde_s=$solde_s+$users_frs_h_s["credit"]-$users_frs_h_s["debit"];
			$sql = "UPDATE historique_fournisseur SET ";
			$sql .= "solde = " . $solde_s . " ";
			$sql .= "WHERE id = " . $id . " ;";
			db_query($database_name, $sql);
		}


		$du="2011-06-30";
		$sql  = "SELECT id,date,libelle,sum(debit) As total_debit,sum(credit) As total_credit ";
		$sql .= "FROM historique_fournisseur where frs='$frs' group by libelle order by date;";
		$user_frs = db_query($database_name, $sql); $m=0;$solde=0;
		while($users_frs_h = fetch_array($user_frs)) {?><tr>
		<td><? echo dateUsToFr($users_frs_h["date"]);?></td>
		<td><? echo $users_frs_h["libelle"];?></td>
		<td align="right"><? echo number_format($users_frs_h["total_debit"],2,',',' ');?></td>
		<td align="right"><? echo number_format($users_frs_h["total_credit"],2,',',' ');?></td>
		<td align="right"><? $solde=$solde+$users_frs_h["total_credit"]-$users_frs_h["total_debit"];
		echo number_format($solde,2,',',' ');?></td>
		
		
		
		
		<? }
		
		
		/*$du="2011-06-30";
		$sql  = "SELECT * ";
		$sql .= "FROM historique_fournisseur where frs='$frs' and date>'$du' order by date,id;";
		$user_frs = db_query($database_name, $sql); $m=0;$solde=0;
		while($users_frs_h = fetch_array($user_frs)) {?><tr>
		<td><? echo dateUsToFr($users_frs_h["date"]);?></td>
		<td><? echo $users_frs_h["libelle"];?></td>
		<td align="right"><? echo number_format($users_frs_h["debit"],2,',',' ');?></td>
		<td align="right"><? echo number_format($users_frs_h["credit"],2,',',' ');?></td>
		<td align="right"><? $solde=$solde+$users_frs_h["total_credit"]-$users_frs_h["total_debit"];
		echo number_format($users_frs_h["solde"],2,',',' ');?></td>
		
		
		
		
		<? }*/
		
		
		
		?>
		


</table>

<p style="text-align:center">

</body>

</html>