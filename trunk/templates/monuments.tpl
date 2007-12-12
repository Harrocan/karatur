<center><img src="monument1.jpg"></center>
<table width="100%">
	{section name=t loop=$Tops}
	{if ($smarty.section.t.index+1)%2!=0}
	<tr>
	{/if}
		<td>
			<table class="table" class="table" width="100%">
				<tr>
					<td class="thead" colspan="2" align="center">{$Title[t]}</td>
				</tr>
				{section name=v loop=$Tops[t] }
					<tr>
						<td width="160px">{$Tops[t][v][1]}({$Tops[t][v][0]})</td>
						<td>{$Tops[t][v][2]}</td>
					</tr>
				{/section}
			</table>
		</td>
	{if ($smarty.section.t.index+1)%2==0}
		
	</tr>
	{/if}
	{/section}
</table><br>