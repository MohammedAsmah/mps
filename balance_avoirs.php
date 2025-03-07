<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$caisse="";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	$vendeur=$_GET['vendeur'];$date=$_GET['date'];$date1=$_GET['date1'];$du=dateUsToFr($_GET['date']);$au=dateUsToFr($_GET['date1']);

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">


</head>

<body style="background:#dfe8ff">
	
	
<?			
	
	$sql  = "SELECT * ";
	$vide="";
	$sql .= "FROM porte_feuilles where (date_enc between '$date' and '$date1') and vendeur='$vendeur' and impaye=0 and m_avoir<>0 Order BY date_enc;";
	$users11 = db_query($database_name, $sql);$t_cheque=0;$t_espece=0;$t_avoir=0;
	/*while($row = fetch_array($users11))
	{	$numero_cheque = $row['numero_cheque'];$facture_n = $row['facture_n'];
		$total_cheque = $row['m_cheque'];$total_espece = $row['m_espece']-$row['m_avoir']-$row['m_diff_prix'];
		$total_effet = $row['m_effet'];$total_avoir = $row['m_avoir'];$total_diff = $row['m_diff_prix'];
		$total_virement = $row['m_virement'];$t_avoir=$t_avoir+$row['m_avoir'];
		$t_cheque=$t_cheque+$total_cheque-$total_effet-$total_virement;
		$t_espece=$t_espece+$total_espece;
	}
	*/?>


<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Avoirs $vendeur $du au $au "; ?></span>

<p style="text-align:center">


<table class="table2">

<tr>
	<th><?php echo "Tableau";?></th>
	<th><?php echo "Avoir Numero";?></th>
	<th><?php echo "Client";?></th>
	<th><?php echo "Date Enc";?></th>
	<th><?php echo "Montant Avoir";?></th>
</tr>

<?php $debit=0;$credit=0;$t=0;$s=0;
	while($row = fetch_array($users11))
	{	$numero_cheque = $row['numero_cheque'];$facture_n = $row['facture_n'];$numero_avoir = $row['numero_avoir'];
		$total_cheque = $row['m_cheque'];$total_espece = $row['m_espece']-$row['m_avoir']-$row['m_diff_prix'];
		$total_effet = $row['m_effet'];$total_avoir = $row['m_avoir'];$total_diff = $row['m_diff_prix'];
		$total_virement = $row['m_virement'];$t_avoir=$t_avoir+$row['m_avoir'];
		$t_cheque=$t_cheque+$total_cheque-$total_effet-$total_virement;
		$t_espece=$t_espece+$total_espece;
		$id_registre_regl = $row['id_registre_regl'];
		$sql1  = "SELECT * ";
		$sql1 .= "FROM registre_reglements where id='$id_registre_regl' ORDER BY id;";
		$users111 = db_query($database_name, $sql1);$users_111 = fetch_array($users111);
		$statut=$users_111["statut"];$observation=$users_111["observation"];$dest=$users_111["service"];
		$service=$users_111["service"];$code=$users_111["code_produit"];$bon=$users_111["observation"];
		$id_tableau=$users_111["bon_sortie"]."/".$users_111["mois"]."".$users_111["annee"];
		?>
		<tr><td><?php echo $id_tableau;?></td>
		<td><?php echo $numero_avoir;?></td>
		<td><?php echo $row['client'];?></td>
		<td><?php echo dateUsToFr($row['date_enc']);?></td>
		<td align="right"><?php echo number_format($row['m_avoir'],2,',',' ');?></td></tr>
		
		<?	}?>
<tr><td></td><td></td><td></td><td></td><td align="right"><?php echo number_format($t_avoir,2,',',' ');?></td>


</table>

<p style="text-align:center">

</body>

</html>