{if $action==''}
<table>
	<tr>
		<td width="300"> Nazwa przedmiotu </td>
		<td> cena </td>
		<td> ilosc kupna </td>
		<td> ilosc uzyc </td>
	</tr>
{section name=eq loop=$eq_name}
	<tr>
		<td align="right" width="300"> 
			{$eq_name[eq]} 
		</td>
		<td width="80" align="right"> 
			{$eq_price[eq]} 
		</td>
		<td width="80" align="right"> 
			{$eq_amau[eq]} 
		</td>
		<td width="80" align="right"> 
			{$eq_use[eq]}
		</td>
	</tr>
{/section}
</table>
<form method="post" action="drey.php?action=add">
	<input type="submit" value="Dodaj nowy przedmiot">
</form>
<form method="post" action="drey.php?action=edit1">
	<input type="submit" value="Edytuj przedmioty">
</from>
{$action}
{/if}

{if $action=='add'}
<table>
	<tr>
		<td width="200"> 
			Nazwa przedmiotu:
		</td>
		<td width="80"> 
			Cena:
		</td>
		<td width="80"> 
			Ilosc:
		</td>
		<td width="80"> 
			Uzycie:
		</td>
	</tr>
	<tr>
		<form method="post" action="drey.php?action=do">
			<td width="200"> <input type="text" name="nazwa"> </td>
			<td width="80"> <input type="text" name="cena"> </td>
			<td width="80"> <input type="text" name="ilosc"> </td>
			<td width="80"> <input type="text" name="uzyc"> </td>
			<tr><td> <input type="submit" value="Utwórz"> </td></tr>
		</form>
	</tr>
</table>
{/if}
{if $action=='do'}
{$nazwa}
<A HREF="http://karatur.ivan.netshock.pl/drey.php">Wroc do poczaku</A>
{/if}

{if $action=='edit1'}
Zaznacz przedmiot
<table>
<form method="POST" action="drey.php?action=edit2">
	{section name=eq loop="$id"}
		<tr>
			<td>
				<input type="radio" name="co" value="{$id[eq]}"> {$eq_name[eq]}
			</td>
		</tr>
	{/section}
	<tr><td>
		<input type="submit" value="Wybierz"></td>	
	</tr>
</form>
</table>
{/if}

{if $action=='edit2'}
<table>
	<form method="POST" action="drey.php?action=do_edit">
		<tr>
			<td width="300">Nazwa przedmitu:</td>
			<td>Cena:</td>
			<td>ilosc:</td>
			<td>U¿yc:</td>
		</tr>
		<tr>
			<td width="300"><input type="text" name="nazwa" value="{$keq_name}"></td>
			<td><input type="text" name="cena" value="{$keq_price}"></td>
			<td><input type="text" name="ilosc" value="{$keq_amau}"></td>
			<td><input type="text" name="uzyc" value="{$keq_use}"></td>
		</tr>
	<tr>
		<td><input type="submit" value="Popraw"></td>
		<td><input type="hidden" name="id" value="{$id}"></td>
	</tr>
	</form>
</table>
{/if}
{if $action=='do_edit'}
	{$id}
{/if}


























