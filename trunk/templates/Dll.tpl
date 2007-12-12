{if $View == ""}
    Witaj w panelu Straznika ostrzy. Co chcesz zrobic?
    <ul>
	<li><a href="Dll.php?view=jail">Wyslij gracza do wiezienia</a>
	<li><a href="Dll.php?view=czat">Zablokuj/odblokuj wiadomosci od gracza na czacie</a>
    </ul>
{/if}

{if $View == "czat"}
    Lista zablokowanych<br>
    {section name=player loop=$List1}
        ID {$List1[player]}<br>
    {/section}
    <form method="post" action="Dll.php?view=czat&step=czat">
    <select name="czat"><option value="blok">Zablokuj</option>
    <option value="odblok">Odblokuj</option></select>
    ID <input type="text" name="czat_id" size="5">.
    <input type="submit" value="Zrob"></form>
{/if}
{if $View == "jail"}
    <form method="post" action="Dll.php?view=jail&step=add">
    ID gracza: <input type="text" name="prisoner"><br>
    Przyczyna: <textarea name="verdict"></textarea><br>
    Czas (w dniach): <input type="text" name="time"><br>
    Kaucja za uwolnienie: <input type="text" name="cost"><br>
    <input type="submit" value="Dodaj"></form>
{/if}

