<?php
/***************************************************************************
 *                               preset.php
 *                            -------------------
 *   copyright            : (C) 2004 Vallheru Team based on Gamers-Fusion ver 2.5
 *   email                : thindil@users.sourceforge.net
 *
 ***************************************************************************/

/***************************************************************************
 *
 *       This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with this program; if not, write to the Free Software
 *   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 ***************************************************************************/

require 'libs/Smarty.class.php';
require_once ('includes/config.php');

$smarty = new Smarty;

$smarty->compile_check = true;

if (isset ($_GET['id'])) {
	if (!ereg("^[1-9][0-9]*$", $_GET['id'])) {
		$smarty -> assign ("Error", "Zapomnij o tym.");
		$smarty -> display ('error.tpl');
		exit;
	}
	if (!isset ($_GET['code'])) {
		$db -> Execute("DELETE FROM reset WHERE player=".$_GET['id']);
		$smarty -> assign ("Error", "Proba resetu zostala anulowana.");
		$smarty -> display ('error.tpl');
	} else {
		if (!ereg("^[1-9][0-9]*$", $_GET['code'])) {
			$smarty -> assign ("Error", "Zapomnij o tym.");
			$smarty -> display ('error.tpl');
			exit;
		}
		$reset = $db -> Execute("SELECT id FROM reset WHERE player=".$_GET['id']." AND code=".$_GET['code']);
		if (!$reset -> fields['id']) {
			$smarty -> assign ("Error", "Nie ma takiego zgloszenia.");
			$smarty -> display ('error.tpl');
			exit;
		}
	$reset -> Close();
	$db -> Execute("DELETE FROM core WHERE owner=".$_GET['id']);
	$db -> Execute("DELETE FROM core_market WHERE seller=".$_GET['id']);
	$db -> Execute("DELETE FROM equipment WHERE owner=".$_GET['id']);
	$db -> Execute("DELETE FROM kowal WHERE gracz=".$_GET['id']);
	$db -> Execute("DELETE FROM log WHERE owner=".$_GET['id']);
	$db -> Execute("DELETE FROM mail WHERE owner=".$_GET['id']);
	$db -> Execute("DELETE FROM outposts WHERE owner=".$_GET['id']);
	$db -> Execute("DELETE FROM pmarket WHERE seller=".$_GET['id']);
	$db -> Execute("DELETE FROM hmarket WHERE seller=".$_GET['id']);
	$db -> Execute("DELETE FROM mikstury WHERE gracz=".$_GET['id']);
	$db -> Execute("DELETE FROM sorowce WHERE gracz=".$_GET['id']);
	$db -> Execute("DELETE FROM alchemik WHERE gracz=".$_GET['id']);
	$db -> Execute("DELETE FROM czary WHERE gracz=".$_GET['id']);
	$db -> Execute("DELETE FROM kowal_praca WHERE gracz=".$_GET['id']);
	$db -> Execute("DELETE FROM notatnik WHERE gracz=".$_GET['id']);
	$db -> Execute("DELETE FROM tribe_oczek WHERE gracz=".$_GET['id']);
	$db -> Execute("DELETE FROM mill WHERE owner=".$_GET['id']);
	$db -> Execute("DELETE FROM mill_work WHERE gracz=".$_GET['id']);
	$db -> Execute("UPDATE players set level=1 WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set exp=0 WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set credits=0 WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set energy=0 WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set max_energy=5 WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set strength=3 WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set agility=3 WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set ap=5 WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set mithril=0 WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set hp=15 WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set max_hp=15 WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set bank=0 WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set ability=0.01 WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set corepass='N' WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set trains=5 WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set inteli=3 WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set pw=0 WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set atak=0.01 WHERE id=".$_GET['id']);
	
	$db -> Execute("UPDATE players set ugryziony=0 WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set ilosc_ugryz=0 WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set krew=30 WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set max_krew=30 WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set ugryz=5 WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set przez='0' WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set przemieniony_przez='' WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set unik=0.01 WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set magia=0.01 WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set immu='N' WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set pm=6 WHERE id=".$_GET['id']);
	//$db -> Execute("UPDATE players set miejsce='Altara' WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set szyb=3 WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set wytrz=3 WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set alchemia=0.01 WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set wisdom=3 WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set shoot=0.01 WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set fletcher=0.01 WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set rasa='' WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set klasa='' WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set deity='' WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set tow='' WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set jail='N' WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set oczy='' WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set skora='' WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set wlos='' WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set gender='' WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players set leadership=0.01 WHERE id=".$_GET['id']);
	$db -> Execute("UPDATE players SET kat='0'");
	$db -> Execute("DELETE FROM farms WHERE owner=".$_GET['id']);
	$db -> Execute("DELETE FROM farm WHERE owner=".$_GET['id']);
	$db -> Execute("DELETE FROM houses WHERE owner=".$_GET['id']);
	$db -> Execute("DELETE FROM reset WHERE players=".$_GET['id']." and code=".$_GET['code']);
	$db -> Execute("DELETE FROM jail WHERE prisoner=".$_GET['id']);
	$db -> Execute("DELETE FROM questaction WHERE player=".$_GET['id']);
	$db -> Execute("DELETE FROM bank WHERE pid=".$_GET['id']);
	$db -> Execute("DELETE FROM mines WHERE pid=".$_GET['id']);
	$smarty -> assign ("Error", "Postac zostala zresetowana.");
	$smarty -> display ('error.tpl');
	}
}
$db->Close();
?>
