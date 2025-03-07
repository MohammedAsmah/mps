<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$user_name=GetUserName();
	$error_message = "";
	$type_service="SEJOURS ET CIRCUITS";$action="Recherche";$date1="";$date2="";
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url

	
		$vendeur_list = "";
	$sql = "SELECT * FROM  vendeurs ORDER BY vendeur;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($vendeur == $temp_["vendeur"]) { $selected = " selected"; } else { $selected = ""; }
		
		$vendeur_list .= "<OPTION VALUE=\"" . $temp_["vendeur"] . "\"" . $selected . ">";
		$vendeur_list .= $temp_["vendeur"];
		$vendeur_list .= "</OPTION>";
	}
?>
	<? if(isset($_REQUEST["action"])){}else{ ?>
	<form id="form" name="form" method="post" action="encaissements_especes_encompte.php">
	<td><?php echo "Du : "; ?><input onclick="ds_sh(this);" name="date1" value="<?php echo $date1; ?>" readonly="readonly" style="cursor: text" /></td>
	<td><?php echo "Au : "; ?><input onclick="ds_sh(this);" name="date2" value="<?php echo $date2; ?>" readonly="readonly" style="cursor: text" /></td>
	<TR><td><?php echo "Vendeur		:"; ?></td><td><select id="vendeur" name="vendeur"><?php echo $vendeur_list; ?></select></td></TR>
	<input type="submit" id="action" name="action" value="<?php echo $action; ?>">
	</form>
	
	<? }


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
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<? 	if(isset($_REQUEST["action"]))
	{ $date=dateFrToUs($_POST['date1']);$total=0;$date2=dateFrToUs($_POST['date2']);$vendeur=$_POST['vendeur'];
	
	/*$sql  = "SELECT * ";$espece="ESPECE";
	$sql .= "FROM porte_feuilles where m_cheque=0 and m_espece<>0 and m_effet=0 and remise=0 ORDER BY id_registre_regl;";
	$users11 = db_query($database_name, $sql);*/
	
	/*$sql  = "SELECT date_remise,id,date_f,date_enc,client,client_tire,client_tire_e,vendeur,numero_cheque,v_banque,facture_n,impaye,
	sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece, sum(m_effet) as total_effet
	,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix ";
	$sql .= "FROM porte_feuilles where facture_n<>0 and m_espece<>0 and date_enc between '$date' and '$date2' Group BY id;";*/
	
	
	//enc espece mois en cours
	
	$sql  = "SELECT date_remise,id,date_e,evaluation,id_commande,date_f,date_enc,client,client_tire,client_tire_e,vendeur,numero_cheque,v_banque,facture_n,impaye,
	sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece, sum(m_effet) as total_effet
	,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix ";$date_aout="2010-07-31";
	$sql .= "FROM porte_feuilles where date_enc between '$date' and '$date2' and montant_f=0 Group BY id;";
	/*$sql .= "FROM porte_feuilles  Group BY id;";*/
	
	// encaiss espece sur en compte
	/*$date_aout="2010-08-01";
	$sql  = "SELECT date_remise,date_e,id,id_commande,date_f,date_enc,client,client_tire,client_tire_e,vendeur,numero_cheque,v_banque,facture_n,impaye,
	sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece, sum(m_effet) as total_effet
	,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix ";
	$sql .= "FROM porte_feuilles where m_espece<>0 and date_enc between '$date' and '$date2' and date_e>'$date_aout' and date_e<'$date' Group BY id;";
	*/
	$users11 = db_query($database_name, $sql);
	
?>


<span style="font-size:24px"><?php echo "Encaissments Especes / En compte : ".dateUsToFr($date)." Au ".dateUsToFr($date2)."  ".$vendeur; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Inputation";?></th>
	<th><?php echo "Client";?></th>
	<th><?php echo "Date Enc";?></th>
	<th><?php echo "ESPECE";?></th>
	<th><?php echo "Date Eval";?></th>
	<th><?php echo " Eval";?></th>
	
</tr>

<?php $compteur1=0;$total_g=0;$total_e=0;$total_c=0;$total_t=0;$total_ee=0;
while($users_1 = fetch_array($users11)) { $date_enc=$users_1["date_enc"];$vendeur=$users_1["vendeur"];$impaye=$users_1["impaye"];
			$ref="espece";$facture_n=$users_1["facture_n"];$dff=$users_1["date_f"];$id=$users_1["id"];$date_e=$users_1["date_e"];
			$client=$users_1["client"];$client_tire=$users_1["client_tire"];$client_tire_e=$users_1["client_tire_e"];
			$client=$users_1["client"];$total_e=$users_1["total_e"];$total_avoir=$users_1["total_avoir"];
			$total_cheque=$users_1["total_cheque"];$total_espece=$users_1["total_espece"];$total_effet=$users_1["total_effet"];
			$total_diff_prix=$users_1["total_diff_prix"];$id_commande=$users_1["id_commande"];$ev=$users_1["evaluation"];
			//
			$sql  = "SELECT * ";
	$sql .= "FROM commandes where id='$id_commande' ORDER BY id;";
	$users111r = db_query($database_name, $sql);$user_r = fetch_array($users111r);
		$date_ee=$user_r["date_e"];
			$sql = "UPDATE porte_feuilles SET ";
			$sql .= "date_e = '" . $date_ee . "' ";
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);
			///////////////
			
			
								$sql  = "SELECT * ";
	$sql .= "FROM clients where client='$client' ORDER BY id;";
	$users111 = db_query($database_name, $sql);$user_ = fetch_array($users111);
		$inputation=$user_["inputation"];$patente=$user_["patente"];

			
			?>
			<tr><td><?php print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$inputation </font>"); ?></td>
			<td><?php print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$client </font>"); ?></td>
			<td><?php $d1= dateUsToFr($date_enc);print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$d1 </font>"); ?></td>
			<td align="right"><?php $total_e=$total_e+$total_espece+$total_cheque+$total_effet+$total_virement;
			$total_ee=$total_ee+$total_espece+$total_cheque+$total_effet+$total_virement;
			/*$total_ee=$total_ee+$total_cheque+$total_espece+$total_effet+$total_virement-$total_avoir-$total_diff_prix;*/
			$tesp=number_format($total_espece+$total_cheque+$total_effet+$total_virement,2,',',' ');
			 print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$tesp </font>");?></td>
			<td><?php $de= dateUsToFr($date_e);print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$de </font>"); ?></td>
			<td><?php print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$ev </font>"); ?></td>
			<? 
			
			
			?>	
<? } ?>
<tr><td></td><td></td><td></td>
			<td align="right"><?php $tt=number_format($total_ee,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#CC0000\">$tt </font>");
			 ?></td>
</table>
</strong>
<p style="text-align:center">


<? }?>
</body>

</html>