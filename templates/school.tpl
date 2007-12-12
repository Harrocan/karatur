<b>{$Title}</b><br>
Mo¿esz u nas trenowaæ nastepuj±ce rzeczy :<br>
<ul>
{if !empty($Train.str)}
	<li>{$Trainjump.str} si³y za {$Traincost.str} z³ota<br></li>
{/if}
{if !empty($Train.dex)}
	<li>{$Trainjump.dex} zrêczno¶ci za {$Traincost.dex} z³ota<br></li>
{/if}
{if !empty($Train.int)}
	<li>{$Trainjump.int} inteligencji za {$Traincost.int} z³ota<br></li>
{/if}
{if !empty($Train.spd)}
	<li>{$Trainjump.spd} szybko¶ci za {$Traincost.spd} z³ota<br></li>
{/if}
{if !empty($Train.con)}
	<li>{$Trainjump.con} wytrzyma³o¶ci za {$Traincost.con} z³ota<br></li>
{/if}
{if !empty($Train.wis)}
	<li>{$Trainjump.wis} si³y woli za {$Traincost.wis} z³ota<br></li>
{/if}
</ul>
Ka¿dy trening jest mêcz±cy i czasoch³onny, dlatego zabiera ci 0.4 energii.<br><br>
<form method="post" action="?sid={$Sid}&action=train">
Chcê æwiczyæ 
<SELECT name="co">
{if $Train.str=="1"}<option value='str'>si³ê{/if}
{if $Train.dex=="1"}<option value='dex'>zrêczno¶æ{/if}
{if $Train.int=="1"}<option value='int'>inteligencjê{/if}
{if $Train.spd=="1"}<option value='spd'>szybko¶æ{/if}
{if $Train.con=="1"}<option value='con'>wytrzyma³o¶æ{/if}
{if $Train.wis=="1"}<option value='wis'>si³ê woli{/if}
</select> <input type="text" name="ile" size="5"> razy<br>
<input type="submit" value="Trenuj !">
</form>
<br>