<?php /* Smarty version 2.6.9, created on 2015-06-23 12:09:39
         compiled from C:%5CApache+Software+Foundation%5CApache2.2%5Chtdocs%5Cmailing_list/templates/admin/member_update_confirmation.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'C:\\Apache Software Foundation\\Apache2.2\\htdocs\\mailing_list/templates/admin/member_update_confirmation.tpl', 21, false),array('modifier', 'nl2br', 'C:\\Apache Software Foundation\\Apache2.2\\htdocs\\mailing_list/templates/admin/member_update_confirmation.tpl', 33, false),)), $this); ?>
<html>
 <head>
  <title><?php echo @ADMIN_TITLE; ?>
</title>
  <meta http-equiv="Content-Language" content="ja">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="robots" content="noindex,nofollow,noarchive">
  <meta http-equiv="Content-Style-Type" content="text/css">
  <link rel="stylesheet" href="./_design/styles/core.css" type="text/css">
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
        <h3>入力確認</h3>
        <h4>以下の内容で送信します。よろしいでしょうか</h4>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/_error_msg.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <table class="form">
          <tr>
            <th>社名</th>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['input_map']['company'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
          </tr>
          <tr>
            <th>氏名</th>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['input_map']['member_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
          </tr>
          <tr>
            <th>メールアドレス</th>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['input_map']['mail_address'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
          </tr>
          <tr>
            <th>備考テキスト</th>
            <td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['input_map']['memo'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</td>
          </tr>
        </table>
        <br><br>
        <table>
          <tr>
            <form action="<?php echo @URL_ROOT_HTTPS; ?>
/tcm-admin/member_update.php" method="post">
              <td>
                <input type="submit" value="登録" class="button">
              </td>
              <input type="hidden" name="page" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['input_map']['page'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
              <input type="hidden" name="hishounin" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['hishounin'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
              <input type="hidden" name="number" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['number'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
              <input type="hidden" name="group_id" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['group_id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
              <input type="hidden" name="page" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['page'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
              <input type="hidden" name="mode" value="completion">
              <input type="hidden" name="mail_address_1" value=<?php echo ((is_array($_tmp=$this->_tpl_vars['input_map']['mail_address_1'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
>
              <input type="hidden" name="post_key" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['post_key'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
            </form>
            <form action="<?php echo @URL_ROOT_HTTPS; ?>
/tcm-admin/member_update.php?number=<?php echo ((is_array($_tmp=$this->_tpl_vars['input_map']['number'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" method="post">
              <td>
                <input type="submit" value="戻る" class="button">
              </td>
              <input type="hidden" name="mode" value="back">
            </form>
          </tr>
        </table>
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