Pewnego dnia, przechadzaj&#261;c si&#281; po ulicach Helgrindu z zau&#322;ka wyskoczy&#322; pewien hobbit. By&#322; bardzo bogato ubrany, a na obywduch r&#281;kach mia&#322; mnóstwo z&#322;otych pier&#347;cieni... Zaraz po chwili zagada&#322;: <br><i>-Witaj, jestem Slytheus... Zajmuj&#281; si&#281; hazardem. Od ma&#322;ego by&#322;em w tym dobry! Szanse na trafienie s&#261; 1 do 4... Musisz postawi&#263; jak&#261;&#347; sum&#281;. Jak wygrasz dostajesz 1/4 dodatkowo do sumy postawionej, a jak przegrasz to tracisz po&#322;ow&#281; sumki postawionej. Chcesz zagra&#263;?</i>
<ul>
<li><a href="karty.php?view=gram"><i>-Chetnie! - odpowiadasz jak najpr&#281;dzej.</a></i></li>
<li><a href="stats.php"><i>-Nie dziêki! - odwracasz si&#281; na palcach i szybkim krokiem udajesz si&#281; tam z kad wrci³es.</i></a></li>

</ul>


{if $View == "gram"}
  <center>  Gramy dziesi&#261;tkami. Wybieraj:<br><img alt="" src="images/karty/Karo10.gif">    <img alt="" src="images/karty/kier10.jpg"><br>
<img alt="" src="images/karty/Pik10.gif">    <img alt="" src="images/karty/Trefl10.gif"><BR>
    <form method="post" action="karty.php?view=gram&step=dalej">
    <table>Wybieram:<br>
<select name="karta">
    <option value="1">10 Kier</option>
    <option value="2">10 Pik</option>
    <option value="3">10 Karo</option>
    <option value="4">10 Trefl</option></select><br>I stawiam: 
<input type="text" name="ile"><br><br>
   
    <tr><td colspan=2 align=center><input type="submit" value="Wybra³em i gram dalej!"></td></tr></center>
    </form>
    </table>
{/if}


<br><br>
<a href=http://team.helgrind.info><i>Made by Revolas.</a>
