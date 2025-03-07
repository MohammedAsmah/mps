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
	
	$sql  = "SELECT * ";$occ="occasionnelles";$per="permanents";$vide="";$semaine="semaine";$espece="espece";
	$sql .= "FROM employes where t_h_normales>0 and employe<>'$vide' and cloture=0 and statut=0 and service='$per' and paie='$semaine' and mode='$espece' ORDER BY service,employe;";
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

<span style="font-size:24px"><?php echo "Etat Permanents Du 25/06/2011 au 01/07/2011 "; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Nom et Prenom ";?></th>
	<th><?php echo "H.N";?></th>
	<th><?php echo "H.25%";?></th>
	<th><?php echo "H.50%";?></th>
	<th><?php echo "H.100%";?></th>
	<th><?php echo "Total H.";?></th>	
	
	<th><?php echo "S.H";?></th>
	<th><?php echo "Montant";?></th>
	<th><?php echo "Arrondi";?></th>
	<th><?php echo "Salaire Brut";?></th>
	<th><?php echo "Signature";?></th>	
</tr>

<?php $sbt=0;$b_200_t=0;$b_100_t=0;$b_50_t=0;$b_20_t=0;$b_10_t=0;$b_5_t=0;$b_1_t=0;$p_50_t=0;$p_20_t=0;$p_10_t=0;
while($users_ = fetch_array($users)) { ?><tr>

<td><?php echo $users_["employe"];?></td>
<td align="right"><?php echo number_format($users_["t_h_normales"],2,',',' '); ?></td>
<td align="right"><?php echo number_format(0,2,',',' '); ?></td>
<td align="right"><?php echo number_format(0,2,',',' '); ?></td>
<td align="right"><?php echo number_format(0,2,',',' '); ?></td>
<td align="right"><?php $tt=$users_["t_h_normales"];
echo number_format($tt,2,',',' ');?></td>
<td align="right"><?php echo number_format($users_["s_h"],2,',',' '); ?></td>
<td align="right"><?php $montant=$users_["s_h"]*$tt;$m=number_format($users_["s_h"]*$tt,2,',',' ');echo $m; ?></td>
<td align="right"><?php $arrondi=0;$virgule=explode(",", $m);$v=$virgule[1];$m=$virgule[0];
$arrondi=$v;if ($arrondi>0 and $arrondi<10){$arrondi=10;}if ($arrondi==0){$arrondi=0;}if ($arrondi>10 and $arrondi<20){$arrondi=20;}
if ($arrondi>20 and $arrondi<30){$arrondi=30;}if ($arrondi>30 and $arrondi<40){$arrondi=40;} 
if ($arrondi>40 and $arrondi<50){$arrondi=50;}if ($arrondi>50 and $arrondi<60){$arrondi=60;}
if ($arrondi>60 and $arrondi<70){$arrondi=70;}if ($arrondi>70 and $arrondi<80){$arrondi=80;}
if ($arrondi>80 and $arrondi<90){$arrondi=90;}if ($arrondi>90 and $arrondi<100){$arrondi=100;}
echo $arrondi-$v;?></td>
<td align="right"><?php $sb=$m+$arrondi/100;echo number_format($sb,2,',',' '); $sbt=$sbt+$sb; ?></td>
<td align="center"><?php echo "-----"; ?></td>
<? 

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
	$b_1_t=$b_1_t+$b_1;
////////////////decompte cts
	$sb_net=number_format($sb,2,',',' ');
	$cts=explode(",", $sb_net);$v=$cts[1];
	$p_50="";$p_20="";$p_10="";
	if ($v>=50)
		{$p_50=intval($v/50);$reste=$v-($p_50*50);}else{$reste=$v;}
		if ($reste>=20)
			{$p_20=intval($reste/20);$reste=$reste-($p_20*20);}
			if ($reste>=10)
				{$p_10=intval($reste/10);$reste=$reste-($p_10*10);}
	$p_50_t=$p_50_t+$p_50;$p_20_t=$p_20_t+$p_20;$p_10_t=$p_10_t+$p_10;
							
?>					
<?php } ?>
<tr>
<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
<td align="center"><? echo number_format($sbt,2,',',' ');?></td><td></td>
</table>
<tr>
<table class="table2">
<? echo  "<tr><td>B.200 dhs</td><td>B.100 dhs</td><td>B.50 dhs</td><td>B.20 dhs</td>
							<td>Piece 10 dhs</td><td>Piece 5 dhs</td><td>Piece 1 dhs</td><td>Piece 50 cts</td>
							<td>Piece 20 cts</td><td>Piece 10 cts</td></tr>
		<tr><td>$b_200_t</td><td>$b_100_t</td><td>$b_50_t</td><td>$b_20_t</td><td>$b_10_t</td><td>$b_5_t</td><td>$b_1_t</td>
		<td>$p_50_t</td><td>$p_20_t</td><td>$p_10_t</td></tr>
									";?>
</table>
<p style="text-align:center">


</body>

</html>