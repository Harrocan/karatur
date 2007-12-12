
    {literal}
    <style type="text/css">
	.bb-sel-desc{
	padding-left:15px;
	}
	td.bb-sel-marker{
	vertical-align:top;
	background:#0D2D0D;
	cursor:pointer;
	}
	td.bb-sel-marker:hover{
	background:#158C15;
	}
	.ex-code {
	border: dashed 1px white;
	margin-left:20px;
	background:#273844;
	white-space: pre;
	}
	fieldset.ex-code > legend {
	font-weight:bold;
	
	}
	.ex-profile {
	border: dashed 1px white;
	margin-left:20px;
	background:#273844;
	}
	</style>
    <script type="text/javascript">
    function toggleBBdesc( item ) {
    	var el = $( 'desc-' + item );
    	var mark = $( 'desc-marker-' + item );
    	if( el ) {
    		if( el.style.display == 'none') {
    			el.style.display = "table-row";
    			mark.innerHTML = "-";
    		}
    		else {
    			el.style.display = "none";
    			mark.innerHTML = "+";
    		}
    	}
    }
    </script>
    {/literal}
    <br/><br/>
 <table class="table">
 	<tr>
 		<td class="thead" colspan="10" style="text-align:center;font-size:1.8em;font-weight:bold;">Pomoc do profili !</td>
 	</tr>
 	<tr>
 		<td>
 			<b>Ten system jeszcze nie zosta� wprowadzony !! To b�dzie strona na kt�rej b�dzie mo�na si� dowiadywa� jak to dzia�a, jednak�e jeszce �adne opcje z tej strony nie dzia�aj� w obecnych profilach.</b><br/><br/>
 			Zosta� wprowadzony nowy, zaawansowany i daj�cy du�e mo�liwo�ci system formatowania profili. Teraz mozliwa jest prawie ka�da kombinacja i dowolny uk�ad graficzny profilu. Co nie jest mo�liwe ? obrazki i linki. Reszt� chyba si� da ;).<br/><br/>Zaczn� od przyk�adu :
 			<fieldset class="ex-code"><legend>Kod</legend>by�a
 [b text-decoration="blink" color="red"]
   ciemna
 [/b]
 noc ... 
 [i]
   dooko�a
     [text text-decoration="line-through"]
       grzmia�o
     [/text]
 [/i]</fieldset>
 			da nast�puj�cy efekt :
 			<fieldset class="ex-profile"><legend>Profil</legend>
 			by�a 
 			<b style="text-decoration:blink;color:red">ciemna</b> noc ... <i>dooko�a <span style="text-decoration:line-through">grzmia�o</span></i>
 			</fieldset>
 			Jak wida� - mo�liwo�ci sporo, zw�aszcza gdy si� pozna ca�� dost�pn� list� ...<br/>
 			Zanim j� przedstawi� ... kt�tkie om�wienie ... Chc�c zastosowa� jakie� formatowanie do profilu, trzeba zastosowa� nast�puj�c� konstrukcj� :
 			<fieldset class="ex-code">[(selektor) (atrybut)="(warto��)"]
  (zawarto�� modyfikowana)
[/(selektor)]</fieldset>
 			czyli np.
 			<fieldset class="ex-code">[b color="red"]jaki� text[/b]</fieldset><br/><br/><br/>Na uspokojnie na samym poczatku powiem �e nowy system jest w pe�ni kompatybilny ze starym - to znaczy ze po zmianie na nowy system, nie b�dzie trzeba nic zmienia� w starych profilach. Mo�na tylko doda� co� wi�cej :)
 		</td>
 	</tr>
 	<tr>
 		<td class="thead" colspan="10" style="text-align:left;font-size:1.3em;font-weight:bold;">Dost�pne selektory</td>
 	</tr>
 	<tr>
 		<td>
 			No dobra ... wiemy jak to ze szkicu wygl�da, ale jakie selektory mo�na u�ywa� :
 			<ul>
 				<li><b>a</b> - hiper��cze. Jednak�e nie mo�na go wkorzysta� do stworzenia normalnego odno�nika do dowolnego adresu. Mo�na go u�y� do stworzenia kotwicy, oraz odno�nika do tej kotwicy. Przydatne je�li ma si� d�ugi profil, i chce si� stworzy� co� w rodzaju spisu tre�ci na pocz�tku</li>
 				<li><b>b</b> - text pogrubiony</li>
 				<li><b>u</b> - text podkre�lony</li>
 				<li><b>i</b> - text kursywy</li>
 				<li><b>ul</b> - lista nieuporz�dkowana</li>
 				<li><b>ol</b> - lista uporz�dkowana</li>
 				<li><b>li</b> - element listy (dowolnego rodzaju listy)</li>
 				<li><b>div</b> - osobny blok tekstu</li>
 				<li><b>span</b> - fragment tekstu w wi�kszym bloku</li>
 				<li><b>text</b> - inna nazwa na selektor 'span'</li>
 				<li><b>block</b> - inna nazwa na selektor 'div'</li>
 				<li><b>table</b> - Tabela</li>
 				<li><b>tr</b> - wiersz tabeli</li>
 				<li><b>td</b> - kom�rka w wierszu</li>
 			</ul>
 			Dodatkowo istniej� jeszcze selektory [br] (nowa linia) oraz [hr] (linia pozioma) jednak�e nie mo�na im przypisywa� �adnch atrybut�w.<br/><br/>
 			<span style="font-size:1.3em;color:red">UWAGA !!!</span> nie mo�na zagnie�dza� w sobie selektor�w o takiej samej nazwie !!. B�ednym jest u�ycie takiej konstrukcji :
 			<fieldset class="ex-code">[b]jakis [i]dlugi [b]tekst[/b] z zagnie�dzonymi [/i] selektorami[/b]</fieldset>
 			lub takiej :
 			<fieldset class="ex-code">[b]jakis [b]tekst[/b] niepoprawny[/b]</fieldset>
 			W przyk�adach powy�ej selektor <b>b</b> jest wewn�trz innego takiego selektora. W przykladzie na samym dole strony jest pokazane w jaki sposob takie przyklady beda blednie zinterpretowane.<br/>
 			<!--Poniewa� cz�sto spotyka si� konieczno�� zagnie�dzania w sobie kolejnych selektor�w <b>div</b> oraz <b>span</b> tote� na t� okoliczno�c zosta�y stworzone dodatkowe selektory : div1, div2, div3, div4, span1, span2, span3, span4. Taka ilo�c powinna wystarczy� na wszelkie rozwi�zania-->
 		</td>
 	</tr>
 	<tr>
 		<td class="thead" colspan="10" style="text-align:left;font-size:1.3em;font-weight:bold;">Dost�pne atrbuty</td>
 	</tr>
 	<tr>
 		<td>
 		Skoro ju� wiemy jakie mo�na selektory stosowa�, to teraz pytanie jakie atrybuty mo�na im przypisac ? <br/>
 		Dozwolone warto�ci typu &lt;jaka� warto��&gt; to s� grupy typ�w. Wyja�nienie znaczenia tych grup znajduje si� w nast�pnym rozdziale ni�ej <br/>
 		Oto lista dost�pnych atrybut�w:
 		<table class="table">
 			<tr>
 				<td>Selektor</td><td>dozwolone warto�ci</td><td>opis</td>
 			</tr>
 		{section name=cs loop=$CssData}
 		{assign value=$CssData[cs] var='Item'}
 			<tr>
 				<td>{$Item.name}</td><td>{if $Item.v_type=='C'}<a href="#{$Item.value}"><i>&lt;{$Item.value}&gt;</i></a>{else}{$Item.value}{/if}</td><td>{$Item.s_desc}</td><td onclick="toggleBBdesc( '{$Item.name}' )" id="desc-marker-color" class="bb-sel-marker">+</td>
 			<tr id="desc-{$Item.name}" style="display:none">
 				<td class="bb-sel-desc" colspan="10">{if $Item.l_desc}{$Item.l_desc}{else}Zagadnienie nie opisane.<br/>Jest wysoce prawdopodobne �e na pierwszych 2-3 linkach znajdziesz dok�adne wyja�nienie dzia�ania selektora {$Item.name} (po polsku). <a href="http://www.google.pl/search?q=css+{$Item.name}&lr=lang_pl" target="_blank">Link</a>{/if}</td>
 			</tr>
 		
 		{/section}
 
 		</table>
 		</td>
 	</tr>
 	<tr>
 		<td class="thead" colspan="10" style="text-align:left;font-size:1.3em;font-weight:bold;">Dost�pne grupy typ�w</td>
 	</tr>
 	<tr>
 		<td>Tak wi�c cz�� selektor�w mo�na pogrupowa� w pewne dozwolone warto�ci. Oto one :
 		<ul>
 			<li><a name="dlugosc"></a><b>D�ugo��</b> : Opisuje odleg�o��. M.in. od brzeg�w, od wn�trza, od tekstu. Generalnie to bardzo r�nie. Jakie jednostki s� dozwolone : <br/>
 			- 1.5cm<br/>
 			- 30px<br/>
 			- 13mm<br/>
 			- 1.2em - specjalna jednostka. 1em oznacza standardow� wysoko�� tekstu. Czyli np. 1.5em oznacza tekst kt�r jest proporcjonalnie 0.5 raza wi�kszy od zwk�ego tekstu<br/>
 			Generalnie to jak namieszasz z wysoko�ci� ( np. 3.4px ) to poprostu nie b�dzie dzia�a� ta definicja d�ugo�ci. Nic strasznego si� nei stanie ;)</li>
 			<li><a name="kolor"></a><b>Kolor</b> : Okre�la jak �atwo si� domysli� - kolor ;) Jedyne co mo�e sprawia� k�oppty to dozwolony format definiowania koloru : szesnastkowo. Czyli np <b>#FFA50A</b>. Je�li chodzi o szczeg�ly to mo�na taki zapis podzieli� na 3 cz�sci :  FF, A5, 0A ... to s� odpowiednio zawarto�ci koloru czerwonego (FF), zielonego (A5) i niebieskiego (0A) w kolorze. Je�li nie rozumiesz tego to si� nie martw - nie musisz ;)<br/><br/>Tutaj znajduje si� spora lista kolor�w kt�re mo�na u�ywa� : <a href="http://en.wikipedia.org/wiki/Web_colors">Wikipedia (ang)</a> oraz <a href="http://pl.wikipedia.org/wiki/Barwa">Wikipedia (pl)</a></li>
 		</ul>
 		</td>
	</tr>
	<tr>
 		<td class="thead" colspan="10" style="text-align:center;font-size:1.8em;font-weight:bold;">Przyk�ad</td>
 	</tr>
 	<tr>
 		<td>
 		 <br/><br/>A tutaj jako (zaawansowany nieco) przyk�ad profilu, wykorzystuj�cy zaawansowanie BBcode, oraz efekt ko�cowy. Mo�e komu� to pomo�e<br/>Najpierw efekt ko�cowy, a poni�ej kod jaki zosta� u�yty �eby co� takiego osi�gn��
 		 {$sample_html}
 		 <textarea readonly="readonly" style="width:100%;height:200px;white-space:pre;">{$sample_bbcode}</textarea>>
 		</td>
 	</tr>
 </table>
