Witaj !<br>
Tutaj mo�esz wymieni� swoje punkty jakie uzbiera�e� polecaj�c nasz� krain� w zamorskich miejscowo�ciach<br>
<br>
Posiadasz {$Total} punkt�w, z czego wykorzysta�e� {$Used}. Pozosta�o Ci <b>{$Left}</b> punkt�w<br>
Czego sobie �yczysz ?
<ul>
	<li><a href="?type=a">AP</a> (1AP = 70 punkt�w)
	<li><a href="?type=e">Maksymalnej energii</a> (0.01 Max Energi = 20 punkt�w)
	<li><a href="?type=z">Z�ota</a> (1 z�ota = 0.5 punktu)
</ul>
{if $Type!=''}
<form method="post" action="?action=go">
Podaj ile {$What} chcesz zyska� : <input type="text" name="amount" style="width:30px"> <input type="submit" value="dalej">
<input type="hidden" name="type" value="{$Type}">
</form>
{/if}
<br><br><br><br>
<i>Ma�a informacja - ot� wystarczy klika� w przyciski na dole po lewej stronie �eby zdobywa� punkty. Wystarczy klika� raz dziennie w ka�dy z tych przycisk�w i za ka�dy dostanie si� punkt.</i>