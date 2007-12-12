{if $View == "" && $Remowe == "" && $Buy == ""}
    Tutaj jest rynek z przedmiotami. Masz pare opcji.<br>
    <ul>
    <li><a href="{$SCRIPT_NAME}?view=market&lista=id&limit=0">Zobacz oferty</a>
    <li><a href="{$SCRIPT_NAME}?view=szukaj">Szukaj ofert</a></li>
    <li><a href="{$SCRIPT_NAME}?view=add">Dodaj oferte</a>
    <li><a href="{$SCRIPT_NAME}?view=del">Skasuj wszystkie swoje oferty</a>
    <li><a href="{$SCRIPT_NAME}?view=all">Spis wszystkich ofert na rynku</a>
    </ul>
    (<a href="market.php">Wroc na rynek</a>)
{/if}

{if $View == "szukaj"}
    Szukaj ofert na rynku lub <a href="imarket.php">wroc</a>. Uwaga! Wpisz dokladna nazwe przedmiotu jakiego poszukujesz.<br><br>
    <table><form method="post" action="imarket.php?view=market&limit=0&lista=name">
    Przedmiot: <input type="text" name="szukany">
    <tr><td colspan="2" align="center"><input type="submit" value="Szukaj"></td></tr>
    </form></table>
{/if}

{if $View == "market"}
    Zobacz oferty lub <a href="imarket.php">wroc</a>.<br><br>
	<center><b>UWAGA!!!</b><br>Aby kupiæ przedmiot nale¿y kliknac na jego na nazwie, w³asne przedmioty sa podswietlone na niebiesko.</center><br>
    <table>
    <tr>
    <td width="100"><a href="imarket.php?view=market&lista=name&limit=0"><b><u>Nazwa</u></b></a></td>
    <td width="100"><a href="imarket.php?view=market&lista=power&limit=0"><b><u>Sila</u></b></a></td>
    <td width="100"><a href="imarket.php?view=market&lista=wt&limit=0"><b><u>Wytrz</u></b></a></td>
    <td width="100"><a href="imarket.php?view=market&lista=szyb&limit=0"><b><u>Szyb</u></b></a></td>
    <td width="100"><a href="imarket.php?view=market&lista=zr&limit=0"><b><u>Zrec</u></b></a></td>
    <td width="50"><a href="imarket.php?view=market&lista=minlev&limit=0"><b><u>Pozi</u></b></a></td>
    <td width="50"><a href="imarket.php?view=market&lista=amount&limit=0"><b><u>Ile</u></b></a></td>
    <td width="100"><a href="imarket.php?view=market&lista=cost&limit=0"><b><u>Koszt</u></b></a></td>
    <td width="50"><a href="imarket.php?view=market&lista=owner&limit=0"><b><u>Oferta</u></b></a></td>
    </tr>
    {section name=item loop=$Name}
        <tr>
        {$Action[item][0]}{popup text='Klikajac na przedmiot kupujesz go lub wycofujesz ze sprzedarzy jezeli nalezy on do Ciebie' fgcolor='black' bgcolor='black' textcolor='white' border=1 vauto=TRUE}{$Action[item][1]}{$Name[item]}{$Action[item][2]}
        <td align="center">{$Power[item]}</td>
        <td align="center">{$Durability[item]}/{$Maxdur[item]}</td>
        <td align="center">{$Speed[item]}</td>
        <td align="center">{$Agility[item]}</td>
	<td align="center">{$Minlev[item]}</td>
        <td align="center">{$Amount[item]}</td>
        <td>{$Cost[item]}</td>
        <td><a href="view.php?view={$Owner[item]}" >{$Seller[item]}</a></td>
        </tr>
    {/section}
    </table>
    {$Previous}{$Next}
{/if}

{if $View == "add"}
    Dodaj oferte na rynku lub <a href="imarket.php">wroc</a>.<br><br>
    <table><form method="post" action="imarket.php?view=add&step=add">
    Przedmiot: <select name="przedmiot">
    {section name=item1 loop=$Name}
        <option value="{$Itemid[item1]}">{$Name[item1]}(ilosc: {$Amount[item1]})</option>
    {/section}
    <tr><td>Ilosc:</td><td><input type="text" name="amount"></td></tr>
    <tr><td>Cena za sztuke:</td><td><input type="text" name="cost"></td></tr>
    <tr><td colspan="2" align="center"><input type="submit" value="Dodaj"></td></tr>
    </form></table>
{/if}

{if $Buy != ""}
    Zakup przedmiot lub <a href="imarket.php">wroc</a>.<br /><br />
    <b>Przedmiot:</b> {$Name} <br />
    <b>Sila:</b> {$Power} <br />
    {if $Agi != "0"}
        <b>Premia do zrecznosci:</b> {$Agi} <br />
    {/if}
    {if $Speed != "0"}
        <b>Premia do szybkosci:</b> {$Speed} <br />
    {/if}
    {if $Type != "R" && $Type != "S" && $Type != "Z" && $Type != "G"}
        <b>Wytrzymalosc:</b> {$Dur}/{$MaxDur} <br />
    {/if}
    {if $Type == "R"}
        <b>Liczba strzal:</b> {$Dur} <br />
    {/if}
    {if $Type == "G"}
        <b>Liczba grotow:</b> {$Dur} <br />
    {/if}
    <b>Ilosc w ofercie:</b> {$Amount1} <br />
    <b>Cena za sztuke:</b> {$Cost} <br />
    <b>Sprzedajacy:</b> <a href="view.php?view={$Sid}">{$Seller}</a> <br /><br />
    <table><form method="post" action="imarket.php?buy={$Itemid}&step=buy">
    <tr><td>Ilosc:</td><td><input type="text" name="amount"></td></tr>
    <tr><td colspan="2" align="center"><input type="submit" value="Kup"></td></tr>
    </form></table>
{/if}

{if $View == "all"}
    Tutaj masz spis wszystkich ofert jakie sa na rynku.<br />
    <table>
    <tr>
    <td><b><u>Nazwa</u></b></td><td><b><u>Ofert</u></b></td><td align="center"><b><u>Akcja</u></b></td>
    </tr>
    {section name=all loop=$Name}
        <tr>
        <td>{$Name[all]}</td>
	<td align="center">{$Amount[all]}</td>
	<td><form method="post" action="imarket.php?view=market&limit=0&lista=id">
	    <input type="hidden" name="szukany" value="{$Name[all]}">
	    <input type="submit" value="Pokaz"></form>
	</td>
	</tr>
    {/section}
    </table>
{/if}

{$Message}
