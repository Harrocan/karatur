{if $UserSniff == 1 }
<div style="text-align:right;font-size:0.8em">
	<a href="usersniff.php?id={$Id}" style="font-size:0.8em">podgladnij</a> tego gracza
</div>
{/if}
<table border=0 class="table"  style="width:380px;overflow:hidden;">
	<tr>
		<td colspan=2>
			<center> <u><b style="font-size:26px">{$User}</b></u> ({$Id})<br />
			{if !empty($Avatar)}<img src="{$Avatar}" style="max-width:380;max-height:300px">{/if}
			</center>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<u><b>Ogó³em:</b></u><br>
			Rasa: {$Race}<br>
			P³eæ: {if $Gender=="Mezczyzna"}Mê¿czyzna{else}{$Gender}{/if}<br>
			Klasa: {$Clas}<br>
			{$Deity}<br>
			Lokacja: {$Location}<br>
			Ostatnio widzian{if $Gender=="Mezczyzna"}y{else}a{/if}: {$Page}<br>
			Dni w krainie: {$Age}<br>
			{$GG}<br>
		</td>
		<td valign="top">
			<u><b>Informacje precyzuj±ce:</b></u><br>
			Ranga: {$Rank}<br>
			W krainie: {$Age} dni<br>
			{$Immu}<br>
			Charakter: {$Charakter}<br>
			Stan Cywilny: {$Stan}<br>
			Poziom: {$Level}<br>
			Klan: {$Clan} <br>
			Maksymalne P¯: {$Maxhp}<br>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<u><b>Wygl±d ogólny:</b></u><br>
			Kolor W³osów: {$Wlos}<br>
			Kolor Oczu: {$Oczy}<br>
			Kolor Skóry: {$Skora}<br><br>
			<b>Vallary:</b> {$Refs}<br>
			{*$Ojciec*}<br>
		</td>
		<td valign="top">
			<u><b>Walki:</b></u><br>
			Wyniki: {$Wins}/{$Losses}<br>
			{if $Gender=="Mezczyzna"}
			Ostatnio zabi³: {$Lastkilled}<br>Ostatnio zabity przez: {$Lastkilledby}
			{else}
			Ostatnio zabi³a: {$Lastkilled}<br>Ostatnio zabita przez: {$Lastkilledby}
			{/if}
		</td>
	</tr>
	<tr>
		<td colspan=2>
			<b>Profil:</b><br>
			<div style="width:370px;overflow:hidden">{$Profile}</div>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			Opcje:<br>
			<ul>
			{$Attack}
			{$Mail}
			{$Crime}
			{if isset($Ugryz)}{$Ugryz}{/if}
			</ul>
			{$IP}
		</td>
	</tr>
</table>
