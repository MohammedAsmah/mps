<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
			$hostname_smoby = "appbo.jaoudaplastic.ma"; // nom de votre serveur
			$database_smoby = "appbojaoudaplast_prod"; // nom de votre base de données
			$username_smoby = "appbojaoudaplast_bo"; // nom d'utilisateur (root par défaut) !!! 
			$password_smoby = "yHHzKfX(Y]l5"; // mot de passe (aucun par défaut mais il est conseillé d'en mettre un)
			
			
			
			$mysqli = new mysqli("$hostname_smoby", "$username_smoby", "$password_smoby", "$database_smoby");
			$con=mysqli_connect("$hostname_smoby", "$username_smoby", "$password_smoby", "$database_smoby");
				
			// Check connection
			if ($mysqli->connect_error) {
				die("Connection failed: " . $mysqli->connect_error);
			}
			else
			{echo "connected";}
		
		
		$action="recherche";$date_order=date("Y-m-d");
	
	
	

	
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
	<th><?php echo "Article";?></th>
	<th><?php echo "ancien stock";?></th>
	<th><?php echo "nouveau stock";?></th>
	

</tr>
<? $t=0;
$ret=mysqli_query($con,"select * from articles where com_id=1");
$cnt=1;
$row=mysqli_num_rows($ret);
if($row>0){
while ($row=mysqli_fetch_array($ret)) {
			  
			?>
		  
		  <tr><td align="center"><?php $article=$row[1];echo $article;$eid=$row[0];?></td>
			<td align="center"><?php echo $row["8"];?></td>
			
			<?php 
			
			//ajout sur systeme
			$stock=0;
			$sql  = "SELECT * ";
						$sql .= "FROM produits WHERE produit = '$article' ;";
						$user = db_query($database_name, $sql);
						$user_ = fetch_array($user);$stock = $user_["stock_simulation"];
										
			 $query=mysqli_query($con, "update articles set stock_reel='$stock' where name='$article'");
     
				if ($query) {
				  }
			  else
				{
				  //echo "<script>alert('Something Went Wrong. Please try again');</script>";
				}			
			
			?><td align="center"><?php echo $stock;?></td>
			
			
				  
			
		 <? }
		  
		}

		
?>
</table>


</body>

</html>