<?php /* Smarty version 2.6.9, created on 2015-06-18 20:50:38
         compiled from C:%5CApache+Software+Foundation%5CApache2.2%5Chtdocs%5Cmailing_list/templates/admin/member_date.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'C:\\Apache Software Foundation\\Apache2.2\\htdocs\\mailing_list/templates/admin/member_date.tpl', 20, false),array('modifier', 'date_format', 'C:\\Apache Software Foundation\\Apache2.2\\htdocs\\mailing_list/templates/admin/member_date.tpl', 32, false),array('modifier', 'nl2br', 'C:\\Apache Software Foundation\\Apache2.2\\htdocs\\mailing_list/templates/admin/member_date.tpl', 48, false),)), $this); ?>
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
        <h3>メンバー詳細</h3>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/_error_msg.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <table class="form"  width="50%">
          <tr>
            <th width="40%">グループ名</th>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['group_name_map']['group_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
          </tr>
          <tr>
            <th width="40%">社名</th>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['group_member_map']['company'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
          </tr>
          <tr>
            <th width="40%">氏名</th>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['group_member_map']['member_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
          </tr>
          <tr>
            <th width="40%">研修日</th>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['group_member_map']['training_datetime'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
</td>
          </tr>
          <tr>
            <th width="40%">研修コード</th>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['trainingcodeDef']->getStringByValue($this->_tpl_vars['group_member_map']['training_code']))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
          </tr>
          <tr>
            <th width="40%">テーブルID</th>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['tablecodeDef']->getStringByValue($this->_tpl_vars['group_member_map']['table_code']))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
          </tr>
          <tr>
            <th width="40%">メールアドレス</th>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['group_member_map']['mail_address'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
          </tr>
          <tr>
            <th width="40%">備考テキスト</th>
            <td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['group_member_map']['memo'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</td>
          </tr>
        </table>
        <br><br>
        <div>
          <a href="<?php echo @URL_ROOT_HTTPS; ?>
/tcm-admin/group_member_list.php?group_id=<?php echo ((is_array($_tmp=$this->_tpl_vars['group_member_map']['group_id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
&approval_status=<?php echo ((is_array($_tmp=$this->_tpl_vars['approval_status'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
&number=<?php echo ((is_array($_tmp=$this->_tpl_vars['page'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">戻る</a>
        </div>
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