{if $View == ""}
    Witaj w panelu administracyjnym. Co chcesz zrobic?
    <ul>
	<li><A href="addnews.php">Dodac Plotke</a>
	<li><a href="staff.php?view=takeaway">Zabrac sztuki zlota</a>
	<li><a href="staff.php?view=clearc">Wyczyscic Czat</a>
	<li><a href="staff.php?view=czat">Zablokuj/odblokuj wiadomosci od gracza na czacie</a>
	<li><a href="staff.php?view=tags">Daj Immunitet</a>
	<li><a href="staff.php?view=jail">Wyslij gracza do wiezienia</a>
    </ul>
{/if}

{if $View == "jail"}
    <form method="post" action="staff.php?view=jail&step=add">
    ID gracza: <input type="text" name="prisoner"><br>
    Przyczyna: <textarea name="verdict"></textarea><br>
    Czas (w dniach): <input type="text" name="time"><br>
    Kaucja za uwolnienie: <input type="text" name="cost"><br>
    <input type="submit" value="Dodaj"></form>
{/if}

{if $View == "tags"}
	<form method="post" action="staff.php?view=tags&step=tag">
	Daj immunitet ID <input type="text" name="tag_id" size="5">. <input type="submit" value="Daj">
	</form>
{/if}

{if $View == "takeaway"}
    <form method="post" action="staff.php?view=takeaway&step=takenaway"> 
    ID: <input type="text" name="id"> <br>
    ilosc: <input type="text" name="taken">  <input type="submit" value="Zabierz"></form>
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
