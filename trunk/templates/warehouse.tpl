Wkraczasz do zatêchlego spichlerza wype³nionego wszelakiej ma¶ci przedmiotami- mithrilem, mineralami, ziolami, itd. Podchodzisz do laty, gdzie wita cie krepy krasnolud: Witam, jestem Dhorn. Jestem tutaj zarzadca. Chcesz cos kupic czy sprzedac?
<br><br>
{if $Action == ""}
	<table align="center" class="table"
		<tr>
				<td class="thead"><b><u>Surowiec</u></b></td>
				<td class="thead"><b><u>Skup</u></b></td>
				<td class="thead"><b><u>Dostêpne</u></b></td>
				<td class="thead"><b><u>Sprzeda¿</u></b></td>
				<td class="thead"><b><u>Akcje</u></b></td>
		</tr>
		{section name=warehouse loop=$Minname}
			<tr>
				<td>{$Minname[warehouse]}</td>
				<td align="center">{$Costmin[warehouse]}</td>
				<td align="center">{$Sellavail[warehouse]}</td>
				<td align="center">{$Sellcost[warehouse]}</td>
				<td>
					<a href="warehouse.php?action=sell&item={$Mineral[warehouse]}">Sprzedaj</a> | 
					<a href="warehouse.php?action=buy&item={$Mineral[warehouse]}">Kup</a></td>
			</tr>
		{/section}
	</table>
	<br />
{/if}

{if $Action == "sell"}
	{$Warehouseinfo2}<br /><br />
	<form method="post" action="warehouse.php?action=sell&amp;item={$Item}&amp;sell=sell">
		<input type="submit" value="{$Asell}" /> 
		<input type="text" name="amount" size="5" value="{$Iamount}"/>{$Tamount} {$Itemname} {$Youhave} {$Iamount} {$Tamount} {$Itemname}.
	</form>
	<br /><br />
	<a href="warehouse.php">{$Aback}</a>
{/if}
{if $Action == "buy"}
	{$Warehouseinfo2}<br /><br />
	<form method="post" action="warehouse.php?action=buy&amp;item={$Item}&amp;buy=buy">
		<input type="submit" value="Kup" /> 
		<input type="text" name="amount" size="5"/> sztuk {$Itemname}, po <b>{$Cost}</b> za sztuke
	</form>
	<br /><br />
	<a href="warehouse.php">{$Aback}</a>
{/if}
