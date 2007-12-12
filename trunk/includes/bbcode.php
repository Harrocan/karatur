<?php
/***************************************************************************
 *                               bbcode.php
 *                            -------------------
 *   copyright            : (C) 2004 Vallheru Team based on Gamers-Fusion ver 2.5
 *   email                : thindil@users.sourceforge.net
 *
 ***************************************************************************/

/***************************************************************************
 *
 *       This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with this program; if not, write to the Free Software
 *   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 ***************************************************************************/ 
 
 function nl2brStrict($text, $replacement = '<br>')
{
   return preg_replace("((\r\n)+)", trim($replacement), $text);
}
 
// funkcja konwertujaca znaki [b], [i], [u] na standardowe znaki html <b>, <i>, <u>, dodajaca usmieszki oraz znaki nowej linii
function bbcodetohtml($text) {
    // usuwanie znakow html z tekstu
    $text = strip_tags($text);
    // pogrubienie czcionki
    $text = str_replace("[b]","<b>",$text);
    $text = str_replace("[/b]","</b>",$text);
    // kursywa
    $text = str_replace("[i]","<i>",$text);
    $text = str_replace("[/i]","</i>",$text);
    // podkreslenie
    $text = str_replace("[u]","<u>",$text);
    $text = str_replace("[/u]","</u>",$text);
    // nowa linia i centerowanie
    $text = str_replace("[center]","<center>",$text);
    $text = str_replace("[/center]","</center>",$text);
    $text = str_replace("[br]","<br>",$text);
    $text = str_replace("[/br]","</br>",$text);
    //img
    $text = str_replace('[img]""', '<img =""',$text);
    $text = str_replace('[/img]','</img>',$text);
    //marqee
    $text = str_replace("[marquee]", "<marquee>", $text);
    $text = str_replace("[/marquee]", "</marquee>", $text);
    //url
    $text = str_replace("[url]","<url>",$text);
    $text = str_replace("[/url]","</url>",$text);
    // zmiana znakow konca linii na znaczniki html
    //$text = nl2brStrict($text);
    // zmiana usmieszkow w tekscie
    $text = str_replace(":)","*usmiecha sie*", $text);
    $text = str_replace(":D","*szeroko sie usmiecha*", $text);
    $text = str_replace(";)", "*mruga*", $text);
    $text = str_replace(":p","*pokazuje jezyk*", $text);
    $text = str_replace(";p","*pokazuje jezyk*", $text);
    $text = str_replace(":/","*krzywi sie*", $text);
    $text = str_replace(";/","*krzywi sie*", $text);
    $text = str_replace(":(","*smuci sie*", $text);
    $text = str_replace(":>","*patrzy z ukosa*", $text);
    $text = str_replace("xD","*bije glowa o sciane*", $text);
    $text = str_replace(":|","*dziwi sie*", $text);
    $text = str_replace(":]", "*patrzy*", $text);
    $text = str_replace("]:->", "*usmiecha sie zlowieszczo*", $text);
    $text = str_replace(":o","*szczeka opada*", $text);
    $text = str_replace(":O","*szczeka szeroko opada*", $text);
    $text = str_replace(";(","*beczy*", $text);
    // zwrocenie skonwertowanego tekstu
    return $text;
}
function bb2html( $text, $mode = 'normal' ) {
	$text = bbcodetohtml( $text );
	switch( $mode ) {
		case 'mg_room':
			$text = nl2br( $text );
			break;
	}
	return $text;
}

// funkcja konwertujaca znaki HTML takie jak <b> itd na znaki bbcode [b] oraz zmieniajaca usmieszki w tekst
function htmltobbcode($text) {
    // zmiana pogrubienia w html na bbcode
    $text = str_replace("<b>","[b]",$text);
    $text = str_replace("</b>","[/b]",$text);
    // zmiana kursywy w html na bbcode
    $text = str_replace("<i>","[i]",$text);
    $text = str_replace("</i>","[/i]",$text);
    //zmiana tego co u gory center i linia nowa
    $text = str_replace("<center>","[center]",$text);
    $text = str_replace("</center>","[/center]",$text);
    $text = str_replace("<br>","[br]",$text);
    $text = str_replace("</br>","[/br]",$text);
    //marqee
    $text = str_replace('<marquee>', '[marquee]', $text);
    $text = str_replace('</marquee>', '[/marquee]', $text);
    //img
    $text = str_replace("<img =>","[img]",$text);
    $text = str_replace("</img>","[/img]",$text);
    //url
    $text = str_replace("<url>","[url]",$text);
    $text = str_replace("</url>","[/url]",$text);
    // zmiana podkreslenia w html na bbcode
    $text = str_replace("<u>","[u]",$text);
    $text = str_replace("</u>","[/u]",$text);
    // zmiana obrazkol usmieszkow na tekst
    $text = str_replace("*usmiecha sie",":)", $text);
    $text = str_replace("*skacze z radosci*",":D", $text);
    $text = str_replace("*smuci sie*",":(", $text);
    $text = str_replace("*szczeka opada*",":o", $text);
    $text = str_replace("*beczy*",";(", $text);
    // pozbycie sie pozostalych znacznikow html
    $text = strip_tags($text,'<img>');
    //zwrocenie skonwertowanego tekstu
    return $text;
}
?>
