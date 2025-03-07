<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$action="Recherche";$date1="";$date2="";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$client = $_REQUEST["client"];$date_enc = dateFrToUs($_REQUEST["date_enc"]);$facture = $_REQUEST["facture"];$date_f = dateFrToUs($_REQUEST["date_f"]);
			
	if ($date_f>="2018-01-01" and $date_f<"2019-01-01"){$exe="/18";}
	if ($date_f>="2017-01-01" and $date_f<"2018-01-01"){$exe="/17";}
	if ($date_f>="2019-01-01" and $date_f<"2020-01-01"){$exe="/19";}
	if ($date_f>="2020-01-01" and $date_f<"2021-01-01"){$exe="/20";}
	
	if ($facture<10){$zero="000";}
	if ($facture>=10 and $facture<100){$zero="00";}
	if ($facture>=100 and $facture<1000){$zero="0";}
	if ($facture>=1000 and $facture<10000){$zero="";}

	$facture1=$zero.$facture.$exe;
			
			$montant_f = $_REQUEST["montant_f"];$m_espece = $_REQUEST["m_espece"];
					if(isset($_REQUEST["locked"])) { $locked = 1;$v="sur compte"; } else { $locked = 0;$v="hors compte"; }

		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		$v="hors compte";
	$sql1  = "INSERT INTO porte_feuilles_factures 
	(client ,date_enc,facture_n,date_f,montant_f,vendeur,m_espece,numero_facture,date_facture )
	VALUES ('$client','$date_enc','$facture','$date_f','$montant_f','$v','$m_espece','$facture1','$date_f')";
	db_query($database_name, $sql1);
			

			break;

			case "update_user":
			$user_id=$_REQUEST["user_id"];
			$sql = "UPDATE porte_feuilles_factures SET client = '$client',date_enc = '$date_enc',date_f = '$date_f',facture_n = '$facture',numero_facture = '$facture1',date_facture = '$date_f',
			montant_f = '$montant_f' , vendeur = '$v' ,m_espece = '$m_espece' WHERE id = '$user_id'";
			db_query($database_name, $sql);
			
			break;
			
			case "delete_user":
			

			// delete user's profile
			$sql = "DELETE FROM porte_feuilles_factures WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	

	$total=0;
	
		
	$sql  = "SELECT * ";$v="hors compte";$v1="sur compte";$dd="2021-12-31";
	$sql .= "FROM porte_feuilles_factures where (vendeur='$v' or vendeur='$v1') and date_f>'$dd' ORDER BY date_enc DESC;";
	$users = db_query($database_name, $sql);
	
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste "; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "saisie_reglement.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>
<p style="text-align:center">
<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>
<span style="font-size:24px"><?php echo "liste Reglements Hors Compte"; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Client";?></th>
	<th><?php echo "Facture";?></th>
	<th><?php echo "Date Facture";?></th>
	<th><?php echo "Date Enc";?></th>
	<th><?php echo "Espece";?></th>
	
</tr>

<?php $m=0;while($users_ = fetch_array($users)) { ?><tr>
<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["client"];?></A></td>
<td><?php if($users_["numero_facture"]<>""){echo $users_["numero_facture"];}else {echo $users_["facture_n"];} ?></td>
<td><?php echo dateUsToFr($users_["date_f"]); ?></td>
<td><?php echo dateUsToFr($users_["date_enc"]); ?></td>
<td align="right"><?php $e= $users_["m_espece"];$m=$m+$users_["m_espece"];echo number_format($e,2,',',' ') ?></td>
<?php 

$client = $users_["client"];
		$facture = $users_["facture_n"];$date_enc = $users_["date_enc"];$date_f = $users_["date_f"];
		$m_espece = $users_["m_espece"];$montant_f = $users_["montant_f"];$vendeur = $users_["vendeur"];

/*$sql1  = "INSERT INTO porte_feuilles_factures 
	(client ,date_enc,facture_n,date_f,montant_f,vendeur,m_espece )
	VALUES ('$client','$date_enc','$facture','$date_f','$montant_f','$vendeur','$m_espece')";
	db_query($database_name, $sql1);*/


} ?>
<tr><td></td><td></td><td></td><td></td>
<td align="right"><?php echo number_format($m,2,',',' '); ?></td>
</table>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>

</body>

</html>