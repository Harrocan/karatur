<?php

$title="Administracja Szko³ami";
require_once('includes/head.php');

if($player->id!=267)
	error("Spieprzaj dziadu. Tylko Wujek-Samo-Z³o mo¿e tu siê bawiæ");


// $krowka=$db->Execute("SELECT * FROM ranks WHERE id={$player->rid}");
// $dyd=$krowka->_numOfFields;
// $kopytko=$krowka->GetArray();
// $kopytko=$kopytko[0];
// //$test=$test->GetArray();
// for($i=4;$i<$dyd;$i++) {
// 	$field=$krowka->FetchField($i);
// 	$rank[$field->name]=$kopytko[$field->name];
// 	//echo "rank_{$field->name} : {$ff[$field->name]}<BR>";
// }
//print_r($_SESSION);
//print_r($test);
//echo $num;

if( !isset( $_GET['action'] ) )
	$_GET['action'] ='';
if( !isset( $_GET['step'] ) )
	$_GET['step'] ='';

if(isset($_GET['action']) && $_GET['action']=='add') {
	if(isset($_GET['step']) && $_GET['step']=='2') {
		$smarty->assign(array("Si"=>$_POST['si'],"Zr"=>$_POST['zr'],"In"=>$_POST['in'],"Sz"=>$_POST['sz'],"Wy"=>$_POST['wy'],"Sw"=>$_POST['sw']));
	}
	if(isset($_GET['step']) && $_GET['step']=='3') {
		if(empty($_POST['name']) || empty($_POST['city']) || empty($_POST['level']))
			error("Wype³nij wszystkie pola");
		if(isset($_POST['si'])) {
			if(empty($_POST['sicost']) || empty($_POST['sijump']) || empty($_POST['simax']))
				error("Wype³nij wszystkie pola");
		}
		if(isset($_POST['zr'])) {
			if(empty($_POST['zrcost']) || empty($_POST['zrjump']) || empty($_POST['zrmax']))
				error("Wype³nij wszystkie pola");
		}
		if(isset($_POST['in'])) {
			if(empty($_POST['incost']) || empty($_POST['injump']) || empty($_POST['inmax']))
				error("Wype³nij wszystkie pola");
		}
		if(isset($_POST['sz'])) {
			if(empty($_POST['szcost']) || empty($_POST['szjump']) || empty($_POST['szmax']))
				error("Wype³nij wszystkie pola");
		}
		if(isset($_POST['wy'])) {
			if(empty($_POST['wycost']) || empty($_POST['wyjump']) || empty($_POST['wymax']))
				error("Wype³nij wszystkie pola");
		}
		if(isset($_POST['sw'])) {
			if(empty($_POST['swcost']) || empty($_POST['swjump']) || empty($_POST['swmax']))
				error("Wype³nij wszystkie pola");
		}
		$train=implode(",",array((int)$_POST['si'],(int)$_POST['zr'],(int)$_POST['in'],(int)$_POST['sz'],(int)$_POST['wy'],(int)$_POST['sw']));
		$traincost=implode(",",array((int)$_POST['sicost'],(int)$_POST['zrcost'],(int)$_POST['incost'],(int)$_POST['szcost'],(int)$_POST['wycost'],(int)$_POST['swcost']));
		$trainjump=implode(",",array((double)$_POST['sijump'],(double)$_POST['zrjump'],(double)$_POST['injump'],(double)$_POST['szjump'],(double)$_POST['wyjump'],(double)$_POST['swjump']));
		$trainmax=implode(",",array((int)$_POST['simax'],(int)$_POST['zrmax'],(int)$_POST['inmax'],(int)$_POST['szmax'],(int)$_POST['wymax'],(int)$_POST['swmax']));
		
		$sql="INSERT INTO school (name, city, train, traincost, trainjump, trainmax, level) VALUES ('".$_POST['name']."', '".$_POST['city']."', '".$train."', '".$traincost."', '".$trainjump."', '".$trainmax."', '".$_POST['level']."')";
		$db->Execute($sql)or error($sql);
		error("Szko³a dodana !",'done');
	}
}

if(empty($_GET['action'])) {
	$school=$db->Execute("SELECT * FROM school");
	$school=$school->GetArray();
	foreach($school as $key=>$s) {
		$school[$key]['train']=explode(",",$s['train']);
		$school[$key]['traincost']=explode(",",$s['traincost']);
		$school[$key]['trainjump']=explode(",",$s['trainjump']);
		$school[$key]['trainmax']=explode(",",$s['trainmax']);
	}
	$smarty->assign("School",$school);
	/*$schoolid=array();
	$schoolname=array();
	$schoolcity=array();
	$schoollvl=array();
	$schoolatr=array();
	foreach($stab as $sk) {
		$schoolid[]=$sk['id'];
		$schoolname[]=$sk['name'];
		$schoolcity[]=$sk['city'];
		$schoollvl[]=$sk['level'];
		$schoolatr[]=explode(",",$sk['train']);
	}
	$smarty->assign(array("Schoolid"=>$schoolid,"Schoolname"=>$schoolname,"Schoolcity"=>$schoolcity,"Schoollvl"=>$schoollvl,"Schoolatr"=>$schoolatr));*/
}
$smarty->assign("Action",$_GET['action']);
$smarty->assign("Step",$_GET['step']);
$smarty->display('schooladm.tpl');

require_once('includes/foot.php');
?>