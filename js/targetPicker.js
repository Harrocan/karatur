function targetPicker( source,target ) {
	this.start = new Object();
	this.start.x = new Number( source.getAttribute( 'x' ) );
	this.start.y = new Number( source.getAttribute( 'y' ) );
	this.end = new Object();
	this.end.x = new Number( target.getAttribute( 'x' ) );
	this.end.y = new Number( target.getAttribute( 'y' ) );
	this.a = ( this.end.y - this.start.y ) / ( this.end.x - this.start.x );
	this.b = this.start.y;
	this.x1 = this.start.x;
	this.line = new Array();
	
	this.getPerc = tp_getPerc;
	this.getLine = tp_getLine;
	this.isInLine = tp_isInLine;
	this.markLine = tp_markLine;
	this.calcCover = tp_calcCover;
	this.knownX = tp_knownX;
	this.knownY= tp_knownY;
}

function tp_getPerc() {
	if( this.isInLine() ) {
		
		return this.getLine();
		
	}
	var dx = this.start.x - this.end.x;
	var dy = this.start.y - this.end.y;
	if( Math.abs( dx ) >= Math.abs( dy ) ) {
		var start = Math.min( this.start.x, this.end.x );
		var end = Math.max( this.start.x, this.end.x );
		for( var i = start+1; i < end; i++ ) {
			
			var res = this.knownX( i );
			var fract = res - Math.floor( res );
			//document.getElementById( 'test' ).innerHTML += "X:"+i+" Y:"+res+" F:"+fract+"<br>";
			if( fract != 0 ) {
				if( fract < 0.5 ) {
					var mod = 1;
				}
				else {
					var mod = -1;
				}
				var tmp = new Object();
				tmp.x = i;
				tmp.y = Math.round( res );
				tmp.perc = fract;
				this.line.push( tmp );
				
				tmp = new Object();
				tmp.x = i;
				tmp.y = Math.round( res ) + mod;
				tmp.perc = Math.abs( fract - 1 );
				this.line.push( tmp );
			}
			else {
				var tmp = new Object();
				tmp.x = i;
				tmp.y = Math.round( res );
				tmp.perc = 1;
				this.line.push( tmp );
			}
		}
	}
	else {
		var start = Math.min( this.start.y, this.end.y );
		var end = Math.max( this.start.y, this.end.y );
		for( var i = start + 1; i< end; i++ ) {
			
			var res = this.knownY( i );
			var fract = res - Math.floor( res );
			//document.getElementById( 'test' ).innerHTML += "Y:"+i+" X:"+res+" F:"+fract+"<br>";
			if( fract != 0 ) {
				if( fract < 0.5 ) {
					var mod = 1;
				}
				else {
					var mod = -1;
				}
				var tmp = new Object();
				tmp.x = Math.round( res );
				tmp.y = i;
				tmp.perc = fract;
				this.line.push( tmp );
				
				tmp = new Object();
				tmp.x = Math.round( res ) + mod;
				tmp.y = i;
				tmp.perc = Math.abs( fract - 1 );
				this.line.push( tmp );
			}
			else {
				var tmp = new Object();
				tmp.x = Math.round( res );
				tmp.y = i;
				tmp.perc = 1;
				this.line.push( tmp );
			}
		}
	}
}

function tp_getLine() {
	if( Number( this.start.x ) == Number( this.end.x ) ) {
		//alert( "same x ");
		var start = Math.min( this.start.y, this.end.y );
		var end = Math.max( this.start.y, this.end.y );
		for( var i = start+1; i < end; i++ ) {
			var tmp = new Object();
			tmp.x = this.start.x;
			tmp.y = i;
			tmp.perc = 1;
			
			this.line.push( tmp );
		}
	}
	if( Number( this.start.y ) == Number( this.end.y ) ) {
		var start = Math.min( this.start.x, this.end.x );
		var end = Math.max( this.start.x, this.end.x );
		for( var i = start +1; i < end; i++ ) {
			var tmp = new Object();
			tmp.x = i;
			tmp.y = this.start.y;
			tmp.perc = 1;
			this.line.push( tmp );
		}
	}
	//else {
	///	 return Array();
	//}
}

function tp_isInLine() {
	//$('test').innerHTML += this.start.x + '==' + this.end.x + ' | ' + this.start.y + '==' + this.end.y + '<br>';
	if( Number( this.start.x ) == Number( this.end.x ) || 
		Number( this.start.y ) == Number( this.end.y ) ) {
		//$('test').innerHTML += "IN LINE !!<br>";
		return true;
	}
	return false;
}

function tp_markLine() {
	for( var i = 0; i < this.line.length; i++ ) {
		var item = this.line[i];
		//alert( item.x + '_' + item.y );
		document.getElementById( item.x + '_' + item.y ).innerHTML = "<span style='font-size:5px'>"+Math.round(item.perc*100)+"</span>";
		//document.getElementById( item.x + '_' + item.y ).innerHTML = "<img src='images/map/spc_block.gif'>";
	}
	document.getElementById( this.line[this.line.length-1].x + '_' + this.line[this.line.length-1].y ).innerHTML = '<img //src=images/map/spc_starte.gif>';
	document.getElementById( this.line[0].x + '_' + this.line[0].y ).innerHTML = '<img src=images/map/spc_startp.gif>';
}

function tp_calcCover() {
	//alert( "calc cover" );
	if( this.line.length <= 0 ) {
		this.getPerc();
	}
	var cover = 0;
	for( var i = 0; i < this.line.length; i++ ) {
		var item = this.line[i];
		var node = document.getElementById( item.x + '_' + item.y );
		if( node.getAttribute( 'option' ) == 'highblock' ) {
			cover += item.perc;
			if( cover >= 1 ) {
				cover = 1;
				break;
			}
		}
	}
	return cover
	
}

function tp_knownX( varX ) {
	var val = this.a * ( varX - this.x1 ) + this.b;
	return val;
}

function tp_knownY( varY ) {
	var val = this.x1 + ( varY - this.b ) / this.a;
	return val;
}
