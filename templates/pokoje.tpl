{if $pokoj == ""}
    Witaj przyjacielu w mej karczmie ...widze ze jestes zmeczony, zapewne miales dluga i wyczerpujaca podroz ...prosze spocznij tutaj w karczmie w jednym z moich pokoi goscinnych. 
Prosze oto oferty:
     :<br><br>
   <center> - <a href="hotel.php?pokoj=maly">Pokoj Maly</a><br><br></center>
   <center>- <a href="hotel.php?pokoj=sredni">Pokoj Sredni</a><br><br></center>
   <center> - <a href="hotel.php?pokoj=duzy">Pokoj Duzy</a><br><br><br></center>

   


 {/if}

{if $Pokoj == "maly" && $opis == ""}
    Oto jedna z naszych ofert.Maly Pokoj!Wybierajac ten pokoj wyspisz sie tu i zaplacisz : {$Cost} za co twa energia wzorsnie o 0.5.
<br><br><br>
    <center><form method="post" action="hotel.php?pokoj=maly&step=wybierz">
    <input type="submit" value="Przespij sie"><br><br><br>
    (<a href="hotel.php">Wroc</a>)
{/if}

{if $Pokoj == "sredni" && $opis == ""}
Oto jedna z naszych ofert.Sredni Pokoj!Wybierajac ten pokoj wyspisz sie tu i zaplacisz : {$Cost2} za co twa energia wzorsnie o 1.
<br><br><br>
    <center><form method="post" action="hotel.php?pokoj=sredni&step=wybierz">
    <input type="submit" value="Przespij sie"><br><br><br>
    (<a href="hotel.php">Wroc</a>)
{/if}

{if $Pokoj == "duzy" && $opis == ""}
Oto jedna z naszych ofert.Duzy Pokoj!Wybierajac ten pokoj wyspisz sie tu i zaplacisz : {$Cost3} za co twa energia wzorsnie o 1.5.
<br><br><br>
    <center><form method="post" action="hotel.php?pokoj=duzy&step=wybierz">
    <input type="submit" value="Przespij sie"><br><br><br>
    (<a href="hotel.php">Wroc</a>)
{/if}


{if $Step == "wybierz" && $opis == ""}
    <br>Wybrales piekny {$pokoj}. Bardzo sie wyspales przez co twoja energia wzrosla.
{/if}

