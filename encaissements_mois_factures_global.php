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

	
	 
	$reference="";
	


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
	$total=0;
	
	$sql  = "SELECT * ";
	$sql .= "FROM porte_feuilles where (chq_f=1 or esp_f=1 or eff_f=1) and facture_n=0 and enc_facture1=0 ORDER BY date_cheque,date_echeance;";
	$users111 = db_query($database_name, $sql);
	
	
	
	
	$date_jour=date("Y-m-d");
	
	
while($users_11 = fetch_array($users111)) { 
			$ch=$users_11["numero_cheque"];$idp=$users_11["id"];
			if ($ch<>"" and $ch<>"0"){$date_reg=$users_11["date_cheque"];}
			$eff=$users_11["numero_effet"];
			if ($eff<>"" and $eff<>"0"){$date_reg=$users_11["date_echeance"];}
			$nbjours = round((strtotime($date_reg) - strtotime($date_jour))/(60*60*24)-1); 
			$sql = "UPDATE porte_feuilles SET jours = '$nbjours' WHERE id = '$idp'";
			db_query($database_name, $sql);
	
}
	
	
	
	
$sql  = "SELECT id,jours,date_remise,date_cheque,date_echeance,date_virement,date_enc,client,client_tire,client_tire_e,vendeur,numero_cheque,numero_virement,numero_effet,v_banque,facture_n,impaye,
	sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece, sum(m_effet) as total_effet, sum(m_virement) as total_virement
	,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix ";
	$sql .= "FROM porte_feuilles where (chq_f=1 or esp_f=1 or eff_f=1) and facture_n=0 and enc_facture1=0 group by id ORDER BY jours;";
	$users11 = db_query($database_name, $sql);	
	
?>


<span style="font-size:24px"><?php echo "Encaissments A facturer  : "; ?></span>

<table class="table2">

<tr>
	
	<th><?php echo "Client";?></th>
	<th><?php echo "date encaiss";?></th>
	<th><?php echo "Ref.enc";?></th>
	
	<th><?php echo "Espece";?></th>
	<th><?php echo "Effet";?></th>
	<th><?php echo "Cheque";?></th>
	<th><?php echo "Virement";?></th>
	<th><?php echo "date echeance";?></th>
	
	<th><?php echo "Jours";?></th>
	
</tr>

<?php $compteur1=0;$total_g=0;$total_e=0;$total_c=0;$total_t=0;$total_ee=0;$d="";
while($users_1 = fetch_array($users11)) { $date_enc=$users_1["date_enc"];$vendeur=$users_1["vendeur"];$impaye=$users_1["impaye"];$ch=$users_1["numero_cheque"];$jours=$users_1["jours"];
			$id_porte_feuille=$users_1["id"];
			if ($ch<>"" and $ch<>"0"){$ch="Chq/".$ch;$de=dateUsToFr($users_1["date_cheque"]);$date_reg=$users_1["date_cheque"];}else{$ch="";}
			$eff=$users_1["numero_effet"];
			if ($eff<>"" and $eff<>"0"){$eff="Eff/".$eff;$de=dateUsToFr($users_1["date_echeance"]);$date_reg=$users_1["date_echeance"];}else{$eff="";}
			$vir=$users_1["numero_cheque_v"];
			if ($vir<>"" and $vir<>"0"){$vir="Vir/".$vir;$de=dateUsToFr($users_1["date_virement"]);}else{$vir="";}
			$ref=$ch." ".$eff;$facture_n=$users_1["facture_n"];$date_remise=$users_1["date_remise"];$id=$users_1["id"];$date_virement=$users_1["date_virement"];
			$client=$users_1["client"];$client_tire=$users_1["client_tire"];$client_tire_e=$users_1["client_tire_e"];$date_cheque=$users_1["date_cheque"];
			$client=$users_1["client"];$total_e=$users_1["total_e"];$total_avoir=$users_1["total_avoir"];$date_echeance=$users_1["date_echeance"];
			$total_cheque=$users_1["total_cheque"];$total_espece=$users_1["total_espece"];$total_effet=$users_1["total_effet"];$total_virement=$users_1["total_virement"];
			$total_diff_prix=$users_1["total_diff_prix"];
	$sql  = "SELECT * ";
	$sql .= "FROM clients where client='$client' ORDER BY id;";
	$users111 = db_query($database_name, $sql);$user_ = fetch_array($users111);
		$inputation=$user_["inputation"];$patente=$user_["patente"];
				
				$sql  = "SELECT * ";
				$sql .= "FROM factures2020 where numero='$facture_n' ORDER BY id;";
				$users = db_query($database_name, $sql);$row = fetch_array($users);$d=$row["date_f"];$date_aout="2010-08-01";

				$date_jour=date("Y-m-d");
				$nbjours = round((strtotime($date_reg) - strtotime($date_jour))/(60*60*24)-1); 
				
				
			?>

			<? echo "<tr><td>$client</td>";?>
			
			<td><?php $d1= dateUsToFr($date_enc);print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$d1 </font>"); ?></td>
			<td><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$ref </font>"); ?></td>
			
			
			<td align="right"><?php $total_c=$total_c+$total_cheque;$tchq=number_format($total_espece,2,',',' ');
			print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$tchq </font>");
			 ?></td>
			
			
			
			<td align="right"><?php $total_c=$total_c+$total_cheque;$tchq=number_format($total_effet,2,',',' ');
			print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$tchq </font>");
			 ?></td>
			 		
			
			<td align="right"><?php $total_c=$total_c+$total_cheque;$tchq=number_format($total_cheque,2,',',' ');
			print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$tchq </font>");
			 ?></td>
			  <td align="right"><?php $total_v=$total_v+$total_virement;$tchq=number_format($total_virement,2,',',' ');
			print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$tchq </font>");
			 ?>
			 </td>
			 <td><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$de </font>"); ?></td>
				<? if ($jours<60){?>
			 <td bgcolor="#33CCFF"><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$jours </font>"); ?></td>
				<? } else {?>
				<td><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$jours </font>"); ?></td>
				<? } ?>		
<? 



} 




?>

			
</table>
</strong>
<p style="text-align:center">


<? ?>
</body>

</html>