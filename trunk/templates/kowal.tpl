<center><img src="kowal.jpg"/></center><br />
{if $Smith == ""}
    Witaj w kuzni. Tutaj mozesz wyrabiac rozne przedmioty. Aby moc je wykonywac musisz najpierw posiadac plany odpowiedniej rzeczy oraz
    odpowiednia ilosc surowcow.<br><br>
    <ul>
    <li><a href="kowal.php?kowal=plany">Kup plany przedmiotu</a></li>
    <li><a href="kowal.php?kowal=kuznia">Idz do kuzni</a></li>
    </ul>
{/if}

{if $Smith == "plany"}
    Witaj w sklepie dla kowali. Tutaj mozesz kupic plany przedmiotow, ktore chcesz wykonywac. Aby kupic dany plan, musisz miec przy sobie
    odpowiednia ilosc sztuk zlota.<br>
    <ul>
    <li><a href="kowal.php?kowal=plany&dalej=W">Kup plany broni</a></li>
    <li><a href="kowal.php?kowal=plany&dalej=A">Kup plany zbroi</a></li>
    <li><a href="kowal.php?kowal=plany&dalej=D">Kup plany tarcz</a></li>
    <li><a href="kowal.php?kowal=plany&dalej=H">Kup plany helmu</a></li>
    <li><a href="kowal.php?kowal=plany&dalej=N">Kup plany nagolennikow</a></li>
    <li><a href="kowal.php?kowal=plany&dalej=R">Kup plany grotow strzal</a></li>
    </ul>
    {if $Next != ""}
        Oto lista dostepnych planow:
        <table>
        <tr>
        <td width="100"><b><u>Nazwa</td>
        <td width="50"><b><u>Cena</td>
        <td><b><u>Poziom</td>
        <td><b><u>Opcje</td>
        </tr>
        {section name=smith loop=$Name}
            <tr>
            <td>{$Name[smith]}</td>
            <td>{$Cost[smith]}</td>
            <td>{$Level[smith]}</td>
            <td>- <a href="kowal.php?kowal=plany&buy={$Id[smith]}">Kup</a></td>
            </tr>
        {/section}
        </table>
    {/if}
    {if $Buy != ""}
        Zaplaciles <b>{$Cost}</b> sztuk zlota, i kupiles za to nowy plan przedmiotu: <b>{$Plan}</b>.
    {/if}
{/if}

{if $Smith == "kuznia"}
    {if $Make == "" && $Continue == ""}
        Tutaj mozesz wykonywac przedmioty co do ktorych masz plany. Aby wykonac przedmiot, musisz posiadac rowniez odpowiednia ilosc surowcow.
        Kazda proba kosztuje ciebie tyle energii jaki jest poziom przedmiotu. Nawet za nieudana probe dostajesz 0,01 do umiejetnosci.
        {if !isset($Maked)}
            <ul>
            <li><a href="kowal.php?kowal=kuznia&type=W">Wykonuj bron</a></li>
            <li><a href="kowal.php?kowal=kuznia&type=A">Wykonuj zbroje</a></li>
            <li><a href="kowal.php?kowal=kuznia&type=D">Wykonuj tarcze</a></li>
            <li><a href="kowal.php?kowal=kuznia&type=H">Wykonuj helmy</a></li>
            <li><a href="kowal.php?kowal=kuznia&type=N">Wykonuj nagolenniki</a></li>
            <li><a href="kowal.php?kowal=kuznia&type=R">Wykonuj groty strzal</a></li>
            </ul>
            {if $Type != "R" && $Type != ""}
                Oto lista przedmiotow, ktore mozesz wykonywac. Jezeli nie masz tyle energii aby wykonac ow przedmiot, mozesz po prostu wykonywac go po
                kawalku:
            {/if}
            {if $Type == "R"}
                Oto lista grotow jakie mozesz wykonywac. W odroznieniu od innych przedmiotow koszt energii dotyczy nie pojedynczego grotu ale 10 sztuk.
                Oto lista posiadanych grotow strzal:
            {/if}
            <table>
            <tr>
            <td width="100"><b><u>Nazwa</td>
            <td width="50"><b><u>Poziom</td>
            <td><b><u>Miedz</td>
            <td><b><u>Zelaza</td>
            <td><b><u>Wegla</b></u></td>
            <td><b><u>Mithril</u></b></td>
            <td><b><u>Adamantyt</u><b></td>
            <td><b><u>Meteor</u></b></td>
            <td><b><u>Krysztal</u></b></td>
            </tr>
            {section name=smith2 loop=$Name}
                <tr>
                <td><a href="kowal.php?kowal=kuznia&dalej={$Id[smith2]}">{$Name[smith2]}</a></td>
                <td>{$Level[smith2]}</td>
                <td>{$Copper[smith2]}</td>
                <td>{$Iron[smith2]}</td>
                <td>{$Coal[smith2]}</td>
                <td>{$Mithril[smith2]}</td>
                <td>{$Adamantium[smith2]}</td>
                <td>{$Meteor[smith2]}</td>
                <td>{$Crystal[smith2]}</td>
                </tr>
            {/section}
            </table>
        {/if}
        {if isset($Maked)}
            Oto przedmiot jaki obecnie wykonujesz:
            <table>
            <tr>
            <td width="100"><b><u>Nazwa</u></b></td>
            <td width="50"><b><u>Wykonany(w %)</u></b></td>
            <td width="50"><b><u>Potrzebnej energii</u></b></td>
            </tr>
            <tr>
            <td><a href="kowal.php?kowal=kuznia&ko={$Id}">{$Name}</a></td>
            <td>{$Percent}</td>
            <td>{$Need}</td>
            </tr>
            </table>
        {/if}
    {/if}
    {if $Cont != "" || $Next != ""}
        <form method="post" action="{$Link}">
        Wykonaj <b>{$Name}</b> <input type="text" name="razy"> razy
        <input type="submit" value="Wykonaj"></form>
    {/if}
    {if $Continue != ""}
        {$Message}
    {/if}
    {if $Make != ""}
        {$Message}
    {/if}
{/if}

{if $Smith != ""}
    <br><br><a href=kowal.php>(wroc)</a>
{/if}


