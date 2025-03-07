<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$action="Recherche";$date="";$date1="";$du="";$au="";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$produit = $_REQUEST["produit"];$qte=$_REQUEST["qte"];$prix=$_REQUEST["prix"];
			$date = dateFrToUs($_REQUEST["date"]);$date1 = $_REQUEST["date"];
					$frs = $_REQUEST["frs"];$ref = $_REQUEST["ref"];$taux_tva = $_REQUEST["taux_tva"];

		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
				$d=dateFrToUs(date("d/m/Y"));$col="tig";
				$sql  = "INSERT INTO achats_mat ( produit,type, frs,ref,date,date_ins,prix_achat,ttc,qte ) VALUES ( ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $col . "', ";
				$sql .= "'" . $frs . "', ";
				$sql .= "'" . $ref . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $d . "', ";
				$sql .= "'" . $prix . "', ";$sql .= "'" . $taux_tva . "', ";
				$sql .= $qte . ");";

				db_query($database_name, $sql);
			

			break;

			case "update_user":

			$sql = "UPDATE achats_mat SET ";
			$sql .= "produit = '" . $_REQUEST["produit"] . "', ";
			$sql .= "frs = '" . $_REQUEST["frs"] . "', ";
			$sql .= "ref = '" . $_REQUEST["ref"] . "', ";
			$sql .= "qte = '" . $_REQUEST["qte"] . "', ";
			$sql .= "date = '" . $date . "', ";$sql .= "ttc = '" . $taux_tva . "', ";
			$sql .= "prix_achat = '" . $prix . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			// delete user's profile
			$sql = "DELETE FROM achats_mat WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	
	// recherche ville
	?>
	
	
	
	<?
	if(isset($_REQUEST["action"])){}else{
	?>
	<form id="form" name="form" method="post" action="achats_tig.php">
	<td><?php echo "Du : "; ?><input onclick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" />
	<td><?php echo "Au : "; ?><input onclick="ds_sh(this);" name="date1" readonly="readonly" style="cursor: text" />
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }
	$debut_exe="2024-01-01";$fin_exe="2024-12-31";
	if(isset($_REQUEST["action"]))
	{
	
	$date=dateFrToUs($_POST['date']);$du=$_POST['date'];$date1=dateFrToUs($_POST['date1']);$au=$_POST['date1'];
	$du=$_POST['date'];$au=$_POST['date1'];
	
	$sql  = "SELECT * ";$col="tig";
	$sql .= "FROM achats_mat where type='$col' and date between '$date' and '$date1' ORDER BY date;";
	$users = db_query($database_name, $sql);
		
	 }
	 else
	 {
	
	
	
	$sql  = "SELECT * ";$col="tig";
	$sql .= "FROM achats_mat where type='$col' and date between '$debut_exe' and '$fin_exe' ORDER BY date;";
	$users = db_query($database_name, $sql);
		
	 }
	
	
	/*$d=dateFrToUs(date("d/m/Y"));
	$sql  = "SELECT * ";
	$sql .= "FROM achats_mat where date_ins='$d' ORDER BY date;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);*/

	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head><? require "head_cal.php";?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "Production"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "achat_tig.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff"><? require "body_cal.php";?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Achats tiges Et divers"; ?></span>

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>


<table class="table2">

<tr>
	<th><?php echo "date";?></th>
	<th><?php echo "Matiere";?></th>
	<th><?php echo "Qte";?></th>
	<th><?php echo "Prix Achat";?></th>	<th><?php echo "Valeur";?></th>
	<th><?php echo "Fournisseur";?></th>
	<th><?php echo "Ref. Achat";?></th>

</tr>
<? $t=0;$q=0;while($users_ = fetch_array($users)) {?><tr>
	<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo dateUsToFr($users_["date"]);?></A></td>
	<td align="center"><?php echo $users_["produit"];?></td>
	<td align="center"><?php echo number_format($users_["qte"],3,',',' ');?></td>
	<td align="center"><?php echo number_format($users_["prix_achat"],2,',',' ');?></td>
		<td align="right"><?php $t=$t+$users_["prix_achat"]*$users_["qte"];$q=$q+$users_["qte"];echo number_format($users_["prix_achat"]*$users_["qte"],2,',',' ');?></td>	

	<td align="center"><?php echo $users_["frs"];?></td>
	<td align="center"><?php echo $users_["ref"];?></td>

<? }?>
<tr>
<td></td><td></td>
<td align="right"><?php echo number_format($q,2,',',' ');?></td>
<td></td>
<td align="right"><?php echo number_format($t,2,',',' ');?></td>
<td><td/><td><td/>
</table>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>
	

</body>

</html>