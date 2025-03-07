<?php
	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	$numero = $_REQUEST["numero"];$client = $_REQUEST["client"];
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	
	// recherche ville
	?>
	
	<?
	$sql  = "SELECT * ";
	$sql .= "FROM detail_bon_besoin where confirme=1 and bon_commande=0 ORDER BY commande,id;";
	$users1 = db_query($database_name, $sql);
	//reset 
	$activer=0;
	$action_="tableau";
	
	while($users_1 = fetch_array($users1)) { $sql = "UPDATE detail_bon_besoin SET palmares = $activer ";
	db_query($database_name, $sql);}
	
	$sql  = "SELECT * ";$article="article";
	$sql .= "FROM detail_bon_besoin where confirme=1 and bon_commande=0 ORDER BY commande,id;";
	$users = db_query($database_name, $sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Produits"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "enregistrer_panier_bc_mps.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
		<? require "body_cal.php";?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "liste Produits"; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Article";?></th>
</tr>
<form id="regForm" name="regForm" method="post" action="enregistrer_panier_bc_mps.php">
		
	<tr><td><input type="submit" name="Submit1" value="Articles selectionnés">
          </td></tr>
<?php while($users_ = fetch_array($users)) { $produit=$users_["produit"];$id_v=$users_["id"];$palmares=$users_["palmares"];?><tr>


       <td><input name="utilities1[]"<?php if($palmares) { echo " checked"; } ?> value="<? echo $id_v;?>" type="checkbox" 
			id="<? echo $id_v;?>"><? echo $produit;?> </td>



<? }?>
      <tr><td><input type="submit" name="Submit1" value="Articles selectionnés">
          </td>
	   
      </tr>
	  <input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">
<input type="hidden" id="numero" name="numero" value="<?php echo $numero; ?>">
<input type="hidden" id="client" name="client" value="<?php echo $client; ?>">
<input type="hidden" id="montant" name="montant" value="<?php echo $mt; ?>">
</form>
</table>

<p style="text-align:center">


</body>

</html>