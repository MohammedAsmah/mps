<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];$date1 = $_REQUEST["date"];$qte_tige1=0;
				$sql = "TRUNCATE TABLE `fiche_de_stock`  ;";
			db_query($database_name, $sql);


	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "Nouveau Produit";

		$produit = "";$favoris = 0;$non_favoris = 0;$colorant="";$qte_colorant=0;$dispo=0;
		$condit = "";
		$prix = "";$en_cours_final=0;$prix_revient_final=0;$production=0;
		$poids = "";$stock_initial = 0;$encours = 0;$stock_final = 0;$prix_revient =0;
		$tige="";$qte_tige=1;$emballage="";$qte_emballage=1;$matiere="";$qte_matiere=1;$etiquette="";$qte_etiquette=1;
	
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";
		$stock_ini_exe = $user_["stock_ini_exe"];
		$produit = $user_["produit"];$colorant = $user_["colorant"];$dispo = $user_["dispo"];$production=0;$production1 = $user_["production"];
		$condit = $user_["condit"];$production_a=0;$production_b=0;$qte_colorant=$user_["qte_colorant"];$prix_revient_final = $user_["prix_revient_final"];$en_cours_final = $user_["en_cours_final"];
		$prix = $user_["prix"];$favoris = $user_["favoris"];$non_favoris = $user_["non_favoris"];$encours = $user_["encours"];
		$poids = $user_["poids"];$stock_initial = $user_["stock_ini_exe"];$stock_final = $user_["stock_final"];$prix_revient = $user_["prix_revient"];
		$tige=$user_["tige"];$qte_tige=$user_["qte_tige"];$emballage=$user_["emballage"];$qte_emballage=$user_["qte_emballage"];
		$matiere=$user_["matiere"];$qte_matiere=$user_["qte_matiere"];$etiquette=$user_["etiquette"];$qte_etiquette=$user_["qte_etiquette"];
			$sql1  = "SELECT * ";$du="2015-10-30";$au=dateFrToUs(date("d/m/y"));
			$sql1 .= "FROM entrees_stock where produit='$produit' and (date between '$du' and '$date1' ) ORDER BY produit;";
			$users11 = db_query($database_name, $sql1);
			while($users11_ = fetch_array($users11)) { 
			$entree_a=0;$entree_b=0;$sortie_a=0;$sortie_b=0;
			$production_a=$production_a+$users11_["depot_a"];$production_b=$production_b+$users11_["depot_b"];
			$entree_a=$users11_["depot_a"];
			$date=$users11_["date"];$entree_b=$users11_["depot_b"];$type=$users11_["type"];$bon=$users11_["ref"];
			if ($type=="production"){$ref="Production";$t1=1;$entree_a=$users11_["depot_a"];$sortie_a=0;}$depot_a_balance=0;$depot_b_balance=0;
			if ($type=="a_vers_b"){$ref="Transfert vers depot Jaouda";$entree_a=0;$entree_b=$users11_["depot_a"]*-1;
			$sortie_a=$users11_["depot_a"]*-1;$t1=2;$sortie_b=0;
			}
			if ($type=="b_vers_a"){$ref="Transfert vers depot Mps";$entree_b=0;$entree_a=$users11_["depot_b"]*-1;
			$sortie_b=$users11_["depot_b"]*-1;$entree_b=0;$t1=1;
			}
			if ($type=="casse mps"){$ref="article casse depot mps";$t1=2;$sortie_a=$users11_["depot_a"]*-1;$entree_a=0;}
			if ($type=="casse jaouda"){$ref="Article casse depot jaouda";$t1=2;$sortie_b=$users11_["depot_b"]*-1;$entree_b=0;}
			if ($type=="stock report au 17/09/09"){$ref="Stock report au 18/09/09";$t1=1;$entree_a=$users11_["depot_a"];$sortie=0;}
			if ($type=="stock report au 17/09/09 b"){$ref="Stock report au 18/09/09";$t1=1;$entree_b=$users11_["depot_b"];$sortie_b=0;}
			
			$ref=$ref." ".$bon;
				$sql  = "INSERT INTO fiche_de_stock ( produit, date, entree_a,entree_b,sortie_a,sortie_b,ref,type ) VALUES ( ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $entree_a . "', ";
				$sql .= "'" . $entree_b . "', ";
				$sql .= "'" . $sortie_a . "', ";
				$sql .= "'" . $sortie_b . "', ";
				$sql .= "'" . $ref . "', ";
				$sql .= $t1 . ");";

				db_query($database_name, $sql);

			}
	}
			$sql1  = "SELECT * ";$qte_vendu_a=0;$qte_vendu_b=0;$du="2015-10-30";$au=dateFrToUs(date("d/m/Y"));
			$sql1 .= "FROM bon_de_sortie_magasin where produit='$produit' and (date between '$du' and '$date1' ) ORDER BY produit;";
			$users11 = db_query($database_name, $sql1);
			while($users11_ = fetch_array($users11)) { 
					$qte_vendu_a=$qte_vendu_a+$users11_["depot_a"];$id_registre=$users11_["id_registre"];
					$sql  = "SELECT * ";
					$sql .= "FROM registre_vendeurs WHERE id = " . $id_registre . ";";
					$user = db_query($database_name, $sql); $user_ = fetch_array($user);
					$bon_sortie=$user_["statut"];
					$qte_vendu_b=$qte_vendu_b+$users11_["depot_b"];
					$depot_a=$users11_["depot_a"];$date=$users11_["date"];$ref="Bon $bon_sortie";$t2=2;$depot_b=$users11_["depot_b"];
					$sql  = "INSERT INTO fiche_de_stock ( produit, date, sortie_a,sortie_b,ref,type ) VALUES ( ";
					$sql .= "'" . $produit . "', ";
					$sql .= "'" . $date . "', ";
					$sql .= "'" . $depot_a . "', ";
					$sql .= "'" . $depot_b . "', ";
					$sql .= "'" . $ref . "', ";
					$sql .= $t2 . ");";
					db_query($database_name, $sql);

			}
			$stock_final_a=$production_a-$qte_vendu_a;
			$stock_final_b=$production_b-$qte_vendu_b;
	
	
	
	// extracts profile list

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . $title; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">
<link href="Templates/css.css" rel="stylesheet" type="text/css">
<script type="text/javascript"><!--
	function UpdateUser() {
			document.getElementById("form_user").submit();
	}

	function CheckUser() {
		if(document.getElementById("produit").value == "" ) {
			alert("<?php echo "Nom Produit !"; ?>");
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression de ce produit ?"; ?>")) {
			document.location = "produits.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}

//--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php $jour=date("d/m/y");echo "Article : $produit       Conditionnement : $condit    "; ?></span>
<span style="font-size:14px"><?php $date11=dateUsToFr($date1);echo "      Fiche de Stock au : $date11"; ?></span>
<table class="table2">
<TD>DATE</TD>
<td>DESIGNATION</td>
<TD bgcolor="#66CCFF">ENTREE MPS</TD>
<TD bgcolor="#66CCFF">SORTIE MPS</TD>
<TD bgcolor="#66CCFF">STOCK MPS</TD>
<TD bgcolor="#FF9999">ENTREE JAOUDA</TD>
<TD bgcolor="#FF9999">SORTIE JAOUDA</TD>
<TD bgcolor="#FF9999">STOCK JAOUDA</TD>
</TR>
<? 			$sql1  = "SELECT * ";$du="2015-10-30";$au=dateFrToUs(date("d/m/y"));
			$sql1 .= "FROM fiche_de_stock where produit='$produit' ORDER BY date,type;";
			$users11 = db_query($database_name, $sql1);$e_a=0;$s_a=0;$e_b=0;$s_b=0;
			while($users11_ = fetch_array($users11)) { 
			$date=dateUsToFr($users11_["date"]);$ref=$users11_["ref"];
			$entree_a=$users11_["entree_a"];$entree_b=$users11_["entree_b"];
			$sortie_a=$users11_["sortie_a"];$sortie_b=$users11_["sortie_b"];
			$entree_a_f=$users11_["entree_a"];$entree_b_f=$users11_["entree_b"];
			$sortie_a_f=$users11_["sortie_a"];$sortie_b_f=$users11_["sortie_b"];
			if ($entree_a<0){$sortie_a_f=$entree_a*-1;}
			if ($entree_b<0){$sortie_b_f=$entree_b*-1;}
			$type=$users11_["type"];$balance=0;
			$e_a=$e_a+$entree_a;$s_a=$s_a+$sortie_a;$e_b=$e_b+$entree_b;$s_b=$s_b+$sortie_b;
	
	?>
	<tr><td><?php echo $date; ?></td><td><?php echo $ref; ?></td>
	
	<td align="right"><?php echo $entree_a_f; ?></td><td align="right"><?php echo $sortie_a_f; ?></td>
	<td align="right"><?php echo $e_a-$s_a; ?></td>
	<td align="right"><?php echo $entree_b_f; ?></td><td align="right"><?php echo $sortie_b_f; ?></td>
	<td align="right"><?php echo $e_b-$s_b; ?></td></tr>
			
			<? }?>
			
	<td></td><td></td>
<TD></TD>
<TD></TD>
<TD></TD>
<TD></TD>
<TD></TD>
<TD></TD>
<tr>
	<td></td><td></td>
	<td align="right"><?php  ?></td>
	<td align="right"><?php  ?></td>
	<td align="right"><?php echo $e_a-$s_a; ?></td>
	<td align="right"><?php  ?></td>
	<td align="right"><?php  ?></td>
	<td align="right"><?php echo $e_b-$s_b; ?></td>

</tr>

</table>	


</body>

</html>