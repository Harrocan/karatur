{if $Tow == ""}
    Tutaj mozesz wybrac swego zwierzecego towarzysza bed¹cego z tob¹ od dziecinstwa. Wybierz swego towarzysza w zaleznoœci jak bardzo upodabniasz sie do niego (ich opis znajdziesz po kliknieciu w link). Zastanow sie
    dobrze, poniewaz twoj towarzysz bedzie zyl z toba az do samego konca.<br><br>
    - <a href="tow.php?tow=sokol">Sokol</a><br>
    - <a href="tow.php?tow=lasica">Lasica</a><br>
    - <a href="tow.php?tow=szczur">Szczur</a><br>
    - <a href="tow.php?tow=pies">Pies</a><br>
    - <a href="tow.php?tow=kot">Kot</a><br>
    - <a href="tow.php?tow=pseldosmok">Pseldosmok</a><br>
    - <a href="tow.php?tow=waz">Waz</a><br>
    
{/if}

{if $Tow == "sokol"}
    <br>
    Wybierajac za swego zwierzecego towarzysza sokola upodabniasz sie do niego za co zyskujesz:
    <ul>
    <li>+5 do szybkosci</li>
    </ul>
    <form method="post" action="tow.php?tow=sokol&step=wybierz">
    <input type="submit" value="Wybierz"><br>
    (<a href="tow.php">Wroc</a>)
{/if}

{if $Tow == "lasica"}
    <br>
    Wybierajac za swego zwierzecego towarzysza lasice upodabniasz sie do niego za co zyskujesz:
    <ul>
    <li>+5 do zrecznosci</li>
    </ul>
    <form method="post" action="tow.php?tow=lasica&step=wybierz">
    <input type="submit" value="Wybierz"><br>
    (<a href="tow.php">Wroc</a>)
{/if}

{if $Tow == "szczur"}
    <br>
    Wybierajac za swego zwierzecego towarzysza szczura upodabniasz sie do niego za co zyskujesz:
    <ul>
    <li>+5 wytrzymalosc</li>
    </ul>
    <form method="post" action="tow.php?tow=szczur&step=wybierz">
    <input type="submit" value="Wybierz"><br>
    (<a href="tow.php">Wroc</a>)
{/if}

{if $Tow == "pies"}
    <br>
    Wybierajac za swego zwierzecego towarzysza psa upodabniasz sie do niego za co zyskujesz:
    <ul>
    <li>+5 sily</li>
    </ul>
    <form method="post" action="tow.php?tow=pies&step=wybierz">
    <input type="submit" value="Wybierz"><br>
    (<a href="tow.php">Wroc</a>)
{/if}

{if $Tow == "kot"}
    <br>
    Wybierajac za swego zwierzecego towarzysza kota upodabniasz sie do niego za co zyskujesz:
    <ul>
    <li>+5 inteligencji</li>
    </ul>
    <form method="post" action="tow.php?tow=kot&step=wybierz">
    <input type="submit" value="Wybierz"><br>
    (<a href="tow.php">Wroc</a>)
{/if}

{if $Tow == "pseldosmok"}
    <br>
    Wybierajac za swego zwierzecego towarzysza pseldosmoka upodabniasz sie do niego za co zyskujesz:
    <ul>
    <li>+5 sily woli</li>
    </ul>
    <form method="post" action="tow.php?tow=pseldosmok&step=wybierz">
    <input type="submit" value="Wybierz"><br>
    (<a href="tow.php">Wroc</a>)
{/if}

{if $Tow == "waz"}
    <br>
    Wybierajac za swego zwierzecego towarzysza weza upodabniasz sie do niego za co zyskujesz:
    <ul>
    <li>+1 szybkosc</li>
    <li>+1 zrecznosc</li>
    <li>+1 sila</li>
    <li>+1 wytrzymalosc</li>
    <li>+1 inteligencja</li>
    <li>+1 sila woli</li>
    </ul>
    <form method="post" action="tow.php?tow=waz&step=wybierz">
    <input type="submit" value="Wybierz"><br>
    (<a href="tow.php">Wroc</a>)
{/if}


