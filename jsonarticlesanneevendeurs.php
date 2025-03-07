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
	
	$produit=$_GET['article'];$mois = $date->format('m');$annee = $date->format('Y');
	
	//echo $produit;echo $mois;
    $sql  = "SELECT produit,client,vendeur,condit,sum(quantite) As total_quantite ";
	$sql .= "FROM detail_commandes where produit='$produit' and YEAR(date) ='$annee' and escompte_exercice=0 GROUP BY produit,vendeur order by total_quantite DESC;";
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
