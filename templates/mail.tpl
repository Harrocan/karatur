<script type="text/javascript" src="js/advajax.js"></script>
<script type="text/javascript" src="js/ajax_base.js"></script>
<script type="text/javascript" src="js/mail.js"></script>
{if $View == ""}
	Twoja skrzynka z waidomosciami<br /><br />
	- <a href="mail.php?view=inbox">Wiadomosci</a><br />
	- <a href="mail.php?view=send">Wyslane</a><br />
	- <a href="mail.php?view=write">Napisz</a>
{/if}

{if $View == "inbox"}
	<form method="post" action="mail.php?view=inbox&step=next">
	<div id='msg'>
	{section name=m loop=$Mail}
		{assign value=$Mail[m] var='Msg'}
		<div id='msg_{$Msg.id}' class="mailContainer">
			<div class="mailHeader">
				<input name="delmsg[]" value="{$Msg.id}" type="checkbox" />
				Data: {$Msg.date},
				{if $Msg.type == 'msg' }
				od <a href="view.php?view={$Msg.sender}"><b>{$Msg.user}</b></a> (<span id="msg_{$Msg.id}_id">{$Msg.sender}</span>)
				{elseif $Msg.type=='syst'}
				
				{elseif $Msg.type=='ann'}
				
				{/if}
			</div>
			<div id='msg_{$Msg.id}_t' class="mailTopic{if $Msg.new=='Y'} mailUnread{/if}">
				<b>Temat :</b> <span id="msg_{$Msg.id}_topic">{$Msg.topic}</span>
			</div>
			<div id='msg_{$Msg.id}_body' class="mailBody" style="display:none">
				{if $Msg.type=='syst'}
				<div style="border-bottom:solid thin;margin-bottom:10px">wiadomosc systemowa</div>
				{elseif $Msg.type=='ann'}
				<div style="border-bottom:solid thin;margin-bottom:10px">ogloszenie</div>
				{/if}
				{$Msg.body}
				{if $Msg.type=='msg'}
				<div id="msg_{$Msg.id}_reply" class='mailReply' onclick="reply( {$Msg.id} )">odpowiedz na ta wiadomsc</div>
				{elseif $Msg.type=='syst'}
				<div style="border-top:solid thin;margin-top:10px">wiadomosc systemowa</div>
				{elseif $Msg.type=='ann'}
				<div style="border-top:solid thin;margin-top:10px">ogloszenie</div>
				{/if}
			</div>
			<div id='msg_{$Msg.id}_more' class="mailMore" onclick="more( {$Msg.id} )">czytaj</div>
			<input type="hidden" id="msg_{$Msg.id}_unread" value="{$Msg.new}" />
		</div>
	{/section}
	</div>
	<div id='msg_pages' class="mailPages">
		{section name=p loop=$Pages}
			<a href="?view=inbox&page={$Pages[p]}">{$Pages[p]}</a>   
		{/section}
	</div>
	<input type="submit" value="Kasuj zaznaczone" name="delete" /><br />
	</form>
	<div id='replyForm' style="display:none">
		<form method="post" action="mail.php?view=write&step=send">
			<table border="0" class="table" style="width:100%">
			<tr>
				<td>Do (ID Numer)</td>
				<td style="width:70%"><input type="text" id="replyTo" name="owner" /></td>
			</tr>
			<tr>
				<td>Temat</td>
				<td><input type="text" name="topic" id="replyTopic" style="width:100%" /></td>
			</tr>
			<tr>
				<td valign="top">Tresc</td>
				<td><textarea name="body" id="replyBody" style="width:100%;height:150px"></textarea></td>
			</tr>
			<tr>
				<td></td>
				<td align="center"><input type="submit" value="Wyslij" onclick="return validateMsg();" /> <input type="submit" value="Wroc" onclick="return back();" /></td>
			</tr>
		</table>
	</form>
	</div>
	<br/>

	[<a href="mail.php?view=send">Wiadomosci wyslane</a>]
	[<a href="mail.php?view=inbox&step=clear">Wyczysc skrzynke</a>]
	[<a href="mail.php?view=write">Napisz</a>]
{/if}

{if $View == "send"}
	<form method="post" action="mail.php?step=next&view=send">
	<div id='msg'>
		{section name=m loop=$Mail}
		{assign value=$Mail[m] var='Msg'}
		<div id='msg_{$Msg.id}' class="mailContainer">
			<div class="mailHeader"><input name="delmsg[]" value="{$Msg.id}" type="checkbox" />Data: {$Msg.date}, od <a href="view.php?view={$Msg.owner}"> <b>{$Msg.user}</b></a>(<span id="msg_{$Msg.id}_id">{$Msg.owner}</span>)</div>
			<div id='msg_{$Msg.id}_t' class="mailTopic">
				<b>Temat :</b> <span id="msg_{$Msg.id}_topic">{$Msg.topic}</span>
			</div>
			<div id='msg_{$Msg.id}_body' class="mailBody" style="display:none">
				{$Msg.body}
			</div>
			<div id='msg_{$Msg.id}_more' class="mailMore" onclick="more( {$Msg.id} )">czytaj</div>
			<input type="hidden" id="msg_{$Msg.id}_unread" value="{$Msg.new}" />
		</div>
		{/section}
	</div>
	<div id='msg_pages' class="mailPages">
		{section name=p loop=$Pages}
		<a href="?view=send&page={$Pages[p]}">{$Pages[p]}</a>   
		{/section}
	</div>
	<input type="submit" value="Usun zaznaczone" name="delete" />
	</form>
	[<a href="mail.php?view=inbox">Wiadomosci otrzymane</a>]
	[<a href="mail.php?view=send&amp;step=clear">Wykasuj wyslane</a>]
	[<a href="mail.php?view=write">Napisz</a>]
{/if}

{if $View == "write"}
	<center><div style="display:block; border-style: solid; border-color: #860102;text-align:center; width:80%">
		Uwaga ! Od 28 grudnia zabrania siê wysy³ania zg³oszeñ o b³êdach, rangach, problemach, ¶lubach itp do w³adców [popularna praktyka wysy³ania problemu do id1 i id2 jednocze¶nie]. Bêd± ostrzenia w przypadku niedostosowania. Proszê wysy³aæ wszystkie takie informacje na <a href="info.php">formularz zg³oszeniowy</a>.
	</div></center>
	[<a href="mail.php?view=inbox">Skrzynka</a>]<br /><br />
	<form method="post" action="mail.php?view=write">
		<table border="0" class="table" style="width:100%">
		
			<tr><td>Do (ID) :</td><td style="width:70%"><input type="text" name="owner" value="{$To}" /></td></tr>
		<tr><td>Temat:</td><td><input type="text" name="topic" style="width:100%" value="{$Reply}" /></td></tr>
		<tr><td valign="top">Tresc:</td><td><textarea name="body" style="width:100%; height:150px">{$Body}</textarea></td></tr>
		<tr><td></td><td align="center"><input type="submit" value="Wyslij" /></td></tr>
		</table>
	</form>
{/if}
