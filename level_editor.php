<?php

require_once( "includes/preinit.php" );

function createAction( $name ) {
	$filename = "class/LevelActions/KT.LevelAction." . $name . ".class.php";
	if( !file_exists( $filename ) ) {
		error( "Nie istnieje taka akcja `$name` !" );
	}
	require_once( "class/KTLevelAction.php" );
	require_once( $filename );
	return new $name();
}

function getLevelActions() {
	require_once( "class/KTLevelAction.php" );
	$actionReg = "/KT\\.LevelAction\\.(\\w*)\\.class\\.php/";
	$dirPath = "class/LevelActions/";
	$dirh = opendir( $dirPath );
	$ret = array();
	while( ( $file = readdir( $dirh ) ) !== false ) {
		if( preg_match( $actionReg, $file, $subs ) ) {
			$filename = "class/LevelActions/$file";
			require_once( $filename );
			$tmpAction = new $subs[1]();
			$tmp['name'] = $subs[1];
			$tmp['short'] = $tmpAction->getShortDesc();
			$tmp['long'] = $tmpAction->getLongDesc();
			$tmp['req'] = $tmpAction->getReqParams();
			$ret[] = $tmp;
			
			unset( $tmpAction );
			//qDebug( $subs );
			//$tmp[] = $file;
			unset( $subs );
		}
	}
	
	qDebug( $ret );
}

$title = "Edytor poziomów";
$js_onLoad = "init();";
makeHeader();

//require_once( "class/KTLevelAction.php" );
//$t = new KTLevelAction();

//getLevelActions();

$smarty->display( "level_editor.tpl" );

makeFooter();

?>