{if $View == ""}
    Witaj w panelu Karczmarza. Co chcesz zrobic?
    <ul>
        <li><a href="Karczmarz.php?view=czat">Zablokuj/odblokuj wiadomosci od gracza na czacie</a>
	<li><a href="Karczmarz.php?view=clearc">Wyczyscic Czat</a>
    </ul>
{/if}

{if $View == "czat"}
    Lista zablokowanych<br>
    {section name=Karczmarz loop=$Chatid}
        ID: {$Chatid[Karczmarz]}
    {/section}
    <form method="post" action="Karczmarz.php?view=czat&step=czat">
    <select name="czat"><option value="blok">Zablokuj</option><option value="odblok">Odblokuj</option></select>
    ID <input type="text" name="czat_id" size="5">. <input type="submit" value="Zrob">
    </form>
{/if}
