<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$caisse="";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$date = dateFrToUs($_REQUEST["date"]);$caisse = $_REQUEST["caisse"];$libelle = $_REQUEST["libelle"];$type = $_REQUEST["type"];
			$debit = $_REQUEST["debit"];$credit = $_REQUEST["credit"];$imputation = $_REQUEST["imputation"];
			if(isset($_REQUEST["non_pris"])) { $non_pris = 1; } else { $non_pris = 0; }
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
				

			
			break;

			case "update_user":

			
			
			
			break;
			
			case "delete_user":
			
			
			
					
			break;


		} //switch
	} //if
	
	$profiles_list_caisse = "";$caisse_list="";$action="Recherche";
	$sql1 = "SELECT * FROM liste_banques ORDER BY profile_name;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($caisse_list == $temp_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_caisse .= "<OPTION VALUE=\"" . $temp_["profile_name"] . "\"" . $selected . ">";
		$profiles_list_caisse .= $temp_["profile_name"];
		$profiles_list_caisse .= "</OPTION>";
	}
		if(isset($_REQUEST["action"]))
	{}else{

	?>
	<form id="form" name="form" method="post" action="journal_banques_editions.php">
	<td><?php echo "BANQUE  : "; ?></td><td><select id="caisse_list" name="caisse_list"><?php echo $profiles_list_caisse; ?></select>
	<td><?php echo "Du : "; ?><input type="text" id="du" name="du" value="<?php echo $du; ?>" size="15"></td>
	<td><?php echo "Au : "; ?><input type="text" id="au" name="au" value="<?php echo $au; ?>" size="15"></td>
	
	
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	<? }
	
	$exe="2008-01-01";
	if(isset($_REQUEST["action"]))
	{
		$caisse_list=$_POST['caisse_list'];$du=dateFrToUs($_POST['du']);$datefr_du=$_POST['du'];$banque=$_POST['caisse_list'];
		$au=dateFrToUs($_POST['au']);$datefr_au=$_POST['au'];
		if (isset($_REQUEST["du"])){
			$sql  = "SELECT * ";
			$sql .= "FROM journal_banques where caisse='$caisse_list' and date>'$exe' and erreur=0 ORDER BY date,id;";
			$users = db_query($database_name, $sql);
			
		}
	}
	else
	{		

		
	}
	

	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "journal_banque.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Banque : ".$caisse_list." du : ".$datefr_du." au : ".$datefr_au; ?></span>

<p style="text-align:center">


<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Libelle";?></th>
	<th><?php echo "Imputation";?></th>
	<th><?php echo "Debit";?></th>
	<th><?php echo "Credit";?></th>
	<th><?php echo "Solde";?></th>
</tr>

<?php $debit=0;$credit=0;$sss=0;$solde=0 ; while($users_ = fetch_array($users)) { $solde=$solde+($users_["credit"]-$users_["debit"]);
if ($users_["date"]>=$du and $users_["date"]<=$au){?><tr>
<td><?php echo dateUsToFr($users_["date"]);?></td>
<? $non_pris=$users_["non_pris"];if ($non_pris){$debit=$users_["debit"];
if ($debit>0){

?>
<td><?php $libelle=$users_["libelle"];print("<font size=\"3\" face=\"Comic sans MS\" color=\"FF3300\">$libelle </font>"); ?></td>
<? } else { ?>
<td><?php $libelle=$users_["libelle"];print("<font size=\"3\" face=\"Comic sans MS\" color=\"0000FF\">$libelle </font>"); ?></td>
<? } ?>
<? } else { ?>
<td><?php $libelle=$users_["libelle"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$libelle </font>"); ?></td>
<? } ?>

<td><?php $imputation=$users_["imputation"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$imputation </font>"); ?></td>
<?php $caisse=$users_["caisse"];?>
<?php $type=$users_["type"];?>
<td align="right"><?php $debit=$debit+$users_["debit"];$d=number_format($users_["debit"],2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$d </font>"); ?></td>
<td align="right"><?php $credit=$credit+$users_["credit"];$c=number_format($users_["credit"],2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$c </font>"); ?></td>
<td align="right"><?php 

//$solde=$solde+($users_["credit"]-$users_["debit"]);

if ($solde<=0){$s1=$solde*-1;$signe="DB";}else {$s1=$solde*1;$signe="CR";}

$ss=number_format($s1,2,',',' ');
if ($signe=="CR"){
print("<font size=\"1\" face=\"Comic sans MS\" color=\"FF3300\">$ss $signe </font>");
}
else
{
print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$ss $signe </font>");
}


 ?></td>

<? }
			
?>

<?php } ?>
<? if(isset($_REQUEST["action"]))
	{
 echo "<tr><td><a href=\"\\mps\\tutorial\\tresorerie.php?du=$du&au=$au&banque=$banque\">Imprimer</a></td></tr>";
	}
	?>
</table>

<p style="text-align:center">

</body>

</html>