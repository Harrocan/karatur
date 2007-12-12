<?php

$title="Administracja Rang";
require_once('includes/head.php');

if($_SESSION['rank']['ranks']!='1')
	error("Nie masz uprawnien");

if( !isset( $_GET['action'] ) )
	$_GET['action'] = '';

if(isset($_GET['action']) && $_GET['action']=='addrank') {
	if(isset($_POST['nazwa'])) {
		if(!ereg("^#[0-9a-fA-F]{6,6}$",$_POST['color']))
			error("Nieprawid³owy kolor !",'error','rank.php?action=addrank');
		if(!isset($_POST['image']))
			error("Wybierz symbol rangi",'error','rank.php?action=addrank');
		$db->Execute("INSERT INTO ranks (name, color, image) VALUES ('".$_POST['nazwa']."', '".$_POST['color']."', '".$_POST['image']."')")or die("INSERT INTO ranks (name, color, image) VALUES ('".$_POST['nazwa']."', '".$_POST['color']."', '".$_POST['image']."')");
		error("Ranga ".$_POST['name']." dodana !",'done');
	}
	$dir = opendir('images/ranks/');
	$i=0;
	while (($file = readdir($dir)) !== false) {
		if(filetype('images/ranks/' . $file)=='file') {
			$arrfile[$i]=$file;
			$i++;
		}
	}
	$smarty->assign("Images",$arrfile);
}
if(isset($_GET['action']) && $_GET['action']=='edit') {
	if(isset($_GET['step']) && $_GET['step']=='edit') {
		$ranks = array( 'update', 'news', 'edplayer', 'qmsg', 'delete', 'cash', 'ranks', 'rankprev', 'city', 'old', 'atribs', 'immu', 'clearforum', 'clearchat', 'ip', 'addeq', 'addmon', 'addkow', 'addsp', 'mail', 'block', 'jail', 'bridge', 'email', 'close', 'ban', 'priest', 'clearlog', 'clearmail', 'mapedit', 'shop', 'poll', 'akta', 'form', 'edtown', 'double', 'userdel', 'usersniff', 'tribedel', 'forum_adm', 'moduleadd', 'modulemanage', 'changelog', 'gamemaster', 'grant_citizen', 'library', 'filer' );
		$fields = array();
		$fields['name'] = $_POST['name'];
		$fields['color'] = $_POST['color'];
		$fields['image'] = $_POST['image'];
		$fields['salary'] = $_POST['salary'];
		$fields['desc'] = $_POST['desc'];
		//qDebug( $_POST );
		$r = SqlExec( "SELECT * FROM ranks WHERE id={$_POST['id']}" );
		$r = $r->GetArray();
		$r = $r[0];
		$msg = "Modyfikacja nastepujacych uprawnien w randze `{$fields['name']}` ({$_POST['id']}) :\n";
		$diff = array();
		foreach( $r as $k => $v ) {
			if( $v == "1" ) {
				if( !isset( $_POST['rank'][$k] ) ) {
					$diff[$k] = 0;
				}
			}
			else {
				if( isset( $_POST['rank'][$k] ) ) {
					$diff[$k] = 1;
				}
			}
		}
		unset( $r );
		foreach( $diff as $k => $v ) {
			$msg .= "$k SET($v)\n";
		}
		//unset( $r['id'], $r['name'], $r['color'], $r['image'], $r['salary'], $r['desc'] );
		//$diff = array_diff_assoc( $r, $_POST['rank']);
		//qDebug( $msg );
		//qDebug( $r );
		log_event( $msg );
		//die();
		foreach( $ranks as $r ) {
			if( !empty( $_POST['rank'][$r] ) ) {
				$fields[$r] = 1;
			}
			else {
				$fields[$r] = 0;
			}
		}
		$sql = SqlCreate( "UPDATE", 'ranks', $fields, array( 'id' => $_POST['id'] ) );
		//qDebug( $sql );
		SqlExec( $sql );
		error("Ranga zaktualizowana !",'done');
	}
	if(!isset($_POST['id']))
		error("Wybierz poprawn± rangê !");
	$ranga=$db->Execute("SELECT * FROM ranks WHERE id=".$_POST['id'])or die("Shit");
	$dir = opendir('images/ranks/');
	$i=0;
	$sel=-1;
	while (($file = readdir($dir)) !== false) {
		if(filetype('images/ranks/' . $file)=='file') {
			$arrfile[$i]=$file;
			if($file==$ranga->fields['image'])
				$sel=$i;
			$i++;
		}
	}
	$smarty->assign("Id",$_POST['id']);
	$smarty->assign("Images",$arrfile);
	$smarty->assign("Sel",$sel);
	$smarty->assign("Color",$ranga->fields['color']);
	$smarty->assign("Name",$ranga->fields['name']);
	$smarty->assign("Salary",$ranga->fields['salary']);
	$smarty->assign("Desc",$ranga->fields['desc']);
	/*$smarty->assign(array(	"Update"=>$ranga->fields['update'],
							"News"=>$ranga->fields['news'],
							"Qmsg"=>$ranga->fields['qmsg'],
							"Delete"=>$ranga->fields['delete'],
							"Cash"=>$ranga->fields['cash'],
							"Ranks"=>$ranga->fields['ranks'],
							"Rankprev"=>$ranga->fields['rankprev'],
							"City"=>$ranga->fields['city'],
							"Old"=>$ranga->fields['old'],
							"Atribs"=>$ranga->fields['atribs'],
							"Immu"=>$ranga->fields['immu'],
							"Clearforum"=>$ranga->fields['clearforum'],
							"Clearchat"=>$ranga->fields['clearchat'],
							"Ip"=>$ranga->fields['ip'],
							"Addeq"=>$ranga->fields['addeq'],
							"Addmon"=>$ranga->fields['addmon'],
							"Addkow"=>$ranga->fields['addkow'],
							"Addsp"=>$ranga->fields['addsp'],
							"Mail"=>$ranga->fields['mail'],
							"Block"=>$ranga->fields['block'],
							"Jail"=>$ranga->fields['jail'],
							"Bridge"=>$ranga->fields['bridge'],
							"Email"=>$ranga->fields['email'],
							"Close"=>$ranga->fields['close'],
							"Ban"=>$ranga->fields['ban'],
							"Priest"=>$ranga->fields['priest'],
							"Clearlog"=>$ranga->fields['clearlog'],
							"Clearmail"=>$ranga->fields['clearmail'],
							"Mapedit"=>$ranga->fields['mapedit'],
							"Shop"=>$ranga->fields['shop'],
							"Edplayer"=>$ranga->fields['edplayer'],
							"Akta"=>$ranga->fields['akta'],
							"Poll"=>$ranga->fields['poll']
	));*/
	$ranga=$ranga->GetArray();
	$ranga=$ranga[0];
	$smarty->assign("Rank",$ranga);
}
if( empty( $_GET['action'] ) ) {
	if(isset($_POST['pid'])) {
		$test=$db->Execute("SELECT user FROM players WHERE id=".$_POST['pid']);
		if(!$test->fields['user'])
			error("Niepoprawny gracz !");
		log_event( "Usunieto range graczowi {$test->fields['user']} (id {$_POST['pid']})" );
		$db->Execute("UPDATE players SET rid=1 WHERE id=".$_POST['pid']);
	}
	//$users = SqlExec( "SELECT p.id,p.user,r.name FROM players p JOIN ranks r ON r.id=p.rid WHERE p.rid > 1" );
	//print_r( $users -> GetArray() );
	$rangi=$db->Execute("SELECT * FROM ranks");
	$rankid=array();
	$rankname=array();
	$rankcolor=array();
	$rankimage=array();
	$i=0;
	while(!$rangi->EOF) {
		$rankid[$i]=$rangi->fields['id'];
		$rankname[$i]=$rangi->fields['name'];
		$rankcolor[$i]=$rangi->fields['color'];
		$rankimage[$i]=$rangi->fields['image'];
		$i++;
		$rangi->MoveNext();
	}
	$user=$db->Execute("SELECT id,user,rid FROM players WHERE rid>1 ORDER BY rid ASC ");
	$userid=array();
	$username=array();
	$userrank=array();
	$userrankicon=array();
	$i=0;
	$old=$user->fields['rid'];
	while(!$user->EOF) {
		$old=$user->fields['rid'];
		$userid[$i][]=$user->fields['id'];
		$username[$i][]=$user->fields['user'];
		$rno=array_search($user->fields['rid'],$rankid);
		$userrank[$i]=$rankname[$rno];
		$userrankicon[$i]=$rankimage[$rno];
		//$i++;
		$user->MoveNext();
		if(!$user->EOF)
			if($old!=$user->fields['rid'])
			$i++;
	}
	$smarty->assign(array("Rankid"=>$rankid,"Rankname"=>$rankname,"Rankcolor"=>$rankcolor,"Rankimage"=>$rankimage));
	$smarty->assign(array("Userid"=>$userid,"Username"=>$username,"Userrank"=>$userrank,"Userrankicon"=>$userrankicon));
}
if( $_GET['action']=='pl2rank') {
	$rangi=$db->Execute("SELECT id,name FROM ranks");
	$rankid=array();
	$rankname=array();
	$i=0;
	while(!$rangi->EOF) {
		$rankid[$i]=$rangi->fields['id'];
		$rankname[$i]=$rangi->fields['name'];
		$i++;
		$rangi->MoveNext();
	}
	$smarty->assign(array("Rankid"=>$rankid,"Rankname"=>$rankname));
	if(isset($_POST['ranga'])) {
		$test=$db->Execute("SELECT user, rid FROM players WHERE id=".$_POST['pid']);
		if(!$test->fields['user'])
			error("Taki gracz nie istnieje !");
		$sql="UPDATE players SET rid=".$_POST['ranga']." WHERE id=".$_POST['pid'];
		log_event( "Nadano range nr.{$_POST['ranga']} (uprzednio {$test->fields['rid']}) graczowi {$test->fields['user']} (id {$_POST['pid']})" );
		SqlExec( $sql );
		error("Ranga nadana !",'done');
	}
}

if( $_GET['action'] == 'delete' ) {
	$rid =& $_POST['id'];
	if( empty( $rid ) ) {
		error( "wybierz rangê do usuniêcia !" );
	}
	if( $rid < 3 ) {
		error( "Tej rangi nie mo¿na usun±æ !" );
	}
	$test = SqlExec( "SELECT name FROM ranks WHERE id={$rid}" );
	if( empty( $test->fields['name'] ) ) {
		error( "Nie ma takiej rangi !" );
	}
	
	SqlExec( "UPDATE players SET rid=1 WHERE rid={$rid}" );
	SqlExec( "DELETE FROM ranks WHERE id={$rid}" );
	error( "Ranga <b>{$test->fields['name']}</b> usuniêta !", 'done' );
}

$smarty->assign ("Action",$_GET['action']);
$smarty->display('rank.tpl');

require_once('includes/foot.php');
?>