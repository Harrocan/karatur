{if $Action == ""}
    Pragniesz zarobic nieco sztuk zlota? W porzadku. Za kazdy worek smieci jakie uprzatniesz, dam ci <b>{$Gold}</b> sztuk zlota.<br><br>
    <form method="post" action="landfill.php?action=work">
    <input type="submit" value="Pracuj"> <input type="text" name="amount" value="1" size="5"> razy.</form>
{/if}
{if $Action == "work"}
    Podczas pracy zuzyles <b>{$Amount}</b> punkt(ow) energii i zarobiles <b>{$Gain}</b> sztuk zlota.
    <br>[<a href="landfill.php">Wroc</a>]
{/if}

