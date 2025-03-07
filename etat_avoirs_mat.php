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
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 

		if($_REQUEST["action_"] != "delete_user") {$date = dateFrToUs($_REQUEST["date"]);$date_f = dateFrToUs($_REQUEST["date"]);
		
			
			// prepares data to simplify database insert or update
			$client = $_REQUEST["client"];$be = $_REQUEST["be"];$net = $_REQUEST["net"];
			if(isset($_REQUEST["sans_remise"])) { $sans_remise = 1; } else { $sans_remise = 0; }
		$sql  = "SELECT * ";
		$sql .= "FROM clients WHERE client = '$client' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$remise10 = $user_["remise10"];
		$remise2 = $user_["remise2"];$remise3 = $user_["remise3"];$vendeur = $user_["vendeur"];
			
			}
		if($_REQUEST["action_"] == "update_user"){	
			$remise10 = $_REQUEST["remise10"];$remise2 = $_REQUEST["remise2"];$remise3 = $_REQUEST["remise3"];
			$client = $_REQUEST["client"];$vendeur = $_REQUEST["vendeur"];$net = $_REQUEST["net"];
			}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
				
				$encours="encours";
				$sql  = "INSERT INTO avoirs ( commande,date_e,be,net,client, vendeur, sans_remise ) VALUES ( ";
				$sql .= "'" . $cde . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $be . "', ";
				$sql .= "'" . $net . "', ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $sans_remise . "');";

				db_query($database_name, $sql);
		
		
		//retour à liste triée par date
		$date=$_POST['date'];$action="recherche";
					

			break;

			case "update_user":
			$mode=$_POST['mode'];$remise_4=$_POST['remise_4'];$net=$_POST['net'];
			$sql = "UPDATE avoirs SET ";
			$sql .= "client = '" . $client . "', ";
			$sql .= "date_e = '" . $date . "', ";
			$sql .= "be = '" . $be . "', ";
			$sql .= "vendeur = '" . $vendeur . "', ";
			$sql .= "net = '" . $net . "', ";
			$sql .= "mode = '" . $mode . "', ";
			$sql .= "remise_4 = '" . $remise_4 . "', ";
			$sql .= "sans_remise = '" . $sans_remise . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);

			//revenir à liste
			$date=$_POST['date'];$action="recherche";
			


			break;
			
			case "delete_user":
			$sql  = "SELECT * ";
			$sql .= "FROM avoirs WHERE id = " . $_REQUEST["user_id"] . ";";
			$user = db_query($database_name, $sql); $users_ = fetch_array($user);
			$commande=$users_["commande"];
			$sql = "DELETE FROM avoirs WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
			$sql = "DELETE FROM detail_avoirs WHERE commande = " . $commande . ";";
			db_query($database_name, $sql);
			
			
			
			break;


		} //switch
	} //if
	

	$sql1 = "SELECT * FROM vendeurs ORDER BY vendeur;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($vendeur == $temp_["vendeur"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_vendeur .= "<OPTION VALUE=\"" . $temp_["vendeur"] . "\"" . $selected . ">";
		$profiles_list_vendeur .= $temp_["vendeur"];
		$profiles_list_vendeur .= "</OPTION>";
	}
	$profiles_list_client;
	$sql1 = "SELECT * FROM clients ORDER BY client;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($client == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_client .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";
		$profiles_list_client .= $temp_["client"];
		$profiles_list_client .= "</OPTION>";
	}
	$destination="";
		if(isset($_REQUEST["action"])){}else{
	?>
	<form id="form" name="form" method="post" action="etat_avoirs_mat.php">
	<table>
	<td><?php echo "Du: "; ?><input onClick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" />
	<td><?php echo "Au: "; ?><input onClick="ds_sh(this);" name="date2" readonly="readonly" style="cursor: text" />
	
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }
	if(isset($_REQUEST["action"]))
	{$date=dateFrToUs($_POST['date']);$date_f=dateFrToUs($_POST['date']);$date2=dateFrToUs($_POST['date2']);
	$vendeur=$_POST['vendeur'];$destination=$_POST['destination'];$date_au=$_POST['date2'];$date_du=$_POST['date'];
		
		
		$sql  = "SELECT * ";
		$sql .= "FROM avoirs where date_e between '$date' and '$date2' group by matricule ORDER BY matricule;";
		$users = db_query($database_name, $sql);
		
		}
		
		else
			
		{
		@$vendeur=$_GET['vendeur'];@$date=$_GET['date'];$date_a=$_GET['date'];
		$sql  = "SELECT * ";
		$sql .= "FROM avoirs where date_e between '$date' and '$date2' group by matricule ORDER BY matricule;";
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
	function EditUser(user_id) { document.location = "avoir_client.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";
	?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>
<span style="font-size:24px"><?php echo "liste Avoirs Du $date_du Au $date_au    "; ?></span>

<table class="table2">

<tr>
	
	<th><?php echo "Matricule";?></th>

</tr>

<?php 

$total_g=0;$bon="";$client_g="";$total_gg=0;
while($users_ = fetch_array($users)) { ?><tr>
<? $commande=$users_["commande"];$evaluation=$users_["be"];$client=$users_["client"];$date_e=dateUsToFr($users_["date_e"]);
$vendeur=$users_["vendeur"];$numero=$users_["commande"];$sans_remise=$users_["sans_remise"];$remise10=$users_["remise_10"];$net1=$users_["net"];
$remise2=$users_["remise_2"];$remise3=$users_["remise_3"];$id=$users_["id"]; $date_en=dateFrToUs($users_["date"]);$ev_pre=$users_["ev_pre"];
$ref=$users_["vendeur"];

$bon=$bon."-".$evaluation;
$client_g=$client_g."-".$client;

?>

<td><?php $mat=$users_["matricule"];echo "<a href=\"avoirs_mat_dates.php?matricule=$mat&du=$date&au=$date2\">$mat</a>"; ?></td>


<?php } ?>
</tr>
</table>


<p style="text-align:center">


</body>

</html>