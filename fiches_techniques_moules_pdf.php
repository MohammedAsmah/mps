<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
		
	$sql  = "SELECT * ";
	$sql .= "FROM fiches_techniques group by numero_moule ORDER BY accessoire ;";
	$users = db_query($database_name, $sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "fiche_technique_moule.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><table class="table2">

<p style="text-align:center">

<table class="table2">

<tr>
<th><?php echo "Numero";?></th>
	<th><?php echo "Libelle";?></th>
	<th><?php echo "Categorie";?></th>
	
	<th><?php echo "Hauteur";?></th>
	
		
</tr>

<?php $poids=0;$compt=0;while($users_ = fetch_array($users)) { ?><tr>
	
	<? $user_id=$users_["id"];$compt=$compt+1;$id_produit=$users_["id_produit"];
	$sql  = "SELECT * ";
			$sql .= "FROM produits  where id='$id_produit' ORDER BY produit ASC;";
			$usersp = db_query($database_name, $sql);$user_pp = fetch_array($usersp);
			$image = $user_pp["image"];$produit = $user_pp["produit"];
	?>
	<td><?php $numero_moule=$users_["numero_moule"];echo $numero_moule ; $couleur_moule=$users_["couleur_moule"];?></td>
    <td><?php $acc=$users_["accessoire"];echo $acc ; ?></td>
	
	<td bgcolor="<? echo "MOULES";?>"><?php ?></td>
	
   <td align="center"><?php  $cycle=$users_["cycle_moule"];$v1=$users_["v1"];$v2=$users_["v2"];$v3=$users_["v3"];echo "Dim : ".$v1." x ".$v2." x ".$v3." Cycle : ".$cycle ; ?></td>
   
	
	
	<td>
	<table>
		
		
	</table>
	</td>
	
	
   
		
	
<?php } ?>
<tr><td></td><td></td><td></td><td></td><td></td>


</table>

<p style="text-align:center">

</body>

</html>