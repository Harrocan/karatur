{if $Clas == ""}
    Tutaj mozesz wybrac klase swojej postaci. Kazda klasa ma swoje plusy i minusy. Zastanow sie dobrze, poniewaz pozniej nie bedziesz juz
    mogl zmienic swojej klasy.<br><br>
    - <a href="klasa.php?klasa=wojownik">Wojownik</a><br>
    - <a href="klasa.php?klasa=mag">Mag</a><br>
    - <a href="klasa.php?klasa=craftsman">Rzemieslnik</a><br>
    - <a href="klasa.php?klasa=barbarzynca">Barbarzynca</a><br>
    - <a href="klasa.php?klasa=zlodziej">Zlodziej</a><br><br>
    - <a href="klasa.php?klasa=kaplan">Kaplan(test)</a><br<br>
    - <a href="klasa.php?klasa=druid">Druid(test)</a><br<br>
    - <a href="klasa.php?klasa=lowca">Lowca(test)</a><br<br>
    - <a href="klasa.php?klasa=mnich"></a><br<br>
{/if}

{if $Clas == "wojownik" && $Plclass == ""}
<center><img src="images/woj.jpg"/></center>
    Wojownicy sa popularna klasa. W wiekszosci wojownikami zostaja krasnoludy choc elfy i ludzie tez nie
    rezygnuja z tej klasy. Maja najwieksze zdolnosci bojowe - najwazniejsze dla nich sa sila i wytrzymalosc
    ale tez bez odpowiedniej szybkosci i zrecznosci sie nie obejdzie. W Vallheru wojownicy stanowia
    najwieksza czesc spoleczenstwa. Podczas walki wojownik posluguje sie bronia biala a najczesciej ubiera
    sie w mocne zbroje - choc sa w Vallheru znakomici szermierze ktorym zbroja tylko przeszkadza. Zostaja
    zlymi rzezimieszkami, silnymi ochroniarzami, wiernymi obroncami, przebieglymi zlodziejami, lub po prostu
    neutralnymi poszukiwaczami przygod. Wojownikami zostaja osoby ktore najczesciej szukaja okazji do bitki
    i przetestowania swoich zdolnosci bojowych, lub z checi zemsty na kims ale tez dla samoobrony lub
    zmierzenia sie na arenie z innymi dla chwaly.<br>
    Krasnoludy ktore zostaja wojownikami sa najczesciej nieokrzesani i porywczy, ale i silni oraz bardzo
    niebezpieczni, posluguja sie ciezka bronia i zbroja. Elfi szermierze posluguja sie lekka bronia i
    zbroja aby moc wykorzystac swoja zwinnosc podczas walki. Natomiast ludzie akceptujacy te profesje
    zostaja rownie dobrymi zbrojnymi co zwinnymi wojownikami.<br>
    Cechy charakterystyczne wojownika
    <ul>
    <li>- 0.5 do inteligencji (zamiast 2.5 inteligencji za 1 AP dostaje 2 punkty inteligencji)</li>
    <li>Premia do umiejetnosci atak oraz unik w wysokosci poziomu postaci</li>
    </ul>
    <form method=post action="klasa.php?klasa=wojownik&step=wybierz">
    <input type="submit" value="Wybierz"><br>
    (<a href="klasa.php">Wroc</a>)
{/if}

{if $Clas == "mag" && $Plclass == ""}
    Magowie maja swoj stereotyp ktorego skrupulatnie sie trzymaja. Elfy najczesciej akceptuja ta klase choc
    ludzie nie wydaja sie byc ta profesja mniej zainteresowane, natomiast krasnoludy krzywo na nia patrza.
    Magow nie obchodza bronie czy zbroje. Nie uwazaja iz sila czy wytrzymalosc sa najwazniejsze - w sumie
    uwazaja je za zbedne. Sila maga sa jego czary. W Vallheru magowie tworza scisla elite i zazwyczaj
    trzymaja sie razem. Sa madrzy i charyzmatyczni, inteligentni i roztropni - lecz sa tez szaleni i
    nierozwazni czarodzieje ktorzy wymyslaja nowe dziwne zaklecia. Magami zostaja przewaznie osoby ktore
    chca poznac tajniki wiedzy i potegi magicznej aby mogli stac sie najpotezniejszymi magami swych czasow.<br>
    Krasnoludy nie wybieraja tej klasy chyba ze sa to jakies bekarty - tacy zostaja najczesciej szalonymi
    wynalazcami. Jest to ulubiona klasa elfow ktore sa madre i roztropne. Ludzcy magowie sa inteligentni i
    utalentowani lecz znajduja sie tez wsrod nich dziwni ludzie ktorych nie powinno sie dopuszczac do magii.<br>
    Cechy charakterystyczne Magow:
    <ul>
    <li>+0.5 do inteligencji (za kazdy 1 AP dostaja +3 do inteligencji)</li>
    <li>Jako jedyni moga uzywac czarow bojowych oraz obronnych</li>
    <li>Moga uzywac broni (ale nie jednoczesnie z czarem bojowym) oraz nosic pancerze (chociaz te ograniczaja ich czary - kazdy poziom
    pancerza obniza sile czarow maga o 1%)</li>
    </ul>
    <form method="post" action="klasa.php?klasa=mag&step=wybierz">
    <input type="submit" value="Wybierz"><br>
    (<a href="klasa.php">Wroc</a>)
{/if}

{if $Clas == "craftsman" && $Plclass == ""}
    Te klase tworza rzemieslnicy, kowale, kolekcjonerzy chowancow i kupcy. Grupa ta nie ma okreslonych
    ulubionych ras ktorzy wybieraja ta profesje. Kazdy krasnolud, elf czy czlowiek nadaje sie na kupca czy
    kowala. Jednak tylko rzemieslnicy potrafia najzreczniej poslugiwac sie kowalskim mlotem lub kupieckim
    sztucznym urokiem. Uzywaja broni bialej gdyz nie interesuja ich zaklecia - w zasadzie walka takze lecz
    nigdy nie wiadomo z kim przyjdzie handlowac wiec zawsze nosza przy sobie bron. Zostaja bogatymi
    handlarzami, silnymi kowalami lub chciwymi szulerami lub przemytnikami. Rzemieslnikami zostaja osoby ktorymi
    prowadzi chec szybkiego zarobku a potem osiedlenie sie i rozkrecanie interesu. Jednak niektorzy
    zarabiajac nielegalnie pieniadze zakladaja potajemne gildie zlodziei lub przemytnikow.<br>
    Kazda rasa ma takie same predyspozycje na obywatela.<br>
    Cechy Rzemieslnika:
    <ul>
    <li>Premia do umiejetnosci Kowalstwo w wysokosci 1/10 poziomu Rzemieslnika</li>
    </ul>
    <form method="post" action="klasa.php?klasa=craftsman&step=wybierz">
    <input type="submit" value="Wybierz"><br>
    (<a href="klasa.php">Wroc</a>)
{/if}

{if $Clas == "barbarzynca" && $Plclass == ""}
    <i>Byles wspanialym przeciwnikiem! Wspomne twe imie gdy podczas uczt bede pil najlepsze trunki z twej czaszki!</i><br>
    Gdyby wojownika nazwac synem wojny, barbarzynce trzeba by bylo nazwac jej mezem. Z dalekich i dzikich miejsc calego Vallheru u
    bram Altary pojawili sie barbarzyncy, glodni bogactw oraz slawy. Ich domem jest pole bitwy, ich jezykiem dzwiek wydawany przez bron
    w momencie ataku. Sa najbardziej nieokrzesana grupa obywateli wsrod mieszkancow Vallheru. Nie cierpia magii ani jakiejkolwiek pomocy
    ze strony magow, uwazaja iz o chwale barbarzyncy decyduje on sam a nie jakies nieznane moce. Unikaja przez to jakiejkolwiek
    formy magii czy to czarow czy magicznych broni. Jednak owa niechec sprawia, iz sa bardziej odporni na dzialania urokow niz inne kasty
    mieszkancow. Owe uprzedzenia do magow wywolaly juz kilka poteznych bitew z magami. Na slady owych walk mozna natknac sie czasami,
    podrozujac po bezdrozach Vallheru. Najwiecej barbarzyncow mozna spotkac posrod Jaszczuroludzi, najmniej - posrod Hobbitow.
    Ich glowna domena jest walka, lecz podobnie jak wojownicy jako tako radza sobie rowniez z kowalstwem czy stolarstwem.
    Niezaleznie czy barbarzynca jest Krasnolud czy Czlowiek, kasta ta ma takie same cechy<br>
    Cechy Barbarzyncy
    <ul>
    <li>Premia do ataku oraz uniku w wysokosci poziomu barbarzyncy</li>
    <li>Premia do odpornosci na magie w wysokosci 1/10 poziomu (do maksymalnych 20%)</li>
    <li>Barbarzyncy nie moga uzywac ani czarow ani przedmiotow magicznych - moga nosic je w plecaku ale nie moga ich zakladac</li>
    </ul>
    <form method="post" action="klasa.php?klasa=barbarzynca&step=wybierz">
    <input type="submit" value="Wybierz"><br>
    (<a href="klasa.php">Wroc</a>)
{/if}

{if $Clas == "zlodziej" && $Plclass == ""}
    <i>Hej, przyjacielu! Potrzebujesz moze pomocy? Moge ci pokazac pare ciekawych miejsc w naszym pieknym miescie! Choc pokaze ci skrot, 
    prosze ta waska uliczka. Kim sa ci uzbrojeni osobnicy? To moi wspolnicy, razem prowadzimy interesy...</i><br>
    Mowi sie, ze kiedy pojawila sie inteligencja pojawili sie i oni - Zlodzieje. Ponoc to jeden z najstarszych zawodow swiata, jednak na
    pewno jeden z mniej powazanych. Nikt nie lubi zlodziei ale kazdy chcialby miec ich po swojej stronie - z jeszcze innej strony
    zaprzyjaznienie sie z kims takim to jak zaprzyjaznienie sie z kobra. Jedno jest pewne - juz nie bedziesz sie nudzil wiecej w towarzystwie
    zlodzieja. Zlodzieje to przede wszystkim sprytni osobnicy, ktorzy ponad sile i otwarta, honorowa walke stawiaja podstepy oraz oszustwo.
    Kiedy moga, unikaja walki, lecz gdy juz do niej stana staraja sie uzyc wszelkich sposobow aby wygrac. Niestety to wszystko powoduje iz nie
    sa zbyt lubiani posrod mieszkancow Vallheru, a juz na pewno sily porzadkowe probuja zwalczac ich na kazdym kroku. Wielu z nich prowadzi
    podwojne zycie, tak aby zabezpieczyc sie na wypadek gdyby cos poszlo nie tak. Lecz nawet w tej wydawaloby sie do konca zepsutej kascie,
    czasami natknac mozna sie na kogos kto wspiera innych bez ogladania sie na wlasne korzysci. Tacy najczesciej zostaja zwiadowcami karawan,
    czy tez przewodnikami grup poszukiwaczy przygow. Jednego mozna sie spodziewac po zlodzieju - tego ze nic nie jest pewne. Najczesciej te
    sciezke zyciowa wybieraja Hobbici, choc slyszano rowniez o Jaszczuroludziach ktorzy palali sie ta profesja. Pewne cechy sa niezalezne od
    rasy danej postaci.<br>
    Cechy Zlodzieja:
    <ul>
    <li>Mozliwosc raz na reset okradzenia banku, gracza lub sklepu</li>
    <li>Jezeli zlodziej dokona nieudanej proby kradziezy (zostanie zlapany) - trafia do lochow na jeden dzien z kaucja 1000 x poziom</li>
    </ul>
    <form method="post" action="klasa.php?klasa=zlodziej&step=wybierz">
    <input type="submit" value="Wybierz"><br>
    (<a href="klasa.php">Wroc</a>)
{/if}

{if $Clas == "kaplan" && $Plclass == ""}
    <i>Niech bog ma cie w opiece synu</i><br>
    Kaplani sa wyslannikami swoich boskich patronow, sprawiajac by ich wola stala sie rzeczywistoscia.<br>
    Cechy Kaplana:
    <ul>
    <li>nic</li>
    <li>nic</li>
    </ul>
    <form method="post" action="klasa.php?klasa=kaplan&step=wybierz">
    <input type="submit" value="Wybierz"><br>
    (<a href="klasa.php">Wroc</a>)
{/if}


{if $Clas == "druid" && $Plclass == ""}
    Druidzi sa straznikami swiata. Zamknieci w snie, obudzili sie by przeciwstawic sie zlu Plonacego Legionu podczas ich ostatniego najazdu. Po klesce Archimonde'a postanowili nie zasypiac ponownie i pomoc odbudowac zrujnowanπ ziemie. Atak Legionow pozostawil straszliwπ blizne w naturalnym porzadku swiata. Druidzi daza by uzdrowic ten stan rzeczy. <br>
    Cechy charakterystyczne Druidow:
    <ul>
<li>- +3.5 Sila za 1 ap</li>
<li>- +2 Zrecznosc za 1 ap</li>
<li>- +3.5 Szybkosc za 1 ap</li>
<li>- +2 Wytrzymalosc za 1 ap</li>
<li>- +2.5 Inteligencja za 1 ap</li>
<li>- +2.5 Sily Woli za 1 ap</ul>
   <li>Premia do umiejetnosci Alchemia w wysokosci 1/10 poziomu Druida</li>
   <li>Mozliwoúc przemiany w bestie</li>
    </ul>
    <form method="post" action="klasa.php?klasa=druid&step=wybierz">
    <input type="submit" value="Wybierz"><br>
    (<a href="klasa.php">Wroc</a>)
{/if}

{if $Clas == "lowca" && $Plclass == ""}
Azeroth jest domem dla wielu rodzajow zwierzπt. Poczawszy od nowego úwiata Lordaeron'u a skonczywszy na starym úwicie Kalimdor'u mozna znaleüc wszystkie rodzaje stworzen. jedne sa przyjazne drugie sa agresywne i dzikie, ale wszystkie one maja jednπ wspolna ceche. Kazde zwierze posiada specjalna wieü z Lowca. Lowcy tropia, oswajaja i zabijaja wszelkie rodzaje zwierzat i bestii, jakie napotkaja na dziczyünie. Niezaleznie od tego czy Lowca polega na luku czy broni bialej, uwazaja swojπ bron i zwierze jako jedynych przyjaciol. <br>
    Cechy charakterystyczne wojownika
    <ul>
 <li>- +3.5 Sila za 1 ap </li>
 <li>- +2 Zrecznoúc za 1 ap </li>
 <li>- +3.5 Szybkoúc za 1 ap </li>
 <li>- +2 Wytrzymaloúc za 1 ap </li>
 <li>- +0 Inteligencja za 1 ap </li>
 <li>- +0 Sily Woli za 1 ap
    <li>- 0.5 do inteligencji (zamiast 2.5 inteligencji za 1 AP dostaje 2 punkty inteligencji)</li>
    <li>Premia do umiejetnosci atak oraz unik w wysokosci poziomu postaci</li>
    </ul>
    <form method=post action="klasa.php?klasa=lowca&step=wybierz">
    <input type="submit" value="Wybierz"><br>
    (<a href="klasa.php">Wroc</a>)
{/if}
{if $Clas == "mnich" && $Plclass == ""}
mnich <br>
    Cechy charakterystyczne mnicha
    <ul>
 <li>- +3.5 Sila za 1 ap </li>
 <li>- +2.5 Sily Woli za 1 ap
    <li>- 0.5 do inteligencji (zamiast 2.5 inteligencji za 1 AP dostaje 2 punkty inteligencji)</li>
    <li>Premia do umiejetnosci atak oraz unik w wysokosci poziomu postaci</li>
    </ul>
    <form method=post action="klasa.php?klasa=mnich&step=wybierz">
    <input type="submit" value="Wybierz"><br>
    (<a href="klasa.php">Wroc</a>)
{/if}
