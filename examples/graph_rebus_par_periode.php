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
$graph = new Graph(605, 250);

// Set title
$du1=$_GET["du"];$au1=$_GET["au"];$machine=$_GET["machine"];$produit=$_GET["produit"];
$du_f=dateUsToFr($du1);$au_f=dateUsToFr($au1);$titre="Rebuts $produit / $machine du $du_f au $au_f";
$graph->title->set("$titre");
$graph->title->setFont(new Tuffy(12));
$graph->title->setColor(new DarkRed);


$link = mysql_connect("localhost", "root", "");
mysql_select_db("mps2009", $link);

$res1 = mysql_query("SELECT rebut_1,rebut_2,rebut_3,date from details_productions where date between '$du1' and '$au1' and produit='$produit' and machine='$machine' order by date", $link);
$tab1=array();
while($ligne1= mysql_fetch_array ($res1)) {
	$pp=$ligne1['rebut_1']+$ligne1['rebut_2']+$ligne1['rebut_3'];
	array_push($tab1,$pp);

}

$graph = new Graph(700, 300);
$graph->setAntiAliasing(TRUE);

$x = array(
	1, 2, 5, 0.5, 3, 8, 7, 6, 2, -4
);

$plot = new LinePlot($tab1);

// Change component padding
$plot->setPadding(10, NULL, NULL, NULL);

// Change component space
$plot->setSpace(5, 5, 5, 5);

// Set a background color
$plot->setBackgroundColor(
	/*new Color(230, 230, 230)*/
	new Color(255, 255, 255, 255)
);

// Change grid background color
$plot->grid->setBackgroundColor(
	/*new Color(235, 235, 180, 60)*/
	new Color(255, 255, 255, 255)
);



$plot->grid->hide(TRUE);


$plot->yAxis->label->hide(TRUE);

$plot->xAxis->label->setInterval(1);

$plot->label->set($tab1);
$plot->label->setFormat('%.0f');
$plot->label->setBackgroundColor(new Color(240, 240, 240, 15));
$plot->label->border->setColor(new Color(255, 0, 0, 15));
$plot->label->setPadding(5, 3, 1, 1);

$plot->xAxis->label->move(0, 5);
/*$plot->xAxis->label->setBackgroundColor(new Color(240, 240, 240, 15));*/
$plot->xAxis->label->setBackgroundColor(new Color(255, 255, 255, 255));
$plot->xAxis->label->border->setColor(new Color(0, 150, 0, 15));
$plot->xAxis->label->setPadding(5, 3, 1, 1);


$plot->legend->setPosition(0.75, 0.5);
/*$plot->legend->setAlign(Legend::LEFT);*/
$plot->legend->shadow->smooth(TRUE);

$plot->legend->add($plot, "$titre", Legend::MARK);

$graph->add($plot);
$graph->draw();





/*

$plot = new LinePlot($tab1);


$plot->setSize(0.76, 1);
$plot->setCenter(0.38, 0.5);

$plot->setPadding(30, 15, 38, 25);
$plot->setColor(new Orange());
$plot->setFillColor(new LightOrange(80));


$plot->grid->setType(Line::DASHED);


$plot->mark->setType(Mark::STAR);
$plot->mark->setFill(new MidRed);
$plot->mark->setSize(6);


$plot->legend->setPosition(1, 0.5);
$plot->legend->setAlign(Legend::LEFT);
$plot->legend->shadow->smooth(TRUE);

$plot->legend->add($plot, 'Production', Legend::MARK);

$graph->add($plot);
$graph->draw();
*/
?>