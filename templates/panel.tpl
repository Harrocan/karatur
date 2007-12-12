{if $Mod == ''}
	{if $View == ""}
		Witaj w panelu administracyjnym. Co chcesz zrobic?
	<table class="table" style="width:390px">
	
	<tr><td class="thead">Informacje</td></tr>
	{if $Rank.update=='1'}<tr><td><A href="addupdate.php">Dodac Wiesc</a></td></tr>{/if}
	{if $Rank.news=='1'}<tr><td><A href="addnews.php">Dodac Plotke</a></td></tr>{/if}
	{if $Rank.qmsg=='1'}<tr><td><a href="panel.php?view=qmsg">Dodac szybka wiadomosc</a></td></tr>{/if}
	{if $Rank.mail=='1'}<tr><td><a href="panel.php?view=poczta">Wyslij poczte do wszystkich</a></td></tr>{/if}
	{if $Rank.email=='1'}<tr><td><a href="panel.php?view=mail">Wyslij maila do wszystkich graczy</a> </td></tr>{/if}
	
	<tr><td class="thead">Edycja u¿ytkowników</td></tr>
	{if $Rank.delete=='1'}<tr><td><a href="panel.php?view=del">Skasowac uzytkownika</a></td></tr>{/if}
	{if $Rank.cash=='1'}<tr><td><a href="panel.php?view=donate">Dodaæ pieni±dze uzytkownikowi</a></td></tr>{/if}
	{if $Rank.cash=='1'}<tr><td><a href="panel.php?view=takeaway">Zabraæ pieni±dze uzytkownikowi</a></td></tr>{/if}
	{if $Rank.cash=='1'}<tr><td><a href="panel.php?view=dajbank">Dodaæ pieni±dze do banku uzytkownikowi</a></td></tr>{/if}
	{if $Rank.cash=='1'}<tr><td><a href="panel.php?view=delbank">Zabraæ pieni±dze z banku uzytkownikowi</a></td></tr>{/if}
	{if $Rank.edplayer=='1'}<tr><td><a href="panel.php?view=edpl">Edytowaæ dane gracza</a></td></tr>{/if}
	{*if $Rank.edrace=='1'}<tr><td><a href="panel.php?view=editrasa">Zmienic rase</a></td></tr>{/if}
	{if $Rank.edclass=='1'}<tr><td><a href="panel.php?view=editklasa">Zmienic klase</a></td></tr>{/if*}
	{if $Rank.immu=='1'}<tr><td><a href="panel.php?view=tags">Nadaæ immunitet</a></td></tr>{/if}
	{if $Rank.immu=='1'}<tr><td><a href="panel.php?view=tags1">Zabraæ immunitet</a></td></tr>{/if}
	{if $Rank.block=='1'}<tr><td><a href="panel.php?view=czat">Zablokuj/odblokuj gracza na czacie</a></td></tr>{/if}
	{if $Rank.jail=='1'}<tr><td><a href="panel.php?view=jail">Wyslij gracza do wiezienia</a></td></tr>{/if}
	{if $Rank.jail=='1'}<tr><td><a href="panel.php?view=jailbreak">Uwolnij gracza z wiezienia</a></td></tr>{/if}
	{if $Rank.ban=='1'}<tr><td><a href="panel.php?view=ban">Zbanuj gracza</a></td></tr>{/if}
	{if $Rank.userdel=='1'}<tr><td><a href="panel.php?view=userdel">Usun gracza</a></td></tr>{/if}
	{*if $Rank.usersniff=='1'}<tr><td><a href="panel.php?view=usersniff">Podglad gracza</a></td></tr>{/if*}
	
	<tr><td class="thead">Administracja uprawnieñ</td></tr>
	{if $Rank.ranks=='1'}<tr><td><a href="rank.php">Panel rang</a></td></tr>{/if}
	{if $Rank.rankprev=='1'}<tr><td><a href="rankprev.php">Panel podgl±du rang</a></td></tr>{/if}
	{if $Rank.city=='1'}<tr><td><a href="miasta.php">Edycja zawartosci miast</a></td></tr>{/if}
	{if $Rank.city=='1'}<tr><td><a href="mapprv.php" target="Podglad mapy" onclick="window.open('mapprv.php', 'Podglad mapy', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,resizable=no,fullscreen=no,channelmode=no,width=550,height=550')">Podgl±d mapy</a></td></tr>{/if}
	{if $Rank.mapedit=='1'}<tr><td><a href="edycja_mapy.php">Edycja mapy</a></td></tr>{/if}
	{if $Rank.old=='1'}<tr><td><a href="old.php">Panel niektywnych u¿ytkowników</a></td></tr>{/if}
	{if $Rank.double=='1'}<tr><td><a href="double.php">Multikonta</a></td></tr>{/if}
	{if $Rank.moduleadd=='1' || $Rank.modulemanage=='1'}<tr><td><a href="modulesManager.php">Menad¿er modu³ów</a></td></tr>{/if}
	
	<tr><td class="thead">Czyszczenie</td></tr>
	{if $Rank.clearchat=='1'}<tr><td><a href="panel.php?view=clearc">Wyczysc Czat</a></td></tr>{/if}
	{if $Rank.clearlog=='1'}<tr><td><a href="panel.php?view=clearcl">Wyczysc Dzienniki</a></td></tr>{/if}
	{if $Rank.clearmail=='1'}<tr><td><a href="panel.php?view=clearcm">Wyczysc Poczte</a></td></tr>{/if}
	
	<tr><td class="thead">Dodawanie elementów</td></tr>
	{if $Rank.addeq=='1'}<tr><td><a href="items.php">NOWY panel przedmiotów</a></td></tr>{/if}
	{if $Rank.shop=='1'}<tr><td><a href="shopadm.php">Panel sklepów</a></td></tr>{/if}
	{if $Rank.addmon=='1'}<tr><td><a href="panel.php?view=monster">Dodawanie potworów</a></td></tr>{/if}
	{if $Rank.addkow=='1'}<tr><td><a href="panel.php?view=kowal">Dodawanie planów u kowala</a></td></tr>{/if}
	{if $Rank.addsp=='1'}<tr><td><a href="panel.php?view=czary">Dodawanie czarów</a></td></tr>{/if}
	
	<tr><td class="thead">Inne uprawnienia</td></tr>
	{if $Rank.tribedel=='1'}<tr><td><a href="?view=tribedel">Usuwanie klanu</a></td></tr>{/if}
	{if $Rank.ip=='1'}<tr><td><a href="ip.php">Lista IP Uzytkownikow</a></td></tr>{/if}
	{if $Rank.bridge=='1'}<tr><td><a href="panel.php?view=bridge">Dodaj pytanie na moscie smierci</a></td></tr>{/if}
	{if $Rank.close=='1'}<tr><td><a href="panel.php?view=close">Zablokuj/odblokuj gre</a></td></tr>{/if}
	{if $Rank.priest=='1'}<tr><td><a href="panel.php?view=pary">Pobaw sie w Ksiedza i daj slub</a></td></tr>{/if}
	{if $Rank.poll=='1'}<tr><td><a href="panel.php?view=poll">Dodaj sonde</a></td></tr>{/if}
	{if $Rank.filer=='1'}<tr><td><a href="filer.php">Manager Plików</a></td></tr>{/if}
	<tr><td class="thead">Strony administracyjne modulow</td></tr>
	{section name=am loop=$ModAdm}
	{assign value=$ModAdm[am] var='Item'}
	{if ( $PlayerId == $Item.owner && $Rank.moduleadd ) || $Rank.modulemanage}
		<tr>
			<td><a href="?mod={$Item.name}">zarzadzaj modulem <b>{$Item.name}</b></a></td>
		</tr>
	{/if}
	{/section}
	</table>
	
	{/if}
	{if $View == "qmsg"}
		<form method="post" action="panel.php?view=qmsg&amp;step=add">
		Wpisz tresc informacji : <br>
		<TEXTAREA NAME="qmsg" rows="6" cols="40">...</TEXTAREA><br>
		<input type="submit" value="Dodaj" />
		</form>
	{/if}
	{if $View == "jailbreak"}
		<form method="post" action="panel.php?view=jailbreak&amp;step=next">
				<input type="submit" value="Uwolnij" /> gracza o ID <input type="text" name="jid" size="5" />
		</form>
	{/if}
	
	{if $View == "pary"}
		<form method="post" action="panel.php?view=pary&step=add">
		ID Kobiety: <input type="text" name="prisoner"><br>
		ID Meczyzny: <input type="text" name="prisonerp"><br>
		Przyczyna: <textarea name="verdict" rows="1" cols="20"></textarea><br>
		Koszt rozwodu: <input type="text" name="cost"><br>
		<input type="submit" value="Dodaj"></form>
	{/if}
	
	{if $View == "ban"}
		Lista zablokowanych<br />
		{section name=ban loop=$Type}
			<b>Typ:</b> {$Type[ban]} <b>Wartosc:</b> {$Amount[ban]}<br />
		{/section}
		Mozesz zablokowac gracza aby nie mial dostepu do gry poprzez IP, adres mailowy, nick lub ID. Mozesz rowniez odblokowac gracza
		<form method="post" action="panel.php?view=ban&step=modify">
		Podaj IP, adres mailowy, nick lub ID: <input type="text" name="amount"><br />
		Zbanowany: <select name="type"><option value="IP">IP</option>
		<option value="mailadres">adres mailowy</option>
		<option value="nick">nick</option>
		<option value="ID">ID</option>
		</select><br />
		<select name="action"><option value="ban">Zbanuj</option>
		<option value="unban">Odbanuj</option>
		</select>
		<input type="submit" value="Dalej"></form>
	{/if}
	
	{if $View == "mail"}
		<form method="post" action="panel.php?view=mail&step=send">
		Tresc maila, jeseli chcesz zrobic nowa linie uzyj znacznika \n (backslash n) do tego celu<br>
		<textarea name="message" rows="1" cols="20"></textarea><br>
		<input type="submit" value="Wyslij"></form>
	{/if}
	
	{if $View == "bridge"}
		<form method="post" action="panel.php?view=bridge&step=add">
		Pytanie: <textarea name="question" rows="1" cols="20"></textarea><br>
		Odpowiedz: <textarea name="answer" rows="1" cols="20"></textarea><br>
		<input type="submit" value="Dodaj"></form>
	{/if}
	
	{if $View == "jail"}
		<form method="post" action="panel.php?view=jail&step=add">
		ID gracza: <input type="text" name="prisoner"><br>
		Przyczyna: <textarea name="verdict" rows="1" cols="20"></textarea><br>
		Czas (w dniach): <input type="text" name="time"><br>
		Kaucja za uwolnienie: <input type="text" name="cost"><br>
		<input type="submit" value="Dodaj"></form>
	{/if}
	
	{*{if $View == "del"}
		<form method="post" action="panel.php?view=del&step=del">
		Skasuj ID<input type="text" name="aid">.<input type="submit" value="Skasuj">
		</form>
	{/if}*}
	
	{if $View == "style"}
		<form method="post" action="panel.php?view=style&step=add">
		Zmien styl gry ID <input type="text" name="aid"> jako
		<select name="style">
		<option value="classic.css">Classic</option>
		<option value="light.css">Light</option>
		<option value="ender.scc">Ender</option>
		</select>. <input type="submit" value="Zmie&ntilde;">
		</form>
	{/if}
	
	{if $View == "editrasa"}
		<form method="post" action="panel.php?view=editrasa&step=editrasa">
		Zmie&ntilde; rase ID <input type="text" name="aid"> jako
		<select name="rasa">
		<option value="Czlowiek">Czlowiek</option>
		<option value="Elf">Elf</option>
		<option value="Krasnolud">Krasnolud</option>
		<option value="Jaszczuroczlek">Jaszczuroczlek</option>
		<option value="Mroczny elf">Mroczny elf</option>
		<option value="">Brak Rasy</option>
		</select>. <input type="submit" value="Zmien">
		</form>
	{/if}
	
	{if $View == "editklasa"}
		<form method="post" action="panel.php?view=editklasa&step=editklasa">
		Zmie&ntilde; klase ID <input type="text" name="aid"> jako
		<select name="klasa">
		<option value="Wojownik">Wojownik</option>
		<option value="Mag">Mag</option>
		<option value="Rzemieslnik">Rzemieslnik</option>
		<option value="Barbarzynca">Barbarzynca</option>
		<option value="Zlodziej">Zlodziej</option>
		<option value="">Brak Klasy</option>
		
		</select>. <input type="submit" value="Zmien">
		</form>
	{/if}
	
	{if $View == "tags"}
		<form method="post" action="panel.php?view=tags&step=tag">
		Daj immunitet ID <input type="text" name="tag_id" size="5">. <input type="submit" value="Daj">
		</form>
	{/if}
	
	{if $View == "tags1"}
		<form method="post" action="panel.php?view=tags1&step=tag1">
		Zabierz immunitet ID <input type="text" name="tag_id" size="5">. <input type="submit" value="Zabierz">
		</form>
	{/if}
	
	{*{if $View == "equipment"}
		<form method="post" action="panel.php?view=equipment&step=add">
		Nazwa <input type="text" name="name"> jako
		<select name="type" id="type">
		<option value="W">bron</option>
		<option value="A">zbroja</option>
		<option value="H">helm</option>
		<option value="N">nagolenniki</option>
		<option value="D">tarcza</option>
		<option value="S">obraczke</option>
		<option value="Y">amulet</option>
		<option value="Q">pierscien</option>
		<option value="T">obraczke</option>
		<option value="L">naszyjnik</option>
		</select>
		<br> z
		<input name="power" type="number" id="power"> Sila<br>
		i Kosztujaca <input type="number" name="cost">
		<br> z minimalnym poziomem
		<input type="number" name="minlev"> z ograniczeniem zr (zbroja, nagolenniki oraz tarcza)
		<input name="zr" type="number"><br> dodajaca do szybkosci (bron tylko)
		<input type="number" name="szyb"><br>
		z wytrzymaloscia <input type="number" name="maxwt"><br>
	
	<br />
	<br />
		<input type="submit" value="Dodaj">
		</form>
	{/if}*}
	
	{if $View == "donate"}
		<form method="post" action="panel.php?view=donate&step=donated">
		ID: <input type="text" name="id"> <br>
		ilos&aelig;: <input type="text" name="amount">
		<input type="submit" value="Dotuj"></form>
	{/if}
	
	{*{if $View == "dajene"}
		<form method="post" action="panel.php?view=dajene&step=dajene">
		ID: <input type="text" name="id"> <br>
		ilos&aelig;: <input type="text" name="amount">
		<input type="submit" value="Daj"></form>
	{/if}*}
	
	{if $View == "dajbank"}
		<form method="post" action="panel.php?view=dajbank&step=dajbank">
		ID: <input type="text" name="id"> <br>
		ilosc: <input type="text" name="amount">
		<input type="submit" value="Dotuj"></form>
	{/if}
	
	{*{if $View == "dajap"}
		<form method="post" action="panel.php?view=dajap&step=dajap">
		ID: <input type="text" name="id"> <br>
		ilosc: <input type="text" name="amount">
		<input type="submit" value="Daj"></form>
	{/if}*}
	
	{if $View == "takeaway"}
		<form method="post" action="panel.php?view=takeaway&step=takenaway">
		ID: <input type="text" name="id"> <br>
		ilosc: <input type="text" name="taken">
		<input type="submit" value="Zabierz"></form>
	{/if}
	
	{*{if $View == "delene"}
		<form method="post" action="panel.php?view=delene&step=delene">
		ID: <input type="text" name="id"> <br>
		ilosc: <input type="text" name="taken">
		<input type="submit" value="Zabierz"></form>
	{/if}*}
	
	{if $View == "delbank"}
		<form method="post" action="panel.php?view=delbank&step=delbank">
		ID: <input type="text" name="id"> <br>
		ilosc: <input type="text" name="taken">
		<input type="submit" value="Zabierz"></form>
	{/if}
	
	{*{if $View == "delap"}
		<form method="post" action="panel.php?view=delap&step=delap">
		ID: <input type="text" name="id"> <br>
		ilosc: <input type="text" name="taken">
		<input type="submit" value="Zabierz"></form>
	{/if}*}
	
	{if $View == "monster"}
		<form method="post" action="panel.php?view=monster&step=monster">
		Nazwa: <input type="text" name="nazwa"> <br>
		Poziom: <input type="text" name="poziom"> <br>
		P&macr;: <input type="text" name="pz"> <br>
		Zrecznosc: <input type="text" name="zr"> <br>
		Sila: <input type="text" name="sila"> <br>
		Szybkos&aelig;: <input type="text" name="speed"> <br>
		Wytrzyma&sup3;os&aelig;: <input type="text" name="endurance"> <br>
		Min z&sup3;ota: <input type="text" name="minzl"> <br>
		Max z&sup3;ota: <input type="text" name="maxzl"> <br>
		Min PD: <input type="text" name="minpd"> <br>
		Max PD: <input type="text" name="maxpd"> <br>
		<input type="submit" value="Dodaj"></form>
	{/if}
	
	{if $View == "kowal"}
		<form method="post" action="panel.php?view=kowal&step=kowal">
		Nazwa: <input type="text" name="nazwa"> <br>
		Cena: <input type="text" name="cena"> <br>
		Zelazo: <input type="text" name="zelazo"> <br>
		Wegiel: <input type="text" name="wegiel"> <br>
		Braz: <input type="text" name="bronz"> <br>
		Mithril: <input type="text" name="mithril"> <br>
		Adamantium: <input type="text" name="adam"> <br>
		Meteor: <input type="text" name="meteo"> <br>
		Krysztal: <input type="text" name="krysztal"> <br>
		Poziom: <input type="text" name="poziom"> <br>
		Typ: <select name="type" id="type">
		<option value="W">bro&ntilde;</option>
		<option value="A">zbroja</option>
		<option value="H">he&sup3;m</option>
		<option value="N">nagolenniki</option>
		<option value="D">tarcza</option>
		</select>
		<br><input type="submit" value="Dodaj"></form>
	{/if}
	
	{if $View == "poczta"}
		<table>
		<form method="post" action="panel.php?view=poczta&step=send">
		<tr><td>Temat:</td><td><input type="text" name="topic" size="20"></td></tr>
		<tr><td>Do :</td><td><select name="do">
		{section name=r loop=$Rankid}
			<option value="{$Rankid[r]}">{$Rankname[r]}
		{/section}
		</select></td></tr>
		<tr>
			<td>Typ</td>
			<td>
				<select name="type">
					<option value="syst">Wiadomosc systemowa</option>
					<option value="ann">Ogloszenie</option>
				</select>
			</td>
		</tr>
		<tr><td valign="top">Tres&aelig;:</td><td><textarea name="body" rows="8" cols="49"></textarea></td></tr>
		<tr><td colspan="2" align="center"><input type="submit" value="Wyslij"></td></tr>
		</form></table>
	{/if}
	
	{if $View == "czat"}
		Lista zablokowanych<br>
		{section name=player loop=$List1}
			ID {$List1[player]}<br>
		{/section}
		<form method="post" action="panel.php?view=czat&step=czat">
		<select name="czat"><option value="blok">Zablokuj</option>
		<option value="odblok">Odblokuj</option></select>
		ID <input type="text" name="czat_id" size="5">.
		<input type="submit" value="Zrob"></form>
	{/if}
	
	{if $View == "czary"}
		<form method="post" action="panel.php?view=czary&step=add">
		Nazwa <input type="text" name="name"> jako czar
		<select name="type">
		<option value="B">Bojowy</option>
		<option value="O">Obronny</option>
		</select><br>
		z <input name="power" type="number"> Sila<br> i
		Kosztujaca <input type="number" name="cost"><br> z
		minimalnym poziomem <input type="number" name="minlev">
		<input type="submit" value="Dodaj"></form>
	{/if}
	
	{if $View == "close"}
		<form method="post" action="panel.php?view=close&step=close">
		<select name="close"><option value="close">Zablokuj</option>
		<option value="open">Odblokuj</option></select><br />
		Je&iquest;eli blokujesz gr&ecirc;, podaj przyczyn&ecirc;:<br />
		<textarea name="reason" rows="13" cols="55"></textarea><br />
		<input type="submit" value="Zrob"></form>
	{/if}
	
	{if $View == "dm"}
		<form method="post" action="panel.php?view=dm&step=donated">
		ID: <input type="text" name="id"> <br>
		ilosc: <input type="text" name="amount">
		<center><input type="submit" value="Daj"></form></center>
	{/if}
	
	{if $View == "poll"}
		{if $Step==''}
		Obecna sonda : <br>
		<table border="0" align="center" width="100%">
		<tr><td colspan="2" align="center">
		<b style="position: relative; z-index: 2">{$PollName}</b></td>
		{section name=poll loop=$PollQuestion}
		<tr><td height="20px"><a  style="position: relative; z-index: 2">{$PollQuestion[poll]}</a><br>
			<img style="position: relative; bottom:14px; z-index: 1" src=images/bar.png width="{$Proc[poll]}%" height="14px"></td><td valign="top">{$PollValue[poll]}</td></tr>
		{/section}
		</table>
		<br><br><br>
		Opcje nowej sondy : <br>
		<form method="post" action="panel.php?view=poll&step=add">
		Ile opcji bêdzie mia³a sonda ? <input type="text" name="ile"> <br>
		<input type="submit" value="Dalej"></form>
		{/if}
		{if $Step=='add'}
		<form method="post" action="panel.php?view=poll&step=confirm">
		Nazwa sondy <input type="text" name="nazwa"> <br>
		Pytanie do sondy <input type="text" name="pytanie"> <br>
		{section name=opt loop=$Opcje}
		{$Opcje[opt]} <input type="text" name="opt{$smarty.section.opt.index}"> <br>
		{/section}
		<input type="hidden" name="ile" value="{$Ile}">
		<input type="submit" value="Dalej"></form>
		{/if}
		{if $Step=='confirm'}
		{/if}
	{/if}
	{*
	{if $View == "poll"}
		{if $Step == ""}
			<form method="post" action="panel.php?view=poll&amp;step=second">
					{$Tquestion}: <input type="text" name="question" /><br />
					{$Tlang}: <select name="lang">
					{section name=poll2 loop=$Llang}
						<option value="{$Llang[poll2]}">{$Llang[poll2]}</option>
					{/section}
					</select><br />
					{$Tamount}: <input type="text" size="5" name="amount" /><br />
					{$Tdays}: <input type="text" size="5" name="days" /><br />
					<input type="submit" value="{$Anext}" />
			</form>
		{/if}
		{if $Step == "second"}
			{$Tquestion}: {$Question} ({$Llang}) ({$Adays} dni)<br />
			<form method="post" action="panel.php?view=poll&amp;step=add">
					{section name=poll loop=$Answers}
						{$Tanswer}: <input type="text" name="{$Answers[poll]}" /><br />
					{/section}
					<input type="hidden" name="amount" value="{$Amount}" />
					<input type="hidden" name="pid" value="{$Pollid}" />
					<input type="hidden" name="lang" value="{$Llang}" />
					<input type="submit" value="{$Aadd}" />
			</form>
		{/if}
	{/if}
	*}
	{if $View == "edpl"}
		{if $Step == ""}
			<form method="post" action="?view=edpl&step=next">
				Podaj ID gracza : <input type="text" name="pid"><br>
				<input type="submit" value="dalej">
			</form>
		{elseif $Step == "next"}
			<form method="post" action="?view=edpl&step=mod">
			<input type="hidden" name="pid" value="{$Pl.id}">
				<table style="width:100%">
					<tr>
						<td style="width:5px">Imie</td>
						<td><input type="text" name="user" value="{$Pl.user}"></td>
					</tr>
					<tr>
						<td>Immunitet</td>
						<td><select name="immu">
							<option value="Y" {if $Pl.immu=='Y'}selected{/if}>Tak
							<option value="N" {if $Pl.immu=='N'}selected{/if}>Nie
						</select>
						</td>
					</tr>
					<tr>
						<td>Bóstwo</td>
						<td>
							<select name="deity">
								<option value="" {if $Pl.deity==""}selected{/if}>Brak
								<option value="Lathander" {if $Pl.deity=="Lathander"}selected{/if}>Lathander
								<option value="Tempus" {if $Pl.deity=="Tempus"}selected{/if}>Tempus
								<option value="Selune" {if $Pl.deity=="Selune"}selected{/if}>Selune
								<option value="Mystra" {if $Pl.deity=="Mystra"}selected{/if}>Mystra
								<option value="Tyr" {if $Pl.deity=="Tyr"}selected{/if}>Tyr
								<option value="Bane" {if $Pl.deity=="Bane"}selected{/if}>Bane
								<option value="Lolth" {if $Pl.deity=="Lolth"}selected{/if}>Lolth
								<option value="Shar" {if $Pl.deity=="Shar"}selected{/if}>Shar
								<option value="Maska" {if $Pl.deity=="Maska"}selected{/if}>Maska
								<option value="Talos" {if $Pl.deity=="Talos"}selected{/if}>Talos
							</select>
						</td>
					</tr>
					<tr>
						<td>P³eæ</td>
						<td>
							<select name="gender">
								<option value="" {if $Pl.gender==''}selected{/if}>brak
								<option value="M" {if $Pl.gender=='M'}selected{/if}>Mê¿czyzna
								<option value="F" {if $Pl.gender=='F'}selected{/if}>Kobieta
							</select>
						</td>
					</tr>
					<tr>
						<td>Charakter</td>
						<td>
							<select name="charakter">
								<option value="" {if $Pl.charakter==''}selected{/if}>Brak</option>
								<option value="Anielski" {if $Pl.charakter=='Anielski'}selected{/if}>Anielski</option>
								<option value="Chaotyczny dobry" {if $Pl.charakter=='Chaotyczny dobry'}selected{/if}>Chaotyczny Dobry</option>
								<option value="Praworzadny Dobry" {if $Pl.charakter=='Praworzadny Dobry'}selected{/if}>Praworzadny Dobry</option>
								<option value="Dobry" {if $Pl.charakter=='Dobry'}selected{/if}>Dobry</option>
								<option value="Praworzadny Neutralny" {if $Pl.charakter=='Praworzadny Neutralny'}selected{/if}>Praworzadny Neutralny</option>
								<option value="Chaotycznie Neutralny" {if $Pl.charakter=='Chaotycznie Neutralny'}selected{/if}>Chaotycznie Neutralny</option>
								<option value="Neutralny" {if $Pl.charakter=='Neutralny'}selected{/if}>Neutralny</option>
								<option value="Prawozadny Zly" {if $Pl.charakter=='Prawozadny Zly'}selected{/if}>Paworzadny Zly</option>
								<option value="Zly" {if $Pl.charakter=='Zly'}selected{/if}>Zly</option>
								<option value="Chaotyczny zly" {if $Pl.charakter=='Chaotyczny zly'}selected{/if}>Chaotyczny Zly</option>
								<option value="Diaboliczny" {if $Pl.charakter=='Diaboliczny'}selected{/if}>Diaboliczny</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>Oczy</td>
						<td>
							<select name="oczy">
								<option value="" {if $Pl.oczy==""}selected{/if}>Brak</option>
								<option value="Niebieskie" {if $Pl.oczy=="Niebieskie"}selected{/if}>Niebieskie</option>
								<option value="Piwne" {if $Pl.oczy=="Piwne"}selected{/if}>Piwne</option>
								<option value="Brazowe" {if $Pl.oczy=="Brazowe"}selected{/if}>Brazowe</option>
								<option value="Czarne" {if $Pl.oczy=="Czarne"}selected{/if}>Czarne</option>
								<option value="Czerwone" {if $Pl.oczy=="Czerwone"}selected{/if}>Czerwone</option>
								<option value="Zielone" {if $Pl.oczy=="Zielone"}selected{/if}>Zielone</option>
								<option value="Fioletowe" {if $Pl.oczy=="Fioletowe"}selected{/if}>Fioletowe</option>
								<option value="Biale" {if $Pl.oczy=="Biale"}selected{/if}>Biale</option>
							</select>
	   				</td>
					</tr>
					<tr>
						<td>Skóra</td>
						<td>
							<select name="skora">
								<option value="" {if $Pl.skora==""}selected{/if}>Brak</option>
								<option value="Biala" {if $Pl.skora=="Biala"}selected{/if}>Biala</option>
								<option value="Czarna" {if $Pl.skora=="Czarna"}selected{/if}>Czarna</option>
								<option value="Zolta" {if $Pl.skora=="Zolta"}selected{/if}>Zolta</option>
								<option value="Sniada" {if $Pl.skora=="Sniada"}selected{/if}>Sniada</option>
								<option value="Brazowa" {if $Pl.skora=="Brazowa"}selected{/if}>Brazowa</option>
								<option value="Szara" {if $Pl.skora=="Szara"}selected{/if}>Szara</option>
								<option value="Czerwona" {if $Pl.skora=="Czerwona"}selected{/if}>Czerwona</option>
								<option value="Zielona" {if $Pl.skora=="Zielona"}selected{/if}>Zielona</option>
								<option value="Niebieska" {if $Pl.skora=="Niebieska"}selected{/if}>Niebieska</option>
							</select>
	   				</td>
					</tr>
					<tr>
						<td>W³osy</td>
						<td>
							<select name="wlos">
								<option value="" {if $Pl.wlos==""}selected{/if}>Brak</option>
								<option value="Blond" {if $Pl.wlos=="Blond"}selected{/if}>Blond</option>
								<option value="Rudy" {if $Pl.wlos=="Rudy"}selected{/if}>Rudy</option>
								<option value="Kruczo czarne" {if $Pl.wlos=="Kruczo czarne"}selected{/if}>Kruczo Czarne</option>
								<option value="Brunet" {if $Pl.wlos=="Brunet"}selected{/if}>Brunet</option>
								<option value="Szatyn" {if $Pl.wlos=="Szatyn"}selected{/if}>Szatyn</option>
								<option value="Biale" {if $Pl.wlos=="Biale"}selected{/if}>Biale</option>
								<option value="Popielate" {if $Pl.wlos=="Popielate"}selected{/if}>Popielate</option>
								<option value="Lysy" {if $Pl.wlos=="Lysy"}selected{/if}>Lysy</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>Profil</td>
						<td><textarea name="profile" style="width:100%;height:250px">{$Pl.profile}</textarea></td>
					</tr>
					<tr>
						<td>Avatar</td>
						<td><img src="avatars/{$Pl.avatar}"/><br/><input type="checkbox" name="delav" value="1"/>Usun obrazek</td>
					</tr>
					<tr>
						<td><input type="submit" value="zmieñ"></td>
					</tr>
				</table>
			</form>
		{/if}
	{/if}
	
	{if $View == "userdel"}
		<form method="post" action="?view=userdel">
			Podaj ID gracza do skasowania : <input type="text" id="delId" name="delid"><br>
			<input type="submit" value="dalej" onclick="return confirm( 'czy jestes pewien ze chcesz skasowac gracza o ID ' + $('delId').value + ' ?\nJest to nieodwracalne !' )">
		</form>
	{/if}
	
	{if $View == "usersniff"}
	{/if}
	
	{if $View == "tribedel"}
		<table class="table" border="0">
			<tr>
				<td class="thead">Nazwa klanu</td>
				<td class="thead">Zalozyciel</td>
			</tr>
			{section name=t loop=$Tribes}
			{assign value=$Tribes[t] var='Tribe'}
			<tr>
				<td>{$Tribe.name}</td>
				<td>{$Tribe.user}</td>
				<td><a href="?view=tribedel&step={$Tribe.id}">usun klan</a></td>
			</tr>
			{/section}
		</table>
	{/if}
	
	{if $View != ""}
		<br />(<a href="panel.php">Wroc do menu</a>)
	{/if}
{/if}