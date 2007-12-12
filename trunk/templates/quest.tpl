{$Start}

{$Text}

{$Link}

{$End}

{if $Box != ""}
    <form method="post" action="{$File}?step=quest">
    {section name=quest loop=$Box}
        <input type="radio" name="{$Name}" value="{$Option[quest]}">{$Box[quest]}<br><br>
    {/section}
    <input type="submit" value="Wybierz"></form>
{/if}

{if $Answer == "Y"}
    <form method="post" action="{$File}?step=quest">
    Podaj odpowiedz:<br />
    <input type="text" name="planswer"><br />
    <input type="submit" value="Zatwierdz"></form>
{/if}

