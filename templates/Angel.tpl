{if $View == ""}
    Witaj w panelu administracyjnym. Co chcesz zrobic?
    <ul>
        <li><a href="Angel.php?view=czat">Zablokuj/odblokuj wiadomosci od gracza na czacie</a>
    </ul>
{/if}

{if $View == "czat"}
    Lista zablokowanych<br>
    {section name=staff loop=$Chatid}
        ID: {$Chatid[staff]}
    {/section}
    <form method="post" action="Angel.php?view=czat&step=czat">
    <select name="czat"><option value="blok">Zablokuj</option><option value="odblok">Odblokuj</option></select>
    ID <input type="text" name="czat_id" size="5">. <input type="submit" value="Zrob">
    </form>
{/if}
