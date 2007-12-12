<?
//@type: F
//@desc: Wymiana vallarów
/**
* Vermilion based on Vallheru
* @function: sell items too vallars
* @copyrights: 2006 for thion
* @author: thion <thion@o2.pl>
* @version: 0.1 alfa
*/

$title = 'Wymiana vallarow';
require_once('includes/head.php');

error( "Wymianaalarow czeka na oprawienie !" );

if($player -> location != 'Athkatla')
{
    error('Nie znajdujesz sie w miescie!');
}

if(isset($_POST['submit']))
{
    switch($_POST['item'])
    {
       case 'sword':
            $c = 100;
            $n = 'Ogien';
            $query = "INSERT INTO equipment (owner, name, power, type, cost, zr, wt, minlev, maxwt, amount, magic, poison, szyb, twohand) VALUES(".$player -> id.",'Ogien', 50,'W',0,0,100,10,100,1,'Y',0,0,'Y')";
            PutSignal( $player->id, 'back' );
       break;
       case 'bow':
            $c = 100;
            $n = 'Wiatr';
            $query = "INSERT INTO equipment (owner, name, power, type, cost, zr, wt, minlev, maxwt, amount, magic, poison, szyb, twohand) VALUES(".$player -> id.",'Wiatr', 50,'B',0,0,100,10,100,1,'Y',0,50,'Y')";
            PutSignal( $player->id, 'back' );
       break;
       case 'staff':
            $c = 100;
            $n = 'Blyskawica';
            $query = "INSERT INTO equipment (owner, name, cost, minlev, type, power, status) VALUES(".$player -> id.",'Blyskawica',0,10,'S',50,'U')";
            PutSignal( $player->id, 'back' );
       break;
       case 'credits':
            $c = 1;
            $n = '100 sztuk zlota';
            $query = 'UPDATE resources SET gold = gold + 100 WHERE id = '.$player -> id;
            PutSignal( $player->id, 'res' );
       break;
       case 'energy':
            $c = 10;
            $n = '+1 maksymalnej energii';
            $query = 'UPDATE players SET max_energy = max_energy + 1 WHERE id = '.$player -> id;
            PutSignal( $player->id, 'misc' );
       break;
    }

    if($ref < $c)
    {
        error('Nie masz tyle vallarow!');
    }
    
    $db -> Execute($query);
    
    $lol = $db -> Execute('SELECT id FROM players WHERE refs = '.$player -> id);
    $i = 0;
    while(!$lol -> EOF)
    {
        $db -> Execute('UPDATE players SET refs = 0 WHERE id = '.$lol -> fields['id']);
        $i++;
    }
        
    error('Za '.$c.' vallarow otrzymales <b>'.$n.'</b>!');
}
    else
{
    $smarty -> assign('Info', 'Witaj, '.$player -> user.'!<br />Obecnie znajdujesz sie w sklepie, ktory wymienia vallary - sa one drogie memu sercu, wiec zawziecie je kolekcjonuje...');
}

$smarty -> display('vallars.tpl');

require_once('includes/foot.php');
?>
