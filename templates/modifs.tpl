Glowny architekt zajmujacy sie sprawami KT wyjezdza na kilka miechow do pracy. Dotychczas tylko ja mialem mozliwosc dowolnej modyfikacji danych graczy, ktra wykorzystywalem przy karaniu na bugi itp. Teraz musze to komus przekazac. Nie pozwole sobie na udostepnienie calej bazy, wiec stworzylem specjalny panel, w ktorym mozna ogladac i modyfikowac wiekszosc potrzebnych danych graczy. Aby nie dochodzilo do naduzyc (jak kiedys, zanim tu sie zjawilem), kazde uzycie tego panelu jest monitorowane - i to sa wlasnie wyniki tego monitorowania. Dla waszego bezpieczenstwa, zebyscie sami mogli sprawdzac kto i co zmienia.
<br/><br/>
<div style="text-align:center;font-size:0.8em">
{section name=p loop=$Pages.total}
	{if $Pages.total[p]!=$Pages.cur}<a href="?page={$Pages.total[p]-1}">{$Pages.total[p]}</a>
	{else}{$Pages.total[p]}
	{/if}
{/section}
</div>
{foreach from=$Mods item='Item'}
{assign value=$Item.data var='Data'}
{assign value=$Item.det var='Det'}
<table>
	<tr>
		<td>Modyfikujacy</td>
		<td><a href="view.php?view={$Det.pid}">{$Det.user}</a></td>
	</tr>
	<tr>
		<td>Cel</td>
		<td><a href="view.php?view={$Det.tid}">{$Det.user_t}</a></td>
	</tr>
	<tr>
		<td>Rodzaj modyfikacji</td>
		<td>{$Det.type}</td>
	</tr>
	<tr>
		<td style="vertical-align:top">Powod</td>
		<td>{$Det.editreason}</td>
	</tr>
	<tr>
		<td>Data</td>
		<td>{$Det.date}</td>
	</tr>
	<tr>
		<td style="vertical-align:top">Zmodyfikowane pola</td>
		<td>
			<table class="table">
				<tr>
					<td class="thead">Nazwa</td>
					<td class="thead">Stara wart.</td>
					<td class="thead">Nowa wart.</td>
				</tr>
				{foreach from=$Data item='Val' key='Key'}
				<tr>
					<td>{$Key}</td>
					<td>{$Val.oldval}</td>
					<td>{$Val.newval}</td>
				</tr>
				{/foreach}
			</table>
		</td>
</table>
<hr>
{/foreach}