var chatRoom = "";
function chatInit( chatType ) {
	chatRoom = chatType;
	refreshChat();
	refreshUserList();
	if( chatRoom != 'offtop' ) {
		updateOffAmount( 5000 );
	}
	if( chatRoom != 'chat' ) {
		updateMainAmount( 5000 );
	}
	if( chatRoom != 'basement' ) {
		updateBaseAmount( 5000 );
	}
}

function updateOffAmount( timeout ) {
	setTimeout( "updateOffAmount( " + timeout + " )", timeout );
	advAJAX.post( { 
		url : 'ajax/ajax_chat.php',
		queryString : 'type=amount&room=' + chatRoom + '&room_type=Pokoj Nieklimatyzowany',
		onSuccess : function( obj ) {
			var el = $('roomOffAmount');
			if( el ) {
				el.innerHTML = obj.responseText;
			}
		} 
	} );
}
function updateMainmount( timeout ) {
	setTimeout( "updateMainAmount( " + timeout + " )", timeout );
	advAJAX.post( { 
		url : 'ajax/ajax_chat.php',
		queryString : 'type=amount&room=' + chatRoom + '&room_type=Chat',
		onSuccess : function( obj ) {
			var el = $('roomMainAmount');
			if( el ) {
				el.innerHTML = obj.responseText;
			}
		} 
	} );
}
function updateBaseAmount( timeout ) {
	setTimeout( "updateBaseAmount( " + timeout + " )", timeout );
	advAJAX.post( { 
		url : 'ajax/ajax_chat.php',
		queryString : 'type=amount&room=' + chatRoom + '&room_type=Piwnica',
		onSuccess : function( obj ) {
			var el = $('roomBaseAmount');
			if( el ) {
				el.innerHTML = obj.responseText;
			}
		} 
	} );
}
function updateChat( ajax ) {
	var data = ajax.responseText;
	var el = $('chatText');
	if( el ) {
		el.innerHTML = trans( data, 'decode' );
	}
}
function updateUserList( ajax ) {
	var data = ajax.responseText;
	var el = $('chatUsers');
	if( el ) {
		el.innerHTML = data;
	}
	
}
function chatKey(ev ) {
	if( ev.keyCode == 13 ) {
		return sendMsg();
	}
	return true;
}
function chatKeyInn(ev ) {
	if( ev.keyCode == 13 ) {
		return sendMsgInn();
	}
	return true;
}
function sendMsg() {
	//alert( mType );
	//alert( "sending " + $('chatMsg').value );
	if( $( 'offBtn' ).getAttribute( "offtop" ) == "1" ) {
		offMode();
	}
	if( $( 'emoBtn' ).getAttribute( "emote" ) == "1" ) {
		emoMode();
	}
	var msg = $('chatMsg').value;
	if( !msg ) {
		return;
	}
	var el = $('chatMsg');
	el.value = '';
	msg = trans( msg, 'encode' );
	el.focus();
	advAJAX.post( { 
		url : 'ajax/ajax_chat.php',
		queryString : 'type=send&room=' + chatRoom + '&text=' + msg,
		onSuccess : function( obj ) { 
			//alert( obj.responseText );
			if( obj.responseText == 'ban' ) {
				alert( "Nie mozesz pisac poniewaz dostales bana !" );
			};
			dispatchReq( refreshChat, -1 );
			//refreshChat( -1 );
		} 
	} );
	
	
}
function sendMsgInn() {
	//alert( mType );
	//alert( "sending " + $('chatMsg').value );
	var msg = $('innkeeperMsg').value;
	$('innkeeperMsg').value = '';
	msg = trans( msg, 'encode' );
	var innType = $('innkeeperType').value;
	//alert( 'type=sendInn&innType=' + innType + '&text=' + msg );
	advAJAX.post( { 
		url : 'ajax/ajax_chat.php',
		queryString : 'type=sendInn&room=' + chatRoom + '&innType=' + innType + '&text=' + msg,
		onSuccess : function( obj ) { 
			/*if( obj.responseText == 'ban' ) {
			alert( "Nie mozesz pisac poniewaz dostales bana !" );
		};*/
			//alert( obj.responseText );
			dispatchReq( refreshChat, -1 );
			//refreshChat( -1 );
		} 
	} );
	$('innkeeperMsg').focus();
}
function refreshChat() {
	advAJAX.post( { 
		url : 'ajax/ajax_chat.php',
		queryString : 'type=msg&room=' + chatRoom,
		onSuccess : function( obj ) { dispatchReq( updateChat, obj ); setTimeout( "refreshChat(2000)", 2000 ); } 
	} );
}

function refreshUserList() {
	advAJAX.post( { 
		url : 'ajax/ajax_chat.php',
		queryString : 'type=user&room=' + chatRoom,
		onSuccess : function( obj ) { dispatchReq( updateUserList, obj ); setTimeout( "refreshUserList()", 2000 ); } 
	} );
}
function clearChat() {
	advAJAX.post( { 
		url : 'ajax/ajax_chat.php',
		queryString : 'type=clear&room=' + chatRoom,
		onSuccess : function( obj ) { dispatchReq( refreshChat, -1 ); } 
	} );
}
function ban() {
	var mode = $('ban').value;
	var banId = $('banid').value;
	$('banid').value = '';
	advAJAX.post( { 
		url : 'ajax/ajax_chat.php',
		queryString : 'type=' + mode + '&room=' + chatRoom + '&id=' + banId,
		tag : mode,
		onSuccess : function( obj ) {
			if( obj.tag == 'ban' ) {
				alert( "Zbanowales " + obj.responseText );
			}
			if( obj.tag == 'unban' ) {
				alert( "Odbanowales " + obj.responseText );
			}
		} 
	} );
}

function emoMode() {
	var text = $( 'chatMsg' );
	var btn = $( 'emoBtn' );
	if( btn.getAttribute( "emote" ) == "0" ) {
		text.value += "*";
		text.focus();
		btn.setAttribute( "emote", "1" );
		btn.value = "/emo";
	}
	else {
		text.value += "*";
		text.focus();
		btn.setAttribute( "emote", "0" );
		btn.value = "emo";
	}
}

function offMode() {
	var text = $( 'chatMsg' );
	var btn = $( 'offBtn' );
	if( btn.getAttribute( "offtop" ) == "0" ) {
		text.value += "/";
		text.focus();
		btn.setAttribute( "offtop", "1" );
		btn.value = "/komentarz";
	}
	else {
		text.value += "/";
		text.focus();
		btn.setAttribute( "offtop", "0" );
		btn.value = "komentarz";
	}
}

function chatHelpSwitch( mode ) {
	if( mode == 'show' ) {
		var item = $( 'chatHelpText' );
		item.style.display = "block";
	}
	if( mode == 'hide' ) {
		var item = $( 'chatHelpText' );
		item.style.display = "none";
	}
}

function trans( str, mode ) {
		//alert( str );
		/*var old = str;
		var trArr = new Array();
		var pos = 0;
		trArr[pos++] = { from:"±", to:"a" };
		trArr[pos++] = { from:"¡", to:"A" };
		trArr[pos++] = { from:"æ", to:"c" };
		trArr[pos++] = { from:"Æ", to:"C" };
		trArr[pos++] = { from:"ê", to:"e" };
		trArr[pos++] = { from:"Ê", to:"E" };
		trArr[pos++] = { from:"³", to:"l" };
		trArr[pos++] = { from:"£", to:"L" };
		trArr[pos++] = { from:"ñ", to:"n" };
		trArr[pos++] = { from:"Ñ", to:"N" };
		trArr[pos++] = { from:"ó", to:"o" };
		trArr[pos++] = { from:"Ó", to:"O" };
		trArr[pos++] = { from:"¶", to:"s" };
		trArr[pos++] = { from:"¦", to:"S" };
		trArr[pos++] = { from:"¿", to:"z" };
		trArr[pos++] = { from:"¯", to:"Z" };
		trArr[pos++] = { from:"¼", to:"x" };
		trArr[pos++] = { from:"¬", to:"X" };
		if( mode == 'encode' ) {
			for( var i = 0; i < trArr.length; i++ ) {
				//document.write( trArr[i].from + " => " + trArr[i].to + "<br/>" );
				//if( str.indexOf( trArr[i].from ) >= 0 ) {
					//alert( "replacing " + trArr[i].from );
					str = str.replace( trArr[i].from, "[latin:" + trArr[i].to + "]", "g" );
				//}
			}
		}
		if (mode == 'decode' ) {
			for( var i = 0; i < trArr.length; i++ ) {
				//if( str.indexOf( "[latin:" + trArr[i].to + "]" ) >= 0 ) {
					//alert( "replacing " + trArr[i].from );
					str = str.replace( "[latin:" + trArr[i].to + "]", trArr[i].from, "g" );
				//}
			}
		}*/
		if( mode == 'encode' ) {
			str = encodeURIComponent( str );
		}
		else {
			str = decodeURIComponent( str );
		}
		//document.write( "<br/>" + old + " :: " + str + "<br/>" );
		return str;
	}