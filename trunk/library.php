<?php
//@type: F
//@desc: Biblioteka miejska
/**
 *   File functions:
 *   Library with players texts
 *
 *   @name                 : library.php                            
 *   @copyright            : (C) 2004-2005 Vallheru Team based on Gamers-Fusion ver 2.5
 *   @author               : thindil <thindil@users.sourceforge.net>
 *   @version              : 0.8 beta
 *   @since                : 28.05.2005
 *
 */

//
//
//       This program is free software; you can redistribute it and/or modify
//   it under the terms of the GNU General Public License as published by
//   the Free Software Foundation; either version 2 of the License, or
//   (at your option) any later version.
//
//   This program is distributed in the hope that it will be useful,
//   but WITHOUT ANY WARRANTY; without even the implied warranty of
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//   GNU General Public License for more details.
//
//   You should have received a copy of the GNU General Public License
//   along with this program; if not, write to the Free Software
//   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//
// 

$title = "Biblioteka Miejska";
require_once("includes/head.php");

error( "Biblioteka zamknieta !" );

checklocation($_SERVER['SCRIPT_NAME']);

/*if ($player -> location != 'Athkatla' && $player -> location != 'Iriaebor') 
{
    error ("Nieznajdujesz sie w miescie");
}
*/
if ($player -> przemiana > 0) {

error ("Musisz powrocic z Besti w czlowieka aby tutaj przebywac!"); 

}

/**
* Main menu
*/
if (!isset($_GET['step']))
{
    $objQuery = $db -> Execute("SELECT id FROM library WHERE added='N'");
    $intTextnot = $objQuery -> RecordCount();
    $objQuery = $db -> Execute("SELECT id FROM library WHERE added='Y'");
    $intTextin = $objQuery -> RecordCount();
    $objQuery = $db -> Execute("SELECT id FROM library WHERE type='tale' AND added='Y'");
    $intTales = $objQuery -> RecordCount();
    $objQuery = $db -> Execute("SELECT id FROM library WHERE type='poetry' AND added='Y'");
    $intPoetry = $objQuery -> RecordCount();
    $objQuery -> Close();
    
    $smarty -> assign(array("Atextnot" => $intTextnot,
        "Atextin" => $intTextin,
        "Amounttales" => $intTales,
        "Amountpoetry" => $intPoetry,
        "Atales" => Opowiadania,
        "Apoetry" => Poezje,
        "Tinfo1" => prac,
        "Tinfo2" => prac,
        "Aaddtext" => "Dodaj Prace",
        "Aadmin" => Bibliotekarz,
        "Arules" => Zasady));
}
    else
{
    $smarty -> assign("Aback", Wroc);
}

/**
* Add text to library (simple user)
*/
if (isset($_GET['step']) && $_GET['step'] == 'add')
{

    $arrType = array(Opowiadania, Poezje);
    $smarty -> assign(array("Ttype" => $arrType,
        "Ttype2" => Rodzaj,
        "Ttitle2" => Tytul,
        "Tbody2" => Zawartosc,
        "Aadd" => Dodaj,
        "Addinfo" => "Tutaj mozesz oddac swoja prace"));

    if (isset($_GET['step2']))
    {
        if (!in_array($_POST['type'], $arrType))
        {
            error(ERROR);
        }
        if (empty($_POST['ttitle']) || empty($_POST['body']))
        {
            error(EMPTY_FIELDS);
        }
        if ($_POST['type'] == Opowiadania)
        {
            $strType = 'tale';
        }
        if ($_POST['type'] == Poezje)
        {
            $strType = 'poetry';
        }
        $_POST['body'] = nl2br($_POST['body']);
        require_once('includes/bbcode.php');
        $_POST['body'] = bbcodetohtml($_POST['body']);
        $strAuthor = $player -> user." ID: ".$player -> id;
        $db -> Execute("INSERT INTO library (title, body, type, author) VALUES('".$_POST['ttitle']."', '".$_POST['body']."', '".$strType."', '".$strAuthor."')");
        error("Twoj utwor zostal dodany poczekaj na zatwierdzenie");
    }
}

/**
* Add text to library (librarian)
*/
if (isset($_GET['step']) && $_GET['step'] == 'addtext')
{
    if ($player -> rank != 'Bibliotekarz' && $player -> rank != 'Admin')
    {
        error("Brak dostepu");
    }
    $objText = $db -> Execute("SELECT id, title, author FROM library WHERE added='N'");
    $arrId = array();
    $arrTitle = array();
    $arrAuthor = array();
    $i = 0;
    while (!$objText -> EOF)
    {
        $arrId[$i] = $objText -> fields['id'];
        $arrTitle[$i] = $objText -> fields['title'];
        $arrAuthor[$i] = $objText -> fields['author'];
        $i = $i + 1;
        $objText -> MoveNext();
    }
    $objText -> Close();
    $smarty -> assign(array("Ttitle" => $arrTitle,
        "Tid" => $arrId,
        "Tauthor" => $arrAuthor,
        "Admininfo" => Zarzadzanie,
        "Admininfo2" => Zarzadzanie,
        "Admininfo3" => Zarzadzanie,
        "Admininfo4" => Zarzadzanie,
        "Admininfo5" => Zarzadzanie,
        "Tauthor2" => Autor,
        "Amodify" => Modyfikuj,
        "Aadd" => Dodaj,
        "Adelete" => Wykasuj));
    /**
    * Modify text
    */
    if (isset($_GET['action']) && $_GET['action'] == 'modify')
    {
        if (!ereg("^[1-9][0-9]*$", $_GET['text']))
        {
            error(ERROR);
        }
        $objText = $db -> Execute("SELECT id, title, body, type FROM library WHERE id=".$_GET['text']);
        $smarty -> assign(array("Ttitle" => $objText -> fields['title'],
            "Tbody" => $objText -> fields['body'],
            "Ttype" => $objText -> fields['type'],
            "Tid" => $objText -> fields['id'],
            "Ttitle2" => Tytul,
            "Tbody2" => Tresc,
            "Ttype2" => Typ,
            "Achange" => Zmien,
            "Ttypet" => Opowiadania,
            "Ttypep" => Poezje));
        $objText -> Close();
        if (isset($_POST['tid']))
        {
            if (!ereg("^[1-9][0-9]*$", $_POST['tid']))
            {
                error(ERROR);
            }
            if (empty($_POST['ttitle']) || empty($_POST['body']))
            {
                error("Puste pola");
            }
            if ($_POST['type'] == Opowiadania)
            {
                $strType = 'tale';
            }
            if ($_POST['type'] == Poezje)
            {
                $strType = 'poetry';
            }
            $_POST['body'] = nl2br($_POST['body']);
            require_once('includes/bbcode.php');
            $_POST['body'] = bbcodetohtml($_POST['body']);
            $db -> Execute("UPDATE library SET title='".$_POST['ttitle']."', body='".$_POST['body']."', type='".$strType."' WHERE id=".$_POST['tid']);
            error (Zmodyfikowany);
        }
    }
    /**
    * Add or delete texts in library
    */
    if (isset($_GET['action']) && ($_GET['action'] == 'add' || $_GET['action'] == 'delete'))
    {
        if (!ereg("^[1-9][0-9]*$", $_GET['text']))
        {
            error(ERROR);
        }
        $objText = $db -> Execute("SELECT id FROM library WHERE id=".$_GET['text']);
        if (!$objText -> fields['id'])
        {
            error("Wpisz text");
        }
        $objText -> Close();
        if ($_GET['action'] == 'add')
        {
            $db -> Execute("UPDATE library SET added='Y' WHERE id=".$_GET['text']);
            error(Dodane);
        }
            else
        {
            $db -> Execute("DELETE FROM library WHERE id=".$_GET['text']);
            error(Usuniete);
        }
    }
}

/**
* Display texts in library
*/
if (isset($_GET['step']) && ($_GET['step'] == 'tales' || $_GET['step'] == 'poetry'))
{
    if ($_GET['step'] == 'tales')
    {
        $strType = 'tale';
        $strInfo = Opowiadan;
    }
    if ($_GET['step'] == 'poetry')
    {
        $strType = 'poetry';
        $strInfo = Wierszy;
    }
    $objQuery = $db -> Execute("SELECT id FROM library WHERE added='Y' AND type='".$strType."'");
    $intAmount = $objQuery -> RecordCount();
    $objQuery -> Close();
    $smarty -> assign(array("Tamount" => $intAmount,
        "Listinfo" => Lista,
        "Ttype" => $strInfo,
        "Noitems" => Brak,
        "Tauthor2" => Autor,
        "Ttitle2" => Tytul,
        "Tbody2" => Tresc,
        "Inlib" => "w bibliotece",
        "Sortinfo" => Sortuj,
        "Asort" => Sortuj,
        "Oauthor" => Autor,
        "Otitle" => Tytul,
        "Odate" => Data));
    /**
    * Display sorted texts
    */
    if (isset($_POST['sort']) && $_POST['sort'] != 'author')
    {
        $arrSort = array('title', 'id');
        if (!in_array($_POST['sort'], $arrSort))
        {
            error(ERROR);
        }
        $arrTitle = array();
        $arrAuthor = array();
        $arrId = array();
        $arrPid = array();
        $arrComments = array();
        $i = 0;
        $objList = $db -> Execute("SELECT id, title, author FROM library WHERE added='Y' AND type='".$strType."' ORDER BY ".$_POST['sort']." DESC") or error($db -> ErrorMsg());
        while (!$objList -> EOF)
        {
            $arrTitle[$i] = $objList -> fields['title'];
            $arrId[$i] = $objList -> fields['id'];
            $arrAuthor[$i] = $objList -> fields['author'];
            $arrAuthorId = explode(": ", $objList -> fields['author']);
            $arrPid[$i] = $arrAuthorId[1];
            $objQuery = $db -> Execute("SELECT id FROM lib_comments WHERE textid=".$objList -> fields['id']);
            $arrComments[$i] = $objQuery -> RecordCount();
            $objQuery -> Close();
            $i = $i + 1;
            $objList -> MoveNext();
        }
        $objList -> Close();
        $smarty -> assign(array("Tid" => $arrId,
            "Ttitle" => $arrTitle,
            "Tauthor" => $arrAuthor,
            "Tauthorid" => $arrPid,
            "Comments" => $arrComments,
            "Tcomments" => Komentarze));
    }
    /**
    * Display authors list
    */
    if (!isset($_GET['author']) && (!isset($_POST['sort']) || (isset($_POST['sort']) && $_POST['sort'] == 'author')))
    {
        $objAuthor = $db -> Execute("SELECT author FROM library WHERE added='Y' AND type='".$strType."' GROUP BY author");
        $arrAuthor = array();
        $arrTexts = array();
        $arrId = array();
        $i = 0;
        while (!$objAuthor -> EOF)
        {
            $intTest = 0;
            $arrAuthorId = explode(": ", $objAuthor -> fields['author']);
            foreach ($arrId as $intId)
            {
                if ($arrAuthorId[1] == $intId)
                {
                    $intTest = 1;
                    break;
                }
            }
            if (!$intTest)
            {
                $arrAuthor[$i] = $objAuthor -> fields['author'];
                $objQuery2 = $db -> Execute("SELECT id FROM library WHERE author LIKE '%ID: ".$arrAuthorId[1]."' AND added='Y' AND type='".$strType."'") or error($db -> ErrorMsg());
                $arrTexts[$i] = $objQuery2 -> RecordCount();
                $objQuery2 -> Close();
                $arrId[$i] = $arrAuthorId[1];
                $i = $i + 1;
            }
            $objAuthor -> MoveNext();
        }
        $objAuthor -> Close();
        $smarty -> assign(array("Tauthor" => $arrAuthor,
            "Ttexts" => $arrTexts,
            "Tauthorid" => $arrId));
    }
    /**
    * Display texts selected author
    */
    if (isset($_GET['author']))
    {
        if (!ereg("^[1-9][0-9]*$", $_GET['author']))
        {
            error(ERROR);
        }
        $objAuthor = $db -> Execute("SELECT author FROM library WHERE author LIKE '%ID: ".$_GET['author']."' GROUP BY author") or ($db -> ErrorMsg());
        $arrTitle = array();
        $arrAuthor = array();
        $arrId = array();
        $arrPid = array();
        $arrComments = array();
        $i = 0;
        while (!$objAuthor -> EOF)
        {
            $objList = $db -> Execute("SELECT id, title, author FROM library WHERE added='Y' AND type='".$strType."' AND author='".$objAuthor -> fields['author']."' ORDER BY id DESC") or error($db -> ErrorMsg());
            while (!$objList -> EOF)
            {
                $arrTitle[$i] = $objList -> fields['title'];
                $arrId[$i] = $objList -> fields['id'];
                $arrAuthor[$i] = $objList -> fields['author'];
                $arrAuthorId = explode(": ", $objList -> fields['author']);
                $arrPid[$i] = $arrAuthorId[1];
                $objQuery = $db -> Execute("SELECT id FROM lib_comments WHERE textid=".$objList -> fields['id']);
                $arrComments[$i] = $objQuery -> RecordCount();
                $objQuery -> Close();
                $i = $i + 1;
                $objList -> MoveNext();
            }
            $objAuthor -> MoveNext();
        }
        $objAuthor -> Close();
        $objList -> Close();
        $smarty -> assign(array("Tid" => $arrId,
            "Ttitle" => $arrTitle,
            "Tauthor" => $arrAuthor,
            "Tauthorid" => $arrPid,
            "Comments" => $arrComments,
            "Tcomments" => Komentarze));
    }
    /**
    * Display selected text
    */
    if (isset($_GET['text']))
    {
        if (!ereg("^[1-9][0-9]*$", $_GET['text']))
        {
            error(ERROR);
        }
        $objText = $db -> Execute("SELECT id, title, author, body FROM library WHERE id=".$_GET['text']);
        if (!$objText -> fields['id'])
        {
            error("Wpisz text");
        }
        $arrAuthorId = explode(": ", $objText -> fields['author']);
        $smarty -> assign(array("Ttitle" => $objText -> fields['title'],
            "Tauthor" => $objText -> fields['author'],
            "Tbody" => $objText -> fields['body'],
            "Tauthorid" => $arrAuthorId[1],
            "Tid" => $objText -> fields['id'],
            "Tcomments" => Komentarze,
            "Amodify" => Modyfikuj));
    }
}

/**
* Comments to text
*/
if (isset($_GET['step']) && $_GET['step'] == 'comments')
{
    $smarty -> assign("Amount", '');
    
    /**
    * Display comments
    */
    if (!isset($_GET['action']))
    {
        if (!ereg("^[1-9][0-9]*$", $_GET['text']))
        {
            error(ERROR);
        }
        $objText = $db -> Execute("SELECT id FROM library WHERE id=".$_GET['text']." AND added='Y'");
        if (!$objText -> fields['id'])
        {
            error("Wpisz text");
        }
        $objText -> Close();
        $objComments = $db -> Execute("SELECT id, body, author FROM lib_comments WHERE textid=".$_GET['text']);
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
            "Nocomments" => "Brak komentarzy",
            "Addcomment" => "Dodaj komentarz",
            "Adelete" => "Wykasuj",
            "Aadd" => Dodaj));
    }

    /**
    * Add comment
    */
    if (isset($_GET['action']) && $_GET['action'] == 'add')
    {
        $strBody = strip_tags($_POST['body']);
        if (empty($strBody))
        {
            error("Wypelnij pola");
        }
        if (!ereg("^[1-9][0-9]*$", $_POST['tid']))
        {
            error(ERROR);
        }
        $strAuthor = $player -> user." ID: ".$player -> id; 
        $db -> Execute("INSERT INTO lib_comments (textid, author, body) VALUES(".$_POST['tid'].", '".$strAuthor."', '".$strBody."')");
        error("Komentarz dodany");
    }

    /**
    * Delete comment
    */
    if (isset($_GET['action']) && $_GET['action'] == 'delete')
    {
        if ($player -> rank != 'Bibliotekarz' && $player -> rank != 'Admin')
        {
            error("Brak pozwolenia");
        }
        if (!ereg("^[1-9][0-9]*$", $_GET['cid']))
        {
            error(ERROR);
        }
        $db -> Execute("DELETE FROM lib_comments WHERE id=".$_GET['cid']);
        error("Wykasowales komentarz");
    }
}

/**
* Display library rules
*/
if (isset($_GET['step']) && $_GET['step'] == 'rules')
{
    $smarty -> assign("Rules", Zasady);
}

/**
* Initialization of variable
*/
if (!isset($_GET['step']))
{
    $_GET['step'] = '';
}
if (!isset($_GET['action']))
{
    $_GET['action'] = '';
}
if (!isset($_GET['text']))
{
    $_GET['text'] = '';
}
if (!isset($_GET['author']))
{
    $_GET['author'] = '';
}
if (!isset($_POST['sort']))
{
    $_POST['sort'] = '';
}

/**
* Assign variables to template and display page
*/
$smarty -> assign(array("Rank" => $player -> rank,
    "Step" => $_GET['step'],
    "Action" => $_GET['action'],
    "Text" => $_GET['text'],
    "Author" => $_GET['author'],
    "Sort" => $_POST['sort']));
$smarty -> display ('library.tpl');

require_once("includes/foot.php");
?>

