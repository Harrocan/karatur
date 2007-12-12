<?php


$title = "Hala zgromadzen";
require_once("includes/head.php");

/**
* Select active poll
*/
$objPollid = $db -> Execute("SELECT id FROM polls ORDER BY id DESC");

/**
* Show active poll
*/
if (!isset($_GET['action']))
{
    if (!$objPollid -> fields['id'])
    {
        $smarty -> assign("Pollid", 0);
    }
        else
    {
        $objPoll = $db -> Execute("SELECT poll, votes, days, members FROM polls WHERE id=".$objPollid -> fields['id']);
        $arrPoll = array();
        $arrVotes = array();
        $intVotes = 0;
        $i = 0;
        while (!$objPoll -> EOF)
        {
            if ($objPoll -> fields['votes'] < 0)
            {
                $strQuestion = $objPoll -> fields['poll'];
                $intDays = $objPoll -> fields['days'];
                $intMembers = $objPoll -> fields['members'];
            }
                else
            {
                $arrPoll[$i] = $objPoll -> fields['poll'];
                $arrVotes[$i] = $objPoll -> fields['votes'];
                $intVotes = $intVotes + $objPoll -> fields['votes'];
                $i++ ;
            }
            $objPoll -> MoveNext();
        }
        /**
        * Count percent for each option
        */
        $arrPercentvotes = array();
        $i = 0;
        foreach ($arrVotes as $intVote)
        {
            if ($intVote && $intVotes)
            {
                $arrPercentvotes[$i] = ceil(($intVote / $intVotes) * 100);
            }
                else
            {
                $arrPercentvotes[$i] = 0;
            }
            $i++ ;
        }
        /**
        * Count percent for voting players
        */
        if ($intDays)
        {
            $objQuery = $db -> Execute("SELECT id FROM players");
            $intMembers = $objQuery -> RecordCount();
            $objQuery -> Close();
            $fltVoting = ($intVotes / $intMembers) * 100;
        }
            else
        {
            $fltVoting = ($intVotes / $intMembers) * 100;
        }
        $fltVoting = round($fltVoting, 2);
        /**
        * Check for aviable for voting
        */
        if ($intDays)
        {
            $strVoting = 'Y';
        }
            else
        {
            $strVoting = 'N';
        }
        $objVote = $db -> Execute("SELECT poll FROM players WHERE id=".$player -> id);
        if ($objVote -> fields['poll'] == 'N' && $strVoting == 'Y')
        {
            $strVoting = 'Y';
        }
            else
        {
            $strVoting = 'N';
        }
        $objVote -> Close();
        $objPoll -> Close();
        $smarty -> assign(array("Pollid" => $objPollid -> fields['id'],
            "Question" => $strQuestion,
            "Answers" => $arrPoll,
            "Voting" => $strVoting,
            "Votes" => $arrVotes,
            "Summaryvotes" => $intVotes,
            "Percentvotes" => $arrPercentvotes,
            "Summaryvoting" => $fltVoting,
            "Days" => $intDays));
    }
}

/**
* Vote in poll
*/
if (isset($_GET['action']) && $_GET['action'] == 'vote')
{
    if (!ereg("^[1-9][0-9]*$", $_GET['poll']) || $_GET['poll'] != $objPollid -> fields['id'])
    {
        error(ERROR);
    }
    $objVote = $db -> Execute("SELECT poll FROM players WHERE id=".$player -> id);
    if ($objVote -> fields['poll'] == 'Y')
    {
        error(ERROR);
    }
    $objVote -> Close();
    $strAnswer = $db -> qstr($_POST['answer'], get_magic_quotes_gpc());
    $db -> Execute("UPDATE polls SET votes=votes+1 WHERE id=".$_GET['poll']." AND poll=".$strAnswer);
    $db -> Execute("UPDATE players SET poll='Y' WHERE id=".$player -> id);
    $smarty -> assign("Message", VOTE_SUCC);
}


/**
* Show last 10 polls
*/
if (isset($_GET['action']) && $_GET['action'] == 'last')
{
    $objPollsid = $db -> SelectLimit("SELECT id FROM polls WHERE lang='".$player -> lang."' AND votes=-1 ORDER BY id DESC", 10) or $db -> ErrorMsg();
    $arrQuestions = array();
    $arrPolls = array(array());
    $arrVotes = array(array());
    $arrSumvotes = array();
    $arrPercentvotes = array(array());
    $arrPercentmembers = array();
    $arrPercentvoting = array();
    $i = 0;
    while (!$objPollsid -> EOF)
    {
        $j = 0;
        $objPoll = $db -> Execute("SELECT poll, votes, members FROM polls WHERE id=".$objPollsid -> fields['id']);
        while (!$objPoll -> EOF)
        {
            if ($objPoll -> fields['votes'] < 0)
            {
                $arrQuestions[$i] = $objPoll -> fields['poll'];
                $arrSumvotes[$i] = 0;
                if ($objPoll -> fields['members'])
                {
                    $intMembers = $objPoll -> fields['members'];
                }
                    else
                {
                    $objQuery = $db -> Execute("SELECT id FROM players");
                    $intMembers = $objQuery -> RecordCount();
                    $objQuery -> Close();
                }
            }
                else
            {
                $arrPolls[$i][$j] = $objPoll -> fields['poll'];
                $arrVotes[$i][$j] = $objPoll -> fields['votes'];
                $arrSumvotes[$i] = $arrSumvotes[$i] + $objPoll -> fields['votes'];
                $j++ ;
            }
            $objPoll -> MoveNext();
        }
        $objPoll -> Close();
        /**
        * Count percent for each option
        */
        $j = 0;
        foreach ($arrVotes[$i] as $intVote)
        {
            if ($intVote && $arrSumvotes[$i])
            {
                $arrPercentvotes[$i][$j] = ceil(($intVote / $arrSumvotes[$i]) * 100);
            }
                else
            {
                $arrPercentvotes[$i][$j] = 0;
            }
            $j++ ;
        }
        /**
        * Count percent for voting players
        */
        if ($arrSumvotes[$i] && $intMembers)
        {
            $arrPercentvoting[$i] = ($arrSumvotes[$i] / $intMembers) * 100;
            $arrPercentvoting[$i] = round($arrPercentvoting[$i], 2);
        }
            else
        {
            $arrPercentvoting[$i] = 0;
        }
        $i++ ;
        $objPollsid -> MoveNext();
    }
    $smarty -> assign(array("Questions" => $arrQuestions,
        "Answers" => $arrPolls,
        "Votes" => $arrVotes,
        "Lastinfo" => LAST_INFO,
        "Summaryvotes" => $arrSumvotes,
        "Percentvotes" => $arrPercentvotes,
        "Percentvoting" => $arrPercentvoting));
}

/**
* Initialization of variable
*/
if (!isset($_GET['action']))
{
    $_GET['action'] = '';
    $smarty -> assign(array("Pollsinfo" => POLLS_INFO,
            "Nopolls" => NO_POLLS,
            "Lastpoll" => LAST_POLL,
            "Asend" => A_SEND,
            "Alast10" => A_LAST_10,
            "Polldays" => POLL_DAYS,
            "Tdays" => T_DAYS,
            "Pollend" => POLL_END));
}

/**
* Assign variables to template and display page
*/
$smarty -> assign(array("Action" => $_GET['action'],
    "Aback" => A_BACK,
    "Tvotes" => T_VOTES,
    "Sumvotes" => SUM_VOTES,
    "Tmembers" => T_MEMBERS));
$smarty -> display('polls.tpl');

require_once("includes/foot.php");
?>

