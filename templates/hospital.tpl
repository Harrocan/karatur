
<p align="center"><img src="bb.jpg">
<p>{if $Action == ""}
    {if $Health > "0"}
        Czy mozesz mnie <a href="hospital.php?action=heal">uzdrowic</a>?
        <br>Jasne, bedzie cie to kosztowalo <b>{$Need}</b> sztuk zlota.
    {/if}
    {if $Health <= "0"}
        Czy chcesz aby twa dusza wrocila do ciala?
        <br>Bedzie kosztowalo to <b>{$Need}</b> sztuk zlota.<br>
        <a href="hospital.php?action=ressurect">Tak</a>
    {/if}
{/if}</p>
