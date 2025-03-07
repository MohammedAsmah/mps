<?php
    //open connection to mysql db
    $connection = mysqli_connect("datamjpmps.mysql.db","datamjpmps","Marwane06","datamjpmps") or die("Error1 " . mysqli_error($connection));
	//$connectionjp = mysqli_connect("datamjpjaouda.mysql.db","datamjpjaouda","Marwane06","datamjpjaouda") or die("Error2 " . mysqli_error($connectionjp));
?>
<?php
    //fetch table rows from mysql db
	$today=date("Y-m-d");
	$today=$_GET['date'];$today1=$_GET['date1'];
	
	
	
	
	
    $sql = "select * from registre_vendeurs where date ='$today' order by id";
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
	else{$sql = "select id,date_e As date,vendeur,date_e As datefr,net As montant,destination,client As observation from commandes where date_e ='$today' order by id";
    $result1 = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));
	
	$emparray = array();
    while($row =mysqli_fetch_assoc($result1))
    {
        $emparray[] = $row;
    }	
	}	
	
	
	//LUNDI
	$size= sizeof($emparray);
	if ($size>0){}
	else{$sql = "select * from registre_vendeurs where date ='$today1' order by id";
    $result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));
	
	$emparray = array();
    while($row =mysqli_fetch_assoc($result1))
    {
        $emparray[] = $row;
    }	
	}	
	
	//LUNDI
	$size= sizeof($emparray);
	if ($size>0){}
	else{$sql = "select id,date_e As date,vendeur,date_e As datefr,net As montant,destination,client As observation from commandes where date_e ='$today1' order by id";
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
