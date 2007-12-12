{*<center><img src="arena1.jpg"/></center><br />*}
{if $Action == "" && $Battle == ""}
    Idziesz sobie alejka pod gor� i nagle widzisz t�umy magow, wojownikow a nawet obywateli poda��ajacych do pewnego budynku. Gdy zbli�y�es
    si� do niego bli�ej zauwa�y�es, �e jest od wykonany z mocnego kamienia w kolorze jasno szarym w niektorych miejscach poz�acanym. Na gorze
    owego budynku znajduja si� trzy wie�e ka�da z nich jest pokryta innym materia�em. Pierwsza brazem, druga srebrem a trzecia z�otem.
    Przy wejsciu do budynku jest wyryty w skale napis Arena Walk. Wchodzisz do srodka gdzie widzisz t�umy wojownikow sciany sa tu z twardego
    kamienia w cz�sciach poz�acane. Ciekawy wbiegasz do najwieszej z sal gdzie wszystko jest pokryte kamieniem i znajduja si� trzy drzwi. Ju�
    zaciekawiony chcia�es owe drzwi otworzy�, ale w tym momencie z�apa� ci� za d�o� silny wojownik i powiedzia� <i>Witaj, czego tutaj szukasz?
    </i> Ty odpowiadasz:
    <br><br>
    - <a href="battle.php?action=levellist">Poka� mi list� osob na danych poziomach.</a><br>
    - <a href="battle.php?action=showalive">Chc� walczy� z osobami na tym samym poziomie, co ja...</a><br>
    - <a href="battle.php?action=monster">Chc� trenowa� z potworami.</a><br>
{/if}

{if $Action == "showalive"}
    Poka� wszystkich �ywych na poziomie {$Level}...<br><br>
    <table>
    <tr>
    <td width="20"><b><u>ID</td>
    <td width="100"><b><u>Imi�</td>
    <td width="100"><b><u>Ranga</td>
    <td width="20"><b><u>Klan</td>
    <td width="60"><b><u>Opcje</td>
    </tr>
    {section name=player loop=$Enemyid}
        <tr>
        <td>{$Enemyid[player]}</td>
        <td><a href="view.php?view={$Enemyid[player]}">{$Enemyname[player]}</a></td>
        <td>{$Enemyrank[player]}</td>
        <td>{$Enemytribe[player]}</td>
        <td>- <A href="battle.php?battle={$Enemyid[player]}">Atakuj</a></td>
        </tr>
    {/section}
    </table><br>Lub mo�esz zawsze... <a href=battle.php>zawroci�</a>.
{/if}

{if $Action == "levellist"}
    <form method="post" action="battle.php?action=levellist&step=go">
    Poka� �ywych na poziomach od <input type="text" name="slevel" size="5"> do <input type="text" name="elevel" size="5">
    <input type="submit" value="Id&frac14;"></form>
    {if $Step == "go"}
        <table>
        <tr>
        <td width="20"><b><u>ID</td>
        <td width="100"><b><u>Imi�</td>
        <td width="100"><b><u>Ranga</td>
        <td width="20"><b><u>Klan</td>
        <td width="60"><b><u>Opcje</td>
        </tr>
        {*{section name=player loop=$Enemyid}
            <tr>
            <td>{$Enemyid[player]}</td>
            <td><a href="view.php?view={$Enemyid[player]}">{$Enemyname[player]}</a></td>
            <td>{$Enemyrank[player]}</td>
            <td>{$Enemytribe[player]}</td>
            <td>- <A href="battle.php?battle={$Enemyid[player]}">Atakuj</a></td>
            </tr>
        {/section}*}
        {section name=e loop=$Elist}
        		<tr>
        			<td>{$Elist[e].id}</td>
        			<td><a href="view.php?view={$Elist[e].id}">{$Elist[e].user}</a></td>
        			<td>{$Elist[e].rname}</td>
        			<td>{$Elist[e].tribe}</td>
        			<td>- <A href="battle.php?battle={$Elist[e].id}">Atakuj</a></td>
        		</tr>
        {/section}
        </table>
    {/if}
{/if}

{if $Battle > "0"}
{/if}<br>Lub mo�esz zawsze... <a href=battle.php>zawroci�</a>.
        {if $Dalej > 0}
            <form method="post" action="battle.php?action=monster&fight={$Id}">
            <input type="submit" value="Walcz"> jednoczesnie z <input type="text" size="5" name="razy" value="1"> {$Name}(ami)
            <input type="text" size="5" name="times" value="1"> razy</form>
        {/if}
        {*{if $Next > 0}
            <form method="post" action="battle.php?action=monster&fight1={$Id}">
            <input type="submit" value="Walcz"> jednoczesnie z <input type="text" size="5" name="razy" value="1"> {$Name}(ami)
            <input type="hidden" name="write" value="Y">
            </form>
        {/if}*}
{if $Action == "monster"}
    {if !$Fight && !$Fight1}
        Sa tutaj potwory z ktorymi mo�esz walczy�. Ale uwa�aj... nie chcesz przecie� atakowa� kogos znacznie silniejszego od siebie, prawda?
        <br><br>
        <table>
        <tr>
        <td width="100"><b><u>Nazwa</td>
        <td width="50"><b><u>Poziom</td>
        <td width="50"><b><u>Zdrowie</td>
        {*<td><b><u>Turowa</u></b></td>*}
        <td><b><u>Szybka</u></b></td>
        </tr>
        {section name=monster loop=$Enemyid}
            <tr>
            <td>{$Enemyname[monster]}</td>
            <td>{$Enemylevel[monster]}</td>
            <td>{$Enemyhp[monster]}</td>
            {*<td><a href="battle.php?action=monster&next={$Enemyid[monster]}">Walka</a></td>*}
            <td><a href="battle.php?action=monster&dalej={$Enemyid[monster]}">Walka</a></td>
            </tr>
        {/section}
        </table><br>Lub mo�esz zawsze... <a href=battle.php>zawroci�</a>.
        {if $Dalej > 0}
            <form method="post" action="battle.php?action=monster&fight={$Id}">
            <input type="submit" value="Walcz"> jednoczesnie z <input type="text" size="5" name="razy" value="1"> {$Name}(ami)
            <input type="text" size="5" name="times" value="1"> razy</form>
        {/if}
        {*{if $Next > 0}
            <form method="post" action="battle.php?action=monster&fight1={$Id}">
            <input type="submit" value="Walcz"> jednoczesnie z <input type="text" size="5" name="razy" value="1"> {$Name}(ami)
            <input type="hidden" name="write" value="Y">
            </form>
        {/if}*}
    {/if}
{/if}
