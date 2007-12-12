var mapData = new Array();
var curBrush;
var mapInfo = new Object();
var brushArr = new Array();
var mapGroups = new Array();
var tilesPath = 'images/map_tiles/';

function ar_index_of( value ) {
    for( var i = 0; i < this.length; i++ ) {
        if( this[i] == value ) {
            return i;
        }
    }
    return -1;
}
Array.prototype.indexOf = ar_index_of;

function init() {

    advAJAX.post( {
        url : 'ajax/ajax_level_editor.php',
        queryString : 'action=nodelist',
        onSuccess : function( obj ) {
            //alert( obj.responseText );
            respManager( obj.responseText );
            //refreshChat( -1 );
        }
    } );

    mapInfo.ox = 0;
    mapInfo.oy = 0;
    mapInfo.sx = 20;
    mapInfo.sy = 20;
    mapInfo.vx = 8;
    mapInfo.vy = 8;
    mapInfo.miniport = false;
    mapInfo.name = "taka sobie testowa mapa";
    mapInfo.mode = 'tiles';
    mapInfo.exLock = false;

    mapData = new Array( mapInfo.sx );
    for( var i = 0; i < mapInfo.sx; i++ ) {
        mapData[i] = new Array( mapInfo.sy );
        for( var j = 0; j < mapInfo.sy; j++ ) {
            tmp = new Object();
            //tmp.img = new Object();
            tmp.img = new Array();
            //tmp.img.level = new Object();
            mapData[i][j] = tmp;
        }
    }

    draw();

    var miniTab = document.createElement( 'table' );
    miniTab.setAttribute( 'cellpadding', '0' );
    miniTab.setAttribute( 'cellspacing', '0' );
    miniTab.style.width = '100px';
    miniTab.style.height = '100px';
    miniTab.style.position = 'absolute';

    if( mapInfo.miniport ) {
        var miniMap = $( 'mini-map' );
        miniMap.appendChild( miniTab );
        for( var i = 0; i < mapInfo.sx; i++ ) {
            var miniRow = document.createElement( 'tr' );
            miniTab.appendChild( miniRow );
            for( var j = 0; j < mapInfo.sy; j++ ) {
                var miniCell = document.createElement( 'td' );
                miniCell.id = 'mini_' + i + '_' + j;
                miniCell.innerHTML = ' ';
                miniRow.appendChild( miniCell );
            }
        }
    }

    var el = $( 'level-main' );
    var tmain = $( 'tab-main' );
    //el.onmousemove = mouseMoveMain;
    //el.onclick = mouseClickMain;
    //el.addEventListener("click", mouseClickMain, true);
    //el.setAttribute( 'onclick', 'mouseClickMain()' );

    //tmain.onclick = mouseClickMain;
    tmain.onmouseover = mouseOverMain;
    tmain.onmouseout = mouseOutMain;

    var tm = $( 'map-capt-area' );
    tm.onmousemove = mouseMoveMain;
    tm.onclick = mouseClickMain;

    updateMiniport();
}

function draw() {
    var el = $( 'level-main' );
    var maxI = mapInfo.vx;
    var maxJ = mapInfo.vy;
    var innerTree = document.createElement( 'div' );

    while( el.hasChildNodes() ) {
        el.removeChild( el.firstChild );
    }
    el.appendChild( innerTree );

    innerTree.id = 'div_tab';
    innerTree.style.width = mapInfo.vx*40 + 'px';
    innerTree.style.height = mapInfo.vy*40 + 'px';
    for( var i = mapInfo.ox; i < mapInfo.ox + mapInfo.vx; i++ ) {
        var tmpRow = document.createElement( 'div' );
        tmpRow.className = 'div_tab_row';
        innerTree.appendChild( tmpRow );
        for( var j = mapInfo.oy; j < mapInfo.oy + mapInfo.vy; j++ ) {
            tmpCell = document.createElement( 'div' );
            tmpCell.className = 'div_tab_cell';
            tmpCell.id = 'cell_' + i + 'x' + j;
            tmp.innerHTML= ' ';
            tmpRow.appendChild( tmpCell );
            updateCell( i, j );
        }
    }


}

function scrollMap( dir ) {
    switch( dir ) {
        case 'right' : {
            if( mapInfo.ox + mapInfo.vx >= mapInfo.sx ) {
                break;
            }
            var tab = $( 'div_tab' );
            var rows = tab.childNodes;
            for( var i = 0; i < rows.length; i++ ) {
                //var cells = rows[i].childNodes;
                var x = mapInfo.ox + i;
                var y = mapInfo.oy + mapInfo.vy;
                rows[i].removeChild( rows[i].firstChild );
                tmpCell = document.createElement( 'div' );
                tmpCell.className = 'div_tab_cell';
                tmpCell.id = 'cell_' + x  + 'x' + y;
                tmp.innerHTML= ' ';
                rows[i].appendChild( tmpCell );
                updateCell( x, y );
            }
            mapInfo.oy++;
            break;
        }
        case 'left' : {
            if( mapInfo.oy <= 0 ) {
                break;
            }
            var tab = $( 'div_tab' );
            var rows = tab.childNodes;
            for( var i = 0; i < rows.length; i++ ) {
                //var cells = rows[i].childNodes;
                var x = mapInfo.ox + i;
                var y = mapInfo.oy - 1;
                rows[i].removeChild( rows[i].lastChild );
                tmpCell = document.createElement( 'div' );
                tmpCell.className = 'div_tab_cell';
                tmpCell.id = 'cell_' + x  + 'x' + y;
                tmp.innerHTML= ' ';
                rows[i].insertBefore( tmpCell, rows[i].firstChild );
                updateCell( x, y );
            }
            mapInfo.oy--;
            break;
        }
        case 'down' : {
            if( mapInfo.ox + mapInfo.vx >= mapInfo.sx ) {
                break;
            }
            var tab = $( 'div_tab' );
            tab.removeChild( tab.firstChild );
            var row = document.createElement( 'div' );
            row.className = 'div_tab_row';
            tab.appendChild( row );
            for( var i = 0; i < tab.firstChild.childNodes.length; i++ ) {
                var x = mapInfo.ox + mapInfo.vx;
                var y = mapInfo.oy + i;
                tmpCell = document.createElement( 'div' );
                tmpCell.className = 'div_tab_cell';
                tmpCell.id = 'cell_' + x  + 'x' + y;
                tmp.innerHTML= ' ';
                row.appendChild( tmpCell );
                updateCell( x, y );
            }
            mapInfo.ox++;
            break;
        }
        case 'up' : {
            if( mapInfo.ox <= 0 ) {
                break;
            }
            var tab = $( 'div_tab' );
            tab.removeChild( tab.lastChild );
            var row = document.createElement( 'div' );
            row.className = 'div_tab_row';
            //tab.appendChild( row );
            tab.insertBefore( row, tab.firstChild );
            for( var i = 0; i < tab.lastChild.childNodes.length; i++ ) {
                var x = mapInfo.ox - 1;
                var y = mapInfo.oy + i;
                tmpCell = document.createElement( 'div' );
                tmpCell.className = 'div_tab_cell';
                tmpCell.id = 'cell_' + x  + 'x' + y;
                tmp.innerHTML= ' ';
                row.appendChild( tmpCell );
                updateCell( x, y );
            }
            mapInfo.ox--;
            break;
        }
    }
    updateMiniport();
}

function updateMiniport() {
    if( !mapInfo.miniport ) {
        return;
    }
    var miniRect = $( 'mini-map' );
    var miniRectStyle = window.getComputedStyle( miniRect, '' );
    var tmp = new Number( new RegExp( '^(\\d*)' ).exec( miniRectStyle.width )[0] );
    //var tmp = new Number( miniRectStyle.width );
    //var ratio = mapInfo.sx / tmp;
    var ratio = tmp / mapInfo.sx;
    var box_width = Math.floor( mapInfo.vx * ratio );

    var miniRectBox = $( 'mini-map-box' );
    miniRectBox.style.width = box_width + 'px';
    miniRectBox.style.height = box_width + 'px';

    var pos_x = mapInfo.ox * ratio;
    var pos_y = mapInfo.oy * ratio;

    miniRectBox.style.left = pos_x + 'px';
    miniRectBox.style.top = pos_y + 'px';
    return;
}

function respManager( response ) {
    var respObj = resp2obj( response );

    switch( respObj.type ) {
        case 'nodelist' : {
            var el = $( 'nodes' );
            el.innerHTML = 'Kafelki za³adowane ! Wybierz poziom';
            var amount = new Number( respObj.amount );
            for( var i = 0; i < amount; i++ ) {
            //    var tmp = new Image();
            //    tmp.src= "images/Kafelki/" + respObj[ 'node_' + i ]['file'];
            //    tmp.className = "node-el";
            //    tmp.setAttribute( 'onclick', 'changeBrush(' + i + ')' );
            //    el.appendChild( tmp );
                brushArr[i] = respObj['node_' + i];
            }
            //curBrush = respObj[ 'node_' + ( amount-1 ) ];
            //changeBrush( 0 );
            break;
        }
    }
}

function setMode( newMode ){
    switch( mapInfo.mode ) {
        case 'tiles' : {
            $( 'nodes-container' ).style.display = 'none';
            $( 'node-info' ).style.display = 'none';
            break;
        }
        case 'groups' : {
            $( 'groups-container' ).style.display = 'none';
            break;
        }
    }
    mapInfo.mode = newMode;
    switch( mapInfo.mode ) {
        case 'tiles' : {
            $( 'nodes-container' ).style.display = 'block';
            $( 'node-info' ).style.display = 'block';
            break;
        }
        case 'groups' : {
            $( 'groups-container' ).style.display = 'block';
            break;
        }
    }
}

function changeBrush( index ) {
    curBrush = brushArr[index];
    var path = tilesPath + '/' + curBrush['level'] + '/' + curBrush['sub'] + '/' + curBrush['file'];
    var brv = $( 'brush-view' );
    brv.style.background = 'url( ' + path + ' )';

    updateBrushInfo();
}

function updateBrushInfo() {
    var brushInfo = $( 'brush-info' );
    var path = tilesPath + '/' + curBrush['level'] + '/' + curBrush['sub'] + '/' + curBrush['file'];

    var brush_img = $( 'brush-info-img' );
    if( !brush_img ) {
        var brush_img = new Image();
        brush_img.id = 'brush-info-img';
        brush_img.style.margin = '5px';
        brush_img.style.verticalAlign = 'top';
        brushInfo.insertBefore( brush_img, brushInfo.firstChild );
    }
    brush_img.src = path;

    var pass_yes = $( 'brush-info-pass-yes' );
    var pass_no = $( 'brush-info-pass-no' );

    if( curBrush['passable'] == '1' ) {
        pass_yes.checked = true;
    }
    else {
        pass_no.checked = true;
    }
}

function setBrushPassable( pass ) {
    curBrush['passable'] = pass;
}

function showBrushSub( catId ) {
    if( brushArr.length <= 0 ) {
        alert( "Kafelki nie zostaly jeszce wczytane !" );
        return;
    }
    var subs = new Array();
    for( var i = 0; i < brushArr.length; i++ ) {
        var tmp1 = subs.indexOf( brushArr[i]['sub'] );
        if( tmp1 < 0 && brushArr[i]['level'] == catId ) {
            subs.push( brushArr[i]['sub'] );
        }
    }
    //var foo;
    var subCont = $( 'nodes-sub' );
    while( subCont.hasChildNodes() ) {
        subCont.removeChild( subCont.firstChild );
    }

    for( var i = 0; i < subs.length; i++ ) {
        var tmp = document.createElement( 'div' );
        tmp.className = 'node-el';
        tmp.setAttribute( 'onclick', "showBrushes( " + catId + ", '" + subs[i] + "' )" );
        tmp.innerHTML = subs[i];
        subCont.appendChild( tmp );
    }
}

function showBrushes( catId, subCat ) {
    if( brushArr.lenght <= 0 ) {
        alert( "Kafelki nie zostaly jeszce wczytane !" );
        return;
    }

    var brCont = $( 'nodes' );
    while( brCont.hasChildNodes() ) {
        brCont.removeChild( brCont.firstChild );
    }
    var items = new Array();
    for( var i = 0; i < brushArr.length; i++ ) {
        if( brushArr[i]['level'] == catId && brushArr[i]['sub'] == subCat ) {
            //items.push( brushArr[i] );
            var path = tilesPath + '/' + brushArr[i]['level'] + '/' + brushArr[i]['sub'] + '/' + brushArr[i]['file'];
            //var tmp = document.createElement( 'div' );
            var tmp = new Image();
            tmp.src = path;
            tmp.className = 'node-el';
            tmp.setAttribute( 'onclick', 'changeBrush(' + i + ')' );
            brCont.appendChild( tmp );
        }
    }



    for( var i = 0; i < items.length; i++ ) {
        var tmp = document.createElement( 'div' );
        tmp.className
    }
}

function mouseOverMain( ev ) {
    var brv = $( 'brush-view' );
    brv.style.display = "block";
}


function mouseOutMain( ev ) {
    var brv = $( 'brush-view' );
    brv.style.display = "none";
}

function mouseMoveMain( ev ) {
    //var el = $( 'tmp' );
    var brv = $( 'brush-view' );
    var x = Math.floor( ev.layerX/40 ) * 40;
    var y = Math.floor( ev.layerY/40 ) * 40;

    brv.style.top = y + 'px';
    brv.style.left = x + 'px';
}

function mouseClickMain( ev ) {
    var target = ev.target;
    //var x = target.offsetLeft / 40;
    //var y = target.offsetTop / 40;
    var y = Math.floor( ev.layerX / 40 ) + mapInfo.oy;
    var x = Math.floor( ev.layerY / 40 ) + mapInfo.ox;

    mapData[x][y]['img'][ curBrush['level'] ] = curBrush;

    if( mapInfo.miniport ) {
        //var miniCell = $( 'mini_' + y + '_' + x );
        //miniCell.style.background = 'white';
    }

    updateCell( x, y );
}

function updateCell( x, y ) {
    if( x < 0 || y < 0 ) {
        return;
    }
    var cell = $( 'cell_' + x + 'x' + y );
    if( !cell ) {
        return;
    }
    var data = generateImgStack( x, y );

    while( cell.hasChildNodes() ) {
        cell.removeChild( cell.firstChild );
    }
    cell.appendChild( data );
}

function generateImgStack( x, y ) {
    var mapCell = mapData[x][y];
    var passable = 1;
    var root = document.createElement( 'div' );
    root.className = 'img-stack';
    var cur = root;
    //for( var i in mapCell['img'] ) {
    for( var i = 0; i < mapCell['img'].length; i++ ) {
        if( !mapCell['img'][i] ) {
            continue;
        }
        if( mapCell.img[i].passable == 0 ) {
            passable = 0;
        }
        var tmp = document.createElement( 'div' );
        tmp.className = 'img-stack';
        var path = tilesPath + '/' + mapCell['img'][i]['level'] + '/' + mapCell['img'][i]['sub'] + '/' + mapCell['img'][i]['file'];
        tmp.style.background = 'url( ' + path + ' )';
        tmp.style.zIndex = i*2;
        cur.appendChild( tmp );
        cur = tmp;
    }
    if( !passable ) {
        var tmpImg = new Image();
        tmpImg.src = 'images/map/spc_block.gif';
        cur.appendChild( tmpImg );
    }
    //cur.innerHTML = ' ';
    return root;
}

function sendMap() {
    var postArray = new Array();
    for( var i = 0; i < mapInfo.sx; i++ ) {
        for( var j = 0; j < mapInfo.sy; j++ ) {
            if( mapData[i][j]['img'] ) {
                for( var f in mapData[i][j]['img'] ) {
                    if( !f ) {
                        continue;
                    }
                    var el = mapData[i][j]['img'][f];
                    var tmp = "map[" + i + "][" + j + "][img][" + f + "][file]=" + encodeURIComponent( el['file'] );
                    postArray.push( tmp );
                    var tmp = "map[" + i + "][" + j + "][img][" + f + "][level]=" + encodeURIComponent( el['level'] );
                    postArray.push( tmp );
                    var tmp = "map[" + i + "][" + j + "][img][" + f + "][passable]=" + encodeURIComponent( el['passable'] );
                    postArray.push( tmp );
                    var tmp = "map[" + i + "][" + j + "][img][" + f + "][sub]=" + encodeURIComponent( el['sub'] );
                    postArray.push( tmp );
                }
            }

        }
    }
    tmp = "mapInfo[name]=" + encodeURIComponent( mapInfo.name );
    postArray.push( tmp );
    tmp = "mapInfo[size_x]=" + encodeURIComponent( mapInfo.sx );
    postArray.push( tmp );
    tmp = "mapInfo[size_y]=" + encodeURIComponent( mapInfo.sy );
    postArray.push( tmp );
    advAJAX.post( {
        url : 'ajax/ajax_level_editor.php',
        queryString : 'action=mapsave&' + postArray.join( '&' ),
        //onSuccess : function( obj ) {
            //alert( obj.responseText );
        //    respManager( obj.responseText );
            //refreshChat( -1 );
        //}
    } );
}

function loadMap() {
    advAJAX.post( {
        url : 'ajax/ajax_level_editor.php',
        queryString : 'action=loadmap&lid=1',
        onSuccess : function( obj ) {
            //alert( obj.responseText );
            respXml( obj.responseXML );
            //refreshChat( -1 );
        }
    } );
}

function addMapImg( x, y, level, data ) {
    if( !mapData[x] ) {
        mapData[x] = new Array();
    }
    if( !mapData[x][y] ) {
        mapData[x][y] = new Object();
    }
    if( !mapData[x][y]['img'] ) {
        mapData[x][y]['img'] = new Array();
    }
    if( !mapData[x][y]['img'][level] ) {
        mapData[x][y]['img'][level] = new Object();
    }
    mapData[x][y]['img'][level] = data;
    return;
}

function processMapDataXML( root ) {
    for( var i = 0; i < root.childNodes.length; i++ ) {
        var t_cell = root.childNodes[i];
        var t_x = t_cell.getAttribute( 'x' );
        var t_y = t_cell.getAttribute( 'y' );
        for( var j = 0; j < t_cell.childNodes.length; j++ ) {
            var t_img = t_cell.childNodes[j];
            for( var k = 0; k < t_img.childNodes.length; k++ ) {
                var t_entry = t_img.childNodes[k];
                var tmp = new Object();
                tmp.file = t_entry.getAttribute( 'file' );
                tmp.sub = t_entry.getAttribute( 'sub' );
                tmp.level = t_entry.getAttribute( 'level' );
                tmp.passable = t_entry.getAttribute( 'pass' );
                addMapImg( t_x, t_y, tmp.level, tmp );
                //updateCell( t_x, t_y );
            }
        }
    }
}

function respXml( root ) {

    if( root.firstChild.tagName == 'error' ) {
        var errorNode = root.firstChild;
        alert( errorNode.textContent );
        return;
    }

    //do we have any new nodes to save ?
    var t_mapData = root.firstChild.getElementsByTagName('mapData')[0];
    if( t_mapData ) {
        //then process it
        processMapDataXML( t_mapData );
    }

    draw();
}

function addGroup() {
    var group = new Object();
    group.name = prompt( "Podaj nazwê grupy ", "" );
    if( !group.name ) {
        return;
    }
    group.fields = new Object();
    
    mapGroups.push( group );
    
    showAllGroups();
}

function showAllGroups() {
    var root = $( 'groups-elements' );
    while( root.hasChildNodes() ) {
        root.removeChild( root.firstChild );
    }
    for( var i = 0; i < mapGroups.length; i++ ) {
    	var group = mapGroups[i];
    	var t_entry = document.createElement( 'div' );
    	t_entry.className = 'grp-el';
    	var tbtn = document.createElement( 'span' );
    	tbtn.className = "grp-btn";
    	tbtn.textContent = "ed";
    	t_entry.appendChild( tbtn );
    	var tbtn = document.createElement( 'span' );
    	tbtn.className = "grp-btn";
    	tbtn.textContent = "del";
    	t_entry.appendChild( tbtn );
    	t_entry.appendChild( document.createTextNode( group.name ) );
    	root.appendChild( t_entry );
	}
}