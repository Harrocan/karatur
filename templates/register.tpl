{if $Action == ""}
    Zarejestruj sie w grze. To nic nie kosztuje. Po rejestracji na twoje konto email zostanie wyslany specjalny link aktywacyjny. 
    <b>Uwaga!</b> Jezeli korzystasz z konta na Wirtualnej Polsce lub Tlenie - sprawdz czy nie masz ustawionego filtru anty-spamowego. 
    Poniewaz mail jest wysylany programowo nie recznie, jest traktowany jako spam i moze nigdy nie dojsc do ciebie!<br />Haslo musi
    skladac sie z co najmniej 5 znakow z czego musi byc co najmniej jedna wielka litera (A,G,W, itd) oraz cyfra.<br />
    Mamy obecnie <b>{$Players}</b> zarejestrowanych graczy.
    <form method=post action=register.php?action=register>
	<table>
	<tr><td>Pseudonim:</td><td><input type="text" name="user"></td></tr><center><a href="http://www.kara-tur.yoyo.pl/imie.html">Generator imion Kara-Tur</a></center>
	<tr><td>Email:</td><td><input type="text" name="email"></td></tr>
	<tr><td>Potwierdz email:</td><td><input type="text" name="vemail"></td></tr>
	<tr><td>Haslo:</td><td><input type="password" name="pass"></td></tr>
        <tr><td>ID Polecajacego:</td><td><input type="text" name="ref" value="{$Referal}"> <i>Jezeli nie jestes czyims poleconym,
             to pole jest puste.</i></td></tr>
	<tr><td colspan=2 align="center"><input type="submit" value="Zarejestruj"></td></tr></table>
    </form>
    Krotki spis zasad w grze:<br />
    <ol>
    <li>W grze obowiazuje netykieta - w wielkim skrocie - nie rob drugiemu co tobie nie mile.</li>
    <li>Wielokrotne ataki na jednego gracza w ciagu kilku minut - czyli zwykle nekanie - sa karane.</li>
    <li>Wykorzystywanie bledow w grze do zdobycia przewagi nad innymi konczy sie najczesciej skasowaniem postaci. Natomiast pomoc w ich znalezieniu moze zostac nagrodzona przyznaniem specjalnej rangi</li>
    <li>W sprawie jakichkolwiek naruszen prawa mozesz zglaszac to do ksiazat - oni najczesciej rowniez wymierzaja kare</li>
    <li>Jezeli nie zgadzasz sie z kara, mozesz zawsze decyzje zaskarzyc do Sadu Najwyzszego - jego siedziba znajduje sie na forum zewnetrznym (link podany jest u gory).</li>
    <li>Zabrania sie posiadania wiecej niz 1 konta na osobe</li>
    <li>Wiecej informacji na ten temat znajdziesz <a href="index.php?step=rules">tutaj</a></li>
    <li>Pamietaj, jezeli chcesz grac w te gre, musisz zaakceptowac zasady w niej obowiazujace</li>
    </ol><center>
{/if}

{if $Action == "register"}
   <div style="text-align:center;font-size:110%;"><br>Proces rejestracji przebieg³ pomy¶lnie.<br>Sprawdz swoj± skrzynkê pocztow±. Wys³ali¶my na ni± e-mail z kluczem aktywuj±cym Twoje konto.</div>
{/if}

