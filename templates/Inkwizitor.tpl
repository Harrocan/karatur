{if $View == ""}
    Witaj w panelu Inkwizytora. Co chcesz zrobic?
    <ul>
	<li><a href="Inkwizitor.php?view=jail">Wyslij gracza do wiezienia</a>
    </ul>
{/if}

{if $View == "jail"}
    <form method="post" action="Inkwizytor.php?view=jail&step=add">
    ID gracza: <input type="text" name="prisoner"><br>
    Przyczyna: <textarea name="verdict"></textarea><br>
    Czas (w dniach): <input type="text" name="time"><br>
    Kaucja za uwolnienie: <input type="text" name="cost"><br>
    <input type="submit" value="Dodaj"></form>
{/if}

