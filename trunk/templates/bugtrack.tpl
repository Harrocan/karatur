{literal}
<style type="text/css">
.new {
	background-color: #FF0000;
}
.solved {
	background: #00FF00;
}
</style>
{/literal}
<table class="table" width="100%">
	<tr>
		<td class="thead">Bugtrack</td>
	</tr>
{section name=b loop=$Bugs}
	<tr>
		<td style="border-top-style:solid; border-width:thin;background-color: {if $Bugs[b].new=='Y'}#7b1212{else}#0c4e1b{/if};">
			Bug nr <b>{$Bugs[b].num}</b> , ostatni raz: {$Bugs[b].time}
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<table width="100%">
				<tr>
					<td>Ilosc</td>
					<td>{$Bugs[b].amount}</td>
				</tr>
				<tr>
					<td>Plik</td>
					<td>{$Bugs[b].file}</td>
				</tr>
				<tr>
					<td>Linia</td>
					<td>{$Bugs[b].line}</td>
				</tr>
				<tr>
					<td>URL</td>
					<td>{$Bugs[b].url}</td>
				</tr>
				<tr>
					<td>Komunikat</td>
					<td class="thead">{$Bugs[b].desc}</td>
				</tr>
				<tr>
					<td>Backtrace</td>
					<td class="thead"><pre style="width:300px;overflow:auto">{$Bugs[b].backtrace}</pre></td>
				</tr>
				<tr>
					<td colspan="2">
						{if $Bugs[b].new=='Y'}
							<a href="?action=solve&id={$Bugs[b].id}">oznacz jako rozwiazany</a>
						{else}
							rozwiazany przez <b>{$Bugs[b].user}</b>
						{/if}
					</td>
				</tr>
			</table>
		</td>
	</tr>
{/section}
</table>