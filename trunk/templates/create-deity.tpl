{literal}
<script type="text/javascript">
	var curDeity = '';
	function toggleDeityDesc( name ) {
		if( $( 'deity-desc-' + curDeity ) ) {
			$( 'deity-desc-' + curDeity ).style.display = "none";
		}
		curDeity = name;
		if( $( 'deity-desc-' + curDeity ) ) {
			$( 'deity-desc-' + curDeity ).style.display = "block";
		}
	}
</script>
<style type="text/css">
	.deity_cont{
	display:none;
	border:solid 2px #0c1115;
	}
	.deity_title{
	background: #0c1115;
	font-size:1.3em;
	font-weight:bold;
	}
	.deity_img{
	float:left;
	background: white;
	max-width:100px;
	}
	.deity_desc{
	padding-left:15px;
	}
</style>
{/literal}
<i>"a jak u Ciebie z wiara? ... kto jest patronem twej duszy w tym swiecie?"</i>

<ul>
{section name=ds loop=$Deity}
{assign value=$Deity[ds] var='Item'}
	<input type="radio" name="deity" value="{$Item}" id="race-{$Item}" onclick="toggleDeityDesc( '{$Item}' )"/><label for="deity-{$Item}">{$Item|ucfirst}</label><br/>
{/section}
</ul>
<input type="hidden" name="action" value="deity"/>
{section name=dd loop=$Deity}
{assign value=$Deity[dd] var='Item'}
<div class="deity_cont" id="deity-desc-{$Item}">
	<div class="deity_title">{$Item|ucfirst}</div>
	<div class="deity_desc">
		<img class="deity_img" src="images/deity/{$Item}.gif"/>
		{metaText value="deity_desc-`$Item`"}
		<div style="clear:both">&nbsp;</div>
	</div>
</div>
{/section}
