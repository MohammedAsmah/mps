<?php
set_time_limit(0);
	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$date_j=date("Y-m-d");$action="Recherche";
	
		if(isset($_REQUEST["action"])){}else{
	?>
	<form id="form" name="form" method="post" action="recap_commercial.php">
	<td><?php echo "Date : "; ?><input onclick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" />
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }
	if(isset($_REQUEST["action"]))
		{$date=dateFrToUs($_POST['date']);$date_aff=$_POST['date'];
		
		$sql  = "SELECT * ";$encours="encours";
		$sql .= "FROM commandes where date_e='$date' ORDER BY date_e;";
		$users = db_query($database_name, $sql);
		}
		
		else
		{$sql  = "SELECT * ";$date_aff=dateUsToFr($date_j);
		$sql .= "FROM commandes where date_e='$date_j' ORDER BY date_e;";
		$users = db_query($database_name, $sql);}
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Evaluations"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "evaluation_client.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";
	?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>
<span style="font-size:24px"><?php echo "Etat Commandes Clients $date_aff "; ?></span>
<tr>
</tr>

<table class="table2">

<tr>
	
	<th><?php echo "Evaluation";?></th>
	<th><?php echo "Client";?></th>
	<th><?php echo "Net";?></th>
</tr>

<?php 

$total_g=0;
while($users_ = fetch_array($users)) { ?><tr>
<? $commande=$users_["commande"];$evaluation=$users_["evaluation"];$client=$users_["client"];$date_e=dateUsToFr($users_["date_e"]);
$vendeur=$users_["vendeur"];$numero=$users_["commande"];$sans_remise=$users_["sans_remise"];$remise10=$users_["remise_10"];
$bondesortie=$users_["bondesortie"];
$remise2=$users_["remise_2"];$remise3=$users_["remise_3"];$id=$users_["id"]; $date_en=dateFrToUs($users_["date"]);
$date_ev=$users_["date_e"];

?>


<td><?php echo $users_["evaluation"]; ?></td>
<td><?php echo $users_["client"]; ?></td>
<? ///////////////

	$sql1  = "SELECT * ";$m=0;$total=0;
	$sql1 .= "FROM detail_commandes where commande='$numero' and sans_remise=0 ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { ?>
<?php $produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
		$sub=$users1_["sub"];$sr=$users1_["sans_remise"];
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$pp = $user_["produit"];
		if ($favoris==0){$non_favoris=$non_favoris+$m;}
				if ($sans_remise==0)
		
				{
				if ($sr==0){
		/*$prix=$users_["total_prix"]*(1-$remise10/100);*/
		$r10=$m*$remise10/100;$net1=$m-$r10;
		$r2=$net1*$remise2/100;$net2=$net1-$r2;
		$r3=$net2*$remise3/100;$net3=$net2-$r3;
		/*$prix=$prix*(1-$remise2/100);
		$prix=$prix*(1-$remise3/100);*/}
		else
		{$net3=$m;}
		}
		else{$net3=$m;}

		$p=$users1_["prix_unit"];$total=$total+$net3;
		
	}?>

<?
if ($sans_remise==1){$t=$total;$net=$total;} else {$t=$total;$remise_1=0;$remise_2=0;$remise_3=0;
if ($remise10>0){$remise_1=$total*$remise10/100;}?>
<? if ($remise2>0){$remise_2=($total-$remise_1)*$remise2/100;}?>
<? if ($remise3>0){$remise_3=($total-$remise_1-$remise_2)*$remise3/100;} ?>
<? }?>

<?	
	
	$sql1  = "SELECT * ";$total1=0;
	$sql1 .= "FROM detail_commandes where commande='$numero' and sans_remise=1 ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users1_ = fetch_array($users1)) { ?>
<?php $produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
		$sub=$users1_["sub"];$sr=$users1_["sans_remise"];
//
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE ref = '$produit' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$pp = $user_["produit"];
		if ($favoris==0){$non_favoris=$non_favoris+$m;}
				if ($sans_remise==0)
		
				{
				if ($sr==0){
		/*$prix=$users_["total_prix"]*(1-$remise10/100);*/
		$r10=$m*$remise10/100;$net1=$m-$r10;
		$r2=$net1*$remise2/100;$net2=$net1-$r2;
		$r3=$net2*$remise3/100;$net3=$net2-$r3;
		/*$prix=$prix*(1-$remise2/100);
		$prix=$prix*(1-$remise3/100);*/}
		else
		{$net3=$m;}
		}
		else{$net3=$m;}

			$p=$users1_["prix_unit"];$total1=$total1+$net3;
		

}?>

<?php $net=$total+$total1; 

/////////////////?>

<td style="text-align:Right"><?php $total_g=$total_g+$net;echo number_format($net,2,',',' '); ?></td>
<? if ($evaluation<>"encours")
{echo "<td><a href=\"editer_evaluation_sur_entete.php?numero=$commande\">Imprimer</a></td>";}else{echo "<td></td>";}?>




<?php } ?>
<tr><td></td><td></td>
<td style="text-align:Right"><?php echo number_format($total_g,2,',',' '); ?></td>
</tr>

</table>
<tr>
</tr>

<? 
	
		if(isset($_REQUEST["action"]))
		{$date=dateFrToUs($_POST['date']);$date_aff=$_POST['date'];
		$sql  = "SELECT * ";
		$sql .= "FROM registre_vendeurs where date='$date' ORDER BY id;";
		$users11 = db_query($database_name, $sql);
		}
		
		else
		{$sql  = "SELECT * ";$date_aff=dateFrToUs($date_j);
		$sql  = "SELECT * ";
		$sql .= "FROM registre_vendeurs where date='$date_j' ORDER BY id;";
		$users11 = db_query($database_name, $sql);}
	
	
?>

<table class="table2">

<tr>
	
	<th><?php echo "Destination";?></th>
	<th><?php echo "Vendeur";?></th>
	<th><?php echo "Montant";?></th>
	<th><?php echo "B.S Vendeur";?></th>
	<th><?php echo "B.S Magasin";?></th>
		
	
</tr>

<?php $compteur1=0;$total_g=0;
while($users_1 = fetch_array($users11)) 
			{ $id_r=$users_1["id"];$date3=$users_1["date"];$vendeur=$users_1["vendeur"];
			$statut=$users_1["statut"];$observation=$users_1["observation"];$valide=$users_1["valide"];$valide_c=$users_1["valide_c"];
			$service=$users_1["service"];$code=$users_1["code_produit"];$lp=$users_1["id"]+100000;$bon=$users_1["statut"];?><tr>
			<? 
			?>
			<td><?php $destination=$users_1["service"];echo $users_1["service"]; ?></td>

	<? $sql  = "SELECT * ";
	$sql .= "FROM commandes where id_registre=$id_r ORDER BY date_e;";
	$users = db_query($database_name, $sql);
	$total_g=0;
	while($users_ = fetch_array($users)) { 
		$commande=$users_["commande"];$evaluation=$users_["evaluation"];$client=$users_["client"];$date11=dateUsToFr($users_["date_e"]);
		$vendeur=$users_["vendeur"];$numero=$users_["commande"];$sans_remise=$users_["sans_remise"];$remise10=$users_["remise_10"];
		$remise2=$users_["remise_2"];$remise3=$users_["remise_3"];
		$id=$users_["id"];
		$sql1  = "SELECT * ";$m=0;$total=0;
		$sql1 .= "FROM detail_commandes where commande='$numero' and sans_remise=0 ORDER BY produit;";
		$users1 = db_query($database_name, $sql1);$non_favoris=0;
		while($users1_ = fetch_array($users1)) { 
			$produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
			$total=$total+$m;
			}
			if ($sans_remise==1){$t=$total;$net=$total;} 
			else {
				$t=$total;$remise_1=0;$remise_2=0;$remise_3=0;
				if ($remise10>0){$remise_1=$total*$remise10/100;}
				if ($remise2>0){$remise_2=($total-$remise_1)*$remise2/100;}
				if ($remise3>0){$remise_3=($total-$remise_1-$remise_2)*$remise3/100;}
			 }
			$sql1  = "SELECT * ";$total1=0;
			$sql1 .= "FROM detail_commandes where commande='$numero' and sans_remise=1 ORDER BY produit;";
			$users1 = db_query($database_name, $sql1);
			while($users1_ = fetch_array($users1)) { 
				$produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
				$total1=$total1+$m;
			 }
				$net=$total+$total1-$remise_1-$remise_2-$remise_3; 
				$total_g=$total_g+$net;
			 }
			 ?>
			<td><?php echo "<a href=\"evaluation_pre.php?observation=$observation&montant=$total_g&id_registre=$id_r&date=$date3&vendeur=$vendeur&bon_sortie=$bon&service=$service\">".$vendeur."</a>"; 
			$imp=" Entete"; $entete="<a href=\"evaluation_pre_imp.php?observation=$observation&montant=$total_g&id_registre=$id_r&date=$date3&vendeur=$vendeur&bon_sortie=$bon&service=$service\">".$imp."</a>"; 
			print("<font size=\"1\" face=\"Comic sans MS\" color=\"#FF0000\">$entete </font>");
			?>
			</td>
			 <td align="right"><? echo number_format($total_g,2,',',' ')."</td>";?>
 			<td><?php if ($destination<>""){
			echo "<a href=\"bon_de_sortie.php?observation=$observation&montant=$total_g&id_registre=$id_r&date=$date3&vendeur=$vendeur&bon_sortie=$bon&service=$service\">".$bon."</a>"; ?></td>
			<td><?php 
			echo "<a href=\"bon_de_sortie_g.php?observation=$observation&montant=$total_g&id_registre=$id_r&date=$date3&vendeur=$vendeur&bon_sortie=$bon&service=$service\">".$bon."</a>"; ?></td>
			<? }else{?><td></td><? }
						if ($valide_c==0){

			}else
			{				
			echo "<td>Validee</td>";
			echo "<td></td>";
			}		

 } ?>

</table>





<p style="text-align:center">

</body>

</html>