{if $View == ""}
    Witaj w panelu administracyjnym. Co chcesz zrobic?
    <ul>
	<li><A href="addupdate.php">Dodac Wiesc</a>
	<li><A href="addnews.php">Dodac Plotke</a>
	<li><a href="zadmin.php?view=equipment">Dodac Ekwipunek</a>
	<li><a href="zadmin.php?view=bows">Dodac Luki i Strzaly</a>
	<li><a href="zadmin.php?view=cores">Dodac Chowance</a>
	<li><a href="zadmin.php?view=monster">Dodac Potwory</a>
	<li><a href="zadmin.php?view=kowal">Dodac Kowal</a>
	<li><a href="zadmin.php?view=czary">Dodac Czary</a>
    <li><a href="zadmin.php?view=magic">Dodac Magiczne przedmioty</a>
	<li><a href="zadmin.php?view=clearf">Wyczyscic Forum</a>
	<li><a href="zadmin.php?view=clearc">Wyczyscic Czat</a>
    <li><a href="zadmin.php?view=clearcl">Wyczyscic Logi</a>
    <li><a href="zadmin.php?view=clearcm">Wyczyscic Poczte</a>
    <li><a href="zadmin.php?view=clearcs">Wyczyscic Sad</a>
    <li><a href="zadmin.php?view=clearcw">Wyczyscic Wiesci</a>
	<li><a href="zadmin.php?view=clearck">Wyczyscic Wiesci Karczmarza</a>
	<li><a href="zadmin.php?view=takeaway">Zabrac sztuki zlota</a>
	<li><a href="zadmin.php?view=jail">Wyslij gracza do wiezienia</a>
	<li><a href="zadmin.php?view=jailw">Wyciag gracza z wiezienia</a>
	<li><a href="zadmin.php?view=tags">Dac Immunitet</a>
	<li><a href="zadmin.php?view=tagsz">Zdjac Immunitet</a>
	<li><a href="zadmin.php?view=poczta">Wyslij poczte do wszystkich</a>
	<li><a href="zadmin.php?view=czat">Zablokuj/odblokuj wiadomosci od gracza na czacie</a>
	<li><a href="zadmin.php?view=sad">Zablokuj/odblokuj wiadomosci od gracza w sadzie</a>
	<li><a href="zadmin.php?view=bridge">Dodaj pytanie na moscie smierci</a>
	<li><a href="zadmin.php?view=mail">Wyslij maila do wszystkich graczy</a>
	<li><a href="zadmin.php?view=close">Zablokuj/odblokuj gre</a>
    </ul>
{/if}

{if $View == "mail"}
    <form method="post" action="zadmin.php?view=mail&step=send">
    Tresc maila, jezeli chcesz zrobic nowa linie uzyj znacznika \n (backslash n) do tego celu<br>
    <textarea name="message" rows="1" cols="20"></textarea><br>
    <input type="submit" value="Wyslij"></form>
{/if}

{if $View == "bridge"}
    <form method="post" action="zadmin.php?view=bridge&step=add">
    Pytanie: <textarea name="question" rows="1" cols="20"></textarea><br>
    OdpowiedA: <textarea name="answer" rows="1" cols="20"></textarea><br>
    <input type="submit" value="Dodaj"></form>
{/if}

{if $View == "jail"}
    <form method="post" action="zadmin.php?view=jail&step=add">
    ID gracza: <input type="text" name="prisoner"><br>
    Przyczyna: <textarea name="verdict" rows="1" cols="20"></textarea><br>
    Czas (w dniach): <input type="text" name="time"><br>
    Kaucja za uwolnienie: <input type="text" name="cost"><br>
    <input type="submit" value="Dodaj"></form>
{/if}

{if $View == "jailw"}
    <form method="post" action="zadmin.php?view=jail&step=clear">
    ID gracza: <input type="text" name="prisonerw"><br>
    <input type="submit" value="Wyciag"></form>
{/if}

{if $View == "tags"}
    <form method="post" action="zadmin.php?view=tags&step=tag">
    Daj immunitet ID <input type="text" name="tag_id" size="5">. <input type="submit" value="Daj">
    </form>
{/if}

{if $View == "tagsz"}
    <form method="post" action="zadmin.php?view=tagsz&step=tagz">
    Zdejmij immunitet ID <input type="text" name="tag_id" size="5">. <input type="submit" value="Zdejmij">
    </form>
{/if}

{if $View == "equipment"}
    <form method="post" action="zadmin.php?view=equipment&step=add">
    Nazwa <input type="text" name="name"> jako
    <select name="type" id="type">
    <option value="W">bron</option>
    <option value="A">zbroja</option>
    <option value="H">helm</option>
    <option value="N">nagolenniki</option>
    <option value="D">tarcza</option>
    <option value="S">obraczke</option>
    <option value="Y">amulet</option>
    <option value="Q">pierscien</option>
    <option value="T">obraczke</option>
    <option value="L">naszyjnik</option>
    </select>
    <br> z
    <input name="power" type="number" id="power"> Sila<br>
    i Kosztujaca <input type="number" name="cost">
    <br> z minimalnym poziomem
    <input type="number" name="minlev"> z ograniczeniem zr (zbroja, nagolenniki oraz tarcza)
    <input name="zr" type="number"><br> dodajaca do szybkosci (bron tylko)
    <input type="number" name="szyb"><br>
    z wytrzymaloscia <input type="number" name="maxwt"><br>

<br />
<br />
    <input type="submit" value="Dodaj">
    </form>
{/if}

{if $View == "bows"}
    <form method="post" action="zadmin.php?view=bows&step=add">
    Nazwa <input type="text" name="name"> jako
    <select name="type" id="type">
    <option value="R">Strzaly</option>
    <option value="B">Luk</option></select>
    <br> z
    <input name="power" type="number" id="power"> Sila<br>
    i Kosztujaca <input type="number" name="cost">
    <br> z minimalnym poziomem
    <input type="number" name="minlev"><br>z ograniczeniem zr
    <input name="zr" type="number"><br> dodajaca do szybkosci
    <input type="number" name="szyb"><br>
    z wytrzymaloscia <input type="number" name="maxwt"><br>
	oraz
	<select name="twohand" id="twohand">
	<option value="Y">Dwureczna</option>
    <option value="N">Jednoreczna</option></select><br>
    <input type="submit" value="Dodaj">
    </form>
{/if}



{if $View == "cores"}
    <form method="post" action="zadmin.php?view=cores&step=add">
    Nazwa <input type="text" name="name"> jako
    <select name="type" id="type">
    <option value="Plant">Lesny</option>
    <option value="Aqua">Wodny</option>
    <option value="Material">Gorski</option>
    <option value="Element">Polny</option>
    <option value="Alien">Pustynny</option>
    <option value="Ancient">Magiczny</option>
    </select>
    <br> z Sila
    <input type="number" name="power"  > <br>
    i obrona <input type="number" name="defense">
    <br>
    z zadkoscia <input type="number" name="rarity"><br>
    Opis <input type="text" name="opis"><br>
	<input type="submit" value="Dodaj">
    </form>
{/if}

{if $View == "donate"}
    <form method="post" action="zadmin.php?view=donate&step=donated">
    ID: <input type="text" name="id"> <br>
    ilosc: <input type="text" name="amount">
    <input type="submit" value="Dotuj"></form>
{/if}

{if $View == "takeaway"}
    <form method="post" action="zadmin.php?view=takeaway&step=takenaway">
    ID: <input type="text" name="id"> <br>
    ilosc: <input type="text" name="taken">
    <input type="submit" value="Zabierz"></form>
{/if}

{if $View == "monster"}
    <form method="post" action="zadmin.php?view=monster&step=monster">
    Nazwa: <input type="text" name="nazwa"> <br>
    Poziom: <input type="text" name="poziom"> <br>
    PZ: <input type="text" name="pz"> <br>
    Zrecznosc: <input type="text" name="zr"> <br>
    Sila: <input type="text" name="sila"> <br>
    Szybkosc: <input type="text" name="speed"> <br>
    Wytrzymalosc: <input type="text" name="endurance"> <br>
    Min zlota: <input type="text" name="minzl"> <br>
    Max zlota: <input type="text" name="maxzl"> <br>
    Min PD: <input type="text" name="minpd"> <br>
    Max PD: <input type="text" name="maxpd"> <br>
    <input type="submit" value="Dodaj"></form>
{/if}

{if $View == "kowal"}
    <form method="post" action="zadmin.php?view=kowal&step=kowal">
    Nazwa: <input type="text" name="nazwa"> <br>
    Cena: <input type="text" name="cena"> <br>
    Zelazo: <input type="text" name="zelazo"> <br>
    Wegiel: <input type="text" name="wegiel"> <br>
    Braz: <input type="text" name="bronz"> <br>
    Mithril: <input type="text" name="mithril"> <br>
    Adamantium: <input type="text" name="adam"> <br>
    Meteor: <input type="text" name="meteo"> <br>
    Krysztal: <input type="text" name="krysztal"> <br>
    Poziom: <input type="text" name="poziom"> <br>
    Typ: <select name="type" id="type">
    <option value="W">bron</option>
    <option value="A">zbroja</option>
    <option value="H">helm</option>
    <option value="N">nagolenniki</option>
    <option value="D">tarcza</option>
    </select>
    <br><input type="submit" value="Dodaj"></form>
{/if}

{if $View == "poczta"}
    <table>
    <form method="post" action="zadmin.php?view=poczta&step=send">
    <tr><td>Temat:</td><td><input type="text" name="subject"></td></tr>
    <tr><td valign="top">Tresc:</td><td><textarea name="body" rows="5" cols="19"></textarea></td></tr>
    <tr><td colspan="2" align="center"><input type="submit" value="Wyslij"></td></tr>
    </form></table>
{/if}

{if $View == "czat"}
    Lista zablokowanych<br>
    {section name=player loop=$List1}
        ID {$List1[player]}<br>
    {/section}
    <form method="post" action="zadmin.php?view=czat&step=czat">
    <select name="czat"><option value="blok">Zablokuj</option>
    <option value="odblok">Odblokuj</option></select>
    ID <input type="text" name="czat_id" size="5">.
    <input type="submit" value="Zrob"></form>
{/if}

{if $View == "sad"}
    Lista odblokowanych<br>
    {section name=player loop=$List1}
        ID {$List1[player]}<br>
    {/section}
    <form method="post" action="zadmin.php?view=sad&step=sad">
    Dodaj ID <input type="text" name="aid"> jako
    <select name="rank">
    <option value="O">Oskarzony</option>
    <option value="T">Odblokuj w sadzie</option>
    <option value="N">Zablokuj w sadzie</option>
    </select>. <input type="submit" value="Dodaj">
    </form>
{/if}

{if $View == "czary"}
    <form method="post" action="zadmin.php?view=czary&step=add">
    Nazwa <input type="text" name="name"> jako czar
    <select name="type">
    <option value="B">Bojowy</option>
    <option value="O">Obronny</option>
    </select><br>
     z <input name="power" type="number"> Sila<br> i
    Kosztujaca <input type="number" name="cost"><br> z
    minimalnym poziomem <input type="number" name="minlev">
    <input type="submit" value="Dodaj"></form>
{/if}

{if $View == "magic"}
    <form method="post" action="zadmin.php?view=magic&step=add">
    Nazwa <input type="text" name="name"> jako 
    <select name="type">
    <option value="S">Rozdzka</option>
    <option value="Z">Szata</option>
    </select><br>
     z <input name="power" type="number"> Sila<br> i
    Kosztujaca <input type="number" name="cost"><br> z
    minimalnym poziomem <input type="number" name="minlev">
    <input type="submit" value="Dodaj"></form>
{/if}

{if $View == "close"}
    <form method="post" action="zadmin.php?view=close&step=close">
    <select name="close"><option value="close">Zablokuj</option>
    <option value="open">Odblokuj</option></select>
    <input type="submit" value="Zrob"></form>
{/if}

{$Message}
