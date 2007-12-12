



Tutaj znajduja sie osoby, ktore zdecydowaly sie polaczyc na wieki:  
<br><br>
<table class="table">
{section name=p loop=$Pary}
	<tr>
		<td class="thead"><a href="view.php?view={$Pary[p].marriage1}">{$Pary[p].p1}</a> i <a href="view.php?view={$Pary[p].marriage2}">{$Pary[p].p2}</a></td>
		<td class="thead">{$Pary[p].data}</td>
		<td class="thead">{$Pary[p].cost}</td>
		<td class="thead">{if $Pary[p].break == 1}<a href="?break={$Pary[p].id}">Uniewaznij</a>{/if}</td>
	</tr>
	<tr>
		<td colspan=4>{$Pary[p].desc}</td>
	</tr>
{/section}
</table>
<br><br>
Jesli bardzo go pragniesz, a on Ciebie, napiszcie do ksiedza.<br>
- Nowozency w prezencie dostaja 2 do max energi<br>
- Para po rozwodzie traci 3 max energi<br>
- Dozwolone sa zwiazki tej samej plci.<br>
- Kazda strona musi napisac wiadomosc!<br>
- W wiadomosci prosze umiescic:<br>
  1. ID: Kobiety<br>
  2. ID: Mezczyzny<br>
  3. W jaki sposob sie oswiadczyl<br><br>
Aktualnie slubow na Kara-Tur udzielac moga :
<ul>
{$Priests}
</ul>
Prosimy jednak w miare mozliwosci kierowac prosby o slub albo do kaplanow albo na formularz zgloszeniowy.<br>
{*
	{section name=pary loop=$Name}
		<b>Imie Kobiety:</b> <a href=view.php?view={$Id[pary]}>{$Name[pary]}</a><br>
		<b>ID Kobiety:</b> {$Id[pary]}<br>
		<b>Imie Mezczyzny:</b> <a href=view.php?view={$Idp[pary]}>{$Namep[pary]}</a><br>
		<b>ID Mezczyzny:</b> {$Idp[pary]}<br>
		<b>Data ich slubu:</b> {$Date[pary]}<br>
		<b>Oswiadczyny:</b> {$Verdict[pary]}<br>
		<b>Koszt rozwodu:</b> <a href=pary.php?prisoner={$Jailid[pary]}>{$Cost[pary]} sztuk zlota</a><br><br><br>
	{/section}
*}
<center><img src="sluby.jpg"/></center><br />
