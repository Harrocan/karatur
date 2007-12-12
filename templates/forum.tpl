<table border="0" width="1000%" align="center" style="margin-top:10px">
{if $Cat==''}
	<tr>
		<td>	
		Oto dostepne dzialy :<br>
		<table width="100%" class="table">
			<tr>
				<td class="thead">Nazwa</td>
				<td class="thead" width="20px">Tematow</td>
				<td class="thead" width="20px">Wypowiedzi</td>
			</tr>
		{section name=c loop=$Cats}
			<tr>
				<td class="body"><a href="?cat={$Cats[c].id}">{$Cats[c].name}</a></td>
				<td class="body">{$Cats[c].tamount}</td>
				<td class="body">{$Cats[c].ramount}</td>
			</tr>
			<tr>
				<td class="body" colspan="4" style="padding-left:15px">{$Cats[c].desc}</td>
			</tr>
		{/section}
		</table>
		</td>
	</tr>
{/if}
{if $Cat!=''}
	{if $Topic==''}
		{if $Action==''}
		<tr>
			<td class="sub">
				<a href="forum.php">Forum glowne</a> >> <a href="?cat={$Cat}">{$Catname}</a>
			</td>
		</tr>
		<tr>
			<td class="body">
				Oto tematy dostepne w tym dziale :<br>
				<table width="100%" class="table">
					<tr>
						<td class="thead" width="10px"></td>
						<td class="thead">Temat</td>
						<td class="thead" width="20px">Odp.</td>
						<td class="thead">Zalozyciel</td>
						<td class="thead">Ost. odpowiedz
					</tr>
				{section name=t loop=$Topics}
					<tr>
						<td class="body">
							{if $Topics[t].closed=='Y'}
								<img src="images/forum/zamkniety.gif">
							{elseif $Topics[t].sticky=='Y'}
								<img src="images/forum/przyklejony.gif">
							{else}
								<img src="images/forum/temat.gif">
							{/if}
						</td>
						<td class="body"><a href="?cat={$Cat}&topic={$Topics[t].id}">{$Topics[t].start_topic}</a></td>
						<td class="body">{$Topics[t].ramount}</td>
						<td class="body">{$Topics[t].start_user}</td>
						<td class="body">{$Topics[t].last_time}</td>
						<td class="body">
							{if $Ranks.forum_delete}
								<a href="?cat={$Cat}&topic={$Topics[t].id}&action=delete"><img src="images/forum/usun.gif"></a> 
							{/if}
							{if $Ranks.forum_sticky}
								{if $Topics[t].sticky=='N'}
									<a href="?cat={$Cat}&topic={$Topics[t].id}&action=sticky"><img src="images/forum/przyklej.gif"></a>
								{else}
									<a href="?cat={$Cat}&topic={$Topics[t].id}&action=unsticky"><img src="images/forum/odklej.gif"></a>
								{/if} 
							{/if}
							{if $Ranks.forum_move}
								<a href="?cat={$Cat}&topic={$Topics[t].id}&action=move"><img src="images/forum/przenies.gif"></a>
							{/if}
						</td>
					</tr>
				{/section}
					<tr>
						<td class="body" align="center" colspan=8>
							<a href="?cat={$Cat}&action=topic"><img src="images/forum/nowytemat.gif"> Dodaj temat</a> 
						</td>
					</tr>
				</table>
			</td>
		</tr>
		{elseif $Action=='topic'}
		<tr>
			<td class="sub">
				<a href="forum.php">Forum glowne</a> >> <a href="?cat={$Cat}">{$Catname}</a>
			</td>
		</tr>
		<tr>
			<td class="sub">
				Dodaj temat
			</td>
		</tr>
		<tr>
			<td class="body">
				<form method="post" action="?cat={$Cat}&action=addtopic">
					Temat : <input type="text" name="topic" style="width:250px;"><br>
					Wpisz tresc : <br>
					<textarea name="body" style="width:350px; height:130px"></textarea><br>
					<input type="submit" value="dodaj">
				</form>
			</td>
		</tr>
		{/if}
	{/if}
	{if $Topic!=''}
		{if $Action==''}
		<tr>
			<td class="sub">
				<a href="forum.php">Forum glowne</a> >> <a href="?cat={$Cat}">{$Catname}</a> >> <a href="?cat={$Cat}&topic={$Topic}">{$Head.start_topic}</a>
			</td>
		</tr>
			<td class="body">
			<table width="100%" class="table">
				<tr>
					<td rowspan="2" valign="top" style="width:100px" class="thead"><a href="view.php?view={$Head.start_id}" class="web">{$Head.user}</a></td>
					<td style="height:10px" class="thead">{$Head.start_time}</td>
				</tr>
				<tr>
					<td class="body" valign="top">{$Head.start_body}</td>
				</tr>
				{section name=r loop=$Rep}
				<tr>
					<td rowspan="2" valign="top"><a href="view.php?view={$Rep[r].sender}" class="web">{$Rep[r].user}</a></td>
					<td style="height:10px">
						<table width="100%"><tr><td>{$Rep[r].time}</td><td width="10px">{if $Ranks.forum_delete}<a href="?cat={$Cat}&topic={$Topic}&msg={$Rep[r].id}&action=delete">X</a>{/if}</td></tr></table>
					</td>
				</tr>
				<tr>
					<td class="body" valign="top">{$Rep[r].body}</td>
				</tr>
				{/section}
				<tr>
					<td class="body" align="center" colspan=2>
						{if $Head.closed=='N'}
							<a href="?cat={$Cat}&topic={$Topic}&action=reply">
							<img src="images/forum/odpowiedz.gif"> Dodaj odpowiedz
							</a> 
						{else}
							<img src="images/forum/odpowiedz.gif"> Temat zamkniety 
						{/if}
						{if $Ranks.forum_close}
							{if $Head.closed=='N'}
								| <a href="?cat={$Cat}&topic={$Topic}&action=close">Zamknij</a>
							{else}
								| <a href="?cat={$Cat}&topic={$Topic}&action=open">Otworz</a>
							{/if}
						{/if}
					</td>
				</tr>
			</table>
			</td>
			
		</tr>
		{elseif $Action=='reply'}
		<tr>
			<td class="sub">
				<a href="forum.php">Forum glowne</a> >> <a href="?cat={$Cat}">{$Catname}</a> >> <a href="?cat={$Cat}&topic={$Topic}">{$Head.start_topic}</a>
			</td>
		</tr>
		<tr>
			<td class="sub">
				Dodaj odpowiedz
			</td>
		</tr>
		<tr>
			<td class="body">
			<form method="post" action="?cat={$Cat}&topic={$Topic}&action=addreply">
				Wpisz tresc : <br>
				<textarea name="body" style="width:350px; height:130px"></textarea><br>
				<input type="submit" value="dodaj">
			</form>
			</td>
		</tr>
		{elseif $Action=='move'}
		<tr>
			<td class="sub">
				<a href="forum.php">Forum glowne</a> >> <a href="?cat={$Cat}">{$Catname}</a> >> <a href="?cat={$Cat}&topic={$Topic}">{$Head.start_topic}</a>
			</td>
		</tr>
		<tr>
			<td class="sub">
				Przesun watek
			</td>
		</tr>
		<tr>
			<td class="body">
				<form method="post" action="?cat={$Cat}&topic={$Topic}&action=move">
				Przesun temat do kategori {html_options name=dest options=$Kat selected=$Selected}<br>
				<input type="submit" value="dalej">
				</form>
			</td>
		</tr>
		{/if}
	{/if}
{/if}
</table>
