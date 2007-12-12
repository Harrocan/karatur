{literal}
<style type="text/css">
.atr{
border-bottom:solid 2px #0c1115;
}
span.atr-btn-minus{
background: #631A11;
cursor:pointer;
}
span.atr-btn-minus:hover{
background: #AF2D1E;
}
span.atr-btn-plus{
background: #0D2D0D;
cursor:pointer;
}
span.atr-btn-plus:hover{
background: #158C15;
}
</style>
<script type="text/javascript">
function atrAdd( key ) {
	atrMod( key, 1 );
}
function atrSub( key ) {
	atrMod( key, -1 );
}
function atrMod( key, val ) {
	var base = parseFloat( $( 'atr-' + key + '-base' ).innerHTML );
	var cur = parseFloat( $( 'atr-' + key + '-cur' ).innerHTML );
	var mlt = parseInt( $( 'atr-' + key + '-mlt' ).innerHTML );
	var left = parseInt( $( 'atr-left' ).innerHTML );
	//alert( base + " :: " + cur + " :: " + mlt );
	if( cur <= 0 && val < 0 ) {
		alert( "Nie mo¿esz bardziej obni¿yc tego atrybutu !" );
		return;
	}
	cur+=val;
	if( left <= 0 && val > 0 ) {
		alert( "Nie masz ju¿ wolnych punktów !" );
		return;
	}
	left-=val;
	var total = base + cur*mlt;
	$( 'atr-' + key + '-cur' ).innerHTML = cur;
	$( 'atr-left' ).innerHTML = left;
	$( 'atr-' + key + '-total' ).innerHTML = total;
}
function trySubmit() {
	var form = $( 'ap-form' );
	var atrArr = new Array( 'str', 'dex', 'con', 'int', 'wis', 'spd' );
	for( var i = 0; i < atrArr.length; i++ ) {
		var atr = atrArr[i];
		var val = Number( $( 'atr-' + atr + '-cur').innerHTML );
		//alert( atr + " : " + val );
		var f = document.createElement( 'input' );
		f.setAttribute( 'type', 'hidden' );
		f.setAttribute( 'name', 'atr['+atr+']' );
		f.setAttribute( 'value', val );
		form.appendChild( f );
	};
}
</script>
{/literal}
rozdysponuj atrybuty<br/><br/>

<table class="table" cellpadding="2" cellspacing="0">
	<tr>
		<td class="thead">Nazwa</td>
		<td class="thead" colspan="2">Bazowa</td>
		<td class="thead">Dodane</td>
		<td class="thead" colspan="2">Mno¿nik</td>
		<td class="thead" colspan="2">Razem</td>
	</tr>
{foreach from=$AtrArr item='Key'}
{assign value=$Atr[$Key] var='Item'}
	<tr>
		<td class="atr">{$Key}</td>
		<td class="atr" id="atr-{$Key}-base">{$Item.base}</td>
		<td class="atr"> + </td>
		<td class="atr" style="text-align:center"><span class="atr-btn-minus" onclick="atrSub( '{$Key}' )">-</span> <span id="atr-{$Key}-cur">0</span> <span class="atr-btn-plus" onclick="atrAdd( '{$Key}' )">+</span></td>
		<td class="atr"> x </td>
		<td class="atr" id="atr-{$Key}-mlt">{$Item.race+$Item.class}</td>
		<td class="atr"> = </td>
		<td class="atr" id="atr-{$Key}-total">{$Item.base}</td>
	</tr>
{/foreach}
<tr>
	<td></td>
	<td colspan="2">Pozosta³o</td>
	<td style="text-align:center" id="atr-left">{$Left}</td>
	<td colspan="10"></td>
</tr>
</table>
<form method="POST" id="ap-form" action="?"><input type="submit" value="rozdaj !" onclick="trySubmit()" /></form>