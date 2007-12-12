var brush = 'grass';
var grid = 1;
var tileType = 'land';
var mode = 'paint';
var option = 'none';
//var brushTab = array(
//var brushes = new Array( "grass", "step", "water" );
var brushNo = new Array( 'grass', 'step', 'water', 'point' );

function setMode( newMode ) {
	document.getElementById( mode + '_tab' ).style.display = 'none';
	document.getElementById( newMode + '_tab' ).style.display = 'block';
	mode = newMode;
	//switch( mode )
}

function setTab( type ) {
	switch( type ) {
		case 'land' :
			var arr = new Array( 'grass', 'step', 'road_v', 'road_h', 'wood' );
			break;
		case 'water' :
			var arr = new Array( 'water' );
			break;
	}
	tileType = type;
	brush = arr[0];
	var content = '';;
	for( var i = 0; i < arr.length; i++ ) {
		var n = arr[i];
		content += "<img id='brush_" + n + "' src='images/map/" + n + ".gif' onclick=\"setBrush('" + n + "')\"/>";
	}
	//content = 
	document.getElementById( 'brushes' ).innerHTML = content;
	setBrush( arr[0] );
}

function setBrush( no ) {
	document.getElementById( 'brush_'+brush ).style.borderStyle = 'none';
	document.getElementById( 'brush_'+no ).style.borderStyle = 'solid';
	brush = no;
}

function setOption( newOption ) {
	option = newOption;
}

function click( item ) {
	//var brush = document.getElementById( 'brush' ).getAttribute('value');
	//var item = document.getElementById( posx + '_' + posy );
	//item.innerHTML = brush;
	switch( mode ) {
		case 'paint' :
				// ***************
				// * TRYB MALOWANIA
				// ***************
			//switch( tileType ) {
			//	case 'land' :
			//	case 'water' :
					item.style.background = 'url(images/map/' + brush + '.gif)';
			//		break;
			//	case 'special' :
			//		item.innerHTML = "<img id='spc_" + item.getAttribute( 'id' ) + "' src='images/map/" + brush + ".gif' />";
			//		item = document.getElementById( "spc_" + item.getAttribute( 'id' ) );
			//		break;
			//}
			item.style.background = 'url(images/map/' + brush + '.gif)';
			item.setAttribute( 'tiletype', tileType );
			item.setAttribute( 'tileno', brush );
			item.setAttribute( 'option', option );
			//var opt = document.getElementById( 'option' );
			//item.innerHTML = opt.getAttribute( 'value' );
			if( option != 'none' ) {
				item.innerHTML = "<img src='images/map/spc_" + option + ".gif' />";
			}
			else {
				item.innerHTML = "&nbsp;";
			}
			break;
		case 'info' :
				// ***************
				// * TRYB INFORMACJI
				// ***************
			var div = document.getElementById( 'info_tab' );
			var msg = 'Wspolrzedne : ' + item.getAttribute( 'x' ) + 'x' + item.getAttribute( 'y' ) + '<br>';
			if( !item.getAttribute( 'tiletype' ) ) 
				msg += '<i>puste pole</i><br>';
			
			else {
				msg += 'Rodzaj pola : ' + item.getAttribute( 'tiletype' ) + '<br>';
				msg += 'Typ pola : ' + item.getAttribute( 'tileno' ) + '<br>';
			}
			div.innerHTML = msg;
			break;
	}
}

function changeGrid( item ) {
	if( grid == 1 )
		grid = 0;
	else
		grid = 1;
	//document.getElementById( 'test' ).innerHTML = grid;
	document.getElementById( 'tab_map' ).setAttribute( 'border', grid );
	document.getElementById( 'tab_map' ).borderWidth = 1;
}

function createInput( name, value ) {
	var field = document.createElement( "input" );
	field.setAttribute( "type", "hidden" );
	field.setAttribute( "name", name );
	field.setAttribute( "value", value );
	return field;
}

function sendMap() {
	alert( "Dziekuje za ogladniecie mozliwosci tego edytora. W tym momencie mapa zostala by zapisana na dysk i byla by gotowa do pozniejszego uzycia - w ten sposob utworzylem mape na ktorej mozna testowac wyszukiwanie drogi i celowanie" );
	return;
	var f = document.createElement( "form" );
	document.body.appendChild( f );
	f.action = "test.php";
	f.method = "post";
	var tab = document.getElementById( "tab_map" );
	var tds = tab.getElementsByTagName( "td" );
	for( var i = 0; i < tds.length; i++ ) {
		var td = tds[i];
		var name = td.getAttribute( "id" ) + "[tileno]";
		var value = td.getAttribute( "tileno" );
		f.appendChild( createInput( name, value )  );
		var name = td.getAttribute( "id" ) + "[tiletype]";
		var value = td.getAttribute( "tiletype" );
		f.appendChild( createInput( name, value )  );
		var name = td.getAttribute( "id" ) + "[option]";
		var value = td.getAttribute( "option" );
		f.appendChild( createInput( name, value )  );
	}
	/*
	var spc = tab.getElementsByTagName( "img" );
	for( var i = 0; i < spc.length; i++ ) {
		var item = spc[i];
		var name = item.getAttribute( "id" ) + "[tileno]";
		var value = item.getAttribute( "tileno" );
		f.appendChild( createInput( name, value )  );
		var name = item.getAttribute( "id" ) + "[tiletype]";
		var value = item.getAttribute( "tiletype" );
		f.appendChild( createInput( name, value )  );
	}
	*/
	f.submit();
}