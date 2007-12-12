<?
/*require_once ('includes/config.php');
require_once('includes/globalfunctions.php');
require_once('class/player.class.php');
require_once('includes/sessions.php');
require_once ('libs/Smarty.class.php');

$smarty = new Smarty;

$smarty-> compile_check = true;
*/

require_once( "includes/preinit.php" );

if (isset ($_POST['pass'])) {
	$objOpen = $db -> Execute("SELECT value FROM settings WHERE setting='open'");
	if ($objOpen -> fields['value'] == 'N' && $player -> rid != '2') {
		throwError( "RESET" );
		$objReason = $db -> Execute("SELECT value FROM settings WHERE setting='close_reason'");
		$smarty -> assign (array("Error" => "Przyczyna wylaczenia gry:<br />".$objReason -> fields['value'], "Gamename" => $gamename, "Meta" => ''));
		$objReason -> Close();
		$smarty -> display ('error.tpl');
		exit;
	}
	$objOpen -> Close();
	if (!$_POST['email'] || !$_POST['pass']) {
		throwError( "Prosze wypelnic wszystkie pola podczas logowania !" );
		$smarty -> assign (array("Error" => "Prosze wypelnic wszystkie pola.", "Gamename" => $gamename, "Meta" => ''));
		$smarty -> display ('error.tpl');
		exit;
	}
	$pass = MD5($_POST['pass']);
	$query = $db -> Execute("SELECT id, user, email, ip, rank FROM players WHERE email='".$_POST['email']."' AND pass='".$pass."'")or die("kicha ~~");
	$logres = $query -> RecordCount();
	$ban = $db -> Execute("SELECT type, amount FROM ban ORDER BY type");
	$numban = $ban -> RecordCount();
	$arrban = array(array());
	$i = 0;
	while (!$ban -> EOF) {
		$arrban[$i][0] = $ban -> fields['type'];
		$arrban[$i][1] = $ban -> fields['amount'];
		$ban -> MoveNext();
		$i = $i + 1;
	}
	$ban -> Close();
	$banned = 0;
	if (isset($arrban[0][0])) {
		foreach ($arrban as $ban) {
				if ($ban[0] == 'IP') {
			if ($ban[1] == $query -> fields['ip']) {
					$banned = 1;
			break;
			}
		}
		if ($ban[0] == 'ID') {
			if ($ban[1] == $query -> fields['id']) {
					$banned = 1;
			break;
			}
		}
		if ($ban[0] == 'nick') {
			if ($ban[1] == $query -> fields['user']) {
					$banned = 1;
			break;
			}
		}
		if ($ban[0] == 'mailadres') {
			if ($ban[1] == $query -> fields['email']) {
					$banned = 1;
			break;
			}
		}
		}
	}
	if ($banned) {
		throwError( "BANNED" );
		$smarty -> assign (array("Error" => "Poniewaz zostales zbanowany, nie masz dostepu do gry.", "Gamename" => $gamename, "Meta" => ''));
		$smarty -> display ('error.tpl');
		exit;
	}
	//$query -> Close();
	if ($logres <= 0) {
		throwError( "WRONG_LOGIN" );
		$smarty -> assign (array("Error" => "Blad przy logowaniu. Jezeli nie jestes zarejestrowany, zarejestruj sie. W przeciwnym wypadku, sprawdz pisownie i sprobuj jeszcze raz.", "Gamename" => $gamename, "Meta" => ''));
		$smarty -> display ('error.tpl');
		exit;
	} else {
		/*$pl = $db -> Execute("SELECT lpv FROM players WHERE rank!='Admin' AND rank!='Staff'");
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
		if ($numo >= 35 && $query -> fields['rank'] != 'Admin' && $query -> fields['rank'] != 'Staff') {
		$smarty -> assign(array("Error" => "Przykro mi, ale ze wzgledu na duze obciazenie serwera w grze moze przebywac maksymalnie 35 graczy. Prosze sprobuj pozniej", "Gamename" => $gamename, "Meta" => ''));
		$smarty -> display('error.tpl');
		exit;
	}*/
		//$_SESSION['email'] = $_POST['email'];
		//$_SESSION['pass'] = MD5($_POST['pass']);
		$pid=$db->Execute("SELECT id,rid FROM players WHERE email='".$_POST['email']."';");
		$_SESSION['player'] = new Player( $pid -> fields['id'] );

		//$ranga=$db->Execute("SELECT * FROM ranks WHERE id=".$pid->fields['rid'])or die("Shit");
		
		$krowka=$db->Execute("SELECT * FROM ranks WHERE id={$pid->fields['rid']}");
		$dyd=$krowka->_numOfFields;
		$kopytko=$krowka->GetArray();
		$kopytko=$kopytko[0];
		//$test=$test->GetArray();
		for($i=4;$i<$dyd;$i++) {
			$field=$krowka->FetchField($i);
			$rank[$field->name]=$kopytko[$field->name];
			//echo "rank_{$field->name} : {$ff[$field->name]}<BR>";
		}
		$_SESSION['rank']=$rank;
		
		$ip = $_SERVER['REMOTE_ADDR'];
		$test = SqlExec( "SELECT `id` FROM ip_tab WHERE `pid`={$pid -> fields['id']} AND `ip`='$ip'" );
		if( $test->fields['id'] ) {
			SqlExec( "UPDATE ip_tab SET `amount` = `amount` + 1, `lasttime`='".time()."' WHERE `id`={$test->fields['id']}" );
		}
		else {
			SqlExec( "INSERT INTO ip_tab( `pid`, `ip`, `amount`,`lasttime` ) VALUES( {$pid -> fields['id']}, '$ip',1, '".time()."' )" );
		}
		
		/*$_SESSION['rank_update']=$ranga->fields['update'];
		$_SESSION['rank_news']=$ranga->fields['news'];
		$_SESSION['rank_qmsg']=$ranga->fields['qmsg'];
		$_SESSION['rank_delete']=$ranga->fields['delete'];
		$_SESSION['rank_cash']=$ranga->fields['cash'];
		$_SESSION['rank_ranks']=$ranga->fields['ranks'];
		$_SESSION['rank_rankprev']=$ranga->fields['rankprev'];
		$_SESSION['rank_city']=$ranga->fields['city'];
		$_SESSION['rank_old']=$ranga->fields['old'];
		$_SESSION['rank_atribs']=$ranga->fields['atribs'];
		$_SESSION['rank_immu']=$ranga->fields['immu'];
		$_SESSION['rank_clearforum']=$ranga->fields['clearforum'];
		$_SESSION['rank_clearchat']=$ranga->fields['clearchat'];
		$_SESSION['rank_ip']=$ranga->fields['ip'];
		$_SESSION['rank_addeq']=$ranga->fields['addeq'];
		$_SESSION['rank_addmon']=$ranga->fields['addmon'];
		$_SESSION['rank_addkow']=$ranga->fields['addkow'];
		$_SESSION['rank_addsp']=$ranga->fields['addsp'];
		$_SESSION['rank_mail']=$ranga->fields['mail'];
		$_SESSION['rank_block']=$ranga->fields['block'];
		$_SESSION['rank_jail']=$ranga->fields['jail'];
		$_SESSION['rank_bridge']=$ranga->fields['bridge'];
		$_SESSION['rank_email']=$ranga->fields['email'];
		$_SESSION['rank_close']=$ranga->fields['close'];
		$_SESSION['rank_ban']=$ranga->fields['ban'];
		$_SESSION['rank_priest']=$ranga->fields['priest'];
		$_SESSION['rank_clearlog']=$ranga->fields['clearlog'];
		$_SESSION['rank_clearmail']=$ranga->fields['clearmail'];
		$_SESSION['rank_poll']=$ranga->fields['poll'];
		$_SESSION['rank_mapedit']=$ranga->fields['mapedit'];
		$_SESSION['rank_shop']=$ranga->fields['shop'];
		$_SESSION['rank_edplayer']=$ranga->fields['edplayer'];*/
		
		//$db -> Execute("UPDATE players SET logins=logins+1, rest='N' WHERE email='".$_POST['email']."'");
		$player->logins++;
		$player->rest = 'N';
		//$user=$db->Execute("SELECT user FROM players WHERE  email='".$_POST['email']."'");
		$smarty->assign("User",$player->user);
		$smarty->display('login.tpl');
	}
}
//$user=$db->Execute("SELECT user FROM players WHERE  email='".$_POST['email']."'");
//$smarty->assign("User",$user->fields['user']);
//$smarty->display('login.tpl');
$db->Close();
?>
