<center><img src="jubiler.jpg"/></center><br />
{if $Buy == 0}
    Zwiedzajac kraine {$Gamename} natknoles sie na niewielki, obszyty zlotymi zdobieniami, marmurowy budynek. Podszedles do niego a za szklem bylo pelno pierscieni, naszyjnikow i  innych wielce drogocennych rzeczy.
    Kiedy wszedles do budynku twe oczy az zablysly swiatlem odbijajacym sie od zlotych pierscieni i naszyjnikow. Podszedles od lady przy ktorej stal bogaty elf i po chwili powiedziedziales mu
    ze chcesz zobaczyc...</i>
    <ul>
    <li><a href="jubiler.php?dalej=Y">Amulety</a></li>
    <li><a href="jubiler.php?dalej=Q">Pierscienie</a></li>
    <li><a href="jubiler.php?dalej=T"></a></li>
    <li><a href="jubiler.php?dalej=L">Naszyjniki</a></li>
    </ul>
    {if $Next != ''}
        <table>
        <tr>
        <td width="100"><b><u>Nazwa</td>
        <td><b><u>Wt.</td>
        <td width="100"><b><u>Efekt</td>
        <td width="50"><b><u>Cena</td>
        <td><b><u>Wymagany poziom</td>
        <td><b><u>Ograniczenie zrecznosci</td>
        <td><b><u>Opcje</td>
        </tr>
        {section name=number loop=$Name}
            <tr>
            <td>{$Name[number]}</td>
            <td>{$Durability[number]}</td>
            <td>+{$Power[number]} Obrona</td>
            <td>{$Cost[number]}</td>
            <td>{$Level[number]}</td>
            <td>{$Agility[number]} %</td>
            <td>- <a href="jubiler.php?buy={$Id[number]}">Kup</a>{if $Crime > "0"}<br><a href="jubiler.php?steal={$Id[number]}">Kradziez</a>{/if}</td>
            </tr>
        {/section}
        </table>
    {/if}
{/if}

{if $Buy != 0}
    Zaplaciles <b>{$Cost}</b> sztuk zlota, i kupiles za to nowy ekwipunek o nazwie <b>{$Name} z Obrona + {$Power}</b>.
{/if}


