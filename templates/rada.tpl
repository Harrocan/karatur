Witaj w domu Spotkan Najwyzszej Rady Magow
<br /><br />
{if $location == 'Altara'}
	Nawet, jezeli jestes tak daleko od miejsca spotkan, tutaj znajduje sie magiczny ekran, za pomoca ktorego mozesz sie polaczyc z rada. Na miejscach siedzi kilku poslow z tego miasta
{/if}
<br />	
{if $zezw == 'yes'}
	Widze, ze jestes czlonkiem naszej Rady.<br />
	Nastepne nasze spotkanie odbedzie sie za {$data} dni
	
	{if $data == 0}
		Wlasnie odbywa sie spotkanie, prosze wejdz 
		<br>
			<ul>
			<li>
				<a href="rada.php?step=posiedzenie">
					Wchodzisz na posiedzenie
				</a>
			</li>
		</ul>
	{/if}
{/if}
{if $info == 'yes'}
	<i> Aby zostac czlonkiem musisz byc magiem, oraz miec odpowiedni poziom </i>
{/if}

{if $zezw == 'pos'}
	
	Widze, ze jestes czlonkiem naszej Rady.<br />
	Wlasnie odbywa sie spotkanie, siadz na wolnym miejscu i debatuj
	<br />
	<br />
	Dzisiejsza debata jest na temat {$temat}
	<br />
	<br />
	Powiedz cos:
	<br />
	<FORM METHOD=GET ACTION=rada.php NAME=formularz>
		<INPUT TYPE=HIDDEN NAME=ACTION VALUE=add>
		<INPUT TYPE=TEXT SIZE=60 MAXLENGTH=100 NAME=TEKST>
		<INPUT TYPE=HIDDEN NAME=step VALUE=posiedzenie>
		
		<SCRIPT LANGUAGE="JavaScript">
		<!--
		
		document.formularz.TEKST.focus();
		
		// -->
		</SCRIPT>
	</Form>
	<br />
	<a href="rada.php?step=posiedzenie">Odswierz</a>
	<br />
	<br />
	Oto dotychczasowe wypowiedzi radnych
	<br />
	<br />
	<iframe src="radameet.php?zezw=yes" width="105%" height="1000" name="ifr" frameborder="0"></iframe>

{/if}
{if $cd == 1}
	<br /> <br />
	Dotychczas ustalono taki dokument:
	<br />
	<br />
	<br />
	<i>
{/if}
{if $check == 'ok'}
	<br /> <br />
	Dotychczas ustalono taki dokument:
	<br />
	<br />
	<FORM METHOD=GET ACTION=rada.php NAME=formularz>
		<INPUT TYPE=SUBMIT NAME=ACTION VALUE=WYSLIJ>
{/if}
{if $cd == 2}		
		<INPUT TYPE=HIDDEN NAME=step VALUE=checkustawa>
		<INPUT TYPE=HIDDEN NAME=a VALUE=a>
		
		<SCRIPT LANGUAGE="JavaScript">
		<!--
		
		document.formularz.TEKST.focus();
		
		// -->
		</SCRIPT>
	</Form>
	<br />
	<i>
{/if}
{if $step == 'nic'}
Czego szukasz?
<br>
<ul>
	<li>
		<a href="rada.php?step=wejsc">
			Chce wejsc do srodka
		</a>
	</li>
	<li>
		<a href="rada.php?step=info">
			Chce sie dowiedziec, jak sie dostac do rady
		</a>
	</li>
</ul>
{/if}
{if $step == "data"}
Podaj iloœc dni do nastepnego spotkania
<FORM METHOD=GET ACTION=rada.php?step=data NAME=formularz>
<INPUT TYPE=TEXT NAME=dni SIZE=50 MAXLENGHT=2>
<INPUT TYPE=SUBMIT NAME=ACTION VALUE=WYSLIJ>
</FORM>
{/if}
{if $step == 'datadni'}
Zmienileœ dni do nastepnego spotkania na {$dni} <a href="rada.php">(wroc)</a>
<br />
<br />
{/if}
OPCJA TYLKO DLA WLADCOW
<a href="rada.php?step=data">ZMIEN DATE</a><br /><br />
