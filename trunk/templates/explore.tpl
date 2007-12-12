{$Link}
{if $Step == "run"}
    {if $Chance > "0"}
        Udalo ci sie uciec przed {$Ename}! Zdobywasz za to {$Expgain} PD<br>
    {/if}
    {if $Chance < "1"}
        Nie udalo ci sie uciec przed {$Ename}! Rozpoczyna sie walka<br>
    {/if}
    {if $Health > "0"}
        <br>Czy chcesz zwiedzac dalej?<br>
	<a href={$Yes}>Tak</a><br>
	<a href={$No}>Nie</a><br>
    {/if}
{/if}

{if $Health > "0" && $Action == "" && $Location == "Nashkel" && $Step == "" && $Fight == "0"}
    Dookola siebie widzisz Chmurne Szczyty. Czy chcesz zobaczyc co znajduje sie wsrod nich? Kazde zwiedzanie kosztuje
    0,5 energii.<br>
    <a href="explore.php?akcja=gory">Tak</a><br>
    <a href="nashkel.php">Nie</a><br>
{/if}

{if $Action == "gory" && $Location == "Nashkel"}
    {if $Roll < "6"}
        Podrozowales jakis czas wsrod szczytow, ale nie znalazles nic ciekawego.
    {/if}
    {if $Roll == "9"}
        Podczas podrozy zauwazyles slady dawnego obozowiska w tym miejscu. Zaintrygowany postanowiles nieco rozejrzec sie po okolicy.
        Bacznie obserwujac ziemie, spostrzegles lekko poruszona ziemie. Odgarniajac ja na boki, odsloniles zniszczony mocno worek, ktory
        rozlecial sie w momemcie kiedy podnosiles go do gory. Lecz nie zwrociles na to uwagi, poniewaz z jego wnetrza wysypalo sie {$Amount}
        sztuk zlota!
    {/if}
    {if $Roll == "10"}
        Wedrujac w pewnym momencie spostrzegasz, iz niedaleko sciezki widac duza, mocno osmalona dziure. Podchodzac blizej zauwazasz, ze na jej
        dnie znajduje sie kilka dziwnych, niewielkich bryl. Zblizajac sie do owego znaleziska, rozpoznajesz owe bryly. To meteoryt! Zdobywasz
        {$Amount} kawalkow meteoru.
    {/if}
    {if $Roll >= "11" && $Roll <= "13"}
        Wedrujac przez jakis czas po gorach natykasz sie na maly zagajnik wsrod skal. Rozgladajac sie po nim, zauwazasz kilka niewielkich
        zolto - niebieskich kwiatow rosnacych niedaleko. To Illani! Delikatnie, aby nie uszkodzic roslin wyciagasz je z ziemi. Zdobywasz
        {$Amount} Illani.
    {/if}
    {if $Roll >= "14" && $Roll <= "15"}
        Podrozujac dostrzegasz z oddali niewielkie gorskie jeziorko. Woda w nim jest krystalicznie czysta. Gasisz pragnienie woda i zaczynasz
        rozgladac sie po brzegach jeziorka w poszukiwaniu interesujacych ciebie rzeczy. Tuz nad zbiornikiem dostrzegasz kepe jasno-zielonego
        mchu. To Illanias! Starannie wydobywasz go z ziemi. Zdobywasz {$Amount} Illanias.
    {/if}
    {if $Roll == "16"}
        W pewnym momencie sciezka gwaltownie opada. Podazajac dalej tym szlakiem zauwazasz ze prowadzi do malej kotlinki wsrod szczytow. W
        kotlinie tej, na samym jej srodku znajduje sie niewielki, starozytny krag zbudawany z duzych kamieni. Glazy sa stare i nieco popekane,
        napisy jakie niegdys na nich sie chyba znajdowaly, dawno juz zatarl wiatr i deszcz. Doslownie czujesz niesamowita cisze otaczajaca
        zewszad. Chodzac w skupieniu po kotlince, widzisz nieco na uboczu owego kregu przewrocony glaz. Jest on porosniety podobna do bluszczu
        roslina o niebiesko-zielonych listkach. To Nutari! Delikatnie zrywasz kilka listkow i odchodzisz z tego miejsca. Zdobywasz {$Amount}
        Nutari.
    {/if}
    {if $Roll == "18"}
        Wedrujac wsrod skal wyczuwasz z oddali nieprzyjemny zapach zgnilizny. Z ciekawosci podazasz w tamta strone. Po pewnym czasie docierasz
        na niewielka polke skalna, jednak nigdzie nie widac padliny. Tuz przy scianie zauwazasz niewielka rosline o ostrych kolcach. Kiedy
        nachylasz sie nad nia, smrod staje sie nie do zniesienia. Slyszales o tej roslinie - to Dynallca. Delikatnie wydobywasz ja z ziemi i
        wkladasz na sam spod plecaka. Zdobywasz {$Amount} Dynallca.
    {/if}
    {if $Roll > "5" && $Roll < "9"}
        Napotkales {$Name}. Czy chcesz sprobowac walki?<br>
       <a href="explore.php?step=battle">Tak</a><br>
       <a href="explore.php?step=run">Nie</a><br>
    {/if}
    {if $Roll == "17" && $Step ==""}
        W pewnym momencie dostrzegasz przed soba most linowy przerzucony nad przepascia. Obok wejscia na most stoi zakapturzona postac. Kiedy
        podchodzisz blizej, odwraca sie w twoim kierunku i cichym zmeczonym glosem mowi: <i>To Most Smierci, tylko najmadrzejsi moga tedy przejsc
        na druga strone. Jezeli chcesz przejsc przez most musisz odpowiedziec na 3 pytania. Jezeli ci sie uda, otrzymasz nagrode.
        Jezeli nie odpowiesz poprawnie - zginiesz. </i>Czy chcesz sprobowac przejsc przez most?<br>
        <form method="post" action="explore.php?akcja=gory&step=first">
        <input type="submit" value="Tak">
        <input type="hidden" name="check" value="first"></form>
        - <a href="explore.php?akcja=gory">Nie</a>
    {/if}
    {if $Step == "first"}
        Dobrze oto pierwsze pytanie: <b>Jaki jest twoj numer (ID)?</b><br>
        <form method="post" action="explore.php?akcja=gory&step=second">
        <input type="text" name="fanswer"><br><input type="submit" value="Dalej"></form>
    {/if}
    {if $Step == "second"}
        {if $Answer == "true"}
            Doskonale, odpowiedziales na pierwsze pytanie! Oto drugie pytanie: <b>Jak nazywa sie kraina w ktorej zyjesz?</b><br>
            <form method="post" action="explore.php?akcja=gory&step=third">
            <input type="text" name="sanswer"><br><input type="submit" value="Dalej"></form>
        {/if}
        {if $Answer == "false"}
            Kiedy wypowiedziales odpowiedz, nagle poczules ze ziemia pod twoimi nogami zaczyna sie osuwac a ty lecisz w dol przepasci.
            Poniewaz spadales dosc dlugo zdazyles zobaczyc przed oczami cale swoje zycie (przy nudniejszych fragmentach udalo ci sie
            nawet przysnac). Zanim zderzyles sie z dnem przepasci ostatnia twoja mysla bylo: ZAPAMIETAC - UNIKAC STARYCH WARIATOW PRZY
            MOSTACH ZADAJACYCH GLUPIE PYTANIA!
        {/if}
    {/if}
    {if $Step == "third"}
        {if $Answer == "true"}
            Doskonale, odpowiedziales na drugie pytanie! Coz za niezwykla inteligencja! Oto trzecie pytanie: <b>{$Question}?</b><br>
            <form method="post" action="explore.php?akcja=gory&step=forth">
            <input type="hidden" name="number" value="{$Number}">
            <input type="text" name="tanswer"><br><input type="submit" value="Dalej"></form>
        {/if}
        {if $Answer == "false"}
            Kiedy wypowiedziales odpowiedz, nagle poczules ze ziemia pod twoimi nogami zaczyna sie osuwac a ty lecisz w dol przepasci.
            Poniewaz spadales dosc dlugo zdazyles zobaczyc przed oczami cale swoje zycie (przy nudniejszych fragmentach udalo ci sie
            nawet przysnac). Zanim zderzyles sie z dnem przepasci ostatnia twoja mysla bylo: ZAPAMIETAC - UNIKAC STARYCH WARIATOW PRZY
            MOSTACH ZADAJACYCH GLUPIE PYTANIA!
        {/if}
    {/if}
    {if $Step == "forth"}
        {if $Answer == "true"}
            Doskonale, odpowiedziales na trzecie pytanie! Zdobyles w nagrode {$Item} oraz mozesz przejsc przez most! Postac w kapturze powoli odchodzi,
            mruczac pod nosem: <i>Co za swiat, czlowiek jak juz dostaje jakas role to praktycznie niewiele warta. Musze pogadac z moim agentem, caly
            czas daje mi takie same role...</i><br>
            (<a href="explore.php"> Odswiez</a>)
        {/if}
        {if $Answer == "false"}
            Kiedy wypowiedziales odpowiedz, nagle poczules ze ziemia pod twoimi nogami zaczyna sie osuwac a ty lecisz w dol przepasci.
            Poniewaz spadales dosc dlugo zdazyles zobaczyc przed oczami cale swoje zycie (przy nudniejszych fragmentach udalo ci sie
            nawet przysnac). Zanim zderzyles sie z dnem przepasci ostatnia twoja mysla bylo: ZAPAMIETAC - UNIKAC STARYCH WARIATOW PRZY
            MOSTACH ZADAJACYCH GLUPIE PYTANIA!
        {/if}
    {/if}
    {if $Roll == "19"}
        {if $Maps == "Y"}
            Wedrujac po gorach zauwazasz niewielka jaskinie niedaleko szlaku. Zaciekawiony podazasz w te strone. Wchodzac do srodka widzisz ze pod
            przeciwlegla sciana znajduje sie niewielka, okuta zelazem skrzynie. Podchodzisz do niej i {$Open} Wewnatrz dostrzegasz zwoj
            starego pergaminu. Ostroznie wyciagasz go i uwaznie przygladasz sie. To kawalek mapy skarbow. Delikatnie chowasz ja w
            plecaku.
        {/if}
        {if $Maps == 'N'}
            Wedrowales jakis czas po gorach, ale niestety nie znalazles nic ciekawego.
        {/if}
    {/if}
    {if $Menu == "Y"}
        <br>Czy chcesz zwiedzac dalej?<br>
	<a href={$Yes}>Tak</a><br>
	<a href={$No}>Nie</a><br>
    {/if}
{/if}
{if $Health > 0 && $Action == "" && $Location == "Las Ostrych Klow" && $Step == "" && $Fight == "0"}
    Przed soba widzisz sciane lasu Ostrych Klow. Waska sciezka prowadzaca w glab lasu niknie juz po chwili za zakretem. Zewszad otaczaja sie
    stare, wysokie drzewa, slychac dookola spiew ptactwa, gdzies z lasu dochodza odglosy zycia zwierzat. Czy chcesz dalej podazac lesna
    sciezka? Kazde zwiedzanie kosztuje 0,5 energii.<br>
    <a href="explore.php?akcja=las">Tak</a><br>
    <a href="las.php">Nie</a><br>
{/if}

{if $Action == "las" && $Location == "Las Ostrych Klow"}
    {if $Roll < "6"}
        Podrozowales jakis czas wsrod drzew, ale nie znalazles nic ciekawego
    {/if}
    {if $Roll == "9"}
        Podczas podrozy zauwazyles slady dawnego obozowiska w tym miejscu. Zaintrygowany postanowiles nieco rozejrzec sie po okolicy. Bacznie
        obserwujac ziemie, spostrzegles lekko poruszona ziemie. Odgarniajac ja na boki, odsloniles zniszczony mocno worek, ktory rozlecial sie
        w momemcie kiedy podnosiles go do gory. Lecz nie zwrociles na to uwagi, poniewaz z jego wnetrza wysypalo sie {$Amount} sztuk zlota!
    {/if}
    {if $Roll == "10"}
        Podrozujac poprzez las w dostrzegasz niewielki lesny potok. Postaniawiasz odpoczac nieco nad jego brzegiem. Po kilku godzinach
        ponownie ruszasz w droge. Odzyskales {$Amount} punktow energii.
    {/if}
    {if $Roll >= "11" && $Roll <= "13"}
        Wedrujac przez jakis czas po lesie natykasz sie na duza kepe krzakow porastajacych porozrzucane tu i owdzie kamienie. Rozgladajac sie po
        nim, zauwazasz kilka niewielkich zolto - niebieskich kwiatow rosnacych niedaleko. To Illani! Delikatnie, aby nie uszkodzic roslin
        wyciagasz je z ziemi. Zdobywasz {$Amount} Illani.
    {/if}
    {if $Roll >= "14" && $Roll <= "15"}
        Podrozujac dostrzegasz z oddali niewielkie lesne jeziorko. Woda w nim jest krystalicznie czysta. Gasisz pragnienie woda i zaczynasz
        rozgladac sie po brzegach jeziorka w poszukiwaniu interesujacych ciebie rzeczy. Tuz nad zbiornikiem dostrzegasz kepe jasno-zielonego mchu.
        To Illanias! Starannie wydobywasz je z ziemi. Zdobywasz {$Amount} Illanias.
    {/if}
    {if $Roll == "16"}
        W pewnym momencie las dostrzegasz ze las dookola ciebie wyglada na starszy niz w innych miejscach. Na drzewach widac dlugie brody mchu,
        ktore sprawiaja iz wiekowe deby wygladaja jak twarze starych ludzi. Wokol panuje gleboka cisza nie slychac nawet spiewu ptakow. Dookola
        ciebie panuje lekki polmrok, sprawiajac iz cienie na sciezcie wydluzaja sie, a ty odnosisz wrazenie ze drzewa poruszaja sie mimo iz nie ma
        wiatru. W pewnym momencie nagle wychodzisz na niewielka polane. Niestety nawet tutaj nie widac nieba, poniewaz galezie drzew tworza
        sklepienie nad polanka. Przygladajac sie otoczeniu w pewnym momencie zauwazasz ze trawa tutaj promieniuje jakby lekkim, jasnoszarym
        blaskiem. Przechadzajac sie po polanie zauwazasz nieco na uboczu dosc duzy kamien, na ktorym ktos dawno temu wyryl jakies znaki, dzis juz
        prawie calkowicie zatarte przez czas. Obchodzac glaz do okola zauwazasz ze jest on porosniety podobna do bluszczu roslina o
        niebiesko-zielonych listkach. To Nutari! Delikatnie zrywasz kilka listkow i odchodzisz z tego miejsca. Zdobywasz {$Amount} Nutari.
    {/if}
    {if $Roll == "17"}
        Wedrujac po lesie, po pewnym czasie zauwazasz ze teren nieco sie podnosi. Po pewnym czasie idac dalej dostrzegasz w oddali wejscie do
        niewielkiej jaskini. Podchodzac blizej slyszysz z tego kierunku lekki plusk. Kiedy stajesz w wejsciu widzisz dosc duza kaluze wody, ktora
        kapie z sufitu jaskini. Postanowiles napic sie nieco. Zblizajac sie do wody, nagle poczules okropny swad zgnilizny. Rozgladajac sie
        wokolo, tuz przy scianie groty zauwazasz niewielka rosline o ostrych kolcach. Kiedy nachylasz sie nad nia, smrod staje sie nie do
        zniesienia. Slyszales o tej roslinie - to Dynallca. Delikatnie wydobywasz ja z ziemi i wkladasz na sam spod plecaka. Zdobywasz
        {$Amount} Dynallca
    {/if}
    {if $Roll > "5" && $Roll < "9"}
        Napotkales {$Name}. Czy chcesz sprobowac walki?<br>
       <a href="explore.php?step=battle&type=T">Tak (turowa walka)</a><br>
       <a href="explore.php?step=battle&type=S">Tak (szybka walka)</a><br>
       <a href="explore.php?step=run">Nie</a><br>
    {/if}
    {if $Roll == "18"}
        {if $Maps == "Y"}
            Wedrujac wsrod starych drzew widzisz niedaleko mala jame w ziemi, nieco juz przysypana. Kiedy zblizasz sie do niej, promien slonca ktory
            akurat przebil sie przez listowie odbil sie na czyms metalicznym na ziemi. Delikatnie odgarniajac piach dostrzegasz niewielka, okuta
            zelazem skrzynie. Podchodzisz do niej i {$Open} Wewnatrz dostrzegasz zwoj
            starego pergaminu. Ostroznie wyciagasz go i uwaznie przygladasz sie. To kawalek mapy skarbow. Delikatnie chowasz ja w
            plecaku.
        {/if}
        {if $Maps == 'N'}
            Wedrowales jakis czas po lesie, ale niestety nie znalazles nic ciekawego.
        {/if}
    {/if}
    {if $Menu == "Y"}
        <br>Czy chcesz zwiedzac dalej?<br>
	<a href={$Yes}>Tak</a><br>
	<a href={$No}>Nie</a><br>
    {/if}
{/if}

{if $Health > "0" && $Action == "" && $Location == "Beregost" && $Step == "" && $Fight == "0"}
    Przed soba widzisz Rownine Doliny Mroku. Waska sciezka prowadzaca przez gigantyczny niknie juz po chwili spadajac za pagorek. W kilku miejscach widzisz
    stare, wysokie drzewa, slychac dookola spiew ptactwa, gdzies z daleko slychac wycie stada bawolu. Czy chcesz dalej podazac
    sciezka? Kazde zwiedzanie kosztuje 0,5 energii!.<br>
    <a href="explore.php?akcja=dolina">Tak</a><br>
    <a href="dolina.php">Nie</a><br>
{/if}

{if $Action == "dolina" && $Location == "Beregost"}
    {if $Roll < "6"}
        Podrozowales jakis czas wsrod pagorkow, ale nie znalazles nic ciekawego
    {/if}
    {if $Roll == "9"}
        Podczas podrozy zauwazyles slady dawnego obozowiska w tym miejscu. Zaintrygowany postanowiles nieco rozejrzec sie po okolicy. Bacznie
        obserwujac ziemie, spostrzegles lekko poruszona ziemie. Odgarniajac ja na boki, odsloniles zniszczony mocno worek, ktory rozlecial sie
        w momemcie kiedy podnosiles go do gory. Lecz nie zwrociles na to uwagi, poniewaz z jego wnetrza wysypalo sie {$Amount} sztuk zlota!
    {/if}
    {if $Roll == "10"}
        Podrozujac poprzez las w dostrzegasz niewielki potok. Postaniawiasz odpoczac nieco nad jego brzegiem. Po kilku godzinach
        ponownie ruszasz w droge. Odzyskales {$Amount} punktow energii.
    {/if}
    {if $Roll >= "11" && $Roll <= "13"}
        Wedrujac przez jakis czas po dolinie natykasz sie na duza kepe krzakow porastajacych porozrzucane tu i owdzie kamienie. Rozgladajac sie po
        nim, zauwazasz kilka niewielkich zolto - niebieskich kwiatow rosnacych niedaleko. To Illani! Delikatnie, aby nie uszkodzic roslin
        wyciagasz je z ziemi. Zdobywasz {$Amount} Illani.
    {/if}
    {if $Roll >= "14" && $Roll <= "15"}
        Podrozujac dostrzegasz z oddali wielkie jezioro. Woda w nim jest krystalicznie czysta. Gasisz pragnienie woda i zaczynasz
        rozgladac sie po brzegach jeziorka w poszukiwaniu interesujacych ciebie rzeczy. Zauwazasz, ze wszystkie stworzenia przychodza sie napic z tego miejsca Tuz nad zbiornikiem dostrzegasz kepe jasno-zielonego mchu.
        To Illanias! Starannie wydobywasz je z ziemi. Zdobywasz {$Amount} Illanias.
    {/if}
    {if $Roll == "16"}
        W pewnym momencie dostrzegasz ze dolina dookola ciebie wyglada na starsza niz w innych miejscach. Na krzewach widac dlugie brody mchu,
        ktore sprawiaja iz wiekowy busz wyglada jak twarz starego mezczynzy. Wokol panuje gleboka cisza nie slychac nawet spiewu ptakow. Dookola
        ciebie panuje lekki polmrok, sprawiajac iz cienie na sciezcie wydluzaja sie, a ty odnosisz wrazenie ze krzewy poruszaja sie mimo iz nie ma
        wiatru. W pewnym momencie nagle wychodzisz na wielka calkowicie nie zarosnieta polane. Przygladajac sie otoczeniu w pewnym momencie zauwazasz ze trawa tutaj promieniuje jakby lekkim, jasnoszarym
        blaskiem. Przechadzajac sie po polanie zauwazasz nieco na uboczu dosc duzy kamien, na ktorym ktos dawno temu wyryl jakies znaki, dzis juz
        prawie calkowicie zatarte przez czas. Obchodzac glaz do okola zauwazasz ze jest on porosniety podobna do bluszczu roslina o
        niebiesko-zielonych listkach. To Nutari! Delikatnie zrywasz kilka listkow i odchodzisz z tego miejsca. Zdobywasz {$Amount} Nutari.
    {/if}
    {if $Roll == "17"}
        Wedrujac po dolinkach, po pewnym czasie zauwazasz ze teren mocniej sie podnosi. Po pewnym czasie idac dalej dostrzegasz w oddali wejscie do
        niewielkiej jaskini. Podchodzac blizej slyszysz z tego kierunku lekki plusk. Kiedy stajesz w wejsciu widzisz dosc duza kaluze wody, ktora
        kapie z sufitu jaskini. Postanowiles napic sie nieco. Zblizajac sie do wody, nagle poczules okropny swad zgnilizny. Rozgladajac sie
        wokolo, tuz przy scianie groty zauwazasz niewielka rosline o ostrych kolcach. Kiedy nachylasz sie nad nia, smrod staje sie nie do
        zniesienia. Slyszales o tej roslinie - to Dynallca. Delikatnie wydobywasz ja z ziemi i wkladasz na sam spod plecaka. Zdobywasz
        {$Amount} Dynallca
    {/if}
    {if $Roll > "5" && $Roll < "9"}
        Napotkales {$Name}. Czy chcesz sprobowac walki?<br>
       <a href="explore.php?step=battle&type=T">Tak (turowa walka)</a><br>
       <a href="explore.php?step=battle&type=S">Tak (szybka walka)</a><br>
       <a href="explore.php?step=run">Nie</a><br>
    {/if}
    {if $Roll == "18"}
        {if $Maps == "Y"}
            Wedrujac wsrod starych drzew widzisz niedaleko mala jame w ziemi, nieco juz przysypana. Kiedy zblizasz sie do niej, promien slonca odbil sie na czyms metalicznym na ziemi. Delikatnie odgarniajac piach dostrzegasz niewielka, okuta
            zelazem skrzynie. Podchodzisz do niej i {$Open} Wewnatrz dostrzegasz zwoj
            starego pergaminu. Ostroznie wyciagasz go i uwaznie przygladasz sie. To kawalek mapy skarbow. Delikatnie chowasz ja w
            plecaku.
        {/if}
        {if $Maps == 'N'}
            Wedrowales jakis czas po dolinach i rowninach, ale niestety nie znalazles nic ciekawego.
        {/if}
    {/if}
    {if $Menu == "Y"}
        <br>Czy chcesz zwiedzac dalej?<br>
	<a href={$Yes}>Tak</a><br>
	<a href={$No}>Nie</a><br>
    {/if}
{/if}



