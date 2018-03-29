<?php /* Smarty version 2.6.9, created on 2018-03-29 15:34:54
         compiled from /var/www/html/data/idea_box/templates/idea_box_tpl/idea_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', '/var/www/html/data/idea_box/templates/idea_box_tpl/idea_list.tpl', 31, false),array('modifier', 'truncate', '/var/www/html/data/idea_box/templates/idea_box_tpl/idea_list.tpl', 34, false),array('modifier', 'date_format', '/var/www/html/data/idea_box/templates/idea_box_tpl/idea_list.tpl', 35, false),)), $this); ?>
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
                <li class='active'><a href="<?php echo @URL_ROOT_HTTPS; ?>
/idea_box_php/idea_list.php">アイデア一覧</a></li>
                <li><a href="<?php echo @URL_ROOT_HTTPS; ?>
/idea_box_php/idea_admin.php">管理画面</a></li>
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
/idea_box_php/idea_detail.php?id=<?php echo ((is_array($_tmp=$this->_tpl_vars['idea_map']['id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
                    <section>
                      <h3 class="under_line">・<?php echo ((is_array($_tmp=$this->_tpl_vars['idea_map']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h3>
                      <p><?php echo ((is_array($_tmp=$this->_tpl_vars['idea_map']['body'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 100, '...') : smarty_modifier_truncate($_tmp, 100, '...')); ?>
</p>
                      <p class="date"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['idea_map']['created_at'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
</p>   
                      <?php if ($this->_tpl_vars['idea_map']['shain_id'] == '5'): ?>
                        <p><a href="<?php echo @URL_ROOT_HTTPS; ?>
/idea_box_php/idea_edit.php?id=<?php echo ((is_array($_tmp=$this->_tpl_vars['idea_map']['id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
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