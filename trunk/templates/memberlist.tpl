<table>
<tr>
<td width="50"><a href="memberlist.php?lista=id&limit=0"><b><u>ID</u></b></a></td>
<td width="100"><a href="memberlist.php?lista=user&limit=0"><b><u>Imie</u></b></a></td>
<td width="100"><a href="memberlist.php?lista=rank&limit=0"><b><u>Ranga</u></b></a></td>
<td width="50"><a href="memberlist.php?lista=rasa&limit=0"><b><u>Rasa</b></u></a></td>
<td width="50"><a href="memberlist.php?lista=level&limit=0"><b><u>Poziom</u></b></a></td>
</tr>
{section name=list1 loop=$Name}
    <tr>
    <td>{$Memid[list1]}</td>
    <td><a href="view.php?view={$Memid[list1]}">{$Name[list1]}</a></td>
    <td>{$Rank[list1]}</td>
    <td>{$Race[list1]}</td>
    <td>{$Level[list1]}</td>
    </tr>
{/section}
</table>
{$Previous} {$Next}
<br>
<form method="post" action="memberlist.php?limit=0&lista=user">
Szukaj gracza po ksywce. Jezeli nie znasz jego dokladnej ksywki, uzyj znaku * zamiast liter.<br>
Gracz: <input type="text" name="szukany"><br>
Badz tez mozesz sprobowac szukac po numerze gracza (id)<br>
ID: <input type="text" name="id" value="0"><br>
<input type="submit" value="Szukaj">
</form>

