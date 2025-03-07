<?php
    //open connection to mysql db
    $connection = mysqli_connect("datamjpmps.mysql.db","datamjpmps","Marwane06","datamjpmps") or die("Error1 " . mysqli_error($connection));
	//$connection = mysqli_connect("datamjpjaouda.mysql.db","datamjpjaouda","Marwane06","datamjpjaouda") or die("Error2 " . mysqli_error($connection));
?>
<?php
    //fetch table rows from mysql db
	
	//$date = date_create('2021-10-16');
	
	
	$date=date_create($_GET['date']);
	$mois = $date->format('m');
	$annee = $date->format('y');
	$produit=$_GET['produit'];
	$mois = $date->format('m');$annee = $date->format('Y');
    $sql  = "SELECT id,date,produit,machine,sum(prod_6_14) As prod_6_14,sum(prod_14_22) As prod_14_22,sum(prod_22_6) As prod_22_6, ";
	$sql .= "FROM details_production where produit='$produit' and week(NOW()) = week(date) and year(NOW()) = year(date) GROUP BY date order by date ;";
	$result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));
?>
<?php
    //create an array
    $emparray = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $emparray[] = $row;
    }
?>

<?php 
    echo json_encode($emparray);
	//echo json_encode($emparray1);
?>
