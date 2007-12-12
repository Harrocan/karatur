{if $Location == "Athkatla"}
Spis Rzemieslnikow.
<br><br><br>
{if $Number > "0"}
<table>
<tr>
<td width="100"><b><u>Nick Rzemieslnika:</td>
<td width="50"><b><u>ID:</td>
<td width="200"><b><u>Poziom Rzemieslnika</u></b></td>

</tr>
{section name=craftsman loop=$Name}
<tr>
<td><a href=view.php?view={$Id[craftsman]}>{$Name[craftsman]}</a></td>
<td>{$Id[craftsman]}</td>
<td>{$Level[craftsman]}</td>
</tr>
{/section}
</table>

{/if}

{/if}

<br><br><br><a href="cech.php">wroc</a><br>

