<?php
    //open connection to mysql db
    $connection = mysqli_connect("datamjpmps.mysql.db","datamjpmps","Marwane06","datamjpmps") or die("Error1 " . mysqli_error($connection));
	//$connectionjp = mysqli_connect("datamjpjaouda.mysql.db","datamjpjaouda","Marwane06","datamjpjaouda") or die("Error2 " . mysqli_error($connectionjp));
?>
<?php
    //fetch table rows from mysql db
	$today=date("Y-m-d");
	
		
    $sql = "select * from commandes where week(NOW()) = week(date_e) and year(NOW()) = year(date_e) order by client";
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
