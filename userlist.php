<?
// Chatr - Super-simple chat for your site
//   (c) 2006 David Sterry
//   Distributed under the BSD license
//   Link: http://www.sterryit.com/chatr

include("config.php");

$path_base="/home/ivan/public_html/karatur/";
require_once($path_base.'adodb/adodb.inc.php');
$db = NewADOConnection('mysql');
$db -> Connect("localhost", "ivan_karatur", "karatur", "ivan_karatur");
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;

$time=time();
$time-=180;
$users=$db->Execute("SELECT user,id FROM players WHERE lpv>$time AND page='chat'");

$users=$users->GetArray();
foreach($users as $user) {
	$us=$user['user'];
	$us=strtr($us,'ë','e');
	echo "<li>" .$us."</li>";
}

$db->Close();

/*$file = file_get_contents($users_file);
$lines = explode("\n",$file);
$num = count($lines);

for( $i = 0; $i < $num; $i++ ) {
  $data = explode(",",$lines[$i]); 
  if( count($data) > 1 ) { echo "<li>" . $data[1] . "</li>"; }
}*/

?>
