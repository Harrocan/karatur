<?php
$title = "Kosciol Lolth";
require_once("includes/head.php");
$db -> Execute("UPDATE players SET page='Kosciol Lolth' WHERE id=".$player -> id);
if (isset ($_GET['action']) && $_GET['action'] == 'chat') {
     if (isset ($_POST['msg'])) {
        if ($player -> rank == 'Admin') {
            $starter = "<font color=0066cc>".$player -> user."</font>";
        } elseif ($player -> rank == 'Staff') {
            $starter = "<font color=00ff00>".$player -> user."</font>";
        } elseif ($player -> rank == 'Archaniol') {
            $starter = "<font color=white>".$player -> user."</font>";
        } elseif ($player -> rank == 'Ksiaze') {
            $starter = "<font color=#B22222>".$player -> user."</font>";
        } elseif ($player -> rank == 'Ksiezniczka') {
            $starter = "<font color=#40E0D0>".$player -> user."</font>";
        } else {
            $starter = $player -> user;
        }
        $czat = $db -> Execute("SELECT gracz FROM lolthkosciolconfig");
        while (!$czat -> EOF) {
            if ($player -> id == $czat -> fields['gracz']) {
                error ("Nie mozesz pisac wiadomosci w Kosciele Lolth");
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
            if ($test == "Niewolniku ".$item." dla " && ereg("^[1-9][0-9]*$", $id)) {
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
        $db -> Execute("INSERT INTO lolthkosciol (user, chat, senderid,ownerid) VALUES('".$starter."', '".$message."',".$player -> id.",".$owner.")");
        for ($i = 0; $i < 8; $i++) {
            $empty = 0;
            if ($test == "Niewolniku ".$arritems[$i]." dla "){
                $id = substr($_POST['msg'],20);
                if ($id == 'wszystkich!') {
                           $db -> Execute("INSERT INTO lolthkosciol (user, chat) VALUES('<i>Niewolnik</i>', 'Uwaga! ".$player -> user." stawia wszystkim ".$arritems[$i]."!')");
                       }
                if (ereg("^[1-9][0-9]*$", $id)) {
                    $db -> Execute("INSERT INTO lolthkosciol (user, chat) VALUES('<i>Niewolnik</i>', 'Prosze ".$user -> fields['user']." oto ".$arritems[$i]." od ".$player -> user."')");
                }
                break;
            } elseif ($checkbot == "Niewolniku") {
                $empty = 1;
            }
        }
        if ($_POST['msg'] == 'Niewolniku jakies wiesci?') {
            $empty = 0;
            $query = $db -> Execute("SELECT id FROM events");
            $number = $query -> RecordCount();
            $query -> Close();
            if ($number > 0) {
                $roll = rand (1,$number);
                $event = $db -> Execute("SELECT text FROM events WHERE id=".$roll);
                $text = "Oczywiscie! ".$event -> fields['text'];
                $db -> Execute("INSERT INTO lolthkosciol (user, chat) VALUES('<i>Niewolnik</i>', '".$text."')");
            } else {
                $db -> Execute("INSERT INTO lolthkosciol (user, chat) VALUES('<i>Niewolnik</i>', 'Niestety nic ciekawego sie nie wydarzylo')");
            }
        }
        if ($_POST['msg'] == 'Ochroniarzu jakis problem?') {
            $empty = 0;
            $query = $db -> Execute("SELECT id FROM events");
            $number = $query -> RecordCount();
            $query -> Close();
            if ($number > 0) {
                $roll = rand (1,$number);
                $db -> Execute("INSERT INTO lolthkosciol (user, chat) VALUES('<i>Ochroniaz</i>', 'Nie niema zadnego, tak patrze na twoja bron i sie boje')");
            }
        }
        if ($empty == 1) {
            $arrtext = array ('Nie rozumiem', 'Ochrona!, pokaz temu klientowi drzwi!', 'Hmm w jakim to jezyku?', 'Pytania sa tendencyjne', 'Do mnie mowisz?');
            $roll = rand (0, 4);
            $db -> Execute("INSERT INTO lolthkosciol (user, chat) VALUES('<i>Karczmarz</i>', '".$arrtext[$roll]."')");
        }
    }
}

$query = $db -> Execute("SELECT id FROM lolthkosciol");
$numchat = $query -> RecordCount();
$query -> Close();
$smarty -> assign ("Number", $numchat);
$smarty -> display ('lolthkosciol.tpl');

require_once("includes/foot.php");
?>
