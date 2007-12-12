<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso8859-2">
		<title>KaraTur :: {$PageTitle}</title>
		<link rel="shortcut icon" href="images/ikonka_KT.gif" type="image/gif">
		<link rel="stylesheet" type="text/css" href="css/layout_out.css" />
		{literal}
		<script type="text/javascript">
		function $( id ) {
			return document.getElementById( id );
		}
		function _scroll( id, dir, m ) {
			if( m == undefined ) {
				m = 0;
			}
			var timeout = 40;
			var step = 4;
			var el = $( 'side_text_' + id );
			//var reg = /(\d*)/;
			//alert( Number( el.style.height ) );
			//var cur = Number( reg.exec( el.style.height )[1] );
			id = parseInt( id );
			var target = sideArr[id];
			//var cur = parseInt( el.style.height );
			//var cur = parseInt( window.getComputedStyle( el, 'div' ).height )
			var cur = el.clientHeight;
			var d = target - cur;
			if( d > 80 ) {
				step = 8;
			}
			else if( d > 40 ) {
				step = 4;
			}
			else if( d > 20 ) {
				step = 2;
			}
			else {
				step = 1;
			}
			
			if( m == 0 ) {
				if( isScroll[id] ) {
					return;
				}
			}
			else {
				isScroll[id] = true;
			}
			
			if( dir == 'up' ) {
				var end = 0;
				step = -step;
			}
			else {
				var end = target;
			}
			
			//left -= Math.abs( step );
			cur += step;
			if( cur < 0 ) {
				cur = 0;
			}
			
			el.style.height = cur + 'px';
			if( cur != end ) {
				setTimeout( "_scroll( " + id + ", '" + dir + "', 1 )", timeout);
			}
			else {
				if( dir == 'up' ) {
					dir = 'down';
				}
				else {
					dir = 'up';
				}
				isScroll[id] = false;
				$( 'side_head_' + id ).setAttribute( 'onclick', "_scroll( " + id + ", '" + dir + "')")
			}
		}
		var sideArr = new Array();
		var isScroll = new Array();
		function saveHeight( id, hide ) {
			if( hide == undefined ) {
				hide = true;
			}
			id = parseInt( id );
			var el = $( 'side_text_' + id );
			if( !el ) {
				return;
			}
			//sideArr[id] = parseInt( window.getComputedStyle( el, 'div' ).height );
			sideArr[id] = el.clientHeight;
			isScroll[id] = false;
			//alert( hide );
			if( hide ) {
				el.style.height = '0px'
				//el.clientHeight = 0;
			}
		}
		</script>
		{/literal}
	</head>
	<body>
		<div class="main_page">
			<img src="images/logo_kara.png" class="main_logo" />
			<div class="main_navigation">
				
				<div class="main_nav_entry"><a href="?">Strona gďż˝ďż˝wna</a></div>
				<div class="main_nav_entry"><a href="?step=aboutkt">O KaraTur</a></div>
				<div class="main_nav_entry"><a href="?step=register">Rejestracja</a></div>
				<div class="main_nav_entry"><a href="?step=rules">Kodeks</a></div>
				<div class="main_nav_entry"><a href="?step=team">KaraTur-Team</a></div>
				<img class="main_nav_left" src="images/layout_out/bar_left.png" />
				<img class="main_nav_right" src="images/layout_out/bar_right.png" />
			</div>
			<div class="main">
			<div class="main_content">
					<div class="sidebar" id="ie_error" style="display:none;border-color:red">
						<div class="sidebar_head" style="color:red;font-weight:bold;text-decoration:blink;font-size:13px">UWAGA</div>
						<div class="sidebar_text">
							Twoja przeglďż˝darka nie jest w stanie poprawnie wyświetlić tej strony internetowej.<br/><br/>
							Zalecamy korzystanie z popularniejszych oraz <b>bezpieczniejszych</b> przeglądarek niż <i>Internet Explorer</i><br/><br/><div style="text-align:center"><b>Dowiedz się czemu !</b><br/><a href="http://browsehappy.pl"><img src="http://browsehappy.pl/2.png" alt="Nowoczesne przeglďż˝darki" border="0"></a></div>
						</div>
					</div>
					{literal}
					<script type="text/javascript">
					userAg = navigator.userAgent;
					if( userAg.indexOf( "MSIE" ) >= 0 ) {
						document.all["ie_error"].style.display = "block";
					}
					</script>
					{/literal}
					<div class="sidebar">
						<form method="post" action="login.php">
						<table align="center" class="main_login" cellpadding="0" cellspacing="0">
							<tr>
								<td style="width:30px" colspan="3">Zaloguj się</td>
							</tr>
							<tr>
								<td>Email</td><td><input type="text" name="email"/></td>
							</tr>
							<tr>
								<td>Hasło</td><td><input type="password" name="pass"/></td>
							</tr>
							<tr>
								<td colspan="2" style="text-align:right"><a href="?step=lostpaswd" style="float:left">zapomniasłem hasła</a><input type="submit" value="dalej"/></td>
							</tr>
						</table>
						</form>
					</div>
					<div class="sidebar">
						<div class="sidebar_head" id="side_head_0" onclick="_scroll( 0, 'down' )">Statystyki</div>
						<div class="sidebar_text" id="side_text_0">
							<div style="padding-left:20px;text-indent:-20px">Obecnie w grze : {$Stats.online} graczy</div>
							<div style="padding-left:20px;text-indent:-20px">Oogółem mieszkańców : {$Stats.total}</div>
							<div style="padding-left:20px;text-indent:-20px">Ostani przybyły do krainy : {$Stats.last_user}</div>
							<div style="padding-left:20px;text-indent:-20px">Przez krainę przewinęło się : {$Stats.last_id} osďż˝b</div>
						</div>
					</div>
					{literal}<script type="text/javascript">saveHeight(0)</script>{/literal}
					<div class="sidebar">
						<div class="sidebar_head" id="side_head_1" onclick="_scroll( 1, 'down' )">Galeria</div>
						<div class="sidebar_text" id="side_text_1">
							<div style="text-align:center;border-bottom:solid 1px;font-weight:bold;">Co nowego</div>
							{kt_gallery mode='last_updated' amount=4}
							<div style="text-align:center;border-bottom:solid 1px;font-weight:bold;">Najwięcej odsłon</div>
							{kt_gallery mode='most_view' amount=2}
						</div>
					</div>
					{literal}<script type="text/javascript">saveHeight(1)</script>{/literal}
					<div class="sidebar">
						<div class="sidebar_head" id="side_head_2" onclick="_scroll( 2, 'up' )">Pomóż nam</div>
						<div class="sidebar_text" id="side_text_2">
							<table style="margin:0px auto; width:170px">
							{section name=t loop=$Tops}
							{assign value=$Tops[t] var='Top'}
							<tr>
							<td style="position:relative;height:35px;text-align:center"><a href="out.php?id={$Top.id}" target="_blank">{$Top.entry}</a></td>
							</tr>
							{/section}
							</table>
						</div>
						{literal}
						<script type="text/javascript">saveHeight(2, false);
						var foo</script>
						{/literal}
					</div>