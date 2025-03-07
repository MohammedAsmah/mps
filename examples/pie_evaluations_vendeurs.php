<?php
/*
 * This work is hereby released into the Public Domain.
 * To view a copy of the public domain dedication,
 * visit http://creativecommons.org/licenses/publicdomain/ or send a letter to
 * Creative Commons, 559 Nathan Abbott Way, Stanford, California 94305, USA.
 *
 */

require_once "../Pie.class.php";
require "config.php";
require "connect_db.php";
require "functions.php";

$graph = new Graph(900, 450);
$graph->setAntiAliasing(TRUE);
$date1=$_GET['date1'];$date2=$_GET['date2'];$encours="encours";
$du=dateUsToFr($date1);$au=dateUsToFr($date2);
$graph->title->set("C.A PAR VENDEUR $du au $au");
$graph->title->border->show();
$graph->title->setBackgroundColor(new LightRed(60));
$graph->title->setPadding(3, 3, 3, 3);

$values = array(8, 4, 6, 3, 4);
$values=array();
$vendeurs=array();

	
	$sql  = "SELECT id,trimestre,vendeur,client,net,date_e,solde,sum(net) As total_net,sum(solde) As total_solde ";
	$sql .= "FROM commandes where date_e between '$date1' and '$date2' and evaluation<>'$encours' and id_registre<>0 GROUP BY vendeur order by total_net DESC;";
	$users = db_query($database_name, $sql);
	while($users_ = fetch_array($users)) { 	$pp=$users_['vendeur'].":".number_format($users_['total_net'],2,',',' ');
		array_push($values,$users_['total_net']);
		array_push($vendeurs,$pp);
		}


$colors = array(
	new LightOrange,
	new LightPurple,
	new LightBlue,
	new LightRed,
	new LightPink,
	new Green,
	new MidBlue,
	new Yellow,
	new MidMagenta
);

$plot = new Pie($values, $colors);
$plot->setSize(0.70, 0.60);
$plot->setCenter(0.40, 0.55);
$plot->set3D(10);
$plot->setBorderColor(new LightGray);

/*$plot->setLegend(array(
	'AGHRAR HASSAN',
	'Beta',
	'Gamma',
	'Delta',
	'Epsilon'
));*/
$plot->setLegend($vendeurs);

$plot->legend->setPosition(1.35);

$graph->add($plot);
$graph->draw();

?>