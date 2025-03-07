<!--  ******************************************************************************************
************************************************************************************************
****     Le script PHP et le Javascript pour le clique droit et la Div qui s'affiche au 	****
****	 clique droit est entièrement de moi: Xavier Langlois (Caen,France)					****
****     E-mail: xavier.langlois@gmail.com													****
****     Site perso: http://xl714.free.fr													****
****     Ca serait sympa de me laisser un message si mon script vous apporte quelque chose	****
****     Et de laisser cette entête si vous mettez ce script en ligne.						****
****																						****
****	Le script pour transformer la simple liste en menu déroulant vient de:				****
****	http://www.javascriptfr.com/code.aspx?ID=21208  par 		Michel Deboom			****										****					
************************************************************************************************
*********************************************************************************************-->
<?php
/* Pour se connecter à la base de données, si vous n'avez pas éditer les infos de connection
   dans module.php ça ne va jamais marché et il faut également que vous ayez créer la table à 
   partir du fichier .sql aussi.*/
require "module.php";
function recupLesCat($intCat)
{	$db = ConnectDB();
	$requete = "SELECT lc_id,lc_titre FROM `liencat` WHERE lc_mere_id = ".$intCat." AND lc_lc = 1";
	$result = mysql_query ($requete,$db) or die("Erreur dans la requête:<br>$requete");
	$nbRec = mysql_num_rows($result);
	if($nbRec)
	{	while($cat = mysql_fetch_object($result))
		{	echo "<li><a id='annucat".$cat->lc_id."' href='#'>".stripslashes ($cat->lc_titre)."</a><ul>";
			addLiensDeLaCat($cat->lc_id);
			recupLesCat($cat->lc_id);
			echo"</ul></li>";
		}
	}
	mysql_free_result($result);
}
function addLiensDeLaCat($intCatId)
{	$ladb = ConnectDB();
	$req = "SELECT lc_id,lc_titre,lc_lib,lc_url FROM `liencat` WHERE `lc_mere_id` = ".$intCatId." AND `lc_lc` = 0";
    $res = mysql_query ($req,$ladb) or die("Erreur dans la requête:<br>$req");
	$nRec = mysql_num_rows($res);
    if($nRec)
	{	while($lien = mysql_fetch_object($res))
		{	echo "<li><a id='annulien".$lien->lc_id."' href='".$lien->lc_url."' target='BAT' title='".stripslashes($lien->lc_lib)."'>".stripslashes($lien->lc_titre)."</a></li>";
		}
	}
	else
	{ 	$db5 = ConnectDB();
		$requete5 = "SELECT lc_id FROM `liencat` where `lc_mere_id` = $intCatId";
		$result5 = mysql_query ($requete5,$db5) or die("Erreur dans la requête:<br>$requete5");
		$nbRec5 = mysql_num_rows($result5);
		if(!$nbRec5)
		{	echo "<li>Vide</li>";		
		}
		mysql_free_result($result5);
	}
	mysql_free_result($res);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="fr" xml:lang="fr" xmlns="http://www.w3.org/1999/xhtml">
<head> 
<title>Menu déroulant dynamique</title> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15" />
<meta http-equiv="Content-Language" content="fr" />
<!-- Lien vers le scipt du menu déroulant pris à cette source: http://www.javascriptfr.com/code.aspx?ID=21208 -->
<script type="text/javascript" src="menu.js"></script> 
<!-- Style de la div apparaissant au clique droit sur un élément de l'annuaire  -->
<style type="text/css">
/*A:link {COLOR: Black; TEXT-DECORATION: none;}*/
#annuoption {DISPLAY: none; Z-INDEX: 10; POSITION: absolute; BACKGROUND-COLOR: #888088;border: 2px #277aff outset;}
#lc-titre {	WIDTH: 130px; COLOR: white; BACKGROUND-COLOR: #727272; TEXT-ALIGN: center;border: 3px double;}
#choix {border: 2px ridge;width: 130px;padding-left: 3px;background-color: #888888;cursor:hand;}
#choix2 {cursor:hand;padding-left: 3px;border: 2px outset;width: 130px;font-weight: bold;color: silver;text-align: center;}
</style>
<!-- Script pour afficher une boite de menu au clique droit sur un lien ou une catégorie  -->
<script language="JavaScript">
var lien_id="";
//var act = "";
var typelc = "";
var zetimer = null;
var x = 0;
var y = 0;
var lid = 0;
function actlc(p){
	if(p == "sup"){
		var flag=confirm('Supprimer ?');
		if(flag){
			popupCentree("act.php?act=sup&id= " + lien_id + "",460,250);
		}
	}
	else if(p == "mod"){
		popupCentree("act.php?act=mod&id= " + lien_id + "",460,250);
	}
	else if(p == "add"){
		popupCentree("act.php?act=add&lcMere=" + lien_id + "",460,250);
	}
	else{
		alert("Mauvais paramètre");
	}
}
function popupCentree(nomFichier,largeur,hauteur){var top=(screen.height-hauteur)/2;var left=(screen.width-largeur)/2;window.open(nomFichier,"","top="+top+",left="+left+",width="+largeur+",height="+hauteur+",resizable=no,menubar=no,scrollbars=no,statusbar=no");}
function closemenudelay(){zetimer = setTimeout("closemenu()",500);}
function closemenu(){if(document.all){document.all["annuoption"].style.display = "none";}else if(document.layers){document.layers["annuoption"].display = "none";}else if(document.getElementById){document.getElementById("annuoption").style.display = "none";}}
function click(e) {
	if(navigator.appName == "Netscape"){
		 if(e.which == 3){
			var lidlc = e.target.id;
			if(lidlc)
			{	//Vérification qu'on est bien sur un id de l'annuaire de liens
				var reg = new RegExp("^(annulien|annucat){1}[0-9]{1,5}$", "g");
				if (reg.test(lidlc) ) {
					reg = new RegExp("[0-9]{1,5}$", "g");
					lid = reg.exec(lidlc);

					reg = new RegExp("^(annulien)", "g");
					if (reg.test(lidlc)){
						document.getElementById("add").style.display = "none";
					}else{
						document.getElementById("add").style.display = "block";
					}
					var letitre = document.getElementById(lidlc).firstChild.data;
					if(letitre){document.getElementById("lc-titre").innerHTML = letitre;	//Mettre le titre du lien en titre de la div annuoption;
					}else{document.getElementById("lc-titre").innerHTML = "Catégorie";}
					document.getElementById("annuoption").style.top = y;
					document.getElementById("annuoption").style.left = x;
					lien_id = lid;
					document.getElementById("annuoption").style.display = "block";
				}
			}
		}
	}
	else{	
		if (event.button==2 || event.button==1+2)	{	
			var lidlc = event.srcElement.id;
			if(lidlc){	
				//Vérification qu'on est bien sur un id de l'annuaire de liens
				var reg = new RegExp("^(annulien|annucat){1}[0-9]{1,5}$", "g");
				if (reg.test(lidlc) ) {
					reg = new RegExp("[0-9]{1,5}$", "g");
					lid = reg.exec(lidlc);
					reg = new RegExp("^(annulien)", "g");
					if (reg.test(lidlc)){
						document.getElementById("add").style.display = "none";
					}else{
						document.getElementById("add").style.display = "block";
					}
					//if(document.all){//var comment = document.getElementById(lid).getAttribute("title");		//Récupérer le commentaire
					var letitre = document.getElementById(lidlc).firstChild.data;
					if(letitre){
						document.getElementById("lc-titre").innerHTML = letitre;	//Mettre le titre du lien en titre de la div annuoption;}
					}else{
						document.getElementById("lc-titre").innerHTML = document.getElementById(lidlc).innerHTML;
					}
					document.all["annuoption"].style.top = y;
					document.all["annuoption"].style.left = x;
					lien_id = lid;
					document.all["annuoption"].style.display = "block";
				}
			}
		}
	}
}
document.onmousedown=click;
</script>
</head>
<body onload="initMenu('menu','mn')" oncontextmenu="return false;">
<SCRIPT LANGUAGE="JavaScript">
//Pour pouvoir récupéré en permanence la position du curseur
if (document.getElementById){
	if(navigator.appName.substring(0,3) == "Net")
		document.captureEvents(Event.MOUSEMOVE);
	document.onmousemove = Pos_Souris;
}
function Pos_Souris(e){
	x = (navigator.appName.substring(0,3) == "Net") ? e.pageX : event.x+document.body.scrollLeft;
	y = (navigator.appName.substring(0,3) == "Net") ? e.pageY : event.y+document.body.scrollTop;
}
</script>
	<!-- Voilà la div qui apparait au clique droit sur un élément du menu -->
	
<div id="annuoption" onMouseOver='clearTimeout(zetimer);' onMouseOut="closemenudelay();"> 
  <div id="lc-titre">Titre</div>
  <div id="add"><a href="javascript:actlc('add');">
    <div id="choix" onMouseOver="this.id = ('choix2')" onMouseOut="this.id = ('choix')">+ 
      1 lien ou cat</div>
    </a> </div>
  <a href="javascript:actlc('mod');">
  <div id="choix" onMouseOver="this.id = ('choix2')" onMouseOut="this.id = ('choix')">Modifier</div>
  </a><a href="javascript:actlc('sup');">
  <div id="choix" onMouseOver="this.id = ('choix2')" onMouseOut="this.id = ('choix')">Supprimer</div>
  </a></div>

<table>
<tr><td><div id="ancre_menu"></div></td></tr>
<tr>
<td>

</td></tr></table>
<ul id="menu">
	<?PHP
		//Appel de la fonction récursive pour construire la liste.
		recupLesCat(1);
	?>
</ul>
</body>
</html>
