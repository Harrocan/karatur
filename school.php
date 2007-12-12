<?php
//@type: F
//@desc: Szko³a
$title="Szko³a";
require_once('includes/head.php');

if (! function_exists('array_combine')) {
  function array_combine($keys, $values) {
   foreach($keys as $key) $out[$key] = array_shift($values);
   return $out;
  }
}

if(empty($_GET['sid']))
	error("Podaj poprawny identyfikator szko³y !");
$school=$db->Execute("SELECT * FROM school WHERE id=".$_GET['sid']);
if(!$school->fields['name'])
	error("Taka szko³a nie istnieje !");
if($school->fields['city']!=$player->file)
	error("Jeste¶ w niew³a¶ciwym mie¶cie !");
if ($player -> hp == 0)
    error ("Nie mo¿esz szkoliæ siê, poniewa¿ jestes martwa/y!");
if (!$player -> race)
    error("Nie mo¿esz siê szkoliæ poniewa¿ nie wybra³a¶/e¶ jeszcze rasy!");
if (!$player -> clas)
    error("Nie mozesz siê szkolic poniewa¿ nie wybrala¶/e¶ jeszcze klasy!");
if( ((int)$school->fields['level']) > ((int)$player->level) )
	error("Nie masz wystarczaj±cego poziomu. Wróc pó¼niej",'error',$player->file);


$train=array_combine(array('str','dex','int','spd','con','wis'),explode(",",$school->fields['train']));
$traincost=array_combine(array('str','dex','int','spd','con','wis'),explode(",",$school->fields['traincost']));
$trainjump=array_combine(array('str','dex','int','spd','con','wis'),explode(",",$school->fields['trainjump']));
$trainmax=array_combine(array('str','dex','int','spd','con','wis'),explode(",",$school->fields['trainmax']));

if(isset($_GET['action']) && $_GET['action']=='train') {
	$atr=array_combine(array('si','zr','in','sz','wy','sw'),array('strength','agility','inteli','szyb','wytrz','wisdom'));
	$energy=$_POST['ile']*0.4;
	$cost=$_POST['ile']*$traincost[$_POST['co']];
	$gain=$_POST['ile']*$trainjump[$_POST['co']];
	if(empty($_POST['co']) || empty($_POST['ile']))
		error("Wprowad¼ wszystkie dane !");
	if( $gain + $player -> $_POST['co'] > $trainmax[$_POST['co']] ) {
		error("Twoje umiejêtno¶ci s± zaprawdê na imponuj±cym poziomie ... niestety ale nasi nauczyciele nie s± w stanie przekazaæ Ci jak±kolwiek uzyteczn± wiedzê",'error','school.php?sid='.$_GET['sid']);
	}
	if($energy > $player->energy) {
		error("Nie posiadasz wystarczaj±co energii ¿eby trenowaæ",'error','school.php?sid='.$_GET['sid']);
	}
	if($cost > $player->gold) {
		error("Za trening siê p³aci ... z tak± ilo¶ci± pieniêdzy poszukaj sobie innego nauczyciela",'error','school.php?sid='.$_GET['sid']);
	}
	//$sql="UPDATE players SET ".$atr[$_POST['co']]."=".$atr[$_POST['co']]."+".$gain.", credits=credits-".$cost.", energy=energy-".$energy." WHERE id=".$player->id;
	$player -> $_POST['co'] = $player -> GetAtr( $_POST['co'], TRUE ) + $gain;
	$player -> gold -= $cost;
	$player -> energy -= $energy;
	//$db->Execute($sql)or error($sql);
	if($_POST['co']=='con') {
		$player -> hp_max = $player -> GetMisc( 'hp_max', TRUE ) + $gain;
		//$db -> Execute("UPDATE players SET max_hp=max_hp+".$gain." WHERE id={$player->id}");
	}
	switch ($_POST['co']) {
	case "str": $jakitrening="si³ê";break;
	case "dex": $jakitrening="zrêczno¶æ";break;
	case "int": $jakitrening="inteligencjê";break;
	case "spd": $jakitrening="prêdko¶æ";break;
	case "con": $jakitrening="wytrzyma³o¶æ";break;
	case "wis": $jakitrening="si³ê woli";
	}
	
        if ($player -> gender == 'M') {
	error("Trenowa³e¶ ".$jakitrening." ".$_POST['ile']." razy !",'done','school.php?sid='.$_GET['sid']);
	}
        else {
	error("Trenowa³a¶ ".$jakitrening." ".$_POST['ile']." razy !",'done','school.php?sid='.$_GET['sid']);
        }
			
}

$smarty->assign(array("Train"=>$train,"Trainjump"=>$trainjump,"Traincost"=>$traincost,"Trainmax"=>$trainmax));
$smarty->assign("Title",$school->fields['name']);
$smarty->assign("Sid",$_GET['sid']);
$smarty->display('school.tpl');

require_once('includes/foot.php');
?>