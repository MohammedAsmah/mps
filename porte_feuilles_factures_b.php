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
	$b="BERRADA TAIB";
	
	$sql  = "SELECT id,date_enc,date_cheque,client,client_tire,v_banque,numero_cheque,sum(m_cheque) As total_cheque ";
	$sql .= "FROM porte_feuilles where client='$b' GROUP BY client_tire;";
	$users11 = db_query($database_name, $sql);
	
	/*$sql  = "SELECT id,date_enc,evaluation,facture_n,date_cheque,client,client_tire,v_banque,numero_cheque,sum(m_cheque) As total_cheque ";
	$sql .= "FROM porte_feuilles where date_e='$vide' GROUP BY id;";
	$users11 = db_query($database_name, $sql);*/
	
	
?>


<span style="font-size:24px"><?php echo "Porte Feuilles au : ".dateUsToFr($date); ?></span>

<table class="table2">

<tr>
	<th><?php echo "Client tire";?></th>
   	<th><?php echo "Montant Total";?></th>

	
</tr>

<?php 
$compteur1=0;$total_g=0;
while($users_1 = fetch_array($users11)) { 
			$date_enc=$users_1["date_enc"];$evaluation=$users_1["facture_n"];$id=$users_1["id"];
			$client=$users_1["client"];$client_tire=$users_1["client_tire"];
			$v_banque=$users_1["v_banque"];$numero_cheque=$users_1["numero_cheque"];$total_cheque=$users_1["total_cheque"];
			$ref=$v_banque." ".$numero_cheque;$date_cheque=dateUsToFr($users_1["date_cheque"]);$date_cheque1=$users_1["date_cheque"];?>
			<? echo "<tr><td><a href=\"porte_feuilles_details1.php?date_cheque=$date_cheque1\">$client_tire</a></td>";?>
			<td align="right"><?php $total_g=$total_g+$total_cheque;echo number_format($total_cheque,2,',',' ');?></td></tr>
		<? 
		
		/*$sql  = "SELECT * ";$du="2009-06-01";$au="2010-12-31";$v="";
		$sql .= "FROM factures WHERE numero = '$evaluation' ;";
		$userp = db_query($database_name, $sql);
		$user_a = fetch_array($userp);
		$date_e = $user_a["date_f"];
					$sql = "UPDATE porte_feuilles SET ";
			$sql .= "date_e = '" . $date_e . "' ";
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);*/

		
		
?>
<? } ?>
<tr><td></td><td align="right"><? $m=number_format($total_g,2,',',' ');echo "<a href=\"cheques_non_remis.php\">$m</a></td>";?>
<tr><? echo "<td><a href=\"\\mps\\tutorial\\porte_feuilles_facture.php\">Imprimer</a></td>";?>

</table>
</strong>
<p style="text-align:center">


</body>

</html>