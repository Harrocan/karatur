<?php

require_once( "includes/preinit.php" );
require_once( "includes/bbcode.php" );
if( !isset( $_GET['action'] ) ) {
	$_GET['action'] = '';
}

$title = "Pokój Mistrza Gry";

if( $_GET['action'] == 'view' && isset( $_GET['s'] ) ) {
	//echo "fpp";
	$js_onLoad = "chatInit('{$_GET['s']}');";
}
makeHeader();

switch ( $_GET['action'] ) {
	case '':
		$sessions = SqlExec( "SELECT s.*, p.user AS gm_name, IF( su.player_id, 1, 0 ) AS in_game, IF( sq.player_id, 1, 0 ) AS form FROM mg_sessions s LEFT JOIN players p ON p.id=s.mg_id LEFT JOIN mg_sessions_users su ON su.sess_id=s.id AND su.player_id={$player->id} LEFT JOIN mg_users_queue sq ON sq.sess_id=s.id AND sq.player_id={$player->id} ORDER BY s.type ASC" );
		$sessions = $sessions->GetArray();
		//qDebug( $sessions );
		foreach( $sessions as $k => $s ) {
			//$test = SqlExec( "SELECT player_id FROM mg_sessions_users WHERE sess_id={$s['id']} AND player_id={$player->id}" );
			if( $s['mg_id'] == $player->id || $s['in_game'] ) {
				$s['access'] = true;
			}
			else {
				$s['access'] = false;
			}
			$s['desc'] = bb2html( $s['desc'] );
			$s['short'] = strip_tags( substr( $s['desc'], 0, 150 ), "<br><br/>" ) . " [...]";
			$s['rest'] = substr( $s['desc'], 150, strlen( $s['desc'] ) );
			$sessions[$k] = $s;
		}
		//qDebug( $sessions );
		$smarty->assign( "Sessions", $sessions );
		break;
	case 'create':
		if( !getRank( 'gamemaster' ) ) {
			error( "Nie jestes mistrzem gry !" );
		}
		if( !empty( $_POST) ) {
			qDebug( $_POST );
			$toAdd = $_POST['create'];
			$toAdd['mg_id'] = $player->id;
			$toAdd['date'] = dbDate( time() );
			
			$test = SqlExec( "SELECT id FROM mg_sessions WHERE mg_id={$toAdd['mg_id']} AND `name`='{$toAdd['name']}'" );
			if( $test ->fields['id'] ) {
				error( "Taka sesja juï¿½ istnieje !" );
			}
			
			$sql = SqlCreate( "INSERT", "mg_sessions", $toAdd );
			//qDebug( $sql );
			SqlExec( $sql );
			error( "Nowa sesja <b>{$toAdd['name']}</b> zostaï¿½a zaï¿½oï¿½ona !", 'done' );
		}
		break;
	case 'join':
		$sid =& $_GET['s'];
		if( !isset( $sid ) ) {
			error( "Nieprawidï¿½owe ï¿½ï¿½danie !" );
		}
		$test = SqlExec( "SELECT name,status FROM mg_sessions WHERE id={$sid}" );
		if( empty( $test->fields['status'] ) ) {
			error( "Nie ma takiej sesji !" );
		}
		if( $test->fields['status'] == 'closed' ) {
			error( "Ta sesja jest zamkniï¿½ta i nie moï¿½na do niej doï¿½ï¿½czaï¿½ !" );
		}
		$smarty->assign( "Sess_name", $test->fields['name'] );
		$smarty->assign( "Sess_id", $sid );
		$pid = $player->id;
		$test = SqlExec( "SELECT `date` FROM mg_sessions_users WHERE sess_id=$sid AND player_id=$pid" );
		if( !empty( $test ->fields['date'] ) ) {
			error( "Juz uczestniczysz w tej sesji !" );
		}
		if( !empty( $_POST ) ) {
			$reason =& $_POST['reason'];
			if( empty( $reason ) ) {
				error( "Uzupeï¿½nij wszystkie pola !", 'error', "?action=join&s={$sid}" );
			}
			//qDebug( $_POST );
			$toAdd['sess_id'] = $sid;
			$toAdd['player_id'] = $pid;
			$toAdd['reason'] = $reason;
			$toAdd['date'] = dbDate();
			$sql = SqlCreate( "INSERT", "mg_users_queue", $toAdd );
			//qDebug( $sql );
			SqlExec( $sql );
			error( "Zï¿½oï¿½yï¿½eï¿½ podanie. Gdy zostanie ono rozpatrzone, zostaniesz poinformowany listownie", 'done' );
		}
		break;
	case 'view':
		$sid =& $_GET['s'];
		if( !isset( $sid ) ) {
			error( "Nieprawidï¿½owe ï¿½ï¿½danie !" );
		}
		$sessData = SqlExec( "SELECT * FROM mg_sessions WHERE id={$sid}" );
		if( empty( $sessData->fields['id'] ) ) {
			error( "Nie ma takiej sesji !" );
		}
		$sessData = array_shift( $sessData->GetArray() );
		//qDebug( $sessData );
		//if( $sessData['mg_id'] == $player->id ) {
		//	$sessData['']
		//}
		$sessData['is_mg'] = ( $sessData['mg_id'] == $player->id )? true : false;
		$test = SqlExec( "SELECT sess_id FROM mg_sessions_users WHERE sess_id={$sessData['id']} AND player_id={$player->id}");
		$sessData['is_user'] = ( $test->fields['sess_id'] == $sessData['id'] )? true:false;
		$sessData['is_spect'] = ( !$sessData['is_mg'] && !$sessData['is_user'] )? 1:0;
		
		require_once( "includes/bbcode.php" );
		$plot = SqlExec( "SELECT p.*, pl.user, pl2.user AS change_user FROM mg_plot p LEFT JOIN players pl ON pl.id=p.player_id LEFT JOIN players pl2 ON pl2.id=p.change_pid WHERE p.sess_id={$sessData['id']} ORDER BY p.date DESC");
		$plot = $plot->getArray();
		foreach( $plot as $k => $entry ) {
			$thumb = "avatars/thumb_50_{$entry['player_id']}.jpg";
			if( !file_exists( $thumb ) ) {
				$av = imagecreatefromjpeg( "avatars/{$entry['player_id']}.jpg" );
				$mini = resizeImage( $av, 50, 50 );
				imagejpeg( $mini, $thumb );
			}
			$plot[$k]['body'] = bb2html( $entry['body'], 'mg_room' );
			$plot[$k]['is_owner'] = ( $entry['player_id'] == $player->id )? true:false;
		}
		
		//qDebug( $plot );
		if( !empty( $plot) ) {
			$sessData['tableModTime'] = strtotime( $plot[0]['date'] );
		}
		else {
			$sessData['tableModTime'] = 0;
		}
		
		if( $sessData['is_spect'] && $sessData['spectate'] == 'closed' ) {
			error( "Ta sesja jest zamkniï¿½ta i nie moï¿½na podglï¿½daï¿½ jej przebiegu !" );
		}
		
		$smarty->assign( "SessData", $sessData );
		$smarty->assign( "Plot", $plot );
		
		if( $sessData['is_mg'] ) {
			$forms = SqlExec( "SELECT q.reason, q.date, q.id AS qid, p.id AS pid, p.user FROM mg_users_queue q LEFT JOIN players p ON p.id=q.player_id WHERE q.sess_id={$sessData['id']}" );
			$forms = $forms->getArray();
			foreach( $forms as $form ) {
				$thumb = "avatars/thumb_50_{$form['pid']}.jpg";
				if( !file_exists( $thumb ) ) {
					if( is_file( "avatars/{$form['pid']}.jpg" ) ) {
						$av = imagecreatefromjpeg( "avatars/{$form['pid']}.jpg" );
						$mini = resizeImage( $av, 50, 50 );
						imagejpeg( $mini, $thumb );
					}
				}
			}
			$smarty->assign( "Options_forms", $forms );
			$smarty->assign( "Options_forms_amount", count( $forms ) );
			
			$pls = SqlExec( "SELECT p.user, p.id, mu.date FROM mg_sessions_users mu LEFT JOIN players p ON p.id=mu.player_id WHERE mu.sess_id={$sessData['id']}" );
			$pls = $pls->GetArray();
			$smarty->assign( "Options_players", $pls );
			$smarty->assign( "Options_players_amount", count( $pls ) );
		}
		
		if( !empty( $_GET['edit'] ) ) {
			if( $sessData['is_spect'] ) {
				error( "Nie moï¿½esz edytowaï¿½ wpisï¿½w bï¿½dï¿½c obserwatorem", 'error', "?action=view&s={$sessData['id']}" );
			}
			$toEdit = SqlExec( "SELECT id,player_id, body,date FROM mg_plot WHERE sess_id={$sessData['id']} AND id={$_GET['edit']}" );
			$toEdit = array_shift( $toEdit->GetArray() );
			$smarty->assign( "EditEntry", $toEdit );
			if( !empty( $_POST['editMsg'] ) ) {
				//qDebug( $_POST );
				$body =& $_POST['editMsg']['body'];
				$body = htmlspecialchars( $body );
				if( strcmp( $toEdit['body'], $body ) != 0 ) {
					SqlExec( "UPDATE mg_plot SET body='{$body}', change_date='".dbDate()."', change_total=change_total+1, change_pid={$player->id} WHERE id={$toEdit['id']}" );
					error( "Wpis edytowany !", 'done', "?action=view&s={$sessData['id']}" );
				}
				else {
						error( "Nic nie zmieniï¿½eï¿½ we wpisie - nie zapisujï¿½ ï¿½adnych zmian !", 'done', "?action=view&s={$sessData['id']}" );
				}
			}
		}
		
		
		
		/**
		 * Dodawanie wiadomoï¿½ci
		 */
		if( !empty( $_POST['addMsg'] ) ) {
			if( $sessData['is_spect'] ) {
				error( "Nie moï¿½esz dodawaï¿½ wpisï¿½w bï¿½dï¿½c obserwatorem", 'error', "?action=view&s={$sessData['id']}" );
			}
			//qDebug( $_POST['addMsg'] );
			$body =& $_POST['addMsg']['body'];
			if( empty( $body ) ) {
				error( "Nieprawidï¿½owe ï¿½ï¿½danie !", 'error', "?action=view&s={$sessData['id']}");
			}
			$toAdd['sess_id'] = $sessData['id'];
			$toAdd['player_id'] = $player->id;
			$toAdd['body'] = htmlspecialchars( $body );
			$toAdd['date'] = dbDate();
			$sql = SqlCreate( "INSERT", "mg_plot", $toAdd );
			//qDebug( $sql );
			SqlExec( $sql );
			error( "Dodaï¿½eï¿½ wpis do sesji !", 'done', "?action=view&s={$sessData['id']}" );
		}
		
		if( !empty( $_POST['general'] ) ) {
			$toMod = $_POST['general'];
			$sql = SqlCreate( "UPDATE", "mg_sessions", $toMod, array( 'id'=>$sessData['id'] ) );
			//qDebug( $sql );
			SqlExec( $sql );
			error( "Opcje zmienione !", 'done', "?action=view&s={$sessData['id']}" );
		}
		
		if( !empty( $_POST['forms'] ) ) {
			$forms =& $_POST['forms'];
			//qDebug( $forms );
			$toDel = array();
			if( is_array( $forms['allow'] ) ) {
				foreach( $forms['allow'] as $form ) {
					$toAdd['sess_id'] = $sessData['id'];
					$toAdd['player_id'] = $form;
					$toAdd['date'] = dbDate();
					$sql = SqlCreate( "INSERT", "mg_sessions_users", $toAdd );
					//qDebug( $sql );
					$msg['title'] = "Wiadomoï¿½ï¿½ z Pokoju Mistrza Gry";
					$msg['body'] = <<<MSG
Twoje podanie do sesji <b>{$sessData['name']}</b> zostaï¿½o rozpatrzone <b><span style="color:green">pozytywnie</span></b>.[br]Zapraszamy do gry.
MSG;
					sendMsg( $player->id, $form, $msg['title'], $msg['body'], 'syst' );
					SqlExec( $sql );
					$toDel[] = $form;
				}
			}
			if( is_array( $forms['deny'] ) ) {
				foreach( $forms['deny'] as $form ) {
					$msg['title'] = "Wiadomoï¿½ï¿½ z Pokoju Mistrza Gry";
					$msg['body'] = <<<MSG
Twoje podanie do sesji <b>{$sessData['name']}</b> zostaï¿½o rozpatrzone <b><span style="color:red">negatwnie</span></b>.[br]Najwidoczniej nie speï¿½niï¿½eï¿½ wymagaï¿½.
MSG;
					sendMsg( $player->id, $form, $msg['title'], $msg['body'], 'syst' );
					$toDel[] = $form;
				}
			}
			$deleted = 0;
			if( !empty( $toDel ) ) {
				$ids = implode( ", ", $toDel );
				$sql =  "DELETE FROM mg_users_queue WHERE sess_id={$sessData['id']} AND player_id IN ( $ids )";
				//qDebug( $sql );
				$deleted = SqlExec( $sql );
			}
			error( "Rozpatrzono $deleted zgï¿½oszeï¿½ !", 'done', "?action=view&s={$sessData['id']}" );
		}
		
		break;
	default:
		error( "Nieprawidï¿½owe ï¿½ï¿½danie !" );
		break;
}
//if( empty( $_GET['action'] ) ) {
//	
//}


$smarty->assign( array( "Action" => $_GET['action'], "Rank_gm" => getRank( "gamemaster" ) ) );
$smarty->display( "mgRoom.tpl" );

require_once( "includes/foot.php" );

?>