<?
//@type: F
//@desc: Mistyczny zagajnik
/**
* @function: sell chaos, bless and soul jewels
* @author: _th <thion@o2.pl>
* @version: 0.1
*/

$title = 'Mistyczny Zagajnik';
require_once('includes/head.php');

checklocation($_SERVER['SCRIPT_NAME']);

error( "Zagajnik zamkniety" );

if(isset($_POST['submit']))
{
    switch($_POST['jewel'])
    {
       case 'bles':
            $c = 1000000;
            $n = 'Bless';
       break;
       case 'soul':
            $c = 2000000;
            $n = 'Soul';
       break;
       case 'chaos':
            $c = 3000000;
            $n = 'Chaos';
       break;
    }
    
    if($player -> credits < $c)
    {
        error('Nie masz pieniedzy!');
    }
        else
    {
        $db -> Execute('UPDATE players SET '.$_POST['jewel'].' =  '.$_POST['jewel'].' + 1 WHERE id = '.$player -> id);
        $db -> Execute('UPDATE players SET credits = credits - '.$c.' WHERE id='.$player -> id);
        error('Kupiles jeden Jewel of '.$n.'!');
    }
}
    else
{
    $smarty -> assign('Info', 'Witaj w sklepie z klejnotami chaosu (tzw. jewele). Klejnoty moga ulepszac ekwipunek, bez podniesienia wymagan do jego uzywania.');
}

$smarty -> display('upgrade.tpl');

require_once('includes/foot.php');
?>
