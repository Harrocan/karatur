{if $Location == "Athkatla"}
Spis Lowcow.
<br><br><br>
{if $Number > "0"}
<table>
<tr>
<td width="100"><b><u>Nick Lowcy:</td>
<td width="50"><b><u>ID:</td>
<td width="200"><b><u>Poziom Lowcy</u></b></td>

</tr>
{section name=lowca loop=$Name}
<tr>
<td><a href=view.php?view={$Id[lowca]}>{$Name[lowca]}</a></td>
<td>{$Id[lowca]}</td>
<td>{$Level[lowca]}</td>
</tr>
{/section}
</table>

{/if}

{/if}

<br><br><br><a href="cech.php">wroc</a><br>

