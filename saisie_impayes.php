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
			$client = $_REQUEST["client"];$date_impaye = dateFrToUs($_REQUEST["date_impaye"]);
			$m_cheque = $_REQUEST["m_cheque"];$facture = $_REQUEST["facture"];$numero_effet = $_REQUEST["numero_effet"];$date_facture = $_REQUEST["date_facture"];
			$numero_cheque = $_REQUEST["numero_cheque"];$v_banque = $_REQUEST["v_banque"];$client_tire = $_REQUEST["client_tire"];
				if ($numero_effet<>""){$m_effet=$m_cheque;$m_cheque=0;}else{$m_effet=0;}
				
				
				
				if ($date_f>="2018-01-01" and $date_f<"2019-01-01"){$factures="factures2018";$exe="/18";}
				if ($date_f>="2017-01-01" and $date_f<"2018-01-01"){$factures="factures";$exe="/17";}
				if ($date_f>="2019-01-01" and $date_f<"2020-01-01"){$factures="factures2019";$exe="/19";}
				if ($date_f>="2020-01-01" and $date_f<"2021-01-01"){$factures="factures2020";$exe="/20";}
				
				
				$sql  = "SELECT * ";
				$sql .= "FROM ".$factures." where numero='$facture' ORDER BY id;";
				$users = db_query($database_name, $sql);$row = fetch_array($users);$d=$row["date_f"];$m=$row["montant"];

		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		$v="impaye";$r_impaye=1;$remise=1;
	$sql1  = "INSERT INTO porte_feuilles_factures 
	(client ,date_impaye,r_impaye,remise,facture_n,date_f,montant_f,vendeur,m_cheque,m_effet,numero_effet,numero_cheque,v_banque,client_tire )
	VALUES ('$client','$date_impaye','$r_impaye','$remise','$facture','$d','$m','$v','$m_cheque','$m_effet','$numero_effet','$numero_cheque','$v_banque','$client_tire')";
	db_query($database_name, $sql1);
			

			break;

			case "update_user":
			$user_id=$_REQUEST["user_id"];
			$sql = "UPDATE porte_feuilles_factures SET client = '$client',date_impaye = '$date_impaye',date_f = '$date_f',facture_n = '$facture',
			montant_f = '$montant_f' , vendeur = '$v' ,m_cheque = '$m_cheque' ,numero_cheque = '$numero_cheque',v_banque = '$v_banque' 
			,client_tire = '$client_tire' WHERE id = '$user_id'";
			db_query($database_name, $sql);
			
			break;
			
			case "delete_user":
			

			// delete user's profile
			$sql = "DELETE FROM porte_feuilles_factures WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
		if(isset($_REQUEST["action"])){}else{ ?>
	<form id="form" name="form" method="post" action="saisie_impayes.php">
	<td><?php echo "Periode Impayes Du : "; ?><input type="text" id="date1" name="date1" style="width:100px" value="<?php echo $date1; ?>"></td>
	<td><?php echo "Au : "; ?><input type="text" id="date2" name="date2" style="width:100px" value="<?php echo $date2; ?>"></td>
	<input type="submit" id="action" name="action" value="<?php echo $action; ?>">
	</form>
	
	<? }

	if(isset($_REQUEST["action"]))
	{ $date=dateFrToUs($_POST['date1']);$total=0;$date2=dateFrToUs($_POST['date2']);
	
	$sql  = "SELECT * ";$v="impaye";$v1="sur compte";
	$sql .= "FROM porte_feuilles_factures where vendeur='$v' and (date_impaye between '$date' and '$date2') ORDER BY id;";
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
	function EditUser(user_id) { document.location = "saisie_impaye.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "liste Impayes Hors Compte"; ?></span>

<table class="table2">

<tr>	<th><?php echo "Mode";?></th>
	<th><?php echo "Montant";?></th>
	<th><?php echo "Banque";?></th>
	<th><?php echo "Client";?></th>
	<th><?php echo "Facture";?></th>
	<th><?php echo "Date Facture";?></th>
	<th><?php echo "Date Impaye";?></th>
	
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<? if ($users_["m_cheque"]>0){?>
<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo "CHQ. ".$users_["numero_cheque"];?></A></td>
<td><?php echo $users_["m_cheque"]; ?></td>

<? } else {?>
<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo "Effet ".$users_["numero_effet"];?></A></td>
<td><?php echo $users_["m_effet"]; ?></td>
<? } ?>

<td><?php echo $users_["v_banque"]; ?></td>
<td><?php echo $users_["client"]; ?></td>
<td><?php echo $users_["facture_n"]; ?></td>
<td><?php echo dateUsToFr($users_["date_f"]); ?></td>
<td><?php echo dateUsToFr($users_["date_impaye"]); ?></td>
<?php } ?>

</table>
<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>
<?php } ?>

</body>

</html>