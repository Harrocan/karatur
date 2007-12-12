{if $Action != "haslo"}
    Jezeli zapomniales hasla do swojej postaci, wpisz tutaj swoj adres email. Jednak ze wzgledu na to, ze hasla w bazie danych sa kodowane, niemozliwe jest odzyskanie twojego starego hasla. Dlatego dostaniesz nowe haslo. Jezeli twoje konto istnieje, informacja o hasle zostanie wyslana pod podany mail. <b>Uwaga!</b> jezeli masz na swoim koncie wlaczony filtr anty-spamowy, wylacz go przed wyslaniem maila, inaczej informacja o hasle nie dojdzie do ciebie!
    <center>
	<form method=post action=index.php?step=lostpasswd&action=haslo>
	<table>
	<tr><td>Email:</td><td><input type="text" name="email"></td></tr>
	<tr><td colspan="2" align="center"><input type="submit" value="Wyslij"></td></tr>
	</table>
	</form>
	</center>
{/if}

{if $Action == "haslo"}
    <center><br><br>Mail z haslem zostal wyslany na podany adres e-mail</center>
{/if}