<?php

/*

ALTER TABLE `ranks` ADD `userdel` BOOL NOT NULL DEFAULT '0' AFTER `double` ,
ADD `usersniff` BOOL NOT NULL DEFAULT '0' AFTER `userdel` ,
ADD `tribedel` BOOL NOT NULL DEFAULT '0' AFTER `usersniff` 

$create[] = "
CREATE TABLE resources (
	id INT(6) NOT NULL PRIMARY KEY,
	gold INT(15) NOT NULL,
	bank INT(15) NOT NULL,
	mithril INT(7) NOT NULL,
	copper INT(7) NOT NULL,
	iron INT(7) NOT NULL,
	coal INT(7) NOT NULL,
	adamantium INT(7) NOT NULL,
	meteor INT(7) NOT NULL,
	crystal INT(7) NOT NULL,
	wood INT(7) NOT NULL,
	illani INT(7) NOT NULL,
	illanias INT(7) NOT NULL,
	nutari INT(7) NOT NULL,
	dynallca INT(7) NOT NULL,
	fish INT(7) NOT NULL,
	grzyb INT(7) NOT NULL,
	potato INT(7) NOT NULL
	);";

$create[] = "
DROP TABLE IF EXISTS `bugtrack`;";

$create[] = "
CREATE TABLE `bugtrack` (
`id` INT( 6 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`url` VARCHAR( 255 ) NOT NULL ,
`file` VARCHAR( 255 ) NOT NULL ,
`line` INT( 7 ) NOT NULL ,
`desc` TEXT NOT NULL ,
`time` INT( 12 ) NOT NULL ,
`new` ENUM( 'Y', 'N' ) NOT NULL ,
`solveid` INT( 8 ) NOT NULL
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;";

$create[] = "
CREATE TABLE `wakeup` (
`pid` INT( 8 ) NOT NULL ,
`type` VARCHAR( 10 ) NOT NULL
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci";


$create[] = "
DROP TABLE IF EXISTS `views`;";

$create[] = "
CREATE TABLE views (
file VARCHAR(30) NOT NULL PRIMARY KEY,
times INT(10) NOT NULL);";

$create[] = "
CREATE TABLE `item_images` (
`id` INT( 6 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`img_file` VARCHAR( 50 ) NOT NULL ,
`item_type` CHAR( 1 ) NOT NULL
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci";

$create[] = "
CREATE TABLE `images_potions` (
`id` INT( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`img_file` VARCHAR( 255 ) NOT NULL ,
`potion_type` VARCHAR( 1 ) NOT NULL
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci";

$create[] = "
ALTER TABLE `items` ADD `imagenum` INT( 7 ) NOT NULL ";

$create[] = "
ALTER TABLE `shopware` ADD `imagenum` INT( 7 ) NOT NULL ";

$create[] = "
ALTER TABLE `mikstury` ADD `imagenum` INT( 5 ) NOT NULL ";

$create[] = "
 ALTER TABLE `equipment` ADD `prefix` VARCHAR( 20 ) NOT NULL ,
ADD `imagenum` INT( 5 ) NOT NULL ";

$create[] = "
ALTER TABLE `mikstury` ADD `prefix` VARCHAR( 20 ) NOT NULL ";

$create[] = "
ALTER TABLE `shopware` ADD `prefix` VARCHAR( 20 ) NOT NULL ";

$create[] = "
CREATE TABLE `potions` (
`id` INT( 4 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`prefix` VARCHAR( 30 ) NOT NULL ,
`name` VARCHAR( 60 ) NOT NULL ,
`type` VARCHAR( 1 ) NOT NULL ,
`efekt` VARCHAR( 20 ) NOT NULL ,
`cost` INT( 6 ) NOT NULL ,
`power` INT( 5 ) NOT NULL ,
`amount` INT( 3 ) NOT NULL ,
`imagenum` INT( 4 ) NOT NULL
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci";

$create[] = "
CREATE TABLE `kowal_plany` (
`id` INT( 7 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`pid` INT( 7 ) NOT NULL ,
`plan` INT( 4 ) NOT NULL
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci";

$create[] = "
CREATE TABLE `mill_plany` (
`id` INT( 6 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`pid` INT( 6 ) NOT NULL ,
`plan` INT( 4 ) NOT NULL
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci";

$create[] = "
CREATE TABLE `alchemik_plany` (
`id` INT( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`pid` INT( 7 ) NOT NULL ,
`plan` INT( 3 ) NOT NULL
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci";

$create[] = "
CREATE TABLE `imarket_tmp` (
`iid` INT( 7 ) NOT NULL ,
`basecost` INT( 12 ) NOT NULL ,
PRIMARY KEY ( `iid` )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci";

$create[] = "
CREATE TABLE `shop_user_tmp` (
`iid` INT( 7 ) NOT NULL ,
`basecost` INT( 12 ) NOT NULL ,
PRIMARY KEY ( `iid` )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci";

$create[] = "
ALTER TABLE `pary` CHANGE `prisoner` `marriage1` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `prisonerp` `marriage2` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `verdict` `desc` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ";

$create[] = "
update equipment set amount = 1 where amount = 0";

$create[] = "
ALTER TABLE `mikstury` CHANGE `moc` `moc` INT( 3 ) NOT NULL DEFAULT '1'";
*/

require_once( "includes/preinit.php" );

$title = "Pokój Wielkiego Architekta";

makeHeader();

if( !isset( $_GET['action'] ) ) {
	$_GET['action'] = '';
}

if( $player->rid != 2 ) {
	error( "Spieprzaj dziadu ! Tylko Wielki Architekt ma tutaj wstêp !" );
}

echo <<<EOL
Zarz±dzaj
<ul>
	<li><a href="?action=img_eq">Zaktualizuj</a> obrazki w equipment i shopware</li>
	<li><a href="?action=img_pot">Zaktualizuj</a> obrazki mikstur</li>
	<li><a href="?action=change_id">Zmieñ</a> id gracza</li>
</ul>
Wykonaj aktualizajcê KT do nowo¶ci :
<ul>
	<li><a href="?action=update_freeze">Zamra¿anie</a> kont</li>
	<li><a href="?action=update_citizen">Nadawanie</a> obywatelstwa</li>
	<li><a href="?action=update_events">Raportowanie</a> zdarzen</li>
	<li><a href="?action=update_ref_map">Referencje</a> na mapie</li>
	<li><a href="?action=update_bbcode">Nowy</a> BBcode</li>
</ul>
EOL;

echo "<pre>";

if( $_GET['action'] == 'change_id' ) {
	if( !isset( $_GET['old'] ) ) {
		echo <<<EOL
		<form method="get" action="?">
		<input type="hidden" name="action" value="change_id"/>
		Stare ID : <input type="text" name="old" style="width:70px"/><br/>
		Nowe ID : <input type="text" name="new" style="width:70px"/><br/>
		<input type="submit" value="zmien"/>
		</form>
EOL;
	}
	else {
		if( !isset( $_GET['new'] ) ) {
			error( "Z³e zapytanie !" );
		}
		$tables = array( 'alchemik' => 'gracz', 'bank' => 'pid', 'chat_config' => 'gracz', 'core' => 'owner', 'core_market' => 'seller', 'czary' => 'gracz', 'equipment' => 'owner', 'farm' => 'owner', 'farms' => 'owner', 'houses' => 'owner', 'kowal' => 'gracz', 'log' => 'owner', 'mail' => 'owner', 'mill' => 'owner', 'mill_plany' => 'pid', 'mines' => 'pid', 'notatnik' => 'gracz', 'outposts' => 'owner', 'players' => 'id', 'pmarket' => 'seller', 'hmarket' => 'seller', 'mikstury' => 'gracz', 'resources' => 'id', 'sklepy' => 'owner', 'toplista' => 'pid', 'wakeup' => 'pid' );
		$aff = 0;
		foreach( $tables as $tab => $key) {
			$sql = SqlCreate( "UPDATE", $tab, array( $key => $_GET['new'] ), array( $key => $_GET['old'] ) );
			//qDebug( $sql );
			$aff += SqlExec( $sql );
		}
		$sql = SqlCreate( "UPDATE", 'mail', array( 'sender' => $_GET['new'] ), array( 'sender' => $_GET['old'] ) );
		//qDebug( $sql );
		$aff += SqlExec( $sql );
		
		error( "Zmodyfikowano $aff rekordów !", 'done' );
	}
}

switch( $_GET['action'] ) {
	case 'update_ref_map' :
		SqlExec( "ALTER TABLE `mapa` ADD `ref_id` INT( 4 ) NOT NULL DEFAULT '0';" );
		error( "Aktualizacja przebieg³a pomy¶lnie !", 'done' );
		break;
	case 'update_bbcode' : {
		require_once( "includes/bbcode.php" );
		$old = SqlExec( "SELECT id, profile FROM players" );
		$old = $old->GetArray();
		foreach( $old as $item ) {
			$new = addslashes( htmltobbcode( $item['profile'] ) );
			SqlExec( "UPDATE players SET profile='$new' WHERE id={$item['id']}" );
		}
		error( "Aktualizacja profili zakoñczona !", 'done' );
		break;
	}
}

if( $_GET['action'] == 'update_freeze' ) {
	SqlExec( "ALTER TABLE `players` ADD `freeze` ENUM( 'Y', 'N' ) NOT NULL DEFAULT 'N';" );
	SqlExec( "ALTER TABLE `players` ADD `freeze_date` DATETIME NOT NULL ;" );
	error( "Aktualizacja przebieg³a pomy¶lnie !", 'done' );
}


if( $_GET['action'] == 'update_citizen' ) {
	SqlExec( "ALTER TABLE `ranks` ADD `grant_citizen` BOOL NOT NULL DEFAULT '0';" );
	error( "Aktualizacja przebieg³a pomy¶lnie !", 'done' );
}

if( $_GET['action'] == 'update_events' ) {
	SqlExec( "CREATE TABLE `event_log` ( `id` INT( 10 ) NOT NULL ,`user` INT( 8 ) NOT NULL ,`date` DATETIME NOT NULL ,`level` INT( 2 ) NOT NULL ,`text` TEXT NOT NULL ,PRIMARY KEY ( `id` ) ,INDEX ( `level` )) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci;" );
	error( "Aktualizacja przebieg³a pomy¶lnie !", 'done' );
}


//SqlExec( $create );
//! Przeniesienie wszystkich surowcow do osobnej tabeli
/*
$res = SqlExec( "SELECT * FROM kopalnie" );
$res = $res -> GetArray();
foreach( $res as $item ) {
	$ins['copper'] = $item['copper'];
	$ins['iron'] = $item['zelazo'];
	$ins['coal'] = $item['wegiel'];
	$ins['adamantium'] = $item['adam'];
	$ins['meteor'] = $item['meteo'];
	$ins['crystal'] = $item['krysztal'];
	$ins['wood'] = $item['lumber'];
	$test = SqlExec( "SELECT id FROM resources WHERE id={$item['gracz']}" );
	if( $test -> fields['id'] ) {
		$sql = $pl -> SqlCreate( "UPDATE", 'resources', $ins, "id={$item['gracz']}" );
		//echo "$sql<br>";
	}
	else {
		$ins['id'] = $item['gracz'];
		$sql = $pl -> SqlCreate( "INSERT", 'resources', $ins, "id={$item['gracz']}" );
		//echo "$sql<br>";
	}
	SqlExec( $sql );
	unset( $ins, $sql );
}

unset( $ins );
$res = $db -> Execute( "SELECT * FROM herbs" );
$res = $res -> GetArray();
foreach( $res as $item ) {
	$ins['illani'] = $item['illani'];
	$ins['illanias'] = $item['illanias'];
	$ins['nutari'] = $item['nutari'];
	$ins['dynallca'] = $item['dynallca'];
	$test = SqlExec( "SELECT id FROM resources WHERE id={$item['gracz']}" );
	if( $test -> fields['id'] ) {
		$sql = $pl -> SqlCreate( "UPDATE", 'resources', $ins, "id={$item['gracz']}" );
		//echo "$sql<br>";
	}
	else {
		$ins['id'] = $item['gracz'];
		$sql = $pl -> SqlCreate( "INSERT", 'resources', $ins, "id={$item['gracz']}" );
		//echo "$sql<br>";
	}
	SqlExec( $sql );
	unset( $ins, $sql );
}
unset( $ins );

$res = SqlExec( "SELECT id,credits,bank,platinum,ryby,grzyby,ziemniaki FROM players" );
$res = $res -> GetArray();
foreach( $res as $item ) {
	$ins['gold'] = $item['credits'];
	$ins['bank'] = $item['bank'];
	$ins['mithril'] = $item['platinum'];
	$ins['fish'] = $item['ryby'];
	$ins['grzyb'] = $item['grzyby'];
	$ins['potato'] = $item['ziemniaki'];
	$test = $db -> Execute( "SELECT id FROM resources WHERE id={$item['id']}" );
	if( $test -> fields['id'] ) {
		$sql = $pl -> SqlCreate( "UPDATE", 'resources', $ins, "id={$item['id']}" );
	}
	else {
		$ins['id'] = $item['id'];
		$sql = $pl -> SqlCreate( "INSERT", 'resources', $ins, "id={$item['id']}" );
	}
	SqlExec( $sql );
	unset( $ins, $sql );
}
*/

//! Zaktualizowanie obrazkow w equipment i shopware

if( $_GET['action'] == 'img_eq' ) {
	$tomod = array( 'shopware', 'equipment' );
	$stock = SqlExec( "SELECT * FROM items" );
	$stock = $stock -> GetArray();
	foreach( $tomod as $what ) {
		foreach( $stock as $ware ) {
			$search['type'] = $ware['type'];
			$search['name'] = $ware['name'];
			$sql = SqlCreate( "SELECT", $what, "id, name,imagenum", $search );
			$ret = SqlExec( $sql, FALSE );
			$ret = $ret -> GetArray();
			foreach( $ret as $change ) {
				if( strcasecmp( $change['name'], $ware['name'] ) == 0 &&  $change['imagenum'] != $ware['imagenum'] ) {
					SqlExec( "UPDATE $what SET imagenum={$ware['imagenum']} WHERE id={$change['id']}", true );
				}
			}
			unset( $search );
		}
	}
}


//! Zaktualizowanie obrazkow mikstur
if( $_GET['action'] == 'img_pot' ) {  
	$tomod = array( 'mikstury' );
	$stock = SqlExec( "SELECT * FROM potions" );
	$stock = $stock -> GetArray();
	foreach( $tomod as $what ) {
		foreach( $stock as $ware ) {
			$search['typ'] = $ware['type'];
			$search['nazwa'] = $ware['name'];
			$sql = SqlCreate( "SELECT", $what, "id, nazwa,imagenum", $search );
			$ret = SqlExec( $sql );
			$ret = $ret -> GetArray();
			foreach( $ret as $change ) {
				if( strcasecmp( $change['nazwa'], $ware['name'] ) == 0 &&  $change['imagenum'] != $ware['imagenum'] ) {
					SqlExec( "UPDATE $what SET imagenum={$ware['imagenum']} WHERE id={$change['id']}", true );
				}
			}
			unset( $search );
		}
	}
}


//! Przeniesienie prefixow przedmiotow do osobnej kolumny
/*
$items = SqlExec( "SELECT * FROM equipment" );
$items = $items -> GetArray();
$find = ' ';
foreach( $items as $item ) {
	
	
	$suffs = array( 'Smocz', 'Elf', 'Krasnoludz', 'Magiczn' );
	foreach( $suffs as $suff ) {
		$pos = strpos( $item['name'], $suff, 0 );
		if( $pos === 0 ) {
			$spacja = stripos( $item['name'], $find );
			$item['suff'] = substr( $item['name'], 0, $spacja );
			$item['name'] = substr_replace( $item['name'], '', 0, $spacja+1 );
		}
	}
	
	echo "name :: {$item['name']}\n";
	if( !empty( $item['suff'] ) ) {
		SqlExec( "UPDATE equipment SET name='{$item['name']}', prefix='{$item['suff']}' WHERE id={$item['id']}" );
		//echo "\tsuffix :: {$item['suff']}\n";
	}
}*/

//! Przeniesienie prefixow mikstur do osobnej kolumny
/*
$prefs = array( 'Dobrej jakosci ', 'Wyjatkowej jakosci ', 'Niesamowita ');
foreach( $prefs as $pref ) {
	$potions = SqlExec( "SELECT id,nazwa FROM mikstury WHERE nazwa LIKE '$pref%'" );
	$potions = $potions->GetArray();
	foreach( $potions as $potion ) {
		$prefix = substr( $pref, 0, strlen( $pref ) -1 );
		$name = str_replace( $pref, '', $potion['nazwa'] );
		$sql = "UPDATE mikstury SET nazwa='$name', prefix='$prefix' WHERE id={$potion['id']}";
		SqlExec( $sql );
	}
}
*/

//! Przeniesienie wzorcow mikstur do osobnej tabeli
/*
$potions = SqlExec( "SELECT * FROM mikstury WHERE gracz=0 ORDER BY typ, moc" );
$potions = $potions -> GetArray();
foreach( $potions as $potion ) {
	//$toadd['id']=$potion[''];
	$toadd['prefix']=$potion['prefix'];
	$toadd['name']=$potion['nazwa'];
	$toadd['type']=$potion['typ'];
	$toadd['efekt']=$potion['efekt'];
	$toadd['cost']=$potion['cena'];
	$toadd['power']=$potion['moc'];
	$toadd['amount']=$potion['amount'];
	$toadd['imagenum']=0;
	$sql = $pl -> SqlCreate( "INSERT", 'potions', $toadd );
	SqlExec( $sql );
}
*/

//! Naprawienie skutkow buga w umagicznianiu. Uzywac TYLKO po zastosowaniu prefixow !
/*
$items = SqlExec( "SELECT * FROM equipment" );
$items = $items -> GetArray();
foreach( $items as $item ) {
	if( strpos( $item['prefix'], 'Magicz' ) !== FALSE && $item['magic'] == 'N' ) {
		SqlExec( "UPDATE equipment SET magic='Y' WHERE id={$item['id']}" );
	}
}
*/

//! Przerzucenie planow od kowala do osobnej tabeli
/*
$plany = SqlExec( "select * from kowal where gracz!=0" );
$plany = $plany -> GetArray();
foreach( $plany as $plan ) {
	$res = SqlExec( "select * from kowal where gracz=0 and nazwa='{$plan['nazwa']}'", false );
	$sql = "insert into kowal_plany(pid,plan) values({$plan['gracz']},{$res -> fields['id']})";
	SqlExec( $sql );
}*/

//! Przerzucenie planow tartaku do odobnej tabeli
/*
$plany = SqlExec( "select * from mill where owner!=0" );
$plany = $plany -> GetArray();
foreach( $plany as $plan ) {
	$res = SqlExec( "select * from mill where owner=0 and name='{$plan['name']}'", false );
	$sql = "insert into mill_plany(pid,plan) values({$plan['owner']},{$res->fields['id']})";
	SqlExec( $sql );
	//echo "$sql\n";
}
*/

//! Przerzucenie planow alchemika do odobnej tabeli
/*
$plany = SqlExec( "select * from alchemik where gracz!=0" );
$plany = $plany -> GetArray();
foreach( $plany as $plan ) {
	$res = SqlExec( "select * from alchemik where gracz=0 and nazwa='{$plan['nazwa']}'", false );
	$sql = "insert into alchemik_plany(pid,plan) values({$plan['gracz']},{$res->fields['id']})";
	SqlExec( $sql );
	//echo "$sql\n";
}
*/

//! Poprawienie zawartosci bazaru - uzupelnienie tabeli imarket_tmp
/*
$items = SqlExec( "SELECT id,cost FROM equipment WHERE status='R'" );
$items = $items -> GetArray();
foreach( $items as $item ) {
	$sql = "INSERT INTO imarket_tmp(iid,basecost) VALUES({$item['id']},1)";
	SqlExec( $sql );
}
*/

//! Poprawienie zawartosci skelpow mieszkancow - uzupelnienie tabeli shop_user_tmp
/*
$items = SqlExec( "SELECT id,cost FROM equipment WHERE status='Q'" );
$items = $items -> GetArray();
foreach( $items as $item ) {
	$sql = "INSERT INTO shop_user_tmp(iid,basecost) VALUES({$item['id']},1)";
	SqlExec( $sql );
}
*/

//! Przeniesienie komentarzy  wiesci do nowego forum - NIE DZIALA
/*
$topics = SqlExec( "SELECT * FROM updates" );
$topics = $topics -> GetArray();
print_r( $topics );
*/


//! naprawiene buga z alcchemia i mnozeniem mikstur ?
/*
$pots = SqlExec( "SELECT COUNT(*) AS total, m.*, SUM(amount) AS tot_am, id FROM mikstury m WHERE status='K' GROUP BY gracz, typ, moc, nazwa, prefix" );
$pots = $pots -> GetArray();
foreach( $pots as $pot ) {
	if( $pot['total'] > 1 ) {
		echo "{$pot['total']} :: {$pot['id']}) {$pot['prefix']} {$pot['nazwa']} - {$pot['tot_am']} ({$pot['gracz']})\n";
		$toadd = array();
		//id 	gracz 	nazwa 	typ 	efekt 	status 	cena 	moc 	amount 	prefix 	imagenum
		
		$toadd['nazwa'] = $pot['nazwa'];
		$toadd['prefix'] = $pot['prefix'];
		
		
		$toadd['typ'] = $pot['typ'];
		$toadd['status'] = 'K';;
		//
		$toadd['moc'] = $pot['moc'];
		$toadd['gracz'] = $pot['gracz'];
		
		$search = $pl->SqlCreate( "select", "mikstury", 'id', $toadd );
		$res = SqlExec( $search, FALSE );
		$res = $res -> GetArray();
		$foo = array();
		foreach( $res as $r ) {
			$foo[] = $r['id'];
		}
		$sql = "DELETE FROM mikstury WHERE id IN (".implode(",",$foo).")";
		//echo "$sql\n";
		SqlExec( $sql );
		//print_r( $foo );
		//echo "$search\n";
		
		//$toadd['id'] = $pot['id'];
		//$toadd['cena'] = $pot['cena'];
		$toadd['amount'] = $pot['tot_am'];
		$toadd['imagenum'] = $opt['imagenum'];
		$sql = $pl -> SqlCreate( "INSERT", 'mikstury', $toadd );
		//echo "$sql\n";
		SqlExec( $sql );
	}
}
*/

echo "</pre>";

makeFooter();

?>