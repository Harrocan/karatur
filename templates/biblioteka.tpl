<link rel="stylesheet" href="css/bibl.css">
<script language="JavaScript" src="js/chat.js"></script>
<table>
{if ($Step=='') && ($Text=='') && ($Action=='')}
<tr><td>
	<br><br> <center> Maiczne drzwi otwieraja sie przed toba, wchodzisz do srodka i od razu w drzwiach wita Cie starzec: <i>Witaj w naszej biblioterce wedrowcze, tedy...</i> 
			Meszczyzna wskazuje Ci droge i znika. Idziesz dalej wskazanym korytarzem, podziwaisz antyki rzezb i obrazow, wszystko wydaje sie tu wiekowe mimo to zachowalo sie w calkiem dobrym stanie.
			<i>Witaj. </i>Ku twojemu zdziwieniu nagle kolejny z starzec staje przed Toba i z rowna uprzejmoscia wskazuje na wielkie pomieszczenie.
			Sala jest majestatyczna a wszedzie stoja kilkumetrowe regaly pelne ksiazek, drabinki prowadzace na wyzsze pietra zdaja sie prowadzic w nieskonczonoc, i znikac w magicznej mgle unoszacej sie nad sklepieniem sufitu, który nie wiadomo czy wogole istnieje.
			Nagle uwage twoje przykuwaja trzy postacie, dwie z nich juz spotkales idac tu, otaczaja trzeciego, zdaje sie najstarszego...:
			<i>Witaj, byc moze tu znajdziejsz to czego szukasz...Jestesmy Magami-Straznikami tej wiedzy i przewodnikami labiryntu biblioteki, rozgladaj sie dowoli.<br><br>
			Moze znajdziesz tu cos ciekawego dla sibie ostatnio pojawi³o sie kilka nowcyh prac, miedzy innymi:
			{section name=new loop=$News}
				<a href="biblioteka.php?text={$News[new].id}">{$News[new].title}</a>,
			{/section} i inne
			</i></center><br><br>
</td></tr>
<tr><td>
<table align="center">
<tr>
<div class="tekst">
	{section name=type loop=$Data}
	{assign value='-1' var=pop}
	{assign value='1' var=nast}
	<td>
	<div class="bibl-menu">
		{$Type[type]}
		<div class="bibl-list">
		<div class="bibl-roll3"></div>
		{section name=tab loop=$Data[type]}
			{if ($pop=='-1') || ($Data[type][$pop].author!=$Data[type][tab].author)}
			<div class="bibl-autor">
			<a href="view.php?view={$Data[type][tab].aid}">{$Data[type][tab].author}</a>
			<div class="bibl-title-list">
			<div class="bibl-roll4"></div>
			{/if}
				<div class="bibl-title">
				<a href="biblioteka.php?text={$Data[type][tab].id}">{$Data[type][tab].title}<br/></a>
				</div>
			{if (!isset($Data[type][$nast].author)) || ($Data[type][$nast].author!=$Data[type][tab].author)}
			<div class="bibl-roll2"></div>
			</div>
			</div>
			{/if}
			{assign value=$smarty.section.tab.index var=pop}
			{assign value=$smarty.section.tab.index+2 var=nast}
		{/section}
		<div class="bibl-roll"></div>
		</div>
	</div>
	</td>
	{/section}
	<td>
	<div class="bibl-menu">
		Dodaj
		<div class="bibl-list">
		<div class="bibl-roll3"></div>
		<div class="bibl-autor"><a href="biblioteka.php?step=rules">Zasady</a></div>
		<div class="bibl-autor"><a href="biblioteka.php?step=add">Napisz Prace</a></div>
		<div class="bibl-roll"></div>
		</div>
	</div>
	</td>
	{if $Rank}
	<td>
	<div class="bibl-menu">
		Sprawdzaj
		<div class="bibl-list">
		<div class="bibl-roll3"></div>
		{section name=spr loop=$Bibl}
			<div class="bibl-autor"><a href="biblioteka.php?action=modify&text={$Bibl[spr].id}">{$Bibl[spr].title}</a></div>
		{/section}
		{if !isset($Bibl[0])}
		<div class="bibl-autor">Pusto...</div>
		{/if}
		<div class="bibl-roll"></div>
		</div>
	</div>
	</td>
	{/if}
</tr>
</table>
</td></tr>
<tr><td>
	<table width="100%">
	<tr><td>
		<table class="table" width="100%">
		<tr><td class="thead"><b>Ostatnio Komentowane</b></td></tr>
		{section name=last loop=$Lastcom}
			<tr><td><a href="?text={$Lastcom[last].id}">-={$Lastcom[last].title}=-</a><br>
			skomentowa³(a)<br>
			{$Lastcom[last].author}</td></tr>
		{/section}
		</table>
	</td>
	<td valign=top>
		<table class="table" width="100%" style="valign:top;">
		<tr><td class="thead" colspan="3" align="center"><div style="font-size:16;"><b>TOp 5</b></div></td></tr>
		<tr><td colspan="3"></td></tr>
		<tr><td class="thead" align="center">Ocena</td>
		<td class="thead" align="center">G³osów</td>
		<td class="thead" align="center">Praca</td>
		{section name=top loop=$Best}
			<tr><td align="center"><div style="font-size:14">{$Best[top].vote}</div></td>
			<td align="center"><div style="font-size:14">{$Best[top].count}</div></td>
			<td><a href="?text={$Best[top].id}">{$Best[top].title}</a><br>
			<b>{$Best[top].author}</b></td></tr>
		{/section}
		</table>
	</td></tr>
	</table>
</td></tr>
{/if}
{if $Step == "rules"}
    <br/>
	<ul>
    	<li>1.Nie nalezy przeklinac w Tekstach, chyba ze zostanie to zezwolone przez Wladce lub s³owa u¿yte, choc nieco wulgarne nadaja sens wypowiedzi.<br>
    	<li>2.Prace maja byc tresciwe i tak napisane aby dalo sie je odczytac.<br>
    	<li>3.Niewolno obrazac w jakimkolwiek utworze innego gracza.<br>
	</ul>
{/if}
{if $Step == "add"}
    Tutaj mozesz oddac swoja prace<br /><br />
    <form method="post" action="biblioteka.php?step=add&amp;step2=add">
        Rodzaj: <select name="type">
                <option value="Opowiadanie">Opowiadanie</option>
		<option value="Poezja">Poezja</option>
        </select><br />
        Tytul: <input type="text" name="title" /><br />
        Zawartosc: <br /><textarea name="body" rows="30" cols="60"></textarea><br />
        <input type="submit" value="Dodaj" />
    </form>
{/if}
{if $Text != ""}
        {if $Rank}
            (<a href="biblioteka.php?action=modify&amp;text={$Tekst.id}">Modyfikuj</a>)<br />
        {/if}
        <b>Autor</b>:<a href="view.php?view={$Tekst.aid}">{$Tekst.author}</a><br />
        <b>Tytul</b>:{$Tekst.title}<br />
        <b>Tresc</b>:<br />
        {$Tekst.body}<br /><br/><br/>
	{if $Vote == 'N'}
	<form action="biblioteka.php?action=vote" method="POST">
	<center>
	<label><input type="radio" name="vote" checked="checked" value=1> 1 </label>
	<label><input type="radio" name="vote" value=2> 2 </label>
	<label><input type="radio" name="vote" value=3> 3 </label>
	<label><input type="radio" name="vote" value=4> 4 </label>
	<label><input type="radio" name="vote" value=5> 5 </label>
	<input type="hidden" name="text" value={$Tekst.id}>
	<input type="submit" value="Oceñ ta Prace">
	</form><br>{/if}
	{if $Vote == 'T'}
	<b>Ocena tej pracy:  {$Points}</b>
	{/if}
	<div id="chatHelp">
		<div id="chatHelpTop" onclick="chatHelpSwitch('show')" class="mailMore">
			Komentarze({$TComments})
		</div>
		<form method="POST" action="biblioteka.php?step=addcom">
		<div id="chatHelpText" style="display:none">
			<ul type="square">
			{section name=kom loop=$Comm}
				<div style="margin: 10px; float:left;"><li><b>Autor komentarza:</b><a href="view.php?view={$Comm[kom].acid}"> {$Comm[kom].author}</a></li></div>
				{if ($Rank) || ($Player==$Comm[kom].acid)}
					<div style="margin: 10px; float:right;">(<a href="biblioteka.php?step=usun&com={$Comm[kom].id}&aid={$Comm[kom].acid}">Usun</a>)</div>
				{/if}
				<div style="margin: 10px; margin-left:20px; margin-right:20px; clear:left;">{$Comm[kom].body}</div>
			{/section}
			</ul>
			<div style="margin: 10px; clear:left; margin-left:20px;">
			<br/>Skomentuj ta prace:<br/>
			<input type="hidden" name="cid" value={$Tekst.id}/>
			<textarea name="body" rows="1" cols="60"></textarea><br/>
			<input type="submit" value="Dodaj"/>
			</div>
			<div class="mailMore" onclick="chatHelpSwitch('hide')">Schowaj</div>
		</div>
		</form>
	</div>
{/if}
{if $Action == "modify"}
<tr><td>
<form method="post" action="biblioteka.php?action=modify">
<b>Autor: </b><a href=view.php?view={$Tekst.aid}>{$Tekst.author}</a><br><br>
<b>Opcje: </b> 
<table><tr>
	<td><input type="submit" name="mod" value="Modyfikuj"></td>
	<td><input type="submit" name="mod" value="Modyfikuj i Dodaj"></td>
	<td><input type="submit" name="mod" value="Usun Prace"></td>
</tr></table>
<br/>
    <b>Typ: </b><select name="type">
        <option value="tale" {if $Tekst.type == "tale"} selected="true" {/if}>Opowiadanie</option>
        <option value="poetry" {if $Tekst.type == "poetry"} selected="true" {/if}>Poezja</option>
    </select>
    <input type="hidden" name="id" value="{$Tekst.id}"/><br/>
    <b>Tytul: </b><input type="text" name="title" value="{$Tekst.title}"/><br/>
    <b>Tresc: </b><br /><textarea name="body" rows="30" cols="60">{$Tekst.body}</textarea><br />
<br>
<b>Opcje: </b>
<table><tr>
	<td><input type="submit" name="mod" value="Modyfikuj"></td>
	<td><input type="submit" name="mod" value="Modyfikuj i Dodaj"></td>
	<td><input type="submit" name="mod" value="Usun Prace"></td>
</tr></table>
</form>
</td></tr>
{/if}
{if ($Step!='') || ($Text!='') || ($Action!='')}
<tr><td>
<br/><br/>Kliknij tu aby <a href="biblioteka.php">zawrocic</a>..
</td></tr>
{/if}
</table>