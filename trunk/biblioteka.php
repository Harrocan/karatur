<?php
//@type: F
//@desc: Biblioteka Trzech Magów
/*  
*	Biblioteka KT, nowa. 
*	Robi wszystko to co poprzednia i jeszcze troche.
*	Biblioteka jest dosyæ elastyczna, a przede wszystkim 
*	bardziej przejrzysta z nowym Layout'em
*	(C) 2006-2007 Kara-Tur Team based on Vallheru Team
--------
*/
/*
//@Autor	: windu <windu83@wp.pl>
//@ID	 	: 2888
--------
*/

$title = "Biblioteka Trzech Magów";
require_once("includes/head.php");

checklocation($_SERVER['SCRIPT_NAME']);

if ($player -> przemiana > 0) {
error ("Musisz powrocic z Besti w czlowieka aby tutaj przebywac!"); 
}
$rank_li = getRank('library');
/**
* Dodawanie tekstu
*/
if (isset($_GET['step']) && $_GET['step'] == 'add')
{

    $arrType = array("Opowiadanie", "Poezja");
    if (isset($_GET['step2']))
    {
        if (!in_array($_POST['type'], $arrType))
        {
            error(ERROR);
        }
        if (empty($_POST['title']) || empty($_POST['body']))
        {
            error("Puste Pola!!!!");
        }
        if ($_POST['type'] == "Opowiadanie")
        {
            $strType = 'tale';
        }
        if ($_POST['type'] == "Poezja")
        {
            $strType = 'poetry';
        }
        SqlExec("INSERT INTO library (title, body, type, author, aid) VALUES('".$_POST['title']."', '".$_POST['body']."', '".$strType."', '{$player->user}', '{$player->id}')");
        error("Twoj utwor zostal dodany poczekaj na zatwierdzenie","done");
    }
}
/*
* Dodawanie usuwanie komentarza
*/
if((isset($_GET['step'])) && ($_GET['step']=="addcom")){
	if(!empty($_POST['body'])){
		SqlExec("INSERT INTO lib_comments (textid, author, body, acid) VALUES('".$_POST['cid']."', '".$player->user."', '".$_POST['body']."', '".$player->id."')");
		error("Dodano Komentarz","done");
	}
	else{
		error("Puste Pola!");
	}
}
if((isset($_GET['step'])) && ($_GET['step']=="usun")){
	if ((!$rank_li) && ($_POST['aid'] != $player -> id)){
		error("Spieprzaj dziadu!!!");
	}
	SqlExec("DELETE FROM lib_comments WHERE id='".$_GET['com']."'");
	error("Usuniete");
}
if((!isset($_GET['step']))){
	$_GET['step']='';
}
/**
* Przekazywanie zmiennych tekstu do czytania i edycji
*/
if (isset($_GET['text']))
{
    if (!ereg("^[1-9][0-9]*$", $_GET['text']))
    {
        error(ERROR);
    }
    $objText1 = SqlExec("SELECT id, title, author, body, type, aid FROM library WHERE id=".$_GET['text']);
    $objText = $objText1 -> GetArray();
    if(!isset($_GET['action'])){
    	require_once('includes/bbcode.php');
    	 $coss = bbcodetohtml($objText[0]['body']);
    	 $objText[0]['body'] = $coss;
    }
    $smarty -> assign( array("Tekst" => $objText[0],
    	"Player" => $player -> id));
    if(!isset($_GET['action'])){
	    /*
	    G³osowanie
	    */
	    $title = "";
	    $title = "{$objText[0]['id']}";
	    if($title == ''){ error("Nie wybra³eœ pracy na któr¹ zag³osujesz...lipa");}
	    $perm = SqlExec("SELECT vid FROM library_vote WHERE pid={$player -> id} AND vid={$title} ");
	    $permm = $perm -> GetArray();
	    if(!isset($permm[0]['vid'])){
	    	$vote = 'N';
	    }
	    else{
	    	$points = SqlExec("SELECT vote FROM library WHERE id={$title}"); 
	    	$vote = 'T';
	    	$smarty -> assign("Points", $points -> fields['vote']);
	    }
	    $smarty -> assign("Vote", $vote);
	    /*
	    * Wyswietalnie Komentarzy
	    */
	    $Comm1 = SqlExec("SELECT id, author, body, acid FROM lib_comments WHERE textid=".$_GET['text']);
	    $arrComments = $Comm1 -> RecordCount();
	    $Comm = $Comm1 -> GetArray();
	    $smarty -> assign(array("Comm" => $Comm,
	    "TComments" => $arrComments));
    }
}
else{
	$_GET['text']='';
}
/*
G³osujesz
*/
if ((isset($_GET['action'])) && ($_GET['action']=="vote")){
	if((isset($_POST['text'])) && (isset($_POST['vote']))){
		$perm = SqlExec("SELECT vid FROM library_vote WHERE pid={$player -> id} AND vid=".$_POST['text']);
	    $permm = $perm -> GetArray();
	    if(isset($permm[0]['vid'])){error("Ju¿ zag³osowa³eœ a teraz spadaj, skryba nie ma tyle czasu dla ciebie");}
		SqlExec("INSERT INTO library_vote(pid, vid, vote) VALUES({$player -> id}, ".$_POST['text'].", ".$_POST['vote'].")");
		$var = SqlExec("SELECT vote FROM library_vote WHERE vid=".$_POST['text']);
		$vary = $var -> GetArray();
		$i = 0;
		$sum = 0;
		foreach($vary as $obj){
			$sum = $sum + $obj['vote'];
			$i++;
		}
		$vote = round($sum/$i,2);
		SqlExec("UPDATE library SET `vote`={$vote}, `count`={$i} WHERE id=".$_POST['text']);
		error("Dobra ocena dla tej pracy, brawo!", "done");
	}
}
/*
Modyfikacja prac
*/
if ((isset($_GET['action'])) && ($_GET['action']=="modify")){
	$_GET['text']='';
	if (isset($_POST['mod'])){
		if (!$rank_li){
			error("Spieprzaj dziadu!!!");
			}
		if ($_POST['mod']=="Usun Prace"){
			SqlExec("DELETE FROM library WHERE id=".$_POST['id']);
			SqlExec("DELETE FROM lib_comments WHERE textid=".$_POST['id']);
		}
		else{
	        if (empty($_POST['title']) || empty($_POST['body'])){
	            error("Puste Pola!!!");
	        }
	        if ($_POST['type'] == "Opowiadanie"){
	            $strType = 'tale';
	        }
	        if ($_POST['type'] == "Poezja"){
	            $strType = 'poetry';
	        }
			if (($_POST['mod']=="Modyfikuj") || ($_POST['mod']=="Modyfikuj i Dodaj")){
				SqlExec("UPDATE library SET type='".$_POST['type']."',title='".$_POST['title']."',body='".$_POST['body']."' WHERE id='".$_POST['id']."'");
			}
			if ($_POST['mod']=="Modyfikuj i Dodaj"){
				SqlExec("UPDATE library SET added='Y' WHERE id='".$_POST['id']."'");
			}
		}
		$_GET['action']='';
		error($_POST['mod']." - pomyslnie wykonane!!!");
	}
}
else{
	$_GET['action']='';
}
/*
Menu Poczatkowe
*/
if(($_GET['step']=='') && ($_GET['text']=='') && ($_GET['action']=='')){
	$tab = array("tale", "poetry");
	$data = array();
	foreach ($tab as $rodz){
		$obj = SqlExec("SELECT author, id, title, aid FROM library WHERE added='Y' AND  type='{$rodz}' ORDER BY author");
		$obj1 = $obj -> GetArray();
		$data[] = $obj1;
	}
	$smarty -> assign( array(
		"Data" => $data,
        "Type" => array("Opowiadania", "Poezje")
        ));
	/*
	Menu Poczatkowe(Bibliotekarz)
	*/
	if($rank_li){
		    $objText1 = SqlExec("SELECT id, title FROM library WHERE added='N'");
		    $objText = $objText1 -> GetArray();
		    $smarty -> assign("Bibl", $objText);
		    $objText1 -> Close();
	}
	//News
	$news = SqlExec("SELECT title, id FROM library ORDER BY id DESC LIMIT 3");
	$newss = $news -> GetArray();
	$lastcom = SqlExec("SELECT a.author, b.title, b.id FROM lib_comments as a JOIN library as b WHERE a.textid = b.id ORDER BY a.id DESC LIMIT 5");
	$lastcom1 = $lastcom -> GetArray();
	$best = SqlExec("SELECT id, title, author, vote, count FROM library ORDER BY vote DESC, count DESC LIMIT 5");
	$bests = $best -> GetArray();
	$smarty -> assign(array("News" => $newss, "Lastcom" => $lastcom1, "Best" => $bests));
}
$smarty -> assign(array(
    "Step" => $_GET['step'],
    "Action" => $_GET['action'],
    "Text" => $_GET['text'],
	"Rank" => $rank_li));
$smarty -> display('biblioteka.tpl');
require_once("includes/foot.php");
?>