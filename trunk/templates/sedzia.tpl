{if $View == ""}
<a href="sedzia.php?view=jail">Wyslij gracza do wiezienia</a>
{/if}
{if $View == "jail"}
    <form method="post" action="sedzia.php?view=jail&step=add">
    ID gracza: <input type="text" name="prisoner"><br>
    Przyczyna: <textarea name="verdict" rows="1" cols="20"></textarea><br>
    Czas (w dniach): <input type="text" name="time"><br>
    Kaucja za uwolnienie: <input type="text" name="cost"><br>
    <input type="submit" value="Dodaj"></form>
{/if}