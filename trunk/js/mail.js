function more( id ){
	var item = $( 'msg_' + id + '_body' );
	var more = $( 'msg_' + id + '_more' );
	if( item.style.display == 'none' ) {
		if( $( 'msg_'+id+'_unread') && $( 'msg_'+id+'_unread').value == 'Y' ) {
		//$('msg_'+id+'_t').className = 'mailTopic';
			advAJAX.post( {
				url: 'ajax/ajax_mail.php',
				queryString: 'action=markRead&mid='+id,
				onSuccess: function( obj ) { respManager( obj ); }
			} );
		$( 'msg_'+id+'_unread').value = 'T';
		}
		item.style.display = 'block';
		more.innerHTML = "schowaj";
	}
	else {
		item.style.display = 'none';
		more.innerHTML = "czytaj";
	}
}

var replyId;

function reply( id ) {
	replyId = id;
	$('msg_pages').style.display = 'none';
	var divs = $('msg').getElementsByTagName( 'div' );
	for( var i = 0; i < divs.length; i++ ) {
		var div = divs[i];
		if( div.className != 'mailContainer' ) {
			continue;
		}
		if( div.id == 'msg_'+id ) {
			var tmp = document.createElement( 'div' );
			tmp.id = 'msg_'+id+'_original';
			tmp.className = 'mailOriginal';
			tmp.innerHTML = "wiadomosc oryginalna";
			div.insertBefore( tmp, div.firstChild );
			continue;
		}
		div.style.display = 'none';
	}
	$('msg_'+id+'_reply').style.display = 'none';
	$('replyForm').style.display = 'block';
	var rid = $('msg_'+id+'_id').innerHTML;
	var topic = $('msg_'+id+'_topic').innerHTML;
	topic = 'Odp: ' + topic;
	$('replyTo').value = rid;
	$('replyTopic').value = topic;
}

function validateMsg() {
	if( $('replyTo').value.length <= 0 ) {
		alert( 'podaj do kogo chcesz wyslac wiadomosc' );
		return false;
	}
	if( $('replyTopic').value.length <= 0 ) {
		alert( 'podaj tytul wiadomosci' );
		return false;
	}
	if( $('replyBody').value.length <= 0 ) {
		alert( 'wpisz tresc wiadomosci' );
		return false;
	}
	//alert( 'ok' );
	return true;
}

function back(){
	$('msg_pages').style.display = 'block';
	var divs = $('msg').getElementsByTagName( 'div' );
	for( var i = 0; i < divs.length; i++ ) {
		var div = divs[i];
		if( div.className != 'mailContainer' ) {
			continue;
		}
		div.style.display = 'block';
	}
	var or = $('msg_'+replyId+'_original');
	or.parentNode.removeChild( or );
	$('msg_'+replyId+'_reply').style.display = 'block';
	$('replyForm').style.display = 'none';
	$('replyTo').value = '';
	$('replyTopic').value = '';
	$('replyBody').value = '';
	return false;
}

function respManager( ajax ) {
	//alert( ajax.responseText );
}