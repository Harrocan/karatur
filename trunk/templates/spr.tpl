<a href="oglw.php">Dodaj Ogloszenie</a><br><br>
{if $View == ""}
<b>{$Title1}</b> napisany przez <b>{$Starter}</b>... {$Modtext}<br><br>
"{$Update}".<br><br>{$Update[1]}<br><br>
<br><br>
(<a href="ogloszenia.php?view=all">ostatnie 10 ogloszen</a>)

{/if}

{if $View == "all"}
{section name=upd loop=$Title1}
<b>{$Title1[upd]}</b> napisana przez <b>{$Starter[upd]}</b>... {$Modtext[upd]}<br><br> 
"{$Update[upd]}"<br><br>
{/section}
{/if}
