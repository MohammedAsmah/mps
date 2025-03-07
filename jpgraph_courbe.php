<?php

require_once(".\jpgraph\jpgraph.php");
require_once(".\jpgraph\jpgraph_line.php");
/*require_once(".\jpgraph\jpgraph_bar.php");*/

require "config.php";
require "connect_db.php";
require "functions.php";
$link = mysql_connect("localhost", "root", "");
mysql_select_db("mps2009", $link);
$produit="TABOURET A PASTILLES 50 N";$du="2011-10-01";$au="2011-10-10";
$du_f=dateUsToFr($du);$au_f=dateUsToFr($au);
$res1 = mysql_query("SELECT prod_14_22 from details_productions where date between '$du' and '$au' and produit='$produit'", $link);
$tab1=array();
{while($ligne1= mysql_fetch_array ($res1))
array_push($tab1,$ligne1['prod_14_22']);
}
	

/*$donnees = array(12,23,9,58,23,26,57,48,12,90);*/
$donnees = array(1,2,3,4,5,6,7,8,9);

$largeur = 850;
$hauteur = 500;

// Initialisation du graphique
$graphe = new Graph($largeur, $hauteur);
// Echelle lineaire ('lin') en ordonnee et pas de valeur en abscisse ('text')
// Valeurs min et max seront determinees automatiquement
$graphe->setScale("textlin");

// Creation de la courbe
$courbe = new LinePlot($tab1);
/*$courbe = new BarPlot($tab1);*/

// Ajout de la courbe au graphique
$graphe->add($courbe);

// Ajout du titre du graphique
$graphe->title->set("Courbe $produit Equipe 14H-22H du $du_f au $au_f ");

// Affichage du graphique
$graphe->stroke();
?>