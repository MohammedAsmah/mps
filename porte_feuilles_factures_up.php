<meta http-equiv="Pragma" content="no-cache" />
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

	$date=dateFrToUs(date("d/m/Y"));$total=0;$vide="0000-00-00";$vide_f="";$d="2024-01-01";
	
	$sql  = "SELECT * ";$vide="";
	//$sql .= "FROM porte_feuilles_factures where facture_n<>0 and numero_facture='$vide' and date_f>='$d' order BY facture_n;";
	$sql .= "FROM porte_feuilles_factures where facture_n<>0 and date_f>='$d' order BY facture_n;";
	$users11 = db_query($database_name, $sql);
	
		
	
?>


<span style="font-size:24px"><?php echo "Porte Feuilles au : ".dateUsToFr($date); ?></span>

<table class="table2">

<tr>
	<th><?php echo "Date Facture";?></th>
   	<th><?php echo "Numero";?></th>
	<th><?php echo "Client";?></th>

	
</tr>

<?php 
$compteur1=0;$total_g=0;
while($users_1 = fetch_array($users11)) { 
			$date_enc=$users_1["date_enc"];$evaluation=$users_1["facture_n"];
			$client=$users_1["client"];$client_tire=$users_1["client_tire"];$vendeur=$users_1["vendeur"];$id_registre_regl=$users_1["id_registre_regl"];
			$v_banque=$users_1["v_banque"];$numero_cheque=$users_1["numero_cheque"];$total_cheque=$users_1["total_cheque"];$facture_n=$users_1["facture_n"];
			$evaluation=$users_1["evaluation"];$date_echeance=$users_1["date_echeance"];$m_cheque_g=$users_1["m_cheque_g"];
			$montant_e=$users_1["montant_e"];
			$ref=$v_banque." ".$numero_cheque;$date_cheque=dateUsToFr($users_1["date_cheque"]);$date_cheque1=$users_1["date_cheque"];
			$numero_facture=$users_1["numero_facture"];$date_facture=dateUsToFr($users_1["date_facture"]);$date_f=$users_1["date_f"];
			
			//$date_f="0000-00-00";
			$id=$users_1["id"];$facture_n=$users_1["facture_n"];$client=$users_1["client"];
			
			
			
			
			
			/*$sql  = "SELECT * ";
			$sql .= "FROM factures where client='$client' and numero='$facture_n' ORDER BY id;";
			$users111 = db_query($database_name, $sql);$user_ = fetch_array($users111);
			$date_f=$user_["date_f"];$exe="/17";
			
			if ($date_f=="0000-00-00"){
			$sql  = "SELECT * ";
			$sql .= "FROM factures2018 where client='$client' and numero='$facture_n' ORDER BY id;";
			$users111 = db_query($database_name, $sql);$user_ = fetch_array($users111);
			$date_f=$user_["date_f"];$exe="/18";}
			
			if ($date_f=="0000-00-00"){
			$sql  = "SELECT * ";
			$sql .= "FROM factures2019 where client='$client' and numero='$facture_n' ORDER BY id;";
			$users111 = db_query($database_name, $sql);$user_ = fetch_array($users111);
			$date_f=$user_["date_f"];$exe="/19";}
			
			if ($date_f=="0000-00-00"){
			$sql  = "SELECT * ";
			$sql .= "FROM factures2020 where client='$client' and numero='$facture_n' ORDER BY id;";
			$users111 = db_query($database_name, $sql);$user_ = fetch_array($users111);
			$date_f=$user_["date_f"];$exe="/20";}
			
			if ($date_f=="0000-00-00"){
			$sql  = "SELECT * ";
			$sql .= "FROM factures2021 where client='$client' and numero='$facture_n' ORDER BY id;";
			$users111 = db_query($database_name, $sql);$user_ = fetch_array($users111);
			$date_f=$user_["date_f"];$exe="/21";$client=$user_["client"];$montant_f=$user_["montant"];}
			
			//if ($date_f=="0000-00-00"){
			$sql  = "SELECT * ";
			//$sql .= "FROM factures2022 where client='$client' and numero='$facture_n' ORDER BY id;";
			$sql .= "FROM factures2022 where numero='$facture_n' ORDER BY id;";
			$users111 = db_query($database_name, $sql);$user_ = fetch_array($users111);
			$date_f=$user_["date_f"];$exe="/22";$client=$user_["client"];$montant_f=$user_["montant"];
			//}
			
			//$sql  = "SELECT * ";
			//$sql .= "FROM factures2022 where client='$client' and numero='$facture_n' ORDER BY id;";
			
			*/
			
			
			$sql  = "SELECT * ";
			$sql .= "FROM factures2024 where numero='$facture_n' ORDER BY id;";
			$users111 = db_query($database_name, $sql);$user_ = fetch_array($users111);
			$date_ff=$user_["date_f"];$exe="/24";$clientf=$user_["client"];$montant_f=$user_["montant"];
			
			
			
			
			
			if ($facture_n<10){$zero="000";}
			if ($facture_n>=10 and $facture_n<100){$zero="00";}
			if ($facture_n>=100 and $facture_n<1000){$zero="0";}
			if ($facture_n>=1000 and $facture_n<10000){$zero="";}
			
			$numero_facturef=$zero.$facture_n.$exe;
			
			$sql = "UPDATE porte_feuilles_factures SET numero_facture = '$numero_facturef' ,date_facture='$date_ff' ,client='$clientf',montant_f='$montant_f' WHERE id = '$id'";
			//$sql = "UPDATE porte_feuilles_factures SET  WHERE id = '$id'";
						db_query($database_name, $sql);
			
			
			
			
			
			?>
			
			<? echo "<tr><td>$date_ff</td><td>$clientf</td><td>$numero_facturef</td>";

			
			?>
			
		<? 
		
		

		
		
?>
<? } ?>

</table>
</strong>
<p style="text-align:center">


</body>

</html>