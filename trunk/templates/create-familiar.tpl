{literal}
<script type="text/javascript">
	var curFam = '';
	function toggleFamDesc( name ) {
		if( $( 'fam-desc-' + curFam ) ) {
			$( 'fam-desc-' + curFam ).style.display = "none";
		}
		curFam = name;
		if( $( 'fam-desc-' + curFam ) ) {
			$( 'fam-desc-' + curFam ).style.display = "block";
		}
	}
</script>
<style type="text/css">
	.fam_cont{
	display:none;
	border:solid 2px #0c1115;
	}
	.fam_title{
	background: #0c1115;
	font-size:1.3em;
	font-weight:bold;
	}
	.gfam_desc{
	padding-left:15px;
	}
</style>
{/literal}

<i>"widze masz ze soba mala sakiewke .. pewnie znajduje sie w niej pamiatka po twych przyjazniach z mlodzienczych lat .. czyz nie ?... no a powiedz mi jakie twe najlepsze zwierze?.."</i>

<ul>
{foreach from=$Fam item='Item' key='Key'}
	<input type="radio" name="familiar" value="{$Key}" id="fam-{$Key}" onclick="toggleFamDesc( '{$Key}' )"/><label for="race-{$Key}">{$Item.name}</label><br/>
{/foreach}
</ul>

<input type="hidden" value="familiar" name="action"/>
{foreach from=$Fam item='Item' key='Key'}
<div class="fam_cont" id="fam-desc-{$Key}">
	<div class="fam_title">{$Item.name}</div>
	<div class="fam_desc">
		{metaText value="familiar_desc-`$Key`"}
		{if $Item.str || $Item.dex || $Item.con || $Item.spd || $Item.int || $Item.wis}
		<br/>
		{$Item.name} wybrany na Tojego towarzysza daje Ci nastêpuj±ce bonusy do atrybutów 
		<ul style="margin:0px;">
			{if $Item.str}{$Item.str} si³y<br/>{/if}
			{if $Item.dex}{$Item.dex} zrêczon¶ci<br/>{/if}
			{if $Item.con}{$Item.con} kondycji<br/>{/if}
			{if $Item.spd}{$Item.spd} szybko¶ci<br/>{/if}
			{if $Item.int}{$Item.int} intelignecji<br/>{/if}
			{if $Item.wis}{$Item.wis} si³y woli<br/>{/if}
		</ul>
		{/if}
	</div>
</div>
{/foreach}