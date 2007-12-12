<?php
/**
*   Funkcje pliku:
*   Funkcje zwiazane z zakladaniem ekwipunku oraz piciem mikstur
*
*   @name                 : functions.php                            
*   @copyright            : (C) 2004-2005 Vallheru Team based on Gamers-Fusion ver 2.5
*   @author               : thindil <thindil@users.sourceforge.net>
*   @version              : 0.7 beta
*   @since                : 06.01.2005
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

/**
* funkcja odpowiedzialna za wypicie napoju - argument $id to id uzywanego napoju 
*/
function drink($id) {
	global $player;
	global $smarty;
	global $db;
	global $title;
	
	if (!ereg("^[1-9][0-9]*$", $id)) {
	error ("Zapomnij o tym!");
	}
	$miks = $db -> Execute("SELECT * FROM mikstury WHERE status='K' AND id=".$id);
	if (empty ($miks -> fields['id'])) {
		error ("Nie ta rzecz.\n");
	}
	if ($player -> id != $miks -> fields['gracz']) {
		error ("Nie posiadasz tego przedmiotu.\n");
	}
	if ($miks -> fields['typ'] == 'M') {
		$cape = $db -> Execute("SELECT power FROM equipment WHERE owner=".$player -> id." AND type='Z' AND status='E'");		
		$maxmana = ($player -> inteli + $player -> wisdom);
		$maxmana = $maxmana + (($cape -> fields['power'] / 100) * $maxmana);
		$cape -> Close();
			if ($player -> mana == round($maxmana,0)) {
				if ($title == 'Ekwipunek')
				{
					error("Nie musisz regenerowac punktow magii!");
				}
					else
				{
					$message = "Nie musisz regenerowac punktow magii";
				}
			}
			if (!isset($message))
			{
				if ($player->mana + $miks -> fields['moc'] >= $maxmana ) 
				{
					$db -> Execute("UPDATE players SET pm=".$maxmana." WHERE id=".$player -> id);
					$player -> mana = $maxmana;
					$efekt = "odzyskales wszystkie punkty magii";
				} 
					else 
				{
					$moc = $miks -> fields['moc'];
					$db -> Execute("UPDATE players SET pm=pm+".$moc." WHERE id=".$player -> id);
					$efekt = "odzyskales ".$moc." punktow magii";
					$player -> mana = $moc;
				}
			}
	}
	if ($miks -> fields['typ'] == 'Z') {
		if ($player -> hp > 0) {
			if ($player->hp + $miks -> fields['moc'] >= $player -> max_hp ) 
				{
					$db -> Execute("UPDATE players SET hp=".$player -> max_hp." WHERE id=".$player -> id);
					$player -> hp = $player -> max_hp;
					$efekt = "odzyskales wszystkie punkty zycia";
				} 
					else 
				{
					$moc = $miks -> fields['moc'];
					$db -> Execute("UPDATE players SET hp=hp+".$moc." WHERE id=".$player -> id);
					$efekt = "odzyskales ".$moc." punktow zycia";
					$player -> hp = $moc;
				}
		} else {
			error ("Potrzebujesz mikstury wskrzeszajacej aby sie uleczyc!");
		}
	}
	if ($miks -> fields['typ'] == 'W') {
		if ($player -> hp <= 0) {
			$pd = $player -> exp - ceil($player -> exp / 100) * 2;
			//$pdpr = ($pdpr1 * 2);
			//$pd = ($player -> exp - $pdpr);
			$moc = $miks -> fields['moc'];
			$db -> Execute("UPDATE players SET exp=".$pd." WHERE id=".$player -> id);
			$db -> Execute("UPDATE players SET hp=$moc WHERE id=".$player -> id);
			$efekt = "wrociles do zycia ale straciles ".$pdpr." punktow doswiadczenia";
		} else {
			error ("Nie musisz sie wskrzeszac!");
		}
	}
		if (!isset($message))
		{
			$amount = $miks -> fields['amount'] - 1;
			if ($amount < 1) 
			{
				$db -> Execute("DELETE FROM mikstury WHERE id=".$miks -> fields['id']);
			} 
				else 
			{
				$db -> Execute("UPDATE mikstury SET amount=".$amount." WHERE id=".$miks -> fields['id']);
			}
			$smarty -> assign("Message", "Wypiles ".$miks -> fields['nazwa']." i $efekt.");
		}
			else
		{
			$smarty -> assign("Message", $message);
		}
	$smarty -> display ('error1.tpl');
	$miks -> Close();	
}

// funkcja odpowiedzialna za zakladanie ekwipunku
function equip ($id) {
	global $player;
	global $smarty;
	global $db;
	if (!ereg("^[1-9][0-9]*$", $id)) {
		error ("Zapomnij o tym!");
	}
	$equip = $db -> Execute("SELECT * FROM equipment WHERE id=".$id." AND status='U'");
	if (empty ($equip -> fields['id'])) {
		error ("Nie ta rzecz.\n");
	}
	if ($player -> id != $equip -> fields['owner']) {
		error ("Nie posiadasz tego przedmiotu.\n");
	}
	if ($player -> level < $equip -> fields['minlev']) {
		error ("Nie masz odpowiednio wysokiego poziomu!\n");
	}
	if ($player -> clas == 'Barbarzynca' && $equip -> fields['magic'] == 'Y') {
		error ("Nie mozesz uzywac magicznych przedmiotow poniewaz jesteœ barbarzync¹!");
	}
	if ($player -> clas == 'Barbarzynca' && ($equip -> fields['type'] == 'S' || $equip -> fields['type'] == 'Z')) {
		error ("Nie mozesz uzywac tego typu przedmiotow poniewaz jesteœ barbarzync¹!");
	}
	$type = $equip -> fields['type'];
	if ($type == 'D') {
		$test = $db -> Execute("SELECT id FROM equipment WHERE status='E' AND twohand='Y' AND owner=".$player -> id);
		if (!empty ($test -> fields['id'])) {
			error ("Nie mozesz zalozyc tarczy poniewaz uzywasz broni dwurecznej!\n");
		}
		$test -> Close();
	}
	if ($equip -> fields['twohand'] == 'Y') {
		$test = $db -> Execute("SELECT id FROM equipment WHERE status='E' AND type='D' AND owner=".$player -> id);
		if (!empty ($test -> fields['id'])) {
			error ("Nie mozesz uzywac broni dwurecznej poniewaz masz zalozana tarcze!\n");
		}
		$test -> Close();
	}
	if ($type == 'R') {
			
		$test = $db -> Execute("SELECT id FROM equipment WHERE `type`='B' AND `status`='E' AND owner=".$player -> id);
		if (empty($test -> fields['id'])) {
			error ("Nie mozesz uzywac strzal poniewaz nie masz zalozonego luku!\n");
		}
		$test -> Close();
		/*if ($equip -> fields['wt'] > 20) {
			$wt = 20;
		} else {
			$wt = $equip -> fields['wt'];
		}
		$arrows = $db -> Execute("SELECT id, name, wt FROM equipment WHERE `type`='R' AND owner=".$player -> id." AND `status`='E'");
		if (empty($arrows -> fields['id'])) {
			$db -> Execute("INSERT INTO equipment (name, wt, power, `status`, `type`, owner) VALUES('".$equip -> fields['name']."',".$wt.",".$equip -> fields['power'].",'E','R',".$player -> id.")") or error("Nie moge zalozyc strzal");
			$testwt = ($equip -> fields['wt'] - $wt);
			if ($testwt < 1) {
					$db -> Execute("DELETE FROM equipment WHERE id=".$equip -> fields['id']);
			} else {
					$db -> Execute("UPDATE equipment SET wt=".$testwt." WHERE id=".$equip -> fields['id']);
			}
		}*/
		$test=$db -> Execute("SELECT id FROM equipment WHERE `type`='R' AND owner=".$player -> id." AND `status`='E'");
		if($test->fields['id'])
			error("Zdejmij najpierw strza³y !");
		if($equip->fields['amount'] == 1 ) {
			//echo "UPDATE equipment SET `status`='U' WHERE id=$id<BR>";
			$db->Execute("UPDATE equipment SET `status`='E' WHERE id=$id")or error("shit");;
		}
		else {
			$db->Execute("UPDATE equipment SET amount=amount-1 WHERE id=$id");
			$db -> Execute("INSERT INTO equipment (name, wt, power, `status`, `type`, owner) VALUES('".$equip -> fields['name']."',{$equip->fields['wt']}, ".$equip -> fields['power'].",'E','R',".$player -> id.")") or error("Nie moge zalozyc strzal");
		}
		
		
	}
	if ($type == 'W' || $type == 'B' || $type == 'S') {
		if ($type == 'W' || $type == 'S') {
				if (isset($arrows -> fields['id'])) {
				$test = $db -> Execute("SELECT id FROM equipment WHERE name='".$arrows -> fields['name']."' AND status='U' AND owner=".$player -> id);
				}
			if (empty ($test -> fields['id'])) {
				$db -> Execute("UPDATE equipment SET status='U' WHERE type='R' AND owner=".$player -> id." AND status='E'");
			} else {
				$db -> Execute("UPDATE equipment SET wt=wt+".$arrows -> fields['wt']." WHERE id=".$test -> fields['id']);
				$db -> Execute("DELETE FROM equipment WHERE id=".$arrows -> fields['id']);
			}
			if (isset($test -> fields['id'])) {
				$test -> Close();
			}
		}
		$test = $db -> Execute("SELECT id FROM equipment WHERE status='E' AND type='".$type."' AND owner=".$player -> id);
		if (empty($test -> fields['id'])) {
			if ($type == 'W') {
				$type = 'B';
				$test1 = $db -> Execute("SELECT id FROM equipment WHERE status='E' AND type='".$type."' AND owner=".$player -> id);
				if (empty ($test1 -> fields['id'])) {
					$type = 'S';
				}
				$test1 -> Close();
			} elseif ($type == 'B') {
				$type = 'W';
				$test1 = $db -> Execute("SELECT id FROM equipment WHERE status='E' AND type='".$type."' AND owner=".$player -> id);
				if (empty ($test1 -> fields['id'])) {
					$type = 'S';
				}
				$test1 -> Close();
			} elseif ($type == 'S') {
				$type = 'W';
				$test1 = $db -> Execute("SELECT id FROM equipment WHERE status='E' AND type='".$type."' AND owner=".$player -> id);
				if (empty ($test1 -> fields['id'])) {
					$type = 'B';
				}
				$test1 -> Close();
			}
		}
		$test -> Close();
	}
	if ($type == 'Z' || $type == 'A') {
		$test = $db -> Execute("SELECT id, power FROM equipment WHERE status='E' AND type='".$type."' AND owner=".$player -> id);
		if (empty ($test -> fields['id'])) {
			if ($type == 'Z') {
				$type = 'A';
			} else {
				$type = 'Z';
			}
		}
		$test -> Close();
	}
	if ($equip -> fields['type'] != 'R') {
		$amount = $equip -> fields['amount'] - 1;
		if ($amount > 0) {
			$db -> Execute("UPDATE equipment SET amount=amount-1 WHERE name='".$equip -> fields['name']."' AND wt=".$equip -> fields['wt']." AND type='".$equip -> fields['type']."' AND status='U' AND owner=".$player -> id." AND power=".$equip -> fields['power']." AND zr=".$equip -> fields['zr']." AND szyb=".$equip -> fields['szyb']." AND maxwt=".$equip -> fields['maxwt']." AND poison=".$equip -> fields['poison']);
		} else {
			$db -> Execute("DELETE FROM equipment WHERE id=".$equip -> fields['id']);
		}
		$test2 = $db -> Execute("SELECT * FROM equipment WHERE status='E' AND owner=".$player -> id." AND type='".$type."'");
		if (!empty($test2 -> fields['id'])) {
			$test = $db -> Execute("SELECT id FROM equipment WHERE name='".$test2 -> fields['name']."' AND wt=".$test2 -> fields['wt']." AND status='U' AND owner=".$player -> id." AND power=".$test2 -> fields['power']." AND zr=".$test2 -> fields['zr']." AND szyb=".$test2 -> fields['szyb']." AND maxwt=".$test2 -> fields['maxwt']." AND poison=".$test2 -> fields['poison']);
			if (!empty($test -> fields['id'])) {
				$db -> Execute("UPDATE equipment SET amount=amount+1 WHERE name='".$test2 -> fields['name']."' AND wt=".$test2 -> fields['wt']." AND status='U' AND owner=".$player -> id." AND power=".$test2 -> fields['power']." AND zr=".$test2 -> fields['zr']." AND szyb=".$test2 -> fields['szyb']." AND maxwt=".$test2 -> fields['maxwt']." AND poison=".$test2 -> fields['poison']);
			} else {
				$db -> Execute("INSERT INTO equipment (owner, name, power, type, cost, zr, wt, minlev, maxwt, amount, magic, poison, szyb, twohand) VALUES(".$player -> id.",'".$test2 -> fields['name']."',".$test2 -> fields['power'].",'".$test2 -> fields['type']."',".$test2 -> fields['cost'].",".$test2 -> fields['zr'].",".$test2 -> fields['wt'].",".$test2 -> fields['minlev'].",".$test2 -> fields['maxwt'].",1,'".$test2 -> fields['magic']."',".$test2 -> fields['poison'].",".$test2 -> fields['szyb'].",'".$test2 -> fields['twohand']."')") or error("nie moge zdjac!");
			}
			$db -> Execute("DELETE FROM equipment WHERE type='".$type."' AND status='E' AND owner=".$player -> id);
		}
		$db -> Execute("INSERT INTO equipment (owner, name, power, type, cost, zr, wt, minlev, maxwt, amount, magic, poison, szyb, status, twohand) VALUES(".$player -> id.",'".$equip -> fields['name']."',".$equip -> fields['power'].",'".$equip -> fields['type']."',".$equip -> fields['cost'].",".$equip -> fields['zr'].",".$equip -> fields['wt'].",".$equip -> fields['minlev'].",".$equip -> fields['maxwt'].",0,'".$equip -> fields['magic']."',".$equip -> fields['poison'].",".$equip -> fields['szyb'].",'E','".$equip -> fields['twohand']."')") or error("nie moge zalozyc!");
		$test2 -> Close();
	}
	$smarty -> assign ("Message", "Wziales ".$equip -> fields['name'].".");
	$smarty -> display ('error1.tpl');
	$equip -> Close();
}

