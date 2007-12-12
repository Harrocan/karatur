{if $View == "" && $Join == ""}
    Witaj w Domu Rodow. Tutaj mozesz zobaczyc, dolaczyc lub nawet stworzyc nowy rod.
    <ul>
    {$Myrod}
    {$Make}
    <li><a href="rod.php?view=all">Zobacz liste rodow</a>
    </ul>
{/if}

{if $View == "all"}
    Tutaj jest lista wszystkich rodow.
    {$Text}
    {section name=rod loop=$Name}
<ul>
        <li><a href="rod.php?view=view&id={$Tribeid[rod]}">{$Name[rod]}</a>, ID Przywodcy <a href="view.php?view={$Owner[rod]}">{$Owner[rod]}</a>.
    {/section}
{/if}

{if $View == "view"}
    {if $Step == ""}
        <ul>
        <li>Ogladasz: {$Name}<br><br>
        {$Logo}
        Glowa rodu: ID <a href="view.php?view={$Owner}">{$Owner}</a><br><br>
        Liczba czlonkow: {$Members}<br>
        <a href="rod.php?view=view&step=members&tid={$Tribeid}">Czlonkowie</a><br>
        {$Pubmessage}<br><br>
        <form method="post" action="rod.php?join={$Tribeid}">
        Dolacz do rod {$Name}<br>
        <input type="submit" value="Dolacz">
        </form>
    {/if}
    {if $Step == "members"}
        Lista czlonkow rodu {$Name}<br>
        {section name=tribes1 loop=$Link}
            {$Link[tribes1]}
        {/section}
    {/if}
{/if}

{if $Join != ""}
    {if $Check == "1"}
        Oczekujesz juz na wejscie do innego rodu! Czy chcesz zmienic swoje zgloszenie?<br>
        <a href="rod.php?join={$Tribeid}&change={$Playerid}">Tak</a><br>
        <a href="rod.php">Nie</a><br>
    {/if}
{/if}

{if $View == "make"}
    <table><form method="post" action="rod.php?view=make&step=make">
    <tr><td>Nazwa rodu:</td><td><input type="text" name="name"></td></tr>
    <tr><td colspan="2" align="center"><input type="submit" value="Zaloz"></td></tr>
    </form></table>
{/if}

{if $View == "my"}
    <br><center><table width="98%" class="td" cellpadding="0" cellspacing="0">
    <tr><td align="center" style="border-bottom: solid black 1px;"><b>Moj rod: {$Name}</b></td></tr>
    <td width="100%" valign="top">
    {if $Step == ""}
        {$Logo}
        Witaj w swoim rodzie.
        <ul>
        <li>Nazwa rodu: {$Name}</li>
        <li>Liczba czlonkow: {$Members}</li>
        <li>Przywodca: <a href="view.php?view={$Ownerid}">{$Owner}</a></li>
        <li>Sztuk zlota: {$Gold}</li>
        <li>Sztuk mithrilu: {$Mithril}</li>
        </ul>
        {$Privmessage}
    {/if}
    {if $Step == "donate"}
        Prosze daj pieniadze swojemu rodowi i pomoz mu finansowo.
        <form method="post" action="rod.php?view=my&step=donate&step2=donate">
        Dotuj <input type="text" size="5" name="amount" value="0"> <select name="type">
        <option value="credits">Sztuk Zlota</option>
        <option value="platinum">Sztuk Mithrilu</option>
        </select> do swojego rodu. <input type="submit" value="Dotuj">
        </form>
        {$Message}
    {/if}
           {/if}
    {if $Step == "members"}
        {section name=rod2 loop=$Link}
            {$Link[rod2]}
        {/section}
    {/if}
    {if $Step == "quit"}
        {if $Owner == "1"}
            Czy na pewno chcesz odejsc z klanu? Jezeli to zrobisz, rod zostanie zlikwidowany!<br>
            <a href="rod.php?view=my&step=quit&dalej=tak">Tak</a><br>
            <a href="rod.php?view=my">Nie</a><br>
        {/if}
        {if $Owner != "1"}
            Czy na pewno chcesz odejsc z klanu?<br>
            <a href="rod.php?view=my&step=quit&dalej=tak">Tak</a><br>
            <a href="rod.php?view=my">Nie</a><br>
        {/if}
    {/if}
    {if $Step == "owner"}
        {if $Step2 == ""}
            Witaj w panelu glowy rodu. Co chcesz zrobic?
            <ul>
            <li><a href="rod.php?view=my&step=owner&step2=permissions">Ustawic uprawnienia czlonkow rodu</a></li>
            <li><a href="rod.php?view=my&step=owner&step2=messages">Edytowac opis rodu, wiadomosc dla czlonkow oraz herb rodu i strone rodu</a></li>
            <li><a href="rod.php?view=my&step=owner&step2=nowy">Sprawdz liste oczekujacych na dolaczenie do rodu</a></li>
            <li><a href="rod.php?view=my&step=owner&step2=kick">Wyrzucic Czlonka</a></li>
            <li><a href="rod.php?view=my&step=owner&step2=loan">Pozycz pieniadze czlonkowi</a></li>
            </ul>
        {/if}
                        {$Message}
            {/if}
            
        {if $Step2 == "permissions"}
            {if $Step3 == ""}
                Tutaj mozesz ustawic uprawnienia do roznych miejsc dowolnym czlonkom rodu. W odpowiednie pola wpisz ID czlonkow rodu<br>
                {if $Perm == "1"}
                    <form method="post" action="rod.php?view=my&step=owner&step2=permissions&step3=add">
                    ID osoby mogacej edytowac opisy klanu: <input type="text" name="messages" size="4" value="0"><br>
                    ID osoby mogacej dolaczac nowych czlonkow: <input type="text" name="wait" size="4" value="0"><br>
                    ID osoby mogacej wyrzucac czlonkow z klanu: <input type="text" name="kick" size="4" value="0"><br>
                    ID osoby mogacej pozyczac pieniadze czlonkom klanu: <input type="text" name="loan" size="4" value="0"><br>
                    ID osoby mogacej kasowac posty na forum: <input type="text" name="forum" size="4" value="0"><br>
                    <input type="submit" value="Zapisz"></form>
                {/if}
                {if $Perm != "1"}
                    <form method="post" action="rod.php?view=my&step=owner&step2=permissions&step3=change">
                    ID osoby mogacej edytowac opisy klanu: <input type="text" name="messages" size="4" value="{$Perm1}"><br>
                    ID osoby mogacej dolaczac nowych czlonkow: <input type="text" name="wait" size="4" value="{$Perm2}"><br>
                    ID osoby mogacej wyrzucac czlonkow z klanu: <input type="text" name="kick" size="4" value="{$Perm3}"><br>
                    ID osoby mogacej pozyczac pieniadze czlonkom klanu: <input type="text" name="loan" size="4" value="{$Perm6}"><br>
                    ID osoby mogacej dawac mineraly ze skarbca: <input type="text" name="bank" size="4" value="{$Perm9}"><br>
                    ID osoby mogacej kasowac posty na forum: <input type="text" name="forum" size="4" value="{$Perm11}"><br>
                    <input type=submit value=Zapisz></form>
                {/if}
            {/if}
            {$Message}
        {/if}
        {
        {if $Step2 == "nowy"}
            {if $New == "1"}
                Lista oczekujacych<br>
                <table>
                <tr>
                <td width="100"><b><u>ID gracza</u></b></td>
                <td width="100"><b><u>Dodaj</td>
                <td width="100"><b><u>Odrzuc</u></b></td>
                </tr>
                {section name=rod4 loop=$Link}
                    {$Link[tribes4]}
                {/section}
                </table>
            {/if}
            {$Message}
        {/if}
        {if $Step2 == "messages"}
            <table><form method="post" action="rod.php?view=my&step=owner&step2=messages&action=edit">
            <tr><td valign="top">Opis klanu:</td><td><textarea name="public_msg" rows="1" cols="20">{$Pubmessage}</textarea></td></tr>
            <tr><td valign="top">Wiadomosc dla czlonkow:</td><td><textarea name="private_msg" rows="1" cols="20">{$Privmessage}</textarea></td></tr>
            <tr><td colspan="2" align="center"><input type="submit" value="Zmien"></td></tr>
            </form></table>
            {$Logo}
            Tutaj mozesz zmienic herb swojego rodu. <b>Uwaga!</b> Jezeli rod juz posiada herb, stary zostanie skasowany. Maksymalny rozmiar herbu to 10 kB. Herb mozesz zaladowac tylko z wlasnego komputera. Musi on miec rozszerzenie *.jpg, *.jpeg lub * gif<br>
            {if $Change == "Y"}
                <form action="rod.php?view=my&step=owner&step2=messages&step4=usun" method="post">
                <input type="hidden" name="av" value="{$Logo}">
                <input type="submit" value="Skasuj">
                </form>
            {/if}
            <form enctype="multipart/form-data" action="rod.php?view=my&step=owner&step2=messages&step4=dodaj" method="post">
            <input type="hidden" name="MAX_FILE_SIZE" value="10240">
            Nazwa pliku graficznego: <input name="plik" type="file"><br>
            <input type="submit" value="Wyslij"></form>
            {$Message}
        {/if}
        {if $Step2 == "kick"}
            <form method="post" action="rod.php?view=my&step=owner&step2=kick&action=kick">
            Wyrzuc ID <input type="text" size="5" name="id"> z rodu. <input type="submit" value="Wyrzuc">
            </form>
            {$Message}
        {/if}
        {if $Step2 == "loan"}
            <form method="post" action="rod.php?view=my&step=owner&step2=loan&action=loan">
            Pozycz <input type="text" size="5" name="amount"> <select name="currency">
            <option value="credits">sztuk zlota</option>
            <option value="platinum">sztuk mithrilu</option></select>
            osobie ID <input type="text" size="5" name="id">. <input type="submit" value="Pozycz">
            </form>
            {$Message}
        {/if}
    {/if}
    </td><tr><td style=\"border-top: solid black 1px;\" align=center>
    <center>
    (<a href="rod.php?view=my">Glowna</a>)
    (<a href="rod.php?view=my&step=donate">Dotuj</a>)
    (<a href="rod.php?view=my&step=members">Czlonkowie</a>)
    (<a href="rod.php?view=my&step=quit">Opusc rod</a>)
    (<a href="rod.php?view=my&step=owner">Opcje Glowy rodu</a>)
    (<a href="trod.php?view=topics">Forum rodu</a>)
    </td></tr></table></center><br>
{/if}
