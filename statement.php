<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$user_name=GetUserName();
	$error_message = "";
			$client=$_GET['client'];$produit=$_GET['produit'];$date1=$_GET['date1'];$date2=$_GET['date2'];

	 $date1_aff=dateFrToUs($_GET['date1']);
	 $date2_aff=dateFrToUs($_GET['date2']);
	
	/* debut procedure*/
	
	list($annee1,$mois1,$jour1) = explode('-', $date1); 
	$pdu = mktime(0,0,0,$mois1,$jour1,$annee1); 
	list($annee1,$mois1,$jour1) = explode('-', $date2); 
	$pau = mktime(0,0,0,$mois1,$jour1,$annee1); 

	
	if ($client=="" and $produit==""){
	$type_s="SEJOURS ET CIRCUITS";
	$sql  = "SELECT * ";
	$sql .= "FROM registre_sans_lp_rak where type_service='$type_s' and (date between '$date1' and '$date2') ORDER BY date;";
	$users_r = db_query($database_name, $sql);}
	if ($client<>"" and $produit<>""){
	$type_s="SEJOURS ET CIRCUITS";
	$sql  = "SELECT * ";
	$sql .= "FROM registre_sans_lp_rak where type_service='$type_s' and client='$client' and service='$produit' and (date between '$date1' and '$date2') ORDER BY date;";
	$users_r = db_query($database_name, $sql);}
	if ($client<>"" and $produit==""){
	$type_s="SEJOURS ET CIRCUITS";
	$sql  = "SELECT * ";
	$sql .= "FROM registre_sans_lp_rak where type_service='$type_s' and client='$client' and (date between '$date1' and '$date2') ORDER BY date;";
	$users_r = db_query($database_name, $sql);}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "registre_sejour.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo ""; ?></span>

<? $net_t=0;echo dateUsToFr($date1)."  au  : ".dateUsToFr($date2);echo "  ".$client."---->".$produit;?>

			<table class="table2" bordercolordark="#333333">
			<td width="150">Produit</td>
			<td width="70">Arrivee</td>
			<td width="220">References</td>
			<td width="140">Noms</td>
			<td width="10">Montant</td>
			<td width="10">HPL</td>
			<td width="10">Solde</td>
			
<?php 
$pax=0;$pax1=0;$j=0;$j1=0;$total_controle=0;$totalpax_adt=0;$totalpax_enf=0;$total_controle1=0;

while($users_r_ = fetch_array($users_r)) 
		{ 
	 	$pax=$pax+$j;$pax1=$pax1+$j1;		
			?>

			<?php /*echo dateUsToFr($users_r_["date"]);*/ ?>
			<?php $service=$users_r_["service"];/*echo $users_r_["service"];*/ ?>
			<?php  $client=$users_r_["client"];/*echo $users_r_["client"];*/ ?>
			<?php /*if ($users_r_["statut"]<>"en cours"){echo $users_r_["statut"];} */?>
			
			
			<?
			
			$id_r=$users_r_["id"];$date=$users_r_["date"];$client=$users_r_["client"];
			$service_lp=$users_r_["service"];$code=$users_r_["code_produit"];$lp=$users_r_["id"]+200000;?>
			<? $sql  = "SELECT * ";
			$sql .= "FROM details_bookings_sejours_rak where id_registre=$id_r and hpl=0 ORDER BY id;";
			$users = db_query($database_name, $sql);?>
			<?php $i=0; 
			while($users_b_ = fetch_array($users)) 
			{
			$adt=$users_b_["adultes"];$enf=$users_b_["enfants"];$i=$i+($adt+$enf);
			}?>
			<?php $tranche=$i;/*echo $i;*/ ?>
			
			<tr>
			<? 
			
			$sql  = "SELECT * ";
			$sql .= "FROM details_bookings_sejours_rak where id_registre=$id_r and hpl=0 ORDER BY id;";
			$users = db_query($database_name, $sql);?>
			<?php $j=0;$j1=0;$tnet=0; ?>
			<? if ($i>0){?>
			
			<? }?>
			
			<?  while($users_b_ = fetch_array($users)) 
					{ 
						$montant_c=$users_b_["montant_c"];$id=$users_b_["id"];$v_ref=$users_b_["v_ref"];
						$montant_envoi=$users_b_["montant_envoi"];
						$age1=$users_b_["age1"];$age2=$users_b_["age2"];$age3=$users_b_["age3"];
						?><tr>
						<td width="100"><?php $serv=$users_b_["service"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$serv </font>") ;    ?></td>
						<td width="80"><?php $arr=dateUsToFr($users_b_["arrivee"]);print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$arr </font>") ;    ?></td>
						<? $service=$users_b_["service"];$id=$users_b_["id"];$client=$users_b_["client"];$client_a=$users_b_["a_facturer"];
						$age11 = $users_b_["age1"];$age22 = $users_b_["age2"];$age33 = $users_b_["age3"];?>
						<? $j=$j+$users_b_["adultes"];$j1=$j1+$users_b_["enfants"];$code1=$users_b_["code"];?>
		
						<td width="280"><? $v_ref=$users_b_["v_ref"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$v_ref </font>") ; ?></td>
											 
						<td width="100"><?php $noms=$users_b_["noms"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$noms </font>") ;    ?></td>
						<?php $adultes=$users_b_["adultes"]; ?>
						<?php $enfants=$users_b_["enfants"]; ?>
						<?php $chambre=$users_b_["chambre"];     ?>
						<?php $regime=$users_b_["regime"];   ?>
						<?php $resa=$users_b_["resa"];$arrivee=$users_b_["arrivee"];$depart=$users_b_["depart"]; ?>
						<td width="100" align="right"><?php $totalpax_adt=$totalpax_adt+$users_b_["adultes"];$totalpax_enf=$totalpax_enf+$users_b_["enfants"];
						$net_hpl=0;
						$sql  = "SELECT * ";
						$sql .= "FROM statement_hpl where ref ='$v_ref' ORDER BY id;";
						$users = db_query($database_name, $sql);
						while($users_b1_ = fetch_array($users)) 
							{ $net_hpl=$net_hpl+$users_b1_["debit"];}
						$net=number_format($montant_envoi,2,',',' ');$total_controle=$total_controle+$montant_envoi;print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$net</font>") ; ?></td>
						<td width="100" align="right"><? $net_hpl1=number_format($net_hpl,2,',',' ');$total_controle1=$total_controle1+$net_hpl;print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$net_hpl1</font>") ; ?></td>						
						<td width="100" align="right"><? $solde=$montant_envoi-$net_hpl;$solde=number_format($solde,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$solde</font>") ; ?></td>						
					<? }?>
						
<? } ?>
</table>
<td width="80"><?php echo "Envoi : ";$tc=number_format($total_controle,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$tc</font>"); ?></td>
<td width="80"><?php echo "HPL : ";$tc1=number_format($total_controle1,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$tc1</font>"); ?></td>
<td width="80"><?php echo "  Total Adultes : ";print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$totalpax_adt</font>"); ?></td>
<td width="80"><?php echo "  Total Enfants : ";print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$totalpax_enf</font>"); ?></td>

<p style="text-align:center">


</body>

</html>