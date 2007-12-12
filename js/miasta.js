function editCity( id ) {
	
	var sectionTitle = $( 'city-' + id + '-title' ).textContent;
	
	var sectionData = new Array();
	for( var i = 0; i < 5; i++ ) {
		var item = new Object();
		//var test = 'city-' + id + '-fields-' + i + '-name';
		//alert( test );
		if( !$( 'city-' + id + '-fields-' + i + '-name' ) ) {
			break;
		}
		item.name = $( 'city-' + id + '-fields-' + i + '-name' ).innerHTML;
		item.type = $( 'city-' + id + '-fields-' + i + '-type' ).innerHTML;
		item.option = $( 'city-' + id + '-fields-' + i + '-option' ).innerHTML;
		item.query = $( 'city-' + id + '-fields-' + i + '-query' ).innerHTML;
		//alert( item.name + ', ' + item.type + ', ' + item.option + ', ' + item.query );
		sectionData[i] = item;
	}
	
	for( var z = 0; z < sectionData.length; z++ ) {
		var toFind = sectionData[z].option;
		var htmlName = $( 'city-' + z + '-name' );
		var htmlQuery = $( 'city-' + z + '-query' );
		var select = $( 'city-' + z + '-option' );
		var amount = select.length;
		//alert( "toFind : " + toFind );
		//alert( amount );
		for( var i = 0; i < amount; i ++ ) {
			var node = select[i];
			if( node.value == toFind ) {
				//alert( "found at " + i );
				select.selectedIndex = i;
				break;
			}
		}
		htmlName.value = sectionData[z].name;
		htmlQuery.value = sectionData[z].query;
	}
	
	$( 'city-title' ).value = sectionTitle;
	$( 'city-position' ).value = id;
	
	var lay = $( 'layer_citysection' );
	lay.style.display = 'block';
}

function cancelEdit() {
	for( var z = 0; z < 5; z++ ) {
		var htmlName = $( 'city-' + z + '-name' );
		var htmlQuery = $( 'city-' + z + '-query' );
		var select = $( 'city-' + z + '-option' );
		
		select.selectedIndex = 0;
		htmlName.value = "";
		htmlQuery.value = "";
	}
	
	$( 'city-title' ).value = "";
	$( 'city-position' ).value = '';
	
	var lay = $( 'layer_citysection' );
	lay.style.display = 'none';
}