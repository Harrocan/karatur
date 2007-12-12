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
function smarty_function_css_popup_navig($params, &$smarty) {
	$active = '';
	if( isset( $params['active']) && $params['active'] ) {
		$active=" btn-active";
	}
	$ret = <<<EOT
<a href="{$params['url']}" class="css-popup"><img class="bar-btn{$active}" src="images/layout/btn/{$params['img']}"/><div class="css-popup-content kt_nav" style="width:180px"><div class="kt_nav_title">{$params['title']}</div><div class="kt_nav_cont">{$params['text']}</div></div></a>
EOT;
	return $ret;
}

?>