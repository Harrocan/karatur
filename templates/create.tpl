{literal}
<script type="text/javascript">
	function validateForm( step ) {
		var ret = false;
		switch( step ) {
			case 'welcome' : {
				ret = true;
				break;
			}
			case 'race' : {
				var inputs = document.getElementsByName( 'race' );
				for( var i = 0; i < inputs.length; i++ ) {
					var el = inputs[i];
					if( el.checked ) {
						ret = true;
					}
				}
				if( !ret ) {
					alert( "Wybierz rasê !" );
				}
				//var ret = false;
				break;
			}
			case 'gender' : {
				var inputs = document.getElementsByName( 'gender' );
				for( var i = 0; i < inputs.length; i++ ) {
					var el = inputs[i];
					if( el.checked ) {
						ret = true;
					}
				}
				if( !ret ) {
					alert( "Wybierz p³eæ !" );
				}
				//var ret = false;
				break;
			}
			case 'class' : {
				var inputs = document.getElementsByName( 'class' );
				for( var i = 0; i < inputs.length; i++ ) {
					var el = inputs[i];
					if( el.checked ) {
						ret = true;
					}
				}
				if( !ret ) {
					alert( "Wybierz klasê !" );
				}
				//var ret = false;
				break;
			}
			case 'deity' : {
				var inputs = document.getElementsByName( 'deity' );
				for( var i = 0; i < inputs.length; i++ ) {
					var el = inputs[i];
					if( el.checked ) {
						ret = true;
					}
				}
				if( !ret ) {
					alert( "Wybierz bóstwo !" );
				}
				//var ret = false;
				break;
			}
			case 'atr': {
				var left = Number( $( 'atr-left' ).innerHTML );
				if( left > 0 ) {
					alert( "Rozdaj wszystkie punkty !" );
					ret = false;
				}
				else {
					ret = true;
				}
				break;
			}
			case 'familiar' : {
				var inputs = document.getElementsByName( 'familiar' );
				for( var i = 0; i < inputs.length; i++ ) {
					var el = inputs[i];
					if( el.checked ) {
						ret = true;
					}
				}
				if( !ret ) {
					alert( "Wybierz towarzysza !" );
				}
				//var ret = false;
				break;
			}
			case 'origin' : {
				var inputs = document.getElementsByName( 'origin' );
				for( var i = 0; i < inputs.length; i++ ) {
					var el = inputs[i];
					if( el.checked ) {
						ret = true;
					}
				}
				if( !ret ) {
					alert( "Wybierz swoje pochodzenie !" );
				}
				//var ret = false;
				break;
			}
			case 'misc' : {
				ret = true;
				var selects = new Array( 'stan', 'char', 'wlos', 'oczy', 'skora' );
				for( var i = 0; i < selects.length; i++ ) {
					var el = $( 'misc-' + selects[i] );
					if( el.selectedIndex == 0 ) {
						ret = false;
						break;
					}
				}
				if( !ret ) {
					alert( "Wybierz wszystkie cechy !" );
				}
				break;
			}
			case 'done' : {
				ret = true;
				break;
			}
			default : {
				alert( "Can't validate for " + step + " !" );
				//ret = false;
			}
		}
		return ret;
	}
	function trySubmit( step ) {
		if( step == 'atr' ) {
			var form = $( 'create_form' );
			var atrArr = new Array( 'str', 'dex', 'con', 'int', 'wis', 'spd' );
			for( var i = 0; i < atrArr.length; i++ ) {
				var atr = atrArr[i];
				var val = Number( $( 'atr-' + atr + '-cur').innerHTML );
				//alert( atr + " : " + val );
				var f = document.createElement( 'input' );
				f.setAttribute( 'type', 'hidden' );
				f.setAttribute( 'name', 'atr['+atr+']' );
				f.setAttribute( 'value', val );
				form.appendChild( f );
			};
		}
	}
	function crt_reset() {
		if( confirm( "Czy na pewno chcesz wyczy¶ciæ wszystkie dane ?" ) ) {
			window.location = "?do=reset";
		}
	}
</script>
{/literal}
<form method="POST" action="?" id="create_form" onsubmit="trySubmit( '{$Step}' )">
<div>
{include file="create-$Step.tpl"}
</div>
{if !$Created}
<div style="text-align:center">
	<input type="submit" value="kontynuuj" onclick="return validateForm( '{$Step}' )"/>
	{if $Step=='done'}
	<input type="submit" value="wyczy¶æ" onclick="crt_reset();return false"/>
	{/if}
</div>
{/if}
</form>