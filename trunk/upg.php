<?
//@type: F
//@desc: Piewca Dusz
/**
* @function: upgrade items
* @author: _th <thion@o2.pl>
* @version: 0.1 alfa
*/

$title = 'Piewca Dusz';
require_once('includes/head.php');

error( "Piewca dusz zamkniety" );

if($player -> chaos <= 0 && $player -> bles <= 0 && $player -> soul <= 0)
{
    error('Nie masz klejnotow ulepszajacych!');
}

if(!@$_GET['act'])
{
    
    $log = $db -> Execute("SELECT * FROM equipment WHERE owner=".$player -> id." ORDER BY id DESC");
    $arrtext = array();
    $arrdate = array();
    $i = 0;
    while (!$log -> EOF)
    {
        if($player -> soul > 0) $soul = '<a href="?act=s&item='.$log -> fields['id'].'">ulepszaj klejnotem Krysztal Duszy</a>';
        if($player -> bles > 0) $bless = '<a href="?act=b&item='.$log -> fields['id'].'">ulepszaj klejnotem Krysztal Blogoslawienstwa</a>';
        if($player -> chaos > 0) $chaos = '<a href="?act=c&item='.$log -> fields['id'].'">ulepszaj klejnotem Krysztal Chaosu</a>';

        $arrtext[$i] = $log -> fields['name'];
        $arrdate[$i] = '[ '.$bless.' '.$soul.' '.$chaos.' ]';
        $log -> MoveNext();
        $i++;
    }
    
    $log -> Close();
    
    $smarty -> assign(array('Date' => $arrdate,
            'Text' => $arrtext));
    
    $smarty -> display('upg.tpl');
}
    elseif($_GET['act'] == 's' || $_GET['act'] == 'c' || $_GET['act'] == 'b')
{
    if(isset($_GET['item']))
    {
        if(!eregi('[[:digit:]]', $_GET['item']))
        {
            error('Niepoprawne id przedmiotu!');
        }
        
        $item = $db -> Execute('SELECT * FROM equipment WHERE id = '.$_GET['item'].' AND owner = '.$player -> id);
        if(!$item)
        {
            error('Taki przedmiot nie istnieje!');
        }
        
        switch($_GET['act'])
        {
            case 'b':
                 $p = 1;
                 $n = 'bles';
            break;
            case 'c':
                 $p = 10;
                 $n = 'chaos';
            break;
            case 's':
                 $p = 5;
                 $n = 'soul';
            break;
        }
        
        $db -> Execute('UPDATE equipment SET power = power + '.$p.' WHERE id = '.$item -> fields['id']);
        $db -> Execute('UPDATE players SET '.$n.' = '.$n.' - 1 WHERE id = '.$player -> id);
        
        error('Sila '.$item -> fields['name'].' podniesiona o +'.$p.'!');
        
        $item -> Close;
        
    }
}
    else
{
    error('Co chciales tu robic?');
}

require_once('includes/foot.php');
?>
