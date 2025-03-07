<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
			$sql  = "SELECT * ";$sel=1;
		$sql .= "FROM mois_rak WHERE encours = " . $sel . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";

		$mois = $user_["mois"];
		$du = dateUsToFr($user_["du"]);
		$au = dateUsToFr($user_["au"]);
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url

	$action="recherche";$produit="";
	$client_list = "";$client_rech="";
	$sql = "SELECT * FROM  rs_data_clients ORDER BY last_name;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($client_rech == $temp_["last_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$client_list .= "<OPTION VALUE=\"" . $temp_["last_name"] . "\"" . $selected . ">";
		$client_list .= $temp_["last_name"];
		$client_list .= "</OPTION>";
	}


?>

	<form id="form" name="form" method="post" action="registres_factures_g.php">
	<td><?php echo "Client : "; ?><select id="client_rech" name="client_rech"><?php echo $client_list; ?></select></td>
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>

	</form>
	<?
	$date1="";$client_rech="";$produit="";
	if(isset($_REQUEST["action"]))
	{
	 $client_rech=$_POST['client_rech'];
	
	if ( $client_rech<>"."){
	$sql  = "SELECT * ";
	$sql .= "FROM registre_factures_rak WHERE mois_f='$mois' and client='$client_rech' ORDER BY id;";
	$users1 = db_query($database_name, $sql);}
	else
	{	$sql  = "SELECT * ";
	$sql .= "FROM registre_factures_rak WHERE mois_f='$mois' ORDER BY id;";
	$users1 = db_query($database_name, $sql);}
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "edition_facture_sejour.php?numero=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "RELEVE DE FACTURES ".$mois; ?></span>

<table class="table2" bordercolordark="#333333">
<tr>
	<th><?php echo "Numero";?></th>
	<th><?php echo "Date";?></th>
	<th><?php echo "Client";?></th>
	<th><?php echo "Net";?></th>
</tr>

<?php $releve=0;$releve_mad=0;
while($users_ = fetch_array($users1)) 
{ ?><tr>
<td width="50"><?php $numero=$users_["id"]."/2007";print("<font size=\"1\" face=\"Comic sans MS\" color=\"#3300FF\">$numero </font>");?></td>
<td style="text-align:center" width="50"><?php $date=dateUsToFr($users_["date_f"]); print("<font size=\"1\" face=\"Comic sans MS\" color=\"#3300FF\">$date </font>");?></td>
<td width="150"><?php $client=$users_["client"]; print("<font size=\"1\" face=\"Comic sans MS\" color=\"#3300FF\">$client </font>");?></td>
<? $type_s=$users_["type_service"];$numero=$users_["id"];
if ($type_s="SEJOURS ET CIRCUITS") {
	$sql  = "SELECT * ";
	$sql .= "FROM details_bookings_sejours_rak where numero_f='$numero' and montant_f>0 and validation_f=1 ORDER BY id;";
	$users2 = db_query($database_name, $sql);$net=0;$net_mad=0;

	while($row=mysql_fetch_array($users2)) 
  	{ 
 	 $ref=$row["v_ref"]; $noms=$row["noms"]; $adt=$row["adultes"];$enf=$row["enfants"];$prix=number_format($row["montant_f"]/$row["adultes"],2,',',' ');
 	 $montant_f_f=number_format($row["montant_f"],2,',',' ');$lp=$row["id_registre"]+200000;
		$net=$net+$row["montant_f"];$net_mad=$net_mad+($row["montant_f"]*$row["cours_f"]);
 	 } 
	?>
	<? if ($net>0){ 
	?><td style="text-align:right" width="80"><?php $net1=number_format($net,2,',',' '); print("<font size=\"1\" face=\"Comic sans MS\" color=\"#3300FF\">$net1 </font>");?></td>
	<? 
	$releve=$releve+$net;$releve_mad=$releve_mad+$net_mad;
	}?>
<? }?>

<?php } ?>
<tr>
<td></td><td></td><td></td>
	<td style="text-align:right" width="80"><?php $releve1=number_format($releve,2,',',' '); print("<font size=\"1\" face=\"Comic sans MS\" color=\"#3300FF\">$releve1 </font>");?></td>

</table>

<?
}
?>


</body>

</html>
