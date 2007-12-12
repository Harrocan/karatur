<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>{$Gamename} :: {$Title}</title>
<link rel="stylesheet" href="css/layout.css">
<link rel="stylesheet" href="css/lucass.css">
<link rel="shortcut icon" href="images/ikonka_KT.gif" type="image/gif">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2"> {*utf-8*}
<script language="JavaScript" src="js/advajax.js"></script>
<script language="JavaScript" src="js/ajax_base.js"></script>
<script type="text/javascript" src="js/head.js"></script>
{literal}
<!--[if IE]>
<script type="text/javascript" src="js/ie/iemarginfix.js"></script>
<style type="text/css">
body { behavior:url("css/hover.htc"); }
.css-popup-content {
top:25px !important;
}
</style>
<![endif]-->
{/literal}
</head>
{* refresh(5000); *}
<body onload="window.status='{$Gamename}';{if isset($Js_onLoad)}{$Js_onLoad};{/if}" style="margin:0px">
	

	<div style="background:black">
	<div id="overDiv" style="position:absolute; visibility:hidden;; z-index:1000"></div>
	</div>
	<Script language="JavaScript" src="overlib.js"></script>
	<div class="kt_cont">
		<table cellpadding="0" cellspacing="0" class="bar">
			<tr>
				<td class="bar-left"></td>
				<td class="bar-mid">
					{$FrDate}
				</td>
				<td class="bar-right"></td>
			</tr>
		</table>
		<img class="kt_logo" src="images/logo_kara.png" />
		<table cellpadding="0" cellspacing="0" class="bar">
			<tr>
				<td class="bar-left"></td>
				<td class="bar-mid">
				{css_popup_navig title="Statystyki" text="Zobacz swoje statystyki" url="stats.php" img="statystyki.gif"}
				{css_popup_navig title="Bogactwa" text="Sprawdz ile posiadasz pieniedzy, mineralow, ziol" url="zloto.php" img="bogactwa.gif"}
				{css_popup_navig title="Ekwipunek" text="Tutaj znajdziesz wszystkie swoje przedmioty" url="equip.php" img="ekwipunek.gif"} 
				{if $Spells}{css_popup_navig title="Księga czarów" text="Lista zaklęć" url="czary.php" img="ksiega.gif"}{/if}
				{if $Numlog>0}{assign value=1 var='Active'}{assign value="[`$Numlog`]" var='LogAmount'}{else}{assign value=0 var='Active'}{assign value="" var='LogAmount'}{/if}
				{css_popup_navig title="Dziennik <span style='color:red'>`$LogAmount`</span>" text="Wydarzenia zwiazane z twoja postacia" url="log.php" img="dziennik.gif" active=$Active} 
				{css_popup_navig title="Wieści" text="Aktualne wydazenia i wazne wiesci" url="updates.php" img="wiesci.gif"} 
				{css_popup_navig title="Notatnik" text="Tutaj mozesz zapisac sobie wszystkie informacje i nikt nie bedzie mial do nich wgladu" url="notatnik.php" img="notatnik.gif"}
				{if $Unread>0}{assign value=1 var='Active'}{assign value="[`$Unread`]" var='MailAmount'}{else}{assign value=0 var='Active'}{assign value="" var='MailAmount'}{/if}
				{css_popup_navig title="Poczta <span style='color:red'>`$MailAmount`</span>" text="Sprawdz kto ma dla Ciebie informacje do przekazania" url="mail.php" img="poczta.gif" active=$Active} 
				{css_popup_navig title="Karczma [`$Players`]" text="Wejdz do Karczmy pod Bialym Koniem i napij sie najlepszego piwa krasnoludzkiego z piana na dwa palce" url="chat.php" img="karczma.gif"} 
				{css_popup_navig title="Wędrówka" text="Wyrusz na wędrówkę w nieznane. Gdzie poniosą Cię nogi ?" url="mapa.php" img="wedrowka.gif"} 
				{if $Tribe}{css_popup_navig title="Klan" text="Sprawdz co się dzieje w Twoim klanie" url="tribes.php?view=my" img="klany.gif"} {/if}
				</td>
				<td class="bar-right"></td>
			</tr>
		</table>
		<div class="sidebar_left">
			<div class="sidebar_left-before"></div>
			<div class="side-cont">
				<center><b><i>{$Name}</i></b> ({$Id})</center><br>
				<b>Poziom:</b> {$Level}<br>
				<img src="imgbar.php?type=E&stat=PD&width=125&total={$Expneed}&cur={$Exp}" style="margin-top:5px"><br>
				<img src="imgbar.php?type=L&stat=Życie&width=125&total={$Maxhealth}&cur={$Health}" style="margin-top:5px"><br>
				<img src="imgbar.php?type=M&stat=Mana&width=125&total={$Maxmana}&cur={$Mana}" style="margin-top:5px"><br>
				{if isset($Krewka)}
				<img src="imgbar.php?type=K&stat=Krew&width=125&total={$Krewka_m}&cur={$Krewka}" style="margin-top:5px"><br>{/if}
				<span id="head_energy"><b>Energia:</b> <span id="head_energy_current">{$Energy}</span>/<span id="head_energy_max">{$Maxenergy}</span></span><br>
				<b>Zloto:</b> {$Gold}<br>
				<b>W banku:</b> {$Bank}<br>
				
				<hr class="kt-line"/>
				<b>Nawigacja</b>
				<hr class="kt-line"/>
				<br/>

				- <a href="bbhelp.php">Nowy BBCode</a><br/>
				- <a href="plany.php" {popup caption="Plany KTT" text='Przeczytaj co te planujemy zrobic z waszym kochanym, poczciwym i prostym Kara-Tur\'em ... to ju nie bedzie ta sama gra ... kiedys ...' fgcolor=$_OL.fg bgcolor=$_OL.bg textcolor=$_OL.text border=1 vauto=TRUE}>Plany KTT</a>
				<br>
				{if isset($Formlink)}{$Formlink}{/if}
				- <a href="bugtrack.php">Bugtrack ({$Numbugs})</a><br/>
				- <a href="modifs.php">Modyfikacje graczy</a>
				<br>
				- <a href="changelog.php" {popup caption="Rejestr zmian" text='Zastanawiasz sie co sie dzieje z gra ? Tutaj znajduje sie aktualizowany na bierzaco rejestr zmian - zagladaj czesto !' fgcolor=$_OL.fg bgcolor=$_OL.bg textcolor=$_OL.text border=1 vauto=TRUE}>Rejestr zmian</a><br>
				<hr class="kt-line"/>
				
				<br>
				- <a href="mgRoom.php">Pokój Mistrzów Gry</a><br>
				- <a href="rank_view.php" {popup caption='Płace' text="Sprawdz jakie sa aktualne stawki za wykonywane prace w krainie!" fgcolor=$_OL.fg bgcolor=$_OL.bg textcolor=$_OL.text border=1 vauto=TRUE}>Rangi</a><br>
				- <a href="info.php" {popup caption='Formularz zgloszeniowy' text="Jesli uwazasz ze jakas sprawa potrzebuje naglego zgloszenia do wladcow i chcesz by byla jak nasjszybciej rozpatrzona to wypelnij formularz i napisz wszystkie problemy ktore cie gnebia" fgcolor=$_OL.fg bgcolor=$_OL.bg textcolor=$_OL.text border=1 vauto=TRUE}>Formularz zgłoszeniowy</a><br>		
				- <a href="prawa.php" {popup caption='Kodeks Kara-Tur' text='Zapoznaj sie z prawami obowiazujacymi w tej krainie' fgcolor=$_OL.fg bgcolor=$_OL.bg textcolor=$_OL.text border=1 vauto=TRUE}>Kodeks Kara-Tur</a><br>
				- <a href="http://www.vilim.yoyo.pl/galeria/" {popup caption='Galeria Kara-Tur' text='Pokaz sie wszystkim oraz komentuj i oceniaj zdjecia innych' fgcolor=$_OL.fg bgcolor=$_OL.bg textcolor=$_OL.text border=1 vauto=TRUE}>Galeria Kara-Tur</a><br>
				- <a href="http://forum.karatur.pl/">Forum zewnetrzne</a><br>
				- <a href="forum.php?" {popup caption='Forum wewnetrzne' text='Napisz tu co spedza ci sen z powiek a na pewno wladcy postaraja sie w jakis sposob temu zaradzic' fgcolor=$_OL.fg bgcolor=$_OL.bg textcolor=$_OL.text border=1 vauto=TRUE}>Forum</a><br>
				<hr class="kt-line"/>
				<br>
				- <a href="map.php" {popup caption='Mapa Swiata' text='Spojrz na Swiat Kara-Tur' fgcolor=$_OL.fg bgcolor=$_OL.bg textcolor=$_OL.text border=1 vauto=TRUE}>Mapa Swiata</a><br><br>
				- <a href="account.php" {popup caption='Opcje konta' text='Zmien swoje ustwaienia' fgcolor=$_OL.fg bgcolor=$_OL.bg textcolor=$_OL.text border=1 vauto=TRUE}>Opcje konta</a><br>
				- <a href="logout.php?did={$Id}" {popup caption='Wylogowanie' text='Wroc do rzeczywistosci' fgcolor=$_OL.fg bgcolor=$_OL.bg textcolor=$_OL.text border=1 vauto=TRUE}>Wylogowanie</a><br>
				- <a href="help.php" {popup caption="Pomoc" text='Pomoc dla nowych graczy i nie tylko. Sa tu takze informacje jak polapac sie w nowosciach wprowadzonych na KT' fgcolor=$_OL.fg bgcolor=$_OL.bg textcolor=$_OL.text border=1 vauto=TRUE}>Pomoc</a><br><br>
				- <a href="panel.php">Panel Administracyjny</a><br><br>
	
<table class="table">
							<tr>
						<td class="thead">Pomóż nam</td>
							</tr>
							{section name=t loop=$Tops}
							{assign value=$Tops[t] var='Top'}
							<tr>
								<td style="position:relative;height:35px;text-align:center"><a href="out.php?id={$Top.id}" target="_blank">{$Top.entry}</a></td>
							</tr>
							{/section}
				</table>
			</div>
			<div class="sidebar_left-after"></div>
		</div>
		<div class="kt_main_nav">
			<div class="kt_main_nav-before"></div>
			<div class="kt_main_cont">
				<div style="text-align:center;font-size:1.5em">{$Title}</div>
						{if $Warn!=''}
							<div style="display:block; border-style: solid; border-color: #860102;text-align:center; width:90%">{$Warn}</div>
						{/if}
						{if $Info!=''}
							<div style="display:block; border-style: solid; border-color: #c58610;text-align:center; width:90%">{$Info}</div>
						{/if}