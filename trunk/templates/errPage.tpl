<html>
	<head>
		<title>{$Gamename} :: strona bledu</title>
		<link rel="Stylesheet" href="css/layout_out.css"/>
		<meta http-equiv="Content-Type" content="text/html; charset=iso8859-2"/>
		<link rel="shortcut icon" href="images/ikonka_KT.gif" type="image/gif"/>
		<meta http-equiv="Content-Language" content="pl"/>
	</head>
	<body>
		{literal}
		<style type="text/css">
			.title {
			text-align:center;
			font-weight:bold;
			font-size:1.5em !important;
			}
			.msg{
			text-align:center;
			}
		</style>
		{/literal}
		<div class="main_page">
			<img src="images/logo_kara.png" alt="Kara-Tur-MMORPG" style="margin:0px auto;display:block"/>
			<br/><br/>
			<div class="main">
                <div class="main_content">
                    <div style="text-align:center">
						<div class="title">{$Error.title}</div>
						<div class="msg">{$Error.msg}</div>
						<div style="border-top:solid 2px; width:50%;text-align:center;margin:5px auto 0px auto;padding-top:5px"><a href="{$Gameadress}">Wroc</a> do strony glownej</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>