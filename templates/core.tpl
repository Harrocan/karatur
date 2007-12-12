<center><img src="polana1.jpg"/></center><br />
{if $Corepass != "Y"}
    Witaj na Polanie Chowancow. Polana Chowancow jest o miescje gdzie trzymane sa zwierzeta wystepujace w naszej pieknej krainie Kara-Tur. Normalnie poluje sie
    na nie jako na zwierzyne lowna, ale tutaj sa trzymane pod straza. Jezeli kupisz Licencje na Chowanca, bedziesz mogl zlapac i trenowac
    wlasnego podopiecznego.
    {if $Gold >= "500"}
        <br>Masz odpowiednia ilosc sztuk zlota ?-jesli posiadasz 500 sztuk to dlaczego nie kupisz licencji? To otworzy ci kolejne miejsce w miescie.
        <ul>
        <li><a href="core.php?answer=yes">Jasne, kupuje.</a></li>
        <li><a href="core.php?answer=no">Niee...</a></li>
        </ul>
    {/if}
{/if}

{if $View == "" && $Corepass == "Y"}
    Witaj w Sektorze! Widze, ze masz swoja licencje... w porzadku, baw sie dobrze.
    <ul>
    <li><a href="core.php?view=mycores">Moje Chowance</a>
    <li><a href="core.php?view=arena">Arena Chowancow</a>
    <li><a href="core.php?view=train">Sala Treningowa Chowancow</a>
    <li><a href="core.php?view=market">Sklep z Chowancami</a>
    <li><a href="core.php?view=explore">Szukaj</a>
    <li><a href="core.php?view=library">Biblioteka Chowancow</a><br><br>
    <li><a href="core.php?view=help">Opis Polany Chowancow</a>
    </ul>
{/if}

{if $View == "mycores"}
    {if $Coreid == ""}
        Tutaj jest lista wszystkich Chowancow jakie znalazles.
        <ul>
        {section name=core loop=$Name}
            <li><a href="core.php?view=mycores&id={$Coreid1[core]}">{$Name[core]} Chowaniec</a> {$Activ[core]}</li>
        {/section}
        </ul>
    {/if}
    {if $Coreid > "0"}
        <center><br><table class="td" width="300" cellpadding="0" cellspacing="0">
        <tr><td align="center" style="border-bottom: solid black 1px;" colspan="2"><b>Zobacz Chowanca</b></td></tr>
        <tr><td width="150" valign="top">+ <b>Podstawowe Informacje</b>
        <ul>
        <li>ID: {$Id}</li>
        <li>Imie: {$Name}</li>
        <li>Typ: {$Type}</li>
        </ul>
        </td><td width="150" valign="top" style="border-left: solid black 1px">
        + <b>Fizyczne informacje</b>
        <ul>
        <li>Status: {$Stat}</li>
        <li>Sila: {$Power}</li>
        <li>Obrona: {$Defense}</li>
        </ul>
        </td></tr>
        <tr><td colspan="2" align="center" style="border-top: solid black 1px;">Opcje:
        (<a href="core.php?view=library&id={$Library}">Zobacz opis</a>)
        {$Link}
        (<a href="core.php?view=mycores&release={$Id}">Uwolnij</a>)
        (<a href="core.php?view=mycores&give={$Id}">Przekaz innemu graczowi</a>)</td></tr>
        </table></center>
    {/if}
    {if $Give > "0"}
        <form method="post" action="core.php?view=mycores&give={$Id}&step=give">
        <input type="submit" value="Daj"> {$Name} graczowi o ID: <input type="text" name="gid" size="5">
        </form>
    {/if}
{/if}

{if $View == "library"}
    {if $Coreid == ""}
        Witaj w Bibliotece Chowancow, {$Name}. Znajdziesz tutaj informacje o twoich <b>{$Plcores}</b> chowancach
        posrod informacji o wszystkich <b>{$Allcores}</b> znajdujacych sie w bibliotece.
        <br><br>Mozesz uzywac naszej biblioteki aby zobaczyc informacje tylko o tych chowancach, ktore juz widziales.
        <br><br>+ <b>Podstawowe Chowance</b><br>
        <ul>
        {section name=core loop=$Normalcore}
            {$Normalcore[core]}
        {/section}
        </ul>
        {if $Hybridcore > "0"}
            + <b>Laczone chowance</b><br>
            <ul>
            {section name=core1 loop=$Hybridcore1}
                {$Hybridcore1[core1]}
            {/section}
            </ul>
        {/if}
        {if $Specialcore > "0"}
            + <b>Specjalne chowance</b><br>
            <ul>
            {section name=core2 loop=$Specialcore1}
                {$Specialcore1[core2]}
            {/section}
            </ul>
        {/if}
    {/if}
    {if $Coreid > "0"}
        {if $Yourcore > 0}
	    <br><center>
	    <table cellpadding="0" cellspacing="0" class="td" align="center" width="300">
	    <tr><td colspan="2" align="center" style="border-bottom: solid black 1px;"><b>Obejrzyj chowanca</td></tr>
	    <tr><td colspan="2" align="center"><img src="images/pets/{$Id}.jpg"></td></tr>
	    <tr><td valign="top" width="150">
	    + <b>Podstawowe informacje</b>
	    <ul>
	    <li>Standardowy ID: {$Id}
	    <li>Nazwa: {$Name}
	    <li>Typ: {$Type}
	    <li>Rzadkosc: {$Rarity}
	    <li>Zlapano: {$Caught}
	    </ul>
	    </td><td width="150" valign="top" style="border-left: solid black 1px;">
	    {$Description}
	    </td></tr></table></center>
	{/if}
    {/if}
{/if}

{if $View == "arena"}
    {if $Step == "" && $Attack == ""}
        Witaj na Arenie Chowancow. Sa pewne roznice w stosunku do walki na Arenie Walk - kazdy Chowaniec zadaje jeden cios innemu.
        Ten, ktory zada najwiecej obrazen jest uznawany za zwyciezce.
        <ul>
        {$Forest}
        {$Sea}
        {$Mountains}
        {$Plant}
        {$Desert}
        {$Magic}
        <li><a href="core.php?view=arena&step=heal">Ulecz moje chowance</a>.
        </ul>
    {/if}
    {if $Step == "battles" && $Attack == ""}
        <table><tr><td width=100><b><u>Chowaniec</td><td width=100><b><u>Wlasciciel</td><td width=100><b><u>Opcje</td></tr>
        {section name=core3 loop=$Corename}
            <tr>
            <td><a href="core.php?view=library&id={$Library[core3]}">{$Corename[core3]}</a> Chowaniec</td>
            <td><a href="view.php?view={$Owner[core3]}">{$Owner[core3]}</a></td>
            <td><a href="core.php?view=arena&attack={$Attackid[core3]}">Atak</a></td>
            </tr>
        {/section}
        </table>
    {/if}
    {if $Attack > "0"}
        + <b>Walka Chowancow</b><br>
        Twoj Chowaniec {$Ycorename} przeciwko ID {$Ecoreowner} {$Ecorename} Chowancowi.<br><br>
        Wrogi Chowaniec <b>{$Ecorename}</b> atakuje za {$Ecoreattack}!<br>Twoj Chowaniec <b>{$Ycorename}</b> atakuje za {$Ycoreattack}!<br><br>
        {$Result}
        {$Info}
        {$Gains}
    {/if}
    {if $Step == "heal"}
        To bedzie kosztowac <b>{$Cost}</b> sztuk zlota, aby wyleczyc wszystkie twoich <b>{$Number}</b> martwych Chowancow.
        <ul>
        <li><a href="core.php?view=arena&step=heal&answer=yes">Wylecz je</a>
        <li><a href="core.php">Nie chce leczyc ich teraz</a>.
        </ul>
    {/if}
{/if}

{if $View == "train"}
    Witaj w sali treningowej. Dostajesz 15 punktow treningu kazdego dnia. Kazdy punkt podwyzsza Chowancowi .125 w odpowiedniej statystyce.
    Obecnie masz <b>{$Trains}</b> wolnych punktow treningowych.
    <form method="post" action="core.php?view=train&step=train">
    Trenuj mojego <select name="train_core">
    {section name=core4 loop=$Corename}
        <option value="{$Coreid1[core4]}">{$Corename[core4]}</option>
    {/section}
    </select> 
    Chowanca <input type=text size=5 name=reps> razy w <select name=technique>
    <option value=power>Sile</option>
    <option value=defense>Obronie</option>
    </select>. <input type=submit value=Trenuj></form>
{/if}

{if $View == "market"}
    {if $Step == ""}
        Witaj w sklepie z Chowancami. Tutaj mozesz kupic Chowanca od innych graczy. Co chcesz zrobic?
        <ul>
        <li><a href="core.php?view=market&step=market">Zobacz oferty</a>
        <li><a href="core.php?view=market&step=add">Dodaj oferte</a>
        </ul>
    {/if}
    {if $Step == "market"}
        Tutaj sa oferty sprzedazy Chowancow przez innych graczy.<br><br>
        <table>
        <tr><td width="100"><b><u>Nazwa Chowanca</td>
        <td width="100"><b><u>ID Sprzedajacego</td>
        <td width="100"><b><u>Cena</td>
        <td width="100"><b><u>Opcje</td></tr>
        {section name=core5 loop=$Link}
            {$Link[core5]}
        {/section}
        </table>
    {/if}
    {if $Step == "add"}
        Tutaj dodasz swoja oferte sprzedazy chowanca.
        <form method="post" action="core.php?view=market&step=add&action=add">
        Dodaj mojego <select name="add_core">
        {section name=core6 loop=$Corename}
            <option value="{$Coreid1[core6]}">{$Corename[core6]}</option>
        {/section}
        </select> Chowanca za <input type=text size=7 name=cost> sztuk zlota. <input type=submit value=Sprzedaj></form>
    {/if}
{/if}

{if $View == "explore"}
    {if $Next == ""}
        Witaj w centrum poszukiwan Chowancow. Prosze, wybierz region, z ktorego szukasz chowanca. Jest wiele regionow, ale musisz posiadac
        odpowiednia ilosc mithrilu aby moc wejsc w jeden z nich. Kazde poszukianie chowanca kosztuje 0.1 energii. Chowance przyciaga
        mithril z wielu powodow...
        <form method="post" action="core.php?view=explore&next=yes">
        <select name="explore"><option value="Forest">Las (0 mith)</option>
        <option value="Ocean">Ocean (50 mith)</option>
        <option value="Mountains">Gory (100 mith)</option>
        <option value="Plains">Laki (150 mith)</option>
        <option value="Desert">Pustynia (200 mith)</option>
        <option value="Magic">W innym wymiarze (250 mith)</option></select><br>
        Szukaj <input type="text" name="repeat" size="4"> razy<br>
        <input type="submit" value="Szukaj"></form>
    {/if}
    {if $Next == "yes"}
        Chcesz szukac Chowanca w regionie: <b>{$Area}</b>...<br>
        {section name=core7 loop=$Find1}
            {$Find1[core7]}
            {$Find2[core7]}
            {$Find3[core7]}
        {/section}
  	<br>Szukales chowancow {$Repeat} razy<br>
        <br>Chcesz szukac ponownie?<br>
        <a href="core.php?view=explore">Tak</a><br>
        <a href="core.php">Nie</a><br>
    {/if}
{/if}

{if $View == "help"}
    {if $Step == ""}
        Witaj w opisie Polany Chowancow. Wszystko co potrzebujesz wiedziec, znajduje sie wlasnie tutaj.
        <ul>
        <li><a href="core.php?view=help&step=getting">Zdobywanie Chowancow</a>
        <li><a href="core.php?view=help&step=info">Informacje o Chowancach</a>
        <li><a href="core.php?view=help&step=library">Biblioteka Chowancow</a>
        <li><a href="core.php?view=help&step=training">Trenowanie Chowancow</a>
        <li><a href="core.php?view=help&step=battling">Walka Chowancow</a>
        </ul>
    {/if}
    {if $Step == "getting"}
        + <b>Zdobywanie Chowancow</b><br><br>
        Najprostszym sposobem jest lapanie ich! Jest to bardzo proste. Wszystko co potrzebujesz to isc do opcji Szukaj. Nastepnie zobaczysz
        kilka opcji. Jest wiele regionow do wyboru, ale kazdy jest oznaczony (# mith). Musisz miec co najmniej tyle samo mithrilu ile
        jest podane jako #. Liczba ta oznacza rowniez ile zaplacisz za znalezienie jedenego chowanca danego typu. Kazde poszukiwanie kosztuje
        0,01 energii<br><br>Chowance sa posegregowane wedlug rzadkosci. Czesto spotykane - szansa aby je zlapac jest okolo 1/150.
        Rzadkie aby zlapac 1/750, Bardzo rzadkie okolo 1/1500.
    {/if}
    {if $Step == "info"}
        + <b>Informacje o Chowancach</b><br><br>
        Aby zobaczyc informacje o Chowancu, musisz kliknac opcje Moje Chowance. Nastepnie kliknij na nazwie Chowanca. Bedziesz mial mozliwosc
        obejrzenia Chowanca, aktywacji go lub uwolnienia.
    {/if}
    {if $Step == "library"}
        + <b>Biblioteka Chowancow</b><br><br>
        Biblioteka Chowancow pokaze ci informacje o wszystkich chowancach jakie zebrales. Mozesz zobaczyc tylko te, ktore posiadasz.
    {/if}
    {if $Step == "training"}
        + <b>Trenowanie Chowancow</b><br><br>
        To miejsce posiada wlasny opis. Za kazde .2 punktu treningowego, twoj Chowaniec zdobywa .1 w odpowiedniej statystyce.
    {/if}
    {if $Step == "battling"}
        + <b>Walka Chowancow</b><br><br>
        Walka Chowancow jest bardzo latwa droga aby zdobyc nieco mithrilu. Im wyzsza Sila oraz Obrona twojego Chowanca, tym wieksza szansa na
        zwyciestwo. Abys mogl toczyc walke, jeden z twoich Chowancow musi byc Aktywny.
    {/if}
    {if $Step != ""}
        <br><br>... <a href=core.php?view=help>wroc</a>.
    {/if}
{/if}

{if $View != ""}
    <br><br>... <a href=core.php>Polana Chowancow</a>.
{/if}


