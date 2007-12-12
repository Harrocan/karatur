<?php

$sql="SELECT players.lpv, players.avatar, players.jail, players.id, players.miejsce, players.rasa, players.user, players.level, players.age, players.user, players.gender, players.page, players.miejsce, players.stan, players.avatar, players.opis, players.tribe, ranks.name AS rankname, ranks.image FROM players JOIN ranks ON players.rid=ranks.id WHERE players.lpv>".(time()-180).";";
$total = SqlExec( "SELECT COUNT(*) AS total FROM players" );
$players = SqlExec($sql);

$numo = count( $players );
//qDebug( $players );
$nump = $total[0]['total'];
$overData = array();

foreach( $players as $pl ) {
		//$imglink="<img src=\"images/ranks/{$pl['image']}\" ALT=\"{$pl['rankname']}\">";
		//if( is_file( "avatars/{$pl['avatar']}" ) ) {
		//	$mini = "<td rowspan=9><img src=\"avatars/{$pl['avatar']}\" style=\"max-width:100px;max-height:100px\"></td>";
		//}
		//else
		//	$mini = '';
		//$overlib="<table width=100% border=0><tr>$mini<td> Level: {$pl -> fields['level']}<br>Wiek: {$pl -> fields['age']}<br>Rasa: {$pl -> fields['rasa']}<br>Lokalizacja: {$pl -> fields['miejsce']}<br>Widziany: {$pl -> fields['page']}<br>Stan: {$pl -> fields['stan']}<br>Ranga: {$pl->fields['rankname']}<BR>Opis : {$pl->fields['opis']}";
    	//if($pl->fields['jail']=='Y')
		//	$overlib.="<br><b>W wiezieniu</b>";
		//$overlib.="</td></tr></table>";
		//$overcaption="<center><B>{$pl['user']}</B> ({$pl['id']})</center>";
		
		$tmp['data'] = $pl;
		//$tmp['title'] = $overcaption;
		//$tmp['img'] = $imglink;
		//$tmp['body'] = $overlib;
		//$tmp['link'] = "<a href=\"view.php?view={$pl['id']}\">{$pl['user']}</a> ";
		if($pl['tribe']>0) {
			if(file_exists('images/tribes/mini/'.$pl['tribe'].'.jpg'))
				$tmp['data']['tribeimg'] = $pl['tribe'].'.jpg';
		}
		if( !isset( $tmp['data']['tribeimg'] ) )
			$tmp['data']['tribeimg'] = '';
		
		$overData[] = $tmp;
		//$arrplayers[$numo] ="$imglink <A onMouseOver=\"overlib('$overlib', CAPTION, '$overcaption', FGCOLOR, '$Overfg', BGCOLOR, '$Overbg', TEXTCOLOR, '#000000', CAPTIONSIZE, 2, BORDER, 1,WIDTH, 240, TEXTSIZE, 1,VAUTO,HAUTO)\" onMouseOut=\"nd();\" href=\"view.php?view={$pl->fields['id']}\">{$pl->fields['user']}</a> ";
		//if($pl->fields['tribe']>0)
		//	if(file_exists('images/tribes/mini/'.$pl->fields['tribe'].'.jpg'))
		//		$arrplayers[$numo].=' <a href="tribes.php?view=view&id='.$pl->fields['tribe'].'"><img src="images/tribes/mini/'.$pl->fields['tribe'].'.jpg"></a>';
		//$numo ++;
		//$pl -> MoveNext();
}
//$pl -> Close();
$smarty->assign( array( "userlist"=>$overData, "usertotal"=>$nump, "usercurrent"=>$numo ) );
$smarty->display( "userlist.tpl" );

?>