<?php /* Smarty version 2.6.9, created on 2018-03-27 19:10:35
         compiled from admin/_header.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'admin/_header.tpl', 4, false),)), $this); ?>
<div id="header">
  <h1></h1>
  <p id="logout"><input type="button" value="ログアウト" onClick="location.href='<?php echo @URL_ROOT_HTTPS; ?>
/tcm-admin/logout.php'"></p>
  <p id="user">ログインID: <?php echo ((is_array($_tmp=$_SESSION['a']['login_id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</p>
</div>