{if $Dziwka == ""}
    Szedles przez ulice gdy nagle zobaczyles duzy budynek stojacy przy rogu dwoch ulic. Na budynku pisalo "Madame Maxima zaprasza do Domu Towarzyskiego". Kiedy wszedles zobaczyles duzy hol pelen mezczyzn i skapo ubranych pieknych kobiet.Nagle podeszla do ciebie  przysadzista dama i powiedziala : Witaj w Domu Towarzyskim - i podala oferty :<br><br>
<center><b>Dla Panow</b></center><br><br>
   <center>- <a href="burdel.php?dziwka=eilena">Eilena</a><br><br></center>
   <center> - <a href="burdel.php?dziwka=kasandra">Kasandra</a><br><br><br></center>
<center><b>Dla Pan</b></center><br><br>
    <center>- <a href="burdel.php?dziwka=length">Length</a><br><br></center>
    <center>- <a href="burdel.php?dziwka=anarion">Anarion</a><br><br><br></center>


Cena zalezy od waszego poziomu w koncu im wieksze miesnie tym wiecej potrzebuja uwagi.
   


 {/if}


{if $Dziwka == "eilena"}
    Eilena : Niska, szczupla blondynka. Zaplacisz jej : {$Cost} za co twa energia wzorsnie o 3.
<br><br><br>
    <center><form method="post" action="burdel.php?dziwka=eilena&step=wybierz">
    <input type="submit" value="Przespij sie"><br><br><br>
    (<a href="burdel.php">Wroc</a>)
{/if}

{if $Dziwka == "kasandra"}
    Kasandra : Wysoka, szczupla, o ciemnych wlosach i bladej cerze. Zaplacisz jej : {$Cost2} za co twa energia wzorsnie o 5.
<br><br><br>
    <center><form method="post" action="burdel.php?dziwka=kasandra&step=wybierz">
    <input type="submit" value="Przespij sie"><br><br><br>
    (<a href="burdel.php">Wroc</a>)
{/if}

{if $Dziwka == "length"}
    Length : Szczuply elf o dlugich wlosach. Zaplacisz mu : {$Cost3} za co twa energia wzorsnie o 3.
<br><br>
    <center><form method="post" action="burdel.php?dziwka=length&step=wybierz">
    <input type="submit" value="Przespij sie"><br><br><br>
    (<a href="burdel.php">Wroc</a>)
{/if}

{if $Dziwka == "anarion"}
    Anarion : mlody chlopaczek z poludniowych rownin. Zaplacisz mu : {$Cost4} za co twa energia wzorsnie o 5.
<br><br>
    <center><form method="post" action="burdel.php?dziwka=anarion&step=wybierz">
    <input type="submit" value="Przespij sie"><br><br><br>
    (<a href="burdel.php">Wroc</a>)
{/if}

{if $Step == "wybierz"}
    <br>Wybrales piekna  {$dziwka}. Spedziliscie upojne chwile dzieki czemu twoja energia wzrosla.
{/if}
<br><br><a href="Wir.php">Wroc</a><br>

