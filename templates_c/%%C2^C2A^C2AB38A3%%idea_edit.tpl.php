<?php /* Smarty version 2.6.9, created on 2018-03-27 16:53:24
         compiled from /var/www/html/data/idea_box/templates/admin/idea_edit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', '/var/www/html/data/idea_box/templates/admin/idea_edit.tpl', 28, false),array('modifier', 'date_format', '/var/www/html/data/idea_box/templates/admin/idea_edit.tpl', 37, false),array('function', 'html_radios', '/var/www/html/data/idea_box/templates/admin/idea_edit.tpl', 34, false),)), $this); ?>
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
        <h3>アイデア編集</h3>
          <form action="<?php echo @URL_ROOT_HTTPS; ?>
/tcm-admin/idea_edit.php" method="post">
            <table class="table" width="95%">
              <tr>
                <th>タイトル</th>
                <th>内容</th>
                <th>承認</th>
                <th>投稿日</th>
                <th>発案者</th>
                </tr>
                  <tr>
                    <td>
                      <input type="text" name="title" size="40" value=<?php echo ((is_array($_tmp=$this->_tpl_vars['idea_map']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
>
                    </td>
                    <td>
                      <input type="text" name="body" size="40" value=<?php echo ((is_array($_tmp=$this->_tpl_vars['idea_map']['body'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
>
                    </td>
                    <td>
                      <center><?php echo smarty_function_html_radios(array('name' => 'approval_flag','options' => $this->_tpl_vars['approval'],'selected' => $this->_tpl_vars['idea_map']['approval_flag']), $this);?>
</center>
                    </td>
                    <td>
                      <center><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['idea_map']['created_at'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
</center>
                    </td>
                    <td>
                      <center><?php echo ((is_array($_tmp=$this->_tpl_vars['idea_map']['user_id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</center>
                    </td>
                  </tr>
                </tr>
              </table>
              <input type="hidden" name="id" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['idea_map']['id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
              <input type="hidden" value="edit" name="mode">
              <input type="submit" value="編集" class="button">
            </form>
        <p><a href="<?php echo @URL_ROOT_HTTPS; ?>
/tcm-admin/idea_list.php?page=<?php echo ((is_array($_tmp=$this->_tpl_vars['page'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
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