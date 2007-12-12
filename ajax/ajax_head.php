<?php

require_once( "ajax_base.php" );

if( empty( $_SESSION['player'] ) ) {
	//err( "SESS_EXPIRE" );
	echo "kupa";
	die();
}

$player =& $_SESSION['player'];

$player->lpv = time();
$Overfg = '#000000';
$Overbg = '#0C1115';


switch( $_POST['type'] ) {
	case 'playerList' :
		$sql="SELECT players.lpv, players.avatar, players.jail, players.id, players.miejsce, players.rasa, players.user, players.level, players.age, players.user, players.gender, players.page, players.miejsce, players.stan, players.avatar, players.opis, players.tribe, ranks.name AS rankname, ranks.image FROM players JOIN ranks ON players.rid=ranks.id WHERE players.lpv>".(time()-180).";";
		$pl = SqlExec($sql);
		while (!$pl -> EOF) {
			$imglink="<img src=\"images/ranks/{$pl->fields['image']}\" ALT=\"{$pl->fields['rankname']}\">";
			if( is_file( "../avatars/{$pl->fields['avatar']}" ) ) {
				$mini = "<td rowspan=9><img src=\'avatars/{$pl->fields['avatar']}\' style=\'max-width:100px;max-height:100px\'></td>";
			}
			else
				$mini = '';
			$overlib="<table width=100% border=0><tr>$mini<td> Level: {$pl -> fields['level']}<br>Wiek: {$pl -> fields['age']}<br>Rasa: {$pl -> fields['rasa']}<br>Lokalizacja: {$pl -> fields['miejsce']}<br>Widziany: {$pl -> fields['page']}<br>Stan: {$pl -> fields['stan']}<br>Ranga: {$pl->fields['rankname']}<BR>Opis : {$pl->fields['opis']}";
			if($pl->fields['jail']=='Y')
				$overlib.="<br><b>W wiezieniu</b>";
			$overlib.="</td></tr></table>";
			$overcaption="<center><B>{$pl->fields['user']}</B> ({$pl->fields['id']})</center>";

			$text ="$imglink <A onMouseOver=\"overlib('$overlib', CAPTION, '$overcaption', FGCOLOR, '$Overfg', BGCOLOR, '$Overbg', TEXTCOLOR, '#000000', CAPTIONSIZE, 2, BORDER, 1,WIDTH, 240, TEXTSIZE, 1,VAUTO,HAUTO)\" onMouseOut=\"nd();\" href=\"view.php?view={$pl->fields['id']}\">{$pl->fields['user']}</a> ";
			if($pl->fields['tribe']>0) {
				if(file_exists('../images/tribes/mini/'.$pl->fields['tribe'].'.jpg')) {
				$text.=' <a href="tribes.php?view=view&id='.$pl->fields['tribe'].'"><img src="images/tribes/mini/'.$pl->fields['tribe'].'.jpg"></a>';
				}
			}
			echo "<div>$text</div>\n";
			$pl -> MoveNext();
		}
		break;
	case 'mail' :
		$unread = SqlExec("SELECT COUNT(*) AS amount FROM mail WHERE owner={$player->id} AND zapis='N' AND unread='F' AND send=0");
		echo $unread->fields['amount'];
		break;
	case 'chat' :
		$pl = SqlExec("SELECT COUNT(*) AS amount FROM players WHERE page='Chat' AND lpv > ".( time() - 180 ) );
		echo $pl->fields['amount'];
		break;
}

?>