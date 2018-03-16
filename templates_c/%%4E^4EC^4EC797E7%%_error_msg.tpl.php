<?php /* Smarty version 2.6.9, created on 2018-03-15 18:47:31
         compiled from admin/_error_msg.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'admin/_error_msg.tpl', 14, false),)), $this); ?>
<?php if (is_array ( $this->_tpl_vars['error_map'] )): ?>
  <table class="form" width="90%">
  <tr>
    <td style="background-color:#f7f7f7;">
      <table class="no_table" border="0" cellpadding="0" cellspacing="0" bgcolor="#cccccc">
      <tr>
      <td width="20" style="background-color:#f7f7f7;">&nbsp;</td>
      <td width="100" valign="middle" style="background-color:#f7f7f7;">
      <img src="<?php echo @URL_ROOT_HTTPS; ?>
/tcm-admin/_design/images/error_arrow.gif" style="padding-left:30px; padding-right:40px; padding-top:10px; padding-bottom:10px;"/>
      </td>
      <td style="background-color:#f7f7f7; color:#FF0000; padding-top:10px; padding-bottom:10px;">
      <p class="error">
        <?php $_from = $this->_tpl_vars['error_map']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['msg']):
?>
          <?php echo ((is_array($_tmp=$this->_tpl_vars['msg'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<br>
        <?php endforeach; endif; unset($_from); ?>
      </p>
      </td>
      </tr>
      </table>
    </td>
  </tr>
  </table>
  <br>
<?php endif; ?>