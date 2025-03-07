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

	?>
	<? if(isset($_REQUEST["action"])){}else{ ?>
	<form id="form" name="form" method="post" action="indexation_dates.php">
	<td><?php echo "Du : "; ?><input onclick="ds_sh(this);" name="date1" value="<?php echo $date1; ?>" readonly="readonly" style="cursor: text" /></td>
	<td><?php echo "Au : "; ?><input onclick="ds_sh(this);" name="date2" value="<?php echo $date2; ?>" readonly="readonly" style="cursor: text" /></td>
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

<? 	 $date=date("Y-m-d");$total=0;
	if(isset($_REQUEST["action"]))
	{ $date=dateFrToUs($_POST['date1']);$total=0;$date2=dateFrToUs($_POST['date2']);
	/*$sql  = "SELECT * ";$espece="ESPECE";
	$sql .= "FROM porte_feuilles where date_enc='$date' ORDER BY id_registre_regl;";
	$users11 = db_query($database_name, $sql);*/
	$sql  = "SELECT * ";$date_vide="0000-00-00";
	$sql .= "FROM porte_feuilles_factures where date_f='$date_vide' ORDER BY date_echeance;";
	$users11 = db_query($database_name, $sql);
	
?>


<span style="font-size:24px"><?php echo "Effets avec date echeance repportée : ".$_POST['date1']." au ".$_POST['date2']; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Inputation";?></th>
	<th><?php echo "Client";?></th>
	<th><?php echo "Vendeur";?></th>
	<th><?php echo "Facture";?></th>
	<th><?php echo "Date Fact";?></th>
	<th><?php echo "Reference";?></th>
	<th><?php echo "Echeance";?></th>
	<th><?php echo "Remise le";?></th>
	<th><?php echo "Effet";?></th>
	
</tr>

<?php $compteur1=0;$total_g=0;$total_e=0;$total_c=0;$total_t=0;$total_ee=0;$d="";
while($users_1 = fetch_array($users11)) { $date_enc=$users_1["date_enc"];$vendeur=$users_1["vendeur"];$impaye=$users_1["impaye"];$id=$users_1["id"];
			$ref=$users_1["numero_effet"]."/".$users_1["v_banque_e"];$facture_n=$users_1["facture_n"];$date_remise=$users_1["date_remise_e"];
			$client=$users_1["client"];$client_tire=$users_1["client_tire_e"];$client_tire_e=$users_1["client_tire_e"];
			$total_effet=$users_1["m_effet"];
			$date_echeance=$users_1["date_echeance"];
	$sql  = "SELECT * ";
	$sql .= "FROM clients where client='$client' ORDER BY id;";
	$users111 = db_query($database_name, $sql);$user_ = fetch_array($users111);
		$inputation=$user_["inputation"];$patente=$user_["patente"];
				
				if ($facture_n<9039){
				$sql  = "SELECT * ";
				$sql .= "FROM factures where numero='$facture_n' ORDER BY id;";
				}
				else
				{
				$sql  = "SELECT * ";
				$sql .= "FROM factures2016 where numero='$facture_n' ORDER BY id;";
				}
				$users = db_query($database_name, $sql);$row = fetch_array($users);$d=$row["date_f"];?>
			
			
			<? 
			$sql = "UPDATE porte_feuilles_factures SET ";$valider_f=1;
			$sql .= "date_f = '" . $d . "' ";
			$sql .= "WHERE id = '$id'" . ";";
			db_query($database_name, $sql);
			
			?>

				

			<tr><td><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$inputation </font>"); ?></td>
			<td><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$client </font>"); ?></td>
			<td><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$vendeur </font>"); ?></td>
			<td><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$facture_n </font>"); ?></td>
			<td><?php $df=dateUsToFr($d);print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$df </font>"); ?></td>
			<td><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$ref </font>"); ?></td>
			<td><?php $d1= dateUsToFr($date_echeance);print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$d1 </font>"); ?></td>
			<td><?php $d2= dateUsToFr($date_remise);print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$d2 </font>"); ?></td>
			
			<td align="right"><?php $total_c=$total_c+$total_effet;$tchq=number_format($total_effet,2,',',' ');
			print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$tchq </font>");
			 ?></td>
			 	<? ?>
				
<? } ?>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
			<td align="right"><?php $tcc=number_format($total_c,2,',',' '); print("<font size=\"1\" face=\"Comic sans MS\" color=\"#CC0000\">$tcc </font>");?></td>

</table>
</strong>
<p style="text-align:center">
<? }?>


</body>

</html>