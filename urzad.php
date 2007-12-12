<?php
//@type: F
//@desc: Sala audiencyjna
$title = "Sala Audiencyjna";
require_once("includes/head.php");
checklocation($_SERVER['SCRIPT_NAME']);

if ($player -> przemiana > 0) {

error ("Musisz powrocic z Besti w czlowieka aby tutaj przebywac!"); 

}
$ra=$db->Execute("SELECT id,user,rid FROM players WHERE rid>1");
$r=$ra->GetArray();
for($i=0, $ile=count($r);$i<$ile;$i++) {
	$rn=$db->Execute("SELECT name FROM ranks WHERE id={$r[$i]['rid']}");
	$r[$i]['rid']=$rn->fields['name'];
}
   /*$players = mysql_query("select * from players where rank='Admin' or rank='Ksiaze'or rank='Bohater' or rank='Krolowa' or rank='Kanclerz Sadu' or rank='Lord' or rank='Kronikarz' or rank='Sedzia' or rank='Posel' or rank='Prawnik' or rank='Lawnik' or rank='Sekretarz Sadu' or rank='Lord' or rank='Krol' or rank='Ksiezniczka' order by rank asc");*/
   /*$number = mysql_num_rows($players);
   $smarty -> assign ("Number", $number);
   if ($number > 0) {
       $arrid = array();
       $arrname = array();
               $arrrank = array();
        $i = 0;
               while ($pary = mysql_fetch_array($players)) {
           $arrid[$i] = $pary['id'];
                       $arrname[$i] = $pary['user'];
                       $arrrank[$i] = $pary['rank'];
           $i = $i + 1;
       }
       $smarty -> assign ( array("Id" => $arrid, "Name" => $arrname, "Rank" => $arrrank));
   }*/
$smarty -> assign("Rank",$r);
$smarty -> assign ( array("Location" => $player -> location));
$smarty -> display ('urzad.tpl');
require_once("includes/foot.php"); 
?>
