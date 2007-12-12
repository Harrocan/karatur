{literal}
<style type="text/css">
.map-btn{

background-color:yellow;
}
td.map-btn:hover{
background-color:orange;
}
.map-main{
width:320px;
height:320px;
overflow:hidden;
background-color:red;
}
#nodes {
border-top:solid 2px white;
margin: 5px auto;
padding-top: 5px;
}
#nodes .node-el {
border: solid 1px white;
margin: 1px;
}
.nodes-groups .node-el,
#nodes-sub .node-el {
display:inline;
border:solid 1px white;
padding:2px;
margin:1px;
line-height:20px;
color:white;
cursor:pointer;
}
.nodes-groups div.node-el:hover {
background-color: #333;
}
.img-stack {
width:40px;
height:40px;
text-align:left;
}
#mini-map{
width:100px;
height:100px;
background:red;
outline:green;
float:right;
position:relative;
}
#mini-map-box{
position:absolute;
outline:1px solid white;
background:gray;
}
#brush-info {
/*float:left;*/
background:green;
/*height:100%;*/
/*width:280px;*/
}

#div_tab{
background:red;
width: 162px;
}
.div_tab_row{
position:static;
/*padding:2px;*/
background:green;
clear:both;
}
.div_tab_cell{
position:static;
text-align:center;
vertical-align:middle;
width:40px;
height:40px;
background:blue;
/*margin:1px 0px 0px 1px;*/
/*margin:1px;*/
float:left;
font-size:0.8em;
}
</style>
<script type="text/javascript" src="js/ajax_base.js"></script>
<script type="text/javascript" src="js/advajax.js"></script>
<script type="text/javascript" src="js/level_editor.js"></script>
{/literal}

<!--<div style="margin:20px auto;padding:20px 10px; border:solid 2px white;position:relative">
<div><div><div>
	<img src="images/banner1.jpg" style="z-index:3;position:absolute;top:0px;left:0px;"/>
	<img src="images/alucard.gif" style="z-index:1;position:absolute;top:15px;left:15px;"/>
</div></div></div>
<img src="images/czlowiek.gif" style="z-index:4;position:absolute;top:10px;left:10px;"/>
</div>-->
<div>Uk³adanie kafelków</div>
<div>Zaznaczanie dostêpnych akcji</div>
<table cellpadding="0" cellspacing="2" style="width:380px; height:380px; margin:5px auto;position:relative;clear:both;">
	<tr>
		<td></td>
		<td class="map-btn" onclick="scrollMap( 'up' )">t</td>
		</td>
	</tr>
	<tr>
		<td class="map-btn" onclick="scrollMap( 'left' )">t</td>
		<td id='tm' class="map-main">
			<div id="tab-main" class="map-main" style="position:relative">
				<div id='level-main' style="position:absolute">f</div>
				
				<!--<div style="position:absolute;top:40px;left:40px"><img src="images/test.gif" style="z-index:3" /></div>-->
				<div id="brush-view" style="position:absolute;width:40px;height:40px;display:none;z-index:20"/></div>
				<div id="map-capt-area" style="width:380px;height:380px;position:absolute;z-index:999;"> </div>
			</div>
		</td>
		<td class="map-btn" onclick="scrollMap( 'right' )">t</td>
	</tr>
	<tr>
		<td></td>
		<td class="map-btn" onclick="scrollMap( 'down' )">t</td>
		</td>
	</tr>
</table>
<div style="float:left;width:280px;height:100px;background:orange">
	<div>Info o kafelku</div>
	<div id="brush-info">
		<span>
			Pole przekraczalne : 
			<input type="radio" id="brush-info-pass-yes" name="passable" onclick="setBrushPassable( 1 )"/>tak, 
			<input type="radio" id="brush-info-pass-no" name="passable" onclick="setBrushPassable( 0 )"/>nie
		</span>
	</div>
</div>
<div id="mini-map"><div id="mini-map-box" style="width:40px;height:40px;top:0px;left:0px;"></div></div>
<div id='nodes-container' style="clear:both">
	<h3 style="text-align:center">Kafelki</h3>
	<div class="nodes-groups" style="text-align:center">
		<div class="node-el" onclick="showBrushSub( 1 )">Poziom 1</div>
		<div class="node-el" onclick="showBrushSub( 2 )">Poziom 2</div>
		<div class="node-el" onclick="showBrushSub( 3 )">Poziom 3</div>
		<div class="node-el" onclick="showBrushSub( 4 )">Poziom 4</div>
	</div>
	<div id="nodes-sub"></div>
	<div id="nodes">Prosze czekaæ na za³adowanie kafelków z serwera</div>
</div>