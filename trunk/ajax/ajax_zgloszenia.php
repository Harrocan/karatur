<?php
require_once( 'ajax_base.php' );

function _err( $msg ) {
	echo "ERR~$msg";
	die();
}

if( empty( $_SESSION['player'] ) ) {
	err( "SESS_EXPIRE" );
}

$player =& $_SESSION['player'];

//print_r( $_POST );
//die();

switch( $_GET['action'] ) {
	case 'solve' :
		if( empty( $_GET['id'] ) ) {
			_err( "INVAILD_GET" );
		}
		$id = intval( $_GET['id'] );
		$test=SqlExec("SELECT pid,topic,`body`,solve,`type` FROM zgloszenia WHERE id=$id");
		if(empty($test->fields['pid'])) {
			_err( "REP_NOEXISTS" );
		}
		if($test->fields['solve']=='Y') {
			_err( "SOLVED" );
		}
		//$sql="INSERT INTO mail (sender, senderid, owner, subject, body) VALUES('{$player->user}','{$player->id}',{$test->fields['pid']},'Rozwiazanie zgloszenia','Twoje zgloszenie o temacie <b>{$test->fields['topic']}</b> zosta³o uznane za rozwiazane. Dziekujemy za zgloszenie problemu.')";
		SqlExec( "INSERT INTO mail( `owner`, `sender`, `type`, `topic`, `body` ) VALUES( '{$test->fields['pid']}', '{$player->id}', 'msg', 'Rozwiazanie zgloszenia', 'Twoje zg³oszenie o temacie <b>{$test->fields['topic']}</b> zosta³o uznane za rozwiazane. Dziekujemy za zgloszenie problemu.' )" );
		//SqlExec( $sql );
		SqlExec("UPDATE zgloszenia SET `solve`='Y', `solve_id`='{$player->id}' WHERE id='$id'");
		$r = $_POST['reason'];
		$r = iconv("UTF-8", "ISO-8859-2", rawurldecode( $r ) );
		SqlExec( "INSERT INTO zgl_history( zid, `type`, `date`, `body` ) VALUES( '$id', 'SLV', '".(time())."', '$r' )" );
		echo "SOLVE_OK~" . rawurlencode( iconv("ISO-8859-2", "UTF-8", $player->user ) );
		break;
	case 'msg' :
		if( empty( $_GET['id'] ) ) {
			_err( "INVAILD_GET" );
		}
		if( empty( $_POST['message'] ) ) {
			_err( "INVAILD_GET" );
		}
		$id = intval( $_GET['id'] );
		$test=SqlExec("SELECT id, pid,topic,`body`,solve,`type` FROM zgloszenia WHERE id=$id");
		if(empty($test->fields['id'])) {
			_err( "REP_NOEXISTS" );
		}
		$body = $_POST['message'];
		$text = iconv("UTF-8", "ISO-8859-2", rawurldecode( $body ) );
		$text = strip_tags( $text );
		//$sql="INSERT INTO mail (sender, senderid, owner, subject, body) VALUES('{$player->user}','{$player->id}',{$test->fields['pid']},'Wiadomosc dot. zgloszenia \'{$test->fields['topic']}','$body')";
		//SqlExec( $sql );
		SqlExec( "INSERT INTO mail( `owner`, `sender`, `type`, `topic`, `body` ) VALUES( '{$test->fields['pid']}', '{$player->id}', 'msg', 'Wiadomosc dot. zgloszenia \"{$test->fields['topic']}\"', '{$text}' )" );
		//SqlExec("UPDATE zgloszenia SET `solve`='Y', `solve_id`='{$player->id}' WHERE id='$id'");
		SqlExec( "INSERT INTO zgl_history( zid, `type`, `date`, `body` ) VALUES( '$id', 'MSG', '".(time())."', '$text' )" );
		echo "MSG_OK~". rawurlencode( iconv("ISO-8859-2", "UTF-8", $text ) );
		break;
	default :
		_err( "INVAILD_GET" );
		break;
}

?>