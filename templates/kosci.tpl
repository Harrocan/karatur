Grajac w kosci mo�esz zarobi� dwarazy tyle ile postawi�es ale szansa na wygrana jest jedna na szes�.Przegrywajac tracisz ca�om postawiona kwot�.Czy chcesz zagra� w kosci?
<ul>
<li><a href="kosci.php?view=gram">Tak chc�.</a></li>
<li><a href="city.php">Cholibka!Niewiem co zrobi� wracam do miasta...</a></li>

</ul>


{if $View == "gram"}
  <center>  Gramy wybieraj:<br>
    <form method="post" action="kosci.php?view=gram&step=dalej">
    <table>Wybieram:<br>
<select name="karta">
    <option value="1">Wypadnie 1</option>
    <option value="2">Wypadnie 2</option>
    <option value="3">Wypadnie 3</option>
    <option value="4">Wypadnie 4</option>
    <option value="5">Wypadnie 5</option>
    <option value="6">Wypadnie 6</option></select><br>I stawiam: 
    <input type="text" name="ile"><br>
    <tr><td colspan=2 align=center><input type="submit" value="Gram!"></td></tr></center>
    </form>
    </table>
{/if}


