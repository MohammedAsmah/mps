<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 

		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
		

			break;

			case "update_user":

	
			break;
			
			case "delete_user":
			
			
			break;


		} //switch
	} //if
	
	$sql  = "SELECT * ";$null="";$iks="VENTE USINE IKS";
	$sql .= "FROM vendeurs  where vendeur<>'$null' and vendeur<>'$iks' ORDER BY vendeur;";
	$users = db_query($database_name, $sql);
	
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Vendeurs"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "vendeur.php?user_id=" + user_id; }
	function EditUser1(user_id) { document.location = "compte_vendeur.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "MPS"; ?></span>

<table class="table2">

<tr>
	
	<th><?php echo "Vendeur";?></th>
	<th><?php echo "Plafond";?></th>
	<th><?php echo "En compte MPS";?></th>
	<th><?php echo "En compte JAOUDA";?></th>
	<th><?php echo "Total En compte";?></th>
	<th><?php echo "Decouvert";?></th>
	
</tr>

<?php while($users_1 = fetch_array($users)) { ?><tr>

<td><a href="JavaScript:EditUser1(<?php echo $users_1["id"]; ?>)"><?php echo $users_1["vendeur"];?></A></td>
<td align="right"><?php echo number_format($users_1["plafond"],2,',',' ');?></td>
<?
	$vendeur=$users_1["vendeur"];$encompte_client_mps=0;$du="2024-10-01";$au="2024-11-01";$plafond=$users_1["plafond"];
	$vendeur_g=$users_1["vendeur"];
	$sql  = "SELECT id,client,date_e,sum(net) As total_net,sum(reliquat) As total_reliquat ";$date_enc="2011-01-01";
	//$sql .= "FROM commandes where date_e between '$du' and '$au' and vendeur='$vendeur' group by id ORDER BY client;";
	$sql .= "FROM commandes where vendeur='$vendeur_g' group by vendeur ORDER BY client;";
	$users1 = db_query($database_name, $sql);
	
	while($users_ = fetch_array($users1)) { ?>
<? $client=$users_["client"];$d=$users_["date_e"];$net=$users_["net"];$encompte_client_mps=$users_["total_reliquat"];$net=$users_["total_net"];?>
<?php $vendeur=$users_["vendeur"];$ca=$ca+$net;$reliquat_mps=$reliquat_mps+$encompte_client_mps;$id=$users_["id"];



			/*$sql = "UPDATE commandes SET ";
			
			$sql .= "reliquat = '" . $net . "' ";
			
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);*/




if ($encompte_client_mps>0){?>



<td align="right"><?php echo number_format($encompte_client_mps,2,',',' ');?></td>
<? } else { ?>
<td align="right"><?php ?></td>
				
<? } }



$sql  = "SELECT id,client,date_e,sum(net) As total_net,sum(reliquat) As total_reliquat ";$date_enc="2011-01-01";
	//$sql .= "FROM commandes where date_e between '$du' and '$au' and vendeur='$vendeur' group by id ORDER BY client;";
	$sql .= "FROM commandes where vendeur='$vendeur_g' group by vendeur ORDER BY client;";
	$users1jp = db_query_jp($database_name, $sql);
	
	while($users_jp = fetch_array($users1jp)) { ?>
<? $client=$users_jp["client"];$d=$users_jp["date_e"];$net=$users_jp["net"];$encompte_client_jp=$users_jp["total_reliquat"];$net=$users_jp["total_net"];?>
<?php $vendeur=$users_jp["vendeur"];$ca=$ca+$net;$reliquat_jp=$reliquat_jp+$encompte_client_jp;$id=$users_jp["id"];



			/*$sql = "UPDATE commandes SET ";
			
			$sql .= "reliquat = '" . $net . "' ";
			
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);*/




if ($encompte_client_jp>0){?>



<td align="right"><?php echo number_format($encompte_client_jp,2,',',' ');?></td>
<? } else { ?>
<td align="right"><?php ?></td>
				
<? } } 


?>

<td align="right"><?php echo number_format($encompte_client_mps+$encompte_client_jp,2,',',' ');?></td>
<? if ($plafond-$encompte_client_mps-$encompte_client_jp>0 or $plafond==0){?>
<td align="right"><?php echo number_format($plafond-$encompte_client_mps-$encompte_client_jp,2,',',' ');?></td>
<?php } else { ?>
<td align="right" style="background-color:#FF0000"><?php echo number_format($plafond-$encompte_client_mps-$encompte_client_jp,2,',',' ');?></td>
<?php } ?>
<?php } ?>
<tr><td></td>
<td></td>
<td align="right"><?php echo number_format($reliquat_mps,2,',',' ');?></td>
<td align="right"><?php echo number_format($reliquat_jp,2,',',' ');?></td>
<td></td></tr>
</table>

<p style="text-align:center">



</body>

</html>