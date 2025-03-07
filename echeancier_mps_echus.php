<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$caisse="";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	$du1=date("d/m/Y");$date=date("Y-m-d");$fin_exe="2011-12-31";$t=0;
	/*$sql  = "SELECT id,designation,sum(montant_echeance) as t_m,date_echeance ";
	$sql .= "FROM echeances_credits where date_echeance<'$date' group by id order BY date_echeance DESC;";
	$users = db_query($database_name, $sql);*/
/*while($users_ = fetch_array($users)) { 
	
			$date_echeance=$users_["date_echeance"];$id=$users_["id"];
			list($annee1,$mois1,$jour1) = explode('-', $date_echeance); 
			$date = mktime(0,0,0,$mois1,$jour1,$annee1); 
			$mois=date("M",$date);
				if ($mois=="May"){$mois1="MAI";$mois_v=5;}
				if ($mois=="Jun"){$mois1="JUIN";$mois_v=6;}
				if ($mois=="Jul"){$mois1="JUIL";$mois_v=7;}
				if ($mois=="Aug"){$mois1="AOUT";$mois_v=8;}
				if ($mois=="Sep"){$mois1="SEP";$mois_v=9;}
				if ($mois=="Oct"){$mois1="OCT";$mois_v=10;}
				if ($mois=="Nov"){$mois1="NOV";$mois_v=11;}
				if ($mois=="Dec"){$mois1="DEC";$mois_v=12;}
				if ($mois=="Jan"){$mois1="JAN";$mois_v=1;}
				if ($mois=="Feb"){$mois1="FEV";$mois_v=2;}
				if ($mois=="Mar"){$mois1="MARS";$mois_v=3;}
				if ($mois=="Apr"){$mois1="AVRIL";$mois_v=4;}
			$sql = "UPDATE echeances_credits SET mois = '$mois_v' WHERE id = $id ";
			db_query($database_name, $sql);
}*/

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">


</head>

<body style="background:#dfe8ff">
	
<table class="table2">
<tr><td><? $j=date("d/m/Y H:i:s");echo "Echeancier Echus Edite le : $j ";?></td></tr>
</table>
	
<?	

		
	$te=0;
		
	$sql  = "SELECT id,designation,sum(montant_echeance) as t_m,date_echeance ";
	$sql .= "FROM echeances_credits where date_echeance<='$date' group by id order BY date_echeance DESC;";
	$users = db_query($database_name, $sql);
	?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>


<p style="text-align:center">



<table class="table2">

<tr>
	<th><?php echo "Echeance";?></th>
	<th><?php echo "Designation";?></th>
	<th><?php echo "Montant";?></th>
</tr>

<?php $debit=0;$credit=0;
while($users_ = fetch_array($users)) { ?>
<?php 		$date_echeance=$users_["date_echeance"];
			list($annee1,$mois1,$jour1) = explode('-', $date_echeance); 
			$date = mktime(0,0,0,$mois1,$jour1,$annee1); 
			$mois=date("M",$date);
				if ($mois=="May"){$mois1="MAI";$mois_v=5;}
				if ($mois=="Jun"){$mois1="JUIN";$mois_v=6;}
				if ($mois=="Jul"){$mois1="JUIL";$mois_v=7;}
				if ($mois=="Aug"){$mois1="AOUT";$mois_v=8;}
				if ($mois=="Sep"){$mois1="SEP";$mois_v=9;}
				if ($mois=="Oct"){$mois1="OCT";$mois_v=10;}
				if ($mois=="Nov"){$mois1="NOV";$mois_v=11;}
				if ($mois=="Dec"){$mois1="DEC";$mois_v=12;}
				if ($mois=="Jan"){$mois1="JAN";$mois_v=1;}
				if ($mois=="Feb"){$mois1="FEV";$mois_v=2;}
				if ($mois=="Mar"){$mois1="MARS";$mois_v=3;}
				if ($mois=="Apr"){$mois1="AVRIL";$mois_v=4;}?>
<tr><td><? echo dateUsToFr($date_echeance);?></td>
<td><? echo $users_["designation"];?></td>
<td align="right"><?php $t=$t+$users_["t_m"];$te=$te+$users_["t_m"];echo number_format($users_["t_m"],2,',',' ');?></td>
<?php } ?>
<? if ($t>0){?>
<tr><td></td><td align="right"><? echo "Total : ";?></td>
<td align="right" bgcolor="#3366FF" width="150"><?php echo number_format($t,2,',',' ');?></td></tr>
<? }?>




</body>

</html>