<b>{$Title}</b><br>
Mo�esz u nas trenowa� nastepuj�ce rzeczy :<br>
<ul>
{if !empty($Train.str)}
	<li>{$Trainjump.str} si�y za {$Traincost.str} z�ota<br></li>
{/if}
{if !empty($Train.dex)}
	<li>{$Trainjump.dex} zr�czno�ci za {$Traincost.dex} z�ota<br></li>
{/if}
{if !empty($Train.int)}
	<li>{$Trainjump.int} inteligencji za {$Traincost.int} z�ota<br></li>
{/if}
{if !empty($Train.spd)}
	<li>{$Trainjump.spd} szybko�ci za {$Traincost.spd} z�ota<br></li>
{/if}
{if !empty($Train.con)}
	<li>{$Trainjump.con} wytrzyma�o�ci za {$Traincost.con} z�ota<br></li>
{/if}
{if !empty($Train.wis)}
	<li>{$Trainjump.wis} si�y woli za {$Traincost.wis} z�ota<br></li>
{/if}
</ul>
Ka�dy trening jest m�cz�cy i czasoch�onny, dlatego zabiera ci 0.4 energii.<br><br>
<form method="post" action="?sid={$Sid}&action=train">
Chc� �wiczy� 
<SELECT name="co">
{if $Train.str=="1"}<option value='str'>si��{/if}
{if $Train.dex=="1"}<option value='dex'>zr�czno��{/if}
{if $Train.int=="1"}<option value='int'>inteligencj�{/if}
{if $Train.spd=="1"}<option value='spd'>szybko��{/if}
{if $Train.con=="1"}<option value='con'>wytrzyma�o��{/if}
{if $Train.wis=="1"}<option value='wis'>si�� woli{/if}
</select> <input type="text" name="ile" size="5"> razy<br>
<input type="submit" value="Trenuj !">
</form>
<br>