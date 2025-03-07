<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
			$hostname_smoby = "appbo.jaoudaplastic.ma"; // nom de votre serveur
			$database_smoby = "appbojaoudaplast_prod"; // nom de votre base de données
			$username_smoby = "appbojaoudaplast_bo"; // nom d'utilisateur (root par défaut) !!! 
			$password_smoby = "yHHzKfX(Y]l5"; // mot de passe (aucun par défaut mais il est conseillé d'en mettre un)
			
			
			
			$mysqli = new mysqli("$hostname_smoby", "$username_smoby", "$password_smoby", "$database_smoby");

			echo $mysqli->host_info . "\n";

	
			// Check connection
			if ($mysqli->connect_error) {
				die("Connection failed: " . $mysqli->connect_error);
			}
			else
			{echo "connected";}
		
		
		
		
		$today="2024-11-14";
		$sql = "SELECT * FROM orders where delivery_date_clt='$today' ORDER BY delivery_date_clt";

		
	

	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head><? require "head_cal.php";?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "Production"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">



</head>

<body style="background:#dfe8ff"><? require "body_cal.php";?>


<table class="table2">

<tr>
	<th><?php echo "date";?></th>
	<th><?php echo "commande";?></th>
	<th><?php echo "client";?></th>
	

</tr>
<? $t=0;
if ($result = $mysqli -> query($sql)) {
		  while ($row = $result -> fetch_row()) {
			  
			  //printf ("%s (%s)\n", $row[0], $row[1]);?>
		  
		  <tr><td align="center"><?php $commande=$row[0];echo dateUsToFr($row["12"]);?></td>
			<td align="center"><?php echo $row["1"];?></td>
			<td align="center"><?php $id_client=$row["8"];
			
			$sql = "SELECT * FROM companies where id='$id_client' ORDER BY id";
			if ($result1 = $mysqli -> query($sql)) {
			$rowc = $result1 -> fetch_row();
			echo $rowc["1"];
			$client=$rowc["1"];
			}
			$result1 -> free_result();
			
			
			//ajout sur systeme
			$sql  = "SELECT * ";
						$sql .= "FROM clients WHERE client = '$client' ;";
						$user = db_query($database_name, $sql);
						$user_ = fetch_array($user);$remise10 = $user_["remise10"];
						$remise2 = $user_["remise2"];$remise3 = $user_["remise3"];$secteur1 = $user_["ville"];$type_remise1 = $user_["type_remise"];$escompte1 = $user_["escompte"];
			
			
			
			?></td>
			<td align="center"><?php echo $remise10;?></td>
			<td align="center"><?php echo $remise2;?></td>
			<td align="center"><?php echo $remise3;?></td>
			<td align="center"><?php echo $escompte1;?></td>
	
	
	
	
	</tr>
		  
		  
			
		 <? }
		  $result -> free_result();
		}

		$mysqli -> close();


/*while($users_ = fetch_array($users)) {?><tr>
	
	
	

<? }*/?>
</table>


</body>

</html>