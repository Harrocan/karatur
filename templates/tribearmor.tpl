{if $Step == "" && $Step2 == "" && $Give == "" && $Step3 == ""}
    Witaj w zbrojowni klanu. Tutaj sa skladowane przedmioty nalezace do klanu. Kazdy czlonek klanu moze ofiarowac klanowi jakis przedmiot ale
    tylko przywodca lub osoba upowazniona przez niego moze darowac dany przedmiot czlonkom swojego klanu. Co chcesz zrobic?<br>
    <ul>
    <li><a href="tribearmor.php?step=zobacz&lista=id&type=W">Zobaczyc liste broni w zbrojowni klanu</a></li>
    <li><a href="tribearmor.php?step=zobacz&lista=id&type=A">Zobaczyc liste zbroj w zbrojowni klanu</a></li>
    <li><a href="tribearmor.php?step=zobacz&lista=id&type=H">Zobaczyc liste helmow w zbrojowni klanu</a></li>
    <li><a href="tribearmor.php?step=zobacz&lista=id&type=N">Zobaczyc liste nagolennikow w zbrojowni klanu</a></li>
    <li><a href="tribearmor.php?step=zobacz&lista=id&type=D">Zobaczyc liste tarcz w zbrojowni klanu</a></li>
    <li><a href="tribearmor.php?step=zobacz&lista=id&type=B">Zobaczyc liste lukow w zbrojowni klanu</a></li>
    <li><a href="tribearmor.php?step=zobacz&lista=id&type=S">Zobaczyc liste rozdzek w zbrojowni klanu</a></li>
    <li><a href="tribearmor.php?step=zobacz&lista=id&type=Z">Zobaczyc liste szat w zbrojowni klanu</a></li>
    <li><a href="tribearmor.php?step=zobacz&lista=id&type=R">Zobaczyc liste strzal w zbrojowni klanu</a></li>
    <li><a href="tribearmor.php?step=zobacz&lista=id&type=G">Zobaczyc liste grotow w zbrojowni klanu</a></li>
    <li><a href="tribearmor.php?step=daj">Dac przedmiot do klanu</a></li>
    </ul>
{/if}

{if $Step == "zobacz"}
    W zbrojowni klanu jest {$Amount1} {$Name1}<br>
    <table>
    <tr>
    <td width="100"><a href="tribearmor.php?step=zobacz&lista=name&limit=0&type={$Type}"><b><u>Nazwa</u></b></a></td>
    <td width="100"><a href="tribearmor.php?step=zobacz&lista=power&limit=0&type={$Type}"><b><u>Sila</u></b></a></td>
    <td width="100"><a href="tribearmor.php?step=zobacz&lista=wt&limit=0&type={$Type}"><b><u>Wytrzymalosc</u></b></a></td>
    <td width="100"><a href="tribearmor.php?step=zobacz&lista=zr&limit=0&type={$Type}"><b><u>Premia do zrecznosci</u></b></a></td>
    <td width="100"><a href="tribearmor.php?step=zobacz&lista=szyb&limit=0&type={$Type}"><b><u>Premia do szybkosci</u></b></a></td>
    <td width="50"><b><u>Ilosc</u></b></td>
    <td width="100"><b><u>Opcje</u></b></td>
    </tr>
    {section name=tribearmor loop=$Name}
        <tr>
        <td>{$Name[tribearmor]}</td>
        <td align=center>{$Power[tribearmor]}</td>
        <td align=center>{$Durability[tribearmor]}/{$Maxdurability[tribearmor]}</td>
        <td align=center>{$Agility[tribearmor]}</td>
        <td align=center>{$Speed[tribearmor]}</td>
        <td align=center>{$Amount[tribearmor]}</td>
        {$Action[tribearmor]}
    {/section}
    </table>
{/if}

{if $Give != ""}
    {if $Step3 == ""}
        <form method="post" action="tribearmor.php?daj={$Id}&step3=add">
        <input type="submit" value="Daj">
        <input type="text" name="amount" value="{$Amount}" size=5> sztuk(i) <b>{$Name}</b> graczowi ID:
        <input type="text" name="did" size="5"><br>
        </form>
    {/if}
{/if}

{if $Step == "daj"}
    Dodaj przedmiot do zbrojowni<br><br>
    <table><form method="post" action="tribearmor.php?step=daj&step2=add">
    Przedmiot: <select name="przedmiot">
    {section name=tribearmor1 loop=$Name}
        <option value="{$Itemid[tribearmor1]}">(ilosc: {$Amount[tribearmor1]}) {$Name[tribearmor1]}</option>
    {/section}
    </select> sztuk <input type="text" name="amount" size="5"></td></tr>
    <tr><td colspan="2" align="center"><input type="submit" value="Dodaj"></td></tr>
    </form></table>
{/if}

{$Message}

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
