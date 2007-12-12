<?php

$title="Podglad Rang";
require_once('includes/head.php');

//if($_SESSION['rank']['rankprev']!='1')
//	error("Nie masz uprawnien");

$rangi=$db->Execute("SELECT * FROM ranks");
	$rankid=array();
	$rankname=array();
	$rankcolor=array();
	$rankimage=array();
	$i=0;
	while(!$rangi->EOF) {
		$rankid[$i]=$rangi->fields['id'];
		$rankname[$i]=$rangi->fields['name'];
		$rankcolor[$i]=$rangi->fields['color'];
		$rankimage[$i]=$rangi->fields['image'];
		$i++;
		$rangi->MoveNext();
	}
	$user=$db->Execute("SELECT id,user,rid FROM players WHERE rid>1 ORDER BY rid ASC ");
	$userid=array();
	$username=array();
	$userrank=array();
	$userrankicon=array();
	$i=0;
	$old=$user->fields['rid'];
	while(!$user->EOF) {
		$old=$user->fields['rid'];
		$userid[$i][]=$user->fields['id'];
		$username[$i][]=$user->fields['user'];
		$rno=array_search($user->fields['rid'],$rankid);
		$userrank[$i]=$rankname[$rno];
		$userrankicon[$i]=$rankimage[$rno];
		//$i++;
		$user->MoveNext();
		if(!$user->EOF)
			if($old!=$user->fields['rid'])
			$i++;
	}
	$smarty->assign(array("Rankid"=>$rankid,"Rankname"=>$rankname,"Rankcolor"=>$rankcolor,"Rankimage"=>$rankimage));
	$smarty->assign(array("Userid"=>$userid,"Username"=>$username,"Userrank"=>$userrank,"Userrankicon"=>$userrankicon));
	
$smarty->display('rankprev.tpl');

require_once('includes/foot.php');
?>