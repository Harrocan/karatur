{if $Step == "" && $Step2 == "" && $Step3 == "" && $Give == ""}
    Witaj w magazynie klanu. Tutaj sa skladowane mikstury nalezace do klanu. Kazdy czlonek klanu moze ofiarowac klanowi jakas miksture ale 
    tylko przywodca lub osoba upowazniona przez niego moze darowac dana miksture czlonkom swojego klanu. Co chcesz zrobic?<br>
    <ul>
    <li><a href="tribeware.php?step=zobacz&lista=id">Zobaczyc liste mikstur w magazynie klanu</a></li>
    <li><a href="tribeware.php?step=daj">Dac miksture do klanu</a></li></ul>
{/if}

{if $Step == "zobacz"}
    W magazynie klanu jest {$Amount1} mikstur<br>
    <table>
    <tr>
    <td width="100"><a href="tribeware.php?step=zobacz&lista=nazwa"><b><u>Nazwa</u></b></a></td>
    <td width="100"><a href="tribeware.php?step=zobacz&lista=efekt"><b><u>Efekt</u></b></a></td>
    <td width="50"><b><u>Ilosc</u></b></td>
    <td width="100"><b><u>Opcje</u></b></td>
    </tr>
    {section name=tribeware loop=$Name}
        <tr>
        <td>{$Name[tribeware]}</td>
        <td align=center>{$Efect[tribeware]}</td>
        <td align=center>{$Amount[tribeware]}</td>
        {$Link[tribeware]}
    {/section}
    </table>
{/if}

{if $Give != ""}
    {if $Step3 == ""}
        <form method="post" action="tribeware.php?daj={$Id}&step3=add">
        <input type="submit" value="Daj"> <input type="text" name="amount" value="{$Amount}" size="5"> sztuk(i)
        <b>{$Name}</b> graczowi ID: <input type="text" name="did" size="5"><br></form>
    {/if}
    {$Message}
{/if}

{if $Step == "daj"}
    Dodaj miksture do magazynu<br><br>
    <table><form method="post" action="tribeware.php?step=daj&step2=add">
    <tr><td>Mikstura: <select name="przedmiot">
    {section name=tribeware1 loop=$Name}
        <option value="{$Itemid[tribeware1]}">(ilosc: {$Amount[tribeware1]}) {$Name[tribeware1]}</option>
    {/section}
    </select> sztuk <input type="text" name="amount" size="5"></td></tr>
    <tr><td colspan="2" align="center"><input type="submit" value="Dodaj"></td></tr>
    </form></table>
    {$Message}
{/if}

<center>
(<a href="tribes.php?view=my">Glowna</a>)
(<a href="tribes.php?view=my&step=donate">Dotuj</a>)
(<a href="tribes.php?view=my&step=members">Czlonkowie</a>)
(<a href="tribearmor.php">Zbrojownia</a>)
(<a href="tribeware.php">Magazyn</a>)
(<a href="tribes.php?view=my&step=skarbiec">Skarbiec</a>)
(<a href="tribes.php?view=my&step=zielnik">Zielnik</a>)
(<a href="tribes.php?view=my&step=quit">Opusc klan</a>)
(<a href="tribes.php?view=my&step=owner">Opcje Przywodcy</a>)
(<a href="tforums.php?view=topics">Forum klanu</a>)
