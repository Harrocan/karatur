<table border="0" class="table" width="90%">
	<tr>
		<td>Walka zaczeta !</td>
	</tr>
	<tr>
		<td>
			Naprzeciwko siebie staneli :<br>
			{foreach from=$Starting item=group}
			Grupa <b>{$group.group}</b><br>
			<ul>
				{section name=p loop=$group.players}
					<li>{$group.players[p]}
				{/section}
			</ul>
			{/foreach}
		</td>
	</tr>
	<tr>
		<td><b><i><span style="font-size:16px">Przebieg walki</span></i></b></td>
	</tr>