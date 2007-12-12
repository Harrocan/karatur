<center><img src="lochy1.jpg"/></center><br />
{if $Action == "" && $Step == ""}
    Dochodzisz na obrzeza miasta, gdzie doslyszales pogloski o potworach zamieszkujacych w okolicznych sciekach.
    Po dojsciu na miejsce odczuwasz powalajacy odor, dobywajacy sie z tego miejsca.
    Slyszysz nieludzki krzyk dobywajacy sie z glebi tunelu. W koncu, mimo paralizujacego cie strachu postanawiasz wejsc
    do tego siedliska zla, by zdobyc chwale, przezyc przygody, odszukac zaginione skarby...
    <a href="scieki.php?action=explore">Wchodzisz</a>
{/if}

{if $Chance == "1"}
    Idziesz przez dluzszy czas rozgladajac sie wkolo lecz nic tu nie ma. Czujesz tylko smrod..
{/if}

{if $Chance == "2"}
    Nic nie znajdujesz, oprocz gnijacych pajeczyn i szczurow, ktore lapiesz na sniadanie.
{/if}

{if $Chance == "3"}
    Znalazles mieszek! Znajduje sie w nim <b>{$Goldgain}</b> sztuk zlota.
{/if}

{if $Chance == "4"}
    Idziesz i idziesz, lecz nic nie znajdujesz. W koncu siadasz, by odpoczac po meczacej wedrowce. Jednak rzadza przygod jest w tobie silniejsza- ruszasz dalej.
{/if}

{if $Chance == "5"}
    Co to jest?
{/if}

{if $Chance == "6"}
    Znalazles mithril! Zdobyles <b>{$Mithgain}</b> sztuk mithrilu.
{/if}

{if $Chance == "7"}
    {if $Max == "Y"}
        Widzisz zrodlo! Idziesz do niego i wypijasz cala wode. Zyskujesz <b>0.1</b> maksymalnej energii! Gratuluje..
    {/if}
    {if $Max == ""}
     	Zobaczyles zrodlo! Podbiegasz i odzyskujesz <b>1</b> punkt energi!
    {/if}
{/if}

{if $Chance == "8"}
    Nie ma tutaj nic wartosciowego.
{/if}

{if $Chance == "9"}
    {if $Maps == "Y"}
        {$Text}
    {/if}
    {if $Maps == ""}
        Wedrowales jakis czas po korytarzach, ale niestety nie znalazles nic ciekawego.
    {/if}
{/if}

{if $Action == "explore" && $Chance <= 10}
    <br><br>... <a href="scieki.php?action=explore">zwiedzaj</a> dalej. (zostalo ci {$Energyleft} punktow energii.)
{/if}

