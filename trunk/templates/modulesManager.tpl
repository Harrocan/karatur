{literal}
<style type="text/css">
  .modCont{
  border:solid 0px;
  }
  .modTitle{
  background: #006600;
  }
</style>
<script language="JavaScript" src="js/ajax_base.js"></script>
{/literal}
{if $Action == '' }
<a href="?action=add">Dodaj nowy modul</a><br/>
{if $Rank_mod}<a href="?action=manageActive">Zarzadzaj aktywnymi modulami</a>{/if}<br/><br/>
{section name=mod loop=$Modules}
{assign value=$Modules[mod] var='Mod'}
<div class="modCont">
  <div class="modTitle">
  {$Mod.name}, Autor: {$Mod.author}, nadeslany przez: {$Mod.user}
  </div>
  <div class="modDesc">
    {$Mod.desc}
  </div>
  <div>
		<a href="?action=manage&mid={$Mod.id}">Zarzadzaj</a> | 
		{if $Mod.valid == 1}
			{if $Mod.type=='page'}
				<a href="?action=watch&mid={$Mod.id}">Ogladnij</a>
			{elseif $Mod.type=='sidebar'}
				Ogladnij w <a href="?action=watch&mode=left&mid={$Mod.id}">lewym</a> lub <a href="?action=watch&mode=right&mid={$Mod.id}">prawym</a> sidebarze
			{/if}
		{else}
			Modul niekompletny
		{/if} | 
		{if $Mod.checked != 1 }
			{if $Rank_mod}
				<a href="?action=validate&mid={$Mod.id}">Zaakceptuj</a>
			{/if}
		{else}
			{if $Mod.type=='page'}
				Zaakceptowany
			{else}
				{if $Mod.active != 1}
					{if $Rank_mod}
						<a href="?action=activate&mid={$Mod.id}">Aktywuj</a>
					{/if}
				{else}
					Aktywny
				{/if}
			{/if}
		{/if}
		{if $Rank_mod}
			| <a href="?action=delete&mid={$Mod.id}">Usuñ</a>
		{/if}
	</div>
</div>
{sectionelse}
bleeee
{/section}
{elseif $Action == 'add'}
	{literal}
		<script type="text/javascript">
			function validate() {
				var ret = true;
				if( $( 'moduleAdd_rights' ).checked != true ) {
					alert( "Musisz wyrazic zgode na przekazanie wlasnosci !" );
					ret = false;
				}
				if( $( 'moduleAdd_name' ).value == '' ) {
					alert( "Podaj nazwe modulu !" );
					ret = false;
				}
				else {
					var reg = /^[\w-]+$/;
					var value = $( 'moduleAdd_name' ).value;
					if( !reg.test( value ) ) {
						alert( "Nazwa zawiera niedozwolone znaki !" );
						ret = false;
					}
				}
				
				
				if( $( 'moduleAdd_desc' ).value == '' ) {
					alert( "Wypelnij opis modulu !" );
					ret = false;
				}
				return ret;
			}
		</script>
	{/literal}
	<fieldset>
		<legend>Dodaj modul</legend>
		<form method="post" action="?action=add">
			<table>
				<tr>
					<td>Nazwa</td><td><input id="moduleAdd_name" type="text" name="name" /></td>
				</tr>
				<tr>
					<td>Autor</td><td><input id="moduleAdd_author" type="text" name="author" /></td>
				</tr>
				<tr>
					<td>Opis</td><td><textarea id="moduleAdd_desc" name="desc" style="width:300px;height:100px"></textarea></td>
				</tr>
				<tr>
					<td>Typ</td><td><input type="radio" name="type" value="page" checked="checked">Osobna strona<br/><input type="radio" name="type" value="sidebar"/>Panel boczny</td>
				</tr>
			</table>
			<input id="moduleAdd_rights" name="rights" type="checkbox"/> Oswiadczam ze mam pelne prawo do zarzadzania kodem zrodlowym, ktory zamieszcze w tym module. Jednoczesnie zgadzam sie na publikowanie i zarzadzanie tym modulem przez czlonkow KaraTur-Teamu<br/><br/>
			<input type="submit" value="dodaj" onclick="return validate();" />
		</form>
	</fieldset>
{elseif $Action == 'manage' }
<table class="table" style="width:80%">
	<tr>
		<td class="thead" colspan="2" style="text-align:center">Modul <b>{$Mod.name}</b></td>
	</tr>
	<tr>
		<td>Autor</td><td>{$Mod.author}</td>
	</tr>
	<tr>
		<td>Zarzadzajacy</td><td>{$Mod.user}</td>
	</tr>
	<tr>
		<td style="vertical-align:top">Opis</td><td>{$Mod.desc}</td>
	</tr>
	<tr>
		<td>Nadeslany</td><td>{$Mod.date}</td>
	</tr>
	<tr>
		<td>Ost. modfikacja</td><td>{if $Mod.mtime > 0}{$Mod.mfile},<br/>{$Mod.mtime}{else}<i>brak</i>{/if}</td>
	</tr>
	<tr>
		<td>Typ</td><td>{$Mod.type_trans}</td>
	</tr>
	<tr>
		<td>Weryfikacja</td><td>{if $Mod.checked==1}poprawny{else}niesprawdzony{/if}</td>
	</tr>
	<tr>
		<td>Aktywny</td><td>{if $Mod.active!=1}<i>nieaktywny</i>{else}{$Mod.where_trans}{if $Mod.type=='sidebar'} na pozycji {$Mod.position}{/if}{/if}</td>
	</tr>
</table>
<br/>
<a href="?action=addchange&mid={$Mid}">dodaj wpis</a> do rejestru zmian<br/>
<br/>
<table class="table" style="width:80%">
	<tr>
		<td class="thead" colspan="4" style="text-align:center"><b>Pliki</b></td>
	</tr>
	<tr>
		<td colspan="4" style="padding-left:15px"><b>Glowny plik wykonywalny</b></td>
	</tr>
	<tr>
		<td>{if $Mod.files.main == 1}main.php{else}<i>brak</i>{/if}</td>
		<td style="width:20px">
			{if $Mod.files.main == 1}
				<a href="javascript:void(0)" target="Podglad zrodla modulow" onclick="window.open('modulesource.php?mid={$Mid}&file=main.php', 'Podglad zrodla modulow', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=yes,fullscreen=no,channelmode=no,width=750,height=550')">zrodlo</a>
			{/if}
		</td>
		<td style="width:20px"><a href="?action=delfile&mid={$Mid}&file=main.php">usun</a></td>
	</tr>
	{if $Mod.files.inc}
	<tr>
		<td colspan="4" style="padding-left:15px"><b>Pliki zrodlowe</b></td>
	</tr>
	{section name=fp loop=$Mod.files.inc}
	{assign value=$Mod.files.inc[fp] var="File"}
	<tr>
		<td style="width:100%">{$File}</td><td><a href="javascript:void(0)" target="Podglad zrodla modulow" onclick="window.open('modulesource.php?mid={$Mid}&file=inc/{$File}', 'Podglad zrodla modulow', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=yes,fullscreen=no,channelmode=no,width=750,height=550')">zrodlo</a></td>
		<td style="width:20px"><a href="?action=delfile&mid={$Mid}&file=tpl/{$File}">usun</a></td>
	</tr>
	{/section}
	{/if}
	{if $Mod.files.tpl}
	<tr>
		<td colspan="4" style="padding-left:15px"><b>Szablony</b></td>
	</tr>
	{section name=ft loop=$Mod.files.tpl}
	{assign value=$Mod.files.tpl[ft] var="File"}
	<tr>
		<td>{$File}</td>
		<td style="width:20px"><a href="javascript:void(0)" target="Podglad zrodla modulow" onclick="window.open('modulesource.php?mid={$Mid}&file=tpl/{$File}', 'Podglad zrodla modulow', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=yes,fullscreen=no,channelmode=no,width=750,height=550')">zrodlo</a></td>
		<td style="width:20px"><a href="?action=delfile&mid={$Mid}&file=tpl/{$File}">usun</a></td>
	</tr>
	{/section}
	{/if}
	{if $Mod.files.img}
	<tr>
		<td colspan="4" style="padding-left:15px"><b>Obrazki/zdjecia</b></td>
	</tr>
	{section name=fi loop=$Mod.files.img}
	{assign value=$Mod.files.img[fi] var="File"}
	<tr>
		<td>{$File}</td>
	</tr>
	{/section}
	{/if}
	{if $Mod.files.data}
	<tr>
		<td colspan="4" style="padding-left:15px"><b>Pliki rozne</b></td>
		<td style="width:20px"><a href="javascript:void(0)" target="Podglad zrodla modulow" onclick="window.open('modulesource.php?mid={$Mid}&file=tpl/{$File}', 'Podglad zrodla modulow', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=yes,fullscreen=no,channelmode=no,width=750,height=550')">zrodlo</a></td>
		<td style="width:20px"><a href="?action=delfile&mid={$Mid}&file=tpl/{$File}">usun</a></td>
	</tr>
	{section name=fd loop=$Mod.files.data}
	{assign value=$Mod.files.data[fd] var="File"}
	<tr>
		<td>{$File}</td>
	</tr>
	{/section}
	{/if}
	<tr>
		<td style="text-align:right" colspan="3"><a href="?action=addfile&mid={$Mid}">dodaj pliki</a></td>
	</tr>
</table><br/><br/>
{if $Mod.resets}
<table class="table" style="width:100%">
	<tr>
		<td class="thead" style="text-align:center"><b>Resety</b></td>
	</tr>
	<tr>
		<td style="padding-left:15px"><b>Wynik ostatniego resetu godzinnego</b></td>
	</tr>
	<tr>
		<td><pre style="width:100%;overflow:auto">{$Mod.resetHour}</pre></td>
	</tr>
	<tr>
		<td style="padding-left:15px"><b>Wynik ostatniego resetu dziennego</b></td>
	</tr>
	<tr>
		<td><pre style="width:100%;overflow:auto">{$Mod.resetDay}</pre></td>
	</tr>
</table>
{/if}
<a href="?">Wroc</a> do strony glownej
{elseif $Action=='addchange'}
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
<form method="POST" action="?action=addchange&mid={$Mod.id}">
	<fieldset>
		<legend>Dodaj zmiany do modulu <b>{$Mod.title}</b></legend>
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
{elseif $Action=='addfile'}
	{literal}
		<script type="text/javascript">
			var curFile = '';
			function fileDesc( node ) {
				if( $( 'fileDesc-' + curFile ) ) {
					$( 'fileDesc-' + curFile ).style.display = "none";
				}
				curFile = node.value;
				if( $( 'fileDesc-' + curFile ) ) {
					$( 'fileDesc-' + curFile ).style.display = "block";
				}
			}
			function validateForm() {
				if( !( curFile ) ) {
					alert( "Wybierz rodzaj pliku !" );
					return false;
				}
				if( ! $('file').value ) {
					alert( "Wybierz plik !" );
					return false;
				}
				return true;
			}
		</script>
	{/literal}
	<form enctype="multipart/form-data" method="post" action="?action=addfile&mid={$Mid}">
		<fieldset>
			<legend>Dodaj plik</legend>
			Wybierz typ pliku :<br>
			<input type="radio" name="file[type]" value="main" onclick="fileDesc( this )"/> Plik glowny<br/>
			<input type="radio" name="file[type]" value="tpl" onclick="fileDesc( this )"/> Szablon<br/>
			<input type="radio" name="file[type]" value="img" onclick="fileDesc( this )"/> Obrazki<br/>
			<input type="radio" name="file[type]" value="inc" onclick="fileDesc( this )"/> Kod zrodlowy<br/>
			<input type="radio" name="file[type]" value="data" onclick="fileDesc( this )"/> Dane rozne<br/>
			<div id="fileDesc-main" style="display:none">
				Opis main'a
			</div>
			<div id="fileDesc-tpl" style="display:none">
				Opis tpl
			</div>
			<div id="fileDesc-img" style="display:none">
				Opis img
			</div>
			<div id="fileDesc-inc" style="display:none">
				Opis inc
			</div>
			<div id="fileDesc-data" style="display:none">
				Opis data
			</div>
			Wybierz plik : <input id="file" type="file" name="file" value="foo" /><br/>
			<b>UWAGA</b> - nadeslanie nowego pliku, spowoduje, ze modul na nowo zostane oznaczony jako 'do weryfikacji' i do czasu sprawdzenia poprawnosci bedzie nieaktywny !<br/>
			<input type="submit" value="wyslij" onclick="return validateForm()" />
		</fieldset>
	</form>
{elseif $Action == 'activate'}
	{if $Mod.type == 'sidebar'}
		<form method="post" action="?action=activate&mid={$Mod.id}">
			Masz zamiar aktywowac modul <b>{$Mod.name}</b><br/>
			Wybierz do ktorego panelu chcesz go dodac :<br/>
			<input type="radio" name="side" value="left" checked="checked"/>Lewy sidebar<br/>
			<input type="radio" name="side" value="right"/>Prawy sidebar<br/>
			<input type="submit" value="dodaj !" />
		</form>
	{/if}
{elseif $Action == 'manageActive'}
	<table class="table" style="width:100%">
		<tr>
			<td class="thead">Lewy sidebar</td>
			<td class="thead">Oddzielna strona</td>
			<td class="thead">Prawy sidebar</td>
		</tr>
		<tr>
			<td style="vertical-align:top">
				<table cellspacing="0" cellpadding="0" border="0" style="width:100%">
			{section name=sl loop=$Widgets.sidebar_left}
			{assign value=$Widgets.sidebar_left[sl] var='Widget'}
					<tr>
						<td>{$Widget.name}</td>
						<td style="width:38px">
							<a href="?action=manageActive&move=left&dir=up&mid={$Widget.id}">
								<img src="images/modules/up.gif" style="width:10px;height:10px;"/>
							</a>
							<a href="?action=manageActive&move=left&dir=down&mid={$Widget.id}">
								<img src="images/modules/down.gif" style="width:10px;height:10px;"/>
							</a>
							<a href="?action=manageActive&del={$Widget.id}">
								<img src="images/modules/del.gif" style="width:10px;height:10px"/>
							</a>
						</td>
					</tr>
			{sectionelse}
					<tr>
						<td>brak widgetow</td>
					</tr>
			{/section}
				</table>
			</td>
			<td style="vertical-align:top">
				<table cellspacing="0" cellpadding="0" border="0" style="width:100%">
			{section name=pa loop=$Widgets.page}
			{assign value=$Widgets.page[pa] var='Widget'}
					<tr>
						<td>{$Widget.name}</td>
						<td style="width:38px">
							<a href="?action=manageActive&move=left&dir=up&mid={$Widget.id}">
								<img src="images/modules/up.gif" style="width:10px;height:10px;"/>
							</a>
							<a href="?action=manageActive&move=left&dir=down&mid={$Widget.id}">
								<img src="images/modules/down.gif" style="width:10px;height:10px;"/>
							</a>
							<a href="?action=manageActive&del={$Widget.id}">
								<img src="images/modules/del.gif" style="width:10px;height:10px"/>
							</a>
						</td>
					</tr>
			{sectionelse}
					<tr>
						<td style="text-align:center">brak widgetow</td>
					</tr>
			{/section}
				</table>
			</td>
			<td style="vertical-align:top">
				<table cellspacing="0" cellpadding="0" border="0" style="width:100%">
			{section name=sr loop=$Widgets.sidebar_right}
			{assign value=$Widgets.sidebar_right[sr] var='Widget'}
					<tr>
						<td>{$Widget.name}</td>
						<td style="width:38px">
							<a href="?action=manageActive&move=right&dir=up&mid={$Widget.id}"><img src="images/modules/up.gif" style="width:10px;height:10px;border:none 0px;padding:0px;margin:0px;"/></a>
							<a href="?action=manageActive&move=right&dir=down&mid={$Widget.id}"><img src="images/modules/down.gif" style="width:10px;height:10px;border:none 0px;padding:0px;margin:0px;"/></a>
							<a href="?action=manageActive&del={$Widget.id}">
								<img src="images/modules/del.gif" style="width:10px;height:10px"/>
							</a>
						</td>
					</tr>
			{sectionelse}
					<tr>
						<td style="text-align:center">brak widgetow</td>
					</tr>
			{/section}
				</table>
			</td>
		</tr>
	</table>
	<a href="?">Wroc</a> do strony glownej
{elseif $Action == 'validate'}
	Masz zamiar oznaczyc modul <b>{$Mod.name}</b> jako poprawny. Zanim tego dokonasz, upewnij sie ze ten modul jest bezpieczny, nie posiada kodu który móg³by zaszkodzic stronie. Przejrzyj w tym celu pliki zrodlowe i szablony, albo recznie przez ftp(jesli posiadasz taka mozliwosc), albo za pomoca zalaczonego skryptu do podgladania zrodel modulow. Jest on dostepny na podstronie zarzadzania danym modulem. Jesli jestes pewien ze ten modul jest bezpieczny, klinij 'kontynuuj'.<br/>
	<form method="post" action="?action=validate&mid={$Mod.id}">
		<input type="submit" name="next" value="kontunuuj"/>
	</form>
	W przeciwnym razie ... <a href="?">Wroc</a> do glownej strony Managera Modulow
{elseif $Action == 'delete'}
	Masz zamiar usun¹æ modu³ <b>{$Mod.name}</b>Spowoduje to <b>nieodwracalne</b> usuniêcie wszystkich plików, jak i wpisów z bazy. Jest to operacja nieodwracalna. Czy na pewno chcesz to zrobic ?<br/>
	<form method="post" action="?action=delete&mid={$Mod.id}">
		<input type="submit" name="next" value="kontunuuj"/>
	</form>
	W przeciwnym razie ... <a href="?">Wroc</a> do glownej strony Managera Modulow
{/if}