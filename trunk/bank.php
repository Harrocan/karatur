<?php
//@type: F
//@desc: Bank
/**
*   Funkcje pliku:
*   Bank - przechowywanie pieniedzy oraz przekazywanie roznych rzeczy innym graczom
*
*   @name                 : bank.php                            
*   @copyright            : (C) 2004-2005 Vallheru Team based on Gamers-Fusion ver 2.5
*   @author               : thindil <thindil@users.sourceforge.net>
*   @version              : 0.7 beta
*   @since                : 05.01.2005
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

$title = "Bank";
require_once("includes/head.php");

checklocation($_SERVER['SCRIPT_NAME']);

if( !isset( $_GET['action'] ) )
	$_GET['action'] = '';
if( !isset( $_GET['about'] ) )
	$_GET['about'] = '';

//! przypisanie zmiennych
$smarty -> assign(array("Potions" => '', "Minerals" => '', "Items" => '', "Crime" => '', "Herbs" => ''));

$items = $player -> EquipSearch();
//$items = array_values( $items );
$sellit = array();
foreach( $items as $key => $item ) {
	$sellit[] = array( 'key'=>$item['id'], 'item'=>"(ilosc: {$item['amount']}) {$item['prefix']} {$item['name']}" );
}
//print_r( $sellit );
$smarty -> assign( "GiveItem", $sellit );

$potions = $player -> EquipSearch( NULL, 'potions' );
if( !is_array( $potions ) ) {
	trigger_error( "Test", E_USER_ERROR );
}
$givepot = array();
foreach( $potions as $key => $potion ) {
	$givepot[] = array( 'key'=>$potion['id'], 'potion'=>"(ilosc: {$potion['amount']}) {$potion['prefix']} {$potion['name']}" );
}
//print_r( $givepot );
$smarty->assign( "GivePot", $givepot );

if ($player -> clas == 'Zlodziej' && $player -> crime > 0) {
	$smarty -> assign ("Crime", "<br><br><br><br><a href=\"bank.php?action=steal\">Okradnij bank</a>");
}

$smarty -> assign ( array( "Bank" => $player -> bank,"Gold" => $player -> gold ) );


//! dawanie mineralow innym graczom
if (isset ($_GET['action']) && $_GET['action'] == 'minerals') {
	if (!isset($_POST['item'])) {
		error("Nie podales jaki rodzaj mineralu chcesz przekazac!");
	}
	if( !in_array( $_POST['item'], array( 'copper', 'iron', 'coal', 'adamantium', 'meteor', 'crystal', 'wood', 'illani', 'illanias', 'nutari', 'dynallca', 'mithril' ) ) ) {
		error( "Nieprawidlowy surowiec !" );
	}
	if (!ereg("^[1-9][0-9]*$", $_POST['amount']) || !ereg("^[1-9][0-9]*$", $_POST['id'])) {
		error ("Zapomij o tym!");
	}
	$mins = array( 'copper'=>'miedzi', 'iron'=>'zelaza', 'coal'=>'wegla', 'adamantium'=>'adamantytu', 'meteor'=>'meteoru', 'crystal'=>'krysztalu', 'wood'=>'drewna', 'illani'=>'illani', 'illanias'=>'illanias', 'nutari'=>'nutari', 'dynallca'=>'dynallca', 'mithril'=>'mithrilu' );
	$min = $mins[$_POST['item']];
	$mineral = $_POST['item'];
	if ($player -> $mineral < $_POST['amount']) {
		error ("Nie masz tyle mienralow");
	}
	//$minerals -> Close();
	if ($_POST['id'] == $player -> id) {
		error ("Nie mozesz dotowac siebie!");
	}
	$dotowany = $db -> Execute("SELECT id,ip FROM players WHERE id=".$_POST['id']);
	if (empty ($dotowany -> fields['id'])) {
		error ("Nie ma takiego gracza!");
	}
	if( $dotowany -> fields['ip'] == $player->ip) {
		SqlExec( "INSERT INTO transfer( `from`, `to`, `what`, `amount`, `date` ) VALUES( $player->id, {$dotowany->fields['id']}, '$mineral', {$_POST['amount']}, ".time()." ) " );
	}
	$dotowany -> Close();
	SqlExec( "UPDATE resources SET $mineral = $mineral + {$_POST['amount']} WHERE id={$_POST['id']}" );
	PutSignal( $_POST['id'], 'res' );
	//$db -> Execute("UPDATE kopalnie SET ".$_POST['item']."=".$_POST['item']."-".$_POST['amount']." WHERE gracz=".$player -> id);
	$player -> $mineral -= $_POST['amount'];
	$db -> Execute("INSERT INTO log (owner, log, czas) VALUES(".$_POST['id'].",'Gracz <b><a href=view.php?view=".$player -> id.">".$player -> user."</a> ID:".$player -> id."</b>, przekazal ci ".$_POST['amount']." $min.','".$newdate."')");
	error ("Przekazales graczowi ID: ".$_POST['id']." ".$_POST['amount']." sztuk $min",'done');
}

//! dawanie mikstur innym graczom
if (isset ($_GET['action']) && $_GET['action'] == 'potions') {
	if (!ereg("^[1-9][0-9]*$", $_POST['item']) || !ereg("^[1-9][0-9]*$", $_POST['id']) || !ereg("^[1-9][0-9]*$", $_POST['amount'])) {
		error ("Zapomij o tym!");
	}
	//print_r( $_POST );
	$items = $player -> EquipSearch( array( 'id' => $_POST['item'] ), 'potions' );
	//print_r( $items );
	if( empty( $items ) ) {
		error( "nie masz takiego przedmiotu !" );
	}
	$key = key( $items );
	$items = $items[$key];
	if ($_POST['id'] == $player -> id) {
		error ("Nie mozesz dotowac siebie!");
	}

	$dotowany = new Player( $_POST['id'] );
	if( $dotowany -> created == FALSE ) {
		error( "Nie ma takiego gracza !" );
	}
	if( $dotowany->ip == $player->ip) {
		SqlExec( "INSERT INTO transfer( `from`, `to`, `what`, `amount`, `date` ) VALUES( $player->id, $dotowany->id, '{$items['prefix']} {$item['name']}', {$_POST['amount']}, ".time()." ) " );
	}
	//print_r( $items );
	//error( "{$dotowany -> user}" );
	if ($items['amount'] < $_POST['amount']) {
		error ("Nie masz tyle {$items['prefix']} ".$items['name']);
	}
	
	$toadd = $items;
	$toadd['amount'] = $_POST['amount'];
	
	$dotowany -> EquipAdd( $toadd, 'potions' );
	PutSignal( $dotowany -> id, 'pot' );
	if( $items['amount'] - $_POST['amount'] < 1 ) {
		$player -> EquipDelete( $items['id'], 'potions' );
	}
	else {
		$player -> SetEquip( 'potions', $key, array( 'amount' => $items['amount'] - $_POST['amount'] ) );
	}
	
	SqlExec("INSERT INTO log (owner, log, czas) VALUES(".$_POST['id'].",'Gracz <b><a href=view.php?view=".$player -> id.">".$player -> user."</a> ID:".$player -> id."</b>, przekazal ci ".$_POST['amount']." {$items['prefix']} ".$items['name'].".','".$newdate."')");
	error ("Przekazales graczowi {$dotowany -> user} ".$_POST['amount']." sztuk {$items['prefix']} {$items['name']}.<a href=bank.php> Odswiez</a>",'done');
	//$item -> Close();
}

//! dawanie przedmiotow innym graczom
if (isset ($_GET['action']) && $_GET['action'] == 'items') 
{
	if (!ereg("^[1-9][0-9]*$", $_POST['id']) || !ereg("^[1-9][0-9]*$", $_POST['amount']) || !ereg("^[1-9][0-9]*$", $_POST['item'])) {
		error ("Zapomnij o tym!");
	}
	
	$items = $player -> EquipSearch( array( 'id' => $_POST['item'] ), 'backpack' );
	//print_r( $items );
	if( empty( $items ) ) {
		error( "nie masz takiego przedmiotu !" );
	}
	$key = key( $items );
	$items = $items[$key];
	if ($_POST['id'] == $player -> id) {
		error ("Nie mozesz dotowac siebie!");
	}
	
	if( $dotowany->ip == $player->ip) {
		SqlExec( "INSERT INTO transfer( `from`, `to`, `what`, `amount`, `date` ) VALUES( $player->id, $dotowany->id, '{$items['prefix']} {$item['name']}', {$_POST['amount']}, ".time()." ) " );
	}

	$dotowany = new Player( $_POST['id'] );
	if( $dotowany -> created == FALSE ) {
		error( "Nie ma takiego gracza !" );
	}
	//print_r( $items );
	//error( "{$dotowany -> user}" );
	if ($items['amount'] < $_POST['amount']) {
		error ("Nie masz tyle {$items['prefix']} ".$items['name']);
	}
	
	$toadd = $items;
	$toadd['amount'] = $_POST['amount'];
	
	$dotowany -> EquipAdd( $toadd, 'backpack' );
	PutSignal( $dotowany -> id, 'back' );
	if( $items['amount'] - $_POST['amount'] < 1 ) {
		$player -> EquipDelete( $items['id'], 'backpack' );
	}
	else {
		$player -> SetEquip( 'backpack', $key, array( 'amount' => $items['amount'] - $_POST['amount'] ) );
	}
	
	SqlExec("INSERT INTO log (owner, log, czas) VALUES(".$_POST['id'].",'Gracz <b><a href=view.php?view=".$player -> id.">".$player -> user."</a> ID:".$player -> id."</b>, przekazal ci ".$_POST['amount']." {$items['prefix']} ".$items['name'].".','".$newdate."')");
	error ("Przekazales graczowi {$dotowany -> user} ".$_POST['amount']." sztuk {$items['prefix']} {$items['name']}.<a href=bank.php> Odswiez</a>",'done');
	
}

//! wycofywanie zlota z banku
if (isset ($_GET['action']) && $_GET['action'] == 'withdraw') {
	if (!isset($_POST['with'])) {
		error("Podaj ile zlota chcesz zabrac z banku");
	}
	if ($_POST['with'] > $player -> bank || !ereg("^[1-9][0-9]*$", $_POST['with'])) {
	error ("Nie mozesz wycofac az tyle.");
	}
	//$db -> Execute("UPDATE players SET credits=credits+".$_POST['with']." WHERE id=".$player -> id);
	//$db -> Execute("UPDATE players SET bank=bank-".$_POST['with']." WHERE id=".$player -> id);
	$player -> gold += $_POST['with'];
	$player -> bank -= $_POST['with'];
	error ("Wycofales ".$_POST['with']." sztuk zlota.",'done');
}

//! deponowanie zlota w banku
if (isset ($_GET['action']) && $_GET['action'] == 'deposit') {
	if (!isset($_POST['dep'])) {
		error ("Podaj ile zlota chcesz zdeponowac w banku");
	}
	if ($_POST['dep'] > $player -> gold || $_POST['dep'] <= 0 || !ereg("^[1-9][0-9]*$", $_POST['dep'])) {
		error ("Nie mozesz zdeponowac az tyle.");
	}
	//$db -> Execute("UPDATE players SET credits=credits-".$_POST['dep']." WHERE id=".$player -> id);
	//$db -> Execute("UPDATE players SET bank=bank+".$_POST['dep']." WHERE id=".$player -> id);
	$player -> gold -= $_POST['dep'];
	$player -> bank += $_POST['dep'];
	error ("Zdeponowales ".$_POST['dep']." sztuk zlota.",'done');
}

	//! dawanie zlota innemmu graczowi
if (isset ($_GET['action']) && $_GET['action'] == 'dotacja') 
{ 
	if (!isset($_POST['id'])) 
	{
		error("Podaj ID gracza ktoremu chcesz wyslac zloto!");
	}
	if (!isset($_POST['with'])) 
	{
		error("Podaj ile zlota chcesz wyslac");
	}
	if (!ereg("^[1-9][0-9]*$", $_POST['id'])) 
	{
	error ("Zapomnij o tym!");
	}
	if ($_POST['with'] > $player -> bank || $_POST['with'] <= 0 || !ereg("^[1-9][0-9]*$", $_POST['with'])) 
	{
		error ("Nie mozesz dac az tyle.");
	}
	if ($player -> bank < 0)
	{
		error("Nie mozesz dawac zlota innym graczom kiedy masz ujemne zloto w rece!");
	}
	if ($_POST['id'] == $player -> id) 
	{
	error ("Nie mozesz dotowac siebie!");
	}
	
	$dotowany = $db -> Execute("SELECT id,ip FROM players WHERE id=".$_POST['id']);
	if (empty ($dotowany -> fields['id'])) {
		error ("Nie ma takiego gracza!");
	}
	if( $dotowany -> fields['ip'] == $player->ip) {
		SqlExec( "INSERT INTO transfer( `from`, `to`, `what`, `amount`, `date` ) VALUES( '$player->id', '{$dotowany->fields['id']}', 'gold', '{$_POST['with']}', '".time()."' ) " );
	}
	
	
		SqlExec("UPDATE resources SET bank=bank+'".$_POST['with']."' WHERE id='".$_POST['id']."'");
		PutSignal( $_POST['id'], 'res' );
	//	$db -> Execute("UPDATE players SET bank=bank-".$_POST['with']." WHERE id=".$player -> id);
		$player -> bank -= $_POST['with'];
		$db -> Execute("INSERT INTO log (owner, log, czas) VALUES(".$_POST['id'].",'Gracz <b><a href=view.php?view=".$player -> id.">".$player -> user."</a> ID:".$player -> id."</b>, przekazal ci ".$_POST['with']." sztuk zlota.','".$newdate."')");
		$db -> Execute("INSERT INTO log (owner, log, czas) VALUES(".$player -> id.",'Przekazales graczowi  ID:".$_POST['id']."</b> ".$_POST['with']." sztuk zlota.','".$newdate."')");
	error ("Dales ".$_POST['with']." sztuk zlota graczowi ID ".$_POST['id'],'done');
}


//! okradanie banku
if (isset ($_GET['action']) && $_GET['action'] == 'steal') {
	require_once("includes/checkexp.php");
	if ($player -> crime <= 0) {
		error ("Nie mozesz probowac okradac bank, poniewaz niedawno probowales juz swoich sil!");
	}
	$roll = rand (1, ($player -> level * 100));
	$chance = ($player -> agility + $player -> inteli) - $roll;
	if ($chance < 1) {
		$cost = 1000 * $player -> level;
		$expgain = ceil($player -> level / 10);
		//checkexp($player -> exp,$expgain,$player -> level,$player -> race,$player -> user,$player -> id,0,0,$player -> id,'',0);
		//$db -> Execute("UPDATE players SET miejsce='Lochy' WHERE id=".$player -> id);
		//$db -> Execute("UPDATE players SET crime=crime-1 WHERE id=".$player-> id);
		$player -> AwardExp( $expgain );
		$player -> jail = 'Y';
		$player -> crime --;
		$insert = SqlExec("INSERT INTO jail (prisoner, verdict, duration, cost, data) VALUES(".$player -> id.",'Proba kradziezy zlota z banku w {$player->location}',1,".$cost.",'".$newdate."')");
		
		SqlExec( "INSERT INTO akta ( pid, name, dur, data, reason, cela, cost ) VALUES ({$player->id} , '{$player->user}', 1, '{$newdate}', 'Proba kradziezy zlota z banku w {$player->location}', $insert, $cost );");
		$skaz = SqlExec("SELECT name FROM skazani WHERE id={$player->id};");
		if( !empty( $skaz -> fields['name'] ) ) {
			SqlExec("UPDATE skazani SET ilosc=ilosc+1 WHERE id={$player->id};");
		}
		else {
			SqlExec("INSERT INTO skazani (id, name, ilosc) VALUES ({$player->id} ,'{$player->user}', 1);");
		}
		
		$db -> Execute("INSERT INTO log (owner, log, czas) VALUES(".$player -> id.",'Zostales wtracony do wiezienia na 1 dzien za probe okradzenia banku. Mozesz wyjsc z wiezienia za kaucja: ".$cost.".','".$newdate."')");
		error ("Kiedy probowales okrasc bank, nagle z jakiegos pokoju wyskoczyl straznik. Szybko zlapal ciebie za nadgarstek i zakul w kajdany. Obrot spraw tak ciebie zaskoczyl iz zapomniales nawet zareagowac w jakis sposob. I tak oto znalazles sie w lochach!");
	}
	if ($chance > 0) {
		//$db -> Execute("UPDATE players SET crime=crime-1 WHERE id=".$player -> id);
		$player -> crime ++;
		$gain = $player -> level * 1000;
		$expgain = ($player -> level * 10);
		//checkexp($player -> exp,$expgain,$player -> level,$player -> race,$player -> user,$player -> id,0,0,$player -> id,'',0);
		$player -> AwardExp( $expgain );
		//$db -> Execute("UPDATE players SET credits=credits+".$gain." WHERE id=".$player -> id);
		$player -> gold += $gain;
		error ("Udalo ci sie dyskretnie dostac do skarbca banku. Wyniosles z tamtad ".$gain." sztuk zlota. Nie niepokojony przez nikogo odszedles sobie spokojnie w swoja strone. To byl jednak udany dzien",'done');
	}
}

if($_GET['action']=='fixed') {
	if(empty($_POST['fixed']))
		error("Podaj ile chcesz zdeponowaæ");
	if (!ereg("^[1-9][0-9]*$", $_POST['fixed']))
		error("Podaj poprawn± warto¶æ !");
	if($player->credits < $_POST['fixed'] )
		error("Nie masz tyle pieniêdzy !");
	//$db->Execute("UPDATE players SET credits=credits-{$_POST['fixed']} WHERE id={$player->id}");
	$player -> gold -= $_POST['fixed'];
	if($_POST['time']=='7')
		$proc=0.04;
	elseif($_POST['time']=='14')
		$proc=0.06;
	elseif($_POST['time']=='21')
		$proc=0.08;
	else
		$proc=0.1;
	$sql="INSERT INTO bank (pid,type,proc,base,current,date,time) VALUES ({$player->id},'L',$proc,{$_POST['fixed']},".($_POST['fixed']+$_POST['fixed']*$proc).",".time().",".(time()+$_POST['time']*60*60*24).")";
	$db->Execute($sql)or error($sql);
	error("Zdeponowa³e¶ {$_POST['fixed']} z³ota na czas {$_POST['time']} dni",'done');
}
if($_GET['action']=='loan') {
	if($player->jail == 'Y' )
		error("Nie mo¿esz po¿yczac gdy siedzisz w wiêzieniu");
	if(empty($_POST['loan']))
		error("Podaj ile chcesz po¿yczyæ");
	if (!ereg("^[1-9][0-9]*$", $_POST['loan']))
		error("Podaj poprawn± warto¶æ !");
	if($_POST['loan']>300000)
		error("Nie mo¿esz po¿yczyæ tak du¿o");
	$test=$db->Execute("SELECT id FROM bank WHERE type='P' AND pid={$player->id}");
	$num=$test->RecordCount();
	if($num > 5 )
		error("Nie mo¿esz wzi±æ wiêcej po¿yczek");
	if($_POST['loan']<100000)
		$time=60*60*24*15;
	else
		$time=60*60*24*30;
	$sql="INSERT INTO bank (pid,type,proc,base,current,date,time) VALUES ({$player->id},'P',0.2,{$_POST['loan']},".($_POST['loan']+$_POST['loan']*0.2).",".time().",".(time()+$time).")";
	$db->Execute($sql)or error($sql);
	$db->Execute("UPDATE players SET credits=credits+{$_POST['loan']} WHERE id={$player->id}");
	error("Po¿yczy³e¶ {$_POST['loan']} z³ota",'done');
}
if($_GET['action']=='repay') {
	if(empty($_POST['lid']))
		error("Nieprawid³owy kredyt !");
	$loan=$db->Execute("SELECT * FROM bank WHERE id={$_POST['lid']}");
	if($player->gold >= $loan->fields['current']) {
		//$db->Execute("UPDATE players SET credits=credits-{$loan->fields['current']} WHERE id={$player->id}");
		$player -> gold -= $loan -> fields['current'];
		$db->Execute("DELETE FROM bank WHERE id={$_POST['lid']}");
		error("Kredyt sp³acony !",'done');
	}
	else {
		//$db->Execute("UPDATE players SET credits=0 WHERE id={$player->id}");
		$player -> gold = 0;
		$db->Execute("UPDATE bank SET current=current-{$player->gold} WHERE id={$_POST['lid']}");
		error("Sp³aci³e¶ {$player->credits} z {$loan->fields['current']} kredytu",'done');
	}
}

$depo=$db->Execute("SELECT * FROM bank WHERE type='L' AND pid={$player->id}");
$depo=$depo->GetArray();
foreach($depo as $k => $dep) {
	//$depo[$k]['date']=date("Y m d",$dep['date']);
	//print_r($depo[$k]['date']);
	//$depo[$k]['time']=date("Y m d",$dep['time']);
	print(time());
	$left = floor( ( $dep['time'] - time() ) / ( 60 * 60 * 24 ) ) + 1;
	$depo[$k]['time'] = $left;
}
$loans=$db->Execute("SELECT * FROM bank WHERE type='P' AND pid={$player->id}");
$loans=$loans->GetArray();
foreach($loans as $a => $loan) {
	$loans[$a]['date']=date("Y m d",$loan['date']);
	$loans[$a]['time']=date("Y m d",$loan['time']);
}
$smarty->assign("About",$_GET['about']);
$smarty->assign("Depo",$depo);
$smarty->assign("Loan",$loans);
$smarty -> display ('bank.tpl');

require_once("includes/foot.php");
?>
