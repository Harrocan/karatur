<center><img src="luk.jpg"/></center><br />
{if $Buy == 0}
    Witaj u fleczera. Mozesz tutaj kupic luki oraz strzaly.<br><br>
    <table>
    <tr><td width="100"><b><u>Nazwa</td>
    <td width="100"><b><u>Efekt</td>
    <td width="50"><b><u>Szyb</u></b></td>
    <td width="50"><b><u>Wt.</td>
    <td width=50><b><u>Cena</td>
    <td><b><u>Wymagany poziom</td>
    <td><b><u>Opcje</td></tr>
    {section name=item loop=$Level}
        <tr>
        <td>{$Name[item]}</td>
        <td>+{$Power[item]} Atak</td>
        <td>+{$Speed[item]}%</td>
        <td>{$Durability[item]}</td>
        <td>{$Cost[item]}</td>
        <td>{$Level[item]}</td>
        <td>- <a href="bows.php?buy={$Itemid[item]}">Kup</a>{if $Crime > "0"}<br><a href="bows.php?steal={$Itemid[item]}">Kradziez</a>{/if}</td>
        </tr>
    {/section}
    </table>
{/if}
{if $Buy > 0}
    Zaplaciles <b>{$Cost}</b> sztuk zlota, ale teraz masz nowy <b>{$Name} z +{$Power}</b> do Obrazen.
{/if}


