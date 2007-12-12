<?

// Bardzo niebezpieczne !!
$player->str += 10;

//Tak jest _duzo_ bezpieczniej
$player->str = $player->getAtr( 'str', TRUE ) + 10;
?>