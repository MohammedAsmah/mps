<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$user_name=GetUserName();
	$error_message = "";
	$type_service="EXCURSIONS";$produit="";$client="";
		/*$sql  = "SELECT * ";$sel=1;
		$sql .= "FROM mois_rak WHERE encours = " . $sel . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";

		$mois = $user_["mois"];
		$du = dateUsToFr($user_["du"]);
		$au = dateUsToFr($user_["au"]);*/

	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	
	$du="01/11/2006";$au="30/11/2006";
	$date1="";$date2="";$t="1";
	if(isset($_REQUEST["validation_f"])) { $validation_f = 1; } else { $validation_f = 0; }
	if(isset($_REQUEST["action_fact_modif"]))
	{
	
			$sql = "UPDATE details_bookings_sejours_rak SET ";
			$sql .= "v_ref = '" . $_REQUEST["v_ref"] . "', ";
			$sql .= "n_ref = '" . $_REQUEST["n_ref"] . "', ";
			$sql .= "noms = '" . $_REQUEST["noms"] . "',";
			$sql .= "adultes = '" . $_REQUEST["adultes"] . "', ";
			$sql .= "enfants = '" . $_REQUEST["enfants"] . "', ";
			$sql .= "age1 = '" . $_REQUEST["age1"] . "', ";
			$sql .= "age2 = '" . $_REQUEST["age2"] . "', ";
			$sql .= "age3 = '" . $_REQUEST["age3"] . "', ";
			$sql .= "chambre = '" . $_REQUEST["chambre"] . "', ";
			$sql .= "regime = '" . $_REQUEST["regime"] . "', ";
			$sql .= "arrivee = '" . $_REQUEST["arrivee"] . "', ";
			$sql .= "depart = '" . dateFrToUs($_REQUEST["depart"]) . "', ";
			$sql .= "origine = '" . $_REQUEST["origine"] . "', ";
			$sql .= "destination = '" . $_REQUEST["destination"] . "', ";
			$sql .= "heure_arrivee = '" . $_REQUEST["heure_arrivee"] . "', ";
			$sql .= "heure_depart = '" . $_REQUEST["heure_depart"] . "', ";
			$sql .= "heure_ram = '" . $_REQUEST["heure_ram"] . "', ";
			$sql .= "service = '" . $_REQUEST["service"] . "', ";
			$sql .= "client = '" . $_REQUEST["client"] . "', ";
			$sql .= "a_facturer = '" . $_REQUEST["a_facturer"] . "', ";
			$sql .= "mode = '" . $_REQUEST["mode"] . "', ";
			$sql .= "statut = '" . $_REQUEST["statut"] . "', ";
			$sql .= "observation = '" . $_REQUEST["observation"] . "', ";
			$sql .= "obs_htl = '" . $_REQUEST["obs_htl"] . "', ";
			$sql .= "obs_to = '" . $_REQUEST["obs_to"] . "', ";
			$sql .= "montant_envoi = '" . $_REQUEST["montant_envoi"] . "', ";
			$sql .= "vol_a = '" . $_REQUEST["vol_a"] . "', ";
			$sql .= "hpl = '" . $_REQUEST["hpl"] . "', ";
			$sql .= "vol_d = '" . $_REQUEST["vol_d"] . "', ";
			$sql .= "resa = '" . dateFrToUs($_REQUEST["resa"]) . "', ";
			$sql .= "ref1 = '" . $_REQUEST["ref1"] . "', ";
			$sql .= "ref2 = '" . $_REQUEST["ref2"] . "', ";
			$sql .= "numero_f = '" . $_REQUEST["numero_f"] . "', ";
			$sql .= "validation_f = '" . $validation_f . "', ";
			$sql .= "montant_f = '" . $_REQUEST["montant_f"] . "', ";
			$sql .= "montant_c = '" . $_REQUEST["montant_c"] . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			$client=$_POST['client'];$produit=$_POST['produit'];$date1=$_POST['date1'];$date2=$_POST['date2'];

	}	
	
		if(isset($_REQUEST["action_fact_modif1"]))
	{
				$debit=$_REQUEST["net_hpl"];
				$sql  = "INSERT INTO statement_hpl ( produit,client,ref,noms,date,debit )
				 VALUES ( ";
				$sql .= "'" . $_REQUEST["produit"] . "', ";
				$sql .= "'" . $_REQUEST["client"] . "', ";
				$sql .= "'" . $_REQUEST["v_ref"] . "', ";
				$sql .= "'" . $_REQUEST["noms"] . "', ";
				$sql .= "'" . $_REQUEST["arrivee"] . "', ";
				$sql .= $debit . ");";
				db_query($database_name, $sql);	
				$client=$_POST['client'];$produit=$_POST['produit'];$date1=$_POST['date1'];$date2=$_POST['date2'];

	}	
	$action="recherche";
	$client_list = "";
	$sql = "SELECT * FROM  rs_data_clients ORDER BY last_name;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($client == $temp_["last_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$client_list .= "<OPTION VALUE=\"" . $temp_["last_name"] . "\"" . $selected . ">";
		$client_list .= $temp_["last_name"];
		$client_list .= "</OPTION>";
	}
	$profiles_list_p = "Selectionnez Produit";$med="MEDHOTELS";
	$sql_produit = "SELECT * FROM contrats_sejours ORDER BY first_name;";
	$temp_produit = db_query($database_name, $sql_produit);
	while($temp_produit_ = fetch_array($temp_produit)) {
		if($produit == $temp_produit_["first_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_p .= "<OPTION VALUE=\"" . $temp_produit_["first_name"] . "\"" . $selected . ">";
		$profiles_list_p .= $temp_produit_["first_name"];
		$profiles_list_p .= "</OPTION>";
	}
	
	$action="Recherche";$action_t="Par Periode";
	?>
	
	<form id="form" name="form" method="post" action="registres_sejours_sans_lp_ec.php" target="_top">
	<td><?php echo "Client : "; ?><select id="client" name="client"><?php echo $client_list; ?></select></td>
	<td><?php echo "Produit : "; ?><select id="produit" name="produit"><?php echo $profiles_list_p; ?></select></td>
	<td><?php echo "Du : "; ?><input onclick="ds_sh(this);" name="date1" readonly="readonly" style="cursor: text" / value="<?php echo $du; ?>"></td>
	<td><?php echo "Au : "; ?><input onclick="ds_sh(this);" name="date2" readonly="readonly" style="cursor: text" / value="<?php echo $au; ?>"></td>
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>

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
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo ""; ?></span>
	
	<?	
	if(isset($_REQUEST["action"]))
	{
	 $date1=dateFrToUs($_POST['date1']);$client=$_POST['client'];
	 $date2=dateFrToUs($_POST['date2']);
	 $produit=$_POST['produit'];}
	/* debut procedure*/
	/*list($annee1,$mois1,$jour1) = explode('-', $date1); 
	$pdu = mktime(0,0,0,$mois1,$jour1,$annee1); 
	list($annee1,$mois1,$jour1) = explode('-', $date2); 
	$pau = mktime(0,0,0,$mois1,$jour1,$annee1); */

	
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


<? $net_t=0;echo dateUsToFr($date1)."  au  : ".dateUsToFr($date2);echo "  ".$client."---->".$produit."   --  ";?>
<? /*<td width="280"><?php echo "<a href=\"registres_sejours_sans_lp_edit.php?date1=$date1&date2=$date2&client=$client&produit=$produit\">Imprimer</a>";?></td>
<td width="280"><?php echo "<a href=\"demande_payement.php?date1=$date1&date2=$date2&client=$client&produit=$produit\">[ Etat à Envoyer ]</a>";?></td>
<td width="280"><?php echo "<a href=\"statement.php?date1=$date1&date2=$date2&client=$client&produit=$produit\">[ Relevé ]</a>";?></td>
<td width="280"><?php echo "<a href=\"ordre_payement.php?date1=$date1&date2=$date2&client=$client&produit=$produit\">[ Ordre Payement ]</a>";?></td>*/?>

			<table class="table2" bordercolordark="#333333">
			<td width="70">Arrivee</td>
			<td width="280">References</td>
			<td width="140">Noms</td>
			<td width="10">Adt</td>
			<td width="10">Enf</td>
			<td width="10">Resa</td>
			<td width="180">Chambre</td>
			<td width="10">Regime</td>
			<td width="10">duree</td>
			<td width="10">Base</td>
			<td width="10">Brut</td>
			<td width="10">taxe</td>
			<td width="10">Sup</td>
			<td width="10">eb</td>
			<td width="10">ofs</td>
			<td width="10">x=y</td>
			<td width="100">Net</td>
			
			
<?php 
$pax=0;$pax1=0;$j=0;$j1=0;$total_controle=0;$totalpax_adt=0;$totalpax_enf=0;

while($users_r_ = fetch_array($users_r)) 
		{ 
	 	$pax=$pax+$j;$pax1=$pax1+$j1;		
		$date_lp=$users_r_["date"];
		/*list($annee1,$mois1,$jour1) = explode('-', $date_lp); 
		$da = mktime(0,0,0,$mois1,$jour1,$annee1); 
		if ($da>=$pdu and $da<=$pau)
			{*/
			?>

			<?php /*echo dateUsToFr($users_r_["date"]);*/ ?>
			<?php $service=$users_r_["service"];/*echo $users_r_["service"];*/ ?>
			<?php  $client=$users_r_["client"];/*echo $users_r_["client"];*/ ?>
			<?php /*if ($users_r_["statut"]<>"en cours"){echo $users_r_["statut"];} */?>
			
			
			<?
			
			$id_r=$users_r_["id"];$date=$users_r_["date"];$client=$users_r_["client"];$statut=$users_r_["statut"];
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
					$age1=$users_b_["age1"];$age2=$users_b_["age2"];$age3=$users_b_["age3"];
					
					
					
					?><tr>
						<td width="80"><?php $arr=dateUsToFr($users_b_["arrivee"]);print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$arr </font>") ;    ?></td>
						<? $service=$users_b_["service"];$id=$users_b_["id"];$client=$users_b_["client"];$client_a=$users_b_["a_facturer"];$age11 = $users_b_["age1"];$age22 = $users_b_["age2"];$age33 = $users_b_["age3"];?>
						<? $j=$j+$users_b_["adultes"];$j1=$j1+$users_b_["enfants"];$code1=$users_b_["code"];?>
		
						<td width="280"><?php echo "<a href=\"booking_sans_lp_maj.php?user_id=$id&date1=$date1&date2=$date2&client=$client&produit=$produit\">$v_ref</a>";?></td>
											 
						<td width="100"><?php $noms=$users_b_["noms"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$noms </font>") ;    ?></td>
						<td style="text-align:center" width="10"><?php $adultes=$users_b_["adultes"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$adultes </font>"); ?></td>
						<td style="text-align:center" width="10"><?php $enfants=$users_b_["enfants"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$enfants </font>"); ?></td>
						<td width="80"><?php $date_resa=dateUsToFr($users_b_["resa"]); print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$date_resa </font>");    ?></td>
						<td width="100"><?php $chambre=$users_b_["chambre"]; print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$chambre </font>");    ?></td>
						<td width="10"><?php $regime=$users_b_["regime"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$regime </font>");    ?></td>
						<?php $resa=$users_b_["resa"];$arrivee=$users_b_["arrivee"];$depart=$users_b_["depart"]; ?>
						
						<? 
						$sql  = "SELECT * FROM rs_data_produits where last_name='$service' ;";
						$user = db_query($database_name, $sql); $user_ = fetch_array($user);
						$type_s=$user_["profile_id"];
						?>
												
						<?
						$sql  = "SELECT * ";
						$sql .= "FROM contrats_sejours WHERE first_name='$service_lp' and last_name='$client' ORDER BY user_id;";
						$user = db_query($database_name, $sql); $user_ = fetch_array($user);
						$login = $user_["login"];$id_contrat=$user_["user_id"];
						$last_name = $user_["last_name"];
						$first_name = $user_["first_name"];
						$email = $user_["email"];$type_c = $user_["type_c"];$chris=$user_["chris"];$ny=$user_["ny"];
						$cumuler_offres= $user_["cumuler_offres"];$choix_offres= $user_["choix_offres"];$activer_offres1= $user_["activer_offres1"];$activer_offres2= $user_["activer_offres2"];

						$profile_id = $user_["profile_id"];
						$remarks = $user_["remarks"];
						$minimum=$user_["minimum"];$agent_voyage=$user_["agent_voyage"];$duree_long_sejour=$user_["duree_long_sejour"];$red_long_sejour=$user_["red_long_sejour"];$voyage_noce=$user_["voyage_noce"];$pax_groupe_red=$user_["pax_groupe_red"];$red_groupe=$user_["red_groupe"];$pax_gratuite_groupe=$user_["pax_gratuite_groupe"];$gratuite=$user_["gratuite"];$contribution=$user_["contribution"];
						$dleb1=$user_["dleb1"];$dueb1=$user_["dueb1"];$aueb1=$user_["aueb1"];$veb1=$user_["veb1"];
						$dleb2=$user_["dleb2"];$dueb2=$user_["dueb2"];$aueb2=$user_["aueb2"];$veb2=$user_["veb2"];
						$dleb3=$user_["dleb3"];$dueb3=$user_["dueb3"];$aueb3=$user_["aueb3"];$veb3=$user_["veb3"];
						$dleb4=$user_["dleb4"];$dueb4=$user_["dueb4"];$aueb4=$user_["aueb4"];$veb4=$user_["veb4"];
		
						$du_a1_value=$user_['du_a1'];$au_a1_value=$user_['au_a1'];$du_b1_value=$user_['du_b1'];$au_b1_value=$user_['au_b1'];
						$du_c1_value=$user_['du_c1'];$au_c1_value=$user_['au_c1'];$du_d1_value=$user_['du_d1'];$au_d1_value=$user_['au_d1'];
						$du_e1_value=$user_['du_e1'];$au_e1_value=$user_['au_e1'];$du_f1_value=$user_['du_f1'];$au_f1_value=$user_['au_f1'];
		
		
						$du_a2_value=$user_['du_a2'];$au_a2_value=$user_['au_a2'];$du_b2_value=$user_['du_b2'];$au_b2_value=$user_['au_b2'];
						$du_c2_value=$user_['du_c2'];$au_c2_value=$user_['au_c2'];$du_d2_value=$user_['du_d2'];$au_d2_value=$user_['au_d2'];
						$du_e2_value=$user_['du_e2'];$au_e2_value=$user_['au_e2'];$du_f2_value=$user_['du_f2'];$au_f2_value=$user_['au_f2'];
		
						$du_a3_value=$user_['du_a3'];$au_a3_value=$user_['au_a3'];$du_b3_value=$user_['du_b3'];$au_b3_value=$user_['au_b3'];
						$du_c3_value=$user_['du_c3'];$au_c3_value=$user_['au_c3'];$du_d3_value=$user_['du_d3'];$au_d3_value=$user_['au_d3'];
						$du_e3_value=$user_['du_e3'];$au_e3_value=$user_['au_e3'];$du_f3_value=$user_['du_f3'];$au_f3_value=$user_['au_f3'];
		
						$du_a4_value=$user_['du_a4'];$au_a4_value=$user_['au_a4'];$du_b4_value=$user_['du_b4'];$au_b4_value=$user_['au_b4'];
						$du_c4_value=$user_['du_c4'];$au_c4_value=$user_['au_c4'];$du_d4_value=$user_['du_d4'];$au_d4_value=$user_['au_d4'];
						$du_e4_value=$user_['du_e4'];$au_e4_value=$user_['au_e4'];$du_f4_value=$user_['du_f4'];$au_f4_value=$user_['au_f4'];

						$du_a5_value=$user_['du_a5'];$au_a5_value=$user_['au_a5'];$du_b5_value=$user_['du_b5'];$au_b5_value=$user_['au_b5'];
						$du_c5_value=$user_['du_c5'];$au_c5_value=$user_['au_c5'];$du_d5_value=$user_['du_d5'];$au_d5_value=$user_['au_d5'];
						$du_e5_value=$user_['du_e5'];$au_e5_value=$user_['au_e5'];$du_f5_value=$user_['du_f5'];$au_f5_value=$user_['au_f5'];
		
						$sql  = "SELECT * ";$vide="";
						$sql .= "FROM details_contrats_sejours WHERE id_contrat='$id_contrat' and libelle='$chambre' and (regime='$regime' or regime='$vide') and ('$tranche'>=pax and '$tranche'<=pax1) ORDER BY id;";
						$user = db_query($database_name, $sql); $user_ = fetch_array($user);
						$code=$user_["code"];$v_a=$user_["v_a"];$v_b=$user_["v_b"];$v_c=$user_["v_c"];$v_d=$user_["v_d"];
						$v_e=$user_["v_e"];$unite=$user_["unite"];$v_f=$user_["v_f"];
						//tarif special
						if ($statut=="GROUPE SPECIAL"){$v_f=$user_["v_f"];$v_a=0;$v_b=0;$v_c=0;$v_d=0;$v_e=0;}	
						
						
						$sql  = "SELECT * ";$christmas="CHRISTMAS";$v_a_chris=0;
						$sql .= "FROM details_contrats_sejours WHERE id_contrat='$id_contrat' and libelle='$christmas' ORDER BY id;";
						$user = db_query($database_name, $sql); $user_ = fetch_array($user);
						$v_a_chris=$user_["v_a"]+$user_["v_b"]+$user_["v_c"]+$user_["v_d"]+$user_["v_e"]+$user_["unite"];


						$sql  = "SELECT * ";$newyear="NEW YEAR";$v_a_ny=0;
						$sql .= "FROM details_contrats_sejours WHERE id_contrat='$id_contrat' and libelle='$newyear' ORDER BY id;";
						$user = db_query($database_name, $sql); $user_ = fetch_array($user);
						$v_a_ny=$user_["v_a"]+$user_["v_b"]+$user_["v_c"]+$user_["v_d"]+$user_["v_e"]+$user_["unite"];

						if ($code=="SUP")
							{
							$sql  = "SELECT * ";$co1="TBJ";$co2="TBF";
							$sql .= "FROM details_contrats_sejours WHERE id_contrat='$id_contrat' and (code='$co1' or code='$co2') and regime='$regime' and ('$tranche'>=pax and '$tranche'<=pax1)  ORDER BY id;";
							$user = db_query($database_name, $sql); $user_ = fetch_array($user);
							$v_a_b=$user_["v_a"];$v_b_b=$user_["v_b"];$v_c_b=$user_["v_c"];$v_d_b=$user_["v_d"];
							$v_e_b=$user_["v_e"];
							}
						else
							{$v_a_b=0;$v_b_b=0;$v_c_b=0;$v_d_b=0;$v_e_b=0;}
							
							
							
							
						
						$sql  = "SELECT * ";$taxe1="Taxe";$taxe2="STEUER";$taxe3="TAXE";
						$sql .= "FROM details_contrats_sejours WHERE id_contrat='$id_contrat' and (libelle='$taxe1' or libelle='$taxe2' or libelle='$taxe3') ORDER BY id;";
						$user = db_query($database_name, $sql); $user_ = fetch_array($user);
						$taxe_a=$user_["v_a"];$taxe_b=$user_["v_b"];$taxe_c=$user_["v_c"];$taxe_d=$user_["v_d"];$taxe_e=$user_["v_e"];
						
						
						list($annee1,$mois1,$jour1) = explode('-', $arrivee); 
						$timestamp1 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', $depart); 
						$timestamp2 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						$jour=$timestamp1;$tableau1=array();$tableau2=array();

						$date_resa=dateUsToFr($resa);
						list($annee1,$mois1,$jour1) = explode('-', $resa); 
						$resa = mktime(0,0,0,$mois1,$jour1,$annee1); 
						
						/* offres speciales non contractees */
						$date_limite_resa=0;$du_o=0;$au_o=0;$valeur_o=0;$offre_speciale_nc=0;
						$sql  = "SELECT * ";
						$sql .= "FROM offres_speciales_nc WHERE id_contrat='$id_contrat' and ((chambre='$chambre' and regime='$regime') or tout=1) ORDER BY id;";
						$user = db_query($database_name, $sql); $trouve=0;
						
						while($user_ = fetch_array($user)) 
						{ 
						if ($trouve==0){
						$date_limite_resa_du=$user_["date_limite_resa_du"];$date_limite_resa_au=$user_["date_limite_resa_au"];$du_o=$user_["du"];$au_o=$user_["au"];
						list($annee1,$mois1,$jour1) = explode('-', $date_limite_resa_du); 
						$date_limite_resa_du = mktime(0,0,0,$mois1,$jour1,$annee1);
						list($annee1,$mois1,$jour1) = explode('-', $date_limite_resa_au); 
						$date_limite_resa_au = mktime(0,0,0,$mois1,$jour1,$annee1);
						
						
						list($annee1,$mois1,$jour1) = explode('-', $du_o); 
						$du_o = mktime(0,0,0,$mois1,$jour1,$annee1);
						list($annee1,$mois1,$jour1) = explode('-', $au_o); 
						$au_o = mktime(0,0,0,$mois1,$jour1,$annee1);
						
						
						if ($resa>=$date_limite_resa_du and $resa<=$date_limite_resa_au and $timestamp1>=$du_o and $timestamp1<=$au_o)
						{$offre_speciale_nc=$user_["valeur"];$trouve=1;
						$type_offre=$user_["type_offre"];$type_date=$user_["type_date"];$tout=$user_["tout"];
						}
						else
						{$offre_speciale_nc=0;}
						
						}
						}
						/*fin offres speciales non contractes*/
						
						/* offre speciales 7=6 */
						
						$date_limite_resa=0;$du_o=0;$au_o=0;$d1=0;$a1=0;$d2=0;$a2=0;$d3=0;$a3=0;$d4=0;$a4=0;$d5=0;$a5=0;$prg="";$type_date="";
						$offre_speciale="non";
						$sql  = "SELECT * ";
						$sql .= "FROM offres_speciales WHERE id_contrat='$id_contrat' ORDER BY id;";
						$user = db_query($database_name, $sql); 
						
						while($user_ = fetch_array($user)) 
						{ 
						$du_of=$user_["du"];$au_of=$user_["au"];
						
						list($annee1,$mois1,$jour1) = explode('-', $du_of); 
						$du_of = mktime(0,0,0,$mois1,$jour1,$annee1);
						list($annee1,$mois1,$jour1) = explode('-', $au_of); 
						$au_of = mktime(0,0,0,$mois1,$jour1,$annee1);
						
						
						if ($timestamp1>=$du_of and $timestamp1<=$au_of)
						{$d1=$user_["d1"];$a1=$user_["a1"];
						$d2=$user_["d2"];$a2=$user_["a2"];
						$d3=$user_["d3"];$a3=$user_["a3"];
						$d4=$user_["d4"];$a4=$user_["a4"];
						$d5=$user_["d5"];$a5=$user_["a5"];
						$prg=$user_["prolonger"];$type_date=$user_["type_date"];$jr=$user_["jour"];
						$offre_speciale="oui";$jour_offre=0;
						if ($prg=="oui" or $prg=="OUI"){$jour_offre=$jr;}
						}

						}

						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($du_a1_value));$du_a1 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($au_a1_value));$au_a1 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($du_a2_value));$du_a2 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($au_a2_value));$au_a2 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($du_a3_value));$du_a3 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($au_a3_value));$au_a3 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($du_a4_value));$du_a4 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($au_a4_value));$au_a4 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($du_a5_value));$du_a5 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($au_a5_value));$au_a5 = mktime(0,0,0,$mois1,$jour1,$annee1); 
		
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($du_b1_value));$du_b1 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($au_b1_value));$au_b1 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($du_b2_value));$du_b2 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($au_b2_value));$au_b2 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($du_b3_value));$du_b3 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($au_b3_value));$au_b3 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($du_b4_value));$du_b4 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($au_b4_value));$au_b4 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($du_b5_value));$du_b5 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($au_b5_value));$au_b5 = mktime(0,0,0,$mois1,$jour1,$annee1); 
		
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($du_c1_value));$du_c1 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($au_c1_value));$au_c1 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($du_c2_value));$du_c2 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($au_c2_value));$au_c2 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($du_c3_value));$du_c3 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($au_c3_value));$au_c3 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($du_c4_value));$du_c4 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($au_c4_value));$au_c4 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($du_c5_value));$du_c5 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($au_c5_value));$au_c5 = mktime(0,0,0,$mois1,$jour1,$annee1); 
		
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($du_d1_value));$du_d1 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($au_d1_value));$au_d1 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($du_d2_value));$du_d2 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($au_d2_value));$au_d2 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($du_d3_value));$du_d3 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($au_d3_value));$au_d3 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($du_d4_value));$du_d4 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($au_d4_value));$au_d4 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($du_d5_value));$du_d5 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($au_d5_value));$au_d5 = mktime(0,0,0,$mois1,$jour1,$annee1); 
		
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($du_e1_value));$du_e1 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($au_e1_value));$au_e1 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($du_e2_value));$du_e2 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($au_e2_value));$au_e2 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($du_e3_value));$du_e3 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($au_e3_value));$au_e3 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($du_e4_value));$du_e4 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($au_e4_value));$au_e4 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($du_e5_value));$du_e5 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($au_e5_value));$au_e5 = mktime(0,0,0,$mois1,$jour1,$annee1); 
		//early booking
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($dleb1));$dleb1 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($dueb1));$dueb1 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs1($aueb1));$aueb1 = mktime(0,0,0,$mois1,$jour1,$annee1); 
						$date_chris="24/12/2006";$date_ny="31/12/2006";
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs($date_chris));$date_chris = mktime(0,0,0,$mois1,$jour1,$annee1); 
						list($annee1,$mois1,$jour1) = explode('-', dateFrToUs($date_ny));$date_ny = mktime(0,0,0,$mois1,$jour1,$annee1); 
						$duree=($timestamp2-$timestamp1)/(24*60*60);$eb=0;?>
						
						<? if ($type_s==1)
							{?>
								<td width="10"><? print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">F</font>") ; ?></td>

								<? if (($jour>=$du_a1 and $jour<=$au_a1) or ($jour>=$du_a2 and $jour<=$au_a2) or ($jour>=$du_a3 and $jour<=$au_a3) or ($jour>=$du_a4 and $jour<=$au_a4) or ($jour>=$du_a5 and $jour<=$au_a5))
								{?>	<?php $v=$v_a+$v_a_b; ?><? }?>

								<? if (($jour>=$du_b1 and $jour<=$au_b1) or ($jour>=$du_b2 and $jour<=$au_b2) or ($jour>=$du_b3 and $jour<=$au_b3) or ($jour>=$du_b4 and $jour<=$au_b4) or ($jour>=$du_b5 and $jour<=$au_b5))
								{?>	<?php $v=$v_b+$v_b_b; ?><? }?>
						
								<? if (($jour>=$du_c1 and $jour<=$au_c1) or ($jour>=$du_c2 and $jour<=$au_c2) or ($jour>=$du_c3 and $jour<=$au_c3) or ($jour>=$du_c4 and $jour<=$au_c4) or ($jour>=$du_c5 and $jour<=$au_c5))
								{?>	<?php $v=$v_c+$v_c_b; ?><? }?>

								<? if (($jour>=$du_d1 and $jour<=$au_d1) or ($jour>=$du_d2 and $jour<=$au_d2) or ($jour>=$du_d3 and $jour<=$au_d3) or ($jour>=$du_d4 and $jour<=$au_d4) or ($jour>=$du_d5 and $jour<=$au_d5))
								{?>	<?php $v=$v_d+$v_d_b; ?><? }?>

								<? if (($jour>=$du_e1 and $jour<=$au_e1) or ($jour>=$du_e2 and $jour<=$au_e2) or ($jour>=$du_e3 and $jour<=$au_e3) or ($jour>=$du_e4 and $jour<=$au_e4) or ($jour>=$du_e5 and $jour<=$au_e5))
								{?>	<?php $v=$v_e+$v_e_b; ?><? }?>
								
								<? if ($unite=="CHAMBRE" or $unite=="Chambre" or $unite=="CH"){$adultes=1;}?>
								
								<td width="100"><?php $brut=number_format($v,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$brut</font>") ; ?></td>
								<? if ($jour>=$dueb1 and $jour<=$aueb1 and $resa<=$dleb1){$eb=$v*$adultes*$veb1/100;}?>
							
								<td width="80"><?php $meb=number_format($eb,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$meb</font>") ; ?></td>
								<td width="80"><?php $tax=number_format($taxe_a*$adultes,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$tax</font>"); ?></td>
								<td width="100"><?php $net=number_format(($v*$adultes+$tax)-$eb,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$net</font>") ; ?></td>
					
						<? }?>
	
						<? // sejour?>
						<? $tv=0; $jour_a=$jour;$v=0;
						if ($type_s==2)
							{?>
								<td width="100"><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$duree</font>") ; ?></td>



								<? $v_a_chris1=0;$v_a_ny1=0;for ($compteur=1;$compteur<=$duree;$compteur++)
									{?>
									
									<? if (($jour>=$du_a1 and $jour<=$au_a1) or ($jour>=$du_a2 and $jour<=$au_a2) or ($jour>=$du_a3 and $jour<=$au_a3) or ($jour>=$du_a4 and $jour<=$au_a4) or ($jour>=$du_a5 and $jour<=$au_a5))
									{?>	<?php $v=$v_a+$v_a_b; ?><? }?>

									<? if (($jour>=$du_b1 and $jour<=$au_b1) or ($jour>=$du_b2 and $jour<=$au_b2) or ($jour>=$du_b3 and $jour<=$au_b3) or ($jour>=$du_b4 and $jour<=$au_b4) or ($jour>=$du_b5 and $jour<=$au_b5))
									{?>	<?php $v=$v_b+$v_b_b; ?><? }?>
						
									<? if (($jour>=$du_c1 and $jour<=$au_c1) or ($jour>=$du_c2 and $jour<=$au_c2) or ($jour>=$du_c3 and $jour<=$au_c3) or ($jour>=$du_c4 and $jour<=$au_c4) or ($jour>=$du_c5 and $jour<=$au_c5))
									{?>	<?php $v=$v_c+$v_c_b; ?><? }?>

									<? if (($jour>=$du_d1 and $jour<=$au_d1) or ($jour>=$du_d2 and $jour<=$au_d2) or ($jour>=$du_d3 and $jour<=$au_d3) or ($jour>=$du_d4 and $jour<=$au_d4) or ($jour>=$du_d5 and $jour<=$au_d5))
									{?>	<?php $v=$v_d+$v_d_b; ?><? }?>

									<? if (($jour>=$du_e1 and $jour<=$au_e1) or ($jour>=$du_e2 and $jour<=$au_e2) or ($jour>=$du_e3 and $jour<=$au_e3) or ($jour>=$du_e4 and $jour<=$au_e4) or ($jour>=$du_e5 and $jour<=$au_e5))
									{?>	<?php $v=$v_e+$v_e_b; ?><? }?>
						
									<? if ($statut=="GROUPE SPECIAL")
									{?>	<?php $v=$v_f; ?><? }?>
						
									<? //fin for 
									
									if ($chris){
												if ($jour==$date_chris)
												{$v_a_chris1=$v_a_chris;}
												}
									else
												{$v_a_chris1=0;}
											
									if ($ny){
												if ($jour==$date_ny)
												{$v_a_ny1=$v_a_ny;}
												}
									else
												{$v_a_ny1=0;}

									$tv=$tv+$v;$jour=$jour+(24*60*60);
																	
									}?>
								
							<? if ($montant_c==0){$v_a_red_pax=0;$red3=0;?>	
								
							<? if ($unite=="CHAMBRE" or $unite=="Chambre" or $unite=="CH"){$adultes=1;}else {
							if ($adultes==2){$red3=0;$red4=0;}
							if ($adultes==3)
							{
						$sql  = "SELECT * ";$libelle_red3="3EME PAX";
						$sql .= "FROM details_contrats_sejours WHERE id_contrat='$id_contrat' and libelle='$libelle_red3' ORDER BY id;";
						$user = db_query($database_name, $sql); $user_ = fetch_array($user);
						$code_red_pax=$user_["code"];$v_a_red_pax=$user_["v_a"];$v_b_red_pax=$user_["v_b"];$v_c_red_pax=$user_["v_c"];$v_d_red_pax=$user_["v_d"];
						$v_e_red_pax=$user_["v_e"];$unite_red_pax=$user_["unite"];
							$red3=$tv*$v_a_red_pax/100;
							}
							}
							
							$tarif_1er=0;$tarif_2er=0;
							
							if ($enfants==1){$age_1er=$age1;
							$v_a_red_1er=0;
							$sql  = "SELECT * ";$libelle_1er="1ER ENFANT";
							$sql .= "FROM details_contrats_sejours WHERE id_contrat='$id_contrat' and libelle='$libelle_1er' and $age_1er>=pax and $age_1er<=pax1 ORDER BY id;";
							$user = db_query($database_name, $sql); $user_ = fetch_array($user);
							$code_red_1er=$user_["code"];$v_a_red_1er=$user_["v_a"];$v_b_red_1er=$user_["v_b"];$v_c_red_1er=$user_["v_c"];$v_d_red_1er=$user_["v_d"];
							$v_e_red_1er=$user_["v_e"];$unite_red_1er=$user_["unite"];
							$tarif_1er=$tv-($tv*$v_a_red_1er/100);
							
							}
							
							if ($enfants==2){
							$age_1er=$age1;
							$v_a_red_1er=0;
							$sql  = "SELECT * ";$libelle_1er="1ER ENFANT";
							$sql .= "FROM details_contrats_sejours WHERE id_contrat='$id_contrat' and libelle='$libelle_1er' and $age_1er>=pax and $age_1er<=pax1 ORDER BY id;";
							$user = db_query($database_name, $sql); $user_ = fetch_array($user);
							$code_red_1er=$user_["code"];$v_a_red_1er=$user_["v_a"];$v_b_red_1er=$user_["v_b"];$v_c_red_1er=$user_["v_c"];$v_d_red_1er=$user_["v_d"];
							$v_e_red_1er=$user_["v_e"];$unite_red_1er=$user_["unite"];
							$tarif_1er=$tv-($tv*$v_a_red_1er/100);
							
							$age_2er=$age2;
							$v_a_red_2er=0;
							$sql  = "SELECT * ";$libelle_2er="2EME ENFANT";
							$sql .= "FROM details_contrats_sejours WHERE id_contrat='$id_contrat' and libelle='$libelle_2er' and $age_2er>=pax and $age_2er<=pax1 ORDER BY id;";
							$user = db_query($database_name, $sql); $user_ = fetch_array($user);
							$code_red_2er=$user_["code"];$v_a_red_2er=$user_["v_a"];$v_b_red_2er=$user_["v_b"];$v_c_red_2er=$user_["v_c"];$v_d_red_2er=$user_["v_d"];
							$v_e_red_2er=$user_["v_e"];$unite_red_2er=$user_["unite"];
							$tarif_2er=$tv-($tv*$v_a_red_2er/100);
							
							}
							
							?>	
							<? $diff=0;
							if ($offre_speciale=="oui"){
							if ($duree==$d1 or $duree==$d2 or $duree==$d3 or $duree==$d4 or $duree==$d5){ 
							if ($duree==$d1){$diff=$d1-$a1;}
							if ($duree==$d2){$diff=$d2-$a2;}
							if ($duree==$d3){$diff=$d3-$a3;}
							if ($duree==$d4){$diff=$d4-$a4;}
							if ($duree==$d5){$diff=$d5-$a5;}
							}else{
							if ($jour_offre>0 and $duree>$d1){$diff=$jr;}
							}
							}
							
							
							$tax=$taxe_a*$duree*($adultes+$enfants);
							?>
							
							<td width="100" align="right"><?php $base=($tv/$duree);$base_aff=number_format($tv/$duree,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$base_aff</font>") ; ?></td>
							<td width="100" align="right"><?php $brut=($tv*$adultes-$red3)+$tarif_1er+$tarif_2er+$tax;$brut_aff=number_format(($tv*$adultes-$red3)+$tarif_1er+$tarif_2er+$tax,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$brut_aff</font>") ; ?></td>
							<? 
							if ($cumuler_offres==1){
								if ($jour_a>=$dueb1 and $jour_a<=$aueb1 and $resa<=$dleb1){$of_s=($brut/$duree)*$diff;
								$eb=((($tv*$adultes-$red3)+$tarif_1er+$tarif_2er+$tax)-$of_s)*$veb1/100;
								$offre_eb=$veb1;}else {$offre_eb=0;}
								}
								else
								{
								if ($jour_a>=$dueb1 and $jour_a<=$aueb1 and $resa<=$dleb1){$of_s=($brut/$duree)*$diff;
								$eb=((($tv*$adultes-$red3)+$tarif_1er+$tarif_2er+$tax))*$veb1/100;$offre_eb=$veb1;}else {$offre_eb=0;}
								}
								
							?>
							
							
							<td width="100" align="right"><?php $tax=$taxe_a*$duree*($adultes+$enfants);$tax_aff=number_format($taxe_a*$duree*($adultes+$enfants),2,',',' ');if ($tax<>0){print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$tax_aff</font>");} ?></td>
							<td width="100" align="right"><?php $sup_chris_ny=($v_a_chris1+$v_a_ny1)*$adultes;$sup_aff=number_format(($v_a_chris1+$v_a_ny1)*$adultes,2,',',' ');if ($sup_chris_ny<>0){print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$sup_aff</font>");} ?></td>
							<td width="100" align="right"><?php $meb=$eb;$meb_aff=number_format($eb,2,',',' ');if ($meb<>0){print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$meb_aff</font>") ; }?></td>
							
							<td width="100" align="right"><?php $of=($brut-$eb)*$offre_speciale_nc/100;$of_aff=number_format($of,2,',',' ');if ($of<>0){print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$of_aff</font>") ;} ?></td>
							
							<td width="100" align="right"><?php $of_s=($brut/$duree)*$diff;$of_s_aff=number_format($of_s,2,',',' ');if ($of_s<>0){print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$of_s_aff</font>") ;} ?></td>
							
							
							<?php $totalpax_adt=$totalpax_adt+$users_b_["adultes"];$totalpax_enf=$totalpax_enf+$users_b_["enfants"];
							
							/* choix offre*/
							$sup_chris_ny=($v_a_chris1+$v_a_ny1)*$adultes;
							
							if ($cumuler_offres==1){
							$net_aff=number_format(($brut+$sup_chris_ny)-($eb+$of+$of_s),2,',',' ');$net=$brut+$sup_chris_ny-($eb+$of+$of_s);
							$total_controle=$total_controle+$net;}
							else
							{ if ($eb>0)
								{$offre_sup=$eb;}
								else
									{if ($of_s>0)
										{$offre_sup=$of_s;}
										else
										{$offre_sup=$of;}
							}
							$net_aff=number_format($brut+$sup_chris_ny-$offre_sup,2,',',' ');$net=$brut+$sup_chris_ny-$offre_sup;
							$total_controle=$total_controle+$net;
							}
							
							
							
							
							?>
							
							<td width="100" align="right"><? print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$net_aff</font>") ; ?></td>

							<? } else {?>
							<td></td><td></td><td></td><td></td><td></td>	<td></td><td></td>
							<td width="100" align="right"><?php $totalpax_adt=$totalpax_adt+$users_b_["adultes"];$totalpax_enf=$totalpax_enf+$users_b_["enfants"];$total=$montant_c;$total_controle=$total_controle+$total;$net=number_format($montant_c,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$net</font>") ; ?></td>
							<? }?>
						<? }?>
						

				<? }?>

<? } ?>
</table>

<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td width="80"><?php echo "Total : ";$tc=number_format($total_controle,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$tc</font>"); ?></td>
<td width="80"><?php echo "  Total Adultes : ";print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$totalpax_adt</font>"); ?></td>
<td width="80"><?php echo "  Total Enfants : ";print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$totalpax_enf</font>"); ?></td>
<p style="text-align:center">

<td width="280"><?php echo "<a href=\"registres_sejours_sans_lp_edit.php?date1=$date1&date2=$date2&client=$client&produit=$produit\">Imprimer</a>";?></td>
<td width="280"><?php echo "<a href=\"demande_payement.php?date1=$date1&date2=$date2&client=$client&produit=$produit\">[ Etat à Envoyer ]</a>";?></td>
<td width="280"><?php echo "<a href=\"demande_payement_validee.php?date1=$date1&date2=$date2&client=$client&produit=$produit\">[ Valider Envoie]</a>";?></td>


</body>

</html>