<?php
$title="Panel specjalny";
//Administracja bazy danych

require_once("includes/head.php");

if (($player -> rid!="22") && ($player -> rid!="2")){
	error("Jezlei kurde myslisz ze raz ci sie udalo tu wejsc i ze bedziesz tu wichodzil co rusz to sie mylisz");
}
//Wstawianie tabeli gotowej

if((isset($_GET['step'])) && ($_GET['step']=='CreTab')){
	if((isset($_GET['action'])) && ($_GET['action']=="Add")){
		if (!($_FILES['plik']['name'])) {
			error("Nie podales nazwy pliku!");}
		$tab = @fopen($_FILES['plik']['tmp_name'], "r");
		$table='';
		while(!feof($tab)){
			$table.=fread($tab,500);
		}
		fclose($tab);
		$Zap=explode(';',$table);
		foreach($Zap as $obj){
		if(($obj==' ')){
		SqlExec($obj);}
		}
		error("Dodano tabele","done");
	}
}

//Usuwnie tabeli

if((isset($_GET['step'])) && ($_GET['step']=='DropTab')){
	$tabs = SqlExec("SHOW TABLES");
	$tabs = $tabs -> GetArray();
	if((isset($_POST['nazwa'])) && ($_GET['action']=="Del")){
		$db -> Execute("SELECT * FROM {$_POST['nazwa']}") or error("Nie mogewykonaæ polecenia, tabela 						najprawdopodobniej nie istnieje");
		SqlExec("DROP TABLE {$_POST['nazwa']}");
		error("Tabela usuniêta");
	}
	$smarty -> assign("tabs", $tabs);
}

//Edycja tabel

if((isset($_GET['step'])) && ($_GET['step']=="EditTab")){
	$tabs = SqlExec("SHOW TABLES");
	$tabs = $tabs -> GetArray();
	$smarty ->assign( array("met" => '',"tabs" => $tabs,"nazwa" => ''));
	
	//Przeglad rekordów
	
	if(((isset($_POST['nazwa'])) || isset($_POST['met'])) && ($_GET['action']=="Sel")){
		if(isset($_POST['pole']) && ($_POST['pole']=='')){ 
			$_POST['pole']="*";
		}
		elseif((isset($_POST['pole'])) && ($_POST['pole']!='')){
			$_POST['pole'] = preg_replace("/[\s]+/",'',$_POST['pole']);
		}
		$war="WHERE";
		if((isset($_POST['war']) && $_POST['war']!='')){
			$wary = preg_replace("/[\s]+/",'', $_POST['war']);
			//print_r($wary);
			$wary= explode("AND",$wary);
			//print_r($wary);
			foreach($wary as $obj){
				if($war != "WHERE"){ $war= "{$war} AND";}
				$item = explode("=",$obj);
				$warun = "{$war} `{$item[0]}`='{$item[1]}'";
			}
		}else{$warun='';
		}
		if(!isset($_POST['nazwa'])){
			$_POST['nazwa']='';
		}
		$lim = "LIMIT {$_GET['limit']}, 20";
		if(isset($_POST['met'])){$met = str_replace('\\','',$_POST['met']);}
		else{$met = "SELECT {$_POST['pole']} FROM {$_POST['nazwa']} {$warun}";}
		//print_r($_POST['met']);
		$sel = SqlExec($met) or Error("Nie moge wykonac zapytanie");
		$rec = $sel -> RecordCount();
		$sel = $db -> Execute("{$met} {$lim}");
		if($_POST['pole']=="*"){
			$nazw = array();
			$pool = SqlExec("SHOW COLUMNS FROM {$_POST['nazwa']}");
			$pool = $pool -> GetArray();
			$i = 0;
			foreach($pool as $obj){
				$nazw[$i] = $obj['Field'];
				$i++;
			}
		}else{
			$nazw = explode(',',$_POST['pole']);
		}
		/*		
		$i = 0;
		$pool = $sel -> FetchField($i);
		$nazw = array();
		while(!empty($pool->name)){
			$nazw[$i]=$pool->name;
			$i++;
			$pool = $sel -> FetchField($i);
		}
		*/
		//print($met);
		$sel1 = $sel -> GetArray();
		$smarty -> assign( array( "nazw" => $nazw, "data" => $sel1, "limit" => $_GET['limit'],
						"record" => $rec, "met" => $met, "nazwa" => $_POST['nazwa'], "pole" => $_POST['pole']));
	}
	
	//Edycja rekordów
	
	if(isset($_GET['action']) && ($_GET['action']=="Edit")){
		$met = "{$_POST['met']} LIMIT {$_POST['i']}, 1";
		$met = str_replace('\\','',$met);
		$data = $db -> Execute($met);
		$nazw = array();
		$pool = SqlExec("SHOW COLUMNS FROM {$_POST['nazwa']}");
		$pool = $pool -> GetArray();
		$i = 0;
		foreach($pool as $obj){
			$nazw[$i] = $obj['Field'];
			$i++;
		}
		$type = array();
		$data = $data -> GetArray();
		foreach($data[0] as $obj){
			$str = strlen($obj);
			if($str>50){
				$type[] = '1';
			}
			else{
				$type[] = '0';
			}
		}
		$smarty -> assign( array( "data" => $data, "nazw" => $nazw, "type" => $type,
								 "mett" => $met, "nazwa" => $_POST['nazwa']));
	}
	
	//Update rekordu
	
	if(isset($_GET['action']) && ($_GET['action']=="Update")){
		$met = str_replace('\\','',$_POST['met']);
		$data = $db -> Execute($met);
		$where ="WHERE";
		$set = "SET";
		$data = $data -> GetArray();
		$i = 0;
		foreach($data[0] as $key => $obj){
			$j = 0;
			if($_POST[$key]!=''){
				if($i != 0){$set = "{$set}, ";}
				for($k = 0;$k < strlen($_POST[$key]);$k++){
					if((ord($_POST[$key][$k]) < 48) || (ord($_POST[$key][$k]) > 57)){$j = 1;}
				}
				if($j == 0){
					$set = "{$set} `{$key}`={$_POST[$key]}";
				}
				else{
					$set = "{$set} `{$key}`='{$_POST[$key]}'";
				}
			}
			if($obj!=''){
				if($i != 0){$where = "{$where} AND";}
				if($j == 0){
					$where = "{$where} `{$key}`={$obj}";
				}
				else{
					$where = "{$where} `{$key}`='{$obj}'";
				}
			}
			$i = 1;
		}
		SqlExec("UPDATE {$_POST['nazwa']} {$set} {$where}") or error("Nie moge wykonaæ");
		error("Uaktualnino rekord!!!","done");
		}
	
	//Usuwanie rekordu
	
	if(isset($_GET['action']) && ($_GET['action']=="Del")){
		$met = "{$_POST['met']} LIMIT {$_POST['i']}, 1";
		$met = str_replace('\\','',$met);
		$data = $db -> Execute($met);
		$where ="WHERE";
		$data = $data -> GetArray();
		foreach($data[0] as $key => $obj){
			if($obj!=''){
				$j = 0;
				for($k = 0;$k < strlen($obj);$k++){
					if((ord($obj[$k]) < 48) || (ord($obj[$k]) > 57)){$j = 1;}
				}
				if($where != "WHERE"){$where = "{$where} AND";}
				if($j == 0){
					$where = "{$where} `{$key}`={$obj}";
				}
				else{
					$where = "{$where} `{$key}`='{$obj}'";
				}
			}
		}
		$db -> Execute("DELETE FROM {$_POST['nazwa']} {$where}") or error("Nie moge wykonaæ");
		error("Rekord usuniety!!!");
	}
}

//Dodawanie rekordu

if((isset($_GET['step'])) && ($_GET['step']=="RecAdd")){
	if(isset($_GET['nazwa'])){
		$nazw = SqlExec("SHOW COLUMNS FROM {$_GET['nazwa']}");
		$nazw = $nazw -> GetArray();
		//print_r($nazw);
		$smarty -> assign( array( "nazwa" => $_GET['nazwa'], "nazw" => $nazw));
	}
	if(isset($_GET['action']) && ($_GET['action']=="Add")){
		$nazw = SqlExec("SHOW COLUMNS FROM {$_POST['nazwa']}");
		$nazw = $nazw -> GetArray();
		//print_r($nazw);
		$valu = "VALUES(";
		foreach($nazw as $obj){
			if($valu!="VALUES("){$valu="{$valu}, ";}
			//print($_POST["{$obj['Field']}"]);
			if($_POST["{$obj['Field']}"]!=''){
					$valu = "{$valu}'{$_POST[$obj['Field']]}'";
			}elseif(($obj['Extra']=="auto_increment") || ($obj['Null']=="NO")){
			$valu = "{$valu}''";
			}else error("Jakieœ pole jest nie wype³nione");
		}
		$valu = "{$valu})";
		SqlExec("INSERT INTO {$_POST['nazwa']} {$valu}");
		error("Rekord dodano!!","done");
	}
}

if(!isset($_GET['step'])){
	$_GET['step']='';
}
if(!isset($_GET['action'])){
	$_GET['action']='';
}

$smarty -> assign( array( "Step" => $_GET['step'], "action" => $_GET['action']));
$smarty -> display("panelm.tpl");
require_once("includes/foot.php");

?>