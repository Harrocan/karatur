<br>
<div style='text-align:center;font-size:110%;'>Rozpoczynasz medytacjê, dziêki której jeste¶ w stanie dok³adnie okre¶liæ poziom swoich umiejêtno¶ci.</div><br><br>
{$Avatar}
<table width="390px">
<tr><td width=50% valign=top>
	<center><b><u>Statystyki w grze</b></u></center><br>
	<b>AP:</b> {$Ap}
	<b>Rasa:</b> {$Race}
	<b>Charakter:</b> {$Charakter}
	<b>Klasa:</b> {$Clas}
	<b>Wyznanie:</b> {$Deity}
	<b>P³eæ:</b> {$Gender}
	<b>Stan Cywilny:</b> {$Stan}
        <b>Zrêczno¶æ:</b> {$Agility}
	<b>Si³a:</b> {$Strength}
	<b>Inteligencja:</b> {$Int}
	<b>Si³a woli:</b> {$Wisdom}
	<b>Szybko¶æ:</b> {$Speed}
	<b>Wytrzyma³o¶æ:</b> {$Cond}
	<b>Punkty Magii:</b> {$Mana} {$Rest}
	<b>Punkty Wiary:</b> {$PW}
	{$Crime}
	{if isset($Ugryz)}{$Ugryz}{/if}<br>
	{if isset($Krewka)}<b>Krew:</b> {$Krewka}/{$Krewka_m}{/if}<br>
	<b>Wyniki:</b> {$Total}
	<b>Ostatnio zabity:</b> {$Lastkilled}
	<b>Ostatnio zabity przez:</b> {$Lastkilledby}<br><br>
        <p>
	<b>Skóra:</b> {$Skora}
	<b>W³osy:</b> {$Wlos}
	<b>Oczy(kolor):</b> {$Oczy}
	</p>
</td><td width=50% valign=top>
	<center><b><u>Informacje</b></u></center><br>
	<b>Pochodzenie:</b> {$Poch}
	<b>Zwierzêcy towarzysz:</b> {$Tow}
        <b>Ranga:</b> {$Rank}
        <b>Lokacja:</b> {$Location}
        <b>Dni w krainie:</b> {$Age}
        <b>Logowañ:</b> {$Logins}
        <b>IP:</b> {$Ip}
        <b>Email:</b> {$Email}
	{$GG}
        <b>Klan:</b> {$Tribe}
        {$Triberank}
</td></tr>





{if $Action == "gender"}
<tr>
<td width=50% valign=top colspan="2">
    <form method="post" action="stats.php?action=gender&step=gender">
    <select name="gender"><option value="M">Mezczyzna</option>
    <option value="F">Kobieta</option></select><br>
    <input type="submit" value="Wybierz"></form>
</td></tr>
{/if}
{if $Action == "stan"}
<tr>
<td width=50% valign=top colspan="2">
    <form method="post" action="stats.php?action=stan&step=stan">
    <select name="stan"><option value="Wolny">Wolny</option>
     <option value="Zajety">Zajety</option></select><br>
    <input type="submit" value="Wybierz"></form>
</td></tr>
{/if}
{if $Action == "char"}
<tr>
<td width=50% valign=top colspan="2">
    <form method="post" action="stats.php?action=char&amp;step=char">
    <select name="char">
    <option value="Anielski">Anielski</option>
    <option value="Chaotyczny dobry">Chaotyczny Dobry</option>
    <option value="Praworzadny Dobry">Praworzadny Dobry</option>
    <option value="Dobry">Dobry</option>
    <option value="Praworzadny Neutralny">Praworzadny Neutralny</option>
    <option value="Chaotycznie Neutralny">Chaotycznie Neutralny</option>
    <option value="Neutralny">Neutralny</option>
    <option value="Prawozadny Zly">Paworzadny Zly</option>
    <option value="Zly">Zly</option>
    <option value="Chaotyczny zly">Chaotyczny Zly</option>
    <option value="Diaboliczny">Diaboliczny</option>
    </select><br>
    <input type="submit" value="Wybierz"></form>
</td></tr>
{/if}

{if $Action == "poch"}
<tr>
<td width=50% valign=top colspan="2">
    <form method="post" action="stats.php?action=poch&amp;step=poch">
    <select name="poch">
    <option value="athkatla.php">Athkatla</option>
    <option value="eshpurta.php">Eshpurta</option>
    <option value="imnescar.php">Imnescar</option>
    <option value="baldursgate.php">Wrota Baldura</option>
    <option value="asbravn.php">Asbravn</option>
    <option value="candlekeep.php">Swiecowa Wie¿a</option>
    <option value="beregost.php">Beregost</option>
    <option value="nashkel.php">Nashkel</option>
    <option value="proskur.php">Proskur</option>
    <option value="iriaebor.php">Iriaebor</option>
    <option value="murann.php">Murann</option>
    <option value="purskul.php">Purskul</option>
    <option value="crimmor.php">Crimmor</option>
    <option value="keczulla.php">Keczulla</option>
    <option value="elturel.php">Elturel</option>
    <option value="berdusk.php">Berdusk</option>
    <option value="greenest.php">Greenest</option>
    <option value="brost.php">Brost</option>
    </select><br>
    <input type="submit" value="Wybierz"></form>
</td></tr>
{/if}

{if $Action == "wlos"}
<tr>
<td width=50% valign=top colspan="2">
   <form method="post" action="stats.php?action=wlos&step=wlos">
   <select name="wlos"><option value="Blond" selected="selected">Blond</option>
    <option value="Rudy">Rudy</option>
	<option value="Kruczoczarne">Kruczoczarne</option>
	<option value="Brunet">Brunet</option>
	<option value="Szatyn">Szatyn</option>
	<option value="Bia³e">Bia³e</option>
	<option value="Popielate">Popielate</option>
	<option value="£ysy">£ysy</option>
   </select><br>
   <input type="submit" value="Wybierz"></form>
 </td></tr>
{/if}
{if $Action == "oczy"}
<tr>
<td width=50% valign=top colspan="2">
   <form method="post" action="stats.php?action=oczy&step=oczy">
   <select name="oczy"><option value="Niebieskie" selected="selected">Niebieskie</option>
    <option value="Piwne">Piwne</option>
    <option value="Br±zowe">Br±zowe</option>
    <option value="Czarne">Czarne</option>
    <option value="Czerwone">Czerwone</option>
    <option value="Zielone">Zielone</option>
    <option value="Fioletowe">Fioletowe</option>
    <option value="Bia³e">Bia³e</option>
    <option value="Niebieskie">Niebieskie</option>
   </select><br>
   <input type="submit" value="Wybierz"></form>
 </td></tr>
{/if}
{if $Action == "skora"}
<tr>
<td width=50% valign=top colspan="2">
   <form method="post" action="stats.php?action=skora&step=skora">
   <select name="skora"><option value="Bia³a" selected="selected">Bia³a</option>
    <option value="Czarna">Czarna</option>
	<option value="¯ó³ta">¯ó³ta</option>
	<option value="¦niada">¦niada</option>
	<option value="Br±zowa">Br±zowa</option>
	<option value="Szara">Szara</option>
	<option value="Czerwona">Czerwona</option>
	<option value="Zielona">Zielona</option>
	<option value="Niebieska">Niebieska</option>
	<option value="Brunatna">Brunatna</option>
	<option value="Zielonkawa">Zielonkawa</option>
	<option value="¯ó³to-br±zowa">¯ó³to-br±zowa</option>
	<option value="¯ó³to-zielona">¯ó³to-zielona</option>
	<option value="Br±zowo-zielona">Br±zowo-zielona</option>
   </select><br>
   <input type="submit" value="Wybierz"></form>
</td></tr>
{/if}



<tr>
<td width=50% valign=top colspan="2">
	<center><b><u>Umiejêtno¶ci</u></b></center><br>
        <table align="center">
        <tr>
        <td>
        <img src="statystyki/kowal.gif"><b>Kowalstwo:</b> {$Smith}
        <img src="statystyki/alch.gif"><b>Alchemia:</b> {$Alchemy}
        <img src="statystyki/stol.gif"><b>Stolarstwo:</b> {$Fletcher}
        <img src="statystyki/walka.gif"><b>Walka broni±:</b> {$Attack}</td>
        <td>
        <img src="statystyki/unik.gif"><b>Unik:</b> {$Miss}
        <img src="statystyki/czar.gif"><b>Rzucanie czarów:</b> {$Magic}
        <img src="statystyki/dowo.gif"><b>Dowodzenie:</b>  {$Leadership}<br>
        <img src="statystyki/strzel.gif"><b>Strzelectwo:</b> {$Shoot}</td>
        </tr>
<tr><td width=50% valign=top>
	
</td></tr>
        </table>
</td></tr>
</table><br><b>INNE:</b><br>
<b>Gotowanie:</b> {$Gotowanie}<br><br>
{*<br><center><b><u>Przemiana (tylko Druid)</b></u></center><br>
        <li><b>Wilkolak:</b><br>przemiana {$Przemiana}<br>odmiana</b> {$Odmiana}<br><br><br><br> *}

