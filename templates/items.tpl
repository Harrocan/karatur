Zarz±dzanie przedmiotami<br>
<br>
{if $Action==''}
<a href="items.php?action=add">Dodaj przedmiot</a><br>
<a href="?action=imageadd">Dodaj obrazki</a><br>
<br>
{section name=a loop=$Added}
	{$Added[a].Name} w bazie: <a href="?action=view&typ={$Added[a].type}">{$Added[a].amount}</a><br>
{/section}
Ogolem w bazie: {$Total}
{/if}
{if $Action=='add'}
	<form method="post" action="?action=add">
	Nazwa : <input type="text" name="name"><br>
	Efekt/moc : <input type="text" name="power" value="0"><br>
	Typ : <select name="type">
	<option value="W">Broñ
	<option value="S">Ró¿dzki
	<option value="H">He³m
	<option value="A">Pancerz
	<option value="D">Tarcza
	<option value="Z">Szata
	<option value="N">Nagolenniki
	<option value="B">£uk
	<option value="R">Strzaly
	<option value="G">Groty
	</select><br>
	Koszt : <input type="text" name="cost" value="0"><br>
	Minimalny poziom : <input type="text" name="minlev" value="0"><br>
	Zrêczno¶æ  : <input type="text" name="zr" value="0"> (lub jej ograniczenie)<br>
	Maksymalna wytrzyma³o¶æ : <input type="text" name="maxwt" value="0"><br>
	Szybko¶æ : <input type="text" name="szyb" value="0"> (w przypadku pancerzy pozostaw puste)<br>
	Magiczny : <input type="radio" name="magic" value="Y">Tak <input type="radio" name="magic" value="N" checked>Nie<br>
	Trucizna : <input type="text" name="poison" value="0"><br>
	Dwurêczny : <input type="radio" name="twohand" value="Y">Tak <input type="radio" name="twohand" value="N" checked>Nie<br>
	<input type="submit" value="Dodaj !">
	</form><br>
	<a href="items.php">Wróæ</a>
{/if}
{if $Action=='imageadd'}
	{if isset($Itemname)}Zmieniany przedmiot : <b>{$Itemname}</b><br>{/if}
	<fieldset>
		<legend><strong>Dodaj nowy plik</strong></legend>
		<form enctype="multipart/form-data" action="?action=imageadd" method="post">
		<input type="hidden" name="MAX_FILE_SIZE" value="102400">
		Nazwa pliku graficznego: <input name="plik" type="file"><br>
		{if !empty($Typ)}
			Rodzaj przedmiotu: {html_options name=foo options=$Cats selected=$Typ disabled=TRUE}<br>
			<input type="hidden" name='type' value="{$Typ}">
		{else}
			Rodzaj przedmiotu: {html_options name=type options=$Cats}<br>
		{/if}
		
		<input type="hidden" name="iid" value="{$Iid}">
		<input type="submit" value="Wyslij"></form>
	</fieldset>
	<br>
	<fieldset>
		{if !empty($Options) && !empty($Iid)}
		<legend><strong>Wybierz sposrod istniejacych</strong></legend>
		<form action="?action=imageadd" method="post">
			Rodzaj przedmiotu: {html_options name=foo options=$Cats selected=$Typ disabled=TRUE}<br>
			<input type="hidden" name='type' value="{$Typ}">
			{html_radios name=image options=$Options}<br>
			<input type="hidden" name="iid" value="{$Iid}">
			<input type="submit" value="Wyslij"></form>
		{elseif isset($Options)}
			<legend><strong>Obecnie zaladowane obrazki</strong></legend>
			{section name=i loop=$Options}
				{$Options[i]} 
			{/section}
		{else}
			<legend><strong>Obecnie zaladowane obrazki</strong></legend>
			Aby przegaldac zaladowane obrazki wybierz typ przedmiotu.<br>
			Aby przypisywac zaladowane obrazki wejdz w liste przedmiotow [<a href="?">pietro wyzej</a>] i wybierz przedmiot do edycji
		{/if}
	</fieldset>
{/if}
{if $Action=='view'}
	<table class="table">
		<tr>
			<td class="thead"> </td><td class="thead">Nazwa</td><td class="thead">Moc</td><td class="thead">Koszt</td><td class="thead">Lvl</td><td class="thead">Zr</td><td class="thead">Wyt.</td><td class="thead">Szyb</td><td class="thead">Dwur.</td>
		</tr>
	{section name=eq loop=$Eq}
		<tr>
			<td><a href="?action=imageadd&type={$Eq[eq].type}&iid={$Eq[eq].id}"><img src="{$Eq[eq].imgfile}"></a></td>
			<td>{$Eq[eq].name}</td>
			<td>{$Eq[eq].power}</td>
			<td>{$Eq[eq].cost}</td>
			<td>{$Eq[eq].minlev}</td>
			<td>{$Eq[eq].zr}</td>
			<td>{$Eq[eq].wt}</td>
			<td>{$Eq[eq].szyb}</td>
			<td>{$Eq[eq].twohand}</td>
			<form method="post" action="?action=del"><input type="hidden" name="id" value="{$Eq[eq].id}">
			<td><input type="submit" value="Usun"></td>
			</form>
		</tr>
	{/section}
	</table><br>
	<a href="items.php">Wróæ</a>
{/if}