<?php
$title = "Dystrybucja AP";
require_once("includes/head.php");

$atrArr = array( 'str', 'dex', 'con', 'spd', 'int', 'wis' );
$rData = SqlExec( "SELECT * FROM races WHERE name='{$player->race}'" );
$rData = array_shift( $rData->GetArray() );
$cData = SqlExec( "SELECT id, code_name, name, IF( str=0, 0, str ) AS str, IF( dex=0, 0, dex ) AS dex, IF( con=0, 0, con ) AS con, IF( spd=0, 0, spd ) AS spd, IF( `int`=0, 0, `int` ) AS `int`, IF( wis=0, 0, wis ) AS wis FROM classes WHERE name='{$player->clas}'" );
$cData = array_shift( $cData -> GetArray() );
foreach( $atrArr as $el ) {
	$atr[$el]['base'] = sprintf("%01.3f",  $player->$el );
	$atr[$el]['race'] = $rData[$el];
	$atr[$el]['class'] = $cData[$el];
	//$atr[$el]['add'] = ( isset())
}

//qDebug( $atr );
$smarty->assign( array( "AtrArr" => $atrArr, "Atr" => $atr, "Left" => $player->ap ) );



if ( !empty( $_POST ) ) {
	//qDebug( $_POST );
	if( array_sum( $_POST['atr'] ) > $player->ap ) {
		error( "Nie masz tylu punktów !" );
	}
	$oldraw = $player -> RawReturn;
    $player -> RawReturn = TRUE;
    $total = 0;
	foreach( $atrArr as $el ) {
		$toAdd = floatval( $_POST['atr'][$el] ) * ( $atr[$el]['race'] + $atr[$el]['class'] );
		//qDebug( "$el : $toAdd" );
		$total += floatval( $_POST['atr'][$el] );
		$player->$el = sprintf("%01.3f", $player->getAtr( $el ) + $toAdd );
	}
	$player -> ap -= $total;
	$player -> RawReturn = $oldraw;
	error( "Punkty rozdane !", 'done', 'stats.php' );
//    $arrpoints = array(0,0,0,0,0,0);
//    $arrname = array('Sily','Zrecznosci','Szybkosci','Wytrzymalosci','Inteligencji','Sily Woli');
//    $oldraw = $player -> RawReturn;
//    $player -> RawReturn = TRUE;
//    for ($i=0;$i<6;$i++) {
//        $arrpoints[$i] = $arrchar[$i] * $arrgain[$i];
//    }
//    if ($arrpoints[0] > 0) {
//	    //$db -> Execute("UPDATE players SET strength=strength+".$arrpoints[0]." WHERE id=".$player -> id);
//	    $player -> str += $arrpoints[0];
//    }
//    if ($arrpoints[1] > 0) {
//	    //$db -> Execute("UPDATE players SET agility=agility+".$arrpoints[1]." WHERE id=".$player -> id);
//	    $player -> dex += $arrpoints[1];
//    }
//    if ($arrpoints[2] > 0) {
//	    //$db -> Execute("UPDATE players SET szyb=szyb+".$arrpoints[2]." WHERE id=".$player -> id);
//	    $player -> spd += $arrpoints[2];
//    }
//    if ($arrpoints[3] > 0) {
//        //$db -> Execute("UPDATE players SET max_hp=max_hp+".$arrpoints[3]." WHERE id=".$player -> id);
//	    //$db -> Execute("UPDATE players SET wytrz=wytrz+".$arrpoints[3]." WHERE id=".$player -> id);
//	    $player -> hp_max += $arrpoints[3];
//	    $player -> con += $arrpoints[3];
//    }
//    if ($arrpoints[4] > 0) {
//	    //$db -> Execute("UPDATE players SET inteli=inteli+".$arrpoints[4]." WHERE id=".$player -> id);
//	    $player -> int += $arrpoints[4];
//    }
//    if ($arrpoints[5] > 0) {
//	    //$db -> Execute("UPDATE players SET wisdom=wisdom+".$arrpoints[5]." WHERE id=".$player -> id);
//	    $player -> wis += $arrpoints[5];
//    }
//    //$db -> Execute("UPDATE players SET ap=ap-".$sum." WHERE id=".$player -> id);
//    $player -> ap -= $sum;
//    $player -> RawReturn = $oldraw;
//    $smarty -> assign (array ("Amount" => $arrpoints, "Name" => $arrname));
}
//inicjalizacja zmiennej
if (!isset($_GET['step'])) {
    $_GET['step'] = '';
}

// przypisanie zmiennych oraz wyswitlenie strony
$smarty -> assign (array ("Step" => $_GET['step'], "Ap" => $player -> ap));
$smarty -> display ('ap.tpl');

require_once("includes/foot.php");
?>
