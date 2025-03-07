<?php
    //open connection to mysql db
    $connection = mysqli_connect("datamjpmps.mysql.db","datamjpmps","Marwane06","datamjpmps") or die("Error1 " . mysqli_error($connection));
	//$connection = mysqli_connect("datamjpjaouda.mysql.db","datamjpjaouda","Marwane06","datamjpjaouda") or die("Error2 " . mysqli_error($connection));
?>
<?php
    //fetch table rows from mysql db
	
	//$date = date_create('2021-10-16');
	
	
	$date=date_create($_GET['date']);$produit=$_GET['produit'];
	$mois = $date->format('m');
	//echo $date." ".$produit;
		
	$mois = $date->format('m');$annee = $date->format('Y');$annee = $annee-2;
    $sql  = "SELECT date,MONTH(date) As mois,YEAR(date) As annee,produit,condit,sum(quantite) As total_quantite ";
	$sql .= "FROM detail_commandes where YEAR(date) ='$annee' and escompte_exercice=0 and produit='$produit' GROUP BY MONTH(date) order by MONTH(date) DESC;";
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
