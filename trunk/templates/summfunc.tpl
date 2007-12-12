<table class="table">
	<tr>
		<td class="thead">Opcja</td>
		<td class="thead">Ilosc</td>
		<td class="thead">W miastach</td>
	</tr>
{section name=f loop=$File}
	<tr>
		<td valign="top">{$File[f].func} ({$File[f].file})</td>
		<td valign="top">{$File[f].amount}</td>
		<td valign="top">
		{if !empty($File[f].cities)}
			{section name=ci loop=$File[f].cities}
				{$File[f].cities[ci].name} {if $File[f].cities[ci].prv!=1}({$File[f].cities[ci].prv}){/if}<br>
			{sectionelse}
				---
			{/section}
		{/if}
		</td>
	</tr>
{/section}
</table>