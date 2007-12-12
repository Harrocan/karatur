function desc( item ) {
	//document.getElementById("desc").innerHTML = 'wybrales ' + document.getElementsByName("type").selectedIndex.value;
	sel = item.options[item.selectedIndex].value;
	switch( sel ) {
		case 'E' :	//Bledy/bugi
			msg = '<b>Informacje o tym jak zglaszac bledy</b><br>' +
			'<ul>'+
			'<li>Opisz mozliwie dokladnie jakie akcje mogles wykonac ktore spowodowaly powstanie bledu</li>'+
			'<li>Temat - staraj sie nadacc  doosssennwy temat typu `blad na targu`  albo `pieniadze nie przechodza z lokat` a nie np `blad` czy tez `zgloszenie`</li>'+
			'<li><b>Koniecznie zamiesc wszelkie komunikaty</b> ktore sie pojawiaja na stronach - o tym ze czegos nie ma, o tym ze czegos brakuje</li>'+
			'<li>staraj sie pisac czytelnie, zrozumiale. Pamietaj ze architekt moze akurat myslec o czyms innym i moze sie nie domyslec roznych `oczywistych` dla Ciebie rzeczy</li>'+
			'<li>Gdy zgoszenie zostanie rozwiazane, zostaniesz o tym automatycznie poinformowany, z informacja jaki blad zostal uznany za rozwiazany. Dlatego prosze o <b>nie zglaszanie wielokrotnie przez ta sama osobe tego samego bledu</b>, ani <b>dopominania sie `czy kiedys rozwiazecie ten blad`, `ile mam czekac`, `czy wy wogole gracie w ta gre`</b> itp. Ani to mile ani na miejscu. Wyjatkiem od zglaszania ponownie tego samego bledu jest sytuacja w ktorej jestescie w stanie udzielic dodatkowch informacji na temat wystepowania bledu, zauwazacie go w innych miejscach i inne sensowne sytuacje</li>'+
			'</ul>'+
			'Pamietaj ze od tego jak opiszesz blad zalezy to jak szybko zostanie on rozwiazany';
			break;
		case 'R' :	//Rangi
			msg = '<b>Informacje gdy starasz sie o range</b><br>'+
			'<ul>Pierwsza, elementarna zasada : <b>klimat</b>. Podania musza byc klimatyczne, najlepiej fabularne, musisz pamietac o tym ze szalony barbarzynca [jesli powiedzmy miales taki opis w profilu] nie zostanie raczej ksiedzem. Na dodatek osoby bez uzupelnionego profilu [ktory takze musi byc klimatyczny a nie jakies kilka danych na odczepne, numer gg, lista przyjaciol i to wszystko] i avatara maja raczej nikle szanse na dostanie rangi. Dodatkowo osoby ktore chca `jakakolwiek`, `dowolna` range - czyli `co dasz to bedzie dobrze` takze nie maja raczej szans z powodow wymienionych wyzej - klimat i fabularnosc</ul>';
			break;
		case 'V' :	//Naruszenia regulaminu
			msg = '<b>Informacje wazne przy zglaszaniu naruszen regulaminu</b><br>' +
			'<ul>'+
			'<li>sprawdz w kodeksie czy na pewno cos co uwazasz za wykroczenie na pewno nim jest</li>'+
			'<li>zamiesc wszystkie dodatkowe informacje z dziennika/poczty/karczmy czy innych miejsc, ktore ukazuja wykroczenie. Pamietaj ze mamy pelna mozliwosc sprawdzania wiarygodnosci tych informacji i mozemy to zrobic. Dlatego odradzam przekrety</li>'+
			'<li>oczywistym chyba jest zebys zamiescil o kogo chodzi ? ;)</li>'+
			'<ul>'
			;
			break;
		case 'M' :	//Sluby
		case 'C' :	//Opinie/rady/uwagi
		case 'O' :	//Inne
			msg = 'Informacja<br><ul>To miejsce gdzie zglaszasz swoje uwagi i informacje. Pamietaj ze od tego jak to napiszesz bedzie zalezalo jak Cie bedziemy postrzegac. Mozesz wierzyc lub nie, ale dobra zabawa lezy w naszym interesie. Dlatego nie ma sensu sie burzyc, przeklinac, klamac. Mozesz byc pewny ze stad nic nie ucieka, dlatego nie ma sensu wielokrotnie zglaszac tego samego. Postaraj sie przed wyslaniem przeczytac swoja wiadomosc i usunac literowki, bledy ortograficzne i inne takie ... wtedy naprawde przyjemniej sie czyta takie zgloszenia ;)</ul>';
			break;
		default :
			msg = '';
			break;
	}
	msg = '<div style="color:red;font-weight:bold;font-size:1.3em;text-align:center">Przeczytaj zanim wy¶lesz zg³oszenie </div>' + msg;
	document.getElementById("desc").innerHTML = msg;
}