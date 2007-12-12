<a href="?view=add">Dodaj Ogloszenie</a><br><br>
{if $View == ""}
<table class="table">
{section name=o loop=$Upd}
	<tr>
		<td class="thead"><b>{$Upd[o].title}</b> napisana przez <b>{$Upd[o].starter}</b></td>
	</tr>
	<tr>
		<td>"{$Upd[o].ogloszenia}"</td>
	</tr>
{/section}
</table>
{/if}
{if $View=='add'}
	<form method="post" action="?action=add">
	Tutul : <input type="text" name="title"><br>
	Tresc : <br>
	<textarea name="body" style="width:80%; height:100px"></textarea><br>
	<input type="submit" value="dodaj">
	</form>
{/if}
