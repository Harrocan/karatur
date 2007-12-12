{if $View == ''}
{literal}
<style type="text/css">
	.change-list{
	list-style-type:square;
	}
	.change-author{
	font-style:italic;
	color:rgb( 0, 128, 0 );
	}
</style>
{/literal}
{if $Rank_changelog}<a href="?view=add">Dodaj wpis</a><br/><br/>{/if}
{foreach from=$Changes item='Date' key='keyDate'}
{$keyDate}
<ul>
	{if !empty( $Date.core ) }
	<b>Zmiany w silniku KT</b>
{section name=cc loop=$Date.core}
{assign value=$Date.core[cc] var='Item}
	<li class="change-list">{$Item.body} <span class="change-author">&lt;{$Item.user}&gt;</span></li>
{/section}
	<br/>
	{/if}
	{if !empty( $Date.module )}
	<b>Zmiany w modulach</b>
	<ul>
	{foreach from=$Date.module item='Mod' key='keyMod'}
		Modul <b>{$keyMod}</b>
		{section name=cm loop=$Mod}
		{assign value=$Mod[cm] var='Item'}
			<li class="change-list">{$Item.body} <span class="change-author">&lt;{$Item.user}&gt;</span></li>
		{/section}
	{/foreach}
	</ul>
	{/if}
</ul>
{/foreach}
{elseif $View == 'add'}
{literal}
<script type="text/javascript">
	function addChange() {
		var nodes = document.getElementsByName( 'change-area' );
		//alert( nodes.length );
		var id = nodes.length + 1;
		var node = document.createElement( 'div' );
		node.innerHTML = "#" + id + "<textarea class=\"area\" name=\"change[]\"></textarea>";
		document.getElementById( 'changes' ).appendChild( node );
	}
	function toggleDate() {
		var node = document.getElementById( 'change-date-now' );
		//alert( node.checked );
		if( node.checked ) {
			document.getElementById( 'change-date' ).setAttribute( 'disabled', 'disabled' );
		}
		else {
			document.getElementById( 'change-date' ).removeAttribute( 'disabled' );
		}
	}
</script>
<style type="text/css">
	.area{
	width:250px;
	height:70px;
	vertical-align:middle;
	}
</style>
{/literal}
<form method="POST" action="?view=add">
	<fieldset>
		<legend>Dodaj wpis</legend>
		Data : <input id="change-date-now" type="checkbox" name="date-now" value="1" checked="checked" onclick="toggleDate()"/> Dzisiejsza data<br/>
		Wlasna data : <input id="change-date" type="text" name="date" value="YY-mm-dd" disabled="disabled"/><br/>
		Podaj wprowadzone modyfikacje, po jednej na jedno pole <br/>
		<div id="changes">
		<div name="change-area">
			#1<textarea class="area" name="change[]"></textarea>
		</div>
		</div>
		<a onclick="addChange()">Dodaj pole</a><br/><br/>
		<input type="submit" value="kontunuuj" />
	</fieldset>
</form>
{/if}