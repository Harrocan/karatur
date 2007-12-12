{if $View == "categories"}
    <table><tr><td><b><u>Kategoria</u></b></td><td><b><u>Tematow</u></b></td><td><b><u>Odpowiedzi</u></b></tr>
    {section name=number loop=$Name}
        <tr>
        <td width="80%"><a href="forums.php?topics={$Id[number]}" onMouseOver="overlib('{$Description[number]}', CAPTION, '<center><B>{$Name[number]}</B></center>', FGCOLOR, '#121212', BGCOLOR, '#000000', TEXTCOLOR, '#000000', CAPTIONSIZE, 2, BORDER, 2, TEXTSIZE, 1,WIDTH,400, STATUS, 'Dymek z naglowkiem')" onMouseOut="nd();">{$Name[number]}</a></td>
        <td>{$Topics1[number]}</td><td>{$Replies[number]}</a></td>
        </tr>
        {*<tr>
        <td><a href="forums.php?topics={$Id[number]}"><i>{$Description[number]}</i></a></td>
        </tr>*}
        <tr>
        {*<td colspan=3><hr></td>*}
        </tr>
    {/section}
    </table>
{/if}

{if $Topics != ""}
    <table><tr><td width=150><u><b>Temat</td><td width=100><u><b>Autor</td><td width=50><b><u>Odpowiedzi</td></tr>
    {section name=number1 loop=$Starttext}
        <tr>
        <td><a href="forums.php?topic={$Id[number1]}"  onMouseOver="overlib('{$Starttext[number1]}', CAPTION, '<center><B>{$Topic1[number1]}</B></center>', FGCOLOR, '#121212', BGCOLOR, '#000000', TEXTCOLOR, '#000000', CAPTIONSIZE, 2, BORDER, 2, TEXTSIZE, 1,WIDTH,400, STATUS, 'Dymek z naglowkiem')" onMouseOut="nd();">{$Topic1[number1]}</a></td>
        <td>{$Starter1[number1]}</td>
        <td>{$Replies1[number1]}</td>
        </tr>
    {/section}
    </table>
    </center>
    <form method="post" action="forums.php?action=addtopic">
    Dodaj temat:<br><input type="text" name="title2" value="Temat" size="40"><br>
    <textarea name="body" cols="40" rows="10">Tekst</textarea><br>
    <input type="hidden" name="catid" value="{$Category}">
    <input type="submit" value="Dodaj Temat"></form><br><br>
    <a href="forums.php?view=categories">Wroc</a> do listy kategorii.
{/if}

{if $Topic != ""}
    <center><br>
    <table class="td" width="98%" cellpadding="0" cellspacing="0">
    <tr>
    <td><b>{$Topic2}</b> napisany przez {$Starter} ID {$Playerid} (<a href="forums.php?topics={$Category}">wroc</a>) {$Action}
    </td>
    </tr>
    <tr>
    <td>{$Ttext}</td>
    </tr>
    </table><br>
    {section name=number2 loop=$Rtext}
        <center>
        <table class="td" width="98%" cellpadding="0" cellspacing="0">
        <tr>
        <td><b>{$Rstarter[number2]}</b> ID {$Rplayerid[number2]} napisal(a)... (<a href="forums.php?topics={$Category}">wroc</a>)
         {$Action2[number2]}
        </td>
        </tr>
        <tr>
        <td>{$Rtext[number2]}</td></tr></table><br>
    {/section}
    </center>
    <form method="post" action="forums.php?reply={$Id}">
    Odpowiedz:<br>
    <textarea name="rep" cols="40" rows="10">Tekst</textarea><br>
    <input type="submit" value="Odpowiedz">
    </form>
{/if}


