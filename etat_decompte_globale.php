<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$employe = $_REQUEST["employe"];$ref = $_REQUEST["ref"];$service = $_REQUEST["service"];
			$poste = $_REQUEST["poste"];if(isset($_REQUEST["statut"])) { $statut = 1; } else { $statut = 0; }
			$t_h_normales = $_REQUEST["t_h_normales"];$t_h_25 = $_REQUEST["t_h_25"];$t_h_50 = $_REQUEST["t_h_50"];
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				$sql  = "INSERT INTO employes ( code, employe,service,statut,poste )
				 VALUES ('$ref','$employe','$service','$statut','$poste')";

				db_query($database_name, $sql);
			

			break;

			case "update_user":
			$user_id=$_REQUEST["user_id"];
			$sql = "UPDATE employes SET ref = '$ref',employe = '$employe',t_h_normales='$t_h_normales',
				t_h_25='$t_h_25',t_h_50='$t_h_50',valide=1,statut='$statut' WHERE id = '$user_id'";
			db_query($database_name, $sql);
			
			break;
			
			case "delete_user":
			

			// delete user's profile
			$sql = "DELETE FROM employes WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	$sql  = "SELECT * ";$occ="occasionnelles";$per="permanents";$vide="";
	$sql .= "FROM employes where employe<>'$vide' and statut=0 and (service='$occ' or service='$per') ORDER by ordre;";
	$users = db_query($database_name, $sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste "; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "employe2.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php $date_e=date("d/m/Y h:m:s");

	$sql  = "SELECT * ";
	$sql .= "FROM paie_ouvriers ORDER BY id;";
	$users2 = db_query($database_name, $sql);
	while($users_2 = fetch_array($users2)) 
	{ if ($users_2["encours"]==1){$du=$users_2["du"];$au=$users_2["au"];}
	}
echo "ETAT DE DECOMPTE Du $du au $au Editée Le $date_e"; ?></span>

<table class="table2">

<tr>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">Nom et Prenom </font>");?></th>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">NET1 </font>");?></th>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">NET2 </font>");?></th>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">TOTAL </font>");?></th>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">200 </font>");?></th>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">100 </font>");?></th>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">50 </font>");?></th>	
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">20 </font>");?></th>	
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">10 </font>");?></th>	
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">5 </font>");?></th>	
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">1 </font>");?></th>	
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">NET </font>");?></th>
</tr>

<?php $tr=0;$ser="";$t200=0;$t100=0;$t50=0;$t20=0;$net1=0;$net2=0;

$tav=0;$tho=0;$sbt=0;$b_200_t=0;$b_100_t=0;$b_50_t=0;$b_20_t=0;$m_occ=0;$m_per=0;
$b_10_t=0;$b_5_t=0;$b_1_t=0;$p_50_t=0;$p_20_t=0;$p_10_t=0;$t_normales=0;$t_25=0;$t_50=0;
$total_net=0;$total=0;$t_bulletin=0;$t_hsup=0;

while($users_ = fetch_array($users)) { 


?><tr>
<? if ($tr==0 and $ser<>$users_["service"])
{?><tr><td bgcolor="#66CCCC"><?php $ser==$users_["service"];$tr=1;$service=$users_["service"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$service </font>");?></td></tr><? }?>
<? $h_sup=$users_["t_h_25"]*1.25+$users_["t_h_50"]*1.50;
$bulletin=$users_["bulletin"];
$t_bulletin=$t_bulletin+$bulletin;$t_hsup=$t_hsup+$h_sup;
?>
<td><?php echo $users_["employe"];?></td>
<td align="right"><?php echo number_format($users_["bulletin"],2,',',' '); ?></td>
<td align="right"><?php echo number_format($h_sup*$users_["s_h"],2,',',' ');?></td>
<td align="right"><?php $net1=$net1+$users_["bulletin"];$net2=$net2+$h_sup*$users_["s_h"];echo number_format($users_["bulletin"]+$h_sup*$users_["s_h"],2,',',' ');?></td>
<?
$sb=$users_["bulletin"]+$h_sup*$users_["s_h"];
$b_200="";$b_100="";$b_50="";$b_20="";$b_10="";$b_5="";$b_1="";
if ($sb>=200)
		{$b_200=intval($sb/200);$reste=$sb-($b_200*200);}else{$reste=$sb;}
		if ($reste>=100)
			{$b_100=intval($reste/100);$reste=$reste-($b_100*100);}
			if ($reste>=50)
				{$b_50=intval($reste/50);$reste=$reste-($b_50*50);}
				if ($reste>=20)
					{$b_20=intval($reste/20);$reste=$reste-($b_20*20);}
					if ($reste>=10)
						{$b_10=intval($reste/10);$reste=$reste-($b_10*10);}
						if ($reste>=5)
							{$b_5=intval($reste/5);$reste=$reste-($b_5*5);}
							if ($reste>=1)
								{$b_1=intval($reste/1);}
								
	$b_200_t=$b_200_t+$b_200;
	$b_100_t=$b_100_t+$b_100;
	$b_50_t=$b_50_t+$b_50;
	$b_20_t=$b_20_t+$b_20;
	$b_10_t=$b_10_t+$b_10;
	$b_5_t=$b_5_t+$b_5;
	
////////////////decompte cts
	$sb_net=number_format($sb,2,',',' ');
	$cts=explode(",", $sb_net);$v=$cts[1];
	$p_50="";$p_20="";$p_10="";
	if ($v>=50)
		{$p_50=intval($v/50);$b_1=$b_1+1;$reste=$v-($p_50*50);}else{$reste=$v;}
		
	$p_50_t=$p_50_t+$p_50;$p_20_t=$p_20_t+$p_20;$p_10_t=$p_10_t+$p_10;							
	$b_1_t=$b_1_t+$b_1;

 
?>
<td align="CENTER"><?php echo $b_200;?></td>
<td align="CENTER"><?php echo $b_100;?></td>
<td align="CENTER"><?php echo $b_50;?></td>
<td align="CENTER"><?php echo $b_20;?></td>
<td align="CENTER"><?php echo $b_10;?></td>
<td align="CENTER"><?php echo $b_5;?></td>
<td align="CENTER"><?php echo $b_1;?></td>
<td align="CENTER"><?php echo number_format(($b_200*200+$b_100*100+$b_50*50+$b_20*20+$b_10*10+$b_5*5+$b_1*1),2,',',' ');
$total_net=$total_net+($b_200*200+$b_100*100+$b_50*50+$b_20*20+$b_10*10+$b_5*5+$b_1*1);
$total=$total+$sb;
?></td>

<? if ($ser<>$users_["service"]){$ser=$users_["service"];$tr=0;}?>
<?php } ?>


<tr><td></td>
<td align="CENTER"><?php echo number_format($t_bulletin,2,',',' ');?></td>
<td align="CENTER"><?php echo number_format($h_sup,2,',',' ');?></td>
<td align="CENTER"><?php echo number_format($total,2,',',' ');?></td>
<td align="CENTER"><?php echo $b_200_t;?></td>
<td align="CENTER"><?php echo $b_100_t;?></td>
<td align="CENTER"><?php echo $b_50_t;?></td>
<td align="CENTER"><?php echo $b_20_t;?></td>
<td align="CENTER"><?php echo $b_10_t;?></td>
<td align="CENTER"><?php echo $b_5_t;?></td>
<td align="CENTER"><?php echo $b_1_t;?></td>
<td align="CENTER"><?php echo number_format($total_net,2,',',' ');?></td></tr>
</table>

<p style="text-align:center">


</body>

</html>