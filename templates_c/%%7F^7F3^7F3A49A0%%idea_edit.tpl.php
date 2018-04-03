<?php /* Smarty version 2.6.9, created on 2018-04-03 18:54:25
         compiled from /var/www/html/data/idea_box/templates/idea_edit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', '/var/www/html/data/idea_box/templates/idea_edit.tpl', 41, false),array('function', 'html_radios', '/var/www/html/data/idea_box/templates/idea_edit.tpl', 52, false),array('function', 'html_checkboxes', '/var/www/html/data/idea_box/templates/idea_edit.tpl', 56, false),)), $this); ?>
<!DOCTYPE HTML>
<!--
  Massively by HTML5 UP
  html5up.net | @ajlkn
  Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
  <head>
    <title>アイデアBOX｜フジボウル</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="css/idea_css/idea_main.css" />
    <link rel="stylesheet" href="css/idea_css/noscript.css" /></noscript>
    <link rel="stylesheet" href="js/idea_js/idea_js/jquery.min.js"></script>
  </head>
<body class="is-loading">
    <!-- Wrapper -->
      <div id="wrapper" class="fade-in">
        <!-- Header -->
          <header id="header">
            <a href="index.html" class="logo">IDEA BOX</a>
          </header>
          <!-- Nav -->
            <nav id="nav">
              <ul class="links">
                <li><a href="<?php echo @URL_ROOT_HTTPS; ?>
/idea_top.php">投稿ページ</a></li>
                <li><a href="<?php echo @URL_ROOT_HTTPS; ?>
/idea_list.php">アイデア一覧</a></li>
                <?php if ($this->_tpl_vars['admin_map']['key'] == 1): ?>
                  <li><a href="<?php echo @URL_ROOT_HTTPS; ?>
/idea_admin.php">管理画面</a></li>
                <?php endif; ?>
              </ul>
            </nav>
        <!-- Footer -->
          <footer id="idea_post">
            <section class="split contact">
              <section class="alt">
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_error_msg.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                <form method="post" action="<?php echo @URL_ROOT_HTTPS; ?>
/idea_edit.php" data-ajax="false">
                  <div class="field">
                    <label for="name">タイトル</label>
                    <input type="text" name="title" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['idea_map']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
                  </div>
                  <div class="field">
                    <label for="message">内容・説明</label>
                    <textarea cols="27" rows="10" name="body"><?php echo ((is_array($_tmp=$this->_tpl_vars['idea_map']['body'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</textarea>
                  </div>
                  <?php if ($this->_tpl_vars['admin_map']['key'] == 1): ?>
                    <div class="field">
                      <center>※管理者のみ表示</center>
                    </div>
                    <div class="field">
                        <center><?php echo smarty_function_html_radios(array('name' => 'approval_flag','options' => $this->_tpl_vars['approval'],'selected' => $this->_tpl_vars['idea_map']['approval_flag']), $this);?>
</center>
                    </div>
                    <div class="field">
                        <center>
                        <?php echo smarty_function_html_checkboxes(array('name' => 'delete_flag','options' => $this->_tpl_vars['delete']), $this);?>

                      </center>
                    </div>
                  <?php endif; ?>
                  <input type="hidden" name="id" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['idea_map']['id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
                  <input type="hidden" value="edit" name="mode">
                  <input type="submit" value="編集する" />
                </form>
              </section>
            </section>
          </footer>
      </div>
  </body>
</html>