<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";	$du="";$au="";$action="Recherche";

	
	?>
	<form id="form" name="form" method="post" action="ca_par_quantite.php">
	<td><?php echo "Du : "; ?><input type="text" id="du" name="du" value="<?php echo $du; ?>" size="15"></td>
	<td><?php echo "Au : "; ?><input type="text" id="au" name="au" value="<?php echo $au; ?>" size="15"></td>
	<tr>
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<?
	if(isset($_REQUEST["action"]))
	{
	 $du=dateFrToUs($_POST['du']);$au=dateFrToUs($_POST['au']);$date2=dateFrToUs($_POST['au']);
	 $ca=0;$pt=0;$t=0;$t1=0;
	 

	
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

<?php 

	$detail_factures="test";
	if ($du>="2017-01-01" and $au<"2018-01-01"){$factures="factures";$exe="/17";$detail_factures="detail_factures2017";}
	if ($du>="2018-01-01" and $au<"2019-01-01"){$factures="factures2018";$exe="/18";$detail_factures="detail_factures2018";}
	
	if ($du>="2019-01-01" and $au<"2020-01-01"){$factures="factures2019";$exe="/19";$detail_factures="detail_factures2019";}
	if ($du>="2020-01-01" and $au<"2021-01-01"){$factures="factures2020";$exe="/20";$detail_factures="detail_factures2020";}
	if ($du>="2021-01-01" and $au<"2022-01-01"){$factures="factures2021";$exe="/21";$detail_factures="detail_factures2021";}
	if ($du>="2022-01-01" and $au<"2023-01-01"){$factures="factures2022";$exe="/22";$detail_factures="detail_factures2022";}
	if ($du>="2023-01-01" and $au<"2024-01-01"){$factures="factures2023";$exe="/23";$detail_factures="detail_factures2023";}
	if ($du>="2024-01-01" and $au<"2025-01-01"){$factures="factures2024";$exe="/24";$detail_factures="detail_factures2024";}
	if ($du>="2025-01-01" and $au<"2026-01-01"){$factures="factures2025";$exe="/25";$detail_factures="detail_factures2025";}
	if ($du>="2026-01-01" and $au<"2027-01-01"){$factures="factures2026";$exe="/26";$detail_factures="detail_factures2026";}
	




 ?><p>

<table class="table2">
<tr>
	<th><?php $total=0;$pt=0;echo "Du : ".$du." Au ".$au." ---".$detail_factures;?></th>
	<?php echo "<th><a href=\"ca_par_quantite_details_global.php?du=$du&au=$au\">Details Factures</a></th>";?>
<tr>
	<th><?php $total=0;$pt=0;echo "Produit";?></th>
	<th><?php echo "Nbre Paquets";?></th>
	<th><?php echo "Px Vente TTC";?></th>
	<th><?php echo "condit";?></th>
	<th><?php echo "Qte Pieces";?></th>
	<th><?php echo "Qte Avoir";?></th>
	<th><?php echo "Poids Unit.";?></th>
	<th><?php echo "Poids Total.";?></th>	
	<th><?php echo "Px.VenteNet";?></th>
	<th><?php echo "C.A TTC Net";?></th>
	<th><?php echo "Px.Vente/Kg";?></th>
</tr>

<?	

$vv="ANNOURIA ABDELFATAH"; 

	$sql  = "SELECT id,produit,facture,matiere,prix_unit,poids,sum(quantite*condit) As total_qte,sum(quantite_avoir*condit) As total_qte_avoir,sum(prix_unit_net) as total_valeur,sum(prix_unit) as total_valeur_brut ";
	$sql .= "FROM ".$detail_factures." where date_f between '$du' and '$au' group BY produit order by produit;";
	
	$users = db_query($database_name, $sql);
	while($users_ = fetch_array($users)) { 
 		$produit = $users_["produit"];$total_qte=$users_["total_qte"];$poids = 1;$total_valeur=$users_["total_valeur"];$total_valeur_brut=$users_["total_valeur_brut"];
		$matiere = $users_["matiere"];$remise10 = $users_["remise10"];$remise2 = $users_["remise2"];$remise3 = $users_["remise3"];$prix_unit=$users_["prix_unit"];
		$facture = $users_["facture"];$total_qte_avoir=$users_["total_qte_avoir"];
		
		
	//recherche donnees sur produit	
		$sql1  = "SELECT * ";
		$sql1 .= "FROM produits where produit='$produit' ORDER BY produit;";
		$users1 = db_query($database_name, $sql1);
	$users1_ = fetch_array($users1);
			$poids=$users1_["poids"];$matiere=$users1_["matiere"];$condit=$users1_["condit"];$emb=$users1_["emballage3"];$emb1=$users1_["emballage"];
			$emb_piece=$users1_["emballage4"];$sachet_paquet=$users1_["sachet_paquet"];$sachet_piece=$users1_["sachet_piece"];
			$prix=$users1_["prix"];//
			
	
	$sql  = "SELECT * ";
	$sql .= "FROM report_mat_precedant_2021 where produit='$sachet_paquet' ORDER BY produit;";
	$userse = db_query($database_name, $sql);$userse_ = fetch_array($userse);
			$poids_sachets=$userse_["poids"];
			
	$sql  = "SELECT * ";
	$sql .= "FROM report_mat_precedant_2021 where produit='$sachet_piece' ORDER BY produit;";
	$userse = db_query($database_name, $sql);$userse_ = fetch_array($userse);
			$poids_sachets_pieces=$userse_["poids"];
	
	
	
	if ($total_qte>0)
	
	{
	 echo "<tr><td><a href=\"ca_par_quantite_details.php?matiere=$produit&du=$du&au=$au\">$produit</a></td>";?>
	 <td align="center" ><?php echo $total_qte/$condit; $paquets = $total_qte/$condit;$pieces = $total_qte;?></td>
	 <td align="center" ><?php echo number_format($prix_unit,2,',',' ');?></td>
<td align="center" ><?php echo $condit; ?></td>
<td align="center" ><?php echo $total_qte; ?></td>
<td align="center" ><?php echo $total_qte_avoir; ?></td>
<td align="center" ><?php echo number_format($poids/1000,3,',',' '); ?></td>
<td align="center" ><?php echo number_format($total_qte*$poids/1000,3,',',' ');$pt=$pt+(($total_qte)*$poids/1000); ?></td>

<td align="center" ><?php echo number_format($total_valeur/$total_qte,2,',',' '); ?></td>
<td align="center" ><?php echo number_format($total_valeur,2,',',' '); $t=$t+$total_valeur;?></td>
<td align="center" ><?php $poidskg=$poids/1000;echo number_format($prix*0.90*0.98*0.97/$poidskg,2,',',' '); ?></td>



</tr>
<?	}

 }?>
 <td></td>
 <td></td>
 <td></td>
 <td></td>
 <td></td>
 <td></td>
 <td></td>
 <td align="center" ><?php echo number_format($pt,3,',',' ');?></td>
 <td></td>
  <td align="center" ><?php echo number_format($t,2,',',' ');?></td>
<td></td>
 
 <?
 
 } // fin action
 
 ?>


</table>

<p style="text-align:center">


</body>

</html>