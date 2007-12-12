{if $Mill == ""}
    Witaj w tartaku. Tutaj mozesz wyrabiac luki oraz strzaly. Aby moc je wykonywac musisz najpierw posiadac plany odpowiedniej rzeczy oraz
    odpowiednia ilosc surowcow (w przypadku strzal musisz dodatkowo posiadac groty).<br><br>
    <ul>
    <li><a href="lumbermill.php?mill=plany">Kup plany przedmiotu</a></li>
    <li><a href="lumbermill.php?mill=mill">Idz do tartaku</a></li>
    </ul>
{/if}

{if $Mill == "plany"}
    Witaj w sklepie w tartaku. Tutaj mozesz kupic plany przedmiotow, ktore chcesz wykonywac. Aby kupic dany plan, musisz miec przy sobie 
    odpowiednia ilosc sztuk zlota.<br>Oto lista dostepnych planow:
    <table>
    <tr>
    <td width="100"><b><u>Nazwa</td>
    <td width="50"><b><u>Cena</td>
    <td><b><u>Poziom</td>
    <td><b><u>Opcje</td>
    </tr>
    {section name=mill loop=$Name}
        <tr>
        <td>{$Name[mill]}</td>
        <td>{$Cost[mill]}</td>
        <td>{$Level[mill]}</td>
        <td>- <a href="lumbermill.php?mill=plany&buy={$Planid[mill]}">Kup</a></td>
        </tr>
    {/section}
    </table>
    {if $Buy != ""}
        Zaplaciles <b>{$Cost1}</b> sztuk zlota, i kupiles za to nowy plan przedmiotu: <b>{$Name1}</b>.
    {/if}
{/if}

{if $Mill == "mill"}
    {if $Make == "" && $Continue == ""}
        Tutaj mozesz wykonywac przedmioty co do ktorych masz plany. Aby wykonac przedmiot, musisz posiadac rowniez odpowiednia ilosc surowcow 
        (oraz w przypadku strzal rowniez grotow). Kazda proba kosztuje ciebie tyle energii jaki jest poziom przedmiotu. Nawet za nieudana probe
        dostajesz 0,01 do umiejetnosci.
        {if $Maked == ""}
             Oto lista przedmiotow, ktore mozesz wykonywac. Jezeli nie masz tyle energii aby wykonac ow przedmiot, mozesz po prostu wykonywac go po 
             kawalku:
             <table>
             <tr>
             <td width="100"><b><u>Nazwa</td>
             <td width="50"><b><u>Poziom</td>
             <td><b><u>Drewna</td></tr>
             {section name=mill1 loop=$Name}
                 <tr>
                 <td><a href="lumbermill.php?mill=mill&dalej={$Planid[mill1]}">{$Name[mill1]}</a></td>
                 <td>{$Level[mill1]}</td>
                 <td>{$Lumber[mill1]}</td>
                 </tr>
             {/section}
             </table>
        {/if}
        {if $Maked == "1"}
            Oto przedmiot jaki obecnie wykonujesz:
            <table>
            <tr>
            <td width="100"><b><u>Nazwa</u></b></td>
            <td width="50"><b><u>Wykonany(w %)</u></b></td>
            <td width="50"><b><u>Potrzebnej energii</u></b></td>
            </tr>
            <tr>
            <td><a href="lumbermill.php?mill=mill&ko={$Planid}">{$Name}</a></td>
            <td>{$Percent}</td>
            <td>{$Need}</td>
            </tr>
            </table>
        {/if}
        {if $Cont != ""}
            <form method="post" action="lumbermill.php?mill=mill&konty={$Id}">
            Przeznacz na wykonanie <b>{$Name}</b> <input type="text" name="razy"> energii.
            <input type="submit" value="Wykonaj"></form>
        {/if}
        {if $Next != ""}
            <form method="post" action="lumbermill.php?mill=mill&rob={$Id}">
            Przeznacz na wykonanie <b>{$Name}</b> <input type="text" name="razy"> energii.<br>
            {if $Type == "R"}
                Wybierz rodzaj grotow: <select name="groty">
                {section name=mill2 loop=$Name1}
                    <option value="{$Itemid[mill2]}">{$Name1[mill2]} (+{$Power[mill2]}) ({$Amount[mill2]} sztuk)</option>
                {/section}
                </select><br>
            {/if}
            <input type=submit value="Wykonaj"></form>
        {/if}
    {/if}
    {if $Continue != "" || $Make != ""}
        {$Message}
    {/if}
{/if}

{if $Mill != ""}
    <br><br><a href="lumbermill.php">(wroc)</a>
{/if}

