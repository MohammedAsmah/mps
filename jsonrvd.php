<?php
    //open connection to mysql db
    $connectionmps = mysqli_connect("datamjpmps.mysql.db","datamjpmps","Marwane06","datamjpmps") or die("Error1 " . mysqli_error($connectionmps));
	//$connectionjp = mysqli_connect("datamjpjaouda.mysql.db","datamjpjaouda","Marwane06","datamjpjaouda") or die("Error2 " . mysqli_error($connectionjp));
?>
<?php
    //fetch table rows from mysql db
	
	$registre=$_GET['registre'];
    $sql = "select * from commandes where id_registre ='$registre' order by id";
    $result = mysqli_query($connectionmps, $sql) or die("Error in Selecting " . mysqli_error($connectionmps));
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
