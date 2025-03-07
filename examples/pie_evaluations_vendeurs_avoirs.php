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


$values = array(8, 4, 6, 3, 4);
$values=array();
$vendeurs=array();

	
	$sql  = "SELECT vendeur,sum(quantite*prix_unit*condit) As total_net ";$t=0;
	$sql .= "FROM detail_avoirs where date between '$date1' and '$date2' GROUP BY vendeur order by vendeur;";
	$users = db_query($database_name, $sql);
	while($users_ = fetch_array($users)) { 	$pp=$users_['vendeur'].":".number_format($users_['total_net'],2,',',' ');
		array_push($values,$users_['total_net']);
		array_push($vendeurs,$pp);
		$t=$t+$users_['total_net'];$ven=$users_['vendeur'];
		// colors
		/*$sql  = "SELECT * ";
		$sql .= "FROM vendeurs where vendeur='$ven' order BY vendeur;";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$couleur = "new ".$user_["couleur"];
		array_push($colors,$couleur);*/
		}
		$t=number_format($t,2,',',' ');
		
		
$graph->title->set("C.A AVOIRS : $t    Periode  $du au $au");
$graph->title->border->show();
$graph->title->setBackgroundColor(new LightRed(60));
$graph->title->setPadding(3, 3, 3, 3);


$colors = array(
	new Green,
	new LightPurple,
	new LightBlue,
	new LightRed,
	new LightPink,
	new LightOrange,
	new MidBlue,
	new Yellow,
	new MidMagenta
);

$plot = new Pie($values, $colors);
$plot->setSize(0.70, 0.60);
$plot->setCenter(0.40, 0.55);
$plot->set3D(10);
$plot->setBorderColor(new LightGray);

$plot->setLegend($vendeurs);

$plot->legend->setPosition(1.35);

$graph->add($plot);

$graph->draw();


?>