<center><img src="lochy1.jpg"/></center><br />
{if $Action == "" && $Step == ""}
    Idziesz sobie stara droga gdzie po bokach stoja stare kamieniczki cale z kamienia juz prawie zniszczonego. Nagle w dali zauwazasz stary,
    potezny labirynt jest on wykonany z marmuru a jego mury licza okolo piec metrow wysokosci. Wejscie jest zablokowane kamieniami, chociaz
    nikt tam nie wchodzil od setek lat! Nagle podchodzi do ciebie stary medrzec i mowi <i>Patrzysz na stary labirynt mlodziencze. Nikt tam
    nie wchodzil od wielu lat. Wielu meznych wojownikow wchodzilo tam zabic potwora. W koncu go zgladzili, lecz gdy chcieli wychodzic zostali
    zasypani glazami. Szczury na pewno poroznosily ich skarby, bedziesz mogl znalezc tam interesujace rzeczy a teraz zegnaj</i>. Podchodzisz
    do wejscia i robisz sobie przejscie. Pod gruzami lezy wielu martwych rycerzy.<br>
    Czy mimo tego chcesz tam wejsc? <a href="grid.php?action=explore">Tak.</a>
{/if}

{if $Chance == "1"}
    Idziesz przez dluzszy czas rozgladajac sie wkolo lecz nic tu nie ma.
{/if}

{if $Chance == "2"}
    Nic nie znajdujesz.
{/if}

{if $Chance == "3"}
    Znalazles mieszek! Znajduje sie w nim <b>{$Goldgain}</b> sztuk zlota.
{/if}

{if $Chance == "4"}
    Idziesz i idziesz, lecz nic nie znajdujesz.
{/if}

{if $Chance == "5"}
    Co to jest?
{/if}

{if $Chance == "6"}
    Znalazles mithril! Zdobyles <b>{$Mithgain}</b> sztuk mithrilu.
{/if}

{if $Chance == "7"}
    {if $Max == "Y"}
        Widzisz zrodlo! Idziesz do niego i wypijasz cala wode. Zyskujesz <b>.1</b> maksymalnej energii!
    {/if}
    {if $Max == ""}
     	Zobaczyles zrodlo! Podbiegasz i odzyskujesz <b>1</b> punkt energi!
    {/if}
{/if}

{if $Chance == "8"}
    Nie ma tutaj nic wartosciowego
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
    <br><br>... <a href="grid.php?action=explore">zwiedzaj</a> dalej. (zostalo ci {$Energyleft} punktow energii.)
{/if}


