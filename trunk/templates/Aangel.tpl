{if $View == ""}
    Witaj w panelu archaniola. Co chcesz zrobic?
    <ul>
    	<li><a href="Aangel.php?view=add">Dodaj aniola</a>
	<li><a href="Aangel.php?view=jail">Wyslij gracza do wiezienia</a>
        <li><a href="Aangel.php?view=czat">Zablokuj/odblokuj wiadomosci od gracza na czacie</a>
    </ul>
{/if}

{if $View == "add"}
    <form method="post" action="admin.php?view=add&step=add">
    Dodaj ID <input type="text" name="aid"> jako
    <select name="rank">
    <option value="Angel">Aniol</option>
    </select>. <input type="submit" value="Dodaj">
    </form>
{/if}

{if $View == "jail"}
    <form method="post" action="staff.php?view=jail&step=add">
    ID gracza: <input type="text" name="prisoner"><br>
    Przyczyna: <textarea name="verdict"></textarea><br>
    Czas (w dniach): <input type="text" name="time"><br>
    Kaucja za uwolnienie: <input type="text" name="cost"><br>
    <input type="submit" value="Dodaj"></form>
{/if}

{if $View == "czat"}
    Lista zablokowanych<br>
    {section name=staff loop=$Chatid}
        ID: {$Chatid[staff]}
    {/section}
    <form method="post" action="staff.php?view=czat&step=czat">
    <select name="czat"><option value="blok">Zablokuj</option><option value="odblok">Odblokuj</option></select>
    ID <input type="text" name="czat_id" size="5">. <input type="submit" value="Zrob">
    </form>
{/if}
