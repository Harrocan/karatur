{literal}
<style type="text/css">
.img-filetype{
width:25px;
height:25px;
}
.not_writable{
color:gray;
}
.filer-actions{
text-align:right;
}
</style>
<script type="text/javascript">
	function promptDel( filename ) {
		if( confirm( "Czy na pewno chcesz usun±æ plik `" + filename + "` ?\nJest to akcja nieodwracalna !" ) ) {
			window.location = "?del=" + encodeURI( filename );
		}
	}
</script>
{/literal}
<div style="position:relative">
{if $Page!='add'}<a href="?action=add"><img src="images/filer/btn-add.gif"/></a> {/if}{if $Page!='tree'}<a href="?"><img src="images/filer/btn-tree.gif"/></a> {/if}{if $Page!='history'}<a href="?action=history"><img src="images/filer/btn-history.gif"/></a> {/if}<a href="?action=logout"><img src="images/filer/btn-logout.gif" style="position:absolute;right:0px;"/></a>
</div>

{if $Page == 'tree'}
<table cellpadding="0" cellspacing="0" class="table" style="width:100%">
<tr>
	<td colspan="10" class="thead" style="text-align:center">Obecny folder : <b>{$SessFiler.dir}</b></td>
</tr>
{section name=dirL loop=$DirList}
{assign value=$DirList[dirL] var="Item"}
	<tr>
		<td class="img-filetype"><img src="images/filer/filetype_{$Item.filetype}.gif"/></td>
		<td>{if $Item.filetype=='dir'}<a href="?cd={$Item.name}">{if $Item.name=='..'}do katalogu wy¿ej{elseif $Item.name=='.'}od¶wie¿ obecny katalog{else}{$Item.name}{/if}</a>{else}<span class="{if !$Item.writable}not_writable {/if}">{$Item.name}</span>{/if}</td>
		{if $Item.filetype=='file'}
		<td>{$Item.ext}</td>
		<td>{$Item.size}</td>
		<td class="filer-actions">
			<a href="?getfile={$Item.name}"><img src="images/filer/action_get.gif"/></a>
			{if $Item.writable}<img src="images/filer/action_del.gif" onclick="promptDel( '{$Item.name}' )"/>{else}<img src="images/filer/action_no.gif"/>{/if}
		</td>
		{else}
		<td colspan="10"></td>
		{/if}
	</tr>
{/section}
</table>
{elseif $Page == 'add'}
{elseif $Page == 'history'}
{literal}
<script type="text/javascript">
	function toggleDisplay( type ) {
		var state = document.getElementById( 'tgl-' + type ).checked;
		//alert( state );
		var tab = document.getElementById( 'hst_tab' );
		var rows = tab.getElementsByTagName( 'tr' );
		for( var i = 0; i < rows.length; i++ ) {
			//alert( rows[i].className );
			if( rows[i].className == 'hst-action-' + type ) {
				//alert( rows[i].style.display );
				if( state ) {
					//alert
					rows[i].style.display = 'table-row';
				}
				else {
					rows[i].style.display = 'none';
				}
			}
		}
	}
</script>
{/literal}
<div> 
Filtruj : 
<input type="checkbox" id="tgl-del" checked="checked"  onclick="toggleDisplay( 'del' )"/>
<label for="tgl-del"><img src="images/filer/action_del.gif"/>kasacje</label> 
<input type="checkbox"  id="tgl-get" onclick="toggleDisplay( 'get' )" checked="checked"/>
<label for="tgl-get"><img src="images/filer/action_get.gif"/>pobrania</label>
 <input type="checkbox"  id="tgl-put" onclick="toggleDisplay( 'put' )" checked="checked"/>
 <label for="tgl-put"><img src="images/filer/action_put.gif"/>zapisania</label>
</div>
<table class="table" id="hst_tab">
	<tr>
		<td class="thead" colspan="2">Plik</td>
		<td class="thead">Uzytkownik</td>
		<td class="thead">Data</td>
	</tr>
{section name=hst loop=$History}
{assign value=$History[hst] var="Item"}
	<tr class="hst-action-{$Item.action}">
		<td class="thead"><img src="images/filer/action_{$Item.action}.gif"/></td>
		<td>{$Item.dir}{$Item.file}</td>
		<td>{$Item.uname}</td>
		<td>{$Item.date}</td>
	</tr>
{/section}
</table>
{/if}