{if $View == "" && $Delete == "" && $Buy == ""}
    Tutaj jest rynek z miksturami. Masz pare opcji.<br>
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
    Szukaj ofert na rynku lub <a href="mmarket.php">wroc</a>. Uwaga! Wpisz nazwe miktury ktora poszukujesz.<br><br>
    <table><form method="post" action="mmarket.php?view=market&limit=0&lista=nazwa">
    Mikstura z <input type="text" name="szukany">
    <tr><td colspan="2" align="center"><input type="submit" value="Szukaj"></td></tr>
    </form></table>
{/if}

{if $View == "market"}
    Zobacz oferty lub <a href=mmarket.php>wroc</a>.<br><br>
    <table>
    <tr>
    <td width="150"><a href="mmarket.php?view=market&lista=nazwa&limit=0"><b><u>Nazwa</u></b></a></td>
    <td width="100" align="center"><a href="mmarket.php?view=market&lista=efekt&limit=0"><b><u>Efekt</u></b></a></td>
    <td width="50"><a href="mmarket.php?view=market&lista=amount&limit=0"><b><u>Ilosc</u></b></a></td>
    <td width="50"><a href="mmarket.php?view=market&lista=cena&limit=0"><b><u>Koszt</u></b></a></td>
    <td width="100"><a href="mmarket.php?view=market&lista=gracz&limit=0"><b><u>Sprzedajacy</u></b></a></td>
    <td width="100"><b><u>Opcje</td>
    </tr>
    {section name=mmarket loop=$Item}
        {$Item[mmarket]}
	{$Link[mmarket]}
    {/section}
    </table>
    {$Previous}{$Next}
{/if}

{if $View == "add"}
    Dodaj oferte na rynku lub <a href="mmarket.php">wroc</a>.<br><br>
    <table><form method="post" action="mmarket.php?view=add&step=add">
    Mikstura: <select name="przedmiot">
    {section name=mmarket1 loop=$Name}
        <option value="{$Itemid[mmarket1]}">{$Name[mmarket1]} (ilosc: {$Amount[mmarket1]})</option>
    {/section}
    <tr><td>Ilosc:</td><td><input type="text" name="amount"></td></tr>
    <tr><td>Cena za jedna miksture:</td><td><input type="text" name="cost"></td></tr>
    <tr><td colspan="2" align="center"><input type="submit" value="Dodaj"></td></tr>
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
	<td><form method="post" action="mmarket.php?view=market&limit=0&lista=id">
	    <input type="hidden" name="szukany" value="{$Name[all]}">
	    <input type="submit" value="Pokaz"></form>
	</td>
	</tr>
    {/section}
    </table>
{/if}

{if $Buy != ""}
    Zakup miksture lub <a href="mmarket.php">wroc</a>.<br /><br />
    <b>Mikstura:</b> {$Name} <br />
    {if $Type == "M" || $Type == "P"}
        <b>Moc:</b> {$Power} %<br />
    {/if}
    <b>Ilosc w ofercie:</b> {$Amount1} <br />
    <b>Cena za sztuke:</b> {$Cost} <br />
    <b>Sprzedajacy:</b> <a href="view.php?view={$Sid}">{$Seller}</a> <br /><br />
    <table><form method="post" action="mmarket.php?buy={$Itemid}&step=buy">
    <tr><td>Ilosc:</td><td><input type="text" name="amount"></td></tr>
    <tr><td colspan="2" align="center"><input type="submit" value="Kup"></td></tr>
    </form></table>
{/if}

{$Message}
