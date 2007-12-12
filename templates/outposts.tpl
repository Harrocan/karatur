<center><img src="straznica1.jpg"></center><br>
{if $Outpost == ""}
    Nie masz dostepu do straznicy! Za 500 sztuk zlota, mozesz wykupic kawalek ziemi pod nia. Wiec jak, chcesz kupic?<br /><br />
    "<a href="outposts.php?action=buy">Tak</a>."<br />
    "<a href="city.php">Nie</a>."<br />
{/if}

{if $View == "" && $Outpost != ""}
    Witaj w straznicy. Jezeli pierwszy raz tu jestes, powinienes przeczytac instrukcje.
    <ul>
    <li><a href="outposts.php?view=myoutpost">Moja Straznica</a>
    <li><a href="outposts.php?view=taxes">Sciagnij daniny z wiosek</a>
    <li><a href="outposts.php?view=shop">Rozbudowa oraz zaciag armii</a>
    <li><a href="outposts.php?view=gold">Skarbiec</a>
    <li><a href="outposts.php?view=battle">Atakuj Straznice</a>
    <li><a href="outposts.php?view=listing">Lista Straznic</a><br><br>
    <li><a href="outposts.php?view=guide">Instrukcja Straznicy</a>
{/if}

{if $View == "gold"}
    Tutaj mozesz przekazac zloto ze od siebie do straznicy. Przelicznik w przypadku wybrania sztuk zlota ze straznicy jest 2:1 (czyli za 2 sztuki zlota ze straznicy dostajesz 1 sztuke zlota do reki), natomiast w przypadku dotowania straznicy przelicznik wynosi 1:1. Obecnie w straznicy posiadasz <b>{$Gold}</b> sztuk zlota.<br /><br />
    <form method="post" action="outposts.php?view=gold&step=player">
    <input type="submit" value="Zabierz"> <input type="text" name="zeton" value="0"> sztuk zlota ze straznicy.</form>
    <form method="post" action="outposts.php?view=gold&step=outpost">
    <input type="submit" value="Dodaj"> <input type="text" name="sztuki" value="0"> sztuk zlota do straznicy.</form>
    {$Message}
{/if}

{if $View == "veterans"}
    <table>
    <tr><td><b>Imie</b>:</td><td>{$Vname}</td></tr>
    <tr><td><b>Bron</b>:</td><td>{$Wname} (sila: {$Wpower}) {if $Aid[1] != "0" || $Hid[1] != "0" || $Lid[1] != "0"} <form method="post" action="outposts.php?view=veterans&id={$Vid}&step=modify"> {/if}</td></tr>
    <tr><td><b>Zbroja</b>:</td><td>{$Aname} {if $Aname != "brak"} (obrona: {$Apower}) {/if} {if $Aid[1] != "0"} <select name="armor"> {section name=outpost9 loop=$Aid}
                    <option value="{$Aid[outpost9]}">{$Aname1[outpost9]} (Obrona: {$Apower1[outpost9]})</option>
                  {/section} </select>{/if}</td></tr>
    <tr><td><b>Helm</b>:</td><td>{$Hname} {if $Hname != "brak"} (obrona: {$Hpower}) {/if} {if $Hid[1] != "0"} <select name="helm"> {section name=outpost10 loop=$Hid}
                    <option value="{$Hid[outpost10]}">{$Hname1[outpost10]} (Obrona: {$Hpower1[outpost10]})</option>
                  {/section} </select>{/if}</td></tr>
    <tr><td><b>Nagolenniki</b>:</td><td>{$Lname} {if $Lname != "brak"} (obrona: {$Lpower}) {/if} {if $Lid[1] != "0"} <select name="legs"> {section name=outpost11 loop=$Lid}
                    <option value="{$Lid[outpost11]}">{$Lname1[outpost11]} (Obrona: {$Lpower1[outpost11]})</option>
                  {/section} </select>{/if}</td></tr>
    <tr><td><b>Atak</b>:</td><td>{$Power}</td></tr>
    <tr><td><b>Obrona</b>:</td><td>{$Defense}</td></tr>
    {if $Aid[1] != "0" || $Hid[1] != "0" || $Lid[1] != "0"}
        <tr><td colspan="2" align="center"><input type="submit" value="Modyfikuj"></form>
    {/if}
    </table>
    {$Message}
{/if}

{if $View == "myoutpost"}
    Witaj w swojej Straznicy, {$User}.<br /><br /><b><u>Informacje o Straznicy</b></u><br />
    <table>
    <tr><td><b>Liczba ziem</b>:</td><td>{$Size}</td></tr>
    <tr><td><b>Punktow Ataku</b>:</td><td>{$Turns}</td></tr>
    <tr><td><b>Sztuk zlota</b>:</td><td>{$Gold}</td></tr>
    <tr><td><b>Piechoty</b>:</td><td>{$Warriors} (wolne: {$Maxtroops})</td></tr>
    <tr><td><b>Lucznikow</b>:</td><td>{$Archers} (wolne: {$Maxtroops})</td></tr>
    <tr><td><b>Fortyfikacji</b>:</td><td>{$Barricades} (wolne: {$Maxequip})</td></tr>
    <tr><td><b>Machin</b>:</td><td>{$Catapults} (wolne: {$Maxequip})</td></tr>
    {if $Size > 3}
        <tr><td><b>Legowiska bestii</b>:</td><td>{$Fence} (maksymalnie: {$Maxfence})</td></tr>
        <tr><td><b>Bestie</b>:</td><td>{$Monster} (wolne: {$Maxmonster})</td></tr>
        {if $Mid != "0"}
            {section name=outpost3 loop=$Mname}
                <tr><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;<b>{$Mname[outpost3]}</b> (sila: {$Mpower[outpost3]} obrona: {$Mdefense[outpost3]})</td></tr>
            {/section}
        {/if}
        <tr><td><b>Kwater weteranow</b>:</td><td>{$Barracks} (maksymalnie: {$Maxbarracks})</td></tr>
        <tr><td><b>Weteranow</b>:</td><td>{$Veterans} (wolne: {$Maxveterans})</td></tr>
        {if $Vid != "0"}
            {section name=outpost8 loop=$Vname}
                <tr><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;<b><a href="outposts.php?view=veterans&id={$Vid[outpost8]}">{$Vname[outpost8]}</a></b> (sila: {$Vpower[outpost8]} obrona: {$Vdefense[outpost8]})</td></tr>
            {/section}
        {/if}
    {/if}
    {if $Warriors > 0 || $Archers > 0}
        <tr><td><b>Zmeczenie Armii</b>:</td><td>{$Fatigue}%</td></tr>
        <tr><td><b>Morale Armii</b>:</td><td>{$Morale} ({$Moralename})</td></tr>
    {/if}
    <tr><td><b>Koszt</b>:</td><td>{$Cost} sztuk zlota na reset</td></tr>
    </table>
    <br /><br /><b><u>Premie dowodcy</b></u><br />
    <table>
    <tr><td><b>Sila ataku<b/>:</td><td>+ {$Attack} % {if $Link == "Y" && $Attack < 15}<a href="outposts.php?view=myoutpost&step=add&ability=battack">Dodaj premie</a>{/if}</td></tr>
    <tr><td><b>Obrona<b/>:</td><td>+ {$Defense} % {if $Link == "Y" && $Defense < 15}<a href="outposts.php?view=myoutpost&step=add&ability=bdefense">Dodaj premie</a>{/if}</td></tr>
    <tr><td><b>Wplywy z danin<b/>:</td><td>+ {$Tax} % {if $Link == "Y" && $Tax < 15}<a href="outposts.php?view=myoutpost&step=add&ability=btax">Dodaj premie</a>{/if}</td></tr>
    <tr><td><b>Strat w bitwie<b/>:</td><td>- {$Lost} % {if $Link == "Y" && $Lost < 15}<a href="outposts.php?view=myoutpost&step=add&ability=blost">Dodaj premie</a>{/if}</td></tr>
    <tr><td><b>Koszt utrzymania<b/>:</td><td>- {$Bcost} % {if $Link == "Y" && $Bcost < 15}<a href="outposts.php?view=myoutpost&step=add&ability=bcost">Dodaj premie</a>{/if}</td></tr>
    </table>
    {$Message}
{/if}

{if $View == "taxes"}
    Tutaj mozesz zbierac danine z wiosek otaczajacych twoja straznice. Im wiecej posiadasz piechoty oraz lucznikow, tym wiekszy obszar moga oni zwiedzic i zebrac wiecej sztuk zlota. Kazda taka wyprawa pochlania 1 Punkt Ataku.<br /><br />
    <form method="post" action="outposts.php?view=taxes&step=gain">
    <input type="submit" value="Wyslij"> zolnierzy <input type="text" name="amount" value="0"> razy do wiosek</form>
    {$Message}
{/if}

{if $View == "shop"}
    Witaj w sklepie w Straznicy! Kupisz tutaj zolnierzy, fortyfikacje oraz machiny obleznicze, mozesz rowniez zwiekszyc rozmiar swojej Straznicy. Obecnie mozesz jeszcze dokupic <b>{$Maxtroops}</b> zolnierzy oraz <b>{$Maxequips}</b> machin lub fortyfikacji.
    <ul>
    <li><a href="outposts.php?view=shop&buy=s">Powieksz rozmiar Straznicy</a> ({$Need} sztuk zlota)</li>
    {if $Need1 > "0"}
        <li><a href="outposts.php?view=shop&buy=f">Dokup 1 Legowisko Bestii</a> ({$Need1} sztuk zlota)</li>
    {/if}
    {if $Need2 > "0"}
        <li><a href="outposts.php?view=shop&buy=r">Dokup 1 Kwatere Weterana</a> ({$Need2} sztuk zlota)</li>
    {/if}
    </ul>
    <form method="post" action="outposts.php?view=shop&buy=w">
    <input type="submit" value="Kup"> <input type="text" name="army" value="0"> piechurow (+3 atak, +1 obrona, 25 sztuk zlota jeden). (Dostepnych: {$Awarriors})</form>
    <form method="post" action="outposts.php?view=shop&buy=a">
    <input type="submit" value="Kup"> <input type="text" name="army" value="0"> lucznikow (+1 atak, +3 obrona, 25 sztuk zlota jeden). (Dostepnych: {$Aarchers})</form>
    <form method="post" action="outposts.php?view=shop&buy=b">
    <input type="submit" value="Kup"> <input type="text" name="army" value="0"> fortyfikacji (+3 obrona, 35 sztuk zlota jedna). (Dostepnych: {$Abarricades})</form>
    <form method="post" action="outposts.php?view=shop&buy=c">
    <input type="submit" value="Kup"> <input type="text" name="army" value="0"> machin oblezniczych (+3 atak, 35 sztuk zlota jedna).  (Dostepnych: {$Acatapults})</form>
    {if $Fence == "Y"}
        <form method="post" action="outposts.php?view=shop&buy=m">
        <input type="submit" value="Dodaj"> <select name="army">
        {section name=outpost2 loop=$Mid}
            <option value="{$Mid[outpost2]}">{$Mname[outpost2]} (Atak: {$Power[outpost2]} | Obrona: {$Defense[outpost2]})</option>
        {/section}
        </select> do straznicy (2000 sztuk zlota jeden)</form>
    {/if}
    {if $Barracks == "Y"}
        <form method="post" action="outposts.php?view=shop&buy=v">
        <input type="submit" value="Dodaj"> weterana o imieniu <input type="text" name="vname"><br />
        <b>Atak:</b> 1 + <select name="weapon">
        {section name=outpost4 loop=$Wid}
            <option value="{$Wid[outpost4]}">{$Wname[outpost4]} (Sila: {$Wpower[outpost4]})</option>
        {/section}
        </select><br />
        <b>Obrona:</b> 1 + <br />
        Zbroja:
        {if $Aid[1] != "0"}
            <select name="armor">
            {section name=outpost5 loop=$Aid}
                <option value="{$Aid[outpost5]}">{$Aname[outpost5]} (Obrona: {$Apower[outpost5]})</option>
            {/section}
            </select><br />
        {/if}
        {if $Aid[1] == "0"}
            brak<br />
        {/if}
        Helm:
        {if $Hid[1] != "0"}
            <select name="helm">
            {section name=outpost6 loop=$Hid}
                <option value="{$Hid[outpost6]}">{$Hname[outpost6]} (Obrona: {$Hpower[outpost6]})</option>
            {/section}
            </select><br />
        {/if}
        {if $Hid[1] == "0"}
            brak<br />
        {/if}
        Nagolenniki:
        {if $Lid[1] != "0"}
            <select name="legs">
            {section name=outpost7 loop=$Lid}
                <option value="{$Lid[outpost7]}">{$Lname[outpost7]} (Obrona: {$Lpower[outpost7]})</option>
            {/section}
            </select><br />
        {/if}
        {if $Lid[1] == "0"}
            brak<br />
        {/if}
        do straznicy (2000 sztuk zlota jeden)</form>
    {/if}
    {$Message}
{/if}

{if $View == "listing"}
    {if $Step == ""}
        <form method="post" action="outposts.php?view=listing&step=list">
        <input type="submit" value="Pokaz"> straznice od rozmiaru <input type="text" name="slevel" size="5" value="1"> do
        <input type="text" name="elevel" size="5" value="1"></form>
    {/if}
    {if $Step != ""}
        <table>
        <tr>
        <td width="100"><b><u>ID Straznicy</td>
        <td width="100"><b><u>Rozmiar Straznicy</td>
        <td width="100"><b><u>Wlasciciel</td>
        <td width="100"><b><u>Atakowac?</td>
        </tr>
        {section name=outposts1 loop=$Oid}
            <tr>
            <td>{$Oid[outposts1]}</td>
            <td>{$Size[outposts1]}</td>
            <td><a href="view.php?view={$Owner[outposts1]}">{$Owner[outposts1]}</a></td>
            <td>- <a href="outposts.php?view=battle&oid={$Oid[outposts1]}">Atak</a></td>
            </tr>
        {/section}
        </table>
    {/if}
{/if}

{if $View == "battle"}
    Witaj w pokoju narad. Wpisz po prostu ID Straznicy oraz ile razy ma nastapic atak.
    <table><form method="post" action="outposts.php?view=battle&action=battle">
    <tr><td>ID Straznicy:</td><td><input type="text" name="oid" size="6" value="{$Id}"></td></tr>
    <tr><td>Ilosc atakow:</td><td><input type="text" name="amount" size="6"></td></tr>
    <tr><td colspan="2" align="center"><input type="submit" value="Atak"></td></tr>
    </form></table>
    {section name=outposts loop=$Result}
        {$Result[outposts]}
    {/section}
{/if}

{if $View == "guide"}
    <u><b>Podstawy</b></u><br />
    Podstawowym zadaniem w grze jest posiadanie najwiekszej straznicy i najsilniejszej armii Podczas kazdego
    resetu, dostajesz 3 punkty ataku ale rowniez co reset musisz oplacac swoje wojska. Koszty moga byc znacznie nizsze jezeli inwestujesz odpowiednio w umiejetnosc Dowodzenie. Mozesz zrobic co chcesz z tymi punktami.
    <br /><br /><u><b>Moja straznica</b></u><br />
    To centrum zarzadzania twoja straznica - tutaj znajdziesz wszystkie informacje na jej temat - liczbe posiadanych wojsk, machin oraz fortyfikacji i budynkow specjalnych (tylko wtedy jezeli twoja straznica osiagnie odpowiedni rozmiar). Oprocz tego tutaj rowniez znajduja sie informacje na temat premii jakie posiadasz z umiejetnosci Dowodzenie. Kazdy punkt w tej umiejetnosci pozwala podniesc jedna premie o 1 % do maksymalnego poziomu 15 % w danej premii. Kiedy bedziesz mial mozliwosc podniesienia jakiejs premii, obok niej, pojawi sie link informujacy o tym.<br />
    Oprocz tego tutaj rowniez mozesz dozbrajac swoich weteranow (jezeli takowych posiadasz). Aby to zrobic, wystarczy kliknac na imie danego weterana.
    <br /><br /><u><b>Zbieranie danin</b></u><br />
    Daniny sa bardzo dobrym sposobem na zarobienie pieniedzy. Wydobycie zabiera jeden Punkt Ataku. Za kazdym razem, kiedy zbierasz daniny, dostajesz sztuki zlota. Jego ilosc zalezy od liczby twoich piechurow oraz lucznikow.
    <br /><br /><u><b>Rozbudowa oraz zaciag armii</b></u><br />
    To jest podstawowy sklep, gdzie mozesz kupowac zolnierzy, fortyfikacje, machiny, jednostki i budynki specjalne oraz rozbudowywac straznice. Wojsko dzieli sie na 2 typy - bardziej ofensywne jednostki (piechurzy) oraz bardziej defensywne (lucznicy). Dodatkowo mozesz kupowac fortyfikacje ktore podniosa obrone twojej straznicy oraz machiny obleznicze ktore zwiekszaja twoje zdolnosci ataku na inne straznice. Oprocz tego, jezeli spelniasz odpowiednie warunki (masz odpowiedni rozmiar straznicy) mozesz dokupic specjalne budynki takie jak Legowisko Bestii czy Kwatera Weterana, ktore pozwola ci rekrutowac specjalne jednostki. Ale nie tylko budynki sa potrzebne do tego celu. Potrzeba jeszcze sztuk zlota do tego celu oraz: <br />
    - dla Bestii - musisz miec przy najmniej jednego chowanca<br />
    - dla Weterana - musisz miec przy najmniej jedna sztuke broni w plecaku<br />
    Podczas wynajmowania Weteranow mozesz wybrac ich uzbrojenie oraz opancerzenie - nie musisz wybierac wszystkiego na raz - w pozniejszym okresie bedziesz mogl go dozbroic.
    <br /><br /><u><b>Skarbiec</b></u><br />
    W skarbcu w straznicy mozesz wymienic sztuki zlota jakie sie w nim znajduja, na te ktore masz w reku i na odwrot. W przypadku kiedy wplacasz przelicznik wynosi 1:1 (czyli za 10 wplaconych sztuk zlota w straznicy pojawia sie 10 sztuk zlota), natomiast w przypadku wyplaty przelicznik wynosi 2:1 (czyli za 10 wyplaconych ze straznicy sztuk zlota w reku pojawia sie 5 sztuk zlota).
    <br /><br /><b><u>Atakowanie Straznicy</b></u><br />
    Atakowanie innych straznic to rowniez sposob na zdobywanie zlota. Jednak podczas ataku musisz uwazac - nawet jezeli wygrasz, tracisz czesc ze swojego wojska (jest rowniez mala szansa na strate jednostek specjalnych). Ale ten ktory przegra zawsze gorzej na tym wychodzi. W nagrode za udany atak dostajesz nie tylko zloto ale rowniez podnosisz swoj poziom w umiejetnosci Dowodzenie.
{/if}

{if $View != ""}
    <br /><br />[<a href="outposts.php">Menu</a>]
{/if}

