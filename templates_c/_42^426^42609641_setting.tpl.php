<?php /* Smarty version 2.6.9, created on 2015-06-19 17:04:01
         compiled from C:%5CApache+Software+Foundation%5CApache2.2%5Chtdocs%5Cmailing_list/templates/admin/setting.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'C:\\Apache Software Foundation\\Apache2.2\\htdocs\\mailing_list/templates/admin/setting.tpl', 30, false),)), $this); ?>
<html>
  <head>
  <title><?php echo @ADMIN_TITLE; ?>
</title>
  <meta http-equiv="Content-Language" content="ja">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="robots" content="noindex,nofollow,noarchive">
  <meta http-equiv="Content-Style-Type" content="text/css">
  <link rel="stylesheet" href="./_design/styles/core.css" type="text/css">
  <script type="text/javascript">
  function setting() {
    res = confirm('設定をを変更してもよろしいでしょうか？');
  if (res == true) {
    document.setting_form.action = 'setting.php?mode=completion&send=1';
    document.setting_form.submit()
  }
  }
  </script>
  </head>
  <body>
    <div id="body">
      <!-- コンテンツヘッダー部 start -->
      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
      <!-- コンテンツヘッダー部  end  -->
      <div id="bodyContainer">
        <h3>管理者アドレス設定</h3>
        <form action="setting.php" method="POST" name="setting_form">
          <table class="table" width="80%">
            <tr>
              <th width="10%"  rowspan="4" >常にグループに含まれるメールアドレス</td>
              <td width="20%"  height="50px"><center>管理者１    <input type="text" name="manager_address1" size="50" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['setting_map']['manager_address1'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></center></td>
            </tr>
            <tr>
              <td width="20%"  height="50px"><center>管理者２    <input type="text" name="manager_address2" size="50" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['setting_map']['manager_address2'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></center></td>
            </tr>
            <tr>
              <td width="20%"  height="50px"><center>管理者３    <input type="text" name="manager_address3" size="50" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['setting_map']['manager_address3'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></center></td>
            </tr>
            <tr>
              <td width="20%"  height="50px"><center>管理者４    <input type="text" name="manager_address4" size="50" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['setting_map']['manager_address4'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></center></td>
            </tr>
          </table><br>
          <input type="button" value="管理者アドレス変更" onclick="setting()" />
        </form>
      </div>
      <br>
      <br>
    </div>
    <!-- メニュー部 start -->
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/_menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <!-- メニュー部  end  -->
  </body>
</html>