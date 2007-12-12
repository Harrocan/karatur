{literal}
<script type="text/javascript">
	var curGender = '';
	function toggleGenderDesc( name ) {
		if( $( 'gender-desc-' + curGender ) ) {
			$( 'gender-desc-' + curGender ).style.display = "none";
		}
		curGender = name;
		if( $( 'gender-desc-' + curGender ) ) {
			$( 'gender-desc-' + curGender ).style.display = "block";
		}
	}
</script>
<style type="text/css">
	.gender_cont{
	display:none;
	border:solid 2px #0c1115;
	}
	.gender_title{
	background: #0c1115;
	font-size:1.3em;
	font-weight:bold;
	}
	.gender_desc{
	padding-left:15px;
	}
</style>
{/literal}

*...po twych slowach starzec przetarl rekawem twarz i zmrozyl ponownie oczy jednak po chwili pokrecil glowa mowiac: <i>"I wzok juz nie ten .. wybacz lecz starosc wzrok mi zabrala i nie widze dokladnie kim jestes.. powiedz mi prosze Cie jaka twa plec?"</i>*
<br><br>
"<i>yy .. no tak .. jestem:</i>

<ul>
	<input type="radio" name="gender" value="male" id="gender-male" {if $Crt.race=='nymph'}disabled="disabled"{/if} onclick="toggleGenderDesc( 'male' )"/><label for="gender-male" {if $Crt.race=='nymph'}style="color:gray"{/if}>Mê¿czyzna</label><br/>
	<input type="radio" name="gender" value="female" id="gender-female" onclick="toggleGenderDesc( 'female' )"/><label for="gender-female">Kobieta</label><br/>
</ul>

<input type="hidden" value="gender" name="action"/>

<div class="gender_cont" id="gender-desc-male">
	<div class="gender_title">{$RaceName} mê¿czyzna</div>
	<div class="gender_desc">
		{metaText value="gender-male-`$Crt.race`-desc"}
	</div>
</div>

<div class="gender_cont" id="gender-desc-female">
	<div class="gender_title">{$RaceName} kobieta</div>
	<div class="gender_desc">
		{metaText value="gender-female-`$Crt.race`-desc"}
	</div>
</div>