<center><img src="ks.jpg"/></center><br />
{if $View == ""}
	{section name=upd loop=$Title1}
    <center><div style="font-size: 13px;"><b>{$Title1[upd]}</b></div></center><br>napisany przez <b>{$Starter[upd]}</b>{$Date[upd]}... {$Modtext[upd]}<br><br>
    "{$Update[upd]}".<br>
	<div align="right"><a href=forum.php?cat=5&topic={$Topicid[upd]}>Skomentuj</a> ({$Reply[upd]})</div><br>
	{/section}
    (<a href="updates.php?view=all">ostatnie 10 wiesci</a>)
	
{/if}

{if $View == "all"}
    {section name=upd loop=$Title1}
        <center><b>{$Title1[upd]}</b></center><br>napisana przez <b>{$Starter[upd]}</b>{$Date[upd]}... {$Modtext[upd]}<br><br> 
        "{$Update[upd]}"<br><br>
    {/section}
{/if}
