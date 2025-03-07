<?php

require_once(".\jpgraph\jpgraph.php");
require_once(".\jpgraph\jpgraph_line.php");
require_once(".\jpgraph\jpgraph_bar.php");


/*$donnees = array(12,23,9,58,23,26,57,48,12);*/
$donnees = array(12,23,9,58,23,26,90,48,12);

$largeur = 450;
$hauteur = 400;

// Initialisation du graphique
$graphe = new Graph($largeur, $hauteur);
// Echelle lineaire ('lin') en ordonnee et pas de valeur en abscisse ('text')
// Valeurs min et max seront determinees automatiquement
$graphe->setScale("textlin");

// Creation de l'histogramme
$histo = new BarPlot($donnees);
// Ajout de l'histogramme au graphique
$graphe->add($histo);

// Ajout du titre du graphique
$graphe->title->set("Histogramme");

// Affichage du graphique
$graphe->stroke();
?>