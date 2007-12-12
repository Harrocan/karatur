Tu jest spis wydarzen zwiazanych z twoja postacia.<br><br>
{if $LogId[0] != "0"}
    {section name=log loop=$Date}
        <b>Wydarzenie:<br>
        </b>Data:{$Date[log]}<br>
        {$Text[log]}<br>
        <a href="info.php">Formularz zgloszeniowy</a><br><br>
    {/section}
    <center>
    {section name=p loop=$Pages}
        {if $Page==$Pages[p]}
            {$Pages[p]}
        {else}
            <a href="log.php?page={$Pages[p]}">{$Pages[p]}</a>
        {/if} 
    {/section}
    </center>
    <a href="log.php?akcja=wyczysc">(Wyczysc dziennik)</a>
{/if}

{if $Send != ""}
    <form method="post" action="log.php?send&step=send">
    Wyslij ten wpis z dziennika do: <select name="staff">
    {section name=log1 loop=$Name}
        <option value="{$StaffId[log1]}">{$Name[log1]}</option>
    {/section}
    </select><br>
    <input type="hidden" name="lid" value="{$Send}">
    <input type="submit" value="Wyslij"></form>
{/if}

