{literal}
<style type="text/css">
	.tab thead th {
	text-align:center;
	font-weight:bold;
	}
</style>
{/literal}
{if $Step == ''}

	<a href="?step=add">Dodaj</a> rangê<br/>
	<a href="?step=assign">Nadaj</a> rangê graczowi<br/>
	
	<table class="tab">
		<thead>
			<th></th>
			<th>Nazwa</th>
			<th>Opcje</th>
		</thead>
		{foreach from=$R2P item=Item}
		<tbody>
			<td><img src="{$RANK_IMG_DIR}{$Item.image}"/></td>
			<td>{$Item.name}</td>
			<td><a href="?step=edit&rid={$Item.id}">edytuj</a> | <a href="?step=del&rid={$Item.id}">usuñ</a></td>
		</tbody>
		{/foreach}
	</table>
	<br/><br/>
	<table class="tab">
		
		{foreach from=$P2R item=Item key=Key}
		<thead>
			<th colspan="3"><img src="{$RANK_IMG_DIR}{$R2P[$Key].image}"/> {$R2P[$Key].name}</th>
		</thead>
		{section name=pr loop=$Item}
		{assign value=$Item[pr] var='pl2r'}
		<tbody>
			<td>{$pl2r.name}</td>
		</tbody>
		{/section}
		{/foreach}
	</table>

{elseif $Step == 'add' || $Step == 'edit'}
<fieldset>
<legend>Dodawanie rangi</legend>
<form method="POST" action="?step={if $Step=='add'}add{else}edit&rid={$Rank.id}{/if}">
<table style="width:100%">
<tbody>
	<td>Nazwa</td>
	<td><input type="text" name="rank[name]" style="width:200px;" value="{$Rank.name}"/></td>
</tbody>
<tbody>
	<td style="vertical-align:top">Obrazek</td>
	<td>
{section name=img loop=$Images}
{assign value=$Images[img] var="Img"}
{if $smarty.section.img.index > 0 && $smarty.section.img.index % 6 == 0}<br/>{/if}
<input type="radio" name="rank[image]" value="{$Img}" id="img_{$Img}"{if $Rank.image==$Img} checked="checked"{/if}/> <label for="img_{$Img}"><img src="{$RANK_IMG_DIR}{$Img}"/></label>

{sectionelse}
<b>Brak obrazków !!</b><br/>
Skopiuj obrazki rankg do folderu <b>{$RANK_IMG_DIR}</b>
<input type="hidden" name="rank[image]" value=""/>
{/section}
</td>
</tbody>
<tbody>
	<td colspan="2" style="text-align:right"><input type="submit" value="{if $Step=='add'}dodaj{else}edytuj{/if} rangê"/></td>
</tbody>
</table>
</form>
</fieldset>
<a href="?">Wróæ</a> do menu gównego
{elseif $Step == 'assign'}
	<form method="POST" action="?step=assign">
	ID gracza : <input type="text" name="user"/><br/>
	Ranga : <select name="rank">
	{section name=r loop=$Ranks}
	{assign value=$Ranks[r] var="Rank}
	<option value='{$Rank.id}'>{$Rank.name}</option>
	{/section}
	</select><br/>
	<input type="submit" value="nadaj range"/>
	</form>
	<a href="?">Wróæ</a> do menu gównego
{/if}