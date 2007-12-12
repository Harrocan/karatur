<?php
require_once('includes/config.php');
$db -> Execute("UPDATE settings SET value='Y' WHERE setting='open'");
?>
