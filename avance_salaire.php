<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$employe = $_REQUEST["employe"];$profile_id = GetUserProfile();$solde = $_REQUEST["solde"];
	//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$login = $user_["login"];

	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "Nouveau Client";

		$montant = "";$echeance="";
		$employe = "";$montant_echeance=0;$nombre_echeances="";$mode="";$date="";$motif="";
		
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM avances_salaires WHERE employe='$employe' ORDER BY id;";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";

		$montant = $user_["montant"];$montant_echeance = $user_["montant_echeance"];$nombre_echeances = $user_["nombre_echeances"];
		$employe = $user_["employe"];$date=dateUsToFr($user_["date"]);$motif=$user_["motif"];$mode=$user_["mode"];
		$debut=dateUsToFr($user_["debut"]);$fin=dateUsToFr($user_["fin"]);$echeance=$user_["echeance"];
		}
	$profiles_list_employe = "";
	$sql43 = "SELECT * FROM employes ORDER BY employe;";
	$temp = db_query($database_name, $sql43);
	while($temp_ = fetch_array($temp)) {
		if($employe == $temp_["employe"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_employe .= "<OPTION VALUE=\"" . $temp_["employe"] . "\"" . $selected . ">";
		$profiles_list_employe .= $temp_["employe"];
		$profiles_list_employe .= "</OPTION>";
	}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . $title; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function UpdateUser() {
			document.getElementById("form_user").submit();
	}

	function CheckUser() {
		
			UpdateUser();
		
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression ?"; ?>")) {
			document.location = "avances_salaires.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}


--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" method="post" action="avances_salaires.php">

	<center>

	<table class="table2">

		<tr>
		<tr><td><?php echo "Employe : "; ?></td><td><?php echo $employe; ?></td>
		</tr>
		<tr>
		<td><?php echo "Date : "; ?></td><td><?php echo $date; ?></td>
		</tr>		
		<tr>
		<td><?php echo "Repport : "; ?></td><td><?php echo number_format($montant,2,',',' '); ?></td>
		</tr>
		<tr>
		<td><?php echo " "; ?></td><td><?php echo $motif; ?></td>
		</tr>
		<tr>
		<td><?php echo "Montant prelevement : "; ?></td><td><?php echo number_format($montant_echeance,2,',',' '); ?></td>
		</tr>	
		
			
			<table class="table2">
			<tr><? echo "<td> Date </td> <td> Motif </td> <td> Debit </td> <td> Credit </td> <td> Solde </td>";?>
			<? $sql  = "SELECT * ";
				$sql .= "FROM avances_employes where employe='$employe' ORDER BY date_avance;";
				$users22 = db_query($database_name, $sql);$ss=0;$s_r=$montant;
				?>
				<tr><td><? echo $date;?></td><td><? echo "Report au 01/06/2011";?></td>
				<td align="right"><? echo $montant;?></td><td></td><td align="right"><? echo $montant;?></td>
				<?
				
				while($users_22 = fetch_array($users22)) {
				$ss=$ss+$users_22["montant"];
			
			?>
			<tr>
			<td><? echo dateUsToFr($users_22["date_avance"]);$mt=number_format($users_22["montant"],2,',',' ');?></td>
			<td><? echo $users_22["motif"];?></td>
			<? if ($users_22["type"]=="avance"){?><td align="right"><? echo $mt;$s_r=$s_r+$users_22["montant"];?></td><td></td><? } else {?>
			<td></td><td align="right"> <? echo $mt."</td>";$s_r=$s_r-$users_22["montant"];}?>
			<td align="right"><? echo number_format($s_r,2,',',' ');?></td>
			</tr>
			<? }?>
			
			</table>
			
			
			
		</table>


<p style="text-align:center">

<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">
<table class="table3"><tr>

<?php if($user_id != "0") { ?>
<td><button type="button" onClick="CheckUser()"><?php echo Translate("Update"); ?></button></td>
<?php } else { ?>
<td><button type="button"  onClick="CheckUser()"><?php echo Translate("OK"); ?></button></td>
<?php 
} ?>
</tr></table>

</center>

</form>

</body>

</html>