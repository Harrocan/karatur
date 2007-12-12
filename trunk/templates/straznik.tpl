{if $View == ""}
    Witaj w panelu Straznika. Co chcesz zrobic?
    <ul>
	<li><a href="straznik.php?view=czat">Zablokuj/odblokuj wiadomosci od gracza na czacie</a>
	<li><a href="straznik.php?view=jail">Wyslij gracza do wiezienia</a>
    </ul>
{/if}

{if $View == "jail"}
    <form method="post" action="straznik.php?view=jail&step=add">
    ID gracza: <input type="text" name="prisoner"><br>
    Przyczyna: <textarea name="verdict"></textarea><br>
    Czas (w dniach): <input type="text" name="time"><br>
    Kaucja za uwolnienie: <input type="text" name="cost"><br>
    <input type="submit" value="Dodaj"></form>
{/if}


{if $View == "czat"}
    Lista zablokowanych<br>
    {section name=straznik loop=$Chatid}
        ID: {$Chatid[straznik]}
    {/section}
    <form method="post" action="straznik.php?view=czat&step=czat">
    <select name="czat"><option value="blok">Zablokuj</option><option value="odblok">Odblokuj</option></select>
    ID <input type="text" name="czat_id" size="5">. <input type="submit" value="Zrob">
    </form>
{/if}
