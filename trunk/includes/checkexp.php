<?php
// Funkcja sprawdzajaca czy postac zdobyla tyle pd aby awansowac na poziom
function checkexp ($exp,$expgain,$level,$rasa,$user,$eid,$enemyid,$enemyuser,$player,$skill,$amount) {
	global $db;
	global $newdate;
	
	global $player;
	$poziom = 0;
	$ap = 0;
	$pz = 0;
	$energia = 0;
	$texp = ($exp + $expgain);
	/*if ($level < 100) {
		$expn = (pow($level,2) * 100);
	}
	if ($level > 99 && $level < 200) {
		$expn = (pow($level,2) * 500);
	}
	if ($level > 199 && $level < 300) {
		$expn = (pow($level,2) * 1000);
	}
	if ($level > 299 && $level < 400) {
		$expn = (pow($level,2) * 2000);
	}
	if ($level > 399 && $level < 500) {
		$expn = (pow($level,2) * 5000);
	}
	if ($level > 499 && $level < 600) {
		$expn = (pow($level,2) * 10000);
	}
	if ($level > 599 && $level < 700) {
		$expn = (pow($level,2) * 20000);
	}
	if ($level > 699 && $level < 800) {
		$expn = (pow($level,2) * 50000);
	}
	if ($level > 799 && $level < 900) {
		$expn = (pow($level,2) * 100000);
	}
	if ($level > 899 && $level < 1000) {
		$expn = (pow($level,2) * 200000);
	}*/
	$expn = expnext( $level );
	$energy = $db -> Execute("select max_energy from players where id=".$eid);
	while ($texp >= $expn) {
		$poziom = ($poziom + 1);
		$ap = ($ap + 6);
		$krew=0;
		$texp = ($texp - $expn);
		$level = ($level + 1);
		/*if ($level < 100) {
				$expn = (pow($level,2) * 100);
			}
			if ($level > 99 && $level < 200) {
				$expn = (pow($level,2) * 500);
			}
			if ($level > 199 && $level < 300) {
				$expn = (pow($level,2) * 1000);
			}
			if ($level > 299 && $level < 400) {
				$expn = (pow($level,2) * 2000);
			}
			if ($level > 399 && $level < 500) {
				$expn = (pow($level,2) * 5000);
			}
			if ($level > 499 && $level < 600) {
				$expn = (pow($level,2) * 10000);
			}
			if ($level > 599 && $level < 700) {
				$expn = (pow($level,2) * 20000);
			}
			if ($level > 699 && $level < 800) {
				$expn = (pow($level,2) * 50000);
			}
			if ($level > 799 && $level < 900) {
				$expn = (pow($level,2) * 100000);
			}
			if ($level > 899 && $level < 1000) {
				$expn = (pow($level,2) * 200000);
			}*/
		$expn = expnext( $level );
		if ($rasa == 'Czlowiek') {
			$pz = ($pz + 5);
		}
		if ($rasa == 'Elf') {
			$pz = ($pz + 4);
		}
		if ($rasa == 'Krasnolud') {
			$pz = ($pz + 6);
		}
		if ($rasa == 'Hobbit') {
			$pz = ($pz + 3);
		}
		if ($rasa == 'Jaszczuroczlek') {
			$pz = ($pz + 5);
		}
		if ($rasa == 'Nieumarly') {
			$pz = ($pz + 4);
		}
			if ($rasa == 'Smokokrwisty') {
			$pz = ($pz + 5);
		}
		if ($rasa == 'Wampir') {
			$pz = ($pz + 4);
			$krew=5;
		}
		if ($rasa == 'Wilkolak') {
			$pz = ($pz + 5);
		}
		if ($rasa == 'Kurtr') {
			$pz = ($pz + 2);
		}
		if ($rasa == 'Polelf') {
			$pz = ($pz + 4);
		}
		if ($rasa == 'Polork') {
			$pz = ($pz + 7);
		}
		if ($rasa == 'Drow') {
			$pz = ($pz + 5);
		}
		if ($rasa == 'Nimfa') {
			$pz = ($pz + 3);
		}
		$energia = $energia + 0.3;
		$maxenergy = $energy -> fields['max_energy'] + $energia;
		if ($maxenergy > 100) {
			$maxenergy = 100;
		}
	}
	$energy -> Close();
	if ($poziom > 0) {
		if ($player == $eid) {
			print "<br><b>Zdobyles poziom</b> ".$user.".<br>";
			print $poziom." Poziom(ow)<br>";
			print $ap." AP<br>";
			print $pz." Maksymalnych Punktow Zycia<br>";
			if ($energia > 0) {
				print $energia." Maksymalnej Energii<br>";
			}
			//$gained['exp'] = $texp;
			//$gained['level'] = $player -> level + $poziom;
			//$gained['ap'] = $player -> ap + $ap;
			//$gained['hp_max'] = $player -> GetMisc( 'hp_max', TRUE ) + $pz;
			//$gained['max_krew'] = $player -> max_krew + $krew;
			//if ($energia > 0) {
			//	$gained['energy_max'] = $maxenergy;
			//$player -> SetArray( $gained );
		}
		$db -> Execute("UPDATE players SET exp=".$texp." WHERE id=".$eid);
		$db -> Execute("UPDATE players SET level=level+".$poziom." WHERE id=".$eid);
		$db -> Execute("UPDATE players SET ap=ap+".$ap." WHERE id=".$eid);
		$db -> Execute("UPDATE players SET max_hp=max_hp+".$pz." WHERE id=".$eid);
		$db -> Execute("UPDATE players SET max_hp=max_hp+".$pz." WHERE id=".$eid);
		$db -> Execute("UPDATE players SET max_krew=max_krew+".$krew." WHERE id=".$eid);
		
		//$player -> SetArray( array( 'exp'=>$texp, 'level'=>$player
		if ($energia > 0) {
			$db -> Execute("UPDATE players SET max_energy=".$maxenergy." WHERE id=".$eid);
			//$gained['energy_max'] = $maxenergy;
		}
		
		if ($enemyid != 0) {
			$db -> Execute("INSERT INTO log (owner, log, czas) VALUES(".$eid.",'Podczas walki z <b>".$enemyuser." ID:".$enemyid."</b>, zdobywasz poziom.','".$newdate."')");
		}
		PutSignal( $eid, 'misc' );
	} else {
		$db -> Execute("UPDATE players SET exp=".$texp." WHERE id=".$eid);
		PutSignal( $eid, 'misc' );
		//$player -> SetArray( array( 'exp' => $texp ) );;
	}
	if ($amount > 0) {
		$db -> Execute("UPDATE players SET ".$skill."=".$skill."+".$amount." WHERE id=".$eid);
		//$player -> $skill += $amount;
		PutSignal( $eid, 'skills' );
	}
	
}

?>
