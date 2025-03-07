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

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$employe = $_REQUEST["employe"];$ref = $_REQUEST["ref"];$service = $_REQUEST["service"];
			$poste = $_REQUEST["poste"];if(isset($_REQUEST["statut"])) { $statut = 1; } else { $statut = 0; }
			$t_h_normales = $_REQUEST["t_h_normales"];$t_h_25 = $_REQUEST["t_h_25"];$t_h_50 = $_REQUEST["t_h_50"];
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				$sql  = "INSERT INTO employes ( code, employe,service,statut,poste )
				 VALUES ('$ref','$employe','$service','$statut','$poste')";

				db_query($database_name, $sql);
			

			break;

			case "update_user":
			$user_id=$_REQUEST["user_id"];
			$sql = "UPDATE employes SET ref = '$ref',employe = '$employe',t_h_normales='$t_h_normales',
				t_h_25='$t_h_25',t_h_50='$t_h_50',valide=1,statut='$statut' WHERE id = '$user_id'";
			db_query($database_name, $sql);
			
			break;
			
			case "delete_user":
			

			// delete user's profile
			$sql = "DELETE FROM employes WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	$sql  = "SELECT * ";$occ="occasionnelles";$per="permanents";$vide="";
	$sql .= "FROM employes where employe<>'$vide' and statut=0 and (service='$occ' or service='$per') ORDER BY service DESC ,ordre,ordre1,date_entree;";
	$users = db_query($database_name, $sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste "; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "employe2.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php $date_e=date("d/m/Y h:m:s");

	$sql  = "SELECT * ";
	$sql .= "FROM paie_ouvriers ORDER BY id;";
	$users2 = db_query($database_name, $sql);
	
	while($users_2 = fetch_array($users2)) 
	{ if ($users_2["encours"]==1){$du=$users_2["du"];$au=$users_2["au"];}
	}
echo "DECOMPTE MONAIE Du $du au $au "; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Nom et Prenom ";?></th>
	<th><?php echo "NET 1";?></th>
	<th><?php echo "NET 2";?></th>
	<th><?php echo "TOTAL";?></th>
	<th><?php echo "200";?></th>
	<th><?php echo "100";?></th>
	<th><?php echo " 50 ";?></th>
	<th><?php echo " 20 ";?></th>
	<th><?php echo " 10 ";?></th>
	<th><?php echo " 5 ";?></th>
	<th><?php echo " 1 ";?></th>
	
	
	
</tr>

<?php $tr=0;$ser="";

$deux_cents_t=0;
$cents_t=0;
$cinquante_t=0;
$vingt_t=0;
$dix_t=0;
$cinq_t=0;
$un_t=0;
$total1=0;
$total2=0;

while($users_ = fetch_array($users)) { 
				
?><tr>
<? if ($tr==0 and $ser<>$users_["service"])
{?><tr><td bgcolor="#66CCCC"><?php $ser==$users_["service"];$tr=1;echo $users_["service"];?></td></tr><? }?>
<? $tt=$users_["t_h_normales"]+($users_["t_h_25"]*1.25)+($users_["t_h_50"]*1.50);
if ($tt>0){?>
<td><?php echo $users_["employe"];?></td>
<td align="right"><?php echo number_format($users_["net1"],2,',',' '); $total1=$total1+$users_["net1"];?></td>
<td align="right"><?php echo number_format($users_["net2"],2,',',' '); $total2=$total2+$users_["net2"];?></td>
<td align="right"><?php $net=round($users_["net1"]+$users_["net2"]);echo number_format($net,2,',',' ');$total=$total+$users_["net1"]; ?></td>
<td align="center"><?php $deux_cents=intval($net/200);echo $deux_cents;$reste=$net-($deux_cents*200); $deux_cents_t=$deux_cents_t+$deux_cents;?></td>
<td align="center"><?php $cent= intval($reste/100);echo $cent;$reste=$net-($deux_cents*200)-($cent*100);$cents_t=$cents_t+$cent; ?></td>
<td align="center"><?php $cinquante=intval($reste/50);echo $cinquante;$reste=$net-($deux_cents*200)-($cent*100)-($cinquante*50);$cinquante_t=$cinquante_t+$cinquante;?></td>
<td align="center"><?php $vingt=intval($reste/20);echo $vingt;$reste=$net-($deux_cents*200)-($cent*100)-($cinquante*50)-($vingt*20);$vingt_t=$vingt_t+$vingt;?></td>
<td align="center"><?php $dix=intval($reste/10);echo $dix;$reste=$reste -($dix*10);$dix_t=$dix_t+$dix;?></td>
<td align="center"><?php $cinq=intval($reste/5);echo $cinq;$reste=$net-($deux_cents*200)-($cent*100)-($cinquante*50)-($vingt*20)-($dix*10)-($cinq*5);$cinq_t=$cinq_t+$cinq; ?></td>
<td align="center"><?php $reste=$net-($deux_cents*200)-($cent*100)-($cinquante*50)-($vingt*20)-($dix*10)-($cinq*5);echo $reste;$un=$reste;$un_t=$un_t+$un;?></td>


<? }?>

<?php } ?>

<tr><td></td>
<td align="center"><?php echo number_format($total1,2,',',' ');?></td>
<td align="center"><?php echo number_format($total2,2,',',' ');?></td>
<td align="center"><?php echo number_format($total1+$total2,2,',',' ');?></td>
<td align="center"><?php echo $deux_cents_t;?></td>
<td align="center"><?php echo $cents_t;?></td>
<td align="center"><?php echo $cinquante_t;?></td>
<td align="center"><?php echo $vingt_t;?></td>
<td align="center"><?php echo $dix_t;?></td>
<td align="center"><?php echo $cinq_t;?></td>
<td align="center"><?php echo $un_t;?></td>


</table>

<p style="text-align:center">


</body>

</html>