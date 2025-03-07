<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$user_name=GetUserName();
	$error_message = "";
	$type_service="SEJOURS ET CIRCUITS";
	//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$login = $user_["login"];
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	
	// recherche ville
	?>
	
	<?
	
	 if(isset($_REQUEST["action"])){$date1 = dateFrToUs($_POST["date1"]);}else{ $action="Recherche";$date1=date("d/m/Y");?>
	<form id="form" name="form" method="post" action="stock_produits2.php">
	<td><?php echo "Date : "; ?><input onClick="ds_sh(this);" name="date1" value="<?php echo $date1; ?>" readonly="readonly" style="cursor: text" /></td>
	<input type="submit" id="action" name="action" value="<?php echo $action; ?>">
	</form>
	
	<? }

	
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Produits"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">


</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>





</table>









<? $sql  = "SELECT * ";$vide="";$article="article";$variante="MEUBLE NAKHLA";
	$sql .= "FROM produits where dispo=1 and produit<>'$vide' and stockable=1 and fictif=0 and id>=400 and id<700 ORDER BY produit;";
	$users = db_query($database_name, $sql);?>



<span style="font-size:24px"><?php $jour=date("d/m/y");$d=$_POST["date1"];echo "Etat de Stock Au : $d"; ?></span>

<table class="table2">

<tr>
<th><?php echo "CB PIECE";?></th>
<th><?php echo "CB PAQUET";?></th>
	<th><?php echo "Article";?></th>
	<th><?php echo "Etat";?></th>
	<th><?php echo "MPS";?></th>
	<th><?php echo "JAOUDA";?></th>
	<th><?php echo "S.TOTAL";?></th>
	<th><?php echo "SORTIES";?></th>
		<th><?php echo "MVT";?></th>
</tr>

<?php while($users_ = fetch_array($users)) { ?>

<?php $id=$users_["id"];$produit=$users_["produit"];$stock_controle=$users_["stock_controle"];$barecode_piece=$users_["barecode_piece"];$barecode_paquet=$users_["barecode"];
$famille=$users_["famille"];$stock_simulation=$users_["stock_simulation"];$stock_mps=$users_["stock_mps"];$stock_jp=$users_["stock_jp"];

//*************************** promotion back a fleurs
/*if ($produit=="BAC A FLEURS GM + SECOUPE"){$pr="BAC A FLEURS GM";}else{$pr=$produit;}*/


//***************************


?>
			
			<? 
			//entrees
			
			if(isset($_REQUEST["action"])){$du="2017-03-03";$au=dateFrToUs(date("d/m/y"));
			
			$sql1  = "SELECT produit,date,sum(depot_a) As total_depot_a,sum(depot_b) As total_depot_b,sum(depot_c) As total_depot_c ";
			$sql1 .= "FROM entrees_stock where produit='$produit' and (date between '$du' and '$date1' ) group BY produit;";
			$users11 = db_query($database_name, $sql1);$users1 = fetch_array($users11);
			$e_depot_a = $users1["total_depot_a"];$e_depot_b = $users1["total_depot_b"];$e_depot_c = $users1["total_depot_c"];
			
			$du="2017-03-03";$au=dateFrToUs(date("d/m/y"));
			$sql1  = "SELECT produit,date,sum(depot_a) As total_depot_a,sum(depot_b) As total_depot_b,sum(depot_c) As total_depot_c ";
			$sql1 .= "FROM bon_de_sortie_magasin where produit='$produit' and (date between '$du' and '$date1' ) group BY produit;";
			$users111 = db_query($database_name, $sql1);$users2 = fetch_array($users111);
			$s_depot_a = $users2["total_depot_a"];$s_depot_b = $users2["total_depot_b"];$s_depot_c = $users2["total_depot_c"];
			$mps=$e_depot_a-$s_depot_a;$jaouda=$e_depot_b-$s_depot_b;
			}
			
			?>
			
			
<tr><td bgcolor="#66CCCC"><? echo $barecode_piece; ?></td>
<td bgcolor="#66CCCC"><? echo $barecode_paquet; ?></td>
<td bgcolor="#66CCCC"><? $user_id=$users_["id"];echo "<a href=\"fiche_de_stock.php?date=$date1&user_id=$user_id\">".$produit."</a>"; ?></td>

<td bgcolor="#66CCCC"><?php if(!$stock_controle) { echo "    N.C"; }; ?></td>
<td bgcolor="#66CCCC"><?php $stock_mps=$stock_mps+$e_depot_a-$s_depot_a; echo $e_depot_a-$s_depot_a;?></td>
<td bgcolor="#66CCCC"><?php $stock_jp=$stock_jp+$e_depot_b-$s_depot_b; echo $e_depot_b-$s_depot_b;?></td>
<td bgcolor="#66CCCC"><?php $stock_simulation=$stock_mps+$stock_jp; echo $stock_simulation;?></td>

<td bgcolor="#66CCCC"><? $user_id=$users_["id"];echo "<a href=\"fiche_de_stock_s.php?date=$date1&user_id=$user_id\">sorties</a>"; ?></td>
<td bgcolor="#66CCCC"><? $user_id=$users_["id"];echo "<a href=\"fiche_de_stock_mvt.php?produit=$produit\">mvt</a>"; ?></td>
<?php 

//mise à jour stock
$stock_simulation=($e_depot_a-$s_depot_a+$e_depot_a_se)+($e_depot_b-$s_depot_b+$e_depot_b_se);
$stock_mps=$e_depot_a-$s_depot_a+$e_depot_a_se;$stock_jp=$e_depot_b-$s_depot_b+$e_depot_b_se;
$sql1 = "UPDATE produits SET stock_simulation = $stock_simulation,date_simulation='$au',stock_mps=$stock_mps,stock_jp=$stock_jp WHERE produit='$produit'";
	db_query($database_name, $sql1);

} ?>

</table>
<p></p>
<td bgcolor="#66CCCC"><? echo "<a href=\"editer_stock_produits.php?du=$du&date1=$date1\">Imprimer</a>"; ?></td>
<? if ($login=="admin"){?>
<td bgcolor="#66CCCC"><? echo "<a href=\"editer_stock_produits_controle.php?du=$du&date1=$date1\">Imprimer 2</a>"; ?></td>
<? }?>
<p style="text-align:center">

</body>

</html>
