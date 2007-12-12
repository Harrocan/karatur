<script language="JavaScript" src="js/advajax.js"></script>
<script language="JavaScript" src="js/zgloszenia.js"></script>
<div id="error" class="error" style="display:none"></div>
	<ul>
		<li><a href="?action=view&type=E">B喚dy/bugi gry ({$Amount.bug}/{$Total.bug})</a>
		<li><a href="?action=view&type=V">Naruszenie regulaminu ({$Amount.regulamin}/{$Total.regulamin})</a>
		<li><a href="?action=view&type=M">奸uby ({$Amount.slub}/{$Total.slub})</a>
		<li><a href="?action=view&type=R">Rangi ({$Amount.rangi}/{$Total.rangi})</a>
		<li><a href="?action=view&type=C">Opinie/rady/uwagi ({$Amount.opinie}/{$Total.opinie})</a>
		<li><a href="?action=view&type=O">Inne ({$Amount.inne}/{$Total.inne})</a>
	</ul>
{if $Action=='view'}
	<table class="table" width=390px">
		<tr>
			<td class="thead" style="text-align:center">strony : {section name=p loop=$Pages}{if $Pages[p]==$Page}{$Pages[p]+1} {else}<a href="?action=view&type={$Type}&page={$Pages[p]+1}">{$Pages[p]+1}</a> {/if}{/section}</td>
		</tr>
		{section name=z loop=$Zgl}
		<tr>
			<td>
				<div id="zgl_{$Zgl[z].id}" class="{if $Zgl[z].solve=='N'}zgl_unsolved{else}zgl_solved{/if}">Zgloszenie nr <b>{$Zgl[z].num}</b></div>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<table width="100%">
					<tr>
						<td>Od</td>
						<td>{if $Zgl[z].user==""}<i>konto usuniete</i>{else}<a href="view.php?view={$Zgl[z].pid}">{$Zgl[z].user}</a>{/if}</td>
					</tr>
					<tr>
						<td>Data</td>
						<td>{$Zgl[z].date}</td>
					</tr>
					<tr>
						<td>Status</td>
						<td id="zgl_{$Zgl[z].id}_status">{if $Zgl[z].solve=='N'}nierozwi您any{else}rozwi您any przez <a href="view.php?view={$Zgl[z].solve_id}">{$Zgl[z].solve_user}</a>{/if}</td>
					</tr>
					<tr>
						<td style="width:40px">Temat</td>
						<td>{$Zgl[z].topic}</td>
					</tr>
					<tr>
						<td valign="top">Tresc</td>
						<td class="thead">{$Zgl[z].body}</td>
					</tr>
					<tr>
						<td valign="top">Akcje</td>
						<td>
							{if $Zgl[z].solve=='N'}<div id="zgl_{$Zgl[z].id}_actSolve">
								<a href="javascript:solveForm('{$Zgl[z].id}');">oznacz jako rozwi您any</a>
							</div>{/if}
							<div id="zgl_{$Zgl[z].id}_actMsg">
								<a href="javascript:msgForm('{$Zgl[z].id}');">napisz wiadomosc</a>
							</div>
						</td>
					</tr>
					<tr>
						<td valign="top">Historia</td>
						<td id="zgl_{$Zgl[z].id}_hist">
							{section name=h loop=$Zgl[z].hist}
							{assign value=$Zgl[z].hist[h] var='Hist'}
								<li>{if $Hist.type == 'MSG'}<i>wiadomosc</i> {elseif $Hist.type== 'SLV'}<b>rozwiazanie</b> {/if}: '{$Hist.body}'</li>
							{sectionelse}
								<i>brak akcji</i>
							{/section}
						</td>
					</tr>
				</table>
			</td>
		</tr>
		{*
		<tr>
			<td><a href="view.php?view={$Zgl[z].pid}">{$Zgl[z].user}</a></td>
			<td>{if $Zgl[z].solve=='N'}<b>nierozwi您any</b>{else}rozwi您any przez ID {$Zgl[z].solve_id}{/if}</td>
			<td>{$Zgl[z].date}</td>
		</tr>
		<tr>
			<td colspan=3>
				<strong>{$Zgl[z].topic}</strong> : {$Zgl[z].body}
			</td>
		</tr>
		<tr>
			<td colspan=3 align=right>{if $Zgl[z].solve=='N'}<a href="?action=solve&id={$Zgl[z].id}">oznacz jako rozwi您any</a>{/if}</td>
		</tr>
		*}
		{/section}
		<tr>
			<td class="thead" style="text-align:center">strony : {section name=p loop=$Pages}{if $Pages[p]==$Page}{$Pages[p]+1} {else}<a href="?action=view&type={$Type}&page={$Pages[p]+1}">{$Pages[p]+1}</a> {/if}{/section}</td>
		</tr>
	</table>
{/if}