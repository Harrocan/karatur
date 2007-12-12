<center><img src="domy.jpg"/></center><br />
{if $Action == ""}
    Jest to dzielnica w ktorej znajduja sie domy graczy. Mozesz tutaj kupic wlasny dom a nastepnie rozbudowywac go.<br /><br />
    {if $Houseid == ""}
        - <a href="house.php?action=land">Kup ziemie</a><br>
        - <a href="house.php?action=list">Zobacz liste domow</a><br>
	- <a href="house.php?action=rent">Zobacz liste domow na sprzedaz</a><br />
    {/if}
    {if $Houseid > "0"}
        - <a href="house.php?action=my">Twoj dom</a><br>
        - <a href="house.php?action=build">Warsztat budowlany</a><br>
        - <a href="house.php?action=land">Kup ziemie</a><br>
        - <a href="house.php?action=list">Zobacz liste domow</a><br>
	- <a href="house.php?action=rent">Zobacz liste domow na sprzedaz</a><br />
    {/if}  
{/if}

{if $Action == "rent"}
    <table>
    <tr>
    <td><b><u>Numer domu</u></b></td>
    <td><b><u>Sprzedajacy</u></b></td>
    <td><b><u>Nazwa domu</u></b></td>
    <td><b><u>Rozmiar</u></b></td>
    <td><b><u>Typ</u></b></td>
    <td><b><u>Cena</u></b></td>
    <td><b><u>Opcje</u></b></td>
    </tr>
    {section name=house loop=$Housesname}
        <tr>
        <td>{$Housesid[house]}</td>
        <td><a href="view.php?view={$Housesseller[house]}">{$Housesseller[house]}</a></td>
        <td>{$Housesname[house]}</td>
        <td>{$Housesbuild[house]}</td>
        <td>{$Housestype[house]}</td>
	<td>{$Housescost[house]}</td>
	<td>{$Houseslink[house]}</td>
        </tr>
    {/section}
    </table> <a href="house.php">Wroc</a>
    {$Message}
{/if}

{if $Action == "land"}
    Witaj w  sklepie z parcelami. Tutaj mozesz kupic ziemie pod swoj dom. Jezeli jeszcze nie posiadasz ziemi, musisz zaplacic 20 sztuk
    mithrilu. Aby moc w przyszlosci rozbudowywac dom, rowniez potrzebujesz nowych terenow pod niego. Jednak wtedy owe tereny kosztuja 1000
    sztuk zlota razy ilosc posiadanych.
    <ul>
    <li><a href="house.php?action=land&step=buy">Kup 1 obszar za {$Cost}</a></li>
    <li><a href="house.php">Wroc</a></li>
    </ul>
{/if}

{if $Action == "build"}
    Witaj w warsztacie budowlanym. Mozesz tutaj rozbudowywac swoj dom oraz upiekszac go. Kazda rozbudowa kosztuje oprocz zlota rowniez
    specjalne punkty budownlanych. Owe punkty przychodza po 2 na reset. Obecnie posiadasz <b>{$Points}</b> punktow budowlanych. Kazda rozbudowa domu
    obniza jego jakosc o 10 punktow. Oto co mozesz zrobic:<br><br><br>
    {$Buildhouse}
    {$Buildbed}
    {$Buildwardrobe}
    {$Upgrade}
    {if $Step == "new"}
        <form method="post" action="house.php?action=build&step=new&step2=make">
        Nazwa domu <input type=text name=name><br>
        <input type=submit value="Buduj"></form><br>
    {/if}
    {if $Step == "upgrade"}
        Tutaj mozesz upiekszac swoj dom. Kazde podniesienie jego wartosci kosztuje 1000 zl oraz 1 punkt budowlany.<br>
        <form method="post" action="house.php?action=build&step=upgrade&step2=make">
        Przeznacz na podniesienie wartosci domu <input type=text name=points size=5> punktow budowlanych<br>
        <input type=submit value="Pracuj"></form><br>
    {/if}
{/if}

{if $Action == "list"}
    <table>
    <tr>
    <td><b><u>Numer domu</u></b></td>
    <td><b><u>Wlasciciel</u></b></td>
    <td><b><u>Wspollokator</u></b></td>
    <td><b><u>Nazwa domu</u></b></td>
    <td><b><u>Rozmiar</u></b></td>
    <td><b><u>Typ</u></b></td>
    </tr>
    {section name=house loop=$Housesname}
        <tr>
        <td>{$Housesid[house]}</td>
        <td><a href="view.php?view={$Housesowner[house]}">{$Housesowner[house]}</a></td>
	<td>{$Locator[house]}</td>
        <td>{$Housesname[house]}</td>
        <td>{$Housesbuild[house]}</td>
        <td>{$Housestype[house]}</td>
        </tr>
    {/section}
    </table> <a href="house.php">Wroc</a>
{/if}

{if $Action == "my"}
    {if $Step == ""}
        Witaj w swoim domu. Mozesz tutaj przechowywac przedmioty - jedno pomieszczenie przeznaczone na przechowalnie pomiesci 100 przedmiotow.
        Jezeli natomiast posiadasz sypialnie, mozesz isc spac dzieki czemu jezeli opuscisz Vallheru nikt nie bedzie mogl ciebie zaatakowac. Dodatkowo mozesz probowac
        odpoczac w sypialni i nieco zregenerowac nadwatlone sily.<br><br>
        Nazwa domu: {$Name} {if $Owner == $Id} [<a href="house.php?action=my&step=name">Zmien nazwe</a>] {/if}<br />
	Wlasciciel: <a href="view.php?view={$Owner}">{$Owner}</a><br />
        Rozmiar domu: {$Build}<br>
        Ilosc ziemi: {$Size}<br>
        Wolnych pokoi: {$Unused}<br>
        Wartosc domu: {$Value} {$Housename}<br>
	Wspollokator: {$Locator}<br />
        Sypialnia: {$Bedroom}<br>
        Ilosc szaf: {$Wardrobe}<br>
        Przedmiotow w domu: {$Items}<br><br>
        {$Bedroomlink}
        {$Wardrobelink}
	{$Locatorlink}
	{$Sellhouse}
        (<a href="house.php">Wroc</a>)
    {/if}
    {if $Step == "sell"}
        {if $Step2 == ""}
	    Tutaj mozesz sprzedac swoj dom. Jednak zanim to zrobisz, zabierz wszystkie przedmioty z domu, inaczej przepadna. Po wystawieniu domu na sprzedaz nie mozesz juz wiecej z niego korzystac ani tez cofnac oferty<br />
            <form method="post" action="house.php?action=my&step=sell&step2=sell">
	    <input type="submit" value="Wystaw"> dom na sprzedaz za <input type="text" name="cost"> sztuk zlota
	    </form>
	{/if}
	(<a href="house.php?action=my">Wroc</a>)<br />
	{$Message}
    {/if}
    {if $Step == "locator"}
        {if $Step2 == ""}
            <form method="post" action="house.php?action=my&step=locator&step2=change">
	    <select name="loc"><option value="add">Dodaj</option>
	    <option value="delete">Usun</option></select> drugiego mieszkanca domu<br />
	    ID: <input type="text" name="lid" size="5" value="{$Locid}"><br />
	    <input type="submit" value="Wykonaj"></form><br />
	{/if}
	(<a href="house.php?action=my">Wroc</a>)<br />
	{$Message}
    {/if}
    {if $Step == "name"}
        <form method="post" action="house.php?action=my&step=name&step2=change">
        <input type="submit" value="Zmien"> nazwe domu na: <input type="text" name="name">
        </form><br>
        (<a href="house.php?action=my">Wroc</a>)
    {/if}
    {if $Step == "bedroom"}
        W sypialni mozesz probowac odpoczac aby zregenerowac nadwatlone sily. Szansa na to czy ci sie uda, zalezy od szczescia, ale to ile odzyskasz
        energii, zdrowia, czy tez punktow magii zalezy od wartosci twojego domu. Mozesz odpoczywac tylko raz na reset. Oprocz tego jezeli
        wylogujesz sie z gry w tym miejscu, twoja postac pojdzie spac i nikt nie bedzie mogl ciebie zaatakowac. Co chcesz robic?<br>
        - <a href="house.php?action=my&step=bedroom&step2=rest">Chce nieco odpoczac</a><br>
        - <a href="logout.php?rest=Y&did={$Id}">Isc spac</a><br>
        (<a href="house.php">Wroc</a>)
    {/if}
    {if $Step == "wardrobe"}
        W szafach w domu mozesz przechowywac przedmioty. W jednej szafie miesci sie 100 przedmiotow. Obecnie posiadasz <b>{$Wardrobe} szaf</b>
        oraz <b>{$Amount} przedmiotow</b> w nich.<br><br>
        - <a href="house.php?action=my&step=wardrobe&step2=add">Schowaj przedmiot w szafie</a><br>
        - <a href="house.php?action=my&step=wardrobe&step2=list">Lista przedmiotow w domu</a><br>
       (<a href="house.php?action=my">Wroc</a>)<br><br>
       {if $Step2 == "list"}
           <table>
           <tr>
           <td width="100"><b><u>Nazwa</u></b></td>
           <td width="100"><b><u>Sila</u></b></td>
           <td width="100"><b><u>Wytrzymalosc</u></b></td>
           <td width="100"><b><u>Premia do zrecznosci</u></b></td>
           <td width="100"><b><u>Premia do szybkosci</u></b></td>
           <td width="50"><b><u>Ilosc</u></b></td>
           <td width="100"><b><u>Opcje</u></b></td>
           </tr>
           {section name=house1 loop=$Itemname}
               <tr>
               <td>{$Itemname[house1]}</td>
               <td align="center">{$Itempower[house1]}</td>
               <td align="center">{$Itemdur[house1]}/{$Itemmaxdur[house1]}</td>
               <td align="center">{$Itemagility[house1]}</td>
               <td align="center">{$Itemspeed[house1]}</td>
               <td align="center">{$Itemamount[house1]}</td>
               <td>- <a href="house.php?action=my&step=wardrobe&take={$Itemid[house1]}">Wez</a></td>
               </tr>
           {/section}
           </table>
        {/if}
        {if $Take != ""}
            {if $Step3 == ""}
                <form method="post" action="house.php?action=my&step=wardrobe&take={$Id}&step3=add">
                <input type="submit" value="Wez"> z domu <input type="text" name="amount" value="{$Amount}" size="5"> sztuk(i) <b>{$Name}</b><br>
                </form>
            {/if}
        {/if}
        {if $Step2 == "add"}
            <table><form method="post" action="house.php?action=my&step=wardrobe&step2=add&step3=add">
            Przedmiot: <select name="przedmiot">
            {section name=house2 loop=$Itemname1}
                <option value="{$Itemid1[house2]}">(ilosc: {$Itemamount1[house2]}) {$Itemname1[house2]}</option>
            {/section}
            </select> sztuk <input type="text" name="amount" size="5"></td></tr>
            <tr><td colspan="2" align="center"><input type="submit" value="Schowaj"></td></tr>
            </form></table>
        {/if}
    {/if}
{/if}

