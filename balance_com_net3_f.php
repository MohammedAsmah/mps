<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$login = $user_["login"];
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
<script type="text/javascript"><!--
	function UpdateUser() {
			document.location = "tableau_com_f.php?du=$du&au=$au";
	}

	--></script>

</head>

<body style="background:#dfe8ff">
		<? require "body_cal.php";?>

	<?
	
			if(isset($_REQUEST["action"])){}else{
	?>
	<form id="form" name="form" method="post" action="balance_com_net3_f.php">
	<td><?php echo "Du : "; ?><input onclick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" />
	<td><?php echo "Au : "; ?><input onclick="ds_sh(this);" name="date1" readonly="readonly" style="cursor: text" />
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }
	if(isset($_REQUEST["action"]))
	{
	
	$date=dateFrToUs($_POST['date']);$du=$_POST['date'];$date1=dateFrToUs($_POST['date1']);$au=$_POST['date1'];
	$du=$_POST['date'];$au=$_POST['date1'];$encours="encours";$enc_t=0;
	
	
	
	
	/*$sql  = "SELECT * ";
		$sql .= "FROM porte_feuilles where date_enc between '$date' and '$date1' order BY vendeur;";
		$users3 = db_query($database_name, $sql);
	while($row33 = fetch_array($users3))
	{	
	
		$id_p = $row33['id'];$date_enc = $row33['date_enc'];$vide="0000-00-00";
		
		    $sql = "UPDATE porte_feuilles_factures SET date_enc = '$date_enc' WHERE id_porte_feuille = '$id_p' and date_enc='$vide' ";
			db_query($database_name, $sql);
	}
	*/
	
	
	?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Balance Encaissement / Factures $du au $au"; ?></span>

<p style="text-align:center">


<table class="table2">

<tr>
	<th><?php echo "Vendeur";?></th>
	<th><?php echo "Factures";?></th>
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

<?php 


//ca 
		$sql  = "SELECT date_f,vendeur,numero,client,sum(montant) as total_net ";$encours="encours";
		$sql .= "FROM factures2021 where date_f between '$date' and '$date1' GROUP BY vendeur;";
		$users = db_query($database_name, $sql);
	while($row3 = fetch_array($users))
	{	
	
		$total_net = $row3['total_net'];
		$vendeur=$row3['vendeur'];$numero=$row3['numero'];$client=$row3['client'];
		/*
		<tr><td align="left"><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$numero </font>"); ?></td>
		<td align="left"><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$vendeur </font>"); ?></td>
		<td align="left"><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$client </font>"); ?></td>
		*/
		
		///insertion
				$sql  = "INSERT INTO journal_commissions ( vendeur,evaluations ) VALUES ( ";
				$sql .= "'".$vendeur . "',";
				$sql .= "'".$total_net . "');";
				db_query($database_name, $sql);

	 }

//encaiss sur en compte cheque

	$date_d="2010-08-01";
	$sql  = "SELECT date_remise,date_f,vendeur, sum(m_cheque) as total_cheque ";$vide="";
	$sql .= "FROM porte_feuilles_factures where (date_remise between '$date' and '$date1')  and date_f<'$date' and remise=1 and numero_cheque_imp='$vide' Group BY vendeur ;";
	$users7 = db_query($database_name, $sql);$t_cheque=0;$t_espece=0;$t_avoir=0;$t_effet=0;$t_virement=0;
	while($row7 = fetch_array($users7))
	{	
	
		$total_cheque = $row7['total_cheque'];
		$total_espece = 0;
		$total_effet = 0;
		$total_avoir = 0;
		$total_diff_prix = 0;
		$total_virement = 0;
		$encaiss_encompte=$total_cheque+$total_espece+$total_effet+$total_virement-$total_avoir-$total_diff_prix;
		$vendeur=$row7['vendeur'];$client=$row7['client'];
		
		///insertion
				$sql  = "INSERT INTO journal_commissions ( vendeur,encaiss_encompte,encompte_cheque ) VALUES ( ";
				$sql .= "'".$vendeur . "',";
				$sql .= "'".$total_cheque . "',";
				$sql .= "'".$total_cheque . "');";
				db_query($database_name, $sql);
				$sql  = "INSERT INTO journal_commissions_d ( vendeur,client,encaiss_encompte,encompte_cheque ) VALUES ( ";
				$sql .= "'".$vendeur . "',";$sql .= "'".$client . "',";
				$sql .= "'".$total_cheque . "',";
				$sql .= "'".$total_cheque . "');";
				db_query($database_name, $sql);

	 }
//encaiss sur en compte espece

	$date_d="2010-08-01";
	$sql  = "SELECT date_enc,id,date_f,client,vendeur,sum(m_espece) as total_espece ";
	$sql .= "FROM porte_feuilles_factures where date_enc between '$date' and '$date1'  and date_f<'$date' and m_espece<>0 and facture_n<>0 Group BY vendeur ;";
	$users7 = db_query($database_name, $sql);$t_cheque=0;$t_espece=0;$t_avoir=0;$t_effet=0;$t_virement=0;
	while($row7 = fetch_array($users7))
	{	
	
		$total_cheque = 0;
		$total_espece = $row7['total_espece'];
		$total_effet = 0;
		$total_avoir = 0;
		$total_diff_prix = 0;
		$total_virement = 0;
		$encaiss_encompte=$total_cheque+$total_espece+$total_effet+$total_virement+$total_avoir+$total_diff_prix;
		$vendeur=$row7['vendeur'];
		
		///insertion
				$sql  = "INSERT INTO journal_commissions ( vendeur,encaiss_encompte,encompte_espece ) VALUES ( ";
				$sql .= "'".$vendeur . "',";$sql .= "'".$total_espece . "',";
				$sql .= "'".$total_espece . "');";
				db_query($database_name, $sql);

	 }
	
//encaiss sur en compte effet

	$date_d="2010-08-01";
	$sql  = "SELECT date_f,client,vendeur,sum(m_effet) as total_effet ";
	$sql .= "FROM porte_feuilles_factures where m_effet<>0 and (date_remise_e between '$date' and '$date1') and date_f<'$date' and date_remise_e<='$date1' and remise_e=1 Group BY vendeur ;";
	$users7 = db_query($database_name, $sql);$t_cheque=0;$t_espece=0;$t_avoir=0;$t_effet=0;$t_virement=0;
	while($row7 = fetch_array($users7))
	{	
	
		$total_cheque = 0;
		$total_espece = 0;
		$total_effet = $row7['total_effet'];
		$total_avoir = 0;
		$total_diff_prix = 0;
		$total_virement = 0;
		$encaiss_encompte=$total_cheque+$total_espece+$total_effet+$total_virement-$total_avoir-$total_diff_prix;
		$vendeur=$row7['vendeur'];
		
		///insertion
				$sql  = "INSERT INTO journal_commissions ( vendeur,encaiss_encompte,encompte_effet ) VALUES ( ";
				$sql .= "'".$vendeur . "',";$sql .= "'".$total_effet . "',";
				$sql .= "'".$total_effet . "');";
				db_query($database_name, $sql);

	 }
	 
///////sur encompte virment
////////////////:virements
	 
		$sql  = "SELECT date_enc,date_f,client,vendeur,sum(m_virement) as total_virement ";
	$sql .= "FROM porte_feuilles_factures where (date_enc between '$date' and '$date1') and date_f<'$date' and m_virement<>0 Group BY vendeur;";
	$users111112 = db_query($database_name, $sql);$t_cheque=0;$t_espece=0;$t_avoir=0;$t_effet=0;$t_virement=0;
	while($row1112 = fetch_array($users111112))
	{	
	
		$total_virement = $row1112['total_virement'];
		$vendeur=$row1112['vendeur'];
		
		///insertion
				$sql  = "INSERT INTO journal_commissions ( vendeur,virement ) VALUES ( ";
				$sql .= "'".$vendeur . "',";
				$sql .= "'".$total_virement . "');";
				db_query($database_name, $sql);

	 }
	 
	 
	 
	 
	 
	 
	 
//////////////////////////	
	
	 
//encaiss sur impayes

	$date_d="2010-08-01";$impaye="impaye";
	$sql  = "SELECT date_remise,id,date_f,date_enc,client,client_tire,client_tire_e,vendeur,numero_cheque,v_banque,facture_n,impaye,
	sum(montant_e) as total_e,id_commande,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece, sum(m_effet) as total_effet
	,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
	$sql .= "FROM porte_feuilles_impayes where (date_enc between '$date' and '$date1') Group BY vendeur;";
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



/// impayes cheques


	$sql  = "SELECT * ";
	$sql .= "FROM porte_feuilles_factures where (date_impaye between '$date' and '$date1') and facture_n<>0 and r_impaye=1 and m_cheque<>0 ;";
	$users6 = db_query($database_name, $sql);$t_cheque=0;$t_espece=0;$t_avoir=0;$t_effet=0;$t_virement=0;
	while($row6 = fetch_array($users6))
	{	
	
		$total_cheque_imp = $row6['m_cheque'];
		$vendeur=$row6['vendeur'];
		
		///insertion
				$sql  = "INSERT INTO journal_commissions ( vendeur,impayes ) VALUES ( ";
				$sql .= "'".$vendeur . "',";
				$sql .= "'".$total_cheque_imp . "');";
				db_query($database_name, $sql);

	 }
	

/// impayes effets


	$sql  = "SELECT * ";
	$sql .= "FROM porte_feuilles_factures where (date_impaye_e between '$date' and '$date1') and facture_n<>0 and r_impaye_e=1 and m_effet<>0 ;";
	$users66 = db_query($database_name, $sql);$t_cheque=0;$t_espece=0;$t_avoir=0;$t_effet=0;$t_virement=0;
	while($row66 = fetch_array($users66))
	{	
	
		$total_cheque_imp = $row66['m_effet'];
		$vendeur=$row66['vendeur'];
		
		///insertion
				$sql  = "INSERT INTO journal_commissions ( vendeur,impayes ) VALUES ( ";
				$sql .= "'".$vendeur . "',";
				$sql .= "'".$total_cheque_imp . "');";
				db_query($database_name, $sql);

	 }
	 


	 

/// espece


	$sql  = "SELECT date_f,date_enc,client,vendeur,sum(m_espece) as total_espece ";
	$sql .= "FROM porte_feuilles_factures where (date_enc between '$date' and '$date1')  and (date_f between '$date' and '$date1') 
	 and m_espece<>0 Group BY vendeur;";
	$users11 = db_query($database_name, $sql);$t_cheque=0;$t_espece=0;$t_avoir=0;$t_effet=0;$t_virement=0;
	while($row = fetch_array($users11))
	{	
	
		$total_cheque = 0;
		$total_espece = $row['total_espece'];
		$total_effet = 0;
		$total_avoir = 0;
		$total_diff_prix = 0;
		$total_virement = 0;
		$t_cheque=$t_cheque+$total_cheque;$t_effet=$t_effet+$total_effet;$t_virement=$t_virement+$total_virement;
		$t_espece=$t_espece+$total_espece;$vendeur=$row['vendeur'];
		
		///insertion
				$sql  = "INSERT INTO journal_commissions ( vendeur,espece ) VALUES ( ";
				$sql .= "'".$vendeur . "',";
				$sql .= "'".$total_espece . "');";
				db_query($database_name, $sql);

	 }
	 
	 
/// avoirs


	$sql  = "SELECT date_remise,id,date_f,date_enc,client,client_tire,client_tire_e,vendeur,numero_cheque,v_banque,facture_n,impaye,
	sum(montant_e) as total_e,id_commande,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece, sum(m_effet) as total_effet
	,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
	$sql .= "FROM porte_feuilles where (date_enc between '$date' and '$date1')  and (date_e between '$date' and '$date1') 
	 and esp_f=1 Group BY vendeur;";
	$users5 = db_query($database_name, $sql);$t_cheque=0;$t_espece=0;$t_avoir=0;$t_effet=0;$t_virement=0;
	while($row5 = fetch_array($users5))
	{	
	
		$total_avoir = 0;
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
	 and esp_f=1 Group BY vendeur;";
	$users4 = db_query($database_name, $sql);$t_cheque=0;$t_espece=0;$t_avoir=0;$t_effet=0;$t_virement=0;
	while($row4 = fetch_array($users4))
	{	
	
		$total_diff_prix = 0;
		$vendeur=$row4['vendeur'];
		
		///insertion
				$sql  = "INSERT INTO journal_commissions ( vendeur,differences ) VALUES ( ";
				$sql .= "'".$vendeur . "',";
				$sql .= "'".$total_diff_prix . "');";
				db_query($database_name, $sql);

	 }


	
	////////////////:cheques
	 
		$sql  = "SELECT date_remise,id,date_f,client,vendeur,sum(m_cheque) as total_cheque ";
	$sql .= "FROM porte_feuilles_factures where (date_remise between '$date' and '$date1')  and (date_f between '$date' and '$date1') 
	 and remise=1 and m_cheque<>0 Group BY vendeur;";
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
	 
		$sql  = "SELECT id,date_f,client,vendeur,sum(m_effet) as total_effet ";
	$sql .= "FROM porte_feuilles_factures where m_effet<>0 and (date_remise_e between '$date' and '$date1')
	and remise_e=1 and (date_f between '$date' and '$date1') and date_remise_e<='$date1' Group BY vendeur;";
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
	 
		$sql  = "SELECT date_enc,date_f,client,vendeur,sum(m_virement) as total_virement ";
	$sql .= "FROM porte_feuilles_factures where (date_enc between '$date' and '$date1')  and (date_f between '$date' and '$date1') 
	 and m_virement<>0 Group BY vendeur;";
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

	 
	 ?>
	
	
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
		$total_evaluations = $row222['total_evaluations'];$tev=$tev+$total_evaluations;
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
		$vendeur=$row222['vendeur'];?>
		
			<td align="left"><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$vendeur </font>"); ?></td>

		<td align="right"><?php $total_evaluations1=number_format($total_evaluations,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$total_evaluations1 </font>"); ?></td>
			<td align="right"><?php $tcc=$tcc+($total_evaluations-($total_virement+$total_espece+$total_cheque+$total_effet+$total_avoirs+$total_differences));
			$tencompte=number_format($total_evaluations-($total_virement+$total_espece+$total_cheque+$total_effet+$total_avoirs+$total_differences),2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$tencompte </font>"); ?></td>
			<td align="right"><?php $total_avoirs1=number_format($total_avoirs+$total_differences,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$total_avoirs1 </font>"); ?></td>
			<td align="right"><?php $total_impayes1=number_format($total_impayes,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$total_impayes1 </font>"); ?></td>
			<td align="right"><?php $total_espece1=number_format($total_espece,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$total_espece1 </font>"); ?></td>
			<td align="right"><?php $total_cheque1=number_format($total_cheque,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$total_cheque1 </font>"); ?></td>
			<td align="right"><?php $total_effet1=number_format($total_effet,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$total_effet1 </font>"); ?></td>
			<td align="right"><?php $total_virement1=number_format($total_virement,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$total_virement1 </font>"); ?></td>
			<td align="right"><?php $total_encaiss_imp1=number_format($total_encaiss_imp,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$total_encaiss_imp1 </font>"); ?></td>
			<td align="right"><?php $total_encaiss_encompte1=number_format($total_encaiss_encompte,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$total_encaiss_encompte1 </font>"); ?></td>

			<td align="right"><?php 
			$tenct=$tenct+$total_virement+$total_espece+$total_cheque+$total_effet+$total_encaiss_encompte+$total_encaiss_imp-$total_avoirs-$total_differences-$total_impayes;
			$tenc=number_format($total_virement+$total_espece+$total_cheque+$total_effet+$total_encaiss_encompte+$total_encaiss_imp-$total_avoirs-$total_differences-$total_impayes,2,',',' ');
			print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$tenc </font>"); ?></td></tr>
	 <? }	?><td></td>
			
			<td align="right"><?php $tev1=number_format($tev,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$tev1 </font>"); ?></td>
			<td align="right"><?php $tcc1=number_format($tcc,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$tcc1 </font>"); ?></td>
			<td align="right"><?php $tav1=number_format($tav+$td,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$tav1 </font>"); ?></td>
			<td align="right"><?php $timp1=number_format($timp,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$timp1 </font>"); ?></td>
			<td align="right"><?php $te1=number_format($te,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$te1 </font>"); ?></td>
			<td align="right"><?php $tc1=number_format($tc,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$tc1 </font>"); ?></td>
			<td align="right"><?php $tf1=number_format($tf,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$tf1 </font>"); ?></td>
			<td align="right"><?php $tv1=number_format($tv,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$tv1 </font>"); ?></td>
			<td align="right"><?php $tencimp1=number_format($tencimp,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$tencimp1 </font>"); ?></td>
			<td align="right"><?php $tencompte1=number_format($t,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$tencompte1 </font>"); ?></td>
			<td align="right"><?php $tenc1=number_format($tenct,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$tenc1 </font>"); ?></td>

</table>
<span style="font-size:24px"><?php echo "Details Encaissement sur En compte / Factures $du au $au"; ?></span>
<table class="table2">

<tr>
	<th><?php echo "Vendeur";?></th>
	<th><?php echo "Espece";?></th>
	<th><?php echo "Cheque";?></th>
	<th><?php echo "Effet";?></th>
	<th><?php echo "Total Encompte";?></th>
</tr>
<? /////edition
	 
	 $te=0;$tc=0;$tf=0;$tv=0;$tev=0;$tav=0;$td=0;$tcc=0;$timp=0;$tencompte=0;$tencimp=0;$tenct=0;$t=0;
		$sql  = "SELECT vendeur,sum(encompte_espece) as total_espece,sum(encompte_cheque) as total_cheque,
		sum(encompte_effet) as total_effet
		,sum(virement) as total_virement,sum(encaiss_imp) as total_encaiss_imp,sum(evaluations) as total_evaluations,
		sum(encaiss_encompte) as total_encaiss_encompte,sum(avoirs) as total_avoirs,sum(differences) 
		as total_differences,sum(impayes) as total_impayes ";
	$sql .= "FROM journal_commissions Group BY vendeur;";
	$users2222 = db_query($database_name, $sql);
	while($row2222 = fetch_array($users2222))
	{	
		$total_espece = $row2222['total_espece'];$te=$te+$total_espece;
		$total_cheque = $row2222['total_cheque'];$tc=$tc+$total_cheque;
		$total_effet = $row2222['total_effet'];$tf=$tf+$total_effet;
		
		$vendeur=$row2222['vendeur'];?>
		
			<td align="left"><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$vendeur </font>"); ?></td>
			<td align="right"><?php $total_espece1=number_format($total_espece,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$total_espece1 </font>"); ?></td>
			<td align="right"><?php $total_cheque1=number_format($total_cheque,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$total_cheque1 </font>"); ?></td>
			<td align="right"><?php $total_effet1=number_format($total_effet,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$total_effet1 </font>"); ?></td>

			<td align="right"><?php 
			$tenc=number_format($total_espece+$total_cheque+$total_effet,2,',',' ');
			$tenct=$tenct+$total_espece+$total_cheque+$total_effet;
			print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$tenc </font>"); ?></td></tr>
	 <? }	?><td></td>
			
			<td align="right"><?php $te1=number_format($te,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$te1 </font>"); ?></td>
			<td align="right"><?php $tc1=number_format($tc,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$tc1 </font>"); ?></td>
			<td align="right"><?php $tf1=number_format($tf,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$tf1 </font>"); ?></td>
			<td align="right"><?php $tenc1=number_format($tenct,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$tenc1 </font>"); ?></td>

</table>


	
<p style="text-align:center">


<td><? echo "<a href=\"tableau_com_f.php?du=$du&au=$au\">IMPRIMER</a>";?></td>

<? }?>
</body>

</html>