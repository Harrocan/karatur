<?php

$title = "Archiwalne sondy"; 
require_once("includes/head.php");

$current = $db-> Execute("SELECT value FROM settings WHERE setting='poll_id'");
$polls=$db->Execute("SELECT * FROM poll WHERE id!={$current->fields['value']} ORDER BY id DESC");
$polls=$polls->GetArray();

for($i=0,$ile=count($polls);$i<$ile;$i++) {
	$polls[$i]['options']=explode(",",$polls[$i]['options']);
	$polls[$i]['votes'] = explode(",",$polls[$i]['votes']);
	$sum=array_sum($polls[$i]['votes']);
	$j=0;
	foreach($polls[$i]['votes'] as $vote) {
		$polls[$i]['sum'][$j] = round(($polls[$i]['votes'][$j]/$sum)*100,2);
		$j++;
	}
}

$smarty->assign("Polls",$polls);
$smarty->display('poll.tpl');

require_once("includes/foot.php");
?>