Witaj w ustawieniach konta. Prosze, wybierz opcje.
<ul>
<li><img src="opcje/imie.png"><a href="account.php?view=name">Zmien imie</a></li>
<li><img src="opcje/key.png"><a href="account.php?view=pass">Zmien haslo</a></li>
<li><img src="opcje/prof.png"><a href="account.php?view=profile">Edytuj profil</a></li>
<li><img src="opcje/gg.png"><a href="account.php?view=eci">Edytuj informacje kontaktowe</a></li>
<li><img src="opcje/avatar.png"><a href="account.php?view=avatar">Edytuj avatara</a>  &nbsp;</li>
<li><img src="opcje/res.png"><a href="account.php?view=reset">Resetuj postac</a></li>
<li><img src="opcje/immu.png"><a href="account.php?view=immu">Immunitet</a></li>
<li><img src="opcje/key.png"><a href="account.php?view=freeze">Zamro¿enie konta</a></li>
<li><img src="opcje/status.png"><a href="account.php?view=opis">Zmien Opis</a></li>
</ul>
{if $View == "immu"}
    Tutaj mozesz samodzielnie dodac sobie immunitet. Immunitet chroni ciebie przed atakami oraz kradziezami dokonywanymi przez innych graczy, ale sam tez nie bedziesz mogl
    atakowac ani okradac (dotyczy tylko zlodzieja) ich. Na dodatek immunitet jest na stale, mozna go zdjac jedynie resetujac postac. Immunitet mozesz wybrac dopiero w momencie wyboru klasy postaci. Czy na pewno chcesz immunitet?<br>
    - <a href="account.php?view=immu&step=yes">Tak</a><br>
    - <a href="account.php">Nie</a><br>
    {if $Step == "yes"}
        Od tej chwili posiadasz immunitet. Kliknij <a href="account.php">tutaj</a> aby wrocic od opcji konta.
    {/if}
{/if}

{if $View == "freeze"}
	{if $Freeze == "Y"}
		Twoje konto jest obecnie zamro¿one.<br/>
		{if $CanFreeze}
			Czy chcesz odmroziæ swoje konto ?<br/>
			<a href="?view=freeze&unfreeze=Y">Tak</a><br/>
			<a href="?">Nie</a>
		{else}
			Nie mo¿esz odmroziæ teraz konta. Odmro¿enie stanie siê mo¿liwe {$DiffString}
		{/if}
	{else}
		Tutaj mo¿esz zamroziæ konto. Na zamro¿onym koncie nie narasta energia, ani ¿adne inne elementy kóre narastaj± na resetach, dana postaæ nie mo¿e zostaæ zaatakowana, oraz sama nie mo¿e wykonywaæ ¿adnych akcji (z karczm± w³±cznie). Jednak¿e zamro¿one konto nie ulega kasacji przez 7 tygodni (normalnie jest kasowane po 3 tyg. nieaktywno¶ci). Oczywi¶cie podczas zamro¿enia mo¿esz logowaæ siê na konto, ¿eby odnowiæ okres odliczania czasu do kasacji. Minimalny okrez zamro¿enia konta to 5 dni, oraz konto mo¿na zamra¿aæ nie czê¶ciej ni¿ co 3 dni od momentu rozmro¿enia konta.<br/>
		{if $CanFreeze}
			Czy chcesz zamroziæ swoje konto ?<br/>
			<li><a href="?view=freeze&freeze=Y">Tak</a></li>
			<li><a href="?">Nie</a></li>
		{else}
			Nie mo¿esz zamroziæ teraz konta. Zamro¿enie stanie siê mo¿liwe {$DiffString}
		{/if}
	{/if}
{/if}


{if $View == "reset"}
    Tutaj mozesz zresetowac swoja postac. Na twoj mail zostanie wyslany specjalny link aktywacyjny. Dopiero po kliknieciu na niego twoja
    postac zostanie zresetowana. Zostanie jej jedynie id, nick, haslo, mail, profil, poleceni oraz wiek. Czy chcesz zresetowac postac?<br>
    <a href="account.php?view=reset&step=make">- Tak</a><br>
    <a href="account.php">- Nie</a><br>
    {if $Step == "make"}
        Na twoje konto pocztowe zostal wyslany mail z prosba o potwierdzenie resetu postaci<br>
    {/if}
{/if}

{if $View == "avatar"}
    Tutaj mozesz zmienic swojego avatara. <b>Uwaga!</b> Jezeli juz posiadasz avatara, stary zostanie skasowany. Maksymalny rozmiar avatara
    to 10 kB. Avatara mozesz zaladowac tylko z wlasnego komputera. Musi on miec rozszerzenie *.jpg, *.jpeg lub *.gif<br>
    {if $Avatar != ""}
 <center><br><br><img src="{$Avatar}" width="100" heigth="100">
        <form action="account.php?view=avatar&step=usun" method="post">
 <input type="hidden" name="av" value="{$Value}">
 <input type="submit" value="Skasuj"></form></center>
    {/if}
    <form enctype="multipart/form-data" action="account.php?view=avatar&step=dodaj" method="post">
    <input type="hidden" name="MAX_FILE_SIZE" value="10240">
    Nazwa pliku graficznego: <input name="plik" type="file"><br>
    <input type="submit" value="Wyslij"></form>
{/if}

{if $View == "name"}
    <form method="post" action="account.php?view=name&step=name">
    <input type="submit" value="Zmien"> moje imie na <input type="text" name="name">
    </form>
{/if}

{if $View == "opis"}
    <form method="post" action="account.php?view=opis&step=opis">
    <input type="submit" value="Zmien"> moj opis na <input type="text" name="opis" value="...">
    </form>
{/if}

{if $View == "pass"}
    Nie uzywaj HTML, ani pojedynczego cudzyslowu. Nie probuj go uzywac, bedzie usuniety.<BR>
    <form method="post" action="account.php?view=pass&step=cp">
    <table>
    <tr><td>Obecne haslo:</td><td><input type="password" name="cp"></td></tr>
    <tr><td>Nowe haslo:</td><td><input type="password" name="np"></td></tr>
    <tr><td colspan=2 align=center><input type="submit" value="Zmien"></td></tr>
    </form>
    </table>
{/if}

{if $View == "profile"}
    {if $Step == "profile"}
 <table>
 <tr><td><span style="color:green;font-weight:bold">Profil zapisany poprawnie !</span></td></tr>
 </table>
 
    {/if}
    <table>
    <form method="post" action="account.php?view=profile&step=profile">
    <tr><td>Dodaj/Modyfikuj swoj profil. Nie uzywaj html ani pojedynczego cudzyslowu!</td></tr>
    <tr><td align="center">Nowy profil:<br /> <textarea name="profile" id="profile" style="width:100%;height:200px">{$Profile}</textarea></td></tr>
    <tr><td colspan=2 align=center><input type="submit" value="Zapisz"></td></tr>
    </form>
    <tr>
    <td colspan="2" style="text-align:center"><a style="font-size:1.6em;font-weight:bold;color:green" href="bbhelp.php"> -&gt; Pomoc do profili ! &lt;-</a></td>
    </tr>
    </table>
	
{/if}

{if $View == "eci"}
    <table>
    <form method=post action="account.php?view=eci&step=ce">
    <tr><td>Obecny adres e-mail:</td><td><input type="text" name="ce" value="{$Email}"></td></tr>
    <tr><td>Nowy adres e-mail:</td><td><input type="text" name="ne"></td></tr>
    <tr><td colspan=2 align="center"><input type="submit" value="Zmien"></td></tr>
    </form>
    </table>
    <table>
    <form method=post action="account.php?view=eci&step=gg">
 <tr><td>Adres gadu-gadu:</td><td><input type="text" name="gg" value="{$GG}"></td></tr>
 <tr><td colspan=2 align=center><input type="submit" value="Zmien"></td></tr>
    </form>
   </table>
{/if}

{if $View == "style"}
    <table>
    <form method="post" action="account.php?view=style&step=style">
    <tr>
    <td><input type="submit" value="Wybierz"> tektowy wyglad gry:</td>
    </tr>
    <tr>
    <td><select name=newstyle>
    {section name=account loop=$Stylename}
        <option value="{$Stylename[account]}">{$Stylename[account]}</option>
    {/section}
    </select>
    </form>
    </table><br /><br />
    Mozesz rowniez wybrac styl graficzny gry.<br />
    <table>
    <form method="post" action="account.php?view=style&step=graph" disabled>
    <tr>
    <td><input type="submit" value="Wybierz"> graficzny wyglad gry:</td>
    </tr>
    <tr>
    <td><select name=graphserver disabled>
    {section name=account1 loop=$Layoutname}
        <option value="{$Layoutname[account1]}">{$Layoutname[account1]}</option>
    {/section}
    </select>
    </form>
    </table><br /><br />
    {if $Step == "style" || $Step == "graph"}
       Zmieniles wyglad gry. (<a href="account.php">Odswiez</a>)
    {/if}
{/if}
