{if $Location == "Athkatla"}
  <center>{$Name}</center>
    
Jest to miejsce gdzie gromadzone sa wszelkie fundusze kraju, to z tad wyplacane sa wyplaty dla pracownikow panstwowych a takze 
pomoc dla biednych mieszkancow.
        <br><br><br><br>
      
       
        <center><li>Sztuk zlota: {$Gold}</li></center>

        <center><li>Sztuk mithrilu: {$Mithril}</li></center>

        <center><br><br><br><li><a href="skarbiec.php?step=donate">Przekaz panstwu surowce</a></center>
        <center><br><br><br><li><a href="skarbiec.php?step2=daj">Dotacje od panstwa (tylko wladca)</a></center>


       
        
      
        </ul>
<br><br><br><br>

Oto panstwowe interesy ktore zasilaja Skarb Panstwa:<br>
Podrozowanie po platnym terenach ( Stajnia ) <br>
Kupowanie Piwa lub innych rzeczy w karczmie ( narazie nie dostepne )<br>
Stworzenie klanu <br>
Dotacje od Mieszkancow


<br><br>
Aby otrzymac dotacje od rzadu nalezy wyslac podanie do ksiecia. Dotacje sa rozdawane do 5000 jednorazowo dla mieszkancow w wieku ponizej 20 lat.<br>
Dotacje Zamkniete !
        
<br><br><Br>
<p align=right><font size=1 face=Verdana color=white></font></p>    
{/if}
    {if $Step == "donate"}<br><br><br>
        Przekaz pieniadze dla panstwa by je wspomoc finansowo.<br><br><br>
        <form method="post" action="skarbiec.php?view=my&step=donate&step2=donate">
        Dotuj <input type="text" size="5" name="amount" value="0"> <select name="type">
        <option value="credits">Sztuk Zlota<img border="0" src="images/zloto.gif" width="27" height="17"></option>
        <option value="platinum">Sztuk Mithrilu<img border="0" src="images/mir.gif" width="27" height="17"></option>
        </select> dla panstwa. <input type="submit" value="Dotuj">
        </form>
        {$Message}
    {/if}

        {if $Step2 == "daj"}<br><br><br>
            <form method="post" action="skarbiec.php?view=my&step2=daj&action=loan">
            Pozycz <input type="text" size="5" name="amount"> <select name="currency">
            <option value="credits">sztuk zlota</option>
            <option value="platinum">sztuk mithrilu</option></select>
            osobie ID <input type="text" size="5" name="id">. <input type="submit" value="Daj">
            </form>
            {$Message}
        {/if}
<br><br><br>
<center><a href=skarbiec.php>(Wroc)</a></center>

