<?php
//@type: F
//@desc: Akta s±dowe
$title = "Kroniki Sadowe";
require_once("includes/head.php");

checklocation($_SERVER['SCRIPT_NAME']);

if( !getRank( 'akta' ) ) 
	error("Nie masz prawa tutaj przebywaæ !");

if(!isset($_GET['id'])) {
	$sk = $db -> Execute("SELECT * FROM skazani");
	$skid=array();
	$skname=array();
	$skile=array();
	$i=0;
	while(!$sk->EOF) {
		$skid[$i]=$sk->fields['id'];
		$skname[$i]=$sk->fields['name'];
		$skile[$i]=$sk->fields['ilosc'];
		$i++;
		$sk->MoveNext();
	}
	$smarty -> assign(array("SkName"=>$skname,"SkId"=>$skid,"SkIlosc"=>$skile));
}
if(isset($_GET['id'])) {
	$sk=$db->Execute("SELECT * FROM akta WHERE pid=".$_GET['id'].";");
	if($sk->fields['id']=='')
		error("Zapomnij o tym");
	$skid=array();
	$skdur=array();
	$skdata=array();
	$skreason=array();
	$skcela=array();
	$skcost=array();
	$freeid=array();
	$freename=array();
	$freedate=array();
	$skstatus=array();
	$i=0;
	while(!$sk->EOF){
		$skid[$i]=$sk->fields['id'];
		$skdur[$i]=$sk->fields['dur'];
		$skdata[$i]=$sk->fields['data'];
		$skreason[$i]=$sk->fields['reason'];
		$skcela[$i]=$sk->fields['cela'];
		$skcost[$i]=$sk->fields['cost'];
		$freeid[$i]=$sk->fields['freeid'];
		$freename[$i]=$sk->fields['freename'];
		$freedate[$i]=$sk->fields['freedate'];
		$skstatus[$i]=0;
		$i++;
		$sk->MoveNext();
	}
	$smarty -> assign(array("SkId"=>$skid,
							"SkDur"=>$skdur,
							"SkData"=>$skdata,
							"SkReason"=>$skreason,
							"SkCela"=>$skcela,
							"SkCost"=>$skcost,
							"FreeId"=>$freeid,
							"FreeName"=>$freename,
							"FreeDate"=>$freedate));
	$pl=$db->Execute("SELECT * FROM players WHERE id=".$_GET['id'].";");
	$smarty->assign(array(	"Id"=>$_GET['id'],
							"Name"=>$pl->fields['user'],
							"Email"=>$pl->fields['email'],
							"Rank"=>$pl->fields['rank'],
							"Age"=>$pl->fields['age'],
							"Logins"=>$pl->fields['logins'],
							"Page"=>$pl->fields['page'],
							"Ip"=>$pl->fields['ip'],
							"Rasa"=>$pl->fields['rasa'],
							"Klasa"=>$pl->fields['klasa'],
							"Immu"=>$pl->fields['immu'],
							"Miejsce"=>$pl->fields['miejsce'],
							"GG"=>$pl->fields['gg'],
							"Avatar"=>$pl->fields['avatar'],
							"Deity"=>$pl->fields['Deity'],
							"Gender"=>$pl->fields['gender']));
}
/*
if(isset($_GET['del']) && isset($_GET['id'])) {
	if (!ereg("^[1-9][0-9]*$", $_GET['del'])) {
        error ("Zapomnij o tym!");
    }
    if (!ereg("^[1-9][0-9]*$", $_GET['id'])) {
        error ("Zapomnij o tym!");
    }
    $db->Execute("DELETE FROM akta WHERE id=".$_GET['del'].";")or die("DELETE FROM akta WHERE id=".$_GET['del'].";");
    $ile=$db->Execute("SELECT ilosc FROM skazani WHERE id=".$_GET['id'].";");
    if($ile->fields['ilosc']>1)
    	$db->Execute("UPDATE skazani SET ilosc=ilosc-1 WHERE id=".$_GET['id'].";");
    else
    	$db->Execute("DELETE FROM skazani WHERE id=".$_GET['id'].";");
    error("Teczka wykasowana !",'done');
}
*/
$smarty -> assign("Id",$_GET['id']);
$smarty -> display ('akta.tpl');

require_once("includes/foot.php");
?>