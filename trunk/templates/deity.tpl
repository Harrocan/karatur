{if $Deity == ""}
    Tutaj mozesz wybrac wyznanie swojej postaci. Kazde bostwo ofiarowuje swym wyznawcom inne rzeczy. Zastanow sie dobrze, poniewaz
    pozniej nie bedziesz juz mogl zmienic swojego wyznania.<br><br>
    <u>Panteon dobrych bogow:</u><br>
    - <a href="deity.php?deity=lathander">Lathander</a><br>
    - <a href="deity.php?deity=tempus">Tempus</a><br>
    - <a href="deity.php?deity=selune">Selune</a><br>
    - <a href="deity.php?deity=tyr">Tyr</a><br><br>
    <u>Panteon zlych bogow:</u><br>
    - <a href="deity.php?deity=bane">Bane</a><br>
    - <a href="deity.php?deity=lolth">Lolth</a><br>
    - <a href="deity.php?deity=maska">Maska</a><br>
    - <a href="deity.php?deity=shar">Shar</a><br>
    - <a href="deity.php?deity=talos">Talos</a><br>
{/if}

{if $Deity == "lathander" && $Pldeity == ""}
    Lathander jest poteznym, tryskajacym energia bostwem, popularnym wsrod plebjuszy. Czasami pozwala sobie na wybryki,
     nadmierny entuzjazm oraz proznosc, ale mimo to pozostaje optymistycznym i wytrwalym bostwem, blogoslawiacym swoje slugi,
     niszczacym nieumarlych swym buzdyganem <u>Piewca Poranka</u>. Lathander to bog pelen energii, ktory lubi wybryki.
     <br>
     Dogmat:
     Staraj sie zwsze pomagac, dawac nadzieje, krzewic nowe idee i walczyc o powodzenie dla calej ludzkosci oraz jej sojusznikow.
      Twym swietym obowiazkiem jest dbac o wszystkie istoty zywe, od robakow i roslin, po smoki i gigantow. Doskonal siebie i badz
       <b>plodny</b> w kwestiach caiala i umyslu. Gdzie tylko sie udasz, rozsiewaj nasiona nadziei, nowych idei i planow. Przedstawiaj
        wszystkim ich przyszlosc w rozowych barwach. Obserwuj kazdy wschod slonca. Rozwazaj wszystkie twe uczynki. Unikaj wszelkego zla,
         maja przy tym na uwadze, ze ze smierci rodzi sie zycie. Wiekszy nacisk kladz na pomaganie innym niz na poslszenstwo regulom.
    <form method="post" action="deity.php?deity=lathander&step=wybierz">
    <input type="submit" value="Wybierz"><br>
    (<a href="deity.php">Wroc</a>)
{/if}

{if $Deity == "tempus" && $Pldeity == ""}
    Tempus losowo przyznaje swoje laski, lecz chaotyczna natura nakazuje mu wspierac po rowno wszystkie strony. W trakcie starc Tempus
     jest potezny  i honorowy oraz wierny jedynie swemu kodeksowi wojownika. Nie dba o dlugotrwale sojusze. Nigdy nie zdarzylo sie, by
     ktos byl swiadkiem jego przemowy- zawsze wykorzystuje w tym celu posrednikow, czyli duchy zabitych wojownikow.
     <br>
     Dogmat: Uzbroj wszytskich, ktorzy chca starcia, nawet wrogow. Wycofuj sie z beznadziejnych walk, lecz nigdy nie unikaj bitwy.
     Przeciwnikow zbijiaj stanowczo, a zbrojne starcia koncz szybko, bowiem powolne wyczerpywanie sil i przeciaganie wzajemnej wrogosci
      nie ma sensu. Pamietaj o zmarlych, ktorzy polegli, ktorzy polegli przed toba.
    <form method="post" action="deity.php?deity=tempus&step=wybierz">
    <input type="submit" value="Wybierz"><br>
    (<a href="deity.php">Wroc</a>)
{/if}

{if $Deity == "selune" && $Pldeity == ""}
Bogini ksiezyca, nawigacji, podroznikow, gwiazd a takze dobrych i neutralnych likantropow; czczona przez likantropy, wladajace magia kobiety,
 nawigatorow, mnichow, zeglarzy. Jej symbolem jest para kobiecych oczu otoczona 7 gwiazdami. To troskliwe, ciche i tajemnicze bostwo Jest
  spokojna i lagdona, czesto wydaje sie zasmucona. Z typowym do niej zachowaniem kontrastuja zaciekle walki z jej arcywrogiem- siostra Shar.
   Owe bitwy rozciagaja sie po niebiosach i innych planach Selune przybiera wiele form, odzwierciedlaja oblcze ksiezyca.
  <br>
  Dogmat:
  Pamietaj, ze zycie jest jak srebrny ksiezyc, to sie rozrasta, to kurczy. Ufaj blaskowi Selune i wiedz, ze kazda milosc ozywa w swietle ksiezyca.
  Zwroc sie ku ksiezycowi, a bedzie ontwym prawdziwym przewodnikiem. Namawiaj do akceptacji i tolerancji. Postrzegaj wszytskie istity rownym sobie.
   Pomagaj innym wyznawcom Selune, jakby byli twoimi najdrozszymi przyjaciolmi.
    <form method="post" action="deity.php?deity=selune&step=wybierz">
    <input type="submit" value="Wybierz"><br>
    (<a href="deity.php">Wroc</a>)
{/if}

{if $Deity == "mystra" && $Pldeity == ""}
Mystra to pracowita i konsekwentna bogini. To ona jest odpowiedzialna za magie w krainie. Mozna nawet rzec, ze Mystra jest magia.
 To jednak takze bogini mozliwosci- jakie oferuje magia, przez co nalezy do najpotezniejszych istot zaangazowanych w zycie Kara-Tur.
  Mimo, ze potrafilaby zapobiegac powstawaniu nowych magicznych przedmiotow, rzadko korzysta z tej mozliwosci,
  chyba ze zagraza to magii jako takiej.
  <br>
  Dogmat:
  Kochaj magie za to, ze jest. Nie traktuj jej jako broni do przeksztalcania swiata, by odpowiadal twoim potrzebom.
  Prawdziwie madry jest ten, ktory wie kiedy nie korzystac z magii. Staraj sie zatem po nia siegac rzadziej, im wieksza masz moc,
   albowiem grozba lub obietnica zda sie na wiecej niz czarodziejski akt. Magia jest Sztuka, Darem Pani, a wladajacy nia
   sa niezwykle uprzywilejowani. Musisz zatem zyc spokojnie, nie ujawniac dumy i zawsze miec wspomniane na uwadze. Sztuki zas uzwyaj
    umiejetnie i skutecznie, nie zas beztrsosko i nieostroznie. Zawsze staraj sie uczyc magi i tworzyc nowa.
    <form method="post" action="deity.php?deity=mystra&step=wybierz">
    <input type="submit" value="Wybierz"><br>
    (<a href="deity.php">Wroc</a>)
{/if}

{if $Deity == "tyr" && $Pldeity == ""}
Tyr jest szlachetnym patronem wszytskich rzemieslnikow i sedziow- silnym duchem i oddanym sprawiedliwosci. Mieszkancy powszechnie postrzegaja ja jako osobe
 ojcowska, ktora w kontaktch z innymi dowodzi milosci, odwagi oraz  wiezow rodzinnych. Mimo to uznaje sie go za stanowczego i sprawiedliwego sedziego.
 <br>
 Dogmat:
 Ujawniaj prawde, karz winnych, prostuj sciezki bladzacych i zawsze postepuj uczciwie. Przestrzegaj prawa, gdziekolwiek sie udasz, i karz tych, ktorzy
 je lamia. Zachowaj w pamieci lub zapisuj wlasne orzeczeniam czyny i decyzje, poniewaz dzieki nim bedziesz mogl naprawiac bledy. Wywieraj zemste na winnych,
  jesli nie moga tego uczynic skrzywdzeni.
    <form method="post" action="deity.php?deity=tyr&step=wybierz">
    <input type="submit" value="Wybierz"><br>
    (<a href="deity.php">Wroc</a>)
{/if}

{if $Deity == "bane" && $Pldeity == ""}
    Bane to straszliwy tyran. Jest do szpiku kosci zly, plawi sie w nienawisci i sporach. Poniewaz jego potega ciagle sie rozwija,
     rzadko dziala bezposrednio, woli bowiem spiskowac, opzostajac w cieniu i niszczyc z oddali. Pragnie kontrolowac caly swiat, opanowac
      lub wchlonac inne bostwa. Bane jest nowopowstalym bogiem nienawisci, tyrani, zla i zniszczenia.Wyznawcow Bane`a, podobnie jak ich
      boga czesciej mozna spotkac na polu bitwy niz w swiatyni. Bane jest panem wojny,
    miluje swych wyznawcow przede wszytkim za walecznosc oraz odwage, gardzi tchorzami. Poszczegolnym rasom jawi sie jako mezczyzna
    odziany w potezna, wspaniale zdobiona zbroje (wsrod Ludzi oraz Krasnoludow) lub jako tajemniczy, smukly mezczyzna odziany w
    plaszcz tropicieli uzbrojony w bojowy luk (wsrod elfow). Swych wyznawcow wspiera darowujac im przede wszytkim sily oraz
    umiejetnosci do walki. Jego symbolem sa skrzyzowany miecz oraz strzala
      <br>
      Dogmat: Nie sluz nikomu poza Bane`em. Zawsze sie go lekaj i spraw, by inni lekali sie go bardziej niz ty sam. Czarna Dlon zmiazdzy
      w koncu kazdego, kto sie jej przeciwstawi. Jesli staniesz po innej niz Bane stronie, zginiesz, a w smierci zapewne odnajdziesz lojalnosc
      wzgledem niego, poniewaz on ja wymusi. Poddaj sie slowu Bane`a, ktore slyszysz z ust jego kaplanow, gdyz prawdzia moc zyskc mozna sluzac
      tylko mu. Zawsze rozsiewaj mroczny strach przed Bane`em. Pamietaj przy tym, ze utrata wladzy oznacza zaglade dla tych, ktorzy na to pozwalaja.
      Wiedz, ze tych, ktorzy rozgniewaja Bane`a, czeka bolesna zaglada wczesniej, niz czcicieli innych bostw.
    <form method="post" action="deity.php?deity=bane&step=wybierz">
    <input type="submit" value="Wybierz"><br>
    (<a href="deity.php">Wroc</a>)
{/if}

{if $Deity == "lolth" && $Pldeity == ""}
Lolth jest okrutnym, kaprysnym bostwem, przez wielu uwazanym za oblakane, poniewaz zacheca wlasnych wyznawcow do walki pomiedzy soba.
 W kontaktach z innymi okazuje zlosliwosc, a w trakcie walki objawia wsciekly chlod. Pozada wladzy, ktora posiadaja bostwa czczone
  przez rasy powierzchni. Potrafi byc uprzejma i pomagac tym, ktorych faworyzuje, lecz zywi sie smiercia, zniszczeniem, oraz torturami
   wszytskich istot- takze wlasnych wyznawcow, ktorzy jej nie zadowolili.
      <br>
  Dogmat:
  Strach jest twardy, niczym stal, milosc i szacunek- slabe i bezuzyteczne. Nawroc lub zniszcz niewiernego sluge.
   Wykorzystaj chwasty, jakimi sa slabi i zbuntowani. Niszcz tych, ktorzy poddaja wiare w watpliwosci.
   Poswiecaj mezczyzn, niewolnikow i tych przedstawicieli innych ras, ktorzy ignoruja rozkazy Lolth lub jej kaplanek.
   Wychowuj dzieci tak, by chwalili boginie i baly sie jej. Pamietaj tez, ze kazda rodzina powinna wydac na swiat przynajmniej jedna kaplanke.
   Kwestionowanie pobudek Lolth lub jej madrosci jest grzechem, tak samo jak zdrada, albo ignorowanie rozkazow bogini dla ratowania kochanka.
    Czcij wszystkie pajeczaki. Wiedz tez, ze ci, ktorzy zabijaja lub znecaja sie nad pajakami musza umrzec.
   <form method="post" action="deity.php?deity=lolth&step=wybierz">
    <input type="submit" value="Wybierz"><br>
    (<a href="deity.php">Wroc</a>)
{/if}

{if $Deity == "maska" && $Pldeity == ""}
Maska jest opiekunem zlodziei. Jest opanowanym i pewnym siebie bostwem, ktore chetnie tworzy skomplikowane plany i zawile intrygi.
 Ostatnio jednak stal sie znacznie bardziej despotyczny, bezposredni, gdyz w wyniku wlasnych knowan stracil wiele ze swoich mocy.
Maska jest ostrozny i chlodny. Zawsze zdaje sie rowniez miec na podredziu jakis kpiarski komentarz. Jego miecz, <u>Skryty Szept</u>,
 nie powoduje zadnych dzwiekow.
      <br>
  Dogmat:
  Cokolwiek wydarzy sie w mroku- jest w zasiegu Maski. Swiat nalezy do tych, ktorzy sa szybcy, mowia ze swada i maja zwinne palce.
   Ostroznosc i skrytosc sa cnotami, tak samo jak gibkosc i latwosc mowienia jednej rzeczy, a myslenia o innym.
   Bogactwo slusznie nalezy do tych, ktorzy potrafia je zdobyc. Staraj sie zakonczyc kazdy dzien z wiekszym majatkiem, niz go zaczales.
    Uczciwosc jest dla glupcow lecz warto zachowac jej pozory. Staraj sie, by kazde twe klamstwo bylo prawdopodobne, i nigdy nie oszukuj,
     gdy mozesz powiedziec prawde.Pozostawi tylko mylne wrazenie. Pamietaj, ze liczy sie przede wszystkim subtelnosc.
     Nigdy nie czyn niczego, co oczywiste. Ufaj cieniom, albowiem oswietlona sciezka czyni z ciebie latwy cel.
   <form method="post" action="deity.php?deity=maska&step=wybierz">
    <input type="submit" value="Wybierz"><br>
    (<a href="deity.php">Wroc</a>)
{/if}

{if $Deity == "shar" && $Pldeity == ""}
Shar jest zla, wypaczona istota, pelna nienawsci. Moze widziec kazda istote, czyn wykonany w ciemnsci, wlada zas bolem ukrytym.
 lecz nie zapomnianym, starannie pielegnowana gorycza oraz cicha zemsta za drobne przewinienia.
 Wiele sil poswieca na odwieczna walke ze swoja nemezis- siostra Selune, w wojnie starszej niz zapisana historia.
      <br>
  Dogmat:
  Sekrety ujawniaj tylko innym wiernym. Nigdy nie ludz sie nadzieja, ani nie licz na obietnice sukcesu. Gas swiatlo ksiezyca.
   Ciemnosci to czas dzialania, nie oczekiwania. Nie masz prawa starac sie o poprawe swego losu ani planowac przyszlosci
    -z wyjatkiem objawien doswiadczonych przez wiernych Mrocznej Bogini. Zadawanie sie z wyznawcanmi dobrych bostw jest grzechem,
     chyba ze w ten sposob zachecasz ich do wiary w Shar. Badz poslyszny nawet szeregowym kaplanom- w przeciwnym razie bedzie
      to oznaczac twoja smierc.
   <form method="post" action="deity.php?deity=shar&step=wybierz">
    <input type="submit" value="Wybierz"><br>
    (<a href="deity.php">Wroc</a>)
{/if}

{if $Deity == "talos" && $Pldeity == ""}
Talos uosabia destrukcyjny szal natury, patron barbarzyncow. Jest gniewnym, pelnym wscieklosci bogiem,
 ktory kieruje sie impulsami i czesto dziala tak tylko dlatego, by nikt nie uznal go za slabego czy sklonnego do kompromisow.
  Chlubi sie niepohamowana destrukcja, i w wielu aspektach jest niczym rozjuszony osilek o ogromnej mocy i gwaltownym temperamencie,
   ktory dowodzi wlasnej wartosci, miazdzac slabych i bezbronnych.
      <br>
  Dogmat:
  Zycie to mieszanina przypadkowych zdarzen i czystego chaosu, chwytaj tedy to, co tylko mozesz i kiedy tylko mozesz,
   poniewaz Taos w kazdej chwili ma prawo przeniesc cie z zycia do smierci. Nauczaj o jego potedze i zawsze ostrzegaj przed mocami,
   ktorym jedynie on moze rozkazywac. Nie lekaj sie wedrowac w trakcie burz, przez pozary lasow, trzesienia ziemi
   i inne katastrofy, bo chroni cie moc Talosa. Spraw by inni lekai sie go przede wszytskim ze znisczen,
   jakich moze dokonac on i jego slugi. Niech ci, ktorzy szydza i nie dowierzaja wiedza, iz jedynie zarliwa modlitwa ma
   szanse ich ocalic.
   <form method="post" action="deity.php?deity=talos&step=wybierz">
    <input type="submit" value="Wybierz"><br>
    (<a href="deity.php">Wroc</a>)
{/if}


{if $Step == "wybierz" && $Pldeity == ""}
    <br>Wybrales wiare w {$God}. Kliknij <a href=stats.php>tutaj</a> aby wrocic.
{/if}

