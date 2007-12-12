Witaj !<br>
Tutaj mo¿esz wymieniæ swoje punkty jakie uzbiera³e¶ polecaj±c nasz± krainê w zamorskich miejscowo¶ciach<br>
<br>
Posiadasz {$Total} punktów, z czego wykorzysta³e¶ {$Used}. Pozosta³o Ci <b>{$Left}</b> punktów<br>
Czego sobie ¿yczysz ?
<ul>
	<li><a href="?type=a">AP</a> (1AP = 70 punktów)
	<li><a href="?type=e">Maksymalnej energii</a> (0.01 Max Energi = 20 punktów)
	<li><a href="?type=z">Z³ota</a> (1 z³ota = 0.5 punktu)
</ul>
{if $Type!=''}
<form method="post" action="?action=go">
Podaj ile {$What} chcesz zyskaæ : <input type="text" name="amount" style="width:30px"> <input type="submit" value="dalej">
<input type="hidden" name="type" value="{$Type}">
</form>
{/if}
<br><br><br><br>
<i>Ma³a informacja - otó¿ wystarczy klikaæ w przyciski na dole po lewej stronie ¿eby zdobywaæ punkty. Wystarczy klikaæ raz dziennie w ka¿dy z tych przycisków i za ka¿dy dostanie siê punkt.</i>