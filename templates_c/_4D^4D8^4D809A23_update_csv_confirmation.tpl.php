<?php /* Smarty version 2.6.9, created on 2015-06-19 10:24:07
         compiled from C:%5CApache+Software+Foundation%5CApache2.2%5Chtdocs%5Cmailing_list/templates/admin/update_csv_confirmation.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'C:\\Apache Software Foundation\\Apache2.2\\htdocs\\mailing_list/templates/admin/update_csv_confirmation.tpl', 37, false),array('modifier', 'date_format', 'C:\\Apache Software Foundation\\Apache2.2\\htdocs\\mailing_list/templates/admin/update_csv_confirmation.tpl', 37, false),)), $this); ?>
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
      <div id="bodyContainer_ken">
        </form>
      </div>
      <!-- コンテンツヘッダー部  end  -->
      <div id="bodyContainer">
        <h3>アップロード確認画面</h3>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/_error_msg.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <?php if (! strlen ( $this->_tpl_vars['error_map'] )): ?>
        <form action="approval.php" method="POST" name="approval_form">
          <table class="table" width="95%">
            <tr>
              <th width="10%">登録日</th>
              <th width="10%">メーリスグループ</th>
              <th width="10%">社名</th>
              <th width="10%">氏名</th>
              <th width="10%">研修日</th>
              <th width="10%">研修コード</th>
              <th width="10%">テーブルID</th>
              <th width="10%">メールアドレス</th>
              <th width="10%">備考</th>
            </tr>
            <?php $_from = $this->_tpl_vars['update_csv_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item_key'] => $this->_tpl_vars['csv_map']):
?>
              <tr>
                <td><center><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['csv_map']['8'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
</center></td>
                <td><center><?php echo ((is_array($_tmp=$this->_tpl_vars['csv_map']['7'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</center></td>
                <td><center><?php echo ((is_array($_tmp=$this->_tpl_vars['csv_map']['0'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</center></td>
                <td><center><?php echo ((is_array($_tmp=$this->_tpl_vars['csv_map']['1'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</center></td>
                <td><center><?php echo ((is_array($_tmp=$this->_tpl_vars['csv_map']['2'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</center></td>
                <td><center><?php echo ((is_array($_tmp=$this->_tpl_vars['csv_map']['3'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</center></td>
                <td><center><?php echo ((is_array($_tmp=$this->_tpl_vars['tablecodeDef']->getStringByValue($this->_tpl_vars['csv_map']['4']))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</center></td>
                <td><center><?php echo ((is_array($_tmp=$this->_tpl_vars['csv_map']['5'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</center></td>
                <td><center><?php echo ((is_array($_tmp=$this->_tpl_vars['csv_map']['6'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</center></td>
              </tr>
            <?php endforeach; endif; unset($_from); ?>
          </table>
        </form>
        <form action="<?php echo @URL_ROOT_HTTPS; ?>
/tcm-admin/update_csv.php" method="post">
          <input type="submit" value="登録" class="button">
          <input type="hidden" name="mode" value="completion">
          <input type="hidden" name="post_key" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['post_key'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
        </form>
        <?php endif; ?>
        <form action="<?php echo @URL_ROOT_HTTPS; ?>
/tcm-admin/update_csv.php" method="post">
          <input type="submit" value="戻る" class="button">
          <input type="hidden" name="mode" value="back">
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