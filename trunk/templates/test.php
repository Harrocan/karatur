<?php

//for($i= 50; $i>=0; $i --) {
//	echo "<img src='itemimage.php?path=images/items/W/battle_axe.gif&wt=$i&maxwt=50'> ";
//}

/*
ALTER TABLE `miasta` DROP `armor.php` ,
DROP `barbarian.php` ,
DROP `bezkilmy.php` ,
DROP `bows.php` ,
DROP `lathanderkosciol.php` ,
DROP `maskakosciol.php` ,
DROP `mines.php` ,
DROP `mystrakosciol.php` ,
DROP `weapons.php` ,
DROP `train.php` ,
DROP `selunekosciol.php` ,
DROP `sharkosciol.php` ;
*/

require_once('includes/config.php');
require_once('includes/globalfunctions.php');
require_once('class/playerManager.class.php');

if( $_POST['ajax'] ) {
	echo "{$POST['text']}";
	die();
}

?>
<script language="JavaScript">
	function send() {
		alert( "send !" );
	}
</script>
<script language="JavaScript" src="js/advajax.js"></script>
<script language="JavaScript" src="js/ajax_base.js"></script>
<input type="text" /> <input type="submit" value="go" onclick="send()"><br/>
<div id="text" style="border:solid">tt</div>
<?php

die();

//SqlExec( "DELETE FROM wakeup WHERE pid NOT IN ( SELECT id FROM players )" );
//SqlExec( "DELETE FROM resources WHERE id NOT IN ( SELECT id FROM players )" );
//SqlExec( "DELETE FROM alchemik_plany WHERE pid NOT IN ( SELECT id FROM players )" );
//SqlExec( "DELETE FROM bank WHERE pid NOT IN ( SELECT id FROM players )" );
//SqlExec( "DELETE FROM core WHERE owner NOT IN ( SELECT id FROM players )" );
//SqlExec( "DELETE FROM czary WHERE gracz NOT IN ( SELECT id FROM players ) AND gracz!=0" );
//SqlExec( "DELETE FROM equipment WHERE owner NOT IN ( SELECT id FROM players ) AND gracz!=0" );

//SqlExec( "DROP TABLE `herbs`" );
//SqlExec( "DROP TABLE `kopalnie`" );
//SqlExec( "DROP TABLE `replies`" );
//SqlExec( "DROP TABLE `topics`" );

//$del = new playerManager( 502 );
//echo "Deleting ".$del->getMisc( 'user' );
//$del->delete();


//SqlExec("DELETE FROM aktywacja WHERE data < ".$db->DBDate( (time()-60*60*24*30) ) );

$res = SqlExec( "SELECT w.*, COUNT(*) AS amount, p.user from wakeup w LEFT JOIN players p ON p.id=w.pid GROUP BY w.pid, w.`type`" );
//$res = SqlExec( "SELECT * FROM wakeup WHERE pid NOT IN ( SELECT id FROM players )" );
$res = $res->GetArray();
echo "<table border=1><tr><td>Id</td><td>User</td><td>typ</td><td>ilosci</td></tr>";
//$i =0;
foreach( $res as $item ) {
	//SqlExec( "DELETE FROM wakeup WHERE pid={$item['pid']} AND `type`='{$item['type']}'" );
	//SqlExec( "INSERT INTO wakeup( pid, `type` ) VALUES( {$item['pid']}, '{$item['type']}' )" );
	//$i++;
	echo "<tr><td>{$item['pid']}</td><td>{$item['user']}<td>{$item['type']}</td><td>{$item['amount']}</td></tr>";
}
//echo "done";
echo "</table>";
// 618

//require_once('class/playerManager.class.php');
//$pl = new playerManager( '267' );
//$pl->addRes( 'gold','20' );
/*
$path = 'images/female.png';
function openimage( $path ) {
	if( !is_file( $path ) ) {
		return FALSE;
	}
	$stats = getimagesize( $path );
	$imgtypes = array( 'gif' => 'imagecreatefromgif', 'jpg' => 'imagecreatefromjpeg', 'png' => 'imagecreatefrompng' );
	switch( $stats['mime'] ) {
		case 'gif' :
			$img = imagecreatefromgif( $path );
			break;
		case 'png' :
			$img = imagecreatefrompng( $path );
			break;
		case 'jpeg' :
			$img = imagecreatefromjpeg( $path );
			break;
		default :
			trigger_error( "Nieobslugiwany format pliku: {$stats['mime']} !",E_USER_WARNING );
			return FALSE;
			break;
	}
	return $img;
}

print_r( getimagesize( $path ) );

if( ( $img = openimage( $path ) ) !== FALSE ) {
	//echo "Obraz typu: $imgtype o wymiarach ".imagesx($img)."x".imagesy($img);
	echo "Poprawnie otworzono !";
	imagedestroy( $img );
}
else {
	echo "Nieobslugiwany format !";
}

//$img = @imagecreatefromgif($path);
//echo exif_imagetype();
*/


/*
if(!empty($_GET['word']))
	$mail=$db->Execute("SELECT * FROM mail WHERE senderid!=owner AND body LIKE '%{$_GET['word']}%' ORDER by time DESC ");
elseif(!empty($_GET['id']))
	$mail=$db->Execute("SELECT * FROM mail WHERE senderid!=owner AND ( senderid={$_GET['id']} OR owner={$_GET['id']} ) ORDER by time DESC LIMIT 150");
elseif(!empty($_GET['sid']))
	$mail=$db->Execute("SELECT * FROM mail WHERE senderid!=owner AND senderid={$_GET['sid']} ORDER by time DESC LIMIT 150");
elseif(!empty($_GET['oid']))
	$mail=$db->Execute("SELECT * FROM mail WHERE senderid!=owner AND owner={$_GET['oid']} ORDER by time DESC LIMIT 150");
else
	$mail=$db->Execute("SELECT * FROM mail WHERE senderid!=owner ORDER by time DESC LIMIT 150");
$mail=$mail->GetArray();

echo "<TABLE border=1>";
foreach($mail as $m) {
	$owner=$db->Execute("SELECT user FROM players WHERE id={$m['owner']}");
	//if( stristr($owner->fields['user'],$word)!==FALSE || stristr($m['sender'],$word)!==FALSE )
		echo "<tr><td>{$m['sender']} ({$m['senderid']}) => {$owner->fields['user']} ({$m['owner']})</td><td>{$m['time']}</td></tr><tr><td colspan=2 style=\"padding-left:50px\">{$m['body']}</td></tr>";
}
echo "</table>";

*/

$db->Close();

/*
$dir=opendir("mapa-big/");
$path_base=str_replace(basename($_SERVER['DOCUMENT_ROOT']),"",$_SERVER['DOCUMENT_ROOT']);
$i=0;
while( ($file=readdir($dir)) !== FALSE ) {
	if($file!='.' && $file!='..')
		echo "ftp://ftp.ivan.netshock.pl/public_html/karatur/mapa-big/{$file}<br>";
	//if($i%220==0)
		//echo "<br>";
	$i++;
}
closedir($dir);

//echo "<br>Kropków w katalogu : $i<br>Przygarnij kropka";
*/
$db -> Close();
?>