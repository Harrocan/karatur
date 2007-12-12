{if $View == ""}
    Witaj w panelu Dowodcy Straznikow. Co chcesz zrobic?
    <ul>
        <li><A href="addupdatee.php">Dodac Wiesc</a>
	<li><a href="SStraz.php?view=clearc">Wyczyscic Czat</a>
	<li><a href="SStraz.php?view=jail">Wyslij gracza do wiezienia</a>
	<li><a href="SStraz.php?view=add">Dodac straznika</a>
	<li><a href="SStraz.php?view=poczta">Wyslij poczte do wszystkich</a>
	<li><a href="SStraz.php?view=czat">Zablokuj/odblokuj wiadomosci od gracza na czacie</a>
    </ul>
{/if}


{if $View == "jail"}
    <form method="post" action="SStraz.php?view=jail&step=add">
    ID gracza: <input type="text" name="prisoner"><br>
    Przyczyna: <textarea name="verdict" rows="1" cols="20"></textarea><br>
    Czas (w dniach): <input type="text" name="time"><br>
    Kaucja za uwolnienie: <input type="text" name="cost"><br>
    <input type="submit" value="Dodaj"></form>
{/if}

{if $View == "add"}
    <form method="post" action="SStraz.php?view=add&step=add">
    Dodaj ID <input type="text" name="aid"> jako
    <select name="rank">
    <option value="Straznik">Straznik Krolewski</option>
    </select>. <input type="submit" value="Dodaj">
    </form>
{/if}

{if $View == "poczta"}
    <table>
    <form method="post" action="SStraz.php?view=poczta&step=send">
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
    <form method="post" action="SStraz.php?view=czat&step=czat">
    <select name="czat"><option value="blok">Zablokuj</option>
    <option value="odblok">Odblokuj</option></select>
    ID <input type="text" name="czat_id" size="5">.
    <input type="submit" value="Zrob"></form>
{/if}


