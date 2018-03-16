<?php /* Smarty version 2.6.9, created on 2015-06-18 20:50:30
         compiled from C:%5CApache+Software+Foundation%5CApache2.2%5Chtdocs%5Cmailing_list/templates/admin/approval.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'C:\\Apache Software Foundation\\Apache2.2\\htdocs\\mailing_list/templates/admin/approval.tpl', 41, false),array('modifier', 'date_format', 'C:\\Apache Software Foundation\\Apache2.2\\htdocs\\mailing_list/templates/admin/approval.tpl', 41, false),)), $this); ?>
<html>
  <head>
  <title><?php echo @ADMIN_TITLE; ?>
</title>
  <meta http-equiv="Content-Language" content="ja">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="robots" content="noindex,nofollow,noarchive">
  <meta http-equiv="Content-Style-Type" content="text/css">
  <link rel="stylesheet" href="./_design/styles/core.css" type="text/css">
  <script>
  function clickDelete(id, page) {
  var res;
  res = confirm("削除します。よろしいですか？");
  if (res == true) {
    location.href = "<?php echo @URL_ROOT_HTTPS; ?>
/tcm-admin/member_delete.php?id=" + id + "&page=" + page;
  }
  }
  //-->
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
        <h3>承認確認画面</h3>
        <?php if (is_array ( $this->_tpl_vars['error_map'] )): ?>
          <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/_error_msg.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
          <p class="message"><?php echo $this->_tpl_vars['count_member']; ?>
</p>
          <p class="resultPage"><?php echo $this->_tpl_vars['paging_link']; ?>
</p>
        <?php else: ?>
          <form action="approval.php" name="approval_form" method="post">
          <table class="table" width="95%">
            <tr>
              <th>研修日</th>
              <th>メーリスグループ</th>
              <th>参加人数</th>
              <th>メーリスメールアドレス</th>
              </tr>
              <?php $_from = $this->_tpl_vars['group_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['group_list']):
?>
                <tr>
                  <td width="10%"><center><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['group_list']['training_datetime'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
</center></td>
                  <td width="10%"><center><?php echo ((is_array($_tmp=$this->_tpl_vars['group_list']['group_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</center></td>
                  <td width="10%"><center><?php echo ((is_array($_tmp=$this->_tpl_vars['group_list']['group_number'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</center></td>
                  <td width="10%"><center><?php echo ((is_array($_tmp=$this->_tpl_vars['group_list']['mailing_list_address'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</center></td>
                </tr>
                <input type="hidden" name="group_id[]" value=<?php echo ((is_array($_tmp=$this->_tpl_vars['group_list']['group_id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
>
                <input type="hidden" name="group_name[]" value=<?php echo ((is_array($_tmp=$this->_tpl_vars['group_list']['group_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
>
              <?php endforeach; endif; unset($_from); ?>
              </tr>
            </table>
          <input type="hidden" name="mode" value="completion">
          <input type="submit" value="実行">
          </form>
        <?php endif; ?>
        <p><a href="<?php echo @URL_ROOT_HTTPS; ?>
/tcm-admin/group_list.php?page=<?php echo ((is_array($_tmp=$this->_tpl_vars['page'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">戻る</a></p>
      </div>
      <br>
      <br>
      <br>
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