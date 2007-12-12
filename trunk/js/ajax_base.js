function $( id ) {
	return document.getElementById( id );
}

function showError( errMsg ) {
	$( 'error' ).style.display = 'block';
	$( 'error' ).innerHTML = errMsg;
}

function resp2obj( text ) {
	var obj = new Object();
	var ret = text;
	var lines = ret.split( "\n" );
	for( var i = 0; i < lines.length; i++ ) {
		var fields = lines[i].split( "&" );
		if( fields.length <= 1 && fields.length > 0 ) {
			var tmp = fields[0].split( "=" );
			obj[ tmp[0] ] = tmp[1];
		}
		else {
			var t1 = fields[0].split( "?" );
			var name = t1[0];
			fields[0] = t1[1];
			var tmpObj = new Object();
			for( var j = 0; j < fields.length; j++ ) {
				if( !fields[j] ) {
					continue;
				}
				var tmp = fields[j].split( "=" );
				tmpObj[ tmp[0] ] = tmp[1];
			}
			obj[ name ] = tmpObj;
		}
	}
	return obj;
}

function URLEncode(clearString){
    var output = '';
    var x = 0;
    clearString = clearString.toString();
    var regex = /(^[a-zA-Z0-9_.]*)/;
    while (x < clearString.length) {
        var match = regex.exec(clearString.substr(x));
        if (match != null && match.length > 1 && match[1] != '') {
            output += match[1];
            x += match[1].length;
        }
        else {
            if (clearString[x] == ' ') 
                output += '+';
            else {
                var charCode = clearString.charCodeAt(x);
                var hexVal = charCode.toString(16);
                output += '%' + (hexVal.length < 2 ? '0' : '') + hexVal.toUpperCase();
            }
            x++;
        }
    }
    return output;
}


function URLDecode(encodedString){
    var output = encodedString;
    var binVal, thisString;
    var myregexp = /(%[^%]{2})/;
    output = output.replace("+", " ");
    while ((match = myregexp.exec(output)) != null &&
    		match.length > 1 &&
    		match[1] != '') {
        binVal = parseInt(match[1].substr(1), 16);
        thisString = String.fromCharCode(binVal);
        output = output.replace(match[1], thisString);
    }
    return output;
}

function dispatchReq( func, val ) {
	if( func && val ) {
		func( val );
	}
}