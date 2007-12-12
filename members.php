<?
//@type: F
//@desc: Statystyki Karatur
$title = 'Oltarz';
require_once('includes/head.php');

checklocation($_SERVER['SCRIPT_NAME']);

function select($type, $atribbute)
{
    global $db;
    $query = SqlExec("SELECT id FROM players WHERE ".$type." = '".$atribbute."';");
    $show = $query -> RecordCount();
    return $show;
}

if(empty($_GET['action']))
{
	$_GET['action'] = '';
	$text = '';
}

if($_GET['action'] == 'races')
{
    $krasnoludki = select('rasa', 'Krasnolud');
    $sexowne_elfki = select('rasa', 'Elf');
    $kurduple = select('rasa', 'Czlowiek');
    $hobysci = select('rasa', 'Hobbit');
   $drow = select('rasa', 'Drow');
	$nieumarly = select('rasa', 'Nieumarly');
	$smokokrwisty = select('rasa', 'Smokokrwisty');
	$wampir = select('rasa', 'Wampir');
	$wilkolak = select('rasa', 'Wilkolak');
	$kurtr = select('rasa', 'Kurtr');
	$polelf = select('rasa', 'Polelf');
	$polork = select('rasa', 'Polork');
	$nimfa = select('rasa', 'Nimfa');
	 $jaszczurki = select('rasa', 'Jaszczuroczlek');
    
    $text = 'W krolestwie mamy:<br /><i>Krasnoludow: '.$krasnoludki.'<br />
    Elfow: '.$sexowne_elfki.'<br />
    Ludzi: '.$kurduple.'<br />
    Hobbitow: '.$hobysci.'<br />
	Drow: '.$drow.'<br />
	Nieumarlych: '.$nieumarly.'<br />
	Smokokrwistych: '.$smokokrwisty.'<br />
	Wampirow: '.$wampir.'<br />
	Wilkolakow: '.$wilkolak.'<br />
	Kurtrow: '.$kurtr.'<br />
	Polelfow: '.$polelf.'<br />
	Polorkow: '.$polork.'<br />
	Nimf: '.$nimfa.'<br />
    Jaszczuroczlekow: '.$jaszczurki.'</i';
}

if($_GET['action'] == 'classes')
{
    $krasnoludki = select('klasa', 'Wojownik');
    $sexowne_elfki = select('klasa', 'Mag');
    $kurduple = select('klasa', 'Rzemieslnik');
    $hobysci = select('klasa', 'Zlodziej');
    $jaszczurki = select('klasa', 'Barbarzynca');
	$modli = select('klasa', 'Kaplan');
	$bum = select('klasa', 'Druid');
	$zlap = select('klasa', 'Lowca');

    $text = 'W krolestwie mamy:<br /><i>Wojownikow: '.$krasnoludki.'<br />
    Magow: '.$sexowne_elfki.'<br />
    Rzemieslnikow: '.$kurduple.'<br />
    Zlodzieji: '.$hobysci.'<br />
	Barbarzyncow: '.$jaszczurki.'<br />
	Kaplanow: '.$modli.'<br />
	Druidow: '.$bum.'<br />
    Lowcow: '.$zlap.'</i>';
}

if($_GET['action'] == 'deities')
{
    $banowcy = select('deity', 'Bane');
    $talowcy = select('deity', 'Talos');
    $solowcy = select('deity', 'Selune');
    $tyrowcy = select('deity', 'Tyr');
    $lole = select('deity', 'Lolth');
	$latki = select('deity', 'Lathander');
	$maski = select('deity', 'Maska');
	$sharki = select('deity', 'Shar');

    $text = 'W krolestwie mamy:<br /><i>Wyznawcow Bane`a: '.$banowcy.'<br />
    Talosa: '.$talowcy.'<br />
    Selune: '.$solowcy.'<br />
    Tyra: '.$tyrowcy.'<br />
	Lolth: '.$lole.'<br />
	Lathandera: '.$latki.'<br />
	Maski: '.$maski.'<br />
    Shar: '.$sharki.'</i>';
}

if($_GET['action'] == 'gender')
{
    $krasnoludki = select('gender', 'M');
    $sexowne_elfki = select('gender', 'F');

    $text = 'W krolestwie mamy:<br /><i>Mezczyzn: '.$krasnoludki.'<br />
    Kobiet: '.$sexowne_elfki.'<br />';
}



$smarty -> assign(array('Action' => $_GET['action'],
        'Show' => $text));
$smarty -> display('members.tpl');

require_once('includes/foot.php');
?>
