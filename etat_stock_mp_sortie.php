<?php
	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url

	$action="recherche";
	
	// recherche ville

    if(isset($_REQUEST["action"])) { $date1 = $_REQUEST["date1"];$date2 = $_REQUEST["date2"];}
	else {$date1="";$date2="";}
	$action="recherche";

	 if(isset($_REQUEST["action"])){}else{ ?>
	<form id="form" name="form" method="post" action="etat_stock_mp_sortie.php">
	<td>
	<?php echo "Du : "; ?><input type="text" id="date1" name="date1" value="<?php echo $date1; ?>"></td>
	<td>
	<?php echo "Au : "; ?><input type="text" id="date2" name="date2" value="<?php echo $date2; ?>"></td>
	<input type="submit" id="action" name="action" value="<?php echo $action; ?>">
	</form>
	
	<? }
	if(isset($_REQUEST["action"]))
	{ $date=dateFrToUs($_POST['date1']);$date2=dateFrToUs($_POST['date2']);

	?>
	<? 
	
	$sql  = "SELECT * ";$t1="mp";$mr="MATIERE R";$mp="MATIERE P";
	$sql .= "FROM matieres_premieres where type='$mr' or type='$mp' ORDER BY produit;";
	$users = db_query($database_name, $sql);
    }

	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste articles commandes"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "histo_article_commande_mp.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php $aufr=date("d/m/Y");echo "SORTIE MATIERES PREMIERES DU $date AU $date2"; ?></span>

<table class="table2">

<tr>
	
	<th><?php echo "Article";?></th>
	<th><?php echo " Unite ";?></th>
	<th><?php echo " INITIAL ";?></th>
	<th><?php echo "ENTREE";?></th>
	<th><?php echo "SORTIE";?></th>
	<th><?php echo "STOCK";?></th>
</tr>

<?php 

$rt=0;$st=0;$stockt=0;
while($users_ = fetch_array($users)) { ?><tr>


<?php $produit=$users_["produit"]; 

$p=$users_["produit"];
	$sql  = "SELECT * ";$type="reception";$r=0;$s=0;$ini=$users_["stock_initial"];$du="2022-07-01";$au="2022-09-30";
	$sql .= "FROM entrees_stock_mp where produit='$p' and date between '$date' and '$date2' ORDER BY date;";
	$users1 = db_query($database_name, $sql);
	
	while($users_1 = fetch_array($users1)) {
	if ($users_1["type"]=="reception")
    {$r=$r+$users_1["depot_a"];$rt=$rt+$users_1["depot_a"];}
    else{$s=$s+$users_1["depot_a"];$st=$st+$users_1["depot_a"];}
	
	}
	$stock=$ini+$r-$s;$stockt=$stockt+$stock;
	$sql = "UPDATE matieres_premieres SET entrees = '$r',sorties = '$s' WHERE produit = '$p'";
			db_query($database_name, $sql);
	//if ($stock<>0){


echo "<td><a href=\"mvt_matieres.php?produit=$produit&au=$au\">$produit</a></td>";?>


<td bgcolor="#66CCCC" align="center"><?php echo $users_["unite"]; ?></td>
<td bgcolor="#66CCCC" align="right"><?php echo $users_["stock_initial"]; ?></td>
<?php
	
	
?>
<td bgcolor="#66CCCC" align="right"><?php echo $r; ?></td>
<td bgcolor="#66CCCC" align="right"><?php echo $s; ?></td>
<td bgcolor="#66CCCC" align="right"><?php echo $stock; ?></td>

	<? //} ?>

<?php } ?>
<tr><td bgcolor="#66CCCC" align="right"><?php  ?></td>
<td bgcolor="#66CCCC" align="right"><?php  ?></td>
<td bgcolor="#66CCCC" align="right"><?php  ?></td>
<td bgcolor="#66CCCC" align="right"><?php echo $rt; ?></td>
<td bgcolor="#66CCCC" align="right"><?php echo $st; ?></td>
<td bgcolor="#66CCCC" align="right"><?php echo $stockt; ?></td></tr>
</table>

<p style="text-align:center">


	
</body>

</html>