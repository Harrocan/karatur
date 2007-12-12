<?php /* Smarty version 2.6.16, created on 2007-08-09 12:45:39
         compiled from harptos_admin_page.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'harptos_admin_page.tpl', 3, false),)), $this); ?>
<form method="POST" action="?">
Podaj date zdarzenia : <select name="date">
	<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['Dates']), $this);?>

</select><br/>
Podaj tre¶æ zdarzenia :<br/>
<textarea name="body" style="width:100%;height:100px"></textarea><br/>
<input type="submit" value="dalej" />
</form>