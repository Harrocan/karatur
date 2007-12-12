{if $Location == "Athkatla"}
Spis Kaplanow.
<br><br><br>
{if $Number > "0"}
<table>
<tr>
<td width="100"><b><u>Nick Kaplana:</td>
<td width="50"><b><u>ID:</td>
<td width="200"><b><u>Poziom Kaplana</u></b></td>

</tr>
{section name=kaplan loop=$Name}
<tr>
<td><a href=view.php?view={$Id[kaplan]}>{$Name[kaplan]}</a></td>
<td>{$Id[kaplan]}</td>
<td>{$Level[kaplan]}</td>
</tr>
{/section}
</table>

{/if}

{/if}

<br><br><br><a href="cech.php">wroc</a><br>

