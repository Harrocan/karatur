    Znajdujesz sie przed wielka plantacja ziemniakow. Sa to ogromne hektary pol, pare budynkow i mnostwo robotnikow w pocie czola wykopuje plony z ziemi. Podchodzi do Ciebie jeden z farmerow i sie pyta: "Co chcialbys tu robic?" Ty zas odpowiadasz:<br><br>
    <ul>
    <li><a href="ziemniaki.php?action=kop">Chce pokopac ziemniaki</a></li>
    </ul>
{if $Action == "kop"}
    Zeby kopac ziemniaki wpisz ile czasu (energii) poswiecisz na ta czynnosc. <br><br>
    <form method="post" action="ziemniaki.php?action=kop&dalej=tak">
    Chce pracowac <input type="text" size="3" value="0" name="rep"> razy. <input type="submit" value="Pracuj">
    </form>
{/if}
{$Message}


