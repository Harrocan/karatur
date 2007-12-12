<?php

require_once('./includes/config.php');
$list = $db->Execute("SELECT id,user,ip FROM players");
//echo '<table cellspacing="0" cellpadding="0" border="1">';
while(!$list->EOF) {
	if($list->fields['ip']!='') {
		//echo '<tr><td width="150px">';
		//echo $list->fields['user']."</td><td>".$list->fields['ip']."</td><td>".$list->fields['id'];
		echo $list->fields['id']."\t".$list->fields['user']."\t".$list->fields['ip']."\n";
		//echo '</td></tr>';
	}
	$list->MoveNext();
}
//echo '</table>';
$list->Close();
$db->Close();
exit();

?>