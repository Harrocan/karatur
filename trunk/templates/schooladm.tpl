{if $Action==''}
	Administacja szko³ami<br>
	<a href="schooladm.php?action=add">Dodaj szko³ê</a><br><br><br>
	<table class="table">
		<tr>
			<td class="thead">Id</td>
			<td class="thead">Nazwa</td><td class="thead">Miasto</td><td class="thead">Lvl</td>
			<td class="thead">Si</td><td class="thead">Zr</td><td class="thead">In</td>
			<td class="thead">Sz</td><td class="thead">Wy</td><td class="thead">Sw</td>
		</tr>
		{section name=sk loop=$School}
			<tr>
				<td>{$School[sk].id}.</td>
				<td>{$School[sk].name}</td>
				<td>{$School[sk].city}</td>
				<td>{$School[sk].level}</td>
				{section name=t loop=$School[sk].train}
					<td>
						{if $School[sk].train[t]==0}
							&nbsp;
						{else}
							J:{$School[sk].trainjump[t]}<br>M:{$School[sk].trainmax[t]}<br>C:{$School[sk].traincost[t]}
						{/if}</td>
				{/section}
					<form method="post" action="schooladm.php?action=edit">
					<td><input type="hidden" name="sid" value="{$School[sk].id}"><input type="submit" value="Edytuj"></td>
					</form>
			</tr>
		{/section}
	</table>
	<br><br>
{/if}
{if $Action=='add'}
	{if $Step==''}
	Dodawanie szko³y<br>
	<form method="post" action="schooladm.php?action=add&step=2">
	Wybierz co bêdze mo¿na trenowaæ w szkole <br>
	<input type="checkbox" name="si" value="1">Si³ê<br>
	<input type="checkbox" name="zr" value="1">Zrêczno¶æ<br>
	<input type="checkbox" name="in" value="1">Inteligencjê<br>
	<input type="checkbox" name="sz" value="1">Szybko¶æ<br>
	<input type="checkbox" name="wy" value="1">Wytrzyma³o¶æ<br>
	<input type="checkbox" name="sw" value="1">Si³ê Woli<br>
	<input type="submit" value="Dalej">
	</form>
	{/if}
	{if $Step=='2'}
	<form method="post" action="schooladm.php?action=add&step=3"><br>
	<table class="table">
		<tr>
			<td colspan="2" class="thead">Informacje ogólne</td>
		</tr>
		<tr>
			<td>Podaj nazwê szko³y</td><td><input type="text" name="name"></td>
		</tr>
		<tr>
			<td>Podaj miasto w którym siê znajduje</td><td><input type="text" name="city"></td>
		</tr>
		<tr>
			<td>Podaj minimalny poziom jaki trzeba posiadaæ</td><td><input type="text" name="level"></td>
		</tr>
	
	{if $Si=='1'}
		<input type="hidden" name="si" value="1">
		<tr><td colspan="2" class="thead">Trening si³y</td></tr>
		<tr><td>Podaj koszt</td><td><input type="text" name="sicost"></td></tr>
		<tr><td>Podaj skok</td><td><input type="text" name="sijump"></td></tr>
		<tr><td>Podaj maksymaln± warto¶æ</td><td><input type="text" name="simax"></td></tr>
	{/if}
	{if $Zr=='1'}
		<input type="hidden" name="zr" value="1">
		<tr><td colspan="2" class="thead">Trening zrêczno¶ci</td></tr>
		<tr><td>Podaj koszt</td><td><input type="text" name="zrcost"></td></tr>
		<tr><td>Podaj skok</td><td><input type="text" name="zrjump"></td></tr>
		<tr><td>Podaj maksymaln± warto¶æ</td><td><input type="text" name="zrmax"></td></tr>
	{/if}
	{if $In=='1'}
		<input type="hidden" name="in" value="1">
		<tr><td colspan="2" class="thead">Trening inteligencji</td></tr>
		<tr><td>Podaj koszt</td><td><input type="text" name="incost"></td></tr>
		<tr><td>Podaj skok</td><td><input type="text" name="injump"></td></tr>
		<tr><td>Podaj maksymaln± warto¶æ</td><td><input type="text" name="inmax"></td></tr>
	{/if}
	{if $Sz=='1'}
		<input type="hidden" name="sz" value="1">
		<tr><td colspan="2" class="thead">Trening szybko¶ci</td></tr>
		<tr><td>Podaj koszt</td><td><input type="text" name="szcost"></td></tr>
		<tr><td>Podaj skok</td><td><input type="text" name="szjump"></td></tr>
		<tr><td>Podaj maksymaln± warto¶æ</td><td><input type="text" name="szmax"></td></tr>
	{/if}
	{if $Wy=='1'}
		<input type="hidden" name="wy" value="1">
		<tr><td colspan="2" class="thead">Trening wytrzyma³o¶ci</td></tr>
		<tr><td>Podaj koszt</td><td><input type="text" name="wycost"></td></tr>
		<tr><td>Podaj skok</td><td><input type="text" name="wyjump"></td></tr>
		<tr><td>Podaj maksymaln± warto¶æ</td><td><input type="text" name="wymax"></td></tr>
	{/if}
	{if $Sw=='1'}
		<input type="hidden" name="sw" value="1">
		<tr><td colspan="2" class="thead">Trening si³y woli</td></tr>
		<tr><td>Podaj koszt</td><td><input type="text" name="swcost"></td></tr>
		<tr><td>Podaj skok</td><td><input type="text" name="swjump"></td></tr>
		<tr><td>Podaj maksymaln± warto¶æ</td><td><input type="text" name="swmax"></td></tr>
	{/if}
	</table>
	<input type="submit" value="Dodaj !"><br>
	</form>
	{/if}
{/if}