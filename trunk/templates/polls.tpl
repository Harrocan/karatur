{if $Action == ""}
    {$Pollsinfo} {$Gamename}<br /><br />

    {if $Pollid == "0"}
        <div align="center">{$Nopolls}</div><br />
    {/if}

    {if $Pollid != "0"}
        {$Lastpoll}<br /><br />
        <div align="center">
            <table>
                <tr>
                    <td colspan="2"><b>{$Question}</b></td>
                </tr>
                {if $Voting == "Y"}
                    <form method="post" action="polls.php?action=vote&amp;poll={$Pollid}">
                        {section name=poll loop=$Answers}
                            <tr>
                                <td><input type="radio" name="answer" value="{$Answers[poll]}" /></td><td>{$Answers[poll]}</td>
                            </tr>
                        {/section}
                        <tr>
                            <td colspan="2" align="center"><input type="submit" value="{$Asend}" /></td>
                        </tr>
                    </form>
                {/if}
                {if $Voting == "N"}
                    {section name=poll2 loop=$Answers}
                        <tr>
                            <td>{$Answers[poll2]}</td><td> - {$Tvotes}: {$Votes[poll2]} ({$Percentvotes[poll2]} %)</td>
                        </tr>
                    {/section}
                {/if}
                <tr>
                    <td colspan="2">{$Sumvotes} <b>{$Summaryvotes} ({$Summaryvoting} %)</b> {$Tmembers}</td>
                </tr>
                <tr>
                    {if $Days > "0"}
                        <td colspan="2">{$Polldays} {$Days} {$Tdays}</td>
                    {/if}
                    {if $Days == "0"}
                        <td colspan="2">{$Pollend}</td>
                    {/if}
                </tr>
            </table>
        </div><br /><br /><br />
      
    {/if}
{/if}

{if $Action == "vote"}
    <div align="center">{$Message}<br /><br />
    <a href="polls.php">{$Aback}</a></div>
{/if}

{if $Action == "last"}
    {$Lastinfo}:<br /><br />
    <div align="center">
        <table>
            {section name=poll3 loop=$Questions}
                <tr>
                    <td colspan="2"><b>{$Questions[poll3]}</b></td>
                </tr>
                    {section name=poll4 loop=$Answers[poll3]}
                        <tr>
                            <td>{$Answers[poll3][poll4]}</td><td> - {$Tvotes}: {$Votes[poll3][poll4]} ({$Percentvotes[poll3][poll4]} %)</td>
                        </tr>
                    {/section}
                <tr>
                    <td colspan="2">{$Sumvotes} <b>{$Summaryvotes[poll3]} ({$Percentvoting[poll3]} %)</b> {$Tmembers}<br /><br /></td>
                </tr>
            {/section}
        </table>
    </div><br /><br /><br />
    <a href="polls.php">{$Aback}</a>
{/if}
