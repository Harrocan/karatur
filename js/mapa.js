function init() {
	advAJAX.post( { 
		url : 'ajax/ajax_mapa.php',
		queryString : 'action=dir&value=null',
		tag: 'null',
		onSuccess : function( obj ) { respManager( obj); } 
	} );
}

var oldLocation;
function move( dir ) { 
	var div = document.getElementById( 'tabMapHead' ); 
	oldLocation = div.innerHTML; 
	switch( dir ) {
		case 'up' : 
		case 'down' :
		case 'left' : 
		case 'right' : 
				div.innerHTML = 'moving ...';
		break; 
		default : 
				showError( "Invaild direction" ); 
		return; 
	} 
	advAJAX.post( { 
		url : 'ajax/ajax_mapa.php', 
		queryString : 'action=dir&value=' + dir, 
		tag : dir,
		onSuccess : function( obj ) { respManager( obj); } 
	} );
} 

function respManager( item ) { 
	var resp = resp2obj( item.responseText ); 
	//alert( resp );
	/*document.getElementById( 'test' ).innerHTML = item.responseText;*/ 
	document.getElementById( 'error' ).style.display = 'none'; 
	document.getElementById( 'info' ).style.display = 'none'; 
	switch( resp.type ) { 
		case 'ERROR' : {
			$('tabMapHead').innerHTML = oldLocation; 
			switch( resp.value ) { 
				case 'SESS_EXPIRE' : {
					showError( "Blad ! Twoja sesja wygasla !<br />Musisz zalogowac sie ponownie" );
					break; 
				}
				case 'INVAILD_GET' : {
					showError( "Blad ! Nieprawidlowe zapytanie !" ); 
					break;
				}
				case 'IN_JAIL' : {
					showError( "Nie mozesz podrozowac poniewaz siedzisz w wiezieniu !" );
					break; 
				}
				case 'NO_HP' : {
					showError( "Nie mozesz podrozowac po mapie gdy jestes martwy !" ); 
					break; 
				}
				case 'NO_COORDS' : {
					showError( "Musisz najpierw wybrac swoje pochodzenie !" ); 
					break; 
				}
				case 'NO_ENERGY' : {
					showError( "Masz za malo energii zeby podrozowac !" ); 
					break; 
				}
				case 'OUT_OF_MAP' : {
					showError( "Dotarles do obecnej granicy mapy. Nie mozesz sie dalej poruszac w tym kierunku" ); 
					break; 
				}
				case 'BLOCKED' : {
					showError( "Nie mozesz sie poruszac po polu zabronionym !" );
					break; 
				}
				default : {
					showError( "Wystapil niezidentyfikowany blad " + resp.value ); 
					break; 
				}
			} 
			break; 
		}
		case 'MAP' : {
			var cell = resp; 
			if( cell.file != 'none' ) { 
				var link = "<a href=\"city.php\">" + decodeURIComponent( cell.name ) + "</a>";
				$('tabMapHead').innerHTML = link;
				$('foot_location_link').innerHTML = '<b>' + decodeURIComponent( link ) + '</b>'; 
			}
			else {
				$('tabMapHead').innerHTML = decodeURIComponent( cell.name ); 
				$('foot_location_link').innerHTML = decodeURIComponent( cell.name ); 
			} 
			$('tabMapHead').innerHTML += "<br>" + cell.coord; $('cell-desc').innerHTML = decodeURIComponent( cell.desc );
			$('cell-geo').innerHTML = decodeURIComponent( cell.geo ); 
			$('cell-nat').innerHTML = decodeURIComponent( cell.nat ); 
			for( var i = 1; i <=3; i++ ) { 
				for( var j = 1; j <= 3; j++ ) { 
					var cells = cell[ 'tabtd_'+i+'_'+j ]; 
					var node = document.getElementById( 'map_' + i + '_' + j );
					var nodeSpec = document.getElementById( 'mapSpec_' + i + '_' + j );
					var zx = cells.x; 
					var xy = cells.y; 
					var tdId = cells.id; 
					var opts = cells.opt; 
					//node.style.background = "url( mapa-big/" + cells.x + "_" + cells.y + ".png );"; 
					node.innerHTML = "<img src=\"mapa-big/" + cells.x + "_" + cells.y + ".png\" />";
					if( tdId == 'tabtd_2_2' ) { 
						nodeSpec.innerHTML = "<img src='mapa/punkt.gif'>"; 
					} 
					else if( opts == 'out' ) { 
						nodeSpec.innerHTML = "<img src='mapa-big/no.gif'>"; 
					} 
					else if( opts == 'block' ) { 
						nodeSpec.innerHTML = "<img src='mapa-big/no.gif'>"; 
					} 
					else { 
						nodeSpec.innerHTML = "&nbsp;"; 
					} 
				} 
			} 
			var energy = new Number( $('head_energy_current').innerHTML );
			if( item.tag != 'null' ) {
				energy -= 0.4; 
				energy = round( energy, 4 ); 
				$('head_energy_current').innerHTML = energy; 
			}
			break; 
		}
	} 
} 

function round( val, afterdot ) { 
	var fract = val - Math.floor( val );
	fract = Math.round( fract * Math.pow( 100, afterdot ) ); 
	return Number( Math.floor( val ) + "." + fract ); 
} 

function $( id ) { 
	return document.getElementById( id ); 
} 

function showError( errMsg ) { 
	document.getElementById( 'error' ).style.display = 'block'; 
	document.getElementById( 'error' ).innerHTML = errMsg; 
}