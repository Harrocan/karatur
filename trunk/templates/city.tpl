<table class="" style="width:390px">
{section name=dr loop=$Data}
{assign value=$Data[dr] var='Row'}
{assign value=$smarty.section.dr.index var='Id'}
	{if $Row.posY==0}<tr>{/if}
	{if $Row.title}
		<td style="width:33%;vertical-align:top">
			<table class="table" style="width:100%">
				<tr>
					<td class="thead" style="text-align:center">{$Row.title}</td>
				</tr>
				{section name=di loop=$Row.fields}
				{assign value=$Row.fields[di] var="Item"}
				{assign value=$smarty.section.di.index var='Iid'}
				<tr>
					<td>
						{if $Item.type!='none'}
							{if $Item.type == 'module' && $Item.valid == false }
								<div style="color:gray" class="css-popup">
									{$Item.name}
									<div class="css-popup-content" style="left:100px;width:150px">
										Modul <b>{$Item.mod}</b> jest niekompletny lub nieprawidlowy
									</div>
								</div>
							{else}
								<a href="{$Item.file}{if $Item.query}?{$Item.query}{/if}">{$Item.name}</a>
							{/if}
						{/if}
					</td>
				</tr>
				{/section}
			</table>
		</td>
	{else}
		<td>&nbsp;</td>
	{/if}
	{if $Row.posY==3}</tr>{/if}
{/section}
</table>