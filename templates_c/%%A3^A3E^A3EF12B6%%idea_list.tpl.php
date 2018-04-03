<?php /* Smarty version 2.6.9, created on 2018-04-03 18:56:18
         compiled from /var/www/html/data/idea_box/templates/idea_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', '/var/www/html/data/idea_box/templates/idea_list.tpl', 38, false),array('modifier', 'mb_strimwidth', '/var/www/html/data/idea_box/templates/idea_list.tpl', 41, false),array('modifier', 'date_format', '/var/www/html/data/idea_box/templates/idea_list.tpl', 42, false),)), $this); ?>
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
                <li class='active'><a href="<?php echo @URL_ROOT_HTTPS; ?>
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
              <?php $_from = $this->_tpl_vars['idea_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['idea_map']):
?>
                <div class="list_box">
                  <a href="<?php echo @URL_ROOT_HTTPS; ?>
/idea_detail.php?id=<?php echo ((is_array($_tmp=$this->_tpl_vars['idea_map']['id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
                    <section>
                      <h3 class="under_line">・<?php echo ((is_array($_tmp=$this->_tpl_vars['idea_map']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h3>
                      <p><?php echo ((is_array($_tmp=$this->_tpl_vars['idea_map']['body'])) ? $this->_run_mod_handler('mb_strimwidth', true, $_tmp, 0, 100, '...') : mb_strimwidth($_tmp, 0, 100, '...')); ?>
</p>
                      <p class="date"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['idea_map']['created_at'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
</p>   
                      <?php if ($this->_tpl_vars['idea_map']['shain_id'] == $this->_tpl_vars['user_map']['shain_id']): ?>
                        <p><a href="<?php echo @URL_ROOT_HTTPS; ?>
/idea_edit.php?id=<?php echo ((is_array($_tmp=$this->_tpl_vars['idea_map']['id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">編集</a></p>
                      <?php endif; ?>
                    </section>
                  </a>
                </div>
              <?php endforeach; endif; unset($_from); ?>
            </section>
          </footer>

          <div id="main">
          <section>
            <footer>
              <p class="message"><?php echo $this->_tpl_vars['count_item']; ?>
</p>
              <div class="pagination">
                <p class="resultPage"><?php echo $this->_tpl_vars['paging_link']; ?>
</p>
              </div>
            </footer>
          </section>
          </div>
  </body>
</html>