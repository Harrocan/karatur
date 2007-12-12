{if $Step == ''}
	{literal}
	<style type="text/css">
		.map-mini {
		width:15px;
		height:15px;
		padding:0px;
		border:0px;
		margin:0px;
		z-index:1;
		}
		.desc-ok {
		color: green;
		font-weight:bold;
		}
		.desc-none {
		color: red;
		font-style:italic;
		}
		.navig-btn{
		padding:0px;
		width:28px;
		height:28px;
		}
		.navig-img{
		padding:0px;
		margin:0px;
		width:20px;
		height:20px;
		border:0px;
		}
	</style>
	<script language="JavaScript" src="js/ajax_base.js"></script>
	<script type="text/javascript">
		function toggleDesc( x, y, type ) {
			var item = $( x + '-' + y + '-' + type );
			var marker = $( x + '-' + y + '-' + type + '-marker' );
			var div = $( x + '-' + y + '-div' );
			var width = Number( div.style.width.replace( 'px', '' ) );
			var left = Number( div.style.left.replace( 'px', '' ) );
			//alert( width );
			if( item.style.display == 'none' ) {
				item.style.display = 'block';
				marker.innerHTML = '-';
				width += 200;
				left -= 200;
			}
			else {
				item.style.display = 'none';
				marker.innerHTML = '+';
				left += 200;
				width -= 200;
			}
			div.style.width = width + 'px';
			div.style.left = left + 'px';
		}

	</script>
	{/literal}
	<form method="POST" action="?">
	<table class="table" style="margin:0px auto">
		<tr>
			<td colspan="3" class="thead" style="text-align:center">Nawigacja</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<button name="move[up]" class="navig-btn"><img src="foo.jpg" class="navig-img"/></button>
			</td>
			<td></td>
		</tr>
		<tr>
			<td>
				<button name="move[left]" class="navig-btn"><img src="foo.jpg" class="navig-img"/></button>
			</td>
			<td><button onclick="window.location='edycja_mapy.php';return false;" class="navig-btn"><img src="foo.jpg" class="navig-img"/></button></td>
			<td>
				<button name="move[right]" class="navig-btn"><img src="foo.jpg" class="navig-img"/></button>
			</td>
		</tr>
		<tr>
			<td></td>
			<td><button name="move[down]" class="navig-btn"><img src="foo.jpg" class="navig-img"/></button></td>
			<td></td>
		</tr>
	</table>
	</form>
	<div style="width:380px;border:solid 1px">
	<table class="table" cellspacing="1" cellpadding="0">
	{foreach from=$MapData item='Row' key='keyX'}
		<tr>
		{foreach from=$Row item='Node' key='keyY'}
			<td style="width:30px;height:30px;position:relative"><img src="mapa-big/{$keyX}_{$keyY}.png" style="width:30px;height:30px;position:absolute"/>{strip}
				{if $Node.name}
					<div class="css-popup" style="display:block;width:30px;height:30px;">
						{if $keyY < $MapLim.minx || $keyY > $MapLim.maxx || $keyX < $MapLim.miny || $keyX > $MapLim.maxy }
							<img src="images/map/map_lock.gif" class="map-mini" />
						{/if}
						{if $Node.type == 'C'}
							<img src="images/map/type_c.gif" class="map-mini" />
						{elseif $Node.type == 'L'}
							<img src="images/map/type_l.gif" class="map-mini" />
						{elseif $Node.type == 'O'}
							<img src="images/map/type_o.gif" class="map-mini" />
						{/if}
						{if $Node.ref_id != '0'}
							<img src="images/map/type_r.gif" class="map-mini" />
						{/if}
						
						{if $Node.dost == 'nie'}
							<img src="images/map/dost_nie.gif" class="map-mini" />
						{/if}
						<div id="{$keyX}-{$keyY}-div" class="css-popup-content" style="width:200px;top:20px;left:20px;background:black;z-index:5">
							<table class="table" style="width:100%">
								{if $Node.ref_id != '0'}
								<tr>
									<td colspan="2"><b>Uwaga ! £±cze do pola {$Node.ref_y}x{$Node.ref_x}</b></td>
								</tr>
								{/if}
								<tr>
									<td>Wsp.</td>
									<td>{$keyX}x{$keyY}</td>
								</tr>
								<tr>
									<td>Nazwa</td><td>{$Node.name}</td>
								</tr>
								{if $Node.type == 'C'}
								<tr>
									<td>Pañstwo</td>
									<td>{$Node.country}</td>
								</tr>
								{/if}
								<tr>
									<td>Opis</td></td>
									<td>
										{if $Node.opis}
											<div class="desc-ok" style="position:relative">ok<span id="{$keyX}-{$keyY}-desc-marker" style="position:absolute;right:1px;top:1px;cursor:pointer" onclick="toggleDesc( {$keyX}, {$keyY}, 'desc' )">+</span></div>
											<div id="{$keyX}-{$keyY}-desc" style="display:none">{$Node.opis}</div>
											
										{else}
											<span class="desc-none">brak</span>
										{/if}
									</td>
								</tr>
								<tr>
									<td>Geografia</td></td>
									<td>
										{if $Node.geo}
											<div class="desc-ok" style="position:relative">ok<span id="{$keyX}-{$keyY}-geo-marker" style="position:absolute;right:1px;top:1px;cursor:pointer" onclick="toggleDesc( {$keyX}, {$keyY}, 'geo' )">+</span></div>
											<div id="{$keyX}-{$keyY}-geo" style="display:none">{$Node.geo}</div>
										{else}
											<span class="desc-none">brak</span>
										{/if}
									</td>
								</tr>
								<tr>
									<td>Flora</td></td>
									<td>
										{if $Node.flora}
											<div class="desc-ok" style="position:relative">ok<span id="{$keyX}-{$keyY}-flora-marker" style="position:absolute;right:1px;top:1px;cursor:pointer" onclick="toggleDesc( {$keyX}, {$keyY}, 'flora' )">+</span></div>
											<div id="{$keyX}-{$keyY}-flora" style="display:none">{$Node.flora}</div>
										{else}
											<span class="desc-none">brak</span>
										{/if}
									</td>
								</tr>
								<tr>
									<td>Dostep</td></td>
									<td>
										{if $Node.dost == 'tak'}
											<span class="desc-ok">ok</span>
										{else}
											<span class="desc-none">pole zablokowane</span>
										{/if}
									</td>
								</tr>
								<tr>
									<td></td>
									<td><a href="?step=edit&x={$keyX}&y={$keyY}">edytuj</a></td>
								</tr>
							</table>
						</div>
					</div>
				{else}
					<a href="?step=edit&x={$keyX}&y={$keyY}" class="css-popup" style="display:block;width:30px;height:30px">
						{if $keyY < $MapLim.minx || $keyY > $MapLim.maxx || $keyX < $MapLim.miny || $keyX > $MapLim.maxy }
							<img src="images/map/map_lock.gif" class="map-mini" />
						{/if}
						<div class="css-popup-content" style="width:100px;top:20px;left:20px;text-align:center">{$keyX}x{$keyY}<br/>dodaj wpis</div>
					</a>
				{/if}
			{/strip}</td>
		{/foreach}
		</tr>
	{/foreach}
	</table>
	</div>
{elseif $Step == 'edit'}
{literal}
<script type="text/javascript">
function toggleRefForm() {
	var el = $('refForm');
	var text = $('refValue');
	var typeDef = $( 'refTypeDef' );
	var dostDef = $( 'refDostDef' );
	if( el.style.display != 'none' ) {
		el.style.display = 'none';
		text.setAttribute( 'disabled', 'disabled' );
		typeDef.setAttribute( 'disabled', 'disabled' );
		dostDef.setAttribute( 'disabled', 'disabled' );
	}
	else {
		el.style.display = 'table-row';
		text.removeAttribute( 'disabled' );
		typeDef.removeAttribute( 'disabled' );
		dostDef.removeAttribute( 'disabled' );
	}
}
function testForm() {
	var ret = true;
	var msg = '';
	var refSwitch = $( 'refSwitch' );
	var typeDef = $( 'refTypeDef' );
	var dostDef = $( 'refDostDef' );
	var fieldName = $( 'fieldName' );
	if( !refSwitch.checked ) {
		//for( var i = 0; i < formType.lenght; i++ )
		if( typeDef.checked ) {
			var ret = false;
			msg += "niew³a¶ciwy typ pliku wybrany \n";
		}
		if( dostDef.checked ) {
			var ret = false;
			msg += "niew³a¶ciwy dostêp wybrany \n";
		}
	}
	else {
		if( fieldName.lenght() <= 0 ) {
			var ret = false;
			msg += "Uzupe³nij co najmniej nazwê pola\n";
		}
	}
	
	if( !ret ) {
		alert( "Nie wszystkie opcje zosta³y wype³nione :\n" + msg );
	}
	return ret;
}
</script>
{/literal}
<fieldset>
	<legend>Edycja elementu mapy</legend>
	<form method="POST" action="?step=edit" name="editForm">
	<input type="hidden" name="map_x" value="{$Elem.zm_x}"/>
	<input type="hidden" name="map_y" value="{$Elem.zm_y}"/>
	<table class="table" style="width:100%">
		<tr>
			<td colspan="2" class="thead">Pozycja : {$Elem.zm_y}x{$Elem.zm_x}</td>
		</tr>
		<tr>
			<td colspan="2"><input type="checkbox" id="refSwitch" onclick="toggleRefForm()"{if $Elem.ref_id != '0'} checked="checked"{/if}/> Zaznacz to pole je¶li chcesz ¿eby ta lokacja by³a ³±czem </td>
		</tr>
		<tr id="refForm" style="display:{if $Elem.ref_id != '0'}table-row{else}none{/if}">
			<td>£±cze do</td><td><input type="text" id="refValue"{if $Elem.ref_id != '0'} value="{$Elem.ref_y}x{$Elem.ref_x}"{/if} name="ref_id"/> (wspó³rzêdne w formacie AAxBB)</td>
		</tr>
		<tr>
			<td>Nazwa</td><td><input type="text" id="fieldName" name="name" value="{$Elem.name}" style="width:200px;"/></td>
		</tr>
		<tr>
			<td>Plik</td><td><input type="text" name="file" value="{$Elem.file}" style="width:200px;"/></td>
		</tr>
		<tr>
			<td>Pañstwo</td><td><input type="text" name="country" value="{$Elem.country}" style="width:200px;"/></td>
		</tr>
		<tr>
			<td>Opis</td><td><textarea name="opis" style="width:100%;height:100px">{$Elem.opis}</textarea></td>
		</tr>
		<tr>
			<td>Geografia</td><td><textarea name="geo" style="width:100%;height:100px">{$Elem.geo}</textarea></td>
		</tr>
		<tr>
			<td>Flora</td><td><textarea name="flora" style="width:100%;height:100px">{$Elem.flora}</textarea></td>
		</tr>
		<tr>
			<td>Typ pliku</td>
			<td>
				<input type="radio" name="type" value="C" {if $Elem.type=='C' || $Elem.type==''}checked="checked"{/if}/>Miasto<br/>
				<input type="radio" name="type" value="L" {if $Elem.type=='L'}checked="checked"{/if}/>Lokacja<br/>
				<input type="radio" name="type" value="O" {if $Elem.type=='O'}checked="checked"{/if}/>Inne/brak<br/>
				<input type="radio" id="refTypeDef" name="type" value="" {if $Elem.ref_id!='0' && $Elem.type==''}checked="checked" {/if}{if $Elem.ref_id=='0'}disabled="disabled"{/if}/><i>warto¶æ pobierana z '³±cza'</i><br/>
			</td>
		</tr>
		<tr>
			<td>Dostêp</td>
			<td>
				<input type="radio" name="dost" value="tak" {if $Elem.dost=='tak' || $Elem.type==''}checked="checked"{/if}/>Pole dostêpne<br/>
				<input type="radio" name="dost" value="nie" {if $Elem.dost=='nie'}checked="checked"{/if}/>Na pole nie mo¿na wchodziæ (woda, przepa¶æ itp)<br/>
				<input type="radio" id="refDostDef" name="dost" value="" {if $Elem.ref_id!='0' && $Elem.dost==''}checked="checked" {/if}{if $Elem.ref_id=='0'}disabled="disabled"{/if}/><i>warto¶æ pobierana z '³±cza'</i><br/>
			</td>
		</tr>
		<tr>
			<td style="text-align:left"><input type="submit" onclick="window.location='edycja_mapy.php'; return false;" value="anuluj"/></td>
			<td style="text-align:right"><input type="submit" onclick="return testForm()" value="zapisz zmiany"/></td>
		</tr>
	</table>
	</form>	
</fieldset>
{/if}