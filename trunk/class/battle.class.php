t  <?php

define( 'B_BATTLE_NONE', -1 );
define( 'B_BATTLE_BEGIN', 2 );
define( 'B_BATTLE_END', 0 );
define( 'B_BATTLE_CONT', 1 );

define( 'B_ROUND_END', 3);
define( 'B_ROUND_CONT', 4);
define( 'B_ROUND_BEGIN', 5);

function figurescmp( $a, $b ) {
	//print_r( $battle -> figures );
	return -( $a['spd'] - $b['spd'] );
}


class Battle {
	public $figures;
	public $groups;
	public $afterbattle;
	private $inbattle;
	public $currentnum;
	public $current;
	public $amount;
	public $status;
	public $roundstatus;
	public $type;
	public $totalbattles;
	//public $smarty;
	public $round;
	function __construct( $type ) {
		if( !in_array( $type, array( 'pvp', 'pvm' ) ) ) {
			trigger_error( "Nieobslugwany typ walki $type !", E_USER_ERROR );
			$this -> figures = NULL;
			return FALSE;
		}
		$this -> type = $type;
		$this -> figures = array();
		$this -> groups = array();
		$this -> afterbattle = array();
		$this -> amount = 0;
		$this -> status = B_BATTLE_NONE;
		$this -> current = NULL;
		$this -> currentnum = 0;
		//global $smarty;
		//$this -> smarty =& $smarty;
	}
	
	
	function FigureAdd( &$figures, $group ) {
		$types = array( 'Fighter_player', 'Fighter_monster' );
		if( !is_array( $figures ) ) {
			if( !in_array( get_class( $figures ), $types ) ) {
				trigger_error( "Nie moge dodac tego typu obiektu ".get_class( $figures )." !", E_USER_ERROR );
				return FALSE;
			}
			$insert = count( $this -> figures );
			$this -> figures["$insert"] = array( 'figure' => $figures, 'group' => $group );
		}
		else {
			foreach( $figures as $figure ) {
				if( !in_array( get_class( $figure ), $types ) ) {
					trigger_error( "Nie moge dodac tego typu obiektu ".get_class( $figure )." !", E_USER_ERROR );
					return FALSE;
				}
				$insert = count( $this -> figures );
				$this -> figures["$insert"] = array( 'figure' => $figure, 'group' => $group );
				//if( empty( $this -> groups[$group] ) ) {
				//	$this -> groups[$group] = array( $insert );
				//}
				//else {
				//	$this -> groups[$group][] = $insert;
				//}
				$this -> amount ++;
			}
		}
	}

	function PickTarget( $num, $group ) {
		$grs = array_keys( $this -> groups );
		if( count( $this -> groups ) < 2 ) {
			return NULL;
		}
		//print_r( $this -> groups);
		do {
			$rgrp = array_rand( $this -> groups );
			//$gr = $grs[rand( 0, count( $grs )-1 )];
		} while( $rgrp == $group );
		//$fgs = count( $this -> groups[$gr] ) - 1;
		$rkey = array_rand( $this -> groups[$rgrp] );
		//$target = $this -> groups[$gr][rand( 0, $fgs )];
		//} while( empty( $target ) );
		return $this -> groups[$rgrp][$rkey];
	}

	function BattleStart() {
		foreach( $this -> figures as $key => $item ) {
			$this -> figures[$key]['exp'] = 0;
			$this -> figures[$key]['gold'] = 0;
			$this -> figures[$key]['gain'] = array( 'melee'=>0, 'ranged'=>0, 'cast'=>0, 'miss'=>0 );
		}
	}

	function BattlePrepare() {
		global $smarty;
		
		

		$item = current( $this -> figures );
		$this -> currentnum = key( $this -> figures );
		$this -> inbattle = array();
		//echo "\n!{$this -> currentnum}!\n";
		//echo " --- ROZPOCZECIE WALKI ---\n";
		$player = array();
		$this -> groups = array();
		foreach( $this -> figures as $key => $item ) {
			//$toadd = array();
			//$toadd['group'] = ;
			//echo "GRUPA $key ------\n";
			//foreach( $group as $id ) {
			if( $item['figure'] -> hp <=0 ) {
				echo "Nie dodaje {$item['figure']->name} ! 0 HP !<br>";
				continue;
			}
				$this -> inbattle[] = array( 'key' => $key, 'spd' => $item['figure']->GetStat('spd') );
				//$item = $this -> figures[$id]['figure'];
				//$toadd['players'][] = $item['figure'] -> name;
				//echo "     --{$id}::{$item->name}\n";
				$this -> groups[$item['group']][]=$key;
				//echo "dodaje do grupy {$item['group']} :: $key<br>";
			//}
			$player [$item['group']]['group'] = $item['group'];
			$player [$item['group']]['players'][] = $item['figure'] -> name." hp:".$item['figure'] -> hp;
		}
		//echo "--------------------------\n";
		if( count( $this -> groups ) < 2 ) {
			trigger_error( "Za malo druzyn zeby zaczac walke !" );
			$this -> status = B_BATTLE_END;
			return FALSE;
		}
		//echo "przed : ";
		//print_r( $this -> inbattle );
		usort( $this -> inbattle, 'figurescmp' );
		//echo "<br>Po : ";
		//print_r( $this -> inbattle );
		$tmp = array();
		foreach( $this -> inbattle as $item ) {
			$tmp[] = $item['key'];
		}
		$this -> inbattle = $tmp;
		//print_r( $this -> inbattle );
		//exit;
		$smarty -> assign( 'Starting', $player );
		$smarty -> display( 'battle/battleprepare.tpl' );
		$this -> status = B_BATTLE_BEGIN;
		$this -> round = 1;
		return TRUE;
	}

	function RoundPrepare() {
		global $smarty;
		$this -> roundstatus = B_ROUND_BEGIN;
		reset( $this -> inbattle );
		$this -> currentnum = current( $this -> inbattle );
		$smarty -> assign( "Roundno", $this -> round );
		$smarty -> display( 'battle/roundprepare.tpl' );
	}

	function TurnPrepare(  ) {
		$fig =& $this -> figures[ $this -> currentnum ];
		$target = $this -> PickTarget( $this -> currentnum, $fig['group'] );
		$fig['target'] = $target;
		if( $target === NULL ) {
			$this -> status = B_BATTLE_END;
			return NULL;
		}
		$enemy = $this -> figures[$target];
		$attacker = $fig['figure'];
		$defender = $enemy['figure'];
		$fig['attackstr'] = ceil( $attacker->GetStat('spd') / $defender->GetStat('spd') );
		if( $fig['attackstr'] > 5 )
			$fig['attackstr'] = 5;
		return $this -> currentnum;
	}

	

	function TurnAttack( ) {
		global $smarty;
		if( $this -> figures[$this -> currentnum]['target'] === NULL ) {
			return;
		}
		$item =& $this -> figures[$this -> currentnum];
		$player =& $this -> figures[$this -> currentnum]['figure'];
		$target =& $this -> figures[$this -> figures[$this -> currentnum]['target']];
		$enemy =& $this -> figures[$this -> figures[$this -> currentnum]['target']]['figure'];
		//$enamyid = key( $this -> figures[$item['target']] );
		//print_r( $item );
		$msg = '';
		
		if( $player -> hp <= 0 ) {
			return;
			$msg.= "<li>jest martwy<br>";
		}
		
		$msg.= "<u>{$player -> GetStat('name')}</u> atakuje {$enemy->GetStat('name')}<br><ul>";

		for( $i=0; $i < $item['attackstr']; $i++ ) {
			if( $this -> figures[$this -> currentnum]['figure'] -> hp <= 0 ) {
				break;
			}
			if( $this -> figures[$this -> currentnum]['figure'] -> GetStat('fatigue') < 1 ) {
				$msg.= "<li>Jest zbyt zmeczony by dalej atakowac !</br>";
				break;
			}
			$unik = $enemy -> CombatGetVal('miss') - $this -> figures[$this -> currentnum]['figure']-> CombatGetVal('attack');
			$szansa = rand( 1, 100 );
			if( $unik >= $szansa && $szansa < 95 ) {
				$msg.= "<li>Przeciwnik unika ciosu !<br>";
				if( $enemy->GetStat('fatigue') < 1 ) {
					continue;
				}
				$target['gain']['miss'] += 0.01;
				if( !empty( $enemy -> equip['armor'] ) ) {
					$enemy -> fatigue -= $enemy -> equip['armor']['minlev'];
				}
				else {
					$enemy -> fatigue ++;
				}
				continue;
			}
			$mod =0;
			$dmg = $player -> CombatGetVal( 'damage' );
			if( $enemy -> GetStat('fatigue') > 0 ) {
				$mod = $enemy -> CombatGetVal('armor');
			}
			$dmg -= $mod;
			
			$what = array( 'armor', 'helm', 'shield', 'knee' );
			$key = array_rand( $what );
			$enemy -> CombatEquipWt( $what[$key], 1 );
			
			if( $dmg < 1 )
				$dmg = 0;
			if( $dmg > $enemy -> GetStat('hp') )
				$dmg = $enemy -> GetStat('hp');
			if( $dmg <= 0 ) {
				$msg.= "<li>Trafia lecz nie zadaje zadnych obrazen !<br>";
				continue;
			}
			
			$msg.= "<li><b>Trafia</b> ! Zadaje $dmg obrazen ... ";
			
			$enemy -> hp -= ( $dmg );
			$player -> hit = true;
			if( $enemy -> hp > 0 ) {
				$msg.= "pozostalo {$enemy->hp}<br>";
			}
			else {
				$msg.= "i zabija go";
				$this -> DelFromCombat($this -> figures[$this -> currentnum]['target'], $this -> currentnum );
			}
			//$msg .= " (za pomoca |".$player->GetWpnType()."|) ";
			if( $player -> GetWpnType() =='weapon' ) {
				$player -> CombatEquipWt( 'weapon', 1 );
				if( $player -> equip['weapon']['type'] == 'W' ) {
					$item['gain']['melee'] += 0.01;
				}
				else {
					$item['gain']['ranged'] += 0.01;
				}
				$player -> fatigue -= $player -> equip['weapon']['minlev'];
			}
			elseif( $player -> GetWpnType() =='spell' ) {
				
				$player -> mana -= $player -> equip['spellatk']['power'];
				$item['gain']['cast'] += 0.01;
			}
			if( $enemy -> GetStat('hp') <= 0 ) {
				break;
			}
			
			
		}
		$msg.= "</ul>";
		$smarty -> assign( 'Message', $msg );
		$smarty -> display('battle/turn.tpl');
	}

	function TurnEnd( ) {
	//print_r( $this->inbattle);
		$item = next( $this -> inbattle );
		if( $item !== FALSE ) {
			$this -> currentnum = current( $this -> inbattle );
			$this -> roundstatus = B_ROUND_CONT;
		}
		else {
			reset( $this -> inbattle );
			$this -> currentnum = current( $this -> inbattle );
			$this -> roundstatus = B_ROUND_END;
		}
	}

	function DelFromCombat( $fid, $killerid = NULL ) {
		//echo "usuwam $fid ! Kilerid = $killerid<br>";
		//$item =  $this -> figures[$fid];
		//$figure = $item['figure'];
		$grp = $this -> figures[$fid]['group'];
		//unset( $this -> figures[$item['target']] );
		//unset( $this -> figures[$fid] );
  		unset( $this -> inbattle[$fid] );
		if( $killerid !== NULL ) {
			if( empty( $this ->figures[$killerid]['figure'] ) ) {
				trigger_error( "Zabojca oznaczony jako pusty !", E_USER_WARNING );
			}
			//$this -> figures[$fid]['killer'] = $this ->figures[$killerid]['figure'];
			$this -> figures[$fid]['killerid'] = $killerid;
			//$killer = $this ->figures[$killerid]['figure'];
			//print_r($killer);
		}
		else {
			$killer = NULL;
		}
		$this -> figures[$fid]['gain'] = $this ->figures[$fid]['gain'];
		//$toadd = array( 'figure' => $figure, 'killer' => $killer, 'group' => $grp, 'gain' => $item['gain'] );
		//$this -> afterbattle[] = $toadd;
		//$this -> figures
		if( !isset( $this -> groups[$grp] ) ) {
			return;
		}
		$key = array_search( $fid, $this -> groups[$grp] );
		if( $key === NULL ) {
			echo "\nnie znaleziono klucza !\n";
		}
		//print_r( $this -> groups );
		
		unset( $this -> groups[$grp][$key] );
		if( empty( $this -> groups[$grp] ) ) {
			//echo "uswam grupe $grp !<br>";
			unset ( $this -> groups[$grp] );
		}
		//print_r($this -> inbattle );
		
	}

	function RoundEnd() {
		global $smarty;
		//print_r( $this -> groups );
		if( count( $this -> groups ) < 2 ) {
			$this -> status = B_BATTLE_END;
			//echo "USAWIAM KONIEC WALKI !";
		}
		$this -> round ++;
		$smarty -> display( 'battle/roundend.tpl' );
	}

	function BattleFinish() {
		global $smarty;
		//foreach( $this -> figures as $key => $val ) {
		//	$this -> DelFromCombat( $key );
		//}
		//echo " --- PODSUMOWANIE ---\n";
		$msg = '';
		//print_r( $this -> figures );
		foreach( $this -> figures as $key => $item ) {
			
			//print_r($item);
			$ply =& $this -> figures[$key]['figure'];
			
			//echo "{$ply -> name}<br>";
			$msg.= "{$ply -> name}";
			//echo "{$killer->name} zabil {$killed -> name}";
			if( isset( $item['killerid'] ) ) {
				//echo "KID : {$item['killerid']}<br>";
				$kill =& $this -> figures[$item['killerid']];
				//print_r( $kill );
				$killer = $kill['figure'];
				$msg.= " (zabity przez {$killer->name}";
				if( $kill['figure'] -> type == 'player' ) {
					$exp = $ply->CombatGetVal('exp');
					$gold = $ply -> CombatGetVal('gold');
					$kill['exp'] += $ply->CombatGetVal('exp');
					$kill['gold'] += $ply -> CombatGetVal('gold');
					//$killer -> AwardExp( $exp );
					//$killer -> gold += $gold;
					//$killer -> ApplyChanges();
					//$kill
					$msg.= ", +$exp exp oraz +$gold zlota";
				}
				$msg.= ")";
			}
			$msg.= "<br>";
			$ply -> BattleFinish();
			//$ply -> ApplyChanges();
			//$ply -> AwardSkill( $item['gain'] );
				//echo " oraz dostaje za to :\n\t{} doswiadczenia\n\t{$killed->CombatGetVal('gold')} zlota\n";
				//echo "";
				//$killer -> ApplyChanges();
			//}
			//else
		}
		$smarty -> assign( "Message", $msg );
		$smarty -> display( 'battle/battlefinish.tpl' );
	}

	function BattleRestart() {
		foreach( $this -> figures as $key => $item ) {
			//$this -> figures[$key]['gain'] = array( 'melee'=>0, 'ranged'=>0, 'cast'=>0, 'miss'=>0 );
			$this -> figures[$key]['figure'] -> Restart();
			unset( $this -> figures[$key]['killerid'] );
		}
	}

	function BattleEnd() {
		foreach( $this -> figures as $key => $item ) {
			echo "{$item['figure']->name} dostaje {$item['exp']} doswiadczenia, {$item['gold']} zlota<br>";
			//echo "{$item['gain']['cast']} rzucania czarow<br>";
			$item['figure'] -> AwardExp( $item['exp'] );
			$item['figure'] -> gold += $item['gold'];
			if( $item['gold'] > 0 ) {
				PutSignal( $item['figure'] -> id, 'res' );
			}
			$item['figure'] -> ApplyChanges();
			$item['figure'] -> AwardSkill( $item['gain'] );
			
		}
	}

	function Battle( $times = 1 ) {
		if( $times > 1 && $this -> type != 'pvm' ) {
			trigger_error( "Wielokrotne walki mozliwe tylko w trybie pvm !", E_USER_WARNING );
			return FALSE;
		}
		$this -> BattleStart();
		$this -> totalbattles = 0;
		for( $i = 1; $i <= $times; $i++ ) {
			$this -> totalbattles ++;
			if( $this -> BattlePrepare() === FALSE ) {
				trigger_error( "Blad posczas przygotowywania walki !", E_USER_WARNING );
				break;
			}
			do{
				$this -> RoundPrepare();
				do{
					$this -> TurnPrepare( );
					$this -> TurnAttack( );
					$this -> TurnEnd( );
				}while( $this -> roundstatus != B_ROUND_END && $this -> status != B_BATTLE_END );
				$this -> RoundEnd();
			} while( $this -> status != B_BATTLE_END && $this -> round < 25 );
			//echo "Walka zakonczona !\n";
			$this -> BattleFinish();
			if( $times > 1 ) {
				$this -> BattleRestart();
			}
			
		}
		$this -> BattleEnd();

	}
}