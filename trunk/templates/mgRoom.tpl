{if $Action == ''}
{literal}
<script type="text/javascript">
function mgShow( id ) {
	$( 'plot-' + id + '-short' ).style.display = "none";
	//$( 'plot-' + id + '-short' ).parentNode.removeChild( $( 'plot-' + id + '-short' ) );
	$( 'plot-' + id + '-long' ).style.display = "block";
}
</script>
{/literal}
	<a href="?action=create">Za³ó¿</a> sesjê
	<table class="table" style="width:100%">
		{section name=sess loop=$Sessions}
		{assign value=$Sessions[sess] var='Item'}
		<tr>
			<td class="thead">{$Item.name}</td>
		</tr>
		<tr>
			<td>
				{if $Item.type=='closed'}<i style="color:grey;">{/if}
				<span id="plot-{$Item.id}-short">{$Item.short}</span>
				<span id="plot-{$Item.id}-long" style="display:none">{$Item.desc}</span>
				<div style="text-align:right" id="plot-{$Item.id}-more" onclick="mgShow( {$Item.id} )">czytaj dalej</div>
				{if $Item.type=='closed'}</i>{/if}
				<br/><br/>
				Prowadzona przez <b>{$Item.gm_name}</b>
				<table border="0" style="width:100%;text-align:center">
					<tr>
						{if $Item.access}
							<td style="width:25%"><a href="?action=view&s={$Item.id}">wejd¼</a></td>
						{else}
							{if $Item.type == 'open'}
								{if $Item.form == '0'}
								<td style="width:25%"><a href="?action=join&s={$Item.id}">do³±cz</a></td>
								{else}
								<td style="width:25%">podanie z³o¿one</td>
								{/if}
							{/if}
							{if $Item.spectate == 'allow'}
								<td style="width:25%"><a href="?action=view&s={$Item.id}">podgl±dnij</a></td>
							{/if}
						{/if}
						<td></td>
					</tr>
				</table>
			</td>
		</tr>
		{/section}
	</table>
{elseif $Action == 'create'}
	<fieldset>
		<legend>Zak³adanie nowej sesji</legend>
		<form method="POST" action="?action=create">
			<table class="table">
				<tr>
					<td class="thead" colspan="2" style="text-align:center">Uzupe³nij wszystkie dane</td>
				</tr>
				<tr>
					<td>Nazwa sesji</td><td><input type="text" name="create[name]"/></td>
				</tr>
				<tr>
					<td>Opis sesji</td><td><textarea name="create[desc]" style="width:300px;height:100px"></textarea></td>
				</tr>
				<tr>
					<td>Typ sesji</td>
					<td>
						
							<input type="radio" id="status-open" name="create[status]" value="open" checked="checked"><label for="status-open">otwarta - kazdy moze z³o¿yæ podanie o do³±czenie do sesji</label><br/>
							<input type="radio" id="status-closed" name="create[status]" value="closed"><label for="status-closed">zamkniêta - podania nie s± mo¿liwe</label><br/>
							<i>(Ustawienie to mo¿na potem zmieniaæ w opcjach sesji)</i>
						
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:right"><input type="submit" value="kontynuuj"/></td>
				</tr>
			</table>
		</form>
	</fieldset>
	<a href="?">Wróæ</a> do menu g³ównego
{elseif $Action == 'join'}
	Masz zamiar z³o¿yæ podanie o do³±czenie do sesji <b>{$Sess_name}</b>. To jest pole ¿eby siê zaprezentowaæ i zachêciæ Mistrza Gry do przyjêcia Ciebie do tej gry.<br/>
	<form method="POST" action="?action=join&s={$Sess_id}">
	<textarea name="reason" style="width:100%;height:150px"></textarea><br/><br/>
	<input type="submit" value="kontynuuj" />
	</form>
{elseif $Action == 'view'}
	{literal}
	<style type="text/css">
	/* STYLE NAWIGACJI */
	td.btn-default {
	text-align:center;
	}
	td.btn-default:hover {
	background: #004400;
	cursor: pointer;
	}
	
	td.btn-selected {
	color: #A24E4E;
	background-color: #121d25;
	font-weight:bold;
	cursor: pointer;
	text-align:center;
	}
	.btn-disabled {
	background: #262626;
	color: #777777;
	cursor: pointer;
	text-align:center;
	}
	.form {
	padding-left:30px;
	border-top:solid 1px;
	}
	/* STYLE CHATU */
	.user-M {
	background:url( 'images/male.png' ) no-repeat;
	background-position: 4px 1px;
	}
	.user-F {
	background:url( 'images/female.png' ) no-repeat;
	background-position: 4px 1px;
	}
	.owner{
	background-color:#151515;
	}
	.chatWindow{
	border:solid #202020 3px;
	}
	.chatMessages{
	overflow:auto;
	height:400px;
	width:300px;
	float:left;
	}
	.chatUserList{
	border-left:solid #202020 3px;
	height:400px;
	width:100px;
	float:left;
	}
	</style>
	<script language="JavaScript" src="js/advajax.js"></script>
	<script language="JavaScript" src="js/ajax_base.js"></script>
	<script language="JavaScript" src="js/mgRoom.js"></script>
	<script type="text/javascript">
		var curMainTab = 'plot';
		function switchMainTab( name ) {
			if( is_spect ) {
				return;
			}
			var node = $( 'mgRoom-' + curMainTab );
			var btn = $( 'btn-' + curMainTab );
			switch( curMainTab ){
				case 'plot': {
					node.style.display = 'none';
					break;
				}
				case 'chat': {
					node.style.display = 'none';
					break;
				}
				case 'options': {
					node.style.display = 'none';
					break;
				}
			}
			btn.className = 'btn-default';
			curMainTab = name;
			var node = $( 'mgRoom-' + curMainTab );
			var btn = $( 'btn-' + curMainTab );
			switch( curMainTab ){
				case 'plot': {
					node.style.display = 'block';
					break;
				}
				case 'chat': {
					node.style.display = 'block';
					break;
				}
				case 'options': {
					node.style.display = 'block';
					break;
				}
			}
			btn.className = 'btn-selected';
		}
		
		var curOptionTab = 'general';
		function switchOptionTab( name ) {
			var node = $( 'mgRoom-option-' + curOptionTab );
			var btn = $( 'btn-' + curOptionTab );
			
			node.style.display = 'none';
			btn.className = 'btn-default';
			
			curOptionTab = name;
			var node = $( 'mgRoom-option-' + curOptionTab );
			var btn = $( 'btn-' + curOptionTab );
			
			node.style.display = 'block';
			btn.className = 'btn-selected';
		}
	</script>
	{/literal}
	<script type="text/javascript">
		//chatRoom = {$SessData.id};
		var is_spect = {$SessData.is_spect};
		var tableLastMod = {$SessData.tableModTime};
	</script>
	<table class="table" style="width:100%">
		<tr>
			<td colspan="10" class="thead" style="text-align:center;font-weight:bold;font-size:1.3em;border-bottom:solid 2px">{$SessData.name}</td>
		</tr>
		<tr>
			<td>
				<table cellpadding="0" cellspacing="0" border="0" style="width:100%;text-align:center">
					<tr>
						<td onclick="switchMainTab( 'plot' )" id="btn-plot" class="btn-selected" style="width:25%">Fabu³a</td>
						{if !$SessData.is_spect}<td onclick="switchMainTab( 'chat' )" id="btn-chat" class="btn-default" style="width:25%">Chat</td>
						<td onclick="switchMainTab( 'options' )" id="btn-options" class="btn-default" style="width:25%">Opcje</td>{/if}
						<td class="btn-default" style="width:25%"></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<br/><br/>
				<div id="mgRoom-plot" style="display:block">
				<!--	BEGIN MG-ROOM-PLOT	-->
				<div id="table-error" class="error" style="margin:0px auto;display:none">Na tablicy pojwi³y siê nowe wiadomo¶ci !<br/><a href="?action=view&s={$SessData.id}">Od¶wie¿</a> stronê</div>
				<table class="table">
					{if !$SessData.is_spect}
					<tr>
						<td class="thead btn-default" onclick="$('plot-add').style.display='block';">Dodaj wiadomo¶æ</td>
					</tr>
					{/if}
					<tr>
						<td id="plot-add" style="display:none">
							<form method="POST" action="?action=view&s={$SessData.id}">
								
								<table style="width:100%">
									<tr>
										<td colspan="2">Wpisz tre¶æ</td>
									</tr>
									<tr>
										<td colspan="2"><textarea name="addMsg[body]" style="width:100%;height:150px"></textarea></td>
									</tr>
									<tr>
										<td style="text-align:left">
											<input type="submit" value="anuluj" onclick="$('plot-add').style.display='none';return false;"/>
										</td>
										<td style="text-align:right">
											<input type="submit" value="dalej"/>
										</td>
									</tr>
								</table>
							</form>
							</td>
						</tr>
					
					{if !empty( $EditEntry )}
						<tr>
							<td id="entry-edit">
								<form method="POST" action="?action=view&s={$SessData.id}&edit={$EditEntry.id}">
							<table style="width:100%">
								<tr>
									<td colspan="2" class="thead">Edycja wpisu z dnia {$EditEntry.date}</td>
								</tr>
								<tr>
									<td colspan="2"><textarea name="editMsg[body]" style="width:100%;height:130px">{$EditEntry.body}</textarea></td>
								</tr>
								<tr>
									<td style="text-align:left">
										<input type="submit" value="anuluj" onclick="$('entry-edit').style.display='none';return false;"/>
									</td>
									<td style="text-align:right">
										<input type="submit" value="zapsz"/>
									</td>
								</tr>
							</table>
							</form>
							</td>
						</tr>
					{/if}
					{section name=plot loop=$Plot}
					{assign value=$Plot[plot] var='Entry'}
						<tr>
							<td>
								<b>{$Entry.user}</b> {$Entry.date}
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<img src="avatars/thumb_50_{$Entry.player_id}.jpg" style="float:left"/>
								{$Entry.body}
								{if $Entry.change_total > 0 }
								<div style="text-align:center;font-style:italic;clear:both">
									edytowany <b>{$Entry.change_total}</b> razy.<br/>
									Ostatni raz {$Entry.change_date} przez <b>{$Entry.change_user}</b>
								</div>
								{/if}
								{if $SessData.is_mg || $Entry.is_owner}
								<div style="text-align:right"><a href="?action=view&s={$SessData.id}&edit={$Entry.id}">edytuj</a></div>
								{/if}
								
							</td>
						<tr>
					{/section}
					</table>
				<!--	END MG-ROOM-PLOT	-->
				</div>
				<div id="mgRoom-chat" style="display:none">
				<!--	BEGIN MG-ROOM-CHAT	-->
					<div  class="chatWindow">
						<div style="width:420px;margin:0px auto">
							<div style="border-bottom:solid #202020 3px;padding: 3px; margin:0px auto">
								wpisz wiadomosc : <input type="text" id="chatMsg" style="width:250px" onkeydown="return chatKey(event)"/> <input type="submit" value="wyslij" onclick="sendMsg(); return false;"/><br/>
								<input id="emoBtn" type="submit" value="emo" style="color:#0DCE0D" emote="0" onclick="emoMode()" /> <input id="offBtn" type="submit" value="komentarz" offtop="0" onclick="offMode()" style="color:gray" />
							</div>
							<div id="chatText" class="chatMessages">
								<div style="margin:0px auto">prosze czekac na zaladowanie ...</div>
							</div>
							<div id="chatUsers" class="chatUserlist">
								lista obecnych niedostêpna
							</div>
						</div>
						<hr style="clear:both"/>
					</div>
				<!--	END MG-ROOM-CHAT	-->
				</div>
				<div id="mgRoom-options" style="display:none">
				<!--	BEGIN MG-ROOM-OPTIONS	-->
				{if $SessData.is_mg}
					<table class="table" style="width:100%">
						<tr>
							<td>
								<table border="0">
									<tr>
										<td onclick="switchOptionTab( 'general' )" id="btn-general" class="btn-selected" style="width:25%">Opcje generalne</td>
										<td onclick="switchOptionTab( 'forms' )" id="btn-forms" class="btn-default" style="width:25%">Podania graczy{if count( $Options_forms )>0} ({$Options_forms_amount}){/if}</td>
										<td onclick="switchOptionTab( 'players' )" id="btn-players" class="btn-default" style="width:25%">Cz³onkowie sesji{if count( $Options_players )>0} ({$Options_players_amount}){/if}</td>
										
										<td></td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td>
								<div id="mgRoom-option-general" style="display:block">
								<!--	BEGIN MG-ROOM-OPTION-GENERAL	-->
								<form method="POST" action="?action=view&s={$SessData.id}">
								Typ gry :
								<ul style="margin-top:0px;">
									<input type="radio" name="general[type]" value="open" id="gametype-open" {if $SessData.type=='open'}checked="checked"{/if}/><label for="gametype-open">Otwarta - gracze moga pisaæ podania o przyjêcie</label><br/>
									<input type="radio" name="general[type]" value="closed" id="gametype-closed" {if $SessData.type=='closed'}checked="checked"{/if} /><label for="gametype-closed">Zamkniêta - pisanie podañ nie jest mo¿liwe</label>
								</ul>
								Status gry :
								<ul style="margin-top:0px;">
									<input type="radio" name="general[status]" value="play" id="gamestatus-play" {if $SessData.status=='play'}checked="checked"{/if} /><label for="gamestatus-play">W toku - sesja trwa i ma siê dobrze</label><br/>
									<input type="radio" name="general[status]" value="end" id="gamestatus-end" {if $SessData.status=='end'}checked="checked"{/if} /><label for="gamestatus-end">Zakoñczona - sesja dobieg³a koñca. Chat jest wy³±czony, oraz pisanie nowych wiadomo¶ci nie jest mo¿liwe</label>
								</ul>
								Obserwatorzy
								<ul style="margin-top:0px;">
									<input type="radio" name="general[spectate]" value="allow" id="gamespectate-allow" {if $SessData.spectate=='allow'}checked="checked"{/if} /><label for="gamespectate-allow">Dozwolone - inni gracze mog± podgl±daæ rozwój wydarzeñ</label><br/>
									<input type="radio" name="general[spectate]" value="closed" id="gamespectate-closed" {if $SessData.spectate=='closed'}checked="checked"{/if} /><label for="gamespectate-closed">Zabronione - sesja jest prywatna i nikt nie mo¿e podgl±daæ fabu³y</label>
								</ul>
								<input type="submit" value="zapisz" />
								</form>
								<!--	END MG-ROOM-OPTION-GENERAL	-->
								</div>
								<div id="mgRoom-option-forms" style="display:none">
								<!--	BEGIN MG-ROOM-OPTION-FORMS	-->
									<form method="POST" action="?action=view&s={$SessData.id}">
									Oto podania oczekuj±ce na rozpatrzenie :
									{section name=of loop=$Options_forms}
									{assign value=$Options_forms[of] var='Form'}
										<div class="form">
										<img src="avatars/thumb_50_{$Form.pid}.jpg" style="float:left"/>
										<a href="view.php?view={$Form.pid}">{$Form.user}</a> : <br/>
										{$Form.reason}<br/>
										<i>z³o¿ono o {$Form.date}</i><br/>
										<input type="checkbox" name="forms[allow][]" value="{$Form.pid}"/>Przyjmij | 
										<input type="checkbox" name="forms[deny][]" value="{$Form.pid}"/>Odrzuæ
										</div>
									{sectionelse}
										<div class="form">Brak oczekujacych podañ</div>
									{/section}
									{if count( $Options_forms ) > 0}<input type="submit" value="kontunuuj"/>{/if}
									</form>
								<!--	END MG-ROOM-OPTION-FORMS	-->
								</div>
								<div id="mgRoom-option-players" style="display:none">
								<!--	BEGIN MG-ROOM-OPTION-PLAYERS	-->
									{section name=op loop=$Options_players}
									{assign value=$Options_players[op] var='Pl'}
										<table cellpadding="0" cellspacing="0" style="margin:3px">
											<tr>
												<td rowspan="2" style="width:55px;height:50px"><img src="avatars/thumb_50_{$Pl.id}.jpg"/></td>
												<td style="height:10px"><a href="view.php?view={$Pl.id}">{$Pl.user}</a></td>
											</tr>
											<tr>
												<td style="vertical-align:top">
													
												</td>
											</tr>
										</table>
									{/section}
								<!--	END MG-ROOM-OPTION-PLAYERS	-->
								</div>
							</td>
						</tr>
					</table>
				{else}
					user data
				{/if}
				<!--	END MG-ROOM-OPTIONS	-->
				</div>
				<br/><br/>
			</td>
		</tr>
	</table>
	<a href="?">Wróæ</a> do g³ównego pokoju
{/if}