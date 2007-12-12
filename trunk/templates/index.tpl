
	<br><br>
    <table width="90%" heigth="100%" align="center">
	{section name=news_i loop=$Newsy[0] max=3}	
	    <tr>
			<td>
				<table width="100%" style="border-spacing: 0px;">
					<tr>
						<td colspan="3" class="border"></td>
					</tr>
					<tr>
						<td class="border">
						</td>
						<td align="center" class="td_title">
							<h2>{$Newsy[1][news_i]}</h2>
						</td>
						<td class="border">
						</td>
					</tr>
					<tr>
						<td class="border">
						</td>
						<td align="center" class="td_title">
							<h3>dnia <b>{$Newsy[0][news_i]}</b> wyglosil swoja mowe <b>{$Newsy[2][news_i]}</b></h3>
						</td>
						<td class="border">
						</td>
					</tr>
					<tr>
						<td colspan="3" class="border"></td>
					</tr>
					<tr>
						<td class="border">
						</td>
						<td>
							{$Newsy[3][news_i]}
						</td>
						<td class="border">
						</td>
					</tr>
					<tr>
						<td class="border">
						</td>
						<td align="right">
							Komentarzy : {$Newsy[4][news_i]} &nbsp;&nbsp;&nbsp;<br>
							Aby skomentowac - zaloguj sie &nbsp;&nbsp;&nbsp;
						</td>
						<td class="border">
						</td>
					</tr>
					<tr>
						<td colspan="3" class="border"></td>
					</tr>
				</table>
				<br><br>
			</td>
	    </tr>
		
	{/section}
    </table>

{if $Step == 'about'}
<table align="center">
	<tr>
		<td>
			Obecny sklad Kara-Tur Teamu wyglada nastepujaco:
			<ul>
				<li>Alucard van Hellsing - obecnie administrator serwera. Zarzadza techniczicznymi apektami serwera oraz rozwija go
				<li>Sarigalae Milivaren - Wladca. Pierwotny zalozyciel serwera, obecnie zarzadza wewnetrznie wszystkimi najwazniejszymi aspektami fabularnymi a takze dysponuje rangami. Rowniez od pewnego czasu zajmuje sie grafika
				<li>Windu Do`Urden - m³odszy architekt, rozwija i poprawia znalezione b³êdy na KT w wolnym czasie.
			</ul>
			Nasza ekipa nie jest zamknieta ... jesli chcialbys nam pomoc - pisz ... napewno znajdzie sie dla Ciebie zajecie
		</td>
	</tr>
</table>
<br><br>
{/if}
