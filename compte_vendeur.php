<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];

	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "Nouveau Client";

		$login = "";
		$last_name = "";
		$first_name = "";$ville="";$vendeur="";
		$email = "";
		$locked = "";
		$profile_id = 0;
		$remarks = "";
		$remise2=0;
		$remise3=0;
		$com_debiteur_to_a=0;
		$com_debiteur_to_e=0;
		$com_cash_rep_a=0;
		$com_cash_rep_e=0;
		$com_cash_ag_a=0;
		$com_cash_ag_e=0;
		
		
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM vendeurs WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		
		$vendeur = $user_["vendeur"];$plafond = number_format($user_["plafond"],2,',',' ');
		
		}
	


	// extracts profile list
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . $title; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "compte_vendeur_client.php?client=" + client; }
	function EditUser1(client) { document.location = "compte_client_reliquat.php?client=" + client; }
--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo "Relevé Compte $vendeur Plafond : $plafond Edité le ".date("d/m/Y"); ?></span>

<table class="table2"><tr><td style="text-align:center">

	<center>

	

<p style="text-align:center">

<center>


</center>


<?
	$sql  = "SELECT id,client,date_e,sum(net) As total_net,sum(reliquat) As total_reliquat, obs_reliquat ";$date_enc="2011-01-01";
	$sql .= "FROM commandes where vendeur='$vendeur' group by id ORDER BY date_e;";
	$users = db_query($database_name, $sql);
?>
<table class="table2">

<tr>
	
	<th><?php echo "Date";?></th>
	<th><?php echo "Client";?></th>
	<th><?php echo "Encompte";?></th>
	<th><?php echo "Obs";?></th>
</tr>

<?php $ca=0;$reliquat=0;
			

while($users_ = fetch_array($users)) { ?>
<? $client=$users_["client"];$d=dateUstoFr($users_["date_e"]);$net=$users_["net"];$encompte_client=$users_["total_reliquat"];$net=$users_["total_net"];?>
<?php $vendeur=$users_["vendeur"];$ca=$ca+$net;$reliquat=$reliquat+$encompte_client;$vide=0;$id=$users_["id"];

			/*$sql = "UPDATE commandes SET ";
			
			$sql .= "reliquat = '" . $vide . "' ";
			
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);*/






if ($encompte_client>0){?>

<tr>
<? echo "<td><a href=\"compte_client_reliquat.php?user_id=$user_id&client=$client&id=$id\">$d</a></td>";?>
<? echo "<td><a href=\"compte_client_reliquat.php?user_id=$user_id&client=$client&id=$id\">$client</a></td>";?>
<td align="right"><?php echo number_format($encompte_client,2,',',' ');?></td>
<td align="right"><?php echo $users_["obs_reliquat"];?></td>
</tr>
<? }?>
				
<? } 


?>
<td></td><td></td>

<td align="right"><?php echo number_format($reliquat,2,',',' ');?></td>
</table>

</body>

</html>