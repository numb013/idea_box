<?php /* Smarty version 2.6.9, created on 2018-03-29 15:18:40
         compiled from /var/www/html/data/idea_box/templates/idea_box_tpl/idea_top.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', '/var/www/html/data/idea_box/templates/idea_box_tpl/idea_top.tpl', 38, false),array('modifier', 'truncate', '/var/www/html/data/idea_box/templates/idea_box_tpl/idea_top.tpl', 61, false),array('modifier', 'date_format', '/var/www/html/data/idea_box/templates/idea_box_tpl/idea_top.tpl', 62, false),)), $this); ?>
<!DOCTYPE HTML>
<!--
  Massively by HTML5 UP
  html5up.net | @ajlkn
  Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
  <head>
    <title>Massively by HTML5 UP</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" type="text/css" href="../css/idea_main.css" />
    <noscript><link rel="stylesheet" href="../css/noscript.css" /></noscript>
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
                <li class='active'><a href="<?php echo @URL_ROOT_HTTPS; ?>
/idea_box_php/idea_top.php">投稿ページ</a></li>
                <li><a href="<?php echo @URL_ROOT_HTTPS; ?>
/idea_box_php/idea_list.php">アイデア一覧</a></li>
                <li><a href="<?php echo @URL_ROOT_HTTPS; ?>
/idea_box_php/idea_admin.php">管理画面</a></li>
              </ul>
            </nav>

        <!-- Footer -->
          <div id="idea_post">
            <section>
              <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "idea_box_tpl/_error_msg.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
              <form method="post" action="<?php echo @URL_ROOT_HTTPS; ?>
/idea_box_php/idea_completion.php" data-ajax="false">
                <div class="field">
                  <label for="name">タイトル</label>
                  <input type="text" name="title" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['input_map']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
                </div>
                <div class="field">
                  <label for="message">内容・説明</label>
                  <textarea cols="27" rows="3" name="body"><?php echo ((is_array($_tmp=$this->_tpl_vars['input_map']['body'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</textarea>
                </div>
                <ul class="actions">
                  <input type="hidden" value="save" name="mode">
                  <li>
                    <input type="submit" value="送信する" />
                  </li>
                </ul>
              </form>
            </section>
            <section class="split contact">
              <section class="idea_bar">
                  <h3><span style="color: #af0000">▶</span>最新アイデア</h3>
              </section>
              <?php $_from = $this->_tpl_vars['idea_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['idea_map']):
?>
              <div class="list_box">
                <a href="<?php echo @URL_ROOT_HTTPS; ?>
/idea_box_php/idea_detail.php?id=<?php echo ((is_array($_tmp=$this->_tpl_vars['idea_map']['id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
                  <section>
                    <h3><?php echo ((is_array($_tmp=$this->_tpl_vars['idea_map']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h3>
                    <p><?php echo ((is_array($_tmp=$this->_tpl_vars['idea_map']['body'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 150, '...', true) : smarty_modifier_truncate($_tmp, 150, '...', true)); ?>
</p>
                    <p class="date"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['idea_map']['insert_datetime'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
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
          </div>
      </div>

    <!-- Scripts -->
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/jquery.scrollex.min.js"></script>
    <script type="text/javascript" src="../js/jquery.scrolly.min.js"></script>
    <script type="text/javascript" src="../js/skel.min.js"></script>
    <script type="text/javascript" src="../js/util.js"></script>
<!--     <script type="text/javascript" src="./js/main.js"></script> -->
  </body>
</html>