<?php /* Smarty version 2.6.9, created on 2015-06-15 14:24:45
         compiled from _error_msg.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', '_error_msg.tpl', 11, false),)), $this); ?>
<?php if (is_array ( $this->_tpl_vars['error_map'] )): ?>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="mt_15">
<tr>
<th class="warning">
<table class="error_table" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td width="100%" class="txt">
<table border="0" cellpadding="0" cellspacing="0">
<?php $_from = $this->_tpl_vars['error_map']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['msg']):
?>
<tr>
<td class="erorr"><?php echo ((is_array($_tmp=$this->_tpl_vars['msg'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
</tr>
<?php endforeach; endif; unset($_from); ?>
</table>
</td>
</tr>
</table>
</th>
</tr>
</table>
<?php endif; ?>