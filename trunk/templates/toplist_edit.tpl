{if $Step == ''}
<a href="?step=add">Dodaj topliste</a><br/><br/>
<table class="table">
	{section name=t loop=$Tops}
	{assign value=$Tops[t] var='Top'}
	<tr>
		<td>{$Top.id}</td>
		<td>{$Top.link}</td>
		<td style="position:relative;height:35px">{$Top.entry}</td>
		<td><a href="?step=edit&tid={$Top.id}">edytuj</a></td>
		<td><a href="?step=del&tid={$Top.id}">usun</a></td>
	</tr>
	{/section}
</table>
{/if}

{if $Step == 'add'}
<form method="post" action="?step=add">
	Podaj link : <br/>
	<textarea name="link" style="width:100%;height:50px"></textarea><br/>
	Podaj kod obrazka : <br/>
	<textarea name="entry" style="width:100%;height:50px"></textarea><br/>
	<input type="submit" value="dodaj !"/><br/><br/>
</form>
Pomoc :<br/>
Kazdy link podawany przez topliste wyglada mniej wiecej tak :<br/>
<pre>&lt;a href="http://jakis_adres_internetowy"&gt;
	kod obrazka
&lt;/a&gt;
</pre>
gdzie <b>kod obrazka</b> to moze byc zwykly napis, moze to byc jakis znacznk &lt;img&gt; a moze to byc para znacznikow &lt;span&gt; &lt;/span&gt;. W kazdym razie, jako link podajesz wyciagniety <i>http://jakis_adres_internetowy</i>, a jako adres obrazka podajesz wszystko co sie znajduje pomiedzy znacznikami &lt;a&gt;&lt;/a&gt;
{/if}

{if $Step == 'edit'}
<form method="post" action="?step=edit&tid={$Top.id}">
	Podaj link : <br/>
	<textarea name="link" style="width:100%;height:50px">{$Top.link}</textarea><br/>
	Podaj kod obrazka : <br/>
	<textarea name="entry" style="width:100%;height:50px">{$Top.entry}</textarea><br/>
	<input type="submit" value="edytuj !"/><br/><br/>
</form>
{/if}