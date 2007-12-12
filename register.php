<?php
/**
 *   Funkcje pliku:
 *   Rejestracja nowych graczy
 *
 *   @name                 : register.php                            
 *   @copyright            : (C) 2005 Vallheru Team based on Gamers-Fusion ver 2.5
 *   @author               : thindil <thindil@users.sourceforge.net>
 *   @version              : 0.7 beta
 *   @since                : 06.01.2005
 *
 */

//
//
//       This program is free software; you can redistribute it and/or modify
//   it under the terms of the GNU General Public License as published by
//   the Free Software Foundation; either version 2 of the License, or
//   (at your option) any later version.
//
//   This program is distributed in the hope that it will be useful,
//   but WITHOUT ANY WARRANTY; without even the implied warranty of
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//   GNU General Public License for more details.
//
//   You should have received a copy of the GNU General Public License
//   along with this program; if not, write to the Free Software
//   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//
//

require 'libs/Smarty.class.php';
require_once ('includes/config.php');

$smarty = new Smarty;
$smarty->compile_check = true;

$query = $db -> Execute("SELECT id FROM players");
		$nump = $query -> RecordCount();
		$query -> Close();
	//pora
		$godzina = date("H:i:s");
		if($godzina <= 4) $pora = 'Noc';
		elseif($godzina <= 8) $pora = 'Poranek';
		elseif($godzina <= 11) $pora = 'Przedpoludnie';
		elseif($godzina == 12) $pora = 'Poludnie';
		elseif($godzina <= 18) $pora = 'Popoludnie';
		elseif($godzina == 19) $pora = 'Wieczor';
		elseif($godzina <= 21) $pora = 'Pozny wieczor';
		else $pora = 'Noc';
		$smarty -> assign (array ("Godzina", $godzina, "Pora" => $pora));
	
		//ostatni
		$ostatni = $db -> EXECUTE("SELECT user FROM players ORDER BY id DESC LIMIT 1");
		$smarty -> assign("Ostatni", $ostatni -> fields['user']);
		$ostatni -> Close();
		$pl = $db -> Execute("SELECT lpv FROM players");
		$ctime = time();
		$numo = 0;
		while (!$pl -> EOF) {
			$span = ($ctime - $pl -> fields['lpv']);
			if ($span <= 180) {
				$numo = ($numo + 1);
			}
			$pl -> MoveNext();
		}
		$pl -> Close();
		
		
		$smarty->assign("Newsy",$newsy);
	
		$adminmail1 = str_replace("@","[at]",$adminmail);
		
		$psel = $db->Execute("SELECT * FROM players WHERE lpv > ".(time()-180));
		$ctime = time();
		$online_name = array();
		$online_count = array();
		$index=0;
		while (!$psel->EOF) {
			//$span = ($ctime - $psel->fields['lpv']);
			//if ($span <= 120) {
				//$sql_arr[0][index]=$pl[user];
				//$sql_arr[1][index]=$pl[id];
				$online_name[$index]=$psel->fields['user'];
				$online_count[$index]=$psel->fields['id'];
				$index++;
			//}
			$psel->MoveNext();
		}
	
		$smarty->assign("on_name",$online_name);
		$smarty->assign("on_id",$online_count);
		
		$smarty->assign( array ("Time" => $newtime, "Players" => $nump, "Online" => $numo, "Update" => $arrnews, "Adminname" => $adminname, "Adminmail" => $adminmail, "Adminmail1" => $adminmail1));

$smarty -> assign("Gamename", $gamename);
$smarty -> display('head.tpl');
$query = $db -> Execute("SELECT id FROM players");
$nump = $query -> RecordCount();
$query -> Close(); 

if (isset($_GET['ref'])) {
    $smarty -> assign("Referal",$_GET['ref']);
} else {
    $smarty -> assign("Referal","");
}

if (isset ($_GET['action']) && $_GET['action'] == 'register') {
// Sprawdzenie czy wszystkie pola zostaly wypelnione
    if (!$_POST['user'] || !$_POST['email'] || !$_POST['vemail'] || !$_POST['pass'] ) {
        $smarty -> assign ("Error", "Musisz wypelnic wszystkie pola.");
        $smarty -> display('foot.tpl');
        $smarty -> display ('error.tpl');
        exit;
    }

//Sprawdzenie poprawnoœci wpisanego maila        
    require_once('includes/verifymail.php');
    if (MailVal($_POST['email'], 2)) {
        $smarty -> assign ("Error", "Nieprawidlowy adres email.");
        $smarty -> display ('error.tpl');
        $smarty -> display('foot.tpl');
        exit;
    }
    require_once('includes/verifypass.php');
    verifypass($_POST['pass'],'register');   
//Sprawdzenie czy dany pseudonim jest wolny    
    $query = $db -> Execute("SELECT id FROM players WHERE user='".$_POST['user']."'")or die("SELECT id FROM players WHERE user='".$_POST['user']."'");
    $dupe1 = $query -> RecordCount();
    $query -> Close();  
    if ($dupe1 > 0) {
        $smarty -> assign ("Error", "Ktos juz wybral taki pseudonim.");
        $smarty -> display ('error.tpl');
        $smarty -> display('foot.tpl');
        exit;
    }
    
//Sprawdzenie czy nikt nie posiada danego maila    
    $query = $db -> Execute("SELECT id FROM players WHERE email='".$_POST['email']."'");
    $dupe2 = $query -> RecordCount();
    $query -> Close();
    if ($dupe2 > 0) {
        $smarty -> assign ("Error", "Ktos juz posiada taki adres mailowy.");
        $smarty -> display ('error.tpl');
        $smarty -> display('foot.tpl');
        exit;
    }

//Sprawdzenie czy podany mail zgadza sie z podanym po raz drugi adresem    
    if ($_POST['email'] != $_POST['vemail']) {
        $smarty -> assign ("Error", "Zly adres email.");
        $smarty -> display ('error.tpl');
        $smarty -> display('foot.tpl');
        exit;
    }
    
    if (!$_POST['ref']) {
	    $_POST['ref'] = 0;
    }
    
    $ref = intval($_POST['ref']);
    $user = strip_tags($user);
    $email = strip_tags($email);
    $pass = strip_tags($pass);
    $aktw = rand(1,10000000);
    $data = date("y-m-d");
    $ip = $HTTP_SERVER_VARS['REMOTE_ADDR'];
	$message = "Witaj w ".$gamename.". <br>\nDostales ten list poniwaz Ty lub ktos, podajacy Twoj adres e-mail chcial sie zarejestrowac w grze $gamename. Twoj link aktywacyjny to:  ".$gameadress."/aktywacja.php?kod=".$aktw." <br>\nZyczymy milej zabawy. <br>\nKara-Tur Team";
    $adress = $_POST['email'];
    $subject = "Rejestracja na ".$gamename;
    require_once('mailer/mailerconfig.php');
    if (!$mail -> Send()) {
    	$smarty -> assign ("Error", "Wiadomosc nie zostala wyslana. Blad:<br> ".$mail -> ErrorInfo);
        $smarty -> display ('error.tpl');
        $smarty -> display('foot.tpl');
        //error("Wiadomosc nie zostala wyslana. Blad:<br> ".$mail -> ErrorInfo);
    }
    $db -> Execute("INSERT INTO aktywacja (user, email, pass, refs, aktyw, data, ip) VALUES('".$_POST['user']."','".$_POST['email']."',MD5('".$_POST['pass']."'),".$ref.",".$aktw.",'".$data."','".$ip."')") or die("Nie moge zarejestrowac.");
}
//inicjalizacja zmiennej
if (!isset($_GET['action'])) {
    $_GET['action'] = '';
}

// przypisanie zmiennych oraz wyswietlenie strony
$smarty -> assign( array("Action" => $_GET['action'], "Players" => $nump, "Meta" => ''));

$smarty -> display('register.tpl');
$smarty -> display('foot.tpl');
$db -> Close();
?>
