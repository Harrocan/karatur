Zauwazasz herolda dumnie stojacego przy wejsciu do jednego z hallow. Nim weszles herold zaslonil ci wejscie do sali halabarda, mowiac:
<br><i>Witaj w Sali Audiencyjnej. Tutaj jest spis osob prawnych w Kara-tur. Jesli masz jakis problem to napisz do ktoregos z przedstawicieli wladzy. Pamietaj jednak, ze im wyzej postawiona jest osoba, tym mniej czasu miec moze. Sprawy techniczne zglaszaj do Admina.</i>
<br><br>
<table>
<tr>
<td width="100"><b><u>Imie :</td>
<td width="50"><b><u>ID:</td>
<td width="200"><b><u>Ranga:</u></b></td>

</tr>
{section name=r loop=$Rank}
	<tr>
	<td><a href=view.php?view={$Rank[r].id}>{$Rank[r].user}</a></td>
	<td>{$Rank[r].id}</td>
	<td>{$Rank[r].rid}</td>
	</tr>
{/section}
</table>
