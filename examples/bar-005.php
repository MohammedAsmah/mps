<?php
/*
 * This work is hereby released into the Public Domain.
 * To view a copy of the public domain dedication,
 * visit http://creativecommons.org/licenses/publicdomain/ or send a letter to
 * Creative Commons, 559 Nathan Abbott Way, Stanford, California 94305, USA.
 *
 */

require_once "../BarPlot.class.php";
require "config.php";
require "connect_db.php";
require "functions.php";
$graph = new Graph(800, 700);

// Set a title to the graph
$du="2011-10-01";$au="2011-10-10";
$du_f=dateUsToFr($du);$au_f=dateUsToFr($au);
$graph->title->set("$du_f");

// Change graph background color
$graph->setBackgroundColor(new Color(230, 230, 230));
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
$values = array(8, 2, 6, 1, 3, 5);

// Declare a new BarPlot
$plot = new BarPlot($tab1);

// Reduce padding around the plot
$plot->setPadding(NULL, NULL, NULL, 20);

// Reduce plot size and move it to the bottom of the graph
$plot->setSize(1, 0.96);
$plot->setCenter(0.5, 0.52);

// Set a background color to the plot
$plot->grid->setBackgroundColor(new White);
// Set a dashed grid
$plot->grid->setType(Line::DASHED);


$plot->label->set($values);
$plot->label->move(0, -10);
$plot->label->setColor(new DarkBlue);

// Set a shadow to the bars
$plot->barShadow->setSize(2);

// Bar size is at 60%
$plot->setBarSize(0.6);

// Change the color of the bars
$plot->setBarColor(
	new Orange(15)
);

// Add the plot to the graph
$graph->add($plot);

// Draw the graph
$graph->draw();

?>