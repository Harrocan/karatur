{if $Empty == "Y"}
    Nie masz jeszcze farmy! Czy chcesz ja kupic? Bedziesz mogl hodowac ziola. Koszt pierwszego poziomu farmy wynosi 50 mithrilu.
    <ul>
    <li><a href="farm.php?answer=yes">Tak</a></li>
    <li><a href="city.php">Nie</a></li>
    </ul>
{/if}

{if $View == "" && $Empty == ""}
    Witaj na swojej swojej farmie.
    <ul>
    <li><a href="farm.php?view=stats">Statystyki</a>
    <li><a href="farm.php?view=shop">Sklep</a>
    <li><a href="farm.php?view=add">Zasiej ziola</a>
    <li><a href="farm.php?view=take">Zbierz ziola</a>
    </ul>
{/if}

{if $View == "stats"}
    Tutaj sa informacje na temat twojej farmy.
    <ul>
    <li>Obszar: {$Amount}</li>
    <li>Uzywane: {$Used}</li>
    <li>Zasiane ziola<br>
    {$Herbs}
    {if $Herbs == ""}
        {section name=herb loop=$Herbname}
            {$Herbname[herb]} ilosc: {$Herbamout[herb]} wiek: {$Herbage[herb]}<br>
        {/section}
    {/if}
    </li></ul>
{/if}

{if $View == "shop"}
    Witaj w sklepie. Tutaj mozesz kupic dodatkowa ziemie dla twojej farmy. Chcesz kupic?
    <ul>
    <li><a href="farm.php?view=shop&buy=land">1 obszar wiecej</a> ({$Cost} sztuk zlota)</li>
    </ul>
{/if}

{if $View == "add"}
    Tutaj mozesz zasiac ziola na swojej farmie. Aby obsiac jeden obszar potrzebujesz 10 ziol danego typu. Ziola mozesz zebrac po 5 
    dniach od zasiania<br>
    <form method="post" action="farm.php?view=add&step=add">
    <input type="submit" value="Zasiej"> <input type="text" name="amount" size="5" value="1"> obszar(ow) ziolem <select name="herb">
    {$Options}
    </select></form>
{/if}

{if $View == "take"}
    {$Chop}
{/if}

{if $View != ""}
    <br><br>... <a href="farm.php">farma</a>.
{/if}

