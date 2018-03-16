<?php /* Smarty version 2.6.9, created on 2015-06-18 20:50:42
         compiled from C:%5CApache+Software+Foundation%5CApache2.2%5Chtdocs%5Cmailing_list/templates/admin/member_update.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'C:\\Apache Software Foundation\\Apache2.2\\htdocs\\mailing_list/templates/admin/member_update.tpl', 33, false),)), $this); ?>
<html>
  <head>
  <title><?php echo @ADMIN_TITLE; ?>
</title>
  <meta http-equiv="Content-Language" content="ja">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="robots" content="noindex,nofollow,noarchive">
  <meta http-equiv="Content-Style-Type" content="text/css">
  <link rel="stylesheet" href="./_design/styles/core.css" type="text/css">
  <script type="text/javascript" src="../js/jquery-1.10.2.min.js"></script>
  <script type="text/javascript" src="../js/jquery-ui.js"></script>
  <script type="text/javascript" src="../js/jquery.ui.datepicker-ja.min.js"></script>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
  <script>
    $(function() {
      $.datepicker.setDefaults( $.datepicker.regional[ "ja" ] );
      $( "#datepicker" ).datepicker();
    });
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
      <div id="bodyContainer">
        <h3>編集フォーム</h3>
        <h4><span style="color:red">※</span>は必須入力項目です。</h4>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/_error_msg.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <form action="<?php echo @URL_ROOT_HTTPS; ?>
/tcm-admin/member_update.php" method="post">
          <table class="form">
            <tr>
              <th>社名<span style="color:red">※</span></th>
              <td>
                <input type="text" name="company" size="20" value=<?php echo ((is_array($_tmp=$this->_tpl_vars['input_map']['company'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
>
              </td>
            </tr>
            <tr>
              <th>氏名<span style="color:red">※</span></th>
              <td>
                <input type="text" name="member_name" size="20" value=<?php echo ((is_array($_tmp=$this->_tpl_vars['input_map']['member_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
>
              </td>
            </tr>
            <tr>
              <th>メールアドレス<span style="color:red">※</span></th>
                <td><input type="text" name="mail_address" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['input_map']['mail_address'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" size="25"></td>
            </tr>
            <tr>
              <th>備考テキスト</th>
              <td><textarea cols="27" rows="3" name="memo"><?php echo ((is_array($_tmp=$this->_tpl_vars['input_map']['memo'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</textarea><br /></td>
            </tr>
          </table><br>
          <input type="hidden" value=<?php echo ((is_array($_tmp=$this->_tpl_vars['page'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 name="page">
          <input type="hidden" value=<?php echo ((is_array($_tmp=$this->_tpl_vars['number'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 name="number">
          <input type="hidden" value=<?php echo ((is_array($_tmp=$this->_tpl_vars['hishounin'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 name="hishounin">
          <input type="hidden" value=<?php echo ((is_array($_tmp=$this->_tpl_vars['input_map']['approval_status'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 name="approval_status">
          <input type="hidden" value=<?php echo ((is_array($_tmp=$this->_tpl_vars['input_map']['group_id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 name="group_id">
          <input type="hidden" value=<?php echo ((is_array($_tmp=$this->_tpl_vars['input_map']['member_id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 name="member_id">
          <input type="hidden" value=<?php echo ((is_array($_tmp=$this->_tpl_vars['input_map']['mail_address'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 name="mail_address_1">
          <input type="hidden" value="confirmation" name="mode">
          <input type="submit" value="入力内容確認" class="button">
        </form>
      </div>
      <div id="bodyContainer">
        <?php if ($this->_tpl_vars['hishounin'] == '1'): ?>
        <a href="<?php echo @URL_ROOT_HTTPS; ?>
/tcm-admin/member_non_admitted_list.php?page=<?php echo ((is_array($_tmp=$this->_tpl_vars['number'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">戻る</a>
        <?php else: ?>
        <a href="<?php echo @URL_ROOT_HTTPS; ?>
/tcm-admin/group_member_list.php?group_id=<?php echo ((is_array($_tmp=$this->_tpl_vars['input_map']['group_id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
&approval_status=<?php echo ((is_array($_tmp=$this->_tpl_vars['input_map']['approval_status'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
&number=<?php echo ((is_array($_tmp=$this->_tpl_vars['number'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">戻る</a>
        <?php endif; ?>
      </div>
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