{if $View == "topics"}
    <table>
    <tr>
    <td width="150"><u><b>Temat</td>
    <td width="100"><u><b>Autor</td>
    <td width="50"><b><u>Odpowiedzi</td>
    </tr>
    {section name=tforums loop=$Topic}
        <tr>
        <td><a href="tforums.php?topic={$Topicid[tforums]}">{$Topic[tforums]}</a></td>
        <td>{$Starter[tforums]}</td>
        <td>{$Replies[tforums]}</td>
        </tr>
    {/section}
    </table>
    </center><form method="post" action="tforums.php?action=addtopic">
    Dodaj temat:<br><input type="text" name="title2" value="Temat" size="40"><br>
    <textarea name="body" cols="40" rows="10">Tekst</textarea><br>
    <input type="submit" value="Dodaj Temat"></form>
{/if}

{if $Topics != ""}
    <center><br>
    <table class=td width="98%" cellpadding="0" cellspacing="0">
    <tr>
    <td><b>{$Topic}</b> napisany przez {$Starter} (<a href="tforums.php?view=topics">wroc</a>) {$Delete}</td>
    </tr>
    <tr>
    <td>{$Topictext}</td>
    </tr>
    </table><br>
    {section name=tforums1 loop=$Reptext}
        <center>
        <table class=td width="98%" cellpadding="0" cellspacing="0">
        <tr>
        <td><b>{$Repstarter[tforums1]}</b> powiedzial... (<a href="tforums.php?view=topics">wroc</a>) {$Action[tforums1]}</td>
        </tr>
        <tr>
        <td>{$Reptext[tforums1]}</td>
        </tr>
        </table><br>
    {/section}
    </center>
    <form method="post" action="tforums.php?reply={$Id}">
    Dodaj Odpowiedz:<br>
    <textarea name="rep" cols="40" rows="10">Tekst</textarea><br>
    <input type="submit" value="Dodaj Odpowiedz"></form>
{/if}

