<?php
//@type: F
//@desc: Karczma
$title = "Karczma";
$js_onLoad = "chatInit('chat');";
require_once("includes/head.php");

checklocation( 'chat.php' );

function offtop(&$text){
	return $text;
if($text[0]=="/")
	$off=1;
else
	$off=0;
$siecz=explode("/",$text);
$i=0;
for($i=$off;$i<=count($siecz);$i++) {
	if($i%2!=0 && $siecz[$i]!='')
		$siecz[$i] = "<font color=\"dimgray\"><i>".$siecz[$i]."</i></font>";
	}
$end=implode("/",$siecz);
$text=$end;
return $text;
}
function emoty(&$text){
if($text[0]=="*")
	$off=1;
else
	$off=0;
$siecz=explode("*",$text);
$i=0;
for($i=$off;$i<=count($siecz);$i++) {
	if($i%2!=0 && $siecz[$i]!='')
		$siecz[$i] = "<font color=\"#054F05;\"><i>".$siecz[$i]."</i></font>";
	}
$end=implode("*",$siecz);
$text=$end;
return $text;
}
$bezkl=$db-> Execute("SELECT id, lpv FROM players WHERE page='Pokoj Nieklimatyzowany';");
$nieklim=0;
while(!$bezkl->EOF) {
	$span = ($ctime - $bezkl -> fields['lpv']);
	if ($span <= 180)
		$nieklim++;
	$bezkl->MoveNext();
}
if($bezkl->fields['id']!='')
	$bezkl->Close();
$schody=$db-> Execute("SELECT id, lpv FROM players WHERE page='Piwnica';");
$schod=0;
while(!$schody->EOF){
	$span = ($ctime - $schody -> fields['lpv']);
	if ($span <= 180)
		$schod++;
	$schody->MoveNext();
	}
if($schody->fields['id']!='')
	$schody->Close();
$smarty->assign( array( "Nieklim"=>$nieklim, "Schody"=>$schod));
$db -> Execute("UPDATE players SET page='chat' WHERE id=".$player -> id);
if (isset ($_GET['action']) && $_GET['action'] == 'chat') {
     if (isset ($_POST['msg'])) {
     $rcol=$db->Execute("SELECT color FROM ranks WHERE id={$player->rid}");
     $starter="<span style=\"color:{$rcol->fields['color']}\">".$player -> user."</span>";
	$czat = $db -> Execute("SELECT gracz FROM chat_config");
	while (!$czat -> EOF) {
	    if ($player -> id == $czat -> fields['gracz']) {
		error ("Dostales Banana! Jakis problem? Pisz do wladz, masz to jak w banku ze Cie wysluchaja.");
	    }
	    $czat -> MoveNext();
	}
	$czat -> Close();


	require_once('includes/bbcode.php');
        $_POST['msg'] = bbcodetohtml($_POST['msg']);
        $test = substr($_POST['msg'], 0, 20);
	$id = substr($_POST['msg'],20);
        $arritems = array('piwo', 'miod', 'wino', 'soku', 'kawa', 'woda', 'sera', 'sake', 'krew', 'woda' );
        $checkbot = substr($_POST['msg'], 0, 10);
        foreach ($arritems as $item) {
            if ($test == "Karczmarzu ".$item." dla " && ereg("^[1-9][0-9]*$", $id)) {
                $user = $db -> Execute("SELECT user FROM players WHERE id=".$id);
                $id = $user -> fields['user'];
                $message = $test.$id;
		$user -> Close();
                break;
            } else {
                $message = $_POST['msg'];
            }
        }
        $test1 = explode("=", $_POST['msg']);
        if (ereg("^[1-9][0-9]*$", $test1[0])) {
            $user = $db -> Execute("SELECT user FROM players WHERE id=".$test1[0]);
            $id = $user -> fields['user'];
            if ($id) {
                $message = "<b>".$id.">>></b> ".$test1[1];
            } else {
                $message = $test1[1];
            }
            $owner = $test1[0];
        } else {
            $owner = 0;
        }
	$message=offtop($message);
	$message=emoty($message);
	$db -> Execute("INSERT INTO chat (user, chat, senderid,ownerid) VALUES('".$starter."', '".$message."',".$player -> id.",".$owner.")");
        $db -> Execute("UPDATE players SET aktyw=aktyw+1 WHERE id=".$player -> id);

		for ($i = 0; $i < count( $arritems ); $i++) {
            $empty = 0;
            if ($test == "Karczmarzu ".$arritems[$i]." dla "){
	        $id = substr($_POST['msg'],20);
                if ($id == 'wszystkich!') {
       	            $db -> Execute("INSERT INTO chat (user, chat) VALUES('<i>Karczmarz</i>', 'Zamknac sie! ".$player -> user." stawia kazdemu ".$arritems[$i]."!')");
       	        }
                if (ereg("^[1-9][0-9]*$", $id)) {
                    $db -> Execute("INSERT INTO chat (user, chat) VALUES('<i>Karczmarz</i>', 'Ej Ty! jak ci tam... ".$user -> fields['user'].", Masz ".$arritems[$i]." od ".$player -> user."')");
                }
                break;
            } elseif ($checkbot == "Karczmarzu") {
                $empty = 1;
            }
        }
	 }
}
$query = $db -> Execute("SELECT id FROM chat");
$numchat = $query -> RecordCount();
$query -> Close();
$smarty -> assign (array("Number" => $numchat,
//     "Arefresh" => A_REFRESH,
//     "Asend" => A_SEND,
//     "Inn" => INN,
//     "Innis" => INN_IS,
//     "Inntexts" => INN_TEXTS,
    "Rank_block" => $_SESSION['rank']['block'],
    "Rank_clear" => $_SESSION['rank']['clearchat']));


/*$smarty -> assign (array("Number" => $numchat,
    "Arefresh" => A_REFRESH,
    "Asend" => A_SEND,
    "Inn" => INN,
    "Innis" => INN_IS,
    "Inntexts" => INN_TEXTS,
    "Rank" => $player -> rank));*/
$smarty -> display ('chat.tpl');
require_once("includes/foot.php");
?>

