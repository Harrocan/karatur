<center><img src="stajnia.jpg"/></center><br />
{if $Action == "" && $Location == "Altara"}
	Witaj w Stajniach. Stad mozesz wyruszyc do innych miejsc swiata Vallheru.<br>
	<ul>
	<li><a href="travel.php?akcja=gory">Gory Kazad-nar (koszt 200 sztuk zlota)</a></li>
	<li><a href="travel.php?akcja=las">Las Avantiel (koszt 100 sztuk zlota)</a></li>
	<li><a href="travel.php?akcja=dolina">Dolina Mroku (koszt 100 sztuk zlota)</a></li>
	<li><a href="travel.php?akcja=Cormanthor">Miasto Cormanthor(koszt 800 sztuk zlota)</a></li>
	</ul>
    {if $Maps == "1"}
        Nieco na uboczu dostrzegasz dziwnego starca przygladajacego sie tobie z ciekawoscia. Kiedy zauwaza ze mu sie przygladasz, daje znak reka 
        abys podszedl do niego. Obaj odchodzicie ze stajni w niewielka boczna uliczke Altary. Kiedy zatrzymujecie sie starzec cichym glosem mowi: 
        <i> Wyczuwam, iz chcesz wyruszyc na wyprawe po skarby dawno zaginione. Wiem ze masz przy sobie odpowiednia rzecz, ktora pozwoli Ci znalezc 
        rzeczy Pierwszych. Jezeli chcesz moge cie przeniesc w odpowiednie miejsce. Lecz uwazaj - skarbow strzeze niebezpieczne istota pozostawiona 
        tam przez wlascicieli. Czy chcesz wyruszyc w to miejsce?<br>
        - <a href="travel.php?akcja=tak">Tak</a><br>
        - <a href="travel.php?akcja=nie">Nie</a><br>
    {/if}
{/if}

{if $Portal == "Y"}
    Starzec zamyka oczy i bezglosnie zaczyna wymawiac jakies zaklecie, kreslac rekami w powietrzu dziwne wzory. Nagle tuz przed toba otwiera 
    sie zielony portal. Starzec patrzy na ciebie i mowi: <i>Ruszaj wiec po swoje przeznaczenie i niech szczescie ci sprzyja.</i> Niepewnie 
    przechodzisz przez <a href="portal.php">portal</a>
{/if}

{if $Portal == "N"}
    Starzec patrzy na ciebie przez chwile i odpowiada: <i>Dobrze wiec, jezeli bedziesz chcial wyruszyc na poszukiwania przybadz w to samo 
    miejsce gdzie spotkalismy sie za pierwszym razem. Bede tam na ciebie czekal.</i> Po tych slowach odchodzi. Ty natomiast wracasz do 
    <a href="city.php">miasta</a>
{/if}

{if $Action == "" && $Location == "Gory"}
    Witaj w Stajniach. Mo¿esz wróciæ do Altary, wêdrowaæ dalej do Dornland b±d¼ zboczyæ do Doliny Mroku.Mo¿esz tak¿e wyruszyæ prosto do Cormanthoru<br>
    <ul>
    <li><a href="travel.php?akcja=dornland">Krasnoludzkie miasto Dornland (koszt 300 sztuk zlota)</a></li>
    <li><a href="travel.php?akcja=powrot">Wroc do Altary (koszt 200 sztuk zlota)</a></li>
    <li><a href="travel.php?akcja=dolina">Dolina Mroku (koszt 200 sztuk zlota)</a></li>
	<li><a href="travel.php?akcja=Cormanthor">Miasto Cormanthor(koszt 600 sztuk zlota)</a></li>
    </ul>
{/if}
{if $Action == "" && $Location == "Dornland"}
    Witaj w Stajniach. Mo¿esz wróciæ do Gór Kazad-Nar<br>
    <ul>
    <li><a href="travel.php?akcja=gory">Góry Kazad-Nar (koszt 300 sztuk zlota)</a></li>
    </ul>
{/if}
{if $Action == "" && $Location == "Dolina"}
    Witaj w Stajniach. Mo¿esz wróciæ do Altary lub podró¿owaæ dalej do Kazad-Nar<br>
    <ul>
    <li><a href="travel.php?akcja=powrot">Wroc do Altary (koszt 100 sztuk zlota)</a></li>
    <li><a href="travel.php?akcja=gory">Góry Kazad-Nar (koszt 200 sztuk zlota)</a></li>
    </ul>
{/if}
{if $Action == "" && $Location == "Las"}
    Witaj w Stajniach. Mo¿esz wróciæ do Altary lub podró¿owaæ dalej do Wiru. Mo¿esz tak¿e odbiæ na pó³noc do Cormanthoru<br>
    <ul>
    <li><a href="travel.php?akcja=powrot">Wroc do Altary (koszt 100 sztuk zlota)</a></li>
    <li><a href="travel.php?akcja=Wir">miasto Wir (koszt 200 sztuk zlota)</a></li>
    <li><a href="travel.php?akcja=Cormanthor">Miasto Cormanthor(koszt 600 sztuk zlota)</a></li>
    </ul>
{/if}
{if $Action == "" && $Location == "Wir"}
    Witaj w Stajniach. Mo¿esz wróciæ przez las do Altary lub podró¿owaæ dalej na wyspê<br>
    <ul>
    <li><a href="travel.php?akcja=las">Podró¿uj przez las (koszt 200 sztuk zlota)</a></li>
    </ul>
{/if}
{if $Action == "" && $Location == "Cormanthor"}
    Witaj w Stajniach. Mo¿esz wróciæ przez las do Altary lub podró¿owaæ dalej na wyspê<br>
    <ul>
    <li><a href="travel.php?akcja=las">Podró¿uj do lasu (koszt 600 sztuk zlota)</a></li>
    <li><a href="travel.php?akcja=powrot">Wróæ do Altary (koszt 800 sztuk zlota)</a></li>
    <li><a href="travel.php?akcja=gory">Podró¿uj do Kazad-Nar (koszt 600 sztuk zlota)</a></li>
    </ul>
{/if}

{if $Action == "" && $Location == "Podroz"}
    Witaj w Stajniach. Tedy mozesz wrocic do stolicy Kara-Tur, Altary.<br>
    - <a href="travel.php?akcja=powrot">Wroc do Altary (koszt 500 sztuk zlota)</a>
{/if}
