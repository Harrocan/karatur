{literal}
<script type="text/javascript">
	var curClass = '';
	function toggleClassDesc( name ) {
		if( $( 'class-desc-' + curClass ) ) {
			$( 'class-desc-' + curClass ).style.display = "none";
		}
		curClass = name;
		if( $( 'class-desc-' + curClass ) ) {
			$( 'class-desc-' + curClass ).style.display = "block";
		}
	}
</script>
<style type="text/css">
	.class_cont{
	display:none;
	border:solid 2px #0c1115;
	}
	.class_title{
	background: #0c1115;
	font-size:1.3em;
	font-weight:bold;
	}
	.class_desc{
	padding-left:15px;
	}
</style>
{/literal}
"<i>wybacz wogle ze spytalem</i>" *starzec podrapal sie po glowie z mina grobowa lecz po chwili na jego twarzy radosny usmiech zawidnial a sam on spytal: *<i>"powiedz mi czymze sie zajmujesz i jaka twa profesja"</i>

<ul>
{section name=cs loop=$Classes}
{assign value=$Classes[cs] var='Item'}
	<input type="radio" name="class" value="{$Item.code_name}" id="class-{$Item.code_name}" onclick="toggleClassDesc( '{$Item.code_name}' )"/><label for="class-{$Item.code_name}">{$Item.name}</label><br/>
{/section}
</ul>
<input type="hidden" name="action" value="class"/>
{section name=cd loop=$Classes}
{assign value=$Classes[cd] var='Item'}
<div class="class_cont" id="class-desc-{$Item.code_name}">
	<div class="class_title">{$Item.name}</div>
	<div class="class_desc">
		{metaText value="class_desc-`$Item.code_name`"}
		{if $Item.str || $Item.dex || $Item.con || $Item.spd || $Item.int || $Item.wis}
		<br/>
		{$Item.name} posiada nastêpuj±ce modyfikatory przy wykupywaniu atrybutów za punkty AP : 
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
{/section}