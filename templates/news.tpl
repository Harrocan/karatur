{if $View == ""}
	{section name=n loop=$News}
		<b>{$News[n].title}</b> ... <BR>{* napisana przez <b>{$News[n].starter}</b> ... <br><br>*}
		{$News[n].news}<br><br>
	{/section}
    (<a href="news.php?view=all">ostatnie 10 Plotek</a>)
{/if}

{if $View == "all"}
    {section name=news loop=$Title1}
        <b>{$Title1[news]}</b> napisana przez <b>{$Starter[news]}</b>...<br><br>
        "{$News[news]}"<br><br>
    {/section}
{/if}

