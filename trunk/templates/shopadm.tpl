Adminstracja Sklepami<br>
<br>
{if $Action==''}
<a href="?action=add">Dodaj sklep</a><br>
<br>
<table class="table">
	<tr>
		<td class="thead">Nr</td><td class="thead" width="160px">Nazwa</td><td class="thead" width="100px">Miasto</td>
	</td>
{section name=sh loop=$Shop}
	<tr>
		<td>{$Shop[sh].id}</td><td><a href="?action=edit&sid={$Shop[sh].id}">{$Shop[sh].name}</a></td><td>{$Shop[sh].city}</td>
		<form method="post" action="?action=edits"><input type="hidden" name="sid" value="{$Shop[sh].id}"><td><input type="submit" value="edytuj"></td></form>
		<form method="post" action="?"><input type="hidden" name="sid" value="{$Shop[sh].id}"><td><input type="submit" value="usuñ"></td></form>
	</tr>
{sectionelse}
	<tr>
		<td colspan="3" align="center">Brak sklepów</td>
	</tr>
{/section}
</table>
{/if}
{if $Action=='add'}
<form method="post" action="?action=add">
Nazwa sklepu : <input type="text" name="city"><br>
Plik z miastem : <select name="file">
{section name=c loop=$City}
	<option value="{$City[c].name}">{$City[c].name}
{/section}
</select><br><br>
Tekst kóry bêdzie wy¶wietlany w sklepie<br>
<textarea name="opis" style="width:300px; height:150px"></textarea><br>
<input type="submit" value="Dodaj">
</form>
<br>
<a href="shopadm.php">Wróæ ...</a>
{/if}
{if $Action=='edit'}
Dodaj przedmiot<br><br>
<b>{$Sname}</b><br>
<ul>
	<li>Bronie : <form name="weap" method="post" action="?action=edit&sid={$Sid}"><select name="weapon">
	{section name=w loop=$Weap}
		<option value="{$Weap[w].id}">({$Weap[w].type}){$Weap[w].name}(+{$Weap[w].power})
	{/section}
	</select> <input type="submit" value="Dodaj">
	</form></li>
	<li>Opancerzenie : <form name="arm" method="post" action="?action=edit&sid={$Sid}"><select name="armor">
	{section name=w loop=$Arm}
		<option value="{$Arm[w].id}">({$Arm[w].type}){$Arm[w].name} (+{$Arm[w].power})
	{/section}
	</select> <input type="submit" value="Dodaj">
	</form></li>
</ul><br>
<table class="table">
	<tr>
		<td class="thead">Typ</td><td class="thead">Nazwa</td><td class="thead">Moc</td><td class="thead">Koszt</td><td class="thead">Lvl</td><td class="thead">Zr</td><td class="thead">Wyt.</td><td class="thead">Szyb</td><td class="thead">Dwur.</td>
	</td>
	{section name=w loop=$Ware}
	<tr>
		<td>{$Ware[w].type}</td><td>{$Ware[w].name}</td><td>{$Ware[w].power}</td><td>{$Ware[w].cost}</td><td>{$Ware[w].minlev}</td><td>{$Ware[w].zr}</td><td>{$Ware[w].maxwt}</td><td>{$Ware[w].szyb}</td><td>{$Ware[w].twohand}</td><form method="post" action="?action=edit&sid={$Sid}"><input type="hidden" name="iid" value="{$Ware[w].id}"><td><input type="submit" value="usun"></td></form>
	</tr>
	{sectionelse}
	<tr>
		<td colspan="9" align="center">W ty skelpie jeszcze nic nie jest sprzedawane</td>
	</tr>
{/section}
</table><br>
<br>
<a href="shopadm.php">Wróæ ...</a>
{/if}
{if $Action=='edits'}
<form method="post" action="?action=edits&sid={$Shop.id}">
<input type="hidden" name="shopid" value="{$Shop.id}">
Nazwa sklepu : <input type="text" name="name" value="{$Shop.name}"><br>
Plik z miastem : <select name="file">
{section name=c loop=$City}
	<option value="{$City[c].name}" {if $City[c].name==$Shop.city}selected{/if}>{$City[c].name}
{/section}
</select><br><br>
Tekst kóry bêdzie wy¶wietlany w sklepie<br>
<textarea name="opis" style="width:300px; height:150px">{$Shop.opis}</textarea><br>
<input type="submit" value="Zmieñ">
</form>
<br>
<a href="shopadm.php">Wróæ ...</a>
{/if}
<br>
