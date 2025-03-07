<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$caisse="";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	
	$profiles_list_caisse = "";$caisse_list="";$action="Recherche";$du="";$au="";
	$sql1 = "SELECT * FROM liste_caisses ORDER BY profile_name;";
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
	<form id="form" name="form" method="post" action="journal_caisses_c_edition.php">
	<td><?php echo "Du : "; ?><input type="text" id="du" name="du" value="<?php echo $du; ?>" size="15"></td>
	<td><?php echo "Au : "; ?><input type="text" id="au" name="au" value="<?php echo $au; ?>" size="15"></td>

	<tr>
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	<? }
	
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">


</head>

<body style="background:#dfe8ff">
	
<?	if(isset($_REQUEST["action"]))
	{
			$caisse="COMPTOIR";$sss=6820.46;$du_s="2013-01-01";
						
			$du=dateFrToUs($_POST['du']);$au=dateFrToUs($_POST['au']);
			$sql  = "SELECT * ";$du1=$_POST['du'];$au1=$_POST['au'];
			$sql .= "FROM journal_caisses where caisse='$caisse' and date>='$du_s' ORDER BY date,credit;";
			$users = db_query($database_name, $sql);?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Caisse : ".$caisse." $du1 au $au1"; ?></span>

<p style="text-align:center">

<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Libelle";?></th>
	<th><?php echo "Debit";?></th>
	<th><?php echo "Credit";?></th>
	<th><?php echo "Solde";?></th>
	
</tr>

<?php $debit=6820.46;$credit=0;while($users_ = fetch_array($users)) { 
$debit=$debit+$users_["debit"];
$credit=$credit+$users_["credit"];
$solde=$debit-$credit;
if ($users_["date"]>=$du and $users_["date"]<=$au){
?><tr>
<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo dateUsToFr($users_["date"]);?></A></td>
<td><?php $libelle=$users_["libelle"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$libelle </font>"); ?></td>
<td align="right"><?php $d=number_format($users_["debit"],2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$d </font>"); ?></td>
<td align="right"><?php $c=number_format($users_["credit"],2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$c </font>"); ?></td>
<td align="right"><?php $s=number_format($solde,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$s </font>"); ?></td>
<? }?>
<?php } ?>
<tr></tr>
</table>
<?php } ?>
<p style="text-align:center">

</body>

</html>