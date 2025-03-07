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
$du="2011-10-01";$au="2011-10-10";
$du_f=dateUsToFr($du);$au_f=dateUsToFr($au);
$link = mysql_connect("localhost", "root", "");
mysql_select_db("mps2009", $link);
$produit="TABOURET A PASTILLES 50 N";
$res1 = mysql_query("SELECT * from details_productions where date between '$du' and '$au' and produit='$produit' order by date", $link);
$tab1=array();
{while($ligne1= mysql_fetch_array ($res1))
array_push($tab1,$ligne1['rebut_1']+$ligne1['rebut_2']+$ligne1['rebut_3']);
/*$date=dateUsToFr($ligne1['date']);$data=$ligne1['prod_14_22'];
echo "<tr><td>$date</td><td>$data</td></tr>";*/
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
	new Color(230, 230, 230)
);

// Change grid background color
$plot->grid->setBackgroundColor(
	new Color(235, 235, 180, 60)
);

// Hide grid
$plot->grid->hide(TRUE);

// Hide labels on Y axis
$plot->yAxis->label->hide(TRUE);

$plot->xAxis->label->setInterval(1);

$plot->label->set($tab1);
$plot->label->setFormat('%.0f');
$plot->label->setBackgroundColor(new Color(240, 240, 240, 15));
$plot->label->border->setColor(new Color(255, 0, 0, 15));
$plot->label->setPadding(5, 3, 1, 1);

$plot->xAxis->label->move(0, 5);
$plot->xAxis->label->setBackgroundColor(new Color(240, 240, 240, 15));
$plot->xAxis->label->border->setColor(new Color(0, 150, 0, 15));
$plot->xAxis->label->setPadding(5, 3, 1, 1);

$graph->add($plot);
$graph->draw();
?>