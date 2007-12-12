<script language="JavaScript" src="js/advajax.js"></script>
<script language="JavaScript" src="js/ajax_base.js"></script>
<script language="JavaScript" src="js/mgRoom.js"></script>
{literal}
<style type="text/css">
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
{/literal}
<center><img src="MGdoor.jpg"/></center><br/><br/>
<table border="0" width="100%">
{if $wej!="ok"}
	<tr>	
		
		<td>
			<br/><br/>Podchodzisz do drzwi, znajdujacych sie w zakamarku Karczmy i ju¿ chcesz ³apac za klamke, kiedy to droge zachodzi Ci Barnaba:<I><br/> -Czego tu szukasz! Do pokoju Mistrza Gry maja wstep tylko Ci, którzy znaja has³o!</I>
			<br/><br/>Ty odpowidasz:
		</td>
	</tr>
	
	<tr>
		<td colspan="2" align="">
			<form action="MGdoor.php" method="POST"">
			Has³o wejscia brzmi:
			<input type="text" name="pass" style="width:100px"">
			<input type="submit" value="odpowiedz">
			</form>
			<br/>
		</td>
		{if ($Rank_block == "1") || ($Rank_clear == "1")}
	<tr>
		<td colspan="2" align="">
			Aktualne haslo to: {$haslo}<br/>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="">
			<form method="POST" Action="MGdoor.php">
			Zmien has³o wejscia na:
			<input type="text" name="passc" style="width:100px"">
			<input type="submit" value="zmien">
			</form>
			<br/><br/>
		</td>
	</tr>
	
		{/if}
{/if}
{if $wej=="ok"}
	<tr><td width="500" valign="top">
			Tutaj Mistrz Gry ustala zasady...
			<div id="chatHelp">
				<div id="chatHelpTop" onclick="chatHelpSwitch('show')" class="mailMore">
					Pomoc do karczmy
				</div>
				<div id="chatHelpText" style="display:none">
					Oto dostepne mozliwosci w karczmie : 
					<ul>
						<li><emo>tekt wyrozniony</emo> tym kolorem uzywamy do zaznaczenia naszych emocji, reakcji i zachowan. Uzyskujemy go poprzez zastosowanie skladni : <span class="preInline">[emo]jakis tekst[/emo]</span> lub <span class="preInline">[*]jakis tekst[/*]</span> co da nam efekt : <emo>jakis tekst</emo></li>
						<li><szept>texkt wyrozniony</szept> tym kolorem uzywamyz kolei do zamieszczania nieklimatycznych wypowiedzi, w stylu <szept>zaraz wroce</szept>. Ten efekt uzyskujemy poprzez zastosowanie skladni <span class="preInline">[szept]zaraz wroce[/szept]</span> albo krocej <span class="preInline">[|]zaraz wroce[/|]</span><br/><b>UWAGA !</b> Prosze pamietac o tym ze nalezy korzystac z tej formu z umiarem gdys w karczmie obowiazuje klimat (z wyjatkiem pokoju Nieklimatyzowanego)</li>
						<li>Karczmarz reaguje na nastepujace slowa wplecione w zdania : 'dobranoc', 'dowidzenia', 'chcesz z kufla ?', 'ale nuda', 'nudno', 'muzyka', 'zimno tu', 'tu zimno', 'witam', 'witajcie', oraz na slowo 'karczmarzu' w polaczeniu z jednym z nastepujacych slow : 'wiesci', 'wydarzylo', 'kawal'</li>
					</ul>
					<div class="mailMore" onclick="chatHelpSwitch('hide')">Schowaj</div>
				</div>
			</div>
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
						osoby w karczmie
					</div>
				</div>
				<hr style="clear:both"/>
			</div>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center">
			{if $Rank_clear == "1"}
			<br />
			<select id="innkeeperType">
				<option value="innkeeper">Karczmarz</option>
				<option value="barnaba">Barnaba</option>
				<option value="aniela">Karczmarka Aniela</option>
			</select>
			<input type="text" id="innkeeperMsg" style="width:250px" onkeydown="return chatKeyInn(event)"/>
			<input type="submit" value="mow" onclick="return sendMsgInn()"/>
			<br/><br/>
			<input type="submit" value="Czysc chat" onclick="clearChat()"/>
			{/if}
			{if $Rank_block == "1"}
			<br/><br/>
			<select id="ban">
				<option value="ban">Banuj</option>
				<option value="unban">Odbanuj</option>
			</select>
			ID <input type="text" size="5" id="banid" /> w tym pokoju <input type="submit" value="Dalej" onclick="ban()" />
			{/if}
		</td>
	</tr>
{/if}
</table>