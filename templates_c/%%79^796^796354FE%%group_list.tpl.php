<?php /* Smarty version 2.6.9, created on 2018-03-15 18:25:09
         compiled from /var/www/html/data/mailing_list/templates/admin/group_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', '/var/www/html/data/mailing_list/templates/admin/group_list.tpl', 32, false),)), $this); ?>
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
        <h3>アイデア一覧</h3>
        <p class="message"><?php echo $this->_tpl_vars['count_item']; ?>
</p>
        <p class="resultPage"><?php echo $this->_tpl_vars['paging_link']; ?>
</p>
        <form action="approval.php" method="POST" name="approval_form">
          <table class="table" width="95%">
            <tr>
              <th width="20%">タイトル</th>
              <th width="30%">内容</th>
              <th width="5%">詳細</th>
            </tr>
            <?php $_from = $this->_tpl_vars['group_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item_key'] => $this->_tpl_vars['group_map']):
?>
              <tr>
                <td><center><?php echo ((is_array($_tmp=$this->_tpl_vars['group_map']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</center></td>
                <td><center><?php echo ((is_array($_tmp=$this->_tpl_vars['group_map']['body'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</center></td>
                <td><center><a href="<?php echo @URL_ROOT_HTTPS; ?>
/tcm-admin/idea_detail.php?id=<?php echo $this->_tpl_vars['group_map']['id']; ?>
">詳細</a></center></td>
              </tr>
            <?php endforeach; endif; unset($_from); ?>
          </table>
          <p class="resultPage"><?php echo $this->_tpl_vars['paging_link']; ?>
</p>
        </form>
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