<br><br>
<table border="0" align="center" width="80%" style="border-style: solid; border-color:{if $Status=='done'}#20AB26{else}#AB2020{/if}; border-width: medium">
<tr VALIGN="top">
<td width="48px" height="48px"><img src="./images/{$Status}.gif"></td><td>{$Message}</td>
{if $Status=='error'}
<tr>
<td colspan="2" align="center">W przypadku bledu ... <br>Napisz informacje na <a href="info.php">Formularz zgloszeniowy</a><td>
{/if}
</tr>
</table>
