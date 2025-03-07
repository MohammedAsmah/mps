<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$caisse="";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	
$action="Recherche";$date="";$date1="";$du="";$au="";
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
	<form id="form" name="form" method="post" action="evaluations_transport_dates.php">
	<td><?php echo "Du : "; ?><input onclick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" />
	<td><?php echo "Au : "; ?><input onclick="ds_sh(this);" name="date1" readonly="readonly" style="cursor: text" />
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }	
	if(isset($_REQUEST["action"]))
	{
	
	$date=dateFrToUs($_POST['date']);$du=$_POST['date'];$date1=dateFrToUs($_POST['date1']);$au=$_POST['date1'];$vendeur="BOURRIOUAIAT DRISS";
	$sql  = "SELECT id,vendeur,date,matricule,service,transport,observation,sum(montant) As total_net,sum(jaouda) As total_net_jaouda,sum(frais) As total_frais ";
	$sql .= "FROM registre_vendeurs where  (date between '$date' and '$date1') and montant<>0 and vendeur<>'$vendeur' GROUP by transport order by transport ;";
	$users = db_query($database_name, $sql);
	}
	?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Balance Transport $du au $au "; ?></span>

<p style="text-align:center">


<table class="table2">

<tr>
	
	
	<th><?php echo "Categorie";?></th>
	<th><?php echo "Chargement Mps+Jaouda";?></th>
	<th><?php echo "Transport";?></th>
	<th><?php echo "%";?></th>
	
</tr>

<?php $debit=0;$credit=0;$tca=0;$s=0;$ttrans=0;
while($users_ = fetch_array($users)) { ?><tr>
<?php 

		$service = $users_["service"];$id = $users_["id"];$transport = $users_["transport"];
		$vendeur = $users_["vendeur"];
		$dater = $users_["date"];
		$total_net = $users_["total_net"];
		$total_frais = $users_["total_frais"];
		$observation = $users_["observation"];
		
		
		//consolidate 
		

	/*$sql  = "SELECT * ";
	$sql .= "FROM registre_vendeurs where vendeur='$vendeur' and service='$service' and date='$dater' order by id;";
	$users1jp = db_query_jp($database_name, $sql);
	
	$users_jp = fetch_array($users1jp);
	$montant_jp=$users_jp["montant"];
	
	$sql = "UPDATE registre_vendeurs SET ";
			$sql .= "jaouda = " . $montant_jp . " ";
			
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);
			
		
		$sql  = "SELECT * ";
		$sql .= "FROM rs_data_villes WHERE ville = '" . $service . "';";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$transport = $user_["categorie_transport"];
		
		
		$sql = "UPDATE registre_vendeurs SET ";
			$sql .= "transport = '" . $transport . "' ";
			
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);*/


echo "<td><a href=\"evaluations_transport_dates_villes.php?transport=$transport&date=$date&date1=$date1\">$transport</a></td>";?>


<td align="right"><?php $tca=$tca+$users_["total_net"]+$users_["total_net_jaouda"];echo number_format($users_["total_net"]+$users_["total_net_jaouda"],2,',',' ');?></td>
<td align="right"><?php $ttrans=$ttrans+$users_["total_frais"];echo number_format($users_["total_frais"],2,',',' ');?></td>
<td align="right"><?php echo number_format($users_["total_frais"]/($users_["total_net"]+$users_["total_net_jaouda"])*100,2,',',' ')."%";?></td>

<?php } ?>
<tr>
<td></td>
<td align="right"><?php echo number_format($tca,2,',',' ');?></td>
<td align="right"><?php echo number_format($ttrans,2,',',' ');?></td>
<td align="right"><?php echo number_format($ttrans/$tca*100,2,',',' ')."%";?></td>
</table>

<p style="text-align:center">

</body>

</html>