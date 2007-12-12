<center><img src="kopalnia.jpg"/></center><br />
{if $Mines == "0"}
    Nie masz jakiejkolwiek kopalni! Czy chcesz kupic kopalnie? Koszt w sztukach mithrilu zalezy od rodzaju kopalni.
    <ul>
    <li><a href="mines.php?kup=miedz">Kopalnia miedzi - 25 sztuk mithrilu</a></li>
    <li><a href="mines.php?kup=zelaz">Kopalna zelaza - 50 sztuk mithrilu</a></li>
    <li><a href="mines.php?kup=wegie">Kolapnia wegla - 75 sztuk mithrilu</a></li>
    </ul>
{/if}

{if $View == "" && $Buy == "" && $Mines == "1"}
    Witaj w swojej kopalni.
    <ul>
    <li><a href="mines.php?view=stats">Statystyki</a>
    <li><a href="mines.php?view=shop">Sklep</a>
    <li><a href="mines.php?view=market">Rynek</a>
    <li><a href="mines.php?view=mine">Kopalnia</a>
    </ul>
{/if}

{if $View == "stats"}
    Tutaj sa informacje na temat twojej kopalni.
    <ul>
    <li>Obszar kopalni miedzi: {$Mcopper}</li>
    <li>Obszar kopalni zelaza: {$Miron}</li>
    <li>Obszar kopalni wegla: {$Mcoal}</li>
    <li>Zostalo Operacji: {$Ops}</li>
    <li>Wegiel: {$Coal}</li>
    <li>Zelazo: {$Iron}</li>
    <li>Miedz: {$Copper}</li>
    </ul>
{/if}

{if $View == "shop"}
    Witaj w sklepie. Tutaj mozesz kupic dodatkowa ziemie dla twojej kopalni. Czy chcesz kupic?
    <ul>
    {$Mcopper}
    {$Miron}
    {$Mcoal}
    </ul>
    {if $Step == "buy"}
        Kupiles dodatkowy obszar dla twojej kopalni {$Name}. (<a href="mines.php?view=shop">Odswiez</a>)
    {/if}
{/if}

{if $View == "market"}
    {if $Step == ""}
        Mozesz tutaj sprzedawac mineraly z twojej kopalni.
        <form method="post" action="mines.php?view=market&step=sell">
        <table>
        <tr><td>Sprzedaj <input type="text" name="wegiel" size="5" value="{$Coal}"> bryl wegla za 7 sztuk zlota kazda.</td></tr>
        <tr><td>Sprzedaj <input type="text" name="zelazo" size="5" value="{$Iron}"> bryl zelaza za 3 sztuk zlota kazda.</td></tr>
        <tr><td>Sprzedaj <input type="text" name="copper" size="5" value="{$Copper}"> bryl miedzi za 2 sztuk zlota kazda.</td></tr>
        <tr><td align="center"><input type="submit" value="Sprzedaj"></td></tr>
        </form></table>
    {/if}
    {if $Step != ""}
       	Sprzedales <b>{$Coal} bryl wegla</b> za <b>{$Gcoal}</b> sztuk zlota.<br>
	Sprzedales <b>{$Iron} bryl zelaza</b> za <b>{$Giron}</b> sztuk zlota.<br>
	Sprzedales <b>{$Copper} bryl miedzi</b> za <b>{$Gcopper}</b> sztuk zlota.<br>
	Ogolnie, zarobiles <b>{$All}</b> sztuk zlota.
    {/if}
{/if}

{if $View == "mine"}
    Zbierasz swoj ekwipunek i wyruszasz do kopalni...<br>
    <form method="post" action="mines.php?view=mine&step=mine">Idz wydobywac zloza <select name="zloze">
    {section name=mines loop=$Option}
        {$Option[mines]}
    {/section}
    </select> <input type="text" name="razy"> razy. <input type="submit" value="Wydobywaj"></form>
    {if $Step == "mine"}
        Wykopales <b>{$Gain} bryl {$Name}</b>.
    {/if}
{/if}

{if $View != ""}
    <br><br>... <a href=mines.php>kopalnia</a>.
{/if}

