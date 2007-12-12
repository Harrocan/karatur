{if $Action == "" && $Health > "0"}
    Tuz po przejsciu przez magiczna brame, przez moment czujesz jak kreci ci sie w glowie. Jednak juz po chwili wszystko wraca do normy i
    zaczynasz rozgladac sie do okola. Dostrzegasz ze jestes w jakims nieznanym miejscu, gdzie nawet gwiazdy wygladaja inaczej. Wszystko
    otulone jest lekka szara mgla. Przygladajac sie kawalkom znalezionych przez siebie map, zaczynasz mniej wiecej dostrzegac ktora droga
    wyruszyc. Ida slyszyl wokol siebie szepty w nieznanym ci jezyku, jednak masz dziwne przeczucie ze owe rozmowy dotycza ciebie. Nie wiesz
    sam przez jaki okres czasu podrozowales przez ten nieco nierealny swiat, kiedy twoja podroz dobiega konca. Przed soba widzisz most
    przerzucony nad przepascia prowadzacy do najwiekszego zamku jaki w zyciu widziales. Podazajac mostem, tuz przy bramie dostrzegasz wysoka,
    dobrze zbudowana postac odziana w pelna zbroje plytowa wykonana z nieznanego ci mineralu. Kiedy podchodzisz blizej z niepokojem zauwazasz,
    ze w oczodolach istoty zapalaja sie niebieskie ognie a ona sama rusza w twoim kierunku. Twoj instynkt ci mowi, ze teraz masz ostatnia
    szanse aby uciec zanim rozpocznie sie walka. Co robisz?<br>
    <ul>
    <li><a href="portal.php?action1=fight">Walcze</a></li>
    <li><a href="portal.php?action1=retreat">Uciekam</a></li>
    </ul>
{/if}

{if $Action == "retreat"}
    Szybko odwracasz sie i zaczynasz uciekac w strone portalu, czujac na swoich plecach oddech owej dziwnej istoty. Nie wiesz jak dlugo
    biegles z powrotem kiedy w koncu szybko wbiegasz w brame portalu. Po chwili slyszysz do okola siebie gwar roznych rozmow - znak ze jestes
    z powrotem w Altarze. Jednak owa podroz zmeczyla cie niesamowicie. Dlatego na razie musisz odpoczac. Kliknij <a href="city.php">tutaj</a>.
{/if}

{if $Win == "1"}
    Po twoim ostatnim ciosie, Straznik stanal nieruchomo w miejscu, a nastepnie powoli zaczal sie rozpadac. Droga do zamku stoi przed toba
    otworem. Kiedy podchodzisz do masywnych wrot te pchane jakas niewidzialna sila otwieraja sie na osciez. Wewnatrz widzisz olbrzymi, dlugi
    korytarz. Na jego scianach wisza gobeliny przedstawiajace jakies dziwne istoty zyjace na Vallheru u zarania dziejow. Odglos twoich krokow
    tlumi bogato zdobiony czerwony dywan. Mimo iz cala twierdza wyglada na opuszczona, nigdzie nie dostrzegasz chocby garstki kurzu. Ciekawie
    rozgladajac sie, idziesz caly czas przed siebie. Nie dostrzegasz nigdzie drzwi prowadzacych do innych pomieszczen, wydaje sie jakby cala
    budowla byla tylko tym jednym korytarzem. Kiedy zblizasz sie do jego konca, zauwazasz owego starca, ktorego spotkales w Altarze. Kiedy
    podchodzisz do niego usmiecha sie na twoj widok i mowi:<br> <i>Witaj bohaterze, udalo ci sie pokonac Straznika, moje gratulacje. Dotarles
    do Shar-lan-hazi, ostatniej twierdzy Pierwszych na Vallheru. W nagrode za twe mestwo oraz upor w dazeniu do tego celu, mozesz wybrac dla
    siebie jeden przedmiot bedacy w tym zamku. Jaka nagrode wybierasz dla siebie?</i><br>
    <ul>
    <li>Wybieram <a href="portal.php?action1=fight&step=sword">Miecz Vallheru</a></li>
    <li>Wybieram <a href="portal.php?action1=fight&step=armor">Zbroje Swiatla</a></li>
    <li>Wybieram <a href="portal.php?action1=fight&step=staff">Rozdzke Potegi</a></li>
    <li>Wybieram <a href="portal.php?action1=fight&step=cape">Szate Pierwszych</a></li>
    </ul>
{/if}

{if $Step != ""}
    Kiedy oznajmiles mu swoj wybor, starzec odzywa sie ponownie:<br><i>Dobrze zatem, twa nagroda niedlugo pojawi sie u ciebie. A teraz prosze
    odejdz stad, pozwol tym, ktorzy tu mieszkaja odpoczywac w spokoju Bohaterze.</i> Powoli wychodzisz z zamku, przechodzisz przez most i
    wracasz w kierunku portalu. Kiedy w pewnym momencie ostatni raz odwracasz sie aby spojrzec na zamek zauwazasz ze ten zniknal, a na jego
    miejscu zostalo jedynie niewielkie jezioro. Rozgladajac sie w okolo widzisz ze dziwna mgla opadla, a do okola ciebie rosna jakies nieznane
    rosliny. W okolo panuje cisza, jakbys byl jedyna zywa istota w okolicy. Zblizasz sie do portalu i przechodzisz przez niego. Po chwilowych
    zawrotach glowy znow slyszysz wokol siebie gwar rozmow roznych istot. Jestes z powrotem w Altarze. Rozgladajac sie dookola dostrzegasz
    obok siebie zawiniatko. Kiedy je rozwijasz twoim oczom ukazuje sie {$Item}. Wejdz <a href=equip.php>tutaj</a>
{/if}

