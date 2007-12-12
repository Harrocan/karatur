<center><img src="miecz.jpg"/></center><br />
{if $Buy == ""}
    Kiedy wchodzisz do duzego domu z szyldem ZBROJMISTRZ dostrzegasz kilku kupcow, wojownikow i dwoch elfow
    za lada. Podchodzisz do jednego z nich a ten pyta: <i>Witaj, czy chcesz kupic u nas orez? Jesli tak to
    powiedz ktora z broni wybierasz</i> w mithrilowej szkatule przez szybe widac wszystkie rodzaje broni jakie
    wykuwa sie w tym zakladzie. Asortyment jest przeogromny - od sztyletow po adamantytowe miecze dwureczne.
    Zza firanki za lada slychac tylko pospieszne kucie broni i krasnoludzkie sapanie <i>Za... Duzo... Tych...
    Wojakow... Arg... No UKONCZONE!</i>. Elf patrzac na Ciebie z usmiechem mowi tylko: <i>Co podac?</i> <br><br>
    <table>
    <tr>
    <td width="100"><b><u>Nazwa</td>
    <td width="100"><b><u>Efekt</td>
    <td width="50"><b><u>Szyb</u></b></td>
    <td width="50"><b><u>Wt.</td>
    <td width="50"><b><u>Cena</td>
    <td><b><u>Wymagany poziom</td>
    <td><b><u>Opcje</td>
    </tr>
    {section name=item loop=$Level}
        <tr>
        <td>{$Name[item]}</td>
        <td>+{$Power[item]} Atak</td>
        <td>+{$Speed[item]}%</td>
        <td>{$Durability[item]}</td>
        <td>{$Cost[item]}</td>
        <td>{$Level[item]}</td>
        <td>- <a href="weapons.php?buy={$Itemid[item]}">Kup</a>{if $Crime > "0"}<br><a href="weapons.php?steal={$Itemid[item]}">Kradziez</a>{/if}</td>
        </tr>
    {/section}
    </table>
{/if}

{if $Buy > 0}
    Zaplaciles <b>{$Cost}</b> sztuk zlota, ale teraz masz nowy <b>{$Name} z +{$Power}</b> do Obrazen.
{/if}        
