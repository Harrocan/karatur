<center><img src="alchemik1.gif"/></center><br />
{if $Alchemist == ''}
    Witaj w pracowni alchemika. Tutaj mozesz wyrabiac rozne mikstury. Aby moc je wykonywac musisz najpierw posiadac przepis na odpowiednia
    miksture oraz odpowiednia ilosc ziol.<br><br>
    <ul>
    <li><a href="alchemik.php?alchemik=przepisy">Kup przepis na miksture</a></li>
    <li><a href="alchemik.php?alchemik=pracownia">Idz do pracowni</a></li>
    </ul>
{/if}

{if $Alchemist == "przepisy"}
    Witaj w sklepie dla alchemikow. Tutaj mozesz kupic przepisy mikstur, ktore chcesz wykonywac. Aby kupic dany przepis, musisz miec przy
    sobie odpowiednia ilosc sztuk zlota. Oto lista dostepnych przepisow:
    <table>
    <tr>
    <td width="100"><b><u>Nazwa</td><td width="50"><b><u>Cena</td><td><b><u>Poziom</td><td><b><u>Opcje</td>
    </tr>
    {section name=alchemy loop=$Name}
        <tr>
        <td>{$Name[alchemy]}</td>
        <td>{$Cost[alchemy]}</td>
        <td>{$Level[alchemy]}</td>
        <td>- <A href="alchemik.php?alchemik=przepisy&buy={$Id[alchemy]}">Kup</a></td>
        </tr>
    {/section}
    </table>
    {if $Buy > 0}
        Zaplaciles <b>{$Cost1}</b> sztuk zlota, i kupiles za to nowy przepis na: <b>{$Name1}</b>.<br>
    {/if}
{/if}

{if $Alchemist == "pracownia"}
    {if $Make == 0}
        Tutaj mozesz wykonywac mikstury co do ktorych masz przepisy. Aby wykonac miksture, musisz posiadac rowniez odpowiednia ilosc ziol.
        Kazda proba kosztuje ciebie 1 punkt energii. Nawet za nieudana probe dostajesz 0,01 do umiejetnosci.<br>
        Oto lista mikstur, ktore mozesz wykonywac:
        <table>
        <tr>
        <td width="100"><b><u>Nazwa</td>
        <td width="50"><b><u>Poziom</td>
        <td><b><u>Illani</td>
        <td><b><u>Illanias</td>
        <td><b><u>Nutari</b></u></td>
        <td><b><u>Dynallca</b></u></td>
        </tr>
        {section name=number loop=$Name}
            <tr>
            <td><a href="alchemik.php?alchemik=pracownia&dalej={$Id[number]}">{$Name[number]}</a></td>
            <td>{$Level[number]}</td>
            <td>{$Illani[number]}</td>
            <td>{$Illanias[number]}</td>
            <td>{$Nutari[number]}</td>
            <td>{$Dynallca[number]}</td>
            </tr>
        {/section}
        </table>
    {/if}
    {if $Next != 0}
        <form method="post" action="alchemik.php?alchemik=pracownia&rob={$Id1}">
        Sprobuj wykonac <b>{$Name1}</b> <input type="text" name="razy"> razy.
        <input type=submit value="Wykonaj"></form>
    {/if}
    {if $Make != 0}
        Wykonales <b>{$Name}</b> <b>{$Amount}</b> razy. Zdobywasz <b>{$Exp}</b> PD oraz <b>{$Ability}</b> poziomu w umiejetnosci Alchemia.
        <br>
    {/if}
{/if}

{if $Alchemist != ''}
<br><br><a href="alchemik.php">(wroc)</a>
{/if}

