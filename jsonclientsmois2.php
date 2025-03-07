<?php
    //open connection to mysql db
    $connection = mysqli_connect("datamjpmps.mysql.db","datamjpmps","Marwane06","datamjpmps") or die("Error1 " . mysqli_error($connection));
	//$connectionjp = mysqli_connect("datamjpjaouda.mysql.db","datamjpjaouda","Marwane06","datamjpjaouda") or die("Error2 " . mysqli_error($connectionjp));
?>
<?php
    //fetch table rows from mysql db
	
	$date=$_GET['date'];$client=$_GET['client'];
	$date=date_create($_GET['date']);
	$mois = $date->format('m');
	$annee = $date->format('Y');
	$annee = $annee-2;
	
    $sql  = "SELECT id,client,vendeur,date_e,sum(net) As total_net,MONTH(date_e) As mois,YEAR(date_e) As annee ";$encours="encours";
	$sql .= "FROM commandes where YEAR(date_e) ='$annee' and client='$client' and evaluation<>'$encours' GROUP BY MONTH(date_e) order by MONTH(date_e) DESC;";

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
