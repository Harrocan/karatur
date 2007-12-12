<center><img src="wieza1.jpg"/></center><br />
{if $Buy == ""}
    Widzisz przed soba ogromna wierze stojaca na samym srodku miasta. Wchodzac wyczuwasz w niej prawdziwa
    potege jej mistycznej magii. Sciany owijaja purpurowe migoczace blaski. Od tego pieknego widoku odrywa
    cie melodyjny glos <i>Witaj, wiem czego chcesz, chodz za mna.</i>. Idac za elfim magiem dostrzegasz wiele
    innych postaci w pieknych jedwabnych szatach praktykujacych swoja magie. Dochodzisz do ogromnej
    biblioteki. <i>Ktore zaklecie cie interesuje? Jesli masz pieniadze moge wprowadzic cie w wyzsze arkana
    naszej magii, lecz te sa dostepne tylko dla magow o wielkich umiejetnosciach. Chodz, wybierz droge magii
    ktora chcesz podazac.</i> Czarow obronnych czy bojowych moga uzywac tylko magowie.<br><br>
    <ul>
    {*<li><a href="wieza.php?dalej=S">Kup rozdzki</a></li>
    <li><a href="wieza.php?dalej=Z">Kup szaty</a></li>*}
    <li><a href="wieza.php?dalej=C">Kup czary</a></li>
    </ul>
    {if $Next != ""}
        <table>
        {if $Next == "C"}
            <tr>
            <td width="100"><b><u>Nazwa</u></b></td>
            <td width="100"><b><u>Obrazenia</u></b></td>
            <td width="50"><b><u>Cena</td>
            <td><b><u>Wymagany poziom</td>
            <td><b><u>Opcje</td>
            </tr>
            {section name=tower loop=$Name}
                <tr>
                <td>{$Name[tower]}</td>
                {$Efect[tower]}
                <td>{$Cost[tower]}</td>
                <td>{$Itemlevel[tower]}</td>
                <td>- <A href="wieza.php?buy={$Itemid[tower]}&type=S">Kup</a></td>
                </tr>
            {/section}
        {/if}
        {if $Next != "C"}
            <tr>
            <td width="100"><b><u>Nazwa</u></b></td>
            <td width="50"><b><u>Sila</u></b></td>
            <td width="50"><b><u>Cena</u></b></td>
            <td width="50"><b><u>Wymagany poziom</u></b></td>
            <td><b><u>Opcje</u></b></td>
            </tr>
            {section name=tower1 loop=$Name}
                <tr>
                <td>{$Name[tower1]}</td>
                <td>{$Power[tower1]}</td>
                <td>{$Cost[tower1]}</td>
                <td>{$Itemlevel[tower1]}</td>
                <td>- <A href="wieza.php?buy={$Itemid[tower1]}&type=I">Kup</a></td>
                </tr>
            {/section}
        {/if}
        </table>
    {/if}
{/if}

{if $Buy != ""}
    {$Message}
{/if}
