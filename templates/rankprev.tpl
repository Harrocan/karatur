<table class="table">
{section name=r loop=$Userid}
	<tr><td colspan="2" class="thead" align="center"><img src="images/ranks/{$Userrankicon[r]}"> {$Userrank[r]}</td></tr>
	{section name=u loop=$Userid[r]}
		<tr><td>{$Userid[r][u]}</td><td width="200px">{$Username[r][u]}</td></tr>
	{/section}
{/section}
</table><br>
<table class="table">
<tr>
	<td colspan="3" class="thead" align="center">Rangi</td>
</tr>
{section name=ranks loop=$Rankname}
	<tr>
		<td align="center"><img src="images/ranks/{$Rankimage[ranks]}"></td>
		<td width="150px">{$Rankname[ranks]}</td>
		<td width="20px" style="background-color:{$Rankcolor[ranks]}">&nbsp;</td>
	</tr>
{/section}
</table>