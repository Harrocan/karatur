<?php
//@type: F
//@desc: Gazeta
$title = "Redakcja gazety";
require_once("includes/head.php");

error( "Chcesz przylaczyc sie do gazety ? - napisz to nam !" );

/**
* Get the localization for game
*/
require_once("languages/pl/newspaper.php");


// wpisz swoje miasto
checklocation($_SERVER['SCRIPT_NAME']);

/**
* Assign variables to template
*/
$smarty -> assign(array("Message" => '', 
    "Aedit" => '', 
    "Apublic" => A_PUBLIC));

/**
* Main menu
*/
if (!isset($_GET['comments']) && !isset($_GET['step']) && !isset($_GET['read']))
{
    $smarty -> assign(array("Paperinfo" => PAPERINFO,
        "Paperinfo2" => PAPERINFO2,
        "Paperinfo3" => PAPERINFO3,
        "Anewpaper" => A_NEW_PAPER,
        "Aarchive" => A_ARCHIVE,
        "Aredaction" => A_REDACTION,
        "Aredmail" => A_RED_MAIL));
}

/**
* Read and edit newspaper
*/
if ((isset($_GET['step']) && $_GET['step'] == 'new') || (isset($_GET['read']) || (isset($_GET['step3']) && $_GET['step3'] == 'S')))
{
    if (isset($_GET['read']) && !ereg("^[1-9][0-9]*$", $_GET['read']))
    {
        error(ERROR);
    }
    if (isset($_GET['step3']))
    {
        if ($player -> rank != 'Redaktor' && $player -> rank != 'Admin' && $player -> rank != 'Redaktor Naczelny')
        {
            error(NO_PERM);
        }
    }
    if (isset($_GET['step2']))
    {
        $arrTest = array('N', 'M', 'O', 'R', 'K', 'C', 'S', 'H', 'I', 'A', 'P');
        if (!in_array($_GET['step2'], $arrTest))
        {
            error(ERROR);
        }
        if (isset($_GET['step']))
        {
            $objPaperid = $db -> Execute("SELECT paper_id FROM newspaper WHERE added='Y' GROUP BY paper_id DESC");
            $objArticles = $db -> Execute("SELECT title, author, id, body FROM newspaper WHERE paper_id=".$objPaperid -> fields['paper_id']." AND type='".$_GET['step2']."' AND added='Y'");
            $objPaperid -> Close();
        }
            elseif (isset($_GET['read']))
        {
            $objArticles = $db -> Execute("SELECT title, author, id, body FROM newspaper WHERE paper_id=".$_GET['read']." AND type='".$_GET['step2']."' AND added='Y'");
        }
            else
        {
            $objArticles = $db -> Execute("SELECT title, author, id, body FROM newspaper WHERE type='".$_GET['step2']."' AND added='N'");
            $smarty -> assign(array("Aedit" => A_EDIT,
                "Adelete" => A_DELETE));
        }
        $arrId = array();
        $arrTitle = array();
        $arrAuthor = array();
        $arrBody = array();
        $arrComments = array();
        $i = 0;
        if (!$objArticles -> fields['id'] && $_GET['step3'] != 'S')
        {
            error(NO_PAPER);
        }
        while (!$objArticles -> EOF)
        {
            $objQuery = $db -> Execute("SELECT id FROM newspaper_comments WHERE textid=".$objArticles -> fields['id']);
            $arrComments[$i] = $objQuery -> RecordCount();
            $objQuery -> Close();
            $arrId[$i] = $objArticles -> fields['id'];
            $arrTitle[$i] = $objArticles -> fields['title'];
            $arrAuthor[$i] = $objArticles -> fields['author'];
            $arrBody[$i] = $objArticles -> fields['body'];
            $i ++;
            $objArticles -> MoveNext();
        }
        $objArticles -> Close();
        $smarty -> assign(array("Artid" => $arrId,
            "Arttitle" => $arrTitle,
            "Artauthor" => $arrAuthor,
            "Artbody" => $arrBody,
            "Artcomments" => $arrComments));
    }
    if (isset($_GET['step']) && $_GET['step'] == 'new')
    {
        $smarty -> assign("Newslink", "step=new");
    }
        elseif (isset($_GET['read']))
    {
        $smarty -> assign("Newslink", "read=".$_GET['read']);
    }
        else
    {
        $smarty -> assign("Newslink", "step3=S");
    }
    $smarty -> assign(array("Anews" => A_NEWS,
        "Anews2" => A_NEWS2,
        "Anews3" => A_NEWS3,
        "Acourt" => A_COURT,
        "Aroyal" => A_ROYAL,
        "Aking" => A_KING,
        "Achronicle" => A_CHRONICLE,
        "Asensations" => A_SENSATIONS,
        "Ahumor" => A_HUMOR,
        "Ainter" => A_INTER,
        "Apoetry" => A_POETRY,
        "Readinfo" => READINFO,
        "Acomment" => A_COMMENT,
        "Twrite" => T_WRITE,
        "Tcomments" => T_COMMENTS));
}

/**
* Newspaper archive
*/
if (isset($_GET['step']) && $_GET['step'] == 'archive')
{
    $objPaperid = $db -> Execute("SELECT paper_id FROM newspaper WHERE added='Y' GROUP BY paper_id DESC");
    if (!$objPaperid -> fields['paper_id'])
    {
        error(EMPTY_ARCHIVE);
    }
    $objPaperid2 = $db -> Execute("SELECT paper_id FROM newspaper WHERE paper_id<".$objPaperid -> fields['paper_id']." AND paper_id!=0 GROUP BY paper_id");
    $objPaperid -> Close();
    $arrPaperid = array();
    $i = 0;
    while (!$objPaperid2 -> EOF)
    {
        $arrPaperid[$i] = $objPaperid2 -> fields['paper_id'];
        $i ++;
        $objPaperid2 -> MoveNext();
    }
    $objPaperid2 -> Close();
    $smarty -> assign(array("Paperid" => $arrPaperid,
        "Anumber" => A_NUMBER,
        "Archiveinfo" => ARCHIVEINFO));
}

/**
* Comments to text
*/
if (isset($_GET['comments']))
{
    $smarty -> assign("Amount", '');
    
    /**
    * Display comments
    */
    if (!isset($_GET['action']))
    {
        if (!ereg("^[1-9][0-9]*$", $_GET['comments']))
        {
            error(ERROR);
        }
        $objText = $db -> Execute("SELECT id FROM newspaper WHERE id=".$_GET['comments']." AND added='Y'");
        if (!$objText -> fields['id'])
        {
            error(NO_TEXT);
        }
        $objText -> Close();
        $objComments = $db -> Execute("SELECT id, body, author FROM newspaper_comments WHERE textid=".$_GET['comments']);
        $arrBody = array();
        $arrAuthor = array();
        $arrId = array();
        $i = 0;
        while (!$objComments -> EOF)
        {
            $arrBody[$i] = $objComments -> fields['body'];
            $arrAuthor[$i] = $objComments -> fields['author'];
            $arrId[$i] = $objComments -> fields['id'];
            $i = $i + 1;
            $objComments -> MoveNext();
        }
        $objComments -> Close();
        $smarty -> assign(array("Tauthor" => $arrAuthor,
            "Tbody" => $arrBody,
            "Amount" => $i,
            "Cid" => $arrId,
            "Nocomments" => NO_COMMENTS,
            "Addcomment" => ADD_COMMENT,
            "Adelete" => A_DELETE,
            "Aadd" => A_ADD,
            "Wrote" => WROTE));
    }

    /**
    * Add comment
    */
    if (isset($_GET['action']) && $_GET['action'] == 'add')
    {
        $strBody = strip_tags($_POST['body']);
        if (empty($strBody))
        {
            error(EMPTY_FIELDS);
        }
        if (!ereg("^[1-9][0-9]*$", $_POST['tid']))
        {
            error(ERROR);
        }
        $strAuthor = $player -> user." ID: ".$player -> id; 
        $db -> Execute("INSERT INTO newspaper_comments (textid, author, body) VALUES(".$_POST['tid'].", '".$strAuthor."', '".$strBody."')");
        error(C_ADDED);
    }

    /**
    * Delete comment
    */
    if (isset($_GET['action']) && $_GET['action'] == 'delete')
    {
        if ($player -> rank != 'Redaktor' && $player -> rank != 'Admin' && $player -> rank != 'Redaktor Naczelny')
        {
            error(NO_PERM);
        }
        if (!ereg("^[1-9][0-9]*$", $_GET['cid']))
        {
            error(ERROR);
        }
        $db -> Execute("DELETE FROM newspaper_comments WHERE id=".$_GET['cid']);
        error(C_DELETED);
    }
}

/**
* Newspaper redaction
*/
if (isset($_GET['step']) && $_GET['step'] == 'redaction')
{
    if ($player -> rank != 'Admin' && $player -> rank != 'Redaktor' && $player -> rank != 'Redaktor Naczelny')
    {
        error(NO_PERM);
    }
    $smarty -> assign(array("Redactioninfo" => REDACTIONINFO,
        "Ashow" => A_SHOW,
        "Aredaction" => A_REDACTION));

    /**
    * Edit article
    */
    if (isset($_GET['step3']) && ($_GET['step3'] == 'edit' || $_GET['step3'] == 'R'))
    {
        if (isset($_GET['edit']) && !ereg("^[1-9][0-9]*$", $_GET['edit']))
        {
            error(ERROR);
        }
        $smarty -> assign(array("Anews" => A_NEWS,
            "Anews2" => A_NEWS2,
            "Anews3" => A_NEWS3,
            "Acourt" => A_COURT,
            "Aroyal" => A_ROYAL,
            "Aking" => A_KING,
            "Achronicle" => A_CHRONICLE,
            "Asensations" => A_SENSATIONS,
            "Ahumor" => A_HUMOR,
            "Ainter" => A_INTER,
            "Apoetry" => A_POETRY,
            "Ttitle" => T_TITLE,
            "Tbody" => T_BODY,
            "Mailinfo" => MAILINFO,
            "Mailtype" => MAIL_TYPE,
            "Ashow" => A_SHOW2,
            "Asend" => A_SEND,
            "Showmail" => '',
            "Mtitle" => '',
            "Mbody" => '',
            "Mtype" => '',
            "Edit" => $_GET['edit'],
            "Youedit" => YOU_EDIT));
        if ($_GET['step3'] == 'edit')
        {
            $objArticle = $db -> Execute("SELECT title, type, body FROM newspaper WHERE id=".$_GET['edit']);
            $smarty -> assign(array("Mtitle" => $objArticle -> fields['title'],
                "Mbody" => $objArticle -> fields['body'],
                "Mtype" => $objArticle -> fields['type']));
            $objArticle -> Close();
        }
        if (isset($_POST['show']))
        {
            $arrType = array('M', 'N', 'O', 'R', 'K', 'C', 'S', 'H', 'I', 'A', 'P');
            if (!in_array($_POST['mail'], $arrType))
            {
                error(ERROR);
            }
            if (empty($_POST['mtitle']) || empty($_POST['mbody']))
            {
                error(EMPTY_FIELDS);
            }
            $_POST['mbody'] = nl2br($_POST['mbody']);
            require_once('includes/bbcode.php');
            $_POST['mbody'] = bbcodetohtml($_POST['mbody']);
            $_POST['mtitle'] = bbcodetohtml($_POST['mtitle']);
            $strMail = T_TITLE." ".$_POST['mtitle']."<br />".T_BODY." <br />".$_POST['mbody'];
            $_POST['mbody'] = htmltobbcode($_POST['mbody']);
            $_POST['mtitle'] = htmltobbcode($_POST['mtitle']);
            $smarty -> assign(array("Showmail" => $strMail,
                "Mtitle" => $_POST['mtitle'],
                "Mbody" => $_POST['mbody'],
                "Mtype" => $_POST['mail']));
        }
        if (isset($_POST['sendmail']))
        {
            $arrType = array('M', 'N', 'O', 'R', 'K', 'C', 'S', 'H', 'I', 'A', 'P');
            if (!in_array($_POST['mail'], $arrType))
            {
                error(ERROR);
            }
            if (empty($_POST['mtitle']) || empty($_POST['mbody']))
            {
                error(EMPTY_FIELDS);
            }
            $_POST['mbody'] = nl2br($_POST['mbody']);
            require_once('includes/bbcode.php');
            $_POST['mbody'] = bbcodetohtml($_POST['mbody']);
            $_POST['mtitle'] = bbcodetohtml($_POST['mtitle']);
            $strAuthor = $player -> user." ID: ".$player -> id;
            $_POST['mbody'] = $_POST['mbody']."<br /><br />".EDITED_BY.$strAuthor;
            if ($_GET['step3'] == 'edit')
            {
                $db -> Execute("UPDATE newspaper SET title='".$_POST['mtitle']."', body='".$_POST['mbody']."', type='".$_POST['mail']."' WHERE id=".$_GET['edit']);
            }
                else
            {
                $strAuthor = $player -> user." ID: ".$player -> id;
                $objPaperid = $db -> Execute("SELECT paper_id FROM newspaper WHERE added='Y' GROUP BY paper_id DESC");
                $intPaperid = $objPaperid -> fields['paper_id'] + 1;
                $objPaperid -> Close();
                $db -> Execute("INSERT INTO newspaper (paper_id, title, body, author, added, type) VALUES(".$intPaperid.", '".$_POST['mtitle']."', '".$_POST['mbody']."', '".$strAuthor."', 'N', '".$_POST['mail']."')");
            }
            $smarty -> assign("Message", "<br /><br />".MAIL_SEND);
        }
    }

    /**
    * Release new newspaper
    */
    if (isset($_GET['step3']) && $_GET['step3'] == 'release')
    {
        $db -> Execute("UPDATE newspaper SET added='Y' WHERE added='N'");
        $smarty -> assign("Message", "<br /><br />".NEWSPAPER_RELEASED);
    }

    /**
    * Delete selected article
    */
    if (isset($_GET['step3']) && $_GET['step3'] == 'delete')
    {
        $db -> Execute("DELETE FROM newspaper WHERE id=".$_GET['del']);
        $smarty -> assign("Message", "<br /><br />".ARTICLE_DELETED);
    }
}

/**
* Newspaper mail
*/
if (isset($_GET['step']) && $_GET['step'] == 'mail')
{
    $smarty -> assign(array("Anews" => A_NEWS,
        "Anews2" => A_NEWS2,
        "Anews3" => A_NEWS3,
        "Acourt" => A_COURT,
        "Aroyal" => A_ROYAL,
        "Aking" => A_KING,
        "Achronicle" => A_CHRONICLE,
        "Asensations" => A_SENSATIONS,
        "Ahumor" => A_HUMOR,
        "Ainter" => A_INTER,
        "Apoetry" => A_POETRY,
        "Ttitle" => T_TITLE,
        "Tbody" => T_BODY,
        "Mailinfo" => MAILINFO,
        "Mailtype" => MAIL_TYPE,
        "Ashow" => A_SHOW,
        "Asend" => A_SEND,
        "Showmail" => '',
        "Mtitle" => '',
        "Mbody" => '',
        "Mtype" => ''));
    if (isset($_GET['step3']) && $_GET['step3'] == 'add')
    {
        $arrType = array('M', 'N', 'O', 'R', 'K', 'C', 'S', 'H', 'I', 'A', 'P');
        if (!in_array($_POST['mail'], $arrType))
        {
            error(ERROR);
        }
        if (empty($_POST['mtitle']) || empty($_POST['mbody']))
        {
            error(EMPTY_FIELDS);
        }
        $_POST['mbody'] = nl2br($_POST['mbody']);
        require_once('includes/bbcode.php');
        $_POST['mbody'] = bbcodetohtml($_POST['mbody']);
        $_POST['mtitle'] = bbcodetohtml($_POST['mtitle']);
        if (isset($_POST['show']))
        {
            $strMail = T_TITLE." ".$_POST['mtitle']."<br />".T_BODY." <br />".$_POST['mbody'];
            $_POST['mbody'] = htmltobbcode($_POST['mbody']);
            $_POST['mtitle'] = htmltobbcode($_POST['mtitle']);
            $smarty -> assign(array("Showmail" => $strMail,
                "Mtitle" => $_POST['mtitle'],
                "Mbody" => $_POST['mbody'],
                "Mtype" => $_POST['mail']));
        }
        if (isset($_POST['sendmail']))
        {
            $strAuthor = $player -> user." ID: ".$player -> id;
            $objPaperid = $db -> Execute("SELECT paper_id FROM newspaper WHERE added='Y' GROUP BY paper_id DESC");
            $intPaperid = $objPaperid -> fields['paper_id'] + 1;
            $objPaperid -> Close();
            $db -> Execute("INSERT INTO newspaper (paper_id, title, body, author, added, type) VALUES(".$intPaperid.", '".$_POST['mtitle']."', '".$_POST['mbody']."', '".$strAuthor."', 'N', '".$_POST['mail']."')");
            $smarty -> assign("Message", "<br /><br />".MAIL_SEND);
        }
    }
}

/**
* Initialization of variables
*/
if (!isset($_GET['step']))
{
    $_GET['step'] = '';
}
if (!isset($_GET['step2']))
{
    $_GET['step2'] = '';
}
if (!isset($_GET['read']))
{
    $_GET['read'] = '';
}
if (!isset($_GET['comments']))
{
    $_GET['comments'] = '';
}
if (!isset($_GET['step3']))
{
    $_GET['step3'] = '';
}

/**
* Assign variables to template and display page
*/
$smarty -> assign(array("Step" => $_GET['step'],
    "Step2" => $_GET['step2'],
    "Read" => $_GET['read'],
    "Comments" => $_GET['comments'],
    "Rank" => $player -> rank,
    "Aback" => A_BACK,
    "Step3" => $_GET['step3']));
$smarty -> display('newspaper.tpl');

require_once("includes/foot.php");
?>
