{if $View == ""}
   <b>*Podró¿ujac d³u¿szy czas zawêdrowa³es do mialego miasteczka nad potokiem nagle potraca cie jakis chlop ktory niesie mise ty spogladasz na niego zlowrogo a ten rzecze*<br></b> -Wybacz panie jednak sie bardfzo spiesze poniewaz me miejsce zostanie zajete<br>
-jakie miejsce<b>*pytasz zdezorientowany*<br></b>
-moje miejsce nad zlotym potokiem .. nie wiesz o co mi chodzi nigdy nie slyszales o zlotym potoku? no coz jest to wolno plynaca rzeczka ktora kryje w sobie niezwykle skarby.. a dokladniej zloto<b>*oczy wiesniaka sie zaswiecily*</b> wybacz ale sie spiesze <b>*odwrocil sie i pobiegl w strone strumienia i zniknal w chaszczach, postanawiasz sprawdzic czy to prawda tak tez idziesz takze w strone owej rzeczki, gdy przechoddzisz przez krzaki zauwazasz na brzrgach wielu ludzi ktorzy brodzac w wodzie dokladnie przeszukuja garnuszki w ktorych maja piasek, sam, ty podchodzisz do brzegu i spogladajac chwile w wode odbijajaca swiatlo sloneczne postanawiasz*</b>:<br><br>

    <center>
    <a href="potok.php?view=woda">Szukac z³ota</a><br>
    <a href="mapa.php">wrócic do podró¿y</a><br>
{/if}


{if $View == "woda"}
    No to zaczynasz prace masz mozliwosc znalezienia od {$G_min} do {$G_max} zlota.<br><br>
    <form method="post" action="potok.php?view=woda&action=woda">
    <input type="submit" value="Pracuj"> <input type="text" name="amount" value="1" size="5"> razy.</form>
{/if}
{if $Action == "woda"}
    Podczas przeszukiwania dna rzeki wykorzystales <b>{$Amount}</b> punkt(ow) energii, przeszukiwales <b>{$Amount}</b> razy i znalazles <b>{$Gain}</b> zlota.
    <br>[<a href="potok.php">Wroc</a>]
{/if}
