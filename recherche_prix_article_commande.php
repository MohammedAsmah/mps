<?php
	
	require "config.php";
	require "connect_db.php";
	require "functions.php";
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();	$user_name=GetUserName();



$q=$_GET["q"];$dt="2014-08-09";

$con = mysql_connect('datamjpmps.mysql.db', 'datamjpmps', 'Marwane06');
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("datamjpmps", $con);


//entrees
			$sql1  = "SELECT produit,date,sum(depot_a) As total_depot_a,sum(depot_b) As total_depot_b,sum(depot_c) As total_depot_c ";
			$du="2009-01-01";$au=dateFrToUs(date("d/m/y"));
			$sql1 .= "FROM entrees_stock where produit='$q' and date>'$du' group BY produit;";
			$users11 = mysql_query($sql1);while($users1 = mysql_fetch_array($users11))
			{
			$e_depot_a = $users1["total_depot_a"];$e_depot_b = $users1["total_depot_b"];$e_depot_c = $users1["total_depot_c"];
			}
			//sorties
			$sql2  = "SELECT produit,date,sum(depot_a) As total_depot_a,sum(depot_b) As total_depot_b,sum(depot_c) As total_depot_c ";
			$du="2009-01-01";$au=dateFrToUs(date("d/m/y"));
			$sql2 .= "FROM bon_de_sortie_magasin where produit='$q' and date>'$du' group BY produit;";
			$users111 = mysql_query($sql2);while($users2 = mysql_fetch_array($users111))
			{$s_depot_a = $users2["total_depot_a"];$s_depot_b = $users2["total_depot_b"];$s_depot_c = $users2["total_depot_c"];
			$mps=$e_depot_a-$s_depot_a;$jaouda=$e_depot_b-$s_depot_b;}
			//encours
			$sql3  = "SELECT produit,date,sum(quantite) As total_depot_a ";
			$sql3 .= "FROM detail_commandes where produit='$q' and date='$dt' group BY produit;";
			$users1111 = mysql_query($sql3);while($users22 = mysql_fetch_array($users1111))
			{$encours = $users22["total_depot_a"];}if ($encours>0){$text = "Commandes en cours :".$encours." paquets";}else{$text="";}

  if($mps+$jaouda<50){echo "<tr>";
  echo "<td>" . "MPS : ".$mps ."  - JAOUDA : ".$jaouda. "  --> Stock Article < 50 paquets"."</td>";}//echo "<td>" .$text."</td>";
  echo "</tr>";

mysql_close($con);
?> 
