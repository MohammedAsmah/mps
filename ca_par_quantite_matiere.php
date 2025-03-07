<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";	$du="";$au="";$action="Recherche";$matiere="";$du1="";$au1="";
	$profiles_list_matiere = "";
	$sql3 = "SELECT * FROM types_matieres ORDER BY profile_name;";
	$temp = db_query($database_name, $sql3);
	while($temp_ = fetch_array($temp)) {
		if($matiere == $temp_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_matiere .= "<OPTION VALUE=\"" . $temp_["profile_name"] . "\"" . $selected . ">";
		$profiles_list_matiere .= $temp_["profile_name"];
		$profiles_list_matiere .= "</OPTION>";
	}

	
	?>
	<form id="form" name="form" method="post" action="ca_par_quantite_matiere.php">
	<td><?php echo "Du : "; ?><input type="text" id="du" name="du" value="<?php echo $du; ?>" size="15"></td>
	<td><?php echo "Au : "; ?><input type="text" id="au" name="au" value="<?php echo $au; ?>" size="15"></td>
	<td><?php echo "Matiere : "; ?></td><td><select id="matiere" name="matiere"><?php echo $profiles_list_matiere; ?></select>
	<tr>
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<?
	if(isset($_REQUEST["action"]))
	{
	 $du=dateFrToUs($_POST['du']);$au=dateFrToUs($_POST['au']);$matiere=$_POST['matiere'];$du1=$_POST['du'];$au1=$_POST['au'];
	}
	
?>
</table>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "Detail Evaluation"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "produit.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>
<span style="font-size:24px"><?php echo "Matiere : $matiere du : $du1 au $au1"; ?></span>

<table class="table2">

<tr>
	<th><?php $total=0;$pt=0;echo "Produit";?></th>
	<th><?php echo "Quantité";?></th>
	<th><?php echo "Poids Unit /g";?></th>
	<th><?php echo "Poids Total /kg";?></th>
</tr>

<?	
	$sql  = "SELECT * ";
	$sql .= "FROM produits where matiere='$matiere' ORDER BY produit;";
	$users = db_query($database_name, $sql);
	while($users_ = fetch_array($users)) { 
 		$produit = $users_["produit"];$condit1 = $users_["condit"];$qte=0;$poids = $users_["poids"];$montant=0;$condit=0;
	
	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_factures where produit='$produit' and (date_f between '$du' and '$au' ) ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users1_ = fetch_array($users1)) { 
			$qte=$qte+($users1_["quantite"]*$users1_["condit"]);
	
	}
	
	if ($qte>0)
	
	{?>
<td align="left"><?php echo $produit; ?></td>
<td align="center"><?php echo $qte; ?></td>
<td align="right"><?php echo $poids; ?></td>
<td align="right"><?php $p=($poids*$qte)/1000;echo number_format($p,2,',',' '); $pt=$pt+$p;?></td>
</tr>
<?	} }?>
<td></td><td></td><td></td>
<td align="right"><?php echo number_format($pt,2,',',' '); ?></td>
</table>

<p style="text-align:center">


</body>

</html>