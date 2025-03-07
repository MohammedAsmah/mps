<meta http-equiv="Pragma" content="no-cache" />
<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	
	$error_message = "";$du="";$au="";$vendeur="";$remise_1=0;$remise_2=0;$remise_3=0;
	//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$login = $user_["login"];
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
	<form id="form" name="form" method="post" action="porte_feuilles_cheques_clients.php">
	<td><?php echo "Au : "; ?><input onclick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" />
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }



	if(isset($_REQUEST["action"]))
	{
	
	$date=dateFrToUs($_POST['date']);	


	//$date=dateFrToUs(date("d/m/Y"));
	
	$total=0;$vide="0000-00-00";
	
	$sql  = "SELECT id,date_enc,date_cheque,client,client_tire,v_banque,numero_cheque,sum(m_cheque) As total_cheque ";
	$sql .= "FROM porte_feuilles where date_cheque<='$date' and m_cheque<>0 and remise=0 and chq_f=1 GROUP BY client order by total_cheque DESC;";
	$users11 = db_query($database_name, $sql);
	
	
	
	
?>


<span style="font-size:24px"><?php echo "Porte Feuilles au : ".dateUsToFr($date); ?></span>

<table class="table2">

<tr>
	<th><?php echo "Client";?></th>
   	<th><?php echo "Montant Total";?></th>

	
</tr>

<?php 
$compteur1=0;$total_g=0;
while($users_1 = fetch_array($users11)) { 
			$date_enc=$users_1["date_enc"];$evaluation=$users_1["facture_n"];$id=$users_1["id"];
			$client=$users_1["client"];$client_tire=$users_1["client_tire"];$vendeur=$users_1["vendeur"];$id_registre_regl=$users_1["id_registre_regl"];
			$v_banque=$users_1["v_banque"];$numero_cheque=$users_1["numero_cheque"];$total_cheque=$users_1["total_cheque"];$facture_n=$users_1["facture_n"];
			$evaluation=$users_1["evaluation"];$date_echeance=$users_1["date_echeance"];$m_cheque_g=$users_1["m_cheque_g"];
			$montant_e=$users_1["montant_e"];
			$ref=$v_banque." ".$numero_cheque;$date_cheque=dateUsToFr($users_1["date_cheque"]);$date_cheque1=$users_1["date_cheque"];

			$sql  = "SELECT * ";
			$sql .= "FROM porte_feuilles_factures where numero_cheque='$numero_cheque' and client='$client' ;";
			$users111 = db_query($database_name, $sql);$users_111 = fetch_array($users111);
			$remise=$users_111["remise"];
			
			if ($login=="admin"){
			echo "<tr><td><a href=\"porte_feuilles_details1ct.php?client=$client&date=$date\">$client</a></td>";
			}
			
			
			if ($remise==0){
			?>
			
			<? echo "<tr><td><a href=\"porte_feuilles_details1c.php?client=$client&date=$date\">$client</a></td>";

			
			?>
			<?php $total_g=$total_g+$total_cheque;$tc= number_format($total_cheque,2,',',' ');?>
		<? echo "<td>$tc</td>";}
		
		

		
		
?>
<? } ?>
<tr><td></td><td align="right"><? $m=number_format($total_g,2,',',' ');echo "<a href=\"cheques_non_remis.php\">$m</a></td>";?>
<tr>

<tr><? echo "<td><a href=\"\\mps\\tutorial\\porte_feuilles_cheques_clients.php?date=$date\">Imprimer</a></td>";?>
<tr><? echo "<td><a href=\"\\mps\\tutorial\\porte_feuilles_cheques_details_clients.php?date=$date\">Imprimer detail</a></td>";?>


</table>
</strong>
<p style="text-align:center">

<? }?>

</body>

</html>