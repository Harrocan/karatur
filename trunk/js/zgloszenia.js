function solveForm( zgId ) {
	$('zgl_' + zgId + '_actSolve').innerHTML = "Wpisz powod rozwiazania : <br/><b>uwaga !</b> To co tutaj wpiszesz <u>nie trafi do nadawcy</u>. Jest to informacja tylko do wgl±du dla upowa¿nionych. Je¶li chcesz wys³aæ wiadomo¶c, zrób to oddzielnie !<br><textarea id='zgl_" + zgId + "_formSolve' style='width:100%; height: 150px'></textarea><br><input type='submit' value='rozwiaz !' onclick=\"solve('" + zgId + "')\">";
	$('zgl_' + zgId + '_formSolve').focus();
}

function solve( zgId ) {
	
	var body = $( 'zgl_' + zgId + '_formSolve' ).value;
	
	if( !body ) {
		alert( "Wpisz tresc !" );
		return;
	}
	//return;
	$( 'zgl_' + zgId + '_actSolve' ).innerHTML = 'oznaczanie jako rozwiazane ...';
	advAJAX.post( {
		url : 'ajax/ajax_zgloszenia.php?action=solve&id=' + zgId,
		tag : zgId,
		queryString : 'reason=' + encodeURIComponent( body ),
		onSuccess : function( obj ) { respManager( obj ); }
	} );
}

function msgForm( zgId ) {
	$('zgl_' + zgId + '_actMsg').innerHTML = "Wpisz tre¶æ wiadomo¶ci : <br><textarea id='zgl_" + zgId + "_formMsg' style='width:100%; height: 150px'></textarea><br><input type='submit' value='wyslij !' onclick=\"sendForm('" + zgId + "')\">";
	$('zgl_' + zgId + '_formMsg').focus();
}

function sendForm( zgId ) {
	
	var body = $( 'zgl_' + zgId + '_formMsg' ).value;
	//alert( body );
	if( !body ) {
		alert( "Wpisz tresc !" );
		return;
	}
	//return;
	$('zgl_' + zgId + '_actMsg').innerHTML = 'wysylanie wiadomosci ...';
	//$( 'zgl_' + zgId + '_actSolve' ).innerHTML = 'prosze czekac ...';
	advAJAX.post( {
		url : 'ajax/ajax_zgloszenia.php?action=msg&id=' + zgId,
		tag : zgId,
		queryString : 'message=' + encodeURIComponent( body ),
		onSuccess : function( obj ) { respManager( obj ); }
	} );
}

function respManager( item ) {
	//alert( item.responseText );
	//return;
	document.getElementById( 'error' ).style.display = 'none';
	var fields = item.responseText.split( '~' );
	var mType = fields[0];
	switch( mType ) {
		case 'ERR' :
			//$('tabMapHead').innerHTML = oldLocation;
			switch( fields[1] ) {
				case 'SESS_EXPIRE' :
						showError( "Blad ! Twoja sesja wygasla !<br />Musisz zalogowac sie ponownie" );
				break;
				case 'INVAILD_GET' :
						showError( "Blad ! Nieprawidlowe zapytanie !" );
				break;
				case 'REP_NOEXISTS' :
						showError( "Takie zgloszenie nie istnieje !" );
				break;
				case 'SOLVED' :
						showError( "To zgloszenie zostalo juz rozwiazane !" );
				break;
				default :
						showError( "Wystapil niezidentyfikowany blad " + fields[1] );
				break;
			}
			break;
		case 'SOLVE_OK' :
			$( 'zgl_' + item.tag ).setAttribute( 'class', 'zgl_solved' );
			$( 'zgl_' + item.tag + '_status' ).innerHTML = 'rozwiazany przez ' + decodeURIComponent( fields[1] );
			$( 'zgl_' + item.tag + '_actSolve' ).style.display = 'none';
			break;
		case 'MSG_OK' :
			$('zgl_' + item.tag  + '_actMsg').innerHTML = "<a href=\"javascript:msgForm('" + item.tag + "');\">napisz wiadomosc</a>";
			//alert( $( 'zgl_' + item.tag + '_hist' ).innerHTML );
			$( 'zgl_' + item.tag + '_hist' ).innerHTML += "<li><i>wiadomosc</i> : '" + decodeURIComponent( fields[1] ) + "'</li>";
			break;
	}
	
}

function showError( errMsg ) {
	document.getElementById( 'error' ).style.display = 'block';
	document.getElementById( 'error' ).innerHTML = errMsg;
}

function $( id ) {
	return document.getElementById( id );
}