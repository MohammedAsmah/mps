<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) ) { 

		if($_REQUEST["action_"] != "delete_user") {
			$ferier_1=$_REQUEST["ferier_1"];$ferier_2=$_REQUEST["ferier_2"];$du=dateFrtoUs($_REQUEST["du"]);$au=dateFrToUs($_REQUEST["au"]);
			$du=$_REQUEST["du"];$au=$_REQUEST["au"];
			if(isset($_REQUEST["encours"])) { $encours = 1; } else { $encours = 0; }
		if(isset($_REQUEST["avance"])) { $avance = 1; } else { $avance = 0; }
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
							

			break;

			case "update_user":
			$user_id=$_REQUEST["user_id"];
			$sql = "UPDATE paie_ouvriers SET encours = '$encours',du = '$du',au = '$au',avance = '$avance',ferier_1 = '$ferier_1',ferier_2 = '$ferier_2' WHERE id = '$user_id'";
			db_query($database_name, $sql);
			
			break;
			
			case "delete_user":
			

			
			break;


		} //switch
	} //if
	
	$sql  = "SELECT * ";$occ="occasionnelles";$per="permanents";$vide="";
	$sql .= "FROM paie_ouvriers ORDER BY id;";
	$users = db_query($database_name, $sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste "; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "paie_ouvrier.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "JOURNAL PAIE OUVRIERS MPS "; ?></span>

<table class="table2">

<tr>
	
	<th><?php echo "Semaine";?></th>
	<th><?php echo "Du";?></th>
	<th><?php echo "Au";?></th>
	<th><?php echo "H.N";?></th>	
	<th><?php echo "H.25";?></th>		
	<th><?php echo "H.50";?></th>
	<th><?php echo "Brut Perma.";?></th>
	<th><?php echo "Brut Occas.";?></th>
	<th><?php echo "Prelev/avances";?></th>
	
		
</tr>

<?php $m=0;while($users_ = fetch_array($users)) { ?><tr>

<?php $semaine=$users_["semaine"];$du=$users_["du"]; $du_us=dateFrToUs($du);?>
<td bgcolor="#66CCCC"><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["id"];?></A></td>
<td bgcolor="#66CCCC"><? echo "<a href=\"pointage_archive.php?du=$du_us\">$du</a></td>";?>
<td><?php echo $users_["au"]; ?></td>
<td><?php echo $users_["heures_normales"]; ?></td>
<td><?php echo $users_["heures_sup_25"]; ?></td>
<td><?php echo $users_["heures_sup_50"]; ?></td>
<td align="right"><?php echo $users_["montant_permanents"]; ?></td>
<td align="right"><?php echo $users_["montant_occasionnels"]; ?></td>
<td align="right"><?php echo $users_["avances"]; ?></td>
<td align="right"><?php echo $users_["encours"]; ?></td>

<?
			
			
			?>



<?php } ?>

</table>

<p style="text-align:center">

</body>

</html>