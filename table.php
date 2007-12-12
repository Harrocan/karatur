<?php
	require_once("includes/head.php");
	//SqlExec("CREATE TABLE library_vote(`pid` int(6) NOT NULL, `vid` int(6) NOT NULL, vote int(1), PRIMARY KEY(`pid`,`vid`))");
	SqlExec("ALTER TABLE `library` ADD `count` int(5) NOT NULL DEFAULT '0'");
	require_once("includes/foot.php");
?>