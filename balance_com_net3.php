<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$caisse="";$action="Recherche";$date="";$date1="";$du="";$au="";
				$sql = "TRUNCATE TABLE `journal_commissions`  ;";
			db_query($database_name, $sql);

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
	<form id="form" name="form" method="post" action="balance_com_net3.php">
	<td><?php echo "Du : "; ?><input onclick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" />
	<td><?php echo "Au : "; ?><input onclick="ds_sh(this);" name="date1" readonly="readonly" style="cursor: text" />
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }
	if(isset($_REQUEST["action"]))
	{
	
	$date=dateFrToUs($_POST['date']);$du=$_POST['date'];$date1=dateFrToUs($_POST['date1']);$au=$_POST['date1'];
	$du=$_POST['date'];$au=$_POST['date1'];$encours="encours";$enc_t=0;
	
	
	?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Balance Encaissement / Evaluations $du au $au"; ?></span>

<p style="text-align:center">


<table class="table2">



<?php 


//ca 
		$sql  = "SELECT date_e,vendeur,sum(net) as total_net ";$encours="encours";
		$sql .= "FROM commandes where date_e between '$date' and '$date1' and evaluation<>'$encours' and valider_f=0 GROUP BY vendeur;";
		$users = db_query($database_name, $sql);
	while($row3 = fetch_array($users))
	{	
	
		$total_net = $row3['total_net'];
		$vendeur=$row3['vendeur'];
		
		///insertion
				$sql  = "INSERT INTO journal_commissions ( vendeur,evaluations ) VALUES ( ";
				$sql .= "'".$vendeur . "',";
				$sql .= "'".$total_net . "');";
				db_query($database_name, $sql);

	 }

//encaiss sur en compte cheque

	$date_d="2010-08-01";
	$sql  = "SELECT date_remise,id,date_f,date_enc,client,client_tire,client_tire_e,vendeur,numero_cheque,v_banque,facture_n,impaye,
	sum(montant_e) as total_e,id_commande,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece, sum(m_effet) as total_effet
	,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
	$sql .= "FROM porte_feuilles where (date_remise between '$date' and '$date1') and chq_f=0 and facture_n=0 and date_e>='$date_d' and date_e<'$date' 
	 and montant_f=0 Group BY vendeur;";
	$users7 = db_query($database_name, $sql);$t_cheque=0;$t_espece=0;$t_avoir=0;$t_effet=0;$t_virement=0;
	while($row7 = fetch_array($users7))
	{	
	
		$total_cheque = $row7['total_cheque'];
		$total_espece = $row7['total_espece'];
		$total_effet = $row7['total_effet'];
		$total_avoir = $row7['total_avoir'];
		$total_diff_prix = $row7['total_diff_prix'];
		$total_virement = $row7['total_virement'];
		$encaiss_encompte=$total_cheque+$total_espece+$total_effet+$total_virement-$total_avoir-$total_diff_prix;
		$vendeur=$row7['vendeur'];$total_cheque_vide=0;
		
		///insertion
				$sql  = "INSERT INTO journal_commissions ( vendeur,encaiss_encompte,encompte_cheque ) VALUES ( ";
				$sql .= "'".$vendeur . "',";
				$sql .= "'".$total_cheque_vide . "',";
				$sql .= "'".$total_cheque_vide . "');";
				db_query($database_name, $sql);

	 }
//encaiss sur en compte espece

	$date_d="2010-08-01";
	$sql  = "SELECT date_remise,id,date_f,date_enc,client,client_tire,client_tire_e,vendeur,numero_cheque,v_banque,facture_n,impaye,
	sum(montant_e) as total_e,id_commande,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece, sum(m_effet) as total_effet
	,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
	$sql .= "FROM porte_feuilles where (date_enc between '$date' and '$date1') and esp_f=0 and facture_n=0 and date_e>='$date_d' and date_e<'$date' 
	 and montant_f=0 and m_espece<>0 Group BY client;";
	$users7 = db_query($database_name, $sql);$t_cheque=0;$t_espece=0;$t_avoir=0;$t_effet=0;$t_virement=0;
	while($row7 = fetch_array($users7))
	{	
	
		$total_cheque = $row7['total_cheque'];
		$total_espece = $row7['total_espece'];
		$total_effet = $row7['total_effet'];
		$total_avoir = $row7['total_avoir'];
		$total_diff_prix = $row7['total_diff_prix'];
		$total_virement = $row7['total_virement'];
		$encaiss_encompte=$total_cheque+$total_espece+$total_effet+$total_virement-$total_avoir-$total_diff_prix;
		$vendeur=$row7['vendeur'];$client=$row7['client'];
		
		///insertion
				$sql  = "INSERT INTO journal_commissions ( vendeur,client,encaiss_encompte,encompte_espece ) VALUES ( ";
				$sql .= "'".$vendeur . "',";$sql .= "'".$client . "',";
				$sql .= "'".$total_espece . "',";
				$sql .= "'".$total_espece . "');";
				db_query($database_name, $sql);

	 }
	 
//encaiss sur en compte effet

	$date_d="2010-08-01";
	$sql  = "SELECT date_remise,id,date_f,date_enc,client,client_tire,client_tire_e,vendeur,numero_cheque,v_banque,facture_n,impaye,
	sum(montant_e) as total_e,id_commande,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece, sum(m_effet) as total_effet
	,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
	$sql .= "FROM porte_feuilles where (date_echeance between '$date' and '$date1')  and eff_f=0 and date_e>='$date_d' and date_e<'$date' 
	 and montant_f=0 and m_effet<>0 Group BY vendeur;";
	$users7 = db_query($database_name, $sql);$t_cheque=0;$t_espece=0;$t_avoir=0;$t_effet=0;$t_virement=0;
	while($row7 = fetch_array($users7))
	{	
	
		$total_cheque = $row7['total_cheque'];
		$total_espece = $row7['total_espece'];
		$total_effet = $row7['total_effet'];
		$total_avoir = $row7['total_avoir'];
		$total_diff_prix = $row7['total_diff_prix'];
		$total_virement = $row7['total_virement'];
		$encaiss_encompte=$total_cheque+$total_espece+$total_effet+$total_virement-$total_avoir-$total_diff_prix;
		$vendeur=$row7['vendeur'];$total_effet_vide=0;
		
		///insertion
				$sql  = "INSERT INTO journal_commissions ( vendeur,encaiss_encompte,encompte_effet ) VALUES ( ";
				$sql .= "'".$vendeur . "',";
				$sql .= "'".$total_effet . "',";
				$sql .= "'".$total_effet . "');";
				db_query($database_name, $sql);

	 }
	 
	 
//encaiss sur impayes

	$date_d="2010-08-01";$impaye="impaye";
	$sql  = "SELECT date_remise,id,date_f,date_enc,client,client_tire,client_tire_e,vendeur,numero_cheque,v_banque,facture_n,impaye,
	sum(montant_e) as total_e,id_commande,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece, sum(m_effet) as total_effet
	,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
	$sql .= "FROM porte_feuilles where (date_enc between '$date' and '$date1') and facture_n=0 and evaluation='$impaye' and montant_f=0 Group BY vendeur;";
	$users8 = db_query($database_name, $sql);$t_cheque=0;$t_espece=0;$t_avoir=0;$t_effet=0;$t_virement=0;
	while($row8 = fetch_array($users8))
	{	
	
		$total_cheque = $row8['total_cheque'];
		$total_espece = $row8['total_espece'];
		$total_effet = $row8['total_effet'];
		$total_avoir = $row8['total_avoir'];
		$total_diff_prix = $row8['total_diff_prix'];
		$total_virement = $row8['total_virement'];
		$encaiss_imp=$total_cheque+$total_espece+$total_effet+$total_virement-$total_avoir-$total_diff_prix;
		$vendeur=$row8['vendeur'];
		
		///insertion
				$sql  = "INSERT INTO journal_commissions ( vendeur,encaiss_imp ) VALUES ( ";
				$sql .= "'".$vendeur . "',";
				$sql .= "'".$encaiss_imp . "');";
				db_query($database_name, $sql);

	 }



/// impayes


	$sql  = "SELECT date_remise,id,date_f,date_enc,client,client_tire,client_tire_e,vendeur,numero_cheque,v_banque,facture_n,impaye,
	sum(montant_e) as total_e,id_commande,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece, sum(m_effet) as total_effet
	,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
	$sql .= "FROM porte_feuilles where (date_enc between '$date' and '$date1')  and (date_e between '$date' and '$date1') 
	 and m_cheque<>0 and r_impaye=1 and montant_f=0 and facture_n=0 Group BY vendeur;";
	$users6 = db_query($database_name, $sql);$t_cheque=0;$t_espece=0;$t_avoir=0;$t_effet=0;$t_virement=0;
	while($row6 = fetch_array($users6))
	{	
	
		$total_cheque_imp = $row6['total_cheque'];
		$vendeur=$row6['vendeur'];
		
		///insertion
				$sql  = "INSERT INTO journal_commissions ( vendeur,impayes ) VALUES ( ";
				$sql .= "'".$vendeur . "',";
				$sql .= "'".$total_cheque_imp . "');";
				db_query($database_name, $sql);

	 }
	 
	 

/// espece

$v="CAISSE";
	$sql  = "SELECT date_remise,id,date_f,date_enc,client,client_tire,client_tire_e,vendeur,numero_cheque,v_banque,facture_n,impaye,
	sum(montant_e) as total_e,id_commande,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece, sum(m_effet) as total_effet
	,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
	$sql .= "FROM porte_feuilles where (date_enc between '$date' and '$date1') and esp_f=0 and (date_e between '$date' and '$date1') 
	 and montant_f=0 and facture_n=0 and m_espece<>0 Group BY client;";
	$users11 = db_query($database_name, $sql);$t_cheque=0;$t_espece=0;$t_avoir=0;$t_effet=0;$t_virement=0;
	while($row = fetch_array($users11))
	{	
	$client = $row['client'];$date_enc = $row['date_enc'];
		$total_cheque = $row['total_cheque'];
		$total_espece = $row['total_espece'];
		$total_effet = $row['total_effet'];
		$total_avoir = $row['total_avoir'];
		$total_diff_prix = $row['total_diff_prix'];
		$total_virement = $row['total_virement'];
		$t_cheque=$t_cheque+$total_cheque;$t_effet=$t_effet+$total_effet;$t_virement=$t_virement+$total_virement;
		$t_espece=$t_espece+$total_espece;$vendeur=$row['vendeur'];$client=$row['client'];
		
		///insertion
				$sql  = "INSERT INTO journal_commissions ( vendeur,client,espece ) VALUES ( ";
				$sql .= "'".$vendeur . "',";$sql .= "'".$client . "',";
				$sql .= "'".$total_espece . "');";
				db_query($database_name, $sql);
				/*?><tr><td><? echo $client." </td><td>".$vendeur."</td><td>".$total_espece."</td><td>".$date_enc;?></td></tr>
		<?*/
	 }
	 
	 
/// avoirs


	$sql  = "SELECT date_remise,id,date_f,date_enc,client,client_tire,client_tire_e,vendeur,numero_cheque,v_banque,facture_n,impaye,
	sum(montant_e) as total_e,id_commande,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece, sum(m_effet) as total_effet
	,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
	$sql .= "FROM porte_feuilles where (date_enc between '$date' and '$date1')  and montant_f=0 and facture_n=0 and m_avoir<>0 Group BY vendeur;";
	$users5 = db_query($database_name, $sql);$t_cheque=0;$t_espece=0;$t_avoir=0;$t_effet=0;$t_virement=0;
	while($row5 = fetch_array($users5))
	{	
	
		$total_avoir = $row5['total_avoir'];
		$vendeur=$row5['vendeur'];
		
		///insertion
				$sql  = "INSERT INTO journal_commissions ( vendeur,avoirs ) VALUES ( ";
				$sql .= "'".$vendeur . "',";
				$sql .= "'".$total_avoir . "');";
				db_query($database_name, $sql);

	 }

/// diff prix


	$sql  = "SELECT date_remise,id,date_f,date_enc,client,client_tire,client_tire_e,vendeur,numero_cheque,v_banque,facture_n,impaye,
	sum(montant_e) as total_e,id_commande,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece, sum(m_effet) as total_effet
	,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
	$sql .= "FROM porte_feuilles where (date_enc between '$date' and '$date1')  and (date_e between '$date' and '$date1') 
	 and montant_f=0 and facture_n=0 and m_diff_prix<>0 Group BY vendeur;";
	$users4 = db_query($database_name, $sql);$t_cheque=0;$t_espece=0;$t_avoir=0;$t_effet=0;$t_virement=0;
	while($row4 = fetch_array($users4))
	{	
	
		$total_diff_prix = $row4['total_diff_prix'];
		$vendeur=$row4['vendeur'];
		
		///insertion
				$sql  = "INSERT INTO journal_commissions ( vendeur,differences ) VALUES ( ";
				$sql .= "'".$vendeur . "',";
				$sql .= "'".$total_diff_prix . "');";
				db_query($database_name, $sql);

	 }


	
	////////////////:cheques
	 
		$sql  = "SELECT date_remise,id,date_f,date_enc,client,client_tire,client_tire_e,vendeur,numero_cheque,v_banque,facture_n,impaye,
	sum(montant_e) as total_e,id_commande,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece, sum(m_effet) as total_effet
	,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
	$sql .= "FROM porte_feuilles where (date_remise between '$date' and '$date1')  and (date_e between '$date' and '$date1') 
	  and montant_f=0 and facture_n=0 and chq_f=0 and m_cheque<>0 Group BY vendeur;";
	$users111 = db_query($database_name, $sql);$t_cheque=0;$t_espece=0;$t_avoir=0;$t_effet=0;$t_virement=0;
	while($row1 = fetch_array($users111))
	{	
	
		$total_cheque = $row1['total_cheque'];
		$vendeur=$row1['vendeur'];
		
		///insertion
				$sql  = "INSERT INTO journal_commissions ( vendeur,cheque ) VALUES ( ";
				$sql .= "'".$vendeur . "',";
				$sql .= "'".$total_cheque . "');";
				db_query($database_name, $sql);

	 }


	////////////////:effet
	 
		$sql  = "SELECT date_remise,id,date_f,date_enc,client,client_tire,client_tire_e,vendeur,numero_cheque,v_banque,facture_n,impaye,
	sum(montant_e) as total_e,id_commande,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece, sum(m_effet) as total_effet
	,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
	$sql .= "FROM porte_feuilles where (date_enc between '$date' and '$date1')  and (date_e between '$date' and '$date1') 
	 and remise_e=1 and facture_n=0 and date_echeance<='$date1' and montant_f=0 and eff_f=0 and m_effet<>0 Group BY vendeur;";
	$users1111 = db_query($database_name, $sql);$t_cheque=0;$t_espece=0;$t_avoir=0;$t_effet=0;$t_virement=0;
	while($row11 = fetch_array($users1111))
	{	
	
		$total_effet = $row11['total_effet'];
		$vendeur=$row11['vendeur'];
		
		///insertion
				$sql  = "INSERT INTO journal_commissions ( vendeur,effet ) VALUES ( ";
				$sql .= "'".$vendeur . "',";
				$sql .= "'".$total_effet . "');";
				db_query($database_name, $sql);

	 }
 

	////////////////:virements
	 
		$sql  = "SELECT date_remise,id,date_f,date_enc,client,client_tire,client_tire_e,vendeur,numero_cheque,v_banque,facture_n,impaye,
	sum(montant_e) as total_e,id_commande,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece, sum(m_effet) as total_effet
	,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
	$sql .= "FROM porte_feuilles where (date_enc between '$date' and '$date1')  and (date_e between '$date' and '$date1') 
	 and montant_f=0 and facture_n=0 and m_virement<>0 Group BY vendeur;";
	$users11111 = db_query($database_name, $sql);$t_cheque=0;$t_espece=0;$t_avoir=0;$t_effet=0;$t_virement=0;
	while($row111 = fetch_array($users11111))
	{	
	
		$total_virement = $row111['total_virement'];
		$vendeur=$row111['vendeur'];
		
		///insertion
				$sql  = "INSERT INTO journal_commissions ( vendeur,virement ) VALUES ( ";
				$sql .= "'".$vendeur . "',";
				$sql .= "'".$total_virement . "');";
				db_query($database_name, $sql);

	 }

	 
	 /*$sql  = "SELECT * ";$espece="ESPECE";$vide="0000-00-00";$total=0;
	$sql .= "FROM porte_feuilles where date_enc between '$date' and '$date1' and date_e='$vide' and m_cheque<>0 and chq_f=0 group by numero_cheque ORDER BY id_registre_regl;";
	$users112 = db_query($database_name, $sql);
while($users_12 = fetch_array($users112)) { $id_r=$users_12["id"];$date_enc=$users_12["date_enc"];$vendeur=$users_12["vendeur"];
			$client=$users_12["client"];$evaluation=$users_12["evaluation"];$facture_n=$users_12["facture_n"];$id_regl=$users_12["id_registre_regl"];
			$mode=$users_12["mode"];$valeur=$users_12["valeur"];$v_banque=$users_12["v_banque"];
			$numero_cheque=$users_12["numero_cheque"];
			$ref=$v_banque." ".$numero_cheque;$date_e=$users_12["date_e"];$total_cheque=$users_12["m_cheque"];$changer=1;
			
			$sql  = "INSERT INTO journal_commissions ( vendeur,client,changer,espece ) VALUES ( ";
				$sql .= "'".$vendeur . "',";$sql .= "'".$client . "',";$sql .= "'".$changer . "',";
				$sql .= "'".$total_cheque . "');";
				db_query($database_name, $sql);
 } */
	 
	
	 
	 ?>
	 
	 <? 
		$sql  = "SELECT * ";
		$sql .= "FROM registre_reglements WHERE date between '$date' and '$date1' ;";
		$user = db_query($database_name, $sql); 
		
		while($user_ = fetch_array($user)) {
		
		$title = "";

		$date=dateUsToFr($user_["date"]);
		$service = $user_["service"];
		$vendeur = $user_["vendeur"];
		$statut = $user_["statut"];
		$user_open = $user_["user_open"];
		$date_open = $user_["date_open"];
		$observation=$user_["observation"];
		$valider_caisse=$user_["valider_caisse"];

		$type_service="SEJOURS ET CIRCUITS";
		$motif_cancel=$user_["motif_cancel"];$id=$_REQUEST["user_id"];
		$libelle1=$user_["libelle1"];$montant1=$user_["montant1"];
		$libelle2=$user_["libelle2"];$montant2=$user_["montant2"];
		$libelle3=$user_["libelle3"];$montant3=$user_["montant3"];
		$libelle4=$user_["libelle4"];$montant4=$user_["montant4"];
		$libelle5=$user_["libelle5"];$montant5=$user_["montant5"];
		$libelle6=$user_["libelle6"];$montant6=$user_["montant6"];
		$libelle7=$user_["libelle7"];$montant7=$user_["montant7"];
		$libelle8=$user_["libelle8"];$montant8=$user_["montant8"];
		$objet1=$user_["objet1"];$cheque1=$user_["cheque1"];
		$objet2=$user_["objet2"];$cheque2=$user_["cheque2"];
		$objet3=$user_["objet3"];$cheque3=$user_["cheque3"];
		$objet4=$user_["objet4"];$cheque4=$user_["cheque4"];
		$objet5=$user_["objet5"];$cheque5=$user_["cheque5"];
		$objet6=$user_["objet6"];$cheque6=$user_["cheque6"];
		$objet7=$user_["objet7"];$cheque7=$user_["cheque7"];
		$objet8=$user_["objet8"];$cheque8=$user_["cheque8"];
		$objet9=$user_["objet9"];$cheque9=$user_["cheque9"];
		$objet10=$user_["objet10"];$cheque10=$user_["cheque10"];
		$total_espece_change=$cheque1+$cheque2+$cheque3+$cheque4+$cheque5+$cheque6+$cheque7+$cheque8+$cheque9+$cheque10;
		$changer=1;

		$sql  = "INSERT INTO journal_commissions ( vendeur,changer,espece ) VALUES ( ";
				$sql .= "'".$vendeur . "',";$sql .= "'".$changer . "',";
				$sql .= "'".$total_espece_change . "');";
				db_query($database_name, $sql);
		
		
}

?>

	 
	 
	 
	<tr>
	<th><?php echo "Vendeur";?></th>
	<th><?php echo "Evaluations";?></th>
	<th><?php echo "En compte";?></th>
	<th><?php echo "Avoir/Dif Px.";?></th>
	<th><?php echo "Impayes";?></th>
	<th><?php echo "Espece";?></th>
	<th><?php echo "Cheque";?></th>
	<th><?php echo "Effet";?></th>
	<th><?php echo "Virement";?></th>
	<th><?php echo "Enc/Impayes";?></th>
	<th><?php echo "Enc/compte";?></th>
	<th><?php echo "Net Enc";?></th>
</tr>
	
		<? /////edition
	 
	 $te=0;$tc=0;$tf=0;$tv=0;$tev=0;$tav=0;$td=0;$tcc=0;$timp=0;$tencompte=0;$tencimp=0;$tenct=0;$t=0;
		$sql  = "SELECT vendeur,sum(espece) as total_espece,sum(cheque) as total_cheque,sum(effet) as total_effet
		,sum(virement) as total_virement,sum(encaiss_imp) as total_encaiss_imp,sum(evaluations) as total_evaluations,
		sum(encaiss_encompte) as total_encaiss_encompte,sum(avoirs) as total_avoirs,sum(differences) 
		as total_differences,sum(impayes) as total_impayes ";
	$sql .= "FROM journal_commissions Group BY vendeur;";
	$users222 = db_query($database_name, $sql);
	while($row222 = fetch_array($users222))
	{	
		
		$vendeur=$row222['vendeur'];
		
		
		$total_evaluations = $row222['total_evaluations'];$tev=$tev+$total_evaluations;
		?>
		<? if ($total_evaluations>0){
				$total_espece = $row222['total_espece'];$te=$te+$total_espece;
		$total_avoirs = $row222['total_avoirs'];$tav=$tav+$total_avoirs;
		$total_differences = $row222['total_differences'];$td=$td+$total_differences;
		$total_impayes = $row222['total_impayes'];$timp=$timp+$total_impayes;
		$total_cheque = $row222['total_cheque'];$tc=$tc+$total_cheque;
		$total_effet = $row222['total_effet'];$tf=$tf+$total_effet;
		$total_virement = $row222['total_virement'];$tv=$tv+$total_virement;
		$total_encaiss_encompte = $row222['total_encaiss_encompte'];$tencompte=$tencompte+$total_encaiss_encompte;
		$total_encaiss_imp = $row222['total_encaiss_imp'];$tencimp=$tencimp+$total_encaiss_imp;
		$t=$t+$row222['total_encaiss_encompte'];

		
		
		
		$v="<a href=\"balance_com_net3_details.php?vendeur=$vendeur&date1=$date&date2=$date1\">$vendeur</a>";
		print("<td><font size=\"1\" face=\"Arial\" color=\"#000033\">$vendeur </font></td>");
		?>
			<td align="right"><?php $total_evaluations1=number_format($total_evaluations,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$total_evaluations1 </font>"); ?></td>
			<td align="right"><?php $tcc=$tcc+($total_evaluations-($total_virement+$total_espece+$total_cheque+$total_effet));
			$tencompte=number_format($total_evaluations-($total_virement+$total_espece+$total_cheque+$total_effet),2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$tencompte </font>"); ?></td>
			<td align="right"><?php $total_avoirs1=number_format($total_avoirs+$total_differences,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$total_avoirs1 </font>"); ?></td>
			<td align="right"><?php $total_impayes1=number_format($total_impayes,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$total_impayes1 </font>"); ?></td>
			<td align="right"><?php $total_espece1=number_format($total_espece,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$total_espece1 </font>"); ?></td>
			<td align="right"><?php $total_cheque1=number_format($total_cheque,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$total_cheque1 </font>"); ?></td>
			<td align="right"><?php $total_effet1=number_format($total_effet,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$total_effet1 </font>"); ?></td>
			<td align="right"><?php $total_virement1=number_format($total_virement,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$total_virement1 </font>"); ?></td>
			<td align="right"><?php $total_encaiss_imp1=number_format($total_encaiss_imp,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$total_encaiss_imp1 </font>"); ?></td>
			<td align="right"><?php $total_encaiss_encompte1=number_format($total_encaiss_encompte,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$total_encaiss_encompte1 </font>"); ?></td>

			<td align="right"><?php 
			$tenct=$tenct+$total_virement+$total_espece+$total_cheque+$total_effet+$total_encaiss_encompte+$total_encaiss_imp-$total_avoirs-$total_differences;
			$tenc=number_format($total_virement+$total_espece+$total_cheque+$total_effet+$total_encaiss_encompte+$total_encaiss_imp-$total_avoirs-$total_differences,2,',',' ');
			print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$tenc </font>"); ?></td></tr>
			<? }?>
	 <? }	?><td></td>
			
			<td align="right"><?php $tev1=number_format($tev,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$tev1 </font>"); ?></td>
			<td align="right"><?php $tcc1=number_format($tcc,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$tcc1 </font>"); ?></td>
			<td align="right"><?php $tav1=number_format($tav+$td,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$tav1 </font>"); ?></td>
			<td align="right"><?php $timp1=number_format($timp,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$timp1 </font>"); ?></td>
			<td align="right"><?php $te1=number_format($te,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$te1 </font>"); ?></td>
			<td align="right"><?php $tc1=number_format($tc,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$tc1 </font>"); ?></td>
			<td align="right"><?php $tf1=number_format($tf,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$tf1 </font>"); ?></td>
			<td align="right"><?php $tv1=number_format($tv,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$tv1 </font>"); ?></td>
			<td align="right"><?php $tencimp1=number_format($tencimp,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$tencimp1 </font>"); ?></td>
			<td align="right"><?php $tencompte1=number_format($t,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$tencompte1 </font>"); ?></td>
			<td align="right"><?php $tenc1=number_format($tenct,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$tenc1 </font>"); ?></td>

</table>

<span style="font-size:24px"><?php echo "Encaissments /Cheques  : "; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Client";?></th>	<th>
	<?php echo "Vendeur";?></th>
	<th><?php echo "Ref Cheque";?></th>
	<th><?php echo "Montant";?></th>
</tr>

<?php /*$compteur1=0;$total_g=0;

	$sql  = "SELECT * ";$espece="ESPECE";$vide="0000-00-00";$total=0;
	$sql .= "FROM porte_feuilles where date_enc between '$date' and '$date1' and date_e='$vide' and m_cheque<>0 and chq_f=0 group by numero_cheque ORDER BY id_registre_regl;";
	$users112 = db_query($database_name, $sql);
while($users_12 = fetch_array($users112)) { $id_r=$users_12["id"];$date_enc=$users_12["date_enc"];$vendeur=$users_12["vendeur"];
			$client=$users_12["client"];$evaluation=$users_12["evaluation"];$facture_n=$users_12["facture_n"];$id_regl=$users_12["id_registre_regl"];
			$mode=$users_12["mode"];$valeur=$users_12["valeur"];$v_banque=$users_12["v_banque"];
			$numero_cheque=$users_12["numero_cheque"];
			$ref=$v_banque." ".$numero_cheque;$date_e=$users_12["date_e"];$total_cheque=$users_12["m_cheque"];
			
						
			
			
			
			?>
			<tr><td><?php echo dateUsToFr($users_12["date_enc"]); ?></td>
			<td><?php echo $client; ?></td>
			<td><?php echo $vendeur; ?></td>
			<td><?php echo $numero_cheque; ?></td>
			<td align="right"><?php echo number_format($total_cheque,2,',',' ') ?></td>
<? }*/ ?>







</table>

<span style="font-size:24px"><?php echo "Détail Encaissments / en compte  : "; ?></span>

<table class="table2">
<tr>
	<th><?php echo "Vendeur";?></th>
	
	<th><?php echo "Espece";?></th>
	<th><?php echo "Cheque";?></th>
	<th><?php echo "Effet";?></th>
	<th><?php echo "Virement";?></th>
	
	<th><?php echo "Net Enc";?></th>
</tr>
	<? /////edition
	 
	 $te=0;$tc=0;$tf=0;$tv=0;$tev=0;$tav=0;$td=0;$tcc=0;$timp=0;$tencompte=0;$tencimp=0;$tenct=0;$t=0;
		$sql  = "SELECT vendeur,sum(encompte_espece) as total_espece,sum(encompte_cheque) as total_cheque,sum(encompte_effet) as total_effet
		,sum(encompte_virement) as total_virement ";
	$sql .= "FROM journal_commissions Group BY vendeur;";
	$users222 = db_query($database_name, $sql);
	while($row222 = fetch_array($users222))
	{	
		
		$vendeur=$row222['vendeur'];
		
		
		
		?>
		<? 
				$total_espece = $row222['total_espece'];$te=$te+$total_espece;
		
		$total_cheque = $row222['total_cheque'];$tc=$tc+$total_cheque;
		$total_effet = $row222['total_effet'];$tf=$tf+$total_effet;
		$total_virement = $row222['total_virement'];$tv=$tv+$total_virement;
		
		print("<td><font size=\"1\" face=\"Arial\" color=\"#000033\">$vendeur </font></td>");
		?>
			
			<td align="right"><?php $total_espece1=number_format($total_espece,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$total_espece1 </font>"); ?></td>
			<td align="right"><?php $total_cheque1=number_format($total_cheque,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$total_cheque1 </font>"); ?></td>
			<td align="right"><?php $total_effet1=number_format($total_effet,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$total_effet1 </font>"); ?></td>
			<td align="right"><?php $total_virement1=number_format($total_virement,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$total_virement1 </font>"); ?></td>
			
			<td align="right"><?php 
			$tenct=$tenct+$total_virement+$total_espece+$total_cheque+$total_effet;
			$tenc=number_format($total_virement+$total_espece+$total_cheque+$total_effet,2,',',' ');
			print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$tenc </font>"); ?></td></tr>
			
	 <? }	?><td></td>
			
			
			<td align="right"><?php $te1=number_format($te,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$te1 </font>"); ?></td>
			<td align="right"><?php $tc1=number_format($tc,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$tc1 </font>"); ?></td>
			<td align="right"><?php $tf1=number_format($tf,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$tf1 </font>"); ?></td>
			<td align="right"><?php $tv1=number_format($tv,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$tv1 </font>"); ?></td>
			<td align="right"><?php $encenc=number_format($tv+$tf+$tc+$te,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$encenc </font>"); ?></td>

</table>



	<? }?>
<p style="text-align:center">

<td><? echo "<a href=\"tableau_com_e.php?du=$du&au=$au\">IMPRIMER</a>";?></td>
</body>

</html>