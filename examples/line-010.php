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
$du="2011-10-01";$au="2011-10-10";
$du_f=dateUsToFr($du);$au_f=dateUsToFr($au);
$graph->title->set('Production TABOURET A PASTILLES 50 N (22h-06h) du 01/10/11 au 10/10/11');
$graph->title->setFont(new Tuffy(12));
$graph->title->setColor(new DarkRed);


$link = mysql_connect("localhost", "root", "");
mysql_select_db("mps2009", $link);
$produit="TABOURET A PASTILLES 50 N";
$res1 = mysql_query("SELECT prod_14_22,prod_6_14,prod_22_6,date from details_productions where date between '$du' and '$au' and produit='$produit' order by date", $link);
$tab1=array();
{while($ligne1= mysql_fetch_array ($res1))
array_push($tab1,$ligne1['prod_22_6']);
/*$date=dateUsToFr($ligne1['date']);$data=$ligne1['prod_14_22'];
echo "<tr><td>$date</td><td>$data</td></tr>";*/
}


/*$plot = new LinePlot(array(5, 3, 4, 7, 6, 5, 8, 4, 7));*/
$plot = new LinePlot($tab1);

// Change plot size and position
$plot->setSize(0.76, 1);
$plot->setCenter(0.38, 0.5);

$plot->setPadding(30, 15, 38, 25);
$plot->setColor(new Orange());
$plot->setFillColor(new LightOrange(80));

// Change grid style
$plot->grid->setType(Line::DASHED);

// Add customized  marks
$plot->mark->setType(Mark::STAR);
$plot->mark->setFill(new MidRed);
$plot->mark->setSize(6);

// Change legend
$plot->legend->setPosition(1, 0.5);
$plot->legend->setAlign(Legend::LEFT);
$plot->legend->shadow->smooth(TRUE);

$plot->legend->add($plot, 'Production', Legend::MARK);

$graph->add($plot);
$graph->draw();
?>