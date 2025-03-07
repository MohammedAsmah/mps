<!--  ******************************************************************************************
************************************************************************************************
****     Le script PHP et le Javascript pour le clique droit et la Div qui s'affiche au 	****
****	 clique droit est enti�rement de moi: Xavier Langlois (Caen,France)					****
****     E-mail: xavier.langlois@gmail.com													****
****     Site perso: http://xl714.free.fr													****
****     Ca serait sympa de me laisser un message si mon script vous apporte quelque chose	****
****     Et de laisser cette ent�te si vous mettez ce script en ligne.						****
****																						****
****	Le script pour transformer la simple liste en menu d�roulant vient de:				****
****	http://www.javascriptfr.com/code.aspx?ID=21208  par 		Michel Deboom			****										****					
************************************************************************************************
*********************************************************************************************-->
<?php
	require "module.php";
	function recupLesCat($new,$str,$intCat,$lcmereid)
	{	$dba = ConnectDB();
		$requetea = "SELECT lc_id,lc_titre FROM `liencat` WHERE lc_mere_id = $intCat AND lc_lc = 1";
		$resulta = mysql_query ($requetea,$dba) or die("Erreur dans la requ�te:<br>$requetea");
		$nbReca = mysql_num_rows($resulta);
		if($nbReca)
		{	if($new == true){$new = false;}else{$str = $str."--> ";}
			while($cata = mysql_fetch_object($resulta))
			{	$cat_ida = $cata->lc_id;
				$cat_name = addslashes ($cata->lc_titre);
				$msg= "";
				if($lcmereid == $cat_ida){$msg=" selected";}
				echo "<option value='$cat_ida'".$msg.">".$str.$cat_name."</option>";
				recupLesCat(false,$str,$cat_ida,$lcmereid);			 
			}
		}
	}
	function recupLesCat2($new,$str,$intCat,$lcid,$lcmereid)
	{	$dba = ConnectDB();
		$requetea = "SELECT lc_id,lc_titre FROM `liencat` WHERE lc_mere_id = $intCat AND lc_lc = 1";
		$resulta = mysql_query ($requetea,$dba) or die("Erreur dans la requ�te:<br>$requetea");
		$nbReca = mysql_num_rows($resulta);
		if($nbReca)
		{	if($new == true){$new = false;}	else{$str = $str."--> ";}
			while($cata = mysql_fetch_object($resulta))
			{	$cat_ida = $cata->lc_id;
				$cat_name = addslashes ($cata->lc_titre);
				if($cat_ida == $lcid){
					echo "cat_ida == lcid -> $lcid";
				}
				else{
					echo "lcmereid = $lcmereid<br>";
					echo "cat_ida = $cat_ida<br>";
					$msg= "";
					if($lcmereid == $cat_ida){$msg=" selected";}
					echo "<option value='$cat_ida'".$msg.">".$str.$cat_name."</option>";
					recupLesCat2(false,$str,$cat_ida,$lcid,$lcmereid);
				}		 
			}
		}
	}
?>
<html>
<head>
	<title>act</title>
	<!-- <link rel=stylesheet type="text/css" href="../css/style2.css"> -->
<script langage=javascript type="text/javascript">
	function VerifLc()
	{   var pform = document.form_lc_act;
		var flag = true;
		var msg = "Le formulaire ne peut �tre valid� pour la/les raison(s) suivante(s):\n";
		if (pform.txtLcTitre.value==""){msg = msg + "-->\tCase 'Titre' non remplie.\n";flag = false;}
		if (pform.txtLcDescription.value==""){msg = msg + "-->\tCase 'Description' non remplie.\n";flag = false;}
		if (pform.txtLcUrl.value==""){msg = msg + "-->\tCase 'Url' non remplie.\n";flag = false;}
		if(flag==false)
		{    alert(msg);
		}
		else
		{    pform.submit();
		}
	}
</script>
</head>
<body bgcolor="#CCCCCC">
<?php
	if(array_key_exists("act",$_GET))
	{	if($_GET["act"] == "add"):
?>			
			<form name="form_lc_act" action="act.php?act=add_rep" method="post">
			<table height="100%" width="100%">
			<tr><td align="center" valign="middle">
			<table border="0" cellspacing="4" cellpadding="2"><tr><td align="left">
					<b>Ajouter</b></td><td align="left">
					<b><input name="rdLc" type="radio" value="0" checked>un lien&nbsp;&nbsp;&nbsp;
					<input name="rdLc" type="radio" value="1">une cat�gorie</b>
				</td></tr><tr><td align="left">Titre</td><td align="left">
					<input type="text" name="txtLcTitre" size="26" maxlength="25" value="Titre" onFocus="this.select();">		
				</td></tr><tr><td align="left">Cat�gorie</td>
				<td align="left">
					<select name='lstCatMere'>
			<?PHP
			$lcIdMere = "";
			if(array_key_exists("act",$_GET)){$lcIdMere = $_GET["lcMere"];}
			echo "L'lcIdMere R�cup�r� = $lcIdMere";
			recupLesCat(true,"",0,$lcIdMere);
			?>
					</select>
				</td></tr><tr><td align="left">Description</td>
				<td align="left"><input name="txtLcDescription" size="50" maxlength="250" value="Description" onFocus="this.select();"></td>
			  </tr><tr><td align="left">Url</td><td align="left"><input name="txtLcUrl" size="50" maxlength="250" value="#" onFocus="this.select();"></td>
			  </tr><tr><td align="right" colspan="2">
					<input type="button" value="Valider" onClick="javascript:VerifLc();">
					<input type="reset" value="Effacer">
				</td></tr></table></form>
			</td></tr></table>
			<!-- Fin de: act = add -->
<?php
		elseif ($_GET["act"] == "add_rep"):
			//R�cup�ration des valeurs	
			$lc_lc = $_POST["rdLc"];
			$lc_mere_id = $_POST["lstCatMere"];
			$lc_titre = $_POST["txtLcTitre"];
			$lc_lib = $_POST["txtLcDescription"];
			$lc_url = $_POST["txtLcUrl"];
			$user_id = 1;
			$lc_aff = 0;
			//die("Pr�t pour l'ajout ...<br>");
			if(($lc_lc == "0")&&($lc_mere_id == "1"))
			{	die("Impossible de mettre un lien dans la cat�gorie m�re.
					<script language='JavaScript'>
						setTimeout('self.close()',1500);
					</script>");
			}
			//Connection � la base de donn�es pour insertion du lc
			$db = ConnectDB();
			$requete = "insert into liencat values('','$lc_mere_id','$user_id','$lc_titre','$lc_lib','$lc_url','$lc_lc','$lc_aff')";
			if(!mysql_query ($requete,$db) )
			{	echo "<center>L'insertion du lc n'a pas �t� effectu�e car la requ�te a �chou�e :<br>";
			}
			else 
			{	echo "L'lc est bien ajout�e.<br>";
			}
			print("
				<script language='JavaScript'>
					window.opener.location.reload();
					setTimeout('self.close()',1500);
				</script>
			");

//Fin de: act = add_rep -->

		elseif ($_GET["act"] == "mod"):

			//R�cup�ration de l'id
			if(array_key_exists("id",$_GET))
			{	$lc_id = $_GET["id"];
			}
			else
			{	die("L'id n'a pas �t� r�cup�r�.");
			}
			
			//R�cup�ration des information selon l'id
			$req = "SELECT * FROM `liencat` where `lc_id` = ".$lc_id;
			$db = ConnectDB();
			$res = mysql_query ($req,$db) or die("Erreur dans la requ�te pour r�cup�rer les informations selon l'id:<br>$req");
			$nRec = mysql_num_rows($res);
			if($nRec)
			{	$lc = mysql_fetch_object($res);		
				$lc_mere_id = $lc->lc_mere_id;
				$lc_titre = stripslashes($lc->lc_titre);
				$lc_lib = stripslashes($lc->lc_lib);
				$lc_url = stripslashes($lc->lc_url);
				$lc_lc = $lc->lc_lc;
			}
			else
			{	die("Pas acc�s � la modif");
			}
			mysql_free_result($res);
?>
<form name="form_lc_act" action="act.php?act=mod_rep&id=<?=$lc_id ?>" method="post">
			<table height="100%" width="100%">
			<tr><td align="center" valign="middle">
			<table border="0" cellspacing="4" cellpadding="2"><tr><td align="left">
					<b>Ajouter</b></td><td align="left">
					<b><input name="rdLc" type="radio" value="0" <?php if($lc_lc==0){print(" checked");} ?> disabled>un lien&nbsp;&nbsp;&nbsp;
					<input name="rdLc" type="radio" value="1" <?php if($lc_lc==1){print(" checked");} ?> disabled>une cat�gorie</b>
					<input type="hidden" name="rdLc" value="<?=$lc_lc ?>">
				</td></tr><tr><td align="left">Titre</td><td align="left">
					<input type="text" name="txtLcTitre" size="26" maxlength="25" value="<?=$lc_titre ?>" onFocus="this.select();">		
				</td></tr><tr><td align="left">Cat�gorie</td>
				<td align="left">
					<select name='lstCatMere'>
			<?PHP
			if($lc_lc==1){
				recupLesCat2(true,"",0,$lc_id,$lc_mere_id);
			}
			else
			{	recupLesCat(true,"",0,$lc_mere_id);
			}
			?>
					</select>
				</td></tr><tr><td align="left">Description</td>
				<td align="left"><input name="txtLcDescription" size="50" maxlength="250" value="<?=$lc_lib ?>" onFocus="this.select();"></td>
			  </tr><tr><td align="left">Url</td><td align="left"><input name="txtLcUrl" size="50" maxlength="250" value="<?=$lc_url ?>" onFocus="this.select();"></td>
			  </tr><tr><td align="right" colspan="2">
					<input type="button" value="Valider" onClick="javascript:VerifLc();">
					<input type="reset" value="Effacer"></form>
				</td></tr></table>
</td></tr></table> 
<!-- Fin de: act = mod et sup -->
<?php
		elseif ($_GET["act"] == "mod_rep"):
			//R�cup�ration de l'id
			if(array_key_exists("id",$_GET))
			{	$lc_id = $_GET["id"];
			}
			else
			{	die("L'id n'a pas �t� r�cup�r�.");
			}
			
			$lc_lc = $_POST["rdLc"];
			$lc_mere_id = $_POST["lstCatMere"];
			$lc_titre = $_POST["txtLcTitre"];
			$lc_lib = $_POST["txtLcDescription"];
			$lc_url = $_POST["txtLcUrl"];
			$user_id = 1;
			$lc_aff = 0;
			$db = ConnectDB();
			$requete = "UPDATE liencat SET lc_mere_id='$lc_mere_id',lc_titre='$lc_titre',lc_lib='$lc_lib',lc_url='$lc_url' WHERE lc_id =".$lc_id;
			if(!mysql_query ($requete,$db))
			{	echo "<br>Modification rat�e<br> $requete<br>";
			}
			else
			{	echo "Modification effectu�e.<br>";
				print("
					<script language='JavaScript'>
						window.opener.location.reload();
						setTimeout('self.close()',1500);
					</script>
				");
			}
		elseif ($_GET["act"] == "sup"):
			//R�cup�ration de l'id
			if(array_key_exists("id",$_GET))
			{	$lc_id = $_GET["id"];
			}
			else
			{	die("L'id n'a pas �t� r�cup�r�.");
			}
			$db = ConnectDB();
			$requete = "SELECT lc_id FROM `liencat` where `lc_mere_id` = $lc_id";
			$result = mysql_query ($requete,$db) or die("Erreur dans la requ�te:<br>$requete5");
			$nbRec = mysql_num_rows($result);
			mysql_free_result($result);
			if($nbRec)
			{		echo "Impossible car il existe toujours des liens ou des sous cat�gories � cette cat�gorie.<br>";
					print("
						<script language='JavaScript'>
							setTimeout('self.close()',1500);
						</script>
					");			
			}
			else{
				$requete = "DELETE FROM liencat WHERE lc_id=".$lc_id;
				if(!mysql_query ($requete,$db))
				{	echo "<br>Suppression rat�e<br>requete = $requete<br>";
				}
				else
				{	echo "Suppression effectu�e.<br>";
					print("
						<script language='JavaScript'>
							window.opener.location.reload();
							setTimeout('self.close()',1500);
						</script>
					");
				}
			}
		endif;
	}
?>
</body>
</html>