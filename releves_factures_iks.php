<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
$valeur=3600;
set_time_limit($valeur);
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$login = $user_["login"];
	
	
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 
	} //if
	
	$date1="";$date2="";$action="Recherche";$t_cheque_t = 0;
	$t_espece_t = 0;
	$t_effet_t = 0;$t_virement_t = 0;
	$profiles_list_mois = "";$mois="";
	$sql1 = "SELECT * FROM mois_rak_08 ORDER BY id;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($mois == $temp_["mois"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_mois .= "<OPTION VALUE=\"" . $temp_["mois"] . "\"" . $selected . ">";
		$profiles_list_mois .= $temp_["mois"];
		$profiles_list_mois .= "</OPTION>";
	}
	
	
	?>
	
	<form id="form" name="form" method="post" action="releves_factures_iks.php">
	<td><?php echo "Du : "; ?><input onClick="ds_sh(this);" name="date1" value="<?php echo $date1; ?>" readonly="readonly" style="cursor: text" /></td>
	<td><?php echo "Au : "; ?><input onClick="ds_sh(this);" name="date2" value="<?php echo $date2; ?>" readonly="readonly" style="cursor: text" /></td>
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<?
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Factures"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "facture.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "liste Factures"; ?></span>
<?
	if(isset($_REQUEST["action"]))
	{
	$date1=dateFrToUs($_POST['date1']);$date2=dateFrToUs($_POST['date2']);
	$date_d1=dateFrToUs($_POST['date1']);$date_d2=dateFrToUs($_POST['date2']);
	$de1=$_POST['date1'];$de2=$_POST['date2'];$iks="ATELIER IKS";
		
	if ($date2>"2016-12-31"){
	$sql  = "SELECT * ";
	$sql .= "FROM factures where client='$iks' and (date_f between '$date1' and '$date2') and montant>0 ORDER BY id;";
	}
	else
	{
	$sql  = "SELECT * ";
	$sql .= "FROM factures2016 where client='$iks' and (date_f between '$date1' and '$date2') and montant>0 ORDER BY id;";
	}
	$users = db_query($database_name, $sql);
	
	?>



<?php } ?>
</table>
<table><tr><? echo "<td><a href=\"\\mps\\tutorial\\releve_factures.php?date1=$date_d1&date2=$date_d2\">Imprimer Facturation du mois</a></td>";?>
<tr></tr>
<tr><? echo "<td><a href=\"\\mps\\tutorial\\releve_factures_n_enc.php?date1=$date_d1&date2=$date_d2\">Imprimer Factures Non Encaissees du mois</a></td>";?>
<tr><? echo "<td><a href=\"edition_factures_pdf.php?date1=$date_d1&date2=$date_d2\">Imprimer Factures</a></td>";
if ($login=="admin"){
echo "<td><a href=\"edition_factures_pdf2.php?date1=$date_d1&date2=$date_d2\">Imprimer Factures 2</a></td>";
echo "<td><a href=\"edition_factures_pdf_iks.php?date1=$date_d1&date2=$date_d2\">Imprimer Factures iks</a></td>";
}


?>
<tr><? echo "<td><a href=\"\\mps\\tutorial\\releve_factures_espece.php?date1=$date_d1&date2=$date_d2\">Imprimer Etat Timbres / Factures espece</a></td>";?>
</table>
</tr>

<p style="text-align:center">

</body>

</html>