{if $View == "" && $Delete == "" && $Buy == ""}
    Tutaj jest rynek z minera³ami. Masz pare opcji.<br>
    <ul>
     <li><a href="{$SCRIPT_NAME}?view=market&lista=id&limit=0">Zobacz oferty</a></li>
     <li><a href="{$SCRIPT_NAME}?view=all">Spis wszystkich ofert na rynku</a></li>
     <li><a href="{$SCRIPT_NAME}?view=szukaj">Szukaj ofert</a></li>
     <li><a href="{$SCRIPT_NAME}?view=add">Dodaj ofertê</a></li>
     <li><a href="{$SCRIPT_NAME}?view=del">Skasuj wszystkie swoje oferty</a></li>
     <li><a href="{$SCRIPT_NAME}?view=private">Spis Twoich ofert na rynku</a></li>
    </ul>
{/if}

{if $View == "szukaj"}
    Szukaj ofert na rynku lub <a href="pmarket.php">wróæ</a>.<br>Je¿eli nie znasz dok³adnej nazwy minera³u, u¿yj znaku * zamiast liter.<br><br>
    <table><form method="post" action="pmarket.php?view=market&limit=0&lista=nazwa">
    Minera³: <input type="text" name="szukany">
    <tr><td colspan="2" align="center"><input type="submit" value="Szukaj"></td></tr>
    </form></table>
    <br>
    (Nie u¿ywaj polskich liter w nazwach minera³ów.)
{/if}

{if $View == "market"}
    Zobacz ceny minera³ów lub <a href="pmarket.php">wróæ</a>.<br><br>
    <table>
    <tr>
    <td width="100"><a href="pmarket.php?view=market&lista=nazwa&limit=0"><b><u>Minera³</u></b></td>
    <td width="100"><a href="pmarket.php?view=market&lista=ilosc&limit=0"><b><u>Ilo¶æ</u></b></td>
    <td width="100"><a href="pmarket.php?view=market&lista=cost&limit=0"><b><u>Koszt</u></b></td>
    <td width="100"><a href="pmarket.php?view=market&lista=seller&limit=0"><b><u>Sprzedaj±cy</u></b></td>
    <td width="100"><b><u>Opcje</td>
    </tr>
    {section name=pmarket loop=$Name}
        <tr>
        <td>{$Name[pmarket]}</td>
        <td>{$Amount[pmarket]}</td>
        <td>{$Cost[pmarket]}</td>
        <td><a href="view.php?view={$Seller[pmarket]}">{$User[pmarket]}</a></td>
        {$Link[pmarket]}
    {/section}
    </table>
    {$Previous}{$Next}
{/if}

{if $View == "add"}
    Dodaj ofertê na rynku lub <a href="pmarket.php">wróæ</a>.<br><br>
    <table><form method="post" action="pmarket.php?view=add&step=add">
    <tr><td>Minera³:</td><td><select name="mineral">
    <option value="mithril">Mithril</option>
    <option value="miedz">Mied¼</option>
    <option value="zelazo">¯elazo</option>
    <option value="wegiel">Wêgiel</option>
    <option value="adamantyt">Adamantyt</option>
    <option value="meteoryt">Meteor</option>
    <option value="krysztal">Kryszta³</option>
    <option value="drewno">Drewno</option></select></td></tr>
    <tr><td>Ilo¶æ minera³u:</td><td><input type="text" name="ilosc"></td></tr>
    <tr><td>Cena za sztukê:</td><td><input type="text" name="cost"></td></tr>
    <tr><td colspan="2" align="center"><input type="submit" value="Dodaj"></td></tr>
    </form></table>
{/if}

{if $View == "all"}
    Tutaj masz spis wszystkich ofert jakie s± na rynku.<br />
    <table>
    <tr>
    <td><b><u>Nazwa</u></b></td><td><b><u>Ofert</u></b></td><td align="center"><b><u>Akcja</u></b></td>
    </tr>
    {section name=all loop=$Name}
        <tr>
        <td>{$Name[all]}</td>
	<td align="center">{$Amount[all]}</td>
	<td><form method="post" action="pmarket.php?view=market&limit=0&lista=id">
	    <input type="hidden" name="szukany" value="{$Name[all]}">
	    <input type="submit" value="Poka¿"></form>
	</td>
	</tr>
    {/section}
    </table>
{/if}





{if $View == "private"}
    Oto lista Twoich towarów wystawionych na sprzeda¿ :
    <table>
    <tr>
    <td width="100"><a href="pmarket.php?view=market&lista=nazwa&limit=0"><b><u>Minera³</u></b></td>
    <td width="100"><a href="pmarket.php?view=market&lista=ilosc&limit=0"><b><u>Ilo¶æ</u></b></td>
    <td width="100"><a href="pmarket.php?view=market&lista=cost&limit=0"><b><u>Koszt</u></b></td>
    <td width="100"><b><u>Opcje</td>
    </tr>
    {section name=pmarket loop=$Name}
        <tr>
        <td>{$Name[pmarket]}</td>
        <td>{$Amount[pmarket]}</td>
        <td>{$Cost[pmarket]}</td>
        {$Link[pmarket]}
    {/section}
    </table>
    {$Previous}{$Next}
    (<a href="pmarket.php">wróæ</a>)<br><br>
{/if}




{if $Buy != ""}
    Zakup minera³y lub <a href="pmarket.php">wróæ</a>.<br /><br />
    <b>Minera³:</b> {$Name} <br />
    <b>Ilo¶æ w ofercie:</b> {$Amount1} <br />
    <b>Cena za sztukê:</b> {$Cost} <br />
    <b>Sprzedaj±cy:</b> <a href="view.php?view={$Seller}">{$Seller}</a> <br /><br />
    <table><form method="post" action="pmarket.php?buy={$Itemid}&step=buy">
    <tr><td>Ilo¶æ:</td><td><input type="text" name="amount"></td></tr>
    <tr><td colspan="2" align="center"><input type="submit" value="Kup"></td></tr>
    </form></table>
{/if}

{$Message}
