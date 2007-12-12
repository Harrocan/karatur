<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>{$Gamename} :: {$Title}</title>
<link rel="stylesheet" href="css/lucass.css">
<link rel="shortcut icon" href="images/ikonka_KT.gif" type="image/gif">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2"> {*utf-8*}
</head>

<body onload="window.status='{$Gamename}'" style="margin:0px">

	<center>
	<div id="overDiv" style="position:absolute; visibility:hide;"></div>
	<Script language="JavaScript" src="overlib.js"></script>
	
	<table width="760" class="td" cellpadding="0" cellspacing="0">
		<tr>
			<td colspan="3" valign="top" align="center" bgcolor="black">
				<img src="images/tmp/logo.jpg" border="0">
			</td>
		</tr>
		<tr>
			<td colspan="3" valign="top" align="center" bgcolor="black" style="border-bottom-style:solid; border-top-style:solid; border-width:thin;">
				<a href="stats.php" {popup caption='Statystyki' text='Zobacz swoje statystyki' fgcolor=$Overfg bgcolor=$Overbg border=1 vauto=TRUE}>Statystyki</a> | 
				<a href="zloto.php" {popup caption='Bogacta' text='Sprawdz ile posiadasz pieniedzy, mineralow, ziol' fgcolor=$Overfg bgcolor=$Overbg border=1 vauto=TRUE}>Bogactwa</a> | 
				<a href="equip.php" {popup caption='Ekwipunek' text='Tutaj znajdziesz wszystkie swoje przedmioty' fgcolor=$Overfg bgcolor=$Overbg border=1 vauto=TRUE}>Ekwipunek</a> | 
				{$Spells} | 
				<a href="log.php" {popup caption='Dziennik' text='Wydarzenia zwiazane z twoja postacia' fgcolor=$Overfg bgcolor=$Overbg border=1 vauto=TRUE}>{if $Numlog>0}<div style="display:inline; color:#FF0000">Dziennik [{$Numlog}]</div>{else}Dziennik{/if} </a>| 
				<a href="updates.php" {popup caption="Wiesci" text='Aktualne wydazenia i wazne wiesci' fgcolor=$Overfg bgcolor=$Overbg border=1 vauto=TRUE}>Wieści</a> |
				<a href="notatnik.php" {popup caption="Notatnik" text='Tutaj mozesz zapisac sobie wszystkie informacje i nikt nie bedzie mial do nich wgladu' fgcolor=$Overfg bgcolor=$Overbg border=1 vauto=TRUE}>Notatnik</a> |
				<a href="mail.php" {popup caption='Poczta' text='Sprawdz kto ma dla Ciebie informacje do przekazania' fgcolor=$Overfg bgcolor=$Overbg border=1 vauto=TRUE}>{if $Unread>0}<div style="display:inline; color:#FF0000">Poczta [{$Unread}]</div>{else}Poczta{/if}</a> |
				<a href="chat.php" {popup caption='Karczma' text='Wejdz do Karczmy pod Bialym Koniem i napij sie najlepszego piwa krasnoludzkiego z piana na dwa palce' fgcolor=$Overfg bgcolor=$Overbg border=1 vauto=TRUE}>Karczma [{$Players}]</a> |
				<a href="mapa.php" {popup caption='Mapa' text='Wyrusz na wędrówkę w nieznane. Gdzie poniosą Cię nogi ?' fgcolor=$Overfg bgcolor=$Overbg border=1 vauto=TRUE}>Wędrówka</a> |
				{$Tribe}
			</td>
		</tr>
		<tr>
			<td valign="top" width="100px">
				<table cellpadding="0" cellspacing="0" class="td" width="100%">
					<tr>
						<td>
							<center><b><i>{$Name}</i></b> ({$Id})</center><br>
							<b>Poziom:</b> {$Level}<br>
							<img src="imgbar.php?type=E&stat=PD&width=140&total={$Expneed}&cur={$Exp}" style="margin-top:5px"><br>
							<img src="imgbar.php?type=L&stat=Życie&width=140&total={$Maxhealth}&cur={$Health}" style="margin-top:5px"><br>
							<img src="imgbar.php?type=M&stat=Mana&width=140&total={$Maxmana}&cur={$Mana}" style="margin-top:5px"><br>
							<b>Energia:</b> {$Energy}/{$Maxenergy}<br>
							{if isset($Krewka)}
							<img src="imgbar.php?type=K&stat=Krew&width=140&total={$Krewka_m}&cur={$Krewka}" style="margin-top:5px">{/if}
							<b>Zloto:</b> {$Gold}<br>
							<b>W banku:</b> {$Bank}<br>
						</td>
					</tr>
				</table>
				<br>
				<table cellpadding="0" cellspacing="0" class="td" width="100%">
				<tr>
					<td bgcolor="black" align="center">
						<b>Nawigacja</b>
					</td>
				</tr>
				<tr>
					<td>
						- <a href="plany.php" {popup caption="Plany KTT" text='Przeczytaj co te planujemy zrobic z waszym kochanym, poczciwym i prostym Kara-Tur\'em ... to ju nie bedzie ta sama gra ... kiedys ...' fgcolor=$Overfg bgcolor=$Overbg border=1 vauto=TRUE}>Plany KTT</a>
						<br>
						{if isset($Formlink)}{$Formlink}{/if}
						- <a href="bugtrack.php">Bugtrack ({$Numbugs})</a>
						<br>
						- <a href="changelog.php" {popup caption="Rejestr zmian" text='Zastanawiasz sie co sie dzieje z gra ? Tutaj znajduje sie aktualizowany na bierzaco rejestr zmian - zagladaj czesto !' fgcolor=$Overfg bgcolor=$Overbg border=1 vauto=TRUE}>Rejestr zmian</a><br>
						<hr><br>
						- <a href="info.php" {popup caption='Formularz zgloszeniowy' text="Jesli uwazasz ze jakas sprawa potrzebuje naglego zgloszenia do wladcow i chcesz by byla jak nasjszybciej rozpatrzona to wypelnij formularz i napisz wszystkie problemy ktore cie gnebia" fgcolor=$Overfg bgcolor=$Overbg border=1 vauto=TRUE}>Formularz zgłoszeniowy</a><br>		
						- <a href="prawa.php" {popup caption='Kodeks Kara-Tur' text='Zapoznaj sie z prawami obowiazujacymi w tej krainie' fgcolor=$Overfg bgcolor=$Overbg border=1 vauto=TRUE}>Kodeks Kara-Tur</a><br>
						- <a href="http://www.vilim.yoyo.pl/galeria/" {popup caption='Galeria Kara-Tur' text='Pokaz sie wszystkim oraz komentuj i oceniaj zdjecia innych' fgcolor=$Overfg bgcolor=$Overbg border=1 vauto=TRUE}>Galeria Kara-Tur</a><br>
						- <a href="http://www.karatur.fora.pl/index.php">Forum zewnetrzne</a><br>
						- <a href="forum.php?" {popup caption='Forum wewnetrzne' text='Napisz tu co spedza ci sen z powiek a na pewno wladcy postaraja sie w jakis sposob temu zaradzic' fgcolor=$Overfg bgcolor=$Overbg border=1 vauto=TRUE}>Forum</a><br><hr><br>
						- <a href="map.php" {popup caption='Mapa Swiata' text='Spojrz na Swiat Kara-Tur' fgcolor=$Overfg bgcolor=$Overbg border=1 vauto=TRUE}>Mapa Swiata</a><br><br>
						- <a href="account.php" {popup caption='Opcje konta' text='Zmien swoje ustwaienia' fgcolor=$Overfg bgcolor=$Overbg border=1 vauto=TRUE}>Opcje konta</a><br>
						- <a href="logout.php?did={$Id}" {popup caption='Galeria Kara-Tur' text='Wroc do rzeczywistosci' fgcolor=$Overfg bgcolor=$Overbg border=1 vauto=TRUE}>Wylogowanie</a><br>
						- <a href="help.php" {popup caption="Pomoc" text='Pomoc dla nowych graczy i nie tylko. Sa tu takze informacje jak polapac sie w nowosciach wprowadzonych na KT' fgcolor=$Overfg bgcolor=$Overbg border=1 vauto=TRUE}>Pomoc</a><br><br>
						- <a href="panel.php">Panel Administracyjny</a><br><br>
						<table class="table">
							<tr>
								<td class="thead">Pomóż nam</td>
							</tr>
							<tr>
								<td align="center"><a href="out.php?id=2" target="_blank"><img src="http://www.graveyard.boo.pl/button2.jpg" width=100 height=50 border=0 alt="CMENTARZYSKO.tk RANKING - RPG/cRPG/MMORPG"></a></td>
							</tr>
							<tr>
								<td align="center"><a href="out.php?id=3" target="_blank"><img src="http://www.gra24h.pl/dodatki/buton_rpg_najlepsze.gif" width=80 height=60 border=0 alt="Najlepsze strony powiďż˝one RPG, cRPG i Fantasy"></a></td>
							</tr>
							<tr>
								<td height="35px" align="center"><a href="out.php?id=5" target="_blank"><SPAN style="width:100px;height:12px;overflow:hidden;background:#EEEE00;border:2px;border-color:#FFFF22;border-style:outset;padding:5px;font:bold 11px verdana;color:black;text-decoration:none;text-align:center;cursor:pointer">TopLista RPG</SPAN></a></td>
							</tr>
							<tr>
								<td height="35px" align="center"><a href="out.php?id=6" target="_blank"><SPAN style="width:120px;height:50px;overflow:hidden;background:#000000;border:5px;border-color:#FFFF00;border-style:outset;padding:5px;font:bold 11px verdana;color:#FF0000;text-decoration:none;text-align:center;cursor:hand">GRY ONLINE</SPAN></a></td>
							</tr>
							<tr>
								<td align="center"><a href="out.php?id=7" target="_blank"><img src="http://gameshow.pl/lista.jpg" width=120 height=40 border=0 alt="TOP GRY ONLINE"></a></td>
							</tr>
							<tr>
								<td align="center"><a href="out.php?id=8" target="_blank">Toplista RPG i Fantasy</a></td>
							</tr>
							<tr>
								<td align="center"><a href="out.php?id=9" target="_blank">Toplista Bastionu Fantasy</a></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
		<td width="500" valign="top"><br>
			<table cellpadding="0" cellspacing="0" class="td" width="95%" heigth="100%" align="center">
				<tr>
					<td bgcolor="black" align="center" style="border-style: solid solid none solid; border-width:thin;">
						{$Title}
						{if $Warn!=''}
							<div style="display:block; border-style: solid; border-color: #860102;text-align:center; width:90%">{$Warn}</div>
						{/if}
						{if $Info!=''}
							<div style="display:block; border-style: solid; border-color: #c58610;text-align:center; width:90%">{$Info}</div>
						{/if}
					</td>
				</tr>
				<tr>
					<td style="border-style: none solid solid solid; border-width:thin; padding: 0px 10px; height:90%">
	

