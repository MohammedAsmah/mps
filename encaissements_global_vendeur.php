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

	$profiles_list_vendeur="";
	$sql1 = "SELECT * FROM vendeurs ORDER BY vendeur;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($vendeur == $temp_["vendeur"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_vendeur .= "<OPTION VALUE=\"" . $temp_["vendeur"] . "\"" . $selected . ">";
		$profiles_list_vendeur .= $temp_["vendeur"];
		$profiles_list_vendeur .= "</OPTION>";
	}

	?>
	<? if(isset($_REQUEST["action"])){}else{ ?>
	<form id="form" name="form" method="post" action="encaissements_global_vendeur.php">
	<td><?php echo "Du : "; ?><input onclick="ds_sh(this);" name="date1" value="<?php echo $date1; ?>" readonly="readonly" style="cursor: text" /></td>
	<td><?php echo "Au : "; ?><input onclick="ds_sh(this);" name="date2" value="<?php echo $date2; ?>" readonly="readonly" style="cursor: text" /></td>
	<td><?php echo "Vendeur: "; ?></td><td><select id="vendeur" name="vendeur"><?php echo $profiles_list_vendeur; ?></select></td>
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
	
		
	$sql  = "SELECT date_remise,date_remise_e,id,date_f,date_enc,date_remise,client,client_tire,client_tire_e,vendeur,numero_cheque,v_banque,facture_n,impaye,
	sum(montant_e) as total_e,id_commande,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece, sum(m_effet) as total_effet
	,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
	$sql .= "FROM porte_feuilles where vendeur='$vendeur' and (date_enc between '$date' and '$date2') Group BY id order by date_e;";
	
	$users11 = db_query($database_name, $sql);
	$total_cheque_t=0;$total_espece_t=0;$total_effet_t=0;$total_virement_t=0;
?>


<span style="font-size:24px"><?php echo "Encaissments  : $vendeur ".dateUsToFr($date)." Au ".dateUsToFr($date2); ?></span>

<table class="table2">

<tr>
	<th><?php echo "Client";?></th>
	<th><?php echo "Reference";?></th>	
	<th><?php echo "Date Eval";?></th>
	<th><?php echo "Date Enc";?></th>
	<th><?php echo "Espece";?></th>
	<th><?php echo "Cheque";?></th>
	<th><?php echo "Effet";?></th>
	<th><?php echo "Virement";?></th>
	<th><?php echo "Remise";?></th>	
</tr>

<?php $compteur1=0;$total_g=0;$total_e=0;$total_c=0;$total_t=0;$total_ee=0;
while($users_1 = fetch_array($users11)) { $date_enc=dateUsToFr($users_1["date_enc"]);
$vendeur=$users_1["vendeur"];$impaye=$users_1["impaye"];
			$id_commande=$users_1["id_commande"];$tableau=$users_1["id_registre_regl"];
			$id=$users_1["id"];$facture_n=$users_1["facture_n"];
			
		
		if ($facture_n<>0){
	$sql  = "SELECT * ";
	$sql .= "FROM factures where numero=$facture_n GROUP BY id;";
	$users33 = db_query($database_name, $sql);$user_r3 = fetch_array($users33);
	$date_ff=$user_r3["date_f"];$evaluation=$user_r3["evaluation"];$reference="F/".$facture_n;}
		else
		{$sql  = "SELECT * ";
	$sql .= "FROM commandes where id=$id_commande GROUP BY id;";
	$users3 = db_query($database_name, $sql);$user_r = fetch_array($users3);
	$date_ff=$user_r["date_e"];$evaluation=$user_r["evaluation"];$reference="E/".$evaluation;
		}
		
			/*$sql = "UPDATE porte_feuilles SET ";
			$sql .= "date_e = '" . $date_ff . "' ";
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);*/
		
			
			$ref="espece";$facture_n=$users_1["facture_n"];$dff=$users_1["date_f"];$id=$users_1["id"];
			$date_remise=$users_1["date_remise"];$date_remise_e=$users_1["date_remise_e"];
			$client=$users_1["client"];$client_tire=$users_1["client_tire"];$client_tire_e=$users_1["client_tire_e"];
			$client=$users_1["client"];$total_e=$users_1["total_e"];$total_avoir=$users_1["total_avoir"];
			$total_cheque=$users_1["total_cheque"];$total_espece=$users_1["total_espece"];$total_effet=$users_1["total_effet"];
			$total_diff_prix=$users_1["total_diff_prix"];$total_virement=$users_1["total_virement"];
			
			$total_cheque_t=$total_cheque_t+$total_cheque;
			$total_espece_t=$total_espece_t+$total_espece;
			$total_effet_t=$total_effet_t+$total_effet;
			$total_virement_t=$total_virement_t+$total_virement;

			
			///////////////
			?>
			
			<tr>
			<td><?php print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$client </font>"); ?></td>
			<td><?php print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$reference </font>"); ?></td>
			
			<td><?php $date_ee=dateUsToFr($date_ff);print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$date_ee </font>"); ?></td>
			<td><?php print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$date_enc </font>"); ?></td>
			<td align="right"><?php $total_espece=number_format($total_espece,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$total_espece </font>"); ?></td>
			<td align="right"><?php $total_cheque=number_format($total_cheque,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$total_cheque </font>"); ?></td>
			<td align="right"><?php $total_effet=number_format($total_effet,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$total_effet </font>"); ?></td>
			<td align="right"><?php $total_virement=number_format($total_virement,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$total_virement </font>"); ?></td>
			<td><?php if ($total_effet<>0){$date_r=dateUsToFr($date_remise_e);}
			if ($total_cheque<>0){$date_r=dateUsToFr($date_remise);}
			if ($total_espece<>0){$date_r=$date_enc;}
			if ($total_virement<>0){$date_r=$date_enc;}
			print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$date_r </font>"); ?></td></tr>
			
<? } ?>
<td></td><td></td><td></td><td></td>
			<td align="right"><?php $total_espece_t=number_format($total_espece_t,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$total_espece_t </font>"); ?></td>
			<td align="right"><?php $total_cheque_t=number_format($total_cheque_t,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$total_cheque_t </font>"); ?></td>
			<td align="right"><?php $total_effet_t=number_format($total_effet_t,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$total_effet_t </font>"); ?></td>
			<td align="right"><?php $total_virement_t=number_format($total_virement_t,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$total_virement_t </font>"); ?></td></tr>

</table>
</strong>
<p style="text-align:center">


<? }?>
</body>

</html>