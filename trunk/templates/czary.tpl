<center><img src="spellbook.jpg"/></center><br />
<u>Obecnie uzywane czary</u>:<br>
{if isset($Atak)}
	{$Atak.name} - {$Atak.power} x Int do obrazen | <a href="?deakt=spellatk">deaktywuj</a><br>
{/if}
{if !empty($Def)}
	{$Def.name} - {$Def.power} x Sily woli do obrony | <a href="?deakt=spelldef">deaktywuj</a><br>
{/if}
<br><br>
<table class="table" width="100%">
	<tr>
		<td class="thead">Nazwa</td>
		<td class="thead">Moc</td>
	</td>
{section name=s loop=$Spells}
	{assign var='Type' value=$Spells[s]}
	{if !empty($Type.fields)}
		<tr>
			<td colspan=4 style="padding-left:20px"><b>{$Type.name}</b></td>
		</tr>
		{section name=i loop=$Type.fields}
		{assign var='Item' value=$Type.fields[i]}
			<tr>
				<td>{$Item.name}</td>
				<td>{if $Item.power > 0}{$Item.power} {$Type.suff}{/if}</td>
				<td><a href="?{$Type.link}={$Item.id}">{$Type.action}</a></td>
			</tr>
		{/section}
	{/if}
{/section}
</table>
<br>
{*
<br><u>Czary w ksiedze</u>:<br><b>-Czary bojowe:</b><br>
{section name=spell1 loop=$Bname}
    {$Bname[spell1]} (+{$Bpower[spell1]} x Inteligencja obrazen) [ <a href="czary.php?naucz={$Bid[spell1]}">Uzywaj tego czaru</a>]<br>
{/section}

<br><b>-Czary obronne:</b><br>
{section name=spell2 loop=$Dname}
    {$Dname[spell2]} (+{$Dpower[spell2]} x Sila Woli obrony) [ <a href="czary.php?naucz={$Did[spell2]}">Uzywaj tego czaru</a>]<br>
{/section}

<br><b>-Czary uzytkowe:</b><br>
{section name=spell3 loop=$Uname}
    {$Uname[spell3]} ({$Ueffect[spell3]}) [ <a href="czary.php?cast={$Uid[spell3]}">Rzuc ten czar</a> ]<br>
{/section}
*}
{if $Cast != ""}
    <form method="post" action="czary.php?cast={$Cast}&step=items">
    <input type="submit" value="Rzuc"> czar {$Spellname} na 
    <select name="item">
    {section name=i loop=$Items}
        <option value="{$Items[i].id}">{$Items[i].prefix} {$Items[i].name} (sztuk: {$Items[i].amount})</option>
    {/section}
    </select>
    <input type="hidden" name="spell" value="{$Spellname}"><br></form>
    {$Message}
{/if}

{if $Learn > 0}
    Uzywasz {$Name}. (<a href="czary.php">odswiez</a>)
{/if}

{if $Deaktiv > "0"}
    <a href="czary.php">(Odswiez)</a>
{/if}


