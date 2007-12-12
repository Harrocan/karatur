<?
//@type: F
//@desc: Si³ownia
/**
* Vermilion based on Vallheru
* @functions: train players
* @copyrights: 2006 for thion
* @author: thion <thion@o2.pl>
* @version: 0.1 alfa
*/

$title = 'Silownia';
require_once('includes/head.php');

checklocation($_SERVER['SCRIPT_NAME']);

if(isset($_GET['action']) && $_GET['action'] == 'training')
{
    if($player -> energy < 1)
    {
        error('Nie masz energii!');
    }
    
    $intRand = rand(1,100);
    $intRoll = rand(37,100);
    if($intRand == $intRoll)
    {
        $intStats = rand(0,5);
        $arrStats = array('sily',
                  'zrecznosci',
                  'wytrzymalosci',
                  'inteligencji',
                  'sily woli',
                  'szybkosci');
        $arrQueries = array('str',
                    'dex',
                    'con',
                    'int',
                    'wis',
                    'spd');
        $add = rand(1,3);
        $statistic = $arrStats[$intStats];
        $query = $arrQueries[$intStats];
        
        //$db -> Execute('UPDATE `players` SET `'.$query.'` = `'.$query.'` + 0.'.$add.' WHERE `id` = '.$player -> id);
		$player -> $query = $player -> GetAtr( $query, TRUE ) + $add/100;
        //$db -> Execute('UPDATE `players` SET `energy` = `energy` - 1 WHERE `id` = '.$player -> id);
		$player -> energy -= 1;
        
        error('Trenowales dlugo, lecz czas tu spedzony nie okazal sie stracony - zyskales +0.'.$add.' '.$statistic.'!<br /><a href="silka.php?action=training">Trenuj dalej</a> lub <a href="silka.php">Wroc</a>');
    }
        else
    {
        //$db -> Execute('UPDATE `players` SET `energy` = `energy` - 1 WHERE `id` = '.$player -> id);
		$player -> energy -= 1;
        error('Trenowales dlugo, lecz mistrz i tak nie udzielil ci wskazowek...<br /><a href="silka.php?action=training">Trenuj dalej</a> lub <a href="silka.php">Wroc</a>');
    }
}
$smarty -> display('silka.tpl');

require_once('includes/foot.php');
?>
