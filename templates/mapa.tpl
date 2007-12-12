<script language="JavaScript" src="js/advajax.js"></script>
<script language="JavaScript" src="js/ajax_base.js"></script>
<script language="JavaScript" src="js/mapa.js"></script>

<div id="test"></div>
<div id="error" class="error" style="display:none"></div>
<div id="info" class="info" style="display:none"></div>

<div style="position:relative;height:700px;">
	<div style="position:absolute;top:30px;left:20px;width:250px;height:280px">
		<div style="position:absolute;width:250px;text-align:center" id="tabMapHead">
			trwa ladowanie mapy ...
		</div>
		<div style="position:absolute;top:120px;width:50px;height:50px">
			<img src="mapa/arroww.gif" onclick="move( 'left' )"/>
		</div>
		<div style="position:absolute;top:120px;left:200px;width:50px;height:50px">
			<img src="mapa/arrowe.gif" onclick="move( 'right' )"/>
		</div>
		<div style="position:absolute;top:20px;left:100px;width:50px;height:50px">
			<img src="mapa/arrown.gif" onclick="move( 'up' )"/>
		</div>
		<div style="position:absolute;top:220px;left:100px;width:50px;height:50px">
			<img src="mapa/arrows.gif" onclick="move( 'down' )"/>
		</div>
		<div style="position:absolute;top:70px;left:50px">
			{$MapStruct}
		</div>
		<div style="position:absolute;top:70px;left:50px">
			{$MapSpec}
		</div>
	</div>
	<div style="position:absolute;top:10px;left:280px">
		<img src="images/terrain/hills.jpg" class="mapLegend"> Wzgórza<br>
		<img src="images/terrain/low_mountains.jpg" class="mapLegend"> Niskie góry<br>
		<img src="images/terrain/high_mountain.jpg" class="mapLegend"> Wysokie góry<br>
		<img src="images/terrain/cliffs.jpg" class="mapLegend"> Klify<br>
		<img src="images/terrain/clear.jpg" class="mapLegend"> Pustkowia<br>
		<img src="images/terrain/grass.jpg" class="mapLegend"> Tereny trawiaste<br>
		<img src="images/terrain/forest.jpg" class="mapLegend"> Lasy<br>
		<img src="images/terrain/jungle.jpg" class="mapLegend"> D¿ungle<br>
		<img src="images/terrain/marsh.jpg" class="mapLegend"> Bagna<br>
		<img src="images/terrain/swamp.jpg" class="mapLegend"> Mokrad³a<br>
		<img src="images/terrain/moor.jpg" class="mapLegend"> Wrzosowiska<br>
		<img src="images/terrain/badlands.jpg" class="mapLegend"> Bezdro¿a<br>
		<img src="images/terrain/volcano.jpg" class="mapLegend"> Wulkany<br>
		<img src="images/terrain/glacier.jpg" class="mapLegend"> Lodowce<br>
		<img src="images/terrain/river.jpg" class="mapLegend"> Rzeki<br>
		<img src="images/terrain/subterrains.jpg" class="mapLegend"> Podziemne rzeki<br>
		<img src="images/terrain/sandy_desert.jpg" class="mapLegend"> Pustynie piaszczyste<br>
		<img src="images/terrain/rocky_desert.jpg" class="mapLegend"> Pustynie kamieniste
	</div>


	<div style="position: absolute;width:270px;top:300px">
		<table class="table" style="width:100%">
			<tr>
				<td class="thead">
					<b><i>Opis :</i></b>
				</td>
			</tr>
			<tr>
				<td id="cell-desc" style="padding-left:30px">
				</td>
			</tr>
			<tr>
				<td class="thead">
					<b><i>Geografia :</i></b>
				</td>
			</tr>
			<tr>
				<td id="cell-geo" style="padding-left:30px">
				</td>
			</tr>
			<tr>
				<td class="thead">
					<b><i>Natura :</i></b>
				</td>
			</tr>
			<tr>
				<td id="cell-nat" style="padding-left:30px">
				</td>
			</tr>
		</table>
	</div>
</div>