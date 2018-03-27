<?php /* Smarty version 2.6.9, created on 2018-03-27 16:46:07
         compiled from _error_msg.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', '_error_msg.tpl', 4, false),)), $this); ?>
<?php if (is_array ( $this->_tpl_vars['error_map'] )): ?>
	<div class="error_box">
		<?php $_from = $this->_tpl_vars['error_map']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['msg']):
?>
			<p class="error"><?php echo ((is_array($_tmp=$this->_tpl_vars['msg'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</p>
		<?php endforeach; endif; unset($_from); ?>
	</div>
<?php endif; ?>