function edit( block ) {
	var subTree = $( block );
	var nodes = subTree.getElementsByTagName( 'td' );
	//alert( nodes.length );
	for( var i = 0; i < nodes.length; i++ ) {
		var node = nodes[i];
		//alert( node.name );
		if( node.getAttribute( 'name' ) == block+'_edit' ) {
			var show = node.getElementsByTagName( 'div' )[0];
			show.style.display = 'none';
			var edit = node.getElementsByTagName( 'div' )[1];
			edit.style.display = 'block';
			//edit.innerHTML = '<input type="text" value="' + show.innerHTML + '"/>';
			//show.innerHTML = '---';
		}
	}
	var tArea = document.getElementsByName( block + '_tArea' )[0];
	tArea.style.display = 'block';
	var editBtn = document.getElementsByName( block + '_editBtn' )[0];
	editBtn.style.display = 'none';
}

function validate( item ) {
	var valid = true;
	reg = /.*/;
	switch( item.getAttribute( 'vartype' ) ) {
		case 'int' : {
			//valid = false;
			//var reg = new RegExp( "[0-9]{1,12}" );
			var reg = /^[0-9]{1,12}$/;
			break;
		}
		case 'float' : {
			var reg = /^[0-9]{1,12}(\.[0-9]{1,4})?$/;
			break;
		}
		default : {
			//alert( item.getAttribute( 'vartype' ) );
			break;
		}
	}
	
	if( !reg.test( item.value ) ) {
		valid = false;
		item.className = 'invalid';
	}
	else {
		valid = true;
		item.className = 'valid';
	}
	if( !valid ) {
		
	}
	else {
		
	}
	return valid;
}

function validateAll( block ) {
	var subTree = $( block );
	var items = subTree.getElementsByTagName( 'input' );
	var valid = true;
	for( var i = 0; i < items.length; i++ ) {
		if( validate( items[i] ) == false ) {
			valid =false;
		}
	}
	if( !valid ) {
		alert( "Popraw zaznaczone pola" );
	}
	var tArea = document.getElementById( block + '-editReason' );
	if( tArea.value.length <= 0 ) {
		alert( "Wpisz powod dla ktorego chcesz edytowac dane !" );
		valid = false;
	}
	return valid;
}