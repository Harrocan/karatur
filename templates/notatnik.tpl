{if $Action == ""}
    Tutaj mozesz zapisywac sobie rozne przydatne informacje.<br><br>
    {section name=notes loop=$Noteid}
        Czas:{$Notetime[notes]}<br>{$Notetext[notes]}<br> (<a href="notatnik.php?akcja=skasuj&nid={$Noteid[notes]}">Skasuj wpis</a>)<br>
    {/section}
    <br><br><a href="notatnik.php?akcja=dodaj">(Dodaj wpis)</a>
{/if}

{if $Action == "dodaj"}
    <table>
    <form method="post" action="notatnik.php?akcja=dodaj&step=send">
    <tr><td valign="top">Notatka:</td><td><textarea name="body" rows="5" cols="19"></textarea></td></tr>
    <tr><td colspan="2" align="center"><input type="submit" value="Zapisz"></td></tr>
    </form></table>
{/if}

