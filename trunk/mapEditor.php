<html><head><title>Map editor - by IvaN</title>
<script language="JavaScript" src="js/mapEditor.js"></script>
</head>
<body onload="setMode('paint'); setTab('land')">
<?php

//echo "<script language=\"JavaScript\" src=\"js/mapEditor.js\"></script>";
?>

<table><tr><td width="100px">
<?php

require_once( "maps/map.php" );
$sizex = $map['x'];
$sizey = $map['y'];

echo "<div style='border-style:solid; width: ".(20*$sizex)."'><table border=\"1\" id='tab_map' cellpadding=0 cellspacing=0>\n";
for( $i = 0; $i < $sizex; $i++ ) {
	echo "<tr>";
	for( $j = 0; $j < $sizey; $j++ ) {
		$item = $map[$i][$j];
		if( !empty( $item['tiletype'] ) ) {
			echo "<td x='$i' y='$j' id='{$i}_{$j}' tileno='{$item['tilename']}' tiletype='{$item['tiletype']}' ";
			if( !empty( $item['option'] ) ) {
				echo "option='{$item['option']}'";
			}
			echo "style=\"width:20px; height:20px;background: url('images/map/{$map[$i][$j]['tilename']}.gif')\" onclick='click(this);'>";
		}
		else
			echo "<td x='$i' y='$j' id='{$i}_{$j}' style='width:20px; height:20px' onclick='click(this);'>";
		
		if( !empty( $item['option'] ) ) {
			echo "<img src='images/map/spc_{$item['option']}.gif' />";
		}
		else
			echo "&nbsp;";
		//echo "<td valign=\"middle\" align=\"center\" x='$i' y='$j' id='{$i}_{$j}' style='width:20px; height:20px' onclick='click(this);'>";
		//echo "&nbsp;";
		//echo "<img src='images/map/spc_map.gif' /><img src='images/map/spc_block.gif' /><img src='images/map/spc_highblock.gif' /><img src='images/map/spc_estart.gif' /><img src='images/map/spc_items.gif' /><img src='images/map/spc_exit.gif' />";
		echo "</td>";
	}
	echo "</tr>\n";
}
echo "</table></div>\n";
		echo "<div id='test'></div><br>";
?>
</td><td valign="top">
		<a href="javascript:void(0);" onclick="setMode('paint');">malowanie</a> <a href="javascript:void(0);" onclick="setMode('info');">informacje</a>
		<div id='info_tab' style="display:none">
			panel informacji
		</div>
		<div id='paint_tab' style="display:none">
			<table>
				<tr>
					<td>
						
						<a href="javascript:void(0);" onclick="setTab('land');">tereny</a>
						<a href="javascript:void(0);" onclick="setTab('water');">woda</a>
						
					</td>
				</tr>
				<tr>
					<td id="brushes">
					</td>
				</tr>
				<tr>
					<td>
						Dodatkowe opcje :<br>
		<input type="radio" name="option" onclick="setOption('none')" /> brak<br>
		<input type="radio" name="option" onclick="setOption('startp')" /> start graczy<br>
		<input type="radio" name="option" onclick="setOption('starte')" /> start przeciwnikow<br>
		<input type="radio" name="option" onclick="setOption('exit')" /> wyjscie<br>
		<input type="radio" name="option" onclick="setOption('items')" /> przedmioty<br>
		<input type="radio" name="option" onclick="setOption('block')" /> nie do przejscia<br>
		<input type="radio" name="option" onclick="setOption('highblock')" /> mur/sciana/itp<br>
					</td>
				</tr>
			</table>
		</div>
			<input type="checkbox" id="grid" onchange="changeGrid(this)" value="1" checked="checked"/> siatka	<input type="submit" value="gotowe !" onclick="sendMap()" /><br></td></tr><tr><td colspan="2">
		Zeby tworzyc mape - wybierz kafelek z dostepnych kategorii a potem klikaj na mapce. Zeby mapa sie nie rozjezdzala przy wstawianiu kropki z zakladki 'specjalne' wylacz siatke.</td></tr></table>
</body></html>