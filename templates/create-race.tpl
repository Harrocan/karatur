{literal}
<script type="text/javascript">
	var curRace = '';
	function toggleRaceDesc( name ) {
		if( $( 'race-desc-' + curRace ) ) {
			$( 'race-desc-' + curRace ).style.display = "none";
		}
		curRace = name;
		if( $( 'race-desc-' + curRace ) ) {
			$( 'race-desc-' + curRace ).style.display = "block";
		}
	}
</script>
<style type="text/css">
	.race_cont{
	display:none;
	border:solid 2px #0c1115;
	}
	.race_title{
	background: #0c1115;
	font-size:1.3em;
	font-weight:bold;
	}
	.race_desc{
	padding-left:15px;
	}
</style>
{/literal}
*starzec spoglada sie na ciebie dokladnie swymi zmeczonymi oczyma po czym marszczy czolo i rzecze <i>"powiedz mi przyjacielu przedstawicielem jakiej rasy jestes?.."</i>*
<br><br>
*..po chwili odpowiadasz: * <i>"Wywodze sie z rasy potocznie zwanej:</i>

<ul>
{section name=rs loop=$Races}
{assign value=$Races[rs] var='Item'}
	<input type="radio" name="race" value="{$Item.code_name}" id="race-{$Item.code_name}" onclick="toggleRaceDesc( '{$Item.code_name}' )"/><label for="race-{$Item.code_name}">{$Item.name}</label><br/>
{/section}
</ul>
<input type="hidden" name="action" value="race"/>
{section name=rd loop=$Races}
{assign value=$Races[rd] var='Item'}
<div class="race_cont" id="race-desc-{$Item.code_name}">
	<div class="race_title">{$Item.name}</div>
	<div class="race_desc">
		{metaText value="race_desc-`$Item.code_name`"}
		<br/>
		Za 1 AP {$Item.name} dostaje : 
		<ul style="margin:0px;">
			{$Item.str} si³y<br/>
			{$Item.dex} zrêczno¶ci<br/>
			{$Item.con} wytrzyma³o¶ci<br/>
			{$Item.spd} szybko¶ci<br/>
			{$Item.int} intelignecji<br/>
			{$Item.wis} si³y woli<br/>
		</ul>
	</div>
</div>
{/section}
