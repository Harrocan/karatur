{if $View == ""}
    Gdy wchodziles do posredniaka odrazu przykula twoja uwage stara kobieta za zniszczona lada. Urzedniczka odezwala sie do ciebie: Znajdujesz sie w posredniaku, jest tutaj wiele prac przy ktoych mozesz sie wzbogacic kosztem energii. Oto one:<br><br>

    <center>
    <a href="praca.php?view=oczyszczanie">Oczyszczanie miasta</a><br>
    <a href="praca.php?view=dom">Dom publiczny</a><br>
    <a href="praca.php?view=lesniczy">Domek Lesniczego</a><br>
    <a href="praca.php?view=mysliwy">Chatka trapera</a><br>
    <a href="praca.php?view=targ">Targ Niewolnikow</a><br>
    <a href="praca.php?view=studnia">Studnia poza miastem</a><br>
    <a href="praca.php?view=woda">Chatka na wodzie</a><br>
{/if}

{if $View == "oczyszczanie"}
    Pragniesz zarobic nieco sztuk zlota? W porzadku. Za kazdy worek smieci jakie uprzatniesz, dam ci {$G_min} sztuk zlota.<br><br>
    <form method="post" action="praca.php?view=oczyszczanie&action=oczyszczanie">
    <input type="submit" value="Pracuj"> <input type="text" name="amount" value="1" size="5"> razy.</form>
{/if}
{if $Action == "oczyszczanie"}
    Podczas pracy zuzyles <b>{$Amount}</b> punkt(ow) energii, zebrales <b>{$Amount}</b> workow smieci i zarobiles <b>{$Gain}</b> sztuk zlota.
    <br>[<a href="praca.php">Wroc</a>]
{/if}

{if $View == "dom"}
    Pragniesz zarobic nieco sztuk zlota? W porzadku. Za kazdego klienta ktorego "obsluzysz", dam ci od {$G_min} - {$G_max} sztuk zlota.<br><br>
    <form method="post" action="praca.php?view=dom&action=dom">
    <input type="submit" value="Pracuj"> <input type="text" name="amount" value="1" size="5"> razy.</form>
{/if}
{if $Action == "dom"}
    Podczas pracy zuzyles <b>{$Amount}</b> punkt(ow) energii, obsluzylas/es <b>{$Amount}</b> klienta i zarobiles <b>{$Gain}</b> sztuk zlota.
    <br>[<a href="praca.php">Wroc</a>]
{/if}

{if $View == "lesniczy"}
    Pragniesz zarobic nieco sztuk zlota? W porzadku. Za kazde dzrzewko ktore zasadzisz, dam ci od {$G_min} - {$G_max}  sztuk zlota.<br><br>
    <form method="post" action="praca.php?view=lesniczy&action=lesniczy">
    <input type="submit" value="Pracuj"> <input type="text" name="amount" value="1" size="5"> razy.</form>
{/if}
{if $Action == "lesniczy"}
    Podczas pracy zuzyles <b>{$Amount}</b> punkt(ow) energii, zasadziles <b>{$Amount}</b> drzewko/ek i zarobiles <b>{$Gain}</b> sztuk zlota.
    <br>[<a href="praca.php">Wroc</a>]
{/if}

{if $View == "mysliwy"}
    Pragniesz zarobic nieco sztuk zlota? W porzadku. Za kazda lanie ktora ustrzelisz, dam ci od {$G_min} - {$G_max} sztuk zlota.<br><br>
    <form method="post" action="praca.php?view=mysliwy&action=mysliwy">
    <input type="submit" value="Pracuj"> <input type="text" name="amount" value="1" size="5"> razy.</form>
{/if}
{if $Action == "mysliwy"}
    Podczas pracy zuzyles <b>{$Amount}</b> punkt(ow) energii, zestrzeliles <b>{$Amount}</b> lani i zarobiles <b>{$Gain}</b> sztuk zlota.
    <br>[<a href="praca.php">Wroc</a>]
{/if}

{if $View == "targ"}
    Pragniesz zarobic nieco sztuk zlota? W porzadku. Za kazdego zlapanego wyrzutka spoleczenstwa, dam ci od {$G_min} - {$G_max} sztuk zlota.<br><br>
    <form method="post" action="praca.php?view=targ&action=targ">
    <input type="submit" value="Pracuj"> <input type="text" name="amount" value="1" size="5"> razy.</form>
{/if}
{if $Action == "targ"}
    Podczas pracy zuzyles <b>{$Amount}</b> punkt(ow) energii, zlapales <b>{$Amount}</b> "wyrzutkow i zarobiles <b>{$Gain}</b> sztuk zlota.
    <br>[<a href="praca.php">Wroc</a>]
{/if}

{if $View == "woda"}
    Pragniesz zarobic nieco sztuk zlota? W porzadku. Za kazda rybe ktora mi przyniesiesz, dam ci od {$G_min} - {$G_max} sztuk zlota.<br><br>
    <form method="post" action="praca.php?view=studnia&action=studnia">
    <input type="submit" value="Pracuj"> <input type="text" name="amount" value="1" size="5"> razy.</form>
{/if}
{if $Action == "woda"}
    Podczas pracy zuzyles <b>{$Amount}</b> punkt(ow) energii, zlowiles <b>{$Amount}</b> ryb i zarobiles <b>{$Gain}</b> sztuk zlota.
    <br>[<a href="praca.php">Wroc</a>]
{/if}

{if $View == "studnia"}
    Pragniesz zarobic nieco sztuk zlota? W porzadku. Za kazdy dzban z woda ktory przyniesiesz ze studni do miasta, dam ci od {$G_min} - {$G_max} sztuk zlota.<br><br>
    <form method="post" action="praca.php?view=woda&action=woda">
    <input type="submit" value="Pracuj"> <input type="text" name="amount" value="1" size="5"> razy.</form>
{/if}
{if $Action == "studnia"}
    Podczas pracy zuzyles <b>{$Amount}</b> punkt(ow) energii, przyniosles <b>{$Amount}</b> wiader wody i zarobiles <b>{$Gain}</b> sztuk zlota.
    <br>[<a href="praca.php">Wroc</a>]
{/if}
