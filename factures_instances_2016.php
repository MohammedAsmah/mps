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
			$date =dateFrToUs($_REQUEST["date"]);$du = $_REQUEST["du"];$au = $_REQUEST["au"];
			$client = $_REQUEST["client"];$evaluation = $_REQUEST["evaluation"];$vendeur="vv";
			if(isset($_REQUEST["sans_remise"])) { $sans_remise = 1; } else { $sans_remise = 0; }
			$remise10=$_REQUEST["remise10"];$remise2=$_REQUEST["remise2"];$remise3=$_REQUEST["remise3"];		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
		
				$sql  = "INSERT INTO factures ( date_f, client, vendeur,evaluation ) VALUES ( ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $evaluation . "');";

				db_query($database_name, $sql);
			

			break;

			case "update_user":

			$sql = "UPDATE factures SET ";
			$sql .= "date_f = '" . $date . "', ";
			$sql .= "client = '" . $client . "', ";
			$sql .= "sans_remise = '" . $sans_remise . "', ";
			$sql .= "remise_10 = '" . $remise10 . "', ";
			$sql .= "remise_2 = '" . $remise2 . "', ";
			$sql .= "remise_3 = '" . $remise3 . "', ";
			$sql .= "evaluation = '" . $evaluation . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			break;


		} //switch
	} //if
	
	
	$du="";$au="";$action="Recherche";
	
	?>
	
	<form id="form" name="form" method="post" action="factures_instances_2016.php">
	<td><?php echo "Du : "; ?><input type="text" id="du" name="du" value="<?php echo $du; ?>" size="15"></td>
	<td><?php echo "Au : "; ?><input type="text" id="au" name="au" value="<?php echo $au; ?>" size="15"></td>
	<tr>
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<?
	if(isset($_REQUEST["action"]) or isset($_REQUEST["action_"]))
	{
	 $du=dateFrToUs($_POST['du']);$au=dateFrToUs($_POST['au']);
	$sql  = "SELECT * ";
	$sql .= "FROM factures2016 where date_f between '$du' and '$au' and numero<30000 ORDER BY id;";
	$users = db_query($database_name, $sql);
	}
	else
	{
	@$du=$_GET['du'];@$au=$_GET['au'];
	$sql  = "SELECT * ";
	$sql .= "FROM factures2016 where date_f between '$du' and '$au' and numero<30000 ORDER BY id;";
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

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "facture1.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "liste Factures"; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Numero";?></th>
	<th><?php echo "Date";?></th>
	<th width="200"><?php echo "Client";?></th>
	<th width="150"><?php echo "Montant";?></th>
	<th><?php echo "Controle";?></th>
</tr>

<?php $ca=0;while($users_ = fetch_array($users)) { 

$facture=$users_["id"]+9040;$client=$users_["client"];$sans_remise=$users_["sans_remise"];$montant=$users_["montant"];
$remise10=$users_["remise_10"];$remise2=$users_["remise_2"];$remise3=$users_["remise_3"];
?>

<?	$sql1  = "SELECT * ";$qte=0;$montant=0;$total=0;
	$sql1 .= "FROM detail_factures2016 where facture='$facture' and sans_remise=0 ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users1_ = fetch_array($users1)) { 
			$qte=$qte+$users1_["quantite"];$montant=$montant+($users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"]);
	
	}
if ($sans_remise==1){$net=$montant;
 } else {

		$t=$montant;

 		$remise_1=$montant*$remise10/100; 
		$remise_2=($montant-$remise_1)*$remise2/100; 
		$remise_3=($montant-$remise_1-$remise_2)*$remise3/100; 
		$net=$montant-$remise_1-$remise_2-$remise_3; 


 }
  	$sql11  = "SELECT * ";$montant1=0;
	$sql11 .= "FROM detail_factures2016 where facture='$facture' and sans_remise=1 ORDER BY produit;";
	$users11 = db_query($database_name, $sql11);
	while($users11_ = fetch_array($users11)) { 
			$qte=$qte+$users11_["quantite"];$montant1=$montant1+($users11_["quantite"]*$users11_["prix_unit"]*$users11_["condit"]);
	
	}
	$net=$net+$montant1;

 
 
 ?>
<tr>
<? $id=$users_["id"];$facture=$users_["id"]+9040;echo "<td><a href=\"facture1.php?user_id=$id&du=$du&au=$au\">$facture</a></td>";?>
<td><?php $date=dateUsToFr($users_["date_f"]);$d=dateUsToFr($users_["date_f"]);print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$d </font>"); ?></td>
<td><?php $c=$users_["client"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$c </font>"); ?> </td>
<?php $evaluation=$users_["evaluation"]; $client=$users_["client"];?>
<td align="right" width="150"><?php $ca=$ca+$users_["montant"];$m=number_format($users_["montant"],2,',',' ');
print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$m </font>");?></td>
<td align="right" width="150"><?php $m1=number_format($net,2,',',' ');
print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$m1 </font>");?></td>
<? echo "<td><a href=\"detail_evaluation_regroupe.php?numero=$facture&client=$client\">Editer</a></td>";?>
<td align="right" width="150"><?php $diff=$net-$users_["montant"];$diff=number_format($diff,2,',',' ');
print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$diff </font>");?></td>

<?php } ?>
</table>

<p style="text-align:center">


</body>

</html>