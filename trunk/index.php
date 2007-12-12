<?php

require_once( 'includes/preinit.php' );

function gate_error( $msg, $ret_url = '' ) {
	global $smarty, $db;
	if( !$ret_url ) {
		$ret_url = $_SERVER['REQUEST_URI'];
	}
	$smarty -> assign( array( "Error" => $msg, "RetUrl" => $ret_url ) );
	$smarty -> display( 'error.tpl' );
	//require_once( "includes/gate_foot.php" );
	$db->Close();
	$smarty->display( "gate_foot.tpl" );
	exit;
}

if( !isset( $_GET['step'] ) ) {
	$_GET['step'] = 'index';
}

$stats = array();
$tmp = SqlExec( "SELECT COUNT(*) AS amount FROM players" );
$stats['total'] = $tmp->fields['amount'];
$tmp = SqlExec( "SELECT user, id FROM players ORDER BY id DESC LIMIT 1" );
$stats['last_user'] = $tmp->fields['user'];
$stats['last_id'] = $tmp->fields['id'];
$tmp = SqlExec( "SELECT COUNT(*) AS amount FROM players WHERE lpv > " . ( time() - 300 ) );
$stats['online'] = $tmp->fields['amount'];
unset( $tmp );
$smarty->assign( "Stats", $stats );

$tops = SqlExec( "SELECT * FROM toplista_entries" );
$tops = $tops->GetArray();
$smarty->assign( "Tops", $tops );
unset( $tops );

$pageTitle = array( 'index' => "Strona g³ówna",
					'register' => "Rejestracja",
					'rules' => "Kodeks KaraTur",
					'aboutkt' => "O KaraTur",
					'team' => "KaraTur Team",
					'lostpaswd' => "Przypomnienie has³a" );

$smarty->assign( "PageTitle", $pageTitle[$_GET['step']] );
$smarty->display( "gate_head.tpl" );

switch( $_GET['step'] ) {
	case 'register' : {

		if ( !isset( $_GET['ref'] ) ) {
			$_GET['ref'] = '';
		}
		$smarty -> assign( "Referal", $_GET['ref'] );

		if ( !empty( $_POST ) ) {
			// Sprawdzenie czy wszystkie pola zostaly wypelnione
			if (!$_POST['user'] || !$_POST['email'] || !$_POST['vemail'] || !$_POST['pass'] ) {
				gate_error( "Musisz wype³niæ wszystkie pola !", "?step=register" );
			}

			//Sprawdzenie poprawno¶ci wpisanego maila
			require_once('includes/verifymail.php');
			if (MailVal($_POST['email'], 2)) {
				gate_error( "Niepoprawny adres email !" );
			}
			require_once('includes/verifypass.php');
			if( verifypass( $_POST['pass'], $_GET['step'] ) ) {
				gate_error( get_verifypass_err() );
			}
			//Sprawdzenie czy dany pseudonim jest wolny
			$query = SqlExec("SELECT id FROM players WHERE user='".$_POST['user']."'");
			$dupe1 = $query -> RecordCount();
			$query -> Close();
			if ($dupe1 > 0) {
				gate_error( "Kto¶ ju¿ wybra³ taki pseudonim !" );
			}

			//Sprawdzenie czy nikt nie posiada danego maila
			$query = $db -> Execute("SELECT id FROM players WHERE email='".$_POST['email']."'");
			$dupe2 = $query -> RecordCount();
			$query -> Close();
			if ($dupe2 > 0) {
				gate_error( "Ten adres mailowy jest ju¿ zajêty !" );
			}
			
			$test = SqlExec( "SELECT id FROM aktywacja WHERE `email`='{$_POST['email']}'" );
			if( $test->fields['id'] ) {
				gate_error( "Pod tym adresem mailowym ju¿ siê kto¶ rejestrowa³ i oczekuje na aktywacjê !" );
			}
			$test->Close();

			//Sprawdzenie czy podany mail zgadza sie z podanym po raz drugi adresem
			if ($_POST['email'] != $_POST['vemail']) {
				gate_error( "Nieprawid³owy adres email !" );
			}

			if (!$_POST['ref']) {
				$_POST['ref'] = 0;
			}

			$ref = intval($_POST['ref']);
			$user = strip_tags($_POST['user']);
			$email = strip_tags($_POST['email']);
			$pass = strip_tags($_POST['pass']);
			$aktw = rand(1,10000000);
			$data = date("y-m-d");
			$ip = $HTTP_SERVER_VARS['REMOTE_ADDR'];
			$message = "Witaj w ".$gamename.". <br>\nDostales ten list poniwaz Ty lub ktos, podajacy Twoj adres e-mail chcial sie zarejestrowac w grze $gamename. Twoj link aktywacyjny to:  ".$gameadress."/aktywacja.php?kod=".$aktw." <br>\nZyczymy milej zabawy. <br>\nKara-Tur Team";
			$adress = $_POST['email'];
			$subject = "Rejestracja na ".$gamename;
			require_once( 'mailer/mailerconfig.php' );
			if (!$mail -> Send()) {
				gate_error( "Wiadomosc nie zostala wyslana. Blad:<br> ".$mail -> ErrorInfo );
			}
			SqlExec("INSERT INTO aktywacja (user, email, pass, refs, aktyw, data, ip) VALUES('".$_POST['user']."','".$_POST['email']."',MD5('".$_POST['pass']."'),".$ref.",".$aktw.",'".$data."','".$ip."')");
			$smarty->assign( "RegStep", "done" );
		}
		else {
			$smarty->assign( "RegStep", "" );
		}

		$smarty->display( "gate_register.tpl" );
		break;
	}
	case 'lostpaswd' : {
		if ( !empty( $_POST ) ) {
			if (!$_POST['email']) {
				gate_error( "Wpisz adres email" );
			}
			$query = SqlExec("SELECT id FROM players WHERE email='{$_POST['email']}'");
			$dupe1 = $query -> RecordCount();
			$query -> Close();

			if ($dupe1 == 0) {
				gate_error( "Nieprawid³owy adres email" );
			}
			$new_pass = substr(md5(uniqid(rand(), true)), 3, 9);
			$adress = $_POST['email'];
			$message = "Dostales ten mail, poniewaz chciales zmienic haslo w $gamename. Twoje nowe haslo do konta to \n".$new_pass."\n Zmien je jak tylko wejdziesz do gry. Zyczymy milej zabawy w $gamename. KaraTur-Team";
			$subject = "Przypomnienie hasla na $gamename";
			require_once('mailer/mailerconfig.php');
			if (!$mail -> Send()) {
				gate_error( "Wiadomosc nie zostala wyslana. Blad:<br> ".$mail -> ErrorInfo );
				//error("Wiadomosc nie zostala wyslana. Blad:<br> ".$mail -> ErrorInfo);
			}
			SqlExec("UPDATE players SET pass = MD5('".$new_pass."') WHERE email='".$_POST['email']."'");
			$smarty->assign( "PassStep", "done" );
		}
		else {
			$smarty->assign( "PassStep", "" );
		}
		$smarty->display( "gate_lost.tpl" );
		break;
	}
	case 'aboutkt' : {
		$smarty->display( "gate_aboutkt.tpl" );
		break;
	}
	case 'rules' : {
		$smarty->display( "rules.tpl" );
		break;
	}
	case 'team' : {
		$smarty->display( "gate_team.tpl" );
		break;
	}
	default: {
		$smarty->display( "gate_index.tpl" );
		break;
	}
}

$smarty->display( "gate_foot.tpl" );

$db->Close();

?>