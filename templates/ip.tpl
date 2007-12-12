<b>IPList</b> (posortowane wedlug IP):
<table>
<tr>
<td width="100"><b>Nick:</td>
<td><b>ID</b>:</td>
<td><b>IP:</td>
<td width="50"><b>Opcje:</td>
</tr>
{section name=players loop=$Name}
<tr>
<td><a href="view.php?view={$Id[players]}">{$Name[players]}</a></td>
<td>{$Id[players]}</td>
<td>{$Ip[players]}</td>
<td><a href="?id={$Id[players]}">Usun</a></td>
</tr>
{/section}
</table>


