<?php
//@type: F
//@desc: Teatr
$title = "Teatr";
require_once("includes/head.php");

error( "Teatr zamkniety" );

$query = $db -> Execute("SELECT count(id) FROM jobs WHERE gracz=".$player -> id);
$test = $query -> fields['count(id)'];

if ($test == 0) {
   $db -> Execute("INSERT INTO jobs (gracz) VALUES(".$player -> id.")");
   }

if ($player -> location != 'Athkatla')
{
	error (ERROR);
}

if (isset ($_GET['action']) && $_GET['action'] == 'repertuar'){

error ('Oto repertuar teatru na najblizszy tydzien:<ul>
<li><a href="teatr.php?action=spektakl"> Zobacz sztuke pt. Unforgiven </a></li>
<li><a href="teatr.php?action=spektakl"> Zobacz sztuke pt. Odyseji (przedluzony czas emisji)</a></li>
<li><a href="teatr.php?action=spektakl"> Zobacz sztuke pt. Niewierni </a></li>
<br />	');		
}
if (isset ($_GET['action']) && $_GET['action'] == 'scenium'){


$akt = $db -> Execute("SELECT aktor FROM jobs WHERE gracz=" . $player -> id);
$aktor = $akt -> fields['aktor'];
if ($aktor != 'Y'){
   error ('Tutaj wstep maja tylko aktorzy');
}
   error ('Znajdujesz sie w garderobie dla aktorow. Tutaj mozesz odegrac jakas sztuke lub przedstawienie. Wystepowac mozesz raz na reset. A suma funduszy jaka zarobisz zalezy od twoich umiejetnosci<br><ul><li><a href="teatr.php?action=zagrajp">Zagraj w przedstawieniu</a></li><li><a href="teatr.php?action=zagrajsz">Zagraj w sztuce</a></li><li><a href="teatr.php">Wyjdz z garderoby</a></li></ul>');
}
if (isset ($_GET['action']) && $_GET['action'] == 'zagrajp'){

$akt = $db -> Execute("SELECT aktor FROM jobs WHERE gracz=" . $player -> id);
$aktor = $akt -> fields['aktor'];
if ($aktor != 'Y'){
   error ('Nie jestes aktorem');
}
$prac = $db -> Execute("SELECT praca FROM jobs WHERE gracz=" . $player -> id);
$praca = $prac -> fields['praca'];
if ($praca != 'N'){
   error ('Wystepowales niedawno');
}
if ($player -> energy < 1){
   error (' Nie masz energii na wystawienie sztuki');
}
$aktor = $db -> Execute("SELECT aktorstwo FROM jobs WHERE gracz=" . $player -> id);
$aktorstwo = $aktor -> fields['aktorstwo'];
if ($aktorstwo > 7.999){
   error ('Wystawiasz przedstawienia jednak czujesz ze nic ci to juz nie daje. Moze powinienes grac w sztukach');
}
$chance = rand(1,3);

 if ($chance == 1)
    {	
$db -> Execute("UPDATE jobs SET aktorstwo=aktorstwo+ 0.02 WHERE gracz=".$player -> id);
$db -> Execute("UPDATE jobs SET praca='Y' WHERE gracz=".$player -> id);
$db -> Execute("UPDATE players SET energy=energy- 1 WHERE id=".$player -> id);
$db -> Execute("UPDATE players SET credits=credits+ 2000 WHERE id=".$player -> id);
   error ('Widzom srednio podobal sie twoj wystep, jednak czego sie spodziewac po takich umiejetnosciach. Jednak za to przedstawienie zyskales <b>0.02</b> do umiejetnosci aktorstwo oraz <b>2000 zlota</b>');
}
 if ($chance == 2)
    {	
$db -> Execute("UPDATE jobs SET aktorstwo=aktorstwo+ 0.01 WHERE gracz=".$player -> id);
$db -> Execute("UPDATE jobs SET praca='Y' WHERE gracz=".$player -> id);
$db -> Execute("UPDATE players SET energy=energy- 1 WHERE id=".$player -> id);
$db -> Execute("UPDATE players SET credits=credits+ 100 WHERE id=".$player -> id);
   error ('Widzom w ogole nie podobal sie twoj wystep, pod koniec widzowie rzucali pomidorami, jeden pan byl taki mily ze dal ci darowizne w postaci <b>100 sz. zlota</b>. Oprocz tego zyskales <b>0.01</b> do umiejetnosci aktorstwo. ');
}
 if ($chance == 3)
    {	
$db -> Execute("UPDATE jobs SET aktorstwo=aktorstwo+ 0.01 WHERE gracz=".$player -> id);
$db -> Execute("UPDATE jobs SET praca='Y' WHERE gracz=".$player -> id);
$db -> Execute("UPDATE players SET energy=energy- 1 WHERE id=".$player -> id);
$db -> Execute("UPDATE players SET credits=credits+ 800 WHERE id=".$player -> id);
   error ('Zagrales w teatrze role ostatnio planowa. Widzowie cie prawie nie dostrzegli. To moze i lepiej. Dyrektor zaplacil ci <b>800 zlota</b>. Oprocz tego zyskales <b>0.01</b> do umiejetnosci aktorstwo. ');
}
}
if (isset ($_GET['action']) && $_GET['action'] == 'zagrajsz'){

$akt = $db -> Execute("SELECT aktor FROM jobs WHERE gracz=" . $player -> id);
$aktor = $akt -> fields['aktor'];
if ($aktor != 'Y'){
   error ('Nie jestes aktorem');
}
$prac = $db -> Execute("SELECT praca FROM jobs WHERE gracz=" . $player -> id);
$praca = $prac -> fields['praca'];
if ($praca != 'N'){
   error ('Wystepowales niedawno');
}
if ($player -> energy < 1){
   error (' Nie masz energii na zagranie w sztuce');
}
$aktor = $db -> Execute("SELECT aktorstwo FROM jobs WHERE gracz=" . $player -> id);
$aktorstwo = $aktor -> fields['aktorstwo'];
if ($aktorstwo < 8){
   error ('Ze wzgledu na niskie umiejetnosci nie mozesz jeszcze grac w sztukach');
}
$chance = rand(1,3);
 if ($chance == 1)
    {
$db -> Execute("UPDATE jobs SET aktorstwo=aktorstwo+ 0.04 WHERE gracz=".$player -> id);
$db -> Execute("UPDATE jobs SET praca='Y' WHERE gracz=".$player -> id);
$db -> Execute("UPDATE players SET energy=energy- 1 WHERE id=".$player -> id);
$db -> Execute("UPDATE players SET credits=credits+ 3500 WHERE id=".$player -> id);
   error ('Widzom podobal sie twoj wystep, widac praca przyniosla efekt. Za to przedstawienie zyskales <b>0.03</b> do umiejetnosci aktorstwo oraz <b>3500 zlota</b>');
}
 if ($chance == 2)
    {	
$db -> Execute("UPDATE jobs SET aktorstwo=aktorstwo+ 0.015 WHERE gracz=".$player -> id);
$db -> Execute("UPDATE jobs SET praca='Y' WHERE gracz=".$player -> id);
$db -> Execute("UPDATE players SET energy=energy- 1 WHERE id=".$player -> id);
$db -> Execute("UPDATE players SET credits=credits+ 500 WHERE id=".$player -> id);
   error ('Widzom malo podobal sie twoj wystep. Jednak dyrektor nichetnie ale wyjal pieniadze dla cibie. <br><i>Nastepnym razem ma byc lepiej...</i><br> Zyskales <b>0.015</b> do umiejetnosci aktorstwo oraz <b>500 zlota</b>. ');
}
 if ($chance == 3)
    {	
$db -> Execute("UPDATE jobs SET aktorstwo=aktorstwo+ 0.02 WHERE gracz=".$player -> id);
$db -> Execute("UPDATE jobs SET praca='Y' WHERE gracz=".$player -> id);
$db -> Execute("UPDATE players SET energy=energy- 1 WHERE id=".$player -> id);
$db -> Execute("UPDATE players SET credits=credits+ 1500 WHERE id=".$player -> id);
   error ('Zagrales te role przecietnie. Widzowie tez tak to odebrali. Moglo byc lepiej. Ale ze sceny odchodzisz z sakiewka za <b>1500 zlota</b> i z  <b>0.02</b> do umiejetnosci aktorstwo w sercu. ');
}
}

if (isset ($_GET['action']) && $_GET['action'] == 'proscenium'){

    error ('Znajdujesz sie w na scenie. Tutaj mozesz trenowac aktorstwo.<br><ul><li><a href="teatr.php?action=trenuj">Trenuj aktorstwo</a></li><li><a href="teatr.php">Wroc</li></ul>');
}

if (isset ($_GET['action']) && $_GET['action'] == 'trenuj'){

   if ($player -> energy < 1){
               error ('Nie mozesz trenowac bo nie masz energii');
                              }
$aktor = $db -> Execute("SELECT aktorstwo FROM jobs WHERE gracz=" . $player -> id);
$aktorstwo = $aktor -> fields['aktorstwo'];
if ($aktorstwo > 4.999){
   error ('Juz wytrenowales sztuke aktorstwa. Teraz ze spokojna glowa mozesz isc po prace');
      }
$chance = rand(1,3);

 if ($chance == 1)
    {	
$db -> Execute("UPDATE players SET energy=energy-1 WHERE id=".$player -> id);
$db -> Execute("UPDATE jobs SET aktorstwo=aktorstwo+1 WHERE gracz=".$player -> id);
                       error ('Cwiczyles przez jakis czas i jestes z siebie zadowolony.(Zyskujesz 1 aktorstwa) <a href="teatr.php?action=trenuj">Trenuj ponownie</a>');
}
 if ($chance == 2)
    {	
$db -> Execute("UPDATE players SET energy=energy-1 WHERE id=".$player -> id);
       error ('Cwiczyles i cwiczyles ... ale nie przynioslo ci to efektow <a href="teatr.php?action=trenuj">Trenuj ponownie</a>');
}
 if ($chance == 3)
    {	
$db -> Execute("UPDATE players SET energy=energy-1 WHERE id=".$player -> id);
$db -> Execute("UPDATE jobs SET aktorstwo=aktorstwo+1 WHERE gracz=".$player -> id);
                       error ('Cwiczyles przez jakis czas i jestes z siebie zadowolony.(Zyskujesz 1 aktorstwa) <a href="teatr.php?action=trenuj">Trenuj ponownie</a>');
}
}

if (isset ($_GET['action']) && $_GET['action'] == 'spektakl'){

          if (2000 > $player -> credits) {

		error ('Nie masz wystarczajacej ilosci pieniedzy');
}
$t = $db -> Execute("SELECT teatr FROM specials WHERE gracz=" . $player -> id);
$teatr = $t -> fields['teatr'];
if ($teatr > 5){
   error ('Nie masz ochoty ogladac teraz nowej sztuki');
}
$chance = rand(1,2);

    if ($chance == 1)
    {		
$db -> Execute("UPDATE players SET credits=credits- 2000 WHERE id=".$player -> id);
$db -> Execute("UPDATE players SET inteli=inteli+0.2 WHERE id=".$player -> id);	
$db -> Execute("UPDATE specials SET teatr=teatr+1 WHERE gracz=".$player -> id);	
    error ('Obejzales wspaniala sztuke w teatrze dzieki czemu zyskales <b>0.2 do inteligencji</b> ');
}
    if ($chance == 2)
    {
$db -> Execute("UPDATE players SET credits=credits- 2000 WHERE id=".$player -> id);
$db -> Execute("UPDATE specials SET teatr=teatr+1 WHERE gracz=".$player -> id);	
    error ('Ogladales sztuke jednak zasnales w trakcie. Nic oprocz wydanych <b>2000 zlota</b> nie pamietasz');
    }
    if ($chance == 3)
    {
$db -> Execute("UPDATE players SET credits=credits- 2000 WHERE id=".$player -> id);
$db -> Execute("UPDATE players SET wisdom=wisdom+0.2 WHERE id=".$player -> id);	
$db -> Execute("UPDATE specials SET teatr=teatr+1 WHERE gracz=".$player -> id);	
    error ('To byla prawdziwa katorga! Potrzeba ci bylo duzo sily woli na ten spektakl. Jednak wytrzymales. Dostajesz <b>0.2 do sily woli</b>.');
    }
}
$smarty -> display ("teatr.tpl");
require_once("includes/foot.php");
?>

