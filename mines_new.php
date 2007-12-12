<?php
//@type: F
//@desc: Kopalnie
/***************************************************************************
 *                               mines.php
 *                            -------------------
 *   copyright            : (C) 2006 Kara-Tur based on Vallheru
 *   email                : ivan-q@o2.pl
 *
 ***************************************************************************/

/***************************************************************************
 *
 *       This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with this program; if not, write to the Free Software
 *   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 ***************************************************************************/
$title="Kopalnia";
require_once("includes/head.php");

checklocation($_SERVER['SCRIPT_NAME']);

//error("Modernizacja ! Proszê o cierpliwo¶æ");
/*if($player->location!="Trolowe Gory" && $player->location!="Male Zeby" && $player->location!="Chmurne Szczyty")
	error("Zapomnij o tym");*/

if( !isset( $_GET['step'] ) ) {
	$_GET['step'] = '';
}
if( !isset( $_GET['view'] ) ) {
	$_GET['view'] = '';
}
	
$mineData = array( 'mid' => NULL, 'zelazo' => false, 'miedz' => false, 'wegiel' => false );
if($player->location=="Trolowe Gory") {
	$mineData['mid'] = 1;
	$mineData['zelazo'] = true;
}
if($player->location=="Male Zeby") {
	$mineData['mid'] = 2;
	$mineData['wegiel'] = true;
}
if($player->location=="Chmurne Szczyty" && $player->mapx==31 && $player->mapy==39){
	$mineData['mid'] = 3;
	$mineData['miedz'] = true;
}
if($player->location=="Chmurne Szczyty" && $player->mapx==34 && $player->mapy==39){
	$mineData['mid'] = 4;
	$mineData['miedz'] = true;
}
if($player->location=="Chmurne Szczyty" && $player->mapx==35 && $player->mapy==39){
	$mineData['mid'] =4;
	$mineData['miedz'] = true;
}

if( !$mineData['mid'] ) {
	error( "Tutaj nie ma ¿adnej kopalni !", 'error', 'mapa.php' );
}
$mid = $mineData['mid'];
$mine=SqlExec("SELECT * FROM mines WHERE pid=".$player->id." AND mid=".$mid.";");

if (isset ($_GET['kup'])) { 
	switch ($_GET['kup']) {
		case "miedz" :
			$koszt=25;
			break;
		case "zelazo" :
			$koszt=50;
			break;
		case "wegiel" :
			$koszt=75;
			break;
		default :
			error("Nieprawid³owy typ kopalni !");
	}
	if( ! $mineData[$_GET['kup']] ) 
		error("Tutaj nie mo¿na tego wydobywaæ !");
	if($mine->fields[$_GET['kup']]>0)
		error("Ju¿ zakupi³e¶ t± kopalniê !");
    if ($player -> mithril < $koszt) {
		error ("Nie masz wystarczajaco duzo sztuk mithrilu.");
    } else {
		//$db -> Execute("UPDATE players SET platinum=platinum-".$koszt." WHERE id=".$player -> id);
		$player -> mithril -= $koszt;
        if (!$mine -> fields['id']) {
	    	SqlExec("INSERT INTO mines (pid, mid, ".$_GET['kup'].") VALUES(".$player -> id.", ".$mid.", 1)");
		} else {
	    	SqlExec("UPDATE mines SET ".$_GET['kup']."=1 WHERE pid=".$player -> id." AND mid=".$mid);
		}
	error ("Kupiles kopalnie ! Mo¿esz teraz wydobywaæ ".$_GET['kup']."!",'done');
    }
}
if ( $_GET['view'] == 'stats' || $_GET['view'] == 'mine' ){
    $smarty -> assign ( array("Copper" => $mine -> fields['miedz'], "Iron" => $mine -> fields['zelazo'], "Coal" => $mine -> fields['wegiel'], "Ops" => $mine -> fields['oper']));
}
if ( $_GET['view'] == 'shop' ) {
	$kosztm = ($mine -> fields['miedz'] * 5000);
    $kosztz = ($mine -> fields['zelazo'] * 10000);
    $kosztw = ($mine -> fields['wegiel'] * 15000);
    
    $addLink = array();
    $buyLink = array();
    
    if($mine->fields['miedz']>0) {
    	$addLink[] = '<input type="radio" name="add" value="miedz">Dokup obszar miedzi ('.$kosztm.')<br>';
    }
    elseif( $mineData['miedz'] ) {
    	$buyLink[] = '<li><a href="mines_new.php?kup=miedz">Kopalnia miedzi - 25 sztuk mithrilu</a></li>';
    }
    if($mine->fields['zelazo']>0) {
    	$addLink[] = '<input type="radio" name="add" value="zelazo">Dokup obszar ¿elaza ('.$kosztz.')<br>';
    }
    elseif( $mineData['zelazo'] ) {
    	$buyLink[] = '<li><a href="mines_new.php?kup=zelazo">Kopalnia ¿elaza - 50 sztuk mithrilu</a></li>';
    }
    if($mine->fields['wegiel']>0) {
    	$addLink[] = '<input type="radio" name="add" value="wegiel">Dokup obszar wêgla ('.$kosztw.')<br>';
    }
    elseif( $mineData['wegiel'] ) {
    	$buyLink[] = '<li><a href="mines_new.php?kup=wegiel">Kopalnia wêgla - 75 sztuk mithrilu</a></li>';
    }
    
    
    $smarty->assign( array( "AddLink" => $addLink,
    						"BuyLink" => $buyLink ) );
 
    if(isset($_GET['action']) && $_GET['action']=="buy") {
    	if(!isset($_POST['add']))
    		error("Wybierz typ kopalni !");
    	
    	if( !$mineData[$_POST['add']] ) {
    		error( "Tutaj tego nie wydobywamy !" );
    	}
    	if($_POST['add']=="miedz")
    		$koszt=$kosztm;
    	elseif($_POST['add']=="zelazo")
    		$koszt=$kosztz;
    	elseif($_POST['add']=="wegiel")
    		$koszt=$kosztw;
    	if($player->gold<$koszt)
    		error("Za ma³o pieniêdzy");
		$player -> gold -= $koszt;
    	SqlExec("UPDATE mines SET ".$_POST['add']."=".$_POST['add']."+1 WHERE pid=".$player->id." AND mid=".$mid);
    	//$db->Execute("UPDATE players SET credits=credits-".$koszt." WHERE id=".$player->id) or die ("UPDATE players SET credits=credits-".$koszt." WHERE id=".$player->id);
		
    	error("Zakupi³e¶ dodatkowy obszar za cenê ".$koszt." !",'done');
    }
}
if (isset ($_GET['view']) && $_GET['view'] == 'mine') {
    if ($player -> hp <= 0) {
	error ("Nie mozesz wydobywac mineralow poniewaz jestes martwy!");
    }
    $arroption = array();
    if($mine -> fields['miedz'] > 0) {
        $arroption[] = "<option value='miedz'>miedzi</option>";
    }
    if ($mine -> fields['zelazo'] > 0) {
        $arroption[] = "<option value='zelazo'>zelaza</option>";
    }
    if ($mine -> fields['wegiel'] > 0) {
        $arroption[] = "<option value='wegiel'>wegla</option>";
    }
    $smarty -> assign ("Option", $arroption);
    
	if (isset ($_GET['step']) && $_GET['step'] == 'mine') {
		if (!isset($_POST['razy'])) {
			error("Zapomnij o tym1!");
		}
		if ($mine -> fields['oper'] < $_POST['razy']) {
			error ("Nie masz tyle punktow operacji!");
		}
		if (!ereg("^[1-9][0-9]*$", $_POST['razy'])) {
			error ("Zapomnij o tym2");
		}
		$pr = ceil($player -> str / 10);
		if ($player -> clas == 'Rzemieslnik') {
			$premia1 = ceil($player -> level / 10);
			$premia = ($premia1 + $pr);
		} else {
			$premia = $pr;
		}
		$mrazem = 0;
		$mgain = 0;
		if (!isset($_POST['zloze'])) {
			error("Zapomnij o tym!3");
		}
		//if ( !in_array( $_POST['zloze'], array( 'miedz', 'zelazo', 'wegiel' ) ) {
		//	error ("Zapomnij o tym4");
		//}
		
		switch( $_POST['zloze'] ) {
			case 'miedz' :
				$nazwa = "miedzi";
				$randMax = 7;
				$min = 'copper';
				break;
			case 'zelazo' :
				$nazwa = "¿elaza";
				$randMax = 5;
				$min = 'iron';
				break;
			case 'wegiel' :
				$nazwa = "wêgla";
				$randMax = 3;
				$min = 'coal';
				break;
			default:
				error( "Nieprawid³owe z³o¿e !" );
				break;
		}
		for ( $i = 0; $i <= $_POST['razy']; $i++ ) {
			$mgain = (($mine -> fields[$_POST['zloze']] * rand (0,$randMax) + $premia));
			$mrazem = ($mrazem + $mgain);
			//$nazwa = 'miedzi';
		}
		
		SqlExec("UPDATE mines SET oper=oper-".$_POST['razy']." WHERE pid=".$player -> id." AND mid=".$mid);
		$player -> $min += $mrazem;
		//$test = $db->Execute("SELECT id FROM kopalnie WHERE gracz={$player->id}");
		//if($test->fields['id'])
		//	$db -> Execute("UPDATE kopalnie SET ".$_POST['zloze']."=".$_POST['zloze']."+".$mrazem." WHERE gracz=".$player -> id)or die("UPDATE mines SET ".$_POST['zloze']."=".$_POST['zloze']."+".$mrazem." WHERE pid=".$player -> id);
		//else
		//	$db->Execute("INSERT INTO kopalnie (`gracz`,`{$_POST['zloze']}`) VALUES ({$player->id},$mrazem)")or error("INSERT INTO kopalnie (`gracz`,`{$_POST['zloze']}`) VALUES ({$player->id},$mrazem)");
		$smarty -> assign ( array("Gain" => $mrazem, "Name" => $nazwa));
    }
}
$smarty -> assign(array("Mid"=>$mine->fields['id'],"MineData" => $mineData ) );
$smarty -> assign(array("View"=>$_GET['view'],"Step"=>$_GET['step']));
$smarty->display("mines_new.tpl");

require_once("includes/foot.php");
?>
