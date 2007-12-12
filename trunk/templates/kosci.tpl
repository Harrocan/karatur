Grajac w kosci mo¿esz zarobiæ dwarazy tyle ile postawi³es ale szansa na wygrana jest jedna na szesæ.Przegrywajac tracisz ca³om postawiona kwotê.Czy chcesz zagraæ w kosci?
<ul>
<li><a href="kosci.php?view=gram">Tak chcê.</a></li>
<li><a href="city.php">Cholibka!Niewiem co zrobiæ wracam do miasta...</a></li>

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


