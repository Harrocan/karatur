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
<center><img src="karczma2.jpg"></center><br />
	<table border="0" width="390px">
		
		
		<td><br/><br/>Dluga aksamitna suknia szelescila wspaniale,
			gdy dumna sylwetka Joanny d'Erle kierowala sie w strone stolika. Czerwien jej sukni
			odbijala sie niczym w lustrze w marmurowej posadzce. Czerwony marmur z finezyjnymi
			ornamentami wyrzezbionymi reka matki natury, odbijal swiatlo rzucane przez rzad pozlacanych
			kagankow i swiec. W karczmie panowal polmrok, choc znac bylo ze i tu z mistrzowska
			precyzja zadbano o to, by swiatlo bylo dostatecznie jasne dla jedzacych,
			czytajacych menu, a jednoczesnie stwarzalo przyjemna, intymna atmosfere...
			
			<br/><br/><center>||<a href="bezklimy.php">Pokoj Nieklimatyczny</a> (<span id="roomOffAmount">{$Nieklim}</span>) ||
				<a href="pokoje.php">Wynajmij pokoj</a>||
				<br/>||
				<a href="piwnica.php">Zejscie do piwnicy</a> (<span id="roomBaseAmount">{$Schody}</span>) ||
				
				<a href="kawiarnia.php">Barek</a>||<br/>||<a href="kar.php">O zachowaniu w karczmie</a>||<br/>
				<br/><b>!!UWAGA KARCZMA I JEJ POKOJE NIE DZIA£AJA POPRAWNIE W INTERNET EXPLORERZE. ...!!<br/>PROSIMY U¯YCWAC FIREFOXA</b><br/><br/><br/></center>
		</td>
	</tr>
	
	<tr>
		<td width="380px" valign="top">
			<div id="chatHelp">
				<div id="chatHelpTop" onclick="chatHelpSwitch('show')" class="mailMore">
					Pomoc do karczmy
				</div>
				<div id="chatHelpText" style="display:none">
					Oto dostepne mozliwosci w karczmie : 
					<ul>
						<li>wysylanie odpowiedzi dokonkretnego gracza robimy poprzez wpisanie <b>na samym poczatku tresci wiadomosci</b> czegos takiego : <span class="preInline">267= wiadomosc</span>. Zostanie to zamienione na "<b>Alucard van Hellsing >>></b> wiadomosc". Na dodatek osoba do ktorej wysylamy ta wiadomosc, bedzie miala ja delikatnie wyrozniona, zeby ja zauwazyla</li>
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
						wpisz wiadomosc : <input type="text" id="chatMsg" style="width:200px" onkeydown="return chatKey(event)"/> <input type="submit" value="wyslij" onclick="sendMsg(); return false;"/><br/>
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
			<div style="text-align:left">
			<input type="submit" value="Czysc chat" onclick="clearChat()"/>
			</div>
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
