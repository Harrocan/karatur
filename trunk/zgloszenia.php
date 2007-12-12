<?php

$title = "Zgloszenia";
require_once("includes/head.php");
require_once( "includes/bbcode.php" );

if($_SESSION['rank']['form']!='1')
	error("Nie masz prawa tu przebywaæ");

$test=$db->Execute("SELECT id FROM zgloszenia WHERE `type`='E' AND `solve`='N'");
$amount['bug']=$test->RecordCount();
$test=$db->Execute("SELECT id FROM zgloszenia WHERE `type`='V' AND `solve`='N'");
$amount['regulamin']=$test->RecordCount();
$test=$db->Execute("SELECT id FROM zgloszenia WHERE `type`='M' AND `solve`='N'");
$amount['slub']=$test->RecordCount();
$test=$db->Execute("SELECT id FROM zgloszenia WHERE `type`='R' AND `solve`='N'");
$amount['rangi']=$test->RecordCount();
$test=$db->Execute("SELECT id FROM zgloszenia WHERE `type`='C' AND `solve`='N'");
$amount['opinie']=$test->RecordCount();
$test=$db->Execute("SELECT id FROM zgloszenia WHERE `type`='O' AND `solve`='N'");
$amount['inne']=$test->RecordCount();
$smarty->assign("Amount",$amount);

$test=$db->Execute("SELECT id FROM zgloszenia WHERE `type`='E'");
$total['bug']=$test->RecordCount();
$test=$db->Execute("SELECT id FROM zgloszenia WHERE `type`='V'");
$total['regulamin']=$test->RecordCount();
$test=$db->Execute("SELECT id FROM zgloszenia WHERE `type`='M'");
$total['slub']=$test->RecordCount();
$test=$db->Execute("SELECT id FROM zgloszenia WHERE `type`='R'");
$total['rangi']=$test->RecordCount();
$test=$db->Execute("SELECT id FROM zgloszenia WHERE `type`='C'");
$total['opinie']=$test->RecordCount();
$test=$db->Execute("SELECT id FROM zgloszenia WHERE `type`='O'");
$total['inne']=$test->RecordCount();
$smarty->assign("Total",$total);

if( isset( $_GET['action'] ) && $_GET['action']=='view') {
	if( isset( $_GET['page'] ) ) {
		$page = intval( $_GET['page'] ) - 1;
	}
	else {
		$page = 0;
	}
	$perpage = 10;
	$start = $page * $perpage;
	$total = SqlExec( "SELECT COUNT(*) AS amount FROM zgloszenia WHERE `type`='{$_GET['type']}'" );
	$total = $total->fields['amount'];
	$pages = array();
	$i = 0;
	while( $total > 0 ) {
		$pages[] = $i;
		$i++;
		$total -= $perpage;
	}
	$smarty->assign( array( "Pages" => $pages,
							"Page" => $page,
							"Type" => $_GET['type'] ) );
	$zgl=SqlExec("SELECT z.*, p.user, s.user AS solve_user FROM zgloszenia z LEFT JOIN players p ON p.id = z.pid LEFT JOIN players s ON s.id=z.solve_id WHERE z.`type`='{$_GET['type']}' ORDER BY z.solve DESC, z.`date` DESC LIMIT $start, $perpage");
	$zgl=$zgl->GetArray();
	//print_r($zgl);
	foreach($zgl as $key=>$z) {
		$zgl[$key]['date']=date("H:i d/m/Y",$z['date']);
		$zgl[$key]['body']= nl2br( bb2html($z['body']) );
		$zgl[$key]['num'] = sprintf( "%06d", $z['id'] );
		$hist = SqlExec( "SELECT * FROM zgl_history WHERE zid={$z['id']}" );
		$hist = $hist->GetArray();
		$zgl[$key]['hist'] = $hist;
	$smarty->assign("Zgl",$zgl);
	}
}
if( isset( $_GET['action'] ) && $_GET['action']=='solve') {
	if(empty($_GET['id']))
		error("Nieprawid³owe wywo³anie !");
	$test=$db->Execute("SELECT pid,topic,solve,`type` FROM zgloszenia WHERE id={$_GET['id']}");
	if(empty($test->fields['pid']))
	  error("Nie istnieje takie zgloszenie !");
	if($test->fields['solve']=='Y')
		error("To zg³oszenie zosta³o ju¿ rozwi±zane !");
	$sql="INSERT INTO mail (sender, senderid, owner, subject, body) VALUES('{$player->user}','{$player->id}',{$test->fields['pid']},'Rozwiazanie zgloszenia','Twoje zgloszenie o temacie <b>{$test->fields['topic']}</b> zosta³o uznane za rozwiazane. Dziekujemy za zgloszenie problemu.')";
	$db -> Execute($sql) or error($sql);
	$db->Execute("UPDATE zgloszenia SET `solve`='Y', `solve_id`='{$player->id}' WHERE id='{$_GET['id']}'");
	error("Operacja wykonana !",'done',"?action=view&type={$test->fields['type']}");
}

if( !isset( $_GET['action'] ) )
	$_GET['action'] = '';

//przypisanie zmiennych i wy¶wietlenie strony
$smarty -> assign(array("Action"=>$_GET['action']));
$smarty -> display('zgloszenia.tpl');

require_once("includes/foot.php");

?>