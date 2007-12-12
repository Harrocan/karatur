{if $View == "" && $Join == ""}
    Witaj w Domu Klanow. Tutaj mozesz zobaczyc, dolaczyc lub nawet stworzyc nowy klan.
    <ul>
    {$Mytribe}
    {$Make}
    <li><a href="tribes.php?view=all">Zobacz liste klanow</a>
    <li><a href="klany.php">Zapoznaj sie</a> z zasadami posaidania klanu!!
    </ul>
{/if}

{if $View == "all"}
    Tutaj jest lista wszystkich klanow.
    {$Text}
    {section name=tribes loop=$Name}
        <li><a href="tribes.php?view=view&id={$Tribeid[tribes]}">{$Name[tribes]}</a>, utworzony przez <a href="view.php?view={$Owner[tribes]}">{$User[tribes]}</a>.
    {/section}
{/if}

{if $View == "view"}
    {if $Step == ""}
        <ul>
        <li>Ogladasz: {$Name}<br><br>
        {$Logo}
        Przywodca: ID <a href="view.php?view={$Owner}">{$Owner}</a><br><br>
        Liczba czlonkow: {$Members}<br>
        <a href="tribes.php?view=view&step=members&tid={$Tribeid}">Czlonkowie</a><br>
        Wygranych walk: {$Wins}<br>
        Przegranych walk: {$Lost}<br>
        {if $Immu=='Y'}
        <i>Klan zadeklarowa³ neutralno¶æ</i><br>
        {/if}
        {$WWW}
        {$Pubmessage}<br><br>
        <form method="post" action="tribes.php?join={$Tribeid}">
        Dolacz do klanu {$Name}<br>
        <input type="submit" value="Dolacz">
        </form>
    {/if}
    {if $Step == "members"}
        Lista czlonkow klanu {$Name}<br>
        {section name=tribes1 loop=$Link}
            {$Link[tribes1]}
        {/section}
    {/if}
{/if}

{if $Join != ""}
    {if $Check == "1"}
        Oczekujesz juz na wejscie do innego klanu! Czy chcesz zmienic swoje zgloszenie?<br>
        <a href="tribes.php?join={$Tribeid}&change={$Playerid}">Tak</a><br>
        <a href="tribes.php">Nie</a><br>
    {/if}
{/if}

{if $View == "make"}
    <table><form method="post" action="tribes.php?view=make&step=make">
    <tr><td>Nazwa klanu:</td><td><input type="text" name="name"></td></tr>
    <tr><td colspan="2" align="center"><input type="submit" value="Zaloz"></td></tr>
    </form></table>
{/if}

{if $View == "my"}
    <br><center><table width="98%" class="td" cellpadding="0" cellspacing="0">
    <tr><td align="center" style="border-bottom: solid black 1px;"><b>Moj klan: {$Name}</td></tr>
    </td><td width="100%" valign="top">
    {if $Step == ""}
        {$Logo}
        Witaj w swoim klanie.
        <ul>
        <li>Nazwa klanu: {$Name}</li>
        <li>Liczba czlonkow: {$Members}</li>
        <li>Przywodca: <a href="view.php?view={$Ownerid}">{$Owner}</a></li>
        <li>Sztuk zlota: {$Gold}</li>
        <li>Sztuk mithrilu: {$Mithril}</li>
        {if $Immu=='Y'}
        <li>Neutralno¶æ</li>
        {else}
        <li>Wygranych walk: {$Wins}</li>
        <li>Przegranych walk: {$Lost}</li>
        <li>Zolnierzy: {$Soldiers}</li>
        <li>Fotryfikacji: {$Forts}</li>
        {/if}
        {$WWW}
        </ul>
        {$Privmessage}
    {/if}
    {if $Step == "donate"}
        Prosze daj pieniadze swojemu klanowi i pomoz mu finansowo.
        <form method="post" action="tribes.php?view=my&step=donate&step2=donate">
        Dotuj <input type="text" size="5" name="amount" value="0"> <select name="type">
        <option value="credits">Sztuk Zlota</option>
        <option value="platinum">Sztuk Mithrilu</option>
        </select> do swojego klanu. <input type="submit" value="Dotuj">
        </form>
        {$Message}
    {/if}
    {if $Step == "zielnik"}
        {if $Step2 == "" && $Step3 == "" && $Step4 == "" && $Give == ""}
            Witaj w zielniku klanu. Tutaj sa skladowane ziola nalezace do klanu. Kazdy czlonek klanu moze ofiarowac klanowi jakies ziola ale tylko 
            przywodca lub osoba upowazniona przez niego moze darowac dane ziola czlonkom swojego klanu. Aby dac jakies ziola czlonkom klanu, kliknij 
            na nazwe owego ziola<br>
            <table>
            {$Menu}
            <tr>
            <td align="center">{$Illani}</td>
            <td align=center>{$Illanias}</td>
            <td align=center>{$Nutari}</td>
            <td align=center>{$Dynallca}</td>
            </tr>
            </table>
            Co chcesz zrobic?<br>
            <ul>
            <li><a href="tribes.php?view=my&step=zielnik&step2=daj">Dac ziola do klanu</a></li>
            </ul>
        {/if}
        {if $Give != ""}
            {if $Step4 == ""}
                <form method=post action=tribes.php?view=my&step=zielnik&daj={$Itemid}&step4=add>
                Daj graczowi ID: <input type="text" name="did"><br>
                <input type="text" name="ilosc">{$Name}<br>
                <input type="hidden" name="min" value="{$Name}">
                <input type="submit" value="Daj"><br>
                </form>
            {/if}
            {$Message}
        {/if}
        {if $Step2 == "daj"}
            Dodaj ziola do zielnika<br><br>
            <table><form method="post" action="tribes.php?view=my&step=zielnik&step2=daj&step3=add">
            <tr><td>Ziolo:</td><td><select name="mineral">
            <option value="illani">Illani</option>
            <option value="illanias">Illanias</option>
            <option value="nutari">Nutari</option>
            <option value="dynallca">Dynallca</option></select></td></tr>
            <tr><td>Sztuk:</td><td><input type="text" name="ilosc"></td></tr>
            <tr><td colspan="2" align="center"><input type="submit" value="Dodaj"></td></tr>
            </form></table>
            {$Message}
        {/if}
    {/if}
    {if $Step == "skarbiec"}
        {if $Step2 == "" && $Step3 == "" && $Step4 == "" && $Give == ""}
            Witaj w skarbcu klanu. Tutaj sa skladowane mineraly nalezace do klanu. Kazdy czlonek klanu moze ofiarowac klanowi jakis mineral ale tylko 
            przywodca lub osoba upowazniona przez niego moze darowac dany mineral czlonkom swojego klanu. Aby dac jakis mineral czlonkom klanu, 
            kliknij na nazwe owego mineralu<br>
            <table>
            {$Menu}
            <tr>
            <td align=center>{$Copper}</td>
            <td align=center>{$Iron}</td>
            <td align=center>{$Coal}</td>
            <td align=center>{$Adamantium}</td>
            <td align=center>{$Meteor}</td>
            <td align=center>{$Crystal}</td>
            <td align=center>{$Lumber}</td>
            </table>
            Co chcesz zrobic?<br>
            <ul>
            <li><a href="tribes.php?view=my&step=skarbiec&step2=daj">Dac mineraly do klanu</a></li>
            </ul>
        {/if}
        {if $Give != ""}
            {if $Step4 == ""}
                <form method="post" action="tribes.php?view=my&step=skarbiec&daj={$Itemid}&step4=add">
                Daj graczowi ID: <input type="text" name="did"><br>
                <input type="text" name="ilosc"> {$Name}<br>
                <input type="hidden" name="min" value="{$Name}">
                <input type="submit" value="Daj"><br>
                </form>
            {/if}
            {$Message}
        {/if}
        {if $Step2 == "daj"}
            Dodaj mineralow do skarbca<br><br>
            <table><form method="post" action="tribes.php?view=my&step=skarbiec&step2=daj&step3=add">
            <tr><td>Mineral:</td><td><select name="mineral">
            <option value="miedz">Miedz</option>
            <option value="zelazo">Zelazo</option>
            <option value="wegiel">Wegiel</option>
            <option value="adamantyt">Adamantyt</option>
            <option value="meteoryt">Meteor</option>
            <option value="krysztal">Krysztal</option>
            <option value="drewno">Drewno</option></select></td></tr>
            <tr><td>Ilosc mineralu:</td><td><input type="text" name="ilosc"></td></tr>
            <tr><td colspan="2" align="center"><input type="submit" value="Dodaj"></td></tr>
            </form></table>
            {$Message}
        {/if}
    {/if}
    {if $Step == "members"}
        {section name=tribes2 loop=$Link}
            {$Link[tribes2]}
        {/section}
    {/if}
    {if $Step == "quit"}
        {if $Owner == "1"}
            Czy na pewno chcesz odejsc z klanu? Jezeli to zrobisz, klan zostanie zlikwidowany!<br>
            <a href="tribes.php?view=my&step=quit&dalej=tak">Tak</a><br>
            <a href="tribes.php?view=my">Nie</a><br>
        {/if}
        {if $Owner != "1"}
            Czy na pewno chcesz odejsc z klanu?<br>
            <a href="tribes.php?view=my&step=quit&dalej=tak">Tak</a><br>
            <a href="tribes.php?view=my">Nie</a><br>
        {/if}
    {/if}
    {if $Step == "owner"}
        {if $Step2 == ""}
            Witaj w panelu przywodcy klanu. Co chcesz zrobic?
            <ul>
            <li><a href="tribes.php?view=my&step=owner&step2=permissions">Ustawic uprawnienia czlonkow klanu</a></li>
            <li><a href="tribes.php?view=my&step=owner&step2=rank">Ustawic rangi czlonkom klanu</a></li>
            <li><a href="tribes.php?view=my&step=owner&step2=messages">Edytowac opis klanu, wiadomosc dla czlonkow oraz herb gildii i strone gildii</a></li>
            <li><a href="tribes.php?view=my&step=owner&step2=nowy">Sprawdz liste oczekujacych na dolaczenie do klanu</a></li>
            <li><a href="tribes.php?view=my&step=owner&step2=kick">Wyrzucic Czlonka</a></li>
            <li><a href="tribes.php?view=my&step=owner&step2=wojsko">Dokupic zolnierzy lub fortyfikacji do klanu</a></li>
            <li><a href="tribes.php?view=my&step=owner&step2=walka">Zaatakowac inny klan</a></li>
            <li><a href="tribes.php?view=my&step=owner&step2=loan">Pozycz pieniadze czlonkowi</a></li>
            <li><a href="tribes.php?view=my&step=owner&step2=te">Dodatki klanu</a>
            </ul>
        {/if}
        {if $Step2 == "rank"}
            {if $Step3 == ""}
                Tutaj mozesz ustawic rangi czlonkom swojego klanu, jak rowniez okreslic ich nazwy. Maksymalnie mozesz ustalic 10 rang.<br>
                <ul>
                <li><a href="tribes.php?view=my&step=owner&step2=rank&step3=set">Stworz nowe rangi lub edytuj istniejace</a></li>
                {$Menu}
                </ul>
            {/if}
            {if $Step3 == "set"}
                {if $Empty == "1"}
                    Na razie nie posiadasz okreslonych jakichkolwiek rang w klanie! Mozesz wlasnie je stworzyc. Mozesz je wpisywac w dowolnej kolejnosci, 
                    dodatkowo nie musisz wypelniac wszystkich pol (mozesz np zrobic tylko 3 rangi<br>
                    <form method="post" action="tribes.php?view=my&step=owner&step2=rank&step3=set&step4=add">
                    1 ranga <input type="text" name="rank1"><br>
                    2 ranga <input type="text" name="rank2"><br>
                    3 ranga <input type="text" name="rank3"><br>
                    4 ranga <input type="text" name="rank4"><br>
                    5 ranga <input type="text" name="rank5"><br>
                    6 ranga <input type="text" name="rank6"><br>
                    7 ranga <input type="text" name="rank7"><br>
                    8 ranga <input type="text" name="rank8"><br>
                    9 ranga <input type="text" name="rank9"><br>
                    10 ranga <input type="text" name="rank10"><br>
                    <input type="submit" value="Utworz"></form><br>
                {/if}
                {if $Empty != "1"}
                    Posiadasz juz okreslone kilka rang w klanie. Jezeli chcesz mozesz edytowac istniejace lub dodac nowe<br>
                    <form method="post" action="tribes.php?view=my&step=owner&step2=rank&step3=set&step4=edit">
                    1 ranga <input type="text" name="rank1" value="{$Rank1}"><br>
                    2 ranga <input type="text" name="rank2" value="{$Rank2}"><br>
                    3 ranga <input type="text" name="rank3" value="{$Rank3}"><br>
                    4 ranga <input type="text" name="rank4" value="{$Rank4}"><br>
                    5 ranga <input type="text" name="rank5" value="{$Rank5}"><br>
                    6 ranga <input type="text" name="rank6" value="{$Rank6}"><br>
                    7 ranga <input type="text" name="rank7" value="{$Rank7}"><br>
                    8 ranga <input type="text" name="rank8" value="{$Rank8}"><br>
                    9 ranga <input type="text" name="rank9" value="{$Rank9}"><br>
                    10 ranga <input type="text" name="rank10" value="{$Rank10}"><br>
                    <input type="submit" value="Zapisz"></form><br>
                {/if}
                {$Message}
            {/if}
            {if $Step3 == "get"}
                <form method="post" action="tribes.php?view=my&step=owner&step2=rank&step3=get&step4=add">
                Ustaw range <select name="rank">
                {section name=tribes3 loop=$Rank}
                    <option value="{$Rank[tribes3]}">{$Rank[tribes3]}</option>
                {/section}
                </select> graczowi o ID: <input type="tekst" name="rid"><br>
                <input type="submit" value="Ustaw"></form><br>
                {$Message}
            {/if}
        {/if}
        {if $Step2 == "permissions"}
            {if $Step3 == ""}
                Tutaj mozesz ustawic uprawnienia do roznych miejsc dowolnym czlonkom klanu. W odpowiednie pola wpisz ID czlonkow klanu<br>
                {if $Perm == "1"}
                    <form method="post" action="tribes.php?view=my&step=owner&step2=permissions&step3=add">
                    ID osoby mogacej edytowac opisy klanu: <input type="text" name="messages" size="4" value="0"><br>
                    ID osoby mogacej dolaczac nowych czlonkow: <input type="text" name="wait" size="4" value="0"><br>
                    ID osoby mogacej wyrzucac czlonkow z klanu: <input type="text" name="kick" size="4" value="0"><br>
                    ID osoby mogacej kupowac zolniezy oraz fortyfikacje: <input type="text" name="army" size="4" value="0"><br>
                    ID osoby mogacej wykonywac ataki na inny klan: <input type="text" name="attack" size="4" value="0"><br>
                    ID osoby mogacej pozyczac pieniadze czlonkom klanu: <input type="text" name="loan" size="4" value="0"><br>
                    ID osoby mogacej dawac przedmioty ze zbrojowni: <input type="text" name="armory" size="4" value="0"><br>
                    ID osoby mogacej dawac przedmioty z magazynu: <input type="text" name="warehouse" size="4" value="0"><br>
                    ID osoby mogacej dawac mineraly ze skarbca: <input type="text" name="bank" size="4" value="0"><br>
                    ID osoby mogacej dawac ziola z zielnika: <input type="text" name="herbs" size="4" value="0"><br>
                    ID osoby mogacej kasowac posty na forum: <input type="text" name="forum" size="4" value="0"><br>
                    <input type="submit" value="Zapisz"></form>
                {/if}
                {if $Perm != "1"}
                    <form method="post" action="tribes.php?view=my&step=owner&step2=permissions&step3=change">
                    ID osoby mogacej edytowac opisy klanu: <input type="text" name="messages" size="4" value="{$Perm1}"><br>
                    ID osoby mogacej dolaczac nowych czlonkow: <input type="text" name="wait" size="4" value="{$Perm2}"><br>
                    ID osoby mogacej wyrzucac czlonkow z klanu: <input type="text" name="kick" size="4" value="{$Perm3}"><br>
                    ID osoby mogacej kupowac zolniezy oraz fortyfikacje: <input type="text" name="army" size="4" value="{$Perm4}"><br>
                    ID osoby mogacej wykonywac ataki na inny klan: <input type="text" name="attack" size="4" value="{$Perm5}"><br>
                    ID osoby mogacej pozyczac pieniadze czlonkom klanu: <input type="text" name="loan" size="4" value="{$Perm6}"><br>
                    ID osoby mogacej dawac przedmioty ze zbrojowni: <input type="text" name="armory" size="4" value="{$Perm7}"><br>
                    ID osoby mogacej dawac przedmioty z magazymu: <input type="text" name="warehouse" size="4" value="{$Perm8}"><br>
                    ID osoby mogacej dawac mineraly ze skarbca: <input type="text" name="bank" size="4" value="{$Perm9}"><br>
                    ID osoby mogacej dawac ziola z zielnika: <input type="text" name="herbs" size="4" value="{$Perm10}"><br>
                    ID osoby mogacej kasowac posty na forum: <input type="text" name="forum" size="4" value="{$Perm11}"><br>
                    <input type=submit value=Zapisz></form>
                {/if}
            {/if}
            {$Message}
        {/if}
        {if $Step2 == "wojsko"}
            {if $Action == ""}
                Tutaj mozesz dokupic zolnierzy oraz fortyfikacje dla klanu. Zolnieze dodaja do sily ataku twojego klanu, natomiast fortyfikacje dodaja do 
                jego obrony. Koszt pojedynczego zolnieza ub fortyfikacji wynosi: ilosc zolniezy(fortyfikacji) kupowanych * 1000 sztuk zlota.<br>
                <form method="post" action="tribes.php?view=my&step=owner&step2=wojsko&action=kup">
                Ilu zolnierzy chcesz kupic? <input type="text" name="zolnierze" value="0"><br>
                Ile fortyfikacji chcesz kupic? <input type="text" name="forty" value="0"><br>
                <input type="submit" value="Kupuj"></form>
            {/if}
            {$Message}
        {/if}
        {if $Step2 == "nowy"}
            {if $New == "1"}
                Lista oczekujacych<br>
                <table>
                <tr>
                <td width="100"><b><u>ID gracza</u></b></td>
                <td width="100"><b><u>Dodaj</td>
                <td width="100"><b><u>Odrzuc</u></b></td>
                </tr>
                {section name=tribes4 loop=$Link}
                    {$Link[tribes4]}
                {/section}
                </table>
            {/if}
            {$Message}
        {/if}
        {if $Step2 == "walka"}
            Wybierz klan, ktory chcecie zaatakowac:<br>
            {section name=tribes5 loop=$Link}
                {$Link[tribes5]}
            {/section}
            {if $Victory == "My"}
                Stoisz razem ze swoimi towarzyszami i przyjaciolmi przed armia . Zaraz zacznie sie bitwa... ATAK!!! Slyszysz jak przywodca klanu 
                {$Ename} wykrzyknal komende do jego towarzyszy. Ruszasz razem z twoimi podwladnymi w wir walki. W powietrzu lataja ogniste kule,
                strzaly oraz inne pociski. Zabijasz jednego wroga po drugim. Patrzac w chwili spokoju na swoich towarzyszy zauwazasz iz oni takze z 
                wielkim zapalem niszcza przeciwnikow w imie klanu {$Myname}... Wygraliscie te wspaniala bitwe. Ze skarbca pokonanego klanu
                wyniesliscie <b>{$Gold}</b> sztuk zlota oraz <b>{$Mithril}</b> sztuk mithrilu!
            {/if}
            {if $Victory == "Enemy"}
                Stoisz razem ze swoimi towarzyszami i przyjaciolmi przed armia . Zaraz zacznie sie bitwa... ATAK!!! Slyszysz jak przywodca klanu 
                {$Ename} wykrzyknal komende do jego towarzyszy. Ruszasz razem z twoimi podwladnymi i zaczyna sie bitwa. W powietrzu lataja ogniste
                kule, strzaly oraz inne pociski. Atakujesz przywodce klanu {$Ename} i podczas walki giniesz. Padajac na ziemie patrzysz jak inni twoi
                przyjaciele dziela twoj los... Przegraliscie ta walke...  Z waszego skarbca przeciwnik wyniosl <b>{$Gold}</b> sztuk zlota oraz
                <b>{$Mithril}</b> sztuk mithrilu!
            {/if}
        {/if}
        {if $Step2 == "messages"}
            <table><form method="post" action="tribes.php?view=my&step=owner&step2=messages&action=edit">
            <tr><td valign="top">Opis klanu:</td><td><textarea name="public_msg" cols="55" rows="5">{$Pubmessage}</textarea></td></tr>
            <tr><td valign="top">Wiadomosc dla czlonkow:</td><td><textarea name="private_msg" cols="55" rows="5">{$Privmessage}</textarea></td></tr>
            <tr><td colspan="2" align="center"><input type="submit" value="Zmien"></td></tr>
            </form></table>
            <form method="post" action="tribes.php?view=my&step=owner&step2=messages&action=www">
            Adres strony klanu (wpisz bez http://): <input type="text" name="www" value="{$WWW}"><br>
            <input type="submit" value="Zatwierdz"></form><br>
            {$Logo1}
            Tutaj mozesz zmienic herb swojego klanu. <b>Uwaga!</b> Jezeli klan juz posiada herb, stary zostanie skasowany. Maksymalny rozmiar herbu to 10 kB. Herb mozesz zaladowac tylko z wlasnego komputera. Musi on miec rozszerzenie *.jpg, *.jpeg lub * gif<br>
            {if $Change == "Y"}
                <form action="tribes.php?view=my&step=owner&step2=messages&step4=usun" method="post">
                <input type="hidden" name="av" value="{$Logo}">
                <input type="submit" value="Skasuj">
                </form>
            {/if}
            <form enctype="multipart/form-data" action="tribes.php?view=my&step=owner&step2=messages&step4=dodaj" method="post">
            <input type="hidden" name="MAX_FILE_SIZE" value="10240">
            Nazwa pliku graficznego: <input name="plik" type="file"><br>
            <input type="submit" value="Wyslij"></form>
            {$Message}
        {/if}
        {if $Step2 == "kick"}
            <form method="post" action="tribes.php?view=my&step=owner&step2=kick&action=kick">
            Wyrzuc ID <input type="text" size="5" name="id"> z klanu. <input type="submit" value="Wyrzuc">
            </form>
            {$Message}
        {/if}
        {if $Step2 == "loan"}
            <form method="post" action="tribes.php?view=my&step=owner&step2=loan&action=loan">
            Pozycz <input type="text" size="5" name="amount"> <select name="currency">
            <option value="credits">sztuk zlota</option>
            <option value="platinum">sztuk mithrilu</option></select>
            osobie ID <input type="text" size="5" name="id">. <input type="submit" value="Pozycz">
            </form>
            {$Message}
        {/if}
        {if $Step2 == "te"}
            {$Message1}
            Witaj w panelu dodatkow klanu. Co chcesz zrobic?
            <ul>
            <li><a href="tribes.php?view=my&step=owner&step2=te&step3=hospass">Kup darmowe leczenie w szpitalu dla klanu (100 sztuk mithrilu)</a>
            </ul>
            {if $Hospass1 == "1"}
                Kupiles darwowe leczenie dla czlonkow swojego klanu w szpitalu
                <a href="tribes.php?view=my&step=owner">... wroc</a>
            {/if}
        {/if}
        {$Message2}
    {/if}
    </td></tr><tr><td style=\"border-top: solid black 1px;\" align=center>
    <center>
    (<a href="tribes.php?view=my">Glowna</a>)
    (<a href="tribes.php?view=my&step=donate">Dotuj</a>)
    (<a href="tribes.php?view=my&step=members">Czlonkowie</a>)
    (<a href="tribearmor.php">Zbrojownia</a>)
    (<a href="tribeware.php">Magazyn</a>)
    (<a href="tribes.php?view=my&step=skarbiec">Skarbiec</a>)
    (<a href="tribes.php?view=my&step=zielnik">Zielnik</a>)
    (<a href="tribes.php?view=my&step=quit">Opusc klan</a>)
    (<a href="tribes.php?view=my&step=owner">Opcje Przywodcy</a>)
    (<a href="tforums.php?view=topics">Forum klanu</a>)
    </td></tr></table></center><br>
{/if}
