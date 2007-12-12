<?php
require_once('includes/config.php');
require_once('includes/sessions.php');
require_once('libs/Smarty.class.php');
$smarty = new Smarty;
$smarty->compile_check = true;
$stat = $db -> Execute("SELECT id, rank FROM players WHERE email='".$_SESSION['email']."'");
$chat = $db -> SelectLimit("SELECT * FROM chat ORDER BY id DESC", 20) or die("blad!");
$pl = $db -> Execute("SELECT rank, id, lpv, user, gender FROM players WHERE page='Chat'AND dostep!=1");

$arrtext = array();
$arrauthor = array();
$arrsenderid = array();
$i = 0;
if ($stat -> fields['rank'] == 'Admin' || $stat -> fields['rank'] == 'Staff') {
    $smarty -> assign ("Showid", 1);
}
while (!$chat -> EOF) {
    $text = wordwrap($chat -> fields['chat'],50,"\n",1);
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

$chatname=array();
$chatid=array();
$chatgender=array();
$x=0;
while (!$pl -> EOF) {
	$span = ($ctime - $pl -> fields['lpv']);
	if ($span <= 180) {
		
		$chatid[$x]=$pl->fields['id'];
		$chatname[$x]=$pl->fields['user'];
		if($pl->fields['gender']=='M') {
			$chatgender[$x]='male.png';
		}
		elseif($pl->fields['gender']=='F') {
			$chatgender[$x]='female.png';
		}
		else 
		$chatgender[$x]='none.png';
		$x++;
	    $on = $on." [<A href=view.php?view=".$pl -> fields['id']." target=_parent>".$pl -> fields['user']."</a> (".$pl -> fields['id'].")] ";
	    $numon = ($numon + 1);
	}
	$pl -> MoveNext();
}
$pl -> Close();
$query = $db -> Execute("SELECT id FROM chat");
$numchat = $query -> RecordCount();
$query -> Close();

$smarty -> assign ( array( "Chatid"=>$chatid, "Chatname"=>$chatname, "Chatgender"=>$chatgender));

$smarty -> assign ( array("Player" => $on, "Text1" => $numchat, "Online" => $numon, "Author" => $arrauthor, "Text" => $arrtext, "Senderid" => $arrsenderid));
$smarty -> display ('chatmsgs.tpl');
$db->Close();
?>

