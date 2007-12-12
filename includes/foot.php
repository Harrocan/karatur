<?php
if($_SESSION['file']!='')
	$smarty->assign("Link",$_SESSION['file']);
else
	$smarty->assign("Link","");
//unset($_SESSION['file']);
$smarty->assign("SesLocation",$_SESSION['location']);
//$path_base="/home/ivan/public_html/karatur/";
//$sql="SELECT players.lpv, players.avatar, players.jail, players.id, players.miejsce, players.rasa, players.user, players.level, players.age, players.user, players.gender, players.page, players.miejsce, players.stan, players.avatar, players.opis, players.tribe, ranks.name AS rankname, ranks.image FROM players JOIN ranks ON players.rid=ranks.id WHERE players.lpv>".(time()-180).";";
//$pl = SqlExec($sql);
//$nump = $pl -> RecordCount();
//$arrplayers = array();
//$numo=0;
//while (!$pl -> EOF) {
//		$imglink="<img src=\"images/ranks/{$pl->fields['image']}\" ALT=\"{$pl->fields['rankname']}\">";
//		if( is_file( "avatars/{$pl->fields['avatar']}" ) ) {
//			$mini = "<td rowspan=9><img src=\"avatars/{$pl->fields['avatar']}\" style=\"max-width:100px;max-height:100px\"></td>";
//		}
//		else
//			$mini = '';
//		$overlib="<table width=100% border=0><tr>$mini<td> Level: {$pl -> fields['level']}<br>Wiek: {$pl -> fields['age']}<br>Rasa: {$pl -> fields['rasa']}<br>Lokalizacja: {$pl -> fields['miejsce']}<br>Widziany: {$pl -> fields['page']}<br>Stan: {$pl -> fields['stan']}<br>Ranga: {$pl->fields['rankname']}<BR>Opis : {$pl->fields['opis']}";
//    	if($pl->fields['jail']=='Y')
//			$overlib.="<br><b>W wiezieniu</b>";
//		$overlib.="</td></tr></table>";
//		$overcaption="<center><B>{$pl->fields['user']}</B> ({$pl->fields['id']})</center>";
//		
//		$tmp['data'] = $pl->fields;
//		$tmp['title'] = $overcaption;
//		$tmp['img'] = $imglink;
//		$tmp['body'] = $overlib;
//		$tmp['link'] = "<a href=\"view.php?view={$pl->fields['id']}\">{$pl->fields['user']}</a> ";
//		if($pl->fields['tribe']>0) {
//			if(file_exists('images/tribes/mini/'.$pl->fields['tribe'].'.jpg'))
//				$tmp['data']['tribeimg'] = $pl->fields['tribe'].'.jpg';
//		}
//		if( !isset( $tmp['data']['tribeimg'] ) )
//			$tmp['data']['tribeimg'] = '';
//		
//		$overData[] = $tmp;
//		$arrplayers[$numo] ="$imglink <A onMouseOver=\"overlib('$overlib', CAPTION, '$overcaption', FGCOLOR, '$Overfg', BGCOLOR, '$Overbg', TEXTCOLOR, '#000000', CAPTIONSIZE, 2, BORDER, 1,WIDTH, 240, TEXTSIZE, 1,VAUTO,HAUTO)\" onMouseOut=\"nd();\" href=\"view.php?view={$pl->fields['id']}\">{$pl->fields['user']}</a> ";
//		if($pl->fields['tribe']>0)
//			if(file_exists('images/tribes/mini/'.$pl->fields['tribe'].'.jpg'))
//				$arrplayers[$numo].=' <a href="tribes.php?view=view&id='.$pl->fields['tribe'].'"><img src="images/tribes/mini/'.$pl->fields['tribe'].'.jpg"></a>';
//		$numo ++;
//	$pl -> MoveNext();
//}
//$pl -> Close();
//$smarty -> assign( "OverData", $overData );

$numpl=$db->Execute("SELECT id FROM players");
$nump=$numpl->RecordCount();
$qmsg=$db->Execute("SELECT value FROM settings WHERE setting='qmsg'");
$smarty->assign("Qmsg",$qmsg->fields['value']);
$pollid = $db-> Execute("SELECT value FROM settings WHERE setting='poll_id'");
$poll=$db->Execute("SELECT * FROM poll WHERE id=".$pollid->fields['value']."");
if($poll->fields['name']) {
	$polln=$poll->fields['name'];
	$pollq=explode(",",$poll->fields['options']);
	$pollv=explode(",",$poll->fields['votes']);
	$sum=0;
	foreach($pollv as $v)
		$sum+=$v;
	$proc=array();
	foreach($pollv as $v) {
		if($sum>0)
			$proc[]=($v/$sum)*100;
		else
			$proc[]=0;
	}
	$smarty->assign(array("PlVote"=>$player->vote,"PollName"=>$polln,"PollQuestion"=>$pollq,"PollValue"=>$pollv,"Proc"=>$proc));
}
$db -> LogSQL(false);
list($a_dec, $a_sec) = explode(' ', $start_time);
list($b_dec, $b_sec) = explode(' ', microtime());
$duration = sprintf("%0.3f", $b_sec - $a_sec + $b_dec - $a_dec);
/*
if (true) {
    $sqltime = 0;
    $query = $db -> Execute("SELECT timer FROM adodb_logsql");
    $numquery = $query -> RecordCount();
    while (!$query -> EOF) {
        $sqltime = $sqltime + $query -> fields['timer'];
        $query -> MoveNext();
    }
    $query -> Close();
    $phptime = round($duration - $sqltime, 3);
    $sqltime = round($sqltime, 3);
    $show = 1;
} else {
    $show = 0;
}*/
$show = 0; 
SqlExec("TRUNCATE TABLE adodb_logsql");

//inicjalizacja zmiennych
if (!isset($numquery)) {
    $numquery = 0;
}
if (!isset($phptime)) {
    $phptime = 0;
}
if (!isset($sqltime)) {
    $sqltime = 0;
}

$numquery = $numquery + 1;
//$db -> Close();
// if ($compress) {
//     $comp = 'Tak';
// } else {
//     $comp = 'Nie';
// }
// if (!isset($do_gzip_compress)) {
//     $do_gzip_compress = $compress;
// }

//przypisanie odpowiednich wartosci oraz wyswietlenie strony
$smarty -> assign (array (
					//"Players" => $nump, 
					//"Online" => $numo, 
					//"List" => $arrplayers, 
					"Duration" => $duration, 
					"Show" => $show, 
					"Sqltime" => $sqltime, 
					"PHPtime" => $phptime, 
					"Numquery" => $numquery));
$smarty -> display ('footer.tpl');
$db -> Close();

// if ( $do_gzip_compress )
// {
// 	//
// 	// Borrowed from php.net!
// 	//
// 	$gzip_contents = ob_get_contents();
// 	ob_end_clean();
// 
// 	$gzip_size = strlen($gzip_contents);
// 	$gzip_crc = crc32($gzip_contents);
// 
// 	$gzip_contents = gzcompress($gzip_contents, 9);
// 	$gzip_contents = substr($gzip_contents, 0, strlen($gzip_contents) - 4);
// 
// 	echo "\x1f\x8b\x08\x00\x00\x00\x00\x00";
// 	echo $gzip_contents;
// 	echo pack('V', $gzip_crc);
// 	echo pack('V', $gzip_size);
// }

// if ($view -> gender) {
//     if ($view -> gender == 'M') {
//         $gender = 'Mezczyzna';
//     } else {
//         $gender = 'Kobieta';
//     }
//     $smarty -> assign ("Gender", "Plec: ".$gender."<br>");
// }
// if ($view -> hp) {
//     if ($view -> hp == '0') {
//         $hp = '';
//     }
//     $smarty -> assign ("Gender", "Plec: ".$gender."<br>");
// }
exit;
?>

