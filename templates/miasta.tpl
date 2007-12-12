{if $View=='edit'}
<script language="JavaScript" src="js/ajax_base.js"></script>
<script language="JavaScript" src="js/miasta.js"></script>
<div style="position:relative">
<table class="table" style="width:95%">
{section name=dr loop=$Data}
{assign value=$Data[dr] var='Row'}
{assign value=$smarty.section.dr.index var='Id'}
	{if $Row.posY==0}<tr>{/if}
		<td style="width:33%;vertical-align:top">
			<table style="width:100%">
				
				<tr>
					<td id='city-{$Id}-title' class="thead" style="text-align:center">{$Row.title}</td>
				</tr>
				{section name=di loop=$Row.fields}
				{assign value=$Row.fields[di] var="Item"}
				{assign value=$smarty.section.di.index var='Iid'}
				<tr>
					<td id='city-{$Id}-fields-{$Iid}' type="{$Item.type}" colspan="2">
						{if $Item.type!='none'}
							<a class="css-popup">{$Item.name}
								<div class="css-popup-content" style="top:1px;left:100px;width:200px">
								<table cellpadding="0" cellspacing="2">
									<tr>
										<td style="vertical-align:top">Nazwa: </td>
										<td id='city-{$Id}-fields-{$Iid}-name'>{$Item.name}</td>
									</tr>
									<tr>
										<td>Typ: </td><td id='city-{$Id}-fields-{$Iid}-type'>{$Item.type}</td>
									</tr>
									<tr>
										<td>Plik/modul: </td><td id='city-{$Id}-fields-{$Iid}-option'>{$Item.file}</td>
									</tr>
									<tr>
										<td>Parametry: </td>
										<td>?<span id='city-{$Id}-fields-{$Iid}-query'>{if $Item.query}{$Item.query}{/if}</span></td>
									</tr>
								</table>
								</div>
							</div>
						{else}&nbsp;
						{/if}
					</td>
				</tr>
				{/section}
			</table>
			<hr/>
			<a onclick="editCity({$smarty.section.dr.index})" style="text-align:center;display:block">edytuj</a>
		</td>
	{if $Row.posY==3}</tr>{/if}
{/section}
</table>
<div id="layer_citysection" style="position:absolute;top:1px;left:1px;bottom:1px;right:1px;background:url( 'images/transparent.png' );display:none">
	<table border="0" style="width:100%;height:100%">
		<tr>
			<td>
				<form method="POST" action="?view=edit&cid={$Cid}">
				<input type="hidden" id="city-position" name="position"/>
				<table style="margin:0px auto;border:2px solid;background:#282828">
					<tr>
						<td colspan="2" style="text-align:center;font-weight:bold">Edycja dzielnicy</td>
					</tr>
					<tr>
						<td style="background:none;width:40px;">Nazwa</td><td><input id="city-title" type="text" name="title" style="width:200px"/></td>
					</tr>
				{section name=da loop=$DummyArr}
				{assign value=$DummyArr[da] var="index"}
					<tr>
						<td colspan="2" style="text-align:center;border-top:solid 1px">Obszar nr {$index+1}</td>
					</tr>
					<tr>
						<td>Nazwa</td>
						<td><input id="city-{$index}-name" type="text" name="fields[{$index}][name]" style="width:150px"/></td>
					</tr>
					<tr>
						<td>Funkcja</td>
						<td>
							<select id="city-{$index}-option" name="fields[{$index}][option]">
							{html_options options=$Files}
							</select>
						</td>
					</tr>
					<tr>
						<td>Opcje</td>
						<td><div class="css-popup"><input id="city-{$index}-query" type="text" name="fields[{$index}][query]" style="width:150px"/><div class="css-popup-content" style="top: 20px">w postaci : 'nazwa=wartosc'<br/>rozdzielone : przecinkiem, srednikiem lub znakiem &amp;</div></div></td>
					</tr>
					{/section}
						<tr>
							<td style="text-align:left">
								<input type="submit" onclick="cancelEdit(); return false;" value="anuluj"/>
							</td>
							<td style="text-align:right">
								<input type="submit" value="dalej"/>
							</td>
						</tr>
				</table>
				</form>
			</td>
		</tr>
	</table>
</div>
<div>
<a href="?">Wroc</a> do menu glownego
{/if}
{if $View==''}
<table border=0 class="table">
	<tr>
		<td class="thead">Wsp.</td>
		<td class="thead">Nazwa</td>
		<td class="thead">Pañstwo</td>
		<td class="thead">Dzielnic</td>
		<td class="thead">Pozycji</td>
		<td class="thead">akcje</td>
	{section name=c loop=$City}
		<tr>
			<td>{$City[c].zm_y}x{$City[c].zm_x}</td>
			<td>{$City[c].name}</td>
			<td>{$City[c].country}</td>
			<td>{$City[c].sectors}</td>
			<td>{$City[c].amount}</td>
			<td><a href="?view=edit&cid={$City[c].id}">edytuj</a></td>
		</tr>
	{/section}
</table>
{/if}