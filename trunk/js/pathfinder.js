function markPath( path, maxfields ) {
	//updateView();
	var pl = players.getByType( 'pl' )[0];
	for( var i = 1; i < path.length-1; i++ ) {
		if( i <= maxfields ) {
			document.getElementById( path[i].x + '_' + path[i].y ).innerHTML = '<img src=images/map/spc_exit.gif>';
		}
		else{
			document.getElementById( path[i].x + '_' + path[i].y ).innerHTML = '<img src=images/map/spc_gray.gif>';
		}
	}
	document.getElementById( path[path.length-1].x + '_' + path[path.length-1].y ).innerHTML = '<img //src=images/map/spc_starte.gif>';
	document.getElementById( pl.x + '_' + pl.y ).innerHTML = '<img src=images/map/spc_startp.gif>';
	
}

function resetPath( path ) {
	var pl = players.getByType( 'pl' )[0];
	if( !path ) {
		return;
	}
	if( path.length > 0 ) {
		for( var i = 1; i < path.length; i++ ) {
			var node = $( path[i].x + '_' + path[i].y );
			if( node.getAttribute( 'fov' ) == 'fog' ) {
				node.innerHTML ='<img src="images/map/fov_fog.png">';
			}
			else {
				node.innerHTML = '';
			}
			//document.getElementById( path[i].x + '_' + path[i].y ).innerHTML = '';
		}
	}
	document.getElementById( pl.x + '_' + pl.y ).innerHTML = '<img src=images/map/spc_startp.gif>';
}

function pathfinder( source, target ) {
	this.end = new Object();
	this.end.x = new Number( target.getAttribute( 'x' ) );
	this.end.y = new Number( target.getAttribute( 'y' ) );
	this.start = new Object();
	this.start.x = new Number( source.getAttribute( 'x' ) );
	this.start.y = new Number( source.getAttribute( 'y' ) );
	this.openNodes = new Array();
	this.closedNodes = new Array();
	this.path = new Array();
	
	this.findPath = pf_findPath;
	this.getLow = pf_getLow;
	this.inArray = pf_inArray;
	this.around = pf_around;
	this.isBlocked = pf_isBlocked;
	this.isDiagonal = pf_isDiagonal;
	this.count = pf_count;
	this.getItem = pf_getItem;
	this.reset = pf_reset;
	this.mod = pf_mod;
}

function pf_reset( path ) {
	if( path.length > 0 ) {
		for( var i = 0; i < path.length; i++ ) {
			document.getElementById( path[i].x + '_' + path[i].y ).innerHTML = '';
		}
	}
	document.getElementById( this.start.x + '_' + this.start.y ).innerHTML = 's';
	//this.openNodes = new Array();
	//this.closedNodes = new Array();
	//this.path = new Array();
}

function pf_findPath() {
	var tmp = new Object();
	tmp.x = this.start.x;
	tmp.y = this.start.y;
	tmp.px = 0;
	tmp.py = 0;
	tmp.f = 0;
	tmp.g = 0;
	tmp.h = 0;
	this.openNodes.push( tmp );
	var low = this.getLow();
	do{
		
		this.around( low );
		if( this.count( this.openNodes ) <= 0 ) {
			break;
		}
		low = this.getLow( this.openNodes );
		try {
			if( low.x == this.end.x && low.y == this.end.y ) {
				break;
			}
		}
		catch( e ) {
			alert( "error ! amount :" + this.count( this.openNodes ) );
		}
		if( this.count( this.openNodes ) <= 0 ) {
			break;
		}
	} while( true );
	
	if( low.x == this.end.x && low.y == this.end.y ) {
		//path = new Array();
		var item = this.getItem( this.openNodes, this.end.x, this.end.y );
		do{
			//document.getElementById( item.x + '_' + item.y ).innerHTML += ' p' + i;
			var tmp = new Object();
			tmp.x = item.x;
			tmp.y = item.y;
			this.path.unshift( tmp );
			if( item.x == this.start.x && item.y == this.start.y ) {
				break;
			}
			item = this.getItem( this.openNodes, item.px, item.py );
		} while( true );

		return this.path;
		//for( var i = 0; i < this.path.length; i++ ) {
		//	document.getElementById( this.path[i].x + '_' + this.path[i].y ).innerHTML = '<img src=images/map/spc_exit.gif>';
		//}
		//document.getElementById( this.end.x + '_' + this.end.y ).innerHTML = '<img //src=images/map/spc_starte.gif>';
		//document.getElementById( this.start.x + '_' + this.start.y ).innerHTML = '<img src=images/map/spc_startp.gif>';
		//alert( "Sciezka znaleziona" );
		//return this.path;
	}
	else {
 		//document.getElementById( this.end.x + '_' + this.end.y ).innerHTML = '<img src=images/map/spc_highblock.gif>';
		//document.getElementById( this.start.x + '_' + this.start.y ).innerHTML = '<img src=images/map/spc_startp.gif>';
		//alert( "Sciezka nie znaleziona" );
		return false;
	}
	
 	
	
}

function pf_getLow() {
	var min = 99999;
	var minItem;
	for( var i = 0; i < this.openNodes.length; i++ ) {
		//if( tab[i] == undefined ) {
		//	continue;
		//}
		if( this.inArray( this.closedNodes, this.openNodes[i] ) ) {
			continue;
		}
		if( this.openNodes[i].f < min ) {
			min = this.openNodes[i].f;
			minItem = this.openNodes[i];
		}
	}
	//alert( "min item for : " + minItem.x + "x" + minItem.y );
	return minItem;
}

function pf_inArray( array, item ) {
	for( var i = 0; i < array.length; i++ ) {
		if( array[i].x  == item.x && array[i].y == item.y ) {
			return true;
		}
	}
	return false;
}

function pf_isBlocked( node ) {
	if( node.getAttribute( 'option' ) == 'block' ) {
		return true;
	}
	if( node.getAttribute( 'option' ) == 'highblock' ) {
		return true;
	}
	if( node.getAttribute( 'fov' ) == 'hidden' ) {
		return true;
	}
	if( node.getAttribute( 'fId' )  ) {
		return true;
	}
	return false;
}

function pf_isDiagonal( sx, sy, dx, dy ) {
	if( sx != dx && sy != dy ) {
		return true;
	}
	return false;
}

function pf_count( array ) {
	amount = 0;
	for( var i = 0; i < array.length; i++ ) {
		if( this.inArray( this.closedNodes, array[i] ) ) {
			continue;
		}
		amount ++;
	}
	return amount;
}

function pf_getItem( array, tx, ty ) {
	for( var i = 0; i < array.length; i++ ) {
		if( array[i].x == tx && array[i].y == ty ) {
			return array[i];
		}
	}
}

function pf_mod( val ) {
	if( val < 0 ) {
		val = -val;
	}
	return val;
}

function pf_around( item ) {
	for( var i = item.x - 1; i <= item.x + 1; i++ ) {
		for( var j = item.y - 1; j <= item.y + 1; j++ ) {
			if( j < 0 || j >= map.y || i < 0 || i >= map.x ) {
				continue;
			}
			var node = document.getElementById( i + '_' + j );
			if( this.isBlocked( node ) ) {
				continue;
			}
			var cost = 500;
			if( this.isDiagonal( item.x, item.y, i, j ) ) {
				var dx = i - item.x;
				var dy = j - item.y;
				if( this.isBlocked( document.getElementById( ( item.x + dx ) + '_' + item.y ) ) || 
					this.isBlocked( document.getElementById( item.x + '_' + ( item.y + dy ) ) ) ) {
					continue;
				}
				cost = 2;
			}
			else {
				cost = 1;
			}
			var tmp = new Object();
			tmp.x = i;
			tmp.y = j;
			tmp.px = item.x;
			tmp.py = item.y;
			tmp.h = this.mod( i - this.end.x ) + this.mod( j - this.end.y );
			//tmp.h = calcH( i, j, this.end.x, this.end.y );
			tmp.g = item.g + cost;
			tmp.f = tmp.h + tmp.g;
			//node.innerHTML = 'f:' + tmp.f + ' h:' + tmp.h + ' g:' + tmp.g;
			if( this.inArray( this.closedNodes, tmp ) ) {
				//alert( "in mclosed, skipping" );
				continue;
			}
			if( this.inArray( this.openNodes, tmp ) ) {
				//var test = getItem( open, tmp.x, tmp.y );
				//if( test.f > tmp.f ) {
					//alert( "czas na modyfikacje ! test : " + test.x + 'x' + test.y + ' tmp : ' + tmp.x + 'x' + tmp.y );
				//	test.px = tmp.x;
				//	test.py = tmp.y;
				//}
				//alert( "in open, skippig" );
				continue;
			}
			this.openNodes.push( tmp );
			//inArray ++;
		}
	}
	//alert( "inserting to mclosed at " + inCArray );
	//delete open[ item.index ];
	this.closedNodes.push( item );
	//inCArray++;
}
