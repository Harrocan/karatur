<script language="JavaScript" src="js/advajax.js"></script>
<script language="JavaScript" src="js/ajax_base.js"></script>
<script language="JavaScript" src="js/usersniff.js"></script>
{literal}
<style type="text/css">
	.sniffContainer {
	border-style: solid;
	
	}
	.sniffTitle {
	color: red;
	text-align:center;
	}
	.invalid {
	background-color:#760c0e;
	}
	.valid {
	background-color:#083f04;
	}
</style>
{/literal}
{if $Sid === NULL}
podaj dane
{else}
szpiegowanie
<div id="personalData" class="sniffContainer">
	{assign value=$Sniff.player var='PlData'}
	<div class="sniffTitle">Dane osobowe</div>
	<div id="personalData">
		<form method="post" action="?edit={$PlData.id}">
			<table border="0" class="table" style="width:380px">
				<tr name="personalData_edit">
					<td style="width:70px">Imie</td>
					<td name="personalData_edit" style="width:270px">
						<div name="show">{$PlData.user}</div>
						<div name="edit" style="display:none"><input type="text" name="user" value="{$PlData.user}"/></div>
					</td>
				</tr>
				<tr>
					<td>E-mail</td>
					<td name="personalData_edit">
						<div name="show">{$PlData.email}</div>
						<div name="edit" style="display:none"><input type="text" name="email" value="{$PlData.email}"/></div>
					</td>
				</tr>
				<tr>
					<td>Ranga</td>
					<td>{$PlData.rank_name}</td>
				</tr>
				<tr>
					<td>Klan</td>
					<td>{if $PlData.tribe}{$PlData.tribe_name}{else}<i>brak klanu</i>{/if}</td>
				</tr>
				<tr>
					<td>Rasa</td>
					<td name="personalData_edit">
						<div name="show">{$PlData.rasa}</div>
						<div name="edit" style="display:none">
							<select name="rasa">
								<option value="" {if $PlData.rasa==''}selected{/if}>Brak</option>
								<option value="Czlowiek" {if $PlData.rasa=='Czlowiek'}selected{/if}>Czlowiek</option>
								<option value="Elf" {if $PlData.rasa=='Elf'}selected{/if}>Elf</option>
								<option value="Elf Sloneczny" {if $PlData.rasa=='Elf Sloneczny'}selected{/if}>Elf Sloneczny</option>
								<option value="Krasnolud" {if $PlData.rasa=='Krasnolud'}selected{/if}>Krasnolud</option>
								<option value="Hobbit" {if $PlData.rasa=='Hobbit'}selected{/if}>Hobbit</option>
								<option value="Jaszczuroczlek" {if $PlData.rasa=='Jaszczuroczlek'}selected{/if}>Jaszczuroczlek</option>
								<option value="Drow" {if $PlData.rasa=='Drow'}selected{/if}>Drow</option>
								<option value="Nieumarly" {if $PlData.rasa=='Nieumarly'}selected{/if}>Nieumarly</option>
								<option value="Smokokrwisty" {if $PlData.rasa=='Smokokrwisty'}selected{/if}>Smokokrwisty</option>
								<option value="Wampir" {if $PlData.rasa=='Wampir'}selected{/if}>Wampir</option>
								<option value="Wilkolak" {if $PlData.rasa=='Wilkolak'}selected{/if}>Wilkolak</option>
								<option value="Kurtr" {if $PlData.rasa=='Kurtr'}selected{/if}>Kurtr</option>
								<option value="Polelf" {if $PlData.rasa=='Polelf'}selected{/if}>Polelf</option>
								<option value="Polork" {if $PlData.rasa=='Polork'}selected{/if}>Polork</option>
								<option value="Nimfa" {if $PlData.rasa=='Nimfa'}selected{/if}>Nimfa</option>
							</select>
						</div>
					</td>
				</tr>
				<tr>
					<td>Charakter</td>
					<td name="personalData_edit">
						<div name="show">{$PlData.charakter}</div>
						<div name="edit" style="display:none">
							<select name="charakter">
								<option value="" {if $PlData.charakter==''}selected{/if}>Brak</option>
								<option value="Anielski" {if $PlData.charakter=='Anielski'}selected{/if}>Anielski</option>
								<option value="Chaotyczny dobry" {if $PlData.charakter=='Chaotyczny dobry'}selected{/if}>Chaotyczny Dobry</option>
								<option value="Praworzadny Dobry" {if $PlData.charakter=='Praworzadny Dobry'}selected{/if}>Praworzadny Dobry</option>
								<option value="Dobry" {if $PlData.charakter=='Dobry'}selected{/if}>Dobry</option>
								<option value="Praworzadny Neutralny" {if $PlData.charakter=='Praworzadny Neutralny'}selected{/if}>Praworzadny Neutralny</option>
								<option value="Chaotycznie Neutralny" {if $PlData.charakter=='Chaotycznie Neutralny'}selected{/if}>Chaotycznie Neutralny</option>
								<option value="Neutralny" {if $PlData.charakter=='Neutralny'}selected{/if}>Neutralny</option>
								<option value="Prawozadny Zly" {if $PlData.charakter=='Prawozadny Zly'}selected{/if}>Paworzadny Zly</option>
								<option value="Zly" {if $PlData.charakter=='Zly'}selected{/if}>Zly</option>
								<option value="Chaotyczny zly" {if $PlData.charakter=='Chaotyczny zly'}selected{/if}>Chaotyczny Zly</option>
								<option value="Diaboliczny" {if $PlData.charakter=='Diaboliczny'}selected{/if}>Diaboliczny</option>
							</select>
						</div>
					</td>
				</tr>
				<tr>
					<td>Oczy</td>
					<td name="personalData_edit">
						<div name="show">{$PlData.oczy}</div>
						<div name="edit" style="display:none">
							<select name="oczy">
								<option value="" {if $PlData.oczy==""}selected{/if}>Brak</option>
								<option value="Niebieskie" {if $PlData.oczy=="Niebieskie"}selected{/if}>Niebieskie</option>
								<option value="Piwne" {if $PlData.oczy=="Piwne"}selected{/if}>Piwne</option>
								<option value="Brazowe" {if $PlData.oczy=="Brazowe"}selected{/if}>Brazowe</option>
								<option value="Czarne" {if $PlData.oczy=="Czarne"}selected{/if}>Czarne</option>
								<option value="Czerwone" {if $PlData.oczy=="Czerwone"}selected{/if}>Czerwone</option>
								<option value="Zielone" {if $PlData.oczy=="Zielone"}selected{/if}>Zielone</option>
								<option value="Fioletowe" {if $PlData.oczy=="Fioletowe"}selected{/if}>Fioletowe</option>
								<option value="Biale" {if $PlData.oczy=="Biale"}selected{/if}>Biale</option>
							</select>
						</div>
					</td>
				</tr>
				<tr>
					<td>Wlosy</td>
					<td name="personalData_edit">
						<div name="show">{$PlData.wlos}</div>
						<div name="edit" style="display:none">
							<select name="wlos">
								<option value="" {if $PlData.wlos==""}selected{/if}>Brak</option>
								<option value="Blond" {if $PlData.wlos=="Blond"}selected{/if}>Blond</option>
								<option value="Rudy" {if $PlData.wlos=="Rudy"}selected{/if}>Rudy</option>
								<option value="Kruczo czarne" {if $PlData.wlos=="Kruczo czarne"}selected{/if}>Kruczo Czarne</option>
								<option value="Brunet" {if $PlData.wlos=="Brunet"}selected{/if}>Brunet</option>
								<option value="Szatyn" {if $PlData.wlos=="Szatyn"}selected{/if}>Szatyn</option>
								<option value="Biale" {if $PlData.wlos=="Biale"}selected{/if}>Biale</option>
								<option value="Popielate" {if $PlData.wlos=="Popielate"}selected{/if}>Popielate</option>
								<option value="Lysy" {if $PlData.wlos=="Lysy"}selected{/if}>Lysy</option>
							</select>
						</div>
					</td>
				</tr>
				<tr>
					<td>Stan</td>
					<td name="personalData_edit">
						<div name="show">{$PlData.stan}</div>
						<div name="edit" style="display:none">
							<select name="stan">
								<option value="" {if $PlData.stan==""}selected{/if}>Brak</option>
								<option value="Wolny" {if $PlData.stan=="Wolny"}selected{/if}>Wolny</option>
								<option value="Zajety" {if $PlData.stan=="Zajety"}selected{/if}>Zajety</option>
							</select>
						</div>
					</td>
				</tr>
				<tr>
					<td>Bostwo</td>
					<td name="personalData_edit">
						<div name="show">{$PlData.deity}</div>
						<div name="edit" style="display:none">
							<select name="deity">
								<option value="" {if $PlData.deity==""}selected{/if}>Brak</option>
								<option value="Lathander" {if $PlData.deity=="Lathander"}selected{/if}>Lathander</option>
								<option value="Tempus" {if $PlData.deity=="Tempus"}selected{/if}>Tempus</option>
								<option value="Selune" {if $PlData.deity=="Selune"}selected{/if}>Selune</option>
								<option value="Tyr" {if $PlData.deity=="Tyr"}selected{/if}>Tyr</option>
								<option value="Bane" {if $PlData.deity=="Bane"}selected{/if}>Bane</option>
								<option value="Lolth" {if $PlData.deity=="Lolth"}selected{/if}>Lolth</option>
								<option value="Maska" {if $PlData.deity=="Maska"}selected{/if}>Maska</option>
								<option value="Shar" {if $PlData.deity=="Shar"}selected{/if}>Shar</option>
								<option value="Talos" {if $PlData.deity=="Talos"}selected{/if}>Talos</option>
							</div>
						</td>
					</tr>
					<tr>
						<td>Pochodzenie</td>
						<td name="personalData_edit">
							<div name="show">{$PlData.poch}</div>
							<div name="edit" style="display:none">
								<select name="poch">
									<option value="" {if $PlData.poch==""}selected{/if}>Brak</option>
									<option value="Athkatla" {if $PlData.poch=="Athkatla"}selected{/if}>Athkatla</option>
									<option value="Eshpurta" {if $PlData.poch=="Eshpurta"}selected{/if}>Eshpurta</option>
									<option value="Imnescar" {if $PlData.poch=="Imnescar"}selected{/if}>Imnescar</option>
									<option value="Wrota Baldura" {if $PlData.poch=="Wrota Baldura"}selected{/if}>Wrota Baldura</option>
									<option value="Asbravn" {if $PlData.poch=="Asbravn"}selected{/if}>Asbravn</option>
									<option value="Swiecowa Wie¿a" {if $PlData.poch=="Swiecowa Wie¿a"}selected{/if}>Swiecowa Wie¿a</option>
									<option value="Beregost" {if $PlData.poch=="Beregost"}selected{/if}>Beregost</option>
									<option value="Nashkel" {if $PlData.poch=="Nashkel"}selected{/if}>Nashkel</option>
									<option value="Proskur" {if $PlData.poch=="Proskur"}selected{/if}>Proskur</option>
									<option value="Iriaebor" {if $PlData.poch=="Iriaebor"}selected{/if}>Iriaebor</option>
									<option value="Murann" {if $PlData.poch=="Murann"}selected{/if}>Murann</option>
									<option value="Purskul" {if $PlData.poch=="Purskul"}selected{/if}>Purskul</option>
									<option value="Crimmor" {if $PlData.poch=="Crimmor"}selected{/if}>Crimmor</option>
									<option value="Keczulla" {if $PlData.poch=="Keczulla"}selected{/if}>Keczulla</option>
									<option value="Elturel" {if $PlData.poch=="Elturel"}selected{/if}>Elturel</option>
									<option value="Berdusk" {if $PlData.poch=="Berdusk"}selected{/if}>Berdusk</option>
									<option value="Greenest" {if $PlData.poch=="Greenest"}selected{/if}>Greenest</option>
									<option value="Brost" {if $PlData.poch=="Brost"}selected{/if}>Brost</option>
								</select>
							</div>
						</td>
					</tr>
					<tr>
						<td>Obecne miejscje</td>
						<td>{$PlData.miejsce}</td>
					</tr>
					<tr>
						<td>Zwierzecy towarzysz</td>
						<td name="personalData_edit">
							<div name="show">{$PlData.tow}</div>
							<div name="edit" style="display:none">
								<select name="tow">
									<option value="" {if $PlData.tow==""}selected{/if}>Brak</option>
									<option value="Sokol" {if $PlData.tow=="Sokol"}selected{/if}>Sokol</option>
									<option value="Lasica" {if $PlData.tow=="Lasica"}selected{/if}>Lasica</option>
									<option value="Szczur" {if $PlData.tow=="Szczur"}selected{/if}>Szczur</option>
									<option value="Pies" {if $PlData.tow=="Pies"}selected{/if}>Pies</option>
									<option value="Kot" {if $PlData.tow=="Kot"}selected{/if}>Kot</option>
									<option value="Pseudosmok" {if $PlData.tow=="Pseudosmok"}selected{/if}>Pseudosmok</option>
									<option value="Waz" {if $PlData.tow=="Waz"}selected{/if}>Waz</option>
								</select>
							</div>
						</td>
					</tr>
					<tr>
						<td>Klasa</td>
						<td name="personalData_edit">
							<div name="show">{$PlData.klasa}</div>
							<div name="edit" style="display:none">
								<select name="klasa">
									<option value="" {if $PlData.klasa==""}selected{/if}>Brak</option>
									<option value="Wojownik" {if $PlData.klasa=="Wojownik"}selected{/if}>Wojownik</option>
									<option value="Mag" {if $PlData.klasa=="Mag"}selected{/if}>Mag</option>
									<option value="Zlodziej" {if $PlData.klasa=="Zlodziej"}selected{/if}>Zlodziej</option>
									<option value="Rzemieslnik" {if $PlData.klasa=="Rzemieslnik"}selected{/if}>Rzemieslnik</option>
									<option value="Barbarzynca" {if $PlData.klasa=="Barbarzynca"}selected{/if}>Barbarzynca</option>
									<option value="Kaplan" {if $PlData.klasa=="Kaplan"}selected{/if}>Kaplan</option>
									<option value="Druid" {if $PlData.klasa=="Druid"}selected{/if}>Druid</option>
									<option value="Lowca" {if $PlData.klasa=="Lowca"}selected{/if}>Lowca</option>
								</select>
							</div>
						</td>
					</tr>
					<tr>
						<td>Poziom</td>
						<td name="personalData_edit">
							<div name="show">{$PlData.level}</div>
							<div name="edit" style="display:none">
								<input type="text" name="level" vartype="int" value="{$PlData.level}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					<tr>
						<td>Doswiadczenie</td>
						<td name="personalData_edit">
							<div name="show">{$PlData.exp}</div>
							<div name="edit" style="display:none">
								<input type="text" name="exp" vartype="int" value="{$PlData.exp}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					<tr>
						<td>Energia</td>
						<td name="personalData_edit">
							<div name="show">{$PlData.energy}</div>
							<div name="edit" style="display:none">
								<input type="text" name="energy" vartype="float" value="{$PlData.energy}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					<tr>
						<td>Energia maksymalna</td>
						<td name="personalData_edit">
							<div name="show">{$PlData.max_energy}</div>
							<div name="edit" style="display:none">
								<input type="text" name="max_energy" vartype="float" value="{$PlData.max_energy}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					<tr>
						<td>Astralne punkty</td>
						<td name="personalData_edit">
							<div name="show">{$PlData.ap}</div>
							<div name="edit" style="display:none">
								<input type="text" name="ap" vartype="int" value="{$PlData.ap}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					
					<tr>
						<td class="thead" colspan="2" style="text-align:center">Atrybuty</td>
					</tr>
					<tr>
						<td>Sila</td>
						<td name="personalData_edit">
							<div name="show">{$PlData.strength}</div>
							<div name="edit" style="display:none">
								<input type="text" name="strength" vartype="float" value="{$PlData.strength}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					<tr>
						<td>Zrecznosc</td>
						<td name="personalData_edit">
							<div name="show">{$PlData.agility}</div>
							<div name="edit" style="display:none">
								<input type="text" name="agility" vartype="float" value="{$PlData.agility}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					<tr>
						<td>Szybkosc</td>
						<td name="personalData_edit">
							<div name="show">{$PlData.szyb}</div>
							<div name="edit" style="display:none">
								<input type="text" name="szyb" vartype="float" value="{$PlData.szyb}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					<tr>
						<td>Wytrzymalosc</td>
						<td name="personalData_edit">
							<div name="show">{$PlData.wytrz}</div>
							<div name="edit" style="display:none">
								<input type="text" name="wytrz" vartype="float" value="{$PlData.wytrz}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					<tr>
						<td>Inteligencja</td>
						<td name="personalData_edit">
							<div name="show">{$PlData.inteli}</div>
							<div name="edit" style="display:none">
								<input type="text" name="inteli" vartype="float" value="{$PlData.inteli}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					<tr>
						<td>Wiedza</td>
						<td name="personalData_edit">
							<div name="show">{$PlData.wisdom}</div>
							<div name="edit" style="display:none">
								<input type="text" name="wisdom" vartype="float" value="{$PlData.wisdom}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					<tr>
						<td class="thead" colspan="2" style="text-align:center">Umiejetnosci</td>
					</tr>
					<tr>
						<td>Walka bronia</td>
						<td name="personalData_edit">
							<div name="show">{$PlData.atak}</div>
							<div name="edit" style="display:none">
								<input type="text" name="atak" vartype="float" value="{$PlData.atak}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					<tr>
						<td>Walka lukiem</td>
						<td name="personalData_edit">
							<div name="show">{$PlData.shoot}</div>
							<div name="edit" style="display:none">
								<input type="text" name="shoot" vartype="float" value="{$PlData.shoot}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					<tr>
						<td>Rzucanie czarow</td>
						<td name="personalData_edit">
							<div name="show">{$PlData.magia}</div>
							<div name="edit" style="display:none">
								<input type="text" name="magia" vartype="float" value="{$PlData.magia}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					<tr>
						<td>Uniki</td>
						<td name="personalData_edit">
							<div name="show">{$PlData.unik}</div>
							<div name="edit" style="display:none">
								<input type="text" name="unik" vartype="float" value="{$PlData.unik}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					<tr>
						<td>Alchemia</td>
						<td name="personalData_edit">
							<div name="show">{$PlData.alchemia}</div>
							<div name="edit" style="display:none">
								<input type="text" name="alchemia" vartype="float" value="{$PlData.alchemia}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					<tr>
						<td>Stolarstwo</td>
						<td name="personalData_edit">
							<div name="show">{$PlData.fletcher}</div>
							<div name="edit" style="display:none">
								<input type="text" name="fletcher" vartype="float" value="{$PlData.fletcher}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					<tr>
						<td>Kowalstwo</td>
						<td name="personalData_edit">
							<div name="show">{$PlData.ability}</div>
							<div name="edit" style="display:none">
								<input type="text" name="ability" vartype="float" value="{$PlData.ability}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					<tr>
						<td>Dowodzenie</td>
						<td name="personalData_edit">
							<div name="show">{$PlData.leadership}</div>
							<div name="edit" style="display:none">
								<input type="text" name="leadership" vartype="float" value="{$PlData.leadership}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					<tr>
						<td>Kucharstwo</td>
						<td name="personalData_edit">
							<div name="show">{$PlData.gotowanie}</div>
							<div name="edit" style="display:none">
								<input type="text" name="gotowanie" vartype="float" value="{$PlData.gotowanie}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					<tr>
						<td name="personalData_editBtn" colspan="2" style="text-align:right"><a href="javascript:void(0)" onclick="edit('personalData')">edytuj ta czesc</a></td>
					</tr>
				</table>
				
				<div name="personalData_tArea" style="display:none">
					Podaj powod, dla ktorego chcesz edytowac te dane :<br/>
					<textarea id="personalData-editReason" name="spc[editReason]" style="width:90%;height:150px;margin:3px auto"></textarea><br/>
					<input type="hidden" name="spc[modType]" value="personal"/>
					<input type="submit" value="kontunuuj" onclick="return validateAll( 'personalData' )"/>
				</div>
			</form>
		</div>
	</div>
	<div id="resourceData" class="sniffContainer">
		{assign value=$Sniff.resources var='PlRes'}
		<div class="sniffTitle">Bogactwa</div>
		<div>
			<form method="post" action="?edit={$PlData.id}">
				<table border="0" class="table" style="width:380px">
					<tr>
						<td style="width:70px">Zloto</td>
						<td style="width:270px" name="resourceData_edit">
							<div name="show">{$PlRes.gold}</div>
							<div name="edit" style="display:none">
								<input type="text" name="gold" vartype="int" value="{$PlRes.gold}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					<tr>
						<td>Zloto w banku</td>
						<td name="resourceData_edit">
							<div name="show">{$PlRes.bank}</div>
							<div name="edit" style="display:none">
								<input type="text" name="bank" vartype="int" value="{$PlRes.bank}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					<tr>
						<td>Mithril</td>
						<td name="resourceData_edit">
							<div name="show">{$PlRes.mithril}</div>
							<div name="edit" style="display:none">
								<input type="text" name="mithril" vartype="int" value="{$PlRes.mithril}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					<tr>
						<td>Miedz</td>
						<td name="resourceData_edit">
							<div name="show">{$PlRes.copper}</div>
							<div name="edit" style="display:none">
								<input type="text" name="copper" vartype="int" value="{$PlRes.copper}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					<tr>
						<td>Zelazo</td>
						<td name="resourceData_edit">
							<div name="show">{$PlRes.iron}</div>
							<div name="edit" style="display:none">
								<input type="text" name="iron" vartype="int" value="{$PlRes.iron}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					<tr>
						<td>Wegiel</td>
						<td name="resourceData_edit">
							<div name="show">{$PlRes.coal}</div>
							<div name="edit" style="display:none">
								<input type="text" name="coal" vartype="int" value="{$PlRes.coal}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					<tr>
						<td>Adamantium</td>
						<td name="resourceData_edit">
							<div name="show">{$PlRes.adamantium}</div>
							<div name="edit" style="display:none">
								<input type="text" name="adamantium" vartype="int" value="{$PlRes.adamantium}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					<tr>
						<td>Meteoryty</td>
						<td name="resourceData_edit">
							<div name="show">{$PlRes.meteor}</div>
							<div name="edit" style="display:none">
								<input type="text" name="meteor" vartype="int" value="{$PlRes.meteor}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					<tr>
						<td>Krysztaly</td>
						<td name="resourceData_edit">
							<div name="show">{$PlRes.crystal}</div>
							<div name="edit" style="display:none">
								<input type="text" name="crystal" vartype="int" value="{$PlRes.crystal}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					<tr>
						<td name="resourceData_editBtn" colspan="2" style="text-align:right"><a href="javascript:void(0)" onclick="edit('resourceData')">edytuj ta czesc</a></td>
					</tr>
				</table>
				<div name="resourceData_tArea" style="display:none">
					Podaj powod, dla ktorego chcesz edytowac te dane :<br/>
					<textarea id="resourceData-editReason" name="spc[editReason]" style="width:90%;height:150px;margin:3px auto"></textarea><br/>
					<input type="hidden" name="spc[modType]" value="resource"/>
					<input type="submit" value="kontunuuj" onclick="return validateAll( 'resourceData' )"/>
				</div>
			</form>
		</div>
	</div>
	<div id="homeData" class="sniffContainer">
		{assign value=$Sniff.house var='PlHome'}
		<div class="sniffTitle">Dom</div>
		<div>
			<form method="post" action="?edit={$PlData.id}">
				<table border="0" class="table" style="width:380px">
					<tr>
						<td style="width:70px">Wlasciciel</td>
						<td style="width:270px">{$PlHome.owner}</td>
					</tr>
					<tr>
						<td>Nazwa</td>
						<td name="homeData_edit">
							<div name="show">{$PlHome.name}</div>
							<div name="edit" style="display:none">
								<input type="text" name="name" value="{$PlHome.name}" />
							</div>
						</td>
					</tr>
					<tr>
						<td>Rozmiar</td>
						<td name="homeData_edit">
							<div name="show">{$PlHome.size}</div>
							<div name="edit" style="display:none">
								<input type="text" name="size" vartype="int" value="{$PlHome.size}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					<tr>
						<td>Wartosc</td>
						<td name="homeData_edit">
							<div name="show">{$PlHome.value}</div>
							<div name="edit" style="display:none">
								<input type="text" name="value" vartype="int" value="{$PlHome.value}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					<tr>
						<td>Szafy</td>
						<td name="homeData_edit">
							<div name="show">{$PlHome.wardrobe}</div>
							<div name="edit" style="display:none">
								<input type="text" name="wardrobe" vartype="int" value="{$PlHome.wardrobe}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					<tr>
						<td>Punkty bud.</td>
						<td name="homeData_edit">
							<div name="show">{$PlHome.points}</div>
							<div name="edit" style="display:none">
								<input type="text" name="points" vartype="int" value="{$PlHome.points}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					
					<tr>
						<td>Uzyte pkt. bud.</td>
						<td name="homeData_edit">
							<div name="show">{$PlHome.used}</div>
							<div name="edit" style="display:none">
								<input type="text" name="used" vartype="int" value="{$PlHome.used}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					<tr>
						<td>Wspolokator</td>
						<td name="homeData_edit">
							<div name="show">{$PlHome.locator}</div>
							<div name="edit" style="display:none">
								<input type="text" name="locator" vartype="int" value="{$PlHome.locator}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					<tr>
						<td>Kosz (sprzedaz)</td>
						<td name="homeData_edit">
							<div name="show">{$PlHome.cost}</div>
							<div name="edit" style="display:none">
								<input type="text" name="cost" vartype="int" value="{$PlHome.cost}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					<tr>
						<td>Sprzedawca (sprzedaz)</td>
						<td name="homeData_edit">
							<div name="show">{$PlHome.seller}</div>
							<div name="edit" style="display:none">
								<input type="text" name="seller" vartype="int" value="{$PlHome.seller}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					<tr>
						<td name="homeData_editBtn" colspan="2" style="text-align:right"><a href="javascript:void(0)" onclick="edit('homeData')">edytuj ta czesc</a></td>
					</tr></tr>
					
				</table>
				<div name="homeData_tArea" style="display:none">
					Podaj powod, dla ktorego chcesz edytowac te dane :<br/>
					<textarea id="homeData-editReason" name="spc[editReason]" style="width:90%;height:150px;margin:3px auto"></textarea><br/>
					<input type="hidden" name="spc[modType]" value="house"/>
					<input type="submit" value="kontunuuj" onclick="return validateAll( 'homeData' )"/>
				</div>
			</form>
		</div>
	</div>
	<div id="outpostData" class="sniffContainer">
		{assign value=$Sniff.outpost var='PlOut'}
		<div class="sniffTitle">Straznica</div>
		<div>
			<form method="post" action="?edit={$PlData.id}">
				<table border="0" class="table" style="width:380px">
					<tr>
						<td style="width:70px">ID Straznicy</td>
						<td style="width:270px">{$PlOut.id}</td>
					</tr>
					<tr>
						<td>Rozmiar</td>
						<td name="outpostData_edit">
							<div name="show">{$PlOut.size}</div>
							<div name="edit" style="display:none">
								<input type="text" name="size" value="{$PlOut.size}" />
							</div>
						</td>
					</tr>
					<tr>
						<td>Zloto</td>
						<td name="outpostData_edit">
							<div name="show">{$PlOut.gold}</div>
							<div name="edit" style="display:none">
								<input type="text" name="gold" vartype="int" value="{$PlOut.gold}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					<tr>
						<td>Wojownikow</td>
						<td name="outpostData_edit">
							<div name="show">{$PlOut.warriors}</div>
							<div name="edit" style="display:none">
								<input type="text" name="warriors" vartype="int" value="{$PlOut.warriors}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					<tr>
						<td>Lucznikow</td>
						<td name="outpostData_edit">
							<div name="show">{$PlOut.archers}</div>
							<div name="edit" style="display:none">
								<input type="text" name="archers" vartype="int" value="{$PlOut.archers}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					<tr>
						<td>Katapult</td>
						<td name="outpostData_edit">
							<div name="show">{$PlOut.catapults}</div>
							<div name="edit" style="display:none">
								<input type="text" name="catapults" vartype="int" value="{$PlOut.catapults}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					<tr>
						<td>Barykad</td>
						<td name="outpostData_edit">
							<div name="show">{$PlOut.barricades}</div>
							<div name="edit" style="display:none">
								<input type="text" name="barricades" vartype="int" value="{$PlOut.barricades}" onblur="validate(this)"/>
							</div>
						</td>
					</tr>
					<tr>
						<td name="outpostData_editBtn" colspan="2" style="text-align:right"><a href="javascript:void(0)" onclick="edit('outpostData')">edytuj ta czesc</a></td>
					</tr></tr>
				
			</table>
			<div name="outpostData_tArea" style="display:none">
				Podaj powod, dla ktorego chcesz edytowac te dane :<br/>
				<textarea id="outpostData-editReason" name="spc[editReason]" style="width:90%;height:150px;margin:3px auto"></textarea><br/>
				<input type="hidden" name="spc[modType]" value="outpost"/>
				<input type="submit" value="kontunuuj" onclick="return validateAll( 'outpostData' )"/>
			</div>
		</form>
	</div>
	</div>
	<div id="homeData" class="sniffContainer">
		{assign value=$Sniff.transfers var='PlTrans'}
		<div class="sniffTitle">Podejrzane transfery</div>
		<div>
			<table class="table">
				<tr>
					<td class="thead">Od</td>
					<td class="thead">Do</td>
					<td class="thead">Co</td>
					<td class="thead">Ilosc</td>
					<td class="thead">Data</td>
				</tr>
				{section name=tr loop=$PlTrans}
				{assign value=$PlTrans[tr] var='Tr'}
				<tr>
					<td><a href="view.php?vew={$Tr.from}">{$Tr.from_user}</a>({$Tr.from})</td>
					<td><a href="view.php?vew={$Tr.to}">{$Tr.to_user}</a>({$Tr.to})</td>
					<td>{$Tr.what}</td>
					<td>{$Tr.amount}</td>
					<td>{$Tr.date}</td>
				</tr>
				{sectionelse}
				<tr>
					<td colspan="5">Brak transferow</td>
				</tr>
				{/section}
			</table>
		</div>
	</div>
{/if}