<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	require "chiffres_lettres.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$mois="";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	
	
	//regroupement menu
	if(isset($_REQUEST["action_22"]) ) { $s_controle_2=1;$mois=$_REQUEST["mois"];
			$sql = "UPDATE factures2016 SET ";
			$sql .= "s_controle = '" . $s_controle_2 . "' ";	
			$sql .= "WHERE numero = " . $_REQUEST["numero"] . ";";
			db_query($database_name, $sql);
		}
	
	
	if(isset($_REQUEST["action_2"]) ) { 
		if($_REQUEST["action_2"] != "delete_user") {
			// prepares data to simplify database insert or update
			$date =dateFrToUs($_REQUEST["date"]);
			$client = $_REQUEST["client"];$evaluation = $_REQUEST["evaluation"];$vendeur="vv";
			if(isset($_REQUEST["sans_remise"])) { $sans_remise = 1; } else { $sans_remise = 0; }
			if(isset($_REQUEST["editee"])) { $editee = 1; } else { $editee = 0; }
			if(isset($_REQUEST["s_controle"])) { $s_controle = 1; } else { $s_controle = 0; }
			if(isset($_REQUEST["ht"])) { $ht = 1; } else { $ht = 0; }
		$remise10=$_REQUEST["remise10"];$remise2=$_REQUEST["remise2"];$remise3=$_REQUEST["remise3"];
		}
		
		
		
		
		
		
		switch($_REQUEST["action_2"]) {

			case "insert_new_user":
		
				/*$sql  = "INSERT INTO factures2016 ( date_f, client, vendeur,evaluation ) VALUES ( ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $evaluation . "');";*/

				db_query($database_name, $sql);
			

			break;

			case "update_user":
			$sql = "UPDATE factures2016 SET ";
			$sql .= "date_f = '" . $date . "', ";
			$sql .= "client = '" . $client . "', ";
			$sql .= "sans_remise = '" . $sans_remise . "', ";
			$sql .= "remise_10 = '" . $remise10 . "', ";
			$sql .= "remise_2 = '" . $remise2 . "', ";
			$sql .= "remise_3 = '" . $remise3 . "', ";
			$sql .= "ht = '" . $ht . "', ";
			$sql .= "editee = '" . $editee . "', ";	
			$sql .= "s_controle = '" . $s_controle . "', ";	
			$sql .= "montant = '" . $_REQUEST["montant"] . "', ";
			$sql .= "evaluation = '" . $evaluation . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			break;


		} //switch
		} //if isset
	//
	
	
	
	
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$date =dateFrToUs($_REQUEST["date"]);
			$client = $_REQUEST["client"];$evaluation = $_REQUEST["evaluation"];$vendeur="vv";
			
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
		
				/*$sql  = "INSERT INTO factures2016 ( date_f, client, vendeur,evaluation ) VALUES ( ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $evaluation . "');";

				db_query($database_name, $sql);*/
			

			break;

			case "update_user":

			$sql = "UPDATE factures2016 SET ";
			$sql .= "date_f = '" . $date . "', ";
			$sql .= "client = '" . $client . "', ";
			$sql .= "evaluation = '" . $evaluation . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			break;


		} //switch
	} //if
	

	$du="";$au="";$action="Recherche";
	$profiles_list_mois = "";
	$sql1 = "SELECT * FROM mois_rak_08 ORDER BY id;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($mois == $temp_["mois"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_mois .= "<OPTION VALUE=\"" . $temp_["mois"] . "\"" . $selected . ">";
		$profiles_list_mois .= $temp_["mois"];
		$profiles_list_mois .= "</OPTION>";
	}
	

	?>
	
	<form id="form" name="form" method="post" action="edition_factures.php">
	<td><?php echo "Mois : "; ?></td><td><select id="mois" name="mois"><?php echo $profiles_list_mois; ?></select>
	<td><?php $annee="2016";echo "Annee : "; ?><input type="text" id="annee" name="annee" value="<?php echo $annee; ?>" size="15"></td>
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<?
	if(isset($_REQUEST["action"]))
	{
	 $mois=$_POST['mois']; $annee=$_POST['annee'];
	if (isset($_REQUEST["mois"])){
		if ($annee=="2008")
		{
		$sql  = "SELECT * ";
		$sql .= "FROM mois_rak_08 WHERE mois ='$mois';";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$du = $user_["du"];
		$au = $user_["au"];
		}
		if ($annee=="2009")
		{
		$sql  = "SELECT * ";
		$sql .= "FROM mois_rak_09 WHERE mois ='$mois';";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$du = $user_["du"];
		$au = $user_["au"];
		}
		if ($annee=="2010")
		{
		$sql  = "SELECT * ";
		$sql .= "FROM mois_rak_10 WHERE mois ='$mois';";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$du = $user_["du"];
		$au = $user_["au"];
		}
		if ($annee=="2011")
		{
		$sql  = "SELECT * ";
		$sql .= "FROM mois_rak_11 WHERE mois ='$mois';";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$du = $user_["du"];
		$au = $user_["au"];
		}
		if ($annee=="2012")
		{
		$sql  = "SELECT * ";
		$sql .= "FROM mois_rak_12 WHERE mois ='$mois';";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$du = $user_["du"];
		$au = $user_["au"];
		}
		
		if ($annee=="2013")
		{
		$sql  = "SELECT * ";
		$sql .= "FROM mois_rak_13 WHERE mois ='$mois';";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$du = $user_["du"];
		$au = $user_["au"];
		}
		if ($annee=="2014")
		{
		$sql  = "SELECT * ";
		$sql .= "FROM mois_rak_14 WHERE mois ='$mois';";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$du = $user_["du"];
		$au = $user_["au"];
		}
		if ($annee=="2015")
		{
		$sql  = "SELECT * ";
		$sql .= "FROM mois_rak_15 WHERE mois ='$mois';";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$du = $user_["du"];
		$au = $user_["au"];
		}
		if ($annee=="2016")
		{
		$sql  = "SELECT * ";
		$sql .= "FROM mois_rak_16 WHERE mois ='$mois';";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$du = $user_["du"];
		$au = $user_["au"];
		}
		
		
	}
	
	
	$sql  = "SELECT * ";
	$sql .= "FROM factures2016 where (date_f between '$du' and '$au') and id<12230  ORDER BY id;";
	$users = db_query($database_name, $sql);
	
	
	}
	else
	{
	@$du=$_GET['du'];@$au=$_GET['au'];
	$sql  = "SELECT * ";
	$sql .= "FROM factures2016 where (date_f between '$du' and '$au') and id<12230  ORDER BY id;";
	$users = db_query($database_name, $sql);
	}
	if(isset($_REQUEST["action_2"]))
	{
	 $du=$_POST['du'];$au=$_POST['au'];
	$sql  = "SELECT * ";
	$sql .= "FROM factures2016 where (date_f between '$du' and '$au') and id<12230 ORDER BY id;";
	$users = db_query($database_name, $sql);
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Factures"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">


</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "liste Factures"; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Numero";?></th>
	<th><?php echo "Numero";?></th>
	<th><?php echo "Date";?></th>
	<th width="200"><?php echo "Client";?></th>
	<th><?php echo "Evaluations";?></th>
	<th width="150"><?php echo "Montant";?></th>
	<th><?php echo "Impression";?></th>
	<th><?php echo "Valide";?></th>
</tr>

<?php $ca=0;while($users_ = fetch_array($users)) { ?><tr>
<?
		/*$produit=$users_["produit"];$user_id=$users_["id"];
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE ref = '$produit' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$pr = $user_["produit"];
			$sql = "UPDATE detail_commandes_07 SET ";
			$sql .= "produit = '" . $pr . "' ";
			$sql .= "WHERE id = " . $user_id . ";";
			db_query($database_name, $sql);
			?><td><? echo $produit;?></td></tr><?*/
			
			$client=$users_["client"];$user_id=$users_["id"];$date_f=$users_["date_f"];$date_ff="2010-12-31";$net=number_format($users_["montant"],2,',',' ');
			///lettres

			$lettres=int2str($net);


			$sql = "UPDATE factures2016 SET ";
			$sql .= "lettres = '" . $lettres . "' ";
			$sql .= "WHERE id = " . $user_id . ";";
			db_query($database_name, $sql);
			
			
			


?>
<? if ($users_["valide"]==1){?>
<? $facture=$users_["id"]+9040;$client=$users_["client"];$m=$users_["montant"];$user_id=$users_["id"];
if ($users_["editee"]<>1 ){if ($users_["s_controle"]==1 ) {$f= "<td align=\"center\" bgcolor=\"#FFFF00\"><a href=\"maj_factures.php?mois=$mois&montant=$m&numero=$facture&client=$client\">$facture</a></td>";
print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$f </font>");
}
else {$f= "<td align=\"center\"><a href=\"maj_factures.php?mois=$mois&montant=$m&numero=$facture&client=$client\">$facture</a></td>";
print("<font size=\"1\" face=\"Comic sans MS\" color=\"FFFF00\">$f </font>");
}
}else {echo "<td>$facture</td>";}?>
<? echo "<td><a href=\"facture11.php?user_id=$user_id&client=$client&facture=$facture&du=$du&au=$au\">$facture</a></td>";?>

<td><?php $date=dateUsToFr($users_["date_f"]);$d=dateUsToFr($users_["date_f"]);print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$d </font>"); ?></td>
<td><?php $c=$users_["client"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$c </font>"); ?> </td>
<td><?php $e=$users_["evaluation"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$e </font>"); ?> </td>
<td align="right" width="150"><?php $ca=$ca+$users_["montant"];$m=number_format($users_["montant"],2,',',' ');
print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$m </font>");
 ?></td>
<? echo "<td><a href=\"\\mps\\tutorial\\imprimer_facture.php?numero=$facture&client=$client&id=$user_id\">Imprimer</a></td>";?>
<td><?php if ($users_["valide"]==1){$oui="oui";print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$oui </font>");
}else{$non="non";print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$non </font>");
} ?></td>
<? } else {?>
<? $facture=$users_["id"]+9040;$client=$users_["client"];$m=$users_["montant"];$user_id=$users_["id"];
if ($users_["editee"]<>1 ){if ($users_["s_controle"]==1 ) {$f= "<td align=\"center\" bgcolor=\"#FFFF00\"><a href=\"maj_factures.php?mois=$mois&montant=$m&numero=$facture&client=$client\">$facture</a></td>";
print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$f </font>");
}
else {$f= "<td align=\"center\"><a href=\"maj_factures.php?mois=$mois&montant=$m&numero=$facture&client=$client\">$facture</a></td>";
print("<font size=\"1\" face=\"Comic sans MS\" color=\"FFFF00\">$f </font>");
}
}else {echo "<td>$facture</td>";}?>
<? echo "<td><a href=\"facture11.php?user_id=$user_id&client=$client&facture=$facture&du=$du&au=$au\">$facture</a></td>";?>
<td><?php $date=dateUsToFr($users_["date_f"]);$d=dateUsToFr($users_["date_f"]);print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$d </font>"); ?></td>
<td><?php $c=$users_["client"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$c </font>"); ?> </td>
<td><?php $e=$users_["evaluation"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$e </font>"); ?> </td>
<td align="right" width="150"><?php $ca=$ca+$users_["montant"];$m=number_format($users_["montant"],2,',',' ');
print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$m </font>");
 ?></td>
<? echo "<td><a href=\"\\mps\\tutorial\\imprimer_facture.php?numero=$facture&client=$client&id=$user_id\">Imprimer</a></td>";?>
<td><?php if ($users_["valide"]==1){$oui="oui";print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$oui </font>");
}else{$non="non";print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$non </font>");
} ?></td>
<? }?>

<?php } ?>
<tr><td></td><td></td><td></td><td></td><td></td>
<td align="right"><?php $ca=number_format($ca,2,',',' '); print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$ca </font>");?></td><td></td><td></td><td></td></tr>
</table>

<p style="text-align:center">


</body>

</html>