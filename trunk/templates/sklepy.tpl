{if $View == "" && $Remowe == "" && $Buy == ""}
<br>
W tej cz�ci miasta mieszka�cy krainy Kara-Tur rozlokowali swoje sklepy. Wie�� g�osi, �e mo�na w nich naby� niemal wszystko!<br>
Rozgl�daj�c si� uwa�nie dostrzegasz sporo szyld�w i kupc�w zach�caj�cych ci�, do obejrzenia ich towar�w : <br><br>
<ul>
{section name=sklepy loop=$Sklepy}
{$Sklepy[sklepy]}
{/section}
{if $Sklep == 'Y'}
<li><a href="{$SCRIPT_NAME}?view=add">Dodaj ofert�</a>
<li><a href="{$SCRIPT_NAME}?view=del">Skasuj wszystkie swoje oferty</a>
{/if}
{if $Sklep == 'N'}
<li>W dobrze widocznym miejscu, mi�dzy dwoma sklepami wysi og�oszenie :<br>UWAGA MIESZKA�CY !<br>Za uczciw� kwot� pi��dziesi�ciu tysi�cy sztuk z�ota i<br>stu sztuk mithrilu mo�ecie za�o�y� sw�j w�asny sklep!<br>Ch�tni winni zg�asza� si� do <a href="{$SCRIPT_NAME}?view=kup1">zarz�dcy</a>.
{/if}
</ul>
{/if}

{if $View == "kup1"}
<form method="post" action="sklepy.php?view=kup">
Wita ci� gruby, ubrany w szykowny str�j zarz�dca :<br>- Witaj ! Mam dla ciebie �wietn� ofert�! W�asny sklep za drobne pi��dziesi�t tysi�cy z�ota i gar�� mithrilu.<br>*u�miecha si� niemal niezauwa�alnie*<br>- Podaj mi tylko szybko nazw� jaka ma si� pojawi� na szyldzie twojego sklepu, a ja dope�ni� wszystkich potrzebnych formalno�ci.<br>
- Pami�taj jednak ! Je�eli nazwa sklepu b�dzie wulgarna, b�d� te� powiedzmy to dosadnie - beznadziejnie niepasuj�ca do klimatu naszego miasta, stracisz sw�j sklep bez zwrotu koszt�w.<br>
- Noo po�piesz si�. Wielu chce skorzysta� z tak dobrej okazji !
<input type="text" name="opis">
<input type="submit" value="Podaj nazw�"><br>
</form>
{/if}

{if $View == "szukaj"}
Szukaj ofert w sklepach lub <a href="sklepy.php">wroc</a>. Uwaga! Wpisz dokladn� nazwe przedmiotu jakiego poszukujesz.<br><br>
<table><form method="post" action="sklepy.php?view=market&limit=0&lista=name">
Przedmiot: <input type="text" name="szukany">
<tr><td colspan="2" align="center"><input type="submit" value="Szukaj"></td></tr>
</form></table>
{/if}

{if $View == "market"}
Zobacz oferty lub <a href="sklepy.php">wroc</a>.<br><br>
<center><b>UWAGA!!!</b><br>Aby kupi� przedmiot nale�y kliknac na jego na nazwie, w�asne przedmioty sa podswietlone na niebiesko.</center><br>
<table>
<tr>
<td width="100"><b><u>Nazwa</u></b></td>
<td width="100"><b><u>Sila</u></b></td>
<td width="100"><b><u>Wytrz</u></b></td>
<td width="100"><b><u>Szyb</u></b></td>
<td width="100"><b><u>Zrec</u></b></td>
<td width="50"><b><u>Poz</u></b></td>
<td width="50"><b><u>Ile</u></b></td>
<td width="50"><b><u>Koszt</u></b></td>
</tr>
{section name=item loop=$Name}
<tr>
{$Action[item][0]}{popup text='Klikajac na przedmiot kupujesz go lub wycofujesz ze sprzedarzy jezeli nalezy on do Ciebie' fgcolor='black' bgcolor='black' textcolor='white' border=1 vauto=TRUE}{$Action[item][1]}{$Name[item]}{$Action[item][2]}
<td align="center">{$Power[item]}</td>
<td align="center">{$Durability[item]}/{$Maxdur[item]}</td>
<td align="center">{$Speed[item]}</td>
<td align="center">{$Agility[item]}</td>
<td align="center">{$Minlev[item]}</td>
<td align="center">{$Amount[item]}</td>
<td>{$Cost[item]}</td>
{/section}
</table>
{$Previous}{$Next}
{/if}

{if $View == "add"}
Dodaj oferte do sklepu lub <a href="sklepy.php">wroc</a>.<br><br>
<table><form method="post" action="sklepy.php?view=add&step=add">
Przedmiot: <select name="przedmiot">
{section name=item1 loop=$Name}
<option value="{$Itemid[item1]}">{$Name[item1]}(ilosc: {$Amount[item1]})</option>
{/section}
<tr><td>Ilosc:</td><td><input type="text" name="amount"></td></tr>
<tr><td>Cena za sztuke:</td><td><input type="text" name="cost"></td></tr>
<tr><td colspan="2" align="center"><input type="submit" value="Dodaj"></td></tr>
</form></table>
{/if}

{if $Buy != ""}
Zakup przedmiot lub <a href="sklepy.php">wroc</a>.<br /><br />
<b>Przedmiot:</b> {$Name} <br />
<b>Sila:</b> {$Power} <br />
{if $Agi != "0"}
<b>Premia do zrecznosci:</b> {$Agi} <br />
{/if}
{if $Speed != "0"}
<b>Premia do szybkosci:</b> {$Speed} <br />
{/if}
{if $Type != "R" && $Type != "S" && $Type != "Z" && $Type != "G"}
<b>Wytrzymalosc:</b> {$Dur}/{$MaxDur} <br />
{/if}
{if $Type == "R"}
<b>Liczba strzal:</b> {$Dur} <br />
{/if}
{if $Type == "G"}
<b>Liczba grotow:</b> {$Dur} <br />
{/if}
<b>Ilosc w ofercie:</b> {$Amount1} <br />
<b>Cena za sztuke:</b> {$Cost} <br />
<b>Sprzedaj�cy:</b> <a href="view.php?view={$Sid}">{$Seller}</a> <br /><br />
<table><form method="post" action="sklepy.php?buy={$Itemid}&step=buy">
<tr><td>Ilosc:</td><td><input type="text" name="amount"></td></tr>
<tr><td colspan="2" align="center"><input type="submit" value="Kup"></td></tr>
</form></table>
{/if}

{if $View == "all"}
Tutaj masz spis wszystkich ofert jakie s� w sklepach.<br />
<table>
<tr>
<td><b><u>Nazwa</u></b></td><td><b><u>Ofert</u></b></td><td align="center"><b><u>Akcja</u></b></td>
</tr>
{section name=all loop=$Name}
<tr>
<td>{$Name[all]}</td>
<td align="center">{$Amount[all]}</td>
<td><form method="post" action="sklepy.php?view=market&limit=0&lista=id">
<input type="hidden" name="szukany" value="{$Name[all]}">
<input type="submit" value="Pokaz"></form>
</td>
</tr>
{/section}
</table>
{/if}

{$Message}

