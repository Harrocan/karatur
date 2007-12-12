{if $Action == ""}
{$Info}{$Money}<br /><br />
- <a href="?action=more">{$More}</a><br />
- <a href="?action=defense">{$Def}</a><br />
- <a href="travel.php">{$Travel}</a><br />
{/if}
{if $Action == "more"}
{$Dot}<br />
<form action='?action=more' method="POST">
{$Credits}: <input type="text" name="credits" value="" /><br /><br />
<input type="submit" name="submit" value="Dotuj!" />
</form>
{/if}
