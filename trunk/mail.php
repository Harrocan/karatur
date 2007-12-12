<?php
//@type: F
//@desc: Poczta


$title = "Poczta";
require_once("includes/head.php");
require_once("includes/bbcode.php");

if( !isset( $_GET['view'] ) ) {
	$_GET['view'] = '';
}

if( $_GET['view'] == 'inbox' ) {
	if(empty($_GET['page']))
		$offset=0;
	else
		$offset=10*( $_GET['page'] - 1 );
	$mail=SqlExec("SELECT m.*, p.user FROM mail m LEFT JOIN players p ON p.id = m.sender WHERE m.owner={$player->id} AND m.type IN( 'msg', 'syst', 'ann' ) ORDER BY m.id DESC LIMIT $offset,10");
	$test=SqlExec("SELECT id FROM mail WHERE owner={$player->id} AND `type` IN( 'msg', 'syst', 'ann' ) ORDER BY id DESC");
	$mamount=$test->RecordCount();
	$i=1;
	while($mamount>0) {
		$pages[]=$i;
		$mamount-=10;
		$i++;
	}
	
	$mail=$mail->GetArray();
	foreach( $mail as $k=>$msg ) {
		$mail[$k]['body'] = bb2html( $msg['body'] );
	}
	$smarty->assign(array("Mail"=>$mail,"Pages"=>((!empty($pages))?$pages:array())));
	//qDebug( print_r($mail, true) );
	if (isset ($_GET['step']) && $_GET['step'] == 'next') {
		if(!empty($_POST['delete'])) {
            if( empty( $_POST['delmsg'] ) ) {
              error( "Wybierz listy do usuniecia" );
            }
			$lista=implode(",",$_POST['delmsg']);
			$db -> Execute("DELETE FROM mail WHERE id IN ($lista)");
			error("Zaznaczone listy usuniête",'done');
		}
		//$db -> Execute("DELETE FROM mail WHERE owner=".$player -> id." AND zapis='N' AND send=0");
	//error ("<br>Listy usuniete. (<a href=mail.php?view=inbox>odswiez</a>)");
	}
	if( isset( $_GET['step'] ) && $_GET['step']=='clear') {
		$db->Execute("DELETE FROM mail WHERE owner={$player->id} AND `type`!='send'");
		error("Skrzynka wyczyszczona !",'done');
	}
}

if (isset ($_GET['view']) && $_GET['view'] == 'send') {
	if(empty($_GET['page']))
		$offset=0;
	else
		$offset=10*( $_GET['page'] - 1 );
	$mail=SqlExec("SELECT m.*, p.user FROM mail m LEFT JOIN players p ON p.id = m.owner WHERE m.sender={$player->id} AND m.type IN( 'send' ) ORDER BY m.id DESC LIMIT $offset,10");
	$test=SqlExec("SELECT id FROM mail WHERE owner={$player->id} AND `type` IN( 'send' ) ORDER BY id DESC");
	$mamount=$test->RecordCount();
	$i=1;
	while($mamount>0) {
		$pages[]=$i;
		$mamount-=10;
		$i++;
	}
	//print_r($pages);
	$mail=$mail->GetArray();
	foreach( $mail as $k=>$msg ) {
		$mail[$k]['body'] = bb2html( $msg['body'] );
	}
	$smarty->assign(array("Mail"=>$mail,"Pages"=>((!empty($pages))?$pages:array())));
	if (isset ($_GET['step']) && $_GET['step'] == 'next') {
		if(!empty($_POST['delete'])) {
			if( empty( $_POST['delmsg'] ) ) {
				error( "Wybierz listy do usuniecia" );
			}
			$lista=implode(",",$_POST['delmsg']);
			$db -> Execute("DELETE FROM mail WHERE id IN ($lista)");
			error("Zaznaczone listy usuniête",'done');
		}
		//$db -> Execute("DELETE FROM mail WHERE owner=".$player -> id." AND zapis='N' AND send=0");
	//error ("<br>Listy usuniete. (<a href=mail.php?view=inbox>odswiez</a>)");
	}
	if( isset( $_GET['step'] ) && $_GET['step']=='clear') {
		$db->Execute("DELETE FROM mail WHERE sender={$player->id} AND `type`='send'");
		error("Skrzynka nadawcza wyczyszczona !",'done');
	}
}

if (isset ($_GET['view']) && $_GET['view'] == 'write') {
	if (!isset ($_GET['to'])) {
		$_GET['to'] = '';
	}
	if (!isset ($_GET['re'])) {
		$_GET['re'] = '';
	}
	$body = '';
	if (!empty ($_GET['id'])) {
		$mail = $db -> Execute("SELECT body, owner, sender FROM mail WHERE id=".$_GET['id']);
		if ($mail -> fields['owner'] != $player -> id) {
			error ("To nie jest list do ciebie!");
		}
		require_once('includes/bbcode.php');
		$postbody = htmltobbcode($mail -> fields['body']);
		$body = "Gracz ".$mail -> fields['sender']." napisal(a):".$postbody;
		$mail -> Close();
	}
	$smarty -> assign ( array("To" => $_GET['to'], "Reply" => $_GET['re'], "Body" => $body));
	if( !empty( $_POST ) ) {
		$owner = $_POST['owner'];
		$topic = strip_tags( $_POST['topic'] );
		$body = strip_tags( $_POST['body'] );
		$test = SqlExec( "SELECT user FROM players WHERE id={$owner}" );
		if( !$test->fields['user'] ) {
			error( "Taki gracz nie istnieje !", 'error', "?step=write" );
		}
		SqlExec( "INSERT INTO mail( `owner`, `sender`, `type`, `topic`, `body` ) VALUES( '{$owner}', '{$player->id}', 'msg', '{$topic}', '{$body}' )" );
		SqlExec( "INSERT INTO mail( `owner`, `sender`, `type`, `topic`, `body` ) VALUES( '{$owner}', '{$player->id}', 'send', '{$topic}', '{$body}' )" );
		error( "Wyslales wiadomosc do {$test->fields['user']} !", 'done' );
		
	}
	/*if (isset ($_GET['step']) && $_GET['step'] == 'send') {
		if (empty ($_POST['to']) || empty ($_POST['body'])) {
			error ("Wypelnij wszystkie pola.");
		}
		if (empty ($_POST['subject'])) {
			$_POST['subject'] = "Brak";
		}
		$rec = $db -> Execute("SELECT id, user FROM players WHERE id=".$_POST['to']);
		if (!$rec -> fields['id']) {
			error ("Nie ma takiego gracza.");
		}
		if (!ereg("^[1-9][0-9]*$", $_POST['to'])) {
			error ("Zapomnij o tym");
		}
		$subject = strip_tags($_POST['subject']);
		require_once('includes/bbcode.php');
		$_POST['body'] = bbcodetohtml($_POST['body']);
		SqlExec("INSERT INTO mail (sender, senderid, owner, subject, body) VALUES('".$player -> user."','".$player -> id."',".$_POST['to'].",'".$subject."','".$_POST['body']."')") or error("INSERT INTO mail (sender, senderid, owner, subject, body) VALUES('".$player -> user."','".$player -> id."',".$_POST['to'].",'".$subject."','".$_POST['body']."')");
		SqlExec("INSERT INTO mail (sender, senderid, owner, subject, body,  send) VALUES('".$player -> user."','".$player -> id."',".$player -> id.",'".$subject."','".$_POST['body']."',".$_POST['to'].")");
		error ("Wyslales wiadomosc do ".$rec -> fields['user'].".",'done');
	}*/
}

$smarty->assign( array( "View" => $_GET['view'] ) );
$smarty -> display ('mail.tpl');

require_once("includes/foot.php"); 
?>

