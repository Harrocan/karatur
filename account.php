<?php

/**
 * Strona umo¿liwiaj±ca graczowi zmienianie opcji
 *
 * @author IvaN
 * @package KaraTur
 * @subpackage _Pages
 */


$title = "Opcje konta";
require_once("includes/head.php");

$smarty->force_compile = true;
if( isset( $_GET['action'] ) && $_GET['action'] == 'update' ) {
	if( $player->id != '267' ) {
		error( "Spieprzaj dziadu !" );
	}
	require_once( "class/playerManager.class.php" );
	require_once('includes/bbcode.php');
	$pl = SqlExec( "SELECT id, avatar FROM players" );
	$pl = $pl -> GetArray();
	$avDir = "avatars/";
	$mod = 0;
	foreach( $pl as $p ) {
		//continue;
		$man = new PlayerManager( $p['id'] );
		//$av = $man->getMisc( 'avatar' );
		$profile = htmltobbcode($man -> getMisc( 'profile' ) );
		$man -> setMisc( 'profile', $profile );
	}
	error( "profile aktualizowane", 'done' );
}

function openimage( $path ) {
	if( !is_file( $path ) ) {
		return FALSE;
	}
	$stats = getimagesize( $path );
	$imgtypes = array( 'gif' => 'imagecreatefromgif', 'jpg' => 'imagecreatefromjpeg', 'png' => 'imagecreatefrompng' );
	switch( $stats['mime'] ) {
		case 'image/gif' :
			$img = imagecreatefromgif( $path );
			break;
		case 'image/png' :
			$img = imagecreatefrompng( $path );
			break;
		case 'image/jpeg' :
			$img = imagecreatefromjpeg( $path );
			break;
		default :
			trigger_error( "Nieobslugiwany format pliku: {$stats['mime']} !",E_USER_WARNING );
			return FALSE;
			break;
	}
	if( $img )
		return $img;
	else
		return FALSE;
}



function createThumb( $img ) {
	$width = 100;
	$height = 100;

	//list($width_orig, $height_orig) = getimagesize($img);
	$width_orig = imagesx( $img );
	$height_orig = imagesy( $img );

	if ($width && ($width_orig < $height_orig)) {
		$width = ($height / $height_orig) * $width_orig;
	}
	else {
		$height = ($width / $width_orig) * $height_orig;
	}

	$image_p = imagecreatetruecolor($width, $height);
	$image = $img;
	imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

	//imagejpeg($image_p, null, 100);
	return $image_p;
}

// przypisanie zmiennej
$smarty -> assign("Avatar", '');

//przyznawanie immunitetu
if (isset ($_GET['view']) && $_GET['view'] == "immu") {
	if (isset ($_GET['step']) && $_GET['step'] == 'yes') {
		if ($player -> race == '')
		{
			error("Zanim we?miesz immunited wybierz ras?");
		}
		if ($player -> race == 'Wampir')
		{
			error("Wampiry nie mog? brac immunitetu");
		}
	
		if ($player -> immunited == 'Y') {
			error ("Posiadasz juz immunitet!");
		}
		if ($player -> clas == '') {
		error ("Musisz najpierw wybrac klase postaci");
		}
		//$db -> Execute("UPDATE players SET immu='Y' WHERE id=".$player -> id);
		$player -> immu = 'Y';
	}
}

// reset postaci
if (isset ($_GET['view']) && $_GET['view'] == "reset") {
	if (isset ($_GET['step']) && $_GET['step'] == 'make') {
		$code = rand(1,1000000);
	$message = "Dostales ten list poniewaz chciales zresetowac postac. Jezeli nadal pragniesz zresetowac swoja postac na ".$gamename." (".$player -> user." ID: ".$player -> id.") wejdz w ten link ".$gameadress."/preset.php?id=".$player -> id."&code=".$code." Jezeli jednak nie chcesz resetowac postaci (badz ktos inny za ciebie zglosil taka chec) wejdz w ten link ".$gameadress."/preset.php?id=".$player -> id." Pozdrawiamy, obsluga KataTur";	
	$adress = $player->email;
	$subject = "Reset konta gracza na ".$gamename;
	require_once('mailer/mailerconfig.php');
		//if (!$mail -> Send()) {
			//error("Wiadomosc nie zostala wyslana. Blad:<br> ".$mail -> ErrorInfo);
		//}
		qDebug( $message );
		SqlExec("INSERT INTO reset (player, code) VALUES(".$player -> id.",".$code.")");
	}
}

if( isset( $_GET['view'] ) && $_GET['view'] == "freeze" ) {
	$smarty->assign( "Freeze", $player->freeze );
	$fDate = strtotime( $player->freeze_date );
	if( $player->freeze == 'Y' ) {
		$timePeriod = getTimestampPeriod( 0, 0, 0, 5 );
	}
	else {
		//qDebug( $fDate );
		$timePeriod = getTimestampPeriod( 0, 0, 0, 3 );
		
	}
	//qDebug( $timePeriod );
	//qDebug( date( "Y-m-d H:i", $fDate ) );
	$diff = time() - $fDate;
	$canFreeze = ( $diff > $timePeriod )?true:false;
	$diffString = date( "Y-m-d H:i", $fDate + $timePeriod );
	$smarty->assign( "CanFreeze", $canFreeze );
	$smarty->assign( "DiffString", $diffString );
	
	if( isset( $_GET['freeze'] ) && $_GET['freeze'] == 'Y') {
		if( $player->freeze != 'N' ) {
			error( "Nieprawid³owa akcja !" );
		}
		if( !$canFreeze ) {
			error( "Nie mo¿esz obecnie zamroziæ konta" );
		}
		$player->freeze = 'Y';
		$player->freeze_date = dbDate();
		error( "Konto zosta³o zamro¿one !", 'done' );
	}
	if( isset( $_GET['unfreeze'] ) && $_GET['unfreeze'] == 'Y') {
		if( $player->freeze != 'Y' ) {
			error( "Nieprawid³owa akcja !" );
		}
		if( !$canFreeze ) {
			error( "Nie mo¿esz obecnie odmroziæ konta" );
		}
		$player->freeze = 'N';
		$player->freeze_date = dbDate();
		error( "Konto zosta³o odmro¿one !", 'done' );
	}
}

//opcje avatara
		if (isset($_GET['view']) && $_GET['view'] == "avatar") {
	$file = 'avatars/'.$player -> avatar;
	if (is_file($file)) {
		$smarty -> assign (array ("Value" => $player -> avatar, "Avatar" => $file));
	}
	if (isset($_GET['step']) && $_GET['step'] == 'usun') {
		$plik = 'avatars/'.$player->avatar;
		if (is_file($plik)) {
			unlink($plik);
			$targetDir = "avatars/";
			if( file_exists( $targetDir . "thumb_{$player->id}.jpg" ) ) {
				unlink( $targetDir . "thumb_{$player->id}.jpg" );
			}
			$player -> avatar = '';
			error ("Avatar usuniety. <a href=\"account.php?view=avatar\">Odswiez</a><br>",'done');
		} else {
			error ("Nie ma takiego pliku!");
		}
	}
	if (isset($_GET['step']) && $_GET['step'] == 'dodaj') {
		if (!($_FILES['plik']['name'])) {
			error("Nie podales nazwy pliku!");
		}
		if( empty( $_FILES['plik']['tmp_name'] ) )
			error( "Za duzy plik !");
		$oldimg = $player -> avatar;
		//$plik = $_FILES['plik']['tmp_name'];
		//$nazwa = $_FILES['plik']['name'];
		//$typ = $_FILES['plik']['type'];
		$path = $_FILES['plik']['tmp_name'];
		if( ( $img = openimage( $path ) ) === FALSE ) {
			error( "Blad podczas otwierania pliku !");
		}
		//do {
		//	$safe = FALSE;
		//	$num = md5( rand( 1, 1000000 ) ).".jpg";
		//	$newpath = "avatars/$num";
		//	if( !is_file( $newpath ) )
		//		$safe = TRUE;
		//} while ( $safe === FALSE );
		$thumb = createThumb( $img );
		$targetDir = "avatars/";
		$filename = "{$player->id}.jpg";
		//if ($typ != 'image/pjpeg' && $typ != 'image/jpeg' && $typ != 'image/gif') {
		//    error ("Zly typ pliku! $typ");
		//}
		//if ($typ == 'image/pjpeg' || $typ == 'image/jpeg') {
		//    $liczba = rand(1,1000000);
		//    $newname = md5($liczba).'.jpg';
		//    $miejsce = 'avatars/'.$newname;
		//}
		//if ($typ == 'image/gif') {
		//    $liczba = rand(1,1000000);
		//    $newname = md5($liczba).'.gif';
		//    $miejsce = 'avatars/'.$newname;
		//}
		//if (is_uploaded_file($plik)) {
		//    if (!move_uploaded_file($plik,$miejsce)) {
		//	error ("Nie skopiowano pliku!");
		//    }
		//} else {
		//    error ("Zapomij o tym");
		//}
		if( !empty( $oldimg ) && file_exists( $targetDir . $oldimg ) ) {
			//echo "Usuwam stary avatar !<br>";
			unlink( "avatars/".$oldimg );
		}
		if( file_exists( $targetDir . "thumb_{$filename}" ) ) {
			unlink( $targetDir . "thumb_{$filename}" );
		}
		if( imagejpeg( $img, $targetDir . $filename ) === FALSE ) {
			trigger_error( "Blad podczas zapisywania pliku !", E_USER_ERROR );
		}
		if( imagejpeg( $thumb, $targetDir . "thumb_{$filename}") === FALSE ) {
			trigger_error( "Blad podczas zapisywania miniatury !", E_USER_ERROR );
		}
		//$db -> Execute("UPDATE players SET avatar='".$num."' WHERE id=".$player -> id) or error("nie moge dodac!");
		$player -> avatar = $filename;
		error ("Avatar zaladowany! <a href=\"account.php?view=avatar\">Odswiez</a><br>",'done');
	}
}
// zmiana imienia postaci
if (isset($_GET['view']) && $_GET['view'] == "name") {
	if (isset($_GET['step']) && $_GET['step'] == "name") {
	if (empty ($_POST['name'])) {
		error ("Podaj imie.");
	} else {
		$_POST['name'] = str_replace("'","",strip_tags($_POST['name']));
		if ($_POST['name'] == 'Admin' || $_POST['name'] == 'Staff') {
		error ("Zapomnij o tym");
		} else {
		$query = $db -> Execute("SELECT id FROM players WHERE user='".$_POST['name']."'");
		$dupe = $query -> RecordCount();
		$query -> Close();
		if ($dupe > 0) {
			error ("To imie jest juz zajete.");
		} else {
			//$db -> Execute("UPDATE players SET user='".$_POST['name']."' WHERE id=".$player -> id);
			$player -> user = $_POST['name'];
			error ("Zmieniles imie na <b>".$_POST['name']."</b>.");
		}
		}
	}
	}
}

// zmiana opisu na licie graczy
if (isset($_GET['view']) && $_GET['view'] == "opis") {
	if (isset($_GET['step']) && $_GET['step'] == "opis") {
		if (empty ($_POST['opis'])) {
			error ("Podaj opis.");
		}
	//
	//else {
			$_POST['opis'] = str_replace("'","",strip_tags($_POST['opis']));
			if ($_POST['opis'] == 'Admin' || $_POST['opis'] == 'Staff') {
			error ("Zapomnij o tym");
			} else {
			$query = $db -> Execute("SELECT id FROM players WHERE user='".$_POST['opis']."'");
/*          $dupe = $query -> RecordCount();
		$query -> Close();
		if ($dupe > 0) {*/
		if($query->fields['id']) {
			error ("To imie jest juz zajete.");
		} else {
			//$db -> Execute("UPDATE players SET opis='".$_POST['opis']."' WHERE id=".$player -> id);
			$player -> opis = $_POST['opis'];
			error ("Zmieniles opis na <b>".$_POST['opis']."</b>.",'done');
		}
			}
	}
}


// zmiana hasla do konta
if (isset($_GET['view']) && $_GET['view'] == "pass") {
	if (isset($_GET['step']) && $_GET['step'] == "cp") {

	if (empty ($_POST['np'])) {
		error ("Wypelnij wszystkie pola.");
		}
	if (empty ($_POST['cp'])) {
		error ("Wypelnij wszystkie pola.");
	}
		require_once('includes/verifypass.php');
		verifypass($_POST['np'],'account');
	$_POST['np'] = str_replace("'","",strip_tags($_POST['np']));
	$_POST['cp'] = str_replace("'","",strip_tags($_POST['cp']));
	$db -> Execute("UPDATE players SET pass = MD5('".$_POST['np']."') WHERE pass = MD5('".$_POST['cp']."') AND id=".$player -> id);
	//$_SESSION['pass'] = $_POST['np'];
	error ("Zmieniles haslo z ".$_POST['cp']." na ".$_POST['np'],'done');
	}
}

// edycja profilu
if (isset($_GET['view']) && $_GET['view'] == "profile") {
	require_once('includes/bbcode.php');
	//$profile = htmltobbcode($player -> profile);
	$profile = htmlspecialchars( $player -> profile );
	$smarty -> assign ("Profile", stripcslashes( $profile ) );
	if (isset($_GET['step']) && $_GET['step'] == "profile") {
		if (empty ($_POST['profile'])) {
			error ("Wypelnij wszystkie pola.");
		}
		require_once('includes/bbcode_profile.php');
		//$bb = new ProfileBbcode();
			//$_POST['profile'] = bbcodetohtml($_POST['profile']);
		//$db -> Execute("UPDATE players SET profile = '".$_POST['profile']."' WHERE id = '".$player -> id."'");
		
		$player -> profile = $_POST['profile'];
		$_POST['profile'] = stripcslashes( $_POST['profile'] );
		//$_POST['profile'] = bbcode_profile( stripcslashes( $_POST['profile'] ) );
		$smarty -> assign ("Profile",$_POST['profile']);
	}
}

// edycja maila oraz numeru gg
if (isset($_GET['view']) && $_GET['view'] == 'eci') {
	//if (empty($player -> gg)) {
		//if ($player -> rank == "Tester") {
		//	error ("Posiadasz konto testowe. Opcja ta jest dla Ciebie zablokowana!");
		//}
	//$player -> gg = '';
	//}
	$smarty -> assign(array("GG"=>$player -> gg,"Email"=>$player->email));
	if (isset($_GET['step']) && $_GET['step'] == "gg") {
	if (!ereg("^[0-9]*$", $_POST['gg'])) {
		error ("Zapomnij o tym");
	}
	$query= $db -> Execute("SELECT id FROM players WHERE gg='".$_POST['gg']."'");
	$dupe = $query -> RecordCount();
	$query -> Close();
	if ($dupe > 0 && $_POST['gg'] != 0) {
		error ("Ktos juz posiada taki adres gadu-gadu.");
	}
	//$db -> Execute("UPDATE players SET gg=".$_POST['gg']." WHERE id=".$player -> id) or error ("Nie moge dodac");
	$player -> gg = $_POST['gg'];
	error ("Zmieniles numer gadu-gadu na ".$_POST['gg']."<br>",'done');
	}
	if (isset($_GET['step']) && $_GET['step'] == "ce") {
	if (empty ($_POST["ne"])) {
		error ("Wypelnij wszystkie pola.");
	}
	if (empty ($_POST["ce"])) {
		error ("Wypelnij wszystkie pola.");
	}
		require_once('includes/verifymail.php');
		if (MailVal($_POST['ne'], 2)) {
			error("Nieprawidlowy adres email.");
		}
	$query = $db -> Execute("SELECT id FROM players WHERE email='".$_POST['ne']."'");
	$dupe = $query -> RecordCount();
	$query -> Close();
	if ($dupe > 0) {
		error ("Ktos juz posiada taki adres email.");
	}
	//$db -> Execute("UPDATE players SET email = '".$_POST['ne']."' WHERE email = '".$_POST['ce']."' AND id = '".$player -> id."'") or error ("Zly mail");
	$player -> email = $_POST['ne'];
	error ("Zmieniles adres e-mail z ".$_POST['ce']." na ".$_POST['ne'].". Zamknij to okno przegladarki i zaloguj sie ponownie.",'done');
	}
}

//wybor stylu
if (isset($_GET['view']) && $_GET['view'] == 'style') {
	/**
	* Wybor stylu tekstowego
	*/
	$path = 'css/';
	$dir = opendir($path);
	$arrname = array();
	$i = 0;
	while ($file = readdir($dir))
	{
		if (ereg(".css*$", $file))
		{
			$arrname[$i] = $file;
			$i = $i + 1;
		}
	}
	closedir($dir);
	/**
	* sprawdzenie dostepnych layoutow
	*/
	$path = 'templates/';
	$dir = opendir($path);
	$arrname1 = array();
	$i = 0;
	while ($file = readdir($dir))
	{
		if (!ereg(".htm*$", $file) && !ereg(".tpl*$", $file))
		{
			if (!ereg("\.$", $file))
			{
				$arrname1[$i] = $file;
				$i = $i + 1;
			}
		}
	}
	closedir($dir);
	/**
	* Przypisanie zmiennych do templatu
	*/
	$smarty -> assign(array("Stylename" => $arrname, "Layoutname" => $arrname1));
	/**
	* Jezeli gracz zmieni tryb tekstowy
	*/
	if (isset($_GET['step']) && $_GET['step'] == 'style') {
		$_POST['newstyle'] = strip_tags($_POST['newstyle']);
		if ($player -> graphic)
		{
			//$db -> Execute("UPDATE players SET graphic='' WHERE id=".$player -> id);
			$player -> graphic = '';
		}
		//$db -> Execute("UPDATE players SET style='".$_POST['newstyle']."' where id=".$player -> id);
		$player -> style = $_POST['newstyle'];
	}
	/**
	* Jezeli gracz wybierze tryb graficzny
	*/
	if (isset($_GET['step']) && $_GET['step'] == 'graph')
	{
		$_POST['graphserver'] = strip_tags($_POST['graphserver']);
		$db -> Execute("UPDATE players SET graphic='".$_POST['graphserver']."' WHERE id=".$player -> id) or error("Blad!".$path." ".$player -> id);
	}
}

//inicjalizacja zmiennych
if (!isset($_GET['view'])) {
	$_GET['view'] = '';
}
if (!isset($_GET['step'])) {
	$_GET['step'] = '';
}

//przypisanie zmiennych i wyswietlenie strony
$smarty -> assign (array ("View" => $_GET['view'], "Step" => $_GET['step']));
$smarty -> display('account.tpl');

require_once("includes/foot.php");
$db -> Close();
?>

