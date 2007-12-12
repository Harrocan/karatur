<?php
//@type: F
//@desc: Dom pokus
$title = "Dom pokus";
require_once("includes/head.php");
require_once("includes/checkexp.php");

checklocation($_SERVER['SCRIPT_NAME']);

//error( "Die bitch !" );

$smarty->assign( "City", $player->file );

if (isset ($_GET ['action']) && $_GET ['action'] == 'zabaw'){
error ('Widze ze chcesz sie zabawic. Zapraszamy masz duzy wybor:
		<br> <center><b><li>Dla panow:</li></b></center> <br>
		<center><li><a href="houselure.php?action=Eilida">Eilida (7500 zlota za 3 energii)</a></li>
		<li><a href="houselure.php?action=Karshala">Karshala (10500 zlota za 4 energii)</a></li>
		<li><a href="houselure.php?action=Arenturia">Arenturia (13000 zlota za 5 energii)</a></li></center> <br>
		<br> <center><b><li>Dla pan:</li></b></center> <br>
		<center><li><a href="houselure.php?action=Herkulan">Herkulan (7500 zlota za 3 energii)</a></li>
		<li><a href="houselure.php?action=Illiadar">Illiadar (10500 zlota za 4 energii)</a></li>
		<li><a href="houselure.php?action=Oragon">Oragon (13000 zlota za 5 energii)</a></li><br>
		<hr align=center width=150><br>
		<li><a href="houselure.php">Wracaj</a></li></center>
		<br />');
}
if (isset ($_GET['action']) && $_GET['action'] == 'gabinet'){
	$alf = $db -> Execute("SELECT alfons FROM jobs WHERE gracz=" . $player -> id);
	$admin = $alfons -> fields['alfons'];
	if ($alfons != 'Y'){
		error ('Nie jestes alfonsem');
	}
	error ('Jestes w gabinecie alfonsa. Mozesz tutaj zamawiac ludzi  dla swoich panienek/panow. Pamietaj ze mozesz to robic tylko 1 raz na reset <br><ul><li><a href="houselure.php?action=zapraszajs">Zapros osobe ze slamsu</a></li><li><a href="houselure.php?action=zapraszajp">Zapros osobe z przecietnych ludzi</a><li><a href="houselure.php?action=zapraszajz">Zapros osobe z rodzin zamoznych</a><li><a href="houselure.php?action=zapraszajsz">Zapros osobe z rodziny szlacheckiej</a></li></li></li><li><a href="houselure.php">Wyjdz z gabinetu</a></li></ul>');
}

if (isset ($_GET['action']) && $_GET['action'] == 'dyrektor'){
	$dyr = $db -> Execute("SELECT dyrektor FROM jobs WHERE gracz=" . $player -> id);
	$dyrektor = $dyr -> fields['dyrektor'];
	if ($dyrektor != 'Y'){
		error ('Nie jestes dyrektorem');
	}
	error ('Nic');
}

if (isset ($_GET['action']) && $_GET['action'] == 'zapraszajs'){
	$alf = $db -> Execute("SELECT alfons FROM jobs WHERE gracz=" . $player -> id);
	$alfons = $alf -> fields['alfons'];
	if ($alfons != 'Y'){
		error ('Nie jestes alfonsem');
	}
	$prac = $db -> Execute("SELECT praca FROM jobs WHERE gracz=" . $player -> id);
	$praca = $prac -> fields['praca'];
	if ($praca != 'N'){
		error ('Zamawiales kogos niedawno');
	}
	$char = $db -> Execute("SELECT charyzma FROM jobs WHERE gracz=" . $player -> id);
	$inteligencja = $char -> fields['inteligencja'];
	if ($charyzma > 8.999){
		error ('Zamawiasz rozne osoby jednak czujesz ze nic ci to juz nie daje. Moze powinienes zapraszac osoby z bardziej wyksztalconyh ludzi');
	}
	$chance = rand(1,4);

	if ($chance == 1)
	{
		$db -> Execute("UPDATE jobs SET inteligencja=inteligencja+ 0.015 WHERE gracz=".$player -> id);
		$db -> Execute("UPDATE jobs SET praca='Y' WHERE gracz=".$player -> id);
		$db -> Execute("UPDATE players SET credits=credits+ 1000 WHERE id=".$player -> id);
		error ('Zadzwoniles i zaprosiles do swojego burdelu pewnego pana. On zgodzil sie i przyszedl aby sie zabawic... Kiedy wychodzil zadowolony zaplacil ci <b>1000 zlota</b> oraz zdobyles <b>0.015</b> inteligencji');
	}
	if ($chance == 2)
	{
		$db -> Execute("UPDATE jobs SET inteligencja=inteligencja+ 0.01 WHERE gracz=".$player -> id);
		$db -> Execute("UPDATE jobs SET praca='Y' WHERE gracz=".$player -> id);
		$db -> Execute("UPDATE players SET credits=credits+250 WHERE id=".$player -> id);
		error ('Zadzwoniles i zaprosiles do swojego burdelu pewnego pana. On zgodzil sie i przyszedl aby sie zabawic... Kiedy wychodzil byl niezadowolony z uslug i zanim sie zorientowales uciekl bez zaplaty. Jedyne co cie pocieszylo to to ze zanim wyszedl upuscil <b>250 zlota</b>. Zdobyles <b>0.01</b> chazyzmy');
	}
	if ($chance == 3)
	{
		$db -> Execute("UPDATE jobs SET inteligencja=inteligencja- 0.002 WHERE gracz=".$player -> id);
		error ('Zadzwoniles i zaprosiles do swojego burdelu pewna pania. Ona niestety nie zgodzila sie. Straciles przez ta nieudana probe <b>0.002</b> chazyzmy. Moze powinienes sprobowac jeszcze raz w czasie tego resetu');
	}
	if ($chance == 4)
	{
		$db -> Execute("UPDATE jobs SET inteligencja=inteligencja+ 0.015 WHERE gracz=".$player -> id);
		$db -> Execute("UPDATE jobs SET praca='Y' WHERE gracz=".$player -> id);
		$db -> Execute("UPDATE players SET credits=credits+ 1500 WHERE id=".$player -> id);
		error ('Zadzwoniles i zaprosiles do swojego burdelu pewna pania. Ona zgodzila sie i przyszla aby sie zabawic... Kiedy wychodzila zadowolona zaplacila ci <b>1000 zlota</b> oraz zdobyles <b>0.015</b> chazyzmy. Dzieki twojemu szczeciu kiedy wychodzila upuscila jeszcze sakiewke z <b>500 sz zlota</b>');
	}
}

if (isset ($_GET['action']) && $_GET['action'] == 'zapraszajp'){
	$alf = $db -> Execute("SELECT alfons FROM jobs WHERE gracz=" . $player -> id);
	$alfons = $alf -> fields['alfons'];
	if ($alfons != 'Y'){
		error ('Nie jestes alfonsem');
	}
	$prac = $db -> Execute("SELECT praca FROM jobs WHERE gracz=" . $player -> id);
	$praca = $prac -> fields['praca'];
	if ($praca != 'N'){
		error ('Zamawiales kogos niedawno');
	}
	$char = $db -> Execute("SELECT charyzma FROM jobs WHERE gracz=" . $player -> id);
	$inteligencja = $char -> fields['inteligencja'];
	if ($charyzma > 16.999){
		error ('Zamawiasz rozne osoby jednak czujesz ze nic ci to juz nie daje. Moze powinienes zapraszac osoby z bardziej wyksztalconyh ludzi');
	}
	if ($charyzma < 9){
		error ('Nie mozesz zapraszac jeszcze takich ludzi. Na razie sprobuj w slamsie');
	}
	$chance = rand(1,4);

	if ($chance == 1)
	{
		$db -> Execute("UPDATE jobs SET charyzma=charyzma+ 0.03 WHERE gracz=".$player -> id);
		$db -> Execute("UPDATE jobs SET praca='Y' WHERE gracz=".$player -> id);
		$db -> Execute("UPDATE players SET credits=credits+ 2000 WHERE id=".$player -> id);
		$db -> Execute("UPDATE players SET platinum=platinum+ 10 WHERE id=".$player -> id);
		error ('Zadzwoniles i zaprosiles do swojego burdelu pewnego pana. On zgodzil sie i przyszedl aby sie zabawic... Kiedy wychodzil zadowolony zaplacil ci <b>2000 zlota oraz 10 mithrilu</b> oraz zdobyles <b>0.03</b> chazyzmy');
	}
	if ($chance == 2)
	{
		$db -> Execute("UPDATE jobs SET charyzma=charyzma+ 0.04 WHERE gracz=".$player -> id);
		$db -> Execute("UPDATE jobs SET praca='Y' WHERE gracz=".$player -> id);
		$db -> Execute("UPDATE players SET credits=credits+ 5000 WHERE id=".$player -> id);
		error ('Zaprosiles do siebie grupe osob na wieczor kawalerski. Kiedy wychodzili byl srednio zadowoleni ale musieli zaplacic. Dostales od nich <b>5000 zlota</b>. Zdobyles <b>0.04</b> chazyzmy');
	}
	if ($chance == 3)
	{
		$db -> Execute("UPDATE jobs SET charyzma=charyzma- 0.003 WHERE id=".$player -> id);
		error ('Zadzwoniles i zaprosiles do swojego burdelu pewna pania. Ona niestety nie zgodzila sie i powiedziala zebys nie dzwonil wiecej. Straciles przez ta nieudana probe <b>0.003</b> chazyzmy. Moze powinienes sprobowac jeszcze raz w czasie tego resetu');
	}
	if ($chance == 4)
	{
		$db -> Execute("UPDATE jobs SET charyzma=charyzma+ 0.02 WHERE gracz=".$player -> id);
		$db -> Execute("UPDATE jobs SET praca='Y' WHERE gracz=".$player -> id);
		$db -> Execute("UPDATE jobs SET credits=credits+ 2000 WHERE gracz=".$player -> id);
		error ('Zadzwoniles i zaprosiles do swojego burdelu pewna pania. Ona zgodzila sie i przyszla aby sie zabawic... Kiedy wychodzila zadowolona zaplacila ci <b>2000 zlota</b> oraz zdobyles <b>0.02</b> chazyzmy.');
	}
}

if (isset ($_GET['action']) && $_GET['action'] == 'zapraszajz'){
	$alf = $db -> Execute("SELECT alfons FROM jobs WHERE gracz=" . $player -> id);
	$alfons = $alf -> fields['alfons'];
	if ($alfons != 'Y'){
		error ('Nie jestes alfonsem');
	}
	$prac = $db -> Execute("SELECT praca FROM jobs WHERE gracz=" . $player -> id);
	$praca = $prac -> fields['praca'];
	if ($praca != 'N'){
		error ('Zamawiales kogos niedawno');
	}
	$char = $db -> Execute("SELECT charyzma FROM jobs WHERE gracz=" . $player -> id);
	$charyzma = $char -> fields['charyzma'];
	if ($charyzma > 34.999){
		error ('Zamawiasz rozne osoby jednak czujesz ze nic ci to juz nie daje. Moze powinienes zapraszac osoby z rodzin bardziej zamoznych');
	}
	if ($charyzma < 17){
		error ('Nie mozesz zapraszac jeszcze takich ludzi. Na razie sprobuj u ludzi przecietnych');
	}
	$chance = rand(1,4);

	if ($chance == 1)
	{
		$db -> Execute("UPDATE jobs SET charyzma=charyzma+ 0.05 WHERE gracz=".$player -> id);
		$db -> Execute("UPDATE jobs SET praca='Y' WHERE gracz=".$player -> id);
		$db -> Execute("UPDATE players SET credits=credits+ 3500 WHERE id=".$player -> id);
		$db -> Execute("UPDATE players SET platinum=platinum+ 20 WHERE id=".$player -> id);
		error ('Zadzwoniles i zaprosiles do swojego burdelu pewnego slawnego w kraju zamoznego pana. On chetnie przyjal propozycje. I kiedy skonczyl rzucil ci trzy sakiewki pelne monet... Przegladasz swoje znalezisko. A jest to <b>3500 zlota oraz 20 sz. mithrilu</b>. Zdobyles takze zdobyles <b>0.05</b> chazyzmy');
	}
	if ($chance == 2)
	{
		$db -> Execute("UPDATE jobs SET charyzma=charyzma-0.002 WHERE gracz=".$player -> id);
		error ('Dodzwoniles do pewnego domu. <i>Rezydecja panstwa Ziorowskich</i>. Ty pospiesnie odkladasz sluchawke. Dodzwoniles siedo swojej rodziny.Za ta wpadke straciles 0.002 charyzmy. Zdenerwowany sytuacja dzwonisz do kogo innego...');
	}
	if ($chance == 3)
	{
		$db -> Execute("UPDATE jobs SET charyzma=charyzma+ 0.08 WHERE id=".$player -> id);
		$db -> Execute("UPDATE jobs SET energy=energy+ 2 WHERE id=".$player -> id);
		$db -> Execute("UPDATE jobs SET praca='Y' WHERE gracz=".$player -> id);
		$db -> Execute("UPDATE players SET credits=credits- 1000 WHERE id=".$player -> id);
		error ('Zadzwoniles i zaprosiles do siebie pewnego pana. Po chwili przychodzi kobieta i mowi. Chcesz sie ze mna zabawic? Ty zdziwiony przytakujesz... Zyskujesz dzieki temu <b>0.008</b> chazyzmy oraz 2 energii. Po chwili orientujesz sie ze brakuje ci czegos. Patrzysz w sakiewke a tam brakuje 1000 zlota.');
	}
	if ($chance == 4)
	{
		$db -> Execute("UPDATE jobs SET charyzma=charyzma+ 0.04 WHERE gracz=".$player -> id);
		$db -> Execute("UPDATE jobs SET praca='Y' WHERE gracz=".$player -> id);
		$db -> Execute("UPDATE jobs SET credits=credits+ 4000 WHERE gracz=".$player -> id);
		error ('Zadzwoniles i zaprosiles do swojego burdelu pewna pania. Ona zgodzila sie i przyszla aby sie zabawic... Kiedy wychodzila zadowolona zaplacila ci <b>4000 zlota</b> oraz zdobyles <b>0.04</b> chazyzmy.');
	}
}

if (isset ($_GET['action']) && $_GET['action'] == 'zapraszajsz'){
	$alf = $db -> Execute("SELECT alfons FROM jobs WHERE gracz=" . $player -> id);
	$alfons = $alf -> fields['alfons'];
	if ($alfons != 'Y'){
		error ('Nie jestes alfonsem');
	}
	$prac = $db -> Execute("SELECT praca FROM jobs WHERE gracz=" . $player -> id);
	$praca = $prac -> fields['praca'];
	if ($praca != 'N'){
		error ('Zamawiales kogos niedawno');
	}
	$char = $db -> Execute("SELECT charyzma FROM jobs WHERE gracz=" . $player -> id);
	$charyzma = $char -> fields['charyzma'];
	if ($charyzma > 99.999){
		error ('Zamawiasz rozne osoby jednak czujesz ze nic ci to juz nie daje. Moze powinienes zostac dyrektorem tego przedciewziecia');
	}
	if ($charyzma < 35){
		error ('Nie mozesz zapraszac jeszcze takich ludzi. Na razie sprobuj u ludzi zamoznych');
	}
	$chance = rand(1,3);

	if ($chance == 1)
	{
		$db -> Execute("UPDATE jobs SET charyzma=charyzma+ 0.1 WHERE gracz=".$player -> id);
		$db -> Execute("UPDATE jobs SET praca='Y' WHERE gracz=".$player -> id);
		$db -> Execute("UPDATE players SET credits=credits+ 8500 WHERE id=".$player -> id);
		$db -> Execute("UPDATE players SET platinum=platinum+ 50 WHERE id=".$player -> id);
		error ('Przyszedl do ciebie klient z szlacheckiej rodziny. Powiedzial ze chce wynajac 3 dziewczyny. Ty z dolarami w oczach pokazujesz mu 3 najladniejsze. Po przespanej nocy budzisz sie ze zlotem na stole. Twoja nagroda to <b>8500 zlota</b> oraz <b>50 mithrilu</b>. Zdobyles takze zdobyles <b>0.1</b> chazyzmy');
	}
	if ($chance == 2)
	{
		$db -> Execute("UPDATE jobs SET charyzma=charyzma+ 0.08 WHERE id=".$player -> id);
		$db -> Execute("UPDATE jobs SET praca='Y' WHERE gracz=".$player -> id);
		$db -> Execute("UPDATE players SET credits=credits-1000  WHERE id=".$player -> id);
		error ('Przyszla do ciebie pewna pania z rodziny szlacheckiej. Zdobyles za to <b>0.08</b> charyzmy. Ale co to tego sie nie spodziewales osoba szlachecka ukradla ci <b>2000 zlota</b>');
	}
	if ($chance == 3)
	{
		$db -> Execute("UPDATE jobs SET charyzma=charyzma+ 0.2 WHERE gracz=".$player -> id);
		$db -> Execute("UPDATE jobs SET praca='Y' WHERE gracz=".$player -> id);
		$db -> Execute("UPDATE jobs SET credits=credits+ 10000 WHERE gracz=".$player -> id);
		$db -> Execute("UPDATE jobs SET platinum=platinum+ 50 WHERE gracz=".$player -> id);
		error ('Zaprosiles do burdelu syna z rodziny szlacheckiej na wieczor kawalerski. Czyjesz w zylach ze to najlepsza transakcja twojego zycia podczas ktorej zyskales <b>0.2</b> charyzmy oraz <b>10000 zlota</b> oraz <b> 50 sz. mithrilu</b>');
	}
}

if (isset ($_GET['action']) && $_GET['action'] == 'Herkulan'){
	if (7500 > $player -> gold) {
		error ('Nie masz wystarczajacej ilosci pieniedzy');
	}
	if( $player->burdel > 0 ) {
		error ('Mozesz uzywac 1 razy na reset');
	}
	$player->gold -= 7500;
	$player->burdel = 1;
	$player->energy += 3;
	error ('Zabawiales sie cala noc czujac ze zdobywasz nowe doswiadczenia');

}
if (isset ($_GET['action']) && $_GET['action'] == 'Illiadar'){
	if (12500 > $player -> gold) {
		error ('Nie masz wystarczajacej ilosci pieniedzy');
	}
	if( $player->burdel > 0 ) {
		error ('Mozesz uzywac 1 razy na reset');
	}
	$player->gold -= 12500;
	$player->burdel = 1;
	$player->energy += 4;
	error ('Zabawiales sie cala noc czujac ze zdobywasz nowe doswiadczenia');

}
if (isset ($_GET['action']) && $_GET['action'] == 'Oragon'){
	if (20000 > $player -> gold) {
		error ('Nie masz wystarczajacej ilosci pieniedzy');
	}
	if( $player->burdel > 0 ) {
		error ('Mozesz uzywac 1 razy na reset');
	}
	$player->gold -= 20000;
	$player->burdel = 1;
	$player->energy += 5;
	error ('Zabawiales sie cala noc czujac ze zdobywasz nowe doswiadczenia');

}
if (isset ($_GET['action']) && $_GET['action'] == 'Eilida'){
	if (7500 > $player -> gold) {
		error ('Nie masz wystarczajacej ilosci pieniedzy');
	}
	if( $player->burdel > 0 ) {
		error ('Mozesz uzywac 1 razy na reset');
	}
	$player->gold -= 7500;
	$player->burdel = 1;
	$player->energy += 3;
	error ('Zabawiales sie cala noc czujac ze zdobywasz nowe doswiadczenia');

}
if (isset ($_GET['action']) && $_GET['action'] == 'Karshala'){
	if (12500 > $player -> gold) {
		error ('Nie masz wystarczajacej ilosci pieniedzy');
	}
	if( $player->burdel > 0 ) {
		error ('Mozesz uzywac 1 razy na reset');
	}
	$player->gold -= 12500;
	$player->burdel = 1;
	$player->energy += 4;
	error ('Zabawiales sie cala noc czujac ze zdobywasz nowe doswiadczenia');

}
if (isset ($_GET['action']) && $_GET['action'] == 'Arenturia'){
	if (20000 > $player -> gold) {
		error ('Nie masz wystarczajacej ilosci pieniedzy');
	}
	if( $player->burdel > 0 ) {
		error ('Mozesz uzywac 1 razy na reset');
	}
	$player->gold -= 20000;
	$player->burdel = 1;
	$player->energy += 5;
	error ('Zabawiales sie cala noc czujac ze zdobywasz nowe doswiadczenia');

}
$smarty -> display ("houselure.tpl");
require_once("includes/foot.php");
?>

