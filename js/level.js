var mapInfo = new Object();
var mapData = new Array();
var tilesPath = 'images/map_tiles/';

function init() {

	mapInfo.vx = 7;
	mapInfo.vy = 7;
	mapInfo.ox = 0;
	mapInfo.oy = 0;

	advAJAX.post( {
		url : 'ajax/ajax_level.php',
		queryString : 'action=fullMap',
		onSuccess : function( obj ) {
			respXml( obj.responseXML );
		}
	} );


}

function respXml( root ) {

	if( root.firstChild.tagName == 'error' ) {
		var errorNode = root.firstChild;
		alert( errorNode.textContent );
		return;
	}

	//do we have any new nodes to save ?
	var t_mapData = root.firstChild.getElementsByTagName('mapData')[0];
	if( t_mapData ) {
		//then process it
		processMapDataXML( t_mapData );
	}

	//is set any action to make ?
	var action = root.firstChild.getElementsByTagName('action')[0];
	if( action ) {
		//then execute it

		switch( action.textContent ) {
			case 'fullMap' : {
				//var t_mapData = root.firstChild.getElementsByTagName('mapData')[0];
				mapInfo.px = parseInt( root.firstChild.getElementsByTagName('mapInfo')[0].getElementsByTagName('posx')[0].textContent );
				mapInfo.py = parseInt( root.firstChild.getElementsByTagName('mapInfo')[0].getElementsByTagName('posy')[0].textContent );
				mapInfo.ox = mapInfo.px - Math.floor( mapInfo.vx/2 );
				mapInfo.oy = mapInfo.py - Math.floor( mapInfo.vy/2 );

				draw();

				for( var i = mapInfo.ox; i < mapInfo.ox + mapInfo.vx; i++ ) {
					for( var j = mapInfo.oy; j < mapInfo.oy + mapInfo.vy; j++ ) {
						updateCell( i, j );
					}
				}
				break;
			}
			case 'move' : {
				var t_mapInfo = root.firstChild.getElementsByTagName('mapInfo')[0];
				var oldPlPos = new Object();
				oldPlPos.x = mapInfo.px;
				oldPlPos.y = mapInfo.py;
				mapInfo.px = parseInt( t_mapInfo.getElementsByTagName( 'posx' )[0].textContent );
				mapInfo.py = parseInt( t_mapInfo.getElementsByTagName( 'posy' )[0].textContent );
				updateCell( oldPlPos.x, oldPlPos.y );
				updateCell( mapInfo.px, mapInfo.py );
				panView( action.getAttribute( 'dir' ) );
				break;
			}
		}
	}

	return;
}

function processMapDataXML( root ) {
	for( var i = 0; i < root.childNodes.length; i++ ) {
		var t_cell = root.childNodes[i];
		var t_x = t_cell.getAttribute( 'x' );
		var t_y = t_cell.getAttribute( 'y' );
		for( var j = 0; j < t_cell.childNodes.length; j++ ) {
			var t_img = t_cell.childNodes[j];
			for( var k = 0; k < t_img.childNodes.length; k++ ) {
				var t_entry = t_img.childNodes[k];
				var tmp = new Object();
				tmp.file = t_entry.getAttribute( 'file' );
				tmp.sub = t_entry.getAttribute( 'sub' );
				tmp.level = t_entry.getAttribute( 'level' );
				tmp.pass = t_entry.getAttribute( 'pass' );
				addMapImg( t_x, t_y, tmp.level, tmp );
				//updateCell( t_x, t_y );
			}
		}
	}
}

function addMapImg( x, y, level, data ) {
	if( !mapData[x] ) {
		mapData[x] = new Array();
	}
	if( !mapData[x][y] ) {
		mapData[x][y] = new Object();
	}
	if( !mapData[x][y]['img'] ) {
		mapData[x][y]['img'] = new Array();
	}
	if( !mapData[x][y]['img'][level] ) {
		mapData[x][y]['img'][level] = new Object();
	}
	mapData[x][y]['img'][level] = data;
	return;
}

function updateCell( x, y ) {
	if( x < 0 || y < 0 ) {
		return;
	}
	var cell = $( 'cell_' + x + 'x' + y );
	if( !cell ) {
		return;
	}
	var data = generateImgStack( x, y );

	while( cell.hasChildNodes() ) {
		cell.removeChild( cell.firstChild );
	}
	cell.appendChild( data );
}

function generateImgStack( x, y ) {
	var root = document.createElement( 'div' );

	if( !mapData[x] || !mapData[x][y] ) {
		return root;
	}
	var mapCell = mapData[x][y];

	root.className = 'img-stack';
	var cur = root;
	//for( var i in mapCell['img'] ) {
	for( var i = 0; i < mapCell['img'].length; i++ ) {
		if( !mapCell['img'][i] ) {
			continue;
		}
		var tmp = document.createElement( 'div' );
		tmp.className = 'img-stack';
		var path = tilesPath + '/' + mapCell['img'][i]['level'] + '/' + mapCell['img'][i]['sub'] + '/' + mapCell['img'][i]['file'];
		tmp.style.background = 'url( ' + path + ' )';
		tmp.style.zIndex = i*2;
		cur.appendChild( tmp );
		cur = tmp;
	}
	if( mapInfo.px == x && mapInfo.py == y ) {
		var tmpImg = new Image();
		tmpImg.src = 'images/map/player.gif';
		cur.appendChild( tmpImg );
	}
	else {
		//var tmpNode = document.createTextNode( x + 'x' + y );
		//cur.appendChild( tmpNode );
	}
	//cur.innerHTML = ' ';
	return root;
}

function draw() {
	var el = $( 'level-main' );
	var innerTree = document.createElement( 'div' );

	while( el.hasChildNodes() ) {
		el.removeChild( el.firstChild );
	}
	el.appendChild( innerTree );

	innerTree.id = 'div_tab';
	innerTree.style.top = '0px';
	innerTree.style.left = '0px';
	innerTree.style.width = (mapInfo.vx+0)*40 + 'px';
	innerTree.style.height = (mapInfo.vy+0)*40 + 'px';
	for( var i = mapInfo.ox; i < mapInfo.ox + mapInfo.vx; i++ ) {
		var tmpRow = document.createElement( 'div' );
		tmpRow.className = 'div_tab_row';
		innerTree.appendChild( tmpRow );
		for( var j = mapInfo.oy; j < mapInfo.oy + mapInfo.vy; j++ ) {
			tmpCell = document.createElement( 'div' );
			tmpCell.className = 'div_tab_cell';
			tmpCell.id = 'cell_' + i + 'x' + j;
			tmpCell.innerHTML= ' ';
			tmpRow.appendChild( tmpCell );
			updateCell( i, j );
		}
	}
}

function isPassable( x, y ) {
	if( !mapData[x] || !mapData[x][y] || !mapData[x][y]['img'] ) {
		return false;
	}
	for( var i in mapData[x][y]['img'] ) {
		if( parseInt( mapData[x][y]['img'][i]['pass'] ) == 0 ) {
			return false;
		}
	}
	return true;
}

function move( dir ) {
	var off = new Object();
	off.x = 0;
	off.y = 0;
	switch( dir ) {
		case 'up' : {
			off.x--;
			break;
		}
		case 'down' : {
			off.x++;
			break;
		}
		case 'left' : {
			off.y--;
			break;
		}
		case 'right' : {
			off.y++;
			break;
		}
		default : {
			return;
		}
	}

	if( !isPassable( mapInfo.px + off.x, mapInfo.py + off.y ) ) {
		alert( "can't move !" );
		return;
	}

	advAJAX.post( {
		url : 'ajax/ajax_level.php',
		queryString : 'action=move&dir='+dir,
		onSuccess : function( obj ) {
			//alert( obj.responseXml );
			//respManager( obj.responseText );
			respXml( obj.responseXML );
			//panView( dir );
			//refreshChat( -1 );
		}
	} );
}

function panView( dir ) {
	var tab = $( 'div_tab' );
	switch( dir ) {
		case 'down' : {
			/*tab.removeChild( tab.firstChild );
			var tmpRow = document.createElement( 'div' );
			tmpRow.className = 'div_tab_row';
			tab.appendChild( tmpRow );
			for( var i = 0; i < tab.firstChild.childNodes.length; i++ ) {
				var x = mapInfo.ox + mapInfo.vx;
				var y = mapInfo.oy + i;
				var tmpCell = document.createElement( 'div' );
				tmpRow.appendChild( tmpCell );
				tmpCell.className = 'div_tab_cell';
				tmpCell.id = 'cell_' + x + 'x' + y;
				tmpCell.innerHTML = ' ';
				updateCell( x, y );
			}*/
			mapInfo.ox++;
			draw();
			break;
		}
		case 'up' : {
			/*tab.removeChild( tab.lastChild );
			var tmpRow = document.createElement( 'div' );
			tmpRow.className = 'div_tab_row';
			tab.insertBefore( tmpRow, tab.firstChild );
			for( var i = 0; i < tab.lastChild.childNodes.length; i++ ) {
				var x = mapInfo.ox - 1;
				var y = mapInfo.oy + i;
				var tmpCell = document.createElement( 'div' );
				tmpCell.className = 'div_tab_cell';
				tmpCell.id = 'cell_' + x + 'x' + y;
				tmpRow.appendChild( tmpCell );
				tmpCell.innerHTML = ' ';
				updateCell( x, y );
			}*/
			mapInfo.ox--;
			draw();
			break;
		}
		case 'left' : {
//			for( var i = 0; i < tab.childNodes.length; i++ ) {
//				var x = mapInfo.ox + i;
//				var y = mapInfo.oy - 1;
//				var row = tab.childNodes[i];
//
//				var tmpCell = document.createElement( 'div' );
//				row.insertBefore( tmpCell, row.firstChild );
//				tmpCell.className = 'div_tab_cell';
//				tmpCell.id = 'cell_' + x + 'x' + y;
//				tmpCell.innerHTML = ' ';
//				updateCell( x, y );
//				//row.removeChild( row.lastChild );
//			}
//			for( var i = 0; i < tab.childNodes.length; i++ ) {
//				var row = tab.childNodes[i];
//				row.removeChild( row.lastChild );
//			}
			mapInfo.oy--;
			draw();
			break;
		}
		case 'right' : {
//			for( var i = 0; i < tab.childNodes.length; i++ ) {
//				var x = mapInfo.ox + i;
//				var y = mapInfo.oy + mapInfo.vy;
//				var row = tab.childNodes[i];
//
//				var tmpCell = document.createElement( 'div' );
//				row.appendChild( tmpCell );
//				tmpCell.className = 'div_tab_cell';
//				tmpCell.id = 'cell_' + x + 'x' + y;
//				tmpCell.innerHTML = ' ';
//				updateCell( x, y );
//				//row.removeChild( row.firstChild );
//			}
//			for( var i = 0; i < tab.childNodes.length; i++ ) {
//				var row = tab.childNodes[i];
//				row.removeChild( row.firstChild );
//			}
			mapInfo.oy++;
			draw();
			break;
		}
	}
}