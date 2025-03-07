<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$caisse="";$action="Recherche";
	$date1=$_GET['date1'];$date2=$_GET['date2'];$vendeur=$_GET['vendeur'];
				

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
	
				
	?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Encaissements / Evaluations / $vendeur $du au $au"; ?></span>

<p style="text-align:center">


<table class="table2">

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
	$sql .= "FROM journal_commissions where vendeur='$vendeur' Group BY id;";
	$users222 = db_query($database_name, $sql);
	while($row222 = fetch_array($users222))
	{	
		
		$vendeur=$row222['vendeur'];
		
		
		$total_evaluations = $row222['total_evaluations'];$tev=$tev+$total_evaluations;
		?>
		<? 
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
	<th><?php echo "Client";?></th>	<th><?php echo "Vendeur";?></th>

	<th><?php echo "Montant";?></th>
</tr>

<?php $compteur1=0;$total_g=0;

	$sql  = "SELECT * ";$espece="ESPECE";$vide="0000-00-00";$total=0;
	$sql .= "FROM porte_feuilles where vendeur='$vendeur' and date_enc between '$date1' and '$date2' and date_e='$vide' and m_cheque<>0 and montant_f=0 ORDER BY id_registre_regl;";
	$users112 = db_query($database_name, $sql);
while($users_12 = fetch_array($users112)) { $id_r=$users_1["id"];$date_enc=$users_12["date_enc"];$vendeur=$users_12["vendeur"];
			$client=$users_12["client"];$evaluation=$users_12["evaluation"];$facture_n=$users_12["facture_n"];$id_regl=$users_1["id_registre_regl"];
			$mode=$users_1["mode"];$valeur=$users_1["valeur"];$v_banque=$users_1["v_banque"];$numero_cheque=$users_1["numero_cheque"];
			$ref=$v_banque." ".$numero_cheque;$date_e=$users_1["date_e"];
			?>
			<tr><td><?php echo dateUsToFr($users_12["date_enc"]); ?></td>
			<td><?php echo $client; ?></td>
			<td><?php echo $vendeur; ?></td>
			<td align="right"><?php $total_cheque=$users_12["m_cheque"];echo number_format($total_cheque,2,',',' ') ?></td>
<? } ?>

</table>


<p style="text-align:center">

</body>

</html>