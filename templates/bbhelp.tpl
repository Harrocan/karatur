
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
 			<b>Ten system jeszcze nie zosta³ wprowadzony !! To bêdzie strona na której bêdzie mo¿na siê dowiadywaæ jak to dzia³a, jednak¿e jeszce ¿adne opcje z tej strony nie dzia³aj± w obecnych profilach.</b><br/><br/>
 			Zosta³ wprowadzony nowy, zaawansowany i daj±cy du¿e mo¿liwo¶ci system formatowania profili. Teraz mozliwa jest prawie ka¿da kombinacja i dowolny uk³ad graficzny profilu. Co nie jest mo¿liwe ? obrazki i linki. Resztê chyba siê da ;).<br/><br/>Zacznê od przyk³adu :
 			<fieldset class="ex-code"><legend>Kod</legend>by³a
 [b text-decoration="blink" color="red"]
   ciemna
 [/b]
 noc ... 
 [i]
   dooko³a
     [text text-decoration="line-through"]
       grzmia³o
     [/text]
 [/i]</fieldset>
 			da nastêpuj±cy efekt :
 			<fieldset class="ex-profile"><legend>Profil</legend>
 			by³a 
 			<b style="text-decoration:blink;color:red">ciemna</b> noc ... <i>dooko³a <span style="text-decoration:line-through">grzmia³o</span></i>
 			</fieldset>
 			Jak widaæ - mo¿liwo¶ci sporo, zw³aszcza gdy siê pozna ca³± dostêpn± listê ...<br/>
 			Zanim j± przedstawiê ... któtkie omówienie ... Chc±c zastosowaæ jakie¶ formatowanie do profilu, trzeba zastosowaæ nastêpuj±c± konstrukcjê :
 			<fieldset class="ex-code">[(selektor) (atrybut)="(warto¶æ)"]
  (zawarto¶æ modyfikowana)
[/(selektor)]</fieldset>
 			czyli np.
 			<fieldset class="ex-code">[b color="red"]jaki¶ text[/b]</fieldset><br/><br/><br/>Na uspokojnie na samym poczatku powiem ¿e nowy system jest w pe³ni kompatybilny ze starym - to znaczy ze po zmianie na nowy system, nie bêdzie trzeba nic zmieniaæ w starych profilach. Mo¿na tylko dodaæ co¶ wiêcej :)
 		</td>
 	</tr>
 	<tr>
 		<td class="thead" colspan="10" style="text-align:left;font-size:1.3em;font-weight:bold;">Dostêpne selektory</td>
 	</tr>
 	<tr>
 		<td>
 			No dobra ... wiemy jak to ze szkicu wygl±da, ale jakie selektory mo¿na u¿ywaæ :
 			<ul>
 				<li><b>a</b> - hiper³±cze. Jednak¿e nie mo¿na go wkorzystaæ do stworzenia normalnego odno¶nika do dowolnego adresu. Mo¿na go u¿yæ do stworzenia kotwicy, oraz odno¶nika do tej kotwicy. Przydatne je¶li ma siê d³ugi profil, i chce siê stworzyæ co¶ w rodzaju spisu tre¶ci na pocz±tku</li>
 				<li><b>b</b> - text pogrubiony</li>
 				<li><b>u</b> - text podkre¶lony</li>
 				<li><b>i</b> - text kursywy</li>
 				<li><b>ul</b> - lista nieuporz±dkowana</li>
 				<li><b>ol</b> - lista uporz±dkowana</li>
 				<li><b>li</b> - element listy (dowolnego rodzaju listy)</li>
 				<li><b>div</b> - osobny blok tekstu</li>
 				<li><b>span</b> - fragment tekstu w wiêkszym bloku</li>
 				<li><b>text</b> - inna nazwa na selektor 'span'</li>
 				<li><b>block</b> - inna nazwa na selektor 'div'</li>
 				<li><b>table</b> - Tabela</li>
 				<li><b>tr</b> - wiersz tabeli</li>
 				<li><b>td</b> - komórka w wierszu</li>
 			</ul>
 			Dodatkowo istniej± jeszcze selektory [br] (nowa linia) oraz [hr] (linia pozioma) jednak¿e nie mo¿na im przypisywaæ ¿adnch atrybutów.<br/><br/>
 			<span style="font-size:1.3em;color:red">UWAGA !!!</span> nie mo¿na zagnie¿dzaæ w sobie selektorów o takiej samej nazwie !!. B³ednym jest u¿ycie takiej konstrukcji :
 			<fieldset class="ex-code">[b]jakis [i]dlugi [b]tekst[/b] z zagnie¿dzonymi [/i] selektorami[/b]</fieldset>
 			lub takiej :
 			<fieldset class="ex-code">[b]jakis [b]tekst[/b] niepoprawny[/b]</fieldset>
 			W przyk³adach powy¿ej selektor <b>b</b> jest wewn±trz innego takiego selektora. W przykladzie na samym dole strony jest pokazane w jaki sposob takie przyklady beda blednie zinterpretowane.<br/>
 			<!--Poniewa¿ czêsto spotyka siê konieczno¶æ zagnie¿dzania w sobie kolejnych selektorów <b>div</b> oraz <b>span</b> tote¿ na tê okoliczno¶c zosta³y stworzone dodatkowe selektory : div1, div2, div3, div4, span1, span2, span3, span4. Taka ilo¶c powinna wystarczyæ na wszelkie rozwi±zania-->
 		</td>
 	</tr>
 	<tr>
 		<td class="thead" colspan="10" style="text-align:left;font-size:1.3em;font-weight:bold;">Dostêpne atrbuty</td>
 	</tr>
 	<tr>
 		<td>
 		Skoro ju¿ wiemy jakie mo¿na selektory stosowaæ, to teraz pytanie jakie atrybuty mo¿na im przypisac ? <br/>
 		Dozwolone warto¶ci typu &lt;jaka¶ warto¶æ&gt; to s± grupy typów. Wyja¶nienie znaczenia tych grup znajduje siê w nastêpnym rozdziale ni¿ej <br/>
 		Oto lista dostêpnych atrybutów:
 		<table class="table">
 			<tr>
 				<td>Selektor</td><td>dozwolone warto¶ci</td><td>opis</td>
 			</tr>
 		{section name=cs loop=$CssData}
 		{assign value=$CssData[cs] var='Item'}
 			<tr>
 				<td>{$Item.name}</td><td>{if $Item.v_type=='C'}<a href="#{$Item.value}"><i>&lt;{$Item.value}&gt;</i></a>{else}{$Item.value}{/if}</td><td>{$Item.s_desc}</td><td onclick="toggleBBdesc( '{$Item.name}' )" id="desc-marker-color" class="bb-sel-marker">+</td>
 			<tr id="desc-{$Item.name}" style="display:none">
 				<td class="bb-sel-desc" colspan="10">{if $Item.l_desc}{$Item.l_desc}{else}Zagadnienie nie opisane.<br/>Jest wysoce prawdopodobne ¿e na pierwszych 2-3 linkach znajdziesz dok³adne wyja¶nienie dzia³ania selektora {$Item.name} (po polsku). <a href="http://www.google.pl/search?q=css+{$Item.name}&lr=lang_pl" target="_blank">Link</a>{/if}</td>
 			</tr>
 		
 		{/section}
 
 		</table>
 		</td>
 	</tr>
 	<tr>
 		<td class="thead" colspan="10" style="text-align:left;font-size:1.3em;font-weight:bold;">Dostêpne grupy typów</td>
 	</tr>
 	<tr>
 		<td>Tak wiêc czê¶æ selektorów mo¿na pogrupowaæ w pewne dozwolone warto¶ci. Oto one :
 		<ul>
 			<li><a name="dlugosc"></a><b>D³ugo¶æ</b> : Opisuje odleg³o¶æ. M.in. od brzegów, od wnêtrza, od tekstu. Generalnie to bardzo ró¿nie. Jakie jednostki s± dozwolone : <br/>
 			- 1.5cm<br/>
 			- 30px<br/>
 			- 13mm<br/>
 			- 1.2em - specjalna jednostka. 1em oznacza standardow± wysoko¶æ tekstu. Czyli np. 1.5em oznacza tekst któr jest proporcjonalnie 0.5 raza wiêkszy od zwk³ego tekstu<br/>
 			Generalnie to jak namieszasz z wysoko¶ci± ( np. 3.4px ) to poprostu nie bêdzie dzia³aæ ta definicja d³ugo¶ci. Nic strasznego siê nei stanie ;)</li>
 			<li><a name="kolor"></a><b>Kolor</b> : Okre¶la jak ³atwo siê domysliæ - kolor ;) Jedyne co mo¿e sprawiaæ k³oppty to dozwolony format definiowania koloru : szesnastkowo. Czyli np <b>#FFA50A</b>. Je¶li chodzi o szczególy to mo¿na taki zapis podzieliæ na 3 czêsci :  FF, A5, 0A ... to s± odpowiednio zawarto¶ci koloru czerwonego (FF), zielonego (A5) i niebieskiego (0A) w kolorze. Je¶li nie rozumiesz tego to siê nie martw - nie musisz ;)<br/><br/>Tutaj znajduje siê spora lista kolorów które mo¿na u¿ywaæ : <a href="http://en.wikipedia.org/wiki/Web_colors">Wikipedia (ang)</a> oraz <a href="http://pl.wikipedia.org/wiki/Barwa">Wikipedia (pl)</a></li>
 		</ul>
 		</td>
	</tr>
	<tr>
 		<td class="thead" colspan="10" style="text-align:center;font-size:1.8em;font-weight:bold;">Przyk³ad</td>
 	</tr>
 	<tr>
 		<td>
 		 <br/><br/>A tutaj jako (zaawansowany nieco) przyk³ad profilu, wykorzystuj±cy zaawansowanie BBcode, oraz efekt koñcowy. Mo¿e komu¶ to pomo¿e<br/>Najpierw efekt koñcowy, a poni¿ej kod jaki zosta³ u¿yty ¿eby co¶ takiego osi±gn±æ
 		 {$sample_html}
 		 <textarea readonly="readonly" style="width:100%;height:200px;white-space:pre;">{$sample_bbcode}</textarea>>
 		</td>
 	</tr>
 </table>
