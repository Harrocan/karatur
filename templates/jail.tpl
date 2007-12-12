{if $Location != "Y"}
	Tutaj znajduja sie lochy Kara-Tur do ktorych wtracani sa wszyscy przestepcy notorycznie lamiacy prawo tej krainy. Wyrok zapada na okreslony
	czas. Dodatkowo przyjaciele uwiezionych moga wplacac kaucje aby ich uwolnic. Aby wplacic kaucje za dana osobe wystarczy po prostu kliknac
	na kwote kaucji. Oto lista osob skazanych wraz z opisem:<br><br><br>
	{section name=jail loop=$Name}
		<b>Imie skazanca:</b> <a href=view.php?view={$Id[jail]}>{$Name[jail]}</a><br>
		<b>ID skazanca:</b> {$Id[jail]}<br>
		<b>Data wtracenia do lochu:</b> {$Date[jail]}<br>
		<b>Przyczyna skazania:</b> {$Verdict[jail]}<br>
		<b>Dni pozostalych do odsiadki:</b> {$Duration[jail]}<br>
		<b>Wysokosc kaucji:</b> <a href=jail.php?prisoner={$Jailid[jail]}>{$Cost[jail]} sztuk zlota</a><br><br><br>
	{sectionelse}
		<center>Nie ma wiezniow w lochach!</center>
	{/section}
{/if}

{if $Location == "Y"}
Obecnie przebywasz w lochu.<br>
<b>Data wtracenia do lochu:</b> {$Date}<br>
<b>Dni pozostalych do odsiadki:</b> {$Duration}<br>
<b>Przyczyna skazania:</b> {$Verdict}<br>
<b>Wysokosc kaucji:</b> {$Cost}<br><br>
Mozesz uciec z wiezienia ale pamietaj, ze jesli Ci sie nie uda <br>moze Cie to duzo kosztowac.<br>
<b></b> <a href="jail.php?action=ucieczka">Uciekaj</a><br>
{/if}

