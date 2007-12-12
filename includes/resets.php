<?php

require_once('class/playerManager.class.php');
require_once('includes/preinit.php');

/**
* Glowny reset gry
**/
function mainreset() {
	//$time_start = getmicrotime();
//	echo "<br />";
	global $__safeMode, $__sandboxMode, $gamename, $gamemail;
	$oldopen=SqlExec("SELECT value FROM settings WHERE setting='open'");
	$oldreason=SqlExec("SELECT value FROM settings WHERE setting='close_reason'");
	SqlExec("UPDATE settings SET value='N' WHERE setting='open'");
	SqlExec("UPDATE settings SET value='Wykonywanie resetu' WHERE setting='close_reason'");
	SqlExec("TRUNCATE TABLE events");
	SqlExec("UPDATE jail SET duration=duration-1");
	SqlExec("UPDATE farm SET age=age+1");
	$players = SqlExec( "SELECT p.id, r.salary FROM players p LEFT JOIN ranks r ON r.id=p.rid" );
	$players = $players->GetArray();
	foreach( $players as $player ) {
		$pl = new playerManager( $player['id'] );
		
		$pl->addMisc( 'age', '1' );
		$pl->addMisc( 'energy', $pl->getMisc( 'energy_max' ) );
		$pl->setMisc( 'hp', $pl->getMisc( 'hp_max' ) );
		if( $pl->getMisc( 'race' ) != 'Wampir' ) {
			$pl->setMisc( 'ilosc_ugryz', '0' );
		}
		if( $pl->getMisc( 'race' ) == 'Wampir' ) {
			$pl->addMisc( 'ugryz', '1' );
			if( $pl->getMisc( 'krew' ) >= 0.5 ) {
				$pl->addMisc( 'krew', '-0.5' );
			}
		}
	
		if( $pl->getMisc( 'clas' ) == 'Zlodziej' ) {
			$pl->addMisc( 'crime', '1' );
		}
		$pl->setMisc( 'bridge', 'N' );
		$pl->setMisc( 'burdel', '0' );
		//$pl->addMisc( 'cook', '5' );
		if( $pl->getMisc( 'corepass' ) == 'Y' ) {
			$pl->addMisc( 'trains', '15' );
		}
		$pl->setMisc( 'mana', $pl->getAtr( 'int' ) + $pl->getAtr( 'wis' ) );
		
		if( date( 'w' ) == 0 && $pl->getMisc( 'rid' ) > 1 ) {
			$pl->addRes( 'bank', $player['salary'] );
		}
	}
	//SqlExec("UPDATE players SET age=age+1");
	//SqlExec("UPDATE players SET energy=energy+max_energy WHERE miejsce!='Lochy'");
	//SqlExec("UPDATE players SET hp=max_hp");
	//SqlExec("UPDATE players SET ilosc_ugryz=0 WHERE rasa!='Wampir'");
	//SqlExec("UPDATE players SET ugryz=ugryz+1 Where rasa='Wampir'");
	//SqlExec("UPDATE players SET krew=krew-0.5 WHERE rasa='Wampir' AND krew<=0.5");
	//SqlExec("UPDATE players SET crime=crime+1 WHERE klasa='Zlodziej'");
	//SqlExec("UPDATE players SET bridge='N'");
	//SqlExec("UPDATE players SET gotow=gotow+5");
	//SqlExec("UPDATE players SET trains=trains+15 WHERE corepass='Y'");
	//SqlExec("UPDATE players SET pm=inteli+wisdom");
	
	SqlExec("UPDATE outposts SET turns=turns+3");
	//SqlExec("UPDATE outposts SET tokens=tokens+100");
	$intOutSize = 1;
	$outcost = SqlExec("SELECT id, warriors, archers, catapults, gold, bcost, size from outposts");
	while (!$outcost -> EOF) {
		$cost = ($outcost -> fields['warriors'] * 7) + ($outcost -> fields['archers'] * 7) + ($outcost -> fields['catapults'] * 14);
		$query = SqlExec("SELECT id FROM outpost_monsters WHERE outpost=".$outcost -> fields['id']);
		$nummonsters = $query -> RecordCount();
		$query -> Close();
		$cost = $cost + ($nummonsters * 70);
		$query = SqlExec("SELECT id FROM outpost_veterans WHERE outpost=".$outcost -> fields['id']);
		$numveterans = $query -> RecordCount();
		$query -> Close();
		$cost = $cost + ($numveterans * 70);
		$bonus = ($cost * ($outcost -> fields['bcost'] / 100));
		$bonus = round($bonus, "0");
		$cost = $cost - $bonus;
		if ($outcost -> fields['gold'] >= $cost) {
				$tax = $outcost -> fields['gold'] - $cost;
		} else {
				$tax = 0;
				if ($outcost -> fields['gold']) {
					$lost = ($cost / $outcost -> fields['gold']);
				} else {
					$lost = 1;
				}
				if (!$outcost -> fields['gold'] == 0) {
					$arrlost[0] = $outcost -> fields['warriors'];
				} else {
					if ($outcost -> fields['warriors']) {
						$arrlost[0] = ceil($outcost -> fields['warriors'] / $lost);
					} else {
						$arrlost[0] = 0;
					}
				}
				if (!$outcost -> fields['gold']) {
					$arrlost[1] = $outcost -> fields['archers'];
				} else {
					if ($outcost -> fields['archers']) {
						$arrlost[1] = ceil($outcost -> fields['archers'] / $lost);
					} else {
						$arrlost[1] = 0;
					}
				}
				if (!$outcost -> fields['gold']) {
					$arrlost[2] = $outcost -> fields['catapults'];
				} else {
					if ($outcost -> fields['catapults']) {
						$arrlost[2] = ceil($outcost -> fields['catapults'] / $lost);
					} else {
						$arrlost[2] = 0;
					}
				}
				$arrtype = array('warriors','archers','catapults');
				for ($i = 0; $i < 3; $i++) {
					$field = $arrtype[$i];
					$maxlost = $outcost -> fields[$field];
					if ($arrlost[$i] > $maxlost) {
						$arrlost[$i] = $maxlost;
					}
					SqlExec("UPDATE outposts SET ".$arrtype[$i]."=".$arrtype[$i]."-".$arrlost[$i]." WHERE id=".$outcost -> fields['id']);
				}
		}
		SqlExec("UPDATE outposts SET gold=".$tax." WHERE id=".$outcost -> fields['id']);
		if (!$outcost -> fields['warriors'] && !$outcost -> fields['archers'])
		{
				if ($outcost -> fields['size'] > 1)
				{
					SqlExec("UPDATE outposts SET size=size-1 WHERE id=".$outcost -> fields['id']);
				}
					else
				{
					SqlExec("DELETE FROM outposts WHERE id=".$outcost -> fields['id']);
					SqlExec("DELETE FROM outpost_monsters WHERE outpost=".$outcost -> fields['id']);
					SqlExec("DELETE FROM outpost_veterans WHERE outpost=".$outcost -> fields['id']);
				}
		}
		$intOutSize = $intOutSize + $outcost -> fields['size'];
		$outcost -> MoveNext();
	}
	$outcost -> Close(); 
	SqlExec("UPDATE houses SET points=points+2");
	SqlExec("UPDATE houses SET rest='N'");
	SqlExec("UPDATE houses SET locrest='N'");
	$intMithcost = rand(100, 300);
	/**
	* Obliczenie ilosci dostepnych wojsk do zakupu w straznicach
	*/
	$intMaxtroops = $intOutSize * 20;
	$intMintroops = $intOutSize * 15;
	$intMaxspecials = $intOutSize * 10;
	$intMinspecials = $intOutSize * 7;
	$intWarriors = rand($intMintroops, $intMaxtroops);
	$intArchers = rand($intMintroops, $intMaxtroops);
	$intCatapults = rand($intMinspecials, $intMaxspecials);
	$intBarricades = rand($intMinspecials, $intMaxspecials);
	$itemid = SqlExec("SELECT id FROM mikstury WHERE gracz=0");
	while (!$itemid -> EOF) {
		$amount = rand(1,1000);
	SqlExec("UPDATE mikstury SET amount=".$amount." WHERE id=".$itemid -> fields['id']);
	$itemid -> MoveNext();
	}
	$itemid -> Close();
	SqlExec("UPDATE settings SET value='20' WHERE setting='maps'");
	$objItem = SqlExec("SELECT value FROM settings WHERE setting='item'");
	if (!$objItem -> fields['value'])
	{
		SqlExec("UPDATE settings SET value='1000000' WHERE setting='monsterhp'");
	}
	$objItem -> Close();
	SqlExec("UPDATE settings SET value='".$intMithcost."' WHERE setting='mithcost'");
	SqlExec("UPDATE settings SET value='".$intWarriors."' WHERE setting='warriors'");
	SqlExec("UPDATE settings SET value='".$intArchers."' WHERE setting='archers'");
	SqlExec("UPDATE settings SET value='".$intCatapults."' WHERE setting='catapults'");
	SqlExec("UPDATE settings SET value='".$intBarricades."' WHERE setting='barricades'");
	//SqlExec("UPDATE kopalnie SET ops=ops+5");
	$mines = SqlExec("SELECT id,oper FROM mines");
	$block=0;
	while(!$mines->EOF){
		if($mines->fields['oper']<500)
			SqlExec("UPDATE mines SET oper=oper+3 WHERE id=".$mines->fields['id']);
		else
			$block++;
		$mines->MoveNext();
	}
	echo "Kopalni ponad limit : ".$block." \n";
	
	SqlExec("UPDATE tribes SET atak='N'");
	$jail = SqlExec("SELECT id, duration, prisoner FROM jail");
	while (!$jail -> EOF) {
		if ($jail -> fields['duration'] <= 0) {
			$prs = new playerManager( $jail->fields['prisoner'] );
			$prs->setMisc( 'jail', 'N' );
			//SqlExec("UPDATE players SET jail='N' WHERE id=".$jail -> fields['prisoner']);
			SqlExec("DELETE FROM jail WHERE id=".$jail -> fields['id']);
		}
	$jail -> MoveNext();
	}
	$jail -> Close();
	$pl = SqlExec("SELECT id,user,email,lpv FROM players");
	$warns=0;
	$deleted=0;
	while(!$pl->EOF) {
		$dif=floor((time()-$pl->fields['lpv'])/(60*60*24));
		if($dif==20) {
			$message = "Twoje konto na Kara-Tur nie by³o u¿ywane ju¿ od ".$dif." dni. Za tydzieñ nast±pi kasacja tego konta je¶li nie zaczniesz siê logowaæ Przypominamy ¿e Twój login to Twój email a postaæ nazywa siê ".$pl->fields['user'].".<br>Zapraszamy na Kara-Tur<br><br>Kar-Tur Team";
			$subject = "Informacja od Wladcow na ".$gamename;
			$adress = $pl -> fields['email'];
			require('mailer/mailerconfig.php');
			$mail -> AddAddress($pl -> fields['email']);
			if (!$mail -> Send()) {
				echo "Wiadomosc do ".$pl->fields['user']." nie zostala wyslana. Blad:\n ".$mail -> ErrorInfo." \n";
			}
			$mail->ClearAddresses();
			$warns++;
		}
		if($dif>=27 && $pl->fields['id'] != '267' ) {
			$toDel = new playerManager( $pl->fields['id'] );
			$toDel->delete();
			/*SqlExec("DELETE FROM players WHERE id=".$pl->fields['id']);
			SqlExec("DELETE FROM core WHERE owner=".$pl->fields['id']);
			SqlExec("DELETE FROM core_market WHERE seller=".$pl->fields['id']);
			SqlExec("DELETE FROM equipment WHERE owner=".$pl->fields['id']);
			SqlExec("DELETE FROM kowal WHERE gracz=".$pl->fields['id']);
			SqlExec("DELETE FROM log WHERE owner=".$pl->fields['id']);
			SqlExec("DELETE FROM mail WHERE owner=".$pl->fields['id']);
			SqlExec("DELETE FROM outposts WHERE owner=".$pl->fields['id']);
			SqlExec("DELETE FROM pmarket WHERE seller=".$pl->fields['id']);
			SqlExec("DELETE FROM hmarket WHERE seller=".$pl->fields['id']);
			SqlExec("DELETE FROM mikstury WHERE gracz=".$pl->fields['id']);
		//	SqlExec("DELETE FROM sorowce WHERE gracz=".$pl->fields['id']);
			SqlExec("DELETE FROM sorowce WHERE gracz=".$pl->fields['id']);
			SqlExec("DELETE FROM alchemik WHERE gracz=".$pl->fields['id']);
			SqlExec("DELETE FROM czary WHERE gracz=".$pl->fields['id']);
			SqlExec("DELETE FROM kowal_praca WHERE gracz=".$pl->fields['id']);
			SqlExec("DELETE FROM notatnik WHERE gracz=".$pl->fields['id']);
			SqlExec("DELETE FROM tribe_oczek WHERE gracz=".$pl->fields['id']);
			SqlExec("DELETE FROM houses WHERE owner=".$pl->fields['id']);
			SqlExec("DELETE FROM farms WHERE owner=".$pl->fields['id']);
			SqlExec("DELETE FROM farm WHERE owner=".$pl->fields['id']);
			SqlExec("DELETE FROM jail WHERE prisoner=".$pl->fields['id']);
			SqlExec("DELETE FROM mill_work WHERE gracz=".$pl->fields['id']);
			SqlExec("DELETE FROM mill WHERE owner=".$pl->fields['id']);
			SqlExec("DELETE FROM mines WHERE pid=".$pl->fields['id']);*/
			$deleted++;
		}
		$pl->MoveNext();
	}
	echo "Wyslanych ostrzezen: ".$warns." \n";
	echo "Skasowanych kont : ".$deleted." \n";
	//SqlExec("UPDATE toplista SET `1v`='N', `2v`='N', `3v`='N', `4v`='N', `5v`='N', `6v`='N', `7v`='N', `8v`='N', `9v`='N', `10v`='N'");
//POPRAWione ... 
	SqlExec( "DELETE FROM toplista WHERE `key`='vote'" );
//	SqlExec("DELETE FROM mail WHERE time < ".$db->DBTimeStamp( (time()-60*60*24*7) ) );
	SqlExec("DELETE FROM aktywacja WHERE data < ".date( "Y-m-d", time()-60*60*24*30 ) );//$db::DBDate( (time()-60*60*24*30) ) );
	$time = date("H:i:s");
	$data = date("y-m-d");
	$hour = explode(":", $time);
	$day = explode("-",$data);
	$newhour = $hour[0] + 1;
	if ($newhour > 23) {
		$newhour = $newhour - 24;
		$day[2] = $day[2]+1;
	}
	$arrtime = array($newhour, $hour[1], $hour[2]);
	$arrdate = array($day[0], $day[1], $day[2]);
	$newtime = implode(":",$arrtime);
	$newdata = implode("-",$arrdate);
	$arrtemp = array($newdata, $newtime);
	$newdate = implode(" ",$arrtemp);
	$loans = SqlExec("SELECT * FROM bank WHERE type='P' AND time < ".time());
	$loans=$loans->GetArray();
	foreach($loans as $loan) {
		echo "Gracz o ID {$loan['pid']} zalega z platnosciami {$loan['current']} sztuk zlota ! \n";
	}
	/*$loans = SqlExec("SELECT * FROM bank WHERE type='P' AND time < ".time());
	$loans=$loans->GetArray();
	foreach($loans as $loan) {
		$cash=SqlExec("SELECT credits,bank FROM players WHERE id={$loan['pid']}");
		if($cash->fields['credits']+$cash->fields['bank'] > $loan['current']) {
			$cash->fields['credits']-=$loan['current'];
			if($cash->fields['credits'] >=0 )
				SqlExec("UPDATE players SET credits=credits-{$loan['current']} WHERE id={$loan['pid']}");
				echo "Graczowi {$loan['id']} odebrano piendze na sacenie kredytu !");
			else {
				SqlExec("UPDATE players SET credits=0 WHERE id={$loan['pid']}");
				if($loan['current']>0) {
					//$loan
				}
			}
		}
		else {
			$ene=SqlExec("SELECT energy,`max_energy` FROM players WHERE id={$loan['pid']}");
			$stawka=rand(140,160);
			$tmp = SqlExec("INSERT INTO jail (prisoner, verdict, duration, cost, data) VALUES({$loan['pid']},'',{$time},{$loan['current']},'{$newdate}')") or error ("nie moge dodac wpisu!");
			$idcela = $db -> Insert_ID();
			SqlExec("UPDATE players SET miejsce='Lochy' WHERE id={$loan['pid']}");
			SqlExec("INSERT INTO log (owner, log, czas) VALUES({$_POST['prisoner']},'Zostales wtracony do wiezienia na ".$_POST['time']." dni za XXX . Mozesz wyjsc z wiezienia za kaucja: XXX','{$newdate}')");
			
			$pl = SqlExec("SELECT user FROM players WHERE id={$loan['pid']};");
			SqlExec("INSERT INTO akta ( pid, name, dur, data, reason, cela, cost ) VALUES ({$loan['pid']} , '{$pl->fields['user']}', ".$_POST['time'].", '".$newdate."', 'XXX', ".$idcela.",{$loan['current']} );");
			$skaz = SqlExec("SELECT name FROM skazani WHERE id={$loan['pid']};");
			if($skaz -> fields['name']!='') {
				SqlExec("UPDATE skazani SET ilosc=ilosc+1 WHERE id={$loan['pid']};")or die("UPDATE skazani SET ilosc=ilosc+1 WHERE id={$loan['pid']};");
				$skaz->Close();
			}
			else
				SqlExec("INSERT INTO skazani (id, name, ilosc) VALUES ({$loan['pid']} ,'{$pl->fields['user']}', 1);")or die("INSERT INTO skazani (id, name, ilosc) VALUES ({$loan['pid']} ,'{$pl->fields['user']}', 1);");
			$pl->Close();
			echo "Gracz o ID: {$loan['pid']} zostal wtracony do wiezienia na ".$_POST['time']." dni";
		}
	}*/
	SqlExec("ALTER TABLE `players`  ORDER BY `id`");
	
	echo "Wykonywanie resetow modulow\n";
	$mods = SqlExec( "SELECT id,name,checked FROM modules" );
	$mods = $mods -> GetArray();
	foreach ($mods as $mod) {
		$file = "modules/{$mod['name']}/inc/KT.reset.inc.php";
		if( file_exists( $file ) ) {
			$__safeMode = true;
			
			if ( $mod['checked'] != 1 ) {
				$__sandboxMode = true;
			}
			echo "Modul : {$mod['name']}\n";
			require_once ( $file );
			ob_start();
			$fname = "KT_".str_replace( '-', '_', $mod['name'] )."_reset";
			if( function_exists( $fname ) ) {
				$fname( 'day' );
			}
			$result = ob_get_clean();
			$__sandboxMode = false;
			$__safeMode = false;
			$result = str_replace( "'", "&#039;", $result );
			SqlExec( "UPDATE modules SET resetDay='{$result}' WHERE id={$mod['id']}" );
			$result = str_replace( "\n", "\n\t", $result );
			$result = "\t".$result."\n";
			echo $result;
		}
	}
	
	SqlExec("UPDATE settings SET value='Y' WHERE setting='open'");
	SqlExec("UPDATE settings SET value='' WHERE setting='close_reason'");
	//$time_end = getmicrotime();
	//$time = $time_end - $time_start;
	echo "Duzy reset zakonczony o : ",date("H:i:s")," \n";
}

/**
* Zwykle resety w ciagu dnia
*/
function smallreset() {
	//$time_start = getmicrotime();
//	echo "<BR>";
	global $__safeMode, $__sandboxMode;
	$oldopen= SqlExec("SELECT value FROM settings WHERE setting='open'");
	$oldreason=SqlExec("SELECT value FROM settings WHERE setting='close_reason'");
	SqlExec("UPDATE settings SET value='N' WHERE setting='open'");
	SqlExec("UPDATE settings SET value='Wykonywanie resetu' WHERE setting='close_reason'");
	SqlExec("TRUNCATE TABLE events");
	$itemid = SqlExec("SELECT id FROM mikstury WHERE gracz=0");
	while (!$itemid -> EOF) {
		$amount = rand(1,1000);
		SqlExec("UPDATE mikstury SET amount=".$amount." WHERE id=".$itemid -> fields['id']);
		$itemid -> MoveNext();
	}
	$itemid -> Close();
	/**
	* Obliczenie ilosci dostepnych wojsk do zakupu w straznicach
	*/
	$intOutSize = 1;
	$objOutpost = SqlExec("SELECT size FROM outposts");
	while (!$objOutpost -> EOF)
	{
		$intOutSize = $intOutSize + $objOutpost -> fields['size'];
		$objOutpost -> MoveNext();
	}
	$objOutpost -> Close();
	$intMaxtroops = $intOutSize * 20;
	$intMintroops = $intOutSize * 15;
	$intMaxspecials = $intOutSize * 10;
	$intMinspecials = $intOutSize * 7;
	$intWarriors = rand($intMintroops, $intMaxtroops);
	$intArchers = rand($intMintroops, $intMaxtroops);
	$intCatapults = rand($intMinspecials, $intMaxspecials);
	$intBarricades = rand($intMinspecials, $intMaxspecials);
	SqlExec("UPDATE settings SET value='20' WHERE setting='maps'");
	$objItem = SqlExec("SELECT value FROM settings WHERE setting='item'");
	if (!$objItem -> fields['value'])
	{
		SqlExec("UPDATE settings SET value='1000000' WHERE setting='monsterhp'");
	}
	$objItem -> Close();
	$objWarriors = SqlExec("SELECT value FROM settings WHERE setting='warriors'");
	$objArchers = SqlExec("SELECT value FROM settings WHERE setting='archers'");
	$objCatapults = SqlExec("SELECT value FROM settings WHERE setting='catapults'");
	$objBarricades = SqlExec("SELECT value FROM settings WHERE setting='barricades'");
	$intWarriors = $intWarriors + $objWarriors -> fields['value'];
	$intArchers = $intArchers + $objArchers -> fields['value'];
	$intCatapults = $intCatapults + $objCatapults -> fields['value'];
	$intBarricades = $intBarricades + $objBarricades -> fields['value'];
	$objWarriors -> Close();
	$objArchers -> Close();
	$objCatapults -> Close();
	$objBarricades -> Close();
	SqlExec("UPDATE settings SET value='".$intWarriors."' WHERE setting='warriors'");
	SqlExec("UPDATE settings SET value='".$intArchers."' WHERE setting='archers'");
	SqlExec("UPDATE settings SET value='".$intCatapults."' WHERE setting='catapults'");
	SqlExec("UPDATE settings SET value='".$intBarricades."' WHERE setting='barricades'");
	
	$players = SqlExec( "SELECT id FROM players" );
	$players = $players->GetArray();
	foreach( $players as $player ) {
		$pl = new playerManager( $player['id'] );
		
		if( $pl->getMisc( 'jail' ) == 'N' ) {
			$pl->addMisc( 'energy', $pl->getMisc( 'energy_max' ) );
			if( $pl->getMisc( 'clas' ) == 'Zlodziej' ) {
				$pl->addMisc( 'crime', '1' );
			}
		}
		$pl->setMisc( 'hp', $pl->getMisc( 'hp_max' ) );
		
		if( $pl->getMisc( 'race' ) == 'Wampir' && $pl->getMisc( 'krew' ) >= 0.5 ) {
			//$pl->SqlDebug = true;
			$pl->addMisc( 'krew', '-0.5' );
			//$pl->SqlDebug = false;
		}
		
		$pl->setMisc( 'bridge', 'N' );
		$pl->setMisc( 'kuchnia', '0' );
		if( $pl->getMisc( 'corepass' ) == 'Y' ) {
			//$pl->addMisc( 'trains', '15' );
		}
		$pl->setMisc( 'mana', $pl->getAtr( 'int' ) + $pl->getAtr( 'wis' ) );
	}
	
	//SqlExec("UPDATE players SET hp=max_hp");
	//SqlExec("UPDATE players SET krew=krew-0.5 WHERE rasa='Wampir' AND krew>=0.5");
	/*Wywalic po wykonaniu skryptu*/
	//SqlExec("UPDATE players SET krew=0 WHERE rasa!='Wampir'");
	//SqlExec("UPDATE players SET krew=0 WHERE krew<=0");
	//SqlExec("UPDATE players SET miejsce='Athkatla' WHERE miejsce='Lochy'");
	/**/
	//SqlExec("UPDATE players SET crime=crime+1 WHERE klasa='Zlodziej'");	
	//SqlExec("UPDATE players SET energy=energy+max_energy WHERE miejsce!='Lochy'");
	//SqlExec("UPDATE players SET bridge='N'");	
	SqlExec("UPDATE outposts SET turns=turns+3");
	//SqlExec("UPDATE outposts SET tokens=tokens+100");
	//SqlExec("UPDATE kopalnie SET ops=ops+5");
	$mines = SqlExec("SELECT id,oper FROM mines");
	$block=0;
	while(!$mines->EOF){
		if($mines->fields['oper']<500)
			SqlExec("UPDATE mines SET oper=oper+3 WHERE id=".$mines->fields['id']);
		else
			$block++;
		$mines->MoveNext();
	}
	echo "Kopalni ponad limit : ".$block."\n";
	$depos=SqlExec("SELECT * FROM bank WHERE type='L'");
	$depos=$depos->GetArray();
	foreach($depos as $depo) {
		if(time() > $depo['time']) {
			SqlExec("DELETE FROM bank WHERE id={$depo['id']}");
			//SqlExec("UPDATE players SET bank=bank+".($depo['base']+$depo['base']*$depo['proc'])." WHERE id={$depo['pid']}");
			$repay = new playerManager( $depo['pid'] );
			$repay->addRes( 'bank', $depo['current'] );
			echo "Koniec lokaty dla {$depo['pid']} na kwotê{$depo['current']}\n";
		}
	}
	//$hour = date("H",time());
	//$proj=SqlExec("SELECT value FROM settings WHERE setting='interest'");
	//if($hour == $proj->fields['value']) {
	//	$nhour=rand(0,23);
	//	SqlExec("UPDATE settings SET value=$nhour WHERE setting='interest'");
	//	echo "Godzina odsetek ! Nowa godzina to $nhour <BR>";
	//}
	//SqlExec("UPDATE players SET pm=inteli+wisdom");
	SqlExec("UPDATE tribes SET atak='N'");
	SqlExec("UPDATE houses SET points=points+2");
	SqlExec("UPDATE houses SET rest='N'");
	//SqlExec("UPDATE players SET gotow='N'");
	SqlExec("UPDATE houses SET locrest='N'");
	//$ids = SqlExec( "SELECT id FROM players ");
	//$ids = $ids -> GetArray();
	//foreach( $ids as $id ) {
	//	SqlExec( "INSERT INTO wakeup(pid,`type`) VALUES({$id['id']},'misc')" );
	//}
	echo "Wykonywanie resetow modulow\n";
	$mods = SqlExec( "SELECT id,name,checked FROM modules" );
	$mods = $mods -> GetArray();
	foreach ($mods as $mod) {
		$file = "modules/{$mod['name']}/inc/KT.reset.inc.php";
		if( file_exists( $file ) ) {
			$__safeMode = true;
			
			if ( $mod['checked'] != 1 ) {
				$__sandboxMode = true;
			}
			echo "Modul : {$mod['name']}\n";
			require_once ( $file );
			ob_start();
			$fname = "KT_".str_replace( '-', '_', $mod['name'] )."_reset";
			if( function_exists( $fname ) ) {
				$fname( 'hour' );
			}
			$result = ob_get_clean();
			$__sandboxMode = false;
			$__safeMode = false;
			$result = str_replace( "'", "&#039;", $result );
			SqlExec( "UPDATE modules SET resetHour='{$result}' WHERE id={$mod['id']}" );
			$result = str_replace( "\n", "\n\t", $result );
			$result = "\t".$result."\n";
			echo $result;
		}
	}
	SqlExec("UPDATE settings SET value='Y' WHERE setting='open'");
	SqlExec("UPDATE settings SET value='{$oldreason->fields['value']}' WHERE setting='close_reason'");
	//$time_end = getmicrotime();
	//$time = $time_end - $time_start;
	echo "Maly reset zakonczony o : ",date("H:i:s")," \n";
	//exit;
}

?>
