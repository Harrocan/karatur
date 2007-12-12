{if $Action == "" && $Health > "0"}
    Witaj w kopaniach w okolicy {$Location}, czy chcesz wyruszyc na poszukiwanie mineralow?<br><br>
    <a href="kopalnia.php?akcja=kop">Tak</a><br>
    <a href="{$File}">Nie</a><br>
{/if}

{if $Action =="kop"}
    {if $Roll < "5"}
        Uderzales przez jakis czas kilofem w skale, ale nic nie znalazles.
    {/if}
    {if $Roll == "5"}
        W pewnym momencie zauwazyles w scianie kilka niewielkich krysztalkow koloru czerwonego. Delikatnie oblupujac je ze sciany 
        zdobyles {$Amount} krysztalow ktore moga posluzyc do wykonania przedmiotow.
    {/if}
    {if $Roll == "6"}
        Przez pewien czas pracowales w kopalni, gdy nagle na scianie twoim oczom ukazala sie mala niebieska zylka mineralu. Zaczales intensywniej 
        pracowac i udalo ci sie wydobys {$Amount} bryl adamantium.
    {/if}
    {if $Roll == "7"}
        Pracujac w kopalni zauwazyles duza zyle adamantium. Odlupujac skaly zyskales {$Amount} bryl adamantium.
    {/if}
    {if $Roll == "8"}
        Znalazles zyle mithrilu! Udalo ci sie wydobyc {$Amount} sztuk mithrilu.
    {/if}
    {if $Roll == "9"}
        Pracujac przez jakis czas w kopalni, udalo ci sie wydobyc kilka diamentow, wartych {$Amount} sztuk zlota.
    {/if}
    {if $Roll == "10"}
        {if $Health <= "0"}
            Nagle poczules, jak cale wyrobisko powoli zaczyna sie rozpadac. Najszybciej jak potrafisz probowales biec w kierunku wyjscia. Niestety,
            tym razem zywiol okazal sie szybszy od ciebie. Potezna lawina kamieni spadla na ciebie, zabijajac na miejscu.
        {/if}
        {if $Health > "0"}
            Nagle poczules, jak cale wyrobisko powoli zaczyna sie rozpadac. Najszybciej jak potrafisz probowales biec w kierunku wyjscia. W ostatnim 
            momencie udalo ci sie wybiec z zagrozonego wyrobiska, poczules jedynie na plecach podmuch walacych sie ton skal.
        {/if}
    {/if}
    {if $Health > "0"}
     	<br>Czy chcesz kopac ponownie?<br><br>
	<a href="kopalnia.php?akcja=kop">Tak</a><br>
	<a href="{$File}">Nie</a>
    {/if}
{/if}

