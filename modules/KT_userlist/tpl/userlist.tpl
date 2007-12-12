<div style="text-align:center;font-weight:bold">Obecnie w krainie</div>
{section name=od loop=$userlist}
{assign value=$userlist[od].data var='Data'}
<div class="pl-list">
	<img src="images/ranks/{$Data.image}"/> <a href="view.php?view={$Data.id}">{$Data.user}</a>{if $Data.tribeimg != ''} <img src="images/tribes/mini/{$Data.tribeimg}"/>{/if}
	<div class="pl-data">
		<div class="pl-list-title">{$Data.user} ({$Data.id})</div>
		{if $Data.avatar}
		<img src="avatars/thumb_{$Data.avatar}" alt="{$Data.user}" class="pl-list-img"/>
		{/if}
		Poziom: {$Data.level}<br/>
		W krainie: {$Data.age} dni<br/>
		Rasa: {$Data.rasa}<br/>
		
		Miejsce: {$Data.miejsce}<br/>
		Widziany: {$Data.page}<br/>
		Ranga: {$Data.rankname}<br/>
		Opis: {$Data.opis}<br/>
	</div>
</div>
{/section}<br/>
<div style="text-align:center;border-top:solid 1px">
	Po ulicach chodzi <b>{$usercurrent}</b> osób<br/>
	W krainie mieszka <b>{$usertotal}</b> istot
</div>