<?php
$title = "Pomoc BB";

require_once("includes/head.php");
require_once( "includes/bbcode_profile.php" );

$smarty->force_compile = true;

$pos = 0;
$cssData[$pos]['name'] = 'color';
$cssData[$pos]['v_type'] = 'C';
$cssData[$pos]['value'] = 'kolor';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'background-color';
$cssData[$pos]['v_type'] = 'C';
$cssData[$pos]['value'] = 'kolor';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'border-color';
$cssData[$pos]['v_type'] = 'C';
$cssData[$pos]['value'] = 'kolor';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'border-width';
$cssData[$pos]['v_type'] = 'C';
$cssData[$pos]['value'] = 'dlugosc';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'border-style';
$cssData[$pos]['v_type'] = 'V';
$cssData[$pos]['value'] = 'solid, none, dotted, dashed, double';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'border-top-color';
$cssData[$pos]['v_type'] = 'C';
$cssData[$pos]['value'] = 'kolor';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'border-bottom-color';
$cssData[$pos]['v_type'] = 'C';
$cssData[$pos]['value'] = 'kolor';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'border-left-color';
$cssData[$pos]['v_type'] = 'C';
$cssData[$pos]['value'] = 'kolor';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'border-right-color';
$cssData[$pos]['v_type'] = 'C';
$cssData[$pos]['value'] = 'kolor';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'border-top-style';
$cssData[$pos]['v_type'] = 'V';
$cssData[$pos]['value'] = 'solid, none, dotted, dashed, double';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'border-bottom-style';
$cssData[$pos]['v_type'] = 'V';
$cssData[$pos]['value'] = 'solid, none, dotted, dashed, double';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'border-left-style';
$cssData[$pos]['v_type'] = 'V';
$cssData[$pos]['value'] = 'solid, none, dotted, dashed, double';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'border-right-style';
$cssData[$pos]['v_type'] = 'V';
$cssData[$pos]['value'] = 'solid, none, dotted, dashed, double';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'clear';
$cssData[$pos]['v_type'] = 'V';
$cssData[$pos]['value'] = 'none, left, right, both, inherit';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'cursor';
$cssData[$pos]['v_type'] = 'V';
$cssData[$pos]['value'] = 'auto, crosshair, default, pointer, text, wait, help';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'display';
$cssData[$pos]['v_type'] = 'V';
$cssData[$pos]['value'] = 'inline, block, none, inherit';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'float';
$cssData[$pos]['v_type'] = 'V';
$cssData[$pos]['value'] = 'left, right, none, inherit';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'font-size';
$cssData[$pos]['v_type'] = 'C';
$cssData[$pos]['value'] = 'dlugosc';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'font-weight';
$cssData[$pos]['v_type'] = 'V';
$cssData[$pos]['value'] = 'normal, bold';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'font-style';
$cssData[$pos]['v_type'] = 'V';
$cssData[$pos]['value'] = 'normal, oblique, italic';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'line-height';
$cssData[$pos]['v_type'] = 'C';
$cssData[$pos]['value'] = 'dlugosc';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'height';
$cssData[$pos]['v_type'] = 'C';
$cssData[$pos]['value'] = 'dlugosc';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'left';
$cssData[$pos]['v_type'] = 'C';
$cssData[$pos]['value'] = 'dlugosc';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'list-style-position';
$cssData[$pos]['v_type'] = 'V';
$cssData[$pos]['value'] = 'inside, outside, inherit';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'list-style-type';
$cssData[$pos]['v_type'] = 'V';
$cssData[$pos]['value'] = 'disc, circle, square, decimal, decimal-leading-zero, lower-roman, upper-roman';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'margin';
$cssData[$pos]['v_type'] = 'C';
$cssData[$pos]['value'] = 'dlugosc';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'margin-top';
$cssData[$pos]['v_type'] = 'C';
$cssData[$pos]['value'] = 'dlugosc';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'margin-bottom';
$cssData[$pos]['v_type'] = 'C';
$cssData[$pos]['value'] = 'dlugosc';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'margin-left';
$cssData[$pos]['v_type'] = 'C';
$cssData[$pos]['value'] = 'dlugosc';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'margin-right';
$cssData[$pos]['v_type'] = 'C';
$cssData[$pos]['value'] = 'dlugosc';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'max-width';
$cssData[$pos]['v_type'] = 'C';
$cssData[$pos]['value'] = 'dlugosc';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'min-width';
$cssData[$pos]['v_type'] = 'C';
$cssData[$pos]['value'] = 'dlugosc';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'max-height';
$cssData[$pos]['v_type'] = 'C';
$cssData[$pos]['value'] = 'dlugosc';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'min-height';
$cssData[$pos]['v_type'] = 'C';
$cssData[$pos]['value'] = 'dlugosc';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'outline-color';
$cssData[$pos]['v_type'] = 'C';
$cssData[$pos]['value'] = 'kolor';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'outline-style';
$cssData[$pos]['v_type'] = 'V';
$cssData[$pos]['value'] = 'solid, none, dotted, dashed, double';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'padding';
$cssData[$pos]['v_type'] = 'C';
$cssData[$pos]['value'] = 'dlugosc';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'padding-top';
$cssData[$pos]['v_type'] = 'C';
$cssData[$pos]['value'] = 'dlugosc';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'padding-bottom';
$cssData[$pos]['v_type'] = 'C';
$cssData[$pos]['value'] = 'dlugosc';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'padding-left';
$cssData[$pos]['v_type'] = 'C';
$cssData[$pos]['value'] = 'dlugosc';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'padding-right';
$cssData[$pos]['v_type'] = 'C';
$cssData[$pos]['value'] = 'dlugosc';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'position';
$cssData[$pos]['v_type'] = 'V';
$cssData[$pos]['value'] = 'static, relative, absolute';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'right';
$cssData[$pos]['v_type'] = 'C';
$cssData[$pos]['value'] = 'dlugosc';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'text-align';
$cssData[$pos]['v_type'] = 'V';
$cssData[$pos]['value'] = 'left, right, center, justify';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'text-decoration';
$cssData[$pos]['v_type'] = 'V';
$cssData[$pos]['value'] = 'none, underline, overline, line-through, blink';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'text-indent';
$cssData[$pos]['v_type'] = 'C';
$cssData[$pos]['value'] = 'dlugosc';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'text-transform';
$cssData[$pos]['v_type'] = 'V';
$cssData[$pos]['value'] = 'capitalize, uppercase, lowercase, none, inherit';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'top';
$cssData[$pos]['v_type'] = 'C';
$cssData[$pos]['value'] = 'dlugosc';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'white-space';
$cssData[$pos]['v_type'] = 'V';
$cssData[$pos]['value'] = 'normal, pre, nowrap';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;
$cssData[$pos]['name'] = 'width';
$cssData[$pos]['v_type'] = 'C';
$cssData[$pos]['value'] = 'dlugosc';
$cssData[$pos]['s_desc'] = '';
$cssData[$pos]['l_desc'] = '';
$pos++;

$cssData[$pos]['name'] = 'href';
$cssData[$pos]['v_type'] = 'V';
$cssData[$pos]['value'] = '#napis';
$cssData[$pos]['s_desc'] = 'tworzenie odnosnika do kotwicy';
$cssData[$pos]['l_desc'] = 'zagadnienie tworzenia kowicy i odnosnika do niej jest bardzo dobrze opisane tutaj : <a href="http://www.kurshtml.boo.pl/html/do_etykiety,odsylacze.html"> link </a>';
$pos++;

$cssData[$pos]['name'] = 'name';
$cssData[$pos]['v_type'] = 'V';
$cssData[$pos]['value'] = 'napis';
$cssData[$pos]['s_desc'] = 'tworzenie kotwicy';
$cssData[$pos]['l_desc'] = 'zagadnienie tworzenia kowicy i odnosnika do niej jest bardzo dobrze opisane tutaj : <a href="http://www.kurshtml.boo.pl/html/do_etykiety,odsylacze.html"> link </a>';
$pos++;



$text = <<<EOD
[div text-align="center" font-size="1.5em" font-weight="bold" color="red"]
	Alucard van Hellsing
[/div]
[div text-align="center" font-size="0.9em" font-style="italic" color="#404040"]
	nawet nie zauwa¿ysz, [b]gdy [i]zmieni[b]Twoje[/b][/i] ¿ycie[/b]
[/div]

[b clear="both" display="block" font-size="1.3em" padding-left="15px" border-bottom-style="solid" border-width="3px" margin-bottom="4px"]Nawigacja[/b]
[a border-style="solid" margin="2px 2px" background-color="#545454" text-align="center" display="block" width="70px" height="25px" float="left" href="#opis"]Historia postaci[/a]
[a border-style="solid" margin="2px 2px" background-color="#545454" text-align="center" display="block" width="70px" height="25px" float="left" href="#wyglad"]Opis fizyczny[/a]
[a border-style="solid" margin="2px 2px" display="block" background-color="#3D0000" text-align="center" width="70px" height="25px" float="left" href="#wymagam" font-weight="bold" color="red"]Zanim napiszesz[/a]

[a name="opis"][/a]
[b clear="both" display="block" font-size="1.3em" padding-left="15px" border-bottom-style="solid" border-width="3px" margin-bottom="4px"]Historia[/b]
[div background-color="#7F3300" height="300px" width="350px" margin="5px auto" text-align="center"]
	Sporo miejsca na jakas zwyklaa opisowke
[/div]

[a name="wyglad"][/a]
[b clear="both" display="block" font-size="1.3em" padding-left="15px" border-bottom-style="solid" border-width="3px" margin-bottom="4px"]Wygl±d[/b]
[div width="350px" margin="5px auto"]
	Niezwykle wysoki. Wystajê zawsze z t³umu jak typowy pal. Je¶li wogóle przebywam w t³umie. Nozê roz³o¿ysy, czewrony kapelusz oraz pomarañczowe okularki, niezwkle fosforyzujace. Rzadko kiedy zobaczyæ mo¿na moje oczy. Znacznie czê¶ciej natomiast mo¿na zobaczyæ ten typowy ironiczny usmieszek z zaci¶niêtymi wargami, tworz±cy cienk± kreskê, którym zwyk³em obdarzaæ swojego rozmówcê. Noszê siê ubrany na czerwono. Zazwyczaj w moim ulubionym czerwonym p³aszczu, siêgaj±cym do kostek. Do tegp obowi±zkowo bia³e rêkawiczki i charakterystycznym emblematem na grzbiecie. Broni mojej nie zobaczysz. Ot, taka ma³a tajemnica.
[/div]

[a name="wymagam"][/a]
[b display="block" font-size="1.3em" padding-left="15px" border-bottom-style="solid" border-width="3px" margin-bottom="4px"]Czego wymagam[/b]
[ul padding-left="18px" margin="0px"]
[li][b]NIE JESTEM AL[/b][/li]
[li]Nie lubie tanich pogaduszek, nie mam na nie czasu[/li]
[li][span color="red"]Tytu³uj wiadomo¶ci[/span]. Licz siê z du¿± prawdopodobnosci± zignorowania wiadomo¶ci bez tytu³u[/li]
[li]Je¶li masz zamiar zg³osiæ b³±d - [b]kieruj go na formularz zgloszeniowy[/b]. Tam na pewno nie umknie i ci±gle bêdzie widnia³ jako "nierozwi±zany" w denerwuj±cym kolorze czerwonym, wiêc bêdê go widzia³ za ka¿dym razem kiedy tam zagl±dnê (a czêsto zagl±dam)[/li]
[li]Pisz pe³ymi zdaniami, ortograficznie i czytelnie ! Nieczytelne wiadomo¶ci ignorujê (dopuszczam brak polskich liter gdy¿ sam to czêsto stosujê)[/li]
[li]zastanów siê dobrze nad tym czy na pewno chcesz/musisz do mnie napisaæ. Nie cierpiê gdy jaki¶ idiota wysy³a do mnie jakie¶ zbêdne wypociny. Zastanów siê dobrze czy na pewno do mni powiniene¶ to wys³aæ. Je¶li nie wiesz gdzie - zajrzyj na "P³ace" - tam masz wszystkie rangi z opisami do czego one s³u¿±[/li]
[li]Nie nadajê rang, nie udzielam ¶lubów (wyj±tek - zarz±dzam rangami architekta i m³odszego architekta)[/li]
[/ul]

EOD;
$new = bbcode_profile( $text );
$smarty->assign("sample_bbcode", $text );
$smarty->assign("sample_html", $new );
$smarty->assign( "CssData", $cssData );
$smarty -> display ('bbhelp.tpl');

//unset( $matches );
//preg_match_all("/(\[([\w]+)[^]]*\])([\w\d\n\s]*)(\[\/\\2\])/", $test, $matches );
//echo( $new );

require_once("includes/foot.php");
?>