function hide( id, item1 ) {
	var item = document.getElementById( id );
	if( item.style.display == 'none' ) {
		document.getElementById( 'td_' + id ).style.width = '100px';
		item.style.display = 'block';
		item1.innerHTML = 'zwin';
	}
	else {
		document.getElementById( 'td_' + id ).style.width = '0px';
		item.style.display = 'none';
		item1.innerHTML = 'rozwin';
	}
}
function refresh( timeout ) {
	//alert( "refresh !" );
	setTimeout( "refresh(" + timeout + ");", timeout );
	advAJAX.post( { 
		url : 'ajax/ajax_head.php',
		queryString : 'type=playerList',
		onSuccess : function( obj ) { refreshList( obj); } 
	} );
}
function refreshList( ajax ) {
	//alert( ajax.responseText );
	$('playerList').innerHTML = ajax.responseText;
}
function refreshMail( timeout ) {
	//alert( "refresh !" );
	setTimeout( "refreshMail(" + timeout + ");", timeout );
	advAJAX.post( { 
		url : 'ajax/ajax_head.php',
		queryString : 'type=mail',
		onSuccess : function( obj ) { updateMail( obj ); } 
	} );
}
function updateMail( ajax ){
	var amount = new Number( ajax.responseText );
	//alert( amount );
	if( amount > 0 ) {
		var item = $('head_mail');
		if( item.className != 'unreadMail' ) {
			item.className = 'unreadMail';
			item.innerHTML += ' [' + amount + ']';
		}
	}
}
function refreshChatAmount( timeout ) {
	//alert( "refresh !" );
	setTimeout( "refreshChatAmount(" + timeout + ");", timeout );
	advAJAX.post( { 
		url : 'ajax/ajax_head.php',
		queryString : 'type=chat',
		onSuccess : function( obj ) { updateChatAmount( obj ); } 
	} );
}
function updateChatAmount( ajax ){
	var amount = new Number( ajax.responseText );
	//alert( amount );
	$('chatAmount').innerHTML = amount;
}