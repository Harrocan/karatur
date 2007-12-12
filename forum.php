<?php

setlocale(LC_ALL, 'pl_PL');

$title="Forum";
require_once('includes/head.php');
require_once('includes/bbcode.php');

function genpage($amount,$perpage){
	$res=array();
	$i=1;
	while($amount>0) {
		$res[]=$i;
		$amount-=$perpage;
	}
	return $res;
}

if( !isset( $_GET['cat'] ) )
	$_GET['cat'] = '';
if( !isset( $_GET['topic'] ) )
	$_GET['topic'] = '';
if( !isset( $_GET['action'] ) )
	$_GET['action'] = '';

if(empty($_GET['cat'])) {
	$cats=$db->Execute("SELECT * FROM categories");
	$cats=$cats->GetArray();
	foreach($cats as $key=>$cat) {
		$top=$db->Execute("SELECT id FROM forum_top WHERE cat_id={$cat['id']}");
		$cats[$key]['tamount']=$top->RecordCount();
		$rep=$db->Execute("SELECT id FROM forum_rep WHERE cat_id={$cat['id']}");
		$cats[$key]['ramount']=$rep->RecordCount();
	}
	$smarty->assign("Cats",$cats);
}
if(!empty($_GET['cat'])) {
	if(empty($_GET['topic'])) {
		if($_GET['action']=='addtopic') {
			if( empty($_POST['topic']) || empty($_POST['body']) )
				error("Wypelnij wszystkie pola !",'error',"?cat={$_GET['cat']}&action=topic");
			$sql="INSERT INTO forum_top(cat_id, start_id, start_topic, start_body, start_time) VALUES({$_GET['cat']}, {$player->id}, '{$_POST['topic']}', '{$_POST['body']}', ".time().")";
			$db->Execute($sql)or error($sql);
			error("Temat dodany !",'done',"?cat={$_GET['cat']}");
		}
		$topics=$db->Execute("SELECT forum_top.id,forum_top.start_topic,forum_top.start_time,forum_top.start_body,forum_top.closed,forum_top.sticky, forum_top.closed, players.user AS start_user FROM forum_top JOIN players ON players.id=forum_top.start_id WHERE cat_id={$_GET['cat']} ORDER BY forum_top.sticky ASC, forum_top.start_time DESC");
		$topics=$topics->GetArray();
		foreach($topics as $key=>$topic){
			$reps=$db->Execute("SELECT `time` FROM forum_rep WHERE cat_id={$_GET['cat']} AND top_id={$topic['id']} ORDER BY `time` DESC");
			$topics[$key]['ramount']=$reps->RecordCount();
			$topics[$key]['start_time']=date("H:i, d-m-y",$topic['start_time']);
			if($reps->fields['time'])
				$topics[$key]['last_time']=date("H:i, d-m-y",$reps->fields['time']);
			else
				$topics[$key]['last_time']='brak';
		}
		$cat=$db->Execute("SELECT name FROM categories WHERE id={$_GET['cat']}");
		if(empty($cat->fields['name']))
	    error("Nieprawid³owa kategoria !");
		$smarty->assign("Catname",$cat->fields['name']);
		$smarty->assign("Topics",$topics);
	}
	else {
		if($_GET['action']=='move') {
			if($_SESSION['rank']['forum_adm']!='1')
				error("Nie masz uprawnien !");
				if(!empty($_POST['dest'])) {
					$db->Execute("UPDATE forum_top SET cat_id={$_POST['dest']} WHERE id={$_GET['topic']}");
					error("Watek przesuniety",'done',"?cat={$_GET['cat']}");
				}
			$kat=$db->Execute("SELECT id,`name` FROM forum_cat");
			$kat=$kat->GetArray();
			foreach($kat as $ka)
				$c[$ka['id']]=$ka['name'];
			$smarty->assign(array("Kat"=>$c,"Selected"=>$_GET['cat']));
			//$db->Execute("UPDATE forum_top SET sticky='Y' WHERE id={$_GET['topic']}");
			//error("Temat przyklejony",'done',"?cat={$_GET['cat']}");
		}
		if($_GET['action']=='sticky') {
			if($_SESSION['rank']['forum_adm']!='1')
				error("Nie masz uprawnien !");
			$db->Execute("UPDATE forum_top SET sticky='Y' WHERE id={$_GET['topic']}");
			error("Temat przyklejony",'done',"?cat={$_GET['cat']}");
		}
		if($_GET['action']=='unsticky') {
			if($_SESSION['rank']['forum_adm']!='1')
				error("Nie masz uprawnien !");
			$db->Execute("UPDATE forum_top SET sticky='N' WHERE id={$_GET['topic']}");
			error("Temat odklejony",'done',"?cat={$_GET['cat']}");
		}
		if($_GET['action']=='close') {
			if($_SESSION['rank']['forum_adm']!='1')
				error("Nie masz uprawnien !");
			$db->Execute("UPDATE forum_top SET closed='Y' WHERE id={$_GET['topic']}");
			error("Temat zamkniety",'done',"?cat={$_GET['cat']}&topic={$_GET['topic']}");
		}
		if($_GET['action']=='open') {
			if($_SESSION['rank']['forum_adm']!='1')
				error("Nie masz uprawnien !");
			$db->Execute("UPDATE forum_top SET closed='N' WHERE id={$_GET['topic']}");
			error("Temat otwarty",'done',"?cat={$_GET['cat']}&topic={$_GET['topic']}");
		}
		if($_GET['action']=='delete') {
			if($_SESSION['rank']['forum_adm']!='1')
				error("Nie masz uprawnien !");
			if(empty($_GET['msg'])) {
				$db->Execute("DELETE FROM forum_top WHERE id={$_GET['topic']}");
				$db->Execute("DELETE FROM forum_rep WHERE top_id={$_GET['topic']} AND cat_id={$_GET['cat']}");
				error("Temat skasowany !",'done',"?cat={$_GET['cat']}");
			}
			else {
				$db->Execute("DELETE FROM forum_rep WHERE id={$_GET['msg']}");
				error("Wiadomosc skasowana !",'done',"?cat={$_GET['cat']}&topic={$_GET['topic']}");
			}
		}
		if($_GET['action']=='addreply') {
			$test=$db->Execute("SELECT closed FROM forum_top WHERE id={$_GET['topic']}");
			if($test->fields['closed']=='Y')
				error("Ten temat zostal zamkniety !",'error',"?cat={$_GET['cat']}&topic={$_GET['topic']}");
			if(!empty($_POST['body'])) {
				//error("Wpisz tresc !",'error',"?cat={$_GET['cat']}&topic={$_GET['topic']}&action=reply");
				$sql="INSERT INTO forum_rep(cat_id,top_id,sender,`body`,`time`) VALUES({$_GET['cat']}, {$_GET['topic']}, {$player->id}, '{$_POST['body']}', ".time().")";
				$db->Execute($sql)or error($sql);
				error("Odpowiedz dodana !",'done',"?cat={$_GET['cat']}&topic={$_GET['topic']}");
			}
		}
		$cat=$db->Execute("SELECT name FROM categories WHERE id={$_GET['cat']}")or error("Kicha !");
		if(empty($cat->fields['name']))
	    error("Nieprawid³owa kategoria !");
		$smarty->assign("Catname",$cat->fields['name']);
		$head=$db->Execute("SELECT forum_top.*, players.user FROM forum_top JOIN players ON players.id=forum_top.start_id WHERE forum_top.id={$_GET['topic']}");
		if(empty($head->fields['start_id']))
		  error("Nieprawid³owy temat !",'error',"forum.php?cat={$_GET['cat']}");
		$head=$head->GetArray();
		$head=$head[0];
		$head['start_time']=date("H:i, d-m-y",$head['start_time']);
		$sql="SELECT forum_rep.*, players.user FROM forum_rep JOIN players ON players.id=forum_rep.sender WHERE forum_rep.cat_id={$_GET['cat']} AND forum_rep.top_id={$_GET['topic']} ORDER BY forum_rep.time ASC";
		//echo $sql;
		$repl=$db->Execute($sql)or error($sql);
		$pages=genpage($repl->RecordCount(),20);
		$repl=$repl->GetArray();
		foreach($repl as $key=>$rep) {
			//$repl[$key]['body']=bb2html($rep['body']);
			//$repl[$key]['body']=em2img($repl[$key]['body'],$rep['level']);
			$repl[$key]['time']=date("H:i, d-m-y",$rep['time']);
		}
		$smarty->assign(array("Head"=>$head,"Rep"=>$repl,"Pages"=>$pages));
	}
}
$ranks['forum_delete']=$_SESSION['rank']['forum_adm'];
$ranks['forum_sticky']=$_SESSION['rank']['forum_adm'];
$ranks['forum_move']=$_SESSION['rank']['forum_adm'];
$ranks['forum_close']=$_SESSION['rank']['forum_adm'];



$smarty->assign("Ranks",$ranks);
$smarty->assign(array("Cat"=>$_GET['cat'],"Topic"=>$_GET['topic'],"Action"=>$_GET['action']));
$smarty->display('forum.tpl');

require_once('includes/foot.php');

?>
