<? require "config.php";
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
	$menu7 = $user_["menu7"];$menu8 = $user_["menu8"];$menu9 = $user_["menu9"];$menu10 = $user_["menu10"];
	$menu11 = $user_["menu11"];$menu12 = $user_["menu12"];
	$menu13 = $user_["menu13"];$menu14 = $user_["menu14"];$menu15 = $user_["menu15"];$menu16 = $user_["menu16"];

	/*var menu=new CreerMenu("verdana,arial","#0000CC","#0000FF","dyn03.gif","dyn04.gif","dyn02.gif","dyn05.gif",25,'right',"O");*/

?>

<HTML><HEAD>
<TITLE>MPS </TITLE>
<SCRIPT LANGUAGE="JavaScript">
// D'autres scripts et des tutoriaux sur http://www.toutjavascript.com	
// Script gratuit à condition de laisser ce commentaire 

var menu=new CreerMenu("verdana,arial","#000CCC","#000FFF","dyn03.gif","dyn04.gif","dyn02.gif","dyn05.gif",25,'right',"O");
var tout = '<?php echo $tout; ?>' ; 
var menu1 = '<?php echo $menu1; ?>' ; 
var menu2 = '<?php echo $menu2; ?>' ; 
var menu3 = '<?php echo $menu3; ?>' ; 
var menu4 = '<?php echo $menu4; ?>' ; 
var menu5 = '<?php echo $menu5; ?>' ; 
var menu6 = '<?php echo $menu6; ?>' ; 
var menu7 = '<?php echo $menu7; ?>' ; 
var menu8 = '<?php echo $menu8; ?>' ; 
var menu9 = '<?php echo $menu9; ?>' ; 
var menu10 = '<?php echo $menu10; ?>' ; 
var menu11 = '<?php echo $menu11; ?>' ; 
var menu12 = '<?php echo $menu12; ?>' ; 
var menu13 = '<?php echo $menu13; ?>' ; 
var menu14 = '<?php echo $menu14; ?>' ; 
var menu15 = '<?php echo $menu15; ?>' ; 
var menu16 = '<?php echo $menu16; ?>' ; 
var login = '<?php echo $login; ?>' ; 

if ((tout==1)||(menu2!=0)){
menu.AddRub("<B>COMMANDES CLIENTS</B>","N","");
menu.AddLien("Evaluation C","evaluations_client.php");
menu.AddLien("Evaluation V","registres_vendeurs.php");
menu.AddLien("Validation B.Sortie","registres_bons_sortie.php");
menu.AddLien("Caisse Comptoir","journal_caisses_c.php");
}

if ((tout==1)||(menu5!=0)){
menu.AddRub("<B>FACTURATION</B>","N","");
menu.AddLien("Facturation","factures.php");
menu.AddLien("Mise à jour","edition_factures.php");
menu.AddLien("Instance","factures_instances.php");
menu.AddLien("Releve Factures","releves_factures_simples.php");
}

if (tout!=0){
menu.AddRub("<B>SITUATION MATIERES</B>","N","");
menu.AddLien("CA En Quantite","ca_par_quantite.php");
menu.AddLien("Stock Final Matiere","ca_par_matiere.php");
menu.AddLien("Produits Finis","produits_finis.php");
menu.AddLien("Production","entrees_stock_f.php");

menu.AddRub("<B>ENCAISSEMENT</B>","N","");
menu.AddLien("Ajout Reglements","registres_reglements.php");
menu.AddLien("Modification","maj_porte_feuilles.php");
menu.AddLien("Saisie Reglements 2","saisie_reglements.php");
menu.AddLien("Journal Encaissements","journal_encaissements_f.php");
menu.AddLien("Ajout Impayés","saisie_impayes.php.php");
menu.AddLien("Etat Impayés","registres_remises_impayes.php");
menu.AddLien("Encaissement Impayés","registres_remises_impayes_enc.php");
menu.AddLien("Etat Encaiss. Impayés","etat_enc_impayes.php");

menu.AddRub("<B>PORTE FEUILLES</B>","N","");
menu.AddLien("Porte Feuilles Cheques","porte_feuilles_factures.php");
menu.AddLien("Porte Feuilles Effets","porte_feuilles_effets.php");
menu.AddLien("Porte Feuilles Evaluations","porte_feuilles_evaluations.php");
menu.AddLien("Releve Encaissements","releves_encaiss_cheques.php");
menu.AddLien("Remises à la Banque","registres_remises.php");
menu.AddLien("Entree Cheques/Fact","journal_encaissements_chq.php");
menu.AddLien("Entree Cheques/Eval","journal_encaissements_chq_eva.php");
menu.AddLien("Entree Effets","journal_encaissements_effets.php");

menu.AddRub("<B>CAISSES</B>","N","");
menu.AddLien("Caisse Comptoir","journal_caisses_c.php");
menu.AddLien("Caisse Principale","journal_caisses.php");
menu.AddLien("Balance Caisses","balance_caisses.php");

menu.AddRub("<B>GESTION TVA</B>","N","");
menu.AddLien("Encaissements Chq","encaissements_mois_chq.php");
menu.AddLien("Etat effets Echus","encaissements_mois_effet.php");
menu.AddLien("Effets Non Echus du Mois","etat_effets_encaisses_mois.php");
menu.AddLien("Effets Remis à L'escompte","etat_effets_escompte_mois.php");
menu.AddLien("Effets Non Echus Globale","etat_effets_encaisses.php");
menu.AddLien("Effets Echeance Hors Exe","effets_echeances_hors_exercices.php");
menu.AddLien("Etat des virements","encaissements_mois_virement.php");
menu.AddLien("Etat des Effets","etat_effets.php");
menu.AddLien("Encaissements Esp","encaissements_mois_esp.php");
menu.AddLien("Encaissements Global","encaissements_global.php");
menu.AddLien("Releve Factures","releves_factures.php");
menu.AddLien("Releve Encaissements","releves_encaiss_cheques.php");
menu.AddLien("Recherche","recherche.php");
menu.AddLien("T.V.A","declaration_tva.php");

menu.AddRub("<B>EDITIONS</B>","N","");
menu.AddLien("Balance Evaluations","balance_evaluations.php");
menu.AddLien("Palmares Clients","palmares_clients.php");
menu.AddLien("Palmares Vendeurs","palmares_vendeurs.php");
menu.AddLien("Palmares Articles","choix_produits_palmares.php");
menu.AddLien("Palmares Secteurs","palmares_secteurs.php");


menu.AddRub("<B>COMMISSIONS</B>","N","");
menu.AddLien("/Evaluations","balance_com_net3.php");
menu.AddLien("/Factures","balance_com_net3_f.php");
menu.AddLien("Encaiss/Global","balance_com_net3_fe.php");
menu.AddLien("Enc espece/mois","encaissements_especes_mois_encours");
menu.AddLien("Enc espece/encompte","encaissements_especes_encompte.php");
menu.AddLien("Enc cheques s","encaissements_cheques_mois_encours.php");
menu.AddLien("Enc cheques/encompte","encaissements_cheques_encompte.php");
menu.AddLien("Encaiss/Global","balance_com_net3_fe.php");

menu.AddRub("<B>ACHATS</B>","N","");
menu.AddLien("Fournisseurs","fournisseurs.php");
menu.AddLien("Familles Commandes","familles_articles_commandes.php");
menu.AddLien("Matieres","achats_mat.php");
menu.AddLien("Consomables","achats_mat_cons.php");
menu.AddLien("Tiges","achats_tig.php");
menu.AddLien("Colorants","achats_col.php");
menu.AddLien("Emballages","achats_emb.php");
menu.AddLien("Etiquettes","achats_eti.php");
menu.AddLien("Divers","achats_divers.php");
menu.AddLien("Divers","balance_achats.php");
menu.AddLien("Balance / Famille","balance_achats_types.php");
menu.AddLien("Balance Fournisseurs","balance_fournisseurs.php");
menu.AddLien("Regl. Fournisseurs","registres_reglements_frs.php");

}

if ((tout==1)||(menu1!=0)){
menu.AddRub("<B>PARAMETRAGE</B>","N","");
menu.AddLien("Articles","produits.php");
menu.AddLien("Clients","clients.php");
menu.AddLien("Fournisseurs","fournisseurs.php");
menu.AddLien("Employes","fiches_employes.php");
menu.AddLien("Matiere Premiere","matieres.php");
menu.AddLien("Matiere Consomable","matieres_c.php");
menu.AddLien("Colorants","colorants.php");
menu.AddLien("Tiges","tiges.php");
menu.AddLien("Emballages","emballages.php");
menu.AddLien("Etiquettes","etiquettes.php");
menu.AddLien("Promotions","promotions.php");
menu.AddLien("Vendeurs","vendeurs.php");
menu.AddLien("Villes","villes.php");
}

if ((tout==1)||(menu13!=0)){
menu.AddRub("<B>ECHIANCIER</B>","N","");
menu.AddLien("Credits","credits.php");
menu.AddLien("Provisions","provisions.php");
menu.AddLien("Effets O.C","effets_oc.php");
menu.AddLien("Effets AVV.ACC","effets_aa.php");
menu.AddLien("Echeancier Previsionnel","echeancier_previsionnels.php");
menu.AddLien("Mise à jour Echeances","maj_echeances.php");
menu.AddLien("Edition Echeancier","echeancier_mps.php");
menu.AddLien("Echeancier Echus","echeancier_mps_echus.php");
}


if ((tout==1)||(menu1!=10)){
menu.AddRub("<B>STOCK</B>","N","");
menu.AddLien("Production","entrees_stock.php");
menu.AddLien("MPS->JAOUDA","entrees_stock_a_vers_b.php");
menu.AddLien("JAOUDA->MPS","entrees_stock_b_vers_a.php");
menu.AddLien("Etat Stock","stock_produits.php");
menu.AddLien("Mise à jour Stock","entrees_stock_report.php");
menu.AddLien("Programme","produits_en_production.php");
menu.AddLien("Validation Sorties","registres_vendeurs_s.php");
menu.AddLien("Dispatching Sortie","registres_bons_sortie.php");
}

if ((tout==1)||(menu11!=0)){
menu.AddRub("<B>PRODUCTION</B>","N","");
menu.AddLien("Ajout","productions.php");
menu.AddLien("Machines","machines.php");
menu.AddLien("Programme","programme_machines.php");
menu.AddLien("Retours","etat_avoirs_articles.php");
}

if ((tout==1)||(menu14!=0)){
menu.AddRub("<B>POINTAGE HEBDO</B>","N","");
menu.AddLien("Importation","entrer_fichier_pointgae.php");
menu.AddLien("Controle Pointage","maj_pointage2.php");
menu.AddLien("Cartes Pointage","carte_pointage.php");
menu.AddLien("Etat de Pointage","etat_pointage_globale.php");

}

if ((tout==1)||(menu16!=0)){
menu.AddRub("<B>AVOIRS CLIENTS</B>","N","");
menu.AddLien("Ajout Avoirs","avoirs_client.php");
menu.AddLien("Evaluation Avoirs","regrouper_avoirs_client.php");
menu.AddLien("Avoirs / Vendeurs","etat_avoirs_vendeurs.php");
menu.AddLien("Avoirs / Clients","etat_avoirs_clients.php");
menu.AddLien("Avoirs / Articles","etat_avoirs_articles.php");
}

if ((tout==1)||(menu15!=0)){
menu.AddRub("<B>BON DE COMMANDE</B>","N","");
menu.AddLien("Ajout Commande","bc_mps.php");
menu.AddLien("Etat Commandes","etat_bc_mps.php");
menu.AddLien("Articles","articles_commandes.php");
menu.AddLien("Familles","familles_articles_commandes.php");
menu.AddLien("Recherche / Famille","consulter_base_fournisseurs.php");
menu.AddLien("Recherche / Article","consulter_base_fournisseurs_article.php");
menu.AddLien("Tarifs Achats","tarifs_achats.php");
}

menu.AddRub("<B>REPERTOIRE</B>","N","");
menu.AddLien("Global","contacts.php");
menu.AddLien("Partiel","contacts_g.php");

if ((tout==1)&&(login=="admin")){
menu.AddRub("<B>Identifications</B>","N","");
menu.AddLien("Utilisateurs","users.php");
}


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

<FRAMESET COLS="250,*">
	<FRAME NAME="left" SRC="navigdyn.html">
	<FRAME NAME="right" SRC="intro.html">
</FRAMESET><noframes></noframes>

</HTML>

<!-- Script développé par Olivier Hondermarck  webmaster@toutjavascript.com -->
<!-- D'autres scripts et des conseils sur http://www.toutjavascript.com -->

