<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$caisse="";$action="Recherche";$date="";$date1="";$du="";$au="";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">


</head>

<body style="background:#dfe8ff">
		<? require "body_cal.php";?>

	<?
	
			if(isset($_REQUEST["action"])){}else{
	?>
	<form id="form" name="form" method="post" action="palmares_clients_avoirs.php">
	<td><?php echo "Du : "; ?><input onclick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" />
	<td><?php echo "Au : "; ?><input onclick="ds_sh(this);" name="date1" readonly="readonly" style="cursor: text" />
	
	
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }
	if(isset($_REQUEST["action"]))
	{
	
	$date=dateFrToUs($_POST['date']);$du=$_POST['date'];$date1=dateFrToUs($_POST['date1']);$au=$_POST['date1'];
	/*$plafond=$_POST['plafond'];$com=$_POST['com'];
	<td><?php $plafond=0.00;echo "Plafond : "; ?><input type="text" id="plafond" name="plafond" value="<?php echo $plafond; ?>"></td>
	<td><?php $com=0.00;echo "Escompte : "; ?><input type="text" id="com" name="com" value="<?php echo $com; ?>"></td>
	*/
	
	
	$du=$_POST['date'];$au=$_POST['date1'];$encours="encours";$vide="";if(isset($_REQUEST["avoir"])) { $avoir = 1; } else { $avoir = 0; }

	$sql  = "SELECT commande,client,vendeur,date,sum(net) As total ";
	$sql .= "FROM commandes where date_e between '$date' and '$date1' and evaluation<>'$vide' and evaluation<>'$encours' GROUP BY client order by total DESC;";
	$users = db_query($database_name, $sql);
	
	
	?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php $plafond1=number_format($plafond,2,',',' ');
echo "Palmares C.A Clients / Avoirs $du au $au "; ?></span>

<p style="text-align:center">


<table class="table2">

<tr>
	<th><?php echo "Client";?></th>
	<th><?php echo "C.A ";?></th>
	
	<th><?php echo "Avoirs ";?></th>
	<th><?php echo "% / C.A ";?></th>
	
	
	
</tr>

<?php $debit=0;$credit=0;$t=0;$s=0;$t=0;$net_avoir=0;
while($users_ = fetch_array($users)) { $client=$users_["client"];
 $sql12  = "SELECT * ";
		$sql12 .= "FROM clients where client='$client' ORDER BY client;";
		$users12 = db_query($database_name, $sql12);$users1_12 = fetch_array($users12);
		$escompte=$users1_12["escompte"];$sans_escompte=$users1_12["sans_escompte"];

$total=$users_["total"];?><tr><td>
<? print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$client </font>");?></td>
<td align="right"><?php $t=$t+$users_["total"];echo number_format($users_["total"],2,',',' ');?></td>

<? $sql1  = "SELECT client,sum(net) as net_avoir ";
		$sql1 .= "FROM avoirs where client='$client' and date_e between '$date' and '$date1' group by client ORDER BY client;";
		$users1 = db_query($database_name, $sql1);$users1_1 = fetch_array($users1);
		$net_avoir=$users1_1["net_avoir"];
		?>
<td align="right"><?php $a=$a+$net_avoir;echo number_format($net_avoir,2,',',' ');?></td>
<td align="right"><?php echo number_format(($net_avoir/$users_["total"])*100,2,',',' ')." %";?></td>


<?php 

$montant=$users_["total"]-$net_avoir;$com=0;
$sql  = "SELECT * ";
		$sql .= "FROM grille_escompte  order by id;";
		$user = db_query($database_name, $sql); while($user_ = fetch_array($user)) {
		$tranche_de = $user_["tranche_de"];$tranche_a=$user_["tranche_a"];
		if ($montant>$tranche_de and $montant<$tranche_a){$com=$user_["escompte"];}
		}
$c=$c+($users_["total"]-$net_avoir)*$com/100;?>

<?php }?>
<tr>
<td></td>
<td align="right"><?php echo number_format($t,2,',',' ');?></td>

<td align="right"><?php echo number_format($a,2,',',' ');?></td>
<td align="right"><?php echo number_format($a/$t*100,2,',',' ');?></td>



</tr>
</table>

<?php } ?>

<p style="text-align:center">

</body>

</html>