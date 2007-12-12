<?php
//@type: F
//@desc: Wielki Hal
$title = "Wielki Hal";
require_once("includes/head.php");
if ($player -> location != 'Athkatla' ) {
    error ("Zapomnij o tym");
}
   
if ($player -> location == 'Athkatla') {
    $prisoner = mysql_query("select * from players where rank='Admin' or rank='Staff' or rank='Prawnik' or rank='Protektor' or rank='Kronikarz' or rank='Sedzia' or rank='Posel' or rank='Lawnik' or rank='Sekretarz Sadu' or rank='Ksiadz' or rank='Namiestnik' or rank='Szlachta' or rank='Medrzec' order by rank asc");
    $number = mysql_num_rows($prisoner);
    $smarty -> assign ("Number", $number);
    if ($number > 0) {
        $arrid = array();
        $arrname = array();
		$arrrank = array();
         $i = 0;
		while ($pary = mysql_fetch_array($prisoner)) {
            $arrid[$i] = $pary['id'];
			$arrname[$i] = $pary['user'];
			$arrrank[$i] = $pary['rank'];
            $i = $i + 1;
        }
        $smarty -> assign ( array("Id" => $arrid, "Name" => $arrname, "Rank" => $arrrank));
    }
}

$smarty -> assign ( array("Location" => $player -> location));
$smarty -> display ('urzad1.tpl');

require_once("includes/foot.php"); 
?>
