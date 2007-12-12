{if $Location == "Altara"}
Spis Druidow.
<br><br><br>
{if $Number > "0"}
<table>
<tr>
<td width="100"><b><u>Nick Drudia:</td>
<td width="50"><b><u>ID:</td>
<td width="200"><b><u>Poziom Druida</u></b></td>

</tr>
{section name=Druid loop=$Name}
<tr>
<td><a href=view.php?view={$Id[Druid]}>{$Name[Druid]}</a></td>
<td>{$Id[Druid]}</td>
<td>{$Level[Druid]}</td>
</tr>
{/section}
</table>

{/if}

{/if}

<br><br><br><a href="cech.php">wroc</a><br>

