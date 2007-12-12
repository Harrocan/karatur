<?php
// +----------------------------------------------------------------------+
// | PHP Source                                                           |
// +----------------------------------------------------------------------+
// | Copyright (C) 2007 by IvaN <ivan-q@o2.pl>                            |
// +----------------------------------------------------------------------+
// |                                                                      |
// | Copyright: See COPYING file that comes with this distribution        |
// +----------------------------------------------------------------------+
//

/*!
 * TODO
 *
 * kawiarnia.php, baszta.php, jublier.php, kat.php
 * Wszystkie chaty koscielne oraz sala rozpraw
 * edycja szkol, biblioteka, skarbiec, teatr
 * zorientowac sie w sprawach krolestwa (sprw.php)
 * ulepszanie przedmiotow & mistyczny zagajnik
 *
 */

$done = array( 'alchemik.php', 'ap.php', 'core.php', 'deity.php', 'explore.php', 'turnfight.php', 'funkcje.php', 'farm.php', 'stats.php', 'equip.php', 'zloto.php', 'czary.php', 'panel.php', 'shop.php', 'grid.php', 'hospital.php', 'hotel.php', 'house.php', 'stats.php', 'wieza.php', 'praca.php', 'warehouse.php', 'vote.php', 'msklep.php', 'updates.php', 'items.php', 'plany.php', 'kowal.php', 'lumbermill.php', 'market.php', 'pmarket.php', 'imarket.php', 'jail.php', 'hmarket.php', 'tribes.php', 'tribeware.php', 'tribearmor.php', 'school.php', 'outposts.php', 'mail.php', 'log.php', 'sklepy.php', 'mapa.php', 'urzad.php', 'ogl.php', 'ogloszenia.php', 'ziemniaki.php', 'kuchnia.php', 'ashop.php', 'login.php', 'logout.php', 'account.php', 'addnews.php', 'addupdate.php', 'map.php', 'mapprv.php', 'akta.php', 'summfunc.php', 'members.php', 'aktywacja.php', 'miasta.php','mitheneg.php','lumberjack.php','news.php', 'mines_new.php','baszta.php','odmiana.php', 'notatnik.php','burdel.php','monuments.php','pary.php','newspaper.php', 'memberlist.php','pokoje.php','poll.php' );

$flip = array_flip( $done );

$dir = opendir( "." );

while( ( $file = readdir( $dir ) ) !== FALSE ) {
	
	$add = true;
	$end = substr( $file, -1 );
	//echo "$end<br>";
	if( substr( $file, -1 ) == '~' )
		$add = false;
	if( substr( $file, -3 ) != 'php' )
		$add = false;
	if( isset( $flip[$file] ) )
		$add = false;
	
	if( $add == true ) {
		$todo[] = $file;
	}
	
}
echo "<pre>";
echo "Total :".count( $todo )."\n";
print_r( $todo );
echo "</pre>";
closedir( $dir );

?>
