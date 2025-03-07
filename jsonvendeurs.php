<?php
    //open connection to mysql db
    $connection = mysqli_connect("datamjpmps.mysql.db","datamjpmps","Marwane06","datamjpmps") or die("Error1 " . mysqli_error($connection));
	//$connectionjp = mysqli_connect("datamjpjaouda.mysql.db","datamjpjaouda","Marwane06","datamjpjaouda") or die("Error2 " . mysqli_error($connectionjp));
?>
<?php
    //fetch table rows from mysql db
	
	$date=$_GET['date'];
    $sql  = "SELECT vendeur,date,sum(montant) As total_net ";
	$sql .= "FROM registre_vendeurs where date ='$date' GROUP BY vendeur order by total_net DESC;";
	$result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));
?>
<?php
    //create an array
    $emparray = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $emparray[] = $row;
    }
	
	
	$size= sizeof($emparray);

	if ($size>0){}
	else{$sql = "select vendeur,date_e,sum(net) As total_net from commandes where date_e ='$date' GROUP BY vendeur order by total_net DESC;";
    $result1 = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));
	
	$emparray = array();
    while($row =mysqli_fetch_assoc($result1))
    {
        $emparray[] = $row;
    }	
	}	
?>

<?php 
    echo json_encode($emparray);
	//echo json_encode($emparray1);
?>
