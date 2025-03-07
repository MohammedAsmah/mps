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
	 $du=dateFrToUs($_POST['du']);$au=dateFrToUs($_POST['au']);
	 $ca=0;$pt=0;$t=0;$t1=0;
	 

	
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
  <table class="table table-bordered">
    <tr>
	<th><?php $total=0;$pt=0;echo "Produit";?></th>
	<th><?php echo "Nbre Paquets";?></th>
	<th><?php echo "condit";?></th>
	<th><?php echo "Qte Pieces";?></th>
	<th><?php echo "Sachet Paquet";?></th>
	<th><?php echo "Poids Unit.Sachet";?></th>
	<th><?php echo "Poids total Sachet";?></th>
	<th><?php echo "Sachet Piece";?></th>
	<th><?php echo "Poids Unit.Sachet";?></th>
	<th><?php echo "Poids total Sachet";?></th>	
	<th><?php echo "Carton";?></th>
	<th><?php echo "Nbre Carton";?></th>
	<th><?php echo "Poids Mat.";?></th>
	<th><?php echo "Px.VenteTTC";?></th>
	<th><?php echo "C.A TTC";?></th>
	<th><?php echo "Px.Vente/Kg";?></th>
</tr>
<?	
	if ($du>"2018-12-31"){
	$sql  = "SELECT id,produit,facture,matiere,poids,sum(quantite*condit) As total_qte,sum(prix_unit_net) as total_valeur ";
	$sql .= "FROM detail_factures2021 where date_f between '$du' and '$au' group BY produit;";
	}
	else
	{
	$sql  = "SELECT id,facture,produit,prix_unit,matiere,poids,sum(quantite*condit) As total_qte,sum(quantite*condit*prix_unit) as total_valeur ";
	$sql .= "FROM detail_factures where date_f between '$du' and '$au' group BY produit;";
	}
	$users = db_query($database_name, $sql);
	while($users_ = fetch_array($users)) { 
 		$produit = $users_["produit"];$total_qte=$users_["total_qte"];$poids = 1;$total_valeur=$users_["total_valeur"];
		$matiere = $users_["matiere"];$remise10 = $users_["remise10"];$remise2 = $users_["remise2"];$remise3 = $users_["remise3"];
		$facture = $users_["facture"];
		
	//recherche donnees sur produit	
		$sql1  = "SELECT * ";
		$sql1 .= "FROM produits where produit='$produit' ORDER BY produit;";
		$users1 = db_query($database_name, $sql1);
	$users1_ = fetch_array($users1);
			$poids=$users1_["poids"];$matiere=$users1_["matiere"];$condit=$users1_["condit"];$emb=$users1_["emballage3"];$emb1=$users1_["emballage"];
			$emb_piece=$users1_["emballage4"];
			$prix=$users1_["prix"];//
			
	
	$sql  = "SELECT * ";
	$sql .= "FROM types_emballages1 where profile_name='$emb' ORDER BY profile_name;";
	$userse = db_query($database_name, $sql);$userse_ = fetch_array($userse);
			$poids_sachets=$userse_["poids"];
			
	$sql  = "SELECT * ";
	$sql .= "FROM types_emballages1 where profile_name='$emb_piece' ORDER BY profile_name;";
	$userse = db_query($database_name, $sql);$userse_ = fetch_array($userse);
			$poids_sachets_pieces=$userse_["poids"];
	
	
	
	if ($total_qte>0)
	
	{
	 echo "<tr><td><a href=\"ca_par_quantite_details.php?matiere=$produit&du=$du&au=$au\">$produit</a></td>";?>
	 <td align="center" ><?php echo $total_qte/$condit; ?></td>
<td align="center" ><?php echo $condit; ?></td>
<td align="center" ><?php echo $total_qte; ?></td>
<td align="center" ><?php echo $emb; ?></td>
<td align="center" ><?php echo $poids_sachets."g"; ?></td>
<td align="right" ><?php echo number_format(($total_qte/$condit)*$poids_sachets/1000,3,',',' '); ?></td>
<td align="center" ><?php echo $emb_piece; ?></td>
<td align="center" ><?php echo $poids_sachets_pieces."g"; ?></td>
<td align="right" ><?php echo number_format($total_qte*$poids_sachets_pieces/1000,3,',',' '); ?></td>
<td align="center" ><?php echo $emb1; ?></td>

<td align="right" ><?php if ($emb1<>""){echo number_format(($total_qte/$condit),0,',',' ');} ?></td>
<td align="center" ><?php echo number_format($total_qte*$poids/1000,3,',',' ');$pt=$pt+($total_qte*$poids/1000); ?></td>
<td align="center" ><?php echo number_format($prix,2,',',' '); ?></td>
<td align="center" ><?php echo number_format($total_valeur,2,',',' '); $t=$t+$total_valeur;?></td>
<td align="center" ><?php echo number_format(($total_valeur)/($total_qte*$poids/1000),2,',',' '); ?></td>

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


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>