function foo( elem ) {
	var x = elem.getAttribute("x");
	var y = elem.getAttribute("y");
	document.getElementById( 'test' ).innerHTML = 'pos : ' + x + 'x' + y;
	//alert( 'pos : ' + x + 'x' + y );
}