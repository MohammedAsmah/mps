<?php
/*
 * This work is hereby released into the Public Domain.
 * To view a copy of the public domain dedication,
 * visit http://creativecommons.org/licenses/publicdomain/ or send a letter to
 * Creative Commons, 559 Nathan Abbott Way, Stanford, California 94305, USA.
 *
 */

require_once "../LinePlot.class.php";
require "config.php";
require "connect_db.php";
require "functions.php";
$graph = new Graph(855, 350);

// Set title
$du="2011-10-01";$au="2011-10-10";
$du_f=dateUsToFr($du);$au_f=dateUsToFr($au);
//$exe1=$_GET['exe1'];$exe2=$_GET['exe2'];$exe3=$_GET['exe3'];$exe4=$_GET['exe4'];
$exe1="2013";$exe2="2014";$exe3="2015";$exe4="2016";
$ca1=$_GET['ca1'];$ca2=$_GET['ca2'];$ca3=$_GET['ca3'];$ca4=$_GET['ca4'];$produit=$_GET['produit'];
$graph->title->set('VARIATION C.A ');
$graph->title->setFont(new Tuffy(12));
$graph->title->setColor(new DarkRed);



$exercices=array();$valeurs=array();

array_push($exercices,$exe1);
array_push($exercices,$exe2);
array_push($exercices,$exe3);
array_push($exercices,$exe4);
array_push($valeurs,$ca1);
array_push($valeurs,$ca2);
array_push($valeurs,$ca3);
array_push($valeurs,$ca4);

/*$plot = new LinePlot(array(5, 3, 4, 7, 6, 5, 8, 4, 7));*/
$plot = new LinePlot($valeurs,$exercices);

// Change plot size and position
$plot->setSize(0.76, 1);
$plot->setCenter(0.38, 0.5);

//$plot->setPadding(30, 15, 38, 25);
$plot->setPadding(80, 30, 38, 30);
$plot->setColor(new Orange());
$plot->setFillColor(new LightOrange(80));

// Change grid style
$plot->grid->setType(Line::DASHED);

// Add customized  marks
$plot->mark->setType(Mark::STAR);
$plot->mark->setFill(new MidRed);
$plot->mark->setSize(6);

// Change legend
//$plot->legend->setPosition(1, 0.5);
$plot->legend->setPosition(1, 0.5);
$plot->legend->setAlign(Legend::LEFT);
$plot->legend->shadow->smooth(TRUE);

$plot->legend->add($plot, $produit, Legend::MARK);

$graph->add($plot);
$graph->draw();
?>