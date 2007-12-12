<script language="JavaScript" src="js/advajax.js"></script>
<script language="JavaScript" src="js/ajax_base.js"></script>
<script language="JavaScript" src="js/chat.js"></script>
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
	width:280px;
	float:left;
	}
	.chatUserList{
	border-left:solid #202020 3px;
	height:400px;
	width:70px;
	float:left;
	}
</style>
{/literal}
<center><img src="salka.jpg"/></center><br />
<table border="0" width="390px">
	<tr>
		<td><br/><br/>
			Tutaj, w tym pokoju mozna spokojnie wypa¶æ z torow fantastyki i rozmawiac o czym¶ "¶wiatowym"...
			<br/><br/>
			<center>
				|| <a href="chat.php">Pokoj glowny</a> (<span id="roomMainAmount">0</span>) 
				|| <a href="pokoje.php">Wynajmij pokoj</a>
				|| <br/>
				|| <a href="piwnica.php">Zejscie do piwnicy</a> (<span id="roomBaseAmount">0</span>) 
				|| <a href="kawiarnia.php">Barek</a>
				|| <br/>
				|| <a href="kar.php">O zachowaniu w karczmie</a>
				|| <br/>
				<br/>
				<b>!!UWAGA ZA ZAMOWIENIA U KARCZMARZA NALEZY PLACIC ...!!<br/>
					cena jednego zamowienia to 1 sz</b>
				<br/><br/><br/>
			</center>
		</td>
	</tr>
	<tr><td width="500" valign="top">
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
				<div style="width:380px;margin:0px auto">
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
</table>
