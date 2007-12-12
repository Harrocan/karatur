
{if $Action==''}
Panel rang<br><br>
<a href="rank.php?action=addrank">dodaj rangi</a><br>
<a href="rank.php?action=pl2rank">nadaj rangi graczom</a><br><br>
<table class="table">
{section name=r loop=$Userid}
	<tr><td colspan="3" class="thead" align="center"><img src="images/ranks/{$Userrankicon[r]}"> {$Userrank[r]}</td></tr>
	{section name=u loop=$Userid[r]}
		<tr><td>{$Userid[r][u]}</td><td width="200px">{$Username[r][u]}</td><form method="post" action="rank.php?plrnkdel"><td><input type="hidden" name="pid" value="{$Userid[r][u]}"><input type="submit" value="Usuñ"></td></form></tr>
	{/section}
{/section}
</table><br>
<table class="table">
<tr>
	<td colspan="5" class="thead" align="center">Rangi</td>
</tr>
{section name=ranks loop=$Rankname}
	<tr>
		<td align="center"><img src="images/ranks/{$Rankimage[ranks]}"></td>
		<td width="150px">{$Rankname[ranks]}</td>
		<td width="20px" style="background-color:{$Rankcolor[ranks]}">&nbsp;</td>
		<form method="post" action="rank.php?action=edit"><td><input type="hidden" name="id" value="{$Rankid[ranks]}"><input type="submit" value="Edytuj"></td></form>
		<form method="post" action="rank.php?action=delete"><td><input type="hidden" name="id" value="{$Rankid[ranks]}"><input type="submit" value="Usuñ"></td></form>
	</tr>
{/section}
</table>
{/if}
{if $Action=='addrank'}
	{*<table border="1">
	{section name=img loop=$Images}
		<tr>
			<td>
				{$Images[img]}
			</td>
			<td>
				<img src="images/ranks/{$Images[img]}">
			</td>
		</tr>
	{/section}
	</table>*}
	<br>Wype³nij wszystkie pola w celu dodania nowej rangi<br><br>
	<form method="post" action="rank.php?action=addrank">
	Nazwa rangi : <input type="text" name="nazwa"><br>
	Kolor rangi : <input type="text" name="color"> (w formie #FFFFFF, u¿ywany w karczmie) <br>
	Wybierz znaczek rangi : <br>
		{section name=img loop=$Images}
			<input type="radio" name="image" value="{$Images[img]}"><img src="images/ranks/{$Images[img]}">{if ($smarty.section.img.index+1)%10==0}<br>{/if}
		{/section}
	<br><input type="submit" value="Dodaj">
	</form>
{/if}
{if $Action=='edit'}
	<form method="post" action="rank.php?action=edit&step=edit">
	<input type="hidden" name="id" value="{$Id}"/>
	Nazwa rangi : <input type="text" name="name" value="{$Name}"/><br/>
	Kolor rangi : <input type="text" name="color" value="{$Color}"/> (w formie #FFFFFF, u¿ywany w karczmie) <br/>
	Wynagrodzenie : <input type="text" name="salary" value="{$Salary}"/><br/>
	Opis rangi : <br/>
	<textarea name="desc" style="width:100%;height:100px">{$Desc}</textarea><br/>
	Wybierz znaczek rangi : <br/>
		{section name=img1 loop=$Images}
			<input type="radio" name="image" value="{$Images[img1]}" {if $Sel==$smarty.section.img1.index}CHECKED{/if}/><img src="images/ranks/{$Images[img1]}"/>{if ($smarty.section.img1.index+1)%10==0}<br/>{/if}
		{/section}
	<br/><br/>Uprawnienia<br/>
	<input type="checkbox" name="rank[update]" value="1" {if $Rank.update==1}CHECKED{/if}/>Mo¿e dodawaæ wie¶ci<br>
	<input type="checkbox" name="rank[news]" value="1" {if $Rank.news==1}CHECKED{/if}>Mo¿e dodawaæ plotki<br>
	<input type="checkbox" name="rank[qmsg]" value="1" {if $Rank.qmsg==1}CHECKED{/if}>Mo¿e dodawaæ szybkie wiadomo¶ci<br>
	<input type="checkbox" name="rank[delete]" value="1" {if $Rank.delete==1}CHECKED{/if}>kasowanie graczy<br>
	<input type="checkbox" name="rank[cash]" value="1" {if $Rank.cash==1}CHECKED{/if}>dodawanie kasy<br>
	<input type="checkbox" name="rank[ranks]" value="1" {if $Rank.ranks==1}CHECKED{/if}>Zarz±dzanie rangami<br>
	<input type="checkbox" name="rank[rankprev]" value="1" {if $Rank.rankprev==1}CHECKED{/if}>Podgl±d rang<br>
	<input type="checkbox" name="rank[city]" value="1" {if $Rank.city==1}CHECKED{/if}>Edycja dostêpu w miastach<br>
	<input type="checkbox" name="rank[mapedit]" value="1" {if $Rank.mapedit==1}CHECKED{/if}>Edycja mapy<br>
	<input type="checkbox" name="rank[old]" value="1" {if $Rank.old==1}CHECKED{/if}>Przegl±danie starych kont<br>
	<input type="checkbox" name="rank[atribs]" value="1" {if $Rank.atribs==1}CHECKED{/if}>Edycja atrybutów<br>
	<input type="checkbox" name="rank[immu]" value="1" {if $Rank.immu==1}CHECKED{/if}>Nadawanie immunitetu<br>
	<input type="checkbox" name="rank[clearforum]" value="1" {if $Rank.clearforum==1}CHECKED{/if}>czyszczenie forum<br>
	<input type="checkbox" name="rank[clearchat]" value="1" {if $Rank.clearchat==1}CHECKED{/if}>czyszczenie czatu<br>
	<input type="checkbox" name="rank[ip]" value="1" {if $Rank.ip==1}CHECKED{/if}>lista IP<br>
	<input type="checkbox" name="rank[addeq]" value="1" {if $Rank.addeq==1}CHECKED{/if}>dodawnaie ekwipunku<br>
	<input type="checkbox" name="rank[addmon]" value="1" {if $Rank.addmon==1}CHECKED{/if}>dodawanie potworów<br>
	<input type="checkbox" name="rank[addkow]" value="1" {if $Rank.addkow==1}CHECKED{/if}>dodawanie planów<br>
	<input type="checkbox" name="rank[addsp]" value="1" {if $Rank.addsp==1}CHECKED{/if}>dodawanie czarów<br>
	<input type="checkbox" name="rank[mail]" value="1" {if $Rank.mail==1}CHECKED{/if}>wysy³anie poczty masowej<br>
	<input type="checkbox" name="rank[block]" value="1" {if $Rank.block==1}CHECKED{/if}>blokowanie na czacie<br>
	<input type="checkbox" name="rank[jail]" value="1" {if $Rank.jail==1}CHECKED{/if}>wrzucanie do wiêzienia<br>
	<input type="checkbox" name="rank[bridge]" value="1" {if $Rank.bridge==1}CHECKED{/if}>dodawanie pytañ na mo¶cie<br>
	<input type="checkbox" name="rank[email]" value="1" {if $Rank.email==1}CHECKED{/if}>wysy³anie mass-emaila<br>
	<input type="checkbox" name="rank[close]" value="1" {if $Rank.close==1}CHECKED{/if}>zamykanie krainy<br>
	<input type="checkbox" name="rank[ban]" value="1" {if $Rank.ban==1}CHECKED{/if}>banowanie graczy<br>
	<input type="checkbox" name="rank[priest]" value="1" {if $Rank.priest==1}CHECKED{/if}>udzielanie ¶lubów<br>
	<input type="checkbox" name="rank[clearlog]" value="1" {if $Rank.clearlog==1}CHECKED{/if}>czyszczenie dziennika<br>
	<input type="checkbox" name="rank[clearmail]" value="1" {if $Rank.clearmail==1}CHECKED{/if}>czyszczenie poczty<br>
	<input type="checkbox" name="rank[poll]" value="1" {if $Rank.poll==1}CHECKED{/if}>dodawanie sond<br>
	<input type="checkbox" name="rank[shop]" value="1" {if $Rank.shop==1}CHECKED{/if}>Tworzenie sklepów<br>
	<input type="checkbox" name="rank[edplayer]" value="1" {if $Rank.edplayer==1}CHECKED{/if}>Edycja u¿ytkowników<br>
	<input type="checkbox" name="rank[akta]" value="1" {if $Rank.akta==1}CHECKED{/if}>Przegl±danie akt s±dowych<br>
	<input type="checkbox" name="rank[form]" value="1" {if $Rank.form==1}CHECKED{/if}>Dostêp do zg³oszeñ graczy<br>
	<input type="checkbox" name="rank[edtown]" value="1" {if $Rank.edtown==1}CHECKED{/if}>Modyfikacja miast<br>
	<input type="checkbox" name="rank[double]" value="1" {if $Rank.double==1}CHECKED{/if}>Multikonta<br/>
	<input type="checkbox" name="rank[userdel]" value="1" {if $Rank.userdel==1}CHECKED{/if}/>Usuwanie gracza<br/>
	<input type="checkbox" name="rank[usersniff]" value="1" {if $Rank.usersniff==1}CHECKED{/if}/>Podglad gracza<br/>
	<input type="checkbox" name="rank[tribedel]" value="1" {if $Rank.tribedel==1}CHECKED{/if}/>Usuwanie klanu<br/>
	<input type="checkbox" name="rank[forum_adm]" value="1" {if $Rank.forum_adm==1}CHECKED{/if}/>Zarz±dzane forum<br/>
	<input type="checkbox" name="rank[moduleadd]" value="1" {if $Rank.moduleadd==1}CHECKED{/if}/>Tworzenie modow<br/>
	<input type="checkbox" name="rank[modulemanage]" value="1" {if $Rank.modulemanage==1}CHECKED{/if}/>Zarzadzanie modami<br/>
	<input type="checkbox" name="rank[changelog]" value="1" {if $Rank.changelog==1}CHECKED{/if}/>Dodawanie wpisow do rejestru zmian (wpisy typu 'zmiany w silnku KT')<br/>
	<input type="checkbox" name="rank[grant_citizen]" value="1" {if $Rank.grant_citizen==1}CHECKED{/if}/>Nadawanie statusu obywatela<br/>
	<input type="checkbox" name="rank[gamemaster]" value="1" {if $Rank.gamemaster==1}CHECKED{/if}/>Funkcja Mistrza Gry<br/>
	<input type="checkbox" name="rank[library]" value="1" {if $Rank.library==1}CHECKED{/if}/>Zarz±dzanie bibliotek±<br/>
	<input type="checkbox" name="rank[filer]" value="1" {if $Rank.filer==1}CHECKED{/if}/>Dostêp do Managera plików<br/>
	<input type="submit" value="Zmien">
	</form>
{/if}
{if $Action=='pl2rank'}
	<form method="post" action="rank.php?action=pl2rank">
	Podaj ID gracza : <input type="text" name="pid"><br>
	Wybierz rangê : <select name="ranga">
	{section name=pl loop=$Rankid}
		<option value="{$Rankid[pl]}">{$Rankname[pl]}
	{/section}
	</select><br>
	<input type="submit" value="Dodaj">
	</form>
{/if}