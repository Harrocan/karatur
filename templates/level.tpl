{literal}
<style type="text/css">
.map-btn{
background-color:yellow;
}
td.map-btn:hover{
background-color:orange;
}
.map-main{
width:280px;
height:280px;
overflow:hidden;
background-color:yellow;
}

.img-stack {
width:40px;
height:40px;
text-align:left;
}

#div_tab{
position:absolute;
background:red;
width: 162px;
overflow: hidden;
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
<script type="text/javascript" src="js/level.js"></script>
{/literal}

<table cellpadding="0" cellspacing="2" style="width:380px; height:380px; margin:5px auto;position:relative;clear:both;">
	<tr>
		<td></td>
		<td class="map-btn" onclick="move( 'up' )">t</td>
		<td style="width:46px;height:46px;text-align:center"><img id='level-loading' style="display:none" src="images/map/loading.gif"/></td>
	</tr>
	<tr>
		<td class="map-btn" onclick="move( 'left' )">t</td>
		<td id='tm' class="map-main">
			<div id="tab-main" class="map-main" style="position:relative">
				<div id='level-main' style="overflow:hidden;">f</div>
				<!--
				<div id="brush-view" style="position:absolute;width:40px;height:40px;display:none;z-index:20"/></div>
				<div id="map-capt-area" style="width:380px;height:380px;position:absolute;z-index:999;"> </div>
				-->
			</div>
		</td>
		<td class="map-btn" onclick="move( 'right' )">t</td>
	</tr>
	<tr>
		<td></td>
		<td class="map-btn" onclick="move( 'down' )">t</td>
		</td>
	</tr>
</table>