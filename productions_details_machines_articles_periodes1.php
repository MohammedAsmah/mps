<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$login = $user_["login"];$date_ins=date("y-m-d");
	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action1"]))
		
	{
	$machine=$_POST["machine"];$produit=$_POST["produit"];$fiche_stock=$_POST["fiche_stock"];echo $fiche_stock;
	$article=$_POST["article"];if ($article<>""){$produitp=$article;}else{$produitp=$produit;}
	$du=dateFrToUs($_POST["du"]);$au=dateFrToUs($_POST["au"]);if(isset($_REQUEST["copie"])) { $copie = 1; } else { $copie = 0; }
	$du1=$_POST["du"];$au1=$_POST["au"];$a=$_POST["a"];$m=$_POST["m"];$p=$_POST["p"];
	$du_c=dateFrToUs($_POST["du_c"]);$au_c=dateFrToUs($_POST["au_c"]);
	$du1_c=$_POST["du_c"];$au1_c=$_POST["au_c"];
	$sql  = "SELECT machine,produit,date,sum(prod_6_14) as t_prod_6_14,sum(prod_14_22) as t_prod_14_22,sum(prod_22_6) as t_prod_22_6,
	sum(temps_arret_h_1) as t_temps_arret_h,sum(temps_arret_m_1) as t_temps_arret_m,sum(rebut_1) as t_rebut1,
	sum(rebut_2) as t_rebut2,sum(rebut_3) as t_rebut3,sum(poids_1) as t_poids,
	sum(tc1) as t_tc1,sum(tc2) as t_tc2,sum(tc3) as t_tc3 ";$today=date("y-m-d");
	$sql .= "FROM details_productions where machine='$machine' and produit='$produit' and date between '$du' and '$au' group by id ORDER BY date;";
	$users = db_query($database_name, $sql);
	}
	else
	{
	$machine=$_POST["machine"];$produit=$_POST["produit"];
	$du=dateFrToUs($_POST["du"]);$au=dateFrToUs($_POST["au"]);
	$du1=$_POST["du"];$au1=$_POST["au"];
	$sql  = "SELECT id,date,machine,produit,date,sum(prod_6_14) as t_prod_6_14,sum(prod_14_22) as t_prod_14_22,sum(prod_22_6) as t_prod_22_6,
	sum(temps_arret_h_1) as t_temps_arret_h,sum(temps_arret_m_1) as t_temps_arret_m,sum(rebut_1) as t_rebut1,
	sum(rebut_2) as t_rebut2,sum(rebut_3) as t_rebut3,sum(poids_1) as t_poids,
	sum(tc1) as t_tc1,sum(tc2) as t_tc2,sum(tc3) as t_tc3 ";$today=date("y-m-d");
	$sql .= "FROM details_productions where machine='$machine' and produit='$produit' and date between '$du' and '$au' group by id ORDER BY date;";
	$users = db_query($database_name, $sql);
	}
	
	
	?>
	

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo " "; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--

--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "$produit / $machine du $du1 au $au1"; ?></span>

<table class="table2">

<tr>
        <td width="70"><?php echo " Date "; ?></td>
        <td width="70"><?php echo " Prod 6-14 "; ?></td>
        <td width="70"><?php echo " Prod 14-22 "; ?></td>
        <td width="70"><?php echo " Prod 22-6 "; ?></td>
        <td width="70"><?php echo " Total "; ?></td>
		 <td width="70"><?php echo " Nbre Paquets "; ?></td>
        <td width="70"><?php echo " Rebuts "; ?></td>
       
	  <?
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '" . $produitp . "';";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$condit=$user_["condit"];
	  
	  
		?>
	   
	   
	   
	   

</tr>
<?php $obs_g="";$tr=0;$paquets_t=0;while($users_ = fetch_array($users)) { ?><tr>
<? 

if(isset($_REQUEST["action1"]))
		
	{

$tableau = array(); 
$tableau[] = intval($users_["t_prod_6_14"]); $date=$users_["date"];$date_du=$users_["date"];
$id_production=$id_production;$id=$users_["id"];$machine1=$users_["machine"];$obs_machine=$users_["obs_machine"];?>
<td style="text-align:left"><?php $d=dateUsToFr($users_["date"]); print("<font size=\"1\" face=\"Comic sans MS\" color=\"006633\">$d </font>");?></td>
<td style="text-align:center"><?php $p1=$users_["t_prod_6_14"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"006633\">$p1 </font>"); ?></td>
<td style="text-align:center"><?php $p2= $users_["t_prod_14_22"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"006633\">$p2 </font>"); ?></td>
<td style="text-align:center"><?php $p3= $users_["t_prod_22_6"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"006633\">$p3 </font>"); ?></td>
<td style="text-align:center"><?php $total= $users_["t_prod_22_6"]+$users_["t_prod_6_14"]+$users_["t_prod_14_22"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"FF0000\">$total </font>"); ?></td>
<td style="text-align:center"><?php $paquets= intval($total/$condit);$paquets1=intval($paquets*$p/100);print("<font size=\"1\" face=\"Comic sans MS\" color=\"006633\">$paquets </font>"); ?></td>
<td style="text-align:center"><?php $rebut= $users_["t_rebut1"]+$users_["t_rebut2"]+$users_["t_rebut3"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"006633\">$rebut </font>"); ?></td>

<? 
///validation vers fiche
			
			if ($copie)
			//copier vers autre date
			{
			$tmp = explode("/", $d);
			$annee=$tmp[2]+$a;
			$mois=$tmp[1]+$m;
			$jour=$tmp[0];
			$date_du = $annee."-".$mois."-".$jour;
						
			}
			if ($fiche_stock=="valider")
			{$type="production";$depot_b=0;
			
			
			$sql  = "INSERT INTO entrees_stock_f ( produit, date,date_ins,user,depot_a,type,depot_b ) VALUES ( ";
				$sql .= "'" . $produitp . "', ";
				$sql .= "'" . $date_du . "', ";$sql .= "'" . $date_ins . "', ";$sql .= "'" . $user . "', ";
				$sql .= "'" . $paquets1 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			
			}
			else
			{
			$sql = "DELETE FROM entrees_stock_f WHERE produit='$produitp' and date = '$date_du';";
			db_query($database_name, $sql);
			}
			
			
			


?>











<?php $tr=$tr+$rebut;$pro=$pro+$total;$paquets_t=$paquets_t+$paquets;
}
else
{
$tableau = array(); 
$tableau[] = intval($users_["t_prod_6_14"]); 
$id_production=$id_production;$id=$users_["id"];$machine1=$users_["machine"];$obs_machine=$users_["obs_machine"];?>
<td style="text-align:left"><?php $d=dateUsToFr($users_["date"]); print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$d </font>");?></td>
<td style="text-align:center"><?php $p1=$users_["t_prod_6_14"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$p1 </font>"); ?></td>
<td style="text-align:center"><?php $p2= $users_["t_prod_14_22"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$p2 </font>"); ?></td>
<td style="text-align:center"><?php $p3= $users_["t_prod_22_6"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$p3 </font>"); ?></td>
<td style="text-align:center"><?php $total= $users_["t_prod_22_6"]+$users_["t_prod_6_14"]+$users_["t_prod_14_22"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"FF0000\">$total </font>"); ?></td>
<td style="text-align:center"><?php $paquets= intval($total/$condit);print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$paquets </font>"); ?></td>
<td style="text-align:center"><?php $rebut= $users_["t_rebut1"]+$users_["t_rebut2"]+$users_["t_rebut3"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$rebut </font>"); ?></td>


<?php $tr=$tr+$rebut;$pro=$pro+$total;$paquets_t=$paquets_t+$paquets;
}


} ?>
<tr><td></td><td></td><td></td><td></td>
<td style="text-align:center"><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"FF0000\">$pro </font>"); ?></td>
<td style="text-align:center"><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"FF0000\">$paquets_t </font>"); ?></td>
<td style="text-align:center"><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$tr </font>"); ?></td>

</table>


<? if ($login=="admin" or $login=="rakia" or $login=="leila"){?>
<p style="text-align:center">
<form id="form_user" name="form_user" method="post" action="productions_details_machines_articles_periodes1.php">
<? $profiles_list_type = "";$action1="valider vers fiche de stock";$du_c="";$au_c="";$copie=0;
	$sql1 = "SELECT * FROM validation ORDER BY id;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($fiche_stock == $temp_["type"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_type .= "<OPTION VALUE=\"" . $temp_["type"] . "\"" . $selected . ">";
		$profiles_list_type .= $temp_["type"];
		$profiles_list_type .= "</OPTION>";
	}
	
	$profiles_list_articles = "";$article="";
	$sql1 = "SELECT * FROM produits ORDER BY produit;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($article == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_articles .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$profiles_list_articles .= $temp_["produit"];
		$profiles_list_articles .= "</OPTION>";
	}
	
	?>


	<table width="671" class="table3">

		<tr>
		<td><?php $du="";echo "Du"; ?></td><td><input type="text" id="du" name="du" value="<?php echo $du; ?>"></td>
		<td><?php $au="";echo "Au"; ?></td><td><input type="text" id="au" name="au" value="<?php echo $au; ?>"></td>
		<td><select id="fiche_stock" name="fiche_stock"><?php echo $profiles_list_type; ?></select></td>
		<td><?php echo "Vers Article : "; ?></td><td><select id="article" name="article"><?php echo $profiles_list_articles; ?></select></td></tr>
		</tr>
		<tr>
		<tr><td><input type="checkbox" id="copie" name="copie"<?php if($copie) { echo " checked"; } ?>></td><td>Copier Periode</td></tr>
		<td><?php $a="";echo "Annee plus"; ?></td><td><input type="text" id="a" name="a" value="<?php echo $a; ?>"></td>
		<td><?php $m="";echo "Mois plus"; ?></td><td><input type="text" id="m" name="m" value="<?php echo $m; ?>"></td>
		<td><?php $p="100";echo " % "; ?></td><td><input type="text" id="p" name="p" value="<?php echo $p; ?>"></td>
		
		<input type="hidden" id="produit" name="produit" value="<?php echo $produit; ?>">
		<input type="hidden" id="machine" name="machine" value="<?php echo $machine; ?>">
		<input type="hidden" id="action1" name="action1" value="<?php echo $action1; ?>">
		<td><input type="submit" id="action1" name="action1" value="<?php echo $action1; ?>"></td>
		
	</table>
</form>
<? }?>
</body>

</html>