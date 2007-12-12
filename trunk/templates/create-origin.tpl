{literal}
<script type="text/javascript">
	var curOrigin = '';
	function toggleOriginDesc( name ) {
		if( $( 'origin-desc-' + curOrigin ) ) {
			$( 'origin-desc-' + curOrigin ).style.display = "none";
		}
		curOrigin = name;
		if( $( 'origin-desc-' + curOrigin ) ) {
			$( 'origin-desc-' + curOrigin ).style.display = "block";
		}
	}
</script>
<style type="text/css">
	.origin_cont{
	display:none;
	border:solid 2px #0c1115;
	}
	.origin_title{
	background: #0c1115;
	font-size:1.3em;
	font-weight:bold;
	}
	.origin_desc{
	padding-left:15px;
	}
</style>
{/literal}
<i>"powiedz mi teraz z kad sie wywodzisz..."</i>

<ul>
{section name=os loop=$CityData}
{assign value=$CityData[os] var='Item'}
	<input type="radio" name="origin" value="{$Item.id}" id="origin-{$Item.id}" onclick="toggleOriginDesc( '{$Item.id}' )"/><label for="origin-{$Item.id}">{$Item.name}</label><br/>
{/section}
</ul>
<input type="hidden" name="action" value="origin"/>
{section name=od loop=$CityData}
{assign value=$CityData[od] var='Item'}
<div class="origin_cont" id="origin-desc-{$Item.id}">
	<div class="origin_title">{$Item.name}</div>
	<div class="origin_desc">
		{$Item.opis|default:"<i>niestety ale nie dysponujemy danymi dotycz±cymi tego miasta</i>"}
	</div>
</div>
{/section}