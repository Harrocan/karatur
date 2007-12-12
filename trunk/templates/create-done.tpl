{if !$Created}
Taaaaak... a czy na pewno to co powiedziales jest prawda?.. zastanow sie moze cos przeoczyles albo cos Ci sie pomylilo.. lezales tu wkoncu dosc dlugi czas...<br/><br/>

Rasa : {$Summ.race}<br/>
P³eæ : {$Summ.gender}<br/>
Klasa : {$Summ.class}<br/>
Towarzysz : {$Summ.familiar}<br/>
Pochodzenie : {$Summ.origin}<br/>
<table>
	<tr>
		<td colspan="5">Atrybuty</td>
	</tr>
	<tr>
		<td>Si³a</td>
		<td>{$Summ.atr.str}</td>
	</tr>
	<tr>
		<td>Zrêczno¶æ</td>
		<td>{$Summ.atr.dex}</td>
	</tr>
	<tr>
		<td>Wytrzyma³o¶æ</td>
		<td>{$Summ.atr.con}</td>
	</tr>
	<tr>
		<td>Szybko¶æ</td>
		<td>{$Summ.atr.spd}</td>
	</tr>
	<tr>
		<td>Inteligencja</td>
		<td>{$Summ.atr.int}</td>
	</tr>
	<tr>
		<td>Si³a woli</td>
		<td>{$Summ.atr.wis}</td>
	</tr>
</table>
Stan : {$Summ.misc.stan}<br/>
W³osy : {$Summ.misc.wlos}<br/>
Oczy : {$Summ.misc.oczy}<br/>
Skóra : {$Summ.misc.skora}<br/>
charakter : {$Summ.misc.char}<br/>
Bóstwo : {$Summ.deity}<br/>
<input type="hidden" name="action" value="done" />
{else}
{if $Summ.char == 'Anielski' || $Summ.char == 'Chaotyczny dobry' || $Summ.char == 'Praworzadny Dobry' || $Summ.char == 'Dobry'}
*wypowiadajac slowa odnosnnie swego swiatopogladu starzec usmiecha sie z ulga i rzecze: * <i>"zaprawde powiadam Ci iz istot dobrych takich jak ty nam tu potrzeba .. naprawde czuje sie rad iz moglem spotkac kogos kto dobrem kierowany bedzie staral sie pomagac innym i moze jego dobre imie na wieki w kartah historii zapisane bedzie... a wiedz sadze iz to pomoze Ci w twej dalszej wedrowce"</i> *starzec wyciaga sakwe i rzuca Ci jednak niezdolales jej zlapac a ta wyladowala na ziemi. Nachylasz sie by ja siegnac a gdy wracasz do prostej postawy zauwazasz iz starzec siedzacy na kamieniu zniknal. <i>"A niech to.. mial mi powiedziec gdzie jestem.. jak tu sie znalazlem .. "</i> *pokiwales glowa i wyruszyles przed siebie ... by niedlugo dojsc do miasta swego pochodzenia.*
{elseif $Summ.char == 'Praworzadny Neutralny' || $Summ.char == 'Chaotycznie Neutralny' || $Summ.char == 'Neutralny'}
*wypowiadajac slowa odnosnnie swego swiatopogladu na twarzy starca zawidnial grymas zdziwienia. Po chwili jednak uslyszales jakis szelest w krzakach za toba i odskoczyles w przod spogladajac na miejsce z ktorego wydobywal sie odglos. Po dluzszej chwili wracasz wzrokiem na starca jednak ku twemu zdziwieniu zniknal jednak na swym miejscu sakwe pozostawiajac. Podchodzisz do sakwy i zabierasz ja po czym rozgladasz sie jeszcze raz i udajesz sie przed siebie by niedlugo dojsc do miasta swego pochodzenia.*
{else}
*wypowiadajac slowa odnosnnie swego swiatopogladu starzec otwiera szeroko oczy i przerazonym glosem rzecze: *<i> "yy .. chyba musze juz isc .. bardzo pozno sie zrobilo"</i> *starzec wstaje z kamienia i niezdarnie zaczyna kustykac w strone lasu, niezbyt Ci sie spodobala taka ignorancja, dla tego postanowiles wymierzyc kare na wlasna reke. Chwytasz za najblizsza galaz lezaca na ziemi po czym zmrozywszy oczy zaczynasz cicho podazac za starcem a gdy ten odwrocil sie by zobaczyc gdzie jestes z przerazeniem doszedl do wniosku ze to juz jego ostatnie chwile. Glosne lamanie czaszki obieglo caly las zas postura starca lezala juz na ziemi z rozlupana glowa w kaluzy wlasnej krwi.* <i>"Cholerny dziad"</i> *odrzekasz po czym zaczynasz prszeszukiwac zwloki i wynajdujesz sakiewke. Rozbawiony zaistniala sytuacja chowasz mieszek i udajesz sie przed siebie by niedlugo dojsc do miasta swego pochodzenia.*
{/if}
<br/><br/><a href="city.php">Wejscie</a> do miasta<br/>
<b>Kilka dodatkowych informacji</b><br/>
Znajdujesz siê w krainie, gdzie du¿± wagê stawiamy na klimat i rozwój fabularny. Nie jest mo¿liwe na KaraTur szubkie nabijanie poziomów, gdy¿ m.in. system szkó³ zosta³ zbalansowany i zale¿y od poziomu postaci. Dlatego gor±co zachêcamy do uzupe³nienia profilu oraz wybraniu avatara. Takie drobnoski, ale jednak bardzo umilaj± ¿ycie.<br/>
Je¶li nie wiesz do kogo siê zwróciæ z pytaniem - wybierz 'Rangi' w lewym panelu<br/>
Je¶li nie wiesz jak tworzyæ profil - 'Nowy BBCode' w lewym panelu s³u¿y za pomoc<br/>
Je¶li nie wiesz jak siê poruszaæ na KT - w Pomocy w lewym panelu wybierz 'Nowe elementy w grze'<br/>
Je¶li znajdziesz b³±d - koniecznie zg³o¶ go na 'Formularzz zg³oszeniowy' w lewym panelu, stosuj±c siê do wytycznych któe pojawi± siê w zale¿no¶ci od rodzaju zg³oszenia jakie zamie¶cisz.<br/><br/>
Zyczymy mi³ej gry<br/>
KaraTur-Team
{/if}