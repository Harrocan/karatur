Idac jedna z alei miasta, trafiasz na solidny budynek z litego marmuru. Podchodzisz blizej i czytasz wiszacy na nim szyld na ktorym widnieje napis "<i>Baszta Najemnikow</i>". Zaciekawiony wchodzisz do srodka i zauwazasz grupe mieszkancow wsrod ktorych rozpoznajesz glownie kupcow chociaz sa tez rzemieslnicy i zwykli mieszkancy. Dalej w glebi budynku zauwazasz kilkunastu poteznie zbudowanych najemnikow. Spogladajac na nich zauwarzasz, iz sa uzbrojeni po zeby. Jedni w miecze, drudzy w luki. Przedzierajac sie przez tlum mieszkancow docierasz wkoncu do biurka przy ktorym zasiada ich przywodca.<br>-<i> Witam, co sie tutaj dzieje ?</i> - pytasz<br>-<i> Znajdujesz sie w Baszcie Najemnikow, za pewna oplata mozesz u nas wynajac osobistego ochroniarza. W zaleznosci od zaplaconej kwoty bedziesz pod nasza ochrona. Zaciekawiony ?</i> - Najemnik pyta i spoglada na ciebie<br>-<i> Jasne</i> - odpowiadasz i zaczynasz czytac liste najemnikow...
<ul>
<li><a href="baszta.php?view=immu1">Ochrona Godzinna</a></li>
<li><a href="baszta.php?view=immu3">Ochrona Calodniowa</a></li>
</ul><br><br><br><i>Koszt wynajecia ochroniarza to 10000 x twoj poziom</i><br><br><br><br>
<i></i>


{if $View == "immu1"}
Ochrona Godzinna - Dostaniesz jednego z moich ludzi ktory przez godzine bedzie cie chronil.<br><br>
- <a href="baszta.php?view=immu1&step=yes">Tak</a><br>
- <a href="baszta.php">Nie</a><br>
{if $Step == "yes"}
Od tej chwili jestes calkowicie bezpieczny. Moi ludzie beda cie chronic przez pewien czas. Wejdz <a href="baszta.php">tutaj</a> aby wrocic do baszty.
{/if}
{/if}
{if $View == "immu3"}
Ochrona Calodniowa - Placa troche wiecej moi ludzie beda cie chronic przez caly dzien.<br><br>
- <a href="baszta.php?view=immu1&step=yes">Tak</a><br>
- <a href="baszta.php">Nie</a><br>
{if $Step == "yes"}
Od tej chwili jestes calkowicie bezpieczny. Moi ludzie beda cie chronic przez pewien czas. Wejdz <a href="baszta.php">tutaj</a> aby wrocic do baszty.<br><br>
{/if} {/if}

by <i>Neverland Team</i>
