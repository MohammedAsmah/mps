<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$date="";$date_f="";$vendeur="";$remise_1=0;$remise_2=0;$remise_3=0;
		$date="";$action="Recherche";	
	$profiles_list_vendeur = "";$vendeur="";

	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"])) { 

		if($_REQUEST["action_"] != "delete_user") 
		
		{$date = dateFrToUs($_REQUEST["date"]);$date_f = dateFrToUs($_REQUEST["date"]);
		
			
			// prepares data to simplify database insert or update
			$be = $_REQUEST["be"];$vendeur = $_REQUEST["vendeur"];
			$client1 = $_REQUEST["client1"];
			$client2 = $_REQUEST["client2"];
			$client3 = $_REQUEST["client3"];
			$client4 = $_REQUEST["client4"];
			$client5 = $_REQUEST["client5"];
			$client6 = $_REQUEST["client6"];
			$client7 = $_REQUEST["client7"];
			$client8 = $_REQUEST["client8"];
			$client9 = $_REQUEST["client9"];
			$client10 = $_REQUEST["client10"];
			$client11 = $_REQUEST["client11"];
			$client12 = $_REQUEST["client12"];
			$client13 = $_REQUEST["client13"];
			$client14 = $_REQUEST["client14"];
			$client15 = $_REQUEST["client15"];
			
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
				
				$encours="encours";
				$sql  = "INSERT INTO avoirs_vendeurs (date_e,be,client1,client2,client3,client4,client5,
				client6,client7,client8,client9,client10,client11,client12,client13,client14,client15,vendeur ) VALUES ( ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $be . "', ";
				$sql .= "'" . $client1 . "', ";
				$sql .= "'" . $client2 . "', ";
				$sql .= "'" . $client3 . "', ";
				$sql .= "'" . $client4 . "', ";
				$sql .= "'" . $client5 . "', ";
				$sql .= "'" . $client6 . "', ";
				$sql .= "'" . $client7 . "', ";
				$sql .= "'" . $client8 . "', ";
				$sql .= "'" . $client9 . "', ";
				$sql .= "'" . $client10 . "', ";
				$sql .= "'" . $client11 . "', ";
				$sql .= "'" . $client12 . "', ";
				$sql .= "'" . $client13 . "', ";
				$sql .= "'" . $client14 . "', ";
				$sql .= "'" . $client15 . "', ";
				
				$sql .= "'" . $vendeur . "');";

				db_query($database_name, $sql);
		
		
		//retour à liste triée par date
		$date=$_POST['date'];$action="recherche";
					

			break;

			case "update_user":
			
			$sql = "UPDATE avoirs_vendeurs SET ";
			$sql .= "date_e = '" . $date . "', ";
			$sql .= "be = '" . $be . "', ";
			$sql .= "client1 = '" . $client1 . "', ";
			$sql .= "client2 = '" . $client2 . "', ";
			$sql .= "client3 = '" . $client3 . "', ";
			$sql .= "client4 = '" . $client4 . "', ";
			$sql .= "client5 = '" . $client5 . "', ";
			$sql .= "client6 = '" . $client6 . "', ";
			$sql .= "client7 = '" . $client7 . "', ";
			$sql .= "client8 = '" . $client8 . "', ";
			$sql .= "client9 = '" . $client9 . "', ";
			$sql .= "client10 = '" . $client10 . "', ";
			$sql .= "client11 = '" . $client11 . "', ";
			$sql .= "client12 = '" . $client12 . "', ";
			$sql .= "client13 = '" . $client13 . "', ";
			$sql .= "client14 = '" . $client14 . "', ";
			$sql .= "client15 = '" . $client15 . "', ";
			
			$sql .= "vendeur = '" . $vendeur . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);

			//revenir à liste
			$date=$_POST['date'];$action="recherche";
			


			break;
			
			case "delete_user":
			$sql  = "SELECT * ";
			$sql .= "FROM avoirs_vendeurs WHERE id = " . $_REQUEST["user_id"] . ";";
			$user = db_query($database_name, $sql); $users_ = fetch_array($user);
			$commande=$users_["commande"];
			$sql = "DELETE FROM avoirs_vendeurs WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
				
			break;


		} //switch
	} //if
	}

	
	$profiles_list_vendeur;
	$sql1 = "SELECT * FROM vendeurs ORDER BY vendeur;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($vendeur == $temp_["vendeur"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_vendeur .= "<OPTION VALUE=\"" . $temp_["vendeur"] . "\"" . $selected . ">";
		$profiles_list_vendeur .= $temp_["vendeur"];
		$profiles_list_vendeur .= "</OPTION>";
	}
	$destination="";
		if(isset($_REQUEST["action"])){}else{
	?>
	<form id="form" name="form" method="post" action="be_avoirs.php">
	<table><td><?php echo "Date: "; ?><input onClick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" />
	<td><?php echo "vendeur: "; ?></td><td><select id="vendeur" name="vendeur"><?php echo $profiles_list_vendeur; ?></select></td>
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }
	if(isset($_REQUEST["action"]))
	{$date=dateFrToUs($_POST['date']);$date_f=dateFrToUs($_POST['date']);$vendeur=$_POST['vendeur'];
	$destination=$_POST['destination'];
		
		$sql  = "SELECT * ";
		$sql .= "FROM avoirs_vendeurs where vendeur='$vendeur' and date_e='$date' ORDER BY date_e;";
		$users = db_query($database_name, $sql);
		}
		
		else
			
		{
		@$vendeur=$_GET['vendeur'];@$date=$_GET['date'];
		$sql  = "SELECT * ";
		$sql .= "FROM avoirs_vendeurs where vendeur='$vendeur' and date_e='$date' ORDER BY date_e;";
		$users = db_query($database_name, $sql);}
		
			
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Avoirs"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "be_avoir.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";
	?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>
<span style="font-size:24px"><?php echo "liste Avoirs"; ?></span>
<tr>
<td><?php echo dateUsToFr($date_f); ;?></td>
</tr><tr><? echo "<td><a href=\"be_avoir.php?vendeur=$vendeur&date=$date_f&user_id=0&be=$destination\">Ajout Avoir</a></td>";?>
</tr>

<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "vendeur";?></th>
	<th><?php echo "Bon Entree";?></th>
	<th><?php echo "Articles G.";?></th>
	
	
</tr>

<?php 

$total_g=0;
while($users_ = fetch_array($users)) { ?><tr>
<? $commande=$users_["commande"];$evaluation=$users_["be"];$client=$users_["client"];$date_e=dateUsToFr($users_["date_e"]);
$vendeur=$users_["vendeur"];$numero=$users_["commande"];$sans_remise=$users_["sans_remise"];$remise10=$users_["remise_10"];$net1=$users_["net"];
$remise2=$users_["remise_2"];$remise3=$users_["remise_3"];$id=$users_["id"]; $date_en=dateFrToUs($users_["date"]);$ev_pre=$users_["ev_pre"];
?>
<td><?php echo $date_e; ?></td>
<? echo "<td><a href=\"be_avoir.php?date=$date_e&user_id=$id\">$vendeur</a></td>";$ref=$users_["vendeur"];?>
<td><?php echo $users_["be"]; ?></td>
<? echo "<td><a href=\"enregistrer_panier_avoir_vendeur.php?vendeur=$vendeur&client=$client&date=$date_e&numero=$id\">Detail articles</a></td>";?>
<? echo "<td><a href=\"enregistrer_panier_avoir_vendeur_client.php?vendeur=$vendeur&client=$client&date=$date_e&numero=$id\">Detail clients</a></td>";?>

<?php } ?>


</table>
<tr>
</tr>

<p style="text-align:center">


</body>

</html>