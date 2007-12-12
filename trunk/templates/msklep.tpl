<center><img src="alchemik.jpg"/></center><br />
{if $Buy == ""}
    Witaj w sklepie alchemika, mozesz tutaj kupic rozne przydatne mikstury. Cena mikstur zalezy od twojego poziomu, twoich statystyk oraz od
    samej mikstury<br><br>
    <table>
    <tr><td width="100"><b><u>Nazwa</u></b></td>
    <td width="100"><b><u>Efekt</u></b></td>
    <td width="50"><b><u>Cena</td>
    <td width="50"><b><u>Ilosc</td><td><b><u>Opcje</td></tr>
    {section name=msklep loop=$Item}
        {$Item[msklep]}
    {/section}
    </table>
{/if}

{if $Buy != ""}
    <form method="post" action="msklep.php?buy={$Id}&step=buy">
    <input type="submit" value="Kup"> <input type="text" name="amount" value="1" size="5"> sztuk(i) {$Name}</form>
{/if}

