<b>{$Sname}</b><br>
	{if $Sopis==''}Witaj w naszych progach. Zapoznaj siê z nasz± ofert± :
	{else} {$Sopis}
	{/if}
	<br>
	<ul>
	{if isset($Types.W)}<li><a href="?sid={$Sid}&view=W">Bronie</a><br>{/if}
	{if isset($Types.S)}<li><a href="?sid={$Sid}&view=S">Ró¿dzki</a><br>{/if}
	{if isset($Types.B)}<li><a href="?sid={$Sid}&view=B">£uki</a><br>{/if}
	{if isset($Types.R)}<li><a href="?sid={$Sid}&view=R">Strza³y</a><br>{/if}
	{if isset($Types.H)}<li><a href="?sid={$Sid}&view=H">He³my</a><br>{/if}
	{if isset($Types.A)}<li><a href="?sid={$Sid}&view=A">Pancerze</a><br>{/if}
	{if isset($Types.D)}<li><a href="?sid={$Sid}&view=D">Tarcze</a><br>{/if}
	{if isset($Types.N)}<li><a href="?sid={$Sid}&view=N">Nagolenniki</a><br>{/if}
	{if isset($Types.Z)}<li><a href="?sid={$Sid}&view=Z">Szaty</a><br>{/if}
	</ul>
<br>
{if $View != '' }
	{section name=i loop=$Wares}
		{assign var='Item' value=$Wares[i]}
		{capture name=pop assign=popText}<table border=0 cellpadding=0 cellspacing=0><tr><td rowspan=10><img src='itemimage.php?path={$Item.imglink}&wt={$Item.wt}&maxwt={$Item.maxwt}&type={$Item.type}' alt='image'></td><td><b>{$Item.name}</b></td></tr><tr><td>Min. poziom: {$Item.minlev}</td></tr>{if $Item.type!='S' && $Item.type!='Z'}<tr><td>Wytrzymalosc: {$Item.wt}/{$Item.maxwt}</td></tr>{/if}<tr><td>Moc: +{$Item.power} {$Suff}</td></tr>{if $Item.zr!=0}<tr><td>-{$Item.zr} %zrecznosci</td></tr>{/if}{if $Item.szyb!=0}<tr><td>+{$Item.szyb} %szybkosci</td></tr>{/if}</table><b>Opcje</b><br><a href='?sid={$Sid}&view={$View}&iid={$Item.id}'>kup</a> za {$Item.cost} sztuk zlota{/capture}
		<a href='?sid={$Sid}&view={$View}&iid={$Item.id}' {popup caption=' ' closetext='zamknij' text=$popText fgcolor=$Overfg bgcolor=$Overbg border=1 sticky=TRUE vauto=TRUE}><img src='itemimage.php?path={$Item.imglink}&wt={$Item.wt}&maxwt={$Item.maxwt}&type={$Item.type}' alt='image'></a> 
	{/section}<br>
	{if $Iid != '' }
	<form method="post" action="?sid={$Sid}&iid={$Iid}">
	Kupujesz <b>{$Itemname}</b><br>
	Podaj ilosc: <input type=text name="amount" value="1" style="width:30px"> <input type="submit" value="kup !"><br>
	</form>
	{/if}
	<br>
	<a href="?sid={$Sid}">Wróc ...</a>
{/if}