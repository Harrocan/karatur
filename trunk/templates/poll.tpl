<br>
{section name=s loop=$Polls}
	<table class="table" border="0" align="center" width="100%">
	<tr><td colspan="2" class="thead">
	<b style="position: relative; z-index: 2">{$Polls[s].name}</b></td>
	{section name=p loop=$Polls[s].options}
	<tr><td height="20px" width="94%"><a  style="position: relative; z-index: 2">{$Polls[s].options[p]}</a><br>
		<img style="position: relative; bottom:14px; z-index: 1" src=images/bar.png width="{$Polls[s].sum[p]}%" height="14px"></td><td valign="top" style="width:40px">{$Polls[s].votes[p]}</td></tr>
	{/section}
	</table><br><br>
{/section}