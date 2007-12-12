<?php
$title = "Bogactwa";
require_once("includes/head.php");

/**
* Get the localization for game
*/
//$gr13 = $db -> Execute("SELECT id, copper, zelazo, wegiel, adam, meteo, krysztal, lumber FROM kopalnie WHERE gracz=".$player -> id);
//$gr1 = $db -> Execute("SELECT id, nutari, illani, illanias, dynallca FROM herbs WHERE gracz=".$player -> id);
$query = $db -> Execute("SELECT id FROM players WHERE refs=".$player -> id);
$ref = $query -> RecordCount();
$query -> Close();
$smarty -> assign(array("Refs" => $ref,
	"Maps" => $player -> maps,
//	"soul" => $player -> soul,
//	"bless" => $player -> bles,
//	"chaos" => $player -> chaos,
	"Gold" => $player -> gold,
	"Bank" => $player -> bank,
	"Mithril" => $player -> mithril,
	"Copper" => $player -> copper,
	"Iron" => $player -> iron,
	"Coal" => $player -> coal,
	"Adamantium" => $player -> adamantium,
	"Meteor" => $player -> meteor,
	"Crystal" => $player -> crystal,
	"Lumber" => $player -> wood,
	"Illani" => $player -> illani,
	"Illanias" => $player -> illanias,
	"Nutari" => $player -> nutari,
	"Dynallca" => $player -> dynallca,
	"Ryby" => $player -> fish,
	"Grzyby" => $player -> grzyby,
	"Ziemniaki" => $player -> potato));

$smarty -> display ('zloto.tpl');

require_once("includes/foot.php");
?>

