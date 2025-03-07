<?
	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	$sql  = "SELECT *  ";
	$sql .= "FROM articles_commandes ORDER BY produit;";
	$users = db_query($database_name, $sql);
?>

<HTML><HEAD>
<TITLE>Tout JavaScript.com - Liste avec recherche par clavier</TITLE>
<SCRIPT LANGUAGE="JavaScript">
// D'autres scripts et des tutoriaux sur http://www.toutjavascript.com
// Script développé par Tout JavaScript.com
// Si vous utilisez ce script, merci de laisser ce commentaire

var Liste=new CreerListe("Pays", 5, 200)
<?php while($users_ = fetch_array($users)) { ?>
			Liste.Add("<? echo $users_["produit"];?>");

<?}?>
 

function CreerListe(nom, hauteur, largeur) {
	this.nom=nom; this.hauteur=hauteur; this.largeur=largeur;
	this.search="";
	this.nb=0; 
	this.Add=AjouterItem;
	this.Afficher=AfficherListe;
	this.MAJ=MAJListe;
}

function AjouterItem(item) {
	this[this.nb]=item
	this.nb++;
}

function AfficherListe() {
	if (document.layers) {
		var Z="<SELECT name="+this.nom+" size="+this.hauteur+">";
	} else {
		var Z="<SELECT name="+this.nom+" size="+this.hauteur+" style='width:"+this.largeur+"'>";
	}
	for (var i=0; i<this.nb; i++) {
		Z+="<OPTION value=\""+this[i]+"\">"+this[i]+"</OPTION>"		
	}
	Z+="</SELECT>"
	document.write(Z);
}

function MAJListe(txt,f) {
	if (txt!=this.search) {
		this.search=txt
		f.elements[this.nom].options.length=0; 
		for (var i=0; i<this.nb; i++) {
			if ( this[i].substring(0,txt.length).toUpperCase()==txt.toUpperCase() ) {
				var o=new Option(this[i], this[i]);
				f.elements[this.nom].options[f.elements[this.nom].options.length]=o;
			}
		}
		if (f.elements[this.nom].options.length==1) {
			f.elements[this.nom].selectedIndex=0;
		}
	}
}

function ListeCheck() {
	Liste.MAJ(document.forms["monform"].search.value,document.forms["monform"])
	if (document.layers) {
		setTimeout("ListeCheck()", 1001)
	} else {
		setTimeout("ListeCheck()", 100)
	}
}

</SCRIPT>
</HEAD>

<BODY bgcolor="#FFFFFF" text="#FAFAFF" alink="#000066" link="#000066" vlink="#000066" >
<FONT FACE="Arial" SIZE='-1' COLOR="navy">

<BR>
<FORM name=monform>
<INPUT onClick="ListeCheck(this);" type=text name="search" ><BR>
<SCRIPT language=javascript>
	Liste.Afficher();
	ListeCheck();
</SCRIPT>
</FORM>

 


</BODY></HTML>
