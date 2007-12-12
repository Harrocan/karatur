<center><img src="kopalnia.jpg"/></center><br />
{if $Mid==0}
	Nie posiadasz tutaj jeszcze ¿adnej kopalni !<br>
	<ul>
	{if $MineData.miedz }<li><a href="mines_new.php?kup=miedz">Kopalnia miedzi - 25 sztuk mithrilu</a></li>{/if}
	{if $MineData.zelazo }<li><a href="mines_new.php?kup=zelazo">Kopalnia ¿elaza - 50 sztuk mithrilu</a></li>{/if}
	{if $MineData.wegiel }<li><a href="mines_new.php?kup=wegiel">Kopalnia wêgla - 75 sztuk mithrilu</a></li>{/if}
	</ul>
{else}
    Witaj w swojej kopalni.
    <ul>
    <li><a href="mines_new.php?view=stats">Statystyki</a>
    <li><a href="mines_new.php?view=shop">Sklep</a>
    <li><a href="mines_new.php?view=mine">Kopalnia</a>
    </ul>
	{if $View == "stats"}
		Tutaj sa informacje na temat twojej kopalni.
		<ul>
		{if $MineData.miedz }<li>Obszar kopalni miedzi: {$Copper}</li>{/if}
		{if $MineData.zelazo }<li>Obszar kopalni zelaza: {$Iron}</li>{/if}
		{if $MineData.wegiel }<li>Obszar kopalni wegla: {$Coal}</li>{/if}
		<li>Zostalo Operacji: {$Ops}</li>
		</ul>
	{/if}
	
	{if $View == "shop"}
		Witaj w sklepie. Tutaj mozesz kupic dodatkowa ziemie dla twojej kopalni. Czy chcesz kupic?
		<form method="post" action="mines_new.php?view=shop&action=buy">
		<ul>
		{section name=al loop=$AddLink}
		{assign value=$AddLink[al] var="Link"}
		{$Link}
		{sectionelse}
		<i>nie mo¿esz rozbudowaæ obecnie ¿adnych obszarów - wykup najpierw pierwszy obszar poni¿ej</i>
		{/section}
		</ul>
		<input type="submit" value="Dokupujê !">
		</form><br>
		<ul>
		{section name=bl loop=$BuyLink}
		{assign value=$BuyLink[bl] var="Link"}
		{$Link}
		{sectionelse}
		<i>wykupi³e¶ wszystkie dostêpne typy obszarów</i>
		{/section}
		</ul>
		<br>
		{if $Step == "buy"}
			Kupiles dodatkowy obszar dla twojej kopalni {$Name}. (<a href="mines.php?view=shop">Odswiez</a>)
		{/if}
	{/if}
	{if $View == "mine"}
		Zbierasz swoj ekwipunek i wyruszasz do kopalni...<br>
		<form method="post" action="mines_new.php?view=mine&step=mine">Idz wydobywac zloza <select name="zloze">
		{section name=mines loop=$Option}
			{$Option[mines]}
		{/section}
		</select> <input type="text" name="razy" value="{$Ops}"> razy. <input type="submit" value="Wydobywaj"></form>
		{if $Step == "mine"}
			Wykopales <b>{$Gain} bryl {$Name}</b>.
		{/if}
	{/if}
{/if}