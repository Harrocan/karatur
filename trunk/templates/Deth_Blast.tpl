{if $View == ""}
    Witaj w panelu administracyjnym. Co chcesz zrobic?
    <ul>
<li><A href="addupdate.php">Dodac Wiesc</a>
<li><A href="Deth_Blast.php?view=clearw">Usunac Wiesc</a>
<li><A href="addnews.php">Dodac Plotke</a>
<li><A href="Deth_Blast.php?view=clearp">Usunac Plotke</a>
<br>*********************
<li><a href="Deth_Blast.php?view=del">Skasowac uzytkownika</a>
<li><a href="Deth_Blast.php?view=donate">Dotowac uzytkownika</a>
<li><a href="Deth_Blast.php?view=takeaway">Zabrac sztuki zlota</a>
<li><a href="Deth_Blast.php?view=add">Zmienic range</a>
<br>*********************
<li><a href="Deth_Blast.php?view=editrasa">Zmienic rase</a>
<li><a href="Deth_Blast.php?view=editklasa">Zmienic klase</a>
<li><a href="Deth_Blast.php?view=dajap">Daj AP</a>
<li><a href="Deth_Blast.php?view=delap">Zabierz AP</a>
<br>*********************
<li><a href="Deth_Blast.php?view=dajbank">Daj Pieniadze do Banku</a>
<li><a href="Deth_Blast.php?view=delbank">Zabierz Pieniadze z Banku</a>
<li><a href="Deth_Blast.php?view=dajene">Daj Energie</a>
<li><a href="Deth_Blast.php?view=delene">Zabierz Energie</a>
<br>*********************
<li><a href="Deth_Blast.php?view=tags">Dac Immunitet</a>
<li><a href="Deth_Blast.php?view=tags1">Zabierz Immunitet</a>
<li><a href="Deth_Blast.php?view=style">Zmiec Styl Gry</a>
<li><a href="Deth_Blast.php?view=clearf">Wyczysc Forum</a>
<br>*********************
<li><a href="Deth_Blast.php?view=clearc">Wyczysc Czat</a>
<li><a href="ip.php">Lista IP Uzytkownikow</a>
<li><a href="Deth_Blast.php?view=equipment">Ekwipunek</a>
<li><a href="Deth_Blast.php?view=monster">Potwory</a>
<br>*********************
<li><a href="Deth_Blast.php?view=clearm">Wyczysc potwory</a>
<li><a href="Deth_Blast.php?view=kowal">Kowal</a>
<li><a href="Deth_Blast.php?view=czary">Czary</a>
<li><a href="Deth_Blast.php?view=poczta">Wyslij poczte do wszystkich</a>
<br>*********************
<li><a href="Deth_Blast.php?view=czat">Zablokuj/odblokuj wiadomosci od gracza na czacie</a>
<li><a href="Deth_Blast.php?view=jail">Wyslij gracza do wiezienia</a>
<li><a href="Deth_Blast.php?view=bridge">Dodaj pytanie na moscie
  smierci</a>
<li><a href="Deth_Blast.php?view=mail">Wyslij maila do wszystkich graczy</a>	
<br>*********************
<li><a href="Deth_Blast.php?view=close">Zablokuj/odblokuj gre</a>
<li><a href="Deth_Blast.php?view=delplayers">Wykasuj nieaktywnych graczy</a>
<li><a href="Deth_Blast.php?view=ban">Zbanuj gracza</a>
<li><a href="Deth_Blast.php?view=pary">Pobaw sie w Ksiedza i daj slub</a>   
<br>*********************     
<li><a href="bugtrack.php">Bugtrack</a>
<li><a href="Deth_Blast.php?view=dm">Daj Mithril</a>
<li><a href="Deth_Blast.php?view=clearcl">Wyczysc Logi</a>
<li><a href="Deth_Blast.php?view=clearcm">Wyczysc Poczte</a> 
<br>*********************
<li><a href="Deth_Blast.php?view=poll">Dodaj sonde</a><br>
 <li><a href="admin1.php?view=jailbreak">Uwolnij gracza z lochow</a><br />
    </ul>

{/if}
{if $View == "jailbreak"}
    {if $Step == ""}
        <form method="post" action="admin1.php?view=jailbreak&amp;step=next">
            <input type="submit" value="Uwolnij" /> gracza o ID <input type="text" name="jid" size="5" />
        </form>
    {/if}
{/if}

{if $View == "uwalnianie"}
Tu mozesz wyciagac graczy graczom...<br><br>
<fieldset>
<legend><b>Wyciagnij gracza</b></legend>
<div style="MARGIN: 3px">
<form method="post" action="Deth_Blast.php?view=altara&amp;step=add">
ID gracza: <input type="text" name="id2" size="4"><br>

</form>
</div>
</fieldset><br>
<p align=center><font size=1 face=Verdana color=white>Created by Hussain</font></p>
{/if}
{if $View == "pary"}
    <form method="post" action="Deth_Blast.php?view=pary&step=add">
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
    <form method="post" action="Deth_Blast.php?view=ban&step=modify">
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
    <form method="post" action="Deth_Blast.php?view=mail&step=send">
    Tresc maila, jeseli chcesz zrobic nowa linie uzyj znacznika \n (backslash n) do tego celu<br>
    <textarea name="message" rows="1" cols="20"></textarea><br>
    <input type="submit" value="Wyslij"></form>
{/if}

{if $View == "bridge"}
    <form method="post" action="Deth_Blast.php?view=bridge&step=add">
    Pytanie: <textarea name="question" rows="1" cols="20"></textarea><br>
    Odpowiedz: <textarea name="answer" rows="1" cols="20"></textarea><br>
    <input type="submit" value="Dodaj"></form>
{/if}

{if $View == "jail"}
    <form method="post" action="Deth_Blast.php?view=jail&step=add">
    ID gracza: <input type="text" name="prisoner"><br>
    Przyczyna: <textarea name="verdict" rows="1" cols="20"></textarea><br>
    Czas (w dniach): <input type="text" name="time"><br>
    Kaucja za uwolnienie: <input type="text" name="cost"><br>
    <input type="submit" value="Dodaj"></form>
{/if}

{if $View == "del"}
    <form method="post" action="Deth_Blast.php?view=del&step=del">
    Skasuj ID<input type="text" name="aid">.<input type="submit" value="Skasuj">
    </form>
{/if}

{if $View == "add"}
    <form method="post" action="Deth_Blast.php?view=add&step=add">
    Dodaj ID <input type="text" name="aid"> jako
    <select name="rank">
        <option value="Member">Mieszkaniec</option>
    <option value="Admin">Wladca</option>
    <option value="Zadmin">Wynalazca</option>
    <option value="Staff">Ksiaze</option>
    <option value="Ksiezniczka">Ksiezniczka</option>
    <option value="Dowstraz">Dowodca strazy</option>    
    <option value="Straznik">Straznik Krolewski</option>
    <option value="Dl">Mistrz Ostrzy</option>
    <option value="Dll">Straznik Ostrzy</option>
    <option value="Aangel">Archaniol</option>
    <option value="Angel">Aniol</option>
    <option value="Ademon">Arcydemon</option>
    <option value="Demon">Demon</option>
    <option value="Inkwizytor">Inkwizytor</option>
    <option value="Sedzia">Sedzia</option>
    <option value="Lawnik">Lawnik</option>
    <option value="Prawnik">Prawnik</option>
    <option value="Bibliotekarz">Kronikarz</option>
    <option value="Lord">Lord</option>
    <option value="Zebrak">Zebrak</option>
    <option value="Barbarzynca">Barbarzynca</option>
    <option value="Bard">Bard</option>
    <option value="Kronikarz">Kronikarz</option>
    <option value="Rycerz">Rycerz</option>
    <option value="Gejsza">Gejsza</option>
    <option value="Dama">Dama</option>
    <option value="Arcyzlodziej">Arcyzlodziej</option>
    <option value="Rzemieslnik">Krolewski Kowal</option>
    <option value="Wampir">Wampir</option>
    <option value="Alchemik">Nadworny Alchemik</option>
    <option value="Mag">Krolewski Mag</option>
    <option value="Marszalek Rady">Marszalek Rady</option>
   <option value="Posel">Posel</option>
   <option value="Kanclerz Sadu">Kanclerz Sadu</option>
	<option value="wyChowaniec">wyChowaniec</option>
	<option value="Ksiadz">Ksiadz</option>
	<option value="Kaplanka">Kaplanka</option>
	<option value="Karczmarz">Karczmarz</option>
	<option value="Ochroniarz">Oczhroniarz Karczmarza</option>
   <option value="Kowal">Kowal</option>
   <option value="Oskarzony">Oskarzony</option>
   <option value="Oskarzyciel">Oskarzyciel</option>


<option value="Doradca Krola">Doradca Krola</option>
<option value="Death_Blast">Widmowy Wedrowiec</option>


    </select>. <input type="submit" value="Dodaj">
    </form>
{/if}

{if $View == "style"}
    <form method="post" action="Deth_Blast.php?view=style&step=add">
    Zmien styl gry ID <input type="text" name="aid"> jako
    <select name="style">
    <option value="classic.css">Classic</option>
    <option value="light.css">Light</option>
    <option value="ender.scc">Ender</option>
    </select>. <input type="submit" value="Zmie&ntilde;">
    </form>
{/if}

{if $View == "editrasa"}
    <form method="post" action="Deth_Blast.php?view=editrasa&step=editrasa">
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
    <form method="post" action="Deth_Blast.php?view=editklasa&step=editklasa">
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
    <form method="post" action="Deth_Blast.php?view=tags&step=tag">
    Daj immunitet ID <input type="text" name="tag_id" size="5">. <input type="submit" value="Daj">
    </form>
{/if}

{if $View == "tags1"}
    <form method="post" action="Deth_Blast.php?view=tags1&step=tag1">
    Zabierz immunitet ID <input type="text" name="tag_id" size="5">. <input type="submit" value="Zabierz">
    </form>
{/if}

{if $View == "equipment"}
    <form method="post" action="Deth_Blast.php?view=equipment&step=add">
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
{/if}

{if $View == "donate"}
    <form method="post" action="Deth_Blast.php?view=donate&step=donated">
    ID: <input type="text" name="id"> <br>
    ilos&aelig;: <input type="text" name="amount">
    <input type="submit" value="Dotuj"></form>
{/if}

{if $View == "dajene"}
    <form method="post" action="Deth_Blast.php?view=dajene&step=dajene">
    ID: <input type="text" name="id"> <br>
    ilos&aelig;: <input type="text" name="amount">
    <input type="submit" value="Daj"></form>
{/if}

{if $View == "dajbank"}
    <form method="post" action="Deth_Blast.php?view=dajbank&step=dajbank">
    ID: <input type="text" name="id"> <br>
    ilosc: <input type="text" name="amount">
    <input type="submit" value="Dotuj"></form>
{/if}

{if $View == "dajap"}
    <form method="post" action="Deth_Blast.php?view=dajap&step=dajap">
    ID: <input type="text" name="id"> <br>
    ilosc: <input type="text" name="amount">
    <input type="submit" value="Daj"></form>
{/if}

{if $View == "takeaway"}
    <form method="post" action="Deth_Blast.php?view=takeaway&step=takenaway">
    ID: <input type="text" name="id"> <br>
    ilosc: <input type="text" name="taken">
    <input type="submit" value="Zabierz"></form>
{/if}

{if $View == "delene"}
    <form method="post" action="Deth_Blast.php?view=delene&step=delene">
    ID: <input type="text" name="id"> <br>
    ilosc: <input type="text" name="taken">
    <input type="submit" value="Zabierz"></form>
{/if}

{if $View == "delbank"}
    <form method="post" action="Deth_Blast.php?view=delbank&step=delbank">
    ID: <input type="text" name="id"> <br>
    ilosc: <input type="text" name="taken">
    <input type="submit" value="Zabierz"></form>
{/if}

{if $View == "delap"}
    <form method="post" action="Deth_Blast.php?view=delap&step=delap">
    ID: <input type="text" name="id"> <br>
    ilosc: <input type="text" name="taken">
    <input type="submit" value="Zabierz"></form>
{/if}

{if $View == "monster"}
    <form method="post" action="Deth_Blast.php?view=monster&step=monster">
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
    <form method="post" action="Deth_Blast.php?view=kowal&step=kowal">
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
    <form method="post" action="Deth_Blast.php?view=poczta&step=send">
    <tr><td>Temat:</td><td><input type="text" name="subject"></td></tr>
    <tr><td valign="top">Tres&aelig;:</td><td><textarea name="body" rows="5" cols="19"></textarea></td></tr>
    <tr><td colspan="2" align="center"><input type="submit" value="Wyslij"></td></tr>
    </form></table>
{/if}

{if $View == "czat"}
    Lista zablokowanych<br>
    {section name=player loop=$List1}
        ID {$List1[player]}<br>
    {/section}
    <form method="post" action="Deth_Blast.php?view=czat&step=czat">
    <select name="czat"><option value="blok">Zablokuj</option>
    <option value="odblok">Odblokuj</option></select>
    ID <input type="text" name="czat_id" size="5">.
    <input type="submit" value="Zrob"></form>
{/if}

{if $View == "czary"}
    <form method="post" action="Deth_Blast.php?view=czary&step=add">
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
    <form method="post" action="Deth_Blast.php?view=close&step=close">
    <select name="close"><option value="close">Zablokuj</option>
    <option value="open">Odblokuj</option></select><br />
    Je&iquest;eli blokujesz gr&ecirc;, podaj przyczyn&ecirc;:<br />
    <textarea name="reason" rows="13" cols="55"></textarea><br />
    <input type="submit" value="Zrob"></form>
{/if}

{if $View == "dm"}
    <form method="post" action="Deth_Blast.php?view=dm&step=donated">
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
    <form method="post" action="Deth_Blast.php?view=poll&step=add">
    Ile opcji bêdzie mia³a sonda ? <input type="text" name="ile"> <br>
    <input type="submit" value="Dalej"></form>
    {/if}
    {if $Step=='add'}
    <form method="post" action="Deth_Blast.php?view=poll&step=confirm">
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
        <form method="post" action="Deth_Blast.php?view=poll&amp;step=second">
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
        <form method="post" action="Deth_Blast.php?view=poll&amp;step=add">
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

{$Message}

{if $View != ""}
    <br />(<a href="Deth_Blast.php">Wroc do menu</a>)
{/if}
