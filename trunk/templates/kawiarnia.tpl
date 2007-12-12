{if $Step == ""}
Wchodzisz po pieknych, œwiezo mytych stopniach karczmy, prosto do znajduj¹cego sie tam barku . Wchodzisz do srodka i rozgladajac sie chwile po ludnosci znajdujacej sie w pomieszczeniu podchodzisz do kelnera i pytasz sie go
co ma do zaoferowania. On proponuje Ci:
<br><br>
<center><b></b>Kawy:<br><br>
<a href="kawiarnia.php?step=wybierz&type=kawa&what=mk">Mala Kawa</a><br>
Cena: {$Cost.kawa.mk.cost}<br>
<a href="kawiarnia.php?step=wybierz&type=kawa&what=sk">Srednia Kawa</a><br>
Cena: {$Cost.kawa.sk.cost}<br>
<a href="kawiarnia.php?step=wybierz&type=kawa&what=dk">Duza Kawa</a><br>
Cena: {$Cost.kawa.dk.cost}<br>
<br><br>----------------------------<br>Ciasta:<br><br>
<a href="kawiarnia.php?step=wybierz&type=ciasto&what=ser">Sernik</a><br>
Cena: {$Cost.ciasto.ser.cost}<br>
<a href="kawiarnia.php?step=wybierz&type=ciasto&what=pw">Pijana Wisnia</a><br>
Cena: {$Cost.ciasto.pw.cost}<br>
<br>-----------------------------<br>Herbaty:<br><br>
<a href="kawiarnia.php?step=wybierz&type=herbata&what=zh">Zielona Herbata</a><br>
Cena: {$Cost.herbata.zh.cost}<br>
<a href="kawiarnia.php?step=wybierz&type=herbata&what=ch">Czerwona Herbata</a><br>
Cena: {$Cost.herbata.ck.cost}<br>
<a href="kawiarnia.php?step=wybierz&type=herbata&what=hzw">Herbata z Wodka</a><br>
Cena: {$Cost.herbata.hzw.cost}<br>
<br>-----------------------------<br><br>Napoje Alkoholowe:<br><br>
<a href="kawiarnia.php?step=wybierz&type=alkohol&what=sz">Szampan</a><br>
Cena: {$Cost.alkohol.sz.cost}<br>
<a href="kawiarnia.php?step=wybierz&type=alkohol&what=wi">Wino</a><br>
Cena: {$Cost.alkohol.wi.cost}<br>
<a href="kawiarnia.php?step=wybierz&type=alkohol&what=pi">Piwo</a><br>
Cena: {$Cost.alkohol.pi.cost}<br>
<a href="kawiarnia.php?step=wybierz&type=alkohol&what=wo">Wodka</a><br>
Cena: {$Cost.alkohol.wo.cost}<br></center>
{elseif $Step == 'wybierz'}
	Za {$Jedn} {$Item.what} zaplacisz {$Item.cost}, za co twa energia wzorsnie o {$Item.energy}.
	<br><br><br>
    <center><form method="post" action="kawiarnia.php?step=kup&type={$Type}&what={$What}">
    <input type="submit" value="Kup"><br><br><br>
    (<a href="kawiarnia.php">Wroc</a>)</center>
{else}
{/if}
<br>
Mozesz zawsze <a href="chat.php">wrocic</a>
