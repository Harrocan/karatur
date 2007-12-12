<?php
require_once('includes/config.php');
require_once('includes/sessions.php');
require_once('libs/Smarty.class.php');
$smarty = new Smarty;
$smarty->compile_check = true;
$stat = $db -> Execute("SELECT id, rank FROM players WHERE email='".$_SESSION['email']."' AND pass=MD5('".$_SESSION['pass']."')");
$chat = $db -> SelectLimit("SELECT * FROM selunekosciol WHERE ownerid=0 OR ownerid=".$stat -> fields['id']." OR senderid=".$stat -> fields['id']." ORDER BY id DESC", 15) or die("blad!");
$pl = $db -> Execute("SELECT rank, id, lpv, user FROM players WHERE page='Kosciol Selune'");
$arrtext = array();
$arrauthor = array();
$arrsenderid = array();
$i = 0;
if ($stat -> fields['rank'] == 'Admin' || $stat -> fields['rank'] == 'Staff') {
    $smarty -> assign ("Showid", 1);
}
while (!$chat -> EOF) {
    $text = wordwrap($chat -> fields['chat'],30,"\n",1);
    $arrtext[$i] = $text;
    $arrauthor[$i] = $chat -> fields['user'];
    $arrsenderid[$i] = $chat -> fields['senderid'];
    $chat -> MoveNext();
    $i = $i + 1;
}
$chat -> Close();
$ctime = time();
$on = '';
$numon = 0;
while (!$pl -> EOF) {
	$span = ($ctime - $pl -> fields['lpv']);
	if ($span <= 180) {
	    $on = $on." [<A href=view.php?view=".$pl -> fields['id']." target=_parent>".$pl -> fields['user']."</a> (".$pl -> fields['id'].")] ";
	    $numon = ($numon + 1);
	}
	$pl -> MoveNext();
}
$pl -> Close();
$query = $db -> Execute("SELECT id FROM selunekosciol");
$numchat = $query -> RecordCount();
$query -> Close();

$smarty -> assign ( array("Player" => $on, "Text1" => $numchat, "Online" => $numon, "Author" => $arrauthor, "Text" => $arrtext, "Senderid" => $arrsenderid));
$smarty -> display ('selunekosciolsgs.tpl');

?>
