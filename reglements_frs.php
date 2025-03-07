<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$du="";$au="";$vendeur="";$remise_1=0;$remise_2=0;$remise_3=0;
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	
	
	if(isset($_REQUEST["action_r"])) {
	
	if ($_REQUEST["action_r"]=="reglement"){
			$vendeur = $_REQUEST["vendeur"];
			$id_commande = $_REQUEST["id_commande"];$id_registre_regl = $_REQUEST["id_registre"];
			$montant_e = $_REQUEST["montant_e"];			
	
	$sql1  = "INSERT INTO porte_feuilles_frs 
	(vendeur,id_commande,id_registre_regl,montant_e )
	VALUES ('$vendeur','$id_commande','$id_registre_regl','$montant_e')";
	db_query($database_name, $sql1);
			$sql = "UPDATE achats_mat SET ";$p=1;
			$sql .= "preparation = '" . $p . "', ";
			$sql .= "id_registre_regl = '" . $id_registre_regl . "' ";
			$sql .= "WHERE frs='$vendeur' and ref = '" . $id_commande . "';";
			db_query($database_name, $sql);
			
			
			$id_registre = $_REQUEST["id_registre"];
			$vendeur=$_REQUEST["vendeur"];
			$date_enc=$_REQUEST["date_enc"];
	
	}
	else
	///mise à jour reglments //////////////////////////////
	{
		$id_registre = $_REQUEST["id_registre"];$vendeur=$_REQUEST["vendeur"];$date1=$_REQUEST["date1"];
		$date2=$_REQUEST["date2"];
		$id = $_REQUEST["id"];$montant_e=$_REQUEST["montant_e"];$id_commande=$_REQUEST["id_commande"];
			$preparation=$_REQUEST["preparation"];
			if(isset($_REQUEST["preparation"])) { $preparation = 1; } else { $preparation = 0; }
			$id_registre_regl = $_REQUEST["id_registre"];
			if ($preparation){
			$sql = "UPDATE porte_feuilles_frs SET ";
			$sql .= "montant_e = '" . $montant_e . "', ";
			$sql .= "vendeur = '" . $vendeur . "', ";
			$sql .= "id_commande = '" . $id_commande . "' ";
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);
				}
				else
			{
			
			$id_registre_regl=0;
			$sql = "DELETE FROM porte_feuilles_frs WHERE vendeur='$vendeur' and id_commande = '" . $id_commande . "';";
			db_query($database_name, $sql);}
			
			$sql = "UPDATE achats_mat SET ";$p=1;
			$sql .= "preparation = " . $preparation . ", ";
			$sql .= "id_registre_regl = '" . $id_registre_regl . "' ";
			$sql .= "WHERE frs='$vendeur' and ref = '" . $id_commande . "';";
			db_query($database_name, $sql);
			
		
			

	
	}
			
	
	}
		
	else
	{

	$id_registre=$_GET['id_registre'];
	@$date=$_GET['date_enc'];@$date3=$_GET['date_enc'];@$date_enc=$_GET['date_enc'];
	$vendeur=$_GET['vendeur'];$date1=$_GET['date1'];$vendeur=$_GET['vendeur'];$date2=$_GET['date2'];
		
	}
	$sql  = "SELECT preparation,validation,date,frs,produit,ref,taux_tva,type,sum(qte) As total_qte,sum(prix_achat) As total_prix,sum(ttc) as valeur ";$eti="eti";
	$sql .= "FROM achats_mat where frs='$vendeur' GROUP BY ref order by date;";
	$users = db_query($database_name, $sql);
	
	?>

	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Evaluations"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";
	?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>
<span style="font-size:24px"><?php echo ""; ?></span>
<tr>
<td><?php echo $vendeur ;?></td>

<? $action_l="l";echo "<td><a href=\"registres_reglements_frs.php?action_l=$action_l&vendeur=$vendeur&date1=$date1&date2=$date2\">-->Retour Liste Reglements</a></td>";?>

</tr>

<table class="table2">

<tr>
	<th><?php echo "Facture";?></th>
	<th><?php echo "Date";?></th>
	<th><?php echo "Montant";?></th>
	<th><?php echo "Reglé";?></th>	
	<th><?php echo "Solde";?></th>
</tr>

<?php 

$total_g=0;
while($users_ = fetch_array($users)) { ?>
	<? $id_commande=$users_["id"];$pre=$users_["preparation"];$ref=$users_["ref"];$date=dateUsToFr($users_["date"]);
	$p=$users_["total_prix"]*$users_["total_qte"];$taux_tva=$users_["taux_tva"];?>
	<?php $id=$users_["id"];$net=$users_["valeur"]; ?>
	<? $sql  = "SELECT * ";
		$sql .= "FROM porte_feuilles_frs WHERE vendeur='$vendeur' and id_commande = '" . $ref . "';";
		$user = db_query($database_name, $sql); $m=0;
		while($users_2 = fetch_array($user)) {
		$m=$m+$users_2["montant_e"];
		}
	$solde=$net-$m;?><tr>
	<? echo "<td>$ref</td>";?>
	
	<? if ($pre){?>
	<td bgcolor="#66CCCC"><?php echo $date; ?></td>
	<? } else {?>
		<td><?php echo $date; ?></td>
		<? }?>
	<td style="text-align:Right"><?php echo number_format($net,2,',',' '); ?></td>
	<td style="text-align:Right"><?php echo number_format($m,2,',',' '); ?></td>
		<td style="text-align:Right"><?php echo number_format($net-$m,2,',',' '); ?></td>
	
	<? if ($solde<>0){echo "<td><a href=\"evaluation_vers_reglement_frs.php?evaluation=$ref&montant=$solde&id_commande=$id_commande&
	id_registre=$id_registre&vendeur=$vendeur&date_enc=$date_enc\">valider</a></td>";}else {echo "<td></td>";}
	
	?>
	
	
	
<?php } ?>

</table>
<tr>
</tr>

<p style="text-align:center">

</body>

</html>