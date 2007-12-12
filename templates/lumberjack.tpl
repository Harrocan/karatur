{if $Action == "" && $Health > "0"}
    Czy chcesz wyruszyc na poszukiwanie drewna?<br><br>
    <a href="lumberjack.php?akcja=chop">Tak</a><br>
    <a href="city.php">Nie</a><br>
{/if}
{if $Action == "chop"}
    {if $Roll < "5"}
        Wedrowales jakis czas po lesie ale nie znalazles odpowiedniego drzewa.
    {/if}
    {if $Roll == "5"}
        W pewnym momencie zauwazyles niewielkie drzewo odpowiadajace twoim wymaganiom. Wyciagnales siekere i zabrales sie do roboty.
        Zdobyles w ten sposob {$Amount} drewna.
    {/if}
    {if $Roll == "6"}
        Wedrujac po lesie znalazles calkiem solidne drzewo, ktore moze dac ci nieco drewna. Zyskales {$Amount} drewna.
    {/if}
    {if $Roll == "7"}
        Ogladajac pewne drzewo zajrzales w niewielka jame w jego korzeniach. Odgarniajac na boki liscie zauwazyles niewielki mieszek a w nim
        {$Amount} sztuk zlota!
    {/if}
    {if $Roll == "8"}
        {if $Lost == "1"}
            Znalazles odpowiednie drzewo i od razu wziales sie do pracy. Kiedy wydawalo sie ze wszystko idzie zgodnie z planem, nagle drzewo zaczelo
            walic sie w twoim kierunku. Probowales odskoczyc na bok, ale niestety nie byles zbyt szybki. Drzewo przygniotlo ciebie zadajac
            {$Amount} obrazen.
        {/if}
        {if $Lost == ""}
            Znalazles odpowiednie drzewo i od razu wziales sie do pracy. Zadowolony, iz zbliza sie ona do konca, zapomniales o srodkach ostroznosci,
            gdy nagle drzewo zaczelo walic sie w twoim kierunku. Tym razem jednak miales szczescie i w ostatnim momencie udalo ci sie uskoczyc,
            poczules jedynie na plecach podmuch upadajacego drzewa.
        {/if}
    {/if}
    {if $Health > "0"}
        <br>Czy chcesz wyruszyc na wyrab lasu ponownie?<br><br>
        <a href="lumberjack.php?akcja=chop">Tak</a><br>
        <a href="beregost.php">Nie</a>
    {/if}
{/if}

