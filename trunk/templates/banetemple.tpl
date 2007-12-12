
{if $Temple == ""}
    Witaj w swiatyni. Mozesz tutaj modlic sie do {$God} Aby twoja modlitwa zostala wysluchana, musisz posiadac odpowiednia 
    ilosc Punktow Wiary. Punkty zdobywasz sluzac w swiatyni. To czym ciebie obdaruje bog zalezy tylko od niego.<br><br>
    <ul>
    <li><a href="banetemple.php?temp=sluzba">Pracuj dla swiatyni</a></li>
    <li><a href="banetemple.php?temp=modlitwa">Modl sie do {$God}</a></li>
    </ul>
{/if}

{if $Temple == "sluzba"}
    Pracujac dla swiatyni, sprawiasz, {$God} spoglada na ciebie przychylniejszym okiem. Za kazde 0,2 energii zdobywasz 1 Punkt
    Wiary. Czy chcesz sluzyc w swiatyni?<br><br>
    <form method="post" action="banetemple.php?temp=sluzba&dalej=tak">
    Chce pracowac dla swiatyni <input type="text" size="3" value="0" name="rep"> razy. <input type="submit" value="Pracuj">
    </form>
{/if}

{if $Temple == "modlitwa"}
    Postanowiles pomodlic sie do {$God} o dar z nieba. Czy jestes pewien?<br><br>
    <ul>
    <li><a href="banetemple.php?temp=modlitwa&modl=tak">Tak</a></li>
    <li><a href="banetemple.php">Nie</a></li></ul>
{/if}

{$Message}
