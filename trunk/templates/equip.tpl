{if !empty($Poison)}
	Zatruwanie<br>
	Wybierz bron : 
	<form method="post" action="?poison={$Poison}&step=poison">
	<select name="wpn">
	{foreach from=$Items item=Wpn key=Key}
		<option value="{$Wpn.id}">(ilosc: {$Wpn.amount}){$Wpn.prefix} {$Wpn.name}
	{/foreach}
	</select><br>
	<input type="submit" value="Zatruj !">
	<form>
	<br><br>
{/if}

<u>Obecnie uzywane przedmioty</u>:<br>
{*
{if isset( $Equip.weapon )}<b>Bron:</b> {/if}
{if isset( $Equip.armor )} zbroja{/if}
*}
{*foreach from=$Equip item='Item' key='Key'}
	
	{capture name=text assign=Text}<a href="#" {popup caption=' ' closetext='zamknij' text=$Item.popText fgcolor=$Overfg bgcolor=$Overbg border=1 sticky=TRUE vauto=TRUE}">{if isset($Item.imglink)}<img src={$Item.imglink} alt="image">{else}<img src=images/items/na.gif alt="image">{/if}{$Item.prefix} {$Item.name}</a>{/capture}
	
	<b>{$Item.catname}</b>: {$Text} <br>
{foreachelse}
	Brak noszonych przedmiotow<br>
{/foreach*}
<table border=0 align=center>
	<tr>
		<td colspan=3 align=center>Noszony ekwipunek</td>
	</tr>
	<tr>
		<td></td>
		<td>
			{if isset($Equip.helm)}
				<a href="#" {popup caption=' ' closetext='zamknij' text=$Equip.helm.popText fgcolor=$Overfg bgcolor=$Overbg border=1 sticky=TRUE vauto=TRUE}">
					<img src='itemimage.php?path={$Equip.helm.imglink}&wt={$Equip.helm.wt}&maxwt={$Equip.helm.maxwt}&magic={$Equip.helm.magic}' alt="image">
				</a>
			{else}
				<img src=images/items/none.gif>
			{/if}
		</td>
		<td></td>
	</tr>
	<tr>
		<td>
			{if isset($Equip.weapon)}
				<a href="#" {popup caption=' ' closetext='zamknij' text=$Equip.weapon.popText fgcolor=$Overfg bgcolor=$Overbg border=1 sticky=TRUE vauto=TRUE}">
					<img src='itemimage.php?path={$Equip.weapon.imglink}&wt={$Equip.weapon.wt}&maxwt={$Equip.weapon.maxwt}&type={$Equip.weapon.type}&magic={$Equip.weapon.magic}&poison={$Equip.weapon.poison}' alt="image">
				</a>
			{else}
				<img src=images/items/none.gif>
			{/if}
		</td>
		<td>
			{if isset($Equip.armor)} <a href="#" {popup caption=' ' closetext='zamknij' text=$Equip.armor.popText fgcolor=$Overfg bgcolor=$Overbg border=1 sticky=TRUE vauto=TRUE}"><img src='itemimage.php?path={$Equip.armor.imglink}&wt={$Equip.armor.wt}&maxwt={$Equip.armor.maxwt}&type={$Equip.armor.type}&magic={$Equip.armor.magic}' alt="image">{else}<img src=images/items/none.gif>{/if}
		</td>
		<td>
			{if isset($Equip.arrows)}
				{assign var=EquipSecond value=$Equip.arrows}
			{elseif isset($Equip.shield)}
				{assign var=EquipSecond value=$Equip.shield}
			{/if}
			{if isset($EquipSecond)}
				<a href="#" {popup caption=' ' closetext='zamknij' text=$EquipSecond.popText fgcolor=$Overfg bgcolor=$Overbg border=1 sticky=TRUE vauto=TRUE}"><img src='itemimage.php?path={$EquipSecond.imglink}&wt={$EquipSecond.wt}&maxwt={$EquipSecond.maxwt}&type={$EquipSecond.type}&magic={$Equip.second.magic}' alt="image">
			</a>
			{else}
				<img src=images/items/none.gif>
			{/if}
		</td>
	</tr>
	<tr>
		<td></td>
		<td>
			{if isset($Equip.knee)}
				<a href="#" {popup caption=' ' closetext='zamknij' text=$Equip.knee.popText fgcolor=$Overfg bgcolor=$Overbg border=1 sticky=TRUE vauto=TRUE}">
					<img src='itemimage.php?path={$Equip.knee.imglink}&wt={$Equip.knee.wt}&maxwt={$Equip.knee.maxwt}&magic={$Equip.knee.magic}' alt="image">
				</a>
			{else}
				<img src=images/items/none.gif>
			{/if}
		</td>
		<td></td>
	</tr>
	<tr>
		<td colspan=3><a href="?repair=use">Napraw uzywane</a></td>
	</tr>
</table>
<br />
{*
<table class="table" width="100%">
	<tr>
		<td class="thead">Szt.</td>
		<td class="thead">Nazwa</td>
		<td class="thead">Moc</td>
		<td class="thead">Wytrz.</td>
	</td>
{section name=b loop=$Back}
	{assign var='Type' value=$Back[b]}
	{if !empty($Type.fields)}
		<tr>
			<td colspan=4 style="padding-left:20px"><b>{$Type.name}</b></td>
		</tr>
		{section name=i loop=$Type.fields}
			{assign var='Item' value=$Type.fields[i]}
			{assign var='Diff' value=$Item.maxwt-$Item.wt}
			{assign var='Repcost' value=$Item.power*$Diff}
			{if $Item.type == 'R'}
				{assign var='Costone' value=$Item.cost/20}
				{assign var='Sellcost' value=$Costone*$Item.wt}
			{else}
				{assign var='Sellcost' value=$Item.cost}
			{/if}
			{capture name=pop assign=popText}
				{strip}
					<table border=0 cellpadding=0 cellspacing=0>
						<tr>
							{if isset($Item.imglink)}
							<td rowspan=5>
								<img src='itemimage.php?path={$Item.imglink}&wt={$Item.wt}&maxwt={$Item.maxwt}&type={$Item.type}' alt='image'>
							</td>
							{/if}
							<td>
								<b>{$Item.prefix} {$Item.name}</b>
							</td>
						</tr>
						<tr>
							<td>Min. poziom: {$Item.minlev}</td>
						</tr>
						<tr>
							<td>{$Type.pref}{$Item.power} {$Type.suff}</td>
						</tr>
						{if $Item.zr!=0}
						<tr>
							<td>-{$Item.zr} %zrecznosci</td>
						</tr>
						{/if}
						{if $Item.szyb!=0}
							<tr>
								<td>+{$Item.szyb} %szybkosci</td>
							</tr>
						{/if}
					</table>
					<b>Opcje</b><br>
					<a href='?equip={$Item.id}'>zaloz</a><br>
					sprzedaj 1 <b>({$Sellcost} sz)</b><br>
					sprzedaj wszystkie <b>({$Sellcost*$Item.amount} sz)</b><br>
					{if $Item.type!='R' && $Repcost>0}napraw ({$Repcost} sz){/if}
				{/strip}
			{/capture}
			<tr>
				<td>{$Item.amount}</td>
				<td>
					<a href="#" {popup caption=' ' closetext='zamknij' text=$popText fgcolor=$Overfg bgcolor=$Overbg border=1 sticky=TRUE vauto=TRUE}>
						{$Item.prefix} {$Item.name}
					</a>
				</td>
				<td>{$Type.pref}{$Item.power} {$Type.suff}</td>
				<td>{$Item.wt}{if $Item.type!='R'}/{$Item.maxwt}{/if}</td>
			</tr>
		{/section}
	{/if}
{/section}
</table>
*}
<br><br>
{section name=b loop=$Back}
	{assign var='Type' value=$Back[b]}
	{if !empty($Type.fields)}
		<b>{$Type.name}</b><br>
		{section name=i loop=$Type.fields}
			{assign var='Item' value=$Type.fields[i]}
			{assign var='Diff' value=$Item.maxwt-$Item.wt}
			{assign var='Repcost' value=$Item.power*$Diff*$Item.amount}
			{if $Item.type == 'R'}
				{assign var='Costone' value=$Item.cost/20}
				{assign var='Sellcost' value=$Costone*$Item.wt}
			{else}
				{assign var='Sellcost' value=$Item.cost}
			{/if}
			{capture name=pop assign=popText}
				{strip}
					<table border=0 cellpadding=0 cellspacing=0>
						<tr>
							<td rowspan=10>
								<img src='itemimage.php?path={ $Item.imglink }&wt={ $Item.wt }&maxwt={ $Item.maxwt }&type={ $Item.type }&magic={ $Item.magic }&poison={$Item.poison}' alt='image'>
							</td>
							<td><b>{$Item.prefix} {$Item.name}</b></td>
						</tr>
						<tr>
							<td>Min. poziom: {$Item.minlev}</td>
						</tr>
						<tr>
							<td>Ilosc: {$Item.amount}</td>
						</tr>
						{if $Item.type!='S' && $Item.type!='Z'}
						<tr>
							<td>Wytrzymalosc: {$Item.wt}/{$Item.maxwt}</td>
						</tr>
						{/if}
						<tr>
							<td>{$Type.pref}{$Item.power+$Item.poison} {$Type.suff}</td>
						</tr>
						{if $Item.zr!=0}
						<tr>
							<td>-{$Item.zr} %zrecznosci</td>
						</tr>
						{/if}
						{if $Item.szyb!=0}
						<tr>
							<td>+{$Item.szyb} %szybkosci</td>
						</tr>
						{/if}
					</table>
					<b>Opcje</b><br>
					<a href='?equip={$Item.id}'>zaloz</a><br>
					<a href='?sell=one&id={$Item.id}'>sprzedaj 1</a> <b>({$Sellcost} sz)</b><br>
					<a href='?sell=all&id={$Item.id}'>sprzedaj wszystkie</a> <b>({$Sellcost*$Item.amount} sz)</b><br>
					{if $Item.type!='R' && $Repcost>0}<a href='?repair={$Item.id}'>napraw</a> ({$Repcost} sz){/if}
				{/strip}
			{/capture}
			<a href="?equip={$Item.id}" {popup caption=' ' closetext='zamknij' text=$popText fgcolor=$Overfg bgcolor=$Overbg border=1 sticky=TRUE vauto=TRUE}>
				<img src='itemimage.php?path={ $Item.imglink }&wt={ $Item.wt }&maxwt={ $Item.maxwt }&type={ $Item.type }&magic={ $Item.magic }&amount={ $Item.amount }&poison={$Item.poison}' alt="image">
			</a>
		{/section}
	<br>
	{/if}
{/section}
<br><br>
{section name=p loop=$Pot}
	{assign var='Type2' value=$Pot[p]}
	{if !empty($Type2.fields)}
	<b>{$Type2.name}</b><br>
	{section name=pot loop=$Type2.fields}
		{assign var='Item' value=$Type2.fields[pot]}
			{capture name=pop assign=popText}
				{strip}
					<table border=0 cellpadding=0 cellspacing=0>
						<tr>
							<td rowspan=10>
								<img src='imgpotions.php?path={ $Item.imglink}&amount={ $Item.amount}&power={$Item.power}'>
							</td>
							<td><b>{$Item.prefix} {$Item.name}</b></td>
						</tr>
						<tr>
							<td>Ilosc: {$Item.amount}</td>
						</tr>
						<tr>
							<td>Moc: {if $Item.type!='W'}{$Item.power} {/if}{$Type2.suff}</td>
						</tr>
					</table>
					<b>Opcje</b><br>
					{if $Item.type!='P'}
					<a href='?drink={$Item.id}'>wypij</a>
					{else}
					<a href='?poison={$Item.id}'>zatruj</a>
					{/if}<br>
				{/strip}
			{/capture}
		{if $Item.type!='P'}
			<a href='?drink={$Item.id}'>
		{else}
			<a href='?poison={$Item.id}'>
		{/if}
		<img src="imgpotions.php?path={$Item.imglink}&amount={$Item.amount}&power={$Item.power}" {popup caption=' ' closetext='zamknij' text=$popText fgcolor=$Overfg bgcolor=$Overbg border=1 sticky=TRUE vauto=TRUE offsetx=0 offsety=0}>
		</a>
	{/section}
	<br>
	{/if}
{/section}
{*
<br><br>
<table class="table" width="100%">
	<tr>
		<td class="thead">Szt.</td>
		<td class="thead">Nazwa</td>
		<td class="thead">Moc</td>
	</tr>
{section name=p loop=$Pot}
	{assign var='Type2' value=$Pot[p]}
	{if !empty($Type2.fields)}
		<tr>
			<td colspan=4 style="padding-left:20px"><b>{$Type2.name}</b></td>
		</tr>
		{section name=pot loop=$Type2.fields}
			{assign var='Item' value=$Type2.fields[pot]}
			<tr>
				<td>{$Item.amount}</td>
				<td>{$Item.prefix} {$Item.name}</td>
				<td>{if $Item.type!='W'}{$Item.power} {/if}{$Type2.suff}</td>
				<td><a href="?drink={$Item.id}">wypij</a></td>
			</tr>
		{/section}
	{/if}
{/section}
</table>
*}
{$Action}



