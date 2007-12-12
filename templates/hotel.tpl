{if $Pokoj == ""}
    <br>Zwiedzajac miasto zrobiles sie senny i postanowiles odpoczac jednak karczma byla zbyt daleko, rozgladajac sie za jakims spokojnym miejscem na drzemke zauwazasz w oddali duzy dreniany budynek na ktorym widnieje ogromna tablica <i>"Hotel Pod Cichym Ostrzem"</i> nie namyslajac sie zbyt dlugo poszedles w strone budynku kierowany checia odpoczynku. Po wejsciu do budynku zauwazasz gnoma w podeszlym wieku z lysina na glowie, ktory podszedl do ciebie i z usmiechem na ustach zekl:<br><br><i>Witaj przyjacielu w moim hotelu, mam nadzieje ze spodoba ci sie tutaj i bedziesz czestym gosciem... A WLASNIE! Musze cie ostrzec przyjacielu przed karczma ta w miescie, maja tam co prawda takie same ceny ale ten stary glupiec nie dba tak dobrze o pokoje jak ja ...hehe prosze wejdz i zobacz oferty i przekonaj sie sam</i><br><br>Hotelarz zaciera swe dlonie po czym pokazuje ci liste pokoi
     :<br><br>
   <center> - <a href="hotel.php?pokoj=maly">Pokoj Maly</a><br><br></center>
   <center>- <a href="hotel.php?pokoj=sredni">Pokoj Sredni</a><br><br></center>
   <center> - <a href="hotel.php?pokoj=duzy">Pokoj Duzy</a><br><br><br></center>

   


 {/if}

{if $Pokoj == "maly"}
    Oto jedna z naszych ofert.Maly Pokoj!Wybierajac ten pokoj wyspisz sie tu i zaplacisz : {$Cost} za co twa energia wzorsnie o 0.5.
<br><br><br>
    <center><form method="post" action="hotel.php?pokoj=maly&step=wybierz">
    <input type="submit" value="Przespij sie"><br><br><br>
    (<a href="hotel.php">Wroc</a>)
{/if}

{if $Pokoj == "sredni"}
Oto jedna z naszych ofert.Sredni Pokoj!Wybierajac ten pokoj wyspisz sie tu i zaplacisz : {$Cost2} za co twa energia wzorsnie o 1.
<br><br><br>
    <center><form method="post" action="hotel.php?pokoj=sredni&step=wybierz">
    <input type="submit" value="Przespij sie"><br><br><br>
    (<a href="hotel.php">Wroc</a>)
{/if}

{if $Pokoj == "duzy"}
Oto jedna z naszych ofert.Duzy Pokoj!Wybierajac ten pokoj wyspisz sie tu i zaplacisz : {$Cost3} za co twa energia wzorsnie o 1.5.
<br><br><br>
    <center><form method="post" action="hotel.php?pokoj=duzy&step=wybierz">
    <input type="submit" value="Przespij sie"><br><br><br>
    (<a href="hotel.php">Wroc</a>)
{/if}


{if $Step == "wybierz"}
    <br>Wybrales piekny {$pokoj}. Bardzo sie wyspales przez co twoja energia wzrosla.
{/if}

