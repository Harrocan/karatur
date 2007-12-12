{if $View == ""}
    Witaj w panelu Ksiedza. Co chcesz zrobic?
    <ul>
    <li><a href="ksiadz.php?view=poczta">Wyslij poczte do wszystkich</a>
	<li><a href="ksiadz.php?view=pary">Daj slub</a>
    </ul>
{/if}

{if $View == "pary"}
    <form method="post" action="ksiadz.php?view=pary&step=add">
    ID Kobiety: <input type="text" name="prisoner"><br>
	ID Mezczyzny: <input type="text" name="prisonerp"><br>
    Przyczyna: <textarea name="verdict"></textarea><br>
    Koszt rozwodu: <input type="text" name="cost"><br>
    <input type="submit" value="Dodaj"></form>
{/if}
{if $View == "poczta"}
    <table>
    <form method="post" action="ksiadz.php?view=poczta&step=send">
    <tr><td>Temat:</td><td><input type="text" name="subject"></td></tr>
    <tr><td valign="top">Tresc:</td><td><textarea name="body" rows="5" cols="19"></textarea></td></tr>
    <tr><td colspan="2" align="center"><input type="submit" value="Wyslij"></td></tr>
    </form></table>
{/if}

