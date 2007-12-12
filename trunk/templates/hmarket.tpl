{if $View == "" && $Remowe == "" && $Buy == ""}
    Tutaj jest rynek z ziolami. Masz pare opcji.<br>
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
    Szukaj ofert na rynku lub <a href="hmarket.php">wroc</a>. Jezeli nie znasz dokladnej nazwy ziola, uzyj znaku * zamiast liter.<br><br>
    <table><form method="post" action="hmarket.php?view=market&limit=0&lista=nazwa">
    Ziolo: <input type="text" name="szukany">
    <tr><td colspan="2" align="center"><input type="submit" value="Szukaj"></td></tr>
    </form></table>
{/if}

{if $View == "market"}
    Zobacz ceny ziol lub <a href=hmarket.php>wroc</a>.<br><br>
    <table>
    <tr>
    <td width="100"><a href="hmarket.php?view=market&lista=nazwa&limit=0"><b><u>Ziolo</u></b></td>
    <td width="100"><a href="hmarket.php?view=market&lista=ilosc&limit=0"><b><u>Ilosc</u></b></td>
    <td width="100"><a href="hmarket.php?view=market&lista=cost&limit=0"><b><u>Koszt</u></b></td>
    <td width="100"><a href="hmarket.php?view=market&lista=seller&limit=0"><b><u>Sprzedajacy</u></b></td>
    <td width="100"><b><u>Opcje</td>
    </tr>
    {section name=herb loop=$Name}
        <tr>
        <td>{$Name[herb]}</td>
        <td>{$Amount[herb]}</td>
        <td>{$Cost[herb]}</td>
        <td><a href="view.php?view={$Seller[herb]}">{$User[herb]}</a></td>
        {$Action[herb]}
    {/section}
    </table>
    {$Previous}{$Next}
{/if}

{if $View == "add"}
    Dodaj oferte na rynku lub <a href="hmarket.php">wroc</a>.<br><br>
    <table><form method="post" action="hmarket.php?view=add&step=add">
    <tr><td>Ziolo:</td><td><select name="mineral">
    <option value="Illani">Illani</option>
    <option value="Illanias">Illanias</option>
    <option value="Nutari">Nutari</option>
    <option value="Dynallca">Dynallca</option>
    <tr><td>Ilosc ziol:</td><td><input type="text" name="ilosc"></td></tr>
    <tr><td>Cena za sztuke:</td><td><input type="text" name="cost"></td></tr>
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
	<td><form method="post" action="hmarket.php?view=market&limit=0&lista=id">
	    <input type="hidden" name="szukany" value="{$Name[all]}">
	    <input type="submit" value="Pokaz"></form>
	</td>
	</tr>
    {/section}
    </table>
{/if}

{if $Buy != ""}
    Zakup mineraly lub <a href="hmarket.php">wroc</a>.<br /><br />
    <b>Mineral:</b> {$Name} <br />
    <b>Ilosc w ofercie:</b> {$Amount1} <br />
    <b>Cena za sztuke:</b> {$Cost} <br />
    <b>Sprzedajacy:</b> <a href="view.php?view={$Sid}">{$Seller}</a> <br /><br />
    <table><form method="post" action="hmarket.php?buy={$Itemid}&step=buy">
    <tr><td>Ilosc:</td><td><input type="text" name="amount"></td></tr>
    <tr><td colspan="2" align="center"><input type="submit" value="Kup"></td></tr>
    </form></table>
{/if}

{$Message}
