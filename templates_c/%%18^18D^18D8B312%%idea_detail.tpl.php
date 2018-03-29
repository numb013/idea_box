<?php /* Smarty version 2.6.9, created on 2018-03-29 16:07:43
         compiled from /var/www/html/data/idea_box/templates/idea_box_tpl/idea_detail.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', '/var/www/html/data/idea_box/templates/idea_box_tpl/idea_detail.tpl', 30, false),)), $this); ?>
<!DOCTYPE HTML>
<!--
  Massively by HTML5 UP
  html5up.net | @ajlkn
  Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
  <head>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "idea_box_tpl/_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
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
/idea_box_php/idea_top.php">投稿ページ</a></li>
                <li><a href="<?php echo @URL_ROOT_HTTPS; ?>
/idea_box_php/idea_list.php">アイデア一覧</a></li>
                <li><a href="<?php echo @URL_ROOT_HTTPS; ?>
/idea_box_php/idea_admin.php">管理画面</a></li>
              </ul>
            </nav>
        <!-- Footer -->
          <footer id="idea_post">
            <section class="split contact">
              <section class="alt">
                <h2 style="border-bottom: 1px solid #717981;"><?php echo ((is_array($_tmp=$this->_tpl_vars['idea_map']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h2>
                <p style="font-size: 20px;margin-top:15px;line-height: 36px;"><?php echo ((is_array($_tmp=$this->_tpl_vars['idea_map']['body'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</p>
                <?php if ($this->_tpl_vars['idea_map']['shain_id'] == '5'): ?>
                  <p><a href="<?php echo @URL_ROOT_HTTPS; ?>
/idea_box_php/idea_edit.php?id=<?php echo ((is_array($_tmp=$this->_tpl_vars['idea_map']['id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">編集</a></p>
                <?php endif; ?>
              </section>

            </section>
          </footer>
        <!-- Copyright -->
      </div>
  </body>
</html>