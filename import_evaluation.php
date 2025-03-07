<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
		?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Evaluations"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "detail_evaluation.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";
	$action="recherche";
	$date="";$client=$_GET['client'];$facture=$_GET['facture'];$du=$_GET['du'];$au=$_GET['au'];$eva=$_GET['eva'];
		
		$sql1  = "SELECT * "; 
		$sql1 .= "FROM clients WHERE client = '$client';";
		$user1 = db_query($database_name, $sql1); $user1_ = fetch_array($user1);
		$ref_client = $user1_["ref"];$remise2 = $user1_["remise2"];$remise3 = $user1_["remise3"];
	
	?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>
<span style="font-size:16px"><?php echo "liste Evaluations"; ?></span>
	

<?	
	$sql  = "SELECT * ";
	$sql .= "FROM commandes where client='$client' ORDER BY date_e;";
	$users = db_query($database_name, $sql);
?>
<span style="font-size:20px"><td><?php echo $client."-->Facture : ".$facture."--->".$eva;?></td></span>


<table class="table2">
<tr>
	<th><?php echo "Evaluation";?></th>
	<th><?php echo "Date";?></th>
	<th><?php echo "Montant";?></th>
	<th><?php echo "Facture";?></th>
	<th><?php echo "Validation";?></th>
	<th><?php echo "Duplication";?></th>
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<? $commande=$users_["commande"];$evaluation=$users_["evaluation"];$client=$users_["client"];?>
<td><?php echo $users_["evaluation"]; ?></td>
<td><?php echo dateUsToFr($users_["date_e"]); ?></td>
<td style="text-align:Right"><?php echo $users_["net"]; ?></td>
<td><?php echo $users_["facture"]; ?></td>
<?php if ($users_["valider_f"]==0){
echo "<td><a href=\"detail_evaluation_valider.php?du=$du&au=$au&client=$client&facture=$facture&commande=$commande&eval=$evaluation\">valider</a></td>";}
else
{
if ($users_["facture"]>8603){
echo "<td><a href=\"detail_evaluation_devalider.php?du=$du&au=$au&client=$client&facture=$facture&commande=$commande&eval=$evaluation\">dévalider</a></td>";}
else
{ ?>
<td><?php echo "comptabilisée"; ?></td>
<? }
}
echo "<td><a href=\"detail_evaluation_valider.php?du=$du&au=$au&client=$client&facture=$facture&commande=$commande&eval=$evaluation\">Dupliquer</a></td>";

?>

<?php } ?>

</table>


<?	
	$sql  = "SELECT * ";
	$sql .= "FROM commandes07 where client='$client' ORDER BY date_e;";
	$users = db_query($database_name, $sql);
?>
<span style="font-size:20px"><td><?php echo $client."-->Facture : ".$facture."--->".$eva;?></td></span>


<table class="table2">
<tr>
	<th><?php echo "Evaluation";?></th>
	<th><?php echo "Date";?></th>
	<th><?php echo "Montant";?></th>
	<th><?php echo "Facture";?></th>
	<th><?php echo "Validation";?></th>
	<th><?php echo "Duplication";?></th>
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<? $commande=$users_["commande"];$evaluation=$users_["evaluation"];$client=$users_["client"];?>
<td><?php echo $users_["evaluation"]; ?></td>
<td><?php echo dateUsToFr($users_["date_e"]); ?></td>
<td style="text-align:Right"><?php echo $users_["net"]; ?></td>
<td><?php echo $users_["facture"]; ?></td>
<?php if ($users_["valider_f"]==0){
echo "<td><a href=\"detail_evaluation_valider1.php?du=$du&au=$au&client=$client&facture=$facture&commande=$commande&eval=$evaluation\">valider</a></td>";}
else
{
if ($users_["facture"]>8603){
echo "<td><a href=\"detail_evaluation_devalider1.php?du=$du&au=$au&client=$client&facture=$facture&commande=$commande&eval=$evaluation\">dévalider</a></td>";}
else
{ ?>
<td><?php echo "comptabilisée"; ?></td>
<? }
}
echo "<td><a href=\"detail_evaluation_valider1.php?du=$du&au=$au&client=$client&facture=$facture&commande=$commande&eval=$evaluation\">Dupliquer</a></td>";

?>

<?php } ?>

</table>



<p style="text-align:center">

</body>

</html>