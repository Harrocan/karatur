<?php /* Smarty version 2.6.16, created on 2007-12-12 21:41:01
         compiled from userlist.tpl */ ?>
<div style="text-align:center;font-weight:bold">Obecnie w krainie</div>
<?php unset($this->_sections['od']);
$this->_sections['od']['name'] = 'od';
$this->_sections['od']['loop'] = is_array($_loop=$this->_tpl_vars['userlist']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['od']['show'] = true;
$this->_sections['od']['max'] = $this->_sections['od']['loop'];
$this->_sections['od']['step'] = 1;
$this->_sections['od']['start'] = $this->_sections['od']['step'] > 0 ? 0 : $this->_sections['od']['loop']-1;
if ($this->_sections['od']['show']) {
    $this->_sections['od']['total'] = $this->_sections['od']['loop'];
    if ($this->_sections['od']['total'] == 0)
        $this->_sections['od']['show'] = false;
} else
    $this->_sections['od']['total'] = 0;
if ($this->_sections['od']['show']):

            for ($this->_sections['od']['index'] = $this->_sections['od']['start'], $this->_sections['od']['iteration'] = 1;
                 $this->_sections['od']['iteration'] <= $this->_sections['od']['total'];
                 $this->_sections['od']['index'] += $this->_sections['od']['step'], $this->_sections['od']['iteration']++):
$this->_sections['od']['rownum'] = $this->_sections['od']['iteration'];
$this->_sections['od']['index_prev'] = $this->_sections['od']['index'] - $this->_sections['od']['step'];
$this->_sections['od']['index_next'] = $this->_sections['od']['index'] + $this->_sections['od']['step'];
$this->_sections['od']['first']      = ($this->_sections['od']['iteration'] == 1);
$this->_sections['od']['last']       = ($this->_sections['od']['iteration'] == $this->_sections['od']['total']);
 $this->assign('Data', $this->_tpl_vars['userlist'][$this->_sections['od']['index']]['data']); ?>
<div class="pl-list">
	<img src="images/ranks/<?php echo $this->_tpl_vars['Data']['image']; ?>
"/> <a href="view.php?view=<?php echo $this->_tpl_vars['Data']['id']; ?>
"><?php echo $this->_tpl_vars['Data']['user']; ?>
</a><?php if ($this->_tpl_vars['Data']['tribeimg'] != ''): ?> <img src="images/tribes/mini/<?php echo $this->_tpl_vars['Data']['tribeimg']; ?>
"/><?php endif; ?>
	<div class="pl-data">
		<div class="pl-list-title"><?php echo $this->_tpl_vars['Data']['user']; ?>
 (<?php echo $this->_tpl_vars['Data']['id']; ?>
)</div>
		<?php if ($this->_tpl_vars['Data']['avatar']): ?>
		<img src="avatars/thumb_<?php echo $this->_tpl_vars['Data']['avatar']; ?>
" alt="<?php echo $this->_tpl_vars['Data']['user']; ?>
" class="pl-list-img"/>
		<?php endif; ?>
		Poziom: <?php echo $this->_tpl_vars['Data']['level']; ?>
<br/>
		W krainie: <?php echo $this->_tpl_vars['Data']['age']; ?>
 dni<br/>
		Rasa: <?php echo $this->_tpl_vars['Data']['rasa']; ?>
<br/>
		
		Miejsce: <?php echo $this->_tpl_vars['Data']['miejsce']; ?>
<br/>
		Widziany: <?php echo $this->_tpl_vars['Data']['page']; ?>
<br/>
		Ranga: <?php echo $this->_tpl_vars['Data']['rankname']; ?>
<br/>
		Opis: <?php echo $this->_tpl_vars['Data']['opis']; ?>
<br/>
	</div>
</div>
<?php endfor; endif; ?><br/>
<div style="text-align:center;border-top:solid 1px">
	Po ulicach chodzi <b><?php echo $this->_tpl_vars['usercurrent']; ?>
</b> osób<br/>
	W krainie mieszka <b><?php echo $this->_tpl_vars['usertotal']; ?>
</b> istot
</div>