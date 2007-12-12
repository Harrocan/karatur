<?php
//@type: F
//@desc: Pokoj Nieklimatyczny
$title = "Pokoj Nieklimatyczny";
$js_onLoad = "chatInit('offtop');";
require_once("includes/head.php");

checklocation( 'chat.php' );

$db -> Execute("UPDATE players SET page='Pokoj Nieklimatyzowany' WHERE id=".$player -> id);
if (isset ($_GET['action']) && $_GET['action'] == 'chat') {
     if (isset ($_POST['msg'])) {
     $rcol=$db->Execute("SELECT color FROM ranks WHERE id={$player->rid}");
     $starter="<span style=\"color:{$rcol->fields['color']}\">".$player -> user."</span>";
        $czat = $db -> Execute("SELECT gracz FROM bezklimyconfig");
        while (!$czat -> EOF) {
            if ($player -> id == $czat -> fields['gracz']) {
                error ("Nie mozesz pisac wiadomosci w tym pokoju");
            }
            $czat -> MoveNext();
        }
        $czat -> Close();
        require_once('includes/bbcode.php');
        $_POST['msg'] = bbcodetohtml($_POST['msg']);
        $test = substr($_POST['msg'], 0, 20);
        $id = substr($_POST['msg'],20);
        $arritems = array('piwo', 'miod', 'wino', 'lody', 'obiad', 'ryba', 'woda', 'zupa', 'stek', 'narkotyki');
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
        $db -> Execute("INSERT INTO bezklimy (user, chat, senderid,ownerid) VALUES('".$starter."', '".$message."',".$player -> id.",".$owner.")");
        for ($i = 0; $i < 8; $i++) {
            $empty = 0;
            if ($test == "Karczmarzu ".$arritems[$i]." dla "){
                $id = substr($_POST['msg'],20);
                if ($id == 'wszystkich!') {
                           $db -> Execute("INSERT INTO bezklimy (user, chat) VALUES('<i>Karczmarz</i>', 'Uwaga! ".$player -> user." stawia wszystkim ".$arritems[$i]."!')");
                       }
                if (ereg("^[1-9][0-9]*$", $id)) {
                    $db -> Execute("INSERT INTO bezklimy (user, chat) VALUES('<i>Karczmarz</i>', 'Prosze ".$user -> fields['user']." oto ".$arritems[$i]." od ".$player -> user."')");
                }
                break;
            } elseif ($checkbot == "Karczmarzu") {
                $empty = 1;
            }
        }
        if ($_POST['msg'] == 'Karczmarzu jakies wiesci?') {
            $empty = 0;
            $query = $db -> Execute("SELECT id FROM events");
            $number = $query -> RecordCount();
            $query -> Close();
            if ($number > 0) {
                $roll = rand (1,$number);
                $event = $db -> Execute("SELECT text FROM events WHERE id=".$roll);
                $text = "Oczywiscie! ".$event -> fields['text'];
                $db -> Execute("INSERT INTO bezklimy (user, chat) VALUES('<i>Karczmarz</i>', '".$text."')");
            } else {
                $db -> Execute("INSERT INTO bezklimy (user, chat) VALUES('<i>Karczmarz</i>', 'Niestety nic ciekawego sie nie wydarzylo')");
            }
        }
        if ($_POST['msg'] == 'Barnabo jakis problem?') {
            $empty = 0;
            $query = $db -> Execute("SELECT id FROM events");
            $number = $query -> RecordCount();
            $query -> Close();
            if ($number > 0) {
                $roll = rand (1,$number);
                $db -> Execute("INSERT INTO bezklimy (user, chat) VALUES('<i>Barnaba</i>', 'Nie niema zadnego, tak patrze na twoja bron i sie boje')");
            }
        }
        if ($empty == 1) {
            $arrtext = array ('Nie rozumiem', 'Barnaba pokaz temu klientowi drzwi!', 'Hmm w jakim to jezyku?', 'Pytania sa tendencyjne', 'Do mnie mowisz?');
            $roll = rand (0, 4);
            $db -> Execute("INSERT INTO bezklimy (user, chat) VALUES('<i>Karczmarz</i>', '".$arrtext[$roll]."')");
        }
    }
}

/**
* Chat prune
*/
if (isset ($_GET['step']) && $_GET['step'] == 'clearc') 
{
    if ($player -> rank != 'Admin' && $player -> rank != 'Karczmarka' && $player -> rank != 'Karczmarz')
    {
        error(ERROR);
    }
    $db -> Execute("TRUNCATE TABLE bezklimy");
    error("Ahhh... jak przejrzyscie i czysto:P",'done');
}

//$query = $db -> Execute("SELECT id FROM bezklimy");
//$numchat = $query -> RecordCount();
//$query -> Close();
$smarty -> assign (array(//"Number" => $numchat,
//     "Arefresh" => A_REFRESH,
//     "Asend" => A_SEND,
//     "Inn" => INN,
//     "Innis" => INN_IS,
//     "Inntexts" => INN_TEXTS,
    "Rank_block" => $_SESSION['rank']['block'],
    "Rank_clear" => $_SESSION['rank']['clearchat']));
$smarty -> display ('bezklimy.tpl');

require_once("includes/foot.php");
?>
