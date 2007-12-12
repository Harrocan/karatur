{literal}
<style type="text/css">
.data{
background-color:#0c1335;
}
.data-menu{
background-color:#0b6115;
}
</style>
{/literal}
<table>
<br>
<ul>
<li><a href="panelm.php?step=CreTab">Dodaj gotowa tabele</a>
<li><a href="panelm.php?step=DropTab">Usun tabele</a>
<li><a href="panelm.php?step=EditTab">Edytuj tabele</a>
</ul>
{if $Step=="CreTab"}
<tr><td>
	<form enctype="multipart/form-data" action="panelm.php?step=CreTab&action=Add" method="post">
	Dodaj tabele:(tabela.sql) <input name="plik" type="file"><br>
	<input type="submit" value="Wyslij">
	</form>
</td></tr>
{/if}
{if $Step=="DropTab"}
<tr>
	<form action="panelm.php?step=DropTab&action=Del" method="POST">
	<td>Podaj nazwe tabeli: 
	<select name="nazwa">
	{foreach from=$tabs key=key1 item=obj}
		{foreach from=$obj key=key2 item=tab}
			<option value={$tab}>{$tab}</option>
		{/foreach}
	{/foreach}
	</select>
	<input type=submit value="usuñ"></td>
	</form>
</tr>
{/if}
{if $Step=="EditTab"}
	<tr>
	<form action="panelm.php?step=EditTab&action=Sel&limit=0" method="POST">
	<td>Podaj nazwe tabeli:
	<select name="nazwa">
	{foreach from=$tabs key=key1 item=obj}
		{foreach from=$obj key=key2 item=tab}
			<option value={$tab} {if $nazwa==$tab}selected{/if}>{$tab}</option>
		{/foreach}
	{/foreach}
	</select><br>
	"SELECT"(pole, pole...): <input type=text name="pole"><br>
	"WHERE"(warunek AND warunek...): <input type=text name="war"><br>
	<input type=submit value="poka¿"></td>
	</form>
	</tr>

	<tr><td>
	{if $met!=''}
		<hr>
		<table>
		Edycja tabeli: <i>{$nazwa}</i>. <a href="panelm.php?step=RecAdd&action=Show&nazwa={$nazwa}">Dodaj Rekord</a> Rekordy od {$limit}({$record})
		{if $limit>0}
			<form action="panelm.php?step=EditTab&action=Sel&limit={$limit-20}" method="POST">
			<input type="hidden" value="{$met}" name="met">
			<input type="hidden" value="{$pole}" name="pole">
			<input type=submit value="<<" {popup text='Poprzednie 20 recordów' fgcolor='black' bgcolor='black' textcolor='white' border=1 vauto=TRUE}>
			<input type="hidden" name="nazwa" value={$nazwa}>
		</form>
		{/if}
		{if ($limit+20)<$record}
			<form action="panelm.php?step=EditTab&action=Sel&limit={$limit+20}" method="POST">
			<input type="hidden" value="{$met}" name="met">
			<input type="hidden" value="{$pole}" name="pole">
			<input type=submit value=">>" {popup text='Nastêpne 20 recordów' fgcolor='black' bgcolor='black' textcolor='white' border=1 vauto=TRUE}>
			<input type="hidden" name="nazwa" value={$nazwa}>
			</form>
		{/if}
		
		</table>
		</td></tr>
		<tr><td>	
		<div style="width:390px;position:relative;overflow:auto">
		<table>
		<tr>
		<td background="black"></td>
		{section name=n loop=$nazw}
			<td class="data-menu">{$nazw[n]}</td>
		{/section}
		</tr>
		{assign value=$limit var='i'}
		{section name=d loop=$data}
			<tr>
			<form action="panelm.php?step=EditTab&action=Del" method="POST">
			<td valign="top"><input type="submit" value="Usuñ">
			<input type="hidden" name="nazwa" value="{$nazwa}">
			<input type="hidden" name="met" value="{$met}">
			<input type="hidden" name="i" value="{$i}">
			</form>
			<form action="panelm.php?step=EditTab&action=Edit" method="POST">
			<input type="submit" value="Edytuj"></td>
			<input type="hidden" name="nazwa" value="{$nazwa}">
			<input type="hidden" name="met" value="{$met}">
			<input type="hidden" name="i" value="{$i}">
			</form>
			{assign value=$i+1 var='i'}
			{section name=nn loop=$nazw}
				{assign value=$nazw[nn] var='a'}
				<td valign="top" class="data">{$data[d][$a]}</td>
			{/section}
			</tr>
		{/section}
		</table>
		</div>
	{/if}
	{if $action=="Edit"}
		<hr>
		<div style="width:390px;position:relative;overflow:auto">
		<table>
		<tr><td>Edycja tabeli <i>{$nazwa}</i></td>
		<form action="panelm.php?step=EditTab&action=Update" method="POST">
		<input type="hidden" name="met" value="{$mett}">
		<input type="hidden" name="nazwa" value="{$nazwa}">
		<td><input type="submit" value="Uaktualnij"></td></tr>
		<tr><td colspan=2><hr></td></tr>
		{assign value=0 var=i}
		{foreach from=$data[0] item=obj key=key}
		<tr>
			<td class="data-menu">{$key}</td>
			<td>{if $type[$i]=='1'}<textarea cols="40" rows="20" name={$key}>{$obj}</textarea>{/if}
			{if $type[$i]=='0'}<input type="text" name={$key} size="43" value='{$obj}'>{/if}</td>
		</tr>
		{assign value=$i+1 var=i}
		{/foreach}
		<tr><td colspan=2><hr></td></tr>
		<tr><td>Edycja tabeli <i>{$nazwa}</i></td><td><input type="submit" value="Uaktualnij"></td></tr>
		</form>
		</table>
		</div>
	{/if}
	</td></tr>
{/if}
{if $Step=="RecAdd"}
	{if $action=="Show"}
		<tr><td><hr>
		<div style="width:390px;position:relative;overflow:auto">
		<table>
		<form action="panelm.php?step=RecAdd&action=Add" method="POST">
		<input type="hidden" name="nazwa" value="{$nazwa}">
		Rekord tablicy <i>{$nazwa}</i>
		<tr><td><input type="submit" value="Dodaj Rekord"></td></tr>
		<tr><td class="data">Nazwa</td><td class="data">Typ</td><td class="data">Zawartosc</td></tr>
		{section name=t loop=$nazw}
		<tr>
			<td class="data-menu">{$nazw[t].Field}</td>
			<td class="data-menu">{$nazw[t].Type}</td>
			<td>{if ($nazw[t].Type=='text')}<textarea cols="40" rows="20" name={$nazw[t].Field}>{$nazw[t].Default}</textarea>{/if}
			{if ($nazw[t].Type!='text')}<input type="text" name={$nazw[t].Field} size="43" value="{$nazw[t].Default}">{/if}</td>
		</tr>
		{/section}
		<tr><td><input type="submit" value="Dodaj Rekord"></td></tr>
		</form>
		</table>
		</div>
		</td></tr>
	{/if}
{/if}
</table>
