<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$user_name=GetUserName();
	$valeur=3600;
set_time_limit($valeur);

	$error_message = "";
	$type_service="SEJOURS ET CIRCUITS";
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	$action="recherche";
	
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

	<?	
	
	$date=dateFrToUs(date("d/m/Y"));$total=0;$vide="0000-00-00";
	
	if(isset($_REQUEST["action"])){}else{
	?>
	<form id="form" name="form" method="post" action="porte_feuilles_effets_clients_remis.php">
	<td><?php echo "Du : "; ?><input onclick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" />
	<td><?php echo "Au : "; ?><input onclick="ds_sh(this);" name="date2" readonly="readonly" style="cursor: text" />
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }



	if(isset($_REQUEST["action"]))
	{
	
	$date=dateFrToUs($_POST['date']);$date2=dateFrToUs($_POST['date2']);	
	
	$sql  = "SELECT id,date_enc,date_cheque,date_echeance,client,client_tire,v_banque,numero_cheque,sum(m_effet) As total_cheque ";
	$sql .= "FROM porte_feuilles where date_remise_e between '$date' and '$date2' and m_effet<>0 and remise_e=1 and eff_f=1 GROUP BY client;";
	$users11 = db_query($database_name, $sql);
		
	
?>


<span style="font-size:24px"><?php echo "Remises Effets du ".dateUsToFr($date)." au ".dateUsToFr($date2); ?></span>

<table class="table2">

<tr>
	<th><?php echo "Client";?></th>
   	<th><?php echo "Montant Total";?></th>

	
</tr>

<?php 
$compteur1=0;$total_g=0;
while($users_1 = fetch_array($users11)) { 
			$date_enc=$users_1["date_enc"];$evaluation=$users_1["facture_n"];$id=$users_1["id"];
			$client=$users_1["client"];$client_tire=$users_1["client_tire"];
			$v_banque=$users_1["v_banque"];$numero_cheque=$users_1["numero_cheque"];$total_cheque=$users_1["total_cheque"];
			$ref=$v_banque." ".$numero_cheque;$date_cheque=dateUsToFr($users_1["date_echeance"]);$date_cheque1=$users_1["date_echeance"];?>
			<? echo "<tr><td><a href=\"porte_feuilles_effet_details1cr.php?client=$client&date=$date&date2=$date2\">$client</a></td>";?>
			<td align="right"><? $total_g=$total_g+$total_cheque;$tc=number_format($total_cheque,2,',',' ');
			echo "$tc</td>";?>
			
		<? 
		
		

		
		
?>
<? } ?>
<tr><td></td><td align="right"><? $m=number_format($total_g,2,',',' ');echo $m;?>


</table>

<? }?>

</strong>
<p style="text-align:center">


</body>

</html>