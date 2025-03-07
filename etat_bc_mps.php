<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();	$user_name=GetUserName();


	$error_message = "";$date="";$date_f="";$vendeur="";$remise_1=0;$remise_2=0;$remise_3=0;
		$date="";$action="Recherche";	
	$profiles_list_vendeur = "";$vendeur="";

	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 

		if($_REQUEST["action_"] != "delete_user") {$client = $_REQUEST["frs"];$date = dateFrToUs($_REQUEST["date"]);
		$date_f = dateFrToUs($_REQUEST["date"]);$bb = $_REQUEST["bb"];
		
			
			// prepares data to simplify database insert or update
			$frs = $_REQUEST["frs"];$vendeur = $_REQUEST["vendeur"];$destination = $_REQUEST["destination"];
			if(isset($_REQUEST["sans_remise"])) { $sans_remise = 1; } else { $sans_remise = 0; }
		$sql  = "SELECT * ";
		$sql .= "FROM rs_data_fournisseurs WHERE last_name = '$frs' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$ville=$user_["ville"];$fax=$user_["fax"];
			
			}
		if($_REQUEST["action_"] == "update_user"){	
			$destination = $_REQUEST["destination"];
			$frs = $_REQUEST["frs"];$vendeur = $_REQUEST["vendeur"];$client = $_REQUEST["frs"];
			
			$bl = $_REQUEST["bl"];$bc = $_REQUEST["bc"];$piece = $_REQUEST["piece"];
			}
		
		
	} //if
	

	// extracts profile list
	$fr_list = "";$v="1";
	$sql = "SELECT * FROM  rs_data_fournisseurs ORDER BY last_name;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($fr == $temp_["last_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$fr_list .= "<OPTION VALUE=\"" . $temp_["last_name"] . "\"" . $selected . ">";
		$fr_list .= $temp_["last_name"];
		$fr_list .= "</OPTION>";
	}

		if(isset($_REQUEST["action"])){}else{
	?>
	<form id="form" name="form" method="post" action="etat_bc_mps.php">
	<table>
	<td><?php echo "Du : "; ?><input onClick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" /></td>
	<td><?php echo "Au : "; ?><input onClick="ds_sh(this);" name="date2" readonly="readonly" style="cursor: text" /></td>
	<td><?php echo "Fournisseur : "; ?><select onkeydown="return liDown(this);" id="frs" name="frs"><?php echo $fr_list; ?></select></td></tr>
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }
	if(isset($_REQUEST["action"]))
	{$date=dateFrToUs($_POST['date']);$date2=dateFrToUs($_POST['date2']);
	$date_f=dateFrToUs($_POST['date']);$frs=$_POST['frs'];$destination=$_POST['destination'];
		
		$sql  = "SELECT * ";
		$sql .= "FROM commandes_frs where client='$frs' and date_e between '$date' and '$date2' ORDER BY date_e;";
		$users = db_query($database_name, $sql);
		}
		
		else
			
		{
		@$vendeur=$_GET['vendeur'];@$date=$_GET['date'];@$destination=$_GET['destination'];
		$sql  = "SELECT * ";
		$sql .= "FROM commandes_frs where  date_e between '$date' and '$date2' ORDER BY date_e;";
		$users = db_query($database_name, $sql);}
		
	if(isset($_REQUEST["action_"]))
	{$date=dateFrToUs($_POST['date']);$date_f=dateFrToUs($_POST['date']);$vendeur=$_POST['vendeur'];
		
		$sql  = "SELECT * ";
		$sql .= "FROM commandes_frs where date_e between '$date' and '$date2' ORDER BY date_e;";
		$users = db_query($database_name, $sql);
		}
		
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Commandes"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "bc_mps_details.php?user_id=" + user_id; }
	
	<!--

var timer = null;
var chaine
= "";
function startsWith (str1, str2) {
var k = str1.substring(0, str2.length);
return (str2.toLowerCase() == k.toLowerCase());
}
function
liDown (list) {

var c = event.keyCode;
if (c < 48 && c!=32) return true;

var s = String.fromCharCode(c);
chaine += s;
var n = list.selectedIndex;
var
ok = false;

if (chaine.length > 1 && startsWith(list.options[n].text, chaine)) ok=true;

for (var i=n+1; i < list.options.length && !ok; i++)
{
if (startsWith(list.options[i].text, chaine)) { n = i; ok = true; }
}
for (var i=0; i < n && !ok; i++) {
if (startsWith(list.options[i].text,
chaine)) { n = i; ok = true; }
}
list.selectedIndex = n;


if (timer!=null) clearTimeout(timer);
timer = setTimeout("clearChaine();",
2000);
return false;
}
function clearChaine () { chaine=""; }

// -->
	
	
	
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";
	?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>
<span style="font-size:24px"><?php echo "liste Commandes"; ?></span>
<tr>


<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Fournisseur";?></th>
	<th><?php echo "Articles";?></th>

	
</tr>

<?php 

$total_g=0;
while($users_ = fetch_array($users)) { ?><tr>
<td><?php $date_e=dateUsToFr($users_["date_e"]);echo $date_e; ?></td>
<? $commande=$users_["commande"];$bln=$users_["bl"];$bcn=$users_["bc"];$evaluation=$users_["evaluation"];$client=$users_["client"];$date_e=dateUsToFr($users_["date_e"]);
$vendeur=$users_["vendeur"];$numero=$users_["commande"];$sans_remise=$users_["sans_remise"];$remise10=$users_["remise_10"];$date_c=$users_["date_e"];
if ($users_["date_e"]<="2012-12-31" and $users_["date_e"]>="2012-01-01"){$annee="/12";}
		if ($users_["date_e"]<="2013-12-31" and $users_["date_e"]>="2013-01-01"){$annee="/13";}
		if ($users_["date_e"]<="2014-12-31" and $users_["date_e"]>="2014-01-01"){$annee="/14";}
		if ($users_["date_e"]<="2015-12-31" and $users_["date_e"]>="2015-01-01"){$annee="/15";}
		if ($users_["date_e"]<="2016-12-31" and $users_["date_e"]>="2016-01-01"){$annee="/16";}
		if ($users_["date_e"]<="2017-12-31" and $users_["date_e"]>="2017-01-01"){$annee="/17";}
$remise2=$users_["remise_2"];$remise3=$users_["remise_3"];$id=$users_["id"]; $date_en=dateFrToUs($users_["date"]);$ev_pre=$users_["ev_pre"];$bc=$users_["id"]+219;$bc=$bc.$annee;
echo "<td>".$bc;
$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_commandes_frs where commande='$id' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	
	
	$non_favoris=0;$ht=0;echo "<table>";
	while($users1_ = fetch_array($users1)) { 
		$produit=$users1_["produit"];$quantite=$users1_["quantite"];
		echo "<tr><td>".$produit."</td>"."<td>".$quantite."</td></tr>";
		
		}
	echo "</table></td>";	
echo "<td>".$client."</td>";$ref=$users_["vendeur"];$anc=$users_["ancien_commande"];?>
<? if ($date_c>"2011-06-20"){echo "<td><a href=\"editer_bc_mps5.php?date_c=$date_c&client=$client&date=$date_e&numero=$id\">Detail commande </a>";} else {?>
<? echo "<td><a href=\"editer_bc_mps_ancien.php?date_c=$date_c&anc=$anc&date=$date_e&numero=$id\">Detail commande </a>";} ?>

<? }?>

</table>
<tr>
</tr>

<p style="text-align:center">
</body>

</html>