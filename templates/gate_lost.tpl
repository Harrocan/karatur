<div>
    {if $PassStep == 'done'}
    Zmiana has�a przebieg�a pomy�lnie. Na adres mailowy podany na poprzedniej stronie zosta�a wys�ana wiadomo�� z twoim nowym has�em. Sprawd� swoj� poczt�.
    {else}
    Jezeli zapomniales hasla do swojej postaci, wpisz tutaj swoj adres email. Jednak ze wzgledu na to, ze hasla w bazie danych sa kodowane, niemozliwe jest odzyskanie twojego starego hasla. Dlatego dostaniesz nowe haslo. Jezeli twoje konto istnieje, informacja o hasle zostanie wyslana pod podany mail.
    <br/>
    <b>Uwaga!</b>
    jezeli masz na swoim koncie wlaczony filtr anty-spamowy, wylacz go przed wyslaniem maila, inaczej informacja o hasle mo�e do Ciebie nie doj��
    <center>
        <form method=post action="?step=lostpasswd&action=haslo">
            <table>
                <tr>
                    <td>Email:</td>
                    <td><input type="text" name="email"></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><input type="submit" value="Wyslij"></td>
                </tr>
            </table>
        </form>
    </center>
	{/if}
</div>