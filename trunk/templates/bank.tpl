<center><img src="bank.jpg"/></center><br />
Witaj w banku. Mozesz przechowac tutaj sztuki zlota, aby nie ukradl ci ich ktos inny.
Mozesz rowniez darowac nieco pieniedzy innemu uzytkownikowi<br>

{if $About=='fixed'}
<br>
Branie lokat charakteryzuje si� wi�kszymi procentami ni� normalne trzymanie pieni�dzy w banku, ale z�oto na lokacie jest zamro�one czyli nie mo�na go wyp�aci� do czasu a� nie minie termin. Zreszt� pieni�dze automatycznie s� wyp�acane gdy termin dobiegnie ko�ca [je�li wp�aci�e� o 13.20 to zostanie wyp�acone przy najbli�szym resecie tj. o 14]<br>
Je�li zdecydujesz si� na wp�at� pieni�dzy na d�u�szy okres to b�dziesz mia� wi�ksze korzy�ci ...
<ul>
	<li>1 tydzie� - 4%
	<li>2 tygodnie - 6%
	<li>3 tygodnie - 8%
	<li>4 tygodnie - 10%
</ul>
{elseif $About=='loan'}
<br>Kredyty - szybka got�wka *mruga* ... droga szybka got�wka. Kredyty obarczone s� 20% stop� procentow�. Je�li bierzesz kredyt mniejszy ni� 100 000 sztuk z�ota to wtedy masz na sp�at� 15 dni. Sporo. Je�li bierzesz wi�cej to masz na sp�at� 30 dni. Je�li chcesz sp�aci� cz�� albo ca�o�� kredytu to poprostu naci�nij "sp�acaj" obok kredytu. Jesli masz wystarczaj�co z�ota to zostanie kredyt sp�acony. W przeciwnym wypadku zostanie sp�acone tyle ile masz kasy przy sobie. Je�li b�dziesz zwleka� z terminem i go przekroczysz - zostaniesz wrzucony do wi�zienia. Tam gdy uzbiera Ci si� energia - b�dziesz musia� j� wykorzysta� na roboty na rzecz pa�stwa a� do czasu sp�aty kredytu. Czyli b�dziesz siedzia� tyle ile potrzeba �eby� sp�aci� ca�y kredyt. Maksymalnie mo�esz wzi�� 5 kredyt�w na sum� nie wi�ksz� ni� 300 000 sztuk z�ota ka�dy<br><br>
{/if}

<form method="post" action="bank.php?action=withdraw">
Chce <input type="submit" value="wycofac"> <input type="text" value="{$Bank}" name="with"> sztuk zlota.
</form>

<form method="post" action="bank.php?action=deposit">
Chce <input type="submit" value="zdeponowac"> <input type="text" value="{$Gold}" name="dep"> sztuk zlota.
</form>

<form method="post" action="bank.php?action=dotacja">
Chce <input type="submit" value="dac"> graczowi ID (numer) <input type="tekst" name="id" size="3">
<input type="text" value="{$Bank}" name="with"> sztuk zlota.
</form>

{*if $Mithril > 0}
	<form method="post" action="bank.php?action=mithril">
	Chce <input type="submit" value="dac"> graczowi ID (numer) <input type="tekst" name="id" size="3">
	<input type="text" name="mith"> sztuk mithrilu.
	</form>
{/if*}

{*if $Items == 1*}
	<form method="post" action="bank.php?action=items">
	Chce <input type="submit" value="dac"> graczowi ID (numer) <input type="tekst" name="id" size="3">
	<input type="text" name="amount" size="3"> sztuk(i) <select name="item">
	{section name=i loop=$GiveItem}
		<option value={$GiveItem[i].key}>{$GiveItem[i].item}</option>
	{/section}
	</select>.</form>
{*/if*}

{*if $Potions == 1*}
	<form method="post" action="bank.php?action=potions">
	Chce <input type="submit" value="dac"> graczowi ID (numer) <input type="tekst" name="id" size="3">
	<input type="text" name="amount" size="3"> sztuk(i) <select name="item">
	{section name=p loop=$GivePot}
		<option value={$GivePot[p].key}>{$GivePot[p].potion}</option>
	{/section}
	</select>.</form>
{*/if*}

{*if $Herbs == }
	<form method="post" action="bank.php?action=herbs">
	Chce <input type="submit" value="dac"> graczowi ID (numer) <input type="tekst" name="id" size="3"> 
	<select name="item">
		
	{*section name=herb loop=$Herbname}
		<option value={$Herbname[herb]}>{$Herbname[herb]}</option>
	{/sectio}
	</select> w ilosci <input type="text" name="amount" size="5">.</form>
{*/if*}

{*if $Minerals == 1*}
	<form method="post" action="bank.php?action=minerals">
	Chce <input type="submit" value="dac"> graczowi ID (numer) <input type="tekst" name="id" size="3"> 
	<select name="item">
		<option value="mithril">Mithril
		<option value='copper'>Miedz
		<option value='iron'>Zelazo
		<option value='coal'>Wegiel
		<option value='adamantium'>Adamantium
		<option value='meteor'>Meteor
		<option value='crystal'>Krysztaly
		<option value='wood'>Drewno
		<option value='illani'>Illani
		<option value='illanias'>Illanias
		<option value='nutari'>Nutari
		<option value='dynallca'>Dynallca
	{*section name=mineral loop=$Minname}
		<option value={$Minoption[mineral]}>{$Minname[mineral]}</option>
	{/section*}
	</select> w ilosci <input type="text" name="amount" size="5">.</form>
{*/if*}

<form method="post" action="?action=fixed">
Chc� z�o�y� <input type="text" name="fixed"> z�ota na lokat� na okres 
<select name="time">
	<option value="7">tygodnia
	<option value="14">dw�ch tygodni
	<option value="21">trzech tygodni
	<option value="27">czterech tygodni
</select><br>
<input type="submit" value="Dalej"> [dowiedz si� wi�cej o <a href="bank.php?about=fixed">lokatach</a>]<br>
</form>
{*
<form method="post" action="?action=loan">
Chc� po�yczy� <input type="text" name="loan"> z�ota<br>
<input type="submit" value="Dalej"> [dowiedz si� wi�cej o <a href="bank.php?about=loan">kredytach</a>]<BR>
</form>
*}

<br>Lokaty<br>
<table class="table">
<tr><td class="thead">Warto��</td><td class="thead">Ko�cowa</td><td class="thead">procent</td><td class="thead">Koniec za</td></tr>
{section name=f loop=$Depo}
	<tr><td>{$Depo[f].base}</td><td>{$Depo[f].current}</td><td>{$Depo[f].proc} %</td><td>{$Depo[f].time} dni</td></tr>
{sectionelse}
	<tr><td colspan="4">Nie posiadasz �adnych lokat</td></tr>
{/section}
</table>

<br>Pozyczki<br>
<table class="table">
<tr>
	<td class="thead">Warto��</td>
	<td class="thead">procent</td>
	<td class="thead">Do splaty</td>
	<td class="thead">Termin do</td>
	<td class="thead">Akcja</td>
</tr>
{section name=l loop=$Loan}
	<tr><td>{$Loan[l].base}</td><td>{$Loan[l].proc} %</td><td>{$Loan[l].current}</td><td>{$Loan[l].time}</td>
	<td><form method="post" action="?action=repay"><input type="hidden" name="lid" value="{$Loan[l].id}"/><input type="submit" value="splacaj"/></form></td>
	</tr>
{sectionelse}
	<tr><td colspan="5">Nie posiadasz �adnych lokat</td></tr>
{/section}
</table>

{$Crime}

