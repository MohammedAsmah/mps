<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$date =dateFrToUs($_REQUEST["date"]);
			$client = $_REQUEST["client"];$evaluation = $_REQUEST["evaluation"];$vendeur="vv";
			if(isset($_REQUEST["sans_remise"])) { $sans_remise = 1; } else { $sans_remise = 0; }
		$remise10=$_REQUEST["remise10"];$remise2=$_REQUEST["remise2"];$remise3=$_REQUEST["remise3"];
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
		
				$sql  = "INSERT INTO factures_pro ( date_f, client, vendeur,evaluation ) VALUES ( ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $evaluation . "');";

				db_query($database_name, $sql);
			

			break;

			case "update_user":
			$sql = "UPDATE factures_pro SET ";
			$sql .= "date_f = '" . $date . "', ";
			$sql .= "client = '" . $client . "', ";
			$sql .= "sans_remise = '" . $sans_remise . "', ";
			$sql .= "remise_10 = '" . $remise10 . "', ";
			$sql .= "remise_2 = '" . $remise2 . "', ";
			$sql .= "remise_3 = '" . $remise3 . "', ";
			$sql .= "montant = '" . $_REQUEST["montant"] . "', ";
			$sql .= "evaluation = '" . $evaluation . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			break;


		} //switch
	} //if
	
	$du="";$au="";$action="Recherche";
	$profiles_list_mois = "";$mois="";
	$sql1 = "SELECT * FROM mois_rak ORDER BY id;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($mois == $temp_["mois"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_mois .= "<OPTION VALUE=\"" . $temp_["mois"] . "\"" . $selected . ">";
		$profiles_list_mois .= $temp_["mois"];
		$profiles_list_mois .= "</OPTION>";
	}
	
	
	?>
	
	<form id="form" name="form" method="post" action="factures_pro.php">
	<td><?php echo "Mois : "; ?></td><td><select id="mois" name="mois"><?php echo $profiles_list_mois; ?></select>
	<? /*
	<td><?php echo "Du : "; ?><input type="text" id="du" name="du" value="<?php echo $du; ?>" size="15"></td>
	<td><?php echo "Au : "; ?><input type="text" id="au" name="au" value="<?php echo $au; ?>" size="15"></td>
	<tr>
	*/?>
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<?
	if(isset($_REQUEST["action"]))
	{
	 /*$du=dateFrToUs($_POST['du']);$au=dateFrToUs($_POST['au']);*/
	 $mois=$_POST['mois'];
	if (isset($_REQUEST["mois"])){
		$sql  = "SELECT * ";
		$sql .= "FROM mois_rak WHERE mois ='$mois';";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$du = $user_["du"];
		$au = $user_["au"];/*$du = "2007-01-01";$au = "2007-12-31";*/
	}
	
	$sql  = "SELECT * ";
	$sql .= "FROM factures_pro where date_f between '$du' and '$au' ORDER BY id;";
	$users = db_query($database_name, $sql);
	}
	else
	{
	@$du=$_GET['du'];@$au=$_GET['au'];
	$sql  = "SELECT * ";
	$sql .= "FROM factures_pro where date_f between '$du' and '$au' ORDER BY id;";
	$users = db_query($database_name, $sql);
	}
	if(isset($_REQUEST["action_"]))
	{
	 $du=$_POST['du'];$au=$_POST['au'];
	$sql  = "SELECT * ";
	$sql .= "FROM factures_pro where date_f between '$du' and '$au' ORDER BY id;";
	$users = db_query($database_name, $sql);
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Evaluations"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "facture_pro.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "liste Evaluations"; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Compteur";?></th>
	<th><?php echo "Evaluation";?></th>
	<th><?php echo "Date";?></th>
	<th width="200"><?php echo "Client";?></th>
	<th width="150"><?php echo "Montant";?></th>
	<th><?php echo "Valide";?></th>
	<th><?php echo "Regrouper";?></th>
</tr>

<?php $ca=0;while($users_ = fetch_array($users)) { ?><tr>

<? $client=$users_["client"];$id=$users_["id"];$f=$users_["numero"];$d=$users_["date_f"];$client_se=Trim($client);

	/*$sql1  = "SELECT * ";$f1=$users_["id"]+9040;
	$sql1 .= "FROM detail_factures where facture='$f1' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { $id1=$users1_["id"];
			$sql = "UPDATE detail_factures SET ";
			$sql .= "date_f = '" . $d . "' ";
			$sql .= "WHERE id = " . $id1 . ";";
			db_query($database_name, $sql);}*/
			
			


?>

<? if ($users_["valide"]==1){?>
<?php $evaluation=$users_["evaluation"]; $client=$users_["client"];$user_id=$users_["id"];$facture=$users_["id"];$evaluation=$users_["evaluation"];?>
<td bgcolor="#33CCFF"><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$facture </font>"); ?> </td>
<? echo "<td><a href=\"facture_pro.php?user_id=$user_id&client=$client&facture=$facture&du=$du&au=$au\">$evaluation</a></td>";?>
<td bgcolor="#33CCFF"><?php $date=dateUsToFr($users_["date_f"]);$d=dateUsToFr($users_["date_f"]);print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$d </font>"); ?></td>
<td bgcolor="#33CCFF"><?php $c=$users_["client"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$c </font>"); ?> </td>
<?php  $client=$users_["client"];?>
<td bgcolor="#33CCFF" align="right" width="150"><?php $ca=$ca+$users_["montant"];$m=number_format($users_["montant"],2,',',' ');
print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$m </font>");
 ?></td>
<td bgcolor="#33CCFF"><?php if ($users_["valide"]==1){$oui="oui";print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$oui </font>");
}else{$non="non";print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$non </font>");
} ?></td>
<? echo "<td><a href=\"detail_evaluation_regroupe.php?numero=$facture&client=$client\">Regrouper</a></td>";?>
<? } else {?>
<?php $evaluation=$users_["evaluation"]; $client=$users_["client"];$user_id=$users_["id"];$facture=$users_["id"];?>
<td><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$facture </font>"); ?> </td>
<? echo "<td><a href=\"facture_pro.php?user_id=$user_id&client=$client&facture=$facture&du=$du&au=$au\">$evaluation</a></td>";?>
<td><?php $date=dateUsToFr($users_["date_f"]);$d=dateUsToFr($users_["date_f"]);print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$d </font>"); ?></td>
<td><?php $c=$users_["client"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$c </font>"); ?> </td>
<?php $evaluation=$users_["evaluation"]; $client=$users_["client"];?>
<td align="right" width="150"><?php $ca=$ca+$users_["montant"];$m=number_format($users_["montant"],2,',',' ');
print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$m </font>");
 ?></td>
<td><?php if ($users_["valide"]==1){$oui="oui";print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$oui </font>");
}else{$non="non";print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$non </font>");
} ?></td>
<? echo "<td><a href=\"detail_evaluation_regroupe.php?numero=$facture&client=$client\">Regrouper</a></td>";?>
<? }?>

<?php } ?>
<tr><td></td><td></td><td></td><td></td>
<td align="right"><?php $ca=number_format($ca,2,',',' '); print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$ca </font>");?></td><td></td><td></td><td></td></tr>
</table>

<p style="text-align:center">


</body>

</html>