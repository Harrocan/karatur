var mode = 'path';
var path;
var pf;
var map = new Object();
var players = new fighters();

function init() {
	var divTab = $('map');
	advAJAX.get( {
		group : 'mapInit',
		onGroupLeave : function() { loadMapData(); },
		url : 'ajax/ajax_combatMap.php?mode=raw&action=refreshMap',
		onSuccess : function( obj ) { rawResp( obj ); } 
	} );
	
	divTab.innerHTML = "trwa ladowanie mapy";
	setMode( 'path' );
}

function loadMapData() {
	advAJAX.get( { 
		url : 'ajax/ajax_combatMap.php?action=fighterData',
		onSuccess : function( obj ) { objResp( obj ); } 
	} );
}

function click( item ) {
//	var source = $( $('startx').value + '_' + $('starty').value );
	var pl = players.getByType( 'pl' )[0];
	var source = $( pl.x + '_' + pl.y );
	if( path != false ) {
		$('action').innerHTML = '';
		resetPath( path );
	}
	switch( mode ) {
		case 'path' : {
			pf = new pathfinder( source, item );
			path = pf.findPath();
			//$('test').innerHTML += path;
			if( path == false ) {
				alert( "Obecnie nie wiesz jaksie tam dostac!" );
			}
			if( path != false && path != undefined ) {
				markPath( path, 7 );
				$('action').innerHTML = "Zatwierdz droge ... <input id='move_btn' type=\"submit\" value=\"idz\" onclick=\"action('move');\" />";
			}
			break;
		}
		case 'target' : {
			var liner = new targetPicker( source, item );
			liner.getPerc();
			//liner.markLine();
			//var target = liner.end;
			//$( target.x + '_' + target.y ).setAttribute( 'class', 'target' );
			alert( "cover : " + liner.calcCover() );
			break;
		}
	}
}

function action( type ) {
	switch( type ) {
		case 'move' : {
			$('move_btn').disabled = 'disabled';
			var pl = players.getByType( 'pl' )[0];
			advAJAX.post( { 
				url : 'ajax/ajax_combatMap.php?action=move',
				queryString : 'plid='+pl.id+'&fromx='+pf.start.x+'&fromy='+pf.start.y+'&tox='+pf.end.x+'&toy='+pf.end.y,
				onSuccess : function( obj ) { objResp( obj ); } 
			} );
			//alert( pf.end.x + 'x' + pf.end.y );
			break;
		}
	}
}

function setMode( newMode ) {
	$( 'mode_' + mode ).style.color = 'gray';
	$( 'mode_' + newMode ).style.color = 'red';
	mode = newMode;
	//$('test').innerHTML = mode;
}

function objResp( ajax ) {
	//alert( "objresp" );
	var data = ajax.responseText;
	//$('test').innerHTML = data;
	var obj = resp2obj( data );
	//for( var val in obj ) {
	//	$('test').innerHTML += val + ' => ' + obj[val] + '<br>';
	//}
	switch( obj.type ) {
		case 'ERROR' : {
			showError( obj.value );
			break;
		}
		case 'FIGHTER_DATA' : {
			//for( var i = 0; i < obj.amount; i++ ) {
			//	for ( var t in obj[ 'f_' + i ] ) {
			//		$('test').innerHTML += t + ' => ' + obj[ 'f_' + i ][t] + '<br>';
			//	}
			//}
			var ppos = new Object();
			for( var i = 0; i < obj.amount; i++ ) {
				var item = obj[ 'f_' + i ];
				players.addNew( item );
				var tmp = item['x'] + '_' + item['y'];
				var node = $( tmp );
				//$('test').innerHTML += $(tmp).style.background;
				$('test').innerHTML += tmp + ' ';
				
				//switch( item['fType'] ) {
// 					case 'pl' : {
// 						ppos.x = new Number( item['x'] );
// 						ppos.y = new Number( item['y'] );
// 						node.innerHTML = '<img src="images/map/spc_startp.gif" />';
// 						break;
// 					}
// 					case 'en' : {
// 						node.innerHTML = '<img src="images/map/spc_starte.gif" style="-moz-opacity:0.4" />';
// 						break;
// 					}
// 				}
				node.setAttribute( 'fId', item['id'] );
				//if( ! $( 'test' ) ) {
				//	alert( "kupa !" );
				//}
				//$(tmp).innerHTML = obj[ 'f_' + i ].fType;
				//node.innerHTML = 'a';
			}
			updateView();
			//$('test').innerHTML = ppos.x + '_' + ppos.y + '|';
			//$( ppos.x + '_' + ppos.y ).innerHTML = 'h';
			
			//for( var i = ; i
			break;
		}
		case 'MOVE_OK' : {
			markFog();
			$('action').innerHTML = '';
			pl = players.getById( obj.pid );
			var oldnode = $( pl.x + '_' + pl.y );
			oldnode.removeAttribute( 'fId' );
			pl.x = obj.npos.x;
			pl.y = obj.npos.y;
			var newnode = $( pl.x + '_' + pl.y );
			newnode.setAttribute( 'fId', pl.id );
			updateView();
			break;
		}
	}
}

function markFog() {
	var rad = 7;
	var pl = players.getByType( 'pl' )[0];
	//pl = pl[0];
	for( var i = pl.x - rad; i <= pl.x + rad; i++ ) {
		for( var j = pl.y - rad; j <= pl.y + rad; j++ ) {
			if( i < 0 || j < 0 || i >= map.x || j >= map.y ) {
				continue;
			}
			if( inFov( pl.x, pl.y, i, j, rad ) ) {
				var lineTest = new targetPicker( $(pl.x+'_'+pl.y), $( i + '_' + j ) );
				lineTest.getPerc();
				if( lineTest.calcCover() < 1 ) {
					var node = $( i + '_' + j );
					node.setAttribute( 'fov', 'fog' );
					node.innerHTML ='<img src="images/map/fov_fog.png">';
					//node.style.MozOpacity = 0.5;
				}
			}
		}
	}
}

function updateView() {
	var rad = 7;
	var pl = players.getByType( 'pl' )[0];
	//pl = pl[0];
	for( var i = pl.x - rad; i <= pl.x + rad; i++ ) {
		for( var j = pl.y - rad; j <= pl.y + rad; j++ ) {
			if( i < 0 || j < 0 || i >= map.x || j >= map.y ) {
				continue;
			}
			if( inFov( pl.x, pl.y, i, j, rad ) ) {
				var lineTest = new targetPicker( $(pl.x+'_'+pl.y), $( i + '_' + j ) );
				lineTest.getPerc();
				if( lineTest.calcCover() < 1 ) {
					var node = $( i + '_' + j );
					node.setAttribute( 'class', '' );
					node.setAttribute( 'fov', 'none' );
					node.style.background = "url( 'images/map/" + node.getAttribute( 'tileno' ) + ".gif' );";
					node.innerHTML ='';
					//node.style.MozOpacity = 1;
					var en = players.getByPos( i, j );
					if( en ) {
						switch( en.fType ) {
							case 'en' : {
								node.innerHTML ='<img src="images/map/spc_starte.gif">';
								break;
							}
							case 'pl' : {
								node.innerHTML ='<img src="images/map/spc_startp.gif">';
								break;
							}
						}
						
					}
				}
						//var node = $( i + '_' + j );
						//node.innerHTML = 'f';
			}
					//else {
					//	var node = $( i + '_' + j );
					//	node.innerHTML = '<img src="images/map/fov_hidden.gif" />';
					//}
		}
	}
}

function rawResp( ajax ) {
	//alert( "rawresp" );
	var data = ajax.responseText;
	//$('test').innerHTML = data;
	var fields = data.split( '~' );
	switch( fields[0] ) {
		case 'ERR' : {
			showError( fields[1] );
			break;
		}
		case 'MAP' : {
			$('map').innerHTML = fields[1];
			var table = $('tab_map');
			var tds = table.getElementsByTagName('td');
			for( var i = 0; i < tds.length; i++ ) {
				tds[i].setAttribute( 'class', 'fov_hidden' );
				tds[i].setAttribute( 'fov', 'hidden' );
				//tds[i].style.background = "";
				//tds[i].innerHTML = '<img src="images/map/fov_hidden.gif" />';
			}
			map.x = $('mapx').value;
			map.y = $('mapy').value;
			break;
		}
	}
}

function inFov( sx, sy, tx, ty, rad ) {
	var val = Math.pow( tx - sx, 2 ) + Math.pow( ty - sy, 2 );
	if( val < 1.1 * Math.pow( rad, 2 ) ) {
		return true;
	}
	else {
		return false;
	}
}

function fighters() {
	this.fig = new Array();
	// FUNCTIONS
	this.addNew = f_addNew;
	this.getAll = f_getAll;
	this.getByType = f_getByType;
	this.getById = f_getById;
	this.getByPos = f_getByPos;
}

function f_addNew( item ) {
	this.fig.push( item );
}

function f_getAll() {
	return this.fig;
}

function f_getByType( type ) {
	var ret = new Array();
	for( var i = 0; i < this.fig.length; i++ ) {
		if( this.fig[i]['fType'] == type ) {
			ret.push( this.fig[i] );
		}
	}
	return ret;
}

function f_getById( id ) {
	for( var i = 0; i < this.fig.length; i++ ) {
		if( this.fig[i].id == id ) {
			return this.fig[i];
		}
	}
}

function f_getByPos( px, py ) {
	for( var i = 0; i < this.fig.length; i++ ) {
		if( this.fig[i].x == px && this.fig[i].y == py ) {
			return this.fig[i];
		}
	}
}