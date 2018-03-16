<?php /* Smarty version 2.6.9, created on 2018-03-15 17:59:20
         compiled from /var/www/html/data/mailing_list/templates/list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', '/var/www/html/data/mailing_list/templates/list.tpl', 42, false),array('modifier', 'date_format', '/var/www/html/data/mailing_list/templates/list.tpl', 46, false),)), $this); ?>
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
    <link rel="stylesheet" type="text/css" href="./css/main.css" />
    <noscript><link rel="stylesheet" href="./css/noscript.css" /></noscript>
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
/index.php">投稿ページ</a></li>
              <li class="active"><a href="<?php echo @URL_ROOT_HTTPS; ?>
/list.php">アイデア一覧</a></li>
            </ul>
          </nav>



        <!-- Footer -->
          <footer id="idea_post">
            <section class="split contact">
              <?php $_from = $this->_tpl_vars['idea_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['idea_map']):
?>
                <a href="<?php echo @URL_ROOT_HTTPS; ?>
/detail.php?id=<?php echo ((is_array($_tmp=$this->_tpl_vars['idea_map']['id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
                  <section>
                    <h3><?php echo ((is_array($_tmp=$this->_tpl_vars['idea_map']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h3>
                    <p><?php echo ((is_array($_tmp=$this->_tpl_vars['idea_map']['body'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</p>
                    <p><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['idea_map']['created_at'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
</p>                    
                  </section>
                </a>
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

    <!-- Scripts -->
    <script type="text/javascript" src="./js/jquery.min.js"></script>
    <script type="text/javascript" src="./js/jquery.scrollex.min.js"></script>
    <script type="text/javascript" src="./js/jquery.scrolly.min.js"></script>
    <script type="text/javascript" src="./js/skel.min.js"></script>
    <script type="text/javascript" src="./js/util.js"></script>
    <script type="text/javascript" src="./js/main.js"></script>
  </body>
</html>