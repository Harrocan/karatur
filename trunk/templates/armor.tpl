<center><img src="platnerz.jpg"/></center><br />
{if $Buy == 0}
    Stoisz przed malym sklepem z bogato ozdobionym szyldem PLATNERZ. Kiedy wchodzisz do srodka widzisz
    kilka stojakow z zelaznymi i stalowymi zbrojami i kolczugami. Za lada z narzedziami platnerskimi
    stoi stary aczkolwiek tegi i silny krasnolud. <i>Witaj. W czym stary Brodur moze ci pomoc?
    Mam wszystko co tu widzisz chyba ze szukasz czegos drozszego...</i> Mowiac to odslonil mala firanke na
    zaplecze gdzie na manekinach powieszone byly wspaniale mithrilowe i meteorytowe, adamantowe a nawet
    krysztalowe pelne zbroje. <i>Wiec? Bierzesz cos?</i>
    <ul>
    <li><a href="armor.php?dalej=A">Zbroje</a></li>
    <li><a href="armor.php?dalej=H">Helmy</a></li>
    <li><a href="armor.php?dalej=N">Nagolenniki</a></li>
    <li><a href="armor.php?dalej=D">Tarcze</a></li>
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
            <td>- <a href="armor.php?buy={$Id[number]}">Kup</a>{if $Crime > "0"}<br><a href="armor.php?steal={$Id[number]}">Kradziez</a>{/if}</td>
            </tr>
        {/section}
        </table>
    {/if}
{/if}

{if $Buy != 0}
    Zaplaciles <b>{$Cost}</b> sztuk zlota, i kupiles za to nowa <b>{$Name} z Obrona + {$Power}</b>.
{/if}


