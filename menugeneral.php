<?  require "config.php";
	require "connect_db.php";
	require "functions.php";

	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	// check basic user rights
	$users_can_edit_objects = param_extract("users_can_edit_objects");
		//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$login = $user_["login"];$tout = $user_["tout"];$menu1 = $user_["menu1"];$menu2 = $user_["menu2"];$menu3 = $user_["menu3"];
	$menu4 = $user_["menu4"];$menu5 = $user_["menu5"];$menu6 = $user_["menu6"];
	$menu7 = $user_["menu7"];$menu8 = $user_["menu8"];$menu9 = $user_["menu9"];$menu10 = $user_["menu10"];$menu11 = $user_["menu11"];$menu12 = $user_["menu12"];
	$menu13 = $user_["menu13"];$menu14 = $user_["menu14"];
?>	
	<script type="text/javascript"><!--
	function DeLog() { top.location = "index1.php?action_=delog"; }
	--></script>


<HTML><HEAD>
<TITLE>MOULAGE PLASTIQUE DU SUD  zone indistruelle sidi ghanem marrakech (c) </TITLE>


<SCRIPT LANGUAGE="JavaScript">
// D'autres scripts et des tutoriaux sur http://www.toutjavascript.com	
// Script gratuit à condition de laisser ce commentaire 

var menu=new CreerMenu("verdana,arial","#0000CC","#0000FF","dyn03.gif","dyn04.gif","dyn02.gif","dyn05.gif",36,'right',"O");

<?php if($tout == 1 or $menu2==1) { ?>
menu.AddRub("<B>COMMERCIAL</B>","N","recap_commercial.php");
menu.AddLien("Commandes","evaluations_client.php");
menu.AddLien("Livraisons","registres_vendeurs.php");
<? }?>

<?php if($tout == 1 or $menu5==1) { ?>
menu.AddRub("<B>FACTURATION</B>","N","option.html");
menu.AddLien("Creation","option1.html");
menu.AddLien("Mise à jour","option2.html");
menu.AddLien("Edition","option3.html");
<? }?>

<?php if($tout == 1 or $menu7==1) { ?>
menu.AddRub("<B>ENCAISSEMENTS</B>","N","siteweb.html");
menu.AddLien("Creation","option3.html");
menu.AddLien("Mise à jour","option3.html");
menu.AddLien("Edition","option3.html");
<? }?>

<?php if($tout == 1 or $menu1==1) { ?>
menu.AddRub("<B>PARAMETRAGES</B>","N","siteweb.html");
menu.AddLien("Articles","option3.html");
menu.AddLien("Clients","option3.html");
menu.AddLien("Fournisseurs","option3.html");
<? }?>

<?php if($tout == 1 or $menu13==1) { ?>
menu.AddRub("<B>ECHEANCIER</B>","N","siteweb.html");
menu.AddLien("Creation","option3.html");
menu.AddLien("Mise à jour","option3.html");
menu.AddLien("Edition","option3.html");
<? }?>

<?php if($tout == 1 or $menu10==1) { ?>
menu.AddRub("<B>STOCK</B>","N","siteweb.html");
menu.AddLien("Creation","option3.html");
menu.AddLien("Mise à jour","option3.html");
menu.AddLien("Edition","option3.html");
<? }?>

<?php if($tout == 1 or $menu13==1) { ?>
menu.AddRub("<B>PAIE</B>","N","siteweb.html");
menu.AddLien("Creation","option3.html");
menu.AddLien("Mise à jour","option3.html");
menu.AddLien("Edition","option3.html");
<? }?>

<?php if($tout == 1 or $menu13==1) { ?>
menu.AddRub("<B>MAINTENANCE</B>","N","siteweb.html");
menu.AddLien("Creation","option3.html");
menu.AddLien("Mise à jour","option3.html");
menu.AddLien("Edition","option3.html");
<? }?>

<?php if($tout == 1 or $menu15==1) { ?>
menu.AddRub("<B>BON DE COMMANDES</B>","N","recap_commandes.php");
menu.AddLien("Creation","bc_mps.php");
menu.AddLien("Liste Pieces","articles_commandes.php");
menu.AddLien("Demande Prix","demandes_prix_mps.php");

<? }?>



function CreerMenu(police,ColFerme,ColOuvert,imgO,imgF,imgOption,imgOptionFin,hauteur,target,mode) {
	this.nb_rub=0;
	this.police=police;
	this.colF=ColFerme;
	this.colO=ColOuvert;
	this.imgO=imgO;
	this.imgF=imgF;
	this.imgOpt=imgOption;
	this.imgOptFin=imgOptionFin;
	this.hauteur=hauteur;
	this.target=target;
	this.mode=mode;
	this.AddRub=AddRubrique;
	this.AddLien=AddLink;
}

function AddRubrique(txt,aff,page) {
	var rub = new Object;
	rub.txt=txt;
	rub.aff=aff;
	rub.page=page;
	rub.nb_lien=0;
	this[this.nb_rub]=rub;
	this.nb_rub++;
}
function AddLink(txt,page,target) {
	var no_rub = this.nb_rub-1;
	var no_lien= this[no_rub].nb_lien;
	var lien = new Object;
		lien.txt=txt;
		lien.page=page;
		lien.target="";
		if ((target!=null)&&(target!="")) {lien.target=target;}
	this[no_rub][no_lien]=lien;
	this[no_rub].nb_lien++;
}
</SCRIPT>
</HEAD>

<FRAMESET COLS="230,*">
	<FRAME NAME="left" SRC="navigdyn.html">
	<FRAME NAME="right" SRC="intro.html">
</FRAMESET><noframes></noframes>

</HTML>

<!-- Script développé par Olivier Hondermarck  webmaster@toutjavascript.com -->
<!-- D'autres scripts et des conseils sur http://www.toutjavascript.com -->

