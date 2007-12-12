<?php

/*!
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.metaText.php
 * Type:     function
 * Name:     metaText
 * Purpose:  outputs a text from meta-translated texts
 * -------------------------------------------------------------
 */
function smarty_function_metaText($params, &$smarty) {
	if( empty( $params['value'] ) ) {
		$smarty->trigger_error( "missing attribute 'value'" );
	}
	global $locale;
	$text = $params['value'];
	$try = SqlExec( "SELECT data FROM `metaText` WHERE `key`='$text'" );
	if( $try -> fields['data'] ) {
		return $try -> fields['data'];
	}
	else {
		return "<i>[missing translation]$text</i>";
	}
}

?>