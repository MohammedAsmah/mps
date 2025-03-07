<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$user_name=GetUserName();
	$error_message = "";
	$type_service="SEJOURS ET CIRCUITS";
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"])) { 
		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			
			$date_tirage = dateFrToUs($_REQUEST["date_tirage"]);
			list($annee1,$mois1,$jour1) = explode('-', $date_tirage); 
			$pdu = mktime(0,0,0,$mois1,$jour1,$annee1); 
			$mois=date("m",$pdu);$annee=date("Y",$pdu);
			$service="";
			
			$date_open=dateFrToUs($_REQUEST["date_tirage"]);
			$user_open=$user_name;
			
			$debit=$_REQUEST["debit"];
			$credit=$_REQUEST["credit"];
			$libelle=$_REQUEST["libelle"];
			
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
	
				$sql  = "INSERT INTO etats_erreurs (date_tirage,debit,credit,libelle)
				 VALUES 	('$date_tirage','$debit','$credit','$libelle')";

				db_query($database_name, $sql);$id_registre=mysql_insert_id();
					

			

			break;

			case "update_user":
				
			$sql = "UPDATE etats_erreurs SET ";
			$sql .= "date_tirage = '" . $date_tirage . "', ";
			$sql .= "debit = '" . $debit . "', ";
			$sql .= "credit = '" . $credit . "', ";
			$sql .= "libelle = '" . $libelle . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
					
			break;
			
			case "delete_user":
				
			// delete user's profile
			$sql = "DELETE FROM etats_erreurs WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
			$profile_id = GetUserProfile();	$user_name=GetUserName();$date_time=date("y-m-d h:m:s");
			$table_name="registre_remises";$record=$_REQUEST["user_id"];
				$sql  = "INSERT INTO deleted_files ( user,date_time,table_name,record ) VALUES ( ";
				$sql .= "'" . $user_name . "', ";
				$sql .= "'" . $date_time . "', ";
				$sql .= "'" . $table_name . "', ";
				$sql .= "'" . $record . "');";

				db_query($database_name, $sql);
			
			break;


		} //switch
	} //if
	
	else {$banque="";$date_tirage="";$date_tirage_au="";}
	if(isset($_REQUEST["action_"]) and $_REQUEST["action_"] != "delete_user") { $date_tirage = $_REQUEST["date_tirage"];}
	else {$banque="";$date_tirage="";}
	$action="recherche";
	$banque_list = "";
	$sql = "SELECT * FROM  rs_data_banques ORDER BY banque;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($banque == $temp_["banque"]) { $selected = " selected"; } else { $selected = ""; }
		
		$banque_list .= "<OPTION VALUE=\"" . $temp_["banque"] . "\"" . $selected . ">";
		$banque_list .= $temp_["banque"];
		$banque_list .= "</OPTION>";
	}

	
	?>
	<? if(isset($_REQUEST["action"])){}else{ ?>
	<form id="form" name="form" method="post" action="registres_erreurs.php">
	
	<input type="submit" id="action" name="action" value="<?php echo $action; ?>">
	</form>
	
	<? }


?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "registre_erreur.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<? 	
	
	$sql  = "SELECT * ";
	$sql .= "FROM etats_erreurs  ORDER BY id;";
	$users11 = db_query($database_name, $sql);



?>


<span style="font-size:24px"><?php echo $date_tirage; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Date ";?></th>
	<th><?php echo "libelle";?></th>
	<th><?php echo "Debit";?></th>
	<th><?php echo "Credit";?></th>
	
</tr>

<?php 

while($users_1 = fetch_array($users11)) { ?>
			<tr><td><a href="JavaScript:EditUser(<?php echo $users_1["id"]; ?>)"><?php echo dateUsToFr($users_1["date_tirage"]); ?></A></td>
			<td><?php echo $users_1["libelle"]; ?></td>
			<td><?php echo $users_1["debit"]; ?></td>
			<td><?php echo $users_1["credit"]; ?></td>
						
			<?			
 } ?>

<tr><td></td><td></td>
<td align="right">
<? 			?></td>
<td align="right"><? 			?></td>
</table>
</strong>
<p style="text-align:center">
<table class="table2">
<? echo "<td><a href=\"registre_erreur.php?banque=$banque&date_tirage=$date_tirage&user_id=0\">"."Ajout "."</a></td>";?>

</table>

<? ?>
</body>

</html>