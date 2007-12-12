<?php

define( "BB_VAL_STRING", 0x001 );
define( "BB_VAL_HREF", 0x002 );
define( "BB_VAL_HEX", 0x004 );
define( "BB_VAL_COLOR", 0x008 );
define( "BB_VAL_LENGTH", 0x010 );
define( "BB_VAL_LENGTH_MULTI", 0x020 );
define( "BB_VAL_AUTO", 0x040 );

function bbcode_profile( $text ) {
	$cssArray = array( 'color' => BB_VAL_COLOR | BB_VAL_HEX,
					'background-color' => BB_VAL_HEX | BB_VAL_COLOR,
					'border-color' =>  BB_VAL_HEX | BB_VAL_COLOR,
					'border-width' => BB_VAL_LENGTH,
					'border-style' => array( 'solid', 'none', 'dotted', 'dashed', 'double'),
					'border-top-color' =>  BB_VAL_HEX | BB_VAL_COLOR,
					'border-top-style' => array( 'solid', 'none', 'dotted', 'dashed', 'double'),
					'border-left-color' =>  BB_VAL_HEX | BB_VAL_COLOR,
					'border-left-style' => array( 'solid', 'none', 'dotted', 'dashed', 'double'),
					'border-right-color' =>  BB_VAL_HEX | BB_VAL_COLOR,
					'border-right-style' => array( 'solid', 'none', 'dotted', 'dashed', 'double'),
					'border-bottom-color' =>  BB_VAL_HEX | BB_VAL_COLOR,
					'border-bottom-style' => array( 'solid', 'none', 'dotted', 'dashed', 'double'),
					'clear' => array( 'none', 'left', 'right', 'both', 'inerhit' ),
					'cursor' => array( 'auto', 'crosshair', 'default', 'pointer', 'text', 'wait', 'help' ),
					'display' => array( 'inline', 'block', 'none', 'inherit' ),
					'float' => array( 'left', 'right', 'none', 'inherit' ),
					'font-size' => BB_VAL_LENGTH,
					'font-weight' => array( 'normal', 'bold' ),
					'font-style' => array( 'normal', 'oblique', 'italic' ),
					'line-height' => BB_VAL_LENGTH,
					'height' => BB_VAL_LENGTH,
					'left' => BB_VAL_LENGTH,
					'list-style-position' => array( 'inside', 'outside', 'inherit' ),
					'list-style-type' => array( 'disc', 'circle', 'square', 'decimal', 'decimal-leading-zero', 'lower-roman', 'upper-roman' ),
					'margin' => BB_VAL_LENGTH_MULTI | BB_VAL_AUTO,
					'margin-top' => BB_VAL_LENGTH,
					'margin-bottom' => BB_VAL_LENGTH,
					'margin-left' => BB_VAL_LENGTH,
					'margin-right' => BB_VAL_LENGTH,
					'max-width' => BB_VAL_LENGTH,
					'max-height' => BB_VAL_LENGTH,
					'min-width' => BB_VAL_LENGTH,
					'min-height' => BB_VAL_LENGTH,
					'outline-color' => BB_VAL_HEX | BB_VAL_COLOR,
					'outline-style' => array( 'solid', 'none', 'dotted', 'dashed', 'double'),
					'outline-width' => BB_VAL_LENGTH,
					'padding' => BB_VAL_LENGTH_MULTI,
					'padding-top' => BB_VAL_LENGTH | BB_VAL_AUTO,
					'padding-left' => BB_VAL_LENGTH,
					'padding-right' => BB_VAL_LENGTH,
					'padding-bottom' => BB_VAL_LENGTH,
					'position' => array( 'static', 'relative', 'absolute' ),
					'right' => BB_VAL_LENGTH,
					'text-align' => array( 'left', 'right', 'center', 'justify' ),
					'text-decoration' => array( 'none', 'underline', 'overline', 'line-through', 'blink' ),
					'text-indent' => BB_VAL_LENGTH,
					'text-transform' => array( 'capitalize', 'uppercase', 'lowercase', 'none', 'inherit' ),
					'top' => BB_VAL_LENGTH,
					'white-space' => array( 'normal', 'pre', 'nowrap' ),
					'width' => BB_VAL_LENGTH,
					
					'href' => BB_VAL_HREF,
					'name' => BB_VAL_STRING );
	$text = strip_tags( $text );
	$text = str_replace( array( '[br]', '[hr]' ), array( "<br/>", "<hr/>" ), $text );
	bbcode_profile_parse( &$text, $cssArray );
	//qDebug( $text );
	return $text;
}

/**
 * Enter description here...
 *
 * @access private
 * 
 * @param string $input
 * @param array $cssArray
 */
function bbcode_profile_parse( &$input, $cssArray ) {
	$matches = NULL;
	$regExp = "/(\\[([\\w]+)[^]]*\\])(.*)(\\[\\/\\2\\])/sU";
	preg_match_all( $regExp, $input, $matches, PREG_SET_ORDER);
	//qDebug( $matches );
	foreach( $matches as $match ) {
		$test = NULL;
		if( preg_match( $regExp, $match[3], $test) ) {
			$old = $match[3];
			bbcode_profile_parse( $match[3], $cssArray );
			$input = str_replace( $old, $match[3], $input );
			$match[0] = str_replace( $old, $match[3], $match[0] );
			//qDebug( "Inner _parse : {$match[0]}" );
		}
		//$rep = "({$match[2]}){$match[3]}(/{$match[2]})";
		//$input = str_replace( $match[0], $rep, $input );
		$new = $match[3];
		bbcode_profile_apply_bb( $new, $match[1], $cssArray );
		//qDebug( "Input : $input\nMatch : {$match[0]}\nNew : $new" );
		$input = str_replace( $match[0], $new, $input );
		//qDebug( $count );
	}
	//qDebug( "EOF : $input" );
	//$new = match[]
	
	//return $new;
}

function bbcode_profile_apply_bb( &$input, $tag, $cssArray ) {
	$params = NULL;
	preg_match_all( "/\[(\w+)/", $tag, $params, PREG_SET_ORDER );
	$styles = NULL;
	preg_match_all( "/([\w-]*)=\"([^\"]*)\"/", $tag, $styles, PREG_SET_ORDER );
	$params = $params[0];
	
	$rawTag = $params[1];
	if( !in_array( $rawTag, array( 'a', 'b', 'i', 'u', 'ul', 'li', 'ol', 'table', 'tr', 'td', 'div', 'div1', 'div2', 'div3', 'div4', 'span', 'span1', 'span2', 'span3', 'span4', 'text', 'block', 'center' ) ) ) {
		echo "Wrong tag name <b>$rawTag</b>. Skipping whole tag formatting<br/>";
		return "";
	}
	$tagStyle = "";
	$atrArray = array();
	//qDebug( $tag );
	foreach( $styles as $style ) {
		$styleName = $style[1];
		$styleValue = $style[2];
		if( in_array( $styleName, array( 'name', 'href' ) ) ) { 
			if( bbcode_profile_check_bb_val( $styleValue, $cssArray[$styleName] ) ) {
				$atrArray[$styleName] = $styleValue;
			}
			else {
				echo "Wrong attribute definition : <b>$styleName=\"$styleValue\"</b> !<br/>";
			}
			continue;
		}
		if( isset( $cssArray[$styleName] ) && bbcode_profile_check_bb_val( $styleValue, $cssArray[$styleName] ) ) {
			$tagStyle .= "$styleName: $styleValue;";
		}
		else {
			echo "Wrong style definition : <b>$styleName=\"$styleValue\"</b> !<br/>";
		}
	}
	
	$tagTrans = array( 'text' => 'span', 'block' => 'div' );
	foreach( $atrArray as $k=>$a ) {
		$atrArray[$k] = "$k=\"$a\"";
	}
	if( isset( $tagTrans[$rawTag] ) ) {
		$rawTag = $tagTrans[$rawTag];
	}
	//qDebug( $rawTag );
	$attributes = implode( " ", $atrArray );
	$newOpen = "<$rawTag $attributes style='$tagStyle'>";
	$newClose = "</$rawTag>";
	$input = $newOpen . $input . $newClose;

	return $input;
}

function bbcode_profile_check_bb_val( $value, $flags ) {
	$ret = false;
	if( is_array( $flags ) ) {
		if( in_array( $value, $flags ) ) {
			return true;
		}
		return false;
	}
	//qDebug( $value );
	//qDebug( $flags );
	if( $flags & BB_VAL_STRING ) {
		$reg = "/^[\w-_]+\$/";
		$test = NULL;
		if( preg_match_all( $reg, $value, $test ) ) {
			$ret = true;
		}
	}
	if( $flags & BB_VAL_HEX ) {
		$reg = "/^#[a-fA-F0-9]{6,6}\$/";
		$test = NULL;
		if( preg_match_all( $reg, $value, $test ) ) {
			$ret = true;
		}
	}
	if( $flags & BB_VAL_HREF ) {
		$reg = "/(^#[\w-_]*\$)/";
		$test = NULL;
		if( preg_match_all( $reg, $value, $test ) ) {
			$ret = true;
		}
	}
	if( $flags & BB_VAL_COLOR ) {
		//$reg = "/#[0-9a-fA-F]{6,6}/";
		//$test = NULL;
		//preg_match_all( $reg, $value, $test );
		//qDebug( $test );
		$colors = array( 'red', 'green', 'blue' );
		if( in_array( $value, $colors ) ) {
			$ret = true;
		}
	}
	if( $flags & BB_VAL_LENGTH ) {
		$reg = "/^(\d{1,3}\.?\d{0,1}(px|em|ex|cm|mm)".( ($flags & BB_VAL_AUTO)?"|auto":"").")\$/";
		$test = NULL;
		if( preg_match_all( $reg, $value, $test ) ) {
			$ret = true;
		}
	}
	if( $flags & BB_VAL_LENGTH_MULTI ) {
		$reg = "/^(\s*(\d{1,3}\.?\d{0,1}(px|em|ex|cm|mm)".( ($flags & BB_VAL_AUTO)?"|auto":"").")\s*){1,4}\$/";
		$test = NULL;
		if( preg_match_all( $reg, $value, $test ) ) {
			$ret = true;
		}
	}
	return $ret;
}

?>